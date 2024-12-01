<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nama_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_akses_user();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Beasiswa_m', 'beasiswa');
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Nama Beasiswa';
        $data['nama_beasiswa'] = $this->beasiswa->getNamaBeasiswa()->result_array();

        $this->form_validation->set_rules('beasiswa', 'Beasiswa', 'required');
        $this->form_validation->set_rules('singkatan', 'Singkatan', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        if($this->form_validation->run() == false){ 
            $data['isi'] = 'nama_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);
            $this->beasiswa->tambahNamaBeasiswa($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                "Nama Beasiswa ditambahkan!");
            redirect('mbeasiswa/nama_beasiswa');
            }
        }        
    }

    public function del()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('nama_beasiswa_id');
        $this->beasiswa->deleteNamaBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Data berhasil dihapus!");
        }
            redirect('mbeasiswa/nama_beasiswa');
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $this->beasiswa->editNamaBeasiswa($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata("message", 
                "Data berhasil diedit!");
        }
        redirect('mbeasiswa/nama_beasiswa');
    }
} 