
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
              <a href="<?= base_url('admin/AddColours'); ?>" title="Add New Colour" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Colour</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Colour Name</th>
                    <th>Colour Code</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($colourList)){
                  $count = 1;
                  foreach($colourList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><div style="display:flex; align-items:center; gap:8px;">
                            <span><?= ucwords($value->colour_name); ?></span>
                            <div style="
                                width:25px; 
                                height:25px; 
                                border-radius:50%; 
                                background: <?= $value->colour_code ?>; 
                                border:1px solid #ccc;">
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        
                        <?= $value->colour_code; ?></td>
                    
                    <td>
                    <!-- <button type="button" data="< ?php echo $value->id ?>" class="status_checks btn < ?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                    < ?php echo ($value->status == 0) ? "Deactivate" : "Activate"; ?>
                    </button> -->
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_COLOURS; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Colour" 
                    href="<?= base_url().'admin/EditColour/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Colour" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_COLOURS)) ?>"
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
                    <th>Colour Name</th>
                    <th>Colour Code</th>
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
  
  