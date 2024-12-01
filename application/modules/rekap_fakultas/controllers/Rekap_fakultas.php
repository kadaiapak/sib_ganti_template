<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_fakultas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Rekap_fakultas_m','rekap');
    }

    public function index()
    {
        $data['title'] = 'Rekap Fakultas';
        $data['isi'] = 'rekap_fakultas_v';
        $tahun = $this->session->userdata('tahun_beasiswa');
        $fakultas = $this->session->userdata('fakultas');
        date_default_timezone_set('ASIA/JAKARTA');
        $tahun_terbaru = date('Y');
        if($tahun == null){
            $tahun = $tahun_terbaru;
        }
        if($fakultas == null) {
            $fakultas = 'all';
        }

        $rekap = $this->rekap->getDetailRekap($tahun, $fakultas)->result_array();
        $rekap_fakultas = $this->rekap->getDetailRekapFakultas($tahun)->result_array();
      
        if($rekap == null){
            $data['detail_rekap'] = null;
        }else {
            foreach ($rekap as $rk) {
                $detail_rekap[$rk['nama_fakultas']][$rk['nama_beasiswa']][] = $rk;
            }
            $data['detail_rekap'] = $detail_rekap;
        }

        if($rekap_fakultas == null){
            $data['detail_rekap_fakultas'] = null;
        }else {
            foreach ($rekap_fakultas as $rf) {
                $detail_rekap_fakultas[$rf['nama_beasiswa']][] = $rf;
            }
            $data['detail_rekap_fakultas'] = $detail_rekap_fakultas;
        }

        $data['fakultas'] = $this->rekap->getFakultas()->result_array();
        // akhir tambahan
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function cari()
    {
        $tahun = $this->input->post('tahun_beasiswa');
        $fakultas = $this->input->post('fakultas');
        $this->session->set_userdata('tahun_beasiswa',$tahun);
        $this->session->set_userdata('fakultas', $fakultas);
        redirect(base_url('rekap_fakultas'));
    }
}
