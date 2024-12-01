
      <!-- Main Content -->
      <div class="main-content">
          <section class="section">
              <div class="section-header">
                  <h1><?= $title; ?></h1>
              </div>
              <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
              <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
              <div id="errorFlash" data-flash="<?= $this->session->flashdata('error_upload'); ?>"></div>
              <div class="section-body">
                  <h2 class="section-title">Detail Beasiswa</h2>
                  <p class="section-lead mb-0">Terdapat semua informasi mengenai beasiswa dan juga penerima beasiswa secara detail.</p>
                  <p class="section-lead">Harap teliti dalam melakukan upload sk, bukti pembayaran, dan juga upload penerima.</p>
            <?= $this->session->flashdata('pesan'); ?>

                  <div class="row">
                      <div class="col-sm-12 col-md-7 col-lg-7">
                          <div class="invoice card author-box card-warning">
                            <div class="invoice-print">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="invoice-title">
                                    <h2>Detail Beasiswa <?= $detail_beasiswa['nama_beasiswa'] ?> Universitas Negeri Padang</h2>
                                    <h6>Periode <?= $detail_beasiswa['periode'].' / '.$detail_beasiswa['tahun'] ?><br></h6>
                                    <div class="text-small text-muted">ditulis oleh :  <?= $detail_beasiswa['user_created']; ?></div>
                                    <div class="text-small text-muted"><?= date("d-m-Y", strtotime($detail_beasiswa['created_at'])); ?></div>

                                    <div class="text-small text-muted"><?= ( $detail_beasiswa['updated_at'] != null ? 'diedit  '   . date("d-m-Y H:i:s", strtotime($detail_beasiswa['updated_at'])) : null)?></div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>Nama Beasiswa :</strong><br>
                                          <?= $detail_beasiswa['nama_beasiswa'] ?><br>
                                        <strong>Periode / tahun :</strong><br>
                                          <?= $detail_beasiswa['periode'].' / '.$detail_beasiswa['tahun'] ?><br>
                                        <strong>Kelompok Beasiswa :</strong><br>
                                          <?= $detail_beasiswa['kelompok_beasiswa'] ?><br>
                                        <strong>Asal Beasiswa :</strong><br>
                                          <?= $detail_beasiswa['asal_beasiswa'] ?><br>
                                          <strong>Jenis Beasiswa :</strong><br>
                                          <?= $detail_beasiswa['nama_jenis_beasiswa'] ?><br>
                                        <strong>Besar Bantuan / orang :</strong><br>
                                          <?= ($detail_beasiswa['biaya'] ? 'Rp.'.number_format($detail_beasiswa['biaya'],2,',','.') : '')?>
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>Kuota Pendaftaran :</strong><br>
                                        <?= $detail_beasiswa['kuota_pendaftaran']; ?> orang mahasiswa<br>
                                        <strong>Kuota Penetapan :</strong><br>
                                        <?= $detail_beasiswa['kuota_pendaftaran']; ?> orang mahasiswa<br>
                                        <strong>Total Penerima :</strong><br>
                                        <?= $total_penerima; ?> orang mahasiswa<br>
                                        <strong>Tanggal Dibuka Pendaftaran:</strong><br>
                                        <?= date("d-m-Y", strtotime($detail_beasiswa['tgl_awal_pendaftaran'])); ?><br>
                                        <strong>Tanggal Ditutup Pendaftaran:</strong><br>
                                        <?= date("d-m-Y", strtotime($detail_beasiswa['tgl_tutup_pendaftaran'])); ?><br>
                                        <strong>Tanggal Awal Proses Penetapan:</strong><br>
                                        <?= date("d-m-Y", strtotime($detail_beasiswa['tgl_awal_penetapan'])); ?><br>
                                        <strong>Tanggal Tutup Proses Penetapan:</strong><br>
                                        <?= date("d-m-Y", strtotime($detail_beasiswa['tgl_tutup_penetapan'])); ?><br>


                                        <!-- 1234 Main<br>
                                        Apt. 4B<br>
                                        Bogor Barat, Indonesia<br><br> -->
                                        <strong>Tanggal Penetapan:</strong><br>
                                        <?= date("d-m-Y", strtotime($detail_beasiswa['tanggal_penetapan'])); ?><br>
                                        <strong>Status Pendaftaran:</strong><br>
                                        <?= ($detail_beasiswa['buka_pendaftaran'] == 1 ? "<span class='badge badge-success'>Masih dibuka</span>" : "<span class='badge badge-warning'>Telah ditutup</span>"); ?><br>
                                        <strong>Status Beasiswa:</strong><br>
                                        <?= ($detail_beasiswa['aktif'] == 1 ? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-warning'>Tidak aktif</span>"); ?><br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>Metode Pembayaran:</strong><br>
                                        <?= $detail_beasiswa['metode_pembayaran']; ?><br>
                                      </address>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <hr>

                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <div class="form-group row mb-4 mr-4" style="display: inline-block;">
                                        <?php if($cek_akses_user['tambah'] == '1') { ?>
                                            <button type="submit" class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#uploadExcel">
                                            <i class="fas fa-file-upload"></i>Upload Penerima</button>
                                        <?php } ?>
                                    </div>
                                    <a href="<?= base_url('uploads/format/format.xlsx'); ?>" class="btn btn-success btn-icon icon-left" download=""><i class="fas fa-file-download"></i>Download Format Input</a>
                                                <?= form_close(); ?>
                                    <a href="<?= base_url('data_beasiswa/beasiswa'); ?>" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
                                </div>
                            </div>
                          </div>
                      </div>

                      <div class="col-sm-12 col-md-5 col-lg-5">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="font-size: 20px; color: #34395e;">Surat Keputusan Rektor :</h4>
                            </div>
                            <div class="card-body">
                              <?php if(count($sk) == 0) { ?>
                                  <h5>Sedang dalam proses ..</h5>
                                <?php }; ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php $n = 1; ?>
                                    <?php foreach($sk as $b) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?= $n == 1 ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="#b<?= $b['idmbs']?>" role="tab" aria-controls="profile"   aria-selected="false">
                                            <?= $b['periode_mbs'] == 1 ? 'Januari - Juni ' : ($b['periode_mbs'] == 2  ? 'Juli - Desember' : 'Januari - Desember' ); ?> / <?= $b['tahun_mbs']; ?>
                                        </a>
                                    </li>
                                    <?php $n++; ?>
                                    <?php endforeach ; ?>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <?php $no = 1; ?>
                                    <?php foreach ($sk as $b) : ?>
                                    <div class="tab-pane fade <?= $no == 1 ? 'show active' : null; ?>" id="b<?= $b['idmbs']?>" role="tabpanel" aria-labelledby="profile-tab">
                                        <object data="<?= base_url('uploads/sk/'.$b['nama_file_mbs']); ?>" width="100%" height="380px"></object>
                                        <form action="<?= base_url('data_beasiswa/Beasiswa/hapusDetailSk'); ?>" method="post">
                                            <input type="hidden" name='id_sk' value="<?= $b['idmbs']; ?>">
                                            <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                            <input type="hidden" name='nama_file_mbs' value="<?= $b['nama_file_mbs']; ?>">
                                            <?php if($cek_akses_user['hapus'] == '1') { ?>
                                            <button type="submit" class="btn btn-danger btn-icon icon-left" onclick="return confirm('Yakin dihapus')"><i class="fas fa-trash-alt"></i>Hapus</button>
                                            <?php } ?>
                                        </form>
                                    </div>


                                    <?php $no++ ?>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#keputusanRektor">
                        <i class="fas fa-file-upload"></i>Upload Surat Keputusan Rektor</button>
                      </div>
                  </div>
              </div>

              <div class="row">
                  <div class="col-sm-12 col-md-7 col-lg-7">
                      <div class="card card-warning">
                          <div class="card-header">
                              <h4 style="font-size: 20px; color: #34395e;">Mengenai <?= $detail_beasiswa['nama_beasiswa']; ?> :</h4>
                          </div>
                          <div class="card-body">
                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item">
                                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Deskripsi</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Kontak</a>
                                  </li>
                              </ul>
                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <?= $detail_beasiswa['profil']; ?>
                              </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <?= $detail_beasiswa['keterangan']; ?>
                              </div>
                              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <?= $detail_beasiswa['kontak']; ?>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-12 col-md-5 col-lg5 mb-2">
                      <div class="card card-warning">
                          <div class="card-header">
                              <h4 style="font-size: 20px; color: #34395e;">Rekap Bukti Pembayaran :</h4>
                          </div>
                          <div class="card-body">
                              <?php if(count($bp) == 0) { ?>
                              <h5>Sedang dalam proses ..</h5>
                              <?php }; ?>
                              <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <?php $n = 1; ?>
                                  <?php foreach($bp as $b) : ?>
                                  <li class="nav-item">
                                      <a class="nav-link <?= $n == 1 ? 'active' : ''; ?>" id="profile-tab" data-toggle="tab" href="#b<?= $b['idmbp']?>" role="tab" aria-controls="profile"   aria-selected="false">
                                            <?= $b['periode_mbp'] == 1 ? 'Januari - Juni ' : ($b['periode_mbp'] == 2 ?'Juli - Desember' : 'Januari - Desember' ); ?> / <?= $b['tahun_mbp']; ?>
                                      </a>
                                  </li>
                                  <?php $n++; ?>
                                  <?php endforeach ; ?>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                  <?php $no = 1; ?>
                                  <?php foreach ($bp as $b) : ?>
                                  <div class="tab-pane fade <?= $no == 1 ? 'show active' : null; ?>" id="b<?= $b['idmbp']?>" role="tabpanel" aria-labelledby="profile-tab">
                                      <object data="<?= base_url('uploads/sk/'.$b['nama_file_mbp']); ?>" width="100%" height="380px"></object>
                                      <form action="<?= base_url('data_beasiswa/Beasiswa/hapusDetailPembayaran'); ?>" method="post">
                                          <input type="hidden" name='id_bp' value="<?= $b['idmbp']; ?>">
                                          <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                          <input type="hidden" name='nama_file_mbp' value="<?= $b['nama_file_mbp']; ?>">
                                          <?php if($cek_akses_user['hapus'] == '1') { ?>
                                            <button type="submit" class="btn btn-danger btn-icon icon-left" onclick="return confirm('Yakin dihapus')"><i class="fas fa-trash-alt"></i>Hapus</button>
                                          <?php } ?>
                                      </form>
                                  </div>
                                  <?php $no++ ?>
                                  <?php endforeach ;?>
                              </div>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-icon icon-left mt-0" data-toggle="modal" data-target="#buktiPembayaran">
                      <i class="fas fa-file-upload"></i>Upload Bukti Pembayaran</button>
                  </div>

                  <div class="col-sm-12 col-md-12 col-sm-12">
                      <div class="card card-warning">
                          <div class="card-header">
                              <h4 style="font-size: 20px; color: #34395e;">Daftar penerima</h4>
                              <div class="card-header-action">
                                  <form action="<?= base_url('data_beasiswa/Beasiswa/pdf'); ?>" method="post" style="display: inline-block;">
                                      <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                      <input type="hidden" name='nama_beasiswa' value="<?= $detail_beasiswa['nama_beasiswa']; ?>">
                                      <input type="hidden" name='periode' value="<?= $detail_beasiswa['periode']; ?>">
                                      <input type="hidden" name='tahun' value="<?= $detail_beasiswa['tahun']; ?>">
                                      <button type="submit" class="btn btn-success btn-icon icon-left"><i class="fas fa-file-upload"></i>Download PDF</button>
                                  </form>
                                  <?php if($cek_akses_user['tambah'] == '1') { ?>
                                      <a href="<?= base_url('data_beasiswa/beasiswa/check-tambah/'.$detail_beasiswa['id']); ?>" class="btn btn-primary btn-icon icon-left"><i class="fas fa-plus"></i>Tambah Penerima by Form</a>
                                  <?php } ?>
                              </div>
                          </div>

                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-striped table-hover mb-0" id="data_penerima_detail_beasiswa" style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th style="width: 2%;">#</th>
                                              <th style="width: 8%;">NIM</th>
                                              <th style="width: 15%;">Nama Mahasiswa</th>
                                              <th style="width: 15%;">Prodi</th>
                                              <th style="width: 20%;">Fakultas</th>
                                              <th style="width: 10%;">IPK saat daftar</th>
                                              <th style="width: 10%;">Status Beasiswa</th>
                                              <th class="text-center" style="width: 20%;">Aksi</th>
                                          </tr>
                                      </thead>
                                      <!-- body table dipanggil dengan menggunakan datatables -->
                                      <tbody>
                                      </tbody>
                                    <!-- end of body table dipanggil dengan menggunakan datatables -->
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


          </section>
        <!-- modal form untuk upload SK -->
          <div class="modal fade" id="keputusanRektor" tabindex="-1" role="dialog" aria-labelledby="keputusanRektorLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="keputusanRektorLabel">Upload Surat Keputusan Rektor</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <?= form_open_multipart('data_beasiswa/beasiswa/uploadDetailSk') ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control-file" id="id" name="id" value="<?= $detail_beasiswa['id']; ?>">
                            <input type="hidden" class="form-control-file" id="nama_sk" name="nama_sk" value="<?= $detail_beasiswa['singkatan']; ?>">
                            <input type="hidden" class="form-control-file" id="tahun" name="tahun" value="<?= $detail_beasiswa['tahun']; ?>">
                            <label>Periode Penerimaan: </label>
                            <select class="form-control <?= form_error('periode') ? 'is-invalid' : null; ?>" name="periode" id="periode">
                                <option value="" selected>Pilih periode</option>
                                <?php foreach ($periode as $p) :?>
                                <option value="<?= $p['id']; ?>" <?= $p['id'] == set_value('periode') ? "selected" : null; ?>><?= $p['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for='tahun'>Tahun : </label>
                            <input class="form-control" id="tahun_upload" name="tahun_upload">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="sk" name="sk">
                            <!-- <input type="file" class="form-control-file" id="sk" name="sk" accept=".pdf"> -->
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

        <!-- modal untuk bukti pembayaran -->
          <div class="modal fade" id="buktiPembayaran" tabindex="-1" role="dialog" aria-labelledby="buktiPembayaranLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="buktiPembayaranLabel">Upload Rekap Bukti Pembayaran</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <?= form_open_multipart('data_beasiswa/beasiswa/uploadDetailPembayaran') ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control-file" id="id" name="id" value="<?= $detail_beasiswa['id']; ?>">
                            <input type="hidden" class="form-control-file" id="nama_bp" name="nama_bp" value="<?= $detail_beasiswa['singkatan']; ?>">
                            <input type="hidden" class="form-control-file" id="tahun" name="tahun" value="<?= $detail_beasiswa['tahun']; ?>">
                            <label>Periode Penerimaan: </label>
                            <select class="form-control <?= form_error('periode') ? 'is-invalid' : null; ?>" name="periode" id="periode">
                                <option value="" selected>Pilih periode</option>
                                <?php foreach ($periode as $p) :?>
                                <option value="<?= $p['id']; ?>" <?= $p['id'] == set_value('periode') ? "selected" : null; ?>><?= $p['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for='tahun'>Tahun : </label>
                            <input class="form-control" id="tahun_upload" name="tahun_upload">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="bp" name="bp" accept=".pdf">
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

           <!-- modal form untuk upload file lewat excel -->
          <div class="modal fade" id="uploadExcel" tabindex="-1" role="dialog" aria-labelledby="uploadExcelLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="uploadExcelLabel">Upload Excel
                      <small style="color: red;">(Fitur ini belum bisa digunakan)</small></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <form action="<?= base_url('data_beasiswa/beasiswa/uploadpenerima'); ?>" id="uploadPenerimaExcelForm" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name='id_upload' value="<?= $detail_beasiswa['id']; ?>">
                                <label> Pilih File Excel : </label>
                                <input type="file" class="form-control-file" id="uploadbeasiswa" name="uploadbeasiswa" accept=".xlsx,.xls">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="uploadPenerimaExcelBtn" class="btn btn-primary btn-icon icon-left"><i class="fas fa-file-upload"></i>Upload Penerima</button>
                        </div>
                    </form>
                  </div>
                </div>
          </div>

      </div>

         <script>
          $(document).ready(function() {
          $('#data_penerima_detail_beasiswa').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('data_beasiswa/beasiswa/get_ajax/'.$detail_beasiswa['id']) ?>",
                "type": "POST"
            },

            "columnDefs": [
              {
                "targets": [0,7],
                "orderable": false,
                "width": 1
            }],
            "order" : []
          });
      });

    </script>
