<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dafar Mahasiswa</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Detail Mahasiswa</h2>
                <p class="section-lead">
                Menampilkan detail informasi berkas pendaftaran <?= $mahasiswa->nama_mahasiswa; ?>
                </p>
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
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
                                            <td class="font-weight-bold">IPK</td>
                                            <td><?= ($mahasiswa->ipk ?? "-"); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Jalur Masuk</td>
                                            <td><?= ($mahasiswa->nama_jalur_masuk_pendaftar); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Besar UKT</td>
                                            <td>Rp. <?= ($mahasiswa->ukt); ?></td>
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
                                            <td class="font-weight-bold">No Hp Terbaru</td>
                                            <td><?= ($mahasiswa->tulis_nohp); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">NIK</td>
                                            <td><?= ($mahasiswa->tulis_nik); ?></td>
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
                                            <td class="font-weight-bold">Email</td>
                                            <td><?= ($mahasiswa->tulis_email); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Daftar</td>
                                            <td><?= ($mahasiswa->tanggal_daftar ? $mahasiswa->tanggal_daftar : '') ; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <?php if($comment) { ?>
                                <div class="card card-warning">
                                    <div class="card-header" >
                                        Pesan
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($comment as $cm) { ?>
                                            <div class="form-group">
                                                <label><?= $cm['user_comment']; ?></label>
                                                <input type="text" class="form-control" readonly="" value="<?= $cm['isi']; ?>">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between font-weight-bold">
                                            <h5 class="m-0">Status Pendaftar</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-primary mb-0">
                                            <span style="font-size: 1.3rem;">
                                                <i class="fas fa-check-circle"></i> <?= ($mahasiswa->status_beasiswa == '0' ? 'Menunggu Validasi Fakultas' : ($mahasiswa->status_beasiswa == '1' ? 'Menunggu Validasi Universitas' : ($mahasiswa->status_beasiswa == '11' ? 'Pencalonan ditolak' : ($mahasiswa->status_beasiswa == '3' ? 'Ditetapkan Sebagai Penerima' : '')))); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                               <div class="card card-warning">
                                    <div class="card-header">
                                        <h4 style="font-size: 20px; color: #34395e;">Photo</h4>
                                    </div>
                                    <div class="card-body">
                                            <div class="chocolat-parent">
                                                <a href="https://cdn.unp.ac.id/portal/<?= $mahasiswa->nim_mahasiswa; ?>.jpg" class="chocolat-image" title="Just an example">
                                                    <div>
                                                        <img alt="image" src="https://cdn.unp.ac.id/portal/<?= $mahasiswa->nim_mahasiswa; ?>.jpg" class="img-fluid">
                                                    </div>
                                                </a>
                                            </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                <a  href="<?= base_url('status-pendaftaran'); ?>" class="btn btn-primary btn-icon icon-left"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
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
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php if($mahasiswa->tulis_nama_ayah) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="datakeluarga-tab" data-toggle="tab" href="#datakeluarga" role="tab" aria-controls="datakeluarga" aria-selected="true">Data Keluarga</a>
                                    </li>
                                    <?php } ?>
                                    <?php if($mahasiswa->tulis_no_rekening) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="rekening-tab" data-toggle="tab" href="#rekening" role="tab" aria-controls="rekening" aria-selected="false">Rekening</a>
                                    </li>
                                    <?php  }?>
                                    <?php if($mahasiswa->nama_status_rumah) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="rumah-tab" data-toggle="tab" href="#rumah" role="tab" aria-controls="rumah" aria-selected="false">Data Rumah</a>
                                    </li>
                                    <?php  }?>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rekening</a>
                                    </li> -->
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
                                    <?php if($mahasiswa->tulis_nama_ayah) { ?>
                                    <div class="tab-pane fade show active" id="datakeluarga" role="tabpanel" aria-labelledby="datakeluarga-tab">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <table class="table table-sm table-bordered mb-4">
                                                    <tr colspan="2" class="font-weight-bold bg-striped" style="background-color: #6c757d; font-size: 20px; color: aliceblue;">
                                                        <td colspan="2" class="font-weight-bold bg-striped">Informasi Ayah</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">Nama Ayah</td>
                                                        <td><?= $mahasiswa->tulis_nama_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Ayah</td>
                                                        <td><?= $mahasiswa->nama_status_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hubungan dengan Ayah</td>
                                                        <td><?= $mahasiswa->nama_hub_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pendidikan</td>
                                                        <td><?= $mahasiswa->nama_pendidikan_ayah; ?></td>
                                                    </tr>
                                                     <tr>
                                                        <td>Golongan Pekerjaan Ayah</td>
                                                        <td><?= $mahasiswa->nama_pekerjaan_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rincian Pekerjaan Ayah</td>
                                                        <td><?= $mahasiswa->rincian_pekerjaan_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rata - Rata Penghasilan Ayah / Bulan</td>
                                                        <td><?= $mahasiswa->rata_penghasilan_ayah; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Hp Ayah</td>
                                                        <td><?= $mahasiswa->kontak_ayah ; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <table class="table table-sm table-bordered mb-4">
                                                    <tr>
                                                        <td colspan="2" class="font-weight-bold bg-striped" style="background-color: #6c757d; font-size: 20px; color: aliceblue;">Informasi ibu</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">Nama ibu</td>
                                                        <td><?= $mahasiswa->tulis_nama_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status ibu</td>
                                                        <td><?= $mahasiswa->nama_status_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hubungan dengan Ibu</td>
                                                        <td><?= $mahasiswa->nama_hub_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pendidikan</td>
                                                        <td><?= $mahasiswa->nama_pendidikan_ibu; ?></td>
                                                    </tr>
                                                     <tr>
                                                        <td>Golongan Pekerjaan ibu</td>
                                                        <td><?= $mahasiswa->nama_pekerjaan_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rincian Pekerjaan ibu</td>
                                                        <td><?= $mahasiswa->rincian_pekerjaan_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rata - Rata Penghasilan ibu / Bulan</td>
                                                        <td><?= $mahasiswa->rata_penghasilan_ibu; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Hp Ibu</td>
                                                        <td><?= $mahasiswa->kontak_ibu; ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php if($mahasiswa->tulis_no_rekening) { ?>
                                    <div class="tab-pane fade show" id="rekening" role="tabpanel" aria-labelledby="rekening-tab">
                                            <table class="table table-sm table-bordered mb-4">
                                                <tr>
                                                    <td colspan="2" class="font-weight-bold bg-striped" style="background-color: #6c757d; font-size: 20px; color: aliceblue;">Data Rekening</td>
                                                </tr>
                                                <tr>
                                                    <td>Bank</td>
                                                    <td><?= $mahasiswa->jenis_bank; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pemilik Rekening</td>
                                                    <td><?= $mahasiswa->pemilik_rekening; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>No Rekening</td>
                                                    <td><?= $mahasiswa->tulis_no_rekening; ?></td>
                                                </tr>
                                            </table>
                                    </div>
                                    <?php } ?>
                                    <?php if($mahasiswa->nama_status_rumah) { ?>
                                    <div class="tab-pane fade show" id="rumah" role="tabpanel" aria-labelledby="rumah-tab">
                                            <table class="table table-sm table-bordered mb-4">
                                                <tr>
                                                    <td colspan="2" class="font-weight-bold bg-striped" style="background-color: #6c757d; font-size: 20px; color: aliceblue;">Data Rumah</td>
                                                </tr>
                                                <tr>
                                                    <td>Status Rumah</td>
                                                    <td><?= $mahasiswa->nama_status_rumah; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Luas Rumah</td>
                                                    <td><?= $mahasiswa->nama_luas_rumah; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tahun Rumah / Tahun Tinggal</td>
                                                    <td><?= $mahasiswa->tahun_rumah; ?></td>
                                                </tr>
                                            </table>
                                    </div>
                                    <?php } ?>
                                    <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
                                    </div> -->
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
            </div>
        </section>
</div>
