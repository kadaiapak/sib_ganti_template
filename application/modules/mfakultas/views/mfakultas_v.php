    
      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div class="row">

            <div class="col-lg-8 col-md-8">
              <?= form_error('nama_panjang_fakultas', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('singkatan_fakultas', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;" >Fakultas</h4>
                  <div class="card-header-action">
                    <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fakultasModal">
                      Tambah Fakultas
                    </button>
                    <?php } ?>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Panjang Fakultas</th>
                          <th>Singkatan Fakultas</th>
                          <th>Aktif</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th>Aksi</th>
                          <?php  } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($fakultas as $fk) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $fk['nama_panjang_fakultas']; ?></td>
                              <td><?= $fk['singkatan_fakultas']; ?></td>
                              <td><?php if($fk['aktif'] == 1) : ?>
                                  <span class="badge badge-success">Aktif</span>
                              <?php else : ?>
                                  <span class="badge badge-warning">Tidak Aktif</span>
                              <?php endif; ?></td>
                              <?php if($cek_akses_user['hapus'] == '1' || $cek_akses_user['edit'] == '1') {  ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') {  ?>
                                  <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editfakultasModal<?= $fk['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                  <form style="display: inline-block;" action="<?= base_url('mfakultas/hapus'); ?>" method="post" >
                                    <input 
                                    name="fakultas_id"
                                    type="hidden" 
                                    value="<?= $fk['id']; ?>">    
                                    <button onclick="return confirm('Yakin dihapus?')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
                                    </button>
                                  </form>
                                <?php } ?>
                              </td>
                              <?php  } ?>
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
          <div class="modal fade" id="fakultasModal" tabindex="-1" role="dialog" aria-labelledby="fakultasModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="fakultasModalLabel">Masukkan Nama Fakultas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mfakultas');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_panjang_fakultas" name="nama_panjang_fakultas" placeholder="Nama Fakultas ...">
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="singkatan_fakultas" name="singkatan_fakultas" placeholder="Nama Singkatan Fakultas ...">
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="aktif" value="0" id="aktif" />
                                <input class="form-check-input" type="checkbox" value="1" name="aktif"  id="aktif">
                                <label class="form-check-label" for="aktif">
                                    Aktif
                                </label>
                                <div class="text-small text-muted mb-0">(ceklis jika fakultas ini aktif) !</div>
                                </div>
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
          <?php foreach ($fakultas as $fk) : $no++ ?>
          <div class="modal fade" id="editfakultasModal<?= $fk['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editfakultasModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editfakultasModalLabel">Edit Nama Fakultas</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mfakultas/edit');?>" method="post">

                  <input type="hidden" name="id" value="<?= $fk['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $fk['nama_panjang_fakultas']; ?>" type="text" class="form-control" id="nama_panjang_fakultas" name="nama_panjang_fakultas" placeholder="Nama Panjang Fakultas ...">
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $fk['singkatan_fakultas']; ?>" type="text" class="form-control" id="singkatan_fakultas" name="singkatan_fakultas" placeholder="Singkata Fakultas ...">
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                        <div class="form-check">
                        <input type="hidden" name="aktif" value="0" id="aktif" />
                        <input class="form-check-input" <?= $fk['aktif'] == '1' ? "checked" : null; ?> 
                        type="checkbox" value="1" name="aktif"  id="aktif">
                        <label class="form-check-label" for="aktif">
                            Aktif ?
                        </label>
                        <div class="text-small text-muted mb-0">(ceklis jika Fakultas mini aktif) !</div>
                        </div>
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
    
    

   