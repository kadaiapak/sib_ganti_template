<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - mwebsite/Asal_beasiswa


class Website_m extends CI_Model
{
    // @desc -memanggil semua manajemen website
    // @used by
    // - controller 'mwebsite/index'
    public function getWebsiteManajemen()
    {
        $query = $this->db->get('website_manajemen');
        return $query;
    }

    // @desc -menambah settingan baru untuk website
    // @used by
    // - controller 'mwebsite/tambah'
    public function tambahWebsiteManajemen($post)
    {
        $params['judul'] = $post['judul'];
        $params['nama_yang_digunakan'] = $post['nama_yang_digunakan'];
        $this->db->insert('website_manajemen', $params);
    }

    // @desc -hapus setingan website
    // @used by
    // - controller 'mwebsite/hapus'
    public function deleteWebsiteManajemen($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('website_manajemen');
    }

    // @desc -edit asal beasiswa berdasarkan id
    // @used by
    // - controller 'mbeasiswa/Asal_beasiswa/edit($id)'
    public function editWebsiteManajemen($id)
    {
        $dataEdit = [
                'judul' => $this->input->post('judul'),
                'nama_yang_digunakan' => $this->input->post('nama_yang_digunakan')
            ];
        $this->db->where('id', $id);
        $this->db->update('website_manajemen', $dataEdit);
    }
}

?>