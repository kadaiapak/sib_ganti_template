<?php

    // @desc    -digunakan untuk cek paakah user tersebut sudah login, jika belum maka akan di redirect ke auth
    // @used by
    //  - setiap method
    function is_logged_in()
    {
        $ci = get_instance();
        if(!$ci->session->userdata('username')){
            redirect('auth','refresh');
        }
    }

    // @desc    -digunakan untuk membuat form check input pada akses di ceklis
    // @used by
    //  - views 'konfigurasi/menu_sistem/role-access_v.php

    function persyaratan_beasiswa($id_master, $id_persyaratan)
    {
        $ci = get_instance();
        $ci->db->where('master_beasiswa', $id_master);
        $ci->db->where('persyaratan', $id_persyaratan);
        $result = $ci->db->get('master_beasiswa_persyaratan');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    function persyaratan_beasiswa_wajib($id_master, $id_persyaratan)
    {
        $ci = get_instance();
        $ci->db->where('master_beasiswa', $id_master);
        $ci->db->where('persyaratan', $id_persyaratan);
        $ci->db->where('wajib', '1');
        $result = $ci->db->get('master_beasiswa_persyaratan');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    function check_access($role_id, $menu_id)
    {
        $ci = get_instance();
        $ci->db->where('level_user', $role_id);
        $ci->db->where('kode_menu', $menu_id);
        $result = $ci->db->get('akses');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    // @desc    -digunakan untuk membuat form check input pada tambah di ceklis
    // @used by
    //  - views 'konfigurasi/menu_sistem/role-access_v.php
    function check_tambah($role_id, $menu_id)
    {
        $ci = get_instance();
        $ci->db->where('level_user', $role_id);
        $ci->db->where('kode_menu', $menu_id);
        $ci->db->where('tambah', '1');
        $result = $ci->db->get('akses');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    // @desc    -digunakan untuk membuat form check input pada edit di ceklis
    // @used by
    //  - views 'konfigurasi/menu_sistem/role-access_v.php
    function check_edit($role_id, $menu_id)
    {
        $ci = get_instance();
        $ci->db->where('level_user', $role_id);
        $ci->db->where('kode_menu', $menu_id);
        $ci->db->where('edit', '1');
        $result = $ci->db->get('akses');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    // @desc    -digunakan untuk membuat form check input pada hapus di ceklis
    // @used by
    //  - views 'konfigurasi/menu_sistem/role-access_v.php
    function check_hapus($role_id, $menu_id)
    {
        $ci = get_instance();
        $ci->db->where('level_user', $role_id);
        $ci->db->where('kode_menu', $menu_id);
        $ci->db->where('hapus', '1');
        $result = $ci->db->get('akses');
        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }

    // @desc    -digunakan untuk memanggil main menu
    // @used by
    //  - setiap controller
    function main_menu($id)
    {
        $ci = get_instance();
        $main_menu = $ci->db->select('m.*, a.akses,a.tambah,a.edit,a.hapus')
        ->from('menu m')
        ->join('akses a', 'a.kode_menu = m.kode_menu', 'left')
        ->join('pemisah_menu', 'm.pemisah = pemisah_menu.id', 'left')
        ->where(['a.level_user' => $ci->session->role_id, 'm.aktif' => '1','show' => '1', 'level' => 'main_menu', 'm.pemisah' => $id] )
        ->order_by('m.no_urut', 'ASC')
        ->get()->result_array();

        return $main_menu;
    }

    // @desc    -digunakan untuk memanggil sub menu
    // @used by
    //  - setiap controller
    function sub_menu()
    {
        $ci = get_instance();

        $sub_menu = $ci->db->select('m.*, a.akses, a.tambah, a.edit, a.hapus')
        ->from('menu m')
        ->join('akses a','a.kode_menu = m.kode_menu', 'left')
        ->where(['a.level_user' => $ci->session->role_id, 'm.aktif' => '1','show' => '1', 'level' => 'sub_menu'])
        ->order_by('m.no_urut', 'ASC')
        ->get()->result_array();

        return $sub_menu;
    }

    // @desc    -digunakan untuk memanggil single
    // @used by
    //  - setiap controller
    function single_menu($id)
    {
        $ci = get_instance();

        $single_menu = $ci->db->select('m.*, a.akses, a.tambah, a.edit, a.hapus')
        ->from('menu m')
        ->join('akses a','a.kode_menu = m.kode_menu', 'left')
        ->join('pemisah_menu', 'm.pemisah = pemisah_menu.id', 'left')
        ->where(['a.level_user' => $ci->session->role_id, 'm.aktif' => '1','show' => '1', 'level' => 'single_menu', 'm.pemisah' => $id])
        ->order_by('m.no_urut', 'ASC')
        ->get()->result_array();

        return $single_menu;
    }

    function pemisahMenu()
    {
        $ci = get_instance();
        $pemisah_menu = $ci->db->get('pemisah_menu')->result_array();
        return $pemisah_menu;
    }

    // @desc    -digunakan untuk melihat keaktifan mahasiswa berdasarkan tahun dan semester
    // @used by
    //  - controller mahasiswa/detail
    function checkSemester()
    {
        $tahun = date('Y');
        $bulan = date('m');

        if($bulan <= 6)
        {
            $semester = 2;
        }else {
            $semester = 1;
        }
        return $tahun.''.$semester;
    }

    // @desc    -digunakan untuk memanggil semua list main menu untuk menambahkan sub menu pada main menu tersebut
    // @used by
    //  - controller konfigurasi/Menu_sistem/tambah
    //  - controller konfigurasi/Menu_sistem/edit
    function mainMenuUntukTambahMenu()
    {
        $ci = get_instance();

        $tambahMenu = $ci->db->get_where('menu', ['level' => 'main_menu'])->result_array();
        return $tambahMenu;
    }

    // @desc    -digunakan untuk cek hak akses user yang diambil dari uri segment
    // @used by
    //  - setiap controller
    if (!function_exists('cek_akses_user'))
    {
        function cek_akses_user(){
            $ci = get_instance();
            $coba = $ci->uri->segment('1');
            $cek_level_menu = $ci->db->select('level')->from('menu')->where('url', $coba)->get()->row()->level;
            if($cek_level_menu == 'single_menu'){
                $array_b = [
                        'a.level_user' => $ci->session->userdata('role_id'),
                        'm.level' => 'single_menu',
                        'm.url' => $ci->uri->segment(1)
                    ];
                    $cek = $ci->db->select('*')->from('akses a')
                    ->join('menu m','m.kode_menu = a.kode_menu', 'left')
                    ->where($array_b)
                    ->get()->row_array() ;
            }else {
                 $array_a = [
                         'a.level_user' => $ci->session->userdata('role_id'),
                         'm.level' => 'sub_menu',
                         'm.url' => $ci->uri->segment(1,0).$ci->uri->slash_segment(2,'leading')
                    ];
                    $cek = $ci->db->select('*')->from('akses a')
                    ->join('menu m','m.kode_menu = a.kode_menu', 'left')
                    ->where($array_a)
                    ->get()->row_array() ;
            }
            // return $cek;
            if(!$cek){
                redirect('auth/blocked');
            }else {
                if($cek['akses'] != '1'){
                    redirect(base_url('auth/blocked'));
                    }else {
                        return $cek;
                    }
            }

        }
    }

?>
