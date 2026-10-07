
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
                        //echo"30-05-2025 <pre>";
                        //print_r($productImage);
                        foreach ($productImage as $key ) : ?>
                        <div class="block">
                            <div class="item block__title">
                                <img src="<?= base_url('public/'). $key->image; ?>" alt="Product Image" class="block__pic">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
              </div>
            </figure>
            <div class="ps-product__variants" data-item="4" data-md="3" data-sm="3" data-arrow="false">
                <?php foreach ($productImage as $key ) : ?>
                    <div class="item"><img src="<?= base_url('public/'). $key->image; ?>" alt="Product Image"></div>
                <?php endforeach; ?>
            </div>
          </div>
          <div class="ps-product__info">
            <h1><?= $product[0]->product_name; ?> </h1>
            <?php $session = session();
             if ($session->has('is_logged_in')): ?>
             <h4 class="ps-product__price"> <span style="text-decoration: line-through;">INR <?= $product[0]->actual_price; ?></span> INR <?= $product[0]->offer_price; ?> / Per Piece</h4>
              <!--<h4 class="ps-product__price">INR < ?= $product[0]->offer_price; ?> / Per Piece</h4>-->
            <?php endif; ?>
            <div class="ps-product__desc">
              <p><?= $product[0]->short_description; ?></p>
            </div>
            <div class="ps-product__shopping">
                <!-- <form method="post" action="#">
                    <input type="hidden" name="id" value="< ?= $product[0]->id; ?>">
                    <input type="hidden" name="product_name" value="< ?= $product[0]->product_name; ?>">
                    <input type="hidden" name="product_price" value="< ?= $product[0]->offer_price; ?>"> -->

                    <?php 
$session = session();
$totalQty = getProductTotalQuntity($product[0]->id);
$soldQty = manageProductSellQuntity($product[0]->id);

$total = $totalQty->product_quantity ?? 0;
$sold = $soldQty->qty ?? 0;

$isSoldOut = ($sold >= $total && $total > 0);
?>

<?php if (!$isSoldOut): ?>
    <div class="form-group--number">
        <input class="form-control text-center" type="text" id="quantityInput" name="qty" value="200" required>
    </div>
    <br><br>
<?php endif; ?>

<?php if ($isSoldOut): ?>
    <button type="button" class="ps-btn ps-btn--outline ps-btn--white" disabled style="background: #ccc; cursor: not-allowed;">
        <i class="fa fa-ban"></i> Sold Out
    </button>
<?php elseif (!$session->has('is_logged_in')): ?>
    <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product[0]->id; ?>">
        <i class="fa fa-whatsapp"></i> Quick Enquiry
    </button>
<?php else: ?>
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
                                                <input type="hidden" name="product_reference" value="<?= $product[0]->product_reference; ?>"/>
                                                <input type="hidden" name="product_image" value="<?= $product[0]->cover_image; ?>"/>
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
              <!-- <p><strong>Product Type :</strong>< ?= $product[0]->product_type ;?></p><hr>
              <p><strong>Material:</strong>< ?= $product[0]->material ;?></p><hr> -->
              <p><strong>Fabric Type  :</strong><?= !empty($product[0]->fabric_type)?$product[0]->fabric_type:'NA' ;?></p><hr>
              <p><strong>Dimensions  :</strong><?= !empty($product[0]->dimensions)?$product[0]->dimensions:'NA' ;?></p><hr>
              <?php if (!empty($product[0]->blouse_dimensions)) : ?>
                    <p><strong>Blouse Dimensions :</strong> <?= $product[0]->blouse_dimensions; ?></p>
              <?php endif; ?>
              <!--<p><strong>Blouse Dimensions  :</strong>< ?= !empty($product[0]->blouse_dimensions)?$product[0]->blouse_dimensions:'NA' ;?></p><hr>-->
              <!-- <p><strong>Pattern:</strong>< ?= $product[0]->pattern ;?></p><hr>
              <p><strong>Season :</strong>< ?= $product[0]->season ;?></p><hr>
              <p><strong>Occasion:</strong>< ?= $product[0]->occasion ;?></p><hr> -->
              <p><strong>Delivery Time :</strong><?= !empty($product[0]->delivery_time)?$product[0]->delivery_time:'NA' ;?></p><hr>
              <p><strong>Wash Care :</strong><?= !empty($product[0]->wash_care)?$product[0]->wash_care:'NA' ;?></p><hr>
              <!-- <p><strong>Return:</strong>< ?= $product[0]->return_day ;?></p><hr> -->
            </div>
          </div>
        </div>
        <div class="ps-product__content ps-tab-root">
          <ul class="ps-tab-list">
            <li class="active"><a href="#tab-1">Description</a></li>
            <li><a href="#tab-2">Addition Information</a></li>
            <li><a href="#tab-3">Write a Review</a></li>
            <li><a href="#tab-4">Customer Review</a></li>
          </ul>
          <div class="ps-tabs">
            <div class="ps-tab active" role="tabpanel" id="tab-1">
              <p><?= $product[0]->description ;?></p>
            </div>
            <div class="ps-tab" id="tab-2">
              <div class="table-responsive">
                <table class="table ps-table">
                  <tbody>
                    <!-- <tr>
                      <td><strong>Material</strong></td>
                      <td>< ?= $product[0]->material ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Season</strong></td>
                      <td>< ?= $product[0]->season ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Fabric Type</strong></td>
                      <td>< ?= $product[0]->fabric_type ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Occasion</strong></td>
                      <td>< ?= $product[0]->occasion ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Product Type</strong></td>
                      <td>< ?= $product[0]->product_type ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Pattern</strong></td>
                      <td>< ?= $product[0]->pattern ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Payment Terms</strong></td>
                      <td> < ?= $product[0]->payment_terms ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Supply Ability</strong></td>
                      <td>< ?= $product[0]->supply_ability ;?> Piece Per Week</td>
                    </tr>
                    <tr>
                      <td><strong>Delivery Time </strong></td>
                      <td>< ?= $product[0]->delivery_time ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Supply Ability </strong></td>
                      <td>< ?= $product[0]->supply_ability ;?></td>
                    </tr>
                    <tr>
                      <td><strong>Main Domestic Market  </strong></td>
                      <td>< ?= $product[0]->main_domestic_market ;?></td>
                    </tr> -->
                    <tr>
                      <td><strong>Other Feature  </strong></td>
                      <td><?= !empty($product[0]->other_feature) ? $product[0]->other_feature : 'No more information'; ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Tab-2 end -->
            <!-- Tab-3 -->
            <div class="ps-tab active" role="tabpanel" id="tab-3">
              <div class="ps-product--detail" style="margin-top: 2rem;">
        <div class="container" style="  display: flex;
  justify-content: center;">    
        <div class="wrapper">
          
            <h3>Write a review</h3>
            <form action="#">
              <span>Rating</span>
              <div class="rating">
                
                <input type="number" name="rating" hidden>
                <i class='bx bx-star star' style="--i: 0;"></i>
                <i class='bx bx-star star' style="--i: 1;"></i>
                <i class='bx bx-star star' style="--i: 2;"></i>
                <i class='bx bx-star star' style="--i: 3;"></i>
                <i class='bx bx-star star' style="--i: 4;"></i>
              </div>
              <input type="text" name="title" class="texts" placeholder="Review Title">
              <textarea name="opinion" cols="30" rows="5" placeholder="Review Content..."></textarea>

              <div class="main-wrapper">
        <div class="upload-main-wrapper">
                <div class="upload-wrapper">
                        <input type="file" id="upload-file">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" viewBox="224.3881704980842 176.8527621722847 221.13266283524905 178.8472378277154" width="221.13" height="178.85"><defs><path d="M357.38 176.85C386.18 176.85 409.53 204.24 409.53 238.02C409.53 239.29 409.5 240.56 409.42 241.81C430.23 246.95 445.52 264.16 445.52 284.59C445.52 284.59 445.52 284.59 445.52 284.59C445.52 309.08 423.56 328.94 396.47 328.94C384.17 328.94 285.74 328.94 273.44 328.94C246.35 328.94 224.39 309.08 224.39 284.59C224.39 284.59 224.39 284.59 224.39 284.59C224.39 263.24 241.08 245.41 263.31 241.2C265.3 218.05 281.96 199.98 302.22 199.98C306.67 199.98 310.94 200.85 314.93 202.46C324.4 186.96 339.88 176.85 357.38 176.85Z" id="b1aO7LLtdW"></path><path d="M306.46 297.6L339.79 297.6L373.13 297.6L339.79 255.94L306.46 297.6Z" id="c4SXvvMdYD"></path><path d="M350.79 293.05L328.79 293.05L328.79 355.7L350.79 355.7L350.79 293.05Z" id="b11si2zUk"></path></defs><g><g><g><use xlink:href="#b1aO7LLtdW" opacity="1" fill="#ffffff" fill-opacity="1"></use></g><g><g><use xlink:href="#c4SXvvMdYD" opacity="1" fill="#363535" fill-opacity="1"></use></g><g><use xlink:href="#b11si2zUk" opacity="1" fill="#363535" fill-opacity="1"></use></g></g></g></g></svg>
                        <span class="file-upload-text">Upload File</span>
                        <div class="file-success-text">
                         <svg version="1.1" id="check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 100 100"  xml:space="preserve">
                <circle style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-miterlimit:10;" cx="49.799" cy="49.746" r="44.757"/>
                <polyline style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="
                    27.114,51 41.402,65.288 72.485,34.205 "/>
                </svg>
              </div>
              </div>
                    <p id="file-upload-name"></p>
        </div>
    </div>

              <!-- <input type="file" name="review_image" class="texts"> -->
              <input type="text" name="youtube" class="texts" placeholder="Youtube URL">
              <input type="text" name="display_name" class="texts" placeholder="Display name (displayed publicly like John Smith..)">
              <input type="text" name="email" class="texts" placeholder="Email Address">
              <div class="btn-group">
                <button type="submit" class="btn submit">Submit</button>
              </div>
            </form>
          </div>
          </div>
      </div>
            </div>
            <!-- //Tab-3 -->
            <!-- Tab 4 -->
            <div class="ps-tab active" role="tabpanel" id="tab-4">
              <p>Customer Review soon...</p>
            </div>
            <!-- //Tab-4  -->
          </div>
        </div>
      </div>
    </div>
    </div>

    <!-- related product section start -->
<div class="ps-shopping ps-shopping--sidebar">
  <div class="container">
    <div class="ps-section__header" style="text-align: center;">
      <h3>Related Products</h3>
      <hr>
    </div>
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="ps-shopping__content">
          <div class="row">
            <?php if (!empty($relatedProduct)): ?>
              <?php foreach ($relatedProduct as $product): ?>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                  <div class="ps-product">
                    <div class="ps-product__thumbnail">
                      <a class="ps-product__overlay" href="<?= base_url('detail/' . $product->id); ?>"></a>
                      <a class="ps-product__img" href="<?= base_url('detail/' . $product->id); ?>">
                        <img src="<?= base_url('public/' . $product->cover_image); ?>" alt="<?= esc($product->product_name); ?>">
                      </a>
                      <a class="ps-product__img-alt" href="<?= base_url('detail/' . $product->id); ?>">
                        <img src="<?= base_url('public/' . $product->cover_image); ?>" alt="<?= esc($product->product_name); ?>">
                      </a>
                    </div>
                    <div class="ps-product__content">
                      <a class="ps-product__title" href="<?= base_url('detail/' . $product->id); ?>">
                        <?= esc($product->product_name); ?>
                      </a>
                      <?php $session = session();
                         if ($session->has('is_logged_in')): ?>
                          <p class="ps-product__price"> <span style="text-decoration: line-through;">INR <?= $product->actual_price; ?></span> INR <?= $product->offer_price; ?></p>
                          <!-- <p class="ps-product__price">INR < ?= number_format($product->offer_price, 2); ?></p> -->
                        <?php endif; ?>
                      <!--<p class="ps-product__price">INR <?= number_format($product->offer_price, 2); ?></p>-->
                      <?php if (!$session->has('is_logged_in')): ?>
                          <button type="button" class="ps-btn ps-btn--outline ps-btn--white" data-toggle="modal" data-target="#quickEnquiryModal_<?= $product->id; ?>">
                              <i class="fa fa-whatsapp"></i> Quick Enquiry
                          </button>
                      <?php else: ?>
                          <button type="button" class="ps-btn ps-btn--outline ps-btn--white add-to-cart" 
                              data-id="<?= $product->id; ?>" 
                              data-product_name="<?= trim($product->product_name); ?>" 
                              data-offer_price="<?= $product->offer_price; ?>" 
                              data-image="<?= $product->cover_image; ?>">
                              Add To Cart
                          </button>
                      <?php endif; ?>
                      <!-- <button type="button" class="ps-btn ps-btn--outline ps-btn--white"
                        data-toggle="modal"
                        data-target="#relatedEnquiryModal_< ?= $product->id; ?>">
                        <i class="fa fa-whatsapp"></i> Quick Enquiry
                      </button> -->
                    </div>
                  </div>
                </div>

                <!-- Modal for Each Related Product -->
                <div class="modal fade" id="relatedEnquiryModal_<?= $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="relatedEnquiryModalLabel_<?= $product->id; ?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title" id="relatedEnquiryModalLabel_<?= $product->id; ?>">Quick Enquiry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <form action="#" method="POST">
                          <input type="hidden" name="product_id" value="<?= $product->id; ?>"/>
                          <input type="hidden" name="product_name" value="<?= esc($product->product_name); ?>"/>
                          <input type="hidden" name="product_price" value="<?= esc($product->offer_price); ?>"/>
                          <input type="hidden" name="description" value="<?= esc($product->description); ?>"/>

                          <div class="form-group">
                            <label>Enter Name</label>
                            <input type="text" class="form-control" name="customer_name" required>
                          </div>

                          <div class="form-group">
                            <label>Enter Email</label>
                            <input type="email" class="form-control" name="customer_email" required>
                          </div>

                          <div class="form-group">
                            <label>Enter Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" required>
                          </div>

                          <button type="submit" class="btn btn-primary">Submit Enquiry</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal -->

              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-center">No related products found.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


    
    
    <!-- // related product section end -->
   
   
    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
    <a href="https://api.whatsapp.com/send?phone=919630504663&text=Hi, How may I help you?" class="float" target="_blank">
      <i class="fa fa-whatsapp my-float"></i>
      </a>
      <a href="tel:+919630504663" class="float-call" target="_blank">
          <i class="fa fa-phone my-float"></i><span style="padding-left: 5px;"><b>Call Now</b></span>
          </a>
    <div class="ps-site-overlay"></div>
    <div id="loader-wrapper">
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
      <div class="ps-search__content">
        <form class="ps-form--primary-search" action="#" method="post">
          <input class="form-control" type="text" placeholder="Search for...">
          <button><i class="aroma-magnifying-glass"></i></button>
        </form>
      </div>
    </div>
    <div class="ps-cart--sidebar">
      <div class="ps-cart__header">
        <h3>Mini Cart</h3><a class="ps-btn--close ps-btn--no-boder" href="#"></a>
      </div>
      <div class="ps-cart__content">
        <div class="ps-product--cart">
          <div class="ps-product__thumbnail"><a href="#"><img src="img/product/best-5-1.jpg" alt=""></a><span class="ps-btn--close ps-btn--no-boder"></span></div>
          <div class="ps-product__content"><a href="#">Saree</a><span>1x INR 450.00</span></div>
        </div>
        <div class="ps-product--cart">
          <div class="ps-product__thumbnail"><a href="#"><img src="img/product/best-3-1.jpg" alt=""></a><span class="ps-btn--close ps-btn--no-boder"></span></div>
          <div class="ps-product__content"><a href="#">Dupatta </a><span>1x INR 450.00</span></div>
        </div>
      </div>
      <div class="ps-cart__footer">
        <h4>SubTotal: <span>INR 900.00</span></h4>
        <a class="ps-btn" href="cart.html">View Cart</a>
        <a class="ps-btn" href="checkout.html">Checkout Now</a>
      </div>
    </div>

    <script>
  const decreaseBtn = document.getElementById('decreaseBtn');
  const increaseBtn = document.getElementById('increaseBtn');
  const quantityInput = document.getElementById('quantityInput');

  decreaseBtn.addEventListener('click', () => {
    let value = parseInt(quantityInput.value);
    if (value > 1) quantityInput.value = value - 1;
  });

  increaseBtn.addEventListener('click', () => {
    let value = parseInt(quantityInput.value);
    quantityInput.value = value + 1;
  });
</script>