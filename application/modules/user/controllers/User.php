<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        $this->load->model('User_m', 'user');     
    }

    public function index()
    {
        $data['cek_akses_user'] = $this->cek_akses_user;
        
        $data['title'] = "User";

        // PAGINATION
        // load library
        $this->load->library('pagination');
        // config
        $config['base_url'] =   base_url().'user/index';
        $config['total_rows'] = $this->user->countAllUsersPagination();
        $config['per_page'] = 7;
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
        $data['allUser'] = $this->user->getAllUsers($config['per_page'],$data['start_at'])->result_array();
        $data['isi'] = 'user_v';
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function tambah()
    {
        if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
        }
        $data['title'] = 'Tambah User';
        $data['role'] = $this->user->getUserRole()->result_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|min_length[5]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[7]|callback_newusername_check');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah digunakan'
        ]);
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[7]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[7]|matches[password1]');

        if( $this->form_validation->run() ==false){
            $data['isi'] = 'user_tambah_v';
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            if($this->cek_akses_user['tambah'] != '1'){
            redirect(base_url('auth/blocked'));
            }
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT ),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active'),
                'date_created' => time()
            ];
            $this->user->tambahUser($data);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('message', 
                    'Penambahan User berhasil !');
                redirect('user');
            }
        }
    } 
    
    public function hapus()
    {
        if($this->cek_akses_user['hapus'] != '1')
        {
            redirect(base_url('auth/blocked'));
        }

        $id = $this->input->post('user_id');
        $this->user->deleteUser($id); 
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('message', 
                    'User berhasil dihapus !');
                }
        redirect('user');
            
    }

    public function edit($id)
    {
        if($this->cek_akses_user['edit'] != '1'){
            redirect(base_url('auth/blocked'));
        }

        $data['title'] = 'Edit User';
        $data['role'] = $this->user->getUserRole()->result_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|min_length[5]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[7]|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        if($this->input->post('password1')){
            $this->form_validation->set_rules('password1', 'Password', 'trim|min_length[7]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
            ]);
            $this->form_validation->set_rules('password2', 'Password', 'trim|min_length[7]|matches[password1]');
        }
        if($this->input->post('password2')){
            $this->form_validation->set_rules('password2', 'Password', 'trim|min_length[7]|matches[password1]');
        }

        if( $this->form_validation->run() == false){
            $query = $this->user->getUser($id);
            if($query->num_rows() > 0){
                $data['row'] = $query->row();
                $data['isi'] = 'user_edit_v';
                $this->load->view('template/wrapper_frontend_v', $data);
            }else {
                redirect('auth/oops');
            }
        }else {
            $post = $this->input->post(null, TRUE);
            $this->user->editUser($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('message', 
                    'User berhasil diubah !');
                }
                redirect('user');
        }
    } 

    // @desc -callback function digunakan untuk validasi username pada saat edit user
    // @used by
    // - controllers 'User/edit'
    function username_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM user WHERE username = '$post[username]' AND id != $post[user_id]");
        if($query->num_rows() > 0){
            $this->form_validation->set_message('username_check', '{field} ini sudah dipakai');
            return FALSE;
        }else {
            return TRUE;
        }
    }

    // @desc -callback function digunakan untuk validasi username pada saat membuat user baru
    // @used by
    // - controllers 'User/tambah'
    function newusername_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM user WHERE username = '$post[username]'");
        if($query->num_rows() > 0){
            $this->form_validation->set_message('newusername_check', '{field} ini sudah dipakai');
            return FALSE;
        }else {
            return TRUE;
        }
    }
} 