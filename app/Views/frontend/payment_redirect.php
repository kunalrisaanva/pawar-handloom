<form method="post" action="<?= esc($action) ?>" id="hdfcForm">
<?php foreach ($data as $key => $value): ?>
    <input type="hidden" name="<?= esc($key) ?>" value="<?= esc($value) ?>">
<?php endforeach; ?>
</form>

<script>
    document.getElementById('hdfcForm').submit();
</script>
