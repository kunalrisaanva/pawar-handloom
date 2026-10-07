<!-- Hero Section -->
<div class="ps-hero bg--cover text-white text-center py-5" style="background-image: url('<?= base_url('public/frontend/img/hero/shop.jpg'); ?>'); background-size: cover; background-position: center;">
    <h1 class="display-4">Your Orders</h1>
</div>


<div class="container py-5">
    <h2 class="mb-4"><center>Order History</center></h2>

    <?php if (!empty($userOrders)): ?>
        <?php foreach ($userOrders as $order): ?>
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-light">
                    <strong>Order ID:</strong> #<?= esc($order->order_id) ?> |
                    <strong>Color:</strong>
                    <span class="order-color-box"></span> |
                    <strong>Date:</strong> <?= date('d M Y', strtotime($order->create_at)) ?> |
                    <strong>Total:</strong> ₹<?= esc($order->total_amount) ?> |
                    <strong>Status:</strong>
                    <span class="badge" style="background-color: <?= esc($order->status_color) ?>; color: #fff;">
                        <?= esc($order->status_name) ?>
                    </span>
                </div>

                <div class="card-body">
                    <?php if (!empty($order->items)): ?>
                        <ul class="list-group order-items">
                            <?php foreach ($order->items as $item):
                                // echo"Check <pre>";
                                // print_r($item);
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <img src="<?= base_url('public/'.$item->image) ?>" alt="Product Image" style="width: 150px;">
                                    <?= esc($item->product_name) ?> x<?= esc($item->qty) ?>  <span>
                                        <?php 
                                            $getColor = manageProductColour($item->color); ?>
                                        <!-- ✅ Hidden input for color -->
                        <?php if (!empty($getColor) && isset($getColor->colour_code)): ?>
                            <input type="hidden"
                                   class="order-item-color"
                                   value="<?= esc($getColor->colour_code) ?>"
                                   data-name="<?= esc($getColor->colour_name) ?>">
                        <?php endif; ?>
</span> 
                                    <span>₹<?= esc($item->subtotal) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted mb-0">No items found for this order.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">You have no orders yet.</p>
    <?php endif; ?>
</div>
