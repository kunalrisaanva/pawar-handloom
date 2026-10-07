<div id="homepage-1">
      <div class="ps-home-banner">
        <div class="ps-carousel--animate ps-carousel--1st">
          <?php foreach($sliderList as $slider): ?>
          <div class="item">
            <div class="ps-banner left">
              <div class="container" style="width: 100%; padding-left: 0px; padding-right: 0px;"><img src="<?= base_url('public/uploads/admin/slider_image/' .$slider->slider_image); ?>" alt="">
                <div class="ps-banner__content" style="margin-left: 30px;">
                  <h1 style="color: #fff;"><?= $slider->slider_title ?></h1>
                  <a class="ps-btn ps-btn--outline ps-btn--white" style="color: #fff;" href="#">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          

        </div>
      </div>

      <!-- Saree Sub category here -->
        <div class="ps-lookbook" style="background-color: bisque; margin-bottom: 20px;">
        <div class="container"><br>
          <div class="ps-section__header" style="text-align: center;">
            <h3>Saree Categories</h3><hr>
          </div><br>
          <div class="masonry-wrapper" data-col-lg="4" data-col-md="3" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
            <div class="ps-masonry">
              <div class="grid-sizer"></div>
              <?php foreach($SareeSubCat as $sareeCategory): ?>
              <div class="grid-item">
                <div class="grid-item__content-wrapper">
                        <div class="ps-block--lookbook"><a href="<?= base_url('/shop/'.$sareeCategory->cat_id.'/' .$sareeCategory->id); ?>"><img src="<?= base_url('public/uploads/admin/category_image/subCategory/' .$sareeCategory->subCategory_image); ?>" alt=""></a><a href="<?= base_url('/shop/'.$sareeCategory->cat_id.'/' .$sareeCategory->id); ?>" style="display: none;"></a></div>
                </div>
                <div class="text-center"><a href="<?= base_url('/shop/'.$sareeCategory->cat_id.'/' .$sareeCategory->id); ?>" class="ps-btn ps-btn--outline ps-btn--white"><?= $sareeCategory->name ?></a></div>
              </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>
      </div>

      <!-- //Saree Sub category end -->


      <div class="ps-lookbook" style="background-color: bisque; margin-bottom: 20px;">
        <div class="container"><br>
          <div class="ps-section__header" style="text-align: center;">
            <h3>Product Categories</h3><hr>
          </div><br>
          <div class="masonry-wrapper" data-col-lg="4" data-col-md="3" data-col-sm="2" data-col-xs="1" data-gap="30" data-radio="100%">
            <div class="ps-masonry">
              <div class="grid-sizer"></div>
              <?php foreach($categoryList as $category): ?>
              <div class="grid-item">
                <div class="grid-item__content-wrapper">
                        <div class="ps-block--lookbook"><a href="<?= base_url('/shop/' .$category->id); ?>"><img src="<?= base_url('public/uploads/admin/category_image/' .$category->category_image); ?>" alt=""></a><a href="<?= base_url('/shop/' .$category->id); ?>" style="display: none;"></a></div>
                </div>
                <div class="text-center"><a href="<?= base_url('/shop/' .$category->id); ?>" class="ps-btn ps-btn--outline ps-btn--white"><?= $category->category_name ?></a></div>
              </div>
              <?php endforeach; ?>

            </div>
          </div>
        </div>
      </div>
                  <!-- New Arrivals start -->
        <div class="ps-section ps-product-collection ps-trending">
            <div class="container">
                <div class="ps-section__header">
                    <h3>New Arrivals</h3>
                    <p>New Arrival in this week</p>
                    <a href="https://pawarhandloom.com/shop/6" class="ps-btn ps-btn--outline ps-btn--white"> View All</a>
                </div>
                <div class="ps-section__content">
                    <div class="row">
                        <?php if (!empty($NewArrivals)) : ?>
                            <?php foreach ($NewArrivals as $product) : ?>
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="ps-product">
                                        <div class="ps-product__thumbnail">
                                            <a class="ps-product__overlay" href="<?= base_url('/detail/' . $product->id); ?>"></a>
                                            <a class="ps-product__img" href="<?= base_url('/detail/' . $product->id); ?>">
                                                <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>"/>
                                            </a>
                                            <a class="ps-product__img-alt" href="<?= base_url('/detail/' . $product->id); ?>">
                                                <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>"/>
                                            </a>
                                        </div>
                                        <div class="ps-product__content">
                                            <a class="ps-product__title" href="<?= base_url('/detail/' . $product->id); ?>"><?= esc($product->product_name); ?></a>
                                            <!-- <p class="ps-product__price">INR < ?= number_format($product->offer_price, 2); ?></p> -->
                                            <?php $session = session();
                                             if ($session->has('is_logged_in')): ?>
                                              <p class="ps-product__price">INR <?= number_format($product->offer_price, 2); ?></p>
                                            <?php endif; ?>
                                            <!-- <a href="https://wa.me/?text=I'm%20interested%20in%20this%20product:%20< ?= urlencode(base_url('product/details/' . $product->id)); ?>" class="ps-btn ps-btn--outline ps-btn--white">
                                                <i class="fa fa-whatsapp"></i> Quick Enquiry
                                            </a> -->
                                            <?php 
                                              $session = session();
                                            if (!$session->has('is_logged_in')) : ?>
                                            <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product->id; ?>">
                                              <i class="fa fa-whatsapp"></i> Quick Enquiry
                                            </button>
                                            <?php else : ?>
                                              <a href="<?= base_url('/detail/'.$product->id); ?>" class="ps-btn ps-btn--outline ps-btn--white" >
                                                Details
                                              </a>

                                            <?php endif; ?>  
                                        </div>
                                    </div>
                                </div>
                               <!-- Dynamic Modal for Each Product -->
                            <div class="modal fade" id="quickEnquiryModal_<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="quickEnquiryModalLabel_<?= $product->id; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="quickEnquiryModalLabel_<?= $product->id; ?>">Quick Enquiry</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="enquiryForm_<?= $product->id; ?>" action="#" method="POST"/>
                                                <input type="hidden" name="product_id" value="<?= $product->id; ?>"/>
                                                <input type="hidden" name="product_name" value="<?= esc($product->product_name); ?>"/>
                                                <input type="hidden" name="product_price" value="<?= esc($product->offer_price); ?>" />
                                                <input type="hidden" name="description" value="<?= esc($product->description); ?>" />
                                                <div class="form-group">
                                                    <label for="Name">Enter Name</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Enter Email</label>
                                                    <input type="email" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Enter Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="phone_number" required>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="sendWhatsAppMessage(<?= $product->id; ?>)">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- //Dynamic Modal for Each Product  --> 
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <h4>No Products Here</h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
                        <!-- // New Arrivals ENd -->  

      <div class="ps-home-collection" style="background-color: antiquewhite;">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12  ">
              <div class="ps-block--collection"><img src="<?= base_url('public/frontend/img/a1.png');?>" alt=""></div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12  ">
              <div class="">
                <div class="ps-block__content">
                  <h2 style="text-align: center;">Pawar Handloom</h2>
                  <p style="text-align: center; color: #000; font-weight: bold;">Explore our exquisite collection of Maheshwari, Chanderi and Handblock Printed Sarees and Dress Material inspired by the royal heritage weaves of Madhya Pradesh, India.
                  </p>
                  <p style="text-align: center; color: #000;">Pawar Handloom is our ancestry brand from Sth generation. I am Piyush Kailash N.K. Pawar extended my Sth ancestral business to the next level. Initially my great great grandfather brought by Former Queen of Malwa kingdom Ahilya Mata as an artisian to Maheshwar. Back then my grandfather named "Mr. Nathusa Kevalram Pawar' established "Pawar Handloom" as a traditional clothing brand of Maheshwari & Induri Sarees since 90 years back in Maheshwar, Madhya Pradesh.

                  </p>
                  <a href="<?= base_url('/about');?>" class="ps-btn ps-btn--outline ps-btn--white" style="text-align: center; margin-left: 111px;"><i class="fa fa-comments"></i> Read More</a>

                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12  "><div class="ps-block--collection"><img src="<?= base_url('public/frontend/img/a2.png');?>" alt=""></div></div>
          </div>
        </div>
      </div>


                <!-- Best Sellers start -->
          <div class="ps-section ps-product-collection ps-trending">
              <div class="container">
                  <div class="ps-section__header">
                      <h3>Best Sellers</h3>
                      <p>Best Sellers in this week</p>
                      <a href="https://pawarhandloom.com/shop/7" class="ps-btn ps-btn--outline ps-btn--white"> View All</a>
                  </div>
                  <div class="ps-section__content">
                      <div class="row">
                          <?php if (!empty($BestSellers)) : ?>
                              <?php foreach ($BestSellers as $product) : ?>
                                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                      <div class="ps-product">
                                          <div class="ps-product__thumbnail">
                                              <a class="ps-product__overlay" href="<?= base_url('detail/' . $product->id); ?>"></a>
                                              <a class="ps-product__img" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>"/>
                                              </a>
                                              <a class="ps-product__img-alt" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>"/>
                                              </a>
                                          </div>
                                          <div class="ps-product__content">
                                              <a class="ps-product__title" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <?= esc($product->product_name); ?>
                                              </a>
                                              <!-- <p class="ps-product__price">INR < ?= number_format($product->offer_price, 2); ?></p> -->
                                              <?php $session = session();
                                               if ($session->has('is_logged_in')): ?>
                                                <p class="ps-product__price">INR <?= number_format($product->offer_price, 2); ?></p>
                                              <?php endif; ?>
                                              <!-- <a href="https://wa.me/yourwhatsappnumber?text=I'm%20interested%20in%20< ?= urlencode($product->product_name); ?>" class="ps-btn ps-btn--outline ps-btn--white">
                                                  <i class="fa fa-whatsapp"></i> Quick Enquiry
                                              </a> -->
                                              <?php 
                                              $session = session();
                                            if (!$session->has('is_logged_in')) : ?>
                                            <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product->id; ?>">
                                              <i class="fa fa-whatsapp"></i> Quick Enquiry
                                            </button>
                                            <?php else : ?>
                                              <a href="<?= base_url('/detail/'.$product->id); ?>" class="ps-btn ps-btn--outline ps-btn--white" >
                                                Details
                                              </a>

                                            <?php endif; ?>  
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Dynamic Modal for Each Product -->
                            <div class="modal fade" id="quickEnquiryModal_<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="quickEnquiryModalLabel_<?= $product->id; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="quickEnquiryModalLabel_<?= $product->id; ?>">Quick Enquiry</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="enquiryForm_<?= $product->id; ?>" action="#" method="POST"/>
                                                <input type="hidden" name="product_id" value="<?= $product->id; ?>"/>
                                                <input type="hidden" name="product_name" value="<?= esc($product->product_name); ?>"/>
                                                <input type="hidden" name="product_price" value="<?= esc($product->offer_price); ?>" />
                                                <input type="hidden" name="description" value="<?= esc($product->description); ?>" />
                                                <div class="form-group">
                                                    <label for="Name">Enter Name</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Enter Email</label>
                                                    <input type="email" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Enter Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="phone_number" required>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="sendWhatsAppMessage(<?= $product->id; ?>)">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- //Dynamic Modal for Each Product  --> 
                              <?php endforeach; ?>
                          <?php else : ?>
                              <p class="text-center">No Best Sellers available.</p>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Best Sellers end -->


                              <!-- Celebs Look Start -->
      <div class="ps-section ps-product-collection ps-trending" style="background-color: antiquewhite;">
        <div class="container">
          <div class="ps-section__header">
            <h3>Celebs Look</h3>
            <p>Best Look in this week</p>
            <a href="https://pawarhandloom.com/shop/8" class="ps-btn ps-btn--outline ps-btn--white"> View All</a>
          </div>
          <div class="ps-section__content">
                    <div class="row">
                          <?php if (!empty($CelebsLook)) : ?>
                              <?php foreach ($CelebsLook as $product) : ?>
                                  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                      <div class="ps-product">
                                          <div class="ps-product__thumbnail">
                                              <a class="ps-product__overlay" href="<?= base_url('detail/' . $product->id); ?>"></a>
                                              <a class="ps-product__img" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>" style="width:308px; height:462px"/>
                                              </a>
                                              <a class="ps-product__img-alt" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <img src="<?= base_url('/public/'.$product->cover_image); ?>" alt="<?= esc($product->product_name); ?>" style="width:308px; height:462px"/>
                                              </a>
                                          </div>
                                          <div class="ps-product__content">
                                              <a class="ps-product__title" href="<?= base_url('detail/' . $product->id); ?>">
                                                  <?= esc($product->product_name); ?>
                                              </a>
                                              <!-- <p class="ps-product__price">INR < ?= number_format($product->offer_price, 2); ?></p> -->
                                              <?php $session = session();
                                               if ($session->has('is_logged_in')): ?>
                                                <p class="ps-product__price">INR <?= number_format($product->offer_price, 2); ?></p>
                                              <?php endif; ?>
                                              <!-- <a href="https://wa.me/yourwhatsappnumber?text=I'm%20interested%20in%20< ?= urlencode($product->product_name); ?>" class="ps-btn ps-btn--outline ps-btn--white">
                                                  <i class="fa fa-whatsapp"></i> Quick Enquiry
                                              </a> -->
                                              <?php 
                                              $session = session();
                                            if (!$session->has('is_logged_in')) : ?>
                                            <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product->id; ?>">
                                              <i class="fa fa-whatsapp"></i> Quick Enquiry
                                            </button>
                                            <?php else : ?>
                                              <a href="<?= base_url('/detail/'.$product->id); ?>" class="ps-btn ps-btn--outline ps-btn--white" >
                                                Details
                                              </a>

                                            <?php endif; ?>  

                                          </div>
                                      </div>
                                  </div>
                                  <!-- Dynamic Modal for Each Product -->
                            <div class="modal fade" id="quickEnquiryModal_<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="quickEnquiryModalLabel_<?= $product->id; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="quickEnquiryModalLabel_<?= $product->id; ?>">Quick Enquiry</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="enquiryForm_<?= $product->id; ?>" action="#" method="POST"/>
                                                <input type="hidden" name="product_id" value="<?= $product->id; ?>"/>
                                                <input type="hidden" name="product_name" value="<?= esc($product->product_name); ?>"/>
                                                <input type="hidden" name="product_price" value="<?= esc($product->offer_price); ?>" />
                                                <input type="hidden" name="description" value="<?= esc($product->description); ?>" />
                                                <div class="form-group">
                                                    <label for="Name">Enter Name</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Enter Email</label>
                                                    <input type="email" class="form-control" id="phone_number_<?= $product->id; ?>" name="customer_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Enter Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product->id; ?>" name="phone_number" required>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="sendWhatsAppMessage(<?= $product->id; ?>)">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- //Dynamic Modal for Each Product  --> 
                              <?php endforeach; ?>
                          <?php else : ?>
                              <p class="text-center">No Celebs Look available.</p>
                          <?php endif; ?>
                      </div>
          </div>
        </div>
      </div>
                              <!-- Celebs Look End -->

      <div class="ps-site-features">
        <div class="container">
          <div class="ps-block--features">
            <div class="row ps-col-tiny">
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
                <div class="ps-block--feature">
                  <div class="ps-block__left"><img src="<?= base_url('public/frontend/img/handmade.png');?>"></div>
                  <div class="ps-block__right">
                    <p style="padding: 24px; font-size:1.8rem; font-style: italic;">Hand-Made</p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
                <div class="ps-block--feature">
                  <div class="ps-block__left"><img src="<?= base_url('public/frontend/img/art.png');?>"></div>
                  <div class="ps-block__right">
                    <p style="padding: 12px; font-size:1.8rem; font-style: italic;">Supporting-Artisans</p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
                <div class="ps-block--feature">
                  <div class="ps-block__left"><img src="<?= base_url('public/frontend/img/sustain.png');?>"></div>
                  <div class="ps-block__right">
                    <p style="padding: 24px; font-size:1.8rem; font-style: italic;">Sustainable</p>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
                <div class="ps-block--feature">
                  <div class="ps-block__left"><img src="<?= base_url('public/frontend/img/review.png');?>"></div>
                  <div class="ps-block__right">
                    <p style="padding: 24px; font-size:1.8rem; font-style: italic;">Customer Satisfaction</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="ps-section testim" id="testim" style="background-color: antiquewhite;">
        <div class="container">
          <script src="https://widget.trustmary.com/rsczhCiwA"></script>

        </div>
      </div>
  
  <div class="ps-home-collection">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12  ">
          <h3>Pawar Handloom Instagram</h3>
          <div class="ps-block--collection"><blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/official_pawarhandloom/" data-instgrm-version="12" style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:undefinedpx;height:undefinedpx;max-height:100%; width:undefinedpx;">            <div style="padding:16px;">               <a id="main_link" href="official_pawarhandloom" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">                  <div style=" display: flex; flex-direction: row; align-items: center;">                     <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>                     <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">                        <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>                        <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>                     </div>                  </div>                  <div style="padding: 19% 0;"></div>                  <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">                     <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">                           <g transform="translate(-511.000000, -20.000000)" fill="#000000">                              <g>                                 <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>                              </g>                           </g>                        </g>                     </svg>                  </div>                  <div style="padding-top: 8px;">                     <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div>                  </div>                  <div style="padding: 12.5% 0;"></div>                  <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">                     <div>                        <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>                        <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>                        <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>                     </div>                     <div style="margin-left: 8px;">                        <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>                        <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>                     </div>                     <div style="margin-left: auto;">                        <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>                        <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>                        <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>                     </div>                  </div>                  <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">                     <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>                     <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>                  </div>               </a>               <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="official_pawarhandloom" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">Shared post</a> on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;">Time</time></p>            </div>         </blockquote>         <script src="https://www.instagram.com/embed.js"></script><script type="text/javascript" src="#"></script>                  <style>.boxes3{height:175px;width:153px;} #n img{max-height:none!important;max-width:none!important;background:none!important} #inst i{max-height:none!important;max-width:none!important;background:none!important}</style></div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12  ">
              <h3><a href="https://www.youtube.com/@pawar_handloom">Pawar Handloom <img src="<?= base_url('public/frontend/img/y.png');?>"> Youtube Channel</a></h3>
              <div class="ps-block--collection"><iframe width="80%" height="580" src="https://www.youtube.com/embed/D0UnqGm_miA?si=jopD_aR7tSyoGG4N" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
        </div>
      </div>
    </div>
  </div>

  <div class="ps-contact" style="background-color: antiquewhite;">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
          <form class="ps-form--contact" action="#" method="post">
            <h3>Drop us a line</h3>
            <div class="form-group">
              <label>Your name (required)</label>
              <input class="form-control" type="text" placeholder="Your Name">
            </div>
            <div class="form-group">
              <label>Your Email (required)</label>
              <input class="form-control" type="text" placeholder="">
            </div>
            <div class="form-group">
              <label>Subject</label>
              <input class="form-control" type="text" placeholder="">
            </div>
            <div class="form-group">
              <label>Your Message</label>
              <textarea class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group submit">
              <button class="ps-btn ps-btn--fullwidth ps-btn--black ps-btn--outline">Send</button>
            </div>
          </form>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3681.6422356717367!2d75.8263688!3d22.6671239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fdd9f5dc3c01%3A0x50740ede54c4e5cf!2sPAWAR%20HANDLOOM%20(Maheshwari%20%26%20Chanderi%20Saree%20Mfrs.%20%26%20Wholesaler)!5e0!3m2!1sen!2sin!4v1735201591655!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </div>

  <div class="ps-site-features">
    <div class="container">
      <div class="ps-section__header" style="text-align: center; margin-top: 20px;">
        <h3>Our Reviews</h3><hr>
      </div>
      <div class="ps-block--features">
        <div class="row ps-col-tiny">
          <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
            <div class="ps-block--feature">
              <div class="ps-block__right">
                <a href="#"><img src="<?= base_url('public/frontend/img/google.jpg');?>"></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
            <div class="ps-block--feature">
              <div class="ps-block__right">
                <a href="#"><img src="<?= base_url('public/frontend/img/fb.png');?>"></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
            <div class="ps-block--feature">
              <div class="ps-block__right">
                <a href="#"><img src="<?= base_url('public/frontend/img/jd.png');?>"></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 ">
            <div class="ps-block--feature">
              <div class="ps-block__right">
                <a href="#"><img src="<?= base_url('public/frontend/img/logo.jpg');?>"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
     
    </div>