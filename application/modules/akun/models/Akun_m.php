<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - akun


class Akun_m extends CI_Model
{
    // @desc -edit data akun
    // @used by
    // - controller 'akun/edit_profile'
    public function updateProfile($post)
    {
        $username = $post['username'];
        $name = $post['name'];
        $email = $post['email'];
        $this->db->set('name', $name);
        $this->db->set('email', $email);
        $this->db->where('username', $username);
        $this->db->update('user');
    }

    // @desc -edit password
    // @used by
    // - controller 'akun/ubah_password'
    public function updatePassword($post)
    {
        $username = $post['username'];
        $password = password_hash($post['password1'], PASSWORD_DEFAULT );
        $this->db->set('password', $password);
        $this->db->where('username', $username);
        $this->db->update('user');
    }
}

?>