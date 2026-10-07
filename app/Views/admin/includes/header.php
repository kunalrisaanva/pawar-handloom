<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?> </title>
  <link rel="icon" type="image/x-icon" href="<?= base_url($siteDetails[0]->favicon_logo); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/dist/css/adminlte.min.css'); ?>">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/toastr/toastr.min.css'); ?>">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/daterangepicker/daterangepicker.css'); ?>">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/select2/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'); ?>">
  <!-- Self CSS -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/admincss.css'); ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('public/assets/admin/plugins/summernote/summernote-bs4.min.css'); ?>">



</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="<?= base_url('public/assets/admin/dist/img/gymLogo.png'); ?>" alt="GYM Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Dashboard</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <div class="user-block">
            <a title="User Profile" href="<?= base_url('admin/ViewProfile'); ?>" class="nav-link" >
            <?php 
                        $session = session();
                        $display_name = $_SESSION['display_name'];
                        $user_image = $_SESSION['user_image'];
              ?>
              <img class="img-circle img-bordered-sm" src="<?= base_url('public/uploads/admin/profile/'); ?><?= $user_image; ?>" alt="user image" />
              <?php          echo"<span>".$display_name."</span>";
                ?>                
              
            </a>
          </div>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/logout'); ?>" class="nav-link">
            <p> <i class="fas fa-sign-out-alt"></i></p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('admin/Dashboard') ?>" class="brand-link">
        <img src="<?= base_url($siteDetails[0]->favicon_logo); ?>" alt="Company Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?=  $siteDetails[0]->company_name; ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="<?= base_url('admin/Dashboard'); ?>" class="nav-link <?= $active_link == 'admin/Dashboard' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <!-- Super admin configuration -->
            <li class="nav-item <?= ($active_link == 'admin/ViewSlider') || ($active_link == 'admin/addSlider') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cube"></i>
                <p>
                  Slider
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewSlider') ?>" class="nav-link <?= $active_link == 'admin/ViewSlider' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p> View Slider </p>
                  </a>
                </li>
                <!-- <li class="nav-item">
                <a href="pages/examples/lockscreen.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lockscreen</p>
                </a>
              </li> -->

              </ul>
            </li>
            <!-- //End configuration -->

            <li class="nav-item <?= ($active_link == 'admin/ViewCategory') || ($active_link == 'admin/addCategory') || ($active_link == 'admin/ViewSubCategory') || ($active_link == 'admin/addSubCategory') || ($active_link == 'ViewsubSubCategory') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Category
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCategory') ?>" class="nav-link <?= $active_link == 'admin/ViewCategory' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewSubCategory') ?>" class="nav-link <?= $active_link == 'admin/ViewSubCategory' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View SubCategory</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewsubSubCategory') ?>" class="nav-link <?= $active_link == 'admin/ViewsubSubCategory' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Sub-SubCategory</p>
                  </a>
                </li>

              </ul>
            </li>
            <!--Colour-->
            
            <li class="nav-item <?= ($active_link == 'admin/ViewColours') || ($active_link == 'admin/AddColours') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Colour
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewColours') ?>" class="nav-link <?= $active_link == 'admin/ViewColours' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Colour</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <!--//Colour-->
            <li class="nav-item <?= ($active_link == 'admin/ViewProduct') || ($active_link == 'admin/addShift') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Product
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewProduct') ?>" class="nav-link <?= $active_link == 'admin/ViewProduct' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Product</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item <?= ($active_link == 'admin/ViewCoupan') || ($active_link == 'admin/addShift') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Coupon
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCoupan') ?>" class="nav-link <?= $active_link == 'admin/ViewCoupan' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Coupan</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item <?= ($active_link == 'admin/ViewCustomer') || ($active_link == 'admin/addShift') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Customer
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCustomer') ?>" class="nav-link <?= $active_link == 'admin/ViewCustomer' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Customer List</p>
                  </a>
                </li>
              </ul>
            </li>
            <!-- Gallery -->

            <li class="nav-item <?= ($active_link == 'admin/ViewGalleryCategory') || ($active_link == 'admin/ViewGallery') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Gallery
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?= base_url('admin/ViewGalleryCategory') ?>" class="nav-link <?= $active_link == 'admin/ViewGalleryCategory' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Gallery Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewGallery') ?>" class="nav-link <?= $active_link == 'admin/ViewGallery' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Gallery </p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- //Gallery -->

            <!-- Catlog -->

            <li class="nav-item <?= ($active_link == 'admin/ViewCatlogCategory') || ($active_link == 'admin/ViewGallery') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Catalog
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCatlogCategory') ?>" class="nav-link <?= $active_link == 'admin/ViewCatlogCategory' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Catalog Category</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCatlog') ?>" class="nav-link <?= $active_link == 'admin/ViewCatlog' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Catalog </p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- //Catlog -->

             <!--Orders List-->
             
            <!--<li class="nav-item">-->
            <!--  <a href="< ?= base_url('admin/ViewOrders'); ?>" class="nav-link < ?= $active_link == 'admin/ViewOrders' ? 'active' : ''; ?>">-->
            <!--  <i class="nav-icon fas fa-copy"></i>-->
            <!--    <p>-->
            <!--      Orders-->
            <!--    </p>-->
            <!--  </a>-->
            <!--</li>-->
            
            <li class="nav-item <?= ($active_link == 'admin/ViewOrders') || ($active_link == 'admin/ViewCustomerOrders') ? 'menu-open' : ''; ?>">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p> 
                  View Orders
                  <i class="fas fa-angle-left right"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="<?= base_url('admin/ViewOrders') ?>" class="nav-link <?= $active_link == 'admin/ViewOrders' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Resaller Orders</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('admin/ViewCustomerOrders') ?>" class="nav-link <?= $active_link == 'admin/ViewCustomerOrders' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View Customers Orders </p>
                  </a>
                </li>
              </ul>
            </li>
            
            
            <li class="nav-item">
              <a href="<?= base_url('admin/ViewReviews'); ?>" class="nav-link <?= $active_link == 'admin/ViewReviews' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-copy"></i>
                <p>
                  Review
                </p>
              </a>
            </li>
             <!-- //Send Message -->
            <li class="nav-item"> <a href="<?= base_url('logout'); ?>" class="nav-link">
                <p> <i class="fas fa-sign-out-alt"></i> Logout</p>
              </a></li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $page_title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $page_title; ?> </li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->