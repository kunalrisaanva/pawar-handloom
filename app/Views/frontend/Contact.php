<div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/contact.jpg');?>">
      <div class="container">
        <h1>CONTACT US</h1>
      </div>
    </div>
    <div class="ps-site-features">
      <div class="container">
        <div class="ps-block--features">
          <div class="row ps-col-tiny">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12" style="padding: 30px;background: antiquewhite;">
              <div class="ps-block--feature">
                <div class="ps-block__left"><i class="pe-7s-call"></i></div>
                <div class="ps-block__right">
                  <h4>Call Us</h4><small>+91 9630504663<br>+91 9039119245</small>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 " style="padding: 30px;background: antiquewhite;">
              <div class="ps-block--feature">
                <div class="ps-block__left"><i class="fa fa-envelope"></i></div>
                <div class="ps-block__right">
                  <h4>E-Mail Us</h4><small>info@pawarhandloom.com</small>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 " style="padding: 30px;background: antiquewhite;">
              <div class="ps-block--feature">
                <div class="ps-block__left"><i class="fa fa-map-marker"></i></div>
                <div class="ps-block__right">
                  <h4>Our Address</h4><small>97-B, Ground Floor, Rishi Apartment, Rajendra Nagar, Indore 452012

                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="ps-contact">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success mb-4">
                        <?= session()->getFlashdata('success'); ?>
                    </div>
                <?php endif; ?>

            <form class="ps-form--contact" action="<?= base_url('/contact'); ?>" method="POST">
              <h3>Drop us a line</h3>
              <div class="form-group">
                <label>Your name (required)</label>
                <input class="form-control" type="text" name="name" placeholder="Your Name">
              </div>
              <div class="form-group">
                <label>Your Email (required)</label>
                <input class="form-control" type="text" name="email" placeholder="Your Email">
              </div>
              <div class="form-group">
                <label>Subject</label>
                <input class="form-control" type="text" name="subject_type" placeholder="Reason Subject....">
              </div>
              <div class="form-group">
                <label>Your Message</label>
                <textarea class="form-control" rows="4" name="message"></textarea>
              </div>
              <div class="form-group submit">
                <button type="submit" name="contactSubmit" value="1" class="ps-btn ps-btn--fullwidth ps-btn--black ps-btn--outline">Send</button>
              </div>
            </form>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.6422356717367!2d75.8263688!3d22.6671239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fdd9f5dc3c01%3A0x50740ede54c4e5cf!2sPAWAR%20HANDLOOM%20(Maheshwari%20%26%20Chanderi%20Saree%20Mfrs.%20%26%20Wholesaler)!5e0!3m2!1sen!2sin!4v1735201591655!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>