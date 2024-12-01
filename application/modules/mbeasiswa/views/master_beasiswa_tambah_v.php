<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <p class="section-lead">
                        Inputkan saja data mengenai beasiswa yang nantinya akan digunakan sebagai master data beasiswa dalam proses upload data mahasiswa penerima beasiswa tersebut.
                    </p>
                </div>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form id="formMaster" action="<?= base_url('mbeasiswa/master_beasiswa/tambah');?>" method="post">
            <div class="row">

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;">Input Keterangan Beasiswa</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Pilih Nama Beasiswa : </label>
                                <select class="form-control <?= form_error('nama_beasiswa') ? 'is-invalid' : null ; ?>" name="nama_beasiswa" id="nama_beasiswa">
                                    <option value="" selected>Pilih beasiswa</option>
                                    <?php foreach ($nama_beasiswa as $nb) :?>
                                        <option value="<?= $nb['id']; ?>" <?= $nb['id'] ==  set_value('nama_beasiswa') ? "selected" : ""; ?>><?= $nb['nama_beasiswa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('nama_beasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pilih Kelompok Beasiswa: </label>
                                <select class="form-control <?= form_error('kelompok_beasiswa') ? 'is-invalid' : null ; ?>" name="kelompok_beasiswa" id="kelompok_beasiswa">
                                    <option value="" selected>Kelompok</option>
                                    <?php foreach ($kelompok_beasiswa as $kb) :?>
                                        <option value="<?= $kb['id']; ?>" <?= $kb['id'] == set_value('kelompok_beasiswa') ? 'selected' : null ; ?>><?= $kb['nama_kelompok']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('kelompok_beasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pilih Jenis Beasiswa: </label>
                                <select class="form-control <?= form_error('jenis_beasiswa') ? 'is-invalid' : null ; ?>" name="jenis_beasiswa" id="jenis_beasiswa">
                                    <option value="" selected>Jenis</option>
                                    <?php foreach ($jenis_beasiswa as $jb) :?>
                                        <option value="<?= $jb['id']; ?>" <?= $jb['id'] == set_value('jenis_beasiswa') ? 'selected' : null ; ?>><?= $jb['nama_jenis']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('jenis_beasiswa', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pilih Sumber Dana: </label>
                                <select class="form-control <?= form_error('asal_beasiswa') ? 'is-invalid' : null; ?>" name="asal_beasiswa" id="asal_beasiswa">
                                    <option value="" selected>Sumber</option>
                                    <?php foreach ($asal_beasiswa as $ab) :?>
                                        <option value="<?= $ab['id']; ?>" <?= $ab['id'] == set_value('asal_beasiswa') ? "selected" : null; ?>><?= $ab['nama_asal_beasiswa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('asal_beasiswa', '<small class="text-danger pl-3">','</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Besaran bantuan: </label>
                                <input type="number" id="biaya" name="biaya" placeholder="Besar bantuan ..."
                                class="form-control <?= form_error('biaya') ? 'is-invalid' : (set_value('biaya') ? 'is-valid' : null); ?>"
                                value="<?= set_value('biaya'); ?>">
                                <div class="text-small text-muted mb-1">(masukkan angka).</div>
                                <?= form_error('biaya', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Metode pembayaran: </label>
                                <input type="text" id="metode_pembayaran" name="metode_pembayaran" placeholder="Metode pembayaran ..."
                                class="form-control <?= form_error('metode_pembayaran') ? 'is-invalid' : (set_value('metode_pembayaran') ? 'is-valid' : null); ?>"
                                value="<?= set_value('metode_pembayaran'); ?>">
                                <?= form_error('metode_pembayaran', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;">Pengaturan Tanggal Pendaftaran</h4>
                        </div>

                        <div class="card-body">
                           <div class="form-group">
                                <label>Tanggal Buka Pendaftaran</label>
                                <input type="datetime-local" class="form-control <?= form_error('tgl_awal_pendaftaran') ? 'is-invalid' : (set_value('tgl_awal_pendaftaran') ? 'is-valid' : null); ?>"
                                value="<?= set_value('tgl_awal_pendaftaran'); ?>"
                                name='tgl_awal_pendaftaran'>
                                <?= form_error('tgl_awal_pendaftaran', '<small class="text-danger pl-3">','</small>'); ?>
                                <div class="text-small text-muted mb-1">tanggal dibukanya proses pendaftaran beasiswa bagi mahasiswa <br>(cek dan pastikan kembali tanggal sudah benar) !</div>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Tutup Pendaftaran</label>
                                <input type="datetime-local" class="form-control <?= form_error('tgl_tutup_pendaftaran') ? 'is-invalid' : (set_value('tgl_tutup_pendaftaran') ? 'is-valid' : null); ?>"
                                name='tgl_tutup_pendaftaran'
                                value="<?= set_value('tgl_tutup_pendaftaran'); ?>">
                                <?= form_error('tgl_tutup_pendaftaran', '<small class="text-danger pl-3">','</small>'); ?>
                                <div class="text-small text-muted mb-1">tanggal ditutupnya proses pendaftaran beasiswa bagi mahasiswa <br>(cek dan pastikan tanggal kembali sudah benar) !</div>
                            </div>

                            <div class="form-group">
                                    <label>Tanggal Dimulai Penetapan</label>
                                    <input type="datetime-local" class="form-control" name='tgl_awal_penetapan'>
                                    <div class="text-small text-muted mb-1">tanggal awal dilakukannya proses penetapan beasiswa bagi mahasiswa <br>(cek dan pastikan kembali tanggal sudah benar) !</div>
                            </div>

                            <div class="form-group">
                                <label>Batas Akhir Penetapan</label>
                                <input type="datetime-local" class="form-control" name='tgl_tutup_penetapan'>
                                <div class="text-small text-muted mb-1">tanggal ditutupnya proses penetapan beasiswa bagi mahasiswa <br>(cek dan pastikan kembali tanggal sudah benar) !</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;">Proses Pendaftaran</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>Periode Penerimaan: </label>
                                <select class="form-control <?= form_error('periode') ? 'is-invalid' : null; ?>" name="periode" id="periode">
                                    <option value="" selected>Periode</option>
                                    <?php foreach ($periode as $p) :?>
                                        <option value="<?= $p['id']; ?>" <?= $p['id'] == set_value('periode') ? "selected" : null; ?>><?= $p['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('periode', '<small class="text-danger pl-3">','</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Tahun Penerimaan: </label>
                                <input type="number" id="tahun" name="tahun" placeholder="Tahun ..."
                                class="form-control <?= form_error('tahun') ? 'is-invalid' : (set_value('tahun') ? 'is-valid' : null) ; ?>"
                                value="<?= set_value('tahun'); ?>">
                                <div class="text-small text-muted mb-1">(masukkan angka).</div>
                                <?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Kuota Pendaftaran : </label>
                                <input type="number" id="kuota_pendaftaran" name="kuota_pendaftaran" placeholder="Kuota Pendaftaran ..."
                                class="form-control <?= form_error('kuota_pendaftaran') ? 'is-invalid' : (set_value('kuota_pendaftaran') ? 'is-valid' : null) ; ?>"
                                value="<?= set_value('kuota_pendaftaran'); ?>">
                                <?= form_error('kuota_pendaftaran', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Kuota Penetapan : </label>
                                <input type="number" id="kuota_penetapan" name="kuota_penetapan" placeholder="Kuota Penetapan ..."
                                class="form-control <?= form_error('kuota_penetapan') ? 'is-invalid' : (set_value('kuota_penetapan') ? 'is-valid' : null) ; ?>"
                                value="<?= set_value('kuota_penetapan'); ?>">
                                <?= form_error('kuota_penetapan', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Penetapan</label>
                                <input type="text" class="form-control datepicker" name='tanggal_penetapan'>
                                <div class="text-small text-muted mb-1">(cek dan pastikan kembali tanggal penetapan sudah benar) !</div>
                            </div>

                            <div class="form-group">
                                <label>Minimal IPK : </label>
                                <input type="text" id="min_ipk" name="min_ipk" placeholder="Minimal IPK ..."
                                class="form-control <?= form_error('min_ipk') ? 'is-invalid' : (set_value('min_ipk') ? 'is-valid' : null) ; ?>"
                                <?= form_error('min_ipk', '<small class="text-danger pl-3">', '</small>'); ?> >
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="is_active" value="0" id="is_active" />
                                <input class="form-check-input" type="checkbox" value="1" name="is_active"  id="is_active">
                                <label class="form-check-label" for="is_active">
                                    Aktif ?
                                </label>
                                <div class="text-small text-muted mb-1">(ceklis jika ingin beasiswa ini masih aktif) !</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="is_show" value="0" id="is_show" />
                                <input class="form-check-input" type="checkbox" value="1" name="is_show"  id="is_show">
                                <label class="form-check-label" for="is_show">
                                    Tampilkan ?
                                </label>
                                <div class="text-small text-muted mb-1">(ceklis jika ingin ditampilkan) !</div>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="data_keluarga" value="0" id="data_keluarga" />
                                <input class="form-check-input" type="checkbox" value="1" name="data_keluarga" id="data_keluarga">
                                <label class="form-check-label" for="data_keluarga">
                                    Minta Data Keluarga ?
                                </label>
                                <div class="text-small text-muted mb-0">(ceklis jika butuh data keluarga dari pendaftar) !</div>
                                </div>
                            </div>

                             <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="no_rekening" value="0" id="no_rekening" />
                                <input class="form-check-input" type="checkbox" value="1" name="no_rekening" id="no_rekening">
                                <label class="form-check-label" for="no_rekening">
                                    Minta No Rekening ?
                                </label>
                                <div class="text-small text-muted mb-0">(ceklis jika mahasiswa harus input no rekening) !</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="is_buka_pendaftaran" value="0" id="is_buka_pendaftaran" />
                                <input class="form-check-input" type="checkbox" value="1" name="is_buka_pendaftaran"  id="is_buka_pendaftaran">
                                <label class="form-check-label" for="is_buka_pendaftaran">
                                    Buka Pendaftaran ?
                                </label>
                                <div class="text-small text-muted mb-0">(ceklis jika proses pendaftaran dibuka) !</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                <input type="hidden" name="is_validasi_fakultas" value="0" id="is_validasi_fakultas" />
                                <input class="form-check-input" type="checkbox" value="1" name="is_validasi_fakultas"  id="is_validasi_fakultas">
                                <label class="form-check-label" for="is_validasi_fakultas">
                                    Validasi Oleh Fakultas ?
                                </label>
                                <div class="text-small text-muted mb-0">(ceklis jika Fakultas melakukan validasi) !</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <a href="<?= base_url('mbeasiswa/master_beasiswa'); ?>" class="btn btn-danger mr-3"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            <button type="submit" class="btn btn-primary tombolsimpan"><i class="fas fa-folder-open mr-2"></i>Simpan</button>
            </form>
        </div>
    </section>
</div>

<script>
   $(document).ready(function (e) {
        $('#formMaster').submit(function (e) {
                    $('.tombolsimpan').attr('disabled', 'disabled');
                    $('.tombolsimpan').html('<i class="fa fa-spin fa-spinner mr-2"></i>Sedang di Proses')

           })

   })
</script>
