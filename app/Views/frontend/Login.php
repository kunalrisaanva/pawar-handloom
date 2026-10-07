<div class="ps-my-account">
      <div class="container">
        <center>
        <div class="row">
          
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <form class="ps-form--account" action="<?= base_url('front/login') ?>" method="post">
              <h3>Login</h3>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php $errors = session()->getFlashdata('errors'); ?>
              <div class="form-group">
                <input class="form-control" type="text" value="<?= old('email') ?>" name="email" placeholder="Email address">
                <?php if (!empty($errors['email'])): ?>
                    <span class="text-danger"><?= $errors['email'] ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <?php if (!empty($errors['password'])): ?>
                    <span class="text-danger"><?= $errors['password'] ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group submit">
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <button class="ps-btn ps-btn--black ps-btn--outline">Log in</button>
                  </div>
                </div>
              </div>
              <div class="form-group footer"><a href="<?= base_url('/forgotPassword');?>">Lost your password?</a></div>
              <div class="form-group footer"><a href="<?= base_url('/register'); ?>">Doesn't Have an Account? Sign Up Here</a></div>
            </form>
          </div>
        </div></center>
      </div>
    </div>