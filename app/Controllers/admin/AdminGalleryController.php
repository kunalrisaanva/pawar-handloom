<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminGalleryController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);

        // Check authenticate
       
    }

    public function viewGalleryCategory()
    {
        $data['title'] = 'Pawar Handloom Admin | Categories'; // page title
        $data['page'] = 'admin/gallery/viewGalleryCategory'; //page name
        $data['page_title'] = 'Gallery Category'; //Page Title Name
        $data['active_link'] = 'admin/ViewGalleryCategory'; //Page active link 

            //$AdminModel = new AdminModel();
        $where = [
            'is_deleted' => '1',
        ];
       // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
        $data['categoryList'] =  $this->adminModel->select_data(TBL_GALLERYCAT,$where);
        
        return view('admin/includes/pages',$data);
    }
    public function addGalleryCategory(){
        $data['title'] = 'Pawar Handloom Admin | Add Categories'; // page title
        $data['page'] = 'admin/gallery/addGalleryCategory'; //page name
        $data['page_title'] = 'Add Gallery Category'; //Page Title Name
        $data['active_link'] = 'admin/addGalleryCategory'; //Page active link 
        
            //insert category
        if (isset($_POST['addCategory'])) {
            
            $category_name = $this->request->getPost('category_name');
            $cat_description = $this->request->getPost('cat_description');
            $file = $this->request->getFile('cat_image');

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
                    
                    'category_name' => $category_name,
                    // 'category_image' => $catImage,
                    // 'category_description	' => $cat_description,
                ];
                $this->adminModel->insert_data(TBL_GALLERYCAT,$data);
                return redirect()->to('admin/ViewGalleryCategory')->with('status','Save Your Category Successfully !');
                }      

        }    
        
        return view('admin/includes/pages',$data);
    }
    public function edit_gallery_category($u_id){        
        $data['title'] = 'Pawar Handloom Admin | Category Edit'; // page title
        $data['page'] = 'admin/gallery/addGalleryCategory'; //page name
        $data['page_title'] = 'Gallery Category Edit'; //Page Title Name
        $data['active_link'] = 'admin/addGalleryCategory'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getCategoryData'] =  $this->adminModel->select_row(TBL_GALLERYCAT,$where);
        
        return view('admin/includes/pages',$data);
    }
     
public function update_gallery_category() {
    $Edit_id = $this->request->getVar('Edit_id');
    $category_name = $this->request->getVar('category_name');

    $where = ['id' => $Edit_id];
    $data = [
        
        'category_name' => $category_name,
    ];
    // echo"30-03-2025<pre>"; print_r($data);
    // die;
    $result = $this->adminModel->update_data(TBL_GALLERYCAT, $where, $data);
    return json_encode($result);
}
public function viewGallery(){
    $data['title'] = 'Pawar Handloom Admin | Categories'; // page title
    $data['page'] = 'admin/gallery/viewGallery'; //page name
    $data['page_title'] = 'Gallery Images'; //Page Title Name
    $data['active_link'] = 'admin/ViewGallery'; //Page active link 

        //$AdminModel = new AdminModel();
    $where = [
        'is_deleted' => '1',
    ];
   // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
    $data['categoryList'] =  $this->adminModel->select_data(TBL_GALLERY,$where);
    return view('admin/includes/pages',$data);
}
public function addGalleryImage() {
    $data['title'] = 'Pawar Handloom Admin | Add Gallery Images';
    $data['page'] = 'admin/gallery/addGalleryImage';
    $data['page_title'] = 'Add Gallery Image';
    $data['active_link'] = 'admin/addGalleryImage';

    $where = ['is_deleted' => '1'];
    $data['categoryList'] = $this->adminModel->select_data(TBL_GALLERYCAT, $where);

    if (isset($_POST['addImages'])) {
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
                        $file->move('public/uploads/admin/gallery/', $newName);
                        $imageNames[] = $newName;
                    }
                }
            }

            foreach ($imageNames as $image) {
                $data = [
                    'cat_id' => $category_name,
                    'image' => $image,
                ];
                $this->adminModel->insert_data(TBL_GALLERY, $data);
            }

            return redirect()->to('admin/ViewGallery')->with('status', 'Gallery images uploaded successfully!');
        }
    }

    
    return view('admin/includes/pages', $data);
}



}
