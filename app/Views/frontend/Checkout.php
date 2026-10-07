<div class="ps-page__content">
  <div class="container">
    <div class="ps-checkout">
      <form class="ps-form--checkout" action="<?= base_url('checkout/placeOrder'); ?>" method="post">
        <div class="row">
          <!-- Billing Details -->
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <h3 class="ps-checkout__heading">BILLING DETAILS</h3>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" name="first_name" type="text" placeholder="First Name*" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" name="last_name" type="text" placeholder="Last Name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <input class="form-control" name="company_name" type="text" placeholder="Company Name">
            </div>
            <div class="form-group">
              <input class="form-control" name="address" type="text" placeholder="Street Address*" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="city" type="text" placeholder="Town/City*" required>
            </div>
            <div class="form-group">
              <input class="form-control" name="phone" type="text" placeholder="Phone*" required>
            </div>
            <div class="form-group">
              <?php $session = session(); ?>
              <input class="form-control" name="email" type="email" placeholder="E-Mail*" value="<?= $session->get('email');?>" readonly required>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="notes" rows="5" placeholder="Other Notes"></textarea>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <h3 class="ps-checkout__heading">YOUR ORDER</h3>
            <div class="table-responsive">
              <table class="table ps-table ps-table--checkout">
                <tbody>
                  <tr>
                    <td><strong>Product</strong></td>
                    <td><strong>Qty</strong></td>
                    <td><strong>Price</strong></td>
                    <td><strong>Total</strong></td>
                  </tr>
                  
                  <?php 
                  $subtotal = 0; 
                  foreach ($cartItems as $index => $item) : 
                    $total_price = $item['offer_price'] * $item['qty'];
                    $subtotal += $total_price;
                  ?>
                    <tr>
                      <td>
                        <a href="#"><img src="public/img/product/2-1.jpg" alt=""></a>
                        <p><?= $item['product_name']; ?></p>
                      </td>
                      <td><?= $item['qty']; ?></td>
                      <td>INR <?= number_format($item['offer_price'], 2); ?></td>
                      <td>INR <?= number_format($total_price, 2); ?></td>
                    </tr>

                    <input type="hidden" name="products[<?= $index; ?>][name]" value="<?= $item['product_name']; ?>">
                    <input type="hidden" name="products[<?= $index; ?>][price]" value="<?= $item['offer_price']; ?>">
                    <input type="hidden" name="products[<?= $index; ?>][qty]" value="<?= $item['qty']; ?>">
                    <input type="hidden" name="products[<?= $index; ?>][total]" value="<?= $total_price; ?>">
                  <?php endforeach; ?>

                  <!--<tr>-->
                  <!--  <td><strong>Subtotal</strong></td>-->
                  <!--  <td colspan="3">INR < ?= number_format($subtotal, 2); ?></td>-->
                  <!--</tr>-->
                  <tr class="total">
                    <td><strong>Total</strong></td>
                    <td colspan="3">INR <?= number_format($subtotal, 2); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- ✅ Place Order Button INSIDE the form -->
            <div class="col-12 text-right">
              <button type="submit" name="placeOrder" class="ps-btn ps-btn--outline ps-btn--black">Place Order</button>
            </div>
          </div>  
        </div>
      </form>
    </div>
  </div>
</div>
