
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
              <a href="<?= base_url('admin/addCatlogImage'); ?>" title="Add New Catelog Images" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Image</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Catlogery Category</th>
                    <th> Image </th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($categoryList)){
                  $count = 1;
                  foreach($categoryList as $x =>$value): 
                  $categoryName = get_catlog_category($value->cat_id);
                  ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= ucwords($categoryName[0]->catlog_category_name); ?></td>
                    <!-- <td>< ?= ucwords($categoryName[0]->description);?> </td> -->
                    <td> 
                        <img src="<?= base_url('public/uploads/admin/catlog/'. $value->image) ; ?>" style="width: 150px; height: 150px; border: 1px solid; border-radius: 22px;" alt="Catlog Image"/>    
                     </td>
                    <td>
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_CATLOG; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <!--<a title="Edit Image" 
                    href="< ?= base_url().'admin/EditGalleryCategory/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> ||  -->
                    <a title="Delete Image" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_CATLOG)) ?>"
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
                    <th>Catlog Category</th>
                    <th> Image </th>
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
  
  