
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <!-- < ?php
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
            ?> -->
              <!-- <a href="< ?= base_url('admin/addCategory'); ?>" title="Add New Category" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Category</button>
                  </a> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    
                    <th>Name</th>
                    
                    <th>Email</th>
                    <th>Rating </th>
                    <th>Rating Type</th>
                    <th>Content</th>
                    <th>Status</th>
                    
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($reviewList)){
                  $count = 1;
                  foreach($reviewList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    
                    
                    <td><?= ucwords($value->name); ?></td>
                    
                    <td><?= $value->email; ?></td>
                    <td><?= $value->rating; ?></td>
                    <td><?= ($value->review_type == 2)?'Shop':'Product'; ?></td>
                    <td><?= $value->review_text; ?></td>
                    
                    
                    <td>
                       <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_REVIEW; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>   
                    </td>
                    <td> <!--<a title="Edit Category" 
                    href="< ?= base_url().'admin/EditCategory/'.base64_encode(urlencode($value->order_id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a>-->
                    <button type="button" title="View REVIEW Details" class="btn" data-toggle="modal" data-target="#modal-Getinfo_<?= $value->id; ?>">
                          <i style="color: darkorange;" class="fas fa-eye" aria-hidden="true"></i>
                    </button> ||
                    
                    <a title="Delete Category" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_REVIEW)) ?>"
                    data-deletecategory="Yes">
                     <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i>
                    </a>
                    </td>
                  </tr>
                  <!-- ✅ Modal for Review Details -->
<div class="modal fade" id="modal-Getinfo_<?= $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $value->id; ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalLabel<?= $value->id; ?>">Review Details</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p><strong>Name:</strong> <?= ucwords($value->name); ?></p>
        <p><strong>Email:</strong> <?= $value->email; ?></p>
        <p><strong>Rating:</strong> <?= $value->rating; ?> ⭐</p>
        <p><strong>Type:</strong> <?= ($value->review_type == 2)?'Shop':'Product'; ?></p>
        <p><strong>Title:</strong> <?= $value->review_title; ?></p>
        <p><strong>Review:</strong><br><?= nl2br($value->review_text); ?></p>
        
        <?php if (!empty($value->YouTube_url)): ?>
          <p><strong>YouTube:</strong> <a href="<?= $value->YouTube_url; ?>" target="_blank"><?= $value->YouTube_url; ?></a></p>
        <?php endif; ?>

        <!-- Show Review Images -->
            <?php 
               $getImages = getReviewImage($value->id); 
            //   echo"Check Images:- <pre>";
            //   print_r($getImages);
               if (!empty($getImages)): ?>
                <div>
                  <strong>Images:</strong><br>
                  <?php foreach ($getImages as $img): ?>
                    <img src="<?= base_url('public/uploads/review_images/'.$img->review_image); ?>" 
                         alt="Review Image" 
                         style="max-width: 100px; margin: 5px; border:1px solid #ddd; border-radius:5px;">
                  <?php endforeach; ?>
                </div>
            <?php endif; ?>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
<!-- ✅ End Modal -->
                    
                  <?php endforeach;
                    }else{ ?>
                      <tr> <td colspan="4"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>                
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    
                    <th>Name</th>
                    
                    <th>Email</th>
                    <th>Rating </th>
                    <th>Rating Type</th>
                    <th>Content</th>
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