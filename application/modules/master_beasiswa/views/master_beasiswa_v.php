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
                  <h4 style="font-size: 20px; color: #34395e;" >Daftar Master Beasiswa</h4>
                  <div class="card-header-action">
                    <?php if($cek == '1') { ?>
                      <a href="<?= base_url('mbeasiswa/master_beasiswa/tambah'); ?>" class="btn btn-primary">
                          Tambah Master Beasiswa
                      </a>
                    <?php } ?>

                  </div>
                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="width: 100%;">
                      <thead>
                        <tr>
                          <th style="width: 2%;">#</th>
                          <th style="width: 22%;">Nama Beasiswa</th>
                          <th style="width: 12%;">Periode</th>
                          <th style="width: 5%;">Tahun</th>
                          <th style="width: 8%;">Buka Pendaftaran</th>
                          <th style="width: 8%;">Aktif</th>
                          <th style="width: 8%;">Tampilkan</th>
                          <th style="width: 20%;">Jenis Beasiswa</th>
                          <th style="width: 15%;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_beasiswa as $mb) : ?>
                            <tr>
                              <td><?= ++$start_at; ?></td>
                              <td><?= $mb['nama_beasiswa']; ?></td>
                              <td><?= $mb['periode']; ?></td>
                              <td><?= $mb['tahun']; ?></td>
                              <td><?= $mb['buka_pendaftaran'] == '1' ? '<span class="badge badge-success">Buka</span>' : '<span class="badge badge-warning">Tidak</span>'; ?></td>
                              <td><?= $mb['aktif'] == '1' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-warning">Tidak</span>'; ?></td>
                              <td><?= $mb['tampil'] == '1' ? '<span class="badge badge-success">Tampil</span>' : '<span class="badge badge-warning">Tidak</span>'; ?></td>
                              <td><?= $mb['jenis_beasiswa']; ?></td>
                              <td>
                                <a href="<?= base_url('mbeasiswa/master_beasiswa/edit/'.$mb['id']); ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt" ></i></a>
                                  <!-- <form id="deleteFormMasterBeasiswa" style="display: inline-block;" action="< ?= base_url('mbeasiswa/master_beasiswa/del'); ?>" method="post">
                                    <input name="master_beasiswa_id" type="hidden" value="< ?= $mb['id']; ?>">
                                    <button id="deleteButtonMasterBeasiswa" class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash"></i>
                                    </button>
                                  </form> -->
                                  <a href="<?= base_url(); ?>mbeasiswa/master_beasiswa/del/<?= $mb['id']; ?>" class="btn btn-danger btn-action mr-1 deleteButtonMasterBeasiswa" data-toggle="tooltip" title="Edit"><i class="fas fa-trash" ></i></a>
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


        </section>

      </div>
