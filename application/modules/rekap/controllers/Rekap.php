<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Rekap_m','rekap');
    }

    public function index()
    {
        $data['title'] = 'Rekap';
        $data['isi'] = 'rekap_v';
        $tahun = $this->session->userdata(2023);
        $rekap = $this->rekap->getDetailRekap($tahun)->result_array();
        
        foreach ($rekap as $rk) {
            $detail_rekap[$rk['nama_fakultas']][$rk['nama_beasiswa']][] = $rk;
        }
        $data['detail_rekap'] = $detail_rekap;
        // echo '<pre>';
        // print_r($data['detail_rekap']);
        // echo '<pre>';
        // die;
        // akhir tambahan
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function cari()
    {
        $tahun = $this->input->post('tahun_beasiswa');
        $this->session->set_userdata('tahun_beasiswa',$tahun);
        redirect(base_url('statistik'));
    }
}
