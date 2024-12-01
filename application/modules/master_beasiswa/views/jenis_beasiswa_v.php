      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div class="row">

            <div class="col-lg">
              <?= form_error('nama_jenis', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('keterangan', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;">Daftar Jenis Beasiswa</h4>
                  <div class="card-header-action">
                    <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#jenisBeasiswaModal">
                      Tambah Jenis Beasiswa
                    </button>
                    <?php } ?>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10%;">#</th>
                          <th style="width: 20%;">Jenis Beasiswa</th>
                          <th style="width: 50%;">Keterangan</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th>Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jenis_beasiswa as $jb) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $jb['nama_jenis']; ?></td>
                              <td><?= $jb['keterangan']; ?></td>
                              <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') { ?>
                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editJenisBeasiswaModal<?= $jb['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                <form style="display: inline-block;" action="<?= base_url('mbeasiswa/jenis_beasiswa/hapus'); ?>" method="post">
                                <input 
                                name="jenis_beasiswa_id"
                                type="hidden" 
                                value="<?= $jb['id']; ?>">    
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
          <div class="modal fade" id="jenisBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="jenisBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="jenisBeasiswaModalLabel">Masukkan Jenis Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/jenis_beasiswa');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" placeholder="Jenis Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" id="keterangan" name="keterangan"rows="2" cols="10" placeholder="Keterangan ..."></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- modal untuk edit -->
          <?php $no = 0; ?>
          <?php foreach ($jenis_beasiswa as $jb) : $no++ ?>
          <div class="modal fade" id="editJenisBeasiswaModal<?= $jb['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editJenisBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editJenisBeasiswaModalLabel">Edit Nama Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mbeasiswa/jenis_beasiswa/edit');?>" method="post">

                <input type="hidden" name="id" value="<?= $jb['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $jb['nama_jenis']; ?>" type="text" class="form-control" id="nama_jenis" name="nama_jenis" placeholder="Jenis Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <textarea  class="form-control" id="keterangan" name="keterangan"rows="2" cols="40" placeholder="deskripsi ..."><?= $jb['keterangan']; ?></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
      </div>

   