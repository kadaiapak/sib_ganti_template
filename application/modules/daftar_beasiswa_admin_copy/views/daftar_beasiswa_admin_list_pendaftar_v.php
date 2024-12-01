<div class="main-content">
    <section class="section" >
        <div class="section-header">
            <h1>List Pendaftar</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#"></a></div>
                <div class="breadcrumb-item"><a href="<?= base_url('daftar-beasiswa-admin'); ?>">Daftar Beasiswa Admin</a></div>
            </div>
        </div>
        <?= $this->session->flashdata('message'); ?>
        <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
        <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
        <div id="errorFlash" data-flash="<?= $this->session->flashdata('error_upload'); ?>"></div>

        <div class="section-body" style="width: 100%;">
            <h2 class="section-title">Daftar Mahasiswa Yang Sudah Mendaftar Besiswa Ini</h2>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6 col-sm-6">
                    <p class="section-lead">
                        Tabel daftar dan detail mahasiswa yang sudah mendaftar beasiswa ini.
                        Gunakan halaman ini untuk melihat list dan rincian semua mahasiswa yang sudah mendaftar beasiswa, baik itu mendaftar secara mandiri maupun didaftarkan oleh admin.
                    </p>
                </div>
            </div>
        
            <!-- <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-warning" style="padding: 2rem 0 2rem 0;">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-lg-6">
                                <div class="card-header">
                                    <h4 style="color: #34395e; font-size: 20px;">Lakukan Validasi Mahasiswa Penerima Beasiswa</h4>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <div class="card-body">
                                            < ?= form_open_multipart('mhs/validasiPenerima') ?>
                                            <div class="form-group">
                                                <label>Upload File Excel</label>
                                                <input type="file" class="form-control" id="list_nim_penerima" name="list_nim_penerima" accept=".xlsx,.xls">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-file-upload"></i>Upload</button>
                                            <a href="< ?= base_url('uploads/format/format.xlsx'); ?>" class="btn btn-success btn-icon icon-left" download=""><i class="fas fa-file-download"></i>Download Format Pencarian</a>
                                            < ?= form_close(); ?> 
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6" style="border-left: 3px solid rgba(0, 0, 0, 0.2);">
                            <div class="card-header">
                                <h4 style="color: #34395e; font-size: 20px;">Keterangan Status Beasiswa</h4>
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
            </div> -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="color: #34395e; font-size: 20px;">List All</h4>
                            <form action="<?= base_url('daftar-beasiswa-admin/excel'); ?>" method="post">
                                <input type="hidden" name='id_beasiswa' value="<?= $detail_beasiswa['id']; ?>">
                                <input type="hidden" name='nama_beasiswa' value="<?= $detail_beasiswa['nama_beasiswa']; ?>">
                                <input type="hidden" name='periode' value="<?= $detail_beasiswa['periode']; ?>">
                                <input type="hidden" name='tahun' value="<?= $detail_beasiswa['tahun']; ?>">
                                <button type="submit" class="btn btn-success btn-icon icon-left"><i class="fas fa-table" ></i>Download Excel</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data_pendaftar_beasiswa" style="width: 100%;">
                                    <thead>
                                      <tr>
                                        <th class="text-center">No</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Prodi</th>
                                        <th>Fakulltas</th> 
                                        <th>Admin Pendaftar</th> 
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
          $('#data_pendaftar_beasiswa').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('daftar-beasiswa-admin/get_ajax/'.$id_beasiswa.'/all') ?>",
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
    