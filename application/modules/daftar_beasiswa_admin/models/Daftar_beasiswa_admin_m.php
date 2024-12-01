<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - daftar-beasiswa-admin/Beasiswa
class Daftar_beasiswa_admin_m extends CI_Model
{
    // @desc    mulai datatable
    // @used    
    // controller  'validasi/detail'
    var $column_order = array(null,  'mahasiswa_beasiswa.nim_mahasiswa',
                                     'mahasiswa_beasiswa.nama_mahasiswa',
                                     'mahasiswa_beasiswa.prodi',
                                     'mahasiswa_beasiswa.fakultas',
                                     'mahasiswa_beasiswa.status_beasiswa',
                                     'mahasiswa_beasiswa.name',
                                     'mahasiswa_beasiswa.tanggal_daftar',
                                null); //set column field database for datatable orderable
    var $column_search = array('mahasiswa_beasiswa.nim_mahasiswa','mahasiswa_beasiswa.nama_mahasiswa'); //set column field database for datatable searchable
    var $order = array('mahasiswa_beasiswa.nim_mahasiswa' => 'desc'); // default order 

    private function _get_datatables_query($id, $display)
    {
        $user_id = $this->session->userdata('userid');
        $this->db->select('mahasiswa_beasiswa.*, user.name');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->join('user', 'mahasiswa_beasiswa.admin_pendaftar = user.id', 'left');
        $this->db->where('id_beasiswa', $id);
        if($display == 'all') {
            $this->db->group_start(); //this will start grouping
            $this->db->where('status_beasiswa', '0');
            $this->db->or_where('status_beasiswa', '1' );
            $this->db->group_end(); //this will end grouping
        } elseif ($display == 'half') {
            $this->db->where('admin_pendaftar', $user_id);
            $this->db->group_start(); //this will start grouping
            $this->db->where('status_beasiswa', '0');
            $this->db->or_where('status_beasiswa', '1' );
            $this->db->group_end(); //this will end grouping
        }
        $i = 0;
        
        foreach ($this->column_search as $item) { // loop column 
            if(@$_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id, $display) 
    {
        $this->_get_datatables_query($id, $display);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id, $display)
    {
        $this->_get_datatables_query($id, $display);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($id = null) 
    {
        $this->db->from('mahasiswa_beasiswa');
        if($id != null){
            $this->db->where('id_beasiswa', $id);
        }
        return $this->db->count_all_results();
    }
    // end datatables


    // @desc - ambil data semua master beasiswa yang buka pendaftaran, 
    //         walaupun beasiswa tersebut tidak ditampilkan *tampil = 0
    // @used by
    // - controller 'daftar-beasiswa-admin/index'
    public function getMasterBeasiswaDaftar()
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
        $this->db->group_start();
        $this->db->where('tampil', '0');
        $this->db->or_where('tampil', '1');
        $this->db->group_end();
        $this->db->where('buka_pendaftaran', '1');
        $this->db->where('aktif', '1');
        $this->db->where('tgl_awal_pendaftaran <', date('Y-m-d H:i:s'));
        $this->db->where('tgl_tutup_pendaftaran >', date('Y-m-d H:i:s'));
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query;
    }

     // @desc - print data mahasiswa yang didaftarkan beasiswa oleh admin
    // @used by
    // - controller 'daftar-beasiswa-admin/pdf($id)
    // - controller 'daftar-beasiswa-admin/excel($id)
    public function getPendaftarBeasiswa($id = null)
    {
        $this->db->select('mabe.*, 
                            nb.nama_beasiswa as nama_beasiswa, 
                            kb.nama_kelompok as kelompok_beasiswa, 
                            ab.nama_asal_beasiswa as asal_beasiswa, 
                            p.nama as periode,
                            user.name as admin_pendaftar');
        $this->db->from('mahasiswa_beasiswa mabe');
        $this->db->join('master_beasiswa mb', 'mabe.id_beasiswa = mb.id');
        $this->db->join('user', 'mabe.admin_pendaftar = user.id', 'left');
        $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa');
        $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa');
        $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa');
        $this->db->join('periode p', 'p.id = mb.periode');
        if($id){
            $this->db->where('mabe.id_beasiswa', $id);
        }
        $this->db->group_start();
        $this->db->where('status_beasiswa', '0');
        $this->db->or_where('status_beasiswa', '1');
        $this->db->group_end();
        $query = $this->db->get();
        return $query;
    }

    // @desc - menginput data pendaftaran beasiswa oleh mahasiswa ke dalam table mahasiswa_daftar_beasiswa 
    //         nantinya digunakan oleh admin untuk mengajukan mahasiswa untuk beasiswa (show = 1)
    // @used by
    // - controller 'coba-beasiswa-admin/input-data'
    public function prosesPendaftaranBeasiswaOlehAdmin($post, $id, $upload, $validasi_fakultas)
    {
        $id_user = $this->session->userdata('userid');
        // jika beasiswa tersebut harus divalidasi fakultas
        if($validasi_fakultas == '1'){
            // jadikan status beasiswa nya jadi 0 ( harus divalidasi fakultas dahulu)
            $status_beasiswa = '0';
        }else {
            // jika tidak jadikan status beasiswanya jadi 1 (yaitu langsung di validasi oleh admin beasiswa unp)
            $status_beasiswa = '1';
        }
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
            'id_beasiswa' => $id,
            'status_beasiswa' => $status_beasiswa,
            'admin_pendaftar' => $id_user,
            'tanggal_daftar' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert('mahasiswa_beasiswa', $data);
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
        $this->db->where('status_beasiswa', '0');
        $this->db->or_where('status_beasiswa', '1');
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

     // @desc - detail pendaftaran mahasiswa
    // @used by
    // - controller 'daftar-mahasiswa-beasiswa/detail-mahasiswa/id-beasiswa/nim'
    public function getMahasiswaPendaftar($id_beasiswa, $nim)
    {
        $this->db->select('mahasiswa_beasiswa.*, user.name as admin_yang_mendaftarkan');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->join('user', 'mahasiswa_beasiswa.admin_pendaftar = user.id', 'left');
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->group_start(); //this will start grouping
        $this->db->where('status_beasiswa', '0');
        $this->db->or_where('status_beasiswa', '1' );
        $this->db->group_end(); //this will end grouping
        $query = $this->db->get();
        return $query;
    }


    public function getAdminPendaftar($id_beasiswa, $nim_mahasiswa)
    {
        $this->db->select('mahasiswa_beasiswa.admin_pendaftar');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->where('nim_mahasiswa', $nim_mahasiswa);
        $query = $this->db->get();
        return $query;
    }

   

    public function hapusPendaftarBeasiswa($id_beasiswa, $nim_mahasiswa)
    {
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->where('nim_mahasiswa', $nim_mahasiswa);
        $this->db->where('admin_pendaftar', $this->session->userdata('userid'));
        $this->db->delete('mahasiswa_beasiswa');
    }

       public function hapusBerkasPendaftaranBeasiswa($id_beasiswa, $nim_mahasiswa)
    {
        $this->db->query("DELETE file_mahasiswa_daftar_beasiswa FROM file_mahasiswa_daftar_beasiswa
        JOIN mahasiswa_beasiswa ON file_mahasiswa_daftar_beasiswa.id_mahasiswa_daftar_beasiswa = mahasiswa_beasiswa.id
        WHERE mahasiswa_beasiswa.id_beasiswa = $id_beasiswa AND mahasiswa_beasiswa.nim_mahasiswa = $nim_mahasiswa");
            
}

    public function getBerkasPendaftaranBeasiswa($id_beasiswa, $nim_mahasiswa)
    {
        
        $this->db->select('file_mahasiswa_daftar_beasiswa.*');
        $this->db->from('file_mahasiswa_daftar_beasiswa');
        $this->db->join('mahasiswa_beasiswa', 'mahasiswa_beasiswa.id = file_mahasiswa_daftar_beasiswa.id_mahasiswa_daftar_beasiswa');
        $this->db->where('nim_mahasiswa', $nim_mahasiswa);
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->where('admin_pendaftar', $this->session->userdata('userid'));
        $query = $this->db->get();
        return $query;
    }

    public function getPekerjaanAyah()
    {
        $this->db->select('*');
        $this->db->from('pekerjaan_orangtua');
        $this->db->where('is_active', '1');
        $query = $this->db->get();
        return $query;
    }
}

?>