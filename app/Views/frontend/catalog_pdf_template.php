<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h3 { background-color: #f2f2f2; padding: 10px; }
        img { max-width: 300px; max-height: auto; margin: 5px; }
        .product { border-bottom: 1px solid #ccc; margin-bottom: 10px; }
    </style>
</head>
<body>

<h3><?= $categoryName ?? 'Category Not Found !'; ?></h3>
<p><?= $description ?? 'Description Not Found !' ?></p>

<?php if (!empty($images)): ?>
    <?php foreach ($images as $image): ?>
        <div class="product">
        <!-- <img src="< ?= 'http://localhost:8080/public/uploads/admin/catlog/' . $image->image; ?>" width="100" alt="Product Image"> -->
        <!--<img src="data:image/jpeg;base64,< ?= base64_encode(file_get_contents(FCPATH . 'public/uploads\admin/catlog/' . $image->image)); ?>" width="100">-->
       <center> <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(FCPATH . 'public/uploads/admin/catlog/' . $image->image)); ?>" width="500px"> </center>


        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No images available in this category.</p>
<?php endif; ?>

</body>
</html>
