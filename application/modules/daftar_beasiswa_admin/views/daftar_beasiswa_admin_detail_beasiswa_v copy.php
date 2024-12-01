     <!-- Main Content -->
      <div class="main-content">
          <section class="section">
              <div class="section-header">
                  <h1><?= $title; ?></h1>
              </div>
            <?php $error = form_error('nim',null,null); ?>
            <?= form_error('nim') ?  "<div id='gagal' data-flash='$error'></div>" : '' ; ?>
            <?= $this->session->flashdata('pesan'); ?>
              <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
              <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
              <div id="errorFlash" data-flash="<?= $this->session->flashdata('error_upload'); ?>"></div>
              <div class="section-body">
                  <h2 class="section-title">Detail Beasiswa</h2>
                  <p class="section-lead mb-0">Terdapat semua informasi mengenai beasiswa dan juga penerima beasiswa secara detail.</p>
                  <p class="section-lead">Harap teliti dalam melakukan upload sk, bukti pembayaran, dan juga upload penerima.</p>

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
                                    <a href="<?= base_url('daftar-beasiswa-admin'); ?>" class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i>Kembali</a>
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
                                        <form action="<?= base_url('data_beasiswa/Beasiswa/hapusDetailSk'); ?>" method="post" id="deleteFormSkBeasiswa" >
                                            <input type="hidden" name='id_sk' value="<?= $b['idmbs']; ?>">
                                            <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                            <input type="hidden" name='nama_file_mbs' value="<?= $b['nama_file_mbs']; ?>">
                                            <?php if($cek_akses_user['hapus'] == '1') { ?>
                                            <button type="submit" id="deleteButtonSkBeasiswa" class="btn btn-danger btn-icon icon-left"><i class="fas fa-trash-alt"></i>Hapus</button>
                                            <?php } ?>
                                        </form>
                                    </div> 

                                    
                                    <?php $no++ ?>
                                    <?php endforeach ;?>
                                </div>
                            </div>
                        </div>
                        <?php if($cek_akses_user['edit'] == '1') { ?>
                        <button type="submit" class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#keputusanRektor">
                        <i class="fas fa-file-upload"></i>Upload Surat Keputusan Rektor</button>
                        <?php } ?>
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
                                      <form action="<?= base_url('data_beasiswa/Beasiswa/hapusDetailPembayaran'); ?>" method="post" id="deleteFormBpBeasiswa">
                                          <input type="hidden" name='id_bp' value="<?= $b['idmbp']; ?>">
                                          <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                          <input type="hidden" name='nama_file_mbp' value="<?= $b['nama_file_mbp']; ?>">
                                          <?php if($cek_akses_user['hapus'] == '1') { ?>
                                          <button type="submit" class="btn btn-danger btn-icon icon-left" id="deleteButtonBpBeasiswa"><i class="fas fa-trash-alt"></i>Hapus</button>
                                          <?php } ?>
                                      </form>
                                  </div> 
                                  <?php $no++ ?>
                                  <?php endforeach ;?>
                              </div>
                          </div>
                      </div>
                      <?php if($cek_akses_user['edit'] == '1') { ?>
                      <button type="submit" class="btn btn-primary btn-icon icon-left mt-0" data-toggle="modal" data-target="#buktiPembayaran">
                      <i class="fas fa-file-upload"></i>Upload Bukti Pembayaran</button>
                      <?php } ?>
                  </div>

                  <div class="col-sm-12 col-md-12 col-sm-12">              
                      <div class="card card-warning">
                          <div class="card-header">
                              <h4 style="font-size: 20px; color: #34395e;">List mahasiswa yang mendaftar</h4>
                              <div class="card-header-action">
                                  <form action="<?= base_url('daftar-beasiswa-admin/pdf'); ?>" method="post" style="display: inline-block;" target="_blank">
                                      <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                      <input type="hidden" name='nama_beasiswa' value="<?= $detail_beasiswa['nama_beasiswa']; ?>">
                                      <input type="hidden" name='periode' value="<?= $detail_beasiswa['periode']; ?>">
                                      <input type="hidden" name='tahun' value="<?= $detail_beasiswa['tahun']; ?>">
                                      <button type="submit" class="btn btn-success btn-icon icon-left"><i class="fas fa-file-upload" ></i>Download PDF</button>
                                  </form>
                                  <?php if($cek_akses_user['tambah'] == '1') { ?>
                                      <button type="submit" class="btn btn-primary btn-icon icon-left mt-0" data-toggle="modal" data-target="#checkNim">
                                      <i class="fas fa-file-upload"></i>Daftarkan Mahasiswa </button>
                                  <?php } ?>
                              </div>
                          </div>

                          <div class="card-body">
                              <div class="table-responsive">
                                  <table class="table table-striped table-hover mb-0" id="data_pendaftar_beasiswa" style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th style="width: 2%;">#</th>
                                              <th style="width: 5%;">NIM</th>
                                              <th style="width: 18%;">Nama Mahasiswa</th>
                                              <th style="width: 25%;">Prodi</th>
                                              <th style="width: 20%;">Fakultas</th>
                                              <th style="width: 10%;">Admin Pendaftar</th>
                                              <th style="width: 10%;">Tanggal Daftar</th>
                                              <th class="text-center" style="width: 10%;">Aksi</th>
                                          </tr>
                                      </thead>
                                      <!-- body table dipanggil dengan menggunakan datatables -->
                                      <tbody>
                                      </tbody>
                                    <!-- end of body table -- dipanggil dengan menggunakan datatables -->
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
                            <input type="number" class="form-control" id="tahun_upload" name="tahun_upload">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="sk" name="sk" accept=".pdf">
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

          <!-- modal untuk check nim apakah sudah mendaftar beasiswa atau belum  -->
              <div class="modal fade" id="checkNim" tabindex="-1" role="dialog" aria-labelledby="checkNimLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="checkNimLabel">Check Nim Yang didaftarkan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?= form_open_multipart('daftar-beasiswa-admin/detail/'.$detail_beasiswa['id']) ?>
                    <input type="hidden" name='id_beasiswa' value="<?= $id_beasiswa ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for='tahun'>NIM : </label>
                            <input type="text" class="form-control" id="nim" name="nim">
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
          <!-- akhir dari modal untuk check nim tersebut -->
      </div>
    <!--  -->
     
         <script>
          $(document).ready(function() {   
          $('#data_pendaftar_beasiswa').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('daftar-beasiswa-admin/get_ajax/'.$detail_beasiswa['id']) ?>",
                "type": "POST"
            },

            "columnDefs": [
              {
                "targets": [0],
                "orderable": false,
                "width": 1
            }],
            "order" : []
          });
      });

    </script>