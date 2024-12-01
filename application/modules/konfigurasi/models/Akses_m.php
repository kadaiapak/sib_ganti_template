<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses_m extends CI_Model
{
    // @desc -memanggil semua role yang ada di database beserta(join) dengan beasiswa yang ia pegang jika dia admin beasiswa
    // @used by
    // - controller 'konfigurasi/akses/edit'
    // - controller 'konfigurasi/akses/roleaccess'
    public function role($role_id = null)
    {
        // $role = $this->db->select('ur.*, nb.nama_beasiswa')
        //         ->from('user_role ur')
        //         ->join('nama_beasiswa nb', 'ur.id_beasiswa = nb.id', 'left')
        //         ->get();
        // return $role;
        $this->db->select('ur.*, nb.nama_beasiswa');
        $this->db->from('user_role ur');
        $this->db->join('nama_beasiswa nb', 'ur.id_beasiswa = nb.id', 'left');
        if($role_id != null){
            $this->db->where('ur.id', $role_id);
        }
        $query = $this->db->get();
        return $query;
    }

    // @desc - memanggil semua role untuk pagination
    // @used by
    // - controller 'konfigurasi/akses/index'
    public function rolePagination($limit, $start)
    {
        $this->db->select('ur.*, nb.nama_beasiswa, fk.nama_panjang_fakultas');
        $this->db->from('user_role ur');
        $this->db->join('nama_beasiswa nb', 'ur.id_beasiswa = nb.id', 'left');
        $this->db->join('fakultas fk', 'ur.id_fakultas = fk.id', 'left');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query;
    }

    // @desc -digunakan untuk menghitung semua role untuk pagination
    // @used by
    // - controllers 'konfigurasi/akses/index'
    public function countRolePagination()
    {
        $query =  $this->db->count_all_results('user_role');
        return $query;
    }



    // @desc -edit semua role yang ada di database
    // @used by
    // - controller 'konfigurasi/akses/edit'
    public function editRole($id)
    {
        if($this->input->post('id_beasiswa') == 'NULL'){
            $id_beasiswa = NULL;
        }else {
            $id_beasiswa = $this->input->post('id_beasiswa');
        }
        $role = [
            'role' => $this->input->post('role'),
            'nama_panjang' => $this->input->post('nama_panjang'),
            'id_beasiswa' => $id_beasiswa

        ];
        $this->db->where('id', $id);
        $this->db->update('user_role', $role);
    }

    // @desc -menambah role baru
    // @used by
    // - controller 'konfigurasi/akses/index-tambah'
    public function tambahRole($role)
    {
        $this->db->insert('user_role', $role);
    }

    // @desc -hapus role tertentu yang ada di database
    // @used by
    // - controller 'konfigurasi/akses/hapus'
    public function hapusRole($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }

    // @desc -mengambil semua data menu di database
    // @desc -mengambil data menu di database sesuai dengan id yang dikirim
    // @used by
    // - controller 'konfigurasi/akses/roleaccess'
    // - controller 'konfigurasi/Menu_sistem/index'
    // - controller 'konfigurasi/Menu_sistem/edit'
    public function getMenu($id = null)
    {
        $this->db->from('menu');
        if($id != null){
            $this->db->where('kode_menu', $id);
            $query = $this->db->get();
            return $query;
        }
        $this->db->order_by('no_urut_rapi','ASC');
        $queryNonId = $this->db->get();
        return $queryNonId;

    }


    // @desc -mengambil semua data menu di database dengan limit untuk pagination
    // @used by
    // - controller 'konfigurasi/Menu_sistem/index'
    public function getMenuPagination($limit, $start)
    {
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->limit($limit, $start);
        $this->db->order_by('no_urut_rapi','ASC');
        $queryNonId = $this->db->get();
        return $queryNonId;
    }

    // @desc -mengambil semua data pemisah menu di database dengan limit untuk pagination
    // @used by
    // - controller 'konfigurasi/pemisah_menu/index'
    public function getPemisahMenuPagination($limit, $start)
    {
        $this->db->select('*');
        $this->db->from('pemisah_menu');
        $this->db->limit($limit, $start);
        $this->db->order_by('id','ASC');
        $queryNonId = $this->db->get();
        return $queryNonId;
    }

    // @desc -digunakan untuk menghitung semua menu untuk pagination
    // @used by
    // - controllers 'konfigurasi/menu_sistem/index'
    public function countMenuPagination()
    {
        $query =  $this->db->count_all_results('menu');
        return $query;
    }

    // @desc -digunakan untuk menghitung semua pemisah menu untuk pagination
    // @used by
    // - controllers 'konfigurasi/pemisah_menu/index'
    public function countPemisahMenuPagination()
    {
        $query =  $this->db->count_all_results('pemisah_menu');
        return $query;
    }

    // @desc -menambah satu menu di database
    // @used by
    // - controller 'konfigurasi/Menu_sistem/tambah'
    public function tambahMenu($data)
    {
        $params['nama_menu'] = $this->input->post('nama_menu');
        $params['no_urut'] = $this->input->post('no_menu');
        $params['url'] = $this->input->post('url');
        $params['icon'] = $this->input->post('icon');
        $params['level'] = $this->input->post('level_menu');
        if($params['level'] == 'single_menu' || $params['level'] == 'main_menu'){
            $params['main_menu'] = null;
            $params['pemisah'] = $this->input->post('pemisah_menu');
        }else {
            $params['main_menu'] = $this->input->post('main_menu');
        }
        if($params['level'] == 'sub_menu'){
            $params['icon'] = null;
            $params['pemisah'] = null;
        }else {
            $params['icon'] = $this->input->post('icon');
        }
        $params['no_urut_rapi'] = $this->input->post('urut');
        $params['aktif'] = $this->input->post('is_active');
        $params['show'] = $this->input->post('is_show');
        $params['created_at'] = date('Y-m-d');
        $params['user'] =  $this->fungsi->user_login()->name;

        $this->db->insert('menu', $params);
    }

    // @desc -menambah satu pemisah menu di database
    // @used by
    // - controller 'konfigurasi/pemisah_menu/index'
    public function tambahPemisahMenu($post)
    {
        $params['nama_pemisah'] = $post['nama_pemisah_menu'];
        $params['no_urut'] = $post['no_urut'];
        $params['is_deleted'] = '0';
        $this->db->insert('pemisah_menu', $params);
    }

    // @desc -menghapus satu menu di database
    // @used by
    // - controller 'konfigurasi/Menu_sistem/hapus($id)'
    public function hapusMenu($id)
    {
        $error = 1;
        $this->db->where('kode_menu', $id);
        $this->db->from('akses');
        $hitung = $this->db->count_all_results();
        if($hitung <= 0 ){
          $this->db->where('kode_menu', $id);
          $this->db->delete('menu');
          return true;
        }else {
          return false;
        }
    }

    // @desc -menghapus satu pemisah menu di database
    // @used by
    // - controller 'konfigurasi/pemisah-menu/hapus($id)'
    public function hapusPemisahMenu($id)
    {
        $error = 1;
        $this->db->where('pemisah', $id);
        $this->db->from('menu');
        if ($this->db->count_all_results() <= 0) {
            $this->db->where('id', $id);
            $this->db->delete('pemisah_menu');
            return true;
        }else {
            return false;
        }
    }

    // @desc -edit menu tertentu di database
    // @used by
    // - controller 'konfigurasi/Menu_sistem/edit($post)'
    public function editMenu($post)
    {
            $params['nama_menu'] = $post['nama_menu'];
            $params['no_urut'] = $post['no_menu'];
            $params['url'] = $post['url'];
            $params['icon'] = $post['icon'];
            $params['level'] = $post['level_menu'];
            $params['main_menu'] = $post['main_menu'];
            $params['no_urut_rapi'] = $post['urut'];
            $params['aktif'] = $post['is_active'];
            $params['show'] = $post['is_show'];
            if($params['level'] == 'sub_menu'){
                $params['icon'] = null;
            }else {
                $params['icon'] = $post['icon'];
            }
            $this->db->where('kode_menu', $post['kode_menu']);
            $this->db->update('menu', $params);
    }

    // @desc -edit pemisah menu tertentu di database
    // @used by
    // - controller 'konfigurasi/pemisah_menu/edit'
    public function editPemisahMenu($id)
    {
            $params['nama_pemisah'] = $this->input->post('nama_pemisah_menu');
            $params['no_urut'] = $this->input->post('no_urut');
            $this->db->where('id', $id);
            $this->db->update('pemisah_menu', $params);
    }
}
