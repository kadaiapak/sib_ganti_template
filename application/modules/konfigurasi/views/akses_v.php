    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>

          <div class="row">
            <div class="col-lg-12 col-md-12">
              <?= $this->session->flashdata('message'); ?>
              <?= form_error('role', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('nama_panjang', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('id_beasiswa', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>

              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;">Daftar Role</h4>  
                  <div class="card-header-action">
                    <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#roleModal">
                      Tambah Role Baru
                    </button>
                    <?php } ?>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Role</th>
                          <th>Nama Asli</th>
                          <th>Akses Beasiswa</th>
                          <th>Akses Fakultas</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th>Action</th>
                          <?php } ?>
                        </tr>
      
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($role as $r) : ?>
                            <tr>
                              <td><?= ++$start_at; ?></td>
                              <td><?= $r['role']; ?></td>
                              <td><?= $r['nama_panjang']; ?></td>
                              <td><?= $r['id_beasiswa'] == NULL ? 'Bukan Admin Beasiswa' : ($r['id_beasiswa'] == '0' ? 'Semua Beasiswa' : $r['nama_beasiswa']) ; ?></td>
                              <td><?= $r['id_fakultas'] == NULL ? 'Bukan Admin Fakultas' : ($r['id_fakultas'] == '0' ? 'Semua Fakultas' : $r['nama_panjang_fakultas']) ; ?></td>
                              <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') { ?>
                                <a href="<?= base_url('konfigurasi/akses/roleaccess/') . $r['id']; ?>"  class="btn btn-warning btn-action mr-1" data-toggle="tooltip" title="Role access"><i class="fas fa-user-alt-slash"></i></a>
                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-toggle="modal" title="Edit" data-target="#editRoleModal<?= $r['id']; ?>"><i class="fas fa-pencil-alt" ></i></button>
                                <?php  } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                <form style="display: inline-block;" action="<?= base_url('konfigurasi/akses/hapus'); ?>" method="post">
                                <input 
                                name="role_id"
                                type="hidden" 
                                value="<?= $r['id']; ?>">    
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

        <!-- Modal tambah role-->
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="roleModalLabel">Tambah Role Baru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('konfigurasi/akses');?>" method="post">
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="text" class="form-control" id="role" name="role" placeholder="Role title ...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="nama_panjang" name="nama_panjang" placeholder="Nama Panjang ...">
                    </div>
                    <div class="form-group">
                          <label for="name">Pilih Beasiswa :</label>
                          <select class="form-control" name="id_beasiswa" id="id_beasiswa">
                                <option value=''>Pilih Akses Beasiswa</option>
                                <option value='NULL'>Bukan Admin Beasiswa</option>
                                <?php foreach ($nama_beasiswa as $nb) :?>
                                <option value="<?= $nb['id']; ?>"><?= $nb['nama_beasiswa']; ?></option>
                                <?php endforeach; ?>
                                <option value="0">Semua Beasiswa</option>
                          </select>
                    </div>
                    <div class="form-group">
                          <label for="name">Pilih Fakultas :</label>
                          <select class="form-control" name="id_fakultas" id="id_fakultas">
                                <option value=''>Pilih Fakultas</option>
                                <option value='NULL'>Bukan Admin Fakulas</option>
                                <?php foreach ($nama_fakultas as $nf) :?>
                                <option value="<?= $nf['id']; ?>"><?= $nf['nama_panjang_fakultas']; ?></option>
                                <?php endforeach; ?>
                                <option value="0">Semua Fakultas</option>
                          </select>
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
       <!-- Akhir modal tambah role -->

        <!-- Modal edit role -->
        <?php $no = 0; ?>
          <?php foreach ($role as $r) : $no++ ?>
          <div class="modal fade" id="editRoleModal<?= $r['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="<?= base_url('konfigurasi/akses/edit');?>" method="post">
                <input type="hidden" name="id" value="<?= $r['id']; ?>">
                  <div class="modal-body">
                    <div class="form-group">
                      <input value="<?= $r['role']; ?>" type="text" class="form-control" id="role" name="role" placeholder="Nama Role ...">
                    </div>
                    <div class="form-group">
                      <input value="<?= $r['nama_panjang']; ?>" type="text" class="form-control" id="nama_panjang" name="nama_panjang" placeholder="Nama Panjang ...">
                    </div>
                    <div class="form-group">
                          <label for="name">Pilih Beasiswa :</label>
                          <select class="form-control" name="id_beasiswa" id="id_beasiswa">
                                <option value="">Beasiswa ...</option>
                                <option value="NULL" <?= NULL == $r['id_beasiswa'] ? "selected" : ""; ?>>Bukan Admin Beasiswa</option>
                                <?php foreach ($nama_beasiswa as $nb) :?>
                                <option value="<?= $nb['id']; ?>" <?= $nb['id'] == $r['id_beasiswa'] ? "selected" : ""; ?>><?= $nb['nama_beasiswa']; ?></option>
                                <?php endforeach; ?>
                                <option value="0" <?= '0' == $r['id_beasiswa'] ? "selected" : ""; ?>>Semua Beasiswa</option>
                          </select>
                    </div>
                    <div class="form-group">
                          <label for="name">Pilih Fakultas :</label>
                          <select class="form-control" name="id_fakultas" id="id_fakultas">
                                <option value="">Fakultas ...</option>
                                <option value="NULL" <?= NULL == $r['id_fakultas'] ? "selected" : ""; ?>>Bukan Admin Fakultas</option>
                                <?php foreach ($nama_fakultas as $fk) :?>
                                <option value="<?= $fk['id']; ?>" <?= $fk['id'] == $r['id_fakultas'] ? "selected" : ""; ?>><?= $fk['nama_panjang_fakultas']; ?></option>
                                <?php endforeach; ?>
                                <option value="0" <?= '0' == $r['id_fakultas'] ? "selected" : ""; ?>>Semua Fakultas</option>
                          </select>
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
        <!-- Akhir modal edit role -->
      </div>