<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Dashboard_m', 'dashboard');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['berita_beasiswa'] = $this->dashboard->getBeritaBeasiswa()->result_array();
        // $user = $this->fungsi->user_login();
        // die;
        if($this->session->userdata('role_id')== '27'){
            $data['isi'] = 'dashboard_mahasiswa_v';
        }else {
            $data['isi'] = 'dashboard_v';
        }
        $this->load->view('template/wrapper_frontend_v', $data);
    }
}
