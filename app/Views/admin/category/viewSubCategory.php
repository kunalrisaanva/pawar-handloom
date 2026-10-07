
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- Get Notification  -->
                <?php
                if (session()->getFlashdata('status')) {
                   echo'<div class="alert alert-success alert-dismissible">
                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <h5><i class="icon fas fa-check"></i> </h5>'
                   .session()->getFlashdata("status").'</div>';
                 
                }
                // if (session()->getFlashdata('status_delete')) {
                //     echo'<div class="alert alert-danger alert-dismissible">
                //     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                //     <h5><i class="icon fas fa-check"></i> </h5>'
                //     .session()->getFlashdata("status_delete").'</div>';
                  
                //  }
            ?>

              <a href="<?= base_url('admin/addSubCategory'); ?>" title="Add New Category" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Sub Category</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($subcategoryList)){
                  $count = 1;
                  foreach($subcategoryList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    
                    <td><?= ucwords($value->tbl_category_category_name); ?></td>
                    <td><?= ucwords($value->name); ?></td>
                    <td>
                    
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_SUBCAT; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Sub Category" 
                    href="<?= base_url().'admin/EditSubCate/'.base64_encode(urlencode($value->id)).'/'.base64_encode(urlencode(TBL_SUBCAT)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Sub Category" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_SUBCAT)); ?>"
                    data-deletecategory="Yes" >
                    <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a>
                  </td>
                  </tr>
                  <?php endforeach;
                    }else{ ?>
                      <tr> <td colspan="6"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Category</th>
                    <th>Sub Category</th>
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
  
