<?php

if (!function_exists('get_site_details')) {
    function get_site_details()
    {
        // Load the CodeIgniter instance
        $db = \Config\Database::connect();

        // Query the database for the Basic Details
        $query = $db->table(TBL_GLOBAL_SETTING)->get();

        // Fetch the result as an associative array or return null if not found
        return $query->getResult();
    }
}

if (!function_exists('get_product_image')) {
    function get_product_image($id)
    {
        // Load the CodeIgniter instance
        $db = \Config\Database::connect();

        // Query the database for the Basic Details
        $query = $db->table(TBL_PRODUCT_IMAGES)->where('product_id', $id)->get();

        // Fetch the result as an associative array or return null if not found
        return $query->getResult();
    }
}

if (!function_exists('get_gallery_category')) {
    function get_gallery_category($catId)
    {    
        $db = \Config\Database::connect();
        $query = $db->table(TBL_GALLERYCAT)->where('id', $catId)->get();

        // Fetch the result as an associative array or return null if not found
        return $query->getResult();
    }
}