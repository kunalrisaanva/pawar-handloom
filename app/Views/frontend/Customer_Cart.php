<div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/shop.jpg'); ?>">
      <div class="container">
        <h1>Cart</h1>
      </div>
    </div>

<div class="ps-page__content">
        <div class="container">
          <div class="ps-shopping-cart">
            <div class="table-responsive">
              <table class="table ps-tablet ps-table--shopping-cart">
                <thead>
                  <tr>
                    <th></th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><a href="#"><img src="https://pawarhandloom.com/public/uploads/products/cover/1758425525_60760c7db4a02e39e24f.png" alt=""></a></td>
                    <td><a href="#">Cyan Boheme - Cyan, M</a></td>
                    <td>INR 4500.00</td>
                    <td>
                      <div class="form-group--number">
                        <button class="up"><i class="fa fa-plus"></i></button>
                        <button class="down"><i class="fa fa-minus"></i></button>
                        <input class="form-control" type="text" placeholder="1" value="1">
                      </div>
                    </td>
                    <td>
                      <p>INR 4500.00</p><a class="ps-btn--close ps-btn--no-boder" href="#"></a>
                    </td>
                  </tr>
                  <tr class="coupon">
                    <td colspan="2">
                      <div class="form-group--inline">
                        <label>Coupon</label>
                        <div class="form-group__content">
                          <input class="form-control" type="text" placeholder="Coupon Code">
                          <button class="ps-btn ps-btn--outline ps-btn--black">Apply coupon</button>
                        </div>
                      </div>
                    </td>
                    <td colspan="3"><a class="ps-btn ps-btn--outline ps-btn--black" href="#"> Update Cart</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <figure class="ps-shopping-cart__total">
              <figcaption>CART TOTALS</figcaption>
              <div class="table-responsive">
                <table class="table ps-table">
                  <tbody>
                    <tr>
                      <td><strong>Subtotal</strong></td>
                      <td>INR 4500.00</td>
                    </tr>
                    <tr>
                      <td><strong>Shiping</strong></td>
                      <td>
                        <p>Shipping: INR 150.00</p>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Subtotal</strong></td>
                      <td>INR 4500.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="footer"><a class="ps-btn ps-btn--outline ps-btn--black" href="#">Process to checkout</a></div>
            </figure>
          </div>
        </div>
      </div>