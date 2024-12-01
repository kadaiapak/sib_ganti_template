<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mhs_m extends CI_Model
{
     // var $column_order = array(null, 'nim_mahasiswa', 'nama_mahasiswa','mahasiswa_beasiswa.status_beasiswa','bukti_pembayaran_pribadi',null); //set column field database for datatable orderable
    // var $column_search = array('mahasiswa_beasiswa.nim_mahasiswa', 'mahasiswa.nama'); //set column field database for datatable searchable
    // var $order = array('nim_mahasiswa' => 'desc'); // default order 
    var $column_order = array(null, 
                                'nim_mahasiswa', 
                                'nama_mahasiswa',
                                'prodi',
                                'fakultas',
                                'status_beasiswa',
                                null); //set column field database for datatable orderable
    var $column_search = array('nim_mahasiswa', 'nama_mahasiswa'); //set column field database for datatable searchable
    var $order = array('nim_mahasiswa' => 'asc'); // default order 


    // @desc -memanggil semua data dari tabel mahasiswa beasiswa yang dijoin dengan tabel lain yang nantiknya
    //        akan digunakan untuk menampilkan list mahasiswa penerima beasiswa di data table detail_beasiswa
    // @used by
    // - controller 'data_beasiswa/Beasiswa/get_ajax'
    function get_datatables() 
    {
        $this->_get_datatables_query();
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from('mahasiswa_beasiswa');
        $this->db->where('status_beasiswa', '3');
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
    public function getPenerimaBeasiswa($id = null)
    {
        $this->db->select('m.nim_mahasiswa as m_nim, m.nama_mahasiswa as m_nama, m.prodi as m_prodi, m.fakultas as m_fakultas');
        $this->db->from('mahasiswa_beasiswa m');
        $this->db->where('m.nim_mahasiswa', $id);
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