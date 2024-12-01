    
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
              <?= form_error('kelompok_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;">Kelompok Beasiswa</h4>
                  <?php if($cek_akses_user['tambah'] == '1') { ?>
                  <div class="card-header-action">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kelompokBeasiswaModal">
                      Tambah Kelompok Beasiswa
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
                          <?php if($cek_akses_user['edit'] || $cek_akses_user['hapus'] == '1') { ?>
                          <th>Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($kelompok_beasiswa as $kb) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $kb['nama_kelompok']; ?></td>
                              <?php if($cek_akses_user['hapus'] == '1' || $cek_akses_user['edit'] == '1') { ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') { ?>
                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editKelompokBeasiswaModal<?= $kb['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                <form style="display: inline-block;" action="<?= base_url('mbeasiswa/kelompok_beasiswa/del'); ?>" method="post">
                                <input 
                                name="kelompok_beasiswa_id"
                                type="hidden" 
                                value="<?= $kb['id']; ?>">    
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
          <div class="modal fade" id="kelompokBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="kelompokBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="kelompokBeasiswaModalLabel">Masukkan Nama Kelompok Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/kelompok_beasiswa');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok" placeholder="Nama Kelompok Beasiswa ...">
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

          <!-- modal untuk edit -->
          <?php $no = 0; ?>
          <?php foreach ($kelompok_beasiswa as $kb) : $no++ ?>
          <div class="modal fade" id="editKelompokBeasiswaModal<?= $kb['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editKelompokBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editKelompokBeasiswaModalLabel">Edit Nama Kelompok Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/kelompok_beasiswa/edit');?>" method="post">

                <input type="hidden" name="id" value="<?= $kb['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $kb['nama_kelompok']; ?>" type="text" class="form-control" id="kelompok_beasiswa" name="kelompok_beasiswa" placeholder="Nama Beasiswa ...">
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

   