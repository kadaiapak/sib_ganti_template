<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Beasiswa Oleh Admin</h1>
        </div>

        <!-- notification -->
        <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
        <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
        <!-- end of notification -->

        <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <p class="section-lead">
                halaman ini digunakan oleh admin untuk melakukan pendaftaran beasiswa.<br>
                silahkan pilih beasiswa yang tersedia.
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;" >List Beasiswa yang buka pendaftaran</h4>
                        </div>
                        <div class="card-body">
                            <?php foreach($master_beasiswa as $mb) : ?>
                            <!-- awal dari show hide card -->
                            <div class="card" style="border: 2px solid #F4F6F9;">
                                <div class="card-header">
                                    <h4 style="font-size: 15px; color: #34395e;"><?= $mb['nama_beasiswa']; ?> (Periode <?= $mb['periode']; ?> / <?= $mb['tahun']; ?>)</h4>
                                    <div class="card-header-action">
                                        <a data-collapse="#mycard-collapse<?= $mb['id'] ?>" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="collapse show" id="mycard-collapse<?= $mb['id'] ?>">
                                    <div class="card-body">
                                        Periode <?= $mb['periode']; ?> / <?= $mb['tahun']; ?> </br>
                                        Maksimum Pendaftar <?= $mb['kuota_pendaftaran']; ?> orang </br>
                                        Pendaftaran Dimulai tanggal <?= date('d M, Y',strtotime($mb['tgl_awal_pendaftaran'])); ?></br>
                                        Sampai Tanggal <?= date('d M, Y',strtotime($mb['tgl_tutup_pendaftaran'])); ?></br>
                                    </div>
                                    <div class="card-footer">
                                        <a href="<?= base_url('daftar-beasiswa-admin/detail/'.$mb['id']); ?> " class="btn btn-success btn-xs"> <i class="fas fa-user-check"></i> Detail Beasiswa</a>
                                        <a href="<?= base_url('daftar-beasiswa-admin/list-mahasiswa/'.$mb['id']); ?> " class="btn btn-primary btn-xs"> <i class="fas fa-database"></i> List Pendaftar</a>
                                    </div>
                                </div>
                            </div>
                            <!-- akhir dari show hide card -->
                            <?php endforeach ; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>