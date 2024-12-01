<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Informasi</h2>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <p class="section-lead">
                        Silahkan gunakan menu ini apabila mahasiswa yang akan anda inputkan ternyata sudah mendapatkan beasiswa. 
                    </p>
                </div>  
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tambah Penerima Beasiswa</h4>
                            <div class="section-header-button">
                                <a href="<?= base_url('data_beasiswa/beasiswa/'); ?>" class="btn btn-danger ml-2"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nim">NIM :</label>
                                        <input type="number" value="<?= set_value('nim'); ?>" id="nim" name="nim" placeholder="NIM ..."
                                        class="form-control <?= form_error('nim') ? 'is-invalid' : (set_value('nim') ? 'is-valid' : null) ; ?>"
                                        >
                                        <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama :</label>
                                        <input type="text" value="<?= set_value('nama'); ?>" class="form-control <?= form_error('nama') ? 'is-invalid' : (set_value('nama') ? 'is-valid' : null) ; ?>" id="nama" name="nama" placeholder="Nama ...">
                                        <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                                    <div class="form-group">
                                        <label for="prodi">Prodi :</label>
                                        <input type="text" value="<?= set_value('prodi'); ?>" class="form-control <?= form_error('prodi') ? 'is-invalid' : (set_value('prodi') ? 'is-valid' : null) ; ?>" id="prodi" name="prodi" placeholder="Prodi ...">
                                        <?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                                    <div class="form-group">
                                        <label for="fakultas">Fakultas :</label>
                                        <input type="text" value="<?= set_value('fakultas'); ?>" class="form-control <?= form_error('fakultas') ? 'is-invalid' : (set_value('fakultas') ? 'is-valid' : null) ; ?>" id="fakultas" name="fakultas" placeholder="Fakultas ...">
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                        </div>
                  
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>