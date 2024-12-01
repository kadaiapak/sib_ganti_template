    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= $title; ?></h1>
          </div>
          <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
          
          <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <?= form_error('nama_kelompok', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              
              <div class="card card-warning">
                <div class="card-header">
                  <h4 style="font-size: 20px; color: #34395e;" >Beasiswa Group List</h4>
                  <div class="card-header-action">
                    <?php if($cek == '1') { ?>
                      <a href="<?= base_url('mbeasiswa/master_beasiswa/tambah'); ?>" class="btn btn-primary">
                          Tambah Master Beasiswa
                      </a>
                    <?php } ?>
                   
                  </div>
                </div>

                <div class="card-body">
                  <div>
                    <table class="table table-striped table-hover table-bordered" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="width: 2%;">#</th>
                          <th style="width: 18%;">Nama Beasiswa</th>
                          <th style="width: 15%;">Kelompok</th>
                          <th style="width: 10%;">Asal Beasiswa</th>
                          <th style="width: 10%;">Jenis Beasiswa</th>
                          <th style="width: 5%;">Bantuan</th>
                          <th style="width: 10%;">Periode</th>
                          <th style="width: 5%;">Tahun</th>
                          <th style="width: 10%;">Metode Pembayaran</th>
                          <?php if($cek_akses_user['edit'] == '1') { ?>
                          <th style="width: 15%;">Action</th>
                            <?php } ?>
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
                              <td><?= $mb['jenis_beasiswa']; ?></td>
                              <td><?= 'Rp.'.number_format($mb['biaya'],2,',','.') ?></td>
                              <td><?= $mb['periode']; ?></td>
                              <td><?= $mb['tahun']; ?></td>
                              <td><?= $mb['metode_pembayaran']; ?></td>
                              <?php if($cek_akses_user['edit'] == '1') { ?>
                              <td>
                                    <a href="<?= base_url('data_beasiswa/nonaktif/edit/'.$mb['id']); ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt" ></i></a>
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
      
      </div>
