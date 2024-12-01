    
      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div class="row">

            <div class="col-lg-6 col-md-6">
              <?= form_error('nama_asal_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;" >Sumber Pembiayaan</h4>
                  <div class="card-header-action">
                    <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#asalBeasiswaModal">
                      Tambah Sumber Pembiayaan
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
                          <th>Nama Sumber</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th>Aksi</th>
                          <?php  } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($asal_beasiswa as $ab) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $ab['nama_asal_beasiswa']; ?></td>
                              <?php if($cek_akses_user['hapus'] == '1' || $cek_akses_user['edit'] == '1') {  ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') {  ?>
                                  <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editAsalBeasiswaModal<?= $ab['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                  <form style="display: inline-block;" action="<?= base_url('mbeasiswa/asal_beasiswa/hapus'); ?>" method="post" >
                                    <input 
                                    name="asal_beasiswa_id"
                                    type="hidden" 
                                    value="<?= $ab['id']; ?>">    
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
          <div class="modal fade" id="asalBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="asalBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="asalBeasiswaModalLabel">Masukkan Sumber Pembiayaan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/asal_beasiswa');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_asal_beasiswa" name="nama_asal_beasiswa" placeholder="Nama Sumber Pembiayaan ...">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- modal untuk edit -->
          <?php $no = 0; ?>
          <?php foreach ($asal_beasiswa as $ab) : $no++ ?>
          <div class="modal fade" id="editAsalBeasiswaModal<?= $ab['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editAsalBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editAsalBeasiswaModalLabel">Edit Sumber Pembiayaan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/asal_beasiswa/edit');?>" method="post">

                  <input type="hidden" name="id" value="<?= $ab['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $ab['nama_asal_beasiswa']; ?>" type="text" class="form-control" id="asal_beasiswa" name="asal_beasiswa" placeholder="Sumber Pembiayaan ...">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                  </div>

                </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
    </div>
    
    

   