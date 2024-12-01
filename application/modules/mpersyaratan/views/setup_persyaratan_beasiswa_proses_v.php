
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
              <div class="card">
                <div class="card-header">
                  <h4><?= $master_beasiswa->nama_beasiswa; ?>,</h4>
                  <h4><?= $master_beasiswa->periode; ?> /</h4>
                  <h4><?= $master_beasiswa->tahun; ?></h4>
                </div>

                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                      <thead>
                        <tr>
                          <th style="width: 5%;">#</th>
                          <th style="width: 25%;">Nama</th>
                          <th style="width: 20%;">Alias</th>
                          <th style="width: 30%;">Keterangan</th>
                          <th style="width: 10%;">Ceklis Persyaratan</th>
                          <th style="width: 10%;">Apakah Wajib</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_persyaratan as $mp) : ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $mp['persyaratan']; ?></td>
                              <td><?= $mp['alias']; ?></td>
                              <td><?= $mp['keterangan']; ?></td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input persyaratan" type="checkbox" <?= persyaratan_beasiswa($master_beasiswa->id, $mp['id']); ?>
                                        data-beasiswa="<?= $master_beasiswa->id; ?>"
                                        data-persyaratan="<?= $mp['id']; ?>" >
                                    </div>
                                  </div>
                              </td>
                              <td>
                                  <div class="form-group">
                                     <div class="form-check">
                                        <input class="form-check-input persyaratanWajib" type="checkbox" <?= persyaratan_beasiswa_wajib($master_beasiswa->id, $mp['id']); ?>
                                        data-beasiswa="<?= $master_beasiswa->id; ?>"
                                        data-persyaratan="<?= $mp['id']; ?>">
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
