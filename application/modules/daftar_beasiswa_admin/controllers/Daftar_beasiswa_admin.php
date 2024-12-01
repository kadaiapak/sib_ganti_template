<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Daftar_beasiswa_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Daftar_beasiswa_admin_m', 'daftar_beasiswa_admin');
        $this->load->model('data_beasiswa/Penerima_beasiswa_m', 'penerima');
        $this->load->model('mbeasiswa/Beasiswa_m', 'pbeasiswa');
        $this->load->model('validasi/Validasi_m', 'validasi');
    }

    public function get_ajax($id, $display) 
    {
        $list = $this->daftar_beasiswa_admin->get_datatables($id, $display);
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
            // $row[] = ($item->status_beasiswa == '0b' ? '<span class="badge badge-warning">Didaftarkan Admin</span>' : '<span class="badge badge-success">Didaftarkan Admin</span>');
            $row[] = $item->name;
            $row[] = $item->tanggal_daftar;
            $row[] = '<a href="'.site_url('daftar-beasiswa-admin/detail-mahasiswa/'.$id.'/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->daftar_beasiswa_admin->count_all($id, $display),
                    "recordsFiltered" => $this->daftar_beasiswa_admin->count_filtered($id, $display),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {
        $data['title'] = "Pendaftaran Beasiswa Oleh Admin";
        // ambil master beasiswa yang masih buka
        $data['master_beasiswa'] = $this->daftar_beasiswa_admin->getMasterBeasiswaDaftar()->result_array();
   
        $data['isi'] = 'daftar_beasiswa_admin_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function list_mahasiswa($id= '')
    {
        if($id == '')
        {
            redirect('auth/oops');
        }

        $data['detail_beasiswa'] = $this->penerima->getDetailBeasiswa($id);
        $data['id_beasiswa'] = $id;
        $data['title'] = "List Semua Pendaftar Beasiswa";

        $data['isi'] = 'daftar_beasiswa_admin_list_pendaftar_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail($id=null)
    {        
        if(!$id){
            redirect('auth/oops');
        }

        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = "Detail Beasiswa";

        $data['id_beasiswa'] = $id;
        $data['detail_beasiswa'] = $this->penerima->getDetailBeasiswa($id);
        $data['sk'] = $this->penerima->getMasterSk($data['detail_beasiswa']['id'])->result_array();
        $data['bp'] = $this->penerima->getMasterBP($data['detail_beasiswa']['id'])->result_array();
        $data['periode'] = $this->pbeasiswa->getPeriodeBeasiswa()->result_array();
        $data['total_penerima'] = $this->penerima->getTotalPenerimaDetailBeasiswa($id);
        $this->form_validation->set_rules('nim', 'NIM Mahasiswa', 'required|callback_nim_check');
        $this->form_validation->set_rules('validasi_daftar', 'Validasi Daftar', 'callback_tanggal_dan_pelamar_check');
        $this->form_validation->set_rules('validasi_beasiswa', 'Validasi Daftar', 'callback_sedang_dapat_beasiswa_check');
        $this->form_validation->set_rules('validasi_pernah_mendaftar_beasiswa_ini', 'Validasi Daftar', 'callback_pernah_mendaftar_beasiswa_ini_check');
        $this->form_validation->set_rules('validasi_daftar_beasiswa_lain', 'Validasi Daftar', 'callback_daftar_beasiswa_lain_check');
        if($this->form_validation->run() == false){
            $data['isi'] = 'daftar_beasiswa_admin_detail_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $nim = $this->input->post('nim');
            $this->session->set_flashdata("data_mahasiswa", 
                    $nim);
                redirect('daftar-beasiswa-admin/input-data/'.$id);
        }
    }
    
    public function input_data($id= null)
    {
        $this->session->keep_flashdata('data_mahasiswa');
        $nim = $this->session->flashdata('data_mahasiswa');
        $datamhsd = $this->getmhsapis($nim);
          if($datamhsd == null) {
            redirect('auth/connection');
        }
        $arrmhs = get_object_vars($datamhsd->data);
       
      
        $datamhsaktif=$this->getmhsaktifapis($nim,checkSemester());

        $masterBeasiswa = $this->daftar_beasiswa_admin->cekTanggalModel($id)->row();
        // echo '<pre>';
        // print_r($masterBeasiswa->data_keluarga);
        // echo '</pre>';
        // die;
        $validasi_fakultas = $masterBeasiswa->validasi_fakultas;

        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }

        $data['data_keluarga'] = $masterBeasiswa->data_keluarga;
        $data['mhs_api'] = $arrmhs;
        $data['id_beasiswa'] = $id;
        $data['persyaratan'] = $this->daftar_beasiswa_admin->getPersyaratan($id)->result_array();
        $data['pekerjaan_ayah'] = $this->daftar_beasiswa_admin->getPekerjaanAyah()->result_array();
     
        $persyaratanUtama = $data['persyaratan'];
        $data['title'] = 'Input Data Beasiswa';

        $this->form_validation->set_rules('nama_mahasiswa', 'Nama Mahasiswa', 'required');
        $this->form_validation->set_rules('prodi', 'Prodi', 'required');
        $this->form_validation->set_rules('nim', 'Nim', 'required');
        if($masterBeasiswa->data_keluarga == 1)
        {
        $this->form_validation->set_rules('nama_ayah','Nama Ayah','required');
        $this->form_validation->set_rules('nama_ibu','Nama Ibu','required');
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
            $data['isi'] = 'daftar_beasiswa_admin_input_data_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
           
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
                redirect('daftar-beasiswa-admin/input-data/'.$id);
            }
            
            $post = $this->input->post(null, TRUE);
            $this->daftar_beasiswa_admin->prosesPendaftaranBeasiswaOlehAdmin($post, $id, $upload, $validasi_fakultas);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Pendaftaran Beasiswa anda berhasil !");
                redirect('daftar-beasiswa-admin/detail/'.$id);
            }
        }
    }

    public function detail_mahasiswa($id, $nim)
    {
        $data['user_created'] = $this->daftar_beasiswa_admin->getAdminPendaftar($id, $nim)->row()->admin_pendaftar;
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['mahasiswa'] = $this->daftar_beasiswa_admin->getMahasiswaPendaftar($id, $nim)->row();
        $data['berkas_pendaftaran'] = $this->validasi->getBerkasPendaftaran($data['mahasiswa']->id)->result_array();
        $data['title'] = 'Tetapkan Mahasiswa';
        $data['id_untuk_back'] = $id;
        $data['isi'] = 'daftar_beasiswa_admin_detail_mahasiswa_v';

   
        $datamhsaktif=$this->getmhsaktifapis($nim,checkSemester());
        if($datamhsaktif == null) {
            redirect('auth/connection');
        }
        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }
        $this->load->view('template/wrapper_frontend_v', $data);
    }

      public function hapus()
    {
        if($this->cek_akses_user['hapus'] != 1){
            redirect('auth/oops');
        };
        // $data = $this->input->post(null, TRUE);
        $id_beasiswa = $this->input->post('id_beasiswa');
        $nim_mahasiswa = $this->input->post('nim_mahasiswa');
        
        $cek_akses_hapus_pendaftar = $this->daftar_beasiswa_admin->getAdminPendaftar($id_beasiswa, $nim_mahasiswa)->row();
        if($cek_akses_hapus_pendaftar->admin_pendaftar != $this->session->userdata('userid') )
        {
            $this->session->set_flashdata('gagal', 'Anda tidak memiliki akses untuk menghapus pendaftaran mahasiswa tersebut');
            redirect('daftar-beasiswa-admin/detail-mahasiswa/'.$id_beasiswa.'/'.$nim_mahasiswa);
        }
        // hapus berkas terlebih dahulu
          $berkas_pendaftaran = $this->daftar_beasiswa_admin->getBerkasPendaftaranBeasiswa($id_beasiswa, $nim_mahasiswa)->result_array();
       
          foreach($berkas_pendaftaran as $bs)
                {
                    
                    $targetFile = './uploads/persyaratan/'.$bs['nama_file'];
        //                    echo '<pre>';
        // print_r($targetFile);
        // print_r($bs['nama_file']);
        // echo '<pre>';
        // die;
                    unlink($targetFile);
      
                }
        // hapus data semua berkas pendaftaran
        $this->daftar_beasiswa_admin->hapusBerkasPendaftaranBeasiswa($id_beasiswa, $nim_mahasiswa);
        if($this->db->affected_rows() > 0)
        {
            // hapus data mahasiswa yang didaftarkan
            $this->daftar_beasiswa_admin->hapusPendaftarBeasiswa($id_beasiswa, $nim_mahasiswa);
            $this->session->set_flashdata("message", 
                "Mahasiswa ybs berhasil dihapus!");
            redirect('daftar-beasiswa-admin/detail/'.$id_beasiswa);
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak memiliki akses untuk menghapus pendaftaran mahasiswa tersebut');
            redirect('daftar-beasiswa-admin/detail-mahasiswa/'.$id_beasiswa.'/'.$nim_mahasiswa);
        }
        // hapus semua berkas pendaftaran
        // $berkas_pendaftaran = $this->daftar_beasiswa_admin->getBerkasPendaftaranBeasiswa($data)->result_array();
        // $hapus = $this->daftar_beasiswa_admin->hapusPendaftarBeasiswa($data);

        // hapus berkas 
        // $this->daftar_beasiswa_admin->hapusBerkasPendaftaranBeasiswa($data)->result_array();
        // foreach($berkas_pendaftaran as $bs)
        //         {
        //         unlink($bs->nama_file);
        //         }
              
        
        // if($this->db->affected_rows() > 0)
        // {
        //     $this->session->set_flashdata('message', 'Pendaftaran mahasiswa berhasil dihapus');
        //     redirect('daftar-beasiswa-admin/detail-mahasiswa/'.$data['id_beasiswa'].'/'.$data['nim_mahasiswa']);
        // } else {
        //     $this->session->set_flashdata('gagal', 'Anda tidak memiliki akses untuk menghapus pendaftaran mahasiswa tersebut');
        //     redirect('daftar-beasiswa-admin/detail-mahasiswa/'.$data['id_beasiswa'].'/'.$data['nim_mahasiswa']);
        // }
    }

    public function pdf()
    {
        $id = $this->input->post('id_beasiswa');
        $data['nama_beasiswa'] = $this->input->post('nama_beasiswa');
        $data['periode'] = $this->input->post('periode');
        $data['tahun'] = $this->input->post('tahun');
        $this->load->library('pdfgenerator');
        $data['pendaftar_beasiswa'] = $this->daftar_beasiswa_admin->getPendaftarBeasiswa($id)->result_array();

        // title dari pdf
        $data['title_pdf'] = 'Laporan Mahasiswa';
        
        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_mahasiswa_didaftarkan_beasiswa';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

		$html = $this->load->view('laporan_pdf',$data, true);	    

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
    }

      public function excel()
    {
        $id = $this->input->post('id_beasiswa');
        $data['nama_beasiswa'] = $this->input->post('nama_beasiswa');
        $data['periode'] = $this->input->post('periode');
        $data['tahun'] = $this->input->post('tahun');
        $data['pendaftar_beasiswa'] = $this->daftar_beasiswa_admin->getPendaftarBeasiswa($id)->result_array();

        // title dari pdf
        $data['title'] = 'laporan_excel';
        
        // filename dari pdf ketika didownload
        // $file_pdf = 'laporan_mahasiswa_didaftarkan_beasiswa';
        // setting paper
        // $paper = 'A4';
        //orientasi paper potrait / landscape
        // $orientation = "landscape";

		$html = $this->load->view('laporan_excel',$data);	    
    }
    public function nim_check()
    {
            $post = $this->input->post(null, TRUE);
        
            $datamhsd = $this->getmhsapis($post['nim']);
            if($datamhsd->respon == 2){
                $this->form_validation->set_message('nim_check', 'Data mahasiswa yang bersangkutan tidak ada');
                $this->session->set_flashdata('gagal', 'Mahasiswa dengan NIM tersebut tidak ditemukan');
                redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
                return FALSE;
            }else {
                return TRUE;
            }
    }

    public function tanggal_dan_pelamar_check()
    {
            $post = $this->input->post(null, TRUE);
            $result = $this->daftar_beasiswa_admin->cekTanggalModel($post['id_beasiswa'])->row();  
            //   cek apakah pendaftaran nya sudah buka
        if(date('Y-m-d H:i:s') < $result->tgl_awal_pendaftaran ){
            //   echo 'jika pendaftaran belum buka';f
            $this->form_validation->set_message('tanggal_dan_pelamar_check', 'Pendaftaran Belum dibuka');
            $this->session->set_flashdata('gagal', 'Pendaftaran Belum dibuka');
            redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
            return FALSE;
        }else {
        // cek apakah tanggal pendaftaran sudah tutup
        if(date('Y-m-d H:i:s') > $result->tgl_tutup_pendaftaran){
            $this->form_validation->set_message('tanggal_dan_pelamar_check', 'Pendaftaran Sudah ditutup');
            $this->session->set_flashdata('gagal', 'Pendaftaran Sudah ditutup');
            redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
            return FALSE;
        }else {
            // cek jumlah total pelamar
            $totalPendaftar = $this->daftar_beasiswa_admin->cekTotalPendaftar($post['id_beasiswa']);
            // jika total pelamar sudah melebihi ambang batas
            if($totalPendaftar >= $result->kuota_pendaftaran  ){
                $this->form_validation->set_message('tanggal_dan_pelamar_check', 'Total pelamar sudah melebihi kuota');
                $this->session->set_flashdata('gagal', 'Total Pelamar Sudah Melebihi Kuota');
                redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
                return FALSE;
            }else {
                return TRUE;
            }
        }
      }
    }

    public function sedang_dapat_beasiswa_check()
    {
            $post = $this->input->post(null, TRUE);
            $pernah = $this->daftar_beasiswa_admin->cekSedangDapatBeasiswaModel($post['nim']);
            if($pernah > 0) {
                $this->form_validation->set_message('sedang_dapat_beasiswa_check', 'Mahasiswa tersebut sedang mendapatkan beasiswa lain');
                $this->session->set_flashdata('gagal', 'Mahasiswa tersebut sedang mendapatkan beasiswa lain');
                redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
                return FALSE;
            } else {
                return TRUE;
            }
    }

    public function daftar_beasiswa_lain_check()
    {
        $post = $this->input->post(null, TRUE);
        $sedangDaftar = $this->daftar_beasiswa_admin->cekSedangDaftarModel($post['nim']);
        if($sedangDaftar > 0) {
                $this->form_validation->set_message('daftar_beasiswa_lain_check', 'Mahasiswa tersebut sedang mendaftar di beasiswa lain');
                $this->session->set_flashdata('gagal', 'Mahasiswa tersebut sedang mendaftar di beasiswa lain');
                redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
                return FALSE;
            } else {
                return TRUE;
        }
    }
    
    function pernah_mendaftar_beasiswa_ini_check()
    {
        $post = $this->input->post(null, TRUE);
        $hasil = $this->daftar_beasiswa_admin->cekPernahDaftarBeasiswaModel($post['nim'], $post['id_beasiswa']);
        if($hasil > 0) {
                $this->form_validation->set_message('pernah_mendaftar_beasiswa_ini_check', 'Mahasiswa tersebut sudah mendaftar beasiswa ini');
                $this->session->set_flashdata('gagal', 'Mahasiswa tersebut sudah mendaftar beasiswa ini');
                redirect('daftar-beasiswa-admin/detail/'.$post['id_beasiswa']);
                return FALSE;
            } else {
                return TRUE;
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