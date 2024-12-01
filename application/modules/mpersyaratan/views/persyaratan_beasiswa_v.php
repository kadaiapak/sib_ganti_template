    
      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div class="row">
    
            <div class="col-lg-12 col-md-12 col-sm-12">
              <?= form_error('nama_persyaratan_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('alias_persyaratan_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('keterangan_persyaratan_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;">Daftar Persyaratan Beasiswa</h4>
                  <div class="card-header-action">
                    <?php if($cek_tambah == '1') { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#persyaratanBeasiswaModal">
                      Tambah Persyaratan Beasiswa
                    </button>
                    <?php } ?>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 20%;">Nama Persyaratan</th>
                          <th style="width: 10%;">Alias</th>
                          <th style="width: 30%;">Keterangan</th>
                          <th style="width: 5%;">Tipe File</th>
                          <th style="width: 5%;">Ukuran FIle</th>
                          <th style="width: 5%;">(MB)</th>
                          <?php if($cek_edit == '1' || $cek_hapus == '1') { ?>
                          <th style="width: 20%;">Aksi</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($persyaratan_beasiswa as $pb) : ?>
                            <tr>
                              <td><?= ++$start_at; ?></td>
                              <td><?= $pb['persyaratan']; ?></td>
                              <td><?= $pb['alias']; ?></td>
                              <td><?= $pb['keterangan']; ?></td>
                              <td><?= $pb['tipe_file']; ?></td>
                              <td><?= $pb['ukuran_file']; ?></td>
                              <td><?= $pb['ukuran_file_mb']; ?></td>
                              <?php if($cek_edit == '1' || $cek_hapus == '1') { ?>
                              <td>
                                <?php if($cek_edit == '1') { ?>
                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editpersyaratanBeasiswaModal<?= $pb['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php } ?>
                                <?php if($cek_hapus == '1') { ?>
                                <form style="display: inline-block;" action="<?= base_url('mpersyaratan/persyaratan/hapus'); ?>" method="post">
                                <input 
                                name="persyaratan_beasiswa_id"
                                type="hidden" 
                                value="<?= $pb['id']; ?>">    
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
                    <?= $this->pagination->create_links(); ?>

                  </div>
                </div>

              </div>

            </div>
          </div>
                          
        </section>

          <!-- modal untuk tambah data -->
          <div class="modal fade" id="persyaratanBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="persyaratanBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="persyaratanBeasiswaModalLabel">Masukkan Nama Persyaratan Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mpersyaratan/persyaratan');?>" method="post">

                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_persyaratan_beasiswa" name="nama_persyaratan_beasiswa" placeholder="Nama Persyaratan Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="alias_persyaratan_beasiswa" name="alias_persyaratan_beasiswa" placeholder="Alias Persyaratan Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" type="text" class="form-control" id="keterangan_persyaratan_beasiswa" name="keterangan_persyaratan_beasiswa" placeholder="Keterangan Persyaratan Beasiswa ..."></textarea>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="tipe_file" name="tipe_file" placeholder="Tipe File Persyaratan ...">
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control" id="ukuran_file" name="ukuran_file" placeholder="Tipe File dalam KB ...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="ukuran_file_mb" name="ukuran_file_mb" placeholder="Tipe File dalam Mb ...">
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
          <?php foreach ($persyaratan_beasiswa as $pb) : $no++ ?>
          <div class="modal fade" id="editpersyaratanBeasiswaModal<?= $pb['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editpersyaratanBeasiswaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editpersyaratanBeasiswaModalLabel">Edit Persyaratan Beasiswa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('mpersyaratan/persyaratan/edit');?>" method="post">

                  <input type="hidden" name="id" value="<?= $pb['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $pb['persyaratan']; ?>" type="text" class="form-control" id="nama_persyaratan_beasiswa" name="nama_persyaratan_beasiswa" placeholder="Persyaratan Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $pb['alias']; ?>" type="text" class="form-control" id="alias_persyarata_beasiswa" name="alias_persyaratan_beasiswa" placeholder="Alias Persyaratan Beasiswa ...">
                    </div>
                    <div class="form-group">
                      <textarea style="resize: none; display: block; height: 200px;" class="form-control" id="keterangan_persyaratan_beasiswa" name="keterangan_persyaratan_beasiswa"rows="2" cols="40" placeholder="deskripsi ..."><?= $pb['keterangan']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <input value="<?= $pb['tipe_file']; ?>" type="text" class="form-control" id="tipe_file" name="tipe_file" placeholder="Tipe File ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $pb['ukuran_file']; ?>" type="text" class="form-control" id="ukuran_file" name="ukuran_file" placeholder="Ukuran File ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $pb['ukuran_file_mb']; ?>" type="text" class="form-control" id="ukuran_file_mb" name="ukuran_file_mb" placeholder="Ukuran File dalam MB ...">
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
    
    

   