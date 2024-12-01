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
                            <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-3 mb-2">
                                    <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                        <h2 id="heading">Isi Data Yang Dibutuhkan</h2>
                                        <p>Pastikan semua data yang anda isi sesuai !</p>
                                        <form id="msform" action="<?= base_url('daftar-beasiswa-admin/input-data/').$id_beasiswa; ?>" method="post" enctype="multipart/form-data">
                                            <ul id="progressbar">
                                                <li class="active" id="account"><strong>Biodata</strong></li>
                                                <li id="personal"><strong>Upload Persyaratan</strong></li>
                                            </ul>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div> <br> 
                                            <fieldset style="background-color: transparent;">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title"></h2>
                                                            </div>
                                                            <div class="col-5">
                                                                <h2 class="steps">Step 1 - 2</h2>
                                                            </div>
                                                        </div> 
                                                    <div class="form-card card card-warning p-3">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Biodata Pelamar:</h2>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 0;">
                                                            <input type="hidden" name="status_kuliah" id="status_kuliah" value="<?= $cek_aktif; ?>">
                                                            <label for="nim" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Induk Mahasiswa (NIM) / Tahun Masuk</label>
                                                            <div class="col-sm-2 col-md-2">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name='nim' id="nim" value="<?php echo set_value('nim', $mhs_api['nim']); ?>" >
                                                                <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-2 col-md-2">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name='tm_msk' id="tm_msk" value="<?php echo set_value('tm_msk', $mhs_api['tm_msk']); ?>" >
                                                                <?= form_error('tm_msk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nama_mahasiswa" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?php echo set_value('nama_mahasiswa', $mhs_api['nama']); ?>" >
                                                                <?= form_error('nama_mahasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="prodi" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prodi</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="prodi" id="prodi" value="<?php echo set_value('prodi', $mhs_api['nam_prodi']); ?>" >
                                                                <?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="fakultas" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fakultas</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="fakultas" id="fakultas" value="<?php echo set_value('fakultas', $mhs_api['nam_fak']); ?>" >
                                                                <?= form_error('fakultas', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="cek_aktif" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Perkuliahan</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <?= ($cek_aktif == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-success">Tidak Aktif</span>') ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jjp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenjang Pendidikan</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly type="text" class="form-control" name="jjp" id="jjp" value="<?php echo set_value('jjp', $mhs_api['jjp']); ?>" style="margin-bottom: 0;">
                                                                <?= form_error('jjp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="ipk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IPK</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="ipk" id="ipk" value="<?php echo ($mhs_api['ipk'] ? set_value('ipk', $mhs_api['ipk']) : 'mahasiswa baru'); ?>" >
                                                                <?= form_error('ipk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nohp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Hp</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="nohp" id="nohp" value="<?php echo set_value('nohp', $mhs_api['nohp']); ?>" >
                                                                <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tmp_lhr" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat/tgl lahir</label>
                                                            <div class="col-sm-3 col-md-3">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="tmp_lhr" id="tmp_lhr" value="<?php echo set_value('tmp_lhr', $mhs_api['tmp_lhr']); ?>" >
                                                                <?= form_error('tmp_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-3 col-md-3">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="tgl_lhr" id="tgl_lhr" value="<?php echo set_value('tgl_lhr', $mhs_api['tgl_lhr']); ?>" >
                                                                <?= form_error('tgl_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="agama" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Agama</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="agama" id="agama" value="<?php echo set_value('agama', $mhs_api['agama']); ?>" >
                                                                <?= form_error('agama', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                                                            <div class="col-sm-12 col-md-7">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="jk" id="jk" value="<?php echo set_value('jk', $mhs_api['jk']); ?>" >
                                                                <?= form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <?php if($data_keluarga == 1) { ?>
                                                    <div class="card card-warning p-3 text-center">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Biodata Orang Tua:</h2>
                                                            </div>
                                                        </div>
                                                        <h3 class="fs-title" style="font-size: 17px;">Biodata Ayah :</h3>
                                                        
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nama_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Ayah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <input type="text" class="form-control <?= form_error('nama_ayah') ? 'is-invalid' : (set_value('nama_ayah') ? 'is-valid' : null) ; ?>" name="nama_ayah" id="nama_ayah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('nama_ayah'); ?>">
                                                                <?= form_error('nama_ayah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="status_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Ayah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('status_ayah') ? 'is-invalid' : null; ?>" name="status_ayah" id="status_ayah">
                                                                    <option value="" selected>Pilih Status Ayah</option>
                                                                    <option value="masih_hidup" <?= "masih_hidup" == set_value('status_ayah') ? "selected" : null; ?>>Masih Hidup</option>
                                                                    <option value="almarhum" <?= "almarhum" == set_value('status_ayah') ? "selected" : null; ?>>Almarhum</option>
                                                                    <option value="cerai" <?= "cerai" == set_value('status_ayah') ? "selected" : null; ?>>Cerai</option>
                                                                </select>
                                                                <?= form_error('status_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="pendidikan_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pendidikan Terakhir</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('pendidikan_ayah') ? 'is-invalid' : null; ?>" name="pendidikan_ayah" id="pendidikan_ayah">
                                                                    <option value="" selected>Pilih Pendidikan Ayah</option>
                                                                    <option value="sd_sederajat" <?= "sd_sederajat" == set_value('pendidikan_ayah') ? "selected" : null; ?>>SD / Sederajat</option>
                                                                    <option value="smp_sederajat" <?= "smp_sederajat" == set_value('pendidikan_ayah') ? "selected" : null; ?>>SMP / Sederajat</option>
                                                                    <option value="sma_sederajat" <?= "sma_sederajat" == set_value('pendidikan_ayah') ? "selected" : null; ?>>SMA / Sederajat</option>
                                                                    <option value="d1_d4" <?= "d1_d4" == set_value('pendidikan_ayah') ? "selected" : null; ?>>D1/D2/D3/D4</option>
                                                                    <option value="s1" <?= "s1" == set_value('pendidikan_ayah') ? "selected" : null; ?>>S1</option>
                                                                    <option value="s2" <?= "s2" == set_value('pendidikan_ayah') ? "selected" : null; ?>>S2</option>
                                                                </select>
                                                                <?= form_error('pendidikan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="pekerjaan_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pekerjaan Ayah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('pekerjaan_ayah') ? 'is-invalid' : null; ?>" name="pekerjaan_ayah" id="pekerjaan_ayah">
                                                                    <option value="" selected>Pilih Jenis Pekerjaan Ayah</option>
                                                                    <?php foreach ($pekerjaan_ayah as $pa) :?>
                                                                        <option value="<?= $pa['id']; ?>" <?= $pa['id'] == set_value('pekerjaan_ayah') ? "selected" : null; ?>><?= $pa['nama_pekerjaan']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <?= form_error('pekerjaan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="rincian_pekerjaan_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rincian Pekerjaan Ayah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <textarea name="" id="" cols="30" rows="10" style="margin-bottom: 0; background-color: white;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="penghasilan_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rata - Rata Penghasilan Ayah / Bulan</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('penghasilan_ayah') ? 'is-invalid' : null; ?>" name="penghasilan_ayah" id="penghasilan_ayah">
                                                                    <option value="" selected>Pilih Rata - Rata</option>
                                                                    <option value="sd_sederajat" <?= "sd_sederajat" == set_value('penghasilan_ayah') ? "selected" : null;?>>0- Rp 500.000</option>
                                                                    <option value="smp_sederajat" <?= "smp_sederajat" == set_value('penghasilan_ayah') ? "selected" : null;?>>Rp 500.000 - Rp 1.000.000</option>
                                                                    <option value="sma_sederajat" <?= "sma_sederajat" == set_value('penghasilan_ayah') ? "selected" : null;?>>Rp 1.000.000 - Rp 1.500.000</option>
                                                                    <option value="d1_d4" <?= "d1_d4" == set_value('penghasilan_ayah') ? "selected" : null; ?>>Rp 1.500.000 - Rp 2.000.000</option>
                                                                    <option value="s1" <?= "s1" == set_value('penghasilan_ayah') ? "selected" : null; ?>>Rp 2.000.000 - Rp 3.000.000</option>
                                                                    <option value="s2" <?= "s2" == set_value('penghasilan_ayah') ? "selected" : null; ?>>> Rp 3.000.000</option>
                                                                </select>
                                                                <?= form_error('penghasilan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="kontak_ayah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Hp</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <input type="text" class="form-control <?= form_error('kontak_ayah') ? 'is-invalid' : (set_value('kontak_ayah') ? 'is-valid' : null) ; ?>" name="kontak_ayah" id="kontak_ayah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('kontak_ayah'); ?>">
                                                                <?= form_error('kontak_ayah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <h3 class="fs-title" style="font-size: 17px;">Biodata Ibu :</h3>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nama_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Ibu</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <input type="text" class="form-control <?= form_error('nama_ibu') ? 'is-invalid' : (set_value('nama_ibu') ? 'is-valid' : null) ; ?>" name="nama_ibu" id="nama_ibu" style="margin-bottom: 0; background-color: white;" value="<?= set_value('nama_ibu'); ?>">
                                                                <?= form_error('nama_ibu', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="status_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Ibu</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('status_ibu') ? 'is-invalid' : null; ?>" name="status_ibu" id="status_ibu">
                                                                    <option value="" selected>Pilih Status Ibu</option>
                                                                    <option value="masih_hidup" <?= "masih_hidup" == set_value('status_ibu') ? "selected" : null; ?>>Masih Hidup</option>
                                                                    <option value="almarhum" <?= "almarhum" == set_value('status_ibu') ? "selected" : null; ?>>Almarhum</option>
                                                                    <option value="cerai" <?= "cerai" == set_value('status_ibu') ? "selected" : null; ?>>Cerai</option>
                                                                </select>
                                                                <?= form_error('status_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="pendidikan_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pendidikan Terakhir</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('pendidikan_ibu') ? 'is-invalid' : null; ?>" name="pendidikan_ibu" id="pendidikan_ibu">
                                                                    <option value="" selected>Pilih Pendidikan Ayah</option>
                                                                    <option value="sd_sederajat" <?= "sd_sederajat" == set_value('pendidikan_ibu') ? "selected" : null; ?>>SD / Sederajat</option>
                                                                    <option value="smp_sederajat" <?= "smp_sederajat" == set_value('pendidikan_ibu') ? "selected" : null; ?>>SMP / Sederajat</option>
                                                                    <option value="sma_sederajat" <?= "sma_sederajat" == set_value('pendidikan_ibu') ? "selected" : null; ?>>SMA / Sederajat</option>
                                                                    <option value="d1_d4" <?= "d1_d4" == set_value('pendidikan_ibu') ? "selected" : null; ?>>D1/D2/D3/D4</option>
                                                                    <option value="s1" <?= "s1" == set_value('pendidikan_ibu') ? "selected" : null; ?>>S1</option>
                                                                    <option value="s2" <?= "s2" == set_value('pendidikan_ibu') ? "selected" : null; ?>>S2</option>
                                                                </select>
                                                                <?= form_error('pendidikan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="pekerjaan_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pekerjaan Ibu</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('pekerjaan_ibu') ? 'is-invalid' : null; ?>" name="pekerjaan_ibu" id="pekerjaan_ibu">
                                                                    <option value="" selected>Pilih Jenis Pekerjaan Ayah</option>
                                                                    <?php foreach ($pekerjaan_ayah as $pa) :?>
                                                                        <option value="<?= $pa['id']; ?>" <?= $pa['id'] == set_value('pekerjaan_ibu') ? "selected" : null; ?>><?= $pa['nama_pekerjaan']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <?= form_error('pekerjaan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="rincian_pekerjaan_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rincian Pekerjaan Ibu</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <textarea name="" id="" cols="30" rows="10" style="margin-bottom: 0; background-color: white;"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="penghasilan_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rata - Rata Penghasilan Ibu / Bulan</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('penghasilan_ibu') ? 'is-invalid' : null; ?>" name="penghasilan_ibu" id="penghasilan_ibu">
                                                                    <option value="" selected>Pilih Rata - Rata</option>
                                                                    <option value="sd_sederajat" <?= "sd_sederajat" == set_value('penghasilan_ibu') ? "selected" : null;?>>0- Rp 500.000</option>
                                                                    <option value="smp_sederajat" <?= "smp_sederajat" == set_value('penghasilan_ibu') ? "selected" : null;?>>Rp 500.000 - Rp 1.000.000</option>
                                                                    <option value="sma_sederajat" <?= "sma_sederajat" == set_value('penghasilan_ibu') ? "selected" : null;?>>Rp 1.000.000 - Rp 1.500.000</option>
                                                                    <option value="d1_d4" <?= "d1_d4" == set_value('penghasilan_ibu') ? "selected" : null; ?>>Rp 1.500.000 - Rp 2.000.000</option>
                                                                    <option value="s1" <?= "s1" == set_value('penghasilan_ibu') ? "selected" : null; ?>>Rp 2.000.000 - Rp 3.000.000</option>
                                                                    <option value="s2" <?= "s2" == set_value('penghasilan_ibu') ? "selected" : null; ?>>> Rp 3.000.000</option>
                                                                </select>
                                                                <?= form_error('penghasilan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="kontak_ibu" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Hp</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <input type="text" class="form-control <?= form_error('kontak_ibu') ? 'is-invalid' : (set_value('kontak_ibu') ? 'is-valid' : null) ; ?>" name="kontak_ibu" id="kontak_ibu" style="margin-bottom: 0; background-color: white;" value="<?= set_value('kontak_ibu'); ?>">
                                                                <?= form_error('kontak_ibu', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card card-warning p-3 text-center">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Data Pendukung:</h2>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="status_rumah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Kepemilikan Rumah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('status_rumah') ? 'is-invalid' : null; ?>" name="status_rumah" id="status_rumah">
                                                                    <option value="" selected>Pilih Status</option>
                                                                    <option value="milik_sendiri" <?= "milik_sendiri" == set_value('status_rumah') ? "selected" : null; ?>>Milik Sendiri</option>
                                                                    <option value="menyewa" <?= "menyewa" == set_value('status_rumah') ? "selected" : null; ?>>Menyewa</option>
                                                                </select>
                                                                <?= form_error('status_rumah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tahun_rumah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tahun Perolehan</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <input type="number" placeholder="2010" class="form-control <?= form_error('tahun_rumah') ? 'is-invalid' : (set_value('tahun_rumah') ? 'is-valid' : null) ; ?>" name="tahun_rumah" id="tahun_rumah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('tahun_rumah'); ?>">
                                                                <?= form_error('tahun_rumah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="luas_tanah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas Tanah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('luas_tanah') ? 'is-invalid' : null; ?>" name="luas_tanah" id="luas_tanah">
                                                                    <option value="" selected>Pilih Luas Tanah</option>
                                                                    <option value="25-50m2" <?= "25-50m2" == set_value('luas_tanah') ? "selected" : null; ?>>25-50m2</option>
                                                                    <option value="50-100m2" <?= "50-100m2" == set_value('luas_tanah') ? "selected" : null; ?>>50-100m2</option>
                                                                    <option value="100-200m2" <?= "100-200m2" == set_value('luas_tanah') ? "selected" : null; ?>>100-200m2</option>
                                                                    <option value=">200m2" <?= ">200m2" == set_value('luas_tanah') ? "selected" : null; ?>>> 200m2</option>
                                                                </select>
                                                                <?= form_error('luas_tanah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="luas_rumah" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas Rumah</label>
                                                            <div class="col-sm-5 col-md-5">
                                                                <select class="form-control <?= form_error('luas_rumah') ? 'is-invalid' : null; ?>" name="luas_rumah" id="luas_rumah">
                                                                    <option value="" selected>Pilih Luas Rumah</option>
                                                                    <option value="25-50m2" <?= "25-50m2" == set_value('luas_rumah') ? "selected" : null; ?>>25-50m2</option>
                                                                    <option value="50-100m2" <?= "50-100m2" == set_value('luas_rumah') ? "selected" : null; ?>>50-100m2</option>
                                                                    <option value="100-200m2" <?= "100-200m2" == set_value('luas_rumah') ? "selected" : null; ?>>100-200m2</option>
                                                                    <option value=">200m2" <?= ">200m2" == set_value('luas_rumah') ? "selected" : null; ?>>> 200m2</option>
                                                                </select>
                                                                <?= form_error('luas_rumah', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                            </div>
                                                    <?php } ?>

                                                    <input type="button" name="next" class="next action-button" value="Next" />
                                            </fieldset>
                                            <fieldset style="background-color: transparent;">
                                                <div class="form-card">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title"></h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <h2 class="steps">Step 2 - 2</h2>
                                                        </div>
                                                    </div> 
                                                    <div class="card card-warning p-3">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Upload Persyaratan:</h2>
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