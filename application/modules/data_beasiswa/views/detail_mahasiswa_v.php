<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penerima Beasiswa</h1>
            </div>
            <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
            <div class="section-body">
                <h2 class="section-title">Detail Mahasiswa</h2>
                <p class="section-lead">
                Menampilkan detail informasi siswa <?= $mhs_api['nama']; ?>
                </p>

                <div class="row">
                    <div class="col-12 col-md-7 col-lg-7">
                        <div class="card card-warning">  
                            <table class="table table-striped table-bordered mb-0">
                                <tr>
                                    <td class="font-weight-bold">Nomor Induk Mahasiswa (NIM) / Tahun Masuk</td>
                                    <td><?= $mhs_api['nim']; ?> / <?= $mhs_api['tm_msk']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Mahasiswa</td>
                                    <td><?= $mhs_api['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Prodi</td>
                                    <td><?= $mhs_api['nam_prodi']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Fakultas</td>
                                    <td><?= $mhs_api['nam_fak']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Perkuliahan</td>
                                    <td><?= ($cek_aktif == 1 ? "<span class='badge badge-success'>Mahasiswa Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
                                </tr>
                                <!-- <tr>
                                    <td class="font-weight-bold">Status Beasiswa</td>
                                    <td><?= ($mahasiswa->status_beasiswa == 1 ? "<span class='badge badge-success'>Aktif Penerima</span>" : "<span class='badge badge-warning'>Tidak Aktif Penerima</span>"); ?></td>
                                </tr> -->
                                <tr>
                                    <td class="font-weight-bold">Jenjang Pendidikan</td>
                                    <td><?= $mhs_api['jjp']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tempat / Tgl Lahir</td>
                                    <td><?= $mhs_api['tmp_lhr']; ?>, <?= ($mhs_api['kokab_lhr'] ? $mhs_api['kokab_lhr'] : '') ?> / <?= $mhs_api['tgl_lhr']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td><?= $mhs_api['alamat_ortu']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">No Hp</td>
                                    <td><?= $mhs_api['nohp']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Ayah</td>
                                    <td><?= $mhs_api['ayah']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Ibu</td>
                                    <td><?= $mhs_api['ibu']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td><?= $mhs_api['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td><?= $mhs_api['jk']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Agama</td>
                                    <td><?= $mhs_api['agama']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">IPK</td>
                                    <td><?= $mhs_api['ipk']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <!-- <a href="<?= base_url('data_beasiswa/mahasiswa/edit/'.$mahasiswa->m_nim); ?>" class="btn btn-warning btn-icon icon-left"><i class="fas fa-user-edit"></i>Edit Mahasiswa</a> -->
                        
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="font-size: 20px; color: #34395e;">Photo</h4>
                            </div>
                            <div class="card-body">
                                    <div class="chocolat-parent">
                                        <a href="https://cdn.unp.ac.id/portal/<?= $mhs_api['nim']; ?>.jpg" class="chocolat-image" title="Just an example">
                                            <div>
                                                <img alt="image" src="https://cdn.unp.ac.id/portal/<?= $mhs_api['nim']; ?>.jpg" class="img-fluid">
                                            </div>
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                    <h4 style="font-size: 20px; color: #34395e;">Daftar Beasiswa :</h4>
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
                                            <td><?= ($b['mb_status_beasiswa_penerima'] == 1 ? "<span class='badge badge-warning'>Mendaftar</span>" : ($b['mb_status_beasiswa_penerima'] == 2 ? "<span class='badge badge-primary'>Divalidasi</span>" : ($b['mb_status_beasiswa_penerima'] == 3 ? "<span class='badge badge-success'>Penerima</span>" : ( $b['mb_status_beasiswa_penerima'] == 4 ? "<span class='badge badge-danger'>Dibatalkan</span>" : "<span class='badge badge-primary'>Selesai</span>" )) )); ?></td>
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
            </div>
        </section>
</div>