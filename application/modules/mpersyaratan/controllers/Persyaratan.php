<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persyaratan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('mbeasiswa/Beasiswa_m', 'beasiswa');
    }

    public function index()
    {
        $data['cek_tambah'] = $this->cek_akses_user['tambah'];
        $data['cek_edit'] = $this->cek_akses_user['edit'];
        $data['cek_hapus'] = $this->cek_akses_user['hapus'];

        // 
         // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url('mpersyaratan/persyaratan/index');
        $config['total_rows'] = $this->beasiswa->countPersyaratanBeasiswaPagination();
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
        $data['persyaratan_beasiswa'] = $this->beasiswa->getPersyaratanBeasiswa($config['per_page'],$data['start_at'])->result_array();
        // 
        $data['title'] = 'Persyaratan Beasiswa';
        $this->form_validation->set_rules('nama_persyaratan_beasiswa', 'Nama Persyaratan', 'required');
        $this->form_validation->set_rules('alias_persyaratan_beasiswa', 'Alias Persyaratan', 'required');
        $this->form_validation->set_rules('keterangan_persyaratan_beasiswa', 'Keterangan Persyaratan', 'required');
        if($this->form_validation->run() == false){         
            $data['isi'] = 'persyaratan_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1'){
                redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);    
            $this->beasiswa->tambahPersyaratanBeasiswa($post);
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message", 
                    "Persyaratan Beasiswa ditambahkan!");
                redirect('mpersyaratan/persyaratan');
            }else {
                 $this->session->set_flashdata("message", 
                    "Persyaratan Beasiswa gagal ditambahkan");
                redirect('mpersyaratan/persyaratan');
            }
        }         
    }

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('persyaratan_beasiswa_id');
        $this->beasiswa->deletePersyaratanBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                    "Persyaratan Beasiswa dihapus!");
            redirect('mpersyaratan/persyaratan');
        }else {
            redirect('auth/oops');
        }
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $post = $this->input->post(null, TRUE);
        $this->beasiswa->editPersyaratanBeasiswa($id, $post);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Persyaratan Beasiswa Berhasil diedit!");
        }else {
            redirect('auth/oops');
        }
        redirect('mpersyaratan/persyaratan');
    }
} 