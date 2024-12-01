  <!-- <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="<?=base_url('template/');?>assets/img/unpkopsuratm.jpg" alt="logo" width="80" class="shadow-light rounded-circle mb-1 mt-2">

            <h4 class="text-dark font-weight-normal">Selamat Datang di <span class="font-weight-bold">SIB-Partnership</span></h4>
            <p class="text-muted">Sistem Informasi Beasiswa - Partnership</p>

            <?= $this->session->flashdata('message'); ?>
            <form method="POST" action="<?= base_url('auth')?>" class="needs-validation" novalidate="">
              <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control" name="username" tabindex="1" value="<?= set_value('username')?>"required autofocus>
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                <div class="invalid-feedback">
                  Please fill in your username
                </div>
              </div>

              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
                 <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>

              <div class="form-group text-right">
                <a href="auth-forgot-password.html" class="float-left mt-3">
                  Forgot Password?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>

              <div class="mt-5 text-center">
                Don't have an account? <a href="<?= base_url('auth/registration')?>">Create new one</a>
              </div>
            </form>

            <div class="text-center mt-5 text-small">
              Copyright &copy; 2021 <div class="bullet"></div> BAK Universitas Negeri Padang</a>
              <div class="mt-2">
                <a href="#">Privacy Policy</a>
                <div class="bullet"></div>
                <a href="#">Terms of Service</a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?=base_url('template/');?>assets/img/unp.jpeg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">Universitas Negeri Padang</h1>
                <h5 class="font-weight-normal text-muted-transparent">Jl. Prof. Dr. Hamka No.1, Air Tawar Bar., Kec. Padang Utara, Kota Padang, Sumatera Barat 25173</h5>
              </div>
             Copyright &copy; 2021 <div class="bullet"></div> BAK </a> <a class="text-light bb" target="_blank" href=""></a>  <a class="text-light bb" target="_blank" href="https://unp.ac.id">Universitas Negeri Padang</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div> -->

    <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand mb-1">
              <img src="<?=base_url('template/');?>assets/img/unpkopsuratm.jpg" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>
            <div class="login-text text-center">
                <h4 class="text-dark font-weight-normal"><span class="font-weight-bold">SIB-Partnership</span></h4>
                <p class="text-muted mb-0">Sistem Informasi Beasiswa - Partnership</p>
                <p class="text-muted">Login menggunakan NIM dan Password portal !!</p>
            </div>

            <?= $this->session->flashdata('message'); ?>
            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4>
            </div>

              <div class="card-body">
                <form method="POST" action="<?= base_url('auth')?>" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="nim">Nim</label>
                    <input type="text" id="nim" type="nim" class="form-control" name="nim" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      masukkan nim
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a  class="text-small">
                          Forgot Password ?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      masukkan password
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; BAK Universitas Negeri Padang
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>