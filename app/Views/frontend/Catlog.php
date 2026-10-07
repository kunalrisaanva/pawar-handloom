<?php if (!empty($galleryData)): ?>
    <?php foreach ($galleryData as $categoryId => $images): ?>
        <div class="container" style="margin-top: 50px;">
            <div class="ps-section__header" style="text-align: center;">
                <h3><?php 
                $categoryName = get_catlog_category($categoryId);
               echo $categoryName[0]->catlog_category_name; ?></h3>
               <h5><?php 
                $categoryName = get_catlog_category($categoryId);
               echo $categoryName[0]->price; ?></h5>
               <p><?php 
                $categoryName = get_catlog_category($categoryId);
               echo $categoryName[0]->description; ?></p>
                <!-- Download PDF Button for This Category -->
                <a href="<?= base_url('download-pdf/' . $categoryId); ?>" 
                class="btn btn-sm btn-primary" 
                id="downloadBtn_<?= $categoryId; ?>" 
                style="margin: 10px 0;font-size: 15px;">
                    Download PDF of <?= $categoryName[0]->catlog_category_name; ?>
                </a>
               <hr>
            </div>
            <div class="ps-product--detail ps-product--gallery">
                <div class="">
                    <div class="ps-product__thumbnail">
                        <div class="ps-gallery--image">
                            <div class="row">
                                <?php foreach ($images as $index => $image): ?>
                                    <div class="col-sm-3">
                                        <a class="ps-gallery__item" href="<?= base_url('public/uploads/admin/catlog/' . $image->image); ?>">
                                            <img src="<?= base_url('public/uploads/admin/catlog/' . $image->image); ?>" alt="" class="img-fluid">
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
