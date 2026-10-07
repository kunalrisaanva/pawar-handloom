<div class="ps-my-account">
      <div class="container">
        <center>
        <div class="row">
          
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <form class="ps-form--account" action="<?= base_url('register'); ?>" method="post">
              <h3>Registration</h3>
              <!-- ✅ Success Message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>
              <?php $errors = session('errors'); ?>
              <div class="form-group">
                <input class="form-control" type="text" name="company_name" placeholder="Company/Shop Name">
                <?php if (isset($errors['company_name'])): ?>
                    <span class="text-danger"><?= $errors['company_name']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="email" placeholder="Email address">
                <?php if (isset($errors['email'])): ?>
                    <span class="text-danger"><?= $errors['email']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="phone" placeholder="Phone">
                <?php if (isset($errors['phone'])): ?>
                    <span class="text-danger"><?= $errors['phone']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="whatsapp_no" placeholder="whatsapp Number">
                <?php if (isset($errors['whatsapp_no'])): ?>
                    <span class="text-danger"><?= $errors['whatsapp_no']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="address" placeholder="Full Address">
                <?php if (isset($errors['address'])): ?>
                    <span class="text-danger"><?= $errors['address']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <?php if (isset($errors['password'])): ?>
                    <span class="text-danger"><?= $errors['password']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <input class="form-control" type="password" name="confirm_password" placeholder="Retype Password">
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="text-danger"><?= $errors['confirm_password']; ?></span>
                <?php endif; ?>
              </div>
              <div class="form-group submit">
                <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                    <button class="ps-btn ps-btn--black ps-btn--outline">Register</button>
                  </div>
                </div>
              </div>
              <div class="form-group footer"><a href="<?= base_url('/login'); ?>">Already have an Account? Login Here</a></div>
            </form>
          </div>
        </div></center>
      </div>
    </div>