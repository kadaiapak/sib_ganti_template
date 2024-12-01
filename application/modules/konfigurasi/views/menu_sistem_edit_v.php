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
                        Edit data mengenai menu yang akan dibuat, selanjutnya setting akses pada role akses.
                    </p>
                </div>
            </div>

            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h4 style="color: #34395e; font-size: 20px;">Form Input Edit Menu</h4>
                            <div class="section-header-button">
                                <a href="<?= base_url('konfigurasi/menu_sistem'); ?>" class="btn btn-danger ml-2"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6 col-lg-6">
                                <form action="" method="post">
                                <div class="card-body">
                                    <div class="form-group has-error">
                                        <label for="urut" class="mb-0">No </label>
                                        <div class="text-small text-muted mb-1">no urut agar rapi</div>
                                        <input type="text" id="urut" name="urut"
                                        class="form-control <?= form_error('urut') ? 'is-invalid' : (set_value('urut') ? 'is-valid' : null) ; ?>"
                                        value="<?= $this->input->post('urut') ?? $row->no_urut_rapi; ?>">
                                        <?= form_error('urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group has-error">
                                        <label for="nama_menu">Nama Menu :</label>
                                        <input type="hidden" name="kode_menu" value="<?= $row->kode_menu; ?>">
                                        <input type="text" id="nama_menu" name="nama_menu"
                                        class="form-control <?= form_error('nama_menu') ? 'is-invalid' : (set_value('nama_menu') ? 'is-valid' : null) ; ?>"
                                        value="<?= $this->input->post('nama_menu') ?? $row->nama_menu; ?>">
                                        <?= form_error('nama_menu', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group has-error">
                                        <label for="url">URL :</label>
                                        <input type="text" id="url" name="url"
                                        class="form-control <?= form_error('url') ? 'is-invalid' : (set_value('url') ? 'is-valid' : null) ; ?>"
                                        value="<?= $this->input->post('url') ?? $row->url; ?>">
                                        <?= form_error('url', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group has-error">
                                        <label for="urut" class="mb-0">No Menu</label>
                                        <div class="text-small text-muted mb-1">no menu</div>
                                        <input type="text" id="no_menu" name="no_menu"
                                        class="form-control <?= form_error('no_menu') ? 'is-invalid' : (set_value('no_menu') ? 'is-valid' : null) ; ?>"
                                        value="<?= $this->input->post('no_menu') ?? $row->no_urut; ?>">
                                        <?= form_error('no_menu', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group has-error">
                                        <label for="icon" class="mb-0">Icon :</label>
                                        <div class="text-small text-muted mb-1">inputkan font awesome icon<div class="bullet"></div> 'fas fa-fw fa-user-plus'</div>
                                        <input type="text" id="icon" name="icon"
                                        class="form-control <?= form_error('icon') ? 'is-invalid' : (set_value('icon') ? 'is-valid' : null) ; ?>"
                                        value="<?= $this->input->post('icon') ?? $row->icon; ?>">
                                        <?= form_error('icon', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="level_menu">Pilih Level Menu :</label>
                                        <select class="form-control <?= form_error('level_menu') ? 'is-invalid' : null ; ?>" name="level_menu" id="level_menu">
                                            <option value="" selected>Pilih Level Menu ...</option>
                                            <option value="single_menu" <?= $row->level == 'single_menu' ? "selected" : "";?> >Single Menu</option>
                                            <option value="main_menu" <?= $row->level == 'main_menu' ? "selected" : "";?> >Main Menu</option>
                                            <option value="sub_menu" <?= $row->level == 'sub_menu' ? "selected" : "";?> >Sub Menu</option>
                                        </select>
                                        <?= form_error('level_menu', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="main_menu" class="mb-0">Pilih Menu Header :</label>
                                        <div class="text-small text-muted mb-1">Pilih Header dari menunya jika yang ingin ditambahkan adalah sub menu!</div>
                                        <select class="form-control <?= form_error('main_menu') ? 'is-invalid' : null ; ?>" name="main_menu" id="main_menu">
                                            <option value=null selected>Main menu ...</option>
                                                <?php foreach ($tambah_menu as $tm) :?>
                                                <option value="<?= $tm['kode_menu']; ?>" <?= $tm['kode_menu'] == $row->main_menu ? "selected" : ""; ?>><?= $tm['nama_menu']; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                        <?= form_error('main_menu', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="hidden" name="is_active" value="0" id="is_active" />
                                        <input class="form-check-input" <?= $row->aktif == '1' ? "checked" : null; ?>
                                        type="checkbox" value="1" name="is_active"  id="is_active">
                                        <label class="form-check-label" for="is_active">
                                            Aktif ?
                                        </label>
                                        <div class="text-small text-muted mb-1">Ceklis jika ingin diaktifkan!</div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="hidden" name="is_show" value="0" id="is_show" />
                                        <input class="form-check-input" <?= $row->show == '1' ? "checked" : null; ?>
                                        type="checkbox" value="1" name="is_show"  id="is_show">
                                        <label class="form-check-label" for="is_show">
                                            Tampilkan ?
                                        </label>
                                        <div class="text-small text-muted mb-1">Ceklis jika ingin ditampilkan!</div>
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
