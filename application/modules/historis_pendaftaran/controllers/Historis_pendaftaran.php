<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historis_pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Historis_m','historis');
    }



    public function index()
    {
        $nim =  $this->session->userdata('username');
        $data['title'] = "Historis Pendaftaran";
        $data['historis'] = $this->historis->getHistoris($nim)->result_array();
        $data['isi'] = 'historis_pendaftaran_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

}
