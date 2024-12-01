<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Penetapan_mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // cek_akses_user();
        $this->load->model('Penetapan_mahasiswa_m', 'penetapan');
    }

     public function get_ajax($id)
    {

        $list = $this->penetapan->get_datatables($id);
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
            $row[] = ($item->status_beasiswa == 2 ? '<span class="badge badge-primary">Divalidasi</span>' : ($item->status_beasiswa == 3 ? '<span class="badge badge-success">Ditetapkan</span>' : null));
            $row[] = $item->tanggal_daftar;
            $row[] = '<a href="'.site_url('penetapan-mahasiswa/detail-mahasiswa/'.$id.'/'.$item->nim_mahasiswa).'" class="btn btn-primary btn-xs"><i class="fas fa-search-plus"></i> Detail</a>
                      <form action="'. base_url('penetapan-mahasiswa/hapus-mahasiswa').'" id="deleteForm" method="post" style="display: inline-block;">
                        <input name="nim" type="hidden" value="'. $item->nim_mahasiswa .'">
                        <input name="id_beasiswa" type="hidden" value="'. $item->nim_mahasiswa .'">
                        <button id="deleteButton" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                      </form>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->penetapan->count_all($id),
                    "recordsFiltered" => $this->penetapan->count_filtered($id),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {
        cek_akses_user();
        $data['title'] = "Penetapan Mahasiswa Pendaftar Beasiswa";

        $data['master_beasiswa'] = $this->penetapan->getMasterBeasiswaPenetapan()->result_array();

        $data['isi'] = 'penetapan_mahasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail($id = null)
    {
        if($id == null){
            redirect('auth/oops');
        }

        $data['id'] = $id;
        $data['title'] = 'Daftar Mahasiswa Pendaftar';

        $data['isi'] = 'penetapan_mahasiswa_detail_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function detail_mahasiswa($id, $nim)
    {
        $data['mahasiswa'] = $this->penetapan->getMahasiswaPendaftar($id, $nim)->row();

        $data['berkas_pendaftaran'] = $this->penetapan->getBerkasPendaftaran($data['mahasiswa']->id)->result_array();
        $data['title'] = 'Tetapkan Mahasiswa';
        $data['id_untuk_back'] = $id;

        $datamhsaktif=$this->getmhsaktifapis($nim,checkSemester());
        $cekAktif = $datamhsaktif->respon;
        if($cekAktif == 1){
            $data['cek_aktif'] =  1;
        }else {
            $data['cek_aktif'] = 0;
        }
        $data['isi'] = 'penetapan_mahasiswa_detail_mahasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    // @desc - membatalkan dan metetapkan mahasiswa tertentu menjadi penerima beasiswa
    // @used by
    // - view 'penetapan_mahasiswa/penetapan_mahasiswa_detail_mahasiswa_v
    function tetapkan($id, $nim)
    {
        $totalKuotaPenetapan = $this->penetapan->cekTotalKuotaPenetapan($id);
          if($totalKuotaPenetapan)
          {
            $this->session->set_flashdata("gagal", "Penetapan Gagal, kuota sudah terpenuhi");

              redirect('penetapan-mahasiswa/detail-mahasiswa/'.$id.'/'.$nim);
          }
        $this->penetapan->tetapkanBeasiswa($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "Penetapan Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Penetapan Gagal");
        }
        redirect('penetapan-mahasiswa/detail/'.$id);
    }

    // @desc - membatalkan mahasiswa tertentu menjadi penerima beasiswa
    // @used by
    // - view 'penetapan_mahasiswa/penetapan_mahasiswa_detail_mahasiswa_v
    function batalkan($id, $nim)
    {
        $this->penetapan->batalkanBeasiswa($id, $nim);
        if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "Pembatalan Proses Penetapan Berhasil");
        }else {
            $this->session->set_flashdata("gagal", "Penetapan Gagal");
        }

        redirect('penetapan-mahasiswa/detail/'.$id);
    }

        // @desc - membuat fitur export excel
        // @used by
        // - view 'validasi/validasi_detail_v
        public function excel($id)
        {

            $data['mahasiswa_pendaftar'] = $this->penetapan->getMahasiswaPendaftarAll($id)->result_array();
            // echo '<pre>';
            // print_r($data['mahasiswa_pendaftar']);
            // echo '<pre>';
            // die;
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

            $sheet->setCellValue('A1', "DATA MAHASISWA YANG MENDAFTAR BEASISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
            $sheet->mergeCells('A1:X1'); // Set Merge Cell pada kolom A1 sampai E1
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
            // Buat header tabel nya pada baris ke 3
            $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
            $sheet->setCellValue('B3', "NIM"); // Set kolom B3 dengan tulisan "NIM"
            $sheet->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
            $sheet->setCellValue('D3', "PRODI"); // Set kolom D3 dengan tulisan "PRODI"
            $sheet->setCellValue('E3', "FAKULTAS"); // Set kolom E3 dengan tulisan "FAKULTAS"
            $sheet->setCellValue('F3', "JP"); // Set kolom E3 dengan tulisan "JENJANG PENDIDIKAN"
            $sheet->setCellValue('G3', "IPK"); // Set kolom E3 dengan tulisan "IPK"
            $sheet->setCellValue('H3', "NOHP"); // Set kolom E3 dengan tulisan "No Hp"
            $sheet->setCellValue('I3', "NIK"); // Set kolom E3 dengan tulisan "No Hp"
            $sheet->setCellValue('J3', "NAMA REKENING"); // Set kolom E3 dengan tulisan "Nama Rekening"
            $sheet->setCellValue('K3', "NO REKENING"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('L3', "NAMA AYAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('M3', "STATUS AYAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('N3', "HUB DGN AYAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('O3', "PENDIDIKAN AYAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('P3', "PENGHASILAN AYAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('Q3', "NAMA IBU"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('R3', "STATUS IBU"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('S3', "HUB DGN IBU"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('T3', "PENDIDIKAN IBU"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('U3', "PENGHASILAN IBU"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('V3', "STATUS RUMAH"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('W3', "UKT"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('X3', "TOTAL POINT"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('Y3', "TEMPAT LAHIR"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('Z3', "TGL LAHIR"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('AA3', "JENIS KELAMIN"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('AB3', "NOHP AKTIF"); // Set kolom E3 dengan tulisan "No Rekening"
            $sheet->setCellValue('AC3', "EMAIL"); // Set kolom E3 dengan tulisan "No Rekening"

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col);
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);
            $sheet->getStyle('H3')->applyFromArray($style_col);
            $sheet->getStyle('I3')->applyFromArray($style_col);
            $sheet->getStyle('J3')->applyFromArray($style_col);
            $sheet->getStyle('K3')->applyFromArray($style_col);
            $sheet->getStyle('L3')->applyFromArray($style_col);
            $sheet->getStyle('M3')->applyFromArray($style_col);
            $sheet->getStyle('N3')->applyFromArray($style_col);
            $sheet->getStyle('O3')->applyFromArray($style_col);
            $sheet->getStyle('P3')->applyFromArray($style_col);
            $sheet->getStyle('Q3')->applyFromArray($style_col);
            $sheet->getStyle('R3')->applyFromArray($style_col);
            $sheet->getStyle('S3')->applyFromArray($style_col);
            $sheet->getStyle('T3')->applyFromArray($style_col);
            $sheet->getStyle('U3')->applyFromArray($style_col);
            $sheet->getStyle('V3')->applyFromArray($style_col);
            $sheet->getStyle('W3')->applyFromArray($style_col);
            $sheet->getStyle('X3')->applyFromArray($style_col);
            $sheet->getStyle('Y3')->applyFromArray($style_col);
            $sheet->getStyle('Z3')->applyFromArray($style_col);
            $sheet->getStyle('AA3')->applyFromArray($style_col);
            $sheet->getStyle('AB3')->applyFromArray($style_col);
            $sheet->getStyle('AC3')->applyFromArray($style_col);

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
                $sheet->setCellValue('H'.$numrow, $mhs['nohp']);
                $sheet->setCellValueExplicit('I'.$numrow, $mhs['tulis_nik'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);     
                $sheet->setCellValue('J'.$numrow, $mhs['pemilik_rekening']);
                $sheet->setCellValueExplicit('K'.$numrow, $mhs['tulis_no_rekening'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('L'.$numrow, $mhs['tulis_nama_ayah']);
                $sheet->setCellValue('M'.$numrow, $mhs['nama_status_ayah']);
                $sheet->setCellValue('N'.$numrow, $mhs['nama_hub_ayah']);
                $sheet->setCellValue('O'.$numrow, $mhs['nama_pendidikan_ayah']);
                $sheet->setCellValue('P'.$numrow, $mhs['rata_penghasilan_ayah']);
                $sheet->setCellValue('Q'.$numrow, $mhs['tulis_nama_ibu']);
                $sheet->setCellValue('R'.$numrow, $mhs['nama_status_ibu']);
                $sheet->setCellValue('S'.$numrow, $mhs['nama_hub_ibu']);
                $sheet->setCellValue('T'.$numrow, $mhs['nama_pendidikan_ibu']);
                $sheet->setCellValue('U'.$numrow, $mhs['rata_penghasilan_ibu']);
                $sheet->setCellValue('V'.$numrow, $mhs['nama_status_rumah']);
                $sheet->setCellValue('W'.$numrow, $mhs['ukt']);
                $sheet->setCellValue('X'.$numrow, $mhs['total_point_penilaian']);
                $sheet->setCellValue('Y'.$numrow, $mhs['tmp_lhr']);
                $sheet->setCellValue('Z'.$numrow, $mhs['tgl_lhr']);
                $sheet->setCellValue('AA'.$numrow, $mhs['jenis_kelamin']);
                $sheet->setCellValue('AB'.$numrow, $mhs['tulis_nohp']);
                $sheet->setCellValue('AC'.$numrow, $mhs['tulis_email']);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('O'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('P'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('Q'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('R'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('S'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('T'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('U'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('V'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('W'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('X'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('Y'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('Z'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('AA'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('AB'.$numrow)->applyFromArray($style_row);
                $sheet->getStyle('AC'.$numrow)->applyFromArray($style_row);

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
            $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
            $sheet->getColumnDimension('I')->setWidth(30); // Set width kolom E
            $sheet->getColumnDimension('J')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('K')->setWidth(22); // Set width kolom E
            $sheet->getColumnDimension('L')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('M')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('N')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('O')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('P')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('Q')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('R')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('S')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('T')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('U')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('V')->setWidth(8); // Set width kolom E
            $sheet->getColumnDimension('W')->setWidth(12); // Set width kolom E
            $sheet->getColumnDimension('X')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('Y')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('Z')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('AA')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('AB')->setWidth(10); // Set width kolom E
            $sheet->getColumnDimension('AC')->setWidth(10); // Set width kolom E

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
