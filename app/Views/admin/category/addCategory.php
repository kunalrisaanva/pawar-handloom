
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Categories !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/addCategory'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCategoryData))?base64_encode(urlencode($getCategoryData->id)):''; ?>"/>
                   
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
                      </div>  -->
                <div class="form-group">
                    <label for="category_name"><span class="text-danger">*</span>Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name"  value="<?= (isset($getCategoryData))?$getCategoryData->category_name:''; ?>" placeholder="Enter Category Name">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'category_name'):''; ?>
                    </span> 
                  </div>                  
                  <div class="form-group">
                    <label for="cat_description"><span class="text-danger">*</span>Category Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="cat_description" id="cat_description"><?= (isset($getCategoryData))?$getCategoryData->category_description:''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'cat_description'):''; ?>
                    </span> 
                  </div>                  
                  <div class="form-group">
                    <label for="cat_image">Category Cover Image</label>
                    <input type="file" class="form-control" id="cat_image" name="cat_image" value="<?= (isset($getCategoryData))?$getCategoryData->category_image:''; ?>" placeholder="Enter Category Name">
                  </div>
                  <?php
                    if (!empty($getCategoryData->category_image)) { ?>
                        <img src="<?= base_url('public/uploads/admin/category_image').'/'. $getCategoryData->category_image; ?>" alt="Category Image" width="200px" height="200px" />
                   <?php }                      
                  ?>

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addCategory" id="<?= (isset($getCategoryData)) ?'UpdateCategory':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCategoryData)) ?'Update Category':'Save Your Category' ?> </button>
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

