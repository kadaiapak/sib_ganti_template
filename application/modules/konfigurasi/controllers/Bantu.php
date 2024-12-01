<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bantu extends CI_Controller
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
        $data['menu'] = $this->akses->getMenu()->result_array();
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

        $this->akses->hapusMenu($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
            "Menu telah di hapus!");
        }
        redirect('konfigurasi/menu_sistem');
    }
}