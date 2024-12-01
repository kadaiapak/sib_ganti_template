    
      <!-- Main Content -->
     <div class="main-content">
          <section class="section">
              <div class="section-header">
                  <h1><?= $title; ?></h1>
              </div>
              <div class="row">
                  <div class="col-lg-5 col-md-5 col-5 col-sm-5">
                      <div class="card author-box card-warning">
                          <div class="card-body">
                              <form action="" method="post" id="formUbahPassword">
                                <div class="card-body">
                                    <div class="form-group has-error">
                                        <label for="username">Username :</label>
                                        <input readonly type="text" class="form-control" id="username" 
                                               name="username" value="<?= $user->username; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="passwordlama">Password Lama:</label>
                                        <input id="passwordlama" type="password" class="form-control pwstrength <?= form_error('passwordlama') ? 'is-invalid' : null ; ?>" data-indicator="pwindicator" name="passwordlama" autofocus>
                                        <?= form_error('passwordlama', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Password :</label>
                                        <input id="password1" type="password" class="form-control pwstrength <?= form_error('password1') ? 'is-invalid' : null ; ?>" data-indicator="pwindicator" name="password1">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="name">Ulangi Password :</label>
                                        <input id="password2" type="password" class="form-control <?= form_error('password2') ? 'is-invalid' : null ; ?>" name="password2">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <a href="<?= base_url('akun'); ?>" class="btn btn-danger">Kembali</a>
                                    <button type="submit" class="btn btn-primary" id="buttonUbahPassword">Submit</button>
                                </div>
                          </div>
                                
                      </div>
                  </div>
              </div>
          </section>
      </div>
      
  