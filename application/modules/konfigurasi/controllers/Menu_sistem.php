<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_sistem extends CI_Controller
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
        $data['title'] = 'Menu Management';

        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url().'konfigurasi/menu_sistem/index';
        $config['total_rows'] = $this->akses->countMenuPagination();
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
        $data['menu'] = $this->akses->getMenuPagination($config['per_page'],$data['start_at'])->result_array();
        $data['isi'] = 'menu_sistem_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function edit($id)
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect('auth/blocked');
        }
        $data['title'] = 'Edit Menu';
        $data['tambah_menu'] = mainMenuUntukTambahMenu();

        $this->form_validation->set_rules('nama_menu','Nama Menu','required');
        $this->form_validation->set_rules('no_menu','No Menu','required');
        $this->form_validation->set_rules('url','URl','required');
        $this->form_validation->set_rules('level_menu','level Menu','required');
        $this->form_validation->set_rules('main_menu','Kepala','required');

        if($this->form_validation->run() == false){
            $query = $this->akses->getMenu($id);
            if($query->num_rows() > 0){
                $data['row'] = $query->row();
                $data['isi'] = 'menu_sistem_edit_v';
                $this->load->view('template/wrapper_frontend_v', $data);
            }else {
                redirect('auth/oops');
            }
        }else {
            if($this->cek_akses_user['edit'] != '1'){
                redirect('auth/blocked');
            }
            $post = $this->input->post(null, TRUE);
            $this->akses->editMenu($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                "Menu berhasil diedit!");
            }
            redirect('konfigurasi/menu_sistem');
        }
    }

    public function tambah()
    {
        if($this->cek_akses_user['tambah'] != '1'){
            redirect('auth/blocked');
        }
        $data['tambah_menu'] = mainMenuUntukTambahMenu();
        $data['pemisah'] = pemisahMenu();
        $data['title'] = 'Tambah Menu';

        $this->form_validation->set_rules('nama_menu','Nama Menu','required');
        $this->form_validation->set_rules('no_menu','Nomor Menu','required');
        $this->form_validation->set_rules('url','URl','required');
        $this->form_validation->set_rules('level_menu','level Menu','required');
        $this->form_validation->set_rules('urut','No Urut','required');

        if($this->form_validation->run() == false){
            $data['isi'] = 'menu_sistem_tambah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            if($this->cek_akses_user['tambah'] != '1'){
                redirect('auth/blocked');
            }
            $this->akses->tambahMenu($data);
                $this->session->set_flashdata("message",
                "Menu baru ditambahkan!");
                redirect('konfigurasi/menu_sistem');
        }
    }

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('kode_menu');

        $resultMenu = $this->akses->hapusMenu($id);
        if($resultMenu){
            $this->session->set_flashdata("message",
            "Menu telah di hapus!");
        }else {
          $this->session->set_flashdata("gagal",
          "Gagal, menu ini masih digunakan pada hak akses!");
        }
        redirect('konfigurasi/menu_sistem');
    }
}
