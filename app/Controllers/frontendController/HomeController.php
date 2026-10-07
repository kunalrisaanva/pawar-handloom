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
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
        }
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $this->frontModel = new FrontendModel();
        helper(['url','form',]);
        helper('text');
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
        $orderBy1 = [
            'column'    => 'id',
            'direction' => 'DESC',
        ];
        
        $limit1 = 4;
        $data['NewArrivals'] =  $this->frontModel->select_data(TBL_PRODUCT,$where1,null,$orderBy1,$limit1);
         //Get Dress Materials product
        $whered = [
            'category' => '3',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['DressMaterial'] =  $this->frontModel->select_data(TBL_PRODUCT,$whered,'','',$limit);
        //Get Best Seller product
        $where2 = [
            'category' => '7',
            'is_deleted' => '1',
            'status' => '1',
        ];
        
        $data['BestSellers'] =  $this->frontModel->select_data(TBL_PRODUCT,$where2);
         //See it, Love it  product
        $where6 = [
            'category' => '2',
            //'subcategory'=>'3', //wHEN HAVE ANY PRODUCT IN SEE IT LOVE PLEASE UNCOMMENT IT.
            'is_deleted' => '1',
            'status' => '1',
        ];
        
        $data['SeeitLoveit'] =  $this->frontModel->select_data(TBL_PRODUCT,$where6);
        //Get Celebs Look product
        $where3 = [
            'category' => '8',
            'is_deleted' => '1',
            'status' => '1',
        ];
        
        $data['CelebsLook'] =  $this->frontModel->select_data(TBL_PRODUCT,$where3);
        //Get Saree Sub Category
        $where4 = [
            'cat_id' => '2',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['SareeSubCat'] =  $this->frontModel->select_data(TBL_SUBCAT,$where4);
        //echo"SareeSubCat <pre>";print_r($data['SareeSubCat']);die;

        //echo"<pre>"; print_r($data['sliderList']);die;
        
        // show Maheshwari Sarees Sub Category 
        $where5 =[
            'cat_id' => 2,
            'sub_cat_id' => 1,
            'status' => 1,
            'is_deleted' => 1
            ];
        $data['SubCategoryMaheshwari'] = $this->frontModel->select_data(TBL_SUBSUBCAT,$where5);
        // echo"<pre>";
        // print_r($data['SubCategoryMaheshwari']);die;
        

        return view('frontend/includes/pages',$data);
        
        //Get Saree Sub Sub Category
        $wheresst = [
            'cat_id' => '2',
            'sub_cat_id' => '1',
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['SareeSubSubCat'] =  $this->frontModel->select_data(TBL_SUBSUBCAT,$wheresst);
        //echo"SareeSubCat <pre>";print_r($data['SareeSubCat']);die;

        //echo"<pre>"; print_r($data['sliderList']);die;

        return view('frontend/includes/pages',$data);
        
    }
    public function homeClone()
    {
        return view('frontend/HomeClone');
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
        
        if ($this->request->getMethod() === 'POST' && $this->request->getPost('contactSubmit')) {
            
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $subject_type = $this->request->getPost('subject_type');
            $message = $this->request->getPost('message');

        $insertData = [
            'name'         => $name,
            'email'        => $email,
            'subject_type' => $subject_type,
            'message'      => $message,
        ];
        
        // echo"InsertData:- <pre>";
        // print_r($insertData);die;

        $this->frontModel->insert_data(TBL_CONTACT, $insertData);
        
                // Build the email and send to Admin
        $message = '
                    <html>
                    <head>
                      <style>
                        table {
                          border-collapse: collapse;
                          width: 100%;
                        }
                        th, td {
                          border: 1px solid #333;
                          padding: 8px;
                          text-align: left;
                        }
                        th {
                          background-color: #f2f2f2;
                        }
                      </style>
                    </head>
                    <body>
                    
                    <p>Hello Mr. Pawar, we have received a new query.</p>
                    
                    <strong>Customer Contact Details:</strong><br><br>
                    
                    <table>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                      </tr>
                      <tr>
                        <td>'.$name.'</td>
                        <td>'.$email.'</td>
                        <td>'.$subject_type.'</td>
                        <td>'.$message.'</td>
                      </tr>
                    </table>
                    
                    <br>
                    <p>Regards,<br>Pawar Handloom Website</p>
                    
                    </body>
                    </html>';
                        
        $to = $email;                
        $admin_email = "pradeepdhakad543@gmail.com";  // Admin email
                $subject = "Query From Contact Form";

                // Email headers
                $headers = "From: info@pawarhandloom.com" . "\r\n" .
                           "Content-Type: text/html; charset=UTF-8";
        
                // Send email to customer
                mail($to, $subject, $message, $headers);
                
                // Send email to admin
                mail($admin_email, "Contact Query", $message, $headers);                

        // success message
        session()->setFlashdata('success', 'Thank you! Your Message has been Sent We Will Contact Soon...');

        return redirect()->to(base_url('contact'));
    }
        
        
        
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
    
    //customer login
    public function customer_login(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Customer Login'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Customer_Login'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    //Register Form Submit
         if ($this->request->getMethod() == 'POST' && $this->request->getPost('submitRegister')) {
             
             $email = $this->request->getPost('email');
             $pass = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
             $name = $this->request->getPost('name');
        //      echo"Name:- ".$name."<pre>";
        //      echo"Email:- ".$email."<pre>";
        //      echo"Pass:- ".$pass."<pre>";
             
        //   die('form submitted');
        
                $rules = [
                    //'name'  => 'required|min_length[3]|max_length[50]',
                    // 'email' => 'required|valid_email|is_unique['.TBL_USER.'.email]',
                    'email' => [
                        'rules'  => 'required|valid_email|is_unique[' . TBL_USER . '.email]',
                        'errors' => [
                            'required'  => 'Email is required.',
                            'valid_email' => 'Please enter a valid email address.',
                            'is_unique' => 'This email is already registered. Please login.'
                        ]
                    ],
                    //'phone' => 'required|numeric|min_length[10]|max_length[15]|is_unique['.TBL_USERS.'.phone]',
                    'password'  => 'required|min_length[6]|max_length[20]',
                    //'cpassword' => 'required|matches[password]',
                ];

                // if (! $this->validate($rules)) {
                //     //die('validation failed');
                //     $data['validation'] = $this->validator;
                // } 
                 if (! $this->validate($rules)) {
                        return redirect()->back()
                            ->with('error', $this->validator->getError('email') ?? 'Registration failed. Please try again.')
                            ->with('activeTab', 'register');
                    }
                else {
                    //die('validation success');
                    $insertData = [
                        'name'       => $this->request->getPost('name'),
                        'email'      => $this->request->getPost('email'),
                        //'phone'      => $this->request->getPost('phone'),
                        'password' => hash('sha256',trim($this->request->getPost('password'))),
                        //'password'   => $this->request->getPost('password'),
                        'role'     => 2,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    // echo "<pre>";
                    // print_r($insertData);die;
                    $this->frontModel->insert_data(TBL_USER, $insertData);
                    //$data['success'] = "Registration successful! You can now login.";
                    return redirect()->to(base_url('CustomerRegister'))
    ->with('success', 'Registration successful! You can now login.')
    ->with('activeTab', 'register');
                }
            }
            
            // ✅ Login Form Submit
        if ($this->request->getMethod() == 'POST' && $this->request->getPost('submitLogin')) {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required'
            ];
    
            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $email    = $this->request->getPost('email');
                $password = $this->request->getPost('password');
    
                
                $user = $this->frontModel->select_row(TBL_USER, ['email' => $email]);
                // echo"Paswword:- ".$password;
                // echo"<pre>Check User:- <pre>";
                // print_r($user);
                $changPass = hash('sha256',trim($this->request->getPost('password')));
                
                // echo"ChangePass:- <pre>".$changPass;
                
                // die;
               
    
                if ($user) {
                    if ($changPass === $user->password) {
                        // ✅ Session set
                        $session = session();
                        
                        $sessionData = [
                             'id'    => $user->id,
                            'name'  => $user->name,
                            'email' => $user->email,
                            //'phone' => $user->phone,
                            'role' => $user->role,
                            'is_logged_in' => true
                        ];
                        //$session = session();
                        $session->set($sessionData);
                        
                        // $session->set('userData', [
                        //     'id'    => $user->id,
                        //     'name'  => $user->name,
                        //     'email' => $user->email,
                        //     //'phone' => $user->phone,
                        //     'role' => $user->role,
                        //     'is_logged_in' => true
                        // ]);
                         //$session->set($sessionData);
                        // echo"check Session:- <pre>";
                        // print_r($session->get('userData'));
                        // //print_r($session);
                        // die;
                        $redirect = $session->get('redirect_after_login');

                        if(!empty($redirect)){
    
                            $session->remove('redirect_after_login');
    
                            return redirect()->to($redirect);
    
                        }
                        
                        return redirect()->to(base_url('/')); 
                    } else {
                        //$data['error'] = "Invalid password!";
                         return redirect()->back()->with('error', 'Invalid password!');
                    }
                } else {
                    //$data['error'] = "No account found with this email!";
                    return redirect()->back()->with('error', 'No account found with this email!');
                }
            }
        }



        return view('frontend/includes/pages',$data);
    }
    
    //customer forget password
    public function lostPassword(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Customer Login'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Lost_Password'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    
    //customer cart
    public function customer_cart(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Customer Cart'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Customer_Cart'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    
    //customer checkout
    public function customer_checkout(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Customer Checkout'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Customer_Checkout'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
    
    
    
    public function detail($productId){
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        
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
        //echo"Product:-<pre>";
        //print_r($data['product'][0]->subcategory);die;
        $where1 = [
            'subcategory' => $data['product'][0]->subcategory,
            'category' => $data['product'][0]->category,
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['relatedProduct'] =  $this->frontModel->select_data(TBL_PRODUCT,$where1);
        
        //Fetch Colour Details
        $colourIds = explode(',', $data['product'][0]->colour);

        $data['productColours'] = [];

        if (!empty($colourIds)) {
            foreach ($colourIds as $cid) {
                $whereColour = [
                    'id'         => trim($cid),
                    'status'     => '1',
                    'is_deleted' => '1',
                ];
        
                $colour = $this->frontModel->select_data(TBL_COLOURS, $whereColour);
        
                if (!empty($colour)) {
                    $data['productColours'][] = $colour[0];
                }
            }
        }

        
        
        //echo"<pre>";
        //print_r($data['relatedProduct']);die;
        return view('frontend/includes/pages',$data);
    }
    public function shop($categoryId = null, $subcategoryId = null, $subsubcatId = null)
{
    $data['title'] = 'Pawar Handloom By Piyush Pawar | Shop';
    $data['description'] = 'Pawar Handloom By Piyush Pawar';
    $data['page'] = 'frontend/Shop';

    $data['categoryId'] = $categoryId;
    $data['subcategoryId'] = $subcategoryId;
    $data['subsubcatId'] = $subsubcatId;

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

    $where = [
        'category' => $categoryId,
        'is_deleted' => '1',
        'status' => '1',
    ];

    // Add filters if subcategory or subsubcat are present
    if ($subcategoryId) {
        $where['subcategory'] = $subcategoryId;
    }

    if ($subsubcatId) {
        $where['sub_subcategory'] = $subsubcatId;
    }

    // Sorting
    
    $session = session();
    $role = $session->get('role'); 
    
    // echo"Check Role<pre>";
    // print_r($role);die;
    
    $priceSort = $this->request->getGet('price_sort');
    $isAjax = $this->request->isAJAX();

    $orderBy = null;
    if ($isAjax && !empty($priceSort)) {
        //$priceColumn = ($role == 1) ? 'actual_price' : 'actual_price_customer';
    
        $priceColumn = (!empty($role) && $role == 1)
    ? 'actual_price'
    : 'actual_price_customer';


        if ($priceSort == 'high_to_low') {
            $orderBy = ['column' => $priceColumn, 'direction' => 'DESC'];
        } elseif ($priceSort == 'low_to_high') {
            $orderBy = ['column' => $priceColumn, 'direction' => 'ASC'];
        }
    }

    // Fetch products
    
        // echo"Check OrderBy :- <pre>";
        // print_r($orderBy);die;
    $productList = $this->frontModel->select_data(TBL_PRODUCT, $where, '', $orderBy);

    // Attach quantity info
    foreach ($productList as &$product) {
        $totalQty = getProductTotalQuntity($product->id)->product_quantity ?? 0;
        $soldQty = manageProductSellQuntity($product->id)->qty ?? 0;

        $product->total_qty = $totalQty;
        $product->sold_qty = $soldQty;
        $product->is_sold_out = ($soldQty >= $totalQty && $totalQty > 0);
    }

    $data['productList'] = $productList;

    return view('frontend/includes/pages', $data);
}

    
    /*public function profile(){
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Profile'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Profile'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        $session = session();
        $loginUserId = $session->get('user_id') ?? $session->get('id');
        //$loginUserId =  $session->get('user_id');
        $where = [
            'id' => $loginUserId,
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['user'] =  $this->frontModel->select_data(TBL_USER,$where);
    
        return view('frontend/includes/pages',$data);
    }*/
    
    public function profile()
{
    // ==================================================
    // PAGE DATA
    // ==================================================
    $data['title'] = 'Pawar Handloom By Piyush Pawar | Profile';
    $data['description'] = 'Pawar Handloom By Piyush Pawar';
    $data['page'] = 'frontend/Profile';

    // ==================================================
    // FETCH DYNAMIC MENU
    // ==================================================
    $data['categoryMenu'] = getCategoryMenu(
        $this->frontModel
    );

    // ==================================================
    // SESSION
    // ==================================================
    $session = session();

    // ==================================================
    // GET LOGGED-IN USER ID
    // ==================================================
    $loginUserId = $session->get('user_id')
        ?? $session->get('id');

    // ==================================================
    // CHECK LOGIN
    // ==================================================
    if (empty($loginUserId)) {

        // Save current URL for redirect after login
        $session->set(
            'redirect_url',
            current_url()
        );

        $session->setFlashdata(
            'error',
            'Please login to access your profile.'
        );

        return redirect()->to(
            base_url('Login')
        );
    }

    // ==================================================
    // GET USER DETAILS
    // ==================================================
    $where = [
        'id' => $loginUserId,
        'is_deleted' => '1',
        'status' => '1',
    ];

    $user = $this->frontModel->select_data(
        TBL_USER,
        $where
    );

    $data['user'] = !empty($user)
        ? $user
        : [];

    // ==================================================
    // GET USER ADDRESSES
    // ==================================================
    $addressWhere = [
        'user_id' => $loginUserId,
        'is_deleted' => '0',
        'status' => '1',
    ];

    $addresses = $this->frontModel->select_data(
        TBL_USER_ADDRESS,
        $addressWhere
    );

    // ==================================================
    // SAVE ADDRESSES IN DATA
    // ==================================================
    $data['addresses'] = !empty($addresses)
        ? $addresses
        : [];

    // ==================================================
    // ADDRESS COUNT
    // ==================================================
    $data['addressCount'] = count(
        $data['addresses']
    );

    // ==================================================
    // GET USER ORDERS
    // ==================================================
    $orderWhere = [
        'login_user_id' => $loginUserId,
    ];

    $orders = $this->frontModel->select_data(
        TBL_ORDER,
        $orderWhere
    );

    // ==================================================
    // SAVE ORDERS IN DATA
    // ==================================================
    $data['orders'] = !empty($orders)
        ? $orders
        : [];

    // ==================================================
    // ORDER COUNT
    // ==================================================
    $data['orderCount'] = count(
        $data['orders']
    );

    // ==================================================
    // RETURN PROFILE PAGE
    // ==================================================
    return view(
        'frontend/includes/pages',
        $data
    );
}
    
    
    
    public function profileUpdate()
    {

        $session = session();
        $loginUserId = $session->get('user_id') ?? $session->get('id');
        //$loginUserId =  $session->get('user_id');

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
public function catlog(){
    $data['title'] = 'Pawar Handloom By Piyush Pawar | Catlog'; // Page title
    $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
    $data['page'] = 'frontend/Catlog'; // Page name
    // Fetch Dynamic Menu
    $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    $where = [
        'is_deleted' => '1',
        'status' => '1',
    ];

    $images = $this->frontModel->select_data(TBL_CATLOG, $where);

    // Group images by category
    $galleryData = [];
    foreach ($images as $img) {
        $galleryData[$img->cat_id][] = $img;
    }

    $data['galleryData'] = $galleryData; // Pass the grouped data to the view

    return view('frontend/includes/pages', $data);

}
public function userOrders() {
    $data['title'] = 'Pawar Handloom By Piyush Pawar | Orders'; // page title
    $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
    $data['page'] = 'frontend/OrderHistory'; // page name

    // Fetch Dynamic Menu
    $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    $session = session();
    //$loginUserId = $session->get('user_id');
    $loginUserId = $session->get('user_id') ?? $session->get('id');

    $where = [
        'login_user_id' => $loginUserId,
        'is_deleted' => '1',
        'status' => '1',
    ];
    
    $order_by = [
        'column' => 'order_id',
        'direction' => 'DESC'
    ];

    // Fetch user's orders
    $orders = $this->frontModel->select_data(TBL_ORDER, $where, null, $order_by);
    $userOrders = [];

    // Fetch all active order statuses
    $statusResult = $this->frontModel->select_data('tbl_order_status', [
        'is_deleted' => '1',
        'status' => '1'
    ]);

    // Map statuses by ID
    $statusMap = [];
    foreach ($statusResult as $status) {
        $statusMap[$status->id] = [
            'name' => $status->status_name,
            'color' => $status->status_color
        ];
    }

    // Loop through orders and attach items + readable status
    foreach ($orders as $order) {
        $orderId = $order->order_id;

        $itemWhere = [
            'order_id' => $orderId,
            'is_deleted' => '1',
            'status' => '1',
        ];

        $orderItems = $this->frontModel->select_data(TBL_ORDERITEMS, $itemWhere);
        $order->items = $orderItems;

        //  Add status name and color
        $statusId = $order->order_status;
        $order->status_name = isset($statusMap[$statusId]) ? $statusMap[$statusId]['name'] : 'Unknown';
        $order->status_color = isset($statusMap[$statusId]) ? $statusMap[$statusId]['color'] : 'grey';

        $userOrders[] = $order;
    }

    $data['userOrders'] = $userOrders;

    return view('frontend/includes/pages', $data);
}
        /*Single Order Details */
        
public function orderDetails($orderId)
{

    $session = session();
    $loginUserId = $session->get('user_id') ?? $session->get('id');

    if(!$loginUserId){
        return redirect()->to('/login');
    }

    $data['title'] = 'Order Details | Pawar Handloom';
    $data['description'] = 'Pawar Handloom Order Details';
    $data['page'] = 'frontend/OrderDetails';

    $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    /* Fetch order */

    $order = $this->frontModel->select_row(
        TBL_ORDER,
        [
            'order_id' => $orderId,
            'login_user_id' => $loginUserId,
            'is_deleted' => '1',
            'status' => '1'
        ]
    );

    if(!$order){
        return redirect()->to('/my-orders');
    }

    /* Fetch order items */

    $orderItems = $this->frontModel->select_data(
        TBL_ORDERITEMS,
        [
            'order_id' => $orderId,
            'is_deleted' => '1',
            'status' => '1'
        ]
    );

    $order->items = $orderItems;

    /* Fetch order status */

    $status = $this->frontModel->select_row(
        'tbl_order_status',
        [
            'id' => $order->order_status
        ]
    );

    $order->status_name = $status->status_name ?? 'Unknown';
    $order->status_color = $status->status_color ?? '#999';

    $data['order'] = $order;

    return view('frontend/includes/pages',$data);

}        
        
        /*//Single Order Details*/

    /*Coupon apply */
    public function applyCoupon()
    {
        //die("checkcoupan");
    
        $session = session();
    
        $couponCode = trim($this->request->getPost('coupon_code'));
    
        $cart = $session->get('cart') ?? [];
    
        if(empty($cart)){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Cart is empty'
            ]);
        }
    
        /* CART TOTAL */
    
        $cartTotal = 0;
    
        foreach($cart as $item){
    
            $cartTotal += $item['offer_price'] * $item['qty'];
    
        }
    
    
        /* FETCH COUPON */
    
        $coupon = $this->frontModel->select_row('tbl_coupon',[
            'name'=>$couponCode,
            'status'=>1,
            'is_deleted'=>1
        ]);
        // echo"Check Coupon1 <pre>";
        // print_r($coupon);
        // die;
    
        if(!$coupon){
    
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Invalid coupon code'
            ]);
    
        }
    
    
        /* DATE VALIDATION */
    
        $today = date('Y-m-d');
    
        if($today < $coupon->start_date || $today > $coupon->end_date){
    
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Coupon expired'
            ]);
    
        }
    
    
        /* MINIMUM AMOUNT CHECK */
    
        if($coupon->minimum_amount > 0 && $cartTotal < $coupon->minimum_amount){
    
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Minimum order amount should be ₹'.$coupon->minimum_amount
            ]);
    
        }
    
        /*Get Coupon type */
        
        $couponType = $this->frontModel->select_row(
            'tbl_coupontype',
            [
                'id'=>$coupon->coupon_type,
                'status'=>1,
                'is_deleted'=>1
            ]
        );
        
        /*//Get coupon type*/
        if(!$couponType){
            return $this->response->setJSON([
                'status'=>'error',
                'message'=>'Coupon type not found'
            ]);
        }
        
    
        /* DISCOUNT CALCULATION */
            
    
        /*if(strtolower($coupon->coupon_type) == "percentage"){
    
            $discount = ($cartTotal * $coupon->coupan_value) / 100;
    
        }else{
    
            $discount = $coupon->coupan_value;
    
        }*/
        // echo"Check Coupon15-03 <pre>";
        // print_r($couponType);die;
        $discount = calculateDiscount(
            $couponType->code,   // coupon type name (percentage / flat)
            $cartTotal,
            $coupon->coupan_value
        );
    
    
        /* STORE COUPON AMOUNT WITH CODE IN SESSION */
    
        $session->set('coupon',[
    
            'id' => $coupon->id,
            'code' => $coupon->name,
            'discount' => $discount
    
        ]);
    
    
        return $this->response->setJSON([
    
            'status'=>'success',
            'message'=>'Coupon applied successfully',
            'discount'=>number_format($discount,2)
    
        ]);
    
    }
    /*//Coupon apply*/
    
    /*Payment Failed*/
    public function paymentFailed()
    {
        $session = session();
    
        $data['title'] = 'Payment Failed | Pawar Handloom';
        $data['description'] = 'Payment Failed Page';
    
        $data['page'] = 'frontend/payment_failed';
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
    
        return view('frontend/includes/pages', $data);
    
    }
    /*//Payment Failed*/


/*Address functions start*/

public function addAddress()
{
    $session = session();

    // ==================================================
    // GET LOGGED-IN USER ID
    // ==================================================
    $loginUserId = $session->get('user_id') ?? $session->get('id');

    // ==================================================
    // CHECK LOGIN
    // ==================================================
    if (empty($loginUserId)) {

        $session->setFlashdata(
            'error',
            'Please login to add an address.'
        );

        return redirect()->to(
            base_url('CustomerLogin')
        );
    }

    // ==================================================
    // GET EXISTING ACTIVE ADDRESSES
    // ==================================================
    $addressWhere = [
        'user_id'    => $loginUserId,
        'is_deleted' => '0',
        'status'     => '1',
    ];

    $addresses = $this->frontModel->select_data(
        TBL_USER_ADDRESS,
        $addressWhere
    );

    // If no addresses found
    if (empty($addresses)) {
        $addresses = [];
    }

    // ==================================================
    // MAXIMUM 5 ADDRESSES
    // ==================================================
    if (count($addresses) >= 5) {

        return redirect()
            ->to(base_url('profile'))
            ->with(
                'error',
                'You can save maximum 5 addresses.'
            );
    }

    // ==================================================
    // VALIDATION
    // ==================================================
    $rules = [

        'full_name' => [
            'label' => 'Full Name',
            'rules' => 'required|min_length[3]|max_length[100]'
        ],

        'phone' => [
            'label' => 'Phone Number',
            'rules' => 'required|numeric|min_length[10]|max_length[15]'
        ],

        'alternate_phone' => [
            'label' => 'Alternate Phone',
            'rules' => 'permit_empty|numeric|min_length[10]|max_length[15]'
        ],

        'country' => [
            'label' => 'Country',
            'rules' => 'required|max_length[100]'
        ],

        'state' => [
            'label' => 'State',
            'rules' => 'required|max_length[100]'
        ],

        'city' => [
            'label' => 'City',
            'rules' => 'required|max_length[100]'
        ],

        'pincode' => [
            'label' => 'Pincode',
            'rules' => 'required|max_length[10]'
        ],

        'house_no' => [
            'label' => 'House / Flat / Building',
            'rules' => 'required|max_length[255]'
        ],

        'street' => [
            'label' => 'Area / Street',
            'rules' => 'required|max_length[255]'
        ],

        'landmark' => [
            'label' => 'Landmark',
            'rules' => 'permit_empty|max_length[255]'
        ],

        'address_type' => [
            'label' => 'Address Type',
            'rules' => 'required|in_list[home,office,other]'
        ],
    ];

    // ==================================================
    // CHECK VALIDATION
    // ==================================================
    if (!$this->validate($rules)) {

        $errors = $this->validator->getErrors();

        return redirect()
            ->to(base_url('profile'))
            ->withInput()
            ->with('addressErrors', $errors);
    }

    // ==================================================
    // FIRST ADDRESS = DEFAULT
    // ==================================================
    $isDefault = (count($addresses) === 0) ? 1 : 0;

    // ==================================================
    // INSERT DATA
    // ==================================================
    $insertData = [

        'user_id' => $loginUserId,

        'full_name' => trim(
            $this->request->getPost('full_name')
        ),

        'phone' => trim(
            $this->request->getPost('phone')
        ),

        'alternate_phone' => trim(
            $this->request->getPost('alternate_phone')
        ),

        'country' => trim(
            $this->request->getPost('country')
        ),

        'state' => trim(
            $this->request->getPost('state')
        ),

        'city' => trim(
            $this->request->getPost('city')
        ),

        'pincode' => trim(
            $this->request->getPost('pincode')
        ),

        'house_no' => trim(
            $this->request->getPost('house_no')
        ),

        'street' => trim(
            $this->request->getPost('street')
        ),

        'landmark' => trim(
            $this->request->getPost('landmark')
        ),

        'address_type' => $this->request->getPost(
            'address_type'
        ),

        // First address = default
        'is_default' => $isDefault,

        // Active
        'status' => '1',

        // NOT deleted
        'is_deleted' => '0',

        'created_at' => date('Y-m-d H:i:s'),

        'updated_at' => date('Y-m-d H:i:s'),
    ];

    // ==================================================
    // INSERT ADDRESS
    // ==================================================
    $this->frontModel->insert_data(
        TBL_USER_ADDRESS,
        $insertData
    );

    // ==================================================
    // REDIRECT SOURCE
    // ==================================================
    $addressSource = $this->request->getPost(
        'address_source'
    );

    if (
        !in_array(
            $addressSource,
            ['profile', 'checkout'],
            true
        )
    ) {
        $addressSource = 'profile';
    }

    // ==================================================
    // REDIRECT URL
    // ==================================================
    $redirectUrl = ($addressSource === 'checkout')
        ? base_url('checkout')
        : base_url('profile');

    // ==================================================
    // SUCCESS
    // ==================================================
    return redirect()
        ->to($redirectUrl)
        ->with(
            'success',
            'Address added successfully.'
        );
}

public function setDefaultAddress($addressId)
{
    $session = session();

    // Check login
    if (!$session->has('userData')) {

        $session->setFlashdata(
            'error',
            'Please login to manage your address.'
        );

        return redirect()->to(base_url('Login'));
    }

    // Get logged-in user
    $userData = $session->get('userData');

    $loginUserId = $userData['id'] ?? null;

    if (!$loginUserId) {

        $session->setFlashdata(
            'error',
            'Your session has expired. Please login again.'
        );

        return redirect()->to(base_url('Login'));
    }

    // Check address belongs to current user
    $address = $this->frontModel->select_data(
        TBL_USER_ADDRESS,
        [
            'id'         => $addressId,
            'user_id'    => $loginUserId,
            'is_deleted' => '1',
            'status'     => '1',
        ]
    );

    if (empty($address)) {

        return redirect()
            ->to(base_url('profile'))
            ->with('error', 'Address not found.');
    }

    // Remove default from all user's addresses
    $this->frontModel->update_data(
        TBL_USER_ADDRESS,
        [
            'user_id'    => $loginUserId,
            'is_deleted' => '1',
            'status'     => '1',
        ],
        [
            'is_default' => 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );

    // Set selected address as default
    $this->frontModel->update_data(
        TBL_USER_ADDRESS,
        [
            'id'         => $addressId,
            'user_id'    => $loginUserId,
            'is_deleted' => '1',
            'status'     => '1',
        ],
        [
            'is_default' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );

    return redirect()
        ->to(base_url('profile'))
        ->with(
            'success',
            'Default address updated successfully.'
        );
}
    
public function deleteAddress($addressId)
{
    $session = session();

    // Check login
    if (!$session->has('userData')) {

        return redirect()->to(base_url('Login'));
    }

    $userData = $session->get('userData');

    $loginUserId = $userData['id'] ?? null;

    if (!$loginUserId) {

        return redirect()->to(base_url('Login'));
    }

    // Find address
    $address = $this->frontModel->select_data(
        TBL_USER_ADDRESS,
        [
            'id'         => $addressId,
            'user_id'    => $loginUserId,
            'is_deleted' => '1',
            'status'     => '1',
        ]
    );

    if (empty($address)) {

        return redirect()
            ->to(base_url('profile'))
            ->with('error', 'Address not found.');
    }

    // Soft delete
    $this->frontModel->update_data(
        TBL_USER_ADDRESS,
        [
            'id'      => $addressId,
            'user_id' => $loginUserId,
        ],
        [
            'is_deleted' => '0',
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );

    // If deleted address was default,
    // automatically make another address default.
    if ((int)$address[0]->is_default === 1) {

        $remainingAddresses = $this->frontModel->select_data(
            TBL_USER_ADDRESS,
            [
                'user_id'    => $loginUserId,
                'is_deleted' => '1',
                'status'     => '1',
            ]
        );

        if (!empty($remainingAddresses)) {

            $newDefaultId = $remainingAddresses[0]->id;

            $this->frontModel->update_data(
                TBL_USER_ADDRESS,
                [
                    'id'         => $newDefaultId,
                    'user_id'    => $loginUserId,
                    'is_deleted' => '1',
                    'status'     => '1',
                ],
                [
                    'is_default' => 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
    }

    return redirect()
        ->to(base_url('profile'))
        ->with(
            'success',
            'Address deleted successfully.'
        );
}    



/*Address functions end*/












}
