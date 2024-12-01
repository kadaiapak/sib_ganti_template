    
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
                              <form action="" method="post" id="formUpdateAkun">
                                <div class="card-body">
                                    <div class="form-group has-error">
                                        <label for="username">Username :</label>
                                        <input readonly type="text" class="form-control" id="username" 
                                               name="username" value="<?= $user->username; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Nama Panjang :</label>
                                        <input type="text" value="<?= $this->input->post('name') ??  $user->name; ?>" 
                                        class="form-control <?= form_error('name') ? 'is-invalid' : (set_value('name') ? 'is-valid' : null) ; ?>" 
                                        id="name" name="name" placeholder="Nama Panjang ...">
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>  
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="email">Email :</label>
                                        <input type="email" 
                                        class="form-control <?= form_error('email') ? 'is-invalid' : (set_value('email') ? 'is-valid' : null) ; ?>" 
                                        id="email" name="email" value="<?= $this->input->post('email') ??  $user->email; ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <a href="<?= base_url('akun'); ?>" class="btn btn-danger">Kembali</a>
                                    <button type="submit" class="btn btn-primary" id="buttonUpdateAkun">Submit</button>
                                </div>
                          </div>
                                
                      </div>
                  </div>
              </div>
          </section>
      </div>
      
  