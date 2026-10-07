
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
              <a href="<?= base_url('admin/addGalleryCategory'); ?>" title="Add New Category" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Category</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <!-- <th>Language</th> -->
                    <th>Gallery Category</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($categoryList)){
                  $count = 1;
                  foreach($categoryList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <!--<td> < ?php 
                          $language = get_language_by_id($value->language_id);
                          
                          if (!empty($language)) {
                            echo $language[0]->name;
                          }else{
                            echo"No language found";
                          }
                    ?> </td> -->
                    <td><?= ucwords($value->category_name); ?></td>
                    <td>
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_GALLERYCAT; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Category" 
                    href="<?= base_url().'admin/EditGalleryCategory/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Category" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_GALLERYCAT)) ?>"
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
                    <!-- <th>Language</th> -->
                    <th>Gallery Category</th>
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
  
  