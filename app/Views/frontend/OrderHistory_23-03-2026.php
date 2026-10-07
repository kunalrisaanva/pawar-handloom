
<style>
    .order-card{
border-radius:10px;
transition:0.3s;
}

.order-card:hover{
transform:translateY(-2px);
box-shadow:0 6px 18px rgba(0,0,0,0.1);
}

.badge{
font-size:13px;
}
</style>

<!-- Hero Section -->
<div class="ps-hero bg--cover text-white text-center py-5"
     style="background-image: url('<?= base_url('public/frontend/img/hero/shop.jpg'); ?>');
     background-size: cover; background-position: center;">
    <h1 class="display-5 fw-bold">My Orders</h1>
</div>


<div class="container py-5">

<h3 class="mb-4 text-center">Order History</h3>

<?php if (!empty($userOrders)): ?>

<?php foreach ($userOrders as $order): ?>

<div class="card mb-4 shadow-sm border-0 order-card">

<div class="card-header bg-white d-flex justify-content-between align-items-center">

<div>
<strong>Order ID:</strong> #<?= esc($order->order_id) ?><br>
<small class="text-muted">
<?= date('d M Y', strtotime($order->create_at)) ?>
</small>
</div>

<div>
<strong>Total:</strong>
<span class="text-success fw-bold">
₹<?= esc($order->total_amount) ?>
</span>
</div>

<div>
<span class="badge px-3 py-2"
style="background-color: <?= esc($order->status_color) ?>; color:#fff;">
<?= esc($order->status_name) ?>
</span>
</div>

</div>


<div class="card-body">

<?php if (!empty($order->items)): ?>

<?php foreach ($order->items as $item): ?>

<div class="row align-items-center border-bottom py-3">

<div class="col-md-2 text-center">
<img src="<?= base_url('public/'.$item->image) ?>"
class="img-fluid rounded"
style="max-height:80px;">
</div>

<div class="col-md-4">
<h6 class="mb-1"><?= esc($item->product_name) ?></h6>
<small class="text-muted">
Quantity : <?= esc($item->qty) ?>
</small>

<?php 
$getColor = manageProductColour($item->color); ?>

<?php if (!empty($getColor) && isset($getColor->colour_code)): ?>

<div class="mt-2 d-flex align-items-center">

<div style="width:18px;height:18px;
background:<?= esc($getColor->colour_code) ?>;
border-radius:50%;margin-right:8px;">
</div>

<small><?= esc($getColor->colour_name) ?></small>

</div>

<?php endif; ?>

</div>

<div class="col-md-3 text-center">

<span class="text-muted">
Price
</span><br>

<strong>₹<?= esc($item->price) ?></strong>

</div>

<div class="col-md-3 text-end">

<span class="text-muted">
Subtotal
</span><br>

<strong class="text-dark">
₹<?= esc($item->subtotal) ?>
</strong>

</div>

</div>

<?php endforeach; ?>

<?php else: ?>

<p class="text-muted mb-0">No items found for this order.</p>

<?php endif; ?>


<div class="row mt-3">

<div class="col-md-6">
    
   <button 
class="btn btn-outline-dark btn-sm viewOrderBtn"
data-order='<?= json_encode($order) ?>'
data-toggle="modal"
data-target="#orderModal">
View Order Details
</button>

<!--<a href="< ?= base_url('order-details/'.$order->order_id) ?>"
class="btn btn-outline-dark btn-sm">

View Order Details

</a>-->

</div>

<div class="col-md-6 text-end">

<!--<a href="< ?= base_url('/') ?>"
class="btn btn-primary btn-sm">

Buy Again

</a>-->

</div>

</div>


</div>

</div>

<?php endforeach; ?>

<?php else: ?>

<div class="text-center py-5">

<h4 class="text-muted">No Orders Yet</h4>

<p class="text-muted">
You haven't placed any orders yet.
</p>

<a href="<?= base_url('/') ?>"
class="btn btn-primary mt-2">

Start Shopping

</a>

</div>

<?php endif; ?>

<!--Model for View single order history-->
<div class="modal fade" id="orderModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Order Details</h5>
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<div id="modalOrderContent">

</div>

</div>

</div>
</div>
</div>
<!--//Model for View single order history-->

<!--Script for modal and get details-->
<script>

document.querySelectorAll('.viewOrderBtn').forEach(btn => {

btn.addEventListener('click', function(){

let order = JSON.parse(this.getAttribute('data-order'));

let html = '';

/* ORDER SUMMARY */

html += `
<div class="row mb-4">

<div class="col-md-6">

<h5>Order Information</h5>

<p>
<strong>Order ID :</strong> ${order.order_number}<br>
<strong>Date :</strong> ${order.create_at}<br>
<strong>Status :</strong>
<span style="background:${order.status_color};color:#fff;padding:3px 8px;border-radius:5px;">
${order.status_name}
</span><br>
<strong>Total :</strong> ₹${order.total_amount}
</p>

</div>

<div class="col-md-6">

<h5>Payment Details</h5>

<p>
<strong>Payment Status :</strong> ${order.payment_status}<br>
<strong>Payment Method :</strong> ${order.payment_mode}<br>
<strong>Transaction ID :</strong> ${order.transaction_id}
</p>

</div>

</div>

<hr>

<div class="mb-4">

<h5>Shipping Address & Customer Details</h5>

<p>
${order.first_name} ${order.last_name}<br>
${order.address}<br>
${order.city}, ${order.state} - ${order.zipcode}<br>
${order.country}<br>
Phone : ${order.phone}<br>
Email : ${order.email_id}
</p>

</div>

<hr>

<h5>Order Items</h5>
`;


/* ORDER ITEMS */

if(order.items){

order.items.forEach(item => {

html += `
<div class="row align-items-center mb-3 border-bottom pb-2">

<div class="col-md-2">
<img src="/public/${item.image}" class="img-fluid rounded">
</div>

<div class="col-md-5">
<strong>${item.product_name}</strong><br>
Qty : ${item.qty}
</div>

<div class="col-md-2">
₹${item.price}
</div>

<div class="col-md-3 text-end">
<strong>₹${item.subtotal}</strong>
</div>

</div>
`;

});

}

document.getElementById('modalOrderContent').innerHTML = html;

});

});

</script>
<!--//Script for modal and get details-->

</div>