<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>

        <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
        <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>

        <div class="row">
            <div class="col-lg-8 col-md-8">
                <?= form_error('nama_pemisah_menu', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
                <?= form_error('no_urut', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
                <div class="card card-warning">
                    <div class="card-header">
                        <h4 style="font-size: 20px; color: #34395e;" >Pemisah Menu</h4>
                        <div class="card-header-action">
                            <?php if($cek_akses_user['tambah'] == '1') { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pemisahMenuModal">
                                Tambah Pemisah Menu
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
                            <th>Nama Pemisah Menu</th>
                            <th>No Urut</th>
                            <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                            <th>Aksi</th>
                            <?php  } ?>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1; ?>
                          <?php foreach ($menu as $m) : ?>
                              <tr>
                                <td><?= ++$start_at; ?> </td>
                                <td><?= $m['nama_pemisah']; ?></td>
                                <td><?= $m['no_urut']; ?></td>
                                <?php if($cek_akses_user['hapus'] == '1' || $cek_akses_user['edit'] == '1') {  ?>
                                <td>
                                  <?php if($cek_akses_user['edit'] == '1') {  ?>
                                  <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editpemisahMenuModal<?= $m['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                  <?php } ?>
                                  <?php if($cek_akses_user['hapus'] == '1') { ?>
                                  <form style="display: inline-block;" action="<?= base_url('konfigurasi/pemisah-menu/hapus'); ?>" method="post" >
                                      <input
                                      name="pemisah_menu_id"
                                      type="hidden"
                                      value="<?= $m['id']; ?>">
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
                      <?= $this->pagination->create_links(); ?>
                    </div>
                  </div>

                </div>

            </div>
        </div>

    </section>

      <!-- modal untuk tambah data -->
      <div class="modal fade" id="pemisahMenuModal" tabindex="-1" role="dialog" aria-labelledby="pemisahMenuModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="pemisahMenuModalLabel">Masukkan Nama Pemisah Menu</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <form action="<?= base_url('konfigurasi/pemisah-menu');?>" method="post">
                      <div class="modal-body">
                          <div class="form-group">
                              <input type="text" class="form-control" id="nama_pemisah_menu" name="nama_pemisah_menu" placeholder="Nama Pemisah Menu ...">
                          </div>
                          <div class="form-group">
                              <input type="number" class="form-control" id="no_urut" name="no_urut" placeholder="No Urut ...">
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <!-- modal untuk edit -->
      <?php $no = 0; ?>
      <?php foreach ($menu as $m) : $no++ ?>
      <div class="modal fade" id="editpemisahMenuModal<?= $m['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editpemisahMenuModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editpemisahMenuModalLabel">Edit Nama Pemisah Menu</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>

                  <form action="<?= base_url('konfigurasi/pemisah-menu/edit');?>" method="post">
                      <input type="hidden" name="id" value="<?= $m['id']; ?>">

                      <div class="modal-body">
                          <div class="form-group">
                            <input value="<?= $m['nama_pemisah']; ?>" type="text" class="form-control" id="nama_pemisah_menu" name="nama_pemisah_menu" placeholder="Nama Pemisah Menu ...">
                          </div>
                          <div class="form-group">
                            <input value="<?= $m['no_urut']; ?>" type="text" class="form-control" id="no_urut" name="no_urut" placeholder="No Urut ...">
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <?php endforeach; ?>
</div>
