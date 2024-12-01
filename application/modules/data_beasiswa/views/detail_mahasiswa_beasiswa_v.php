
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Penerima Beasiswa</h1>
          </div>
              <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>

          <div class="section-body">
            <h2 class="section-title">Detail Mahasiswa</h2>
            <p class="section-lead">
              Menampilkan detail informasi siswa <?= $mahasiswa->nama_mahasiswa; ?> penerima beasiswa <?= $mahasiswa->nama_beasiswa; ?><br>
              Jika melakukan pembatalan maka mahasiswa tersebut sudah tidak berhak mendapatkan beasiswa. <br>
              Pembatalan hanya dilakukan jika mahasiswa yang bersangkutan telah melanggar peraturan yang ada.
            </p>
              <?= form_error('periode', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('tahun', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>
              <?= form_error('bukti_pembayaran', '<div class="alert alert-danger mb-4" role="alert">', '</div>'); ?>

            <div class="row">
              <div class="col-12 col-md-7 col-lg-7">
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
                            <td class="font-weight-bold">Jenis kelamin</td>
                            <td><?= $mahasiswa->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki - laki'; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Prodi / Jenjang Pendidikan</td>
                            <td><?= ($mahasiswa->prodi ?? "-"); ?> / <?= $mahasiswa->jjp; ?> </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Fakultas</td>
                            <td><?= ($mahasiswa->fakultas ?? "-"); ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">No Hp</td>
                            <td><?= $mahasiswa->nohp; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tempat Lahir</td>
                            <td><?= $mahasiswa->tmp_lhr; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tanggal Lahir</td>
                            <td><?= $mahasiswa->tgl_lhr; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Agama</td>
                            <td><?= $mahasiswa->agama; ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status Perkuliahan</td>
                            <td><?= ($cek_aktif == 1 ? "<span class='badge badge-success'>Mahasiswa Aktif</span>" : "<span class='badge badge-warning'>Tidak Aktif</span>"); ?></td>
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
                            <td><?= ($mahasiswa->status_beasiswa == '3' ? "<span class='badge badge-success'>Penerima</span>" : ($mahasiswa->status_beasiswa == '4' ? "<span class='badge badge-danger'>Dibatalkan</span>" : ($mahasiswa->status_beasiswa == '5' ? "<span class='badge badge-warning'>Selesai</span>" : null))); ?></td>
                        </tr>
                    </table>
                </div>
              </div>
              <div class="col-12 col-md-5 col-lg-5">
                  <div class="card card-warning">
                    <div class="card-header">
                        <h4 style="font-size: 20px; color: #34395e;">Bukti Pembayaran :</h4>
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
                                <form action="<?= base_url('data_beasiswa/Beasiswa/hapusBuktiPembayaranPerorangan'); ?>" method="post">
                                    <input type="hidden" name='id_bukti_pembayaran' value="<?= $b['idmbbp']; ?>">
                                    <input type="hidden" name='nama_file' value="<?= $b['nama_file']; ?>">
                                    <input type="hidden" name='id_beasiswa' value="<?= $mahasiswa->id_beasiswa; ?>">
                                    <input type="hidden" name='nim_mahasiswa' value="<?= $mahasiswa->nim_mahasiswa; ?>">
                                    <button type="submit" class="btn btn-danger btn-icon icon-left"><i class="fas fa-trash-alt"></i>Hapus</button>
                                </form>
                            </div>

                            <?php $no++ ?>
                            <?php endforeach ;?>
                        </div>
                    </div>
                  </div>
                   <button type="submit" class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#buktiPembayaranModal"><i class="fas fa-file-upload"></i>Upload Bukti Pembayaran</button>
              </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php if($mahasiswa->status_beasiswa == '3') { ?>
                        <form action="<?= base_url('data_beasiswa/beasiswa/batalkanPenerima'); ?>" method="post" id="deleteFormBatalkanTetapkanBeasiswa">
                            <input type="hidden" name='id_beasiswa' value="<?= $mahasiswa->id_beasiswa; ?>">
                            <input type="hidden" name='nim' value="<?= $mahasiswa->nim_mahasiswa; ?>">
                            <button type="submit" class="btn btn-danger btn-icon icon-left" id="deleteButtonBatalkanBeasiswa"><i class="fas fa-user-times"></i>Batalkan Status Penerima</button>
                        </form>
                    <?php }elseif ($mahasiswa->status_beasiswa == '4') { ?>
                        <form action="<?= base_url('data_beasiswa/beasiswa/tetapkanPenerima'); ?>" method="post" id="deleteFormBatalkanTetapkanBeasiswa">
                            <input type="hidden" name='id_beasiswa' value="<?= $mahasiswa->id_beasiswa; ?>">
                            <input type="hidden" name='nim' value="<?= $mahasiswa->nim_mahasiswa; ?>">
                            <button type="submit" class="btn btn-success btn-icon icon-left" id="deleteButtonTetapkanBeasiswa"><i class="fas fa-check-square"></i>Tetapkan Status Penerima</button>
                        </form>
                    <?php } ?>
                </div>
                <div class="col-md-5 col-lg-5">
                    <a href="<?= base_url('data_beasiswa/beasiswa/detail/'.$mahasiswa->id_beasiswa); ?>" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
                </div>
                
            </div>
          </div>
        </section>

        <!-- upload bukti pembayaran -->
        <div class="modal fade" id="buktiPembayaranModal" tabindex="-1" role="dialog" aria-labelledby="buktiPembayaranModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="buktiPembayaranModalLabel">Upload Bukti Pembayaran</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <?= form_open_multipart() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_mahasiswa_beasiswa" name="id_mahasiswa_beasiswa" value="<?= $mahasiswa->id_mahasiswa_beasiswa; ?>">
                        <input type="hidden" class="form-control" id="nama_beasiswa" name="nama_beasiswa" value="<?= $mahasiswa->nama_beasiswa; ?>">
                        <input type="hidden" class="form-control" id="id_beasiswa" name="id_beasiswa" value="<?= $mahasiswa->id_beasiswa; ?>">
                        <input type="hidden" class="form-control" id="nim_mahasiswa" name="nim_mahasiswa" value="<?= $mahasiswa->nim_mahasiswa; ?>">
                        <input type="hidden" class="form-control" id="periode_beasiswa" name="periode_beasiswa" value="<?= $mahasiswa->periode; ?>">
                        <input type="hidden" class="form-control" id="tahun_beasiswa" name="tahun_beasiswa" value="<?= $mahasiswa->tahun; ?>">
                        <label>Periode Penerimaan: </label>
                        <select class="form-control <?= form_error('periode') ? 'is-invalid' : null; ?>" name="periode" id="periode">
                            <option value="" selected>Pilih periode</option>
                            <?php foreach ($periode as $p) :?>
                            <option value="<?= $p['id']; ?>" <?= $p['id'] == set_value('periode') ? "selected" : null; ?>><?= $p['nama']; ?></option>   
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <labe for='tahun'>Tahun : </labe>
                        <input type="number" class="form-control" id="tahun" name="tahun" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
                <?= form_close(); ?>        
              </div>
            </div>
        </div>
</div>