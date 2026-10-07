    <div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/shop.jpg'); ?>">
      <div class="container">
        <h1>Shop</h1>
      </div>
    </div>
    <div class="ps-shopping ps-shopping--sidebar">
      <div class="container">
        <!-- Sort product according to price low and high -->
        <div class="ps-filter--shopping">
            <a class="ps-filter__trigger" href="#"><i class="fa fa-sliders"></i></a>
            <div class="form-group--select">
                <i class="fa fa-angle-down"></i>
                <div class="form-group__content">
                <select class="form-control" id="sortPrice">
                    <option value="">Sort Products</option>
                    <option value="high_to_low">Sort by Price High to Low</option>
                    <option value="low_to_high">Sort by Price Low to High</option>
                </select>
                </div>
            </div>
        </div>
        <!-- //SOrt product according to price low and high -->
        <div class="row">
          <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <div class="ps-filter active">
              <div class="ps-filter__header">
                <div class="ps-filter__trigger">
                  <p>Show Filters</p><i class="fa fa-angle-down"></i>
                </div>
              </div>
              <div class="ps-filter__content">
              <aside class="widget widget_shop">
                  <ul class="ps-list">
                      <?php if (!empty($subcategories)): ?>
                          <form method="GET" action="<?= base_url('shop/' . $categoryId); ?>">
                              <?php foreach ($subcategories as $subcategory): ?>
                                  <h4 class="widget-title"><?= $subcategory->name; ?></h4>
                                  <?php if (!empty($subcategory->subsubcategories)): ?>
                                      <?php foreach ($subcategory->subsubcategories as $subsub): ?>
                                          <input type="checkbox" 
                                                name="subsubcat[]" 
                                                value="<?= $subsub->id; ?>" 
                                                <?= (isset($_GET['subsubcat']) && in_array($subsub->id, $_GET['subsubcat'])) ? 'checked' : ''; ?>
                                          > <?= $subsub->name; ?><br>
                                      <?php endforeach; ?>
                                  <?php else: ?>
                                      <p>No sub-subcategories available.</p>
                                  <?php endif; ?>
                                  <hr>
                              <?php endforeach; ?>
                              <button type="submit">Apply Filter</button>
                          </form>
                      <?php else: ?>
                          <p>No subcategories available.</p>
                      <?php endif; ?>
                  </ul>
              </aside>


                <aside class="widget widget_filter widget_shop">
                  <h3 class="widget-title">Filter by price</h3>
                  <p class="ps-slider__meta">Price:<span class="ps-slider__value ps-slider__min">INR 0</span>-<span class="ps-slider__value ps-slider__max">INR 5000</span></p>
                  <div class="ps-slider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-default-min="0" data-default-max="8000" data-max="10000" data-step="100" data-unit="INR"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 50%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 50%;"></span></div>
                </aside>
                <aside class="widget widget_shop widget_size">
                  <h3 class="widget-title">Size</h3>
                  <div class="ps-checkbox ps-checkbox--size">
                    <input class="form-control" type="checkbox" id="size-1" name="size">
                    <label for="size-1">All</label>
                  </div>
                  <div class="ps-checkbox ps-checkbox--size">
                    <input class="form-control" type="checkbox" id="size-2" name="size">
                    <label for="size-2">XSS</label>
                  </div>
                  <div class="ps-checkbox ps-checkbox--size">
                    <input class="form-control" type="checkbox" id="size-3" name="size">
                    <label for="size-3">XS</label>
                  </div>
                  <div class="ps-checkbox ps-checkbox--size">
                    <input class="form-control" type="checkbox" id="size-4" name="size">
                    <label for="size-4">S</label>
                  </div>
                  <div class="ps-checkbox ps-checkbox--size">
                    <input class="form-control" type="checkbox" id="size-5" name="size">
                    <label for="size-5">L</label>
                  </div>
                </aside>
              </div>
            </div>
          </div>
          
          <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <div class="ps-shopping__content">
              <div class="row product-container">
              <?php if (!empty($productList)): ?>
              <?php foreach($productList as $product): ?>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 ">
                  <div class="ps-product">
                    <div class="ps-product__thumbnail">
                        <a class="ps-product__overlay" href="<?= base_url('/detail/'.$product->id); ?>"></a><a class="ps-product__img" href="<?= base_url('/detail/'.$product->id); ?>"><img src="<?= base_url('public/frontend/img/product/25-1.jpg');?>" alt=""></a><a class="ps-product__img-alt" href="<?= base_url('/detail/'.$product->id); ?>"><img src="<?= base_url('public/frontend/img/product/25-1.jpg');?>" alt=""></a>                     
                    </div>
                    <div class="ps-product__content">
                      <div class="ps-product__meta"><a href="<?= base_url('/detail/'.$product->id); ?>"></a></div><a class="ps-product__title" href="<?= base_url('/detail/'.$product->id); ?>"><?= $product->product_name; ?></a>
                      <p class="ps-product__price"> <span style="text-decoration: line-through;">INR <?= $product->actual_price; ?></span> INR <?= $product->offer_price; ?></p>
                      <!--<a href="#" class="ps-btn ps-btn--outline ps-btn--white"><i class="fa fa-whatsapp"></i> Quick Enquiry</a>-->
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
                <?php endforeach; ?>

                <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-danger font-weight-bold">No records found for the selected filters.</p>
                </div>
                <?php endif; ?>
                
              
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    