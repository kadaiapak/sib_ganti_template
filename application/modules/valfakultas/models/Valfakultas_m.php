<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// @used by
//    - validasi/index
class Valfakultas_m extends CI_Model
{
    // @desc    mulai datatable
    // @used    
    // controller  'validasi/detail'
    var $column_order = array(null, 'mahasiswa_beasiswa.nim_mahasiswa',
                                     'mahasiswa_beasiswa.nama_mahasiswa',
                                     'mahasiswa_beasiswa.prodi',
                                     'mahasiswa_beasiswa.fakultas',
                                     'mahasiswa_beasiswa.status_beasiswa',
                                     'mahasiswa_beasiswa.tanggal_daftar',
                                null); //set column field database for datatable orderable
    var $column_search = array('mahasiswa_beasiswa.nim_mahasiswa','mahasiswa_beasiswa.nama_mahasiswa'); //set column field database for datatable searchable
    var $order = array('mahasiswa_beasiswa.nim_mahasiswa' => 'desc'); // default order 

    private function _get_datatables_query($id)
    {
        $id_beasiswa_admin = $this->fungsi->user_login()->role_id;
        $this->db->select('nama_panjang_fakultas');
        $this->db->from('fakultas');
        $this->db->join('user_role', 'fakultas.id = user_role.id_fakultas');
        $this->db->where('user_role.id', $id_beasiswa_admin);
        $nama_fakultas = $this->db->get()->row()->nama_panjang_fakultas;

        $this->db->select('*');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->where('id_beasiswa', $id);
        $this->db->where('fakultas', $nama_fakultas);
        $this->db->group_start(); //this will start grouping
        $this->db->where('status_beasiswa', '0');
        $this->db->or_where('status_beasiswa', '0b');
        $this->db->or_where('status_beasiswa', '1' );
        $this->db->or_where('status_beasiswa', '1b' );
        $this->db->or_where('status_beasiswa', '11' );
        $this->db->group_end(); //this will end grouping
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

    function get_datatables($id) 
    {
        $this->_get_datatables_query($id);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
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

    // @desc - ambil semua master beasiswa yang sedang buka beasiswa
    // @used by
    // - controller 'valfakultas/index'
    public function getMasterBeasiswaValidasiFakultas()
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
        // $this->db->where('tampil', '1');
        $this->db->where('aktif', '1');
        $this->db->where('validasi_fakultas', '1');
        $this->db->where('mb.nama_beasiswa', $id_beasiswa);
        $this->db->where('tgl_awal_pendaftaran <', date('Y-m-d H:i:s'));
        $this->db->where('tgl_tutup_penetapan >', date('Y-m-d H:i:s'));
        $this->db->order_by("id", "desc");
        $query = $this->db->get();

        return $query;
    }

    // @desc - ambil data mahasiswa untuk dilakukan validasi
    // @used by
    // - controller 'validasi/detail_mahasiswa'
    public function getMahasiswaPendaftar($id_beasiswa, $nim)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->group_start(); //this will start grouping
        $this->db->where('status_beasiswa', '0');
        $this->db->or_where('status_beasiswa', '1' );
        $this->db->or_where('status_beasiswa', '11' );
        $this->db->group_end(); //this will end grouping
        $query = $this->db->get();

        return $query;
    }

    // @desc - ambil data mahasiswa untuk dilakukan validasi
    // @used by
    // - controller 'validasi/detail_mahasiswa'
    public function getMahasiswaPendaftarAll($id_beasiswa)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->where('id_beasiswa', $id_beasiswa);
        $this->db->where('status_beasiswa', '0');
        $query = $this->db->get();

        return $query;
    }

    // @desc - ambil berkas pendaftaran mahasiswa
    // @used by
    // - controller 'validasi/detail_mahasiswa'
    public function getBerkasPendaftaran($id)
    {
        $query = $this->db->get_where('file_mahasiswa_daftar_beasiswa', array('id_mahasiswa_daftar_beasiswa' => $id));
        return $query;
    }

    // @desc - ambil comment penolakan
    // @used by
    // - controller 'validasi/detail_mahasiswa'
    public function getComment($id_untuk_mencari_comment)
    {
        $query = $this->db->get_where('comment', array('id_mahasiswa_beasiswa' => $id_untuk_mencari_comment));
        return $query;
    }

     // @desc - ambil data mahasiswa yang sudah melakukan pendaftaran untuk diluluskan validasi fakultas
    // @used by
    // - controller 'valfakultas/calonkan'
    public function terimaValidasiFakultas($id=null, $nim = null)
    {
        $this->db->set('status_beasiswa', '1');
        $this->db->where('id_beasiswa', $id);
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->update('mahasiswa_beasiswa');
        $historis = array(
            'nim' => $nim,
            'id_beasiswa' => $id,
            'status_beasiswa' => '1',
            'keterangan' => 'lulus verifikasi data oleh fakultas',
            'tanggal' => date('Y-m-d H:i:s')
        );
        $this->db->insert('historis_beasiswa', $historis);
    }

    // @desc - ambil data mahasiswa yang sudah divalidasi untuk dibatalkan validasi kembali
    // @used by
    // - controller 'valfakultas/batalkan'
    public function batalkanValidasiFakultas($id=null, $nim = null)
    {
        $this->db->set('status_beasiswa', '0');
        $this->db->where('id_beasiswa', $id);
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->update('mahasiswa_beasiswa');
        $historis = array(
            'nim' => $nim,
            'id_beasiswa' => $id,
            'status_beasiswa' => '0',
            'keterangan' => 'dibatalkan verifikasi data oleh fakultas',
            'tanggal' => date('Y-m-d H:i:s')
        );
        $this->db->insert('historis_beasiswa', $historis);
    }

    // @desc - ambil data mahasiswa yang mendaftar untuk ditolak status pendaftarannya karena sesuatu hal seperti kurang lengkap berkas
    // @used by
    // - controller 'valfakultas/batalkan'
    public function tolakValidasiFakultas($id=null, $nim = null, $id_mahasiswa_beasiswa = null)
    {
        $this->db->set('status_beasiswa', '11');
        $this->db->where('id_beasiswa', $id);
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->update('mahasiswa_beasiswa');
        $comment = array(
            'id_mahasiswa_beasiswa' => $id_mahasiswa_beasiswa,
            'user_comment' => $this->fungsi->user_login()->name,
            'isi' => $this->input->post('isi_komen'),
            'tanggal' => date('Y-m-d H:i:s'),
            'status' => '0'
        );
        $historis = array(
            'nim' => $nim,
            'id_beasiswa' => $id,
            'status_beasiswa' => '11',
            'keterangan' => 'dibatalkan verifikasi data oleh fakultas',
            'tanggal' => date('Y-m-d H:i:s')
        );
        $this->db->insert('historis_beasiswa', $historis);
        $this->db->insert('comment', $comment);
    }

    // @desc - ambil data mahasiswa yang mendaftar untuk ditolak status pendaftarannya karena sesuatu hal seperti kurang lengkap berkas
    // @used by
    // - controller 'valfakultas/batalkan'
    public function batalkanPenolakanValidasiFakultas($id=null, $nim = null, $id_untuk_hapus_comment = null)
    {
        $this->db->set('status_beasiswa', '0');
        $this->db->where('id_beasiswa', $id);
        $this->db->where('nim_mahasiswa', $nim);
        $this->db->update('mahasiswa_beasiswa');

        $this->db->where('id_mahasiswa_beasiswa', $id_untuk_hapus_comment);
        $this->db->delete('comment');

        $delete_status = array(
            'nim' => $nim,
            'id_beasiswa' => $id,
            'status_beasiswa' => '11'
        );
        $this->db->where($delete_status);
        $this->db->delete('historis_beasiswa');
    }
}

?>