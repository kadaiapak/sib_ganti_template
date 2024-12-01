    
      <!-- Main Content -->
     <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><?= $title; ?></h1>
            </div>

            <div class="section-body">
                <h2 class="section-title">Statistik Penerima Beasiswa Per tahun</h2>
                <div class="row">
                    <div class="col-lg-16 col-md-6 col-6 col-sm-6">
                        <p class="section-lead">Silahkan pilih tahun yang ingin ditampilkan</p>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card card-warning">
                      <div class="card-header">
                          <div class="row">
                              <form action="<?= base_url('statistik/cari'); ?>" method="post" style="display: inline-block;">
                                  <div class="form-group" style="display: inline-block;">
                                      <select class="form-control " name="tahun_beasiswa" id="tahun_beasiswa">
                                          <option value="" selected>Pilih Tahun</option>
                                            <?php 
                                            $year =  date("Y");
                                            for ($i= $year - 5; $i <= $year  ; $i++) { ?>
                                              <option value="<?= $i ?>" <?= $this->session->userdata('tahun_beasiswa') == $i ? "selected" : null ?>><?= $i ?></option>   
                                            <?php }  ?>
                                      </select>
                                  </div>
                                  <button style="margin-left: 10px; padding-top : 7px; padding-bottom : 7px;" type="submit" class="btn btn-primary tombolsimpan"><i class="fas fa-folder-open mr-2"></i>Tampilkan</button>
                              </form>
                          </div>
                      </div>

                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Fakultas</th>
                                          <th>Prodi</th>
                                          <?php 
                                              foreach($nama_beasiswa as $nb){
                                                echo "<th>$nb->singkatan</th>";
                                              }
                                          ?>
                                      </tr>
                                  </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach($rekap_beasiswa as $rb){ ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <?php foreach ($rb as $key => $value) { ?>
                                        <td <?= $value > 0 ? "style='background-color: yellow;'" : null ; ?>><?= $value ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php $no++; ?>
                                    <?php } ?>
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
      
  