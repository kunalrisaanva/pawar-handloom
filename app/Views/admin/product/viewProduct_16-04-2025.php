
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <!-- Success and error Message  -->

                <?php
                if (session()->getFlashdata('status')) {
                   echo'<div class="alert alert-success alert-dismissible">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <h5><i class="icon fas fa-check"></i> </h5>'
                   .session()->getFlashdata("status").'</div>';
                 
                }
                if (session()->getFlashdata('status_delete')) {
                    echo'<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> </h5>'
                    .session()->getFlashdata("status_delete").'</div>';
                  
                 }
            ?>

                <!-- Get Notification  -->

              <a href="<?= base_url('admin/AddProduct'); ?>" title="Add New Product" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Product</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Coupan Name</th>
                    <th>Coupan Type</th>
                    <th>Coupan Start Date</th>
                    <th>Coupan End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($couponList)){
                  $count = 1;
                  foreach($couponList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= ucwords($value->name); ?></td>
                    <td>

                      <?= $value->coupon_type; ?></td>
                    <td><?= $value->start_date; ?></td>
                    <td><?= $value->end_date; ?></td>
                    <td>
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_COUPON; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Coupon" 
                    href="<?= base_url().'admin/EditSlider/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Coupon" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_COUPON)) ?>"
                    data-deletecategory="Yes">
                     <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a></td>
                  </tr>
                  <?php endforeach;
                    }else{ ?>
                      <tr> <td colspan="5"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>
                                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Coupan Name</th>
                    <th>Coupan Type</th>
                    <th>Coupan Start Date</th>
                    <th>Coupan End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
