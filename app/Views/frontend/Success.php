<div class="ps-hero bg--cover" data-background="<?= base_url('public/frontend/img/hero/shop.jpg');?>">
    <div class="container">
        <h1>Order Success</h1>
    </div>
</div>

<div class="container" style="margin-top:40px;">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow" style="border-radius:10px;">
                
                <div class="card-body text-center">

                    <!-- Success Icon -->
                    <div style="font-size:60px;color:#28a745;margin-bottom:10px;">
                        ✓
                    </div>

                    <h3 style="color:#28a745;font-weight:600;">
                        Payment Successful
                    </h3>

                    <p style="color:#666;">
                        Thank you for placing your order on <strong>Pawar Handloom</strong>.
                    </p>

                    <hr>

                    <!-- Order Details -->
                    <div class="row text-left">

                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Order ID :</strong><br>
                            <?= $paymentResponse['order_id'] ?? '' ?>
                        </div>

                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Transaction ID :</strong><br>
                            <?= $paymentResponse['txn_id'] ?? '' ?>
                        </div>

                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Payment Method :</strong><br>
                            <?= $paymentResponse['payment_method_type'] ?? '' ?>
                        </div>

                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Amount Paid :</strong><br>
                            ₹ <?= number_format($order->total_amount ?? 0, 2) ?>
                        </div>

                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Status :</strong><br>
                            <span style="color:green;font-weight:bold;">
                                <?= $paymentResponse['status'] ?? '' ?>
                            </span>
                        </div>

                    </div>

                    <!-- ✅ NEW SECTION START -->
                    <?php if(!empty($order)): ?>

                    <hr>

                    <div class="row text-left">

                        <!-- Subtotal -->
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Subtotal :</strong><br>
                            ₹ <?= number_format($order->subtotal, 2) ?>
                        </div>

                        <!-- Coupon -->
                        <?php if(!empty($order->coupon_code)): ?>
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Coupon Applied :</strong><br>
                            <span style="
                                background:#28a745;
                                color:#fff;
                                padding:4px 10px;
                                border-radius:5px;
                                font-size:13px;
                            ">
                                <?= $order->coupon_code ?>
                            </span>
                        </div>

                        <!-- Discount -->
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Discount :</strong><br>
                            <span style="color:green;font-weight:bold;">
                                - ₹ <?= number_format($order->discount_amount, 2) ?>
                            </span>
                        </div>
                        <?php endif; ?>

                        <!-- Grand Total -->
                        <div class="col-md-6" style="margin-bottom:10px;">
                            <strong>Grand Total :</strong><br>
                            <span style="font-size:20px;font-weight:bold;color:#28a745;">
                                ₹ <?= number_format($order->total_amount, 2) ?>
                            </span>
                        </div>

                    </div>

                    <?php endif; ?>
                    <!-- ✅ NEW SECTION END -->

                    <hr>

                    <!-- Buttons -->

                    <div style="margin-top:20px;">

                        <a href="<?= base_url('/') ?>" 
                           class="btn btn-primary"
                           style="margin-right:10px;">
                            Continue Shopping
                        </a>

                       <!-- <a href="<?= base_url('UserOrders'); ?>" 
                           class="btn btn-outline-dark">
                            View Order Details
                        </a>-->

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>