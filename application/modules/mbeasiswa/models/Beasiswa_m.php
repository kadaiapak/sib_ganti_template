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

class Beasiswa_m extends CI_Model
{
    // @desc -memanggil semua asal beasiswa
    // @used by
    // - controller 'mbeasiswa/Asal_beasiswa/index'
    // - controller 'mbeasiswa/Master_beasiswa/tambah'
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    public function getAsalBeasiswa()
    {
        $query = $this->db->get('asal_beasiswa');
        return $query;
    }

    // @desc -menambah asal beasiswa
    // @used by
    // - controller 'mbeasiswa/Asal_beasiswa/index-tambah'
    public function tambahAsalBeasiswa($post)
    {
        $params['nama_asal_beasiswa'] = $post['nama_asal_beasiswa'];
        $this->db->insert('asal_beasiswa', $params);
    }

    // @desc -hapus asal beasiswa berdasarkan id
    // @used by
    // - controller 'mbeasiswa/Asal_beasiswa/hapus($id)'
    public function deleteAsalBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('asal_beasiswa');
    }

    // @desc -edit asal beasiswa berdasarkan id
    // @used by
    // - controller 'mbeasiswa/Asal_beasiswa/edit($id)'
    public function editAsalBeasiswa($id)
    {
        $dataEdit = [
                'nama_asal_beasiswa' => $this->input->post('asal_beasiswa')
            ];
        $this->db->where('id', $id);
        $this->db->update('asal_beasiswa', $dataEdit);
    }

    // @desc -ambil data jenis beasiswa berdasarkan
    // @used by
    // - controller 'mbeasiswa/Jenis_beasiswa/index'
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    // - controller 'mbeasiswa/Master_beasiswa/tambah'
    public function getJenisBeasiswa()
    {
        $query = $this->db->get('jenis_beasiswa');
        return $query;
    }

    // @desc - tambah data jenis beasiswa
    // @used by
    // - controller 'mbeasiswa/Jenis_beasiswa/index-tambah'
    public function tambahJenisBeasiswa($post)
    {
        $params['nama_jenis'] = $post['nama_jenis'];
        $params['keterangan'] = $post['keterangan'];

        $this->db->insert('jenis_beasiswa', $params);

    }

    // @desc - hapus data jenis beasiswa berdasarkan id
    // @used by
    // - controller 'mbeasiswa/Jenis_beasiswa/hapus'
    public function deleteJenisBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jenis_beasiswa');
    }

    // @desc - ubah data jenis beasiswa berdasarkan id
    // @used by
    // - controller 'mbeasiswa/Jenis_beasiswa/edit'
    public function editJenisBeasiswa($id)
    {
        $dataEdit = [
                'nama_jenis' => $this->input->post('nama_jenis'),
                'keterangan' => $this->input->post('keterangan')
            ];
        $this->db->where('id', $id);
        $this->db->update('jenis_beasiswa', $dataEdit);
    }

    // @desc -ambil data kelompok beasiswa
    // @used by
    // - controller 'mbeasiswa/Kelompok_beasiswa/index'
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    // - controller 'mbeasiswa/Master_beasiswa/tambah'
    public function getKelompokBeasiswa()
    {
        $query = $this->db->get('kelompok_beasiswa');
        return $query;
    }

    // @desc - tambah data kelompo beasiswa
    // @used by
    // - controller 'mbeasiswa/Kelompok_beasiswa/index-tambah'
    public function tambahKelompokBeasiswa($post)
    {
        $params['nama_kelompok'] = $post['nama_kelompok'];
        $this->db->insert('kelompok_beasiswa', $params);
    }

    // @desc - hapus data kelompok beasiswa berdasarkan ID
    // @used by
    // - controller 'mbeasiswa/Kelompok_beasiswa/del'
    public function deleteKelompokBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kelompok_beasiswa');
    }

    // @desc - edit data kelompok beasiswa berdasarkan ID
    // @used by
    // - controller 'mbeasiswa/Kelompok_beasiswa/edit'
    public function editKelompokBeasiswa($id)
    {
        $dataKelompok = [
            'nama_kelompok' => $this->input->post('kelompok_beasiswa')
        ];
        $this->db->where('id', $id);
        $this->db->update('kelompok_beasiswa', $dataKelompok);
    }

    // @desc -memanggil semua nama beasiswa
    // @used by
    // - controller 'konfiguras/akses/index-tambah'
    // - controller 'konfiguras/akses/edit'
    // - controller 'mbeasiswa/Nama_beasiswa/index'
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    // - controller 'mbeasiswa/Master_beasiswa/tambah'
    public function getNamaBeasiswa()
    {
        $query = $this->db->get('nama_beasiswa');
        return $query;
    }

    // @desc - tambah nama beasiswa
    // @used by
    // - controller 'mbeasiswa/Nama_beasiswa/index-tambah'
    public function tambahNamaBeasiswa($post)
    {
        $params['nama_beasiswa'] = $post['beasiswa'];
        $params['singkatan'] = $post['singkatan'];
        $params['keterangan'] = $post['deskripsi'];
        $params['profil'] = $post['profil'];
        $this->db->insert('nama_beasiswa', $params);
    }

    // @desc - edit nama beasiswa
    // @used by
    // - controller 'mbeasiswa/Nama_beasiswa/edit($id)'
     public function editNamaBeasiswa($id)
    {
        $dataEdit = [
                'nama_beasiswa' => $this->input->post('beasiswa'),
                'singkatan' => $this->input->post('singkatan'),
                'keterangan' => $this->input->post('deskripsi'),
                'profil' => $this->input->post('profil'),
            ];
        $this->db->where('id', $id);
        $this->db->update('nama_beasiswa', $dataEdit);
    }

    // @desc - delete nama beasiswa
    // @used by
    // - controller 'mbeasiswa/Nama_beasiswa/del($id)'
    public function deleteNamaBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('nama_beasiswa');
    }

    // @desc - ambil data master beasiswa, join dengan tabel asal,jenis,kelompok,nama beasiswa dll
    // @desc - ambil data master beasiswa dengan ID tertentu
    // @used by
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    //  -  controller 'mbeasiswa/Master_beasiswa/edit
    //  -  fungsi count_user
    public function getMasterBeasiswa($id = null)
    {
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
        if($id != null){
            $this->db->where('mb.id', $id);
        }
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        return $query;
    }

    // @desc - ambil data master beasiswa, join dengan tabel asal,jenis,kelompok,nama beasiswa dll
    // @desc - ambil data master beasiswa dengan ID tertentu
    // @desc - ambil data master untuk pagination
    // @used by
    //  -  controller 'mbeasiswa/Master_beasiswa/index
    public function getMasterBeasiswaPagination($limit, $start)
    {
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
        $this->db->limit($limit, $start);
        $this->db->order_by("tahun", "desc");
        $query = $this->db->get();

        return $query;
    }

    public function countMasterBeasiswaPagination()
    {
        $query =  $this->db->count_all_results('master_beasiswa');
        return $query;
    }

    // @desc - tambah data master beasiswa
    // @used by
    //  -  controller 'mbeasiswa/Master_beasiswa/tambah
    public function tambahMasterBeasiswa($post)
    {
        $params['nama_beasiswa'] = $post['nama_beasiswa'];
        $params['kelompok_beasiswa'] = $post['kelompok_beasiswa'];
        $params['asal_beasiswa'] = $post['asal_beasiswa'];
        $params['jenis_beasiswa'] = $post['jenis_beasiswa'];
        $params['biaya'] = $post['biaya'];
        $params['metode_pembayaran'] = $post['metode_pembayaran'];
        $params['periode'] = $post['periode'];
        $params['tahun'] = $post['tahun'];
        $params['metode_pembayaran'] = $post['metode_pembayaran'];
        $params['min_ipk'] = $post['min_ipk'];
        $params['kuota_pendaftaran'] = $post['kuota_pendaftaran'];
        $params['kuota_penetapan'] = $post['kuota_penetapan'];
        $params['tanggal_penetapan'] = $post['tanggal_penetapan'];
        $params['buka_pendaftaran'] = $post['is_buka_pendaftaran'];
        $params['tampil'] = $post['is_show'];
        $params['aktif'] = $post['is_active'];
        $params['data_keluarga'] = $post['data_keluarga'];
        $params['no_rekening'] = $post['no_rekening'];
        $params['validasi_fakultas'] = $post['is_validasi_fakultas'];
        $params['tgl_awal_pendaftaran'] = $post['tgl_awal_pendaftaran'];
        $params['tgl_tutup_pendaftaran'] = $post['tgl_tutup_pendaftaran'];
        $params['tgl_awal_penetapan'] = $post['tgl_awal_penetapan'];
        $params['tgl_tutup_penetapan'] = $post['tgl_tutup_penetapan'];
        $params['user_created'] = $this->fungsi->user_login()->username;
        $this->db->insert('master_beasiswa', $params);
    }

    // @desc - edit data master beasiswa
    // @used by
    //  -  controller 'mbeasiswa/Master_beasiswa/edit
    public function editMasterBeasiswa($post)
    {
        $id = $post['id'];
        $params['nama_beasiswa'] = $post['nama_beasiswa'];
        $params['kelompok_beasiswa'] = $post['kelompok_beasiswa'];
        $params['asal_beasiswa'] = $post['asal_beasiswa'];
        $params['jenis_beasiswa'] = $post['jenis_beasiswa'];
        $params['biaya'] = $post['biaya'];
        $params['periode'] = $post['periode'];
        $params['min_ipk'] = $post['min_ipk'];
        $params['tahun'] = $post['tahun'];
        $params['metode_pembayaran'] = $post['metode_pembayaran'];
        $params['kuota_pendaftaran'] = $post['kuota_pendaftaran'];
        $params['kuota_penetapan'] = $post['kuota_penetapan'];
        $params['tgl_awal_pendaftaran'] = $post['tgl_awal_pendaftaran'];
        $params['tgl_tutup_pendaftaran'] = $post['tgl_tutup_pendaftaran'];
        $params['tgl_awal_penetapan'] = $post['tgl_awal_penetapan'];
        $params['tgl_tutup_penetapan'] = $post['tgl_tutup_penetapan'];
        $params['tanggal_penetapan'] = $post['tanggal_penetapan'];
        $params['buka_pendaftaran'] = $post['is_buka_pendaftaran'];
        $params['aktif'] = $post['is_active'];
        $params['tampil'] = $post['is_show'];
        $params['data_keluarga'] = $post['data_keluarga'];
        $params['no_rekening'] = $post['no_rekening'];
        $params['validasi_fakultas'] = $post['is_validasi_fakultas'];
        $params['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->update('master_beasiswa', $params);

    }

    // @desc - hapus data master beasiswa
    // @used by
    //  -  controller 'mbeasiswa/Master_beasiswa/del
    public function deleteMasterBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('master_beasiswa');
    }

    // @desc - mengambil data periode di database
    // @used by
    // - controller 'mbeasiswa/Master_beasiswa/tambah'
    // - controller 'mbeasiswa/Master_beasiswa/edit'
    public function getPeriodeBeasiswa()
    {
        $query = $this->db->get('periode');
        return $query;
    }



    // @desc - mengambil data penerima beasiswa baik semua maupun detail berdasarkan id
    // @used by
    // - controller 'data_beasiswa/Beasiswa/detail($id)
    // - controller 'data_beasiswa/Beasiswa/pdf($id)
    public function getPenerimaBeasiswa($id = null)
    {
        $this->db->select('mabe.*,mb.*,
                            nb.nama_beasiswa as nama_beasiswa,
                            kb.nama_kelompok as kelompok_beasiswa,
                            ab.nama_asal_beasiswa as asal_beasiswa,
                            p.nama as periode');
        $this->db->from('mahasiswa_beasiswa mabe');
        $this->db->join('master_beasiswa mb', 'mabe.id_beasiswa = mb.id');
        $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa');
        $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa');
        $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa');
        $this->db->join('periode p', 'p.id = mb.periode');
        if($id){
            $this->db->where('mabe.id_beasiswa', $id);
        }
        $this->db->group_start();
        $this->db->where('status_beasiswa', '3');
        $this->db->or_where('status_beasiswa', '4');
        $this->db->or_where('status_beasiswa', '5');
        $this->db->group_end();
        // $query = $this->db->get()->result_array();
        // $query = $this->db->get()->result_array();
        $query = $this->db->get();
        return $query;
    }

    // @desc - mengambil data persyaratan beasiswa
    // @used by
    // - controller 'mbeasiswa/persyaratan'
    public function getPersyaratanBeasiswa($limit = null, $start = null)
    {
        if($limit != null || $start != null){
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get('persyaratan_pendaftaran');
        return $query;
    }

    // @desc -digunakan untuk menghitung semua total persyaratan beasiswa untuk pagination
    // @used by
    // - controllers 'mpersyaratan/persyaratan/index'
    public function countPersyaratanBeasiswaPagination()
    {
        $query =  $this->db->count_all_results('persyaratan_pendaftaran');
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
                'keterangan' => $post['keterangan_persyaratan_beasiswa'],
                'tipe_file' => $post['tipe_file'],
                'ukuran_file' => $post['ukuran_file'],
                'ukuran_file_mb' => $post['ukuran_file_mb'],
            ];
        $this->db->where('id', $id);
        $this->db->update('persyaratan_pendaftaran', $dataEdit);
    }

     // @desc - edit persyaratan beasiswa
    // @used by
    // - controller 'mpersyaratan/persyaratan/hapus($id)'
    public function deletePersyaratanBeasiswa($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('persyaratan_pendaftaran');
    }

    // @desc - edit menghitung total penerima beasiswa
    // @used by
    // - libraries 'fungsi'
    public function getTotalPenerima()
    {
        $query = $this->db->where(['status_beasiswa'=> '3'])->from("mahasiswa_beasiswa")->count_all_results();
        return $query;
    }

     // @desc - edit persyaratan beasiswa
    // @used by
    // - libraries 'fungsi'
    public function getProdi()
    {
        $query = $this->db->query("SELECT COUNT(prodi) as total_prodi, prodi FROM mahasiswa_beasiswa WHERE status_beasiswa = 3 GROUP BY prodi");
        return $query;
    }

}

?>
