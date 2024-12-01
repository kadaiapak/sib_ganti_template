    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_akses_user();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        // $this->load->model('Admin_m', 'admin');
        $this->load->model('Beasiswa_m', 'beasiswa');
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Jenis Beasiswa';
        $data['jenis_beasiswa'] = $this->beasiswa->getJenisBeasiswa()->result_array();
        $this->form_validation->set_rules('nama_jenis', 'Jenis', 'required');
        if($this->form_validation->run() == false)
        {
            $data['isi'] = 'jenis_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1')
            {
            redirect(base_url('auth/blocked'));
            } else {
                    $post = $this->input->post(null, TRUE);
                    $this->beasiswa->tambahJenisBeasiswa($post);
                    if($this->db->affected_rows() > 0){
                    $this->session->set_flashdata("message", 
                            "Jenis Beasiswa berhasil ditambahkan!");
                    redirect('mbeasiswa/jenis_beasiswa');
                    }
            }
        }
    } 

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1')
        {
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('jenis_beasiswa_id');
        $this->beasiswa->deleteJenisBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Jenis Beasiswa berhasil dihapus!");
        }
        redirect('mbeasiswa/jenis_beasiswa');
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1')
        {
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $this->beasiswa->editJenisBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
            "Jenis Beasiswa berhasil diedit!");
            redirect('mbeasiswa/jenis_beasiswa');
        }
    }
}