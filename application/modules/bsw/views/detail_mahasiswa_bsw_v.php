
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penerima Beasiswa</h1>
            </div>

            <div class="section-body">
                <h2 class="section-title">Detail Mahasiswa</h2>
                <p class="section-lead">
                Menampilkan detail informasi siswa <?= $mahasiswa->nama_mahasiswa; ?> penerima beasiswa <?= $mahasiswa->nama_beasiswa; ?>
                </p>
                <div class="row">
                    <div class="col-12 col-md-7 col-lg-7">
                        <div class="card card-primary">  
                            <table class="table table-striped table-bordered mb-0">
                                <tr>
                                    <td class="font-weight-bold">Nomor Induk Mahasiswa (NIM)</td>
                                    <td><?= $mahasiswa->nim_mahasiswa; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Mahasiswa</td>
                                    <td><?= $mahasiswa->nama_mahasiswa; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Prodi</td>
                                    <td><?= ($mahasiswa->prodi ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Fakultas</td>
                                    <td><?= ($mahasiswa->fakultas ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Perkuliahan</td>
                                    <td><?= ($mahasiswa->aktif == 1 ? "<span class='badge badge-success'>Mahasiswa Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Beasiswa</td>
                                    <td><?= $mahasiswa->nama_beasiswa; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Periode Penerimaan</td>
                                    <td><?= $mahasiswa->periode; ?> / <?= $mahasiswa->tahun; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status Beasiswa</td>
                                    <td><?= ($mahasiswa->status_beasiswa == 3 ? "<span class='badge badge-success'>Penerima</span>" : "<span class='badge badge-warning'>Dibatalkan</span>"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat</td>
                                    <td><?= ($mahasiswa->alamat ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">No Hp</td>
                                    <td><?= ($mahasiswa->nomor_hp ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td><?= ($mahasiswa->email ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td><?= ($mahasiswa->jekel ?? "-"); ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Agama</td>
                                    <td><?= ($mahasiswa->agama ?? "-"); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Bukti Pembayaran :</h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php $n = 1; ?>
                                    <?php foreach($bp as $b) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $n == 1 ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="#b<?= $b['idmbbp']?>" role="tab" aria-controls="profile"   aria-selected="false">
                                            <?= $b['periode_bukti_pembayaran'] == 1 ? 'Januari - Juni ' : 'Juli - Desember'; ?> / <?= $b['tahun_bukti_pembayaran']; ?>
                                        </a>
                                    </li>
                                    <?php $n++; ?>
                                    <?php endforeach ; ?>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <?php $no = 1; ?>
                                    <?php foreach ($bp as $b) : ?>
                                    <div class="tab-pane fade <?= $no == 1 ? 'show active' : null; ?>" id="b<?= $b['idmbbp']?>" role="tabpanel" aria-labelledby="profile-tab">
                                        <object data="<?= base_url('uploads/sk/'.$b['nama_file']); ?>" width="100%" height="380px"></object>
                                    </div>
                                    <?php $no++ ?>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('bsw/detail/'.$mahasiswa->id_beasiswa); ?>" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
            </div>
        </section>


</div>