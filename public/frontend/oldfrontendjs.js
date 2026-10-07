// document.getElementById('increaseBtn').addEventListener('click', function () {
//     let quantityInput = document.getElementById('quantityInput');
//     quantityInput.value = parseInt(quantityInput.value) + 1;
// });

// document.getElementById('decreaseBtn').addEventListener('click', function () {
//     let quantityInput = document.getElementById('quantityInput');
//     if (parseInt(quantityInput.value) > 1) {
//         quantityInput.value = parseInt(quantityInput.value) - 1;
//     }
// });

var baseUrl = window.location.origin+ '/demoMain/';

// Script for Product filter low and high
$(document).ready(function () {
    $('#sortPrice').change(function () {
        //alert("Hii");
        let priceSort = $(this).val();
        //let currentUrl = window.location.href; // Keep the same page URL
        let currentUrl = window.location.pathname; // This will return "/shop/2"

        
        $.ajax({
            url: currentUrl,
            type: 'GET',
            data: { price_sort: priceSort },
            success: function (response) {
                // Extract only the section that contains the products
                let updatedContent = $(response).find('.product-container').html();
                $('.product-container').html(updatedContent); // Replace only the product section
            }
        });
    });
});
// Script for Product filter low and high End

//Add to cart script
// $(document).ready(function () {
//     $(".add-to-cart").on("click", function (e) {
//         e.preventDefault();
//         let productId = $(this).data("id");

//         $.ajax({
//             url: "<?= base_url('cart/add'); ?>",
//             type: "POST",
//             data: { product_id: productId },
//             dataType: "json",
//             success: function (response) {
//                 if (response.status === "success") {
//                     updateCartUI(response.cart);
//                 }
//             },
//         });
//     });

//     function updateCartUI(cart) {
//         // Update Cart Count in Header
//         $(".ps-cart-toggle span i").text(cart.total_items);

//         // Update Mini Cart Content
//         let miniCartHtml = "";
//         cart.items.forEach((item) => {
//             miniCartHtml += `
//                 <div class="ps-product--cart">
//                     <div class="ps-product__thumbnail">
//                         <a href="details.html">
//                             <img src="${item.image}" alt="">
//                         </a>
//                         <span class="ps-btn--close ps-btn--no-boder" onclick="removeFromCart(${item.id})"></span>
//                     </div>
//                     <div class="ps-product__content">
//                         <a href="details.html">${item.name}</a>
//                         <span>${item.qty}x INR ${item.price}</span>
//                     </div>
//                 </div>
//             `;
//         });

//         $(".ps-cart__content").html(miniCartHtml);
//         $(".ps-cart__footer h4 span").text("INR " + cart.total_price);
//     }
// });
// add to cart
$(document).ready(function () {
    $(".add-to-cart").click(function () {
        let productId = $(this).data("id");
        let productName = $(this).data("product_name");
        let productPrice = $(this).data("offer_price");
        let productImage = $(this).data("image");
        let quantity = $("#quantityInput").val();
        console.log("AJAX URL:", "<?= base_url('cart/add'); ?>");
        //alert(baseUrl);

        $.ajax({
            url: baseUrl + '/cart/add', 
            type: "POST",
            data: {
                id: productId,
                product_name: productName,
                offer_price: productPrice,
                image: productImage,
                qty: quantity,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    alert(response.message);
                    $("#cart-count").text(response.totalItems);
                    $(".ps-cart__content").html(response.cartHtml);
                } else {
                    alert("Failed to add product to cart.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
                alert("Error: " + status + "\n" + error + "\nResponse: " + xhr.responseText);
            }
        });
    });
});


//for sending whatsapp product details message
function sendWhatsAppMessage(productId) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var customerName = document.querySelector("#enquiryForm_" + productId + " input[name='customer_name']").value;
    var customerEmail = document.querySelector("#enquiryForm_" + productId + " input[name='customer_email']").value;
    var phoneNumber = document.querySelector("#enquiryForm_" + productId + " input[name='phone_number']").value;
    var productName = document.querySelector("#enquiryForm_" + productId + " input[name='product_name']").value;
    var productPrice = document.querySelector("#enquiryForm_" + productId + " input[name='product_price']").value;
    var description = document.querySelector("#enquiryForm_" + productId + " input[name='description']").value;
    // *Description:* ${description}
    // Create the WhatsApp message
    var message = `Hi, I am interested in the product:
    *Product Name:* ${productName}
    *Price:* ₹${productPrice}
    
    
    My details:
    *Name:* ${customerName}
    *Email:* ${customerEmail}
    *Phone:* ${phoneNumber}`;

    // Encode message for URL
    var encodedMessage = encodeURIComponent(message);

    // WhatsApp URL
    var whatsappURL = `https://api.whatsapp.com/send?phone=919630063222&text=${encodedMessage}`;

    // Open WhatsApp chat
    window.open(whatsappURL, "_blank");
}

// Script for Sorting Products by Price high to low and low to high
function applySort() {
    //alert("Hii");
    
    var sortPrice = document.getElementById('sortPrice').value;
    var categoryId = document.getElementById('categoryId').value; // Get the category ID
    //alert(categoryId);
    $.ajax({
      url: baseUrl + '/shop/' + categoryId,
      type: 'GET',
      data: { price_sort: sortPrice },
      success: function(response) {
        // Handle the response (e.g., update the product list without page reload)
        $('#product-container').html(response);
      }
    });
  }
  
