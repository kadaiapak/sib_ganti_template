<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        cek_akses_user();
        $this->load->model('Validasi_m', 'validasi');
    }

     public function get_ajax($id)
    {

        $list = $this->validasi->get_datatables($id);
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->nim_mahasiswa;
            $row[] = $item->nama_mahasiswa;
            $row[] = $item->prodi;
            $row[] = $item->fakultas;
            $row[] = $item->ipk;
            $row[] = ($item->status_beasiswa == 1 ? '<span class="badge badge-warning">Pendaftar</span>' : '<span class="badge badge-success">Dicalonkan</span>');
            $row[] = $item->tanggal_daftar;
            $row[] = '<a href="'.site_url('validasi/detail-mahasiswa/'.$id.'/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>
                      <form action="'. base_url('validasi-mahasiswa/hapus-mahasiswa').'" id="deleteForm" method="post" style="display: inline-block;">
                        <input name="nim" type="hidden" value="'. $item->nim_mahasiswa .'">
                        <input name="id_beasiswa" type="hidden" value="'. $item->nim_mahasiswa.'">
                        <button id="deleteButton" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                      </form>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->validasi->count_all($id),
                    "recordsFiltered" => $this->validasi->count_filtered($id),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {
        $data['title'] = "validasi Mahasiswa Pendaftar Beasiswa";

        $data['master_beasiswa'] = $this->validasi->getMasterBeasiswaValidasi()->result_array();

        $data['isi'] = 'validasi_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail($id = null)
    {
        if($id == null){
            redirect('auth/oops');
        }

        $data['id'] = $id;
        $data['title'] = 'Daftar Mahasiswa Pendaftar';

        $data['isi'] = 'validasi_detail_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail_mahasiswa($id, $nim)
    {
        $data['mahasiswa'] = $this->validasi->getMahasiswaPendaftar($id, $nim)->row();
        $data['berkas_pendaftaran'] = $this->validasi->getBerkasPendaftaran($data['mahasiswa']->id)->result_array();
        $data['title'] = 'Calonkan Mahasiswa';
        $data['id_untuk_back'] = $id;
        $data['isi'] = 'validasi_detail_mahasiswa_v';
        $datamhsaktif=$this->getmhsaktifapis($nim,checkSemester());

        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    // @desc - meluluskan mahasiswa dari proses validasi calon penerima beasiswa
    // @used by
    // - view 'validasi/validasi_detail_mahasiswa_v
    function calonkan($id, $nim)
    {
        $this->validasi->calonkanBeasiswa($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "validasi Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Validasi Gagal");
        }

        redirect('validasi/detail/'.$id);
    }

    // @desc - membatalkan mahasiswa dari kelulusan proses validasi calon penerima beasiswa
    // @used by
    // - view 'validasi/validasi_detail_mahasiswa_v
    function batalkan($id, $nim)
    {
        $this->validasi->batalkanBeasiswa($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "Pembatalan Validasi Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Pembatalan Validasi Gagal");
        }

        redirect('validasi/detail/'.$id);
    }

     private function getmhsaktifapis($nim,$sem)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        'h2hid: 119009',
        'h2hkey: FpY6qZ3S',
        'h2hunicode: nIowYLmcNdMjWHfAgQTlrJqeSpVEsOXvGbzDPaFyuki',
        'nim: '.$nim,
        'idsem: '.$sem,
        'Content-Type: application/json'
      ));
      curl_setopt($ch, CURLOPT_URL, 'https://wsvc.unp.ac.id/api/akademik/cekmhsaktif');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $output = curl_exec($ch);
      $header_data= curl_getinfo($ch);
      curl_close($ch);
      return json_decode($output);
    }
}
