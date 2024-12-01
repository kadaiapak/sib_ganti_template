<?php
defined('BASEPATH') or exit('No direct script access allowed');

// @used by
//    - validasi/index
class Validasi_m extends CI_Model
{
    // @desc    mulai datatable
    // @used
    // controller  'validasi/detail'
    public $column_order = array(null, 'nim_mahasiswa',
        'nama_mahasiswa',
        'prodi',
        'fakultas',
        'ipk',
        'status_beasiswa',
        'tanggal_daftar',
        'total_beasiswa_lain',
        null); //set column field database for datatable orderable
    public $column_search = array('nim_mahasiswa', 'nama_mahasiswa'); //set column field database for datatable searchable
    public $order = array('nim_mahasiswa' => 'desc'); // default order

    private function _get_datatables_query($id)
    {
        $this->db->select('m.nim_mahasiswa, m.nama_mahasiswa, m.id_beasiswa, m.fakultas, m.prodi, m.fakultas, m.ipk, m.status_beasiswa, m.tanggal_daftar');
        $this->db->select("(SELECT COUNT(lain.id_beasiswa) 
                            FROM mahasiswa_beasiswa lain 
                            WHERE lain.nim_mahasiswa = m.nim_mahasiswa 
                              AND lain.id_beasiswa != '$id') AS total_beasiswa_lain");
        $this->db->from('mahasiswa_beasiswa m');
        $this->db->where('m.id_beasiswa', $id);
        $this->db->group_start(); //this will start grouping
        $this->db->where('m.status_beasiswa', '1');
        $this->db->or_where('m.status_beasiswa', '1b');
        $this->db->or_where('m.status_beasiswa', '2');
        $this->db->group_end(); //this will end grouping
        $this->db->group_by('m.nim_mahasiswa');
        $this->db->group_by('m.status_beasiswa');
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop { { { { {
                $this->db->group_end();
            }
            $i++;

        }

    

    //close bracket

    if (isset($_POST['order'])) { // here order processing
        $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);
    }
}

function get_datatables($id)
{
    $this->_get_datatables_query($id);
    if (@$_POST['length'] != -1) {
        $this->db->limit(@$_POST['length'], @$_POST['start']);
    }

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
    if ($id != null) {
        $this->db->where('id_beasiswa', $id);
    }
    return $this->db->count_all_results();
}
// end datatables

// @desc - ambil semua master beasiswa yang sedang buka beasiswa
// @used by
// - controller 'validasi/index'
function getMasterBeasiswaValidasi()
{
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
    $this->db->where('aktif', '1');
    $this->db->where('tgl_awal_penetapan <', date('Y-m-d H:i:s'));
    $this->db->where('tgl_tutup_penetapan >', date('Y-m-d H:i:s'));
    $this->db->order_by("id", "desc");
    $query = $this->db->get();

    return $query;
}

// @desc - ambil data mahasiswa untuk dilakukan validasi
// @used by
// - controller 'validasi/detail_mahasiswa'
function getMahasiswaPendaftar($id_beasiswa, $nim)
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
    $this->db->join('periode per', 'masterb.periode = per.id');
    $this->db->join('jalur_masuk jasuk', 'mahabe.jalur_masuk = jasuk.id', 'left');
    $this->db->join('status_orangtua statayah', 'mahabe.tulis_status_ayah = statayah.id', 'left');
    $this->db->join('status_orangtua statibu', 'mahabe.tulis_status_ibu = statibu.id', 'left');
    $this->db->join('hub_ayah hubayah', 'mahabe.hub_ayah = hubayah.id', 'left');
    $this->db->join('hub_ibu hubibu', 'mahabe.hub_ibu = hubibu.id', 'left');
    $this->db->join('pendidikan_orangtua pendayah', 'mahabe.tulis_pendidikan_ayah = pendayah.id', 'left');
    $this->db->join('pendidikan_orangtua pendibu', 'mahabe.tulis_pendidikan_ibu = pendibu.id', 'left');
    $this->db->join('pekerjaan_orangtua pekayah', 'mahabe.tulis_pekerjaan_ayah = pekayah.id', 'left');
    $this->db->join('pekerjaan_orangtua pekibu', 'mahabe.tulis_pekerjaan_ibu = pekibu.id', 'left');
    $this->db->join('penghasilan_orangtua pengayah', 'mahabe.ratarata_penghasilan_ayah = pengayah.id', 'left');
    $this->db->join('penghasilan_orangtua pengibu', 'mahabe.ratarata_penghasilan_ibu = pengibu.id', 'left');
    $this->db->join('status_rumah stamah', 'mahabe.status_rumah = stamah.id', 'left');
    $this->db->join('luas_rumah lumah', 'mahabe.luas_rumah = lumah.id', 'left');
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->where('id_beasiswa', $id_beasiswa);
    $this->db->group_start(); //this will start grouping
    $this->db->where('status_beasiswa', '1');
    $this->db->or_where('status_beasiswa', '2');
    $this->db->group_end(); //this will end grouping
    $query = $this->db->get();

    return $query;
}

// @desc - ambil data mahasiswa untuk dilakukan validasi
// @used by
// - controller 'validasi/detail_mahasiswa'
function getMahasiswaPendaftarAll($id_beasiswa)
{
    // $this->db->select('*');
    // $this->db->from('mahasiswa_beasiswa');
    // $this->db->where('id_beasiswa', $id_beasiswa);
    // $this->db->where('status_beasiswa', '1');
    // $query = $this->db->get();

    // return $query;
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
    $this->db->join('periode per', 'masterb.periode = per.id');
    $this->db->join('jalur_masuk jasuk', 'mahabe.jalur_masuk = jasuk.id', 'left');
    $this->db->join('status_orangtua statayah', 'mahabe.tulis_status_ayah = statayah.id', 'left');
    $this->db->join('status_orangtua statibu', 'mahabe.tulis_status_ibu = statibu.id', 'left');
    $this->db->join('hub_ayah hubayah', 'mahabe.hub_ayah = hubayah.id', 'left');
    $this->db->join('hub_ibu hubibu', 'mahabe.hub_ibu = hubibu.id', 'left');
    $this->db->join('pendidikan_orangtua pendayah', 'mahabe.tulis_pendidikan_ayah = pendayah.id', 'left');
    $this->db->join('pendidikan_orangtua pendibu', 'mahabe.tulis_pendidikan_ibu = pendibu.id', 'left');
    $this->db->join('pekerjaan_orangtua pekayah', 'mahabe.tulis_pekerjaan_ayah = pekayah.id', 'left');
    $this->db->join('pekerjaan_orangtua pekibu', 'mahabe.tulis_pekerjaan_ibu = pekibu.id', 'left');
    $this->db->join('penghasilan_orangtua pengayah', 'mahabe.ratarata_penghasilan_ayah = pengayah.id', 'left');
    $this->db->join('penghasilan_orangtua pengibu', 'mahabe.ratarata_penghasilan_ibu = pengibu.id', 'left');
    $this->db->join('status_rumah stamah', 'mahabe.status_rumah = stamah.id', 'left');
    $this->db->join('luas_rumah lumah', 'mahabe.luas_rumah = lumah.id', 'left');
    $this->db->where('id_beasiswa', $id_beasiswa);
    $this->db->where('status_beasiswa', '1');
    $this->db->order_by('nim_mahasiswa', 'desc');
    $query = $this->db->get();
    return $query;

}

// @desc - ambil berkas pendaftaran mahasiswa
// @used by
// - controller 'validasi/detail_mahasiswa'
function getBerkasPendaftaran($id)
{
    $query = $this->db->get_where('file_mahasiswa_daftar_beasiswa', array('id_mahasiswa_daftar_beasiswa' => $id));
    return $query;
}

function getBeasiswaYangDiterima($id, $nim)
{
    $this->db->select('
        nama_beasiswa.singkatan as nb_singkatan, nama_beasiswa.nama_beasiswa as nb_nama_beasiswa,
        periode.nama as p_nama,
        master_beasiswa.tahun as master_tahun, master_beasiswa.aktif as master_aktif, master_beasiswa.id as master_id,
        mahasiswa_beasiswa.status_beasiswa as mb_status_beasiswa_penerima
        ');
    $this->db->from('mahasiswa_beasiswa');
    $this->db->join('master_beasiswa', 'mahasiswa_beasiswa.id_beasiswa = master_beasiswa.id');
    $this->db->join('nama_beasiswa', 'nama_beasiswa.id = master_beasiswa.nama_beasiswa');
    $this->db->join('periode', 'periode.id = master_beasiswa.periode');
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->where('id_beasiswa !=', $id);
    $query = $this->db->get();
    return $query;
}

// @desc - ambil data mahasiswa yang sudah melakukan pendaftaran untuk diluluskan validasi
// @used by
// - controller 'validasi/calonkan'
function calonkanBeasiswa($id = null, $nim = null)
{
    $this->db->set('status_beasiswa', '2');
    $this->db->where('id_beasiswa', $id);
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->update('mahasiswa_beasiswa');
    $historis = array(
        'nim' => $nim,
        'id_beasiswa' => $id,
        'status_beasiswa' => '2',
        'keterangan' => 'lulus verifikasi data beasiswa',
        'tanggal' => date('Y-m-d H:i:s'),
    );
    $this->db->insert('historis_beasiswa', $historis);
}

// @desc - ambil data mahasiswa yang sudah divalidasi untuk dibatalkan validasi kembali
// @used by
// - controller 'validasi/batalkan'
function batalkanBeasiswa($id = null, $nim = null)
{
    $this->db->set('status_beasiswa', '1');
    $this->db->where('id_beasiswa', $id);
    $this->db->where('nim_mahasiswa', $nim);
    $this->db->update('mahasiswa_beasiswa');
    $historis = array(
        'nim' => $nim,
        'id_beasiswa' => $id,
        'status_beasiswa' => '1',
        'keterangan' => 'dibatalkan verifikasi data beasiswa',
        'tanggal' => date('Y-m-d H:i:s'),
    );
    $this->db->insert('historis_beasiswa', $historis);
}
}
