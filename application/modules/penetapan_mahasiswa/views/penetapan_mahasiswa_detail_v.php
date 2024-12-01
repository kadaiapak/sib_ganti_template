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
                                <h4 style="font-size: 20px; color: #34395e;">Mahasiswa yang sudah dilakukan validasi :</h4>
                            </div>
                            <div class="card-body">
                              <a class="btn btn-primary btn-icon icon-left mb-2" href="<?= base_url('penetapan_mahasiswa/excel/'.$id); ?>"><i class="fa fa-file"></i> Download Excel</a>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="mahasiswa_data_pendaftardua" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>NIM</th>
                                                <th>Nama Mahasiswa</th>
                                                <th>Prodi</th>
                                                <th>Fakulltas</th>
                                                <th>IPK</th>
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
          $('#mahasiswa_data_pendaftardua').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax": {
                "url": "<?= base_url('penetapan-mahasiswa/get_ajax/'.$id) ?>",
                "type": "POST"
            },

            "columnDefs": [
              {
                "targets": [0,8],
                "orderable": false,
              }
          ],
            "order" : []
          });
      });

    </script>
