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

var baseUrl = window.location.origin+ '/';

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
/*$(document).ready(function () {
    $(".add-to-cart").click(function () {
        let productId = $(this).data("id");
        let productName = $(this).data("product_name");
        let productPrice = $(this).data("offer_price");
        let productImage = $(this).data("image");
        let quantity = $("#quantityInput").val();
        let color = $("#selectedColour").val();
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
                color: color,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    showToast(response.message, 'success');
                    // $("#cart-count").text(response.totalItems);
                    // $(".ps-cart__content").html(response.cartHtml);
                    //alert(response.message);
                    $("#cart-count").text(response.totalItems);
                    $(".ps-cart__content").html(response.cartHtml);
                } else {
                    showToast("Failed to add product to cart", 'error');
                    //alert("Failed to add product to cart.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
                alert("Error: " + status + "\n" + error + "\nResponse: " + xhr.responseText);
            }
        });
    });
});*/

/*New add to cart script updated*/


$(document).ready(function () {

    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();

        let productId    = $(this).data("id");
        let productName  = $(this).data("product_name");
        let productPrice = $(this).data("offer_price");
        let productImage = $(this).data("image");

        // Quantity (fallback to 1)
        let quantity = $("#quantityInput").length 
            ? parseInt($("#quantityInput").val()) 
            : 1;

        // Color (fallback empty string)
        let color = $("#selectedColour").length 
            ? $("#selectedColour").val() 
            : '';

        // Safety check
        if (!productId || !productPrice) {
            console.error("Missing product data");
            return;
        }

        $.ajax({
            url: baseUrl + "/cart/add",
            type: "POST",
            dataType: "json",
            data: {
                id: productId,
                product_name: productName,
                offer_price: productPrice,
                image: productImage,
                qty: quantity,
                color: color
            },
            success: function (response) {

                if (response.status === "success") {

                    // Toast Message
                    showToast(response.message, "success");

                    // Update cart count number
                    //$("#cart-count").text(response.totalItems);
                    $(".cart-count").text(response.totalItems);
                    // Update mini-cart items
                    $(".ps-cart__content").html(response.cartHtml);

                    // Update subtotal
                    $("#miniCartSubtotal").text("INR " + response.subTotal);

                } else {
                    showToast("Failed to add product to cart", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response:", xhr.responseText);
                showToast("Something went wrong. Try again.", "error");
            }
        });
    });

});


/*//New add to cart script updated*/


//for sending whatsapp product details message
function sendWhatsAppMessage(productId) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    var productReference = document.querySelector("#enquiryForm_" + productId + " input[name='product_reference']").value;
    var productImage = document.querySelector("#enquiryForm_" + productId + " input[name='product_image']").value;
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
    *Product Reference Code:* ${productReference}
    *Name:* ${customerName}
    *Email:* ${customerEmail}
    *Phone:* ${phoneNumber}`;

    // Encode message for URL
    var encodedMessage = encodeURIComponent(message);

    // WhatsApp URL
    //var whatsappURL = `https://api.whatsapp.com/send?phone=919630924663&text=${encodedMessage}`;
    var whatsappURL = `http://cloudapi.msg24.in/wapp/api/send?apikey=0c7ad2441dee41c6bdbe544b7269fbb7&mobile=919630924663&msg=${encodedMessage}&img1=https://pawarhandloom.com/public/${productImage}`;

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
  
// script  colour select and add to cart
document.querySelectorAll('.colour-item').forEach(item => {
    item.addEventListener('click', function () {

        // remove active border
        document.querySelectorAll('.colour-item').forEach(el => {
            el.style.border = '2px solid #ccc';
            el.classList.remove('active');
        });

        // add active border
        this.style.border = '2px solid #000';
        this.classList.add('active');

        // set hidden value
        document.getElementById('selectedColour').value =
            this.getAttribute('data-colour');
    });
});

// add to cart message toast js
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast-message show ' + type;

    setTimeout(() => {
        toast.classList.remove('show');
    }, 2500);
}

//show colour on order history page

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.order-items').forEach(function (orderList) {

        // First color input (you can also loop for multiple)
        const colorInput = orderList.querySelector('.order-item-color');

        if (colorInput) {
            const colorCode = colorInput.value;
            const colorName = colorInput.dataset.name;
            // alert(colorCode);
            // alert(colorName);

            // Find header color box (same card)
            const card = orderList.closest('.card');
            const colorBox = card.querySelector('.order-color-box');

            if (colorBox) {
                colorBox.innerHTML = `
                    <div class="colour-item active"
                         title="${colorName}"
                         style="
                            width:25px;
                            height:25px;
                            border-radius:50%;
                            background:${colorCode};
                            border:2px solid #000;
                            display:inline-block;
                            vertical-align:middle;
                            cursor:pointer;">
                    </div>
                `;
            }
        }
    });

});

//   SCRIPT for Increase and decrease button
document.addEventListener("DOMContentLoaded", function () {
    const qtyInput = document.getElementById("quantityInput");
    const increaseBtn = document.getElementById("increaseQty");
    const decreaseBtn = document.getElementById("decreaseQty");

    const minQty = 1;     // minimum quantity
    const step = 1;       // increment step

    increaseBtn.addEventListener("click", function () {
        qtyInput.value = parseInt(qtyInput.value) + step;
    });

    decreaseBtn.addEventListener("click", function () {
        let current = parseInt(qtyInput.value);
        if (current > minQty) {
            qtyInput.value = current - step;
        }
    });
});

/*Script for search Product*/

let searchTimer = null;

$('#searchInput').on('keyup', function () {
    clearTimeout(searchTimer);

    let keyword = $(this).val().trim();

    if (keyword.length < 2) {
        $('#searchResult').html('');
        return;
    }

    searchTimer = setTimeout(function () {
        $.ajax({
            url: baseUrl + '/search',
            type: "POST",
            data: { keyword: keyword },
            dataType: "json",
            success: function (res) {
                if (res.status === 'success') {
                    $('#searchResult').html(res.html);
                }
            }
        });
    }, 300); // debounce
});



/*//Script for search Product*/
