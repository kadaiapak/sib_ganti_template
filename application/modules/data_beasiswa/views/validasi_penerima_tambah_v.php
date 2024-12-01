<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <div id="gagal" data-flash="<?= $this->session->flashdata('gagal'); ?>"></div>
        <div class="section-body">
            <h2 class="section-title">Informasi</h2>
            <div class="row">
                <div class="col-6 col-md-6 col-lg-6">
                    <p class="section-lead">
                        Masukkan NIM yang akan ditambahkan menjadi penerima untuk dicheck data mahasiswa tersebut.
                    </p>
                </div>  
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="font-size: 20px; color: #34395e;">Form Check Data Tambah Penerima Beasiswa</h4>
                            <div class="section-header-button">
                                <a href="<?= base_url('data_beasiswa/beasiswa/detail/'.$id); ?>" class="btn btn-danger ml-2"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="<?= base_url('data_beasiswa/beasiswa/tambah/'.$id); ?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nim">Tuliskan NIM :</label>
                                        <input type="number" value="<?= set_value('nim'); ?>" id="nim" name="nim" placeholder="NIM ..."
                                        class="form-control <?= form_error('nim') ? 'is-invalid' : (set_value('nim') ? 'is-valid' : null) ; ?>"
                                        >
                                        <?= form_error('nim', '<small class="text-danger pl-3">', '</small>'); ?>  
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