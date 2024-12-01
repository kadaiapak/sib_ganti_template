    
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
              <div class="card">
                <div class="card-header">
                    <h4>Daftar Beasiswa</h4>
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
                            <td><?= $no++; ?></td>
                            <td><?= $mb['nama_beasiswa']; ?></td>
                            <td><?= $mb['periode']; ?></td>
                            <td><?= $mb['tahun']; ?></td>
                            <td><?= $mb['tgl_awal_pendaftaran']; ?></td>
                            <td><?= $mb['tgl_tutup_pendaftaran']; ?></td>
                            <?php if($cek_akses_user['edit'] == '1') { ?>
                            <td>  
                              <a href="<?= base_url('mpersyaratan/setup-persyaratan/edit/'.$mb['id']); ?>" class="btn btn-success">Detail</a>
                            </td>
                              <?php } ?>
                          </tr>
                          <?php  } ?>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                    <nav class="d-inline-block">
                      <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
              </div>

            </div>
          </div>
                          
        </section>
    </div>
    
    

   