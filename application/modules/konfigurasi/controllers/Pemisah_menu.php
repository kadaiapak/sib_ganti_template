<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemisah_menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Akses_m','akses');
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Pemisah Menu';
        $this->form_validation->set_rules('nama_pemisah_menu', 'Nama Pemisah Menu', 'required');
        $this->form_validation->set_rules('no_urut', 'No Urut', 'required',
                        array('required' => 'Silahkan masukkan no urut')
                );
        $this->form_validation->set_rules('nama_pemisah_menu', 'Nama Pemisah Menu', 'required',
                        array('required' => 'Silahkan masukkan nama divider')
                );
        if ($this->form_validation->run() == false) {
            // PAGINATION
            // load library
            $this->load->library('pagination');
            // config
            $config['base_url'] =   base_url().'/konfigurasi/pemisah-menu/index';
            $config['total_rows'] = $this->akses->countPemisahMenuPagination();
            $config['per_page'] = 10;
            // styling
            $config['full_tag_open'] = '<nav><ul class="pagination">';
            $config['full_tag_close'] = '</ul></nav>';

            $config['first_link'] = 'First';
            $config['first_tag_open'] = '<li class="page-item">';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = 'Last';
            $config['last_tag_open'] = '<li class="page-item">';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $config['attributes'] = array('class' => 'page-link');
            // initialize
            $this->pagination->initialize($config);
            // get data
            $data['start_at'] = $this->uri->segment(4);
            // END OF PAGINATION
            $data['menu'] = $this->akses->getPemisahMenuPagination($config['per_page'],$data['start_at'])->result_array();
            $data['isi'] = 'menu_pemisah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            if($this->cek_akses_user['tambah'] != '1'){
                redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);
            $this->akses->tambahPemisahMenu($post);
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message",
                    "Pemisah Menu ditambahkan!");
                redirect('konfigurasi/pemisah-menu');
            }else {
                $this->session->set_flashdata("gagal",
                    "Pemisah Menu gagal ditambahkan");
                redirect('konfigurasi/pemisah-menu');
            }
        }

    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $this->akses->editPemisahMenu($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message",
                "Pemisah Menu Berhasil diubah!");
        }else {
            $this->session->set_flashdata("gagal",
                "Pemisah Menu Gagal diubah!");
        }
        redirect('konfigurasi/pemisah-menu');
    }

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('pemisah_menu_id');

        $result = $this->akses->hapusPemisahMenu($id);
        if($result)
        {
            $this->session->set_flashdata("message",
            "Pemisah menu berhasil dihapus");
        }else {
            $this->session->set_flashdata("gagal",
            "Gagal dihapus, ada menu yang memakai divider ini !");
        }
        redirect('konfigurasi/pemisah-menu');
    }
}
