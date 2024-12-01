<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Historis Beasiswa</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Activities</div>
            </div>
          </div>
          <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <p class="section-lead">
                   gunakan halaman ini untuk melihat status pendaftaran beasiswa saudara.
                </p>
                
            <div class="row">
              <div class="col-12">
                <div class="activities">
                  <?php if(count($historis) == '0')  { ?>
                    <div class="activity">
                      <h5>Belum ada historis pendaftaran beasiswa !</h5>
                    </div>
                  <?php } ?>
                  <?php foreach ($historis as $hs) { ?>
                      <div class="activity">
                          <div class="activity-icon bg-primary text-white shadow-primary">
                              <i class="fas fa-comment-alt"></i>
                          </div>
                          <div class="activity-detail">
                              <div class="mb-2">
                                  <span class="bullet"></span>
                                  <span class="" style="margin-right: 1rem;"><?= ($hs['status_beasiswa'] == '1' ? '<span class="badge badge-warning">Mendaftar</span>' : ($hs['status_beasiswa'] == '2' ? '<span class="badge badge-primary">Sudah Divalidasi</span>' : ($hs['status_beasiswa'] == '3' ? '<span class="badge badge-success">Di Tetapkan</span>' : '<span class="badge badge-danger">Dibatalkan</span>'))  ); ?></span>
                                  <a class="text-job"><?= $hs['nb_nama_beasiswa']; ?></a>
                                  <div class="float-right">
                                    <small><?= $hs['tanggal']; ?></small>
                                  </div>
                                  <div>
                                  </div>
                                  <span class="text-job text-primary"></span>
                              </div>
                              <p><?= $hs['keterangan']; ?> <?= $hs['nb_nama_beasiswa']; ?> periode <?= $hs['p_nama']; ?> / <?= $hs['mb_tahun']; ?> </p>
                          </div>
                      </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>