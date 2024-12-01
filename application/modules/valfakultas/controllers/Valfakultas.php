<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Valfakultas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        cek_akses_user();
        $this->load->model('Valfakultas_m', 'valfakultas');
    }

     public function get_ajax($id) 
    {
       
        $list = $this->valfakultas->get_datatables($id);
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
            $row[] = ($item->status_beasiswa == '0' ? '<span class="badge badge-warning">Menunggu Validasi Fakultas</span>' : ($item->status_beasiswa == 11 ? '<span class="badge badge-danger">Validasi Ditolak</span>' : ($item->status_beasiswa == '0b' ? '<span class="badge badge-warning">Didaftarkan Admin, Menunggu Validasi Fakultas</span>' : '<span class="badge badge-success">Sudah divalidasi fakultas</span>' )));
            $row[] = $item->tanggal_daftar;
            $row[] = '<a href="'.site_url('valfakultas/detail-mahasiswa/'.$id.'/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>
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
                    "recordsTotal" => $this->valfakultas->count_all($id),
                    "recordsFiltered" => $this->valfakultas->count_filtered($id),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }
    
    public function index()
    {
        $data['title'] = "validasi Mahasiswa Pendaftar Beasiswa";
        $data['master_beasiswa'] = $this->valfakultas->getMasterBeasiswaValidasiFakultas()->result_array();
        $data['isi'] = 'valfakultas_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail($id = null)
    {
        if($id == null){
            redirect('auth/oops');
        }
        $data['id'] = $id;
        $data['title'] = 'Daftar Mahasiswa Pendaftar';
      
        $data['isi'] = 'valfakultas_detail_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail_mahasiswa($id, $nim)
    {
        $data['mahasiswa'] = $this->valfakultas->getMahasiswaPendaftar($id, $nim)->row();
        $id_untuk_mencari_comment = $data['mahasiswa']->id; 
        $data['comment'] = $this->valfakultas->getComment($id_untuk_mencari_comment)->result_array();
        $data['berkas_pendaftaran'] = $this->valfakultas->getBerkasPendaftaran($data['mahasiswa']->id)->result_array();
        $data['title'] = 'Tetapkan Mahasiswa';
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

    // @desc - meluluskan mahasiswa dari proses validasi fakultas\
    // @used by
    // - view 'valfakultas/validasi_detail_mahasiswa_v
    function calonkan($id, $nim)
    {
        $this->valfakultas->terimaValidasiFakultas($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "validasi Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Validasi Gagal");
        }
           
        redirect('valfakultas/detail/'.$id);
    }

    // @desc - membatalkan mahasiswa dari kelulusan proses validasi calon penerima beasiswa
    // @used by
    // - view 'valfakultas/validasi_detail_mahasiswa_v
    function batalkan($id, $nim)
    {
        $this->valfakultas->batalkanValidasiFakultas($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Pembatalan Validasi Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Pembatalan Validasi Gagal");
        }
           
        redirect('valfakultas/detail/'.$id);
    }

    // @desc - reject pendaftaran mahasiswa karna beberapa hal seperti kurang lengkapnya dokumen
    // @used by
    // - view 'valfakultas/validasi_detail_mahasiswa_v
    function tolak($id, $nim, $id_mahasiswa_beasiswa)
    {
        $this->valfakultas->tolakValidasiFakultas($id, $nim, $id_mahasiswa_beasiswa);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Pendaftaran Mahasiswa ditolak");
        }else {
            $this->session->set_flashdata("gagal", "Pembatalan Validasi Gagal");
        }
           
        redirect('valfakultas/detail-mahasiswa/'.$id.'/'.$nim, 'refresh');
    }

     // @desc - ajukan kembali pendaftaran mahasiswa
    // @used by
    // - view 'valfakultas/validasi_detail_mahasiswa_v
    function batalkanPenolakan($id, $nim, $id_untuk_hapus_comment)
    {
        $this->valfakultas->batalkanPenolakanValidasiFakultas($id, $nim, $id_untuk_hapus_comment);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Daftarkan kembali pencalonan mahasiswa");
        }else {
            $this->session->set_flashdata("gagal", "Pembatalan Validasi Gagal");
        }
           
        redirect('valfakultas/detail-mahasiswa/'.$id.'/'.$nim, 'refresh');
    }

    // @desc - membuat fitur export excel
    // @used by
    // - view 'validasi/validasi_detail_v
    public function excel($id)
    {
        
        $data['mahasiswa_pendaftar'] = $this->valfakultas->getMahasiswaPendaftarAll($id)->result_array();
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font'      => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                            ],
            'borders' => [
                            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A1', "DATA MAHASISWA YANG DIVALIDASI FAKULTAS"); // Set kolom A1 dengan tulisan "DATA MAHASISWA YANG DIVALIDASI FAKULTAS"
        $sheet->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai G1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "NIM"); // Set kolom B3 dengan tulisan "NIM"
        $sheet->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "PRODI"); // Set kolom D3 dengan tulisan "PRODI"
        $sheet->setCellValue('E3', "FAKULTAS"); // Set kolom E3 dengan tulisan "FAKULTAS"
        $sheet->setCellValue('F3', "JP"); // Set kolom E3 dengan tulisan "JENJANG PENDIDIKAN"
        $sheet->setCellValue('G3', "IPK"); // Set kolom E3 dengan tulisan "IPK"
        $sheet->setCellValue('H3', "STATUS"); // Set kolom E3 dengan tulisan "IPK"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($data['mahasiswa_pendaftar'] as $mhs){ // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $mhs['nim_mahasiswa']);
            $sheet->setCellValue('C'.$numrow, $mhs['nama_mahasiswa']);
            $sheet->setCellValue('D'.$numrow, $mhs['prodi']);
            $sheet->setCellValue('E'.$numrow, $mhs['fakultas']);
            $sheet->setCellValue('F'.$numrow, $mhs['jjp']);
            $sheet->setCellValue('G'.$numrow, $mhs['ipk']);
            if($mhs['status_beasiswa'] == 0){
                $sheet->setCellValue('H'.$numrow, 'Menunggu Validasi');
            }else {
                $sheet->setCellValue('H'.$numrow, 'Sudah Validasi');
            }
            
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
            
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(30); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(8); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(8); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(8); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Siswa");

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data_Mahasiswa_Mendaftar_Beasiswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');


        // ini akhir


        // $object->getProperties()->setCreator("Kemahasiswaan UNP");
        // $object->getProperties()->setLastModifiedBy("Kemahasiswaan UNP");
        // $object->getProperties()->setTitle("Kemahasiswaan UNP");

        // $object->setActiveSheetIndex(0);
        // $object->getActiveSheet()->setCellValue('A1', 'NO');
        // $object->getActiveSheet()->setCellValue('B1', 'NIM');
        // $object->getActiveSheet()->setCellValue('C1', 'Nama Mahasiswa');
        // $object->getActiveSheet()->setCellValue('D1', 'Prodi');
        // $object->getActiveSheet()->setCellValue('E1', 'Fakultas');
        // $object->getActiveSheet()->setCellValue('F1', 'Tahun Masuk');
        // $object->getActiveSheet()->setCellValue('G1', 'Jenjang Pendidikan');
        // $object->getActiveSheet()->setCellValue('H1', 'IPK');
        // $object->getActiveSheet()->setCellValue('I1', 'Jekel');
        // $object->getActiveSheet()->setCellValue('J1', 'No HP');

        // $baris = 2;
        // $no = 1;

        // foreach ($data['mahasiswa_pendaftar'] as $mhs) {
        //     $object->getActiveSheet()->setCellValue('A'.$baris, $no++);
        //     $object->getActiveSheet()->setCellValue('B'.$baris, $mhs['nim_mahasiswa']);
        //     $object->getActiveSheet()->setCellValue('C'.$baris, $mhs['nama_mahasiswa']);
        //     $object->getActiveSheet()->setCellValue('D'.$baris, $mhs['prodi']);
        //     $object->getActiveSheet()->setCellValue('E'.$baris, $mhs['fakultas']);
        //     $object->getActiveSheet()->setCellValue('F'.$baris, $mhs['tm_msk']);
        //     $object->getActiveSheet()->setCellValue('G'.$baris, $mhs['jjp']);
        //     $object->getActiveSheet()->setCellValue('H'.$baris, $mhs['ipk']);
        //     $object->getActiveSheet()->setCellValue('I'.$baris, $mhs['jenis_kelamin']);
        //     $object->getActiveSheet()->setCellValue('J'.$baris, $mhs['nohp'] );

        //     $baris++;
        // }

        // $filename="Data_Mahasiswa_Penerima_Beasiswa".'.xlsx';
        // $object->getActiveSheet()->setTitle('Data Mahasiswa Penerima Beasiswa');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'.$filename.'"');
        // header('Cache-Control: max-age=0');
        // $writer=PHPExcel_IOFactory::createWriter($object,'Excel2007');
        // $writer->save('php://output');

        // exit;
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