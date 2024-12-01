<div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <img src="<?=base_url('template/');?>assets/img/unpkopsuratm.jpg" alt="logo" width="80" class="shadow-light rounded-circle mb-1 mt-2">

            <h6 href="index.html">SIB-Partnership</h6>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SIBP</a>
          </div>
          <ul class="sidebar-menu">

              <li class="menu-header">ADMIN</li>
              <li class="<?= ($this->uri->segment(1,0) == 'dashboard' ? 'active' : ''); ?>"><a class="nav-link" href="<?= base_url('dashboard'); ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>

              <?php
                  $query = "SELECT `pemisah_menu`.`id`, `nama_pemisah` FROM `pemisah_menu` ORDER BY `no_urut` ASC";
                  $pemisah_menu = $this->db->query($query)->result_array();
              ?>
              <?php foreach($pemisah_menu as $pm) : ?>
              <?php $single_menu = single_menu($pm['id']) ?>
              <?php $main_menu = main_menu($pm['id']) ?>
              <?php $sub_menu = sub_menu() ?>

              <?php if($single_menu || $main_menu) { ?>
                <li class="menu-header"><?= $pm['nama_pemisah'] ?></li>
              <?php } ?>
              <?php foreach ($single_menu as $sim) : ?>
                    <li class="<?= ($this->uri->segment(1,0) == $sim['url'] ? 'active' : ''); ?>"><a class="nav-link" href="<?= base_url($sim['url']); ?>"><i class="<?= $sim['icon']; ?>"></i><span><?= $sim['nama_menu']; ?></span></a></li>
              <?php endforeach ?>

              <?php foreach($main_menu as $mm) : ?>
                <li class="nav-item dropdown <?= ($mm['url'] == $this->uri->segment(1,0)? "active" : "") ?>">
                  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="<?= $mm['icon']; ?>"></i>
                    <span><?= $mm['nama_menu']; ?>
                  </span></a>
                  <ul class="dropdown-menu">

                  <?php foreach($sub_menu as $sm) : ?>
                    <?php if($sm['main_menu'] == $mm['kode_menu']){ ?>
                      <li class="<?= ($sm['url'] == $this->uri->segment(1,0).$this->uri->slash_segment(2,'leading') ? "active" : "") ?>">
                        <a class="nav-link" href="<?= base_url($sm['url']); ?>"><?= $sm['nama_menu']; ?>
                        </a>
                      </li>
                    <?php } ?>
                  <?php endforeach  ?>
                  </ul>
                </li>
              <?php endforeach ?>
              <?php endforeach; ?>
          </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
              <a href="<?= base_url('auth/logout'); ?>" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> LOGOUT
              </a>
            </div>
        </aside>
      </div>
