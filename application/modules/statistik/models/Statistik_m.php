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

class Statistik_m extends CI_Model
{

    // @desc - edit menghitung total penerima beasiswa
    // @used by
    // - libraries 'fungsi'
    public function getTotalPenerima()
    {
        $query = $this->db->where(['status_beasiswa'=> '3'])->from("mahasiswa_beasiswa")->count_all_results();
        return $query;
    }

    //  // @desc - edit persyaratan beasiswa
    // // @used by
    // // - libraries 'fungsi'
    // public function getProdi()
    // {
    //     $query = $this->db->query("SELECT COUNT(prodi) as total_prodi, prodi FROM mahasiswa_beasiswa WHERE status_beasiswa = 3 GROUP BY prodi");
    //     return $query;
    // }

    
     // @desc - edit persyaratan beasiswa
    // @used by
    // - libraries 'fungsi'
    public function getTotalMaster($tahun = '2021')
    {
        // $q = '';
        // $dbeasiswa = $this->sering($tahun);
        // if($dbeasiswa->num_rows() > 0){
        //     $dbeasiswa = $dbeasiswa->result();
        //     foreach($dbeasiswa as $d){
        //         $q .= "IFNULL (sum(IF(mahasiswa_beasiswa.id_beasiswa = $d->id, 1, 0)),0) AS '$d->singkatan' , ";
        //     }
        // }

        // $query = $this->db->query(
        //     "SELECT $q prodi, fakultas ,tahun  FROM mahasiswa_beasiswa 
        //     INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
        //     WHERE status_beasiswa = 3 AND tahun = 2022 GROUP BY prodi, tahun"
        //     );
        // return $query;

        $query = $this->db->query(
            "SELECT prodi, count(mahasiswa_beasiswa.id) as total_penerima, nama_beasiswa.nama_beasiswa as nama_asli_beasiswa, tahun, fakultas  FROM mahasiswa_beasiswa 
            INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
            INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
            WHERE status_beasiswa = 3 AND tahun = 2021 GROUP BY prodi"
            );
        return $query;
    }

    public function namaBeasiswa($tahun='')
    {
        $this->db->select('master_beasiswa.id,nama_beasiswa.singkatan');
        $this->db->join('nama_beasiswa','master_beasiswa.nama_beasiswa = nama_beasiswa.id');
        $dbeasiswa = $this->db->get_where('master_beasiswa',"master_beasiswa.tahun = $tahun");
        return $dbeasiswa;
    }

    public function getProdi()
    {
        $query = $this->db->query(
            "SELECT DISTINCT fakultas FROM mahasiswa_beasiswa
            ORDER BY fakultas ASC"
            );
        return $query;
    }

    public function getPenerimaBeasiswaDua($prodi = '', $id='')
    {
        $query = $this->db->query(
            "SELECT count(mahasiswa_beasiswa.id) as total_penerima FROM mahasiswa_beasiswa 
            INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
            INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
            WHERE prodi = '$prodi' 
            AND id_beasiswa = $id 
            AND status_beasiswa = 3"
            );
        return $query;
    }

    public function getDetailRekap($tahun = null)
    {
        $query = $this->db->query(
            "SELECT nama_beasiswa.nama_beasiswa as nama_beasiswa, periode.nama as nama_periode ,master_beasiswa.tahun, mahasiswa_beasiswa.fakultas as nama_fakultas, mahasiswa_beasiswa.prodi as nama_prodi, count(mahasiswa_beasiswa.id) AS total_penerima
            FROM mahasiswa_beasiswa
                INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
                INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
                INNER JOIN periode ON master_beasiswa.periode = periode.id
            WHERE status_beasiswa = 3 AND master_beasiswa.tahun = 2023
            GROUP BY mahasiswa_beasiswa.id_beasiswa, fakultas, prodi
            ");
        return $query;
    }


}