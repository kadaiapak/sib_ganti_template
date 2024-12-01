    
      <!-- Main Content -->
<div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
     <div class="main-content">
          <section class="section">
              <div class="section-header">
                  <h1><?= $title; ?></h1>
              </div>
              <div class="row">
                  <div class="col-lg-8 col-md-8 col-8 col-sm-8">
                      <div class="card author-box card-warning">
                          <div class="card-body">
                              <div class="author-box-left">
                                  <img alt="image" src="<?= base_url('uploads/image/no-photo.jpg'); ?>" class="rounded-circle author-box-picture">
                                  <div class="clearfix"></div>
                              </div>
                              <div class="author-box-details">
                                  <div class="author-box-name">
                                      <div class="row">
                                          <div class="col-md-5 col-lg-5 col-sm-5">
                                              <label>Nama</label>
                                          </div>
                                          <div>
                                              <a>: <?= $user->name; ?></a>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-5 col-lg-5 col-sm-5">
                                              <label>Username</label>
                                          </div>
                                          <div>
                                              <a>: <?= $user->username; ?></a>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-5 col-lg-5 col-sm-5">
                                              <label>Email</label>
                                          </div>
                                          <div>
                                              <a>: <?= $user->email; ?></a>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-5 col-lg-5 col-sm-5">
                                              <label>Tanggal Pembuatan Akun </label>
                                          </div>
                                          <div>
                                              <a>: <?= date('d F Y', $user->date_created); ?></a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="float-lg-left mb-lg-0 mb-3">
                                    <a href="<?= base_url('akun/edit-profile'); ?>" class="btn btn-success btn-icon icon-left" ><i class="fas fa-info" style="margin-left: 20px;" ></i>Edit Profil</a>
                                    <a href="<?= base_url('akun/ubah-password'); ?>" class="btn btn-warning  btn-icon icon-left"><i class="fas fa-info"></i>Ubah Password</a>
                              </div>
                          </div>
                                
                      </div>
                  </div>
              </div>
          </section>
      </div>
      
  