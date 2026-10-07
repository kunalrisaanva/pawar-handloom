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
@media only screen and (min-width: 992px) {
	.slick-slide {
		/* margin: 0 25px; */
	}
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

    </style>
  </head>
  <body>
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
            <a href="https://www.youtube.com/@Pawar_Handloom"><img src="<?= base_url('public/frontend/img/y.png'); ?>"></a>
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
            <?php
                $session = session(); 
                if ($session->has('is_logged_in')) :
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
              ?>
                <!-- <li><a href="< ?= base_url('/register'); ?>">Resellers Register</a></li>
                <li><a href="< ?= base_url('/login'); ?>">Reseller Login</a></li> -->
                <?php if (!$session->has('is_logged_in')) : ?>
                  <li><a href="<?= base_url('/register') ?>">Resellers Register</a></li>
                  <li><a href="<?= base_url('/login') ?>">Reseller Login</a></li>
                <?php else : ?>
                  <li>Welcome, <?= $session->get('company_name'); ?> </li>
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
                <span><i id="cart-count"><?= session()->get('cart') ? $totalItems : 0; ?></i></span>
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
              echo"Check Cart:- <pre>";
              print_r($cart);
              $totalItems = count($cart);
            ?>
            <a class="ps-cart-toggle" href="#">
                <i class="pe-7s-shopbag"></i>
                <span><i id="cart-count"><?= session()->get('cart') ? $totalItems : 0; ?></i></span>
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
                <li><a href="login.html">Reseller Login</a></li>
                <li><a href="register.html">Reseller Register</a></li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="menu--mobile">
          <li class=""><a href="index.html">Home</a><span class=""></span></li>
            <li class=""><a href="about.html">About Us</a><span class=""></span></li>
            <li class="menu-item-has-children has-mega-menu"><a href="index.html">Collection</a><span class="sub-toggle"></span>
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
            </li>
            <li class=""><a href="gallery.html">Gallery</a><span class=""></span></li>
            <li class=""><a href="contact.html">Contact</a><span class=""></span></li>
        </ul>
      </div>
    </div>
