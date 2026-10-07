<div class="ps-my-account">
      <div class="container">
        <center>
        <div class="row">
          
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <form class="ps-form--account" action="<?= base_url('forgotPassword') ?>" method="post">
              <h3>Forgot Password</h3>
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
              
              <div class="form-group submit">
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <button class="ps-btn ps-btn--black ps-btn--outline">Submit</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div></center>
      </div>
    </div>