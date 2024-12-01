<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nonaktif extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // cek_akses_user();
        $this->cek_akses_user = cek_akses_user();
        is_logged_in();
        $this->load->model('mbeasiswa/Beasiswa_m', 'beasiswa');
    }
    
    public function index()
    { 
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Master Beasiswa';
        $data['master_beasiswa'] = $this->beasiswa->getMasterBeasiswa()->result_array();
        // untuk menampilkan atau menghilangkan tombol tambah
        $data['cek'] = $this->cek_akses_user['tambah'];
        
        $data['isi'] = 'list_master_beasiswa_nonaktif_v';
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

        $this->form_validation->set_rules('nama_beasiswa','Nama Beasiswa','required');
        $this->form_validation->set_rules('kelompok_beasiswa','Kelompok Beasiswa','required');
        $this->form_validation->set_rules('asal_beasiswa','Asal Beasiswa','required');
        $this->form_validation->set_rules('jenis_beasiswa','Jenis Beasiswa','required');
        $this->form_validation->set_rules('periode','Periode','required');
        $this->form_validation->set_rules('ipk','Ipk','required');
        $this->form_validation->set_rules('tahun','Tahun','required');
        $this->form_validation->set_rules('biaya','Besaran Bantuan','required');
        $this->form_validation->set_rules('metode_pembayaran','Metode Pembayaran','required');

        if($this->form_validation->run() == false){
            $data['isi'] = 'master_beasiswa_tambah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $data = [
                'nama_beasiswa' => $this->input->post('nama_beasiswa'),
                'kelompok_beasiswa' => $this->input->post('kelompok_beasiswa'),
                'asal_beasiswa' => $this->input->post('asal_beasiswa'),
                'jenis_beasiswa' => $this->input->post('jenis_beasiswa'),
                'periode' => $this->input->post('periode'),
                'min_ipk' => $this->input->post('ipk'),
                'tahun' => $this->input->post('tahun'),
                'biaya' => $this->input->post('biaya'),
                'metode_pembayaran' => $this->input->post('metode_pembayaran'),
                'tanggal_penetapan' => $this->input->post('tanggal_penetapan'),
                'buka_pendaftaran' => $this->input->post('is_buka_pendaftaran'),
                'aktif' => $this->input->post('is_active'),
                'tampil' => $this->input->post('is_show'),
                'user_created' => $this->fungsi->user_login()->username
            ];
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
        $data['master_beasiswa'] = $this->beasiswa->getMasterBeasiswa($id)->row();
        
        echo '<pre>' ; 
print_r($data); 
echo '</pre>' ; 
die;
        if($this->form_validation->run() == false){
            $query = $this->beasiswa->getMasterBeasiswa($id);
            if($query->num_rows() > 0){
            $data['master_beasiswa'] = $query->row();
            $data['isi'] = 'master_beasiswa_nonaktif_edit_v';
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

    public function del()
    {
        if($this->cek_akses_user['hapus'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $id = $this->input->post('master_beasiswa_id');
        $this->beasiswa->deleteMasterBeasiswa($id);
        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata("message", 
                "Master Beasiswa telah di hapus!");
        }
        redirect('mbeasiswa/master_beasiswa');
    }
} 