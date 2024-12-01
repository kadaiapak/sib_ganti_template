<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

class Status_pendaftaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('status_pendaftaran_m', 'status_pendaftaran');
    }
    
    public function index()
    {
        $nim = $this->session->userdata('username');
        // $nim = $this->fungsi->user_login()->username;
        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url('status-pendaftaran/index');
        $config['total_rows'] = $this->status_pendaftaran->countMasterBeasiswaYangDiDaftar($nim);
        $config['per_page'] = 4;
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
        $data['start_at'] = $this->uri->segment(3);
        // END OF PAGINATION
        $data['title'] = "Status Pendaftaran Beasiswa";
        $data['master_beasiswa'] = $this->status_pendaftaran->getMahasiswaBeasiswaJoinMasterBeasiswaWhere($config['per_page'],$data['start_at'], $nim)->result_array();
        $data['isi'] = 'status_pendaftaran_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }
    
    public function detail($id=null)
    {        
        if(!$id){
            redirect('auth/oops');
        }
        $data['title'] = "Detail Status Pendaftaran";
        $data['mahasiswa'] = $this->status_pendaftaran->getDetailBeasiswaMahasiswa($id)->row();
//         echo '<pre>';
//         print_r($data['mahasiswa']);
//         echo '<pre>';
// die;
        if($data['mahasiswa'] == null){
            redirect('auth/oops');
        }
        if($this->session->userdata('username') != $data['mahasiswa']->nim_mahasiswa)
        {
            redirect('auth/blocked');
        }
        $data['comment'] = $this->status_pendaftaran->getComment($id)->result_array();
        $data['berkas_pendaftaran'] = $this->status_pendaftaran->getBerkasPendaftaran($data['mahasiswa']->id)->result_array();
   
        $data['isi'] = 'status_pendaftaran_detail_v';
        $this->load->view('template/wrapper_frontend_v', $data);  
    }
} 