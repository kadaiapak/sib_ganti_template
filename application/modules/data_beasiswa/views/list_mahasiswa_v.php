<!-- Main Content -->
    <div class="main-content">
        <section class="section" >
            <div class="section-header">
                <h1>Daftar Penerima</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#"></a></div>
                    <div class="breadcrumb-item"><a href="<?= base_url('mhs'); ?>">Mhs</a></div>
                </div>
              </div>
              <?= $this->session->flashdata('message'); ?>
            <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
            <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
            <div id="errorFlash" data-flash="<?= $this->session->flashdata('error_upload'); ?>"></div>

            <div class="section-body" style="width: 100%;">
                <h2 class="section-title">Daftar Mahasiswa yang pernah mendapatkan Besiswa</h2>
                <div class="row">
                    <div class="col-6 col-md-6 col-lg-6 col-sm-6">
                        <p class="section-lead">
                            Tabel daftar dan detail mahasiswa yang pernah mendapatkan beasiswa Universitas Negeri Padang baik yang statusnya masih penerima maupun yang sudah dibatalkan.
                            Lakukan validasi penerima beasiswa hanya dengan mengupload file excel yang berisikan list nim mahasiswa yang akan di validasi
                        </p>
                  </div>
              </div>
            
              <div class="row">
                  <div class="col-12 col-md-12 col-lg-12">
                      <div class="card card-warning">
                          <div class="row p-4 ">
                              <div class="col-md-6 col-lg-6 col-xl-6">
                                  <div class="card-header">
                                      <h4 style="font-size: 20px; color: #34395e;">Lakukan Validasi Mahasiswa Penerima Beasiswa</h4>
                                  </div>
                                  <div class="row">
                                      <div class="col-12 col-md-12 col-lg-12">
                                          <div class="card-body">
                                              <?= form_open_multipart('data_beasiswa/mahasiswa/validasiPenerima') ?>
                                              <div class="form-group">
                                                  <label>Upload File Excel</label>
                                                  <input type="file" class="form-control" id="list_nim_penerima" name="list_nim_penerima" accept=".xlsx,.xls">
                                              </div>
                                                <button style="display: inline-block;" type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-file-upload"></i>Upload</button>
                                                <a href="<?= base_url('uploads/format/format.xlsx'); ?>" class="btn btn-success btn-icon icon-left" download=""><i class="fas fa-file-download"></i>Download Format Pencarian</a>
                                                <?= form_close(); ?> 

                                          </div>
                                          
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6 col-lg-6 col-xl-6" style="border-left: 3px solid rgba(0, 0, 0, 0.2);">
                                  <div class="card-header">
                                      <h4 style="font-size: 20px; color: #34395e;">Keterangan Status Beasiswa</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                                          <span class="badge badge-success">Penerima Beasiswa</span>
                                      </div>
                                      <div class="col-md-9 col-lg-9 col-sm-9">
                                          : Mahasiswa yang saat ini sedang mendapatkan beasiswa.
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                                        <span class="badge badge-danger">Dibatalkan</span>
                                      </div>
                                      <div class="col-md-9 col-lg-9 col-sm-9">
                                          : Mahasiswa yang beasiswanya dihentikan karna satu dan lain hal.
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-3 col-lg-3 col-sm-3 mb-2">
                                        <span class="badge badge-warning">Selesai</span> 
                                      </div>
                                      <div class="col-md-9 col-lg-9 col-sm-9">
                                        : Mahasiswa yang pernah mendapatkan beasiswa.
                                      </div>
                                    </div>
                                    
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-warning">
                  <div class="card-header">
                    <h4 style="font-size: 20px; color: #34395e;">Daftar Penerima Beasiswa</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="mahasiswa_data_penerima" style="width: 100%;">
                        <thead>
                          <tr>
                            <th class="text-center">No</th>
                                                <th>NIM</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Prodi</th>
                                                <th>Fakulltas</th> 
                                                <th>Status Beasiswa</th> 
                                                <th>Tanggal Daftar</th> 
                                                <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                      </table>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>

<script>
     
$(document).ready(function() {   
          $('#mahasiswa_data_penerima').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('data_beasiswa/mahasiswa/get_ajax') ?>",
                "type": "POST"
            },

            "columnDefs": [
              {
                "targets": [0,5,6],
                "orderable": false,
              }
          ],
            "order" : []
          });
      });

</script>
    