<?php

namespace App\Controllers\FrontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendModel;


class HomeController extends BaseController
{
    protected $frontModel;
    public function __construct()
    {
        $this->frontModel = new FrontendModel();
        helper(['url','form',]);
        //$session = session();
        // Check authenticate
       
    }
    public function index()
    {
        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Home'; //page name
        $where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $limit = '4'; 
        $data['sliderList'] =  $this->frontModel->select_data(TBL_SLIDER,$where);
        $data['categoryList'] =  $this->frontModel->select_data(TBL_CATEGORY,$where,'','',$limit);
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        //Get New Arrivals product
        $where1 = [
            'category' => '6',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['NewArrivals'] =  $this->frontModel->select_data(TBL_PRODUCT,$where1);
        //Get Best Seller product
        $where2 = [
            'category' => '7',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['BestSellers'] =  $this->frontModel->select_data(TBL_PRODUCT,$where2);
        //Get Celebs Look product
        $where3 = [
            'category' => '8',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['CelebsLook'] =  $this->frontModel->select_data(TBL_PRODUCT,$where3);
        //echo"NewArrivals <pre>";print_r($data['NewArrivals']);die;

        //echo"<pre>"; print_r($data['sliderList']);die;

        return view('frontend/includes/pages',$data);
        
    }
    public function about(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | About'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/About'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    public function gallery(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Gallery'; // Page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
        $data['page'] = 'frontend/Gallery'; // Page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
    
        $where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
    
        $images = $this->frontModel->select_data(TBL_GALLERY, $where);
    
        // Group images by category
        $galleryData = [];
        foreach ($images as $img) {
            $galleryData[$img->cat_id][] = $img;
        }
    
        $data['galleryData'] = $galleryData; // Pass the grouped data to the view
    
        return view('frontend/includes/pages', $data);
    }
    
    public function contact(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Contact Us'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Contact'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    public function register(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Register'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Register'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    public function login(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Login'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Login'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    public function detail($productId){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Details'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Detail'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        $where = [
            'id' => $productId,
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['product'] =  $this->frontModel->select_data(TBL_PRODUCT,$where);
        return view('frontend/includes/pages',$data);
    }
    public function shop($categoryId){
        //die($categoryId);
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Shop'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Shop'; //page name
        $data['categoryId'] = $categoryId;
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);

            // Fetch category name
        $category = $this->frontModel->select_data(TBL_CATEGORY, [
            'id' => $categoryId,
            'is_deleted' => '1',
            'status' => '1'
        ]);

        $data['categoryName'] = !empty($category) ? $category[0]->category_name : '';

        // Fetch subcategories
        $data['subcategories'] = $this->frontModel->select_data(TBL_SUBCAT, [
            'cat_id' => $categoryId,
            'is_deleted' => '1',
            'status' => '1'
        ]);

        // Fetch sub-subcategories for each subcategory
        foreach ($data['subcategories'] as &$subcategory) {
            $subcategory->subsubcategories = $this->frontModel->select_data(TBL_SUBSUBCAT, [
                'sub_cat_id' => $subcategory->id,
                'is_deleted' => '1',
                'status' => '1'
            ]);
        }

        // Get selected sub-subcategories from the URL
        $selectedSubSubCategories = $this->request->getGet('subsubcat');
        $priceSort = $this->request->getGet('price_sort');
        $isAjax = $this->request->isAJAX();
        $where = [
            'category' => $categoryId,
            'is_deleted' => '1',
            'status' => '1',
        ];
        
    
        $subSubCatIds = !empty($selectedSubSubCategories) ? array_map('intval', $selectedSubSubCategories) : null;
        
        if ($isAjax && !empty($priceSort)) {
            // Apply sorting only for AJAX requests
            if ($priceSort == 'high_to_low') {
                $orderBy = ['offer_price' => 'DESC'];
            } elseif ($priceSort == 'low_to_high') {
                $orderBy = ['offer_price' => 'ASC'];
            }
        } else {
            $orderBy = null; // No sorting if it's not an AJAX request
        }

        // Fetch data from model
        $data['productList'] = $this->frontModel->select_data(TBL_PRODUCT, $where, null, $orderBy, null, $subSubCatIds);
        return view('frontend/includes/pages',$data);
    }
    public function profile(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Profile'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Profile'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        $session = session();
        $loginUserId =  $session->get('user_id');
        $where = [
            'id' => $loginUserId,
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['user'] =  $this->frontModel->select_data(TBL_USER,$where);
    
        return view('frontend/includes/pages',$data);
    }
    public function profileUpdate()
    {

        $session = session();
        $loginUserId =  $session->get('user_id');

        $data = [
            'name' => $this->request->getPost('name'),
            'company_name' => $this->request->getPost('company_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'whatsapp_no' => $this->request->getPost('whatsapp_no'),
            'address' => $this->request->getPost('address'),
        ];

        $where = [
            'id' => $loginUserId,
            'is_deleted' => '1',
            'status' => '1',
        ];
        $this->frontModel->update_data(TBL_USER,$where,$data);
        
        return redirect()->to('/profile')->with('success', 'Profile updated successfully');

}

}
