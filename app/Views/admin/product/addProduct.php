<!--Product Images css-->
<style>
    .product-image-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;          /* SPACE BETWEEN IMAGES */
    margin-top: 10px;
}

.product-image-box {
    position: relative;
    width: 110px;
}

.product-image-box img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 1px solid #ddd;
    padding: 5px;
    background: #fff;
    border-radius: 4px;
}

.product-image-box .deleteProductImage {
    position: absolute;
    top: -8px;
    right: -8px;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    padding: 0;
    line-height: 18px;
    font-size: 14px;
}

</style>


<!--//Product Images css-->
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
              <!-- <form method="post" action="< ?= base_url('admin/AddProduct'); ?>" enctype="multipart/form-data"> -->
              <form method="post" action="<?= base_url(isset($productData) ? 'admin/UpdateProduct' : 'admin/AddProduct'); ?>" enctype="multipart/form-data">

                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($productData))?base64_encode(urlencode($productData->id)):''; ?>"/>
                    <input type="hidden" name="product_reference" id="product_reference" value="<?= (isset($productData))?($productData->product_reference):''; ?>"/>

                  <div class="form-group">
                    <label for="product_name"><span class="text-danger">*</span>Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?= isset($productData) ? $productData->product_name : ''; ?>"  placeholder="Enter Product Name">
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
                              <option value="<?= $coupon->id; ?>"<?= isset($productData) && $productData->category == $coupon->id ? 'selected' : ''; ?>><?= $coupon->category_name; ?></option>
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
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Short Description Here..." name="short_description" id="short_description"><?= isset($productData) ? $productData->short_description : ''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'short_description'):''; ?>
                    </span> 
                  </div>
                  <!--<div class="form-group">-->
                  <!--  <label for="description"><span class="text-danger">*</span> Description</label>-->
                  <!--  <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="description" id="description">< ?= isset($productData) ? $productData->description : ''; ?></textarea>-->
                  <!--  <span class="text-danger text-sm">-->
                  <!--          < ?= isset($validation)? display_form_errors($validation,'description'):''; ?>-->
                  <!--  </span> -->
                  <!--</div>-->
                  <!-- <div class="form-group">
                    <label for="brand"><span class="text-danger">*</span>Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand"  placeholder="Enter Brand Name">
                    <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'brand'):''; ?>
                    </span> 
                  </div> -->
                  <div class="form-group">
                    <label for="product_qunatity"><span class="text-danger">*</span>Product Qunatity</label>
                    <input type="text" class="form-control" id="product_qunatity" name="product_qunatity" value="<?= isset($productData) ? $productData->product_qunatity : ''; ?>"  placeholder="Enter Product Qunatity">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'product_qunatity'):''; ?>
                    </span> 
                        <?php 
                          if(isset($productData) ){ ?>
                              <input type="checkbox" name="force_qty_update" value="1"> <span style="color:orange;">Re-insert Quantity Even If Same and a change if you want Update qunatity please check !</span>
                         <?php } ?>
                    

                  </div>
                  <!--Colour List-->
                  <?php 
                    $selectedColours = [];
                    if (isset($productData) && !empty($productData->colour)) {
                        $selectedColours = explode(',', $productData->colour);
                        
                        // echo"Check Color:- ";
                        // print_r($selectedColours);
                    }
                    ?>
                    
                    <div class="form-group">
                        <label for="colour_ids"><span class="text-danger">*</span>Select Colour</label>
                    
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" name="colour_ids[]" id="colour_ids">
                            <?php foreach ($colourList as $colour): ?>
                                <option value="<?= $colour->id; ?>"
                                    <?= in_array($colour->id, $selectedColours) ? 'selected' : ''; ?>>
                                    <?= $colour->colour_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                  <!--//Colour List-->
                  <div class="form-group">
                    <label for="actual_price"><span class="text-danger">*</span>Actual Price For Retailers</label>
                    <input type="text" class="form-control" id="actual_price" name="actual_price" value="<?= isset($productData) ? $productData->actual_price : ''; ?>"  placeholder="Enter Product Actual Price">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'actual_price'):''; ?>
                    </span> 
                  </div>
                  <!--Price for Customer -->
                  <div class="form-group">
                    <label for="actual_price"><span class="text-danger">*</span>Actual Price For Customer</label>
                    <input type="text" class="form-control" id="actual_price_customer" name="actual_price_customer" value="<?= isset($productData) ? $productData->actual_price_customer : ''; ?>"  placeholder="Enter Product Actual Price">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'actual_price_customer'):''; ?>
                    </span> 
                  </div>
                  <!--//Price for Customer-->
                  <div class="form-group">
                    <label for="offer_price"><span class="text-danger">*</span>Offer Price In Percentage</label>
                    <input type="text" class="form-control" id="offer_price" name="offer_price" value="<?= isset($productData) ? $productData->offer_price : ''; ?>" placeholder="Enter Product Offer Price">
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
                    <input type="text" class="form-control" id="fabric_type" name="fabric_type" value="<?= isset($productData) ? $productData->fabric_type : ''; ?>"  placeholder="Enter Product fabric type">
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
                    <input type="text" class="form-control" id="dimensions" name="dimensions" value="<?= isset($productData) ? $productData->dimensions : ''; ?>"  placeholder="Enter Product Dimensions">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'dimensions'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="blouse_dimensions"><span class="text-danger">*</span>Blouse Dimensions</label>
                    <input type="text" class="form-control" id="blouse_dimensions" name="blouse_dimensions" value="<?= isset($productData) ? $productData->blouse_dimensions : ''; ?>"  placeholder="Enter Product Blouse Dimensions">
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
                    <input type="text" class="form-control" id="delivery_time" name="delivery_time" value="<?= isset($productData) ? $productData->delivery_time : ''; ?>"  placeholder="Enter Product Delivery Time">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'delivery_time'):''; ?>
                    </span> 
                  </div>
                  <div class="form-group">
                    <label for="wash_care"><span class="text-danger">*</span>Wash Care</label>
                    <input type="text" class="form-control" id="wash_care" name="wash_care" value="<?= isset($productData) ? $productData->wash_care : ''; ?>"  placeholder="Enter Product Wash Care">
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
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Other Feature..." name="other_feature" id="other_feature"><?= isset($productData) ? $productData->other_feature : ''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'other_feature'):''; ?>
                    </span> 
                  </div>

                    <div class="form-group">
                        <label for="cover_image"><span class="text-danger">*</span> Cover Image</label>
                        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                         <!-- Show existing cover image -->
                        <?php if (!empty($productData->cover_image)) : ?>
                            <div class="mt-2">
                                <img src="<?= base_url('public/' . $productData->cover_image); ?>" 
                                     alt="Cover Image"
                                     style="width:120px; height:auto; border:1px solid #ddd; padding:5px;">
                            </div>
                        <?php endif; ?>
                        <span class="text-danger text-sm">
                            <?= isset($validation) ? display_form_errors($validation, 'cover_image') : ''; ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="product_images"><span class="text-danger">*</span> Product Images</label>
                        <input type="file" class="form-control" id="product_images" name="product_images[]" accept="image/*" multiple>
                        <!-- Show existing images -->
                        
                            <!--< ?php if (!empty($productImages)) : ?>-->
                            <!--    <div class="mt-2">-->
                            <!--        <strong>Existing Images:</strong>-->
                        
                            <!--        <div class="d-flex flex-wrap gap-2 mt-2">-->
                            <!--            < ?php foreach ($productImages as $img) : ?>-->
                            <!--                <div style="position:relative;">-->
                            <!--                    <img src="< ?= base_url('public/' . $img->image); ?>"-->
                            <!--                         style="width:100px; height:100px; object-fit:cover; border:1px solid #ddd; padding:5px;">-->
                                                     <!-- Delete button -->
                            <!--                <button type="button"-->
                            <!--                        class="btn btn-danger btn-sm deleteProductImage"-->
                            <!--                        data-id="< ?= $img->id; ?>"-->
                            <!--                        style="position:absolute; top:-6px; right:-6px; border-radius:50%;">-->
                            <!--                    ×-->
                            <!--                </button>-->
                            <!--                </div>-->
                            <!--            < ?php endforeach; ?>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--< ?php endif; ?>-->
                            <?php if (!empty($productImages)) : ?>
                                <div class="mt-2">
                                    <strong>Existing Images:</strong>
                            
                                    <div class="product-image-wrapper">
                                        <?php foreach ($productImages as $img) : ?>
                                            <div class="product-image-box" id="imgBox<?= $img->id; ?>">
                                                
                                                <img src="<?= base_url('public/' . $img->image); ?>" alt="Product Image">
                                                
                                                <!--Edit Button-->
                                                
                                                <button type="button"
                                                        class="btn btn-primary btn-sm editProductImage"
                                                        data-id="<?= $img->id; ?>"
                                                        style="position:absolute; bottom:-6px; left:-6px;">
                                                    ✎
                                                </button>
                                                <!--Delete Button-->
                            
                                                <button type="button"
                                                        class="btn btn-danger btn-sm deleteProductImage"
                                                        data-id="<?= $img->id; ?>">
                                                    ×
                                                </button>
                                                
                                                <!-- Hidden file input -->
                                    <input type="file"
                                           class="d-none replaceImageInput"
                                           data-id="<?= $img->id; ?>"
                                           accept="image/*">
                                                
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                        <span class="text-danger text-sm">
                            <?= isset($validation) ? display_form_errors($validation, 'product_images') : ''; ?>
                        </span>
                    </div>


                  
                
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="<?= (isset($productData)) ?'updateProduct':'addProduct' ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($productData)) ?'Update Product':'Save Your Product' ?> </button>
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

<!-- Script for when edit form and getting category sub category and also child category -->
<script>
    const selectedCategory = "<?= isset($productData->category) ? $productData->category : '' ?>";
    const selectedSubCategory = "<?= isset($productData->subcategory) ? $productData->subcategory : '' ?>";
    const selectedSubSubCategory = "<?= isset($productData->sub_subCategory) ? $productData->sub_subCategory : '' ?>";
</script>