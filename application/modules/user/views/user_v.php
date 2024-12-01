    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div class="row">
            <div class="col-lg">
              <?= $this->session->flashdata('message'); ?>
              <?= form_error('menu_id', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('title', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('url', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('icon', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="color: #34395e; font-size: 20px;">Daftar User</h4>
                  <div class="card-header-action">
                    <?php if($cek_akses_user['tambah'] == '1') { ?>
                    <a href="<?= base_url('user/tambah'); ?>" class="btn btn-primary">
                        Tambah User
                    </a>
                    <?php } ?>
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead style="width: 100%;">
                        <tr>
                          <th style="width: 2%;">#</th>
                          <th style="width: 18%;">Name</th>
                          <th style="width: 15%;">Username</th>
                          <th style="width: 15%;">Email</th>
                          <th style="width: 10%;">Role</th>
                          <th style="width: 10%;">Is Active</th>
                          <th style="width: 15%;">Date Created</th>
                          <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') { ?>
                          <th style="width: 15%;">Action</th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($allUser as $u) : ?>
                            <tr>
                              <td><?= ++$start_at; ?></td>
                              <td><?= $u['name']; ?></td>
                              <td><?= $u['username']; ?></td>
                              <td><?= $u['email']; ?></td>
                              <td><?= $u['role']; ?></td>
                              <td><?php if($u['is_active'] == 1) : ?>
                                  <span class="badge badge-success">Active</span>
                              <?php else : ?>
                                  <span class="badge badge-warning">Not Active</span>
                              <?php endif; ?></td>
                               
                              <td><?= date('d F Y', $u['date_created']); ?></td>
                              <?php if($cek_akses_user['edit'] == '1' || $cek_akses_user['hapus'] == '1') {?>
                              <td>
                                <?php if($cek_akses_user['edit'] == '1') { ?>
                                <a href="<?= base_url('user/edit/'.$u['id']); ?>" class="btn btn-primary"><i class="fas fa-pencil-alt" ></i></a>
                                <?php } ?>
                                <?php if($cek_akses_user['hapus'] == '1') { ?>
                                <form action="<?= base_url('user/hapus'); ?>" method="post" style="display: inline-block;">
                                <input 
                                name="user_id"
                                type="hidden" 
                                value="<?= $u['id']; ?>">    
                                <button onclick="return confirm('Hapus user ?')" class="btn btn-danger btn-action hapus-user" data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                </button>
                                </form>
                                <?php  } ?>
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
      </div>