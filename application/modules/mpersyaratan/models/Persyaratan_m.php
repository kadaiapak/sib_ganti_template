<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Persyaratan_m extends CI_Model
{
   
    // @desc - cek akses dalam pengeditan beasiswa
    // @used by
    // - controller 'mpersyaratan/edit/$id'
    public function cekAksesBeasiswaModel($id, $role_id)
    {
        $this->db->select('id_beasiswa');
        $this->db->from('user_role');
        $this->db->where('id', $role_id);
        $getId = $this->db->get()->row();
        $id_beasiswa = $getId->id_beasiswa;
        
        if($id_beasiswa ==   NULL){
            return false;
        };

        $this->db->where('id', $id);
        if($id_beasiswa != 0){
            $this->db->where('nama_beasiswa', $id_beasiswa);
        }
        $this->db->from('master_beasiswa');
        $hasil = $this->db->count_all_results();
        if($hasil < 1){
            return false;
        }else {
            return true;
        }
    }

    // @desc - ambil data semua master beasiswa yang boleh di tampilkan ataupun yang tidak ditampilkan (show = 1 OR 0)
    // @used by
    // - controller 'mpersyaratan/setup-persyaratan/index'
    public function getMasterBeasiswaPersyaratan($limit = null, $start = null)
    {
        $id_beasiswa_admin = $this->fungsi->user_login()->role_id;
        $this->db->select('id_beasiswa');
        $this->db->from('user_role');
        $this->db->where('id', $id_beasiswa_admin);
        $id_beasiswa = $this->db->get()->row()->id_beasiswa;


        $this->db->select('mb.*,
        nb.nama_beasiswa as nama_beasiswa,
        kb.nama_kelompok as kelompok_beasiswa,
        ab.nama_asal_beasiswa as asal_beasiswa,
        jb.nama_jenis as jenis_beasiswa,
        p.nama as periode');
        $this->db->from('master_beasiswa mb');
        $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa', 'left');
        $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa','left');
        $this->db->join('jenis_beasiswa jb', 'jb.id = mb.jenis_beasiswa','left');
        $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa','left');
        $this->db->join('periode p', 'p.id = mb.periode','left');
        if($id_beasiswa != '0'){
            $this->db->where('mb.nama_beasiswa', $id_beasiswa);
        }
        if($id_beasiswa == NULL){
            $this->db->where('mb.nama_beasiswa', $id_beasiswa);
        }
        if($limit != null || $start != null ){
            $this->db->limit($limit, $start);
        }

        $this->db->order_by("tahun", "desc");
        $query = $this->db->get();

        return $query;
    }

    // @desc -digunakan untuk menghitung semua master beasiswa untuk pagination
    // @used by
    // - controllers 'mpersyaratan/setup-persyaratan/index'
    public function countMasterBeasiswaPersyaratanPagination()
    {
        $id_beasiswa_admin = $this->fungsi->user_login()->role_id;
        $this->db->select('id_beasiswa');
        $this->db->from('user_role');
        $this->db->where('id', $id_beasiswa_admin);
        $id_beasiswa = $this->db->get()->row()->id_beasiswa;

        if($id_beasiswa != '0'){
            $this->db->where('nama_beasiswa', $id_beasiswa);
        }
        if($id_beasiswa == NULL){
            $this->db->where('nama_beasiswa', $id_beasiswa);
        }
        $query =  $this->db->count_all_results('master_beasiswa');
        return $query;
    }

     // @desc - tambah persyaratan beasiswa
    // @used by
    //  -  controller 'persyaratan/index
    public function tambahPersyaratanBeasiswa($post)
    {
        $params['persyaratan'] = $post['nama_persyaratan_beasiswa'];
        $params['alias'] = $post['alias_persyaratan_beasiswa'];
        $params['keterangan'] = $post['keterangan_persyaratan_beasiswa'];
        $params['tipe_file'] = $post['tipe_file'];
        $params['ukuran_file'] = $post['ukuran_file'];
        $params['ukuran_file_mb'] = $post['ukuran_file_mb'];
        $this->db->insert('persyaratan_pendaftaran', $params);
    }

    // @desc - edit persyaratan beasiswa
    // @used by
    // - controller 'mbeasiswa/persyaratan/edit($id)'
    public function editPersyaratanBeasiswa($id, $post)
    {
        $dataEdit = [
                'persyaratan' => $post['nama_persyaratan_beasiswa'],
                'alias' => $post['alias_persyaratan_beasiswa'],
                'keterangan' => $post['keterangan_persyaratan_beasiswa']
            ];
        $this->db->where('id', $id);
        $this->db->update('persyaratan_pendaftaran', $dataEdit);
    }
}

?>