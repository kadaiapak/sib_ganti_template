<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhs_m extends CI_Model
{
    var $column_order = array(null, 'mhs_nim', 'mhs_nama', 'mhs_prodi','mahasiswa_beasiswa.id_beasiswa'); //set column field database for datatable orderable
    var $column_search = array('mahasiswa.nim', 'mahasiswa.nama'); //set column field database for datatable searchable
    var $order = array('mhs_nim' => 'desc'); // default order 

    private function _get_datatables_query()
    {
        $this->db->select('mahasiswa.nim as mhs_nim, mahasiswa.nama as mhs_nama, mahasiswa.prodi as mhs_prodi,
        mahasiswa.aktif as mhs_aktif,
        mahasiswa_beasiswa.*
        ');
        $this->db->from('mahasiswa');
        $this->db->join('mahasiswa_beasiswa', 'mahasiswa.nim = mahasiswa_beasiswa.nim_mahasiswa', 'left');
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

    function get_datatables() 
    {
        $this->_get_datatables_query();
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all() 
    {
        $this->db->from('mahasiswa_beasiswa');
        return $this->db->count_all_results();
    }
    // end datatables

    // @desc -digunakan untuk mendapatkan data maahsiswa sesuai nim
    // @used by
    // - controllers 'data_beasiswa/mahasiswa/detail($id)
    // - controllers 'data_beasiswa/mahasiswa/edit($id)
    // - controllers 'mhs/detail($id)
    public function getPenerimaBeasiswa($id = null)
    {
        // $this->db->select('mabe.*, mb.*,
        //     nb.nama_beasiswa as nama_beasiswa, kb.nama_kelompok as kelompok_beasiswa, ab.nama_asal_beasiswa as asal_beasiswa, p.nama as periode, 
        //     maha.nama as nama_mahasiswa, maha.prodi as prodi, maha.fakultas as fakultas ,maha.aktif as aktif, maha.nama as nama_mahasiswa, maha.photo as photo');
        // $this->db->from('mahasiswa_beasiswa mabe');
        // $this->db->join('master_beasiswa mb', 'mabe.id_beasiswa = mb.id');
        // $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa');
        // $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa');
        // $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa');
        // $this->db->join('periode p', 'p.id = mb.periode');
        // $this->db->join('mahasiswa maha', 'maha.nim = mabe.nim_mahasiswa');

        $this->db->select('m.nim as m_nim, m.nama as m_nama, m.prodi as m_prodi, m.fakultas as m_fakultas, m.aktif as m_aktif');
        $this->db->from('mahasiswa m');
        // $this->db->join('master_beasiswa mb', 'mabe.id_beasiswa = mb.id');
        // $this->db->join('nama_beasiswa nb', 'nb.id = mb.nama_beasiswa');
        // $this->db->join('kelompok_beasiswa kb', 'kb.id = mb.kelompok_beasiswa');
        // $this->db->join('asal_beasiswa ab', 'ab.id = mb.asal_beasiswa');
        // $this->db->join('periode p', 'p.id = mb.periode');
        // $this->db->join('mahasiswa maha', 'maha.nim = mabe.nim_mahasiswa');
        $this->db->where('m.nim', $id);
        $query = $this->db->get();
        if($query->num_rows() == 0)
        {
            redirect('auth/oops');
        }
        return $query;
       
     
    }

    // @desc -digunakan untuk mendapatkan data beasiswa yang diterima mahasiswa sesuai dengan nim
    // @used by
    // - controllers 'data_beasiswa/mahasiswa/detail($id)
    // - controllers 'mhs/detail($id)
    public function getBeasiswaYangDiterima($nim = null)
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
        if($nim){
            $this->db->where('nim_mahasiswa', $nim);
        }
        $query = $this->db->get();
        return $query;
    }

    public function editPenerimaBeasiswa($post)
    {
        $nim = $this->input->post('nim');
       
        $params['nama'] = $post['name'];
        $params['prodi'] = $post['prodi'];
        $params['fakultas'] = $post['fakultas'];
        $params['aktif'] = $post['is_active'];
        // $params['periode'] = $post['periode'];
        // $params['tahun'] = $post['tahun'];
        // $params['updated_at'] = date('Y-m-d H:i:s');
       
        $this->db->where('nim', $nim);
        $this->db->update('mahasiswa', $params);
    }

}

?>