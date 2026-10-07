<?php


function getReviewImage($id)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_REVIEW_IMAGES)->where('review_id', $id)->get()->getResult();
}

function getProductReview($productId)
{
    $db = \Config\Database::connect();
    
    $builder = $db->table(TBL_REVIEW . ' r')
        ->select('r.*, GROUP_CONCAT(ri.review_image) as review_images')
        ->join(TBL_REVIEW_IMAGES . ' ri', 'ri.review_id = r.id AND ri.product_id = r.product_id', 'left')
        ->where('r.product_id', $productId)
        ->where('r.status', 1)
        ->where('r.is_deleted', 1)
        ->groupBy('r.id')
        ->orderBy('r.created_at', 'DESC');

    $query = $builder->get();

    // Print query for debugging
    //echo "<pre>";
    //echo $db->getLastQuery();  
    //echo "</pre>";

    return $query->getResult();
}
function getReviewsWithImages($type)
{
    $db = \Config\Database::connect();

    $builder = $db->table(TBL_REVIEW . ' r')
        ->select('r.*, GROUP_CONCAT(ri.review_image) as review_images')
        ->join(TBL_REVIEW_IMAGES . ' ri', 'ri.review_id = r.id', 'left')
        ->where('r.status', 1)
        ->where('r.is_deleted', 1)
        ->groupBy('r.id')
        ->orderBy('r.created_at', 'DESC');

    if ($type == 1) {
        // All product reviews
        $builder->where('r.review_type', 1);
    } elseif ($type == 2) {
        // All shop reviews
        $builder->where('r.review_type', 2);
    }

    return $builder->get()->getResult();
}


