
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Catlog Categories !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/addCatlogCategory'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCatlogCategoryData))?base64_encode(urlencode($getCatlogCategoryData->id)):''; ?>"/>
                   
                    <div class="form-group">
                        <label for="category_name"><span class="text-danger">*</span>Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name"  value="<?= (isset($getCatlogCategoryData))?$getCatlogCategoryData->catlog_category_name    :''; ?>" placeholder="Enter Catlog Category Name">
                        <span class="text-danger text-sm">
                                <?= isset($validation)? display_form_errors($validation,'category_name'):''; ?>
                        </span> 
                    </div>                  
                    <div class="form-group">
                        <label for="cat_description"><span class="text-danger">*</span>Category Description</label>
                        <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="cat_description" id="cat_description"><?= (isset($getCatlogCategoryData))?$getCatlogCategoryData->description:''; ?></textarea>
                        <span class="text-danger text-sm">
                                <?= isset($validation)? display_form_errors($validation,'cat_description'):''; ?>
                        </span> 
                    </div> 
                    <div class="form-group">
                        <label for="price"><span class="text-danger">*</span>price</label>
                        <input type="text" class="form-control" id="price" name="price"  value="<?= (isset($getCatlogCategoryData))?$getCatlogCategoryData->price    :''; ?>" placeholder="Enter Catlog Price">
                        <!--<span class="text-danger text-sm">-->
                        <!--        < ?= isset($validation)? display_form_errors($validation,'price'):''; ?>-->
                        <!--</span> -->
                    </div>  
                    <!--<div class="form-group">
                        <label for="cat_image">Category Cover Image</label>
                        <input type="file" class="form-control" id="cat_image" name="cat_image" value="< ?= (isset($getCategoryData))?$getCategoryData->category_image:''; ?>" placeholder="Enter Category Name">
                    </div>
                        < ?php
                            if (!empty($getCategoryData->category_image)) { ?>
                                <img src="< ?= base_url('uploads/admin/category_image').'/'. $getCategoryData->category_image; ?>" alt="Category Image" width="200px" height="200px" />
                        < ?php }                      
                        ?> -->

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addCatlogCategory" id="<?= (isset($getCatlogCategoryData)) ?'UpdateCatlogCategory':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCatlogCategoryData)) ?'Update Catlog Category':'Save Your Catlog Category' ?> </button>
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

