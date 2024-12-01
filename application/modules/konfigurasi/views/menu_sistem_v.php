
      <!-- Main Content -->
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>

          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <?= $this->session->flashdata('message'); ?>
            <?= $this->session->flashdata('gagal'); ?>


              <?= form_error('menu', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="color: #34395e; font-size: 20px;">Daftar Menu</h4>
                  <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <div class="card-header-action">
                      <a href="<?= base_url('konfigurasi/menu_sistem/tambah'); ?>" class="btn btn-primary">Tambah Menu Baru</a>
                    </div>
                    <?php  } ?>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 15%;">Nama Menu</th>
                          <th style="width: 5%;">Level</th>
                          <th style="width: 15%;">Url</th>
                          <th style="width: 17%;">Icon</th>
                          <th style="width: 7%;">No Urut</th>
                          <th style="width: 7%;">Aktif ?</th>
                          <th style="width: 7%;">Tampil ?</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th style="width: 12%;">Action</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                              <th><?= $m['no_urut_rapi']; ?></th>
                              <td><?= $m['nama_menu']; ?></td>
                              <td><?= $m['level']; ?></td>
                              <td><?= $m['url']; ?></td>
                              <td><?= $m['icon']; ?></td>
                              <td><?= $m['no_urut']; ?></td>
                              <td><?php if($m['aktif'] == 1) : ?>
                                  <span class="badge badge-success">Aktif</span>
                              <?php else : ?>
                                  <span class="badge badge-warning">Tidak</span>
                              <?php endif; ?></td>
                              <td><?php if($m['show'] == 1) : ?>
                                  <span class="badge badge-success">Tampil</span>
                              <?php else : ?>
                                  <span class="badge badge-warning">Tidak</span>
                              <?php endif; ?></td>
                              <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                              <td>

                                <?php if($cek_akses_user['edit'] == '1') { ?>
                                <a href="<?= base_url('konfigurasi/menu_sistem/edit/'.$m['kode_menu']); ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt" ></i></a>
                                <?php } ?>

                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                <form style="display: inline-block;" action="<?= base_url('konfigurasi/menu_sistem/hapus'); ?>" method="post" id="deleteFormMenu" >
                                <input
                                name="kode_menu"
                                type="hidden"
                                value="<?= $m['kode_menu']; ?>">
                                <button onclick="return confirm('Yakin dihapus?')" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" id="deleteButtonMenu">
                                        <i class="fas fa-trash"></i>
                                </button>
                                </form>
                                <?php } ?>
                              </td>
                              <?php } ?>
                            </tr>
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

<!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Menu</h5>
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
