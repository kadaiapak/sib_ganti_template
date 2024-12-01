<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Keterangan</h2>
            <div class="row">
                <div class="col-6    col-md-6 col-lg-6">
                    <p class="section-lead">
                        Edit Data Mahasiswa dengan NIM <?= $data_penerima->m_nim; ?>
                    </p>
                </div>  
            </div>
            
            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Edit Data Penerima Beasiswa</h4>
                            <div class="section-header-button">
                                <a href="<?= base_url('data_beasiswa/mahasiswa/detail/'.$data_penerima->m_nim); ?>" class="btn btn-danger ml-2"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="" method="post">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nomor Induk Mahasiswa (NIM): </label>
                                            <input type="text" value="<?= $data_penerima->m_nim; ?>"  class="form-control" id="nim" name="nim" disabled>
                                            <input type="hidden" value="<?= $data_penerima->m_nim; ?>"  class="form-control" id="nim" name="nim">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nama Panjang :</label>
                                            <input type="text" value="<?= $this->input->post('name') ??  $data_penerima->m_nama; ?>" 
                                            class="form-control <?= form_error('name') ? 'is-invalid' : (set_value('name') ? 'is-valid' : null) ; ?>" 
                                            id="name" name="name">
                                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>  
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Program Studi :</label>
                                            <input type="text" value="<?= $this->input->post('prodi') ??  $data_penerima->m_prodi; ?>" 
                                            class="form-control <?= form_error('prodi') ? 'is-invalid' : (set_value('prodi') ? 'is-valid' : null) ; ?>" 
                                            id="prodi" name="prodi" placeholder="Prodi ...">
                                            <?= form_error('prodi', '<small class="text-danger pl-3">', '</small>'); ?>  
                                        </div>  
                                        <div class="form-group">
                                            <label for="name">Fakultas :</label>
                                            <input type="text" value="<?= $this->input->post('fakultas') ??  $data_penerima->m_fakultas; ?>" 
                                            class="form-control <?= form_error('fakultas') ? 'is-invalid' : (set_value('fakultas') ? 'is-valid' : null) ; ?>" 
                                            id="fakultas" name="fakultas" placeholder="Fakutlas ...">
                                            <?= form_error('fakultas', '<small class="text-danger pl-3">', '</small>'); ?>  
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input type="hidden" name="is_active" value="0" id="is_active" />
                                                <input class="form-check-input" <?= $data_penerima->m_aktif == '1' ? "checked" : null; ?> 
                                                type="checkbox" value="1" name="is_active"  id="is_active">
                                                <label class="form-check-label" for="is_active">
                                                    Mahasiswa aktif ?
                                                </label>
                                                <div class="text-small text-muted mb-1">(ceklis jika aktif) !</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>