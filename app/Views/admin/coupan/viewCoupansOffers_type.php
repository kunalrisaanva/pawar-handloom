
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- Get Notification  -->

              <a href="<?= base_url('admin/AddCoupanOfferType'); ?>" title="Add New Coupan" style="float:right">
                    <button type="button" class="btn btn-outline-primary btn-block"><i class="fa fa-plus"></i> Add New Coupan & Offer Type</button>
                  </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Type</th>
                    <th>Coupan & Offres</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  <tr>
                    <td><?= 1; ?></td>
                    <td>Coupan</td>
                    <td><?= "first"; ?></td>
                    <td>
                    
                        <a>
                            <span data-id="1" data-table="<?= TBL_CHILDCAT; ?>" class="btn status_checks btn btn-success">
                            Active
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Category" 
                    href="#">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Sub Category" class="deleteCategory"  
                    data-id="1" 
                    data-table="<?= base64_encode(urlencode(TBL_CHILDCAT)) ?>"
                    data-deletecategory="Yes" >
                    <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i>
                   </a>
                  </td>
                  </tr>
                  <tr>
                    <td><?= 2; ?></td>
                    <td>Offer</td>
                    <td><?= "first"; ?></td>
                    <td>
                    
                        <a>
                            <span data-id="1" data-table="<?= TBL_CHILDCAT; ?>" class="btn status_checks btn btn-success">
                            Active
                            </span>
                        </a>    
                    </td>
                    <td> <a title="Edit Category" 
                    href="#">
                    <i class="fas fa-edit" aria-hidden="true"></i></a> || 
                    <a title="Delete Sub Category" class="deleteCategory"  
                    data-id="1" 
                    data-table="<?= base64_encode(urlencode(TBL_CHILDCAT)) ?>"
                    data-deletecategory="Yes" >
                    <i style="color: red;" class="fas fa-trash-alt" aria-hidden="true"></i>
                   </a>
                  </td>
                  </tr>               
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Type</th>
                    <th>Coupan & Offres</th>
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
  
