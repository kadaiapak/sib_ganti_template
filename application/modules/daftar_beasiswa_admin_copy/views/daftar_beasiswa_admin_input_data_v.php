<div id="loading">Loading ...</div>
    <div class="main-content">
    <?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Base;

foreach($persyaratan as $ps) {
        if(form_error($ps['alias'])){ ?>
            <div id="errorFlash" data-flash="Upload semua file persyaratan yang dibutuhkan"></div>
        <?php   }
    } ?>
   
   <div id="errorFlash" data-flash="<?= $this->session->flashdata('error_upload'); ?>"></div>
   <section class="section">
       <div class="section-header">
           <div class="section-header-back">
               <a href="features-posts.html" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Proses Pendaftaran Beasiswa</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <p class="section-lead">
                Halaman pendaftaran, jangan sampai salah dalam mengisikan data dan upload berkas.
            </p>
            
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        
                        <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 text-center mt-3 mb-2">
                                        <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                            <h2 id="heading">Isi Data Yang Dibutuhkan</h2>
                                            <p>Pastikan semua data yang anda isi sesuai !</p>
                                            <form id="msform" action="<?= base_url('daftar-beasiswa-admin/input-data/').$id_beasiswa; ?>" method="post" enctype="multipart/form-data">
                                                <ul id="progressbar">
                                                    <li class="active" id="account"><strong>Biodata</strong></li>
                                                    <li id="personal"><strong>Upload Persyaratan</strong></li>
                                                </ul>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div> <br> 
                                                <fieldset>
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Biodata Pelamar:</h2>
                                                            </div>
                                                            <div class="col-5">
                                                                <h2 class="steps">Step 1 - 2</h2>
                                                            </div>
                                                        </div> 
                                                        <div class="form-group row mb-4">
                                                            <input type="hidden" name="status_kuliah" id="status_kuliah" value="<?= $cek_aktif; ?>">
                                                            <label for="nim" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Induk Mahasiswa (NIM) / Tahun Masuk</label>
                                                            <div class="col-sm-2 col-md-2">
                                                                <input readonly type="text" class="form-control" name='nim' id="nim" value="<?php echo set_value('nim', $mhs_api['nim']); ?>" >
                                                                <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-2 col-md-2">
                                                                <input readonly type="text" class="form-control" name='tm_msk' id="tm_msk" value="<?php echo set_value('tm_msk', $mhs_api['tm_msk']); ?>" >
                                                                <?= form_error('tm_msk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="nama_mahasiswa" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?php echo set_value('nama_mahasiswa', $mhs_api['nama']); ?>" >
                                                                <?= form_error('nama_mahasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="prodi" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prodi</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="prodi" id="prodi" value="<?php echo set_value('prodi', $mhs_api['nam_prodi']); ?>" >
                                                                <?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="fakultas" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fakultas</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="fakultas" id="fakultas" value="<?php echo set_value('fakultas', $mhs_api['nam_fak']); ?>" >
                                                                <?= form_error('fakultas', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="cek_aktif" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Perkuliahan</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <?= ($cek_aktif == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-success">Tidak Aktif</span>') ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="jjp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenjang Pendidikan</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="jjp" id="jjp" value="<?php echo set_value('jjp', $mhs_api['jjp']); ?>" >
                                                                <?= form_error('jjp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="ipk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IPK</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="ipk" id="ipk" value="<?php echo ($mhs_api['ipk'] ? set_value('ipk', $mhs_api['ipk']) : 'mahasiswa baru'); ?>" >
                                                                <?= form_error('ipk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="nohp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Hp</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="nohp" id="nohp" value="<?php echo set_value('nohp', $mhs_api['nohp']); ?>" >
                                                                <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="tmp_lhr" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat/tgl lahir</label>
                                                            <div class="col-sm-3 col-md-3">
                                                                <input readonly type="text" class="form-control" name="tmp_lhr" id="tmp_lhr" value="<?php echo set_value('tmp_lhr', $mhs_api['tmp_lhr']); ?>" >
                                                                <?= form_error('tmp_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-3 col-md-3">
                                                                <input readonly type="text" class="form-control" name="tgl_lhr" id="tgl_lhr" value="<?php echo set_value('tgl_lhr', $mhs_api['tgl_lhr']); ?>" >
                                                                <?= form_error('tgl_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="agama" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Agama</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="agama" id="agama" value="<?php echo set_value('agama', $mhs_api['agama']); ?>" >
                                                                <?= form_error('agama', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-4">
                                                            <label for="jk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="jk" id="jk" value="<?php echo set_value('jk', $mhs_api['jk']); ?>" >
                                                                <?= form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <input type="button" name="next" class="next action-button" value="Next" />
                                                </fieldset>
                                                <fieldset>
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Upload Persyaratan:</h2>
                                                            </div>
                                                            <div class="col-5">
                                                                <h2 class="steps">Step 2 - 2</h2>
                                                            </div>
                                                        </div> 
                                                            <?php foreach ($persyaratan as $p) { ?>
                                                            <div class="form-group row mb-4">
                                                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" ><?= $p['persyaratan']; ?> <?= $p['wajibpersyaratan'] == '1' ? '<a style="color: red;">(*)</a>' : ''?></label>
                                                                <div class="col-sm-12 col-md-7">
                                                                    <?php $alias = $p['alias']; ?>
                                                                    <input type="file" id="<?= $alias; ?>" name="<?= $alias; ?>"  class="form-control">
                                                                    <?= form_error("$alias", "<small class='text-danger pl-3'>", "</small>"); ?>
                                                                    <small>(Ukuran Maksimal <?= $p['ukuran_file_mb']; ?> atau <?= $p['ukuran_file']; ?>Kb / Tipe File <?= $p['tipe_file']; ?>)</small>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                            
                                                        </div> 
                                                    <small>Yang <a style="color: red;">(*)</a> = wajib di upload</small>
                                                    <button id="msbutton" type="submit" class="action-button"><i class="fas fa-folder-open mr-2"></i>Daftar</button>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>  
            </div>
        </section>
        <center><div id="loading"></div></center><br>
        <div id="result"></div>
</div>

<script>

    

  $(document).ready(function () {

  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;
  var current = 1;
  var steps = $("fieldset").length;

  setProgressBar(current);

  $(".next").click(function () {
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          next_fs.css({ opacity: opacity });
        },
        duration: 500,
      }
    );
    setProgressBar(++current);
  });

  $(".previous").click(function () {
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate(
      { opacity: 0 },
      {
        step: function (now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          previous_fs.css({ opacity: opacity });
        },
        duration: 500,
      }
    );
    setProgressBar(--current);
  });

  function setProgressBar(curStep) {
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar").css("width", percent + "%");
  }

$('#msform').submit(function (e) {
                    $('#msbutton').attr('disabled', 'disabled');
                    $('#loading').removeClass('load_animation');
                    $('#loading').addClass('load_animation');
  })

  $(".submit").click(function () {
    return false;
  });

});
</script>