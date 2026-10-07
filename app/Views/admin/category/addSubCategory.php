
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Sub Categories !</h5>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/addSubCategory'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                <input type="hidden" name="id" id="sub_cat_id" value="<?= (isset($getCategoryData))?base64_encode(urlencode($getCategoryData->id)):''; ?>"/>
                <input type="hidden" name="get_category_id" id="get_category_id" value="<?php echo (isset($getCategoryData)) ? $getCategoryData->cat_id : ''; ?>" />                    
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
                                  $selected = (isset($getCategoryData) && $getCategoryData->cat_id == $cat->id) ? 'selected' : '';
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
                        <label for="name"><span class="text-danger">* </span>Sub Category Name</label>
                        <input type="text" class="form-control" id="name" name="name"  value="<?= (isset($getCategoryData))?$getCategoryData->name:''; ?>" placeholder="Enter Category Name">
                        <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'name'):''; ?>
                        </span>        
                    </div>                  
                  <div class="form-group">
                    <label for="cat_description"><span class="text-danger">* </span>Category Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="cat_description" id="cat_description"><?= (isset($getCategoryData))?$getCategoryData->subCategory_description:''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'cat_description'):''; ?>
                    </span>               
                </div>                  
                  <div class="form-group">
                    <label for="cat_image">Category Cover Image</label>
                    <input type="file" class="form-control" id="cat_image" name="cat_image" value="<?= (isset($getCategoryData))?$getCategoryData->subCategory_image:''; ?>" placeholder="Enter Category Name">
                  </div>
                  <?php
                    if (!empty($getCategoryData->subCategory_image)) { ?>
                        <img src="<?= base_url('public/uploads/admin/category_image/subCategory').'/'. $getCategoryData->subCategory_image; ?>" alt="Category Image" width="200px" height="200px" />
                   <?php }                      
                  ?>

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addSubCat" id="<?= (isset($getCategoryData)) ?'UpdateSub':'' ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCategoryData)) ?'Update Sub Category':'Save Your Sub Category' ?> </button>
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

