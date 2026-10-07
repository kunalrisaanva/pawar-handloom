<?php


function getProductDetailsByOrder($order_id)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_ORDERITEMS)->where('order_id', $order_id)->get()->getResult();
}

// Get Product category
function getProductCategory($categoryId)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_CATEGORY)->where('id', $categoryId)->get()->getRow();
}

// Get Product Subcategory
function getProductsubCategory($subcategoryId)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_SUBCAT)->where('id', $subcategoryId)->get()->getRow();
}

// Get Product child Subcategory
function getProductchildsubCategory($childsubcategoryId)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_SUBSUBCAT)->where('id', $childsubcategoryId)->get()->getRow();
}
//Get single Product all other Images
function getProductImages($productId)
{
    $db = \Config\Database::connect();
    return $db->table(TBL_PRODUCT_IMAGES)->where('product_id', $productId)->get()->getResult();
}

//Get All Order Status 
function getAllOrderStatuses()
{
    $db = \Config\Database::connect();
    return $db->table(TBL_ORDERSTATUS)
              ->where('status', 1)
              ->where('is_deleted', 1)
              ->orderBy('status_order_no', 'ASC')
              ->get()
              ->getResult();
}