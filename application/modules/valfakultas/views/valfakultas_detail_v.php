
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Mahasiswa</h1>
            </div>
              <div id="flash" data-flash="<?= $this->session->flashdata('message'); ?>"></div>
              <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
            <div class="section-body">
                <h2 class="section-title">Keterangan</h2>
                <p class="section-lead">
                    daftar mahasiswa yang mendaftar beasiswa<br>
                    untuk melakukan proses penetapan, silahkan klik detail mahasiswa terlebih dahulu
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h4 style="color: #34395e; font-size: 20px;">Mahasiswa yang sudah melakukan pendaftaran</h4>
                            </div>
                            
                            <div class="card-body">
                                <a class="btn btn-primary btn-icon icon-left mb-2" href="<?= base_url('valfakultas/excel/'.$id); ?>"><i class="fa fa-file"></i> Download Excel</a>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="mahasiswa_validasi" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>NIM</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Prodi</th>
                                                <th>Fakulltas</th> 
                                                <th>Status Daftar</th> 
                                                <th>Tanggal Daftar</th> 
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

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
          $('#mahasiswa_validasi').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('valfakultas/get_ajax/'.$id) ?>",
                "type": "POST"
            },

            "columnDefs": [
              {
                "targets": [0,7],
                "orderable": false,
              }
          ],
            "order" : []
          });
      });

    </script>