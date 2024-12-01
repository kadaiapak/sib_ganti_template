    <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2021 <div class="bullet"></div> BAK Universitas Negeri Padang</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <script src="<?= base_url(); ?>template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

  <script src="<?= base_url(); ?>template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> -->

  <!-- JS Libraies -->
  <script src="<?= base_url('template'); ?>/node_modules/sweetalert/dist/sweetalert.min.js"></script>

  <script src="<?=base_url('template/');?>assets/js/stisla.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

  <!-- JS Libraies -->
  <script src="<?=base_url('template/');?>node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('template/');?>node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url('template/');?>node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>

  <!-- Template JS File -->
  <script src="<?=base_url('template/');?>assets/js/scripts.js"></script>
  <script src="<?=base_url('template/');?>assets/js/custom.js"></script>

  <!-- untuk modal -->
  <!-- <script src="<?=base_url('template/');?>node_modules/prismjs/prism.js"></script> -->
  <script src="<?=base_url('template/');?>assets/js/page/bootstrap-modal.js"></script>

  <!-- Page Specific JS File -->
  <!-- Sweet Alert -->
  <script src="<?= base_url('template'); ?>/assets/js/page/modules-sweetalert.js"></script>
  <!-- datepicker -->
  <script src="<?=base_url('template/');?>node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- js saya -->
  <script src="<?= base_url('template'); ?>/assets/js/myscript.js"></script>
  <!-- akhir js saya -->
  <script>

$(document).on('click','#buttonUpdateAkun',  function(e) {
  e.preventDefault();
  swal({
    title: "Yakin diubah ?",
    text: "Yakin mengubah data akun ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#formUpdateAkun').submit();
    } else {
      swal("Akun tidak jadi diubah");
    }
  });
})

$(document).on("click", "#buttonUbahPassword", function (e) {
  e.preventDefault();
  swal({
    title: "Yakin diubah ?",
    text: "Password tidak boleh lupa",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $("#formUbahPassword").submit();
    } else {
      swal("Password tidak jadi diganti");
    }
  });
});

$(document).on('click','#deleteButton',  function(e) {
  e.preventDefault();
  swal({
    title: "Yakin dihapus?",
    text: "Ketika dihapus, data tersebut tidak akan kembali!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteForm').submit();
    } else {
      swal("Data tidak jadi dihapus!");
    }
  });
})

$(document).on('click','#deleteButtonDetailMahasiswaBeasiswa',  function(e) {
  e.preventDefault();
  swal({
    title: "Yakin dihapus?",
    text: "Ketika dihapus, data tersebut tidak akan kembali!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormDetailMahasiswaBeasiswa').submit();
    } else {
      swal("Data tidak jadi dihapus!");
    }
  });
})

$(document).on('click','#deleteButtonTetapkanBeasiswa',  function(e) {
  e.preventDefault();
  swal({
    title: "Tetapkan Mahasiswa ini menjadi penerima beasiswa?",
    text: "penetapan status mahasiswa menjadi penerima beasiswa",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormBatalkanTetapkanBeasiswa').submit();
    } else {
      swal("Proses penetapan beasiswa dibatalkan");
    }
  });
})

$(document).on('click','#deleteButtonUser',  function(e) {
  e.preventDefault();
  swal({
    title: "Hapus data User?",
    text: "Hapus Data user",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormUser').submit();
    } else {
      swal("Proses hapus data dibatalkan");
    }
  });
})


$(document).on('click','#deleteButtonBatalkanBeasiswa',  function(e) {
  e.preventDefault();
  swal({
    title: "Batalkan Penerimaan Beasiswa Mahasiswa ini?",
    text: "proses memberhentikan mahasiswa dari penerimaan beasiswa",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormBatalkanTetapkanBeasiswa').submit();
    } else {
      swal("Proses pemutusan dibatalkan");
    }
  });
})

$(document).on('click','#deleteButtonTetapkanDaftar',  function(e) {
  e.preventDefault();
  swal({
    title: "Tetapkan Mahasiswa ini menjadi penerima ?",
    text: "penetapan status mahasiswa menjadi penerima ",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormBatalkanTetapkanDaftar').submit();
    } else {
      swal("Proses penetapan beasiswa dibatalkan");
    }
  });
})

$(document).on('click','#deleteButtonBatalkanDaftar',  function(e) {
  e.preventDefault();
  swal({
    title: "Batalkan Penerimaan Daftar Mahasiswa ini?",
    text: "proses memberhentikan mahasiswa dari penerimaan Daftar",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormBatalkanTetapkanDaftar').submit();
    } else {
      swal("Proses penetapan dibatalkan");
    }
  });
})

//
$(document).on('click','#deleteButtonTetapkanCalon',  function(e) {
  e.preventDefault();
  swal({
    title: "Validasi Mahasiswa ini menjadi calon penerima ?",
    text: "validasi mahasiswa menjadi calon penerima ",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormTetapkanCalon').submit();
    } else {
      swal("Proses dibatalkan");
    }
  });
})

$(document).on('click','#deleteButtonBatalkanCalon',  function(e) {
  e.preventDefault();
  swal({
    title: "Batalkan Pencalonan Mahasiswa ini?",
    text: "proses membatalan validasi mahasiswa dari calon penerima beasiswa",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#deleteFormBatalkanCalon').submit();
    } else {
      swal("Proses dibatalkan");
    }
  });
})

// $(document).on('click','#deleteButtonMasterBeasiswa',  function(e) {
//   e.preventDefault();
//   swal({
//     title: "Hapus Master Beasiswa ini?",
//     text: "setelah dihapus, data tidak bisa dikembalikan lagi",
//     icon: "warning",
//     buttons: true,
//     dangerMode: true,
//   }).then((willDelete) => {
//     if (willDelete) {
//       $('#deleteFormMasterBeasiswa').submit();
//     } else {
//       swal("hapus data dibatalkan");
//     }
//   });
// })

$('.deleteButtonMasterBeasiswa').on('click', function(e) {
  e.preventDefault();
  const href = $(this).attr('href');
  swal({
    title: "Hapus Master Beasiswa yang ini ?",
    text: "setelah dihapus, data tidak bisa dikembalikan lagi",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
        document.location.href = href;
    }
  });
})

$(document).on('click','#msbutton',  function(e) {
  e.preventDefault();
  swal({
    title: "Yakin semuda data sudah benar ?",
    text: "anda tidak bisa mengubah data yang sudah di upload",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $('#msform').submit();
    } else {
      swal("pendaftaran beasiswa dibatalkan");
    }
  });
})

$(".akses").on("click", function () {
  const menuId = $(this).data("menu");
  const roleId = $(this).data("role");

  $.ajax({
    url: "<?= base_url('konfigurasi/akses/changeaccess'); ?>",
    type: "post",
    data: {
      menuId: menuId,
      roleId: roleId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('konfigurasi/akses/roleaccess/'); ?>" + roleId;
    },
  });
});

$(".tambah").on("click", function () {
  const menuId = $(this).data("menu");
  const roleId = $(this).data("role");

  $.ajax({
    url: "<?= base_url('konfigurasi/akses/changetambah'); ?>",
    type: "post",
    data: {
      menuId: menuId,
      roleId: roleId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('konfigurasi/akses/roleaccess/'); ?>" + roleId;
    },
  });
});

$(".edit").on("click", function () {
  const menuId = $(this).data("menu");
  const roleId = $(this).data("role");

  $.ajax({
    url: "<?= base_url('konfigurasi/akses/changeedit'); ?>",
    type: "post",
    data: {
      menuId: menuId,
      roleId: roleId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('konfigurasi/akses/roleaccess/'); ?>" + roleId;
    },
  });
});

$(".hapus").on("click", function () {
  const menuId = $(this).data("menu");
  const roleId = $(this).data("role");

  $.ajax({
    url: "<?= base_url('konfigurasi/akses/changehapus'); ?>",
    type: "post",
    data: {
      menuId: menuId,
      roleId: roleId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('konfigurasi/akses/roleaccess/'); ?>" + roleId;
    },
  });
});

$(".persyaratan").on("click", function () {
  const beasiswaId = $(this).data("beasiswa");
  const persyaratanId = $(this).data("persyaratan");

  $.ajax({
    url: "<?= base_url('mpersyaratan/setup-persyaratan/tambahpersyaratan'); ?>",
    type: "post",
    data: {
      beasiswaId: beasiswaId,
      persyaratanId: persyaratanId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('mpersyaratan/setup-persyaratan/edit/'); ?>" + beasiswaId;
    },
  });
});

$(".persyaratanWajib").on("click", function () {
  const beasiswaId = $(this).data("beasiswa");
  const persyaratanId = $(this).data("persyaratan");

  $.ajax({
    url: "<?= base_url('mpersyaratan/setup-persyaratan/tambahpersyaratanWajib'); ?>",
    type: "post",
    data: {
      beasiswaId: beasiswaId,
      persyaratanId: persyaratanId,
    },
    success: function () {
      document.location.href =
        "<?= base_url('mpersyaratan/setup-persyaratan/edit/'); ?>" + beasiswaId;
    },
  });
});
  </script>
</body>
</html>
