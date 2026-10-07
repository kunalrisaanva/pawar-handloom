
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Sub subCategories !</h5>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!--<form method="post" action="< ?= base_url('admin/addsubSubCategory'); ?>" enctype="multipart/form-data">-->
                <form method="post" action="<?= isset($getSubCategoryData) 
                    ? base_url('admin/UpdateSubSubCat') 
                    : base_url('admin/addsubSubCategory'); ?>"
                enctype="multipart/form-data">    

                <div class="card-body">   
                
                <!--< ?php 
                    // echo"Get Sub Sub category Data:- <pre>";
                    // print_r($getSubCategoryData);
                    // die;
                ?>-->
                
                <input type="hidden" name="id" id="child_cat_id" value="<?= (isset($getSubCategoryData))?base64_encode(urlencode($getSubCategoryData->id)):''; ?>"/>
                <input type="hidden" name="get_category_id" id="get_category_id" value="<?php echo (isset($getSubCategoryData)) ? $getSubCategoryData->cat_id : ''; ?>" />      
                <input type="hidden" id="edit_sub_cat_id"
                   value="<?= isset($getSubCategoryData) ? $getSubCategoryData->sub_cat_id : '' ?>">
                    <!--<div class="form-group">
                        <label for="language_name"><span class="text-danger">* </span> Language</label>
                        <select class="form-control" name="language_name" id="language_name">
                            <option value=""> --Please Select Language-- </option>
                            < ?php foreach($languageList as $lang => $value):  ?>
                                <option value="< ?= $value->id; ?>" < ?= (isset($getCategoryData)) && ($getCategoryData->language_id === $value->id) ?'selected':'' ?> >< ?= $value->name; ?></option>
                           < ?php endforeach; ?>
                        </select>
                        <span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'language_name'):''; ?>
                        </span>   
                      </div> -->

                    <div class="form-group">
                        <label for="category_name"><span class="text-danger">* </span> Category</label>
                        <select class="form-control" name="category_name" id="category_name">
                            <option value=""> --Please Select Category-- </option>
                            <?php 
                                foreach($categoryList as $cat): 
                                  $selected = (isset($getSubCategoryData) && $getSubCategoryData->cat_id == $cat->id) ? 'selected' : '';
                                ?>
                                <option value="<?= $cat->id; ?>" <?= $selected; ?>> <?= $cat->category_name; ?> </option>
                            <?php    endforeach;
                            ?>
                        </select>
                        <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'category_name'):''; ?>
                        </span>   
                    </div>
                    <div class="form-group">
                        <label for="sub_category_name"><span class="text-danger">* </span>Sub Category</label>
                        <select class="form-control" name="sub_category_name" id="sub_category_name">
                            <option value="">-- Please Select Sub Category --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name"><span class="text-danger">* </span>Sub subCategory Name</label>
                        <input type="text" class="form-control" id="name" name="name"  value="<?= (isset($getSubCategoryData))?$getSubCategoryData->name:''; ?>" placeholder="Enter Category Name">
                        <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'name'):''; ?>
                        </span>        
                    </div>                  
                  <div class="form-group">
                    <label for="cat_description"><span class="text-danger">* </span>Category Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="cat_description" id="cat_description"><?= (isset($getSubCategoryData))?$getSubCategoryData->subsubCategory_description:''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'cat_description'):''; ?>
                    </span>               
                </div>                  
                  <div class="form-group">
                    <label for="cat_image">Category Cover Image</label>
                    <input type="file" class="form-control" id="cat_image" name="cat_image" value="<?= (isset($getSubCategoryData))?$getSubCategoryData->subsubCategory_image:''; ?>" placeholder="Enter Category Name">
                  </div>
                  <?php
                    if (!empty($getSubCategoryData->subsubCategory_image)) { ?>
                        <img src="<?= base_url('uploads/admin/category_image/subCategory').'/'. $getSubCategoryData->subsubCategory_image; ?>" alt="Category Image" width="200px" height="200px" />
                   <?php }                      
                  ?>

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addsubSubCat" id="<?= (isset($getSubCategoryData)) ?'UpdateSubsubCat':'' ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getSubCategoryData)) ?'Update Sub Category':'Save Your Sub Category' ?> </button>
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

