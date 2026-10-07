<div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/shop.jpg'); ?>">
      <div class="container">
        <h1>Cart</h1>
      </div>
    </div>

<div class="ps-page__content">
      <div class="container">
        <div class="row">
          <?php
          // echo"Check cart data<pre>";
          // print_r($cartItems); 
          ?>
          <div class="col-md-8">
          <div class="table-responsive ps-shopping-cart">
            <table class="table ps-tablet ps-table--shopping-cart">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Colour</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
            <tbody>
                <?php
                $cart = session()->get('cart') ?? [];
                $subTotal = 0;
                if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): 
                    $subTotal  += $item['offer_price'] * $item['qty'];
                    ?>
                        <tr>
                            <td>
                                <!-- If you have image -->
                                <img src="<?= base_url('public/'.$item['image']); ?>" width="60">
                            </td>
                            <td><?= $item['product_name'] ?></td>
                            <td>₹<?= number_format($item['offer_price'], 2) ?></td>
                            <td>
                                <?php 
                                // echo"Color Details:- <pre>" ;
                                // print_r($item['color']);die;
                                    $colourName= manageProductColour($item['color']);
                                    //print_r($colourName);
                                ?>
                                <?= $colourName->colour_name; ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>₹<?= number_format($item['offer_price'] * $item['qty'], 2) ?></td>
                            <td><a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-sm btn-danger">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Your cart is empty</td>
                    </tr>
                <?php endif; ?>
            </tbody>

            </table>
          </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-3">
          <figure class="ps-shopping-cart__total">
            <div class="table-responsive ps-shopping-cart">
              <table class="table ps-table">
                <tbody>
                  <tr>
                    <td colspan="2"><strong>Cart Total</strong></td>
                  </tr>
                  <!--<tr>-->
                  <!--  <td><strong>Subtotal</strong></td>-->
                  <!--  <td>INR 450.00</td>-->
                  <!--</tr>-->
                  <!--<tr>-->
                  <!--  <td><strong>Shiping</strong></td>-->
                  <!--  <td>-->
                  <!--    <p>INR 1500.00</p>-->
                  <!--  </td>-->
                  <!--</tr>-->
                  <!--<tr>-->
                  <!--  <td><strong>Total</strong></td>-->
                  <!--  <td>4500.00</td>-->
                  <!--</tr>-->
                  <tr>
                    <td><strong>Total</strong></td>
                    <!--<td>₹< ?= number_format($item['offer_price'] * $item['qty'], 2) ?></td>-->
                    <td>₹<?= number_format($subTotal, 2); ?></td>
                  </tr>
                  
                </tbody>
              </table>
            </div>
            <div class="footer"><a class="ps-btn ps-btn--outline ps-btn--black" href="<?= base_url('/checkout'); ?>">Process to checkout</a></div>
          </figure>
        </div>
        </div>
      </div>
    </div>