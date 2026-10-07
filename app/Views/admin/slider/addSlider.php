
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Slider !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url( !empty($getSliderData->id) ? 'admin/UpdateSlider' : 'admin/addSlider' ); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getSliderData))?base64_encode(urlencode($getSliderData->id)):''; ?>"/>
                   

                  <div class="form-group">
                    <label for="slider_title"><span class="text-danger">*</span>Slider Title</label>
                    <input type="text" class="form-control" id="slider_title" name="slider_title"  value="<?= (isset($getSliderData))?$getSliderData->slider_title:''; ?>" placeholder="Enter Category Name">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'slider_title'):''; ?>
                    </span> 
                  </div>                  
                  <div class="form-group">
                    <label for="slider_description"><span class="text-danger">*</span>Slider Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="slider_description" id="slider_description"><?= (isset($getSliderData))?$getSliderData->slider_description:''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'slider_description'):''; ?>
                    </span> 
                  </div>  
                  <div class="form-group">
                  <label for="web_link"><span class="text-danger">*</span>Slider Button Link</label>
                  <textarea class="form-control" rows="2" wrap="off" placeholder="Enter You web Link Here..." name="web_link" id="web_link"><?= (isset($getSliderData))?$getSliderData->web_link:''; ?></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'web_link'):''; ?>
                    </span> 
                  </div>                
                  <div class="form-group">
                    <label for="slider_image">Web SLider Image</label>
                    <input type="file" class="form-control" id="slider_image" name="slider_image" value="<?= (isset($getSliderData))?$getSliderData->slider_image:''; ?>" placeholder="Enter Slider Name">
                  </div>
                  <?php
                    if (!empty($getSliderData->slider_image)) { ?>
                        <img src="<?= base_url('public/uploads/admin/slider_image').'/'. $getSliderData->slider_image; ?>" alt="Slider Image" width="200px" height="200px" />
                   <?php }                      
                  ?>
                    <div class="form-group">
                    <label for="slider_image">Mobile SLider Image</label>
                    <input type="file" class="form-control" id="mobile_slider_image" name="mobile_slider_image" value="<?= (isset($getSliderData))?$getSliderData->mobile_slider_image:''; ?>" placeholder="Enter Slider Name">
                  </div>
                  <?php
                    if (!empty($getSliderData->mobile_slider_image)) { ?>
                        <img src="<?= base_url('public/uploads/admin/slider_image').'/'. $getSliderData->mobile_slider_image; ?>" alt="Slider Image" width="200px" height="200px" />
                   <?php }                      
                  ?>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addSlider" id="<?= (isset($getSliderData)) ?'UpdateSlider':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getSliderData)) ?'Update':'Save Your Slider' ?> </button>
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

