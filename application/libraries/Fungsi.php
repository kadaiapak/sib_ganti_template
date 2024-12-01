<?php
    Class Fungsi {
        protected $ci;

        function __construct()
        {
            $this->ci =& get_instance();
        }

        // @desc -menampilkan data yang user yang sedang login pada view topbar
        // @used by
        // - model 'konfigurasi/Akses_m/tambahMenu'
        // - view 'template/topbar'
        function  user_login()
        {
            $this->ci->load->model('auth/Auth_m', 'auth');
            $userid = $this->ci->session->userdata('userid');
            $user_data = $this->ci->auth->get($userid)->row();
            return $user_data;
        }

        // @desc -menampilkan total user
        // @used by
        // - view 'statistik'
        function count_user()
        {
            $this->ci->load->model('user/User_m','user');
            $query = $this->ci->user->countAllUsersPagination();
            return $query;
        }

        // @desc -menampilkan total beasiswa
        // @used by
        // - view 'statistik'
        function count_masterBeasiswa()
        {
            $this->ci->load->model('mbeasiswa/Beasiswa_m','beasiswa');
            $query = $this->ci->beasiswa->getMasterBeasiswa()->num_rows();
            return $query;

        }

        // @desc -menampilkan total penerima beasiswa
        // @used by
        // - view 'statistik'
        function count_totalPenerima()
        {
            $this->ci->load->model('mbeasiswa/Beasiswa_m','beasiswa');
            $query = $this->ci->beasiswa->getTotalPenerima();
            return $query;
        }

        // @desc -menampilkan total prodi penerima
        // @used by
        // - view 'statistik'
        function count_totalProdi()
        {
            $this->ci->load->model('mbeasiswa/Beasiswa_m','beasiswa');
            $query = $this->ci->beasiswa->getProdi()->result();
            return $query;
        }
    }

?>
