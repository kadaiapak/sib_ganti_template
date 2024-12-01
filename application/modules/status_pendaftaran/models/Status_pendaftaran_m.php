<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_pendaftaran_m extends CI_Model
{
    // @desc - ambil data status pendaftaran
    // @used by
    // - controller 'status_pendaftaran/index'
    public function getMahasiswaBeasiswaJoinMasterBeasiswaWhere($limit, $start, $nim)
    {
        $this->db->select('mahabe.id as id_mahasiswa_beasiswa, mahabe.nama_mahasiswa as nama_mahasiswa, mahabe.status_beasiswa as status_beasiswa, mahabe.tanggal_daftar,
        nabe.nama_beasiswa, 
        per.nama as nama_periode, 
        masterb.tahun as tahun');
        $this->db->from('mahasiswa_beasiswa mahabe');
        $this->db->join('master_beasiswa masterb', 'mahabe.id_beasiswa = masterb.id');
        $this->db->join('nama_beasiswa nabe', 'masterb.nama_beasiswa = nabe.id');
        $this->db->join('periode per','masterb.periode = per.id');
        $this->db->where('mahabe.nim_mahasiswa', $nim);
        $this->db->order_by("mahabe.id", "desc");
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query;
    }

    // @desc - ambil data status pendaftaran
    // @used by
    // - controller 'status_pendaftaran/index'
    public function getDetailBeasiswaMahasiswa($id)
    {
       
        $this->db->select('mahabe.*,
        jasuk.nama_jalur_masuk as nama_jalur_masuk_pendaftar,
        statayah.nama_status as nama_status_ayah,
        statayah.point_penilaian as point_status_ayah,
        statibu.nama_status as nama_status_ibu,
        statibu.point_penilaian as point_status_ibu,
        hubayah.nama_hub_ayah as nama_hub_ayah,
        hubayah.point_penilaian as point_hub_ayah,
        hubibu.nama_hub_ibu as nama_hub_ibu,
        hubibu.point_penilaian as point_hub_ibu,
        pendayah.nama_pendidikan as nama_pendidikan_ayah,
        pendayah.point_penilaian as point_pendidikan_ayah,
        pendibu.nama_pendidikan as nama_pendidikan_ibu,
        pendibu.point_penilaian as point_pendidikan_ibu,
        pekayah.nama_pekerjaan as nama_pekerjaan_ayah,
        pekayah.point_penilaian as point_pekerjaan_ayah,
        pekibu.nama_pekerjaan as nama_pekerjaan_ibu,
        pekibu.point_penilaian as point_pekerjaan_ibu,
        pengayah.ratarata_penghasilan as rata_penghasilan_ayah,
        pengayah.point_penilaian as point_penghasilan_ayah,
        pengibu.ratarata_penghasilan as rata_penghasilan_ibu,
        pengibu.point_penilaian as point_penghasilan_ibu,
        stamah.nama_status_rumah as nama_status_rumah,
        stamah.point_penilaian as point_status_rumah,
        lumah.nama_luas_rumah as nama_luas_rumah,
        lumah.point_penilaian as nama_point_penilaian,
        nabe.nama_beasiswa, 
        per.nama as nama_periode, 
        masterb.tahun as tahun');
        $this->db->from('mahasiswa_beasiswa mahabe');
        $this->db->join('master_beasiswa masterb', 'mahabe.id_beasiswa = masterb.id');
        $this->db->join('nama_beasiswa nabe', 'masterb.nama_beasiswa = nabe.id');
        $this->db->join('periode per','masterb.periode = per.id');
        $this->db->join('jalur_masuk jasuk','mahabe.jalur_masuk = jasuk.id', 'left');
        $this->db->join('status_orangtua statayah','mahabe.tulis_status_ayah = statayah.id', 'left');
        $this->db->join('status_orangtua statibu','mahabe.tulis_status_ibu = statibu.id', 'left');
        $this->db->join('hub_ayah hubayah','mahabe.hub_ayah = hubayah.id', 'left');
        $this->db->join('hub_ibu hubibu','mahabe.hub_ibu = hubibu.id', 'left');
        $this->db->join('pendidikan_orangtua pendayah','mahabe.tulis_pendidikan_ayah = pendayah.id', 'left');
        $this->db->join('pendidikan_orangtua pendibu','mahabe.tulis_pendidikan_ibu = pendibu.id', 'left');
        $this->db->join('pekerjaan_orangtua pekayah','mahabe.tulis_pekerjaan_ayah = pekayah.id', 'left');
        $this->db->join('pekerjaan_orangtua pekibu','mahabe.tulis_pekerjaan_ibu = pekibu.id', 'left');
        $this->db->join('penghasilan_orangtua pengayah','mahabe.ratarata_penghasilan_ayah = pengayah.id', 'left');
        $this->db->join('penghasilan_orangtua pengibu','mahabe.ratarata_penghasilan_ibu = pengibu.id', 'left');
        $this->db->join('status_rumah stamah','mahabe.status_rumah = stamah.id', 'left');
        $this->db->join('luas_rumah lumah','mahabe.luas_rumah = lumah.id', 'left');
        $this->db->where('mahabe.id', $id);
        $this->db->order_by("mahabe.id", "desc");
        $query = $this->db->get();

       
        return $query;
    }

    // @desc - ambil comment
    // @used by
    // - controller 'status_pendaftaran/detail/$id'
    public function getComment($id)
    {
        $query = $this->db->get_where('comment', array('id_mahasiswa_beasiswa' => $id));
        return $query;
    }

    // @desc - digunakan untuk menghitung semua master untuk pagination
    // @used by
    // - controllers 'status_pendaftaran/index'
    public function countMasterBeasiswaYangDiDaftar($nim)
    {
         $this->db->where('nim_mahasiswa', $nim);
         $query =  $this->db->count_all_results('mahasiswa_beasiswa');
         return $query;
    }

    // @desc - ambil berkas pendaftaran mahasiswa
    // @used by
    // - controller 'status_pendaftaran/detail'
    public function getBerkasPendaftaran($id)
    {
        $query = $this->db->get_where('file_mahasiswa_daftar_beasiswa', array('id_mahasiswa_daftar_beasiswa' => $id));
        return $query;
    }
}

?>