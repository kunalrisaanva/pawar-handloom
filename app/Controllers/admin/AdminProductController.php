<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminProductController extends BaseController
{
    protected $adminModel;
    
    public function __construct()
    {
        $this->adminModel = new AdminModel();
       
    }
    public function viewProduct()
    {
        $data['title'] = 'Pawar Handloom Admin | Product List'; // page title
        $data['page'] = 'admin/product/viewProduct'; //page name
        $data['page_title'] = 'Product List'; //Page Title Name 
        $data['active_link'] = 'admin/ViewProduct'; //Page active link 
        //Get Product List
        $where = [
            'is_deleted' => '1',
        ];
        $order_by = ['column' => 'id', 'direction' => 'DESC'];
        $data['productList'] =  $this->adminModel->select_data(TBL_PRODUCT,$where,'',$order_by);
        
        return view('admin/includes/pages',$data);        
    }
    public function addProduct()
    {
        $data['title'] = 'Pawar Handloom Admin | Add Product'; // page title
        $data['page'] = 'admin/product/addProduct'; //page name
        $data['page_title'] = 'Add New Product'; //Page Title Name
        $data['active_link'] = 'admin/addProduct'; //Page active link 
        $where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['couponTypeList'] = $this->adminModel->select_data(TBL_CATEGORY,$where);
        
        $data['colourList'] = $this->adminModel->select_data(TBL_COLOURS,$where);
        //insert Coupan
        if (isset($_POST['addProduct'])) {
            $category = $this->request->getPost('category');
            $subcategory = $this->request->getPost('subcategory');
            $sub_subCategory = $this->request->getPost('sub_subCategory');
            $product_name = $this->request->getPost('product_name');
            $short_description = $this->request->getPost('short_description');
            $description = $this->request->getPost('description');
            //$brand = $this->request->getPost('brand');
            $product_qunatity = $this->request->getPost('product_qunatity');
            $actual_price = $this->request->getPost('actual_price');
            $actual_price_customer = $this->request->getPost('actual_price_customer');
            $offer_price = $this->request->getPost('offer_price');
            //$size = $this->request->getPost('size');
            //$material = $this->request->getPost('material');
            $fabric_type = $this->request->getPost('fabric_type');

            //$item_weight = $this->request->getPost('item_weight');
            //$pattern = $this->request->getPost('pattern');
            $dimensions = $this->request->getPost('dimensions'); //Saree Dimensions
            $blouse_dimensions = $this->request->getPost('blouse_dimensions');
            //$colour = $this->request->getPost('colour');
            //$colourString = $this->request->getPost('colour'); // e.g., "Red,Blue,Black"
            //$colourArray = array_map('trim', explode(',', $colourString)); // Convert to array & trim spaces
            //$colour = json_encode($colourArray);
            //$warranty = $this->request->getPost('warranty');
            //$occasion = $this->request->getPost('occasion');
            //$season = $this->request->getPost('season');
            //$product_type = $this->request->getPost('product_type');
            //$payment_terms = $this->request->getPost('payment_terms');
            //$supply_ability = $this->request->getPost('payment_terms');
            $delivery_time = $this->request->getPost('delivery_time');
            $wash_care = $this->request->getPost('wash_care');
            //$main_domestic_market = $this->request->getPost('main_domestic_market');
            $other_feature = $this->request->getPost('other_feature');
            $colour_ids = $this->request->getPost('colour_ids');
            
            $colour_ids_string = implode(',', $colour_ids); 
            // echo"Check Colour:- <pre>";
            // print_r($colour_ids);
            // die;

            //echo"coupan_name :- ".$coupan_name."<pre>coupan_description:- ".$coupan_type."<pre> period_time:- ".$sub_subCategory."<pre> period_time_hour:- ".$end_date;
            //die;

            // Handle Cover Image Upload
            $cover_image = $this->request->getFile('cover_image');
            $cover_image_path = '';

            if ($cover_image->isValid() && !$cover_image->hasMoved()) {
                $coverImageName = $cover_image->getRandomName(); // Generate a random file name
                $cover_image->move('public/uploads/products/cover', $coverImageName); // Move file to directory
                $cover_image_path = 'uploads/products/cover/' . $coverImageName; // Save the file path
            }
            $product_reference = 'PH' . date('YmdHis') . rand(100, 999);
            $data = [
                'product_reference' => $product_reference,
                'category' => $category,
                'subcategory' => $subcategory,
                'sub_subCategory' => $sub_subCategory,
                'product_name' => $product_name,
                'short_description' => $short_description,
                'description' => $description,
                //'brand' => $brand,
                'product_qunatity' => $product_qunatity,
                'actual_price' => $actual_price,
                'actual_price_customer' => $actual_price_customer,
                'offer_price' => $offer_price,
                'fabric_type' => $fabric_type,
                //'size' => $size,
                //'material' => $material,
                //'item_weight' => $item_weight,
                //'pattern' => $pattern,
                'dimensions' => $dimensions, //Saree Dimensions
                'blouse_dimensions' => $blouse_dimensions,
                //'colour' => $colour,
                //'warranty' => $warranty,
                //'occasion' => $occasion,
                //'season' => $season,
                //'product_type' => $product_type,
                //'payment_terms' => $payment_terms,
                //'supply_ability' => $supply_ability,
                'delivery_time' => $delivery_time,
                'wash_care' => $wash_care,
                'colour'=> $colour_ids_string,
                //'main_domestic_market' => $main_domestic_market,
                'other_feature' => $other_feature,
                'cover_image' => $cover_image_path,
            ];
            $product_id = $this->adminModel->insert_data(TBL_PRODUCT, $data);
            $last_id = $product_id ;

                        //TBL_PRODUCTQTY
                        $qtyData = [
                            'product_id' => $last_id,
                            'product_quantity' => $product_qunatity,
                        ];
                        $this->adminModel->insert_data(TBL_PRODUCTQTY, $qtyData);
                        

        if ($product_id) {
            // Handle multiple image uploads
            $files = $this->request->getFiles();
            if (isset($files['product_images'])) {
                foreach ($files['product_images'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName(); // Generate random file name
                        $file->move('public/uploads/admin/products', $newName); // Move file to uploads/products directory

                        // Save image path in TBL_PRODUCT_IMAGES
                        $image_data = [
                            'product_id' => $last_id,
                            'image' => 'uploads/admin/products/' . $newName
                        ];
                        $this->adminModel->insert_data(TBL_PRODUCT_IMAGES, $image_data);
                    }
                }
            }

            return redirect()->to('admin/ViewProduct')->with('status', 'Product added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add product. Please try again.');
        }
        
        
        
        
        }
        
        return view('admin/includes/pages',$data);        
    }

    public function edit_product($u_id)
    {
        $data['title'] = 'Pawar Handloom Admin | Edit Product'; // page title
        $data['page'] = 'admin/product/addProduct'; //page name
        $data['page_title'] = 'Edit Product'; //Page Title Name 
        $data['active_link'] = 'admin/addProduct'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['couponTypeList'] = $this->adminModel->select_data(TBL_CATEGORY,$where);
        $data['colourList'] = $this->adminModel->select_data(TBL_COLOURS,$where);
        $where1 = [
            'id' => $id,
            'is_deleted' => '1',
        ];
        $data['productData'] =  $this->adminModel->select_row(TBL_PRODUCT,$where1);
        $where2 = [
            'product_id' => $id,
            'is_deleted' => '1',
            'status' => '1'
        ];
         $data['productImages'] = $this->adminModel->select_data(
        'tbl_product_image',$where2);
        
        return view('admin/includes/pages',$data);        
    }
    
public function update_product()
{
    $Edit_id = $this->request->getPost('id');
    $id = base64_decode(urldecode($Edit_id));

    // Existing product
    $existing = $this->adminModel->select_row(TBL_PRODUCT, ['id' => $id]);
    
    $colour_ids = $this->request->getPost('colour_ids');
    $colour_ids_string = implode(',', $colour_ids); 

    // ===============================
    // BASIC FIELDS
    // ===============================
    $data = [
        'category'          => $this->request->getPost('category'),
        'subcategory'       => $this->request->getPost('subcategory'),
        'sub_subCategory'   => $this->request->getPost('sub_subCategory'),
        'product_name'      => $this->request->getPost('product_name'),
        'short_description' => $this->request->getPost('short_description'),
        'description'       => $this->request->getPost('description'),
        'product_qunatity'  => $this->request->getPost('product_qunatity'),
        'actual_price'      => $this->request->getPost('actual_price'),
        'actual_price_customer' => $this->request->getPost('actual_price_customer'),
        'offer_price'       => $this->request->getPost('offer_price'),
        'fabric_type'       => $this->request->getPost('fabric_type'),
        'dimensions'        => $this->request->getPost('dimensions'),
        'blouse_dimensions' => $this->request->getPost('blouse_dimensions'),
        'delivery_time'     => $this->request->getPost('delivery_time'),
        'wash_care'         => $this->request->getPost('wash_care'),
        'other_feature'     => $this->request->getPost('other_feature'),
        'colour'            => $colour_ids_string,
    ];

    // ===============================
    // COVER IMAGE (OPTIONAL)
    // ===============================
    $cover_image = $this->request->getFile('cover_image');

    if ($cover_image && $cover_image->isValid() && !$cover_image->hasMoved()) {

        $newCover = $cover_image->getRandomName();
        $cover_image->move(FCPATH . 'public/uploads/products/cover', $newCover);

        // delete old if exists
        if (!empty($existing->cover_image) && file_exists(FCPATH . 'public/' . $existing->cover_image)) {
            unlink(FCPATH . 'public/' . $existing->cover_image);
        }

        $data['cover_image'] = 'uploads/products/cover/' . $newCover;
    }

    // ===============================
    // UPDATE PRODUCT
    // ===============================
    // echo"Check EditID:- ".$Edit_id."<pre>";
    // echo $id.":- ID <pre>";
    // echo"Check Data:- <pre>";
    // print_r($data);die;
    $this->adminModel->update_data(
        TBL_PRODUCT,
        
        ['id' => $id],$data
    );

    // ===============================
    // PRODUCT IMAGES (OPTIONAL)
    // ===============================
    if (!empty($_FILES['product_images']['name'][0])) {

        foreach ($this->request->getFiles()['product_images'] as $file) {

            if ($file->isValid() && !$file->hasMoved()) {

                $imgName = $file->getRandomName();
                $file->move(FCPATH . 'public/uploads/admin/products', $imgName);
                $data1 = [
                        'product_id' => $id,
                        'image'      => 'uploads/admin/products/' . $imgName,
                        'status'     => '1',
                        'is_deleted' => '1',
                        'create_at'  => date('Y-m-d H:i:s')
                    ];
                // ALWAYS INSERT (even if no old images exist)
                $this->adminModel->insert_data(
                    TBL_PRODUCT_IMAGES,$data1
                    
                );
            }
        }
    }

    return redirect()->to('admin/ViewProduct')
        ->with('status', 'Product updated successfully!');
}
    

//     public function update_product()
// {
//     //die("hii");
//     $Edit_id = $this->request->getPost('id');
//     //die($Edit_id);
//     $id = base64_decode(urldecode($Edit_id));
//   // die($id);

//     // Fetch the existing product data (for old image)
//     $existing = $this->adminModel->select_row(TBL_PRODUCT, ['id' => $id]);
//     $productReference = $this->request->getPost('product_reference');

//     $category = $this->request->getPost('category');
//     $subcategory = $this->request->getPost('subcategory');
//     $sub_subCategory = $this->request->getPost('sub_subCategory');
//     $product_name = $this->request->getPost('product_name');
//     $short_description = $this->request->getPost('short_description');
//     $description = $this->request->getPost('description');
//     $product_qunatity = $this->request->getPost('product_qunatity');
//     $actual_price = $this->request->getPost('actual_price');
//     $offer_price = $this->request->getPost('offer_price');
//     $fabric_type = $this->request->getPost('fabric_type');
//     $dimensions = $this->request->getPost('dimensions');
//     $blouse_dimensions = $this->request->getPost('blouse_dimensions');
//     $delivery_time = $this->request->getPost('delivery_time');
//     $wash_care = $this->request->getPost('wash_care');
//     $other_feature = $this->request->getPost('other_feature');

//     $force_qty_update = $this->request->getPost('force_qty_update'); //if you want to force update the quantity


//     // Cover image logic
//     $cover_image = $this->request->getFile('cover_image');
//     //$cover_image_path = $existing->cover_image;
//     $cover_image_path = $existing->cover_image ?? '';


//     if ($cover_image && $cover_image->isValid() && !$cover_image->hasMoved()) {
//         $coverImageName = $cover_image->getRandomName();
//         $cover_image->move('public/uploads/products/cover', $coverImageName);
//         $cover_image_path = 'uploads/products/cover/' . $coverImageName;

//         // Delete old cover image
//         if (!empty($existing->cover_image) && file_exists($existing->cover_image)) {
//             unlink($existing->cover_image);
//         }
//     }

//     // Update product main data
//     $where = ['id' => $id];
//     if(!empty($productReference)){
//         $product_reference = $productReference;
//     }else{
//         $product_reference = 'PH' . date('YmdHis') . rand(100, 999);
//     }
//     $data = [
//         'product_reference' => $product_reference,
//         'category' => $category,
//         'subcategory' => $subcategory,
//         'sub_subCategory' => $sub_subCategory,
//         'product_name' => $product_name,
//         'short_description' => $short_description,
//         'description' => $description,
//         'product_qunatity' => $product_qunatity,
//         'actual_price' => $actual_price,
//         'offer_price' => $offer_price,
//         'fabric_type' => $fabric_type,
//         'dimensions' => $dimensions,
//         'blouse_dimensions' => $blouse_dimensions,
//         'delivery_time' => $delivery_time,
//         'wash_care' => $wash_care,
//         'other_feature' => $other_feature,
//         'cover_image' => $cover_image_path
//     ];

//     $result = $this->adminModel->update_data(TBL_PRODUCT, $where, $data);

//     // if checkbox check  product quantity in TBL_PRODUCTQTY insert
//     if ($force_qty_update) {
//         $qtyData = [
//             'product_id' => $id,
//             'product_qunatity' => $product_qunatity,
//         ];
//         $this->adminModel->insert_data(TBL_PRODUCTQTY,$qtyData);
//     }

//     if ($result) {

//         // ✅ Handle multiple image uploads
//         $files = $this->request->getFiles();
//         if (isset($files['product_images'])) {
//             foreach ($files['product_images'] as $file) {
//                 if ($file->isValid() && !$file->hasMoved()) {
//                     $newName = $file->getRandomName();
//                     $file->move('public/uploads/admin/products', $newName);

//                     $image_data = [
//                         'product_id' => $id,
//                         'image' => 'uploads/admin/products/' . $newName
//                     ];
//                     $this->adminModel->insert_data(TBL_PRODUCT_IMAGES, $image_data);
//                 }
//             }
//         }

//         return redirect()->to('admin/ViewProduct')->with('status', 'Product updated successfully!');
//     } else {
//         return redirect()->back()->with('error', 'Failed to update product. Please try again.');
//     }
// }

// Delete Product Images
public function deleteProductImage()
{
    $imageId = $this->request->getPost('image_id');

    if (!$imageId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid image'
        ]);
    }
    $data = ['is_deleted' => '0'];
    $this->adminModel->update_data(
        TBL_PRODUCT_IMAGES,
        ['id' => $imageId],$data
    );

    return $this->response->setJSON([
        'status' => 'success'
    ]);
}
// Update Product Image
// Update / Replace Product Image
public function updateProductImage()
{
    $imageId = $this->request->getPost('image_id');
    $file    = $this->request->getFile('new_image');

    if (!$imageId || !$file) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid request'
        ]);
    }

    // Get existing image
    $imageData = $this->adminModel->select_row(
        TBL_PRODUCT_IMAGES,
        ['id' => $imageId, 'is_deleted' => '1']
    );

    if (!$imageData) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Image not found'
        ]);
    }

    // Upload new image
    $newName = time() . '_' . $file->getRandomName();
    $uploadPath = 'uploads/admin/products/' . $newName;

    $file->move(FCPATH . 'public/uploads/admin/products', $newName);

    // OPTIONAL: remove old file physically
    if (file_exists(FCPATH . 'public/' . $imageData->image)) {
        unlink(FCPATH . 'public/' . $imageData->image);
    }
    
   // echo"Check Image:- <pre>";
    //print_r($uploadPath);
    
    $data= ['image' => $uploadPath];
    
    //die("<pre>check");
    // Update DB (same row)
    $this->adminModel->update_data(
        TBL_PRODUCT_IMAGES,
        ['id' => $imageId],$data
    );

    return $this->response->setJSON([
        'status' => 'success',
        'new_image_url' => base_url('public/' . $uploadPath)
    ]);
}



}
