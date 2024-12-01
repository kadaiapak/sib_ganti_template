    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelompok_beasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_akses_user();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Beasiswa_m', 'beasiswa');
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Kelompok Beasiswa';
        $data['kelompok_beasiswa'] = $this->beasiswa->getKelompokBeasiswa()->result_array();

        $this->form_validation->set_rules('nama_kelompok', 'Nama Kelompok', 'required');
        if($this->form_validation->run() == false){
            $data['isi'] = 'kelompok_beasiswa_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        } else {
            if($this->cek_akses_user['tambah'] != '1')
            {
            redirect(base_url('auth/blocked'));
            } else {
                    $post = $this->input->post(null, TRUE);
                    $this->beasiswa->tambahKelompokBeasiswa($post);
                    $this->session->set_flashdata("message", 
                            "Kelompok Beasiswa ditambahkan!");
                    redirect('mbeasiswa/kelompok_beasiswa');
            }
        }
    } 

    public function del()
    {
        if($this->cek_akses_user['hapus'] != '1')
        {
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('kelompok_beasiswa_id');
        $this->beasiswa->deleteKelompokBeasiswa($id);
        if($this->db->affected_rows() > 0){
        }
            $this->session->set_flashdata("message", 
                            "Kelompok Beasiswa berhasil dihapus!");
            redirect('mbeasiswa/kelompok_beasiswa');
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != '1')
        {
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('id');
        $this->beasiswa->editKelompokBeasiswa($id);
        $this->session->set_flashdata("message", 
                            "Kelompok Beasiswa berhasil diubah!");
        redirect('mbeasiswa/kelompok_beasiswa');
    }
}