<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // cek_akses_user();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('Akses_m', 'akses');
        $this->load->model('mbeasiswa/Beasiswa_m', 'beasiswa');
        $this->load->model('mfakultas/Mfakultas_m', 'mfakultas');
    }

    public function index()
    {
        // 
        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url().'konfigurasi/akses/index';
        $config['total_rows'] = $this->akses->countRolePagination();
        $config['per_page'] = 6;
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
        $data['role'] = $this->akses->rolePagination($config['per_page'],$data['start_at'])->result_array();
        // 
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Akses';

        // model ini digunakan untuk menambahkan admin beasiswa, contoh admin beasiswa a, admin beasiswa b
        $data['nama_beasiswa'] = $this->beasiswa->getNamaBeasiswa()->result_array();
        $data['nama_fakultas'] = $this->mfakultas->getFakultas()->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('nama_panjang', 'Nama Panjang', 'required');
        $this->form_validation->set_rules('id_beasiswa', 'Akses Beasiswa', 'required');
        $this->form_validation->set_rules('id_fakultas', 'Fakultas', 'required');
        if($this->form_validation->run() == false){ 
            $data['isi'] = 'akses_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            if($this->cek_akses_user['tambah'] != 1){       
                redirect('auth/blocked');
            }
            $data = [
                'role' => $this->input->post('role'),
                'nama_panjang' => $this->input->post('nama_panjang'),
                'id_beasiswa' => $this->input->post('id_beasiswa') == 'NULL' ? null : $this->input->post('id_beasiswa'),
                'id_fakultas' => $this->input->post('id_fakultas') == 'NULL' ? null : $this->input->post('id_fakultas')
            ];
            $this->akses->tambahRole($data);   
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata("message", 
                    "Role baru ditambahkan!");
                redirect('konfigurasi/akses');      
            }       
        }
    }

    public function edit()
    {
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $data['title'] = 'Akses';

        $data['nama_beasiswa'] = $this->beasiswa->getNamaBeasiswa()->result_array();
        $data['role'] = $this->akses->role()->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('nama_panjang', 'Nama Panjang', 'required');
        $this->form_validation->set_rules('id_beasiswa', 'Beasiswa', 'required');
        
        if($this->form_validation->run() == false){ 
            $data['isi'] = 'akses_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $id = $this->input->post('id');
            $this->akses->editRole($id);
            $this->session->set_flashdata("message", 
                "Role telah diedit!");
            redirect('konfigurasi/akses');       
            }
    }

    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != 1){       
            redirect('auth/blocked');
        }
        $id = $this->input->post('role_id');
        $this->akses->hapusRole($id);
        if($this->db->affected_rows() > 0){
            echo "<script>alert('Data Berhasil dihapus');</script>";
            $this->session->set_flashdata("message", 
                "<div class='alert alert-success' role='alert' >Role berhasil dihapus!</div>");
        }
            echo "<script>window.location='".base_url('konfigurasi/akses')."'</script>";
    }   

    
    public function roleaccess($role_id)
    {
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $data['title'] = 'Role Access';
        $data['role'] = $this->akses->role($role_id)->row_array();
     
        $data['menu'] = $this->akses->getMenu()->result_array();

        $data['isi'] = 'role-access_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    // @desc  -mengubah data akses di database
    // @used by
    // - jquery 'views/template/footer'
    public function changeaccess()
    {
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        
        $data = [
            'kode_menu' => $menuId,
            'level_user' => $roleId
        ];

        $datainsert = [
            'kode_menu' => $menuId,
            'level_user' => $roleId,
            'akses' => '1'
        ];

        $result = $this->db->get_where('akses', $data);
        if($result->num_rows() < 1){
            $this->db->insert('akses', $datainsert);
        }else {
            $this->db->delete('akses', $data);
        }

         $this->session->set_flashdata('message', 
            'Hak akses telah diganti!');
    }

    // @desc  -mengubah data akses untuk menambah di database
    // @used by
    // - jquery 'views/template/footer'
    public function changetambah()
    {
    
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        
        $data = [
            'kode_menu' => $menuId,
            'level_user' => $roleId
        ];

        // $result = $this->db->get_where('akses', $data)->row_array();
        // var_dump($result['hapus']);
        $result = $this->db->get_where('akses', $data);
        if($result->num_rows() < 1){
            redirect('auth/blocked');
        }else {
            $cekTambah = $result->row_array();
            if($cekTambah['tambah'] == '1')
            {
                // bisa menambah, selanjutnya hilangkan akses menambah';
                $this->db->set('tambah', '0');
                $this->db->where($data);
                $this->db->update('akses');
            }else {
                // tidak bisa menambah, selanjutnya izinkan untuk menambah';
                $this->db->set('tambah', '1');
                $this->db->where($data);
                $this->db->update('akses');
            }
        }

         $this->session->set_flashdata('message', 
            '<div class="alert alert-success" role="alert">Access has been change!</div>');

    }

    // @desc  -mengubah data akses untuk edit di database
    // @used by
    // - jquery 'views/template/footer'
    public function changeedit()
    {
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        
        $data = [
            'kode_menu' => $menuId,
            'level_user' => $roleId
        ];

        $result = $this->db->get_where('akses', $data);
        if($result->num_rows() < 1){
            redirect('auth/blocked');
        }else {
            $cekTambah = $result->row_array();
            if($cekTambah['edit'] == '1')
            {
                // bisa menambah, selanjutnya hilangkan akses menambah';
                $this->db->set('edit', '0');
                $this->db->where($data);
                $this->db->update('akses');
            }else {
                // tidak bisa menambah, selanjutnya izinkan untuk menambah';
                $this->db->set('edit', '1');
                $this->db->where($data);
                $this->db->update('akses');
            }
        }

         $this->session->set_flashdata('message', 
            '<div class="alert alert-success" role="alert">Access has been change!</div>'
        );
    }

    // @desc  -mengubah data akses untuk hapus di database
    // @used by
    // - jquery 'views/template/footer'
    public function changehapus()
    {
        if($this->cek_akses_user['edit'] != 1){       
            redirect('auth/blocked');
        }
        $menuId = $this->input->post('menuId');
        $roleId = $this->input->post('roleId');
        
        $data = [
            'kode_menu' => $menuId,
            'level_user' => $roleId
        ];

        $result = $this->db->get_where('akses', $data);
        if($result->num_rows() < 1){
            redirect('auth/blocked');
        }else {
            $cekTambah = $result->row_array();
            if($cekTambah['hapus'] == '1')
            {
                // bisa menambah, selanjutnya hilangkan akses menambah';
                $this->db->set('hapus', '0');
                $this->db->where($data);
                $this->db->update('akses');
            }else {
                // tidak bisa menambah, selanjutnya izinkan untuk menambah';
                $this->db->set('hapus', '1');
                $this->db->where($data);
                $this->db->update('akses');
            }
        }

         $this->session->set_flashdata('message', 
            '<div class="alert alert-success" role="alert">Access has been change!</div>'
        );
    }

} 