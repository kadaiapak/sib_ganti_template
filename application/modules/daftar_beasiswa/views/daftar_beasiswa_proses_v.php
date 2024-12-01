<div id="loading">Loading ...</div>

<div class="main-content">
    <?php foreach($persyaratan as $ps) {
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
                                    <p style="color: red;">Jika ada permasalahan dalam proses penggunaan aplikasi, bisa email ke : callcenter.kemahasiswaan@unp.ac.id</p>
                                    <p style="color: red;">atau Whatsapp ke nomor : 0822 3208 8983</p>
                                    <form id="msform" action="<?= base_url('daftar-beasiswa/daftar/').$id_beasiswa; ?>" method="post" enctype="multipart/form-data">
                                        <ul id="progressbar">
                                            <li class="active" id="account"><strong>Biodata</strong></li>
                                            <li id="personal"><strong>Upload Persyaratan</strong></li>
                                        </ul>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <br>
                                        <fieldset style="background-color: transparent;">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="fs-title"></h2>
                                                </div>
                                                <div class="col-5">
                                                    <h2 class="steps">Step 1 - 2</h2>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-card card card-warning p-3">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Biodata Pelamar:</h2>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <input type="hidden" name="status_kuliah" id="status_kuliah" value="<?= $cek_aktif; ?>">
                                                            <input type="hidden" name="no_rekening" id="no_rekening" value="<?= $no_rekening; ?>">
                                                            <input type="hidden" name="data_keluarga" id="data_keluarga" value="<?= $data_keluarga; ?>">
                                                            <label for="nim" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIM / Tahun Masuk</label>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name='nim' id="nim" value="<?php echo set_value('nim', $mhs_api['nim']); ?>" >
                                                                <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name='tm_msk' id="tm_msk" value="<?php echo set_value('tm_msk', $mhs_api['tm_msk']); ?>" >
                                                                <?= form_error('tm_msk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nama_mahasiswa" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa" value="<?php echo set_value('nama_mahasiswa', $mhs_api['nama']); ?>" >
                                                                <?= form_error('nama_mahasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="prodi" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Prodi</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="prodi" id="prodi" value="<?php echo set_value('prodi', $mhs_api['nam_prodi']); ?>" >
                                                                <?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="fakultas" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fakultas</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="fakultas" id="fakultas" value="<?php echo set_value('fakultas', $mhs_api['nam_fak']); ?>" >
                                                                <?= form_error('fakultas', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="cek_aktif" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Perkuliahan</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <!-- < ?= ($cek_aktif == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-success">Tidak Aktif</span>') ?> -->
                                                                <span class="badge badge-success">Aktif</span>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jjp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenjang Pendidikan</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly type="text" class="form-control" name="jjp" id="jjp" value="<?php echo set_value('jjp', $mhs_api['jjp']); ?>" style="margin-bottom: 0;">
                                                                <?= form_error('jjp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="ipk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">IPK</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="ipk" id="ipk" value="<?php echo ($mhs_api['ipk'] ? set_value('ipk', $mhs_api['ipk']) : 'mahasiswa baru'); ?>" >
                                                                <?= form_error('ipk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="nohp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Hp</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="nohp" id="nohp" value="<?php echo set_value('nohp', $mhs_api['nohp']); ?>" >
                                                                <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tmp_lhr" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat/tgl lahir</label>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="tmp_lhr" id="tmp_lhr" value="<?php echo set_value('tmp_lhr', $mhs_api['tmp_lhr']); ?>" >
                                                                <?= form_error('tmp_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                            <div class="col-sm-4 col-md-4">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="tgl_lhr" id="tgl_lhr" value="<?php echo set_value('tgl_lhr', $mhs_api['tgl_lhr']); ?>" >
                                                                <?= form_error('tgl_lhr', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="agama" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Agama</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="agama" id="agama" value="<?php echo set_value('agama', $mhs_api['agama']); ?>" >
                                                                <?= form_error('agama', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                                                            <div class="col-sm-9 col-md-9">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="jk" id="jk" value="<?php echo set_value('jk', $mhs_api['jk']); ?>" >
                                                                <?= form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                    <div class="form-card card card-warning p-3">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Data Tambahan:</h2>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jalur_masuk" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jalur Masuk</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <select class="form-control <?= form_error('jalur_masuk') ? 'is-invalid' : null; ?>" name="jalur_masuk" id="jalur_masuk">
                                                                    <option value="" selected>Pilih Jalur Masuk</option>
                                                                    <?php foreach ($jalur_masuk as $jm) :?>
                                                                        <option value="<?= $jm['id']; ?>" <?= $jm['id'] == set_value('jalur_masuk') ? "selected" : null; ?>><?= $jm['nama_jalur_masuk']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <?= form_error('jalur_masuk', '<small class="text-danger pl-3">','</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="ukt" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Besar UKT / Semester: </label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input type="number" id="ukt" name="ukt" placeholder="UKT ..." style="margin-bottom: 0; background-color: white;"
                                                                class="form-control <?= form_error('ukt') ? 'is-invalid' : (set_value('ukt') ? 'is-valid' : null); ?>"
                                                                value="<?= set_value('ukt'); ?>">
                                                                <?= form_error('ukt', '<small class="text-danger pl-3">', '</small>'); ?>
                                                                <div class="text-small text-muted mb-1">(masukkan angka).</div>
                                                            </div>
                                                        </div>
                                                        <?php if($no_rekening == 1) { ?>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="jenis_bank" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Bank</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input readonly style="margin-bottom: 0;" type="text" class="form-control" name="jenis_bank" id="jenis_bank" value="Bank Nagari" >
                                                                <div class="text-small text-muted mb-1">(Bank yang digunakan Harus Bank yang tertera).</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="pemilik_rekening" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pemilik Rekening</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input style="margin-bottom: 0; background-color: white;" type="text" class="form-control <?= form_error('pemilik_rekening') ? 'is-invalid' : (set_value('pemilik_rekening') ? 'is-valid' : null); ?>" 
                                                                name="pemilik_rekening" 
                                                                id="pemilik_rekening" 
                                                                placeholder="input nama pemilik rekening"
                                                                value="<?= set_value('pemilik_rekening'); ?>" >
                                                                <?= form_error('pemilik_rekening', '<small class="text-danger pl-3">', '</small>'); ?>
                                                                <div class="text-small text-muted mb-1">(Nama Pemilik Rekening harus sesuai dengan nama mahasiswa yang mengajukan beasiswa).</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tulis_no_rekening" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Rekening</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input style="margin-bottom: 0; background-color: white;" type="text" class="form-control <?= form_error('tulis_no_rekening') ? 'is-invalid' : (set_value('tulis_no_rekening') ? 'is-valid' : null); ?>" 
                                                                name="tulis_no_rekening" 
                                                                id="tulis_no_rekening" 
                                                                placeholder="tulis nomor rekening"
                                                                value="<?= set_value('tulis_no_rekening'); ?>" >
                                                                <?= form_error('tulis_no_rekening', '<small class="text-danger pl-3">', '</small>'); ?>
                                                                <div class="text-small text-muted mb-1">(masukkan angka, jangan sampai keliru dalam memasukkan no rekening).</div>
                                                            </div>
                                                        </div>
                                                        <?php }; ?>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tulis_nohp" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Whatsapp Aktif</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input style="margin-bottom: 0; background-color: white;" type="text" class="form-control <?= form_error('tulis_nohp') ? 'is-invalid' : (set_value('tulis_nohp') ? 'is-valid' : null); ?>" 
                                                                name="tulis_nohp" 
                                                                id="tulis_nohp" 
                                                                placeholder="tulis nohp"
                                                                value="<?= set_value('tulis_nohp'); ?>" >
                                                                <?= form_error('tulis_nohp', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tulis_nik" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">NIK</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input style="margin-bottom: 0; background-color: white;" type="text" class="form-control <?= form_error('tulis_nik') ? 'is-invalid' : (set_value('tulis_nik') ? 'is-valid' : null); ?>" 
                                                                name="tulis_nik" 
                                                                id="tulis_nik" 
                                                                placeholder="tulis NIK"
                                                                value="<?= set_value('tulis_nik'); ?>" >
                                                                <?= form_error('tulis_nik', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-bottom: 10px;">
                                                            <label for="tulis_email" class="col-form-label text-md-right col-md-3 col-lg-3 col-sm-12">Email Aktif</label>
                                                            <div class="col-sm-8 col-md-8">
                                                                <input style="margin-bottom: 0; background-color: white;" type="text" class="form-control <?= form_error('tulis_email') ? 'is-invalid' : (set_value('tulis_email') ? 'is-valid' : null); ?>" 
                                                                name="tulis_email" 
                                                                id="tulis_email" 
                                                                placeholder="tulis Email"
                                                                value="<?= set_value('tulis_email'); ?>" >
                                                                <?= form_error('tulis_email', '<small class="text-danger pl-3">', '</small>'); ?>
                                                            </div>
                                                        </div>
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
                                                    <label for="tulis_nama_ayah" class="col-form-label text-md-right col-md-3 col-lg-3 col-sm-12">Nama Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <input type="text" class="form-control <?= form_error('tulis_nama_ayah') ? 'is-invalid' : (set_value('tulis_nama_ayah') ? 'is-valid' : null) ; ?>" name="tulis_nama_ayah" id="tulis_nama_ayah" placeholder="Tulis Nama Ayah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('tulis_nama_ayah'); ?>">
                                                        <?= form_error('tulis_nama_ayah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_status_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Status Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_status_ayah') ? 'is-invalid' : null; ?>" name="tulis_status_ayah" id="tulis_status_ayah">
                                                            <option value="" selected>Pilih Status Ayah</option>
                                                            <?php foreach ($status_orangtua as $so) :?>
                                                                <option value="<?= $so['id']; ?>" <?= $so['id'] == set_value('tulis_status_ayah') ? "selected" : null; ?>><?= $so['nama_status']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_status_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="hub_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Hubungan dengan Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('hub_ayah') ? 'is-invalid' : null; ?>" name="hub_ayah" id="hub_ayah">
                                                            <option value="" selected>Pilih Hubungan Ayah</option>
                                                            <?php foreach ($hub_ayah as $ha) :?>
                                                                <option value="<?= $ha['id']; ?>" <?= $ha['id'] == set_value('hub_ayah') ? "selected" : null; ?>><?= $ha['nama_hub_ayah']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('hub_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_pendidikan_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Pendidikan Terakhir</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_pendidikan_ayah') ? 'is-invalid' : null; ?>" name="tulis_pendidikan_ayah" id="tulis_pendidikan_ayah">
                                                            <option value="" selected>Pilih Pendidikan Ayah</option>
                                                            <?php foreach ($pendidikan_orangtua as $pdo) :?>
                                                                <option value="<?= $pdo['id']; ?>" <?= $pdo['id'] == set_value('tulis_pendidikan_ayah') ? "selected" : null; ?>><?= $pdo['nama_pendidikan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_pendidikan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_pekerjaan_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Pekerjaan Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_pekerjaan_ayah') ? 'is-invalid' : null; ?>" name="tulis_pekerjaan_ayah" id="pekerjaan_ayah">
                                                            <option value="" selected>Pilih Jenis Pekerjaan Ayah</option>
                                                            <?php foreach ($pekerjaan_orangtua as $pko) :?>
                                                                <option value="<?= $pko['id']; ?>" <?= $pko['id'] == set_value('tulis_pekerjaan_ayah') ? "selected" : null; ?>><?= $pko['nama_pekerjaan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_pekerjaan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="rincian_pekerjaan_ayah" name="rincian_pekerjaan_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Rincian Pekerjaan Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <textarea name="rincian_pekerjaan_ayah" id="" cols="30" rows="10" style="margin-bottom: 0; background-color: white;"><?= set_value('rincian_pekerjaan_ayah'); ?></textarea>
                                                        <?= form_error('rincian_pekerjaan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="ratarata_penghasilan_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Rata - Rata Penghasilan Ayah / Bulan</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('ratarata_penghasilan_ayah') ? 'is-invalid' : null; ?>" name="ratarata_penghasilan_ayah" id="ratarata_penghasilan_ayah">
                                                            <option value="" selected>Pilih Rata - Rata</option>
                                                            <?php foreach ($penghasilan_orangtua as $pho) :?>
                                                                <option value="<?= $pho['id']; ?>" <?= $pho['id'] == set_value('ratarata_penghasilan_ayah') ? "selected" : null; ?>><?= $pho['ratarata_penghasilan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('ratarata_penghasilan_ayah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="kontak_ayah" class="col-form-label col-md-3 col-lg-3 col-sm-12">No Hp Ayah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <input type="text" class="form-control <?= form_error('kontak_ayah') ? 'is-invalid' : (set_value('kontak_ayah') ? 'is-valid' : null) ; ?>" name="kontak_ayah" id="kontak_ayah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('kontak_ayah'); ?>">
                                                        <?= form_error('kontak_ayah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                </div>
                                                <h3 class="fs-title" style="font-size: 17px;">Biodata Ibu :</h3>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_nama_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Nama Ibu</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <input type="text" class="form-control <?= form_error('tulis_nama_ibu') ? 'is-invalid' : (set_value('tulis_nama_ibu') ? 'is-valid' : null) ; ?>" name="tulis_nama_ibu" id="tulis_nama_ibu" style="margin-bottom: 0; background-color: white;" value="<?= set_value('tulis_nama_ibu'); ?>">
                                                        <?= form_error('tulis_nama_ibu', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_status_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Status Ibu</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_status_ibu') ? 'is-invalid' : null; ?>" name="tulis_status_ibu" id="tulis_status_ibu">
                                                            <option value="" selected>Pilih Status Ibu</option>
                                                            <?php foreach ($status_orangtua as $so) :?>
                                                                <option value="<?= $so['id']; ?>" <?= $so['id'] == set_value('tulis_status_ibu') ? "selected" : null; ?>><?= $so['nama_status']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_status_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="hub_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Hubungan dengan Ibu</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('hub_ibu') ? 'is-invalid' : null; ?>" name="hub_ibu" id="hub_ibu">
                                                            <option value="" selected>Pilih Hubungan Ibu</option>
                                                            <?php foreach ($hub_ibu as $hi) :?>
                                                                <option value="<?= $hi['id']; ?>" <?= $hi['id'] == set_value('hub_ibu') ? "selected" : null; ?>><?= $hi['nama_hub_ibu']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('hub_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_pendidikan_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Pendidikan Terakhir</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_pendidikan_ibu') ? 'is-invalid' : null; ?>" name="tulis_pendidikan_ibu" id="tulis_pendidikan_ibu">
                                                            <option value="" selected>Pilih Pendidikan ibu</option>
                                                            <?php foreach ($pendidikan_orangtua as $pdo) :?>
                                                            <option value="<?= $pdo['id']; ?>" <?= $pdo['id'] == set_value('tulis_pendidikan_ibu') ? "selected" : null; ?>><?= $pdo['nama_pendidikan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_pendidikan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tulis_pekerjaan_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Pekerjaan Ibu</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('tulis_pekerjaan_ibu') ? 'is-invalid' : null; ?>" name="tulis_pekerjaan_ibu" id="tulis_pekerjaan_ibu">
                                                            <option value="" selected>Pilih Jenis Pekerjaan Ibu</option>
                                                            <?php foreach ($pekerjaan_orangtua as $pko) :?>
                                                                <option value="<?= $pko['id']; ?>" <?= $pko['id'] == set_value('tulis_pekerjaan_ibu') ? "selected" : null; ?>><?= $pko['nama_pekerjaan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('tulis_pekerjaan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="rincian_pekerjaan_ibu"  class="col-form-label col-md-3 col-lg-3 col-sm-12">Rincian Pekerjaan Ibu</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <textarea id="" cols="30" rows="10" name="rincian_pekerjaan_ibu" style="margin-bottom: 0; background-color: white;"><?= set_value('rincian_pekerjaan_ibu'); ?></textarea>
                                                        <?= form_error('rincian_pekerjaan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="ratarata_penghasilan_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">Rata - Rata Penghasilan Ibu / Bulan</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('ratarata_penghasilan_ibu') ? 'is-invalid' : null; ?>" name="ratarata_penghasilan_ibu" id="ratarata_penghasilan_ibu">
                                                            <option value="" selected>Pilih Rata - Rata</option>
                                                            <?php foreach ($penghasilan_orangtua as $pa) :?>
                                                                <option value="<?= $pa['id']; ?>" <?= $pa['id'] == set_value('ratarata_penghasilan_ibu') ? "selected" : null; ?>><?= $pa['ratarata_penghasilan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('ratarata_penghasilan_ibu', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="kontak_ibu" class="col-form-label col-md-3 col-lg-3 col-sm-12">No Hp</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
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
                                                    <label for="status_rumah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Status Kepemilikan Rumah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('status_rumah') ? 'is-invalid' : null; ?>" name="status_rumah" id="status_rumah">
                                                            <option value="" selected>Pilih Status Rumah</option>
                                                            <?php foreach ($status_rumah as $sr) :?>
                                                                <option value="<?= $sr['id']; ?>" <?= $sr['id'] == set_value('status_rumah') ? "selected" : null; ?>><?= $sr['nama_status_rumah']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('status_rumah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="luas_rumah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Luas Rumah</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <select class="form-control <?= form_error('luas_rumah') ? 'is-invalid' : null; ?>" name="luas_rumah" id="luas_rumah">
                                                            <option value="" selected>Pilih Luas Rumah</option>
                                                            <?php foreach ($luas_rumah as $lr) :?>
                                                                <option value="<?= $lr['id']; ?>" <?= $lr['id'] == set_value('luas_rumah') ? "selected" : null; ?>><?= $lr['nama_luas_rumah']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('luas_rumah', '<small class="text-danger pl-3">','</small>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 10px;">
                                                    <label for="tahun_rumah" class="col-form-label col-md-3 col-lg-3 col-sm-12">Tahun Perolehan</label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <input type="number" placeholder="2010" class="form-control <?= form_error('tahun_rumah') ? 'is-invalid' : (set_value('tahun_rumah') ? 'is-valid' : null) ; ?>" name="tahun_rumah" id="tahun_rumah" style="margin-bottom: 0; background-color: white;" value="<?= set_value('tahun_rumah'); ?>">
                                                        <?= form_error('tahun_rumah', '<small class="text-danger pl-3">', '</small>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
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
                                                    <label class="col-form-label col-md-3 col-lg-3 col-sm-12" ><?= $p['persyaratan']; ?> <?= $p['wajibpersyaratan'] == '1' ? '<a style="color: red;">(*)</a>' : ''?>
                                                    Tipe File <span style="font-size: 20px; font-weight: bold; color: blue;"><?= $p['tipe_file']; ?></span></label>
                                                    <div class="col-sm-12 col-md-5 col-lg-5">
                                                        <?php $alias = $p['alias']; ?>
                                                        <input type="file" id="<?= $alias; ?>" name="<?= $alias; ?>"  class="form-control">
                                                        <?= form_error("$alias", "<small class='text-danger pl-3'>", "</small>"); ?>
                                                        <small>(<?= $p['keterangan']; ?>)</small>
                                                        <small>(Ukuran Maksimal <?= $p['ukuran_file_mb']; ?> atau <?= $p['ukuran_file']; ?>Kb)</small>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
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
