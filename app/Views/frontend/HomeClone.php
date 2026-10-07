<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawar Handloom - Home Clone</title>
    <meta name="description" content="Pawar Handloom By Piyush Pawar - Handwoven sarees & suits from Maheshwar">
    <link rel="stylesheet" href="<?= base_url('frontend/css/clone-styles.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Lucide icons replacement - using Font Awesome instead */
        .icon { display: inline-flex; align-items: center; }
    </style>
</head>
<body>
<div style="background: #fff; min-height: 100vh;">

    <!-- ══════════ TOP BANNER ══════════ -->
    <div class="top-banner">
        <div class="marquee-content">
            <span>Free Shipping above ₹4000 (prepaid order)</span>
            <span>Buy 2 &amp; Get Extra 7% Off — Use Code B2G7</span>
            <span>Buy 3 &amp; Get Extra 10% Off — Use Code B3G10</span>
            <span>Free Shipping above ₹4000 (prepaid order)</span>
        </div>
    </div>

    <!-- ══════════ MAIN HEADER ══════════ -->
    <header class="main-header">
        <div class="header-top-row">
            <!-- Left: Review Pill (desktop) / Menu button (mobile) -->
            <div class="header-review-pill-container">
                <button class="mobile-menu-toggle" aria-label="Open menu" id="openMobileMenu">
                    <i class="fas fa-bars" style="font-size:24px"></i>
                </button>
                <div class="header-review-pill">
                    <img src="https://ui-avatars.com/api/?name=Swetha+Reddy&background=random" alt="Swetha Reddy">
                    <span>Swetha Reddy</span>
                    <span style="color: #ddd">|</span>
                    <div class="stars">
                        <i class="fas fa-star" style="font-size:12px;color:#c4993f"></i> 5
                    </div>
                    <span class="review-text">The fabric feels soft and premium.</span>
                </div>
            </div>

            <!-- Center: Logo -->
            <div class="header-logo">
                <a href="/">
                    <img src="https://pawarhandloom.com/public/frontend/img/logo.png" alt="Pawar Handloom">
                </a>
            </div>

            <!-- Right: Actions -->
            <div class="header-actions-container">
                <div class="header-actions">
                    <div class="header-search">
                        <i class="fas fa-search" style="font-size:16px"></i>
                        <input type="text" placeholder="Search Lehenga, Saree..." style="border:none;outline:none;font-size:13px;flex:1">
                    </div>
                    <a href="<?= base_url('cart') ?>" style="position: relative;">
                        <i class="fas fa-shopping-bag" style="font-size:20px"></i>
                        <span class="cart-badge">0</span>
                    </a>
                    <a href="#"><i class="far fa-heart" style="font-size:20px"></i></a>
                    <div class="user-dropdown">
                        <a href="#"><i class="far fa-user" style="font-size:20px"></i></a>
                        <ul class="user-dropdown-menu">
                            <li><a href="<?= base_url('register') ?>">Resellers Register</a></li>
                            <li><a href="<?= base_url('login') ?>">Reseller Login</a></li>
                            <li><a href="<?= base_url('CustomerRegister') ?>">Customer Register</a></li>
                            <li><a href="<?= base_url('CustomerLogin') ?>">Customer Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Row -->
        <div class="header-nav-row">
            <nav>
                <ul class="main-nav">
                    <li><a href="<?= base_url('shop/6') ?>">New Arrival</a></li>
                    <li><a href="<?= base_url('shop/7') ?>">Best Seller</a></li>
                    <li><a href="#">Same Day Dispatch</a></li>
                    <li>
                        <span class="nav-badge-new">(NEW)</span>
                        <a href="<?= base_url('shop/2') ?>">Lehenga</a>
                    </li>
                    <li><a href="<?= base_url('shop/3') ?>">Suit Sets</a></li>
                    <li><a href="<?= base_url('shop/3') ?>">Dresses</a></li>
                    <li><a href="<?= base_url('shop/2') ?>">Shop All</a></li>
                    <li>
                        <a href="#">Shop by Collection <i class="fas fa-chevron-down" style="font-size:14px;margin-top:2px"></i></a>
                        <ul class="dropdown">
                            <li><a href="<?= base_url('shop/2') ?>">Sarees <i class="fas fa-chevron-right" style="float:right;margin-top:3px;font-size:12px"></i></a>
                                <ul class="sub-dropdown">
                                    <li><a href="<?= base_url('shop/2/1') ?>">Maheshwari Sarees</a></li>
                                    <li><a href="<?= base_url('shop/2/2') ?>">Chanderi Sarees</a></li>
                                    <li><a href="<?= base_url('shop/2/3') ?>">Handblock Printed Sarees</a></li>
                                    <li><a href="<?= base_url('shop/2/5') ?>">Pure Cotton Sarees</a></li>
                                </ul>
                            </li>
                            <li><a href="<?= base_url('shop/3') ?>">Dress material <i class="fas fa-chevron-right" style="float:right;margin-top:3px;font-size:12px"></i></a>
                                <ul class="sub-dropdown">
                                    <li><a href="<?= base_url('shop/3/6') ?>">Maheshwari Dress Material</a></li>
                                    <li><a href="<?= base_url('shop/3/7') ?>">Chanderi Dress Material</a></li>
                                    <li><a href="<?= base_url('shop/3/8') ?>">HandBlock Dress Material</a></li>
                                    <li><a href="<?= base_url('shop/3/9') ?>">Pure Cotton Dress Material</a></li>
                                </ul>
                            </li>
                            <li><a href="<?= base_url('shop/4') ?>">Stoles/Dupatta</a></li>
                            <li><a href="<?= base_url('shop/6') ?>">New Arrivals</a></li>
                            <li><a href="<?= base_url('shop/7') ?>">Best Sellers</a></li>
                            <li><a href="<?= base_url('shop/8') ?>">Celebs Look</a></li>
                        </ul>
                    </li>
                    <li><a href="#" style="color: #ac4024"><i class="fas fa-leaf" style="margin-right:4px;font-size:14px"></i> Offers</a></li>
                    <li><a href="#" style="color: #ac4024"><i class="fas fa-star" style="margin-right:4px;font-size:14px"></i> Sale</a></li>
                    <li><a href="<?= base_url('about') ?>">About</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ══════════ MOBILE NAV ══════════ -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay" style="display:none"></div>
    <div class="mobile-nav" id="mobileNav" style="display:none">
        <div class="mobile-nav-head">
            <img src="https://pawarhandloom.com/public/frontend/img/logo.png" alt="Pawar Handloom">
            <button aria-label="Close menu" id="closeMobileMenu" style="background:none;border:none;cursor:pointer;">
                <i class="fas fa-times" style="font-size:24px"></i>
            </button>
        </div>
        <div class="mobile-nav-search">
            <i class="fas fa-search" style="font-size:16px"></i>
            <input type="text" placeholder="Search Lehenga, Saree..." style="border:none;outline:none;font-size:13px;flex:1">
        </div>
        <ul>
            <li><a href="<?= base_url('shop/6') ?>">New Arrival</a></li>
            <li><a href="<?= base_url('shop/7') ?>">Best Seller</a></li>
            <li><a href="#">Same Day Dispatch</a></li>
            <li><a href="<?= base_url('shop/2') ?>">Lehenga <span class="mobile-nav-badge">NEW</span></a></li>
            <li><a href="<?= base_url('shop/3') ?>">Suit Sets</a></li>
            <li><a href="<?= base_url('shop/3') ?>">Dresses</a></li>
            <li><a href="<?= base_url('shop/2') ?>">Shop All</a></li>
            <li><a href="#" class="mobile-nav-highlight">Offers</a></li>
            <li><a href="#" class="mobile-nav-highlight">Sale</a></li>
            <li><a href="<?= base_url('about') ?>">About Us</a></li>
            <li><a href="<?= base_url('gallery') ?>">Gallery</a></li>
            <li><a href="<?= base_url('contact') ?>">Contact</a></li>
            <li><a href="<?= base_url('Review') ?>">Review</a></li>
        </ul>
        <div class="mobile-nav-account">
            <a href="<?= base_url('CustomerLogin') ?>">Customer Login</a>
            <a href="<?= base_url('CustomerRegister') ?>">Customer Register</a>
            <a href="<?= base_url('login') ?>">Reseller Login</a>
            <a href="<?= base_url('register') ?>">Resellers Register</a>
        </div>
    </div>

    <!-- ══════════ HERO SECTION ══════════ -->
    <section class="hero-slider" id="heroSlider" style="cursor: grab">
        <div class="hero-slider-track" id="heroTrack">
            <div class="hero-slide">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?= base_url('frontend/clone-assets/pawar-handloom-3.png') ?>">
                    <img src="<?= base_url('frontend/clone-assets/hero-desktop-1.png') ?>" alt="Slide 1" class="hero-slide-img" draggable="false">
                </picture>
            </div>
            <div class="hero-slide">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?= base_url('frontend/clone-assets/pawar-handloom-2.png') ?>">
                    <img src="<?= base_url('frontend/clone-assets/hero-desktop-2.png') ?>" alt="Slide 2" class="hero-slide-img" draggable="false">
                </picture>
            </div>
            <div class="hero-slide">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?= base_url('frontend/clone-assets/whatsapp-image.jpeg') ?>">
                    <img src="<?= base_url('frontend/clone-assets/hero-desktop-3.png') ?>" alt="Slide 3" class="hero-slide-img" draggable="false">
                </picture>
            </div>
        </div>
        <button class="slider-nav-btn prev-btn" id="heroPrev"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-nav-btn next-btn" id="heroNext"><i class="fas fa-chevron-right"></i></button>
    </section>

    <!-- ══════════ SHOP BY OCCASION ══════════ -->
    <section class="shop-by-occasion-section">
        <div class="sbo-header">
            <h2 class="sbo-title">Shop by Occasion</h2>
            <a href="#" class="sbo-view-all">View All <i class="fas fa-arrow-up-right-from-square" style="font-size:16px;margin-bottom:2px"></i></a>
        </div>
        <div class="sbo-tabs">
            <button class="sbo-tab active">Lehenga</button>
            <button class="sbo-tab">Suit Sets</button>
            <button class="sbo-tab">Dresses</button>
        </div>
        <div class="sbo-grid">
            <?php
            $occasions = [
                ['name' => 'Wedding', 'styles' => '97 Styles', 'img' => 'https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg'],
                ['name' => 'Reception', 'styles' => '81 Styles', 'img' => 'https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg'],
                ['name' => 'Haldi', 'styles' => '17 Styles', 'img' => 'https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg'],
                ['name' => 'Mehendi', 'styles' => '24 Styles', 'img' => 'https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg'],
            ];
            foreach ($occasions as $occ): ?>
            <div class="sbo-card">
                <img src="<?= $occ['img'] ?>" alt="<?= $occ['name'] ?>" class="sbo-card-img" loading="lazy">
                <div class="sbo-card-overlay"></div>
                <div class="sbo-card-icon"><i class="fas fa-arrow-up-right-from-square" style="font-size:18px"></i></div>
                <div class="sbo-card-content">
                    <h3><?= $occ['name'] ?></h3>
                    <p><?= $occ['styles'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ══════════ COUPONS ══════════ -->
    <section class="coupons-section">
        <?php $coupons = [['discount'=>'7%','code'=>'B2G7'],['discount'=>'₹5%','code'=>'BKFIRST'],['discount'=>'10%','code'=>'B3G10']]; ?>
        <?php foreach ($coupons as $c): ?>
        <div class="coupon-ticket">
            <div class="coupon-left">
                <span>FLAT <strong class="discount-amount"><?= $c['discount'] ?></strong> OFF*</span>
            </div>
            <div class="coupon-divider"></div>
            <div class="coupon-right">
                <span class="use-code">USE CODE:</span>
                <div class="coupon-code"><?= $c['code'] ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ SUB-CATEGORY ICONS ══════════ -->
    <section class="subcategory-icons">
        <?php
        $subcats = [
            ['name'=>'Pure Silk Cotton Sarees','img'=>'saree-icon.avif'],
            ['name'=>'Pure Silk Sarees','img'=>'saree-icon.avif'],
            ['name'=>'Pure Tissue Saree','img'=>'saree-icon.avif'],
            ['name'=>'Pure Organza Saree','img'=>'saree-icon.avif'],
            ['name'=>'Pure Mulberry','img'=>'saree-icon.avif'],
        ];
        foreach ($subcats as $cat): ?>
        <a href="#" class="subcategory-item">
            <img src="<?= base_url('frontend/clone-assets/'.$cat['img']) ?>" alt="<?= $cat['name'] ?>">
            <span><?= $cat['name'] ?></span>
        </a>
        <?php endforeach; ?>
    </section>

    <!-- ══════════ NEW ARRIVALS ══════════ -->
    <section class="new-arrivals-section">
        <div class="section-header">
            <h2>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                <span style="color: #ac4024">New Arrivals</span>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="product-grid">
            <?php
            $newArrivals = [
                ['name'=>'Pure Maheshwari Silver zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg','original'=>'4,500.00','sale'=>'4,050.00','discount'=>'10% OFF'],
                ['name'=>'Pure Maheshwari golden zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg','original'=>'3,000.00','sale'=>'2,700.00','discount'=>'10% OFF'],
                ['name'=>'Pure Maheshwari silver zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg','original'=>'2,750.00','sale'=>'2,475.00','discount'=>'10% OFF'],
                ['name'=>'Pure Chanderi silk cotton...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
            ];
            foreach ($newArrivals as $product): ?>
            <div class="product-card">
                <div class="product-card-media">
                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="product-card-img" loading="lazy">
                    <span class="product-card-badge">NEW</span>
                    <button type="button" class="product-card-wishlist" aria-label="Add to wishlist">
                        <i class="far fa-heart" style="font-size:26px"></i>
                    </button>
                </div>
                <div class="product-card-body">
                    <div class="product-card-meta">
                        <span class="product-card-ship">
                            <i class="fas fa-truck" style="font-size:18px"></i> Ready to Ship
                        </span>
                    </div>
                    <h4 class="product-card-name" title="<?= $product['name'] ?>"><?= $product['name'] ?></h4>
                    <div class="product-card-footer">
                        <div class="product-card-pricing">
                            <p class="product-card-price">
                                ₹<?= str_replace('.00','',$product['sale']) ?>
                                <span class="original">₹<?= str_replace('.00','',$product['original']) ?></span>
                                <span class="off"><?= $product['discount'] ?></span>
                            </p>
                        </div>
                        <button type="button" class="product-card-cart" aria-label="Add to cart">
                            <i class="fas fa-shopping-cart" style="font-size:24px"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center;">
            <a href="<?= base_url('shop/6') ?>" class="btn-view-all">VIEW ALL</a>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ SHOP BY CATEGORY ══════════ -->
    <section class="shop-category-section">
        <div class="section-header">
            <h2 class="dark">
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                Shop By Category
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="product-grid">
            <?php
            $categories = [
                ['name'=>'Maheshwari Sarees','img'=>'shop-category-1.png'],
                ['name'=>'Chanderi Sarees','img'=>'shop-category-2.png'],
                ['name'=>'Handblock Printed Sarees','img'=>'shop-category-3.png'],
                ['name'=>'Pure Cotton Sarees','img'=>'shop-category-4.png'],
            ];
            foreach ($categories as $cat): ?>
            <div class="category-card">
                <img src="<?= base_url('frontend/clone-assets/card-ornament.png') ?>" alt="" class="card-top-right-ornament">
                <img src="<?= base_url('frontend/clone-assets/'.$cat['img']) ?>" alt="<?= $cat['name'] ?>" class="category-card-img">
                <h4><?= $cat['name'] ?></h4>
                <a href="#" class="btn-details">DETAILS</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ DRESS MATERIALS ══════════ -->
    <section class="dress-materials-section">
        <div class="section-header">
            <h2>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                <span style="color: #333">Dress Materials</span>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="product-grid">
            <?php
            $dressItems = [
                ['name'=>'Maheshwari Bagh Suits','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383012_433d62525d79e078b558.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
                ['name'=>'Dress Material','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383095_26fdba15a2226f5bb2ad.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
                ['name'=>'Dress Material','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383177_1e6bdc13ee56da5dfa1e.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
                ['name'=>'Dress Material','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383264_e91a36f61bfd24b09aaf.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
            ];
            foreach ($dressItems as $product): ?>
            <div class="product-card">
                <div class="product-card-media">
                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="product-card-img" loading="lazy">
                    <button type="button" class="product-card-wishlist" aria-label="Add to wishlist">
                        <i class="far fa-heart" style="font-size:26px"></i>
                    </button>
                </div>
                <div class="product-card-body">
                    <h4 class="product-card-name" title="<?= $product['name'] ?>"><?= $product['name'] ?></h4>
                    <div class="product-card-footer">
                        <div class="product-card-pricing">
                            <p class="product-card-price">
                                ₹<?= str_replace('.00','',$product['sale']) ?>
                                <span class="original">₹<?= str_replace('.00','',$product['original']) ?></span>
                                <span class="off"><?= $product['discount'] ?></span>
                            </p>
                        </div>
                        <button type="button" class="product-card-cart" aria-label="Add to cart">
                            <i class="fas fa-shopping-cart" style="font-size:24px"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="text-align: center;">
            <a href="<?= base_url('shop/3') ?>" class="btn-view-all">VIEW ALL</a>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ BEST SELLERS ══════════ -->
    <section class="best-sellers-section">
        <div class="section-header">
            <h2 class="dark">
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                Best Sellers
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="product-grid">
            <?php
            $bestSellers = [
                ['name'=>'Pure Maheshwari Silver zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg','original'=>'4,500.00','sale'=>'4,050.00','discount'=>'10% OFF'],
                ['name'=>'Pure Maheshwari golden zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg','original'=>'3,000.00','sale'=>'2,700.00','discount'=>'10% OFF'],
                ['name'=>'Pure Maheshwari silver zari...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg','original'=>'2,750.00','sale'=>'2,475.00','discount'=>'10% OFF'],
                ['name'=>'Pure Chanderi silk cotton...','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg','original'=>'2,500.00','sale'=>'2,250.00','discount'=>'10% OFF'],
            ];
            foreach ($bestSellers as $product): ?>
            <div class="product-card">
                <div class="product-card-media">
                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="product-card-img" loading="lazy">
                    <span class="product-card-badge">BESTSELLER</span>
                    <button type="button" class="product-card-wishlist" aria-label="Add to wishlist">
                        <i class="far fa-heart" style="font-size:26px"></i>
                    </button>
                </div>
                <div class="product-card-body">
                    <h4 class="product-card-name" title="<?= $product['name'] ?>"><?= $product['name'] ?></h4>
                    <div class="product-card-footer">
                        <div class="product-card-pricing">
                            <p class="product-card-price">
                                ₹<?= str_replace('.00','',$product['sale']) ?>
                                <span class="original">₹<?= str_replace('.00','',$product['original']) ?></span>
                                <span class="off"><?= $product['discount'] ?></span>
                            </p>
                        </div>
                        <button type="button" class="product-card-cart" aria-label="Add to cart">
                            <i class="fas fa-shopping-cart" style="font-size:24px"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ SEE IT. LOVE IT. OWN IT. ══════════ -->
    <section class="see-it-love-it-section">
        <div class="section-header">
            <h2 class="dark" style="font-style: italic">
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                See It. Love It. Own It.
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="product-grid">
            <?php
            $seeItLoveIt = [
                ['name'=>'Maheshwari Heavy Pallu Saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375798_4a24f6b2ccfcdd56abf1.jpeg','original'=>'10,000.00','sale'=>'9,000.00','discount'=>'10% OFF'],
                ['name'=>'Maheshwari saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756375914_dcd3fc95eed16a8fea82.jpeg','original'=>'7,500.00','sale'=>'6,750.00','discount'=>'10% OFF'],
                ['name'=>'Maheshwari Pure Mullbery Silk Saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376053_d5b3322b97f4c6e66e51.jpeg','original'=>'22,000.00','sale'=>'19,800.00','discount'=>'10% OFF'],
                ['name'=>'Silver Boarder Saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756376180_d75d56b44f97e3e6e68e.jpeg','original'=>'6,300.00','sale'=>'5,670.00','discount'=>'10% OFF'],
                ['name'=>'Maheshwari Saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383012_433d62525d79e078b558.jpeg','original'=>'5,700.00','sale'=>'5,130.00','discount'=>'10% OFF'],
                ['name'=>'Maheshwari saree','img'=>'https://pawarhandloom.com/public/uploads/products/cover/1756383095_26fdba15a2226f5bb2ad.jpeg','original'=>'5,800.00','sale'=>'5,220.00','discount'=>'10% OFF'],
            ];
            foreach ($seeItLoveIt as $product): ?>
            <div class="product-card">
                <div class="product-card-media">
                    <img src="<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="product-card-img" loading="lazy">
                    <button type="button" class="product-card-wishlist" aria-label="Add to wishlist">
                        <i class="far fa-heart" style="font-size:26px"></i>
                    </button>
                </div>
                <div class="product-card-body">
                    <h4 class="product-card-name" title="<?= $product['name'] ?>"><?= $product['name'] ?></h4>
                    <div class="product-card-footer">
                        <div class="product-card-pricing">
                            <p class="product-card-price">
                                ₹<?= str_replace('.00','',$product['sale']) ?>
                                <span class="original">₹<?= str_replace('.00','',$product['original']) ?></span>
                                <span class="off"><?= $product['discount'] ?></span>
                            </p>
                        </div>
                        <button type="button" class="product-card-cart" aria-label="Add to cart">
                            <i class="fas fa-shopping-cart" style="font-size:24px"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ CELEBS LOOK ══════════ -->
    <section class="celebs-look-section">
        <div class="section-header">
            <h2>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament" alt="Ornament">
                <span style="color: #ac4024">Celebs Look</span>
                <img src="<?= base_url('frontend/clone-assets/section-title-ornament.png') ?>" class="section-ornament is-reverse" alt="Ornament">
            </h2>
        </div>
        <div class="celebs-grid">
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="celebs-card">
                <img src="<?= base_url('frontend/clone-assets/card-ornament.png') ?>" alt="" class="card-top-right-ornament">
                <img src="https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg" alt="Celebs <?= $i+1 ?>">
            </div>
            <?php endfor; ?>
        </div>
        <div style="text-align: center;">
            <a href="<?= base_url('shop/8') ?>" class="btn-view-all">VIEW ALL</a>
        </div>
    </section>

    <!-- ══════════ FLORAL DIVIDER ══════════ -->
    <div class="floral-divider-container">
        <div class="floral-line"></div>
        <div class="floral-icon-wrapper">
            <img src="<?= base_url('frontend/clone-assets/divider-ornament.png') ?>" alt="Ornament" class="divider-ornament-img">
        </div>
        <div class="floral-line"></div>
    </div>

    <!-- ══════════ ABOUT US ══════════ -->
    <section class="about-section">
        <div class="about-text">
            <h2>Pawar Handloom</h2>
            <p>
                Explore our exquisite collection of Maheshwari, Chanderi and Handblock Printed Sarees and Dress Material inspired by the royal heritage weaves of Madhya Pradesh, India.
            </p>
            <p>
                Pawar Handloom is our ancestry brand from 5th generation. I am Piyush Kailash N.K. Pawar extended my 5th ancestral business to the next level. Initially my great great grandfather brought by Former Queen of Malwa kingdom Ahilya Mata as an artisian to Maheshwar. Back then my grandfather named "Mr. Nathusa Kevalram Pawar" established "Pawar Handloom" as a traditional clothing brand of Maheshwari &amp; Induri Sarees since 90 years back in Maheshwar, Madhya Pradesh.
            </p>
            <a href="<?= base_url('about') ?>" class="btn-read-more">
                💬 READ MORE
            </a>
        </div>
        <div class="about-image">
            <img src="<?= base_url('frontend/clone-assets/ahilyafort.jpg.jpeg') ?>" alt="Ahilya Fort, Maheshwar">
        </div>
    </section>

    <!-- ══════════ FEATURES BAR MARQUEE ══════════ -->
    <section class="features-bar-marquee">
        <div class="marquee-container-horizontal">
            <div class="marquee-content-horizontal">
                <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="marquee-group-horizontal">
                    <div class="feature-marquee-item">Handcrafted in Maheshwar</div>
                    <div class="feature-marquee-item"><i class="fas fa-truck"></i> Free Shipping across india</div>
                    <div class="feature-marquee-item"><i class="fas fa-ticket-alt"></i> COD Available</div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- ══════════ CUSTOMER REVIEWS ══════════ -->
    <section class="customer-reviews-section">
        <div class="customer-reviews-header">
            <div>
                <h2 class="customer-reviews-title">What Our Customer Say!</h2>
                <p class="customer-reviews-subtitle">250+ style ready to dispatch</p>
            </div>
            <a href="#" class="sbo-view-all" style="border-bottom:none">
                View All <i class="fas fa-arrow-up-right-from-square" style="font-size:16px"></i>
            </a>
        </div>
        <div class="customer-reviews-grid">
            <?php
            $reviews = [
                ['name'=>'Snigdha Agrawal','text'=>'"The colours, fabric quality, and detailing were beautiful, and it looked stunning in photos."','product'=>'Indira Vastra | Soft Silk Lehenga Set'],
                ['name'=>'Ram Sujitha','text'=>'"The fabric feels so premium, and everyone at the family event praised it. Best purchase of the year."','product'=>'Patti Rani Pink Madhubala Lehenga Set'],
                ['name'=>'Anugraha Sudheer','text'=>'"The lehenga was very beautiful. Very comfortable as well as very pretty."','product'=>'Maharani Red Lehenga Set'],
                ['name'=>'Megha Premkumar','text'=>'"I just love this brand, you guys are my saviours. Whenever I wear their dresses, I get lots of compliments."','product'=>'Nishkala Gadval Lime Lehenga Set'],
            ];
            foreach ($reviews as $review): ?>
            <div class="review-card">
                <img src="<?= base_url('frontend/clone-assets/card-ornament.png') ?>" alt="" class="card-top-right-ornament">
                <div class="review-card-img-wrapper">
                    <img src="https://pawarhandloom.com/public/uploads/admin/products/1751543071_1c1d8cc322bd2a538a0a.jpg" alt="<?= $review['name'] ?>" class="review-card-img" loading="lazy">
                    <div class="review-card-stars-overlay">
                        <i class="fas fa-star" style="color:#c4993f;font-size:16px"></i>
                        <i class="fas fa-star" style="color:#c4993f;font-size:16px"></i>
                        <i class="fas fa-star" style="color:#c4993f;font-size:16px"></i>
                        <i class="fas fa-star" style="color:#c4993f;font-size:16px"></i>
                        <i class="fas fa-star" style="color:#c4993f;font-size:16px"></i>
                    </div>
                </div>
                <div class="review-card-content">
                    <h3 class="review-card-name"><?= $review['name'] ?></h3>
                    <p class="review-card-text"><?= $review['text'] ?></p>
                    <p class="review-card-product"><?= $review['product'] ?></p>
                    <p class="review-card-verified">
                        <i class="fas fa-check-circle" style="color:#22c55e;font-size:14px"></i> Verified Buyer
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ══════════ OUR REVIEWS ══════════ -->
    <section class="reviews-section">
        <h2>Our Reviews</h2>
        <div class="review-logos-container">
            <div class="review-logos">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg" alt="Google Reviews">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_%282019%29.png" alt="Facebook Reviews">
                <span class="review-logo-justdial">Justdial</span>
                <span class="review-logo-indiamart">indiamart</span>
            </div>
        </div>
    </section>

    <!-- ══════════ FOOTER ══════════ -->
    <footer class="footer-new">
        <div class="footer-top-grid">
            <div class="footer-col footer-brand">
                <img src="https://pawarhandloom.com/public/frontend/img/logo.png" alt="Pawar Handloom" class="footer-logo">
                <p class="footer-tagline">Handwoven sarees &amp; suits straight from the looms of Maheshwar, Madhya Pradesh.</p>
                <ul class="footer-contact-list">
                    <li><i class="fas fa-phone" style="font-size:15px"></i> <span>(+91) 9630504663 <em>WhatsApp</em><br>(+91) 9039119245 <em>Call</em></span></li>
                    <li><i class="fas fa-envelope" style="font-size:15px"></i> <a href="mailto:support@pawarhandloom.com">support@pawarhandloom.com</a></li>
                    <li><i class="fas fa-map-marker-alt" style="font-size:15px"></i> <span>Pawar Handloom, Maheshwar, Madhya Pradesh - 451224</span></li>
                </ul>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook" style="font-size:16px"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram" style="font-size:16px"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube" style="font-size:16px"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>DESIGNER WEAR</h4>
                <ul>
                    <li><a href="<?= base_url('shop/6') ?>">New Arrival</a></li>
                    <li><a href="#">Same Day Dispatch</a></li>
                    <li><a href="<?= base_url('shop/2') ?>">Lehenga</a></li>
                    <li><a href="<?= base_url('shop/3') ?>">Suit Sets</a></li>
                    <li><a href="<?= base_url('shop/3') ?>">Dresses</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>MY ACCOUNT</h4>
                <ul>
                    <li><a href="#">My Account</a></li>
                    <li><a href="<?= base_url('register') ?>">Register</a></li>
                    <li><a href="<?= base_url('login') ?>">Login</a></li>
                    <li><a href="#">View Order</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>CUSTOMER SERVICE</h4>
                <ul>
                    <li><a href="#">Terms &amp; Condition</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Return &amp; Exchange Policy</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>INFORMATION</h4>
                <ul>
                    <li><a href="#">Blogs</a></li>
                    <li><a href="<?= base_url('about') ?>">About Us</a></li>
                    <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                    <li><a href="#">Wholesale Inquiry</a></li>
                    <li><a href="#">Franchise Inquiry</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-watermark">Pawar Handloom</div>
        <div class="footer-copyright">ALL RIGHTS RESERVED. © PAWAR HANDLOOM 2026.</div>
    </footer>

    <!-- ══════════ FLOATING ELEMENTS ══════════ -->
    <a href="https://wa.me/919630504663" class="float-whatsapp" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp" style="font-size:28px"></i>
    </a>
    <a href="tel:+919630504663" class="float-call">
        <i class="fas fa-phone" style="font-size:16px"></i> Call Now
    </a>

    <!-- Scroll to top -->
    <button class="scroll-top" id="scrollTopBtn" style="display:none">
        <i class="fas fa-chevron-up" style="font-size:20px"></i>
    </button>
</div>

<!-- ══════════ JAVASCRIPT ══════════ -->
<script>
// Hero Slider
(function() {
    let currentSlide = 0;
    const track = document.getElementById('heroTrack');
    const totalSlides = 3;

    function goToSlide(n) {
        currentSlide = ((n % totalSlides) + totalSlides) % totalSlides;
        track.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';
    }

    document.getElementById('heroPrev').addEventListener('click', function() { goToSlide(currentSlide - 1); });
    document.getElementById('heroNext').addEventListener('click', function() { goToSlide(currentSlide + 1); });

    // Auto-advance
    setInterval(function() { goToSlide(currentSlide + 1); }, 4000);

    // Touch/swipe support
    let touchStart = null, touchEnd = null;
    const slider = document.getElementById('heroSlider');
    slider.addEventListener('touchstart', function(e) { touchStart = e.changedTouches[0].clientX; touchEnd = null; });
    slider.addEventListener('touchend', function(e) {
        touchEnd = e.changedTouches[0].clientX;
        if (touchStart !== null && touchEnd !== null) {
            const diff = touchStart - touchEnd;
            if (diff > 50) goToSlide(currentSlide + 1);
            else if (diff < -50) goToSlide(currentSlide - 1);
        }
        touchStart = null; touchEnd = null;
    });
})();

// Mobile Menu
document.getElementById('openMobileMenu').addEventListener('click', function() {
    document.getElementById('mobileNav').style.display = 'block';
    document.getElementById('mobileNavOverlay').style.display = 'block';
    document.body.style.overflow = 'hidden';
});
document.getElementById('closeMobileMenu').addEventListener('click', closeMobileMenu);
document.getElementById('mobileNavOverlay').addEventListener('click', closeMobileMenu);
function closeMobileMenu() {
    document.getElementById('mobileNav').style.display = 'none';
    document.getElementById('mobileNavOverlay').style.display = 'none';
    document.body.style.overflow = '';
}

// Scroll to top
window.addEventListener('scroll', function() {
    document.getElementById('scrollTopBtn').style.display = window.scrollY > 400 ? 'flex' : 'none';
});
document.getElementById('scrollTopBtn').addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Wishlist toggle
document.querySelectorAll('.product-card-wishlist').forEach(function(btn) {
    btn.addEventListener('click', function() {
        this.classList.toggle('is-active');
        var icon = this.querySelector('i');
        if (this.classList.contains('is-active')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
        }
    });
});

// Shop by Occasion tabs
document.querySelectorAll('.sbo-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.sbo-tab').forEach(function(t) { t.classList.remove('active'); });
        this.classList.add('active');
    });
});
</script>
</body>
</html>
