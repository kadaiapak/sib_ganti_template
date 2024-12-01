<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_akses_user();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('mbeasiswa/Beasiswa_m', 'pbeasiswa');
        $this->load->model('Penerima_beasiswa_m', 'penerima');
    }

    // @desc - library datatable yang digunakan untuk menampilkan list mahasiswa penerima beasiswa tertentu
    // @used by
    // - jquery dan views => data_beasiswa/views/detail_beasiswa_v
    public function get_ajax($id = null)
    {
        if ($id != null) {
            $list = $this->penerima->get_datatables($id);
        }
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            // $row[] = $no.".";
            $row[] = $no;
            $row[] = $item->nim_mahasiswa;
            $row[] = $item->nama_mahasiswa;
            $row[] = $item->prodi;
            $row[] = $item->fakultas;
            $row[] = $item->ipk;
            $row[] = $item->status_beasiswa == "3" ? "<span class='badge badge-success'>Penerima</span>" : ($item->status_beasiswa == "4" ? "<span class='badge badge-danger'>Tidak Aktif</span>" : "");
            $row[] = '<a href="' . base_url('data_beasiswa/beasiswa/' . $item->id_beasiswa . '/mahasiswa/' . $item->nim_mahasiswa) . '" class="btn btn-primary btn-action"><i class="fas fa-search-plus"></i></a>
                      <form action="' . base_url('data_beasiswa/beasiswa/hapusPenerima') . '" method="post" id="deleteFormDetailMahasiswaBeasiswa" style="display: inline-block;">
                        <input
                            name="id_beasiswa"
                            type="hidden"
                            value="' . $item->id_beasiswa . '">
                        <input
                            name="nim"
                            type="hidden"
                            value="' . $item->nim_mahasiswa . '">
                        <button id="deleteButtonDetailMahasiswaBeasiswa" class="btn btn-danger btn-action" data-toggle="tooltip" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->penerima->count_all($id),
            "recordsFiltered" => $this->penerima->count_filtered($id),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {
        $data['title'] = "Daftar Beasiswa";
        $tahun = $this->session->userdata('tahun_beasiswa_master');
        //
        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] = base_url('data_beasiswa/beasiswa/index');
        $config['total_rows'] = $this->penerima->countMasterBeasiswaShowPagination($tahun);
        $config['per_page'] = 10;
        // styling
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');
        // initialize
        $this->pagination->initialize($config);
        // get data
        $data['start_at'] = $this->uri->segment(4);
        // END OF PAGINATION
        $data['master_beasiswa'] = $this->penerima->getMasterBeasiswaShow($config['per_page'], $data['start_at'], $tahun)->result_array();
        //
        $data['isi'] = 'list_master_beasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }
    
    public function cari()
    {
        $tahun = $this->input->post('tahun_beasiswa_master');
        $this->session->set_userdata('tahun_beasiswa_master',$tahun);
        redirect(base_url('data_beasiswa/beasiswa'));
    }

    public function detail($id = null)
    {
        if (!$id) {
            redirect('auth/oops');
        }
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = "Detail Beasiswa";
        $data['isi'] = 'detail_beasiswa_v';

        $data['detail_beasiswa'] = $this->penerima->getDetailBeasiswa($id);
        $data['sk'] = $this->penerima->getMasterSk($data['detail_beasiswa']['id'])->result_array();
        $data['bp'] = $this->penerima->getMasterBP($data['detail_beasiswa']['id'])->result_array();
        $data['periode'] = $this->pbeasiswa->getPeriodeBeasiswa()->result_array();
        $data['total_penerima'] = $this->penerima->getTotalPenerimaDetailBeasiswa($id);

        $this->load->view('template/wrapper_frontend_v', $data);
    }

    // @desc - upload pdf sk rektor
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v
    public function uploadDetailSk()
    {
        if ($this->cek_akses_user['edit'] != 1) {
            redirect('auth/blocked');
        }

        $post = $this->input->post(null, true);
        $id = $this->input->post('id');
        $nama = $this->input->post('nama_sk');
        $tahun = $this->input->post('tahun');
        if ($this->input->post('tahun_upload') == '') {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Surat Keputusan, Silahkan pilih tahun");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }
        if ($this->input->post('periode') == '') {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Surat Keputusan, Silahkan pilih periode");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }

        if ($_FILES["sk"]['error'] != 0) {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Surat Keputusan, Silahkan pilih file yang akan di upload");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }

        $config['upload_path'] = './uploads/sk/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 1024;
        $config['file_name'] = 'sk_' . $nama . '_' . $tahun . '_' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('sk')) {
            $post['sk'] = $this->upload->data('file_name');
            $this->penerima->uploadSk($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message",
                    "SK berhasil di upload !");
                redirect('data_beasiswa/beasiswa/detail/' . $id);
            } else {
                $this->session->set_flashdata("gagal",
                    "SK gagal diupload!");
                redirect('data_beasiswa/beasiswa/detail/' . $id);
            }
        } else {
            $error = $this->upload->display_errors();
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }
    }

    // @desc - halam detail mahasiswa dari satu beasiswa
    // @desc - digunakan untuk upload data bukti transfer beasiswa
    // @used by
    // - view 'data_beasiswa/detail_mahasiswa_beasiswa_v
    public function detailMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
    {
        $data['title'] = "Detail Mahasiswa";
        $data['mahasiswa'] = $this->penerima->getMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)->row();
        $data['periode'] = $this->pbeasiswa->getPeriodeBeasiswa()->result_array();
        $data['bp'] = $this->penerima->getBuktiPembayaran($id_beasiswa, $nim)->result_array();
        $datamhsaktif = $this->getmhsaktifapis($nim, checkSemester());

        $cekAktif = $datamhsaktif->respon;
        if ($cekAktif == 1) {
            $data['cek_aktif'] = 1;
        } else {
            $data['cek_aktif'] = 0;
        }
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('periode', 'Periode', 'required');
        if (empty($_FILES['bukti_pembayaran']['name'])) {
            $this->form_validation->set_rules('bukti_pembayaran', 'Bukti Pembayaran', 'required');
        }
        if ($this->form_validation->run() == false) {
            $data['isi'] = 'detail_mahasiswa_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            $post = $this->input->post(null, true);
            $nama_beasiswa = $this->input->post('nama_beasiswa');
            $id_beasiswa = $this->input->post('id_beasiswa');
            $nim_mahasiswa = $this->input->post('nim_mahasiswa');
            $tahun_beasiswa = $this->input->post('tahun_beasiswa');

            $config['upload_path'] = './uploads/sk/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 1024;
            $config['file_name'] = 'bukti_P_' . $nama_beasiswa . '_' . $tahun_beasiswa . '_' . time();

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti_pembayaran')) {
                // cek di database apakah ada gambar
                $post['bukti_pembayaran'] = $this->upload->data('file_name');
                $this->penerima->uploadBuktiPembayaranPerorangan($post);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata("message",
                        "SK berhasil di upload !");
                    redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim_mahasiswa");
                } else {
                    $this->session->set_flashdata("gagal",
                        "SK Gagal Upload!");
                    redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim_mahasiswa");
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata("error_upload",
                    "Gagal Upload $error");
                redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim_mahasiswa");
            }
        }
    }

    // @desc - upload rekap bukti pembayaran
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v
    public function uploadDetailPembayaran()
    {
        if ($this->cek_akses_user['edit'] != 1) {
            redirect('auth/blocked');
        }
        $post = $this->input->post(null, true);
        $id = $this->input->post('id');
        $nama = $this->input->post('nama_bp');
        $tahun = $this->input->post('tahun');
        if ($this->input->post('tahun_upload') == '') {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Bukti Pembayaran, Silahkan isi tahun");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }
        if ($this->input->post('periode') == '') {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Bukti Pembayaran Silahkan pilih periode");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }

        if ($_FILES["bp"]['error'] != 0) {
            $this->session->set_flashdata("error_upload",
                "Gagal Upload Bukti Pembayaran, Silahkan pilih file yang akan di upload");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }

        $config['upload_path'] = './uploads/sk/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;
        $config['file_name'] = 'bp_' . $nama . '_' . $tahun . '_' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('bp')) {
            $post['bp'] = $this->upload->data('file_name');
            $this->penerima->uploadBp($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata("message",
                    "Bukti Pembayaran berhasil di upload !");
                redirect('data_beasiswa/beasiswa/detail/' . $id);
            } else {
                $this->session->set_flashdata("gagal",
                    "Bukti Pembayaran Gagal diupload !");
                redirect('data_beasiswa/beasiswa/detail/' . $id);
            }
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata("error_upload",
                "Gagal Upload $error");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }

    }

    // @desc - upload penerima beasiswa menggunakan excelupload
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v
    public function uploadpenerima()
    {
        if ($this->cek_akses_user['tambah'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id_upload');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'doc' . time();

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('uploadbeasiswa')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();

            $reader->open('uploads/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                $err_array = array();
                $upload_array = array();
                foreach ($sheet->getRowIterator() as $row) {
                    $cells = $row->getCells();
                    if ($numRow > 1) {
                        // $nim = $cells[1]->getValue();
                        $data = array(
                            'nim' => $cells[1]->getValue(),
                            'biaya_hidup' => $cells[2]->getValue(),
                            'ukt' => $cells[3]->getValue(),
                        );
                        if (strlen($data['nim']) != 8) {
                            // $msg = $nim.' jumlah digit tidak sesuai<br>';
                            $msg = "<div class='alert alert-danger' role='alert'>" . $data['nim'] . " digit tidak sesuai</div>";
                            array_push($err_array, $msg);
                        }
                        $dataMahasiswa = $this->getmhsapis($data['nim']);
                        if ($dataMahasiswa->respon == 2) {
                            $msg = "<div class='alert alert-danger' role='alert'>" . $data['nim'] . " data mahasiswa tidak ditemukan</div>";
                            array_push($err_array, $msg);
                        } else {
                            $arrmhs = get_object_vars($dataMahasiswa->data);
                            $arrmhs['biaya_hidup'] = $data['biaya_hidup'];
                            $arrmhs['ukt'] = $data['ukt'];
                            $cek = $this->penerima->cekBeasiswa($data['nim']);
                            if (!$cek) {
                                array_push($upload_array, $arrmhs);
                            } else {
                                $msg = "<div class='alert alert-danger' role='alert'>" . $data['nim'] . " sudah pernah mendapatkan beasiswa</div>";
                                array_push($err_array, $msg);
                            }
                        }
                    }
                    $numRow++;
                }
                $reader->close();
                $name = $file['file_name'];
                unlink('uploads/' . $name);
                if ($err_array) {
                    $msg = '';
                    foreach ($err_array as $er) {
                        $msg .= $er;
                    }
                    // echo 'data gagal di upload';
                    $this->session->set_flashdata('pesan', $msg);
                } else {
                    $this->penerima->import_data($upload_array, $id);
                    echo 'data sukses di upload';
                    $this->session->set_flashdata('message', "Data Sukses di Upload");
                }
                redirect('data_beasiswa/beasiswa/detail/' . $id);
            }
        } else {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata("error_upload",
                "Gagal Upload $error");
            redirect('data_beasiswa/beasiswa/detail/' . $id);
        }
    }

    public function check_tambah($id = null)
    {
        if ($this->cek_akses_user['tambah'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        if (!$id) {
            redirect('auth/oops');
        }
        $data['id'] = $id;
        $data['title'] = 'Validasi Tambah Penerima';
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|min_length[8]');

        if ($this->form_validation->run() == false) {
            $data['isi'] = 'validasi_penerima_tambah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }
    }

    //
    public function tambah($id = null)
    {
        if ($this->cek_akses_user['tambah'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        if (!$id) {
            redirect('auth/oops');
        }

        $nim = $this->input->post('nim');

        $datamhsd = $this->getmhsapis($nim);
        if ($datamhsd->respon == 2) {
            $this->session->set_flashdata("gagal",
                "data mahasiswa tidak ditemukan");
            redirect('data_beasiswa/beasiswa/check-tambah/' . $id);
        }

        // cek apakah sudah mendaftar di beasiswa tersebut
        // koding belum dibuat
        
        // echo '<pre>'
        // print_r($id);
        // echo '</pre>'
        // die;

        $arrmhs = get_object_vars($datamhsd->data);

        $datamhsaktif = $this->getmhsaktifapis($nim, checkSemester());

        $cekAktif = $datamhsaktif->respon;
        if ($cekAktif == 1) {
            $data['cek_aktif'] = 1;
        } else {
            $data['cek_aktif'] = 0;
        }
        $data['id'] = $id;
        $data['title'] = 'Validasi Tambah Penerima';
        $data['mhs_api'] = $arrmhs;
        $data['isi'] = 'penerima_tambah_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function prosesTambah()
    {
        $id = $this->input->post('id_beasiswa');
        $post = $this->input->post(null, true);
        
        $this->penerima->tambahPenerimaBeasiswa($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Penambahan mahasiswa penerima beasiswa berhasil");
        } else {
            $this->session->set_flashdata("gagal",
                "Penambahan mahasiswa penerima beasiswa gagal");
        }
        redirect('data_beasiswa/beasiswa/detail/' . $id);
    }

    // @desc - membatalkan dan metetapkan mahasiswa tertentu sebagai penerima beasiswa tertentu
    // @used by
    // - view 'data_beasiswa/detail_mahasiswa_beasiswa_v
    public function batalkanPenerima()
    {
        $id_beasiswa = $this->input->post('id_beasiswa');
        $nim = $this->input->post('nim');
        $this->penerima->batalkanBeasiswa($id_beasiswa, $nim);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Status Penerima Beasiswa telah dibatalkan!");
        }
        redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim");
    }

    // @desc - membatalkan dan metetapkan mahasiswa tertentu sebagai penerima beasiswa tertentu
    // @used by
    // - view 'data_beasiswa/detail_mahasiswa_beasiswa_v
    public function tetapkanPenerima()
    {
        $id_beasiswa = $this->input->post('id_beasiswa');
        $nim = $this->input->post('nim');
        $this->penerima->tetapkanBeasiswa($id_beasiswa, $nim);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Penetapan Mahasiswa menjadi penerima beasiswa berhasil!");
        }
        redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim");
    }

    // @desc - menghapus data mahasiswa yang menerima beasiswa tertentu
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v
    public function hapusPenerima()
    {
        if ($this->cek_akses_user['hapus'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        $post = $this->input->post(null, true);
        $this->penerima->hapusPenerimaBeasiswa($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Mahasiswa berhasil dihapus jadi penerima!");
        }
        $id_beasiswa = $post['id_beasiswa'];
        redirect("data_beasiswa/beasiswa/detail/$id_beasiswa");
    }

    // @desc - hapus bukti pembayaran
    // @used by
    // - view 'data_beasiswa/detail_mahasiswa_beasiswa_v'
    public function hapusBuktiPembayaranPerorangan()
    {
        if ($this->cek_akses_user['hapus'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        $post = $this->input->post(null, true);
        $id_beasiswa = $this->input->post('id_beasiswa');
        $nim_mahasiswa = $this->input->post('nim_mahasiswa');
        $nama_file = $this->input->post('nama_file');
        $targetFile = './uploads/sk/' . $nama_file;
        unlink($targetFile);
        $this->penerima->hapusBuktiPembayaranPeroranganModel($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Bukti Pembayaran berhasil dihapus!");
        }
        redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim_mahasiswa");
    }

    // @desc - hapus bukti Sk master beasiswa
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v'
    public function hapusDetailSk()
    {
        if ($this->cek_akses_user['hapus'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        $post = $this->input->post(null, true);
        $id = $this->input->post('id_beasiswa');
        $nama_file = $this->input->post('nama_file_mbs');

        $targetFile = './uploads/sk/' . $nama_file;
        unlink($targetFile);
        $this->penerima->hapusDetailSkModel($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Surat Keputusan berhasil dihapus !");
        }
        redirect("data_beasiswa/beasiswa/detail/$id");
        // echo "<script>window.location='".base_url('data_beasiswa/beasiswa/detail/'.$id)."'</script>";
        // redirect("data_beasiswa/beasiswa/$id_beasiswa/mahasiswa/$nim_mahasiswa");
    }

    // @desc - hapus bukti Bukti Pembayaran master beasiswa
    // @used by
    // - view 'data_beasiswa/detail_beasiswa_v'
    public function hapusDetailPembayaran()
    {
        if ($this->cek_akses_user['hapus'] != '1') {
            redirect(base_url('auth/blocked'));
        }
        $post = $this->input->post(null, true);
        $id = $this->input->post('id_beasiswa');

        $nama_file = $this->input->post('nama_file_mbp');

        $targetFile = './uploads/sk/' . $nama_file;
        unlink($targetFile);

        $this->penerima->hapusDetailBpModel($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("message",
                "Bukti Pembayaran berhasil dihapus!");
        } else {
            $this->session->set_flashdata("gagal",
                "Bukti Pembayaran gagal dihapus!");
        }
        echo "<script>window.location='" . base_url('data_beasiswa/beasiswa/detail/' . $id) . "'</script>";
    }

    // @desc - untuk print
    // @used by
    //  - view 'detail_beasiswa_v'
    public function pdf()
    {
        $id = $this->input->post('id_beasiswa');
        $data['nama_beasiswa'] = $this->input->post('nama_beasiswa');
        $data['periode'] = $this->input->post('periode');
        $data['tahun'] = $this->input->post('tahun');
        $this->load->library('pdfgenerator');
        $data['master_beasiswa'] = $this->pbeasiswa->getPenerimaBeasiswa($id)->result_array();

        // title dari pdf
        $data['title_pdf'] = 'Laporan Penerima Beasiswa';

        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penerima_beasiswa';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "landscape";

        $html = $this->load->view('laporan_pdf', $data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    private function getmhsapis($nim)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'h2hid: 119009',
            'h2hkey: FpY6qZ3S',
            'h2hunicode: nIowYLmcNdMjWHfAgQTlrJqeSpVEsOXvGbzDPaFyuki',
            'nim: ' . $nim,
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_URL, 'https://wsvc.unp.ac.id/api/akademik/cekmhs');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        $header_data = curl_getinfo($ch);
        curl_close($ch);
        return json_decode($output);
    }

    private function getmhsaktifapis($nim, $sem)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'h2hid: 119009',
            'h2hkey: FpY6qZ3S',
            'h2hunicode: nIowYLmcNdMjWHfAgQTlrJqeSpVEsOXvGbzDPaFyuki',
            'nim: ' . $nim,
            'idsem: ' . $sem,
            'Content-Type: application/json',
        ));
        curl_setopt($ch, CURLOPT_URL, 'https://wsvc.unp.ac.id/api/akademik/cekmhsaktif');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        $header_data = curl_getinfo($ch);
        curl_close($ch);
        return json_decode($output);
    }

    
}
