<div class="container text-center" style="padding:60px">

<h2 style="color:red;">Payment Failed ❌</h2>

<p>Your payment could not be completed.</p>

<?php if(!empty($payment)): ?>

<div style="margin-top:20px;text-align:left;max-width:500px;margin:auto">

<p><b>Order ID :</b> <?= esc($order) ?></p>

<p><b>Amount :</b> ₹<?= esc($payment['amount'] ?? '') ?></p>

<p><b>Payment Method :</b> <?= esc($payment['payment_method_type'] ?? '') ?></p>

<p><b>Transaction ID :</b> <?= esc($payment['txn_id'] ?? '') ?></p>

<p><b>Reason :</b> 
<?= esc($payment['bank_error_message'] ?? $payment['resp_message'] ?? 'Payment Failed') ?>
</p>

</div>

<?php endif; ?>

<div style="margin-top:30px">

<!--<a href="<?= base_url('checkout') ?>" class="btn btn-primary">
Try Again
</a>-->

<a href="<?= base_url('/') ?>" class="btn btn-dark">
Go Home
</a>

</div>

</div>