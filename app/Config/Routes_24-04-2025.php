<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 /** Routing For Frontend */
$routes->get('/', 'frontendController\HomeController::index');
$routes->get('/about', 'frontendController\HomeController::about');
$routes->get('/gallery', 'frontendController\HomeController::gallery');
$routes->get('/contact', 'frontendController\HomeController::contact');
$routes->get('/register', 'frontendController\HomeController::register');
$routes->get('/login', 'frontendController\HomeController::login');
$routes->match(['get','post'],'/detail/(:any)', 'frontendController\HomeController::detail/$1');
$routes->match(['get','post'],'/shop/(:any)', 'frontendController\HomeController::shop/$1');

$routes->match(['get','post'],'cart/add', 'frontendController\CartController::index');
$routes->get('cart', 'frontendController\CartController::showCart');
$routes->get('cart/remove/(:num)', 'frontendController\CartController::remove/$1');
$routes->match(['get','post'],'checkout', 'frontendController\CartController::checkout');
$routes->match(['get','post'],'checkout/placeOrder', 'frontendController\CartController::placeOrder');
$routes->get('success','frontendController\CartController::success');

$routes->post('register', 'frontendController\AuthController::register');
$routes->post('/front/login', 'frontendController\AuthController::login');
$routes->get('/logout', 'frontendController\AuthController::logout');
$routes->get('/profile','frontendController\HomeController::profile');
$routes->post('profile/update','frontendController\HomeController::profileUpdate');
$routes->get('/sendsendMail', 'frontendController\CartController::sendMail');

$routes->get('/catlog', 'frontendController\HomeController::catlog');

$routes->get('download-pdf/(:num)', 'frontendController\PdfController::downloadCatalogPdf/$1');

$routes->match(['get','post'],'/forgotPassword', 'frontendController\AuthController::forgotPassword');

$routes->match(['get', 'post'], 'reset-password/(:segment)', 'frontendController\AuthController::resetPassword/$1');

$routes->get('/UserOrders', 'frontendController\HomeController::userOrders');


/** //Routing For Frontend */


// Admin Routing

$routes->match (['get','post'],'/LgAdmin', 'admin\AdminLoginController::index',['filter'=>'noauth']);
$routes->post('admin/login', 'admin\AdminLoginController::authenticate', ['filter' => 'noauth']);
$routes->get('admin/logout', 'admin\AdminLoginController::logout', ['filter' => 'auth']);

$routes->get('admin/Dashboard', 'admin\AdminController::dashboard',['filter'=>'auth']);

//Profile
$routes->match(['get','post'],'admin/ViewProfile','admin\AdminController::view_profile',['filter'=>'auth']);
$routes->post('admin/UpdateProfile', 'admin\AdminController::update_profile',['filter'=>'auth']);

//Slider
$routes->get('admin/ViewSlider', 'admin\AdminSliderController::viewSlider',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addSlider', 'admin\AdminSliderController::addSlider',['filter'=>'auth']);
$routes->match(['get','post'],'admin/EditSlider/(:any)', 'admin\AdminSliderController::edit_slider/$1',['filter'=>'auth']);
$routes->post('admin/UpdateSlider', 'admin\AdminSliderController::update_slider',['filter'=>'auth']);

//Category
$routes->get('admin/ViewCategory', 'admin\AdminCategoryController::viewCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addCategory', 'admin\AdminCategoryController::addCategory',['filter'=>'auth']);
//$routes->post('admin/categoryAdd', 'AdminController::insert_category');
$routes->match(['get','post'],'admin/EditCategory/(:any)', 'admin\AdminCategoryController::edit_category/$1',['filter'=>'auth']);
//$routes->get('admin/delete/(:any)', 'AdminController::delete_category/$1');
$routes->post('admin/Updatecategory', 'admin\AdminCategoryController::update_category',['filter'=>'auth']);

$routes->post('admin/Updatestatus', 'admin\AdminController::update_status',['filter'=>'auth']);

//Sub Category
$routes->get('admin/ViewSubCategory', 'admin\AdminCategoryController::viewSubCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addSubCategory', 'admin\AdminCategoryController::addSubCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/getSubcategories', 'admin\AdminCategoryController::getSubcategories',['filter'=>'auth']);
$routes->match(['get','post'],'admin/EditSubCate/(:any)/(:any)', 'admin\AdminCategoryController::subCategoryEdit/$1/$2',['filter'=>'auth']);
$routes->post('admin/UpdateSubCat', 'admin\AdminCategoryController::update_sub_category',['filter'=>'auth']);

//Sub sub Category
$routes->get('admin/ViewsubSubCategory', 'admin\AdminCategoryController::viewsubSubCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addsubSubCategory', 'admin\AdminCategoryController::addsubSubCategory',['filter'=>'auth']);
$routes->post('admin/GetSubcategory', 'admin\AdminCategoryController::get_sub_category',['filter'=>'auth']);
$routes->post('admin/GetsubSubcategory', 'admin\AdminCategoryController::get_sub_sub_category',['filter'=>'auth']);

//Coupan
$routes->get('admin/ViewCoupan', 'admin\AdminCouponController::viewCoupan',['filter'=>'auth']);
$routes->match(['get','post'],'admin/AddCoupan', 'admin\AdminCouponController::addCoupan',['filter'=>'auth']);

//Product
$routes->get('admin/ViewProduct', 'admin\AdminProductController::viewProduct',['filter'=>'auth']);
$routes->match(['get','post'],'admin/AddProduct', 'admin\AdminProductController::addProduct',['filter'=>'auth']);

//Customer
$routes->get('admin/ViewCustomer', 'admin\AdminCustomerController::viewCustomer',['filter'=>'auth']);


//Gallery Category
$routes->get('admin/ViewGalleryCategory', 'admin\AdminGalleryController::viewGalleryCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addGalleryCategory', 'admin\AdminGalleryController::addGalleryCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/EditGalleryCategory/(:any)', 'admin\AdminGalleryController::edit_gallery_category/$1',['filter'=>'auth']);
$routes->post('admin/UpdateGallerycategory', 'admin\AdminGalleryController::update_gallery_category',['filter'=>'auth']);

//Gallery
$routes->get('admin/ViewGallery', 'admin\AdminGalleryController::viewGallery',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addGalleryImage', 'admin\AdminGalleryController::addGalleryImage',['filter'=>'auth']);

//Catlog Category
$routes->get('admin/ViewCatlogCategory', 'admin\AdminCatlogController::viewCatlogCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addCatlogCategory', 'admin\AdminCatlogController::addCatlogCategory',['filter'=>'auth']);
$routes->match(['get','post'],'admin/EditCatlogCategory/(:any)', 'admin\AdminCatlogController::edit_catlog_category/$1',['filter'=>'auth']);
$routes->post('admin/UpdateCatlogCategory', 'admin\AdminCatlogController::update_catlog_category',['filter'=>'auth']);

$routes->get('admin/ViewCatlog', 'admin\AdminCatlogController::viewCatlog',['filter'=>'auth']);
$routes->match(['get','post'],'admin/addCatlogImage', 'admin\AdminCatlogController::addCatlogImage',['filter'=>'auth']);


//Orders
$routes->get('admin/ViewOrders', 'admin\AdminOrderController::vieworderlist',['filter'=>'auth']);
//order status
$routes->post('admin/updateOrderStatus', 'admin\AdminOrderController::update_order_status',['filter'=>'auth']);
