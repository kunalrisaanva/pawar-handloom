<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="favicon.png" rel="icon">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Pawar Handloom
      By Piyush Pawar</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,500i,600,600i,700%7CLibre+Baskerville:400,400i,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/bootstrap4/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/owl-carousel/assets/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/slick/slick/slick.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/lightGallery-master/dist/css/lightgallery.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/jquery-ui/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/pe7/pe-icon-7-stroke/css/pe-icon-7-stroke.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/plugins/YTPlayer/dist/css/jquery.mb.YTPlayer.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/css/slick.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('public/frontend/css/slick-theme.min.css'); ?>">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <style>
      /* Reset CSS */

@import url("https://fonts.googleapis.com/css?family=Muli:200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap");


/* bf-testimonial-slick */
.bf-testimonial-slick-single {
	color: #000 !important;
	text-align: center;
	border-radius: 10px;
	/* background-image: linear-gradient(142deg, #020b15 -14%, #041331 121%); */
	padding: 50px;
}
.slick-slide {
	/* margin: 0 15px; */
}


.mobile-content {
  display: none;
}

.desktop-content {
  display: block; /* Or flex, grid, etc., depending on your layout needs */
}

 .mobile-artisan {
    display: none; /* Or flex, grid */
  }

   .desktop-artisan {
    display: flex;
  }

/* Media query for mobile screens (e.g., max-width of 768px) */
@media screen and (max-width: 768px) {
  .mobile-content {
    display: block !important; /* Or flex, grid */
  }
  .mobile-artisan {
    display: flex; /* Or flex, grid */
  }
  .imgSlider{
    height: 400px;
  }

  .desktop-content {
    display: none !important;
  }
   .desktop-artisan {
    display: none;
  }
  .slick-slide img{
    width: 100%;
    height: auto;
  }
}

@media only screen and (min-width: 992px) {
	.slick-slide {
		/* margin: 0 25px; */
	}
}

@media only screen and (max-width: 767px) {
  /* Styles specific to mobile devices */
  .imgSlider {
height: 300px;	}
}

.bf-testimonial-icon i {
	font-size: 20px;
	letter-spacing: 5.4px;
	color: #f8c51c;
}
.bf-testimonial-title h3 {
	font-size: 24px;
	font-weight: 900;
	line-height: 1.5em;
	text-align: center;
	color: #000;
}

.bf-testimonial-message p {
	opacity: 0.7;
	font-family: "Muli", sans-serif;
	font-size: 15px;
	line-height: 1.6em;
	text-align: center;
	color: #000;
}
.bf-testimonial-author-info {
}
.bf-testimonial-author-info .author-name h4 {
	opacity: 0.6;
	font-size: 15px;
	font-weight: 900;
	line-height: 1em;
	text-align: center;
	color: #000;
}
.bf-testimonial-author-info .author-designation h5 {
	opacity: 0.3;
	font-family: "Muli", sans-serif;
	font-size: 15px;
	line-height: 1em;
	color: #ffffff;
}

/* Testimonial Spacing */
.bf-testimonial-icon {
	margin-bottom: 13px;
}
.bf-testimonial-title {
	margin-bottom: 36px;
}
.bf-testimonial-message {
	padding: 0 50px;
	margin-bottom: 45px;
}
.bf-testimonial-author-info .author-name {
	margin-bottom: 10px;
}
@media only screen and (max-width: 1367px) {
	.bf-testimonial-slick-single {
		padding: 20px;
	}
	.bf-testimonial-message {
		padding: 0 10px;
	}
}
@media only screen and (max-width: 991px) {
	.bf-testimonial-slick-single {
		padding: 20px;
	}
	.bf-testimonial-message {
		padding: 0px;
	}
}

.float{
position:fixed;
width:60px;
height:60px;
bottom:80px;
right:10px;
background-color:#25d366;
color:#FFF;
border-radius:50px;
text-align:center;
font-size:30px;
box-shadow: 2px 2px 3px #999;
z-index:100;
}

.my-float{
margin-top:16px;
}

.float-call {
    position: fixed;
    width: 105px;
    height: 45px;
    bottom: 40px;
    left:50px;
    background-color: #109cb0;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 15px;
    z-index: 100;
    padding-top: 0px;
}

 .icon-container {
  display: flex; /* Enables Flexbox layout */
  justify-content: space-around; /* Distributes space evenly around icons */
  align-items: center; /* Vertically aligns icons in the center */
}

/* Optional: Style your individual icons */
.icon-container i {
  font-size: 24px; /* Adjust icon size */
  margin: 0 10px; /* Add horizontal spacing */
  color: #333; /* Set icon color */
}

    </style>

<!--add to cart message css-->

<style>
.toast-message {
    position: fixed;
    top: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(-10px);
    background: #0f766e;
    color: #fff;
    padding: 16px 28px;
    border-radius: 10px;
    font-size: 18px;          /* 🔥 bigger text */
    font-weight: 500;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    opacity: 0;
    transition: all 0.35s ease;
    z-index: 9999;
    min-width: 320px;
    text-align: center;
}

.toast-message.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.toast-message.error {
    background: #dc2626;
}


/* MOBILE FIX */
@media (max-width: 768px) {
    .toast-message {
        top: 90px;              /* navbar ke niche */
        width: 90%;
        min-width: unset;
        max-width: 90%;
        font-size: 14px;
        padding: 12px 16px;
    }
}

</style>


<!--//add to cart message css-->

  </head>
  <body>
      <!--add to cart message-->
      
      <div id="toast" class="toast-message"></div>

      
      <!--//add to cart message-->
    <header class="header header--1" data-sticky="true">
      <div class="header__top">
        <div class="header__left">
          <p>
            <span><i class="pe-7s-call"></i> +91 9630504663, 9039119245</span>
          <span><i class="pe-7s-mail"></i> <span class="" data-cfemail="">info@pawarhandloom.com</span></span></p>
        </div>
       
        <div class="header__right">
          <div class="ps-dropdown">
            <a href="https://www.facebook.com/Official.PawarHandloom/"><img src="<?= base_url('public/frontend/img/f.png'); ?>"></a>
            <a href="https://www.instagram.com/official_pawarhandloom/"><img src="<?= base_url('public/frontend/img/i.png'); ?>"></a>
            <a href="https://www.youtube.com/@pawarhandloombypiyush"><img src="<?= base_url('public/frontend/img/y.png'); ?>"></a>
          </div>
        </div>
      </div>
      <div class="navigation">
        <div class="navigation__left"><a class="ps-logo" href="<?= base_url('/'); ?>"><img src="<?= base_url('public/frontend/img/logo.png'); ?>" alt=""></a></div>
        <div class="navigation__center">
          <ul class="menu">
            <li class=""><a href="<?= base_url('/'); ?>">Home</a><span class="sub-toggle"></span></li>
            <li class=""><a href="<?= base_url('/about');?>">About Us</a><span class="sub-toggle"></span></li>
            <li class="menu-item-has-children">
              <a href="#">Collection</a>
              <span class="sub-toggle"></span>
              <ul class="sub-menu">
                  <?php $categoryMenu = getCategoryMenu(); // Fetch menu dynamically ?>
                  <?php if (!empty($categoryMenu)) : ?>
                      <?php foreach ($categoryMenu as $category) : ?>
                          <li class="<?= !empty($category['subcategories']) ? 'menu-item-has-children' : ''; ?>">
                              <a href="<?= base_url('shop/' . $category['id']); ?>"><?= esc($category['name']); ?></a>
                              
                              <?php if (!empty($category['subcategories'])) : ?>
                                  <span class="sub-toggle"></span>
                                  <ul class="sub-menu">
                                      <?php foreach ($category['subcategories'] as $subcategory) : ?>
                                          <li class="<?= !empty($subcategory['subsubcategories']) ? 'menu-item-has-children' : ''; ?>">
                                              <a href="<?= base_url('shop/'.$category['id'].'/' . $subcategory['id']); ?>"><?= esc($subcategory['name']); ?></a>
                                              
                                              <?php if (!empty($subcategory['subsubcategories'])) : ?>
                                                  <span class="sub-toggle"></span>
                                                  <ul class="sub-menu">
                                                      <?php foreach ($subcategory['subsubcategories'] as $subsubcat) : ?>
                                                          <li>
                                                              <a href="<?= base_url('shop/'.$category['id'].'/' . $subcategory['id'].'/' . $subsubcat['id']); ?>"><?= esc($subsubcat['name']); ?></a>
                                                          </li>
                                                      <?php endforeach; ?>
                                                  </ul>
                                              <?php endif; ?>
                                          </li>
                                      <?php endforeach; ?>
                                  </ul>
                              <?php endif; ?>
                          </li>
                      <?php endforeach; ?>
                  <?php endif; ?>
              </ul>
            </li>

            
            <li class=""><a href="<?= base_url('/gallery') ?>">Gallery</a><span class="sub-toggle"></span></li>
            <li class=""><a href="<?= base_url('/contact') ?>">Contact</a><span class="sub-toggle"></span></li>
            <li class=""><a href="<?= base_url('/Review') ?>">Review</a><span class="sub-toggle"></span></li>
            <?php
                $session = session(); 
                if ($session->has('is_logged_in') && $session->get('role') == 1) :
            ?>
              <li class=""><a href="<?= base_url('/catlog') ?>">Catalog</a><span class="sub-toggle"></span></li>
            <?php endif; ?>
           </ul>
        </div>
        <div class="navigation__right">
          <div class="header__actions"><a class="ps-search-btn" href="#"><i class="pe-7s-search"></i></a>
            <div class="ps-dropdown"><a href="#"><i class="pe-7s-user"></i></a>
              <ul class="ps-dropdown-menu">
              <?php
                $session = session(); 
                
                // echo"Session Check:- <pre>";
                // print_r($session);
                
                // die;
              ?>
                <!-- <li><a href="< ?= base_url('/register'); ?>">Resellers Register</a></li>
                <li><a href="< ?= base_url('/login'); ?>">Reseller Login</a></li> -->
                <?php if (!$session->has('is_logged_in')) : ?>
                  <li><a href="<?= base_url('/register') ?>">Resellers Register</a></li>
                  <li><a href="<?= base_url('/login') ?>">Reseller Login</a></li>
                  <li><a href="<?= base_url('/CustomerRegister') ?>">Customer Register</a></li>
                  <li><a href="<?= base_url('/CustomerLogin') ?>">Customer Login</a></li>
                <?php else : 
                    $companyName = $session->get('company_name');
                    $email       = $session->get('email');
                ?>
                
                    <li>Welcome, <?= !empty($companyName) ? esc($companyName) : esc($email); ?> </li>
                  <!--<li>Welcome, < ?= $session->get('company_name'); ?> </li>-->
                  <li><a href="<?= base_url('/profile') ?>">Profile</a> </li>
                  <li><a href="<?= base_url('/UserOrders') ?>">Your Orders</a> </li>
                  <li> <a href="<?= base_url('logout'); ?>">Logout</a></li>
              <?php endif; ?>
              </ul>
            </div>
            <?php
              $cart = session()->get("cart") ?? [];
              //echo"Check Cart:- <pre>";
              //print_r($cart);
              $totalItems = count($cart);
            ?>
            <a class="ps-cart-toggle" href="#">
                <i class="pe-7s-shopbag"></i>
                <!--<span><i id="cart-count">< ?= session()->get('cart') ? $totalItems : 0; ?></i></span>-->
                <span><i class="cart-count"><?= session()->get('cart') ? $totalItems : 0; ?></i></span>
            </a>
          </div>
        </div>
      </div>
    </header>
    <header class="header header--mobile" data-sticky="true">
      <div class="header__top">
        <div class="header__left">
          <p><span><i class="pe-7s-call"></i> +91 9630504663, 9039119245
</span><span><i class="pe-7s-mail"></i><span class="">info@pawarhandloom.com</span></span></p>
        </div>
        
        <div class="header__right">
          <div class="ps-dropdown">
            <a href="https://www.facebook.com/Official.PawarHandloom/"><img src="img/f.png"></a>
            <a href="https://www.instagram.com/official_pawarhandloom/"><img src="img/i.png"></a>
            <a href="#"><img src="public/frontend/img/y.png"></a>
          </div>
        </div>
      </div>
      <div class="navigation--mobile">
        <div class="navigation__left">
          <div class="menu-toggle"><span></span></div>
        </div>
        <div class="navigation__center"><a class="ps-logo" href="<?= base_url('/'); ?>"><img src="<?= base_url('public/frontend/img/logo.png'); ?>" alt=""></a></div>
        <div class="navigation__right">
          <div class="header__actions"><a class="ps-search-btn" href="#"><i class="pe-7s-search"></i></a>
            <div class="ps-dropdown"><a href="#"><i class="pe-7s-user"></i></a>
            <?php
              $session = session();
            ?>
              <ul class="ps-dropdown-menu">
              <?php if (empty($session)) : ?>
                  <li><a href="<?= base_url('/register') ?>">Resellers Register</a></li>
                  <li><a href="<?= base_url('/login') ?>">Reseller Login</a></li>
                  
              <?php else : ?>
                  <li>Welcome, <?= $session->get('company_name'); ?> </li>
                  <li> </li>
                  <li> <a href="<?= base_url('logout'); ?>">Logout</a></li>
              <?php endif; ?>
              </ul>
            </div>
            <?php
              $cart = session()->get("cart") ?? [];
              // echo"Check Cart:- <pre>";
              // print_r($cart);
              $totalItems = count($cart);
            ?>
            <a class="ps-cart-toggle" href="#">
                <i class="pe-7s-shopbag"></i>
                <!--<span><i id="cart-count">< ?= session()->get('cart') ? $totalItems : 0; ?></i></span>-->
                <span><i class="cart-count"><?= session()->get('cart') ? $totalItems : 0; ?></i></span>
            </a>
          </div>
        </div>
      </div>
    </header>
    <div class="navigation--sidebar">
      <div class="navigation__header">
        <h3>Menu</h3><a class="ps-btn--close ps-btn--no-boder" href="#"></a>
      </div>
      <div class="navigation__content">
        <div class="navigation__actions">
          <div class="header__actions"><a class="ps-search-btn" href="#"><i class="pe-7s-search"></i></a>
            <div class="ps-dropdown"><a href="#"><i class="pe-7s-user"></i></a>
              <ul class="ps-dropdown-menu">
                <?php
                $session = session(); 
              ?>
                <!-- <li><a href="< ?= base_url('/register'); ?>">Resellers Register</a></li>
                <li><a href="< ?= base_url('/login'); ?>">Reseller Login</a></li> -->
                <?php if (!$session->has('is_logged_in')) : ?>
                  <li><a href="<?= base_url('/register') ?>">Resellers Register</a></li>
                  <li><a href="<?= base_url('/login') ?>">Reseller Login</a></li>
                  <li><a href="<?= base_url('/CustomerRegister') ?>">Customer Register</a></li>
                  <li><a href="<?= base_url('/CustomerLogin') ?>">Customer Login</a></li>
                <?php else : ?>
                  <li>Welcome, <?= $session->get('company_name'); ?> </li>
                  <li><a href="<?= base_url('/profile') ?>">Profile</a> </li>
                  <li><a href="<?= base_url('/UserOrders') ?>">Your Orders</a> </li>
                  <li> <a href="<?= base_url('logout'); ?>">Logout</a></li>
              <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
        
<!-- Mobile Menu -->
<ul class="menu--mobile">
          <li class=""><a href="<?= base_url('/'); ?>">Home</a><span class=""></span></li>
            <li class=""><a href="<?= base_url('/about'); ?>">About Us</a><span class=""></span></li>
            <!--<li class="menu-item-has-children has-mega-menu"><a href="#">Collection</a><span class="sub-toggle"></span>
              <div class="mega-menu">
                <div class="mega-menu__column">
                  <h4>Best Sellers</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>New Arrivals</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>Celebs Look</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>Sarees<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html"><i class="fas fa-arrow-right"></i> Maheshwari</a>
                      <ul class="mega-menu__sublist" style="padding-left: 40px; list-style-type: disc;">
  <li><a href="shop.html">Soft Maheshwari</a>
    <ul class="mega-menu__sublist" style="padding-left: 20px;list-style: circle;">
  <li><a href="shop.html">Soft Maheshwari</a></li>
  <li><a href="shop.html">Silk Blend Maheshwari</a></li>
  <li><a href="shop.html">Traditional Maheshwari</a></li>
</ul>
  </li>
  <li><a href="shop.html">Silk Blend Maheshwari</a></li>
  <li><a href="shop.html">Traditional Maheshwari</a></li>
</ul>

                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
                <div class="mega-menu__column">
                  <h4>Dress Materials<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html">Maheshwari</a>
                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
                <div class="mega-menu__column">
                  <h4>Stole/Dupatta<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html">Maheshwari</a>
                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>-->
            <!--Dynamic menu and sub menu-->
             <!--<li class="menu-item-has-children has-mega-menu"><a href="index.html">Collection</a><span class="sub-toggle"></span>
              <div class="mega-menu">
                <div class="mega-menu__column">
                  <h4>Best Sellers</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>New Arrivals</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>Celebs Look</h4> 
                </div>
                <div class="mega-menu__column">
                  <h4>Sarees<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html"><i class="fas fa-arrow-right"></i> Maheshwari</a>
                      <ul class="mega-menu__sublist" style="padding-left: 40px; list-style-type: disc;">
  <li><a href="shop.html">Soft Maheshwari</a>
    <ul class="mega-menu__sublist" style="padding-left: 20px;list-style: circle;">
  <li><a href="shop.html">Soft Maheshwari</a></li>
  <li><a href="shop.html">Silk Blend Maheshwari</a></li>
  <li><a href="shop.html">Traditional Maheshwari</a></li>
</ul>
  </li>
  <li><a href="shop.html">Silk Blend Maheshwari</a></li>
  <li><a href="shop.html">Traditional Maheshwari</a></li>
</ul>

                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
                <div class="mega-menu__column">
                  <h4>Dress Materials<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html">Maheshwari</a>
                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
                <div class="mega-menu__column">
                  <h4>Stole/Dupatta<span class="sub-toggle"></span></h4>
                  <ul class="mega-menu__list">
                    <li><a href="shop.html">Maheshwari</a>
                    </li>
                    <li><a href="shop.html">Chanderi</a>
                    </li>
                    <li><a href="shop.html">Handblock</a>
                    </li>
                    <li><a href="shop.html">Pure cotton</a>
                    </li>
                  </ul>
                </div>
              </div>
            </li>-->
                <li class="menu-item-has-children has-mega-menu">
    <a href="#">Collection</a>
    <span class="sub-toggle"></span>

    <div class="mega-menu">

        <?php $categoryMenu = getCategoryMenu(); 
        
            //echo"Check Menu:- <pre>";
            //print_r($categoryMenu);
            //die;
        ?>

        <?php if (!empty($categoryMenu)) : ?>
            <?php foreach ($categoryMenu as $category) : ?>

                <!-- CATEGORY COLUMN -->
                <div class="mega-menu__column">
                    <h4>
                        <?= esc($category['name']); ?>
                        <?php if (!empty($category['subcategories'])) : ?>
                            <span class="sub-toggle"></span>
                        <?php endif; ?>
                    </h4>

                    <?php if (!empty($category['subcategories'])) : ?>
                        <ul class="mega-menu__list">

                            <?php foreach ($category['subcategories'] as $subcategory) : ?>
                                <li>
                                    <a href="<?= base_url('shop/'.$category['id'].'/'.$subcategory['id']); ?>">
                                        <i class="fas fa-arrow-right"></i>
                                        <?= esc($subcategory['name']); ?>
                                    </a>

                                    <!-- SUB-SUB CATEGORY -->
                                    <?php if (!empty($subcategory['subsubcategories'])) : ?>
                                        <ul class="mega-menu__sublist" style="padding-left:40px; list-style-type:disc;">

                                            <?php foreach ($subcategory['subsubcategories'] as $subsub) : ?>
                                                <li>
                                                    <a href="<?= base_url('shop/'.$category['id'].'/'.$subcategory['id'].'/'.$subsub['id']); ?>">
                                                        <?= esc($subsub['name']); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    <?php endif; ?>

                                </li>
                            <?php endforeach; ?>

                        </ul>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</li>

            
            <!--//Dynamic menu and sub menu-->
            
            <li class=""><a href="<?= base_url('/gallery'); ?>">Gallery</a><span class=""></span></li>
            <li class=""><a href="<?= base_url('contact');?>">Contact</a><span class=""></span></li>
        </ul>

<!-- //Mobile Menu -->

        <!-- <ul class="menu--mobile">
          <li class=""><a href="< ?= base_url('/'); ?>">Home</a><span class=""></span></li>
            <li class=""><a href="< ?= base_url('/about'); ?>">About Us</a><span class=""></span></li>
            <li class="menu-item-has-children has-mega-menu">
              <a href="#">Collection</a>
              <span class="sub-toggle"></span>
              <ul class="sub-menu">
                  < ?php $categoryMenu = getCategoryMenu(); // Fetch menu dynamically ?>
                  < ?php if (!empty($categoryMenu)) : ?>
                      < ?php foreach ($categoryMenu as $category) : ?>
                          <li class="< ?= !empty($category['subcategories']) ? 'menu-item-has-children' : ''; ?>">
                              <a href="< ?= base_url('shop/' . $category['id']); ?>">< ?= esc($category['name']); ?></a>
                              
                              < ?php if (!empty($category['subcategories'])) : ?>
                                  <span class="sub-toggle"></span>
                                  <ul class="sub-menu">
                                      < ?php foreach ($category['subcategories'] as $subcategory) : ?>
                                          <li class="< ?= !empty($subcategory['subsubcategories']) ? 'menu-item-has-children' : ''; ?>">
                                              <a href="< ?= base_url('shop/'.$category['id'].'/' . $subcategory['id']); ?>">< ?= esc($subcategory['name']); ?></a>
                                              
                                              < ?php if (!empty($subcategory['subsubcategories'])) : ?>
                                                  <span class="sub-toggle"></span>
                                                  <ul class="sub-menu">
                                                      < ?php foreach ($subcategory['subsubcategories'] as $subsubcat) : ?>
                                                          <li>
                                                              <a href="< ?= base_url('shop/'.$category['id'].'/' . $subcategory['id'].'/' . $subsubcat['id']); ?>">< ?= esc($subsubcat['name']); ?></a>
                                                          </li>
                                                      < ?php endforeach; ?>
                                                  </ul>
                                              < ?php endif; ?>
                                          </li>
                                      < ?php endforeach; ?>
                                  </ul>
                              < ?php endif; ?>
                          </li>
                      < ?php endforeach; ?>
                  < ?php endif; ?>
              </ul>
            </li>
            <li class=""><a href="< ?= base_url('/gallery') ?>">Gallery</a><span class=""></span></li>
            <li class=""><a href="< ?= base_url('/contact') ?>">Contact</a><span class=""></span></li>
            <li class=""><a href="< ?= base_url('/Review') ?>">Review</a><span class=""></span></li>
            < ?php
                $session = session(); 
                if ($session->has('is_logged_in')) :
            ?>
              <li class=""><a href="< ?= base_url('/catlog') ?>">Catalog</a><span class=""></span></li>
            < ?php endif; ?>
        </ul> -->
      </div>
    </div>
    <!--script for mobile mega menu-->
    <script>
document.addEventListener("DOMContentLoaded", function () {

    // Main Mega Menu Toggle
    document.querySelectorAll(".has-mega-menu > .sub-toggle")
    .forEach(function(toggle) {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            this.parentElement.classList.toggle("active");
        });
    });

    // Column Toggle
    document.querySelectorAll(".mega-menu__column h4")
    .forEach(function(heading) {
        heading.addEventListener("click", function () {
            this.parentElement.classList.toggle("active");
        });
    });

    // Nested List Toggle
    document.querySelectorAll(".mega-menu__list > li > a")
    .forEach(function(link) {
        link.addEventListener("click", function (e) {
            let subList = this.nextElementSibling;
            if(subList && subList.classList.contains("mega-menu__sublist")) {
                e.preventDefault();
                this.parentElement.classList.toggle("active");
            }
        });
    });

});
</script>

    <!--//script for mobile mega menu-->
