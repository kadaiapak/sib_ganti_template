<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <p class="section-lead">
                        Inputkan data mengenai beasiswa yang nantinya akan digunakan sebagai master data beasiswa dalam proses upload data mahasiswa penerima beasiswa tersebut.
                    </p>
                </div>  
            </div>
            
            <?= form_error('nama_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
            <?= form_error('kelompok_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
            <?= form_error('asal_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
            <?= form_error('periode', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
            <?= form_error('tahun', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
            <?= form_error('biaya', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;">Form Tambah User</h4>
                            <div class="section-header-button">
                                <a href="<?= base_url('user'); ?>" class="btn btn-danger ml-2"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="<?= base_url('user/tambah');?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama Panjang :</label>
                                        <input type="text" value="<?= set_value('name'); ?>" class="form-control <?= form_error('name') ? 'is-invalid' : (set_value('name') ? 'is-valid' : null) ; ?>" id="name" name="name" placeholder="Fullname ...">
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                    
                                    <div class="form-group has-error">
                                        <label for="username">Username :</label>
                                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : (set_value('username') ? 'is-valid' : null) ; ?>" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="Username ...">
                                        <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="email">Email :</label>
                                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : (set_value('email') ? 'is-valid' : null) ; ?>" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="Email ...">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="role_id">Pilih Role :</label>
                                        <select class="form-control <?= form_error('role_id') ? 'is-invalid' : null ; ?>" name="role_id" id="role_id">
                                            <option value="" selected>Role ...</option>
                                                <?php foreach ($role as $r) :?>
                                                <option value="<?= $r['id']; ?>" <?= $r['id'] == set_value('role_id') ? "selected" : ""; ?>><?= $r['role']; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                        <?= form_error('role_id', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="password1">Password :</label>
                                        <input id="password1" type="password" class="form-control pwstrength <?= form_error('password1') ? 'is-invalid' : null ; ?>" data-indicator="pwindicator" name="password1">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="password2">Ulangi Password :</label>
                                        <input id="password2" type="password" class="form-control <?= form_error('password2') ? 'is-invalid' : null ; ?>" name="password2">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                    
                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="hidden" name="is_active" value="0" id="is_active" />
                                        <input class="form-check-input" type="checkbox" value="1" name="is_active"  id="is_active">
                                        <label class="form-check-label" for="is_active">
                                            Is Active ?
                                        </label>
                                        </div>
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