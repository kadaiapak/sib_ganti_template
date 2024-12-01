
<div class="main-content">
        <section class="section">
            <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
            <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>

            <div class="section-header">
                <h1>Detail Mahasiswa</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Detail Mahasiswa</h2>
                <p class="section-lead">
                Menampilkan detail informasi berkas pendaftaran <?= $mahasiswa->nama_mahasiswa; ?>
                </p>
                <div class="row">
                    <div class="col-12 col-md-9 col-lg-9">
                        <div class="card card-warning">  
                            <table class="table table-striped table-bordered mb-0">
                                <tr>
                                    <td class="font-weight-bold">Nomor Induk Mahasiswa (NIM) / Tahun Masuk</td>
                                    <td><?= $mahasiswa->nim_mahasiswa; ?> / <?= $mahasiswa->tm_msk; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Mahasiswa</td>
                                    <td><?= $mahasiswa->nama_mahasiswa; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Prodi / Jenjang Pendidikan</td>
                                    <td><?= ($mahasiswa->prodi ?? "-"); ?> / <?= $mahasiswa->jjp; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Fakultas</td>
                                    <td><?= ($mahasiswa->fakultas ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td><?= ($mahasiswa->jenis_kelamin  == 'P' ? "Perempuan" : ($mahasiswa->jenis_kelamin == 'L' ? 'Laki - Laki' : null)); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">No Hp</td>
                                    <td><?= ($mahasiswa->nohp ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tempat / Tgl Lahir</td>
                                    <td><?= $mahasiswa->tmp_lhr; ?> / <?= $mahasiswa->tgl_lhr; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Agama</td>
                                    <td><?= ($mahasiswa->agama ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tanggal Daftar</td>
                                    <td><?= ($mahasiswa->tanggal_daftar ? $mahasiswa->tanggal_daftar : '') ; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Perkuliahan</td>
                                    <td><?= ($cek_aktif == 1 ? "<span class='badge badge-success'>Mahasiswa Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
                                </tr>
                                
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Photo</h4>
                            </div>
                            <div class="card-body">
                                <!-- <?php if($mahasiswa->photo != null){ ?>
                                    <div class="chocolat-parent">
                                        <a href="<?= base_url(); ?>uploads/image/<?= $mahasiswa->photo; ?>" class="chocolat-image" title="Just an example">
                                            <div>
                                                <img alt="image" src="<?= base_url(); ?>uploads/image/<?= $mahasiswa->photo; ?>" class="img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                <?php }else { ?> -->
                                    <div class="chocolat-parent">
                                        <a href="https://cdn.unp.ac.id/portal/<?= $mahasiswa->nim_mahasiswa ?>.jpg" class="chocolat-image" title="<?= $mahasiswa->nama_mahasiswa; ?>">
                                            <div>
                                                <img alt="image" src="https://cdn.unp.ac.id/portal/<?= $mahasiswa->nim_mahasiswa ?>.jpg" class="img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                <!-- <?php } ?> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="row p-3">
                                <div class="col-xl-4">
                                    
                                    <h5 class="text-danger">Proses Pendaftaran</h5>
                                    <!-- <div class="mb-1 mb-xl-0">
                                        <span class="pr-2"> Kode Akses : 443fc0</span>
                                    </div> -->
                                    <div>
                                            <!-- <a  href="< ?php redirect(); ?>" class="btn btn-primary btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a> -->
                                            <a  href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
                                        </div>
                                </div>
                                <div class="col-xl-8 text-right">
                                    <p class="mb-2 mb-xl-0">Didaftarkan Oleh : <?= $mahasiswa->admin_yang_mendaftarkan; ?></p>
                                    <div class="action-button" style="display: flex; justify-content: flex-end;">
          
                                        <?php if($cek_akses_user['hapus'] == '1' AND $user_created == $this->session->userdata('userid')) { ?>
                                        <form action="<?= base_url('daftar-beasiswa-admin/hapus'); ?>" method="post" style="display: inline-block; margin-left: 10px;">
                                            <input type="hidden" value="<?= $mahasiswa->id_beasiswa ?>" name="id_beasiswa">
                                            <input type="hidden" value="<?= $mahasiswa->nim_mahasiswa ?>" name="nim_mahasiswa">
                                            <button type="submit" class="btn btn-danger btn-icon icon-left">
                                                <i class="fas fa-trash-alt"></i>Hapus Pendaftaran
                                            </button>
                                        </form>
                                        <?php } ?>
                                        <!-- <form action="< ?= base_url('daftar-beasiswa-admin/'.$mahasiswa->id_beasiswa.'/'.$mahasiswa->nim_mahasiswa.'/hapus'); ?>" method="post" id="deleteFormTetapkanCalon" style="display: inline-block; margin-left: 10px;">
                                            <button type="submit" class="btn btn-danger btn-icon icon-left" id="deleteButtonTetapkanCalon">
                                                <i class="fas fa-trash-alt"></i>Hapus Pendaftaran
                                            </button>
                                        </form> -->
                                        <div class="btn-group mb-1" role="group" style="margin-left: 10px;">
                                            <a href="" class="btn btn-success text-decoration-none">
                                                <i class="fas fa-pencil-alt"></i> Perbarui Berkas
                                            </a>
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="" class="dropdown-item text-dark text-decoration-none px-3">
                                                        <i class="fas fa-print mr-1"></i> Cetak Kartu Peserta
                                                    </a>
                                            </div>
                                        </div>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="color: #34395e; font-size: 20px;">Kelengkapan Berkas Persyaratan Pendaftar :</h4>
                            </div>
                            <div class="card-body">
                                <?php if(count($berkas_pendaftaran) == 0) { ?>
                                <h5>Sedang dalam proses ..</h5>
                                <?php }; ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php $n = 1; ?>
                                    <?php foreach($berkas_pendaftaran as $b) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $n == 1 ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="#b<?= $b['id'] ?>" role="tab" aria-controls="profile"   aria-selected="false">
                                            <?= $b['judul'] ?>
                                        </a>
                                    </li>
                                    <?php $n++; ?>
                                    <?php endforeach ; ?>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <?php $no = 1; ?>
                                    <?php foreach ($berkas_pendaftaran as $b) : ?>
                                    <div class="tab-pane fade <?= $no == 1 ? 'show active' : null; ?>" id="b<?= $b['id'] ?>" role="tabpanel" aria-labelledby="profile-tab">
                                        <object data="<?= base_url('uploads/persyaratan/'.$b['nama_file']); ?>" width="100%" height="380px"></object>
                                    </div> 
                                    <?php $no++ ?>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
</div>