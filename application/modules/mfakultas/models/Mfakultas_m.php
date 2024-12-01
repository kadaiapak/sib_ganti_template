<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - mbeasiswa/Asal_beasiswa
//    - mbeasiswa/Jenis_beasiswa
//    - mbeasiswa/Kelompok_beasiswa
//    - mbeasiswa/Nama_beasiswa
//    - mbeasiswa/Master_beasiswa
//    - konfigurasi/Akses
//    - data_beasiswa/Beasiswa

class Mfakultas_m extends CI_Model
{
    // @desc -memanggil semua fakultas
    // @used by
    // - controller 'mfakultas/index
    public function getFakultas()
    {
        $query = $this->db->get('fakultas');
        return $query;
    }

    // @desc -menambah fakultas
    // @used by
    // - controller 'mfakultas/index-tambah'
    public function tambahFakultas($post)
    {
        $params['nama_panjang_fakultas'] = $post['nama_panjang_fakultas'];
        $params['singkatan_fakultas'] = $post['singkatan_fakultas'];
        $params['aktif'] = $post['aktif'];
        $this->db->insert('fakultas', $params);
    }

    // @desc -hapus fakultas berdasarkan id
    // @used by
    // - controller 'mfakultas/hapus($id)'
    public function deleteFakultas($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('fakultas');
    }

    // @desc -edit fakultas berdasarkan id
    // @used by
    // - controller 'mfakultas/edit($id)'
    public function editFakultas($id)
    {
        $dataEdit = [
                'nama_panjang_fakultas' => $this->input->post('nama_panjang_fakultas'),
                'singkatan_fakultas' => $this->input->post('singkatan_fakultas'),
                'aktif' => $this->input->post('aktif')
            ];
        $this->db->where('id', $id);
        $this->db->update('fakultas', $dataEdit);
    }

}

?>