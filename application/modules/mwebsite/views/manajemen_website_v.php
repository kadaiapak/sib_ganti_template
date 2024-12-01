    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>

          
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          
          <div class="row">

            <div class="col-lg">
              <?= $this->session->flashdata('message'); ?>
              <?= form_error('beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('singkatan', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('deskripsi', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card">
                <div class="card-header">
                  <h4>Menu List</h4>
                  <div class="card-header-action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#manajemenWebsiteModal">
                      Tambah Settingan Website
                    </button>
                  </div>
                </div>

                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Settingan</th>
                          <th>Nama Alias</th>
                          <th style="width: 11%;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($manajemen_website as $mw) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $mw['judul']; ?></td>
                              <td><?= $mw['nama_yang_digunakan']; ?></td>
                              <td>
                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editManajemenWebsiteModal<?= $mw['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                
                                <form style="display: inline-block;" action="<?= base_url('mwebsite/hapus'); ?>" method="post">
                                    <input 
                                    name="manajemen_website_id"
                                    type="hidden" 
                                    value="<?= $mw['id']; ?>">    
                                    <button onclick="return confirm('Yakinkah  dihapus?')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                              </td>
                            </tr>
                        <?php $i++ ?>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
                  
        
        </section>

          <!-- modal untuk tambah data -->
          <div class="modal fade" id="manajemenWebsiteModal" tabindex="-1" role="dialog" aria-labelledby="manajemenWebsiteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="manajemenWebsiteModalLabel">Masukkan Settingan Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mwebsite');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul ...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_yang_digunakan" name="nama_yang_digunakan" placeholder="Nama yang digunakan ...">
                    </div>
                  </div>
                  <div class="modal-footer" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- modal untuk edit -->
          <?php $no = 0; ?>
          <?php foreach ($manajemen_website as $mw) : $no++ ?>
          <div class="modal fade" id="editManajemenWebsiteModal<?= $mw['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editManajemenWebsiteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editManajemenWebsiteModalLabel">Edit Nama Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mwebsite/edit');?>" method="post">

                <input type="hidden" name="id" value="<?= $mw['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $mw['judul']; ?>" type="text" class="form-control" id="judul" name="judul" placeholder="Judul Setingan ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $mw['nama_yang_digunakan']; ?>" type="text" class="form-control" id="nama_yang_digunakan" name="nama_yang_digunakan" placeholder="Nama yang digunakan ...">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
      </div>

   