<?php if (!empty($galleryData)): ?>
    <?php foreach ($galleryData as $categoryId => $images): ?>
        <div class="container" style="margin-top: 50px;">
            <div class="ps-section__header" style="text-align: center;">
                <h3><?php 
                $categoryName = get_gallery_category($categoryId);
               echo $categoryName[0]->category_name; ?></h3><hr>
            </div>
            <div class="ps-product--detail ps-product--gallery">
                <div class="">
                    <div class="ps-product__thumbnail">
                        <div class="ps-gallery--image">
                            <div class="row">
                                <?php foreach ($images as $index => $image): ?>
                                    <div class="col-sm-3">
                                        <a class="ps-gallery__item" href="<?= base_url('/public/uploads/admin/gallery/' . $image->image); ?>">
                                            <img src="<?= base_url('/public/uploads/admin/gallery/' . $image->image); ?>" alt="" class="img-fluid" style="width:300px; height:225px;">
                                        </a>
                                    </div>
                                    <?php if (($index + 1) % 4 == 0): ?>
                                        </div><div class="row"> <!-- Close row and start a new one after every 4 images -->
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div> <!-- Close last row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p style="text-align: center;">No images available.</p>
<?php endif; ?>
