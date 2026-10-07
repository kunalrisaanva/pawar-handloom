
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Coupan & Offers Type !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?= base_url('admin/AddCoupanOfferType'); ?>" enctype="multipart/form-data">
                <div class="card-body">                   
                
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCategoryData))?base64_encode(urlencode($getCategoryData->id)):''; ?>"/>
                    <div class="form-group">
                        <label for="coupan_type"><span class="text-danger">*</span>Type</label>
                        <select class="form-control" name="coupan_type" id="coupan_type">
                            <option value=""> --Please Select Type-- </option>
                            <option value="1" >Coupan</option>
                            <option value="1" >Offer</option>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="coupan_name"><span class="text-danger">*</span>Name</label>
                    <input type="text" class="form-control" id="name" name="name"  placeholder="Enter Coupan Name">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'coupan_name'):''; ?>
                    </span> 
                  </div>                  
                  <div class="form-group">
                    <label for="coupan_description"><span class="text-danger">*</span>Coupan Description</label>
                    <textarea class="form-control" rows="5" wrap="off" placeholder="Enter Description Here..." name="coupan_description" id="coupan_description"></textarea>
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'coupan_description'):''; ?>
                    </span> 
                  </div>  
                  
                  <div class="form-group">
                    <label for="coupan_period"><span class="text-danger">*</span>Coupan Period</label>
                    <input type="checkbox" class="coupon_period_toggle" name="coupan_period" data-toggle="switch" id="coupan_period" data-bootstrap-switch data-off-color="danger" data-on-color="success" value="">
                  </div>
                  <!-- radio buttons -->
                  <div class="form-group clearfix" id="getPeriod">
                      <div class="icheck-success d-inline">
                        <input type="radio" name="period_time" id="period_time1" value="1">
                        <label for="period_time1">
                          According to Hours
                        </label>
                      </div>
                      <div class="icheck-success d-inline">
                        <input type="radio" name="period_time" id="period_time2" value="2">
                        <label for="period_time2">
                         According to Date
                        </label>
                      </div>
                    </div> 
                    <div class="form-group" id="hour_range">
                    <label for="period_time_hour">
                          Select for Hours
                        </label>
                      <input type="text" class="form-control" name="period_time_hour" id="period_time_hour" />
                    </div>

                    <!-- Date and time range -->
                <div class="form-group" id="date_and_time_range">
                  <label>Date and time range:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control float-right" name="period_time_date" id="reservationtime">
                  </div>
                </div>
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addCoupan" id="<?= (isset($getCategoryData)) ?'UpdateCoupan':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCategoryData)) ?'Update Coupan':'Save Your Coupan' ?> </button>
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

