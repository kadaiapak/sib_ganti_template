<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->cek_akses_user = cek_akses_user();
        
        $this->load->model('Akun_m', 'akun');

    }

    public function index()
    {
        $data['title'] = 'Profil';
        $data['isi'] = 'akun_v';
        $data['user'] = $this->fungsi->user_login();
        $this->load->view('template/wrapper_frontend_v', $data);
    }

    public function edit_profile()
    {
        $data['title'] = 'Edit Profile';
        $data['isi'] = 'akun_edit_v';

        $data['user'] = $this->fungsi->user_login();

        $this->form_validation->set_rules('name', 'Full Name', 'required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $post = $this->input->post(null, TRUE);
            $this->akun->updateProfile($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('message',
                    'Akun berhasil diubah !');
                }
                redirect('akun');
        }

    }

    public function ubah_password()
    {
        $data['title'] = 'Ubah Password';
        $data['isi'] = 'akun_ubah_password_v';

        $data['user'] = $this->fungsi->user_login();
        $this->form_validation->set_rules('passwordlama', 'Password', 'required|callback_password_check', [
            'required' => 'Tuliskan password awal'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[7]|matches[password2]', [
            'matches' => 'Password tidak sesuai!',
            'min_length' => 'Password terlalu pendek',
            'required' => 'Isikan Password yang baru'
            ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[7]|matches[password1]', [
            'required' => 'Isikan Password Konfirmasi',
            'matches' => 'Password tidak sesuai!',
        ]);
        if($this->form_validation->run() == false)
        {
            $this->load->view('template/wrapper_frontend_v', $data);
        }else {
            $post = $this->input->post(null, TRUE);
            $this->akun->updatePassword($post);
            if($this->db->affected_rows() > 0){
                $this->session->set_flashdata('message',
                    'Password berhasil diubah !');
                }
                redirect('akun');
        }
    }

    // @desc -callback function digunakan untuk validasi password lama apakah sesuai
    // @used by
    // - controllers 'Akun/ubah_password'
    function password_check()
    {
        $post = $this->input->post(null, TRUE);
        $user = $this->db->get_where('user', ['username' => $post['username']] )->row_array();

        if($user){
            if($user['is_active'] == 1){
                if(password_verify($post['passwordlama'], $user['password'])){
                    return TRUE;
                }else {
                    $this->form_validation->set_message('password_check', 'Password awal tidak sesuai');
                    return FALSE;
                }
            }else {
                $this->form_validation->set_message('password_check', 'Password awal tidak sesuai');
                return FALSE;
            }
        }else {
            $this->form_validation->set_message('password_check', 'Password awal tidak sesuai');
            return FALSE;
        }
    }
}
