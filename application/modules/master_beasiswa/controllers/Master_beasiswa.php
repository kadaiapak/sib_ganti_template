<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_akses_user();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('Beasiswa_m', 'beasiswa');
    }

    public function index()
    {
        $data['title'] = 'Master Beasiswa';
        // untuk menampilkan atau menghilangkan tombol tambah
        $data['cek'] = $this->cek_akses_user['tambah'];

        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url().'mbeasiswa/master_beasiswa/index';
        $config['total_rows'] = $this->beasiswa->countMasterBeasiswaPagination();
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
        $data['master_beasiswa'] = $this->beasiswa->getMasterBeasiswaPagination($config['per_page'],$data['start_at'])->result_array();
        // END OF PAGINATION

        $data['isi'] = 'master_beasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function tambah()
    {
        if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $data['title'] = 'Tambah Master Beasiswa';

        $data['nama_beasiswa'] = $this->beasiswa->getNamaBeasiswa()->result_array();
        $data['kelompok_beasiswa'] = $this->beasiswa->getKelompokBeasiswa()->result_array();
        $data['asal_beasiswa'] = $this->beasiswa->getAsalBeasiswa()->result_array();
        $data['periode'] = $this->beasiswa->getPeriodeBeasiswa()->result_array();
        $data['jenis_beasiswa'] = $this->beasiswa->getJenisBeasiswa()->result_array();

        // $this->form_validation->set_rules('nama_beasiswa','Nama Beasiswa','required');
        // $this->form_validation->set_rules('kelompok_beasiswa','Kelompok Beasiswa','required');
        // $this->form_validation->set_rules('asal_beasiswa','Asal Beasiswa','required');
        // $this->form_validation->set_rules('jenis_beasiswa','Jenis Beasiswa','required');
        // $this->form_validation->set_rules('periode','Periode','required');
        // $this->form_validation->set_rules('tahun','Tahun','required');
        // $this->form_validation->set_rules('biaya','Besaran Bantuan','required');
        // $this->form_validation->set_rules('metode_pembayaran','Metode Pembayaran','required');
        // $this->form_validation->set_rules('kuota_pendaftaran','Kuota Pendaftaran','required');
        // $this->form_validation->set_rules('kuota_penetapan','Kuota Penetapan','required');
        // $this->form_validation->set_rules('ipk','Ipk','required');

        $this->form_validation->set_rules('nama_beasiswa','Nama Beasiswa','required');
        $this->form_validation->set_rules('kelompok_beasiswa','Kelompok Beasiswa','required');
        $this->form_validation->set_rules('asal_beasiswa','Asal Beasiswa','required');
        $this->form_validation->set_rules('jenis_beasiswa','Jenis Beasiswa','required');
        $this->form_validation->set_rules('periode','Periode','required');
        $this->form_validation->set_rules('tahun','Tahun','required');
        $this->form_validation->set_rules('kuota_pendaftaran','Kuota Pendaftaran','required');
        $this->form_validation->set_rules('tgl_awal_pendaftaran','Tanggal dibuka pendaftaran','required');
        $this->form_validation->set_rules('tgl_tutup_pendaftaran','Tanggal tutup pendaftaran','required');

        if($this->form_validation->run() == false){
            $data['isi'] = 'master_beasiswa_tambah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            // $data = [
            //     'nama_beasiswa' => $this->input->post('nama_beasiswa'),
            //     'kelompok_beasiswa' => $this->input->post('kelompok_beasiswa'),
            //     'asal_beasiswa' => $this->input->post('asal_beasiswa'),
            //     'jenis_beasiswa' => $this->input->post('jenis_beasiswa'),
            //     'biaya' => $this->input->post('biaya'),
            //     'periode' => $this->input->post('periode'),
            //     'min_ipk' => $this->input->post('ipk'),
            //     'tahun' => $this->input->post('tahun'),
            //     'metode_pembayaran' => $this->input->post('metode_pembayaran'),
            //     'kuota_pendaftaran' => $this->input->post('kuota_pendaftaran'),
            //     'kuota_penetapan' => $this->input->post('kuota_penetapan'),
            //     'tgl_awal_pendaftaran' => $this->input->post('tgl_awal_pendaftaran'),
            //     'tgl_tutup_pendaftaran' => $this->input->post('tgl_tutup_pendaftaran'),
            //     'tgl_awal_penetapan' => $this->input->post('tgl_awal_penetapan'),
            //     'tgl_tutup_penetapan' => $this->input->post('tgl_tutup_penetapan'),
            //     'tanggal_penetapan' => $this->input->post('tanggal_penetapan'),
            //     'buka_pendaftaran' => $this->input->post('is_buka_pendaftaran'),
            //     'aktif' => $this->input->post('is_active'),
            //     'tampil' => $this->input->post('is_show'),
            //     'user_created' => $this->fungsi->user_login()->username
            // ];
            //     $this->beasiswa->tambahMasterBeasiswa($data);

            $data = $this->input->post(null, TRUE);
            $this->beasiswa->tambahMasterBeasiswa($data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "Beasiswa Baru telah ditambahkan!");
                redirect('mbeasiswa/master_beasiswa');
            }
        }
    }

    public function edit($id)
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $data['title'] = 'Edit Master Beasiswa';
        $data['asal_beasiswa'] = $this->beasiswa->getAsalBeasiswa()->result_array();
        $data['jenis_beasiswa'] = $this->beasiswa->getJenisBeasiswa()->result_array();
        $data['kelompok_beasiswa'] = $this->beasiswa->getKelompokBeasiswa()->result_array();
        $data['nama_beasiswa'] = $this->beasiswa->getNamaBeasiswa()->result_array();
        $data['periode'] = $this->beasiswa->getPeriodeBeasiswa()->result_array();

        $this->form_validation->set_rules('nama_beasiswa','Nama Beasiswa','required');
        $this->form_validation->set_rules('kelompok_beasiswa','Kelompok Beasiswa','required');
        $this->form_validation->set_rules('asal_beasiswa','Asal Beasiswa','required');
        $this->form_validation->set_rules('jenis_beasiswa','Jenis Beasiswa','required');
        $this->form_validation->set_rules('periode','Periode','required');
        $this->form_validation->set_rules('tahun','Tahun','required');
        $this->form_validation->set_rules('min_ipk','IPK','required');
        $this->form_validation->set_rules('metode_pembayaran','Metode Pembayaran','required');
        $this->form_validation->set_rules('kuota_pendaftaran','Kuota Pendaftaran','required');
        $this->form_validation->set_rules('kuota_penetapan','Kuota Penetapan','required');

        if($this->form_validation->run() == false){
            $query = $this->beasiswa->getMasterBeasiswa($id);
            if($query->num_rows() > 0){
            $data['master_beasiswa'] = $query->row();
            $data['isi'] = 'master_beasiswa_edit_v';
            $this->load->view('template/wrapper_frontend_v', $data);
            }else{
                redirect('auth/oops');
            }
        }else {
            $post = $this->input->post(null, TRUE);
            $this->beasiswa->editMasterBeasiswa($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message",
                    "Master Beasiswa berhasil diubah!");
                redirect('mbeasiswa/master_beasiswa');
                }
            }
    }

    public function del($id = null)
    {

        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        if($id == null){
            redirect('mbeasiswa/master_beasiswa');
        }
        $this->beasiswa->deleteMasterBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message",
                "Master Beasiswa telah di hapus!");
        }
        redirect('mbeasiswa/master_beasiswa');
    }
}
