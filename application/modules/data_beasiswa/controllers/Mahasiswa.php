<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_akses_user();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('mbeasiswa/Beasiswa_m', 'pbeasiswa');
        $this->load->model('mhs/Mhs_m', 'mhs');
        $this->load->model('data_beasiswa/Penerima_beasiswa_m', 'penerima');    
    }

     public function get_ajax() 
    {
        $list = $this->mhs->get_datatables();
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
            $row[] = ($item->status_beasiswa == 3 ? '<span class="badge badge-success">Penerima Beasiswa</span>' : ($item->status_beasiswa == 4 ? '<span class="badge badge-danger">Dibatalkan</span>' : ($item->status_beasiswa == 5 ? '<span class="badge badge-warning">Selesai</span>' : null)));
            $row[] = $item->tanggal_daftar;
            // $row[] = (is_null($item->id_beasiswa) ? '<span class="badge badge-danger">Pernah Menerima</span>' : '<span class="badge badge-success">Sedang Menerima</span>')  ;
            // add html for action
            $row[] = '<a href="'.site_url('data_beasiswa/mahasiswa/detail/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>
                      <form action="'. base_url('data_beasiswa/mahasiswa/hapusMahasiswa').'" id="deleteForm" method="post" style="display: inline-block;">
                        <input name="nim" type="hidden" value="'. $item->nim_mahasiswa .'">    
                        <button id="deleteButton" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                      </form>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->mhs->count_all(),
                    "recordsFiltered" => $this->mhs->count_filtered(),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

     public function index()
    {        
        $data['title'] = "Daftar Penerima";
        $data['isi'] = 'list_mahasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    // @desc - validasi calon penerima beasiswa apakah dia pernah mendapatkan beasiswa menggunakan excelupload
    // @used by
    // - view 'data_beasiswa/list_mahasiswa_v
    public function validasiPenerima()
    {
        $id = $this->input->post('id_upload');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls'; 
        $config['file_name'] ='doc' . time();

        $this->load->library('upload', $config);
        // sesuai dengan name dari input file
        if($this->upload->do_upload('list_nim_penerima')){
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open('uploads/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                $err_array = array();
                $err_nim_length = array();
                foreach ($sheet->getRowIterator() as $row) {
                    $cells = $row->getCells();
                    if($numRow > 1){
                        $data = array(
                            'nim' => $cells[1]->getValue(),
                        );
                        if(strlen($data['nim']) != 8){
                            $msg = "nim '{$data['nim']}' digit tidak sesuai";
                            array_push($err_nim_length, $msg);
                        }else {
                            $cek = $this->penerima->cekDetailBeasiswa($data['nim'])->get()->result_array();
                            if($cek){
                                array_push($err_array, $cek);
                            }
                        }
                    }
                    $numRow++;
                }
                $reader->close();
                $name = $file['file_name'];
                unlink('uploads/'.$name);
                
                $this->session->set_flashdata('validasi_mahasiswa_pendaftar_beasiswa', $err_array);
                $this->session->set_flashdata('err_nim_length', $err_nim_length);
                redirect('data_beasiswa/mahasiswa/detailValidasiMahasiswa');
            }
        }else {
            $this->session->set_flashdata("error_upload", 
               $this->upload->display_errors() );
            redirect('data_beasiswa/mahasiswa');
            // echo "Error : " . $this->upload->display_errors();

        }
    }

    // @desc    digunakan untuk menampilkan data hasil validasi mahasiswa penerima beasiswa 
    public function detailValidasiMahasiswa()
    {    
        $data['title'] = "Detail Validasi Mahasiswa";
        $data['hasil_validasi'] = $this->session->flashdata('validasi_mahasiswa_pendaftar_beasiswa');
        $data['err_nim_length'] = $this->session->flashdata('err_nim_length');
        $data['isi'] = 'detail_validasi_mahasiswa_beasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);     
    }

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

    public function detail($id = null)
    {    
        if(!$id){
            redirect('auth/oops');
        }
        
        $datamhsd=$this->getmhsapis($id);
        $arrmhs=get_object_vars($datamhsd->data);
        
        
        $datamhsaktif=$this->getmhsaktifapis($id,checkSemester());

        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }
        $data['mhs_api'] = $arrmhs;
        $data['title'] = "Detail Mahasiswas";
        
        $data['mahasiswa'] = $this->mhs->getPenerimaBeasiswa($id)->row();
        $data['beasiswa'] = $this->mhs->getBeasiswaYangDiterima($id)->result_array();
        $data['isi'] = 'detail_mahasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function edit($nim)
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $data['title'] = 'Edit Data Mahasiswa';
        
        $this->form_validation->set_rules('name','Nama Mahasiswa','required');
        $this->form_validation->set_rules('prodi','Nama Mahasiswa','required');
        $this->form_validation->set_rules('fakultas','Nama Mahasiswa','required');

        if($this->form_validation->run() == false){
            $query = $this->mhs->getPenerimaBeasiswa($nim);
            if($query->num_rows() > 0){
                $data['data_penerima'] = $query->row();
                $data['isi'] = 'mahasiswa_edit_v';
                $this->load->view('template/wrapper_frontend_v', $data);
            }else{
                redirect('auth/oops');
            }
        }else {
                $post = $this->input->post(null, TRUE);
                $this->mhs->editPenerimaBeasiswa($post);
                    $this->session->set_flashdata("message", 
                        "Data Mahasiswa berhasil diubah!");
                        redirect('data_beasiswa/mahasiswa/detail/'.$nim );
            }
    }

    public function hapusMahasiswa()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        
        $post = $this->input->post(null, TRUE);
        $cek = $this->penerima->hapusMahasiswaModel($post);
        if($cek == false){
            $this->session->set_flashdata("gagal", 
                        "Gagal dihapus, mahasiswa masih terdaftar sebagai penerima beasiswa!");
        }else {
            $this->session->set_flashdata("message", 
            "Data Mahasiswa Berhasil dihapus!");
        }
        redirect('data_beasiswa/mahasiswa');
    }
} 