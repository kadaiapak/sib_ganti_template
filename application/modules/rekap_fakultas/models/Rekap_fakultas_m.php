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

class Rekap_fakultas_m extends CI_Model
{
    public function getDetailRekap($tahun = null, $fakultas = null)
    {
        if($fakultas == 'all' ){
            $query = $this->db->query(
                "SELECT mahasiswa_beasiswa.fakultas as nama_fakultas, CONCAT(nama_beasiswa.nama_beasiswa, ' periode ', periode.nama) as nama_beasiswa, periode.nama as nama_periode ,master_beasiswa.tahun, mahasiswa_beasiswa.prodi as nama_prodi, mahasiswa_beasiswa.jjp as jenjang_pendidikan,count(mahasiswa_beasiswa.id) AS total_penerima
                FROM mahasiswa_beasiswa
                    INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
                    INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
                    INNER JOIN periode ON master_beasiswa.periode = periode.id
                WHERE status_beasiswa = 3 AND master_beasiswa.tahun = $tahun
                GROUP BY fakultas, mahasiswa_beasiswa.id_beasiswa, prodi 
                ORDER BY nama_beasiswa.nama_beasiswa
                ");
        }else {
            $query = $this->db->query(
                "SELECT mahasiswa_beasiswa.fakultas as nama_fakultas, CONCAT(nama_beasiswa.nama_beasiswa, ' periode ', periode.nama) as nama_beasiswa, periode.nama as nama_periode ,master_beasiswa.tahun, mahasiswa_beasiswa.prodi as nama_prodi, mahasiswa_beasiswa.jjp as jenjang_pendidikan,count(mahasiswa_beasiswa.id) AS total_penerima
                FROM mahasiswa_beasiswa
                    INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
                    INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
                    INNER JOIN periode ON master_beasiswa.periode = periode.id
                WHERE status_beasiswa = 3 AND master_beasiswa.tahun = $tahun AND fakultas = '$fakultas' 
                GROUP BY fakultas, mahasiswa_beasiswa.id_beasiswa, prodi 
                ORDER BY nama_beasiswa.nama_beasiswa
                ");
        }
        return $query;
        
    }

    public function getDetailRekapFakultas($tahun)
    {
        $query = $this->db->query(
            "SELECT mahasiswa_beasiswa.fakultas as nama_fakultas, CONCAT(nama_beasiswa.nama_beasiswa, ' periode ', periode.nama) as nama_beasiswa, periode.nama as nama_periode ,master_beasiswa.tahun, mahasiswa_beasiswa.prodi as nama_prodi, mahasiswa_beasiswa.jjp as jenjang_pendidikan,count(mahasiswa_beasiswa.id) AS total_penerima
            FROM mahasiswa_beasiswa
                INNER JOIN master_beasiswa ON mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id
                INNER JOIN nama_beasiswa ON master_beasiswa.nama_beasiswa = nama_beasiswa.id
                INNER JOIN periode ON master_beasiswa.periode = periode.id
            WHERE status_beasiswa = 3 AND master_beasiswa.tahun = $tahun
            GROUP BY fakultas, mahasiswa_beasiswa.id_beasiswa
            ORDER BY nama_beasiswa.nama_beasiswa
            ");
        return $query;
    }

    public function getFakultas()
    {
        
        $query = $this->db->query(
            "SELECT DISTINCT fakultas FROM mahasiswa_beasiswa
            ORDER BY fakultas ASC"
            );
        return $query;
    }
}