<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bsw_m extends CI_Model
{
    // var $column_order = array(null, 'nim_mahasiswa', 'nama_mahasiswa','mahasiswa_beasiswa.status_beasiswa','bukti_pembayaran_pribadi',null); //set column field database for datatable orderable
    // var $column_search = array('mahasiswa_beasiswa.nim_mahasiswa', 'mahasiswa.nama'); //set column field database for datatable searchable
    // var $order = array('nim_mahasiswa' => 'desc'); // default order
    public $column_order = array(null, 'nim_mahasiswa', 'nama_mahasiswa', 'mahasiswa_beasiswa.prodi', 'mahasiswa_beasiswa.fakultas', null); //set column field database for datatable orderable
    public $column_search = array('nim_mahasiswa', 'nama_mahasiswa'); //set column field database for datatable searchable
    public $order = array('nim_mahasiswa' => 'desc'); // default order

    // @desc -memanggil semua data dari tabel mahasiswa beasiswa yang dijoin dengan tabel lain yang nantiknya
    //        akan digunakan untuk menampilkan list mahasiswa penerima beasiswa di data table detail_beasiswa
    // @used by
    // - controller 'data_beasiswa/Beasiswa/get_ajax'
    public function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if (@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query($id = null)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_beasiswa');
        if ($id != null) {
            $this->db->where('id_beasiswa', $id);
        }
        $this->db->where('status_beasiswa', '3');
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop {
                $this->db->group_end();
            }
            //close bracket
            $i++;
        }
    

    if (isset($_POST['order'])) { // here order processing
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function count_filtered($id)
{
    $this->_get_datatables_query($id);
    $query = $this->db->get();
    return $query->num_rows();
}

function count_all($id)
{
    $this->db->from('mahasiswa_beasiswa');
    return $this->db->count_all_results();
}
// end datatables

// @desc - ambil data semua master beasiswa yang boleh di tampilkan (show = 1)
// @used by
// - controller 'bsw/index'
function getMasterBeasiswaWhere($limit, $start, $tahun = '')
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
    $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa', 'left');
    $this->db->join('jenis_beasiswa jb', 'jb.id = mb.jenis_beasiswa', 'left');
    $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa', 'left');
    $this->db->join('periode p', 'p.id = mb.periode', 'left');
    if ($id_beasiswa != 0) {
        $this->db->where('mb.nama_beasiswa', $id_beasiswa);
    }
    // $this->db->where('tampil', '1');
    $this->db->where('tahun', $tahun);
    $this->db->order_by("mb.periode", "asc");
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    return $query;
}

// @desc -digunakan untuk menghitung semua master untuk pagination
// @used by
// - controllers 'bsw/index'
function countMasterBeasiswaWherePagination($tahun='')
{
    $id_beasiswa_admin = $this->fungsi->user_login()->role_id;
    $this->db->select('id_beasiswa');
    $this->db->from('user_role');
    $this->db->where('id', $id_beasiswa_admin);
    $id_beasiswa = $this->db->get()->row()->id_beasiswa;
    $this->db->where('tampil', '1');
    $this->db->where('tahun', $tahun);
    if ($id_beasiswa != 0) {
        $this->db->where('nama_beasiswa', $id_beasiswa);
    }
    $query = $this->db->count_all_results('master_beasiswa');
    return $query;
}

function uploadSk($post)
{
    $id = $this->input->post('id');
    $this->db->set('sk', $post['sk']);
    $this->db->where('id', $id);
    $this->db->update('master_beasiswa');
}
function import_data($upload_array, $id)
{
    foreach ($upload_array as $ur) {
        $mahasiswa = array(
            'nim' => $ur,
        );
        $mahasiswaBeasiswa = array(
            'nim_mahasiswa' => $ur,
            'id_beasiswa' => $id,
        );
        $query = $this->db->get_where('mahasiswa', $mahasiswa);
        if ($query->num_rows() == 0) {
            $this->db->insert('mahasiswa', $mahasiswa);
        }
        $this->db->insert('mahasiswa_beasiswa', $mahasiswaBeasiswa);
    }
}

function cekBeasiswa($nim)
{
    $cek = array(
        'nim_mahasiswa' => $nim,
    );
    $query = $this->db->get_where('mahasiswa_beasiswa', $cek);
    if ($query->num_rows() > 0) {
        return true;
    }
    return false;
}

function hapusPenerimaBeasiswa($nim)
{
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->delete('mahasiswa_beasiswa');

}
}
