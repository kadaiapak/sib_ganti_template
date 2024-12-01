    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>

          
          
          <div class="row">

            <div class="col-lg-12 col-md-12">
            <?= $this->session->flashdata('message'); ?>

              <?= form_error('menu_id', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="color: #34395e; font-size: 20px;" >Role : <?= $role['role']; ?></h4>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Menu</th>
                          <th>Url</th>
                          <th>Level</th>
                          <th>Akses</th>
                          <th>Tambah</th>
                          <th>Edit</th>
                          <th>Hapus</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $m['nama_menu']; ?></td>
                              <td><?= $m['url']; ?></td>
                              <td><?= $m['level']; ?></td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input akses" type="checkbox" <?= check_access($role['id'], $m['kode_menu']); ?>
                                        data-role="<?= $role['id']; ?>"
                                        data-menu="<?= $m['kode_menu']; ?>" >
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input tambah" type="checkbox" <?= check_tambah($role['id'], $m['kode_menu']); ?>
                                        data-role="<?= $role['id']; ?>"
                                        data-menu="<?= $m['kode_menu']; ?>" >
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input edit" type="checkbox" <?= check_edit($role['id'], $m['kode_menu']); ?>
                                        data-role="<?= $role['id']; ?>"
                                        data-menu="<?= $m['kode_menu']; ?>" >
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input hapus" type="checkbox" <?= check_hapus($role['id'], $m['kode_menu']); ?>
                                        data-role="<?= $role['id']; ?>"
                                        data-menu="<?= $m['kode_menu']; ?>" >
                                    </div>
                                  </div>
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
