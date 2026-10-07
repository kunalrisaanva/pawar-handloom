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
        $data['productList'] =  $this->adminModel->select_data(TBL_PRODUCT,$where);
        
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

            //echo"coupan_name :- ".$coupan_name."<pre>coupan_description:- ".$coupan_type."<pre> period_time:- ".$sub_subCategory."<pre> period_time_hour:- ".$end_date;
            //die;

            // Handle Cover Image Upload
            $cover_image = $this->request->getFile('cover_image');
            $cover_image_path = '';

            if ($cover_image->isValid() && !$cover_image->hasMoved()) {
                $coverImageName = $cover_image->getRandomName(); // Generate a random file name
                $cover_image->move('uploads/products/cover', $coverImageName); // Move file to directory
                $cover_image_path = 'uploads/products/cover/' . $coverImageName; // Save the file path
            }

            $data = [
                'category' => $category,
                'subcategory' => $subcategory,
                'sub_subCategory' => $sub_subCategory,
                'product_name' => $product_name,
                'short_description' => $short_description,
                'description' => $description,
                //'brand' => $brand,
                'product_qunatity' => $product_qunatity,
                'actual_price' => $actual_price,
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
                //'main_domestic_market' => $main_domestic_market,
                'other_feature' => $other_feature,
                'cover_image' => $cover_image_path,
            ];
            $product_id = $this->adminModel->insert_data(TBL_PRODUCT, $data);
            $last_id = $this->db->insertID();

        if ($product_id) {
            // Handle multiple image uploads
            $files = $this->request->getFiles();
            if (isset($files['product_images'])) {
                foreach ($files['product_images'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName(); // Generate random file name
                        $file->move('uploads/admin/products', $newName); // Move file to uploads/products directory

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
}
