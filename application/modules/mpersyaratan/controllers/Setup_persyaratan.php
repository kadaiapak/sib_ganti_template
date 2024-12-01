<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_persyaratan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('mbeasiswa/Beasiswa_m', 'beasiswa');
        $this->load->model('data_beasiswa/Penerima_beasiswa_m', 'penerima');
        $this->load->model('Persyaratan_m', 'persyaratan');
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        $data['title'] = 'Setup Persyaratan';

        //
        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url('mpersyaratan/setup-persyaratan/index');
        $config['total_rows'] = $this->persyaratan->countMasterBeasiswaPersyaratanPagination();
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
        $data['master_beasiswa'] = $this->persyaratan->getMasterBeasiswaPersyaratan($config['per_page'],$data['start_at'])->result_array();
        //
        $data['isi'] = 'setup_persyaratan_beasiswa_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function edit( $id = null)
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect('auth/blocked');
        }

        if($id == null){
            redirect('auth/oops');
        }
         // cek apakah tanggal beasiswa masih buka
        $role_id = $this->fungsi->user_login()->role_id;

        $cekAksesBeasiswa = $this->cekAksesBeasiswa($id, $role_id);
        if(!$cekAksesBeasiswa)
        {
            redirect('auth/blocked');
        }

        $data['title'] = 'Atur Persyaratan';
        $data['master_beasiswa'] = $this->beasiswa->getMasterBeasiswa($id)->row();
        $data['master_persyaratan'] = $this->beasiswa->getPersyaratanBeasiswa()->result_array();

        $data['isi'] = 'setup_persyaratan_beasiswa_proses_v';
        $this->load->view('template/wrapper_frontend_v', $data);

    }

    // @desc  - mengubah persyaratan beasiswa
    // @used by
    // - jquery 'views/template/footer'
    public function tambahpersyaratan()
    {
        $beasiswaId = $this->input->post('beasiswaId');
        $persyaratanId = $this->input->post('persyaratanId');

        $data = [
            'master_beasiswa' => $beasiswaId,
            'persyaratan' => $persyaratanId
        ];

        $result = $this->db->get_where('master_beasiswa_persyaratan', $data);
        if($result->num_rows() < 1){
            $this->db->insert('master_beasiswa_persyaratan', $data);
        }else {
            $this->db->delete('master_beasiswa_persyaratan', $data);
        }

         $this->session->set_flashdata('message',
            'Persyaratan ditambahkan!');
    }

    function cekAksesBeasiswa($id, $role_id)
    {
       $hasil = $this->persyaratan->cekAksesBeasiswaModel($id, $role_id);
       return $hasil;
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['role'] = $this->akses->role($role_id)->row_array();

        $data['menu'] = $this->beasiswa->getPersyaratanBeasiswa()->result_array();

        $data['isi'] = 'setup_persyaratan_beasiswa_proses';
        $this->load->view('template/wrapper_frontend_v', $data);
    }


    public function tambahpersyaratanWajib()
    {
        $beasiswaId = $this->input->post('beasiswaId');
        $persyaratanId = $this->input->post('persyaratanId');

        $data = [
            'master_beasiswa' => $beasiswaId,
            'persyaratan' => $persyaratanId,
            'wajib' => '1'
        ];

        $result = $this->db->get_where('master_beasiswa_persyaratan', $data);
        if($result->num_rows() >= 1){
            $this->db->where('master_beasiswa',$beasiswaId);
            $this->db->where('persyaratan',$persyaratanId);
            $this->db->where('wajib', '1');
            $this->db->update('master_beasiswa_persyaratan', array('wajib' => '0'));
        }else {
            $this->db->where('master_beasiswa',$beasiswaId);
            $this->db->where('persyaratan',$persyaratanId);
            $this->db->where('wajib', '0');
            $this->db->update('master_beasiswa_persyaratan', array('wajib' => '1'));
        }

         $this->session->set_flashdata('message',
            'Persyaratan diubah!');
    }

    // @desc  -mengubah data akses untuk menambah di database
    // @used by
    // - jquery 'views/template/footer'
    public function changetambah()
    {

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
