    
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
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;" >Menu List</h4>
                  <?php if($cek_akses_user['tambah'] == '1') { ?>
                  <div class="card-header-action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#namaBeasiswaModal">
                      Tambah Nama Beasiswa
                    </button>
                  </div>
                  <?php } ?>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Beasiswa</th>
                          <th>Nama Singkat</th>
                          <th style="width: 30%;">Deskripsi</th>
                          <th style="width: 40%;">Profil</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th style="width: 11%;">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($nama_beasiswa as $mb) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $mb['nama_beasiswa']; ?></td>
                              <td><?= $mb['singkatan']; ?></td>
                              <td><?= $mb['keterangan']; ?></td>
                              <td><?= $mb['profil']; ?></td>
                              <?php if($cek_akses_user['hapus'] == '1' || $cek_akses_user['edit'] == '1') { ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1'){ ?>
                                  <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editNamaBeasiswaModal<?= $mb['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') {  ?>
                                <form style="display: inline-block;" action="<?= base_url('mbeasiswa/nama_beasiswa/del'); ?>" method="post">
                                <input 
                                name="nama_beasiswa_id"
                                type="hidden" 
                                value="<?= $mb['id']; ?>">    
                                <button onclick="return confirm('Yakin dihapus?')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                </button>
                                </form>
                                <?php } ?>
                              </td>
                              <?php } ?>
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
          <div class="modal fade" id="namaBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="namaBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content" style="height: 750px;">
                <div class="modal-header">
                  <h5 class="modal-title" id="namaBeasiswaModalLabel">Masukkan Nama Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/nama_beasiswa');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="beasiswa" name="beasiswa" placeholder="Nama Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Nama Singkatan ...">
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" class="form-control" id="deskripsi" name="deskripsi" rows="2" cols="10" placeholder="Deskripsi ..."></textarea>
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" class="form-control" id="profil" name="profil"rows="8" cols="10" placeholder="Profil ..."></textarea>
                    </div>
                  </div>
                  <div class="modal-footer" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- modal untuk edit -->
          <?php $no = 0; ?>
          <?php foreach ($nama_beasiswa as $mb) : $no++ ?>
          <div class="modal fade" id="editNamaBeasiswaModal<?= $mb['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editNamaBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content"  style="height: 750px;">
                <div class="modal-header">
                  <h5 class="modal-title" id="editNamaBeasiswaModalLabel">Edit Nama Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/nama_beasiswa/edit');?>" method="post">

                <input type="hidden" name="id" value="<?= $mb['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $mb['nama_beasiswa']; ?>" type="text" class="form-control" id="beasiswa" name="beasiswa" placeholder="Nama Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $mb['singkatan']; ?>" type="text" class="form-control" id="singkatan" name="singkatan" placeholder="Nama Singkatan ...">
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" class="form-control" id="deskripsi" name="deskripsi"rows="2" cols="40" placeholder="deskripsi ..."><?= $mb['keterangan']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" class="form-control" id="profil" name="profil" rows="2" cols="40" placeholder="profil ..."><?= $mb['profil']; ?></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
      </div>

   