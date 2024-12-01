<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
class Mhs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('mbeasiswa/Beasiswa_m', 'pbeasiswa');
        $this->load->model('Mhs_m', 'mhs');
        $this->load->model('data_beasiswa/Penerima_beasiswa_m', 'penerima');    
    }

    public function index()
    {        
        $data['title'] = "Daftar Penerima";
        $data['isi'] = 'mhs_v';
        $this->load->view('template/wrapper_frontend_v', $data);
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
            $row[] = '<a href="'.site_url('mhs/detail/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>';
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
    
    public function detail($id = null)
    {    
        if(!$id){
            redirect('auth/oops');
        }
        $data['title'] = "Detail Mahasiswa";
        $data['mahasiswa'] = $this->mhs->getPenerimaBeasiswa($id)->row();
        $data['beasiswa'] = $this->mhs->getBeasiswaYangDiterima($id)->result_array();
        $data['isi'] = 'detail_mahasiswa_v';
        echo '<pre>' ; 
print_r($data); 
echo '</pre>' ; 
die;

        $this->load->view('template/wrapper_frontend_v', $data);   
    }

    // @desc - validasi calon penerima beasiswa apakah dia pernah mendapatkan beasiswa menggunakan excelupload
    // @used by
    // - view 'mhs/index
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
                redirect('mhs/validasi');
            }
        }else {
            $this->session->set_flashdata("error_upload", 
               $this->upload->display_errors() );
            redirect('mhs');

        }
    }

     // @desc    digunakan untuk menampilkan data hasil validasi mahasiswa penerima beasiswa 
    public function validasi()
    {    
        $data['title'] = "Detail Validasi Mahasiswa";

        $data['hasil_validasi'] = $this->session->flashdata('validasi_mahasiswa_pendaftar_beasiswa');
        $data['err_nim_length'] = $this->session->flashdata('err_nim_length');
        
        $data['isi'] = 'detail_validasi_mahasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data); 
    }
} 