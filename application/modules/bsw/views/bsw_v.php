    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          
          <div class="section-body">
            <h2 class="section-title">Detail Beasiswa</h2>
            <div class="row">
              <div class="col-lg-12 col-md-6 col-6 col-sm-6">
                <p class="section-lead">Untuk upload penerima beasiswa, silahkan pilih detail beasiswanya terlebih dahulu, jangan sampai salah dalam memilih beasiswa dan melakukan proses upload</p>
              
              </div>
            </div>
            <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <?= $this->session->flashdata('message'); ?>
            <?= form_error('nama_kelompok', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              
              <div class="card card-warning">
                <div class="card-header d-flex">
                  <h4 style="font-size: 20px; color: #34395e;" >Daftar Beasiswa</h4>
                  <form action="<?= base_url('bsw/cari'); ?>" method="post" class="d-flex align-items-center">
                    <select class="form-control" name="tahun_beasiswa_master" id="tahun_beasiswa_master" style="width: 150px; border-radius: 10px;">
                        <option value="" selected>Pilih Tahun</option>
                          <?php 
                          $year =  date("Y");
                          for ($i= $year - 5; $i <= $year  ; $i++) { ?>
                            <option value="<?= $i ?>" <?= $this->session->userdata('tahun_beasiswa_master') == $i ? "selected" : null ?>><?= $i ?></option>   
                          <?php }  ?>
                    </select>
                    <button style="margin-left: 10px; padding-top : 7px; padding-bottom : 7px; width: 150px; border-radius: 10px;" type="submit" class="btn btn-primary tombolsimpan"><i class="fas fa-folder-open mr-2"></i>Tampilkan</button>
                  </form>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Beasiswa</th>
                          <th>Kelompok</th>
                          <th>Asal Beasiswa</th>
                          <th>Biaya</th>
                          <th>Periode</th>
                          <th>Tahun</th>
                          <th class="text-center">Upload</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_beasiswa as $mb) : ?>
                            <tr>
                              <td><?= ++$start_at; ?></td>
                              <td><?= $mb['nama_beasiswa']; ?></td>
                              <td><?= $mb['kelompok_beasiswa']; ?></td>
                              <td><?= $mb['asal_beasiswa']; ?></td>
                              <td><?= ($mb['biaya'] ? 'Rp.'.number_format($mb['biaya'],2,',','.') : '')?></td>
                              <td><?= $mb['periode']; ?></td>
                              <td><?= $mb['tahun']; ?></td>
                              <td>
                                <a href="<?= base_url('bsw/detail/'.$mb['id']); ?>" class="btn btn-primary"><i class="fas fa-pencil-alt" ></i></a>
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
