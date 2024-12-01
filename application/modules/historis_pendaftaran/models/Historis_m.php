<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// @used by
//  controller 'historis_pendaftaran/index

class Historis_m extends CI_Model
{
    public function getHistoris($nim)
    {
        $this->db->select('hb.status_beasiswa, hb.tanggal, hb.keterangan, 
        nb.nama_beasiswa as nb_nama_beasiswa, 
        p.nama as p_nama, 
        mb.tahun as mb_tahun');
        $this->db->from('historis_beasiswa hb');
        $this->db->join('master_beasiswa mb', 'hb.id_beasiswa = mb.id');
        $this->db->join('nama_beasiswa nb', 'mb.nama_beasiswa = nb.id');
        $this->db->join('periode p', 'mb.periode = p.id');
        $this->db->where('nim', $nim);
        $query = $this->db->get();
        return $query;
    }
}

?>