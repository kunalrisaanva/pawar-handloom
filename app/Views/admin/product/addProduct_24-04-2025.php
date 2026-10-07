
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Product !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/AddProduct'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCategoryData))?base64_encode(urlencode($getCategoryData->id)):''; ?>"/>

                  <div class="form-group">
                    <label for="product_name"><span class="text-danger">*</span>Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name"  placeholder="Enter Product Name">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'product_name'):''; ?>
                    </span> 
                  </div>                  
                  <!--<div class="form-group">
                    <label for="coupan_description"><span class="text-danger">*</span>Coupan Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="coupan_description" id="coupan_description"></textarea>
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'coupan_description'):''; ?>
                    </span> 
                  </div>  -->
                  <div class="form-group">
                  <label for="coupan_description"><span class="text-danger">*</span>Select Category</label>
                  <select class="form-control" name="category" id="category_name">
                            <option value=""> --Please Select Category-- </option>
                            <?php foreach ($couponTypeList as $coupon): ?>
                              <option value="<?= $coupon->id; ?>"><?= $coupon->category_name; ?></option>
                            <?php  endforeach; ?>
                        </select>
                  </div>
                  <div class="form-group">
                  <label for="coupan_description"><span class="text-danger">*</span>Select Sub Category</label>
                        <select class="form-control" name="subcategory" id="sub_category_name">
                            <option value=""> --Please Select Sub Category-- </option>
                        </select>
                  </div>
                  <div class="form-group">
                  <label for="coupan_description"><span class="text-danger">*</span>Select Sub sub Category</label>
                        <select class="form-control" name="sub_subCategory" id="sub_subCategory">
                            <option value=""> --Please Select Sub Sub Category-- </option>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="short_description"><span class="text-danger">*</span>Short Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Short Description Here..." name="short_description" id="short_description"></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'short_description'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="description"><span class="text-danger">*</span> Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="description" id="description"></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'description'):''; ?>
                    </span> 
                  </div>
                  <!-- <div class="form-group">
                    <label for="brand"><span class="text-danger">*</span>Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand"  placeholder="Enter Brand Name">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'brand'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="product_qunatity"><span class="text-danger">*</span>Product Qunatity</label>
                    <input type="text" class="form-control" id="product_qunatity" name="product_qunatity"  placeholder="Enter Product Qunatity">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'product_qunatity'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="actual_price"><span class="text-danger">*</span>Actual Price</label>
                    <input type="text" class="form-control" id="actual_price" name="actual_price"  placeholder="Enter Product Actual Price">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'actual_price'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="offer_price"><span class="text-danger">*</span>Offer Price</label>
                    <input type="text" class="form-control" id="offer_price" name="offer_price"  placeholder="Enter Product Offer Price">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'offer_price'):''; ?>
                    </span> 
                  </div>
                  <!--<div class="form-group">
                    <label for="size"><span class="text-danger">*</span>Product Size</label>
                    <input type="text" class="form-control" id="size" name="size"  placeholder="Enter Product Size">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'size'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="material"><span class="text-danger">*</span>Material</label>
                    <input type="text" class="form-control" id="material" name="material"  placeholder="Enter Product Material">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'material'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="fabric_type"><span class="text-danger">*</span>Fabric Type</label>
                    <input type="text" class="form-control" id="fabric_type" name="fabric_type"  placeholder="Enter Product fabric type">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'fabric_type'):''; ?>
                    </span> 
                  </div>
                  <!-- <div class="form-group">
                    <label for="item_weight"><span class="text-danger">*</span>Item Weight</label>
                    <input type="text" class="form-control" id="item_weight" name="item_weight"  placeholder="Enter Product Weight">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'item_weight'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="pattern"><span class="text-danger">*</span>Pattern</label>
                    <input type="text" class="form-control" id="pattern" name="pattern"  placeholder="Enter Product Pattern">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'pattern'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="dimensions"><span class="text-danger">*</span>Saree Dimensions</label>
                    <input type="text" class="form-control" id="dimensions" name="dimensions"  placeholder="Enter Product Dimensions">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'dimensions'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="blouse_dimensions"><span class="text-danger">*</span>Blouse Dimensions</label>
                    <input type="text" class="form-control" id="blouse_dimensions" name="blouse_dimensions"  placeholder="Enter Product Blouse Dimensions">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'blouse_dimensions'):''; ?>
                    </span> 
                  </div>
                  <!-- <div class="form-group">
                    <label for="colour"><span class="text-danger">*</span>Colour</label>
                    <input type="text" class="form-control" id="colour" name="colour"  placeholder="Enter Product Colour">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'colour'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="warranty"><span class="text-danger">*</span>Warranty</label>
                    <input type="text" class="form-control" id="warranty" name="warranty"  placeholder="Enter Product Qunatity">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'warranty'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="occasion"><span class="text-danger">*</span>Occasion</label>
                    <input type="text" class="form-control" id="occasion" name="occasion"  placeholder="Enter Product Qunatity">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'occasion'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="season"><span class="text-danger">*</span>Season</label>
                    <input type="text" class="form-control" id="season" name="season"  placeholder="Enter Product Qunatity">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'season'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="product_type"><span class="text-danger">*</span>Product Type</label>
                    <input type="text" class="form-control" id="product_type" name="product_type"  placeholder="Enter Product Type">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'product_type'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="payment_terms"><span class="text-danger">*</span>Payment Terms</label>
                    <input type="text" class="form-control" id="payment_terms" name="payment_terms"  placeholder="Enter Payment Terms">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'payment_terms'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="supply_ability"><span class="text-danger">*</span>Supply Ability</label>
                    <input type="text" class="form-control" id="supply_ability" name="supply_ability"  placeholder="Enter Supply Ability">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'supply_ability'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="delivery_time"><span class="text-danger">*</span>Delivery Time</label>
                    <input type="text" class="form-control" id="delivery_time" name="delivery_time"  placeholder="Enter Product Delivery Time">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'delivery_time'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="wash_care"><span class="text-danger">*</span>Wash Care</label>
                    <input type="text" class="form-control" id="wash_care" name="wash_care"  placeholder="Enter Product Wash Care">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'wash_care'):''; ?>
                    </span> 
                  </div>
                  <!-- <div class="form-group">
                    <label for="main_domestic_market"><span class="text-danger">*</span>Main Domestic Market</label>
                    <input type="text" class="form-control" id="main_domestic_market" name="main_domestic_market"  placeholder="Enter Main Domestic Market">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'main_domestic_market'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="other_feature"><span class="text-danger">*</span>Other Feature</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Other Feature..." name="other_feature" id="other_feature"></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'other_feature'):''; ?>
                    </span> 
                  </div>

                    <div class="form-group">
                        <label for="cover_image"><span class="text-danger">*</span> Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                        <span class="text-danger text-sm">
                            <?= isset($validation) ? display_form_errors($validation, 'cover_image') : ''; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="product_images"><span class="text-danger">*</span> Product Images</label>
                        <input type="file" class="form-control" id="product_images" name="product_images[]" accept="image/*" multiple>
                        <span class="text-danger text-sm">
                            <?= isset($validation) ? display_form_errors($validation, 'product_images') : ''; ?>
                        </span>
                    </div>


                  
                
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addProduct" id="<?= (isset($getCategoryData)) ?'UpdateCoupan':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCategoryData)) ?'Update Product':'Save Your Product' ?> </button>
                </div>
              </form>
            </div>
            <!-- /.card -->            

          </div>
          <!--/.col (left) -->
          <!-- right column -->

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

