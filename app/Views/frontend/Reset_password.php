<div class="ps-my-account">
  <div class="container">
    <center>
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
        <form class="ps-form--account" action="<?= base_url('reset-password/' . $token) ?>" method="post">
          <h3>Reset Your Password</h3>
          
          <?php if (!empty($errors)) : ?>
              <div class="alert alert-danger">
                  <?= implode('<br>', $errors) ?>
              </div>
          <?php endif; ?>

          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="New Password">
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm New Password">
          </div>

          <div class="form-group submit">
            <button class="ps-btn ps-btn--black ps-btn--outline">Reset Password</button>
          </div>
        </form>
      </div>
    </div></center>
  </div>
</div>
