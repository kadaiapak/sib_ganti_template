<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model
{
    // @desc -digunakan untuk memanggil semua user user dan juga beserta (join) dengan role nya 
    // @used by
    // - controllers 'User/index'
    public function getAllUsers($limit, $start)
    {
        // QUERY LEFT JOIN
        $this->db->select('user.id as id, user.name as name, user.username as username, user.email as email, user.image as image, 
                           user.role_id as role_id, user.is_active as is_active, user.date_created as date_created,
                           user_role.role as role, user_role.nama_panjang as nama_panjang, user_role.id_beasiswa as id_beasiswa
        ');
        $this->db->from('user');
        $this->db->join('user_role', 'user.role_id = user_role.id', 'left');
        $this->db->limit($limit, $start);
        $this->db->order_by("user.id", "desc");
        $hasil = $this->db->get();
        return $hasil;
    }

    // @desc -digunakan untuk menghitung semua user untuk pagination
    // @used by
    // - controllers 'User/index'
    public function countAllUsersPagination()
    {
        $query =  $this->db->count_all_results('user');
        return $query;
    }


    // @desc -digunakan untuk memanggil semua role di database
    // @used by
    // - controllers 'User/tambah'
    // - controllers 'User/edit'
    public function getUserRole()
    {
        $user = $this->db->get('user_role'); 
        return $user;   
    }

    // @desc -digunakan untuk memanggil user baik itu semua user maupun single user berdasarkan id
    // - controllers 'User/edit'
    // - fungsi 'count_user()'
    public function getUser($id = null)
    {
        $this->db->from('user');
        if($id != null){
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        
        return $query;
    }

    // @desc -digunakan untuk menambah user
    // @used by
    // - controllers 'User/tambah'
    public function tambahUser($data)
    {
        $this->db->insert('user', $data);
    }

    // @desc -digunakan untuk edit user
    // @used by
    // - controllers 'User/edit'
    public function editUser($post)
    {
            $params['name'] = $post['name'];
            $params['username'] = $post['username'];
            $params['email'] = $post['email'];
            $params['image'] = 'default.jpg';
            if(!empty($post['password1'])){
                $params['password'] = password_hash($this->input->post('password1'), PASSWORD_DEFAULT );
            }
            $params['role_id'] = $post['role_id'];
            $params['is_active'] = $post['is_active'];
            $this->db->where('id', $post['user_id']);
            $this->db->update('user', $params);
    }
    
    // @desc -digunakan untuk menghapus user
    // @used by
    // - controllers 'User/hapus'
    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->session->set_flashdata("message", 
                    "<div class='alert alert-success' role='alert' >User telah dihapus!</div>");
    }

    

}
