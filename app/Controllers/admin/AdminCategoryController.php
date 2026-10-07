<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;


class AdminCategoryController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);

        // Check authenticate
       
    }

    public function viewCategory(){
        $data['title'] = 'Pawar Handloom Admin | Categories'; // page title
        $data['page'] = 'admin/category/viewCategory'; //page name
        $data['page_title'] = 'Category'; //Page Title Name
        $data['active_link'] = 'admin/ViewCategory'; //Page active link 

            //$AdminModel = new AdminModel();
        $where = [
            'is_deleted' => '1',
        ];
       // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
        $data['categoryList'] =  $this->adminModel->select_data(TBL_CATEGORY,$where);
        
        return view('admin/includes/pages',$data);

    }
    
    public function addCategory(){
        $data['title'] = 'Pawar Handloom Admin | Add Categories'; // page title
        $data['page'] = 'admin/category/addCategory'; //page name
        $data['page_title'] = 'Add Category'; //Page Title Name
        $data['active_link'] = 'admin/addCategory'; //Page active link 
        /*$where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['languageList'] = $this->adminModel->select_data(TBL_LANG,$where); */
            //insert category
        if (isset($_POST['addCategory'])) {
            $language_name = $this->request->getPost('language_name');
            $category_name = $this->request->getPost('category_name');
            $cat_description = $this->request->getPost('cat_description');
            $file = $this->request->getFile('cat_image');

            if ($file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('public/uploads/admin/category_image/', $newName);
                //$file->move($path);
            }
            $catImage = empty($newName) ? 'default_category_image.png' : $newName;
            $validated = $this->validate([
               /*  'language_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Language is Required',
                    ]
                ],  */
                'category_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Category Name is Required',
                    ]
                ], 
                'cat_description'=>[
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please Enter Discription is Required',
                    ]
                ],             
            ]);
            if (!$validated) {
               // die('Hello This not validated');
               $data['validation']  = $this->validator;
                return view('admin/includes/pages',$data);

            }else{
                $data = [
                    /*'language_id' => $language_name,*/
                    'category_name' => $category_name,
                    'category_image' => $catImage,
                    'category_description	' => $cat_description,
                ];
                $this->adminModel->insert_data(TBL_CATEGORY,$data);
                return redirect()->to('admin/ViewCategory')->with('status','Save Your Category Successfully !');
                }      

        }    
        
        return view('admin/includes/pages',$data);

    }
    public function edit_category($u_id){        
        $data['title'] = 'Pawar Handloom Admin | Category Edit'; // page title
        $data['page'] = 'admin/category/addCategory'; //page name
        $data['page_title'] = 'Category Edit'; //Page Title Name
        $data['active_link'] = 'admin/addCategory'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getCategoryData'] =  $this->adminModel->select_row(TBL_CATEGORY,$where);
        $where1 = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        
        return view('admin/includes/pages',$data);
    }
     
public function update_category() {
    $Edit_id = $this->request->getVar('Edit_id');
    
   // $language_name = $this->request->getVar('language_name');
    $category_name = $this->request->getVar('category_name');
    $cat_description = $this->request->getVar('cat_description');
    $file = $this->request->getFile('cat_image');

    $where = ['id' => $Edit_id];
    $data = [
        //'language_id' => $language_name,
        'category_name' => $category_name,
        'category_description' => $cat_description,
    ];
    if ($file && $file->isValid() && !$file->hasMoved()) {
        //die("Hiiiiiiiiiiiiiii");
        $newName = $file->getRandomName();
        $file->move('public/uploads/admin/category_image', $newName);
        $data['category_image'] = $newName;
    }
    // Retrieve the old image name if not updating image
    if (!isset($data['category_image'])) {
        $where = ['id' => $Edit_id];
        //$AdminModel = new AdminModel();
        $oldImage = $this->adminModel->select_row(TBL_CATEGORY, $where);
        // echo"<pre>";
        // print_r($oldImage);die;
        if ($oldImage->category_image) {
            $data['category_image'] = $oldImage->category_image;
        }
    }
    $result = $this->adminModel->update_data(TBL_CATEGORY, $where, $data);
    return json_encode($result);
}
/* SubCategory */
 public function viewSubCategory(){
    $data['title'] = 'Pawar Handloom Admin | Sub Categories'; // page title
    $data['page'] = 'admin/category/viewSubCategory'; //page name
    $data['page_title'] = 'Sub Category'; //Page Title Name
    $data['active_link'] = 'admin/ViewSubCategory'; //Page active link 
    $AdminModel = new AdminModel();
    $where = [
        'is_deleted' => '1',
    ];
    $TableFields = ['id','category_name'];
    $data['subcategoryList'] = $AdminModel->select_dataJoin(TBL_SUBCAT,TBL_CATEGORY,'cat_id','id',$where,$TableFields);

    //echo"<pre>"; print_r($data['subcategoryList']);die;
    
    return view('admin/includes/pages',$data);

}
public function addSubCategory(){
    $data['title'] = 'Pawar Handloom Admin | Add Sub Categories'; // page title
    $data['page'] = 'admin/category/addSubCategory'; //page name
    $data['page_title'] = 'Add Sub Category'; //Page Title Name
    $data['active_link'] = 'admin/addSubCategory'; //Page active link 
    //Get Category
    $AdminModel = new AdminModel();
    $where = [
        'is_deleted' => '1',
        'status' => '1',
    ];
    $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
    /*$where1 = [
        'is_deleted' => '1',
        'status' => '1',
    ];
    $data['languageList'] = $this->adminModel->select_data(TBL_LANG,$where1);*/

        //insert sub category in database
    if (isset($_POST['addSubCat'])) {
        //$language_name = $this->request->getPost('language_name');
        $category_name = $this->request->getPost('category_name');
        $name = $this->request->getPost('name');
        $cat_description = $this->request->getPost('cat_description');
        $file = $this->request->getFile('cat_image');

        if ($file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/uploads/admin/category_image/subCategory/', $newName);
            //$file->move($path);
        }
        $catImage = empty($newName) ? 'default_category_image.png' : $newName;              
         //validate 
         $validated = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Your Sub Category Name is Required',
                ]
            ],
            'category_name'=>[
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select Category is Required',
                ]
            ], 
            'cat_description'=>[
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Discription is Required',
                ]
            ],             
        ]);
        if (!$validated) {
           // die('Hello This not validated');
           $data['validation']  = $this->validator;
            return view('admin/includes/pages',$data);

        }else{
            $data = [
                /*'language_id' => $language_name,*/
                'cat_id' => $category_name,
                'name' => $name,
                'subCategory_image' => $catImage,
                'subCategory_description' => $cat_description,
                //'created_by' => 'testing', //when who's loggedin and create child category Email Id here
            ];
            $AdminModel->insert_data(TBL_SUBCAT,$data);
            return redirect()->to('admin/ViewSubCategory')->with('status','Save Your Sub Category Successfully !');
            }            
    }
    return view('admin/includes/pages',$data);

}
  // Get Sub Category
  public function getSubcategories()
  {
      $category_id = $this->request->getVar('id');
      $where = [
          'cat_id' => $category_id,
          'is_deleted' => '1',
          'status' => '1',
      ];
      $AdminModel = new AdminModel();
      $subcategories = $AdminModel->select_data(TBL_SUBCAT, $where);
      $response = [
            'status' => 'success',
            'data' => $subcategories
        ];

        return $this->response->setJSON($response);
      //return json_encode($subcategories);
  }
//Edit Sub Category
public function subCategoryEdit($u_id, $tableName){
    $data['title'] = 'Pawar Handloom Admin | Add Sub Categories'; // page title
    $data['page'] = 'admin/category/addSubCategory'; //page name
    $data['page_title'] = 'Add Sub Category'; //Page Title Name
    $data['active_link'] = 'admin/addSubCategory'; //Page active link 

    $id = base64_decode(urldecode($u_id));
    $table = base64_decode(urldecode($tableName));
    // echo"Id :-".$id."<pre>";
    // echo"Table :-".$table."<pre>";

    $AdminModel = new AdminModel();
    $where = [
        'id' => $id,
    ];
    $data['getCategoryData'] =  $AdminModel->select_row($table,$where);
    //echo"25-03-2025 <pre>"; print_r($data['getCategoryData']);die;
    //Get Category
        $where1 = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where1);
        
    return view('admin/includes/pages',$data);

}     
public function update_sub_category() {
    $Edit_id = $this->request->getVar('Edit_id');
    //$language_name = $this->request->getVar('language_name');
    $category_name = $this->request->getVar('category_name');
    $subCat_name = $this->request->getVar('subCat_name');
    $name = $this->request->getVar('name');
    $cat_description = $this->request->getVar('cat_description');
    $file = $this->request->getFile('cat_image');

    $where = ['id' => $Edit_id];
    $data = [
        
        'cat_id' => $category_name,
        'name' => $name,
        'subCategory_description' => $cat_description,
    ];
    if ($file && $file->isValid() && !$file->hasMoved()) {
        //die("Hiiiiiiiiiiiiiii");
        $newName = $file->getRandomName();
        $file->move('public/uploads/admin/category_image/subCategory', $newName);
        $data['subCategory_image'] = $newName;
    }
    // Retrieve the old image name if not updating image
    if (!isset($data['subCategory_image'])) {
        $where = ['id' => $Edit_id];
        //$AdminModel = new AdminModel();
        $oldImage = $this->adminModel->select_row(TBL_SUBCAT, $where);
        // echo"<pre>";
        // print_r($oldImage);die;
        if ($oldImage->subCategory_image) {
            $data['subCategory_image'] = $oldImage->subCategory_image;
        }
    }
    $result = $this->adminModel->update_data(TBL_SUBCAT, $where, $data);
    return json_encode($result);
}  
/* //SubCategory */
/* Get Category According to language */

public function get_category()
    {
        if ($this->request->isAJAX()) {
            $language_id = $this->request->getPost('language_id');
            $getCategory = $this->adminModel->getCategoryByLanguage($language_id);
            echo json_encode($getCategory);
        }
    }

/* //Get Category According to language */
/* Get Sub Category According to category */

public function get_sub_category() {
            // $category_id = $this->request->getPost('category_id');
            // $subCategories = $this->subCategoryModel->where('category_id', $category_id)->findAll();
            // return $this->response->setJSON($subCategories);
    if ($this->request->isAJAX()) {
        $category_id = $this->request->getPost('category_id');
        $getSubCategory = $this->adminModel->getSubCategoryByCategory($category_id);
         $response = [
            'status' => 'success',
            'data' => $getSubCategory
        ];

        return $this->response->setJSON($response);
        //echo json_encode($getSubCategory);
    }
}

/** Get SUb Sub Category  */
public function get_sub_sub_category() {
    // $category_id = $this->request->getPost('category_id');
    // $subCategories = $this->subCategoryModel->where('category_id', $category_id)->findAll();
    // return $this->response->setJSON($subCategories);
if ($this->request->isAJAX()) {
$category_id = $this->request->getPost('category_id');
$subcategory_id = $this->request->getPost('subcategory_id');
$getSubCategory = $this->adminModel->getsubSubCategoryByCategory($category_id,$subcategory_id);
echo json_encode($getSubCategory);
}
}
/** //Get Sub sub Category */

/* //Get Sub Category According to category  */

/** Sub SubCategory code start */
    public function viewsubSubCategory(){
        $data['title'] = 'Pawar Handloom Admin | Sub SubCategories'; // page title
        $data['page'] = 'admin/category/viewsubSubcategory'; //page name
        $data['page_title'] = 'Sub subCategory'; //Page Title Name
        $data['active_link'] = 'admin/ViewsubSubCategory'; //Page active link 

            //$AdminModel = new AdminModel();
            $AdminModel = new AdminModel();
            $where = [
                TBL_SUBSUBCAT.'.is_deleted' => '1',
            ];
            $TableFields1 = ['id', 'name']; 
            $TableFields2 = ['id', 'category_name'];   
            $data['subsubcategoryList'] = $AdminModel->select_dataJoin3tbl(
                TBL_SUBSUBCAT,  // Main Table (sub-subcategory)
                TBL_SUBCAT,     // First Join Table (subcategory)
                'sub_cat_id',    // Foreign Key in TBL_SUBSUBCAT linking to TBL_SUBCAT
                'id',           // Primary Key in TBL_SUBCAT
        
                TBL_CATEGORY,   // Second Join Table (category)
                'cat_id',       // Foreign Key in TBL_SUBCAT linking to TBL_CATEGORY
        
                $TableFields1,  // Fields from TBL_SUBCAT
                $TableFields2,  // Fields from TBL_CATEGORY
                $where          // Conditions
            );
            //echo"22603-2025 <pre>";print_r($data['subsubcategoryList']);die;
            return view('admin/includes/pages',$data);
    }

public function addsubSubCategory(){
    $data['title'] = 'Pawar Handloom Admin | Add Sub subCategories'; // page title
    $data['page'] = 'admin/category/addsubSubCategory'; //page name
    $data['page_title'] = 'Add Sub subCategory'; //Page Title Name
    $data['active_link'] = 'admin/addsubSubCategory'; //Page active link 
    //Get Category
    $AdminModel = new AdminModel();
    $where = [
        'is_deleted' => '1',
        'status' => '1',
    ];
    $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);

        //insert sub category in database
    if (isset($_POST['addsubSubCat'])) {
        //$language_name = $this->request->getPost('language_name');
        $category_name = $this->request->getPost('category_name');
        $sub_category_name = $this->request->getPost('sub_category_name');
        $name = $this->request->getPost('name');
        $cat_description = $this->request->getPost('cat_description');
        $file = $this->request->getFile('cat_image');

        if ($file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/admin/category_image/subCategory/', $newName);
            //$file->move($path);
        }
        $catImage = empty($newName) ? 'Best_Seller_1.avif' : $newName;              
         //validate 
         $validated = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Your Sub Category Name is Required',
                ]
            ],
            'category_name'=>[
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select Category is Required',
                ]
            ], 
            'cat_description'=>[
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Discription is Required',
                ]
            ],             
        ]);
        if (!$validated) {
           // die('Hello This not validated');
           $data['validation']  = $this->validator;
            return view('admin/includes/pages',$data);

        }else{
            $data = [
                /*'language_id' => $language_name,*/
                'cat_id' => $category_name,
                'sub_cat_id' => $sub_category_name,
                'name' => $name,
                'subsubCategory_image' => $catImage,
                'subsubCategory_description' => $cat_description,
                //'created_by' => 'testing', //when who's loggedin and create child category Email Id here
            ];
            //echo"26-033-2025 :- <pre>"; print_r($data);die;
            $AdminModel->insert_data(TBL_SUBSUBCAT,$data);
            return redirect()->to('admin/ViewsubSubCategory')->with('status','Save Your Sub subCategory Successfully !');
            }            
    }
    return view('admin/includes/pages',$data);   
}

public function subSubCategoryEdit($u_id, $tableName){
    $data['title'] = 'Pawar Handloom Admin | Add Sub sub Categories'; // page title
    $data['page'] = 'admin/category/addsubSubCategory'; //page name
    $data['page_title'] = 'Edit Sub Sub Category'; //Page Title Name
    $data['active_link'] = 'admin/addsubSubCategory'; //Page active link 

    $id = base64_decode(urldecode($u_id));
    $table = base64_decode(urldecode($tableName));
        //  echo"Id :-".$id."<pre>";
        //  echo"Table :-".$table."<pre>";
        //     die;
    $AdminModel = new AdminModel();
    $where = [
        'id' => $id,
    ];
    $data['getSubCategoryData'] =  $AdminModel->select_row($table,$where);
    //echo"25-03-2025 <pre>"; print_r($data['getSubCategoryData']);die;
    //Get Category
        $where1 = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where1);
        
    return view('admin/includes/pages',$data);

}     

/*Update sub category*/

public function update_sub_sub_category()
{
    $Edit_id = base64_decode(urldecode($this->request->getPost('id')));

    $category_id     = $this->request->getPost('category_name');
    $sub_category_id = $this->request->getPost('sub_category_name');
    $name            = $this->request->getPost('name');
    $description     = $this->request->getPost('cat_description');
    $file            = $this->request->getFile('cat_image');

    $where = ['id' => $Edit_id];

    // Base update data
    $data = [
        'cat_id'                    => $category_id,
        'sub_cat_id'                => $sub_category_id,
        'name'                      => $name,
        'subsubCategory_description'=> $description,
    ];

    /* ================= IMAGE UPDATE ================= */

    if ($file && $file->isValid() && !$file->hasMoved()) {

        $newName = $file->getRandomName();
        $file->move('uploads/admin/category_image/subCategory/', $newName);
        $data['subsubCategory_image'] = $newName;

        // delete old image (optional but recommended)
        $oldData = $this->adminModel->select_row(TBL_SUBSUBCAT, $where);
        if (!empty($oldData->subsubCategory_image)
            && file_exists('uploads/admin/category_image/subCategory/' . $oldData->subsubCategory_image)) {

            unlink('uploads/admin/category_image/subCategory/' . $oldData->subsubCategory_image);
        }

    } else {
        // keep old image if new not uploaded
        $oldData = $this->adminModel->select_row(TBL_SUBSUBCAT, $where);
        $data['subsubCategory_image'] = $oldData->subsubCategory_image;
    }

    /* ================= UPDATE QUERY ================= */

    $result = $this->adminModel->update_data(TBL_SUBSUBCAT, $where, $data);

    if ($result) {
        return redirect()
            ->to('admin/ViewsubSubCategory')
            ->with('status', 'Sub Sub Category Updated Successfully!');
    } else {
        return redirect()
            ->back()
            ->with('error', 'Something went wrong while updating!');
    }
}


/*//Update sub category*/

/** // Sub subCategory code End */


}
