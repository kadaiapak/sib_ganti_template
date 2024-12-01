    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          
          
          <div class="section-body">
            <h2 class="section-title">Daftar Beasiswa</h2>
            <p class="section-lead">Terdapat semua daftar beasiswa pada Universitas Negeri Padang</p>
            <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">

            <?= $this->session->flashdata('message'); ?>
            <?= form_error('nama_kelompok', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;" >Daftar beasiswa</h4>
                  <div class="card-header-action">
                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Beasiswa</th>
                          <th>Kelompok</th>
                          <th>Asal Beasiswa</th>
                          <th>Biaya</th>
                          <th>Periode</th>
                          <th>Tahun</th>
                          <th>SK</th>
                          <th class="text-center">Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_beasiswa as $mb) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $mb['nama_beasiswa']; ?></td>
                              <td><?= $mb['kelompok_beasiswa']; ?></td>
                              <td><?= $mb['asal_beasiswa']; ?></td>
                              <td><?= $mb['biaya']; ?></td>
                              <td><?= $mb['periode']; ?></td>
                              <td><?= $mb['tahun']; ?></td>
                              <td><?= $mb['sk'] != "" ? $mb['sk'] : "Sedang Proses" ; ?></td>
                              <td>
                                <a href="<?= base_url('bsw/detail/'.$mb['id']); ?>" class="btn btn-primary"><i class="fas fa-pencil-alt" ></i></a>
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
