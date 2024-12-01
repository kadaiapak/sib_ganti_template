<div class="main-content">
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
                            <div class="card-header">
                                <h4 style="font-size: 20px; color: #34395e;">Isi Data Persyaratan</h4>
                            </div>
                            <form id="formDaftarBeasiswa" action="<?= base_url('data_beasiswa/beasiswa/prosesTambah'); ?>" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <input type="hidden" name="id_beasiswa" id="id_beasiswa" value="<?= $id; ?>">
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
                                        <?= ($cek_aktif == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>') ?>
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
                                        <input readonly type="text" class="form-control" name="ipk" id="ipk" value="<?php echo set_value('ipk', $mhs_api['ipk']); ?>" >
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
                                
                                <div class="form-group row mb-4">
                                    <label for="besar_bantuan_ukt_persemester" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Besaran Bantuan UKT</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" class="form-control" name="besar_bantuan_ukt_persemester" id="jk" value="0" >
                                        <?= form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                                        <div class="text-small text-muted mb-1">(Masukkan angka contoh : 3000000. Jika tidak ada tulis 0)</div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="besar_biaya_hidup_persemester" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Besaran Bantuan Uang Saku</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" class="form-control" name="besar_biaya_hidup_persemester" id="jk" value="0" >
                                        <div class="text-small text-muted mb-1">(Masukkan angka contoh : 3000000. Jika tidak ada tulis 0)</div>
                                        <?= form_error('jk', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button id="buttonDaftarBeasiswa" type="submit" class="btn btn-primary">Daftar</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>      
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Create New App</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mt-4">
                                    <div class="col-12 col-lg-8 offset-lg-2">
                                        <div class="wizard-steps">
                                            <div class="wizard-step ">
                                                <div class="wizard-step-icon">
                                                    <i class="far fa-user"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Masukkan Data Diri 
                                                </div>
                                            </div>
                                            <div class="wizard-step wizard-step-active">
                                                <div class="wizard-step-icon ">
                                                    <i class="fas fa-box-open"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Create an App
                                                </div>
                                            </div>
                                            <div class="wizard-step">
                                                <div class="wizard-step-icon">
                                                    <i class="fas fa-server"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Server Information
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form class="wizard-content mt-2">
                                    <div class="wizard-pane">
                                        <div class="form-group row align-items-center">
                                            <label class="col-md-4 text-md-right text-left">Name</label>
                                            <div class="col-lg-4 col-md-6">
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-md-4 text-md-right text-left">Email</label>
                                            <div class="col-lg-4 col-md-6">
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 text-md-right text-left mt-2">Address</label>
                                            <div class="col-lg-4 col-md-6">
                                                <textarea class="form-control" name="address"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 text-md-right text-left mt-2">Role</label>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="selectgroup w-100">
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="value" value="developer" class="selectgroup-input">
                                                        <span class="selectgroup-button">Developer</span>
                                                    </label>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="value" value="ceo" class="selectgroup-input">
                                                        <span class="selectgroup-button">CEO</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4"></div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                                <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        <div class="col-md-4"></div>
                                        <div class="col-lg-4 col-md-6 text-right">
                                            <a href="#" class="btn btn-icon icon-right btn-primary">Next <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">

                                    <li role="presentation" class="active">
                                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-folder-open"></i>
                                            </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled">
                                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-picture"></i>
                                            </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                                            <span class="round-tab">
                                                <i class="glyphicon glyphicon-ok"></i>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <form role="form">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" id="step1">
                                        <h3>Step 1</h3>
                                        <p>This is step 1</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step2">
                                        <h3>Step 2</h3>
                                        <p>This is step 2</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="step3">
                                        <h3>Step 3</h3>
                                        <p>This is step 3</p>
                                        <ul class="list-inline pull-right">
                                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" id="complete">
                                        <h3>Complete</h3>
                                        <p>You have successfully completed all steps.</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>
</div>