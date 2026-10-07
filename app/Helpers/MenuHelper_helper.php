<?php 

if (!function_exists('getCategoryMenu')) {
    function getCategoryMenu()
    {
        // Database connection
        $db = \Config\Database::connect();

        // Fetch main categories
        $categories = $db->table(TBL_CATEGORY)
            ->where('is_deleted', 1)
            ->where('status', 1)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        // Initialize menu array
        $menu = [];

        foreach ($categories as $category) {
            // Fetch subcategories for the current category
            $subcategories = $db->table(TBL_SUBCAT)
                ->where('cat_id', $category['id'])
                ->where('is_deleted', 1)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();

            $subMenu = [];

            foreach ($subcategories as $subcat) {
                // Fetch sub-subcategories for the current subcategory
                $subsubcategories = $db->table(TBL_SUBSUBCAT)
                    ->where('cat_id', $category['id'])
                    ->where('sub_cat_id', $subcat['id'])
                    ->where('is_deleted', 1)
                    ->where('status', 1)
                    ->orderBy('id', 'ASC')
                    ->get()
                    ->getResultArray();

                // Add subcategory with its sub-subcategories
                $subMenu[] = [
                    'id' => $subcat['id'],
                    'name' => $subcat['name'],
                    'description' => $subcat['subCategory_description'],
                    'image' => $subcat['subCategory_image'],
                    'subsubcategories' => $subsubcategories // Nested sub-subcategories
                ];
            }

            // Add category with its subcategories
            $menu[] = [
                'id' => $category['id'],
                'name' => $category['category_name'],
                'description' => $category['category_description'],
                'image' => $category['category_image'],
                'subcategories' => $subMenu // Nested subcategories
            ];
        }

        return $menu;
    }
}
