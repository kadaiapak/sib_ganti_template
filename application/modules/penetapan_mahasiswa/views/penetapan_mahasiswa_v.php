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
                    halaman ini digunakan oleh admin partnership dalam melakukan penetapan penerima.<br>
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="font-size: 20px; color: #34395e;">Daftar Beasiswa yang akan ditetapkan :</h4>
                            </div>
                            <div class="card-body">
                                <?php foreach($master_beasiswa as $mb) : ?>
                                <div class="alert alert-light alert-has-icon p-4">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-lg-4">
                                                <div class="alert-title">Beasiswa : <?= $mb['nama_beasiswa']; ?></div>
                                                <p>Periode : <?= $mb['periode']; ?> / <?= $mb['tahun']; ?></p>
                                                <p>Kuota beasiswa <?= $mb['kuota_penetapan']; ?> orang</p>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="alert-title">Tanggal Pendaftaran</div>
                                                <p>mulai tanggal : <?= $mb['tgl_awal_pendaftaran']; ?></p>
                                                <p>sampai tanggal <?= $mb['tgl_tutup_pendaftaran']; ?></p>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-lg-4">
                                                <div class="alert-title">Tanggal Penetapan</div>
                                                <p>mulai tanggal <?= $mb['tgl_awal_penetapan']; ?></p>
                                                <p>sampai tanggal <?= $mb['tgl_tutup_penetapan']; ?></p>
                                            </div>
                                        </div>
                                      
                                        <p class="mt-3">
                                            <a href="<?= base_url('penetapan-mahasiswa/detail/'.$mb['id']); ?> " class="btn btn-success btn-xs"> <i class="fas fa-calendar-alt"></i> Lihat Daftar Mahasiswa</a>
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