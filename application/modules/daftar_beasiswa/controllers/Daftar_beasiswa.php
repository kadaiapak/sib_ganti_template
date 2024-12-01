<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Daftar_beasiswa_m', 'daftar');
    }

    public function index()
    {
        $data['title'] = "Pendaftaran Beasiswa";

        // ambil master beasiswa yang masih buka
        $data['master_beasiswa'] = $this->daftar->getMasterBeasiswaDaftar()->result_array();

        $data['isi'] = 'daftar_beasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function daftar($id)
    {
        $masterBeasiswa = $this->daftar->cekTanggalModel($id)->row();
        
        $validasi_fakultas = $masterBeasiswa->validasi_fakultas;
        
        // cek apakah tanggal beasiswa masih buka
        $cekBisaDaftar = $this->cekBisaDaftar($id);
        if(!$cekBisaDaftar)
        {
            $this->session->set_flashdata("gagal", 
                    "Pendaftaran Gagal, Sudah Melebihi kuota atau batas waktu !");
            redirect('daftar-beasiswa');
        }
        // cek apakah sudah pernah mendaftar beasiswa tersebut
        $nim = $this->session->userdata('username');
        $sedangDapatBeasiswa = $this->cekSedangDapatBeasiswa($nim);
        if($sedangDapatBeasiswa > 0)
        {
            $this->session->set_flashdata("gagal", 
                    "Saat ini anda sedang menerima beasiswa lain !");
            redirect('daftar-beasiswa');
        }

        // cek apakah mahasiswa tersebut sudah mendaftar di beasiswa lain
        // $sedang_daftar = $this->cekSedangDaftar($nim);
        // if($sedang_daftar > 0){
        //      $this->session->set_flashdata("gagal", 
        //             "Anda sudah mendaftar di beasiswa lain !");
        //     redirect('daftar-beasiswa');
        // }

        $pernah_daftar = $this->cekPernahDaftar($nim, $id);
        if($pernah_daftar > 0){
             $this->session->set_flashdata("gagal", 
                    "Anda sudah mendaftar beasiswa ini !");
            redirect('daftar-beasiswa');
        }

        $datamhsd = $this->getmhsapis($nim);
        $arrmhs = get_object_vars($datamhsd->data);

        $datamhsaktif=$this->getmhsaktifapis($nim,checkSemester());

        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }
        
        $data['mhs_api'] = $arrmhs;
        $data['id_beasiswa'] = $id;
        
        $data['no_rekening'] = $masterBeasiswa->no_rekening;
        $data['data_keluarga'] = $masterBeasiswa->data_keluarga;

        $data['jalur_masuk'] = $this->daftar->getJalurMasuk()->result_array();


        $data['status_orangtua'] = $this->daftar->getStatusOrangtua()->result_array();
        $data['pendidikan_orangtua'] = $this->daftar->getPendidikanOrangtua()->result_array();
        $data['pekerjaan_orangtua'] = $this->daftar->getPekerjaanOrangtua()->result_array();
        $data['penghasilan_orangtua'] = $this->daftar->getPenghasilanOrangtua()->result_array();
        $data['hub_ayah'] = $this->daftar->getHubAyah()->result_array();
        $data['hub_ibu'] = $this->daftar->getHubIbu()->result_array();
        $data['status_rumah'] = $this->daftar->getStatusRumah()->result_array();
        $data['luas_rumah'] = $this->daftar->getLuasRumah()->result_array();
     
        $data['persyaratan'] = $this->daftar->getPersyaratan($id)->result_array();

        // echo '<pre>';
        // print_r($data['persyaratan']);
        // echo '</pre>';
        // die;
        $persyaratanUtama = $data['persyaratan'];
        $data['title'] = 'Daftar Beasiswa';
        $this->form_validation->set_rules('nim', 'NIM', 'required');
        $this->form_validation->set_rules('nama_mahasiswa', 'Nama Mahasiswa', 'required');
        $this->form_validation->set_rules('prodi', 'Prodi', 'required');
        $this->form_validation->set_rules('fakultas', 'Fakultas', 'required');
        $this->form_validation->set_rules('tulis_nohp', 'No HP', 'required');
        $this->form_validation->set_rules('tulis_nik', 'NIK', 'required');
        $this->form_validation->set_rules('tulis_email', 'Email', 'required');
        $this->form_validation->set_rules('jalur_masuk', 'Jalur Masuk', 'required');
        $this->form_validation->set_rules('ukt', 'UKT', 'required');
        if($masterBeasiswa->no_rekening == 1)
        {
            $this->form_validation->set_rules('pemilik_rekening', 'Nama Pemilik Rekening', 'required');
            $this->form_validation->set_rules('tulis_no_rekening', 'No Rekening', 'required');
        };
        if($masterBeasiswa->data_keluarga == 1)
        {
            $this->form_validation->set_rules('tulis_nama_ayah', 'Nama Ayah', 'required');
            $this->form_validation->set_rules('tulis_status_ayah', 'Status Ayah', 'required');
            $this->form_validation->set_rules('hub_ayah', 'Hubungan dengan Ayah', 'required');
            $this->form_validation->set_rules('tulis_pendidikan_ayah', 'Pendidikan Ayah', 'required');
            $this->form_validation->set_rules('tulis_pekerjaan_ayah', 'Pekerjaan Ayah', 'required');
            $this->form_validation->set_rules('rincian_pekerjaan_ayah', 'Rincian Pekerjaan Ayah', 'required');
            $this->form_validation->set_rules('ratarata_penghasilan_ayah', 'Penghasilan Rata - Rata', 'required');
            $this->form_validation->set_rules('kontak_ayah', 'Kontak Ayah', 'required');

            $this->form_validation->set_rules('tulis_nama_ibu', 'Nama ibu', 'required');
            $this->form_validation->set_rules('tulis_status_ibu', 'Status ibu', 'required');
            $this->form_validation->set_rules('hub_ibu', 'Hubungan dengan Ibu', 'required');
            $this->form_validation->set_rules('tulis_pendidikan_ibu', 'Pendidikan ibu', 'required');
            $this->form_validation->set_rules('tulis_pekerjaan_ibu', 'Pekerjaan ibu', 'required');
            $this->form_validation->set_rules('rincian_pekerjaan_ibu', 'Rincian Pekerjaan Ibu', 'required');
            $this->form_validation->set_rules('ratarata_penghasilan_ibu', 'Penghasilan Rata - Rata', 'required');
            $this->form_validation->set_rules('kontak_ibu', 'Kontak Ibu', 'required');

            $this->form_validation->set_rules('status_rumah', 'Status Rumah', 'required');
            $this->form_validation->set_rules('luas_rumah', 'Luas Rumah', 'required');
            $this->form_validation->set_rules('tahun_rumah', 'Tahun Rumah', 'required');
        }

        foreach ($persyaratanUtama as $pr) {
            $persyaratan = $pr['alias'];
            $nama_dokumen = $pr['persyaratan'];
            $wajib = $pr['wajibpersyaratan'];
            if($wajib == '1'){
            if (empty($_FILES["$persyaratan"]["name"]))
                {
                    $this->form_validation->set_rules("$persyaratan", "$nama_dokumen", 'required');
                }
            }
        }
        if($this->form_validation->run() == false){
            $data['isi'] = 'daftar_beasiswa_proses_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $post = $this->input->post(null, TRUE);
        
            $error = array();
            foreach ($persyaratanUtama as $p) {
                $kosong = $p['alias'];
                if(!empty($_FILES["$kosong"]["name"])){
                    $newName = $p['alias'].time();
                    $config['upload_path'] = './uploads/persyaratan/';
                    $config['allowed_types'] = $p['tipe_file']; 
                    $config['max_size'] =  $p['ukuran_file'];
                    $config['file_name'] = $newName;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                // jika wajib lakukan ini
                if($p['wajibpersyaratan'] == '1'){
                    if(!$this->upload->do_upload($p['alias'])){
                        $error = array('error' => $this->upload->display_errors());
                        break;  
                    }else {
                        $proses = $this->upload->data();
                        $upload["$p[alias]"] = $proses['file_name'];
                    }
                }else {
                    if(!$this->upload->do_upload($p['alias'])){
                        $error = array('error' => $this->upload->display_errors());
                    }else {
                        $proses = $this->upload->data();
                        $upload["$p[alias]"] = $proses['file_name'];
                    }    
                    }
                }
                
            }
            if($error)
            {   
                foreach ($upload as $up) {
                    $targetFile = './uploads/persyaratan/'.$up;
                        unlink($targetFile);
                }
                $this->session->set_flashdata("error_upload", 
                    "Gagal Upload, ada kesalahan dalam ukuran atau jenis file");
                redirect('daftar-beasiswa/daftar/'.$id);
            }
            
            $post = $this->input->post(null, TRUE);
            $this->daftar->prosesPendaftaranBeasiswa($post, $id, $upload, $validasi_fakultas);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Pendaftaran Beasiswa anda berhasil !");
                redirect('daftar-beasiswa');
            }
        }
    }

    function cekSedangDaftar($nim)
    {
        $sedangDaftar = $this->daftar->cekSedangDaftarModel($nim);
        return $sedangDaftar;
    }

    function cekPernahDaftar($nim, $id)
    {
        $hasil = $this->daftar->cekPernahDaftarBeasiswaModel($nim,$id);
        return $hasil;
    }

    function cekSedangDapatBeasiswa($nim)
    {
        $pernah = $this->daftar->cekSedangDapatBeasiswaModel($nim);
        return $pernah;
    }

    function cekBisaDaftar($id)
    {
      $result = $this->daftar->cekTanggalModel($id)->row();

      //   cek apakah pendaftaran nya sudah buka
      if(date('Y-m-d H:i:s') < $result->tgl_awal_pendaftaran ){
        //   echo 'jika pendaftaran belum buka';f
        return false;
      }else {
        //   echo 'jika Pendaftaran sudah buka';
        // cek apakah tanggal pendaftaran sudah tutup

        if(date('Y-m-d H:i:s') > $result->tgl_tutup_pendaftaran){
            return false;
        }

        else {
            $totalPendaftar = $this->daftar->cekTotalPendaftar($id);
            if($totalPendaftar >= $result->kuota_pendaftaran  ){
                return false;
            }else {
                return true;
            }
        }
      }

    }

    // @desc - mengambil data mahasiswa yang mendaftar dari API
    // @used by
    // - controller 'daftar-beasiswa/daftar
    private function getmhsapis($nim)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HTTPHEADER,array(
        'h2hid: 119009',
        'h2hkey: FpY6qZ3S',
        'h2hunicode: nIowYLmcNdMjWHfAgQTlrJqeSpVEsOXvGbzDPaFyuki',
        'nim: '.$nim,
        'Content-Type: application/json'
      ));
      curl_setopt($ch, CURLOPT_URL, 'https://wsvc.unp.ac.id/api/akademik/cekmhs');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $output = curl_exec($ch);
      $header_data= curl_getinfo($ch);
      curl_close($ch);
      return json_decode($output);
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
