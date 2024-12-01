<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Beasiswa</h1>
            </div>

            <!-- notification -->
            <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
            <!-- end of notification -->

            <div class="section-body">
                <h2 class="section-title">Keterangan</h2>
                <p class="section-lead">
                    halaman ini digunakan oleh admin Universitas Negeri Padang untuk melakukan validasi.<br>
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="color: #34395e; font-size: 20px;">Daftar Beasiswa yang akan divalidasi pendaftarnya</h4>
                            </div>
                            <div class="card-body">
                                <?php foreach($master_beasiswa as $mb) : ?>
                                <div class="alert alert-light alert-has-icon p-4">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 col-sm-4">
                                                <div class="alert-title">Beasiswa : <?= $mb['nama_beasiswa']; ?></div>
                                                <p>Periode : <?= $mb['periode']; ?> / <?= $mb['tahun']; ?></p>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="alert-title">Tanggal Pendaftaran</div>
                                                <p>mulai <?= $mb['tgl_awal_pendaftaran']; ?></p>
                                                <p>sampai <?= $mb['tgl_tutup_pendaftaran']; ?></p>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="alert-title">Tanggal Penetapan</div>
                                                <p>mulai <?= $mb['tgl_awal_penetapan']; ?></p>
                                                <p>sampai <?= $mb['tgl_tutup_penetapan']; ?></p>    
                                            </div>
                                        </div>

                                        <p class="mt-3">
                                            <a href="<?= base_url('validasi/detail/'.$mb['id']); ?> " class="btn btn-success btn-xs"> <i class="fas fa-calendar-alt"></i> Lihat Daftar Mahasiswa</a>
                                        </p> 
                                    </div>
                                </div>
                                <?php endforeach ; ?>
                            </div>
                    </div>
                </div>
                </div>
          </div>
        </section>
      </div>