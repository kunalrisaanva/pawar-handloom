
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
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Child Category</th>
                    <th>Product Name</th>
                    <th>Offer Price</th>
                    <th>Cover Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                  if(!empty($productList)){
                  $count = 1;
                  foreach($productList as $x =>$value): 
                    $category = getProductCategory($value->category);
                    $subcategory = getProductsubCategory($value->subcategory);
                    $childcategory = getProductchildsubCategory($value->sub_subCategory);
                  ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= isset($category->category_name) && $category->category_name != '0' ? $category->category_name : 'NA'; ?></td>
                    <td><?= isset($subcategory->name) && $subcategory->name != '0' ? $subcategory->name : 'NA'; ?></td>
                    <td><?= isset($childcategory->name) && $childcategory->name != '0' ? $childcategory->name : 'NA'; ?></td>

                    <td><?= $value->product_name; ?></td>
                    <td><?= $value->offer_price; ?></td>
                    <td><img src="<?= base_url('public/'.$value->cover_image); ?>" width="50px" height="50px"></td>
                    
                    <td>
                        <a >
                            <span data-id="<?php echo $value->id ?>" data-table="<?= TBL_PRODUCT; ?>" class="btn status_checks btn <?php echo ($value->status == 0) ? "btn-danger" : "btn-success"; ?> ">
                            <?= $value->status==1?'Active':'Inactive'; ?>
                            </span>
                        </a>    
                    </td>
                    <td>
                    <button type="button" title="View Product Details" class="btn" data-toggle="modal" data-target="#modal-ProductInfo_<?= $value->id; ?>">
                          <i style="color: darkorange;" class="fas fa-eye" aria-hidden="true"></i>
                    </button> || <a title="Edit Coupon" 
                    href="<?= base_url().'admin/EditSlider/'.base64_encode(urlencode($value->id)); ?>">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Coupon" class="deleteCategory"
                    data-id="<?= base64_encode(urlencode($value->id)); ?>"
                    data-table="<?= base64_encode(urlencode(TBL_PRODUCT)) ?>"
                    data-deletecategory="Yes">
                     <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i></a></td>
                  </tr>
                  <!-- Modal for product details -->
                  <!-- Modal for product details -->
                  <div class="modal fade" id="modal-ProductInfo_<?= $value->id; ?>" tabindex="-1">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                              <!-- Modal Header -->
                              <div class="modal-header bg-dark text-white">
                                  <h3 class="modal-title">Product Details of <?= $value->product_name; ?></h3>
                                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>

                              <!-- Modal Body -->
                              <div class="modal-body">
                                  <div class="row align-items-start">
                                      <!-- Left: Product Image -->
                                      <div class="col-md-4 text-center mb-3">
                                          <img src="<?= base_url('public/'.$value->cover_image); ?>" alt="Product Image" class="img-fluid rounded shadow-sm border mb-3" style="max-height: 250px;">

                                          <div class="text-left">
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Category:</strong>
                                                  <span><?= isset($category->category_name) && $category->category_name != '0' ? $category->category_name : 'NA'; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Subcategory:</strong>
                                                  <span><?= isset($subcategory->name) && $subcategory->name != '0' ? $subcategory->name : 'NA'; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Child Category:</strong>
                                                  <span><?= isset($childcategory->name) && $childcategory->name != '0' ? $childcategory->name : 'NA'; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Actual Price:</strong>
                                                  <span style="text-decoration: line-through;">₹<?= $value->actual_price; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Offer Price:</strong>
                                                  <span>₹<?= $value->offer_price; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Product Quantity:</strong>
                                                  <span><?= $value->product_qunatity; ?></span>
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Fabric:</strong>
                                                  <span><?= !($value->fabric_type) && $value->fabric_type !=''? $value->fabric_type:'NA'; ?></span> 
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Saree Dimensions:</strong>
                                                  <span><?= !empty($value->dimensions) ? $value->dimensions : 'NA'; ?></span> 
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Blouse Dimensions:</strong>
                                                  <span><?= !empty($value->blouse_dimensions)? $value->blouse_dimensions:'NA'; ?></span> 
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Wash care:</strong>
                                                  <span><?= !empty($value->wash_care)? $value->wash_care:'NA'; ?></span> 
                                              </div>
                                              <div class="mb-2 d-flex">
                                                  <strong class="text-orange me-2" style="min-width: 130px;">Delivery Time:</strong>
                                                  <span><?= !empty($value->delivery_time)? $value->delivery_time:'NA'; ?></span> 
                                              </div>
                                          </div>
                                      </div>


                                      <!-- Right: Product Details -->
                                      <div class="col-md-8">
                                          

                                          <div class="mb-2">
                                              <strong class="text-orange">Short Description:</strong> <?= isset($value->short_description) && $value->short_description != '' ? $value->short_description : 'NA'; ?>
                                          </div>
                                          <div class="mb-2">
                                              <strong class="text-orange">Description:</strong> <?= isset($value->description) && $value->description != '' ? $value->description : 'NA'; ?>
                                          </div>


                                          <!-- Add more fields below if needed -->
                                          <!--
                                          <div class="mb-2">
                                              <strong>Description:</strong> < ?= $value->description ?? 'Not Available'; ?>
                                          </div>
                                          -->
                                      </div>
                                        <!-- Product images -->
                                      <div class="row">
                                          <div class="col-12 mb-2">
                                              <strong class="text-orange">Additional Product Images:</strong>
                                          </div>
                                        <?php 
                                              $productImages = getProductImages($value->id); 
                                              if (!empty($productImages)) : 
                                                  foreach ($productImages as $img): 
                                              ?>
                                                  <div class="col-md-4 mb-3">
                                                      <img src="<?= base_url('public/'.$img->image); ?>" class="img-fluid rounded border shadow-sm" style="height: 150px; width:auto; object-fit: cover;" alt="Product Image">
                                                  </div>
                                              <?php 
                                                  endforeach; 
                                              else: 
                                              ?>
                                                  <div class="col-12">
                                                      <p class="text-muted">No additional images available.</p>
                                                  </div>
                                        <?php endif; ?>

                                      </div>
                                      <!-- //Product images -->
                                  </div>
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
                      <tr> <td colspan="5"> <center><b> No Records Found!</b></center></td></tr>
                    <?php }
                  ?>
                                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Sr. No.</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Child Category</th>
                    <th>Product Name</th>
                    <th>Offer Price</th>
                    <th>Cover Image</th>
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
  
