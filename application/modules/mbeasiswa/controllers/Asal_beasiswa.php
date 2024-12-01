<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asal_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('Beasiswa_m', 'beasiswa');
    }

    public function index()
    {   
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Sumber Pembiayaan';
        $data['asal_beasiswa'] = $this->beasiswa->getAsalBeasiswa()->result_array();

        $this->form_validation->set_rules('nama_asal_beasiswa', 'Asal Beasiswa', 'required');
        if($this->form_validation->run() == false){         
            $data['isi'] = 'asal_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
            }
            $post = $this->input->post(null, TRUE);    
            $this->beasiswa->tambahAsalBeasiswa($post);
            if($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message", 
                    "Asal Beasiswa ditambahkan!");
                redirect('mbeasiswa/asal_beasiswa');
            }else {
                 $this->session->set_flashdata("message", 
                    "Asal Beasiswa gagal ditambahkan");
                redirect('mbeasiswa/asal_beasiswa');
            }
            
        }         
    }

    public function hapus()
    {

        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('asal_beasiswa_id');

        $this->beasiswa->deleteAsalBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                    "Asal Beasiswa dihapus!");
            redirect('mbeasiswa/asal_beasiswa');
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
        $this->beasiswa->editAsalBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Asal Beasiswa Edit berhasil!");
        }else {
            redirect('auth/oops');
        }
        redirect('mbeasiswa/asal_beasiswa');
    }
} 