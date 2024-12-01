    
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
								<form action="<?= base_url('rekap_fakultas/cari'); ?>" method="post" style="display: inline-block;">
									<div class="form-group" style="display: inline-block;">
										<select class="form-control " name="tahun_beasiswa" id="tahun_beasiswa">
											<option value="" selected>-- Pilih Tahun --</option>
												<?php 
												$year =  date("Y");
												for ($i= $year - 5; $i <= $year  ; $i++) { ?>
												<option value="<?= $i ?>" <?= $this->session->userdata('tahun_beasiswa') == $i ? "selected" : null ?>><?= $i ?></option>   
												<?php }  ?>
										</select>
									</div>
                                    <div class="form-group" style="display: inline-block;">
										<select class="form-control " name="fakultas" id="fakultas">
											<option value="" selected>-- Pilih Fakultas --</option>
                                            <?php foreach ($fakultas as $f) { ?>
                                                <option value="<?= $f['fakultas']; ?>" <?= $this->session->userdata('fakultas') == $f['fakultas'] ? "selected" : null ?>><?= $f['fakultas'] ?></option>   
                                            <?php } ?>
										</select>
									</div>
									<button style="margin-left: 10px; padding-top : 7px; padding-bottom : 7px;" type="submit" class="btn btn-primary tombolsimpan"><i class="fas fa-folder-open mr-2"></i>Tampilkan</button>
								</form>
							</div>
						</div>
						<?php if($detail_rekap) { ?>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-12">
										<?php foreach ($detail_rekap as $dt => $value) { ?>
											<table border="1" width='100%'>
												<thead>
													<tr>
														<th colspan="4" class="text-center h5">Rincian Penerima Beasiswa Per Fakultas Tahun <?= $this->session->userdata('tahun_beasiswa'); ?></th>
													</tr>
													<tr>
														<th colspan="4" class="text-center h5">Universitas Negeri Padang</th>
													</tr>
													<tr>
														<th colspan="4" class="text-center h5"><?= $dt; ?></th>
													</tr>
													<tr>
														<th class="text-center">No</th>
														<th class="text-center">Prodi</th>
														<th class="text-center">Jenjang Pendidikan</th>
														<th class="text-center">Total</th>
													</tr>
												</thead>
												<tbody>
													<?php $no = 1; ?>
													<?php foreach ($value as $dl => $vl) { ?>
													<tr style="background-color: lightgrey;">
														<td><?= $no; ?></td>
														<td colspan="3" style="font-weight: bold; font-size: 15px;"><?= $dl; ?></td>
													</tr>
														<?php $subtotal['total_penerima'] = 0; ?>
														<?php foreach($vl as $v){ ?>
														<tr>
															<td></td>
															<td><?= $v['nama_prodi']; ?></td>
															<td><?= $v['jenjang_pendidikan']; ?></td>
															<td><?= $v['total_penerima']; ?></td>
															<?php $subtotal['total_penerima'] += $v['total_penerima'];?>
														</tr>
														
														<?php } ?>
														<tr>
															<td></td>
															<td colspan="2"><b>Sub Total</b></td>
															<td><b><?= $subtotal['total_penerima']; ?></b></td>
														</tr>
													<?php $no++; ?>
													<?php } ?>
												</tbody>
											</table>
										<?php } ?>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-12">
										<table border="1" width='100%'>
											<thead>
												<tr>
													<th colspan="4" class="text-center h5">Rincian Penerima Beasiswa Tahun <?= $this->session->userdata('tahun_beasiswa'); ?></th>
												</tr>
												<tr>
													<th colspan="4" class="text-center h5">Universitas Negeri Padang</th>
												</tr>
												<tr>
													<th colspan="4" class="text-center h5">Semua Fakultas</th>
												</tr>
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Fakultas</th>
													<th class="text-center">Total</th>
												</tr>
											</thead>
											<tbody>
													<?php $no = 1; ?>
													<?php foreach ($detail_rekap_fakultas as $dt => $value) { ?>
													<tr style="background-color: lightgrey;">
														<td><?= $no; ?></td>
														<td colspan="3" style="font-weight: bold; font-size: 15px;"><?= $dt; ?></td>
													</tr>
													<?php $subtotal['total_rekap_fakultas'] = 0 ?>
													<?php foreach ($value as $v) { ?>
													<tr>
														<td></td>
														<td><?= $v['nama_fakultas']; ?></td>
														<td><?= $v['total_penerima']; ?></td>
														<?php $subtotal['total_rekap_fakultas'] += $v['total_penerima']; ?>
													</tr>
													<?php } ?>
													<tr>
														<td></td>
														<td><b>Sub Total</b></td>
														<td><b><?= $subtotal['total_rekap_fakultas']; ?></b></td>
													</tr>
													<?php $no++; ?>
													<?php } ?>
												</tbody>
											</table>
									</div>
								</div>
							</div>
						<?php  } ?>
                    </div>
                  </div>
            </div>
            </div>
        </section>
      </div>
      
  