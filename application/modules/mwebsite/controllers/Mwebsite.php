<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mwebsite extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_akses_user();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Website_m', 'website');
    }

    public function index()
    {
      
        $data['title'] = 'Manajemen Website';

        $data['manajemen_website'] = $this->website->getWebsiteManajemen()->result_array();
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('nama_yang_digunakan', 'Alias', 'required');
        if($this->form_validation->run() == false){ 
        $data['isi'] = 'manajemen_website_v';
        $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);
            $this->website->tambahWebsiteManajemen($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                "Setingan Website ditambahkan!");
            redirect('mwebsite');
            }
        }        
    }

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('manajemen_website_id');
        $this->website->deleteWebsiteManajemen($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Setingan Website dihapus!");
            }
            redirect('mwebsite');
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $this->website->editWebsiteManajemen($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata("message", 
                "Setingan Website diedit!");
        }
        redirect('mwebsite');
    }
} 