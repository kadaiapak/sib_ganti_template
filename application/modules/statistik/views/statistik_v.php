    
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
								<?php foreach ($detail_rekap as $dt => $value) { ?>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<h4>Beasiswa : <?= $dt; ?></h4>
									<table class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>No</th>
												<th>Prodi</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1; ?>
											<?php foreach ($value as $dl => $vl) { ?>
											<tr style="background-color: yellow;">
												<td><?= $no; ?></td>
												<td colspan="2"><?= $dl; ?></td>
											</tr>
												<?php foreach($vl as $v){ ?>
												<tr>
													<td></td>
													<td><?= $v['nama_prodi']; ?></td>
													<td><?= $v['total_penerima']; ?></td>
												</tr>
												<?php } ?>
											<?php $no++; ?>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<?php } ?>
							</div>
                      	</div>
                    </div>
                  </div>
            </div>
            </div>
        </section>
      </div>
      
  