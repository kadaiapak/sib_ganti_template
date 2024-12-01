    
      <!-- Main Content -->
      <div class="main-content">
          <section class="section">
              <div class="section-header">
                  <h1><?= $title; ?></h1>
              </div>
              
              <div class="section-body">
                  <h2 class="section-title">Detail Beasiswa</h2>
                  <div class="row">
                      <div class="col-lg-16 col-md-6 col-6 col-sm-6">
                          <p class="section-lead">List beasiswa yang di daftar</p>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                          <div class="card card-warning">
                              <div class="card-header">
                                  <h4 style="font-size: 20px; color: #34395e;" >List Beasiswa</h4>
                                  <div class="card-header-action">
                                  </div>
                              </div>

                              <div class="card-body p-0">
                                  <div class="table-responsive table-invoice">
                                      <table class="table table-striped table-bordered table-hover">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Nama Beasiswa</th>
                                                  <th>Periode</th>
                                                  <th>Tahun</th>
                                                  <th>Nama Mahasiswa</th>
                                                  <th>Tanggal Pendaftaran</th>
                                                  <th>Status Pendaftaran Beasiswa</th>
                                                  <th class="text-center">Detail</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php $i = 1; ?>
                                              <?php foreach ($master_beasiswa as $mb) : ?>
                                              <tr>
                                                  <td><?= ++$start_at; ?></td>
                                                  <td><?= $mb['nama_beasiswa']; ?></td>
                                                  <td><?= $mb['nama_periode']; ?></td>
                                                  <td><?= $mb['tahun']; ?></td>
                                                  <td><?= $mb['nama_mahasiswa']; ?></td>
                                                  <td><?= $mb['tanggal_daftar']; ?></td>
                                                  <td><?= $mb['status_beasiswa'] == 0 ? "<div class='badge badge-warning'>Menunggu Validasi Fakultas</div>" : ($mb['status_beasiswa'] == 11 ? "<div class='badge badge-danger'>Pendaftaran Ditolak Fakultas</div>" : ($mb['status_beasiswa'] == 1 ? "<div class='badge badge-primary'>Menunggu Validasi Admin Universitas</div>" : ($mb['status_beasiswa'] == 2 ? "<div class='badge badge-primary'>Sudah Validasi Admin Universitas</div>" : ($mb['status_beasiswa'] == 3 ? "<div class='badge badge-success'>Ditetapkan sebagai penerima</div>" : "") ))) ?></td>
                                                  <td>
                                                      <a href="<?= base_url('status-pendaftaran/detail/'.$mb['id_mahasiswa_beasiswa']); ?>" class="btn btn-primary"><i class="fas fa-info mr-2" ></i>Detail</a>
                                                  </td>
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
            </div>
            
                    
          
          </section>
          <!-- Modal -->
            <div class="modal fade" id="kelompokBeasiswaModal" tabindex="-1" role="dialog" aria-labelledby="kelompokBeasiswaModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title" id="kelompokBeasiswaModalLabel">Add New Kelompok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="<?= base_url('master/kelompokbeasiswa');?>" method="post">

                    <div class="modal-body">
                      <div class="form-group">
                        <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok" placeholder="Beasiswa Group name ...">
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
