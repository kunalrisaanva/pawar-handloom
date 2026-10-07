
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Colour !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url( !empty($getColourData->id) ? '#' : 'admin/AddColours' ); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getColourData))?base64_encode(urlencode($getColourData->id)):''; ?>"/>
                   

                  <div class="form-group">
                    <label for="colour_name"><span class="text-danger">*</span>Colour Name</label>
                    <input type="text" class="form-control" id="colour_name" name="colour_name"  value="<?= (isset($getColourData))?$getColourData->colour_name:''; ?>" placeholder="Enter Colour Name">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'colour_name'):''; ?>
                    </span> 
                  </div>           
                    <div class="form-group">
                        <label for="colour_code"><span class="text-danger">*</span>Colour Code</label>
                    
                        <div style="display:flex; align-items:center; gap:10px;">
                            <!-- Color Picker -->
                            <input type="color" id="colour_picker" value="<?= (isset($getColourData))?$getColourData->colour_code:'#000000'; ?>" 
                                   style="width:50px; height:40px; padding:0; border:none;">
                    
                            <!-- Text Input for Code -->
                            <input type="text" class="form-control" id="colour_code" name="colour_code"  
                                   value="<?= (isset($getColourData))?$getColourData->colour_code.'|'.$getColourData->colour_rgb:''; ?>" 
                                   placeholder="Enter Colour Code">
                        </div>
                    
                        <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'colour_code'):''; ?>
                        </span>
                    </div>

                  <!--<div class="form-group">-->
                  <!--  <label for="colour_code"><span class="text-danger">*</span>Colour Code</label>-->
                  <!--  <input type="text" class="form-control" id="colour_code" name="colour_code"  value="< ?= (isset($getSliderData))?$getSliderData->colour_code:''; ?>" placeholder="Enter Colour Code">-->
                    
                  <!--  <span class="text-danger text-sm">-->
                  <!--          < ?= isset($validation)? display_form_errors($validation,'colour_code'):''; ?>-->
                  <!--  </span> -->
                  <!--</div>  -->
                                 
                  
                    
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addColour" id="<?= (isset($getColourData)) ?'UpdateColour':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getColourData)) ?'Update':'Save Your Colour' ?> </button>
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

