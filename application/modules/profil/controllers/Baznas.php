<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Baznas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
    }
    
    // @desc - library datatable yang digunakan untuk menampilkan list mahasiswa penerima beasiswa tertentu
    // @used by
    // - jquery dan views => bsw/views/detail_beasiswa_v
    
    public function index()
    {
       $data['isi'] = 'Baznas_v';
       $data['title'] = 'Profil Baznas';
       $this->load->view('template/wrapper_frontend_v', $data);  
    }
} 