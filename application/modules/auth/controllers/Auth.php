<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_m', 'auth');
        $this->load->model('Api_model');
        $this->load->library('form_validation');
    }

    // @desc -proses login user
    // @used by
    // - views 'auth/login
    public function index()
    {
        if($this->session->userdata('nim') || $this->session->userdata('userid') || $this->session->userdata('role_id')){
            redirect('dashboard');
        }

        $this->form_validation->set_rules('nim', 'Nim', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if( $this->form_validation->run() ==false) {
            $data['title'] = "SIB Partnership Login";
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/auth_footer');
        }  else {
            $post = $this->input->post(null, TRUE);
            // $this->auth->auth($post);
            $username = $this->input->post('nim');
            $password = $this->input->post('password');
            $this->login($username,$password);
        }
    }

    public function login($username,$password)
    {
      $data = $this->Api_model->user_portal($username,$password);

      $res=json_decode($data);

      if ($res->message =='berhasil' && $res->data->username == $username) {
        $rdt = $res->data;
        $data = [
            'userid' => $rdt->username,
            'username' => $rdt->username,
            'nama' => $rdt->nama,
            'role_id' => '27'
        ];



        $this->session->set_userdata($data);
            redirect('dashboard');

      }else {

          $this->session->set_flashdata("message",
          "<div class='alert alert-danger' role='alert' >Username atau Password salah!</div>");
           redirect('auth');
      }
    }

    public function registration()
    {
        if($this->session->userdata('username') || $this->session->userdata('userid') || $this->session->userdata('role_id')){
            redirect('dashboard');
        }

        $this->form_validation->set_rules('name', 'Full Name', 'required|min_length[5]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[7]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[7]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[7]|matches[password1]');

        if( $this->form_validation->run() ==false){
            $data['title'] = "Simbeswa Registration";
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('template/auth_footer');
        }else {
        $this->auth->registration();
        }
    }

    public function logout()
    {
        // $this->session->unset_userdata('email');
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('nama');

         $this->session->set_flashdata('message',
        "<div class='alert alert-success' role='alert' >You have been logout</div>");
        redirect('auth');

    }

    public function blocked()
    {
        $data['title'] = 'Forbidden!';
        $this->load->view('template/auth_header', $data);
        $this->load->view('auth/blocked', $data);
        $this->load->view('template/auth_footer');

    }

    public function oops()
    {
        $data['title'] = 'Not Found!';
        $this->load->view('template/auth_header', $data);
        $this->load->view('auth/oops', $data);
        $this->load->view('template/auth_footer');

    }
}
