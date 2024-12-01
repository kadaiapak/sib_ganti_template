<div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="<?= base_url()?>/assets/img/beasiswa.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>RegisteWr</h4></div>

              <div class="card-body">
                <form method="POST" action="<?= base_url('auth/registration');?>">
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="name">Full Name</label>
                      <input id="name" type="text" class="form-control" name="name" value="<?= set_value('name'); ?>" autofocus>
                      <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>  
                    </div>                       
                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <label for="username">Username</label>
                      <input id="username" type="text" class="form-control" name="username" value="<?= set_value('username'); ?>" autofocus>
                      <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>  
                    </div>                 
                  </div>

                  <div class="form-group">
                    <label for="text">Email</label>
                    <input id="email" type="email" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password1" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password1">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                      <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" class="form-control" name="password2">
                    </div>
                  </div>

            <div class="mt-3 text-center">
                Alaready have an account? <a href="<?= base_url('auth')?>">Login</a>
              </div>

                  <div class="form-group mt-3">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
