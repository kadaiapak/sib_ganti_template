<?php
defined('BASEPATH') or exit('No direct script access allowed');

// @used by
//    - data_beasiswa/Beasiswa
class Penerima_beasiswa_m extends CI_Model
{
    // var $column_order = array(null, 'nim_mahasiswa', 'nama_mahasiswa','mahasiswa_beasiswa.status_beasiswa','bukti_pembayaran_pribadi',null); //set column field database for datatable orderable
    // var $column_search = array('mahasiswa_beasiswa.nim_mahasiswa', 'mahasiswa.nama'); //set column field database for datatable searchable
    // var $order = array('nim_mahasiswa' => 'desc'); // default order
    public $column_order = array(null, 'mahasiswa_beasiswa.nim_mahasiswa', 'mahasiswa_beasiswa.nama_mahasiswa', 'mahasiswa_beasiswa.prodi', 'mahasiswa_beasiswa.ipk', 'mahasiswa_beasiswa.fakultas', null); //set column field database for datatable orderable
    public $column_search = array('mahasiswa_beasiswa.nim_mahasiswa', 'mahasiswa_beasiswa.nama_mahasiswa', 'mahasiswa_beasiswa.prodi', 'mahasiswa_beasiswa.fakultas'); //set column field database for datatable searchable
    public $order = array('mahasiswa_beasiswa.nim_mahasiswa' => 'desc'); // default order

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
        $this->db->group_start();
        $this->db->where('status_beasiswa', '3');
        $this->db->or_where('status_beasiswa', '4');
        $this->db->group_end();
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

function countMasterBeasiswaShowPagination($tahun = '')
{
    $this->db->where('tahun', $tahun);
    $query = $this->db->count_all_results('master_beasiswa');
    return $query;
}

// @desc - menambahkan nama dari sk yang di upload ke dalam table master_beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/uploadDetailSk
function uploadSk($post)
{
    $data = [
        'id_master_beasiswa' => $post['id'],
        'periode' => $post['periode'],
        'tahun' => $post['tahun_upload'],
        'nama_file' => $post['sk'],
    ];
    $this->db->insert('master_beasiswa_sk', $data);
}

// @desc - menambahkan nama dari bukti pembayaran yang di upload ke dalam table master_beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/uploadDetailPembayaran()
function uploadBp($post)
{
    $data = [
        'id_master_beasiswa' => $post['id'],
        'periode' => $post['periode'],
        'tahun' => $post['tahun_upload'],
        'nama_file' => $post['bp'],
    ];
    $this->db->insert('master_beasiswa_bp', $data);
}

// @desc - proses cek apakah mahasiswa tersebut pernah mendapatkan beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/uploadpenerima()
function cekBeasiswa($nim)
{
    $cek = array(
        'nim_mahasiswa' => $nim,
    );
    // $query = $this->db->get_where('mahasiswa_beasiswa', $cek);
    // if($query->num_rows() > 0){
    //     return true;
    // }
    return false;
}

// @desc - proses cek atau validasi secara detail apakah mahasiswa tersebut sedang aktif mendapatkan beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/validasiPenerima()
function cekDetailBeasiswa($nim)
{
    $cek = array(
        'nim_mahasiswa' => $nim,
    );
    $this->db->select('mb.*,
        master_beasiswa.nama_beasiswa,
        master_beasiswa.periode,
        master_beasiswa.tahun as tahun_mahasiswa,
        nama_beasiswa.nama_beasiswa as nama_beasiswa_mahasiswa,
        periode.nama as periode_mahasiswa');
    $this->db->from('mahasiswa_beasiswa mb');
    $this->db->join('master_beasiswa', 'mb.id_beasiswa = master_beasiswa.id');
    $this->db->join('nama_beasiswa', 'master_beasiswa.nama_beasiswa = nama_beasiswa.id');
    $this->db->join('periode', 'master_beasiswa.periode = periode.id');
    $this->db->where('status_beasiswa', '3');
    $this->db->where('master_beasiswa.aktif', '1');
    $query = $this->db->where('nim_mahasiswa', $cek['nim_mahasiswa']);
    return $query;
}

// @desc - input nim ke dalam table mahasiswa_beasiswa dan table mahasiswa yang di dapat dari proses hasil upload excel
// @used by
// - controller 'data_beasiswa/Beasiswa/uploadpenerima()
function import_data($upload_array, $id)
{
    foreach ($upload_array as $ur) {
        $mahasiswaBeasiswa = array(
            'nim_mahasiswa' => $ur['nim'],
            'tm_msk' => $ur['tm_msk'],
            'nama_mahasiswa' => $ur['nama'],
            'jenis_kelamin' => $ur['jk'],
            'prodi' => $ur['nam_prodi'],
            'fakultas' => $ur['nam_fak'],
            'jjp' => $ur['jjp'],
            'ipk' => $ur['ipk'],
            'nohp' => $ur['nohp'],
            'tmp_lhr' => $ur['tmp_lhr'],
            'tgl_lhr' => $ur['tgl_lhr'],
            'agama' => $ur['agama'],
            'id_beasiswa' => $id,
            'status_beasiswa' => '3',
            'besar_bantuan_ukt_persemester' => $ur['ukt'],
            'besar_biaya_hidup_persemester' => $ur['biaya_hidup'],
            'created_by' => $this->fungsi->user_login()->username,
            'tanggal_daftar' => date('Y-m-d H:i:s'),
        );
        $historis = array(
            'nim' => $ur['nim'],
            'id_beasiswa' => $id,
            'status_beasiswa' => '3',
            'keterangan' => 'penerima beasiswa',
            'tanggal' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('historis_beasiswa', $historis);
        $this->db->insert('mahasiswa_beasiswa', $mahasiswaBeasiswa);
    }
}

// @desc -digunakan untuk menghitung total penerima beasiswa berdasarkan beasiswa tertentu
// @used by
// - controllers 'data_beasiswa/beasiswa/detail()'
function getTotalPenerimaDetailBeasiswa($id)
{

    $cek = array(
        'id_beasiswa' => $id,
        'status_beasiswa' => '3',
    );
    $query = $this->db->where($cek)->from("mahasiswa_beasiswa")->count_all_results();
    return $query;
}

// @desc - ambil data semua master beasiswa yang boleh di tampilkan (show = 1)
// @used by
// - controller 'data_beasiswa/Beasiswa/index'
function getMasterBeasiswaShow($limit = null, $start = null, $tahun = '')
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
    $this->db->select('COUNT(m.nim_mahasiswa) AS total_mahasiswa');
    $this->db->select('SUM(CASE WHEN m.status_beasiswa = 1 THEN 1 ELSE 0 END) AS total_mendaftar');
    $this->db->select('SUM(CASE WHEN m.status_beasiswa = 2 THEN 1 ELSE 0 END) AS total_ditolak');
    $this->db->select('SUM(CASE WHEN m.status_beasiswa = 3 THEN 1 ELSE 0 END) AS total_diterima');
    $this->db->select('SUM(CASE WHEN m.status_beasiswa = 3 THEN besar_bantuan_ukt_persemester ELSE 0 END) AS dibantu_ukt');
    $this->db->select('SUM(CASE WHEN m.status_beasiswa = 3 THEN besar_biaya_hidup_persemester ELSE 0 END) AS dibantu_biaya_hidup');
    $this->db->from('master_beasiswa mb');
    $this->db->join('mahasiswa_beasiswa m', 'mb.id = m.id_beasiswa', 'left');
    $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa', 'left');
    $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa', 'left');
    $this->db->join('jenis_beasiswa jb', 'jb.id = mb.jenis_beasiswa', 'left');
    $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa', 'left');
    $this->db->join('periode p', 'p.id = mb.periode', 'left');
    if ($tahun){
        $this->db->where('mb.tahun', $tahun);
    }
    if ($limit != null || $start != null) {
        $this->db->limit($limit, $start);
    }
    $this->db->group_by('mb.id');
    $this->db->order_by("mb.periode ASC");
    $query = $this->db->get();

    return $query;
}

// @desc - input nim ke dalam table mahasiswa_beasiswa dan table mahasiswa yang di input dengan form
// @used by
// {
// - controller 'data_beasiswa/Beasiswa/check-tambah
// - controller 'data_beasiswa/Beasiswa/tambah
// - controller 'data_beasiswa/Beasiswa/prosesTambah
// }
function tambahPenerimaBeasiswa($post)
{
    $user = $this->fungsi->user_login()->username;
    $id_beasiswa = $post['id_beasiswa'];
    $params['nim_mahasiswa'] = $post['nim'];
    $params['tm_msk'] = $post['tm_msk'];
    $params['nama_mahasiswa'] = $post['nama_mahasiswa'];
    $params['jenis_kelamin'] = $post['jk'];
    $params['prodi'] = $post['prodi'];
    $params['fakultas'] = $post['fakultas'];
    $params['jjp'] = $post['jjp'];
    $params['ipk'] = $post['ipk'];
    $params['nohp'] = $post['nohp'];
    $params['tmp_lhr'] = $post['tmp_lhr'];
    $params['tgl_lhr'] = $post['tgl_lhr'];
    $params['agama'] = $post['agama'];
    $params['id_beasiswa'] = $id_beasiswa;
    $params['status_beasiswa'] = '3';
    $params['besar_bantuan_ukt_persemester'] = $post['besar_bantuan_ukt_persemester'];
    $params['besar_biaya_hidup_persemester'] = $post['besar_biaya_hidup_persemester'];
    $params['tanggal_daftar'] = date('Y-m-d H:i:s');
    $params['created_by'] = $user;
    $query = $this->db->get_where('master_beasiswa', array('id' => $id_beasiswa));
    if ($query->num_rows() == 0) {
        redirect('auth/oops');
    }
    $historis = array(
        'nim' => $post['nim'],
        'id_beasiswa' => $id_beasiswa,
        'status_beasiswa' => '3',
        'keterangan' => 'ditetapkan menjadi penerima beasiswa',
        'tanggal' => date('Y-m-d H:i:s'),
    );
    $this->db->insert('mahasiswa_beasiswa', $params);
    $this->db->insert('historis_beasiswa', $historis);
}

// @desc - menampilkan detail dari mahasiswa tertentu yang terdaftar pada beasiswa tertentu
// @used by
// - controller 'data_beasiswa/Beasiswa/detailMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
function getmahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
{
    $this->db->select('mabe.*,mabe.id as id_mahasiswa_beasiswa , mb.*,
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
    $this->db->where('mabe.id_beasiswa', $id_beasiswa);
    $this->db->where('mabe.nim_mahasiswa', $nim);
    $query = $this->db->get();
    return $query;

}

// @desc - mengambil data pdf bukti pembayaran dari tabel bukti pembayaran yang join dengan tabel beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/detailMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
function getBuktiPembayaran($id_beasiswa, $nim)
{
    $this->db->select('mbbp.id as idmbbp, mbbp.id_mahasiswa_beasiswa, mbbp.periode_bukti_pembayaran,
                            mbbp.tahun_bukti_pembayaran, mbbp.nama_file');
    $this->db->from('mahasiswa_beasiswa_bukti_pembayaran mbbp');
    $this->db->join('mahasiswa_beasiswa mb', 'mbbp.id_mahasiswa_beasiswa = mb.id');
    $this->db->where('mb.nim_mahasiswa', $nim);
    $this->db->where('mb.id_beasiswa', $id_beasiswa);
    $query = $this->db->get();
    return $query;

}

// @desc - mengganti status penerimaan beasiswa mahasiswa tertentu yang terdaftar pada beasiswa tertentu
// @used by
// - controller 'data_beasiswa/Beasiswa/batalkanTetapkan()
function batalkanBeasiswa($id_beasiswa, $nim)
{
    $this->db->set('status_beasiswa', '4');
    $this->db->where('id_beasiswa', $id_beasiswa);
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->update('mahasiswa_beasiswa');

    $historis = array(
        'nim' => $nim,
        'id_beasiswa' => $id_beasiswa,
        'status_beasiswa' => '4',
        'keterangan' => 'pembatalan status penerima beasiswa',
        'tanggal' => date('Y-m-d H:i:s'),
    );
    $this->db->insert('historis_beasiswa', $historis);
}

// @desc - mengganti status penerimaan beasiswa mahasiswa tertentu yang terdaftar pada beasiswa tertentu
// @used by
// - controller 'data_beasiswa/Beasiswa/batalkanTetapkan()
function tetapkanBeasiswa($id_beasiswa, $nim)
{
    $this->db->set('status_beasiswa', '3');
    $this->db->where('id_beasiswa', $id_beasiswa);
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->update('mahasiswa_beasiswa');

    $historis = array(
        'nim' => $nim,
        'id_beasiswa' => $id_beasiswa,
        'status_beasiswa' => '3',
        'keterangan' => 'anda ditetapkan menjadi penerima beasiswa',
        'tanggal' => date('Y-m-d H:i:s'),
    );
    $this->db->insert('historis_beasiswa', $historis);
}

// @desc - menghapus data mahasiswa tertentu yang terdaftar pada beasiswa tertentu
// @used by
// - controller 'data_beasiswa/Beasiswa/hapusPenerima()
function hapusPenerimaBeasiswa($post)
{
    $where = [
        'nim_mahasiswa' => $post['nim'],
        'id_beasiswa' => $post['id_beasiswa'],
    ];
    $this->db->where($where);
    $this->db->delete('mahasiswa_beasiswa');
}

// @desc - menghapus data mahasiswa dari tabel master mahasiswa
// @used by
// - controller 'data_beasiswa/mahasiswa/hapusMahasiswa()
function hapusMahasiswaModel($post)
{
    // $where = [
    //     'nim_mahasiswa' => $post['nim'],
    // ];
    $query = $this->db->get_where('mahasiswa_beasiswa', array('nim_mahasiswa' => $post['nim']));
    if ($query->num_rows() > 0) {
        return false;
    } else {
        $nim = $post['nim'];
        $this->db->where('nim', $nim);
        $this->db->delete('mahasiswa');
        return true;
    }
    // if($query->num_rows() > 0){
    //     return false;
    // }else {

    // echo '<pre>';
    // print_r($query->num_rows() > 0);
    // echo '/<pre>';
    // die;
    // if($this->db->get()->num_rows() > )
    // $this->db->where($where);
    // $this->db->delete('mahasiswa_beasiswa');
}

// @desc - upload bukti pembayaran masing masing mahasiswa ke tabel mahasiswa beasiswa bukti pembayaran
// @used by
// - controller 'data_beasiswa/Beasiswa/detailMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
function uploadBuktiPembayaranPerorangan($post)
{
    $params['id_mahasiswa_beasiswa'] = $post['id_mahasiswa_beasiswa'];
    $params['periode_bukti_pembayaran'] = $post['periode'];
    $params['tahun_bukti_pembayaran'] = $post['tahun'];
    $params['nama_file'] = $post['bukti_pembayaran'];
    $this->db->insert('mahasiswa_beasiswa_bukti_pembayaran', $params);
}

// @desc - hapus bukti pembayaran masing masing mahasiswa ke tabel mahasiswa beasiswa bukti pembayaran
// @used by
// - controller 'data_beasiswa/Beasiswa/detailMahasiswaPenerimaBeasiswa($id_beasiswa, $nim)
function hapusBuktiPembayaranPeroranganModel($post)
{
    $id = $post['id_bukti_pembayaran'];
    $this->db->where('id', $id);
    $this->db->delete('mahasiswa_beasiswa_bukti_pembayaran');
}

// @desc - menampikan detail master beasiswa berdasarkan ID
// @used by
// - controller 'data_beasiswa/Beasiswa/detail($id)
// - controller 'data_beasiswa/Beasiswa/uploadDetailSk
// - controller 'data_beasiswa/Beasiswa/uploadDetailPembayaran
function getDetailBeasiswa($id)
{
    $this->db->select('mb.*,
            nb.nama_beasiswa as nama_beasiswa, nb.singkatan as singkatan, nb.kontak as kontak, nb.keterangan as keterangan, nb.profil as profil ,
            kb.nama_kelompok as kelompok_beasiswa,
            ab.nama_asal_beasiswa as asal_beasiswa,
            p.nama as periode,
            jb.nama_jenis as nama_jenis_beasiswa');
    $this->db->from('master_beasiswa mb');
    $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa');
    $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa');
    $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa');
    $this->db->join('periode p', 'p.id = mb.periode');
    $this->db->join('jenis_beasiswa jb', 'jb.id = mb.jenis_beasiswa');
    $this->db->where('mb.id', $id);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row_array();
    } else {
        redirect('auth/oops');
    }
}

// @desc - mengambil data pdf sk master dari master beasiswa join dengan tabel master_beasiswa_sk
// @used by
// - controller 'data_beasiswa/Beasiswa/detail
function getMasterSk($id_beasiswa)
{
    $this->db->select('mbs.id_master_beasiswa_sk as idmbs, mbs.id_master_beasiswa, mbs.periode as periode_mbs, mbs.tahun as tahun_mbs, mbs.nama_file as nama_file_mbs');
    $this->db->from('master_beasiswa_sk mbs');
    $this->db->where('mbs.id_master_beasiswa', $id_beasiswa);
    $query = $this->db->get();
    return $query;

}

// @desc - mengambil data pdf sk master dari master beasiswa join dengan tabel master_beasiswa_sk
// @used by
// - controller 'data_beasiswa/Beasiswa/detail
function getMasterBp($id_beasiswa)
{
    $this->db->select('mbp.id_master_beasiswa_bp as idmbp, mbp.id_master_beasiswa, mbp.periode as periode_mbp, mbp.tahun as tahun_mbp, mbp.nama_file as nama_file_mbp');
    $this->db->from('master_beasiswa_bp mbp');
    $this->db->where('mbp.id_master_beasiswa', $id_beasiswa);
    $query = $this->db->get();
    return $query;

}

// @desc - hapus Surat Keputusan Rektor dari master beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/hapusDetailSk
function hapusDetailSkModel($post)
{
    $id_sk = $post['id_sk'];
    $this->db->where('id_master_beasiswa_sk', $id_sk);
    $this->db->delete('master_beasiswa_sk');
}

// @desc - hapus Bukti Pembayaran dari master beasiswa
// @used by
// - controller 'data_beasiswa/Beasiswa/hapusDetailPembayaran
function hapusDetailBpModel($post)
{
    $id_bp = $post['id_bp'];
    $this->db->where('id_master_beasiswa_bp', $id_bp);
    $this->db->delete('master_beasiswa_bp');
}
}
