<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - data_beasiswa/Beasiswa
class Daftar_beasiswa_m extends CI_Model
{
    // @desc - ambil data semua master beasiswa yang buka pendaftaran,
    //         nantinya digunakan oleh mahasiswa untuk daftar beasiswa (show = 1)
    // @used by
    // - controller 'daftar-beasiswa/index'
    public function getMasterBeasiswaDaftar()
    {
        // $point_penilaian = $this->db->query('SELECT * FROM mahasiswa_beasiswa');
        // return $point_penilaian;


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
        $this->db->where('tampil', '1');
        $this->db->where('buka_pendaftaran', '1');
        $this->db->where('aktif', '1');
        $this->db->where('tgl_awal_pendaftaran <', date('Y-m-d H:i:s'));
        $this->db->where('tgl_tutup_pendaftaran >', date('Y-m-d H:i:s'));
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        return $query;
    }

    // @desc - menginput data pendaftaran beasiswa oleh mahasiswa ke dalam table mahasiswa_daftar_beasiswa
    //         nantinya digunakan oleh mahasiswa untuk daftar beasiswa (show = 1)
    // @used by
    // - controller 'daftar-beasiswa/index'
    public function prosesPendaftaranBeasiswa($post,$id, $upload, $validasi_fakultas)
    {
        if($validasi_fakultas == '1'){
            $status_beasiswa = '0';
        }else {
            $status_beasiswa = '1';
        }

        $tanggal_daftar = date('Y-m-d H:i:s');

        if($post['data_keluarga'] == 1 && $post['no_rekening'] == 1)
            {
                $this->db->query("INSERT INTO mahasiswa_beasiswa(
                    nim_mahasiswa, 
                    tm_msk, 
                    nama_mahasiswa, 
                    jenis_kelamin, 
                    prodi, 
                    fakultas, 
                    jjp, 
                    ipk, 
                    nohp, 
                    tmp_lhr, 
                    tgl_lhr, 
                    agama, 
                    jalur_masuk,
                    ukt,
                    jenis_bank, 
                    pemilik_rekening, 
                    tulis_no_rekening, 
                    tulis_nohp,
                    tulis_nik, 
                    tulis_email, 
                    tulis_nama_ayah, 
                    tulis_status_ayah,
                    hub_ayah, 
                    tulis_pendidikan_ayah, 
                    tulis_pekerjaan_ayah, 
                    rincian_pekerjaan_ayah, 
                    ratarata_penghasilan_ayah, 
                    kontak_ayah, 
                    tulis_nama_ibu, 
                    tulis_status_ibu, 
                    hub_ibu, 
                    tulis_pendidikan_ibu, 
                    tulis_pekerjaan_ibu, 
                    rincian_pekerjaan_ibu, 
                    ratarata_penghasilan_ibu, 
                    kontak_ibu, 
                    status_rumah, luas_rumah, tahun_rumah,
                    id_beasiswa ,status_beasiswa , tanggal_daftar,
                    total_point_penilaian)
                                  VALUES (
                                    '$post[nim]', 
                                    '$post[tm_msk]', 
                                    '$post[nama_mahasiswa]', 
                                    '$post[jk]', 
                                    '$post[prodi]', 
                                    '$post[fakultas]', 
                                    '$post[jjp]', 
                                    '$post[ipk]', 
                                    '$post[nohp]', 
                                    '$post[tmp_lhr]', 
                                    '$post[tgl_lhr]', 
                                    '$post[agama]', 
                                    '$post[jalur_masuk]', 
                                    '$post[ukt]', 
                                    '$post[jenis_bank]',
                                    '$post[pemilik_rekening]',
                                    '$post[tulis_no_rekening]',
                                    '$post[tulis_nohp]',
                                    '$post[tulis_nik]',
                                    '$post[tulis_email]',
                                    '$post[tulis_nama_ayah]',
                                    '$post[tulis_status_ayah]',
                                    '$post[hub_ayah]',
                                    '$post[tulis_pendidikan_ayah]',
                                    '$post[tulis_pekerjaan_ayah]',
                                    '$post[rincian_pekerjaan_ayah]', 
                                    '$post[ratarata_penghasilan_ayah]', 
                                    '$post[kontak_ayah]', 
                                    '$post[tulis_nama_ibu]',
                                    '$post[tulis_status_ibu]',
                                    '$post[hub_ibu]',
                                    '$post[tulis_pendidikan_ibu]', 
                                    '$post[tulis_pekerjaan_ibu]',
                                    '$post[rincian_pekerjaan_ibu]',
                                    '$post[ratarata_penghasilan_ibu]', 
                                    '$post[kontak_ibu]',
                                    '$post[status_rumah]',
                                    '$post[luas_rumah]',
                                    '$post[tahun_rumah]',
                                    '$id', '$status_beasiswa',  '$tanggal_daftar',
                                ((SELECT point_penilaian FROM status_orangtua WHERE status_orangtua.id = $post[tulis_status_ayah])+ 
                                 (SELECT point_penilaian FROM hub_ayah WHERE hub_ayah.id = $post[hub_ayah])+
                                 (SELECT point_penilaian FROM pendidikan_orangtua WHERE pendidikan_orangtua.id = $post[tulis_pendidikan_ayah])+ 
                                 (SELECT point_penilaian FROM pekerjaan_orangtua WHERE pekerjaan_orangtua.id = $post[tulis_pekerjaan_ayah])+
                                 (SELECT point_penilaian FROM penghasilan_orangtua WHERE penghasilan_orangtua.id = $post[ratarata_penghasilan_ayah])+
                                 (SELECT point_penilaian FROM status_orangtua WHERE status_orangtua.id = $post[tulis_status_ibu])+ 
                                 (SELECT point_penilaian FROM hub_ibu WHERE hub_ibu.id = $post[hub_ibu])+
                                 (SELECT point_penilaian FROM pendidikan_orangtua WHERE pendidikan_orangtua.id = $post[tulis_pendidikan_ibu])+ 
                                 (SELECT point_penilaian FROM pekerjaan_orangtua WHERE pekerjaan_orangtua.id = $post[tulis_pekerjaan_ibu])+
                                 (SELECT point_penilaian FROM penghasilan_orangtua WHERE penghasilan_orangtua.id = $post[ratarata_penghasilan_ibu])+
                                 (SELECT point_penilaian FROM status_rumah WHERE status_rumah.id = $post[status_rumah])+
                                 (SELECT point_penilaian FROM luas_rumah WHERE luas_rumah.id = $post[luas_rumah])
                                 ));");
        }elseif($post['data_keluarga'] == 0 && $post['no_rekening'] == 1)
            {
            $data = array(
                    'nim_mahasiswa' => $post['nim'],
                    'tm_msk' => $post['tm_msk'],
                    'nama_mahasiswa' =>  $post['nama_mahasiswa'],
                    'jenis_kelamin' =>  $post['jk'],
                    'prodi' =>  $post['prodi'],
                    'fakultas' =>  $post['fakultas'],
                    'jjp' =>  $post['jjp'],
                    'ipk' =>  $post['ipk'],
                    'nohp' =>  $post['nohp'],
                    'tmp_lhr' =>  $post['tmp_lhr'],
                    'tgl_lhr' =>  $post['tgl_lhr'],
                    'agama' =>  $post['agama'],
                    'jalur_masuk' =>  $post['jalur_masuk'],
                    'ukt' =>  $post['ukt'],
                    'jenis_bank' =>  $post['jenis_bank'],
                    'pemilik_rekening' =>  $post['pemilik_rekening'] ? $post['pemilik_rekening'] : null,
                    'tulis_no_rekening' =>  $post['tulis_no_rekening'] ? $post['tulis_no_rekening'] : null,
                    'tulis_nohp' =>  $post['tulis_nohp'] ? $post['tulis_nohp'] : null,
                    'tulis_nik' =>  $post['tulis_nik'] ? $post['tulis_nik'] : null,
                    'tulis_email' =>  $post['tulis_email'] ? $post['tulis_email'] : null,

                    'id_beasiswa' => $id,
                    'status_beasiswa' => $status_beasiswa,
                    'tanggal_daftar' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('mahasiswa_beasiswa', $data);

        } elseif ($post['data_keluarga'] == 1 && $post['no_rekening'] == 0) 
            {
                    $this->db->query("INSERT INTO mahasiswa_beasiswa( 
                        nim_mahasiswa, 
                        tm_msk, 
                        nama_mahasiswa, 
                        jenis_kelamin, 
                        prodi, 
                        fakultas, 
                        jjp, 
                        ipk, 
                        nohp, 
                        tmp_lhr, 
                        tgl_lhr, 
                        agama, 
                        jalur_masuk, 
                        ukt, 
                        tulis_nohp, 
                        tulis_nik, 
                        tulis_email, 
                        tulis_nama_ayah, 
                        tulis_status_ayah, 
                        hub_ayah, 
                        tulis_pendidikan_ayah, 
                        tulis_pekerjaan_ayah, 
                        rincian_pekerjaan_ayah, 
                        ratarata_penghasilan_ayah, 
                        kontak_ayah, 
                        tulis_nama_ibu, 
                        tulis_status_ibu,
                        hub_ibu, 
                        tulis_pendidikan_ibu, 
                        tulis_pekerjaan_ibu, 
                        rincian_pekerjaan_ibu, 
                        ratarata_penghasilan_ibu, 
                        kontak_ibu,
                        status_rumah, luas_rumah, tahun_rumah,
                        id_beasiswa ,status_beasiswa , tanggal_daftar ,total_point_penilaian)
                            VALUES (
                                '$post[nim]', 
                                '$post[tm_msk]', 
                                '$post[nama_mahasiswa]', 
                                '$post[jk]', 
                                '$post[prodi]', 
                                '$post[fakultas]', 
                                '$post[jjp]', 
                                '$post[ipk]', 
                                '$post[nohp]', 
                                '$post[tmp_lhr]', 
                                '$post[tgl_lhr]', 
                                '$post[agama]', 
                                '$post[jalur_masuk]', 
                                '$post[ukt]', 
                                '$post[tulis_nohp]',
                                '$post[tulis_nik]',
                                '$post[tulis_email]',
                                '$post[tulis_nama_ayah]',
                                '$post[tulis_status_ayah]',
                                '$post[hub_ayah]',
                                '$post[tulis_pendidikan_ayah]',
                                '$post[tulis_pekerjaan_ayah]',
                                '$post[rincian_pekerjaan_ayah]', 
                                '$post[ratarata_penghasilan_ayah]', 
                                '$post[kontak_ayah]', 
                                '$post[tulis_nama_ibu]',
                                '$post[tulis_status_ibu]',
                                '$post[hub_ibu]',
                                '$post[tulis_pendidikan_ibu]', 
                                '$post[tulis_pekerjaan_ibu]',
                                '$post[rincian_pekerjaan_ibu]',
                                '$post[ratarata_penghasilan_ibu]', 
                                '$post[kontak_ibu]',
                                '$post[status_rumah]',
                                '$post[luas_rumah]',
                                '$post[tahun_rumah]',
                                '$id', 
                                '$status_beasiswa',  
                                '$tanggal_daftar',
                            (
                                (SELECT point_penilaian FROM status_orangtua WHERE status_orangtua.id = $post[tulis_status_ayah]) + 
                                (SELECT point_penilaian FROM hub_ayah WHERE hub_ayah.id = $post[hub_ayah]) + 
                                (SELECT point_penilaian FROM pendidikan_orangtua WHERE pendidikan_orangtua.id = $post[tulis_pendidikan_ayah]) + 
                                (SELECT point_penilaian FROM pekerjaan_orangtua WHERE pekerjaan_orangtua.id = $post[tulis_pekerjaan_ayah])+
                                (SELECT point_penilaian FROM penghasilan_orangtua WHERE penghasilan_orangtua.id = $post[ratarata_penghasilan_ayah])+
                                (SELECT point_penilaian FROM status_orangtua WHERE status_orangtua.id = $post[tulis_status_ibu])+ 
                                (SELECT point_penilaian FROM hub_ibu WHERE hub_ibu.id = $post[hub_ibu])+ 
                                (SELECT point_penilaian FROM pendidikan_orangtua WHERE pendidikan_orangtua.id = $post[tulis_pendidikan_ibu])+ 
                                (SELECT point_penilaian FROM pekerjaan_orangtua WHERE pekerjaan_orangtua.id = $post[tulis_pekerjaan_ibu])+
                                (SELECT point_penilaian FROM penghasilan_orangtua WHERE penghasilan_orangtua.id = $post[ratarata_penghasilan_ibu])+
                                (SELECT point_penilaian FROM status_rumah WHERE status_rumah.id = $post[status_rumah])+
                                (SELECT point_penilaian FROM luas_rumah WHERE luas_rumah.id = $post[luas_rumah])
                                ));");
            }else {
                   $data = array(
                    'nim_mahasiswa' => $post['nim'],
                    'tm_msk' => $post['tm_msk'],
                    'nama_mahasiswa' =>  $post['nama_mahasiswa'],
                    'jenis_kelamin' =>  $post['jk'],
                    'prodi' =>  $post['prodi'],
                    'fakultas' =>  $post['fakultas'],
                    'jjp' =>  $post['jjp'],
                    'ipk' =>  $post['ipk'],
                    'nohp' =>  $post['nohp'],
                    'tmp_lhr' =>  $post['tmp_lhr'],
                    'tgl_lhr' =>  $post['tgl_lhr'],
                    'agama' =>  $post['agama'],
                    'jalur_masuk' =>  $post['jalur_masuk'],
                    'ukt' =>  $post['ukt'],
                    'tulis_nohp' =>  $post['tulis_nohp'] ? $post['tulis_nohp'] : null,
                    'tulis_nik' =>  $post['tulis_nik'] ? $post['tulis_nik'] : null,
                    'tulis_email' =>  $post['tulis_email'] ? $post['tulis_email'] : null,

                    'id_beasiswa' => $id,
                    'status_beasiswa' => $status_beasiswa,
                    'tanggal_daftar' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('mahasiswa_beasiswa', $data);
            }
            $insert_id = $this->db->insert_id();

        // masukkan kedalam historis beasiswa
        $historis = array(
            'nim' => $post['nim'],
            'id_beasiswa' => $id,
            'status_beasiswa' => '1',
            'keterangan' => 'mendaftar beasiswa',
            'tanggal' => date('Y-m-d H:i:s')
        );
        $this->db->insert('historis_beasiswa', $historis);
        foreach ($upload as $key => $value) {
            $file_upload = array(
                'id_mahasiswa_daftar_beasiswa' => $insert_id,
                'judul' => $key,
                'nama_file' => $value
            );
            $this->db->insert('file_mahasiswa_daftar_beasiswa', $file_upload);
        }
    }

    // @desc - cek apakah yang bersangkutan sudah pernah mendaftar beasiswa ini
    //         kalau sudah maka dia tidak bisa daftar beasiswa ini, namun dia bisa daftar beasiswa lain
    // @used by
    // - controller 'daftar-beasiswa/index'
    public function cekPernahDaftarBeasiswaModel($nim, $id)
    {
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->where('id_beasiswa', $id);
        $query =  $this->db->count_all_results('mahasiswa_beasiswa');
        return $query;
    }

    public function cekSedangDaftarModel($nim)
    {
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->group_start();
        $this->db->where('status_beasiswa', '1');
        $this->db->or_where('status_beasiswa', '2');
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where('tgl_tutup_pendaftaran >', date('Y-m-d H:i:s'));
        $this->db->or_where('master_beasiswa.buka_pendaftaran','1');
        $this->db->group_end();
        $this->db->join('master_beasiswa', 'mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id');
        $query =  $this->db->count_all_results('mahasiswa_beasiswa');
        return $query;
    }

    public function cekSedangDapatBeasiswaModel($nim)
    {
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->where('status_beasiswa', '3');
        $this->db->where('master_beasiswa.jenis_beasiswa','2');
        $this->db->where('master_beasiswa.aktif','1');
        $this->db->join('master_beasiswa', 'mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id');
        $query =  $this->db->count_all_results('mahasiswa_beasiswa');
        return $query;
    }

    // @desc - cek apakah tanggal nya masih bisa mendaftar
    //         kalau sudah maka dia tidak bisa daftar beasiswa ini, namun dia bisa daftar beasiswa lain
    // @used by
    // - controller 'daftar-beasiswa/index'
    public function cekTanggalModel($id)
    {
        $this->db->select('*');
        $this->db->from('master_beasiswa');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function cekTotalPendaftar($id)
    {

        $query = $this->db->where(['id_beasiswa'=> $id])->from("mahasiswa_beasiswa")->count_all_results();
        return $query;
    }

    public function getPersyaratan($id)
    {
        $this->db->select('persyaratan_pendaftaran.persyaratan as persyaratan,
                           persyaratan_pendaftaran.alias as alias,
                           persyaratan_pendaftaran.keterangan as keterangan,
                           persyaratan_pendaftaran.tipe_file as tipe_file,
                           persyaratan_pendaftaran.ukuran_file_mb as ukuran_file_mb,
                           persyaratan_pendaftaran.ukuran_file as ukuran_file,
                           persyaratan_pendaftaran.aktif as aktif,
                           master_beasiswa_persyaratan.wajib as wajibpersyaratan
                           ');
        $this->db->from('persyaratan_pendaftaran');
        $this->db->join('master_beasiswa_persyaratan', 'master_beasiswa_persyaratan.persyaratan = persyaratan_pendaftaran.id');
        $this->db->where('master_beasiswa_persyaratan.master_beasiswa', $id);
        $result = $this->db->get();
        return $result;
    }

    public function getPekerjaanOrangtua()
    {
        $this->db->select('*');
        $this->db->from('pekerjaan_orangtua');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

    public function getStatusOrangtua()
    {
        $this->db->select('*');
        $this->db->from('status_orangtua');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

    public function getPendidikanOrangtua()
    {
        $this->db->select('*');
        $this->db->from('pendidikan_orangtua');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

     public function getPenghasilanOrangtua()
    {
        $this->db->select('*');
        $this->db->from('penghasilan_orangtua');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

     public function getHubAyah()
    {
        $this->db->select('*');
        $this->db->from('hub_ayah');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

     public function getHubIbu()
    {
        $this->db->select('*');
        $this->db->from('hub_ibu');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

      public function getStatusRumah()
    {
        $this->db->select('*');
        $this->db->from('status_rumah');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

      public function getLuasRumah()
    {
        $this->db->select('*');
        $this->db->from('luas_rumah');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }

      public function getJalurMasuk()
    {
        $this->db->select('*');
        $this->db->from('jalur_masuk');
        $this->db->where('is_active', 1);
        $query = $this->db->get();
        return $query;
    }
}

?>
