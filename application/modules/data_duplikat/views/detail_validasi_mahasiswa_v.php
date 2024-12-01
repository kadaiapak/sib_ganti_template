<!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Hasil Validasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#"></a></div>
                    <div class="breadcrumb-item"><a href="<?= base_url('mhs'); ?>">Mhs</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Hasil Validasi</h2>
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 col-sm-6">
                        <p class="section-lead">
                            - Daftar hasil validasi apakah mahasiswa tersebut sedang mendapatkan beasiswa.<br>
                            - Sistem hanya melakukan pengecekan terhadap mahasiswa yang sedang aktif menerima beasiswa, 
                        </p>
                    </div>
                </div>
            
            <div class="row">
                  <div class="col-12 col-md-12 col-lg-12">
                      
                  </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <?= $this->session->flashdata('error_upload'); ?>
                    <?php if($err_nim_length) { ?>
                        <div class="alert alert-danger alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Gagal !</div>
                                Digit nim tidak sesuai, silahkan perbaiki dan upload kembali !
                            </div>
                        </div>
                        <?php foreach($err_nim_length as $en) { ?>
                            <div class="alert alert-danger">
                                <?= $en; ?>    
                            </div>
                        <?php } ?>
                    <?php }else { ?>
                        <?php if(is_null($hasil_validasi)) { ?>
                            <div class="alert alert-danger alert-has-icon">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Gagal !</div>
                                     Pilih terlebih dahulu file yang akan anda cek !
                                </div>
                            </div>
                        <?php } elseif (count($hasil_validasi) == '0'){ ?>
                            <div class="alert alert-success alert-has-icon">
                                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Berhasil </div>
                                    Semua Mahasiswa yang anda cek belum pernah mendapatkan beasiswa !
                                </div>
                            </div>
                            
                        <?php } else {  ?>
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <?php foreach($hasil_validasi as $hv => $value) { ?>
                                                <?php foreach ($value as $nama => $detail) { ?>
                                                    <div class="alert alert-danger" >
                                                        "<?= $detail['nim_mahasiswa'] ?> / <?= $detail['nama_mahasiswa']; ?>" telah mendapatkan beasiswa  <?= $detail['nama_beasiswa_mahasiswa'] ?> 
                                                        periode <?= $detail['periode_mahasiswa'] ?> tahun <?= $detail['tahun_mahasiswa'] ?>  
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                        <?php } ?>
                    <?php } ?>
                  
              </div>
            </div>
          </div>
        </section>
    </div>

    <script>
     
$(document).ready(function() {   
          $('#data_penerima').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('mhs/get_ajax') ?>",
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
    