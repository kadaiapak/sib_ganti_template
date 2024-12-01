<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dafar Mahasiswa</h1>
            </div>
            <div class="section-body">
                <h2 class="section-title">Detail Mahasiswa yg divalidasi</h2>
                <p class="section-lead">
                Menampilkan detail informasi berkas pendaftaran <?= $mahasiswa->nama_mahasiswa; ?>
                </p>
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
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
                                <!-- <tr>
                                    <td class="font-weight-bold">Status Perkuliahan</td>
                                    <td><?= ($cek_aktif == 1 ? "<span class='badge badge-success'>Mahasiswa Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
                                </tr> -->

                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12">
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
                            <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="card card-warning">
                                    <div class="row p-2">
                                        <div class="col-xl-6 col-md-6 col-lg-6 col col-sm-6">
                                            <?php if($mahasiswa->status_beasiswa == '1') { ?>
                                            <form action="<?= base_url('validasi/'.$mahasiswa->id_beasiswa.'/'.$mahasiswa->nim_mahasiswa.'/calonkan'); ?>" method="post" id="deleteFormTetapkanCalon" style="display: inline-block;">
                                                <button type="submit" class="btn btn-success btn-icon icon-left" id="deleteButtonTetapkanCalon"><i class="fas fa-file-upload"></i>Calonkan</button>
                                            </form>
                                            <?php } else{ ?>
                                            <form action="<?= base_url('validasi/'.$mahasiswa->id_beasiswa.'/'.$mahasiswa->nim_mahasiswa.'/batalkan'); ?>" method="post" id="deleteFormBatalkanCalon" style="display: inline-block;">
                                                <button type="submit" class="btn btn-danger btn-icon icon-left" id="deleteButtonBatalkanCalon"><i class="fas fa-check-square"></i>Batalkan Pencalonan</button>
                                            </form>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-lg-6 col-sm-6">
                                            <a  href="<?= base_url('validasi/detail/'.$id_untuk_back); ?>" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                    <h4 style="color: #34395e; font-size: 20px;">Daftar Beasiswa Yang Diterima:</h4>
                            </div>
                            <div class="card-body">
                                <?php if(!$beasiswa) { ?>
                                    
                                <?php } else { ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php $n = 1; ?>
                                    <?php foreach($beasiswa as $b) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $n == 1 ? 'active' : ''; ?>" id="profile<?= $b['master_id']?>-tab" data-toggle="tab" href="#b<?= $b['master_id']?>" role="tab" aria-controls="profile<?= $b['master_id']?>"   aria-selected="false">
                                            <?= $b['nb_nama_beasiswa']; ?> / <?= $b['master_tahun']; ?>
                                        </a>
                                    </li>
                                    <?php $n++; ?>
                                    <?php endforeach ; ?>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <?php $no = 1; ?>
                                    <?php foreach ($beasiswa as $b) : ?>
                                    <div class="tab-pane fade <?= $no == 1 ? 'show active' : null; ?>" id="b<?= $b['master_id']?>" role="tabpanel" aria-labelledby="profile<?= $b['master_id']?>-tab">

                                        <table class="table table-striped table-bordered mb-0 mt-2">
                                        <tr>
                                            <td class="font-weight-bold">Nama Beasiswa</td>
                                            <td><?= $b['nb_nama_beasiswa']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Periode</td>
                                            <td><?= $b['p_nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tahun</td>
                                            <td><?= $b['master_tahun']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Status Beasiswa tersebut ?</td>
                                            <td><?= ($b['mb_status_beasiswa_penerima'] == 1 ? "<span class='badge badge-warning'>Mendaftar</span>" : ($b['mb_status_beasiswa_penerima'] == 2 ? "<span class='badge badge-primary'>Divalidasi</span>" : ($b['mb_status_beasiswa_penerima'] == 3 ? "<span class='badge badge-success'>Penerima</span>" : ( $b['mb_status_beasiswa_penerima'] == 4 ? "<span class='badge badge-warning'>Dibatalkan</span>" : "<span class='badge badge-primary'>Selesai</span>" )) )); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Apakah Beasiswanya Masih Aktif ?</td>
                                            <td><?= ($b['master_aktif'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
                                        </tr>
                                        </table>
                                    </div>
                                    <?php $no++ ?>
                                    <?php endforeach ;?>
                                </div>
                                <?php }?>
                        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="color: #34395e; font-size: 20px;">Kelengkapan Berkas Persyaratan dan Data Tambahan Pendaftar :</h4>
                                <div class="btn btn-success">
                                    <h4 style="color: #34395e; font-size: 13px;">Total Point : <?= $mahasiswa->total_point_penilaian; ?></h4>
                                </div>
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
                                    <?php $n = 1; ?>
                                    <?php foreach($berkas_pendaftaran as $b) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#b<?= $b['id'] ?>" role="tab" aria-controls="profile"   aria-selected="false">
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
                                                    <tr style="background-color: #6c757d; font-size: 20px; color: aliceblue;">
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
                                    <?php $no = 1; ?>
                                    <?php foreach ($berkas_pendaftaran as $b) : ?>
                                    <div class="tab-pane fade show" id="b<?= $b['id'] ?>" role="tabpanel" aria-labelledby="profile-tab">
                                        <object data="<?= base_url('uploads/persyaratan/'.$b['nama_file']); ?>" width="100%" height="700px"></object>
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
