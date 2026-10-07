<footer class="ps-footer">
      <div class="ps-footer__content">
        <div class="container">
          <div class="row">
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 ">
              <a class="ps-logo" href="https://pawarhandloom.com/"><img src="<?= base_url('public/frontend/img/logo.png');?>" alt=""></a><hr>
              <p>Explore our exquisite collection of Maheshwari, Chanderi and Handblock Printed Sarees and Dress Material inspired by the royal heritage weaves of Madhya Pradesh, India.

              </p>
            </div>
           
            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12  ">
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-6 ">
                  <div class="widget widget_footer">
                    <h3 class="widget-title">Categories</h3>
                    <ul>
                      <li><a href="<?= base_url('/shop/2');?>">Sarees</a></li>
                      <li><a href="<?= base_url('/shop/3');?>">Dress Materials</a></li>
                      <li><a href="<?= base_url('/shop/4');?>">Stoles</a></li>
                      <li><a href="<?= base_url('/shop/4');?>">Dupattas</a></li>
                      
                    </ul>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 col-6 ">
                  <div class="widget widget_footer">
                    <h3 class="widget-title">Infomation</h3>
                    <ul>
                      <li><a href="<?= base_url('/about');?>">About Us</a></li>
                      <li><a href="<?= base_url('/contact');?>">Contact Us</a></li>
                      <li><a href="<?= base_url();?>">Terms & Conditions</a></li>
                      <li><a href="<?= base_url();?>">Returns & Exchanges</a></li>
                      <li><a href="#">Privacy Policy</a></li>
                    </ul>
                  </div>
                </div>

               
              </div>
            </div>
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12  ">
              <div class="ps-site-info">
                <h3 class="widget-title">Contact</h3>
                <figure>
                  <p><i class="pe-7s-map-marker"></i> 97-B, Ground Floor, Rishi Apartment, Rajendra Nagar, Indore 452012</p>
                  <p><i class="pe-7s-mail"></i><a href="#">info@pawarhandloom.com</span></a></p>
                  <p><i class="pe-7s-call"></i> +91 9630504663, 9039119245   </p>
                </figure>
                <ul class="ps-list--social" style="justify-content: center; background: #c39f48a6; padding: 10px; margin-top: 10px; border-radius: 10px;text-align:center;color:#777">
                  <li><a href="https://www.facebook.com/Official.PawarHandloom/"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="https://www.instagram.com/official_pawarhandloom/"><i class="fa fa-instagram"></i></a></li>
                  <li><a href="https://www.youtube.com/@pawarhandloombypiyush"><i class="fa fa-youtube-play"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ps-footer__copyright">
        <div class="container">
          <!--<div class="row">-->
          <!--  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">-->
          <!--    <p>Design By  <a href="#">Accren Technology</a></p>-->
          <!--  </div>-->
          <!--  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">-->
              
          <!--  </div>-->
          <!--</div>-->
        </div>
      </div>
    </footer>
   
    <div id="back2top"><i class="pe-7s-angle-up"></i></div>
    <a href="https://api.whatsapp.com/send?phone=919630924663&text=Hi, How may I help you?" class="float" target="_blank">
      <i class="fa fa-whatsapp my-float"></i>
      </a>
      <a href="tel:+919630924663" class="float-call" target="_blank">
          <i class="fa fa-phone my-float"></i><span style="padding-left: 5px;"><b>Call Now</b></span>
          </a>
    <div class="ps-site-overlay"></div>
    <!--<div id="loader-wrapper">-->
    <!--  <div class="loader-section section-left"></div>-->
    <!--  <div class="loader-section section-right"></div>-->
    <!--</div>-->
    <!--Search Product -->
        <!--<div class="ps-search" id="site-search"><a class="ps-btn--close" href="#"></a>
          <div class="ps-search__content">
            <form class="ps-form--primary-search" action="#" method="post">
              <input class="form-control" type="text" placeholder="Search for...">
              <button><i class="aroma-magnifying-glass"></i></button>
            </form>
          </div>
        </div>-->
    <div class="ps-search" id="site-search">
        <a class="ps-btn--close" href="#"></a>
    
        <div class="ps-search__content">
            <form class="ps-form--primary-search" action="javascript:void(0)">
                <input 
                    class="form-control" 
                    type="text" 
                    id="searchInput"
                    placeholder="Search for product, category..."
                    autocomplete="off"
                >
            </form>
    
            <!-- SEARCH RESULT -->
            <div id="searchResult"></div>
        </div>
    </div>

    
    <!--//Search Product-->
    <!--Old mini cart -->
      <!--< ?php
        $cart = session()->get("cart") ?? [];
        $totalItems = count($cart);
        $subTotal = 0;
      ? > -->

        <!--<div class="ps-cart--sidebar">
            <div class="ps-cart__header">
                <h3>Mini Cart</h3>
                <a class="ps-btn--close ps-btn--no-boder" href="#"></a>
            </div>
            <div class="ps-cart__content">
                <!-- < ?php echo"Cart :- <pre>";
                print_r($cart); ?> -->
                <!-- < ?php if ($totalItems > 0): ?>
                    < ?php foreach ($cart as $item): ?>
                        < ?php $subTotal += $item['offer_price'] * $item['qty']; ?>
                        <div class="ps-product--cart">
                            <div class="ps-product__thumbnail">
                                <a href="< ?= base_url('/detail'.$item['id']); ?>">
                                    <img src="< ?= base_url('public/' . $item['image']); ?>" alt="">
                                </a>
                                <a href="< ?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-sm btn-danger">  <span class="ps-btn--close ps-btn--no-boder remove-item" data-id="< ?= $item['id']; ?>"></span> </a>
                            </div>
                            <div class="ps-product__content">
                                <a href="< ?= base_url('/detail'.$item['id']); ?>">< ?= $item['product_name']; ?></a>
                                <span>< ?= $item['qty']; ?>x INR < ?= number_format($item['offer_price'], 2); ?></span>
                            </div>
                        </div>
                    < ?php endforeach; ?>
                < ?php else: ?>
                    <p>Your cart is empty.</p>
                < ?php endif; ?>
            </div>
            <div class="ps-cart__footer">
                <h4>SubTotal: <span>INR <   ?= number_format($subTotal, 2); ?></span></h4>
                <a class="ps-btn" href="<  ?= base_url('/cart'); ?>">View Cart</a>
                <a class="ps-btn" href="< ?= base_url('/checkout'); ?>">Checkout Now</a>
            </div>
        </div> -->
        <!--//Old Mini cart-->
        <!--New Mini cart-->
<?php
$cart = session()->get('cart') ?? [];
$subTotal = 0;
?>

<div class="ps-cart--sidebar">
    <div class="ps-cart__header">
        <h3>Mini Cart</h3>
        <a class="ps-btn--close ps-btn--no-boder" href="#"></a>
    </div>

    <div class="ps-cart__content">
        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $key => $item): ?>
                <?php
                    $price = (float) $item['offer_price'];
                    $qty   = (int) $item['qty'];
                    $subTotal += ($price * $qty);
                ?>

                <div class="ps-product--cart">
                    <div class="ps-product__thumbnail">
                        <a href="<?= base_url('detail/' . $item['id']); ?>">
                            <img src="<?= base_url('public/' . $item['image']); ?>" alt="">
                        </a>

                        <a href="javascript:void(0);"
                           class="ps-btn--close ps-btn--no-boder remove-item"
                           data-key="<?= esc($key); ?>"></a>
                    </div>

                    <div class="ps-product__content">
                        <a href="<?= base_url('detail/' . $item['id']); ?>">
                            <?= esc($item['product_name']); ?>
                        </a>

                        <?php if (!empty($item['color'])): ?>
                            <small>Color: <?= esc($item['color']); ?></small><br>
                        <?php endif; ?>

                        <span>
                            <?= $qty; ?> × INR <?= number_format($price, 2); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <div class="ps-cart__footer">
        <h4>
            SubTotal:
            <span id="miniCartSubtotal">
                INR <?= number_format($subTotal, 2); ?>
            </span>
        </h4>
        <a class="ps-btn" href="<?= base_url('cart'); ?>">View Cart</a>
        <a class="ps-btn" href="<?= base_url('checkout'); ?>">Checkout Now</a>
    </div>
</div>


        <!--//New Mini cart-->

    <script src="<?= base_url('public/frontend/plugins/jquery-1.12.4.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/owl-carousel/owl.carousel.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/popper.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/imagesloaded.pkgd.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/masonry.pkgd.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/isotope.pkgd.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/jquery.matchHeight-min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/slick/slick/slick.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/jquery-bar-rating/dist/jquery.barrating.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/slick-animation.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/lightGallery-master/dist/js/lightgallery-all.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/sticky-sidebar/dist/sticky-sidebar.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/plugins/YTPlayer/dist/jquery.mb.YTPlayer.min.js'); ?>"></script>
    <script src="<?= base_url('public/frontend/js/main.js'); ?>"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/frontend/js/zoomsl.js');?>"></script>
    <script src="<?= base_url('public/frontend/js/script.js');?>"></script>
    <script src="<?= base_url('public/frontend/frontendjs.js');?>"></script>
    <script>

$(document).ready(function(){
  $('.bf-testimonial-slick').slick({
		pauseOnHover: true,
		autoplay: false,
		autoplayspeed: 2000,
		speed: 1000,
		centerMode: true,
		centerPadding: '20%',
		slidesToShow: 2,
		slidesToScroll: 1,
		arrows: true,
		dots: true,
		draggable:true,
		responsive: [{
			breakpoint: 991,
			settings: {
				slidesToShow: 1,
			}
		}]
    
  });
});
      // vars
'use strict'
var	testim = document.getElementById("testim"),
		testimDots = Array.prototype.slice.call(document.getElementById("testim-dots").children),
    testimContent = Array.prototype.slice.call(document.getElementById("testim-content").children),
    testimLeftArrow = document.getElementById("left-arrow"),
    testimRightArrow = document.getElementById("right-arrow"),
    testimSpeed = 4500,
    currentSlide = 0,
    currentActive = 0,
    testimTimer,
		touchStartPos,
		touchEndPos,
		touchPosDiff,
		ignoreTouch = 30;
;

window.onload = function() {

    // Testim Script
    function playSlide(slide) {
        for (var k = 0; k < testimDots.length; k++) {
            testimContent[k].classList.remove("active");
            testimContent[k].classList.remove("inactive");
            testimDots[k].classList.remove("active");
        }

        if (slide < 0) {
            slide = currentSlide = testimContent.length-1;
        }

        if (slide > testimContent.length - 1) {
            slide = currentSlide = 0;
        }

        if (currentActive != currentSlide) {
            testimContent[currentActive].classList.add("inactive");            
        }
        testimContent[slide].classList.add("active");
        testimDots[slide].classList.add("active");

        currentActive = currentSlide;
    
        clearTimeout(testimTimer);
        testimTimer = setTimeout(function() {
            playSlide(currentSlide += 1);
        }, testimSpeed)
    }

    testimLeftArrow.addEventListener("click", function() {
        playSlide(currentSlide -= 1);
    })

    testimRightArrow.addEventListener("click", function() {
        playSlide(currentSlide += 1);
    })    

    for (var l = 0; l < testimDots.length; l++) {
        testimDots[l].addEventListener("click", function() {
            playSlide(currentSlide = testimDots.indexOf(this));
        })
    }

    playSlide(currentSlide);

    // keyboard shortcuts
    document.addEventListener("keyup", function(e) {
        switch (e.keyCode) {
            case 37:
                testimLeftArrow.click();
                break;
                
            case 39:
                testimRightArrow.click();
                break;

            case 39:
                testimRightArrow.click();
                break;

            default:
                break;
        }
    })
		
		testim.addEventListener("touchstart", function(e) {
				touchStartPos = e.changedTouches[0].clientX;
		})
	
		testim.addEventListener("touchend", function(e) {
				touchEndPos = e.changedTouches[0].clientX;
			
				touchPosDiff = touchStartPos - touchEndPos;
			
				console.log(touchPosDiff);
				console.log(touchStartPos);	
				console.log(touchEndPos);	

			
				if (touchPosDiff > 0 + ignoreTouch) {
						testimLeftArrow.click();
				} else if (touchPosDiff < 0 - ignoreTouch) {
						testimRightArrow.click();
				} else {
					return;
				}
			
		})
}
    </script>
    <!--Review page script-->
    <script>

  document.getElementById('toggleButton').onclick = function() {
  var div = document.getElementById('myDiv');
  if (div.style.display === 'none') {
    div.style.display = 'block'; // Or 'flex', 'grid', etc., depending on your layout
  } else {
    div.style.display = 'none';
  }
};

      const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')

allStar.forEach((item, idx)=> {
	item.addEventListener('click', function () {
		let click = 0
		ratingValue.value = idx + 1

		allStar.forEach(i=> {
			i.classList.replace('bxs-star', 'bx-star')
			i.classList.remove('active')
		})
		for(let i=0; i<allStar.length; i++) {
			if(i <= idx) {
				allStar[i].classList.replace('bx-star', 'bxs-star')
				allStar[i].classList.add('active')
			} else {
				allStar[i].style.setProperty('--i', click)
				click++
			}
		}
	})
})
    </script>
    <script>

$(document).ready(function(){
  $('.bf-testimonial-slick').slick({
		pauseOnHover: true,
		autoplay: false,
		autoplayspeed: 2000,
		speed: 1000,
		centerMode: true,
		centerPadding: '20%',
		slidesToShow: 2,
		slidesToScroll: 1,
		arrows: true,
		dots: true,
		draggable:true,
		responsive: [{
			breakpoint: 991,
			settings: {
				slidesToShow: 1,
			}
		}]
    
  });
});
      // vars
'use strict'
var	testim = document.getElementById("testim"),
		testimDots = Array.prototype.slice.call(document.getElementById("testim-dots").children),
    testimContent = Array.prototype.slice.call(document.getElementById("testim-content").children),
    testimLeftArrow = document.getElementById("left-arrow"),
    testimRightArrow = document.getElementById("right-arrow"),
    testimSpeed = 4500,
    currentSlide = 0,
    currentActive = 0,
    testimTimer,
		touchStartPos,
		touchEndPos,
		touchPosDiff,
		ignoreTouch = 30;
;

window.onload = function() {

    // Testim Script
    function playSlide(slide) {
        for (var k = 0; k < testimDots.length; k++) {
            testimContent[k].classList.remove("active");
            testimContent[k].classList.remove("inactive");
            testimDots[k].classList.remove("active");
        }

        if (slide < 0) {
            slide = currentSlide = testimContent.length-1;
        }

        if (slide > testimContent.length - 1) {
            slide = currentSlide = 0;
        }

        if (currentActive != currentSlide) {
            testimContent[currentActive].classList.add("inactive");            
        }
        testimContent[slide].classList.add("active");
        testimDots[slide].classList.add("active");

        currentActive = currentSlide;
    
        clearTimeout(testimTimer);
        testimTimer = setTimeout(function() {
            playSlide(currentSlide += 1);
        }, testimSpeed)
    }

    testimLeftArrow.addEventListener("click", function() {
        playSlide(currentSlide -= 1);
    })

    testimRightArrow.addEventListener("click", function() {
        playSlide(currentSlide += 1);
    })    

    for (var l = 0; l < testimDots.length; l++) {
        testimDots[l].addEventListener("click", function() {
            playSlide(currentSlide = testimDots.indexOf(this));
        })
    }

    playSlide(currentSlide);

    // keyboard shortcuts
    document.addEventListener("keyup", function(e) {
        switch (e.keyCode) {
            case 37:
                testimLeftArrow.click();
                break;
                
            case 39:
                testimRightArrow.click();
                break;

            case 39:
                testimRightArrow.click();
                break;

            default:
                break;
        }
    })
		
		testim.addEventListener("touchstart", function(e) {
				touchStartPos = e.changedTouches[0].clientX;
		})
	
		testim.addEventListener("touchend", function(e) {
				touchEndPos = e.changedTouches[0].clientX;
			
				touchPosDiff = touchStartPos - touchEndPos;
			
				console.log(touchPosDiff);
				console.log(touchStartPos);	
				console.log(touchEndPos);	

			
				if (touchPosDiff > 0 + ignoreTouch) {
						testimLeftArrow.click();
				} else if (touchPosDiff < 0 - ignoreTouch) {
						testimRightArrow.click();
				} else {
					return;
				}
			
		})
}
// Script for only single image uplaod
//  $(document).ready(function(){
//              $('#upload-file').change(function() {
//                 var filename = $(this).val();
//                 $('#file-upload-name').html(filename);
//                 if(filename!=""){
//                     setTimeout(function(){
//                         $('.upload-wrapper').addClass("uploaded");
//                     }, 600);
//                     setTimeout(function(){
//                         $('.upload-wrapper').removeClass("uploaded");
//                         $('.upload-wrapper').addClass("success");
//                     }, 1600);
//                 }
//             });
//         });

//Script for multi image upalod
$(document).ready(function () {
    $('#upload-file').on('change', function () {
        var files = this.files; // native FileList
        var fileNames = [];

        for (var i = 0; i < files.length; i++) {
            fileNames.push(files[i].name);
        }

        // Show all selected file names, comma separated
        $('#file-upload-name').html(fileNames.join(', '));

        if (files.length > 0) {
            setTimeout(function () {
                $('.upload-wrapper').addClass("uploaded");
            }, 600);
            setTimeout(function () {
                $('.upload-wrapper').removeClass("uploaded");
                $('.upload-wrapper').addClass("success");
            }, 1600);
        }
    });
});

      

    </script>
    <!--Like Review-->
  <script>
$(document).on("click", ".like-btn", function() {
    var reviewId = $(this).data("id");
    var likeCountSpan = $("#like-count-" + reviewId);

    $.ajax({
        url: "<?= base_url('/review/like'); ?>",
        type: "POST",
        data: { id: reviewId },
        dataType: "json", 
        success: function(res) {
            if (res.status === "success") {
                likeCountSpan.text(res.likes);
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", status, error);
            console.log("Response:", xhr.responseText);
        }
    });
});
</script>

    <!--Review page script end-->
    <!-- script for  mobile menu  and submenu -->
    <script>
        $(document).ready(function () {
            // For every .sub-toggle in mobile menu
            $('.menu--mobile .sub-toggle').off('click').on('click', function (e) {
                e.preventDefault();
        
                let parentLi = $(this).closest('li');
        
                // Toggle 'active' class for rotating icon
                $(this).toggleClass('active');
        
                // Slide toggle the nearest submenu
                parentLi.children('.sub-menu').slideToggle(300);
            });
        });

    </script>
    
    <div class="sticky-review-pawar">
  <button class="review-btn" onclick="openReviewModal()">
    <svg viewBox="0 0 24 24">
      <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z"/>
    </svg>
    <span>Reviews</span>
  </button>
</div>

<script>
  function openReviewModal() {
    location.href = "https://pawarhandloom.com/Review";
  }
</script>
    <!-- css for mobile menu and category or subcategory-->
    <style>
        /*.menu--mobile .sub-toggle {*/
        /*    float: right;*/
        /*    padding: 10px;*/
        /*    cursor: pointer;*/
        /*}*/
        
        /*.menu--mobile .sub-toggle.active {*/
        /*    transform: rotate(90deg);*/
        /*}*/
        /* MOBILE MENU FIX */
        @media (max-width: 768px) {
        
            /* Style for the arrow toggle button */
            .menu--mobile .sub-toggle {
                float: right !important;
                padding: 10px !important;
                cursor: pointer !important;
                font-size: 18px !important;
                display: inline-block !important;
                transform: rotate(0deg) !important;
                transition: all 0.3s ease !important;
            }
        
            /* Arrow rotates when active */
            .menu--mobile .sub-toggle.active {
                transform: rotate(90deg) !important;
            }
        
            /* Hide submenus by default */
            .menu--mobile .sub-menu {
                display: none !important;
                padding-left: 15px !important;
            }
        
            /* Show when opened by JS toggle */
            .menu--mobile li.open > .sub-menu {
                display: block !important;
            }
        
            /* Improve spacing for nested items */
            .menu--mobile .sub-menu li {
                padding: 8px 0 !important;
            }
        }


    </style>
    <!--//css for mobile menu and category or subcategory-->
    <!-- //script or mobile menu and submenu-->
    
    <!--Script for coupon apply -->
<script>

$(document).ready(function(){

    $("#applyCouponBtn").click(function(){

        let coupon = $("#couponCode").val();

        if(coupon == ""){
            $("#couponMessage").text("Please enter coupon code");
            return;
        }

        $.ajax({

            url: "<?= base_url('apply-coupon') ?>",
            type: "POST",
            data: {
                coupon_code: coupon
            },
            dataType: "json",

            success:function(res){

                $("#couponMessage").text(res.message);

                if(res.status == "success"){

                    setTimeout(function(){
                        location.reload();
                    },500);

                }

            }

        });

    });

});

</script>
<!--//Script for coupon apply-->
    
  </body>
</html>