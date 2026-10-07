
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
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
              <a href="<?= base_url('admin/addSlider'); ?>" title="Add New Slider" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Slider</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Web Link</th>
                    <th>Image</th>
                    <th>Mobile Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($sliderList)){
                  $count = 1;
                  foreach($sliderList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= ucwords($value->slider_title); ?></td>
                    <td><?= $value->slider_description; ?></td>
                    <td><?= $value->web_link; ?></td>
                    <td>
                        <img src="<?= base_url('public/uploads/admin/slider_image/'); ?><?= $value->slider_image; ?>" alt="Slider Image" width="100px" height="100px"/>
                    </td>
                    <td>
                        <img src="<?= base_url('public/uploads/admin/slider_image/'); ?><?= $value->mobile_slider_image; ?>" alt="Mobile Slider Image" width="100px" height="100px"/>
                    </td>
                    <td>
                    <!-- <button type="button" data="< ?php echo $value->id ?>" class="status_checks btn < ?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                    < ?php echo ($value->status == 0) ? "Deactivate" : "Activate"; ?>
                    </button> -->
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_SLIDER; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Category" 
                    href="<?= base_url().'admin/EditSlider/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Slider" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_SLIDER)) ?>"
                    data-deletecategory="Yes">
                     <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a></td>
                  </tr>
                  <?php endforeach;
                    }else{ ?>
                      <tr> <td colspan="4"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>                
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Sr. No.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Web Link</th>
                    <th>Image</th>
                    <th>Mobile Image</th>
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
  
  