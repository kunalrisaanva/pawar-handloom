<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminCatlogController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);

        // Check authenticate
       
    }

    public function viewCatlogCategory()
    {
        $data['title'] = 'Pawar Handloom Admin | Catalog Categories'; // page title
        $data['page'] = 'admin/catlog/viewCatlogCategory'; //page name
        $data['page_title'] = 'Catalog Category'; //Page Title Name
        $data['active_link'] = 'admin/ViewCatlogCategory'; //Page active link 

            //$AdminModel = new AdminModel();
        $where = [
            'is_deleted' => '1',
        ];
       // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
        $data['categoryList'] =  $this->adminModel->select_data(TBL_CATLOGCAT,$where);
        
        return view('admin/includes/pages',$data);
    }
    public function addCatlogCategory(){
        $data['title'] = 'Pawar Handloom Admin | Add Catalog Categories'; // page title
        $data['page'] = 'admin/catlog/addCatlogCategory'; //page name
        $data['page_title'] = 'Add Catalog Category'; //Page Title Name
        $data['active_link'] = 'admin/addCatlogCategory'; //Page active link 
        
            //insert category
        if (isset($_POST['addCatlogCategory'])) {
            
            $category_name = $this->request->getPost('category_name');
            $cat_description = $this->request->getPost('cat_description');
            $price = $this->request->getPost('price');
            //$file = $this->request->getFile('cat_image');

            // if ($file->isValid() && ! $file->hasMoved()) {
            //     $newName = $file->getRandomName();
            //     $file->move('uploads/admin/category_image/', $newName);
            //     //$file->move($path);
            // }
            // $catImage = empty($newName) ? 'default_category_image.png' : $newName;
            $validated = $this->validate([
               
                'category_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Category Name is Required',
                    ]
                ], 
                // 'cat_description'=>[
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => 'Please Enter Discription is Required',
                //     ]
                // ],             
            ]);
            if (!$validated) {
               // die('Hello This not validated');
               $data['validation']  = $this->validator;
                return view('admin/includes/pages',$data);

            }else{
                $data = [
                    
                    'catlog_category_name' => $category_name,
                    'description' => $cat_description,
                    'price' => $price,
                ];
                $this->adminModel->insert_data(TBL_CATLOGCAT,$data);
                return redirect()->to('admin/ViewCatlogCategory')->with('status','Save Your Category Successfully !');
                }      

        }    
        
        return view('admin/includes/pages',$data);
    }
    public function edit_catlog_category($u_id){      
        //die('Hii');  
        $data['title'] = 'Pawar Handloom Admin | Catalog Category Edit'; // page title
        $data['page'] = 'admin/catlog/addCatlogCategory'; //page name
        $data['page_title'] = 'Catalog Category Edit'; //Page Title Name
        $data['active_link'] = 'admin/addCatlogCategory'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getCatlogCategoryData'] =  $this->adminModel->select_row(TBL_CATLOGCAT,$where);
        
        return view('admin/includes/pages',$data);
    }
     
public function update_catlog_category() {
    $Edit_id = $this->request->getVar('Edit_id');
    $category_name = $this->request->getVar('category_name');
    $description = $this->request->getVar('cat_description');
    $price = $this->request->getVar('price');

    $where = ['id' => $Edit_id];
    $data = [
        
        'catlog_category_name' => $category_name,
        'description'          => $description,
        'price'               => $price
    ];
    // echo"30-03-2025<pre>"; print_r($data);
    // die;
    $result = $this->adminModel->update_data(TBL_CATLOGCAT, $where, $data);
    return json_encode($result);
}
public function viewCatlog(){
    $data['title'] = 'Pawar Handloom Admin | Catalog'; // page title
    $data['page'] = 'admin/catlog/viewCatlog'; //page name
    $data['page_title'] = 'Catalog Images'; //Page Title Name
    $data['active_link'] = 'admin/ViewCatlog'; //Page active link 

        //$AdminModel = new AdminModel();
    $where = [
        'is_deleted' => '1',
    ];
   // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
    $data['categoryList'] =  $this->adminModel->select_data(TBL_CATLOG,$where);
    return view('admin/includes/pages',$data);
}
public function addCatlogImage() {
    $data['title'] = 'Pawar Handloom Admin | Add Catlog Images';
    $data['page'] = 'admin/catlog/addCatlogImage';
    $data['page_title'] = 'Add Catlog Image';
    $data['active_link'] = 'admin/addCatlogImage';

    $where = ['is_deleted' => '1'];
    $data['categoryList'] = $this->adminModel->select_data(TBL_CATLOGCAT, $where);

    if (isset($_POST['addCatlogImages'])) {
        //die('check In addImages');
        $category_name = $this->request->getPost('category_name');
        $files = $this->request->getFiles();

        $validated = $this->validate([
            'category_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Your Category Name is Required',
                ]
            ],
            'gallery_image' => [
                'rules' => 'uploaded[gallery_image]|is_image[gallery_image]|max_size[gallery_image,2048]',
                'errors' => [
                    'uploaded' => 'Please upload at least one image.',
                    'is_image' => 'Only image files are allowed.',
                    'max_size' => 'Image size should not exceed 2MB.',
                ]
                ],
        ]);

        if (!$validated) {
            //die('if validation');
            $data['validation'] = $this->validator;
            return view('admin/includes/pages', $data);
        } else {
            //die('else Image Insert');
            $imageNames = [];
            if (isset($files['gallery_image'])) {
                foreach ($files['gallery_image'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move('public/uploads/admin/catlog/', $newName);
                        $imageNames[] = $newName;
                    }
                }
            }

            foreach ($imageNames as $image) {
                $data = [
                    'cat_id' => $category_name,
                    'image' => $image,
                ];
                $this->adminModel->insert_data(TBL_CATLOG, $data);
            }

            return redirect()->to('admin/ViewCatlog')->with('status', 'Catlog images uploaded successfully!');
        }
    }

    
    return view('admin/includes/pages', $data);
}

}
