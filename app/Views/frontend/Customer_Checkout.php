  <div class="customer-form">
    <div class="checkout-container">

  <!-- Address Form -->
  <div class="card">
    <h2>Shipping Address</h2>
    <form class="ps-form--checkout" action="<?= base_url('checkout/placeOrder'); ?>" method="post">
    <div class="form-grid">
      <div class="form-group">
        <label>First Name</label>
        <input type="text"  name="first_name"  placeholder="John">
      </div>
      <div class="form-group">
        <label>Last Name</label>
        <input type="text"  name="last_name"  placeholder="Doe">
      </div>
      <div class="form-group">
        <label>Email</label>
        <?php $session = session(); ?>
        <input type="email" name="email" value="<?= $session->get('email');?>" placeholder="john@example.com">
      </div>
      <div class="form-group">
          <label>Phone</label>
          <input name="phone" type="text" placeholder="Phone*" required>
            </div>
      <div class="form-group full">
        <label>Street Address</label>
        <input type="text" name="address" placeholder="House no, Street name">
      </div>
      <div class="form-group">
        <label>City</label>
        <input type="text" name="city" placeholder="City">
      </div>
      <div class="form-group">
        <label>State</label>
        <input type="text" name="state" placeholder="State">
      </div>
      <div class="form-group">
        <label>Zip Code</label>
        <input type="text" name="zipcode" placeholder="Postal code">
      </div>
      <div class="form-group">
        <label>Country</label>
        <select name="country">
          <option>India</option>
          <option>United States</option>
          <option>United Kingdom</option>
        </select>
      </div>
      <div class="form-group full">
        <label>Additional Notes</label>
        <textarea name="notes" placeholder="Delivery instructions (optional)"></textarea>
      </div>
    </div>
  </div>

  <!-- Order Summary -->
  <!--<div class="card">-->
  <!--  <h2>Order Summary</h2>-->
  <!--  <div class="summary-item">-->
  <!--    <span>Product Name</span>-->
  <!--    <span>INR 1,200</span>-->
  <!--  </div>-->
  <!--  <div class="summary-item">-->
  <!--    <span>Shipping</span>-->
  <!--    <span>INR 100</span>-->
  <!--  </div>-->
  <!--  <div class="summary-item total">-->
  <!--    <span>Total</span>-->
  <!--    <span>INR 1,350</span>-->
  <!--  </div>-->

  <!--  <button class="checkout-btn">Place Order</button>-->
  <!--</div>-->

<div class="card order-summary">
    <h2>Order Summary</h2>
    <!-- Coupon Section -->
    <!--<div class="coupon-box">-->
    <!--    <input type="text" id="couponCode" placeholder="Enter coupon code">-->
    <!--    <button type="button" id="applyCouponBtn">Apply</button>-->
    <!--</div>-->
    
    <!-- Coupon Section -->
    <div class="coupon-box">
        <input type="text" id="couponCode" placeholder="Enter coupon code">
        <button type="button" id="applyCouponBtn">Apply</button>
    </div>
    
    <p id="couponMessage" style="font-size:13px;color:red;margin-top:5px;"></p>
    
    <div class="summary-item discount" style="display:none;">
        <span>Discount</span>
        <span id="discountAmount">- INR 0.00</span>
    </div>

    <?php 
    $subtotal = 0; 
    foreach ($cartItems as $index => $item) : 
        $total_price = $item['offer_price'] * $item['qty'];
        $subtotal += $total_price;
    ?>
        <div class="summary-item">
            
            <span>
                <?= $item['product_name']; ?> <br>
                <small>Qty: <?= $item['qty']; ?></small>
            </span>
            <span>INR <?= number_format($total_price, 2); ?></span>
        </div>

        <!-- Hidden inputs (unchanged logic) -->
        <input type="hidden" name="products[<?= $index; ?>][name]" value="<?= $item['product_name']; ?>">
        <input type="hidden" name="products[<?= $index; ?>][price]" value="<?= $item['offer_price']; ?>">
        <input type="hidden" name="products[<?= $index; ?>][qty]" value="<?= $item['qty']; ?>">
        <input type="hidden" name="products[<?= $index; ?>][total]" value="<?= $total_price; ?>">
    <?php endforeach; ?>
    
    <!--Coupon calculation-->
                
        <?php

            $coupon = session()->get('coupon');
            
            $discount = 0;
            $couponCode = '';
            
            if(!empty($coupon)){
            
            $discount = $coupon['discount'];
            $couponCode = $coupon['code'];
            
            }
            
            $grandTotal = $subtotal - $discount;
            
            if($grandTotal < 0){
            $grandTotal = 0;
            }
        
        ?>

    <!--//Coupon calculation-->
    

    <!--<div class="summary-item total">
        <span>Total</span>
        <span>INR < ?= number_format($subtotal, 2); ?></span>
    </div>-->
    <!--<div class="summary-item total">
        <span>Grand Total</span>
        <span>INR < ?= number_format($grandTotal,2); ?></span>
    </div>-->
    <!-- Subtotal -->
        <div class="summary-item">
        <span>Subtotal</span>
        <span>INR <?= number_format($subtotal,2); ?></span>
        </div>
        
        <!-- Discount -->
        <?php if($discount > 0): ?>
        
        <div class="summary-item discount">
        <span>Coupon Discount (<?= esc($couponCode) ?>)</span>
        <span>- INR <?= number_format($discount,2); ?></span>
        </div>
        
        <?php endif; ?>
        
        <!-- Grand Total -->
        <div class="summary-item total">
        <span>Grand Total</span>
        <span>INR <?= number_format($grandTotal,2); ?></span>
        </div>


<!-- Hidden values for backend -->
<!--
<input type="hidden" name="coupon_code" value="< ?= $couponCode ?>">
<input type="hidden" name="discount_amount" value="< ?= $discount ?>">
<input type="hidden" name="grand_total" value="< ?= $grandTotal ?>">
-->


    <button type="submit" name="placeOrder" class="checkout-btn">Place Order</button>
</div>

</form>

</div>


<style>

       .customer-form{
      background:#f4f6fb;
      padding:30px;
    }

.checkout-container{
      max-width:1100px;
      margin:auto;
      display:grid;
      grid-template-columns:2fr 1fr;
      gap:30px;
    }

    .card{
      background:#fff;
      border-radius:14px;
      padding:25px;
      box-shadow:0 15px 30px rgba(0,0,0,0.08);
    }

    h2{
      font-size:22px;
      margin-bottom:20px;
      color:#333;
    }

    .form-grid{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:18px;
    }

    .form-group{
      display:flex;
      flex-direction:column;
    }

    .form-group.full{
      grid-column:1/3;
    }

    label{
      font-size:13px;
      margin-bottom:6px;
      color:#555;
    }

    input, select, textarea{
      padding:12px 14px;
      border-radius:8px;
      border:1px solid #ddd;
      outline:none;
      font-size:14px;
    }

    input:focus, select:focus, textarea:focus{
      border-color:#ac4024;
    }

    textarea{
      resize:none;
      min-height:90px;
    }

    .summary-item{
      display:flex;
      justify-content:space-between;
      margin-bottom:12px;
      font-size:14px;
    }

    .summary-item.total{
      font-weight:600;
      font-size:16px;
      margin-top:15px;
    }

    .checkout-btn{
      width:100%;
      margin-top:20px;
      padding:14px;
      background:#ac4024;
      color:#fff;
      border:none;
      border-radius:10px;
      font-size:15px;
      cursor:pointer;
      transition:0.3s;
    }

    .checkout-btn:hover{
      background:#ac4024;
    }

    .secure-note{
      margin-top:12px;
      font-size:12px;
      text-align:center;
      color:#777;
    }

    @media(max-width:900px){
      .checkout-container{
        grid-template-columns:1fr;
      }
    }
    </style>
</div>
<style>
.coupon-box{
    display:flex;
    gap:10px;
    margin:15px 0;
}

.coupon-box input{
    flex:1;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}

.coupon-box button{
    padding:10px 16px;
    background:#000;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
}

.coupon-box button:hover{
    background:#333;
}

.summary-item.discount{
    color:#15803d;
    font-weight:500;
}
</style>

