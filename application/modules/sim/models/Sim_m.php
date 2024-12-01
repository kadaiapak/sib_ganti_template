<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_m extends CI_Model
{

    // @desc -digunakan untuk proses login
    // @used by
    // - controller auth/index
    public function auth($post)
    {
            $username = $post['username'];
            $password = $post['password'];

            $user = $this->db->get_where('user', ['username' => $username] )->row_array();
            // jika ada user
            if($user){
                // jika user active
                if($user['is_active'] == 1){
                      //cek password
                    if(password_verify($password, $user['password'])){
                        $data = [
                            'userid' => $user['id'],
                            'username' => $user['username'],
                            'role_id' => $user['role_id'],
                            'nama' => $user['name']
                        ];

                        $this->session->set_userdata($data);
                        if($user['role_id']){
                            redirect('dashboard');
                        };

                    }else {
                        $this->session->set_flashdata("message",
                        "<div class='alert alert-danger' role='alert' >Username atau Password salah!</div>");
                         redirect('sim');
                    }

                }else {
                    $this->session->set_flashdata("message",
                    "<div class='alert alert-danger' role='alert' >User ini belum diaktifkan</div>");
                    redirect('sim');
                }

            }else {
                $this->session->set_flashdata("message",
                "<div class='alert alert-danger' role='alert' >Username atau Password salah!</div>");
                redirect('sim');
            }
    }

    // @desc -menampilkan data yang user yang sedang login pada view topbar
    // @used by
    // - libraries 'fungsi/user_login'
    public function get($id = null)
    {
        $this->db->from('user');
            if($id != null){
                $this->db->where('id',$id);
            }
            $query = $this->db->get();
            return $query;
    }

    // @desc - digunakan untuk proses registrasi, namun fitur itu masih ditutup
    // @used by
    // - controller auth/registration
    public function registration()
    {
        $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT ),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message',
            '<div class="alert alert-success" role="alert">Akun kamu sudah terdaftar, silahkan tunggu konfirmasi dari admin!</div>');
            redirect('auth');
    }

}
