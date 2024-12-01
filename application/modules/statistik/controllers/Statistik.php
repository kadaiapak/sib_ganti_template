<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Statistik_m','statistik');
        
    }

    public function index()
    {
        $data['title'] = 'Statistik';
        $data['isi'] = 'statistik_v';
        $tahun = $this->session->userdata(2023);
        $data['nama_beasiswa'] = $this->statistik->namaBeasiswa($tahun)->result();
        
        // $data['prodi'] = $this->statistik->getProdi()->result();
        // $arr = array();
        // $bigArr = array();  
        // foreach ($data['prodi'] as $p) {
        //     $sum = 0;
        //     $arr['fakultas'] = $p->fakultas;
        //     $arr['prodi'] = $p->prodi;
        //     foreach ($data['nama_beasiswa'] as $nb) {
        //         $hasil = $this->statistik->getPenerimaBeasiswaDua($p->prodi, $nb->id)->result();
        //         $arr[$nb->singkatan] =  $hasil[0]->total_penerima;
        //     }
        //     $bigArr[] = $arr;
        // }
       
        // $data['rekap_beasiswa'] = $bigArr;
        // tambahan

        $rekap = $this->statistik->getDetailRekap($tahun)->result_array();
        foreach ($rekap as $rk) {
            $detail_rekap[$rk['nama_beasiswa']][$rk['nama_fakultas']][] = $rk;
        }
        $data['detail_rekap'] = $detail_rekap;
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
