
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Catlog !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/addCatlogImage'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCategoryData))?base64_encode(urlencode($getCategoryData->id)):''; ?>"/>
                   
                    <div class="form-group">
                        <label for="category_name"><span class="text-danger">* </span>Catlog Category</label>
                        <select class="form-control" name="category_name" id="category_name">
                            <option value=""> --Please Select Category-- </option>
                            <?php 
                                foreach($categoryList as $cat): 
                                  $selected = (isset($getCategoryData) && $getCategoryData->cat_id == $cat->id) ? 'selected' : '';
                                ?>
                                <option value="<?= $cat->id; ?>" <?= $selected; ?>> <?= $cat->catlog_category_name; ?> </option>
                            <?php    endforeach;
                            ?>
                        </select>
                        <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'category_name'):''; ?>
                        </span>   
                    </div>             
                    <div class="form-group">
                        <label for="gallery_image">Catlog Images</label>
                        <input type="file" class="form-control" id="gallery_image" name="gallery_image[]" value="<?= (isset($getCategoryData))?$getCategoryData->image:''; ?>" placeholder="Enter Category Name" multiple>
                    </div>
                    <span class="text-danger text-sm">
                            <?= isset($validation) ? display_form_errors($validation, 'gallery_image') : ''; ?>
                        </span>
                        <?php
                            if (!empty($getCategoryData->image)) { ?>
                                <img src="<?= base_url('uploads/admin/catlog').'/'. $getCategoryData->image; ?>" alt="Catlog Image" width="200px" height="200px" />
                        <?php }                      
                        ?> 

                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addCatlogImages" id="<?= (isset($getCategoryData)) ?'UpdateCatlogCategory':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCategoryData)) ?'Update Category':'Save Your Images' ?> </button>
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

