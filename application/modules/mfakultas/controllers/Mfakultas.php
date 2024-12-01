<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mfakultas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('Mfakultas_m', 'mfakultas');
    }

    public function index()
    {   
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Pengaturan Fakultas';
        $data['fakultas'] = $this->mfakultas->getFakultas()->result_array();

        $this->form_validation->set_rules('nama_panjang_fakultas', 'Nama Panjang Fakultas', 'required');
        $this->form_validation->set_rules('singkatan_fakultas', 'Singkatan Fakultas', 'required');
        if($this->form_validation->run() == false){         
            $data['isi'] = 'mfakultas_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);   
            $this->mfakultas->tambahFakultas($post);
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message", 
                    "Fakultas ditambahkan!");
                redirect('mfakultas');
            }else {
                 $this->session->set_flashdata("message", 
                    "Fakultas gagal ditambahkan");
                redirect('mfakultas');
            }
            
        }         
    }

    public function hapus()
    {

        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('fakultas_id');

        $this->mfakultas->deleteFakultas($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                    "Fakultas dihapus!");
            redirect('mfakultas');
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
        $this->mfakultas->editFakultas($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Fakultas berhasil diedit!");
        }else {
            redirect('auth/oops');
        }
        redirect('mfakultas');
    }
} 