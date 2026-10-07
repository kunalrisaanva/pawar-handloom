  <style>



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
    
   <div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/shop.jpg');?>">
      <div class="container">
        <h1>Our Reviews</h1>
      </div>
    </div>


<div class="" style="margin-top: 50px;">
    <div class="container" style="max-width: 1200px;">
  <div class="" style="margin-bottom: 20px;">
<!-- <span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<p>< ?= $averageRating ?> average based on < ?= $totalReviews ?> reviews.</p> -->
<?php
$avg = $averageRating; 
$fullStars = floor($avg); 
$halfStar  = ($avg - $fullStars >= 0.5) ? 1 : 0;
$emptyStars = 5 - ($fullStars + $halfStar);
?>

<!-- Dynamic Stars -->
    <?php for ($i = 0; $i < $fullStars; $i++): ?>
        <span class="fa fa-star checked"></span>
    <?php endfor; ?>

    <?php if ($halfStar): ?>
        <span class="fa fa-star-half-o checked"></span>
    <?php endif; ?>

    <?php for ($i = 0; $i < $emptyStars; $i++): ?>
        <span class="fa fa-star"></span>
    <?php endfor; ?>
<p>

    <?= $averageRating ?> average based on <?= $totalReviews ?> reviews.
</p>

<hr style="border:3px solid #f1f1f1">

<div class="row">

 <div class="col-md-9">
  <?php for ($i = 5; $i >= 1; $i--): ?>

    <div class="side">
        <div><?= $i ?>  star</div>
      </div>
      <div class="middle">
        <div class="bar-container">
            <?php 
                  $percent = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0;
                ?>
            <div class="bar-<?= $i ?>" style="width: <?= $percent ?>%;"></div>
        </div>
      </div>
      <div class="side right">
        <div> <?= $ratingCounts[$i] ?></div>
      </div>
  <?php endfor; ?>    
</div>
  <!-- <div class="col-md-9">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div> 150</div>
  </div>
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div> 63</div>
  </div>
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div> 15</div>
  </div>
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div> 6</div>
  </div>
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div> 20</div>
  </div>
</div> -->
 <div class="col-md-3" style="margin-top: 20px;">
    <button id="toggleButton" class="ps-btn ps-btn--outline ps-btn--white">Write a Store Review</button>
    
  </div>
 </div>
<div class="row">
  <div id="myDiv" style="display: none;">
<div>
              <div class="ps-product--detail" style="margin-top: 2rem;">
        <div class="container" style="  display: flex;
  justify-content: center;">    
        <div class="wrapper">
            <!--Fleash Review Message-->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin:20px 0;">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin:20px 0;">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!--Fleash Review Message end-->
          
            <h3>Write a Store review</h3>
            <form action="<?= base_url('/review/save'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_id" 
       value="<?= (session()->has('is_logged_in')) ? session()->get('user_id') : '0'; ?>">


              <span>Rating</span>
              <div class="rating">
                
                <input type="number" name="rating" hidden>
                <i class='bx bx-star star' style="--i: 0;"></i>
                <i class='bx bx-star star' style="--i: 1;"></i>
                <i class='bx bx-star star' style="--i: 2;"></i>
                <i class='bx bx-star star' style="--i: 3;"></i>
                <i class='bx bx-star star' style="--i: 4;"></i>
              </div>
              <input type="text" name="review_title[]" class="texts" placeholder="Review Title">
              <textarea name="review_text" cols="30" rows="5" placeholder="Review Content..."></textarea>

              <div class="main-wrapper">
        <div class="upload-main-wrapper">
                <div class="upload-wrapper">
                        <input type="file" name="review_image[]" id="upload-file" multiple>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid meet" viewBox="224.3881704980842 176.8527621722847 221.13266283524905 178.8472378277154" width="221.13" height="178.85"><defs><path d="M357.38 176.85C386.18 176.85 409.53 204.24 409.53 238.02C409.53 239.29 409.5 240.56 409.42 241.81C430.23 246.95 445.52 264.16 445.52 284.59C445.52 284.59 445.52 284.59 445.52 284.59C445.52 309.08 423.56 328.94 396.47 328.94C384.17 328.94 285.74 328.94 273.44 328.94C246.35 328.94 224.39 309.08 224.39 284.59C224.39 284.59 224.39 284.59 224.39 284.59C224.39 263.24 241.08 245.41 263.31 241.2C265.3 218.05 281.96 199.98 302.22 199.98C306.67 199.98 310.94 200.85 314.93 202.46C324.4 186.96 339.88 176.85 357.38 176.85Z" id="b1aO7LLtdW"></path><path d="M306.46 297.6L339.79 297.6L373.13 297.6L339.79 255.94L306.46 297.6Z" id="c4SXvvMdYD"></path><path d="M350.79 293.05L328.79 293.05L328.79 355.7L350.79 355.7L350.79 293.05Z" id="b11si2zUk"></path></defs><g><g><g><use xlink:href="#b1aO7LLtdW" opacity="1" fill="#ffffff" fill-opacity="1"></use></g><g><g><use xlink:href="#c4SXvvMdYD" opacity="1" fill="#363535" fill-opacity="1"></use></g><g><use xlink:href="#b11si2zUk" opacity="1" fill="#363535" fill-opacity="1"></use></g></g></g></g></svg>
                        <span class="file-upload-text">Upload File</span>
                        <div class="file-success-text">
                         <svg version="1.1" id="check" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 100 100"  xml:space="preserve">
                <circle style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-miterlimit:10;" cx="49.799" cy="49.746" r="44.757"/>
                <polyline style="fill:rgba(0,0,0,0);stroke:#ffffff;stroke-width:10;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="
                    27.114,51 41.402,65.288 72.485,34.205 "/>
                </svg>
              </div>
              </div>
                    <p id="file-upload-name"></p>
        </div>
    </div>

              <!-- <input type="file" name="review_image" class="texts"> -->
              <input type="text" name="YouTube_url" class="texts" placeholder="Youtube URL">
              <input type="text" name="name" class="texts" placeholder="Display name (displayed publicly like John Smith..)">
              <input type="text" name="email" class="texts" placeholder="Email Address">
              <div class="btn-group">
                <button type="submit" name="reviewShop" class="btn submit">Submit</button>
              </div>
            </form>
          </div>
          </div>
      </div>
            </div>
            </div>
</div>
</div>    
     
    </div>
    </div>

    <div class="">
    <div class="container" style="max-width: 1200px;">
      <div class="ps-product--detail">
        <div class="ps-product__content ps-tab-root">
          <!-- <ul class="ps-tab-list">
            <li class="active"><a href="#tab-1">Product Reviews(210)</a></li>
            <li class=""><a href="#tab-2">Shop Reviews(50)</a></li>
          </ul> -->
          <ul class="ps-tab-list">
            <li class="active">
              <a href="#tab-1">Product Reviews (<?= !empty($productReviews) ? count($productReviews) : 0 ?>)</a>
            </li>
            <li>
                <a href="#tab-2">Shop Reviews (<?= !empty($shopReviews) ? count($shopReviews) : 0 ?>)</a>
            </li>
          </ul>
          <div class="ps-tabs">
                     <!-- //Tab1 All Product review show -->
            <div class="ps-tab active" role="tabpanel" id="tab-1">
                <div class="row">
                  <?php if (!empty($productReviews)): foreach ($productReviews as $review): 
                    $images = !empty($review->review_images) ? explode(',', $review->review_images) : [];
                  ?>
                  <div class="col-md-4">
                    <div style="background:#fff;box-shadow:0px 0px 8px rgba(0,0,0,.5);padding:18px;border-radius:5px;margin:5px;">
                      
                      <?php if (!empty($images)): ?>
                      <div id="carouselReview_<?= $review->id ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                          <?php foreach ($images as $i=>$img): ?>
                          <div class="carousel-item <?= $i==0?'active':'' ?>">
                            <img src="<?= base_url('public/uploads/review_images/'.$img) ?>" class="w-100">
                          </div>
                          <?php endforeach; ?>
                        </div>
                        <?php if (count($images)>1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselReview_<?= $review->id ?>" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselReview_<?= $review->id ?>" data-bs-slide="next">
                          <span class="carousel-control-next-icon"></span>
                        </button>
                        <?php endif; ?>
                      </div>
                      <?php endif; ?>

                      <div class="ps-block__content">
                        <p style="font-size:12px;">About <a href="#">Product</a></p>
                        <!--<div class="br-widget">-->
                        <!--  < ?php for ($i=1;$i<=5;$i++): ?>-->
                        <!--    <a class="< ?= ($i <= $review->rating)?'br-selected br-current':'' ?>"></a>-->
                        <!--  < ?php endfor; ?>-->
                        <!--  <div class="br-current-rating">< ?= $review->rating ?></div>-->
                        <!--  < p style="float:right;font-size:12px;">< ?= date('d-m-Y', strtotime($review->created_at)) ?></p>-->
                        <!--</div>-->
                        <div class="br-wrapper br-theme-fontawesome-stars">
                          <div class="br-widget">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <a href="#" data-rating-value="<?= $i; ?>" class="<?= ($i <= $review->rating) ? 'br-selected br-current' : ''; ?>"></a>
                            <?php endfor; ?>
                            <div class="br-current-rating"><?= $review->rating; ?></div>
                            <p style="float: right;font-size: 12px;"><?= date('d-m-Y', strtotime($review->created_at)); ?></p>
                          </div>
                        </div>
                        <h5 style="font-size:12px;"><?= esc($review->name) ?></h5>
                        <h5 style="font-size:12px;"><?= esc($review->review_title) ?></h5>
                        <p style="font-size:12px;"><?= esc($review->review_text) ?></p>
                        <!-- <p><a href="#" class="like-btn" data-id="< ?= $review->id ?>"><i class="fa fa-thumbs-up"></i></a> <span id="like-count-< ?= $review->id ?>">< ? = $review->likes ?? 0 ?></span></p> -->
                        <p style="margin-bottom: 0px;">
                          <a href="javascript:void(0);" class="like-btn" data-id="<?= $review->id; ?>">
                            <i class="fa fa-thumbs-up"></i>
                          </a> 
                          <span id="like-count-<?= $review->id; ?>"><?= $review->likes ?? 0; ?></span>
                        </p>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; else: ?>
                    <p class="text-center">No product reviews yet.</p>
                  <?php endif; ?>
                </div>
              </div>
           
            <!-- //Tab1 All Product review show -->
            <!-- Tab2 all shop review show -->
            <div class="ps-tab" role="tabpanel" id="tab-2">
              <div class="row">
                <?php if (!empty($shopReviews)): foreach ($shopReviews as $review): 
                  $images = !empty($review->review_images) ? explode(',', $review->review_images) : [];
                ?>
                <div class="col-md-4">
                  <div style="background:#fff;box-shadow:0px 0px 8px rgba(0,0,0,.5);padding:18px;border-radius:5px;margin:5px;">
                    
                    <?php if (!empty($images)): ?>
                    <div id="carouselShopReview_<?= $review->id ?>" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                        <?php foreach ($images as $i=>$img): ?>
                        <div class="carousel-item <?= $i==0?'active':'' ?>">
                          <img src="<?= base_url('public/uploads/review_images/'.$img) ?>" class="w-100">
                        </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <div class="ps-block__content">
                      <p style="font-size:12px;">About Shop</p>
                      <!--<div class="br-widget">-->
                      <!--  < ?php for ($i=1;$i<=5;$i++): ?>-->
                      <!--    <a class="< ?= ($i <= $review->rating)?'br-selected br-current':'' ?>"></a>-->
                      <!--  < ?php endfor; ?>-->
                      <!--  <div class="br-current-rating"> < ?= $review->rating ?></div>-->
                      <!--  <p style="float:right;font-size:12px;">< ?= date('d-m-Y', strtotime($review->created_at)) ?></p>-->
                      <!--</div>-->
                        <div class="br-wrapper br-theme-fontawesome-stars">
                          <div class="br-widget">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <a href="#" data-rating-value="<?= $i; ?>" class="<?= ($i <= $review->rating) ? 'br-selected br-current' : ''; ?>"></a>
                            <?php endfor; ?>
                            <div class="br-current-rating"><?= $review->rating; ?></div>
                            <p style="float: right;font-size: 12px;"><?= date('d-m-Y', strtotime($review->created_at)); ?></p>
                          </div>
                        </div>
                      <h5 style="font-size:12px;"><?= esc($review->name) ?></h5>
                      <h5 style="font-size:12px;"><?= esc($review->review_title) ?></h5>
                      <p style="font-size:12px;"><?= esc($review->review_text) ?></p>
                      <!-- <p><a href="#" class="like-btn" data-id="< ?= $review->id ?>"><i class="fa fa-thumbs-up"></i></a> <span id="like-count-< ?= $review->id ?>">< ?= $review->likes ?? 0 ?></span></p> -->
                        <p style="margin-bottom: 0px;">
                          <a href="javascript:void(0);" class="like-btn" data-id="<?= $review->id; ?>">
                            <i class="fa fa-thumbs-up"></i>
                          </a> 
                          <span id="like-count-<?= $review->id; ?>"><?= $review->likes ?? 0; ?></span>
                        </p>
                    </div>
                  </div>
                </div>
                <?php endforeach; else: ?>
                  <p class="text-center">No shop reviews yet.</p>
                <?php endif; ?>
              </div>
            </div>
          <!-- //Tab2 all shop review show -->
        </div>
      </div>
    </div>
    </div>
    </div>


    