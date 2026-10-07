
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon far fa-circle text-warning"></i> Please add your Coupon !</h5>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!--<form method="post" action="< ?= base_url('admin/AddCoupan'); ?>" enctype="multipart/form-data">-->
                  
                <form method="post" action="<?= isset($getCouponData) ? base_url('admin/UpdateCoupon') : base_url('admin/AddCoupan'); ?>" enctype="multipart/form-data">
                    
                    <!--< ?php -->
                    <!--    echo"Check Coupan Details:- <pre>";-->
                    <!--    print_r($getCouponData);-->
                    <!--?>-->
                          
                <div class="card-body">                   
                
                    
                    <input type="hidden" name="id" id="Edit_id" value="<?= (isset($getCouponData))?base64_encode(urlencode($getCouponData->id)):''; ?>" data="<?= (isset($getCouponData))?($getCouponData->id):''; ?>"/>

                  <div class="form-group">
                    <label for="coupan_name"><span class="text-danger">*</span>Coupon Name</label>
                    <input type="text" class="form-control" id="coupan_name" name="coupan_name"  placeholder="Enter Coupan Name" value="<?= isset($getCouponData) ? $getCouponData->name : '' ?>">
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'coupan_name'):''; ?>
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
                  <label for="coupan_description"><span class="text-danger">*</span>Coupon Type</label>
                  <select class="form-control" name="coupan_type" id="coupan_type">
                            <option value=""> --Please Select Coupon Type-- </option>
                            <?php foreach ($couponTypeList as $coupon): ?>
                              <option value="<?= $coupon->id; ?>"
                             <?= (isset($getCouponData) && $getCouponData->coupon_type == $coupon->id) ? 'selected' : '' ?> 
                              ><?= $coupon->name; ?></option>
                            <?php  endforeach; ?>
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="coupan_name"><span class="text-danger">*</span>Coupon Value</label>
                    <input type="text" class="form-control" id="coupan_value" name="coupan_value"  placeholder="Enter Coupan Value" 
                        value="<?= isset($getCouponData) ? $getCouponData->coupan_value : '' ?>"
                    >
                    <span class="text-danger text-sm">
                            <?= isset($validation)? display_form_errors($validation,'coupan_value'):''; ?>
                    </span> 
                  </div>   
                  <!--<div class="form-group">
                    <label for="coupan_period"><span class="text-danger">*</span>Coupan Period</label>
                    <input type="checkbox" class="coupon_period_toggle" name="coupan_period" data-toggle="switch" id="coupan_period" data-bootstrap-switch data-off-color="danger" data-on-color="success" value="">
                  </div> -->
                  <!-- radio buttons -->
                  <!--<div class="form-group clearfix" id="getPeriod">
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
                    </div>-->

                    <!-- Date and time range -->
                <div class="form-group" id="date_and_time_range">
                  <label>Coupon Start Date :</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="date" class="form-control float-right" name="start_date" id="start_date" value="<?= isset($getCouponData) ? $getCouponData->start_date : '' ?>">
                  </div>
                </div>

                <div class="form-group" id="date_and_time_range">
                  <label>Coupon End Date :</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="date" class="form-control float-right" name="end_date" id="end_date"
                        value="<?= isset($getCouponData) ? $getCouponData->end_date : '' ?>"
                    >
                  </div>
                </div>
                <!--Minimum Order Amount-->
                <!--<div class="form-group">
                    <label>Minimum Order Amount</label>
                    <input type="number" class="form-control" name="minimum_amount" placeholder="Enter Minimum Order Amount">-->
                    <!--<span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'minimum_amount'):''; ?>
                    </span> -->
                <!--</div>-->
                <!--//Minimum Order Amount-->
                <!--User Usages Limit-->
                <!--<div class="form-group">
                    <label>User Usage Limit</label>
                    <input type="number" class="form-control" name="user_limit" placeholder="How many times a user can use">-->
                    <!--<span class="text-danger text-sm">
                            < ?= isset($validation)? display_form_errors($validation,'user_limit'):''; ?>
                    </span> -->
                <!--</div>-->
                <!--//User Usages Limit-->
                
                  
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="addCoupan" id="<?= (isset($getCouponData)) ?'UpdateCoupan':'' ?>"  class="btn btn-success"><i class="fa fa-plus"></i> <?= (isset($getCouponData)) ?'Update Coupon':'Save Your Coupon' ?> </button>
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

