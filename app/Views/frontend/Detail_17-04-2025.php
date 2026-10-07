
<div class="ps-hero bg--cover" data-background="<?= base_url('/public/frontend/img/hero/shop.jpg'); ?>"> 
      <div class="container">
        <h1>Product Details</h1>
      </div>
    </div>
    <div class="ps-shopping" style="margin-top: 50px;">
    <div class="container" style="max-width: 1200px;">
      <div class="ps-product--detail">
        <div class="ps-product__header">
          <div class="ps-product__thumbnail" data-vertical="true">
            <figure>
              <div class="ps-wrapper">
                <div class="ps-product__gallery" data-arrow="false">
                    <?php 
                        $productImage = get_product_image($product[0]->id);
                        //echo"27-03-2025 <pre>";
                        //print_r($productImage);
                        foreach ($productImage as $key ) : ?>
                        <div class="block">
                            <div class="item block__title">
                                <img src="<?= base_url('public/'). $key->image; ?>" alt="" class="block__pic">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
              </div>
            </figure>
            <div class="ps-product__variants" data-item="4" data-md="3" data-sm="3" data-arrow="false">
                <?php foreach ($productImage as $key ) : ?>
                    <div class="item"><img src="<?= base_url('public/'). $key->image; ?>" alt=""></div>
                <?php endforeach; ?>
            </div>
          </div>
          <div class="ps-product__info">
            <h1><?= $product[0]->product_name; ?> </h1>
            <h4 class="ps-product__price">INR <?= $product[0]->offer_price; ?> / Per Piece</h4>
            <div class="ps-product__desc">
              <p><?= $product[0]->short_description; ?></p>
            </div>
            <div class="ps-product__shopping">
                <!-- <form method="post" action="#">
                    <input type="hidden" name="id" value="< ?= $product[0]->id; ?>">
                    <input type="hidden" name="product_name" value="< ?= $product[0]->product_name; ?>">
                    <input type="hidden" name="product_price" value="< ?= $product[0]->offer_price; ?>"> -->

                    <div class="form-group--number">
                    
                    <input class="form-control text-center" type="text" id="quantityInput" name="qty" value="200" required>
                    
                    </div>

                    <br><br>
                    <?php 
                      $session = session();
                      if (!$session->has('is_logged_in')) : ?>
                      <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product[0]->id; ?>">
                        <i class="fa fa-whatsapp"></i> Quick Enquiry
                      </button>
                      <?php else : ?>
                    <button type="button" class="ps-btn ps-btn--outline ps-btn--white add-to-cart" 
                                                data-id="<?= $product[0]->id; ?>" 
                                                data-product_name="<?= trim($product[0]->product_name); ?>" 
                                                data-offer_price="<?= $product[0]->offer_price; ?>" 
                                                data-image="<?= $product[0]->cover_image; ?>">
                                                Add To Cart
                    </button>
                    <?php endif; ?>  
                <!-- </form> -->
            </div>
<!-- Dynamic Modal for Each Product -->
<div class="modal fade" id="quickEnquiryModal_<?= $product[0]->id; ?>" tabindex="-1" role="dialog" aria-labelledby="quickEnquiryModalLabel_<?= $product[0]->id; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="quickEnquiryModalLabel_<?= $product[0]->id; ?>">Quick Enquiry</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="enquiryForm_<?= $product[0]->id; ?>" action="#" method="POST"/>
                                                <input type="hidden" name="product_id" value="<?= $product[0]->id; ?>"/>
                                                <input type="hidden" name="product_name" value="<?= esc($product[0]->product_name); ?>"/>
                                                <input type="hidden" name="product_price" value="<?= esc($product[0]->offer_price); ?>" />
                                                <input type="hidden" name="description" value="<?= esc($product[0]->description); ?>" />
                                                <div class="form-group">
                                                    <label for="Name">Enter Name</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product[0]->id; ?>" name="customer_name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Enter Email</label>
                                                    <input type="email" class="form-control" id="phone_number_<?= $product[0]->id; ?>" name="customer_email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Enter Phone Number</label>
                                                    <input type="text" class="form-control" id="phone_number_<?= $product[0]->id; ?>" name="phone_number" required>
                                                </div>
                                                <button type="button" class="btn btn-primary" onclick="sendWhatsAppMessage(<?= $product[0]->id; ?>)">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- //Dynamic Modal for Each Product  --> 
            <div class="ps-product__specification">
              <p><strong>Product Type :</strong><?= $product[0]->product_type ;?></p><hr>
              <p><strong>Material:</strong><?= $product[0]->material ;?></p><hr>
              <p><strong>Fabric Type  :</strong><?= $product[0]->fabric_type ;?></p><hr>
              <p><strong>Pattern:</strong><?= $product[0]->pattern ;?></p><hr>
              <p><strong>Season :</strong><?= $product[0]->season ;?></p><hr>
              <p><strong>Occasion:</strong><?= $product[0]->occasion ;?></p><hr>
              <p><strong>Delivery Type :</strong><?= $product[0]->delivery_type ;?></p><hr>
              <p><strong>Return:</strong><?= $product[0]->return_day ;?></p><hr>
            </div>
          </div>
        </div>
        <div class="ps-product__content ps-tab-root">
          <ul class="ps-tab-list">
            <li class="active"><a href="#tab-1">Description</a></li>
            <li><a href="#tab-2">Addition Information</a></li>
          </ul>
          <div class="ps-tabs">
            <div class="ps-tab active" role="tabpanel" id="tab-1">
              <p><?= $product[0]->description ;?></p>
            </div>
            <div class="ps-tab" id="tab-2">
              <div class="table-responsive">
                <table class="table ps-table">
                  <tbody>
                    <tr>
                      <td><strong>Material</strong></td>
                      <td><?= $product[0]->material ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Season</strong></td>
                      <td><?= $product[0]->season ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Fabric Type</strong></td>
                      <td><?= $product[0]->fabric_type ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Occasion</strong></td>
                      <td><?= $product[0]->occasion ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Product Type</strong></td>
                      <td><?= $product[0]->product_type ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Pattern</strong></td>
                      <td><?= $product[0]->pattern ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Payment Terms</strong></td>
                      <td> <?= $product[0]->payment_terms ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Supply Ability</strong></td>
                      <td><?= $product[0]->supply_ability ;?> Piece Per Week</td>
                    </tr>
                    <tr>
                      <td><strong>Delivery Time </strong></td>
                      <td><?= $product[0]->delivery_time ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Supply Ability </strong></td>
                      <td><?= $product[0]->supply_ability ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Main Domestic Market  </strong></td>
                      <td><?= $product[0]->main_domestic_market ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Other Feature  </strong></td>
                      <td><?= !empty($product[0]->other_feature) ? $product[0]->other_feature : 'No more information'; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <!--<div class="ps-shopping ps-shopping--sidebar">-->
    <!--  <div class="container">-->
       
    <!--    <div class="ps-section__header" style="text-align: center;">-->
    <!--      <h3>Related Product</h3><hr>-->
    <!--    </div>-->
    <!--    <div class="row">-->
          
    <!--      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">-->
    <!--        <div class="ps-shopping__content">-->
    <!--          <div class="row">-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/25-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/25-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="< ?= base_url('/detail'); ?>"></a></div><a class="ps-product__title" href="< ?= base_url('/detail'); ?>">Stole Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/17-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/17-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Stole Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/18-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/18-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Stole Name</a>-->
    <!--                 <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><span class="ps-product__badge disabled"><i>Sold Out</i></span><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/19-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/19-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Stole Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/20-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/20-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Dupatta Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/frontend/img/product/21-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/21-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Dupatta Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><a class="ps-product__img" href="#"><img src="< ?= base_url('/public/frontend/img/product/22-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/22-1.jpg');?>" alt=""></a>-->
                      
                      
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Dupatta Name</a>-->
    <!--                 <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">-->
    <!--              <div class="ps-product">-->
    <!--                <div class="ps-product__thumbnail"><a class="ps-product__overlay" href="#"></a><span class="ps-product__badge disabled"><i>Sold Out</i></span><a class="ps-product__img" href="#"><img src="< ?= base_url('/frontend/img/product/23-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="#"><img src="< ?= base_url('/frontend/img/product/23-1.jpg');?>" alt=""></a>-->
    <!--                  <ul class="ps-product__actions">-->
    <!--                    <li><a href="#"><i class="fa fa-whatsapp"></i> Quick Enquiry</a></li>-->
    <!--                  </ul>-->
    <!--                </div>-->
    <!--                <div class="ps-product__content">-->
    <!--                  <div class="ps-product__meta"><a href="details.html"></a></div><a class="ps-product__title" href="details.html">Dupatta Name</a>-->
    <!--                  <p class="ps-product__price"> INR 850.00</p>-->
    <!--                  <a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
    <!--                </div>-->
    <!--              </div>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
   
   

