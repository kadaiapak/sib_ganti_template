    
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
                    <h4 style="font-size: 20px; color: #34395e;" >Daftar Beasiswa</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-md">
                        <tr>
                          <th>#</th>
                          <th>Nama Beasiswa</th>
                          <th>Periode</th>
                          <th>Tahun</th>
                          <th>Tgl Awal Pendaftaran</th>
                          <th>Tgl Tutup Pendaftaran</th>
                          <?php if($cek_akses_user['edit'] == '1') { ?>
                            <th>Action</th>
                          <?php } ?>
                        </tr>
                        <?php $no = 1 ?>
                        <?php foreach ($master_beasiswa as $mb) { ?>
                          <tr>
                            <td><?= ++$start_at ?></td>
                            <td><?= $mb['nama_beasiswa']; ?></td>
                            <td><?= $mb['periode']; ?></td>
                            <td><?= $mb['tahun']; ?></td>
                            <td><?= $mb['tgl_awal_pendaftaran']; ?></td>
                            <td><?= $mb['tgl_tutup_pendaftaran']; ?></td>
                            <!-- <td><div class="badge badge-success">Active</div></td> -->
                            <?php if($cek_akses_user['edit'] == '1') { ?>
                            <td>
                              <a href="<?= base_url('mpersyaratan/setup-persyaratan/edit/'.$mb['id']); ?>" class="btn btn-success">Detail</a>
                            </td>
                              <?php } ?>
                          </tr>
                          <?php  } ?>
                      </table>
                    <?= $this->pagination->create_links(); ?>
                    </div>
                  </div>
              </div>

            </div>
          </div>
                          
        </section>
    </div>
    
    

   