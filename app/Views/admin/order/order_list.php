
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
                    
                    <th>Order Id</th>
                    <th>Order Place</th>
                    <th>Full Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Payment Status</th>
                    <th>Transaction ID</th>
                    <!-- <th>Status</th> -->
                    <th>Order Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($orderList)){
                  $count = 1;
                  foreach($orderList as $x =>$value): ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= $value->order_id; ?></td>
                    <td><?= date('d-m-Y', strtotime($value->create_at)); ?></td>
                    <td><?= ucwords($value->first_name.' '.$value->last_name); ?></td>
                    <td><?= ucwords($value->company_name); ?></td>
                    <td><?= $value->email_id; ?></td>
                    <td><?= $value->phone; ?></td>
                    <td><?= $value->payment_status; ?></td>
                    <td><?= $value->transaction_id; ?></td>
                    <!-- <td>
                    
                        <a >
                            <span data-id="< ?php echo $value->order_id ?>" data-table="< ?= TBL_ORDER; ?>" class="btn status_checks btn < ?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            < ?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td> -->
                    <td>
                        <!-- Dynamic Dropdown from tbl_order_status -->
                        <?php 
                          $allStatuses = getAllOrderStatuses();
                          $selectedStatusColor = '#000'; // default fallback color

                            foreach ($allStatuses as $status) {
                                if ($status->id == $value->order_status) {
                                    $selectedStatusColor = $status->status_color;
                                    //break;
                                }
                                
                            }
                          ?>

                          <!-- Show current status badge -->
                          <!-- < ?php if ($currentStatus): ?>
                            <span class="badge d-block mb-1" style="background-color: < ?= $currentStatus->status_color ?>; color: #fff;">
                                < ?= $currentStatus->status_name ?>
                            </span>
                          < ?php endif; ?> -->

                          <!-- Custom Select2 Dropdown -->
                          <select class="form-control mt-2 order-status-dropdown select-status" 
                                  data-order-id="<?= $value->order_id ?>" 
                                  data-table="<?= TBL_ORDER ?>" style="color: <?= $selectedStatusColor ?>;">
                              <option value="">-- Update Status --</option>
                              <?php foreach ($allStatuses as $status): ?>
                                  <option 
                                      value="<?= $status->id ?>"
                                      data-color="<?= $status->status_color ?>"
                                      <?= ($status->id == $value->order_status) ? 'selected' : ''; ?>>
                                      <?= $status->status_name ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                    </td>
                    <td> <!--<a title="Edit Category" 
                    href="< ?= base_url().'admin/EditCategory/'.base64_encode(urlencode($value->order_id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a>-->
                    <button type="button" title="View Product Details" class="btn" data-toggle="modal" data-target="#modal-Getinfo_<?= $value->order_id; ?>">
                          <i style="color: darkorange;" class="fas fa-eye" aria-hidden="true"></i>
                    </button> ||
                    
                    <a title="Delete Category" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->order_id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_ORDER)) ?>"
                    data-deletecategory="Yes">
                     <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i>
                    </a>
                    </td>
                  </tr>
                    <!-- Modal for product details -->
                    <div class="modal fade" id="modal-Getinfo_<?= $value->order_id; ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h4 class="modal-title">Product Details</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <?php
                $productDetails = getProductDetailsByOrder($value->order_id);
                if (!empty($productDetails)) :
                    $count = 1;
                    foreach ($productDetails as $product) : ?>
                    
                        <div class="card mb-3 shadow-sm border">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-md-2 text-center mb-2 mb-md-0">
                                        <img src="<?= base_url('public/'.$product->image); ?>" alt="<?= $product->product_name; ?>" class="img-fluid rounded" style="max-height: 80px;">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-10">
                                        <div class="mb-1"><strong>#<?= $count++; ?></strong></div>
                                        <div class="mb-1"><strong>Product Name:</strong> <?= $product->product_name; ?></div>
                                        <div class="mb-1"><strong>Price:</strong> ₹<?= $product->price; ?></div>
                                        <div class="mb-1"><strong>Quantity:</strong> <?= $product->qty; ?></div>
                                        <div class="mb-1"><strong>Subtotal:</strong> ₹<?= $product->subtotal; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;
                else : ?>
                    <p>No product details found for this order.</p>
                <?php endif; ?>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                  <!-- //Modal for product details -->
                  <?php endforeach;
                    }else{ ?>
                      <tr> <td colspan="4"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>                
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    
                    <th>Order Id</th>
                    <th>Order Place</th>
                    <th>Full Name</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Contact No.</th>
                    <th>Payment Status</th>
                    <th>Transaction ID</th>
                    <!-- <th>Status</th> -->
                    <th>Order Status </th>
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