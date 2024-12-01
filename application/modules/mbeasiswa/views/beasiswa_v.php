    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>

          
          
          <div class="row">

            <div class="col-lg">
            <?= $this->session->flashdata('message'); ?>

              <?= form_error('menu', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;">Daftar Menu</h4>
                  <div class="card-header-action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#masterBeasiswaModal">
                      Add New Beasiswa
                    </button>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Beasiswa</th>
                          <th>Nama Singkat</th>
                          <th>Kelompok Beasiswa</th>
                          <th>Asal Beasiswa</th>
                          <!-- <th>Deskripsi</th> -->
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_beasiswa as $mb) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $mb['nama_beasiswa']; ?></td>
                              <td><?= $mb['nama_singkat_beasiswa']; ?></td>
                              <td><?= $mb['kelompok_beasiswa']; ?></td>
                              <td><?= $mb['asal_beasiswa']; ?></td>
                              <!-- <td><?= $mb['deskripsi']; ?></td> -->
                              <td>
                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
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

<!-- Modal -->
          <div class="modal fade" id="masterBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="masterBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="masterBeasiswaModalLabel">Add New Menu</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('menu');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name ...">
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
      </div>

      <!-- Modal -->
      <!-- Button trigger modal -->
<!-- Modal -->