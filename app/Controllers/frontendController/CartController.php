<?php

namespace App\Controllers\FrontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendModel;
use CodeIgniter\Email\Email;
use App\Libraries\EmailHelper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CartController extends BaseController
{
    protected $frontModel;
    public function __construct()
    {
        $this->frontModel = new FrontendModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
       
    }
   
    public function index()
{
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit(0);
    }

    //die('Hello');
    $session = session();

    // Get post data
    $id = $this->request->getPost('id');
    $name = $this->request->getPost('product_name');
    $price = $this->request->getPost('offer_price');
    $qty = $this->request->getPost('qty');
    $image = $this->request->getPost('image'); // Capture image
    $color = $this->request->getPost('color');
    
     // UNIQUE CART KEY (product + color)
    $cartKey = $id . '_' . $color;

    // Fetch existing cart from session
    $cart = $session->get('cart') ?? [];

    // If product already exists, increase quantity
    
    /*if (isset($cart[$id])) {
        $cart[$id]['qty'] += $qty;
    } else {
        // Add new item
        $cart[$id] = [
            'id' => $id,
            'product_name' => $name,
            'offer_price' => $price,
            'qty' => $qty,
            'image' => $image, // Store image in cart
            'color' => $color
        ];
    }*/
    if (isset($cart[$cartKey])) {
        // Same product + same color → increase qty
        $cart[$cartKey]['qty'] += $qty;
    } else {
        // New product OR new color
        $cart[$cartKey] = [
            'id'           => $id,
            'product_name' => $name,
            'offer_price'  => $price,
            'qty'          => $qty,
            'image'        => $image,
            'color'        => $color
        ];
    }

    // Save cart back to session
    $session->set('cart', $cart);

    // Prepare response
    // $response = [
    //     'status' => 'success',
    //     'message' => 'Product added to cart!',
    //     'totalItems' => count($cart),
    //     'cartHtml' => $this->getCartHtml($cart) // Function to update mini-cart dynamically
    // ];

$cartData = $this->getCartHtml($cart);

return $this->response->setJSON([
    'status'   => 'success',
    'message' => 'Product added to cart!',
    'totalItems' => count($cart),
    'cartHtml' => $cartData['html'],     
    'subTotal' => $cartData['subtotal']  
]);


    return $this->response->setJSON($response);
}

public function apiGetCart()
{
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit(0);
    }

    $session = session();
    $cart = $session->get('cart') ?? [];
    $cartData = $this->getCartHtml($cart);

    return $this->response->setJSON([
        'status' => 'success',
        'items' => array_values($cart),
        'subTotal' => $cartData['subtotal'],
        'totalItems' => count($cart)
    ]);
}


    public function showCart()
    {
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        //  echo"Cate Items :- <pre>";
        //  print_r($data['cartItems']);die;

        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Cart'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        
        return view('frontend/includes/pages',$data);



        //return view('frontend/cart', $data); // your cart view page
    }

    public function remove($id)
    {
        $session = session();
        $cart = $session->get('cart');
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
        }

        return redirect()->to('/cart');
    }

    public function apiUpdateQty()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

        $session = session();
        $cartKey = $this->request->getPost('cartKey');
        $action = $this->request->getPost('action'); // 'increase' or 'decrease'
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$cartKey])) {
            if ($action === 'increase') {
                $cart[$cartKey]['qty'] += 1;
            } elseif ($action === 'decrease') {
                if ($cart[$cartKey]['qty'] > 1) {
                    $cart[$cartKey]['qty'] -= 1;
                } else {
                    unset($cart[$cartKey]);
                }
            }
            $session->set('cart', $cart);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Cart updated']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found in cart']);
    }

    public function apiRemove()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

        $session = session();
        $cartKey = $this->request->getPost('cartKey');
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            $session->set('cart', $cart);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Item removed']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Item not found']);
    }

    public function checkout(){
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        
        $loginUserId = $session->get('user_id') ?? $session->get('id');
        
        $UserRole = $session->get('role');
        
        // echo"Check Login Session:- <pre>";
        // print_r($UserRole);
        // die;

        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        
        //$data['page'] = 'frontend/Checkout'; //page name
        $data['page'] = ($UserRole == 1) ? 'frontend/Checkout' : 'frontend/Customer_Checkout'; //Page Name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        
        return view('frontend/includes/pages',$data);

    }
    /*New PlaceOrder*/
    
public function placeOrder()
{
    $session = session();
    $loginUserId = $session->get('user_id') ?? $session->get('id');
    
    /* COUPON DATA FROM FORM */

    // $coupon_code     = $this->request->getPost('coupon_code');
    // $discount_amount = (float)$this->request->getPost('discount_amount');
    // $grand_total     = (float)$this->request->getPost('grand_total');
    // echo"Check LoginID:-<pre>";
    // print_r($loginUserId);die;
    
    // Check user login
    if(empty($loginUserId)){

        // after login redirect back to checkout
        $session->set('redirect_after_login', base_url('checkout'));

        return redirect()->to(base_url('CustomerLogin'))
        ->with('error','Please login to place order');

    }
    
    $session_id = session_id();
    //  echo"Check session Id PlaceOrder :- <pre>";
    //  print_r($session_id);
    //  die;
    $cartItems = $session->get('cart') ?? [];

    if (empty($cartItems)) {
        return redirect()->back()->with('error', 'Cart is empty');
    }

    $total_amount = array_sum(array_map(function ($item) {
        return $item['offer_price'] * $item['qty'];
    }, $cartItems));

    $order_number = 'PH' . date('YmdHis');
    
    /* COUPON FROM SESSION */

    $couponSession = $session->get('coupon');

    $discount = 0;
    $couponCode = '';
    $couponId = 0;

    if(!empty($couponSession)){

        $discount = $couponSession['discount'];
        $couponCode = $couponSession['code'];
        $couponId = $couponSession['id'];

    }


    /* FINAL AMOUNT */

    $grandTotal = $total_amount - $discount;

    $orderData = [
        'order_number' => $order_number,
        'login_user_id' => $loginUserId,
        'first_name' => $this->request->getPost('first_name') ?? '',
        'last_name' => $this->request->getPost('last_name') ?? '',
        'company_name' => $this->request->getPost('company_name') ?? '',
        'address' => $this->request->getPost('address') ?? '',
        'city' => $this->request->getPost('city') ?? '',
        'state' => $this->request->getPost('state') ?? '',
        'zipcode' => $this->request->getPost('zipcode') ?? '',
        'country' => $this->request->getPost('country') ?? '',
        'phone' => $this->request->getPost('phone') ?? '',
        'email_id' => $this->request->getPost('email') ?? '',
        'notes' => $this->request->getPost('notes') ?? '',
        //'total_amount' => $total_amount,
        'payment_status' => 'Pending',
        'payment_mode' => 'HDFC',
        'order_status' => 0,
        'session_id'     => session_id(),
        'subtotal' => number_format($total_amount, 2, '.', ''), // $total_amount,
        'coupon_code' => $couponCode,
        'coupon_id' => $couponId,
        'discount_amount' =>number_format($discount, 2, '.', ''), // $discount,

        'total_amount' => number_format($grandTotal, 2, '.', ''), //$grandTotal,
        
    ];

    $order_id = $this->frontModel->insert_data(TBL_ORDER, $orderData);

    foreach ($cartItems as $item) {
        $itemData = [
            'order_id' => $order_id,
            'product_id' => $item['id'],
            'product_name' => $item['product_name'],
            'price' => $item['offer_price'],
            'qty' => $item['qty'],
            'color' => $item['color'],
            'subtotal' => $item['offer_price'] * $item['qty'],
            'image' => $item['image'],
        ];
        $this->frontModel->insert_data(TBL_ORDERITEMS, $itemData);
    }

    //  Redirect to HDFC
    return $this->redirectToHDFC($order_number, $grandTotal);
}
private function redirectToHDFC($order_number, $amount)
{
    $client = \Config\Services::curlrequest();

    $payload = [
        //"merchantId" => getenv('HDFC_MERCHANT_ID'),
        "order_id"    => $order_number.'-'.number_format($amount, 2, '.', ''),
        "amount"     => number_format($amount, 2, '.', ''),
        //"order_check"    => $order_number.'-'.number_format($amount, 2, '.', ''),
        "currency"   => "INR",
        "return_url"  => base_url('payment-response'),
        //"payment_page_client_id"=>"hdfcmaster",
        "payment_page_client_id"=>"66238",

        "customerEmail"  => $this->request->getPost('email') ?? '',
        "customerMobile" => $this->request->getPost('phone') ?? '',
        "customerName"   => trim(
            ($this->request->getPost('first_name') ?? '') . ' ' .
            ($this->request->getPost('last_name') ?? '')
        ),
        //'Authorization' => 'Basic ' . base64_encode(getenv('HDFC_ACCESS_CODE') . ':')
    ];
    // $checkURL =  getenv('HDFC_INITIATE_URL');
    // echo"check URL:- ".$checkURL."<pre>" ;
    // echo"check Playload:- <pre>";
    // print_r($payload );die;

    try {
        $response = $client->post(
            getenv('HDFC_INITIATE_URL'),
            [
                'headers' => [
                    'x-merchantid' => getenv('HDFC_MERCHANT_ID'),
                    'Content-Type'  => 'application/json',
                    'x-customerid' => 'Test-15',
                    //  BASIC AUTH (as per doc)
                    'Authorization' => 'Basic ' . base64_encode(getenv('HDFC_ACCESS_CODE') . ':')
                ],
                'json' => $payload,
                'timeout' => 30
            ]
        );

        $result = json_decode($response->getBody(), true);

        // THIS IS THE KEY PART
        if (isset($result['payment_links']['web'])) {
            return redirect()->to($result['payment_links']['web']);
        }
        
        log_message('error', 'HDFC INIT FAILED: ' . json_encode($result));
        return redirect()->back()->with('error', 'Unable to initiate payment');

    } catch (\Throwable $e) {
        log_message('error', 'HDFC EXCEPTION: ' . $e->getMessage());
        log_message('error', 'Check URL: ' . getenv('HDFC_INITIATE_URL'));
        return redirect()->back()->with('error', 'Payment service unavailable');
    }
}

/*private function redirectToHDFC($order_number, $amount)
{
    $merchantId = getenv('HDFC_MERCHANT_ID');
    $apiKey     = getenv('HDFC_API_KEY');
    $baseUrl    = getenv('HDFC_BASE_URL');

    $payload = [
        "merchantId" => $merchantId,
        "orderNo"    => $order_number,
        "amount"     => number_format($amount, 2, '.', ''),
        "currency"   => "INR",
        "returnUrl"  => base_url('payment-response'),
        "customerEmail"  => $this->request->getPost('email'),
        "customerMobile" => $this->request->getPost('phone'),
        "customerName"   => trim(
            ($this->request->getPost('first_name') ?? '') . ' ' .
            ($this->request->getPost('last_name') ?? '')
        )
    ];

    $client = \Config\Services::curlrequest();

    try {
        $response = $client->post(
            $baseUrl . '/pgui/api/initiate',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'api-key'      => $apiKey
                ],
                'json' => $payload,
                'timeout' => 30
            ]
        );

        $result = json_decode($response->getBody(), true);

        if (!empty($result['paymentPageUrl'])) {
            return redirect()->to($result['paymentPageUrl']);
        }

        log_message('error', 'HDFC INIT ERROR: ' . json_encode($result));
        return redirect()->back()->with('error', 'Payment initiation failed');

    } catch (\Throwable $e) {
        log_message('error', 'HDFC EXCEPTION: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Payment service unavailable');
    }
}*/

// 🔐 HDFC Encrypt
private function encryptHDFC($plainText, $key)
{
    $secretKey = pack('H*', $key);
    $iv = pack('C*', 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

    $encrypted = openssl_encrypt(
        $plainText,
        'AES-128-CBC',
        $secretKey,
        OPENSSL_RAW_DATA,
        $iv
    );

    return base64_encode($encrypted);
}

// 🔓 HDFC Decrypt
private function decryptHDFC($encryptedText, $key)
{
    $secretKey = pack('H*', $key);
    $iv = pack('C*', 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

    return openssl_decrypt(
        base64_decode($encryptedText),
        'AES-128-CBC',
        $secretKey,
        OPENSSL_RAW_DATA,
        $iv
    );
}


/*private function redirectToHDFC($order_number, $amount)
{
    //die("Check 12");
    $merchantId = getenv('HDFC_MERCHANT_ID');
    $apiKey     = getenv('HDFC_API_KEY');
    $baseUrl    = getenv('HDFC_BASE_URL');

    $payload = [
        "merchantId" => $merchantId,
        "orderNo" => $order_number,
        "amount" => (float)$amount,
        "currency" => "INR",
        "returnUrl" => base_url('payment-response'),
        "customerEmail" => $this->request->getPost('email'),
        "customerMobile" => $this->request->getPost('phone'),
        "customerName" => $this->request->getPost('first_name') . ' ' . $this->request->getPost('last_name')
    ];
    echo"<pre>";
    print_r($payload);
    $client = \Config\Services::curlrequest();

    try {
        //die("Try");
        $response = $client->post(
            $baseUrl . "/paymentgateway/initiate",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'api-key' => $apiKey
                ],
                'json' => $payload
            ]
        );

        $result = json_decode($response->getBody(), true);

        if (isset($result['paymentPageUrl'])) {
            die("IF");
            return redirect()->to($result['paymentPageUrl']);
        } else {
            die("Else");
            log_message('error', json_encode($result));
            return redirect()->back()->with('error', 'Payment initiation failed');
        }

    } catch (\Exception $e) {
       die("Catch");
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Payment error occurred');
    }
}*/

public function payment_response()
{
    //$session = session();
    //$session->start();
    //$session->regenerate(false);
    $response = $this->request->getPost();

     //Debug (temporary);
    //   echo "<pre>";
    //   print_r($response);
    //   die;

    $orderNo = $response['order_id'] ?? '';
    $status  = $response['status'] ?? '';
    
    $orderCheck = explode('-', $orderNo);
    // echo"orderCheck :- <pre>";
    // print_r($orderCheck);
    // die;
    $neworderNo = $orderCheck[0];
    $payment = $orderCheck[1];
    
    // Get order
    $order = $this->frontModel->select_row(
        TBL_ORDER,
        ['order_number' => $neworderNo,
        'total_amount' => $payment,
        
        ]
    );
    
    // echo "checkORder <pre>";
    // print_r($order);
    // die;
    
    if (empty($orderNo) || ($neworderNo != $order->order_number) ) {
        return redirect()->to('payment-failed');
    }
    
     // ⭐ Restore session
//   if (!empty($order->session_id)) {

//     $session = \Config\Services::session();

//     if (session_id() !== $order->session_id) {

//         session_write_close();

//         session_id($order->session_id);

//         $session = \Config\Services::session();
//     }
// }

//     $session = session();

    $txnId = '';
    $paymentMethod = '';
    $result = [];

    try {

        $client = \Config\Services::curlrequest();

        $url = getenv('HDFC_ORDER_STATUS_URL') . '/' . $orderNo;

        $apiResponse = $client->get($url, [
            'headers' => [
                'x-merchantid' => getenv('HDFC_MERCHANT_ID'),
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(getenv('HDFC_ACCESS_CODE') . ':')
            ]
        ]);

        $body = $apiResponse->getBody();

        $result = json_decode($body, true);
        
        // echo"Check Response Data:- <pre>";
        
        // print_r($result);
        
        // die;

        // extract transaction data
        $txnId = $result['txn_id'] ?? '';
        $paymentMethod = $result['payment_method_type'] ?? '';
        $gatewayAmount = $result['amount'] ?? 0;

    } catch (\Throwable $e) {

        log_message('error', 'HDFC STATUS API ERROR: ' . $e->getMessage());
    }

// echo"Check Response Data 1:- <pre>";
        
//         print_r($result);
        
//         die;
        /* Amount validation */

        if($gatewayAmount != $order->total_amount){
            return redirect()->to('payment-failed');
        }
        

    if ($status === 'CHARGED') {

        $updateData = [
            'payment_status'   => 'Paid',
            'transaction_id'   => $txnId,
            'payment_mode'     => $paymentMethod,
            'gateway_response' => json_encode($result),
            'order_status'     => 1
        ];

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $neworderNo,'total_amount' => $payment,],
            $updateData
        );

         $session = session();

        /* ⭐ store response for success page */
        $session->set('payment_response', $result);
        $session->set('payment_order', $neworderNo);


        // clear cart
        session()->remove('cart');

        return redirect()->to('success');

    } else {

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $neworderNo],
            [
                'payment_status'   => 'Failed',
                'gateway_response' => json_encode($result)
            ]
        );
        $session = session();

        /* store failure response */
    
        $session->set('payment_failed_response', $result);
        $session->set('payment_failed_order', $neworderNo);

        return redirect()->to('payment-failed');
    }
}
/*
public function payment_response()
{
    $response = $this->request->getPost();

    // debug remove later
    // echo "<pre>";
    // print_r($response);
    // die;

    $orderNo = $response['order_id'] ?? '';
    $status  = $response['status'] ?? '';

    if (empty($orderNo)) {
        return redirect()->to('payment-failed');
    }

    // Call HDFC Order Status API
    $client = \Config\Services::curlrequest();

    try {

        $apiResponse = $client->get(
            getenv('HDFC_ORDER_STATUS_URL') . '/' . $orderNo,
            [
                'headers' => [
                    'x-merchantid' => getenv('HDFC_MERCHANT_ID'),
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(getenv('HDFC_ACCESS_CODE') . ':')
                ]
            ]
        );

        $result = json_decode($apiResponse->getBody(), true);
        
        echo"Check Response Data:- <pre>";
        
        print_r($result);
        
        die;

        // extract details
        $txnId = $result['txn_id'] ?? '';
        $paymentMethod = $result['payment_method'] ?? '';

    } catch (\Throwable $e) {

        log_message('error', 'HDFC STATUS API ERROR: ' . $e->getMessage());

        $txnId = '';
        $paymentMethod = '';
        $result = [];
    }

        echo"Check Response Data 1:- <pre>";
        
        print_r($result);
        
        die;

    if ($status === 'CHARGED') {

        $updateData = [
            'payment_status' => 'Paid',
            'transaction_id' => $txnId,
            'payment_mode' => $paymentMethod,
            'gateway_response' => json_encode($result),
            'order_status' => 1
        ];

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $orderNo],
            $updateData
        );

        session()->remove('cart');

        return redirect()->to('success');

    } else {

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $orderNo],
            [
                'payment_status' => 'Failed',
                'gateway_response' => json_encode($result)
            ]
        );

        return redirect()->to('payment-failed');
    }
}
*/
/*Payment Response old function.*/

/*public function payment_response()
{
    $response = $this->request->getPost();
    
    echo"check Response:- <pre>";
    print_r($response);
    die;

    $orderNo = $response['orderNo'] ?? '';
    $status  = $response['status'] ?? '';
    $txnId   = $response['transactionId'] ?? '';

    if ($status === 'CHARGED') {

        $updateData = [
            'payment_status' => 'Paid',
            'transaction_id' => $txnId,
            'gateway_response' => json_encode($response),
            'order_status' => 1
        ];

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $orderNo],
            $updateData
        );

        session()->remove('cart');

        return redirect()->to('success');

    } else {

        $this->frontModel->update_data(
            TBL_ORDER,
            ['order_number' => $orderNo],
            [
                'payment_status' => 'Failed',
                'gateway_response' => json_encode($response)
            ]
        );

        return redirect()->to('payment-failed');
    }
}

*/

    /*//New PlaceOrder*/
    /*Old PlaceOrder change and replace with new*/
 /*public function placeOrder()
{
    $session = session();

    $data['title'] = 'Pawar Handloom By Piyush Pawar';
    $data['description'] = 'Pawar Handloom By Piyush Pawar';
    $data['page'] = 'frontend/Success';
    $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    if (isset($_POST['placeOrder'])) {
        //$loginUserId = $session->get('user_id');
        $loginUserId = $session->get('user_id') ?? $session->get('id');
        $cartItems = $session->get('cart') ?? [];

        $first_name = $this->request->getPost('first_name') ?? '';
        $last_name  = $this->request->getPost('last_name') ?? '';
        $company    = $this->request->getPost('company_name') ?? '';
        $address    = $this->request->getPost('address') ?? '';
        $city       = $this->request->getPost('city') ?? '';
        
        $state       = $this->request->getPost('state') ?? '';
        $zipcode       = $this->request->getPost('zipcode') ?? '';
        $country       = $this->request->getPost('country') ?? '';
        
        $phone      = $this->request->getPost('phone') ?? '';
        $email_id   = $this->request->getPost('email') ?? '';
        $notes      = $this->request->getPost('notes') ?? '';

        $total_amount = array_sum(array_map(function ($item) {
            return $item['offer_price'] * $item['qty'];
        }, $cartItems));

        $orderData = [
            'login_user_id' => $loginUserId,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'company_name' => $company,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zipcode' => $zipcode,
            'country' => $country,
            'phone' => $phone,
            'email_id' => $email_id,
            'notes' => $notes,
            'total_amount' => $total_amount,
        ];

        $order_id = $this->frontModel->insert_data(TBL_ORDER, $orderData);

        if ($order_id) {
            foreach ($cartItems as $item) {
                $itemData = [
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['offer_price'],
                    'qty' => $item['qty'],
                    'color' => $item['color'],
                    'subtotal' => $item['offer_price'] * $item['qty'],
                    'image' => $item['image'],
                ];
                $this->frontModel->insert_data(TBL_ORDERITEMS, $itemData);
            }

            $session->remove('cart');

            // Email Setup
            $to = $email_id;
            $admin_email = "info@pawarhandloom.com";
            $subject = "Order Confirmation - Pawar Handloom";

            $message = "Dear $first_name $last_name,\n\n";
            $message .= "Thank you for your order with Pawar Handloom. Your order details are as follows:\n\n";
            $message .= "Order ID: #$order_id\n";
            $message .= "Name: $first_name $last_name\n";
            $message .= "Email: $email_id\n";
            $message .= "Phone: $phone\n";
            $message .= "Shipping Address: $address, $city\n";
            $message .= "Total Amount: ₹$total_amount\n\n";
            $message .= "Order Summary:\n";

            foreach ($cartItems as $item) {
                $message .= "- " . $item['product_name'] . " (Qty: " . $item['qty'] . ") - ₹" . ($item['offer_price'] * $item['qty']) . "\n";
            }

            $message .= "\nWe will process your order soon. If you have any queries, feel free to contact us.\n\n";
            $message .= "Best Regards,\nPawar Handloom Team";

            $headers = "From: info@pawarhandloom.com" . "\r\n" .
                       "Reply-To: info@pawarhandloom.com" . "\r\n" .
                       "Content-Type: text/plain; charset=UTF-8";

            mail($to, $subject, $message, $headers);
            mail($admin_email, "New Order Received - Order ID: #$order_id", $message, $headers);

            // ✅ WhatsApp Integration - CloudAPI.msg24.in
            try {
                $apiKey = '0c7ad2441dee41c6bdbe544b7269fbb7'; //  API key
                $waClient = \Config\Services::curlrequest();
                $whatsappMessage = "Hi $first_name, your order (#$order_id) of ₹$total_amount has been received. Thank you for shopping at Pawar Handloom!";

                // Format phone number (India country code assumed)
                //$formattedPhone = preg_match('/^91\d{10}$/', $phone) ? $phone : '91' . preg_replace('/\D/', '', $phone);
                $formattedPhone = preg_replace('/\D/', '', $phone);

                // Send to customer
                // $waClient->post('https://cloudapi.msg24.in/send', [
                //     'form_params' => [
                //         'apikey' => $apiKey,
                //         'number' => $phone,
                //         'message' => $whatsappMessage
                //     ]
                // ]);
                
                 $response = $waClient->get('http://cloudapi.msg24.in/wapp/api/send', [
                                'query' => [
                                    'apikey' => $apiKey,
                                    'mobile' => $phone,
                                    'msg'    => $whatsappMessage
                                ]
                            ]);

                // Send to admin
                // $waClient->post('https://cloudapi.msg24.in/send', [
                //     'form_params' => [
                //         'apikey' => $apiKey,
                //         'number' => '91XXXXXXXXXX', // Admin's WhatsApp number
                //         'message' => "New order received (Order ID: #$order_id) from $first_name $last_name. Amount: ₹$total_amount."
                //     ]
                // ]);
            } catch (\Exception $e) {
                log_message('error', 'WhatsApp Message Error: ' . $e->getMessage());
            }

            return redirect()->to('success')->with('status', 'Your order has been placed successfully!');
        }
    }

    return view('frontend/includes/pages', $data);
}
*/


    //     require_once ROOTPATH . 'vendor/autoload.php'; // Load PHPMailer

    //     $request = service('request');

    // // Get form data with validation
    // $first_name = $request->getPost('first_name') ?? '';
    // $last_name  = $request->getPost('last_name') ?? '';
    // $company    = $request->getPost('company_name') ?? '';
    // $address    = $request->getPost('address') ?? '';
    // $city       = $request->getPost('city') ?? '';
    // $phone      = $request->getPost('phone') ?? '';
    // $email_id   = $request->getPost('email') ?? '';
    // $notes      = $request->getPost('notes') ?? '';
    // $product_name  = $request->getPost('product_name') ?? '';
    // $product_price = $request->getPost('product_price') ?? '0';
    // $product_qty   = $request->getPost('product_qty') ?? '1';
    // $total_price   = $request->getPost('total_price') ?? '0';

    // // Check required fields
    // if (empty($first_name) || empty($email_id)) {
    //     return redirect()->to(base_url('checkout'))->with('error', 'First Name and Email are required!');
    // }

    // // Email content
    // $subject = "Order Confirmation";
    // $message = "
    //     <h2>Order Confirmation</h2>
    //     <p>Thank you for your order. Here are your order details:</p>
    //     <ul>
    //         <li><strong>Name:</strong> " . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "</li>
    //         <li><strong>Company:</strong> " . htmlspecialchars($company) . "</li>
    //         <li><strong>Address:</strong> " . htmlspecialchars($address) . ", " . htmlspecialchars($city) . "</li>
    //         <li><strong>Phone:</strong> " . htmlspecialchars($phone) . "</li>
    //         <li><strong>Email:</strong> " . htmlspecialchars($email_id) . "</li>
    //         <li><strong>Notes:</strong> " . nl2br(htmlspecialchars($notes)) . "</li>
    //         <li><strong>Product:</strong> " . htmlspecialchars($product_name) . "</li>
    //         <li><strong>Product Price:</strong> INR " . htmlspecialchars($product_price) . "</li>
    //         <li><strong>Product Qty:</strong> " . htmlspecialchars($product_qty) . "</li>
    //         <li><strong>Total Price:</strong> INR " . htmlspecialchars($total_price) . "</li>
    //     </ul>
    //     <p>We will process your order soon.</p>
    // ";

    // // Email headers
    // $headers = "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // $headers .= "From: orderconfirm@pawarhandloom.com" . "\r\n";
    // $headers .= "Reply-To: orderconfirm@pawarhandloom.com" . "\r\n";

    // // Send email using PHP's mail function
    // if (mail($email_id, $subject, $message, $headers)) {
    //     die('if');
    //     return redirect()->to(base_url('success'))->with('message', 'Order placed successfully! Email sent.');
    // } else {
    //     die('else');
    //     return redirect()->to(base_url('checkout'))->with('error', 'Failed to send email.');
    // }

    // Initialize PHPMailer
    // $mail = new PHPMailer(true);

    // try {
    //     // Server settings
    //     $mail->isSMTP();
    //     $mail->Host       = 'smtp.gmail.com'; // Change to your SMTP server
    //     $mail->SMTPAuth   = true;
    //     $mail->Username   = 'orderconfirm@pawarhandloom.com'; // Your SMTP username
    //     $mail->Password   = 'Rzf2$xCK8]kv'; // Your SMTP password
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
    //     $mail->Port       = 587; // SMTP port

    //     // Recipients
    //     $mail->setFrom('orderconfirm@pawarhandloom.com', 'Your Shop');
    //     $mail->addAddress($email_id); // Send email to the user

    //     // Email content
    //     $mail->isHTML(true);
    //     $mail->Subject = $subject;
    //     $mail->Body    = $message;

    //     // Send email
    //     if ($mail->send()) {
    //         echo"If"; die;
    //         return redirect()->to(base_url('success'))->with('message', 'Order placed successfully! Email sent.');
    //     } else {
    //         echo"else"; die;
    //         return redirect()->to(base_url('checkout'))->with('error', 'Failed to send email.');
    //     }
    // } catch (Exception $e) {
    //     die("catch");
    //     return redirect()->to(base_url('checkout'))->with('error', "Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    // }   
    
    public function success(){

    $session = session();

    $paymentResponse = $session->get('payment_response');

    if($paymentResponse){
        
        $orderCheck = explode('-', $paymentResponse['order_id']);

        $orderNo = $orderCheck[0] ?? '';

        if($orderNo){

            $order = $this->frontModel->select_row(
                TBL_ORDER,
                ['order_number'=>$orderNo]
            );

            if($order){

                /* ⭐ Restore login session */
                if(!$session->get('is_logged_in')){

                    $user = $this->frontModel->select_row(
                        TBL_USER,
                        ['id'=>$order->login_user_id]
                    );

                    if($user){

                        $session->set([
                            'id'=>$user->id,
                            'name'=>$user->name,
                            'email'=>$user->email,
                            'role'=>$user->role,
                            'is_logged_in'=>true
                        ]);

                    }

                }
                $data['order'] = $order;

            }

        }

    }

    $data['paymentResponse'] = $paymentResponse;

    $data['title'] = 'Pawar Handloom By Piyush Pawar';
    $data['description'] = 'Pawar Handloom By Piyush Pawar';
    $data['page'] = 'frontend/Success';
    $data['categoryMenu'] = getCategoryMenu($this->frontModel);
    
    // echo"Check Order:- <pre>";
    // print_r( $data['order']);die;

    return view('frontend/includes/pages',$data);
}
    
    
    
    /*public function success(){
         $session  = session();
        // echo"Check Session :- <pre>";
        // print_r(session()->get()); 
        // die;
        $session_id = session_id();
    //  echo"Check session Id:- <pre>";
    //  print_r($session_id);
    //  die;
        $data['paymentResponse'] = $session->get('payment_response');
        $data['orderNumber'] = $session->get('payment_order');
        
        // echo"Check Payment Response :- <pre>";
        // print_r($data['paymentResponse']);
        // echo"<pre> Order Number:- <pre>";
        // print_r($data['orderNumber']);
        // die;

        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Success'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }*/
    public function sendMail()
    {
        //die('hhhh');
        $name = "name";//$_POST['name']; 
	$email = "name";//$_POST['email']; 
	$phone = "name";//$_POST['phone'];
	$sub = "name";//$_POST['subject']; 
	$query = "name";//$_POST['message']; 
	//end of data collection from form


	//check whether user enter some data or not 
	

	$to = "pradeepdhakad543@gmail.com";
	$subject = "Inquiry from website";
	$txt  = "Name: $name". "\r\n";
	$txt .= "Email: $email" . "\r\n";
	$txt .= "Email: $phone" . "\r\n";
	$txt .= "Subject: $sub" . "\r\n";
	$txt .= "Query: $query" . "\r\n";
	$headers = "From: orderconfirm@pawarhandloom.com" . "\r\n";

 $success =  mail($to,$subject,$txt,$headers);
 
	if($success)
	{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('Succesfully Sent')
			window.location.href='index.html';
			</SCRIPT>");
		}
	else{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Your Mail Server Not Responding... Please try After Some Time')
			window.location.href='index.html';
			</SCRIPT>");
		}
    }

   /* private function getCartHtml($cart)
{
    $html = '';
    foreach ($cart as $item) {
        $html .= '<div class="cart-item">';
        $html .= '<img src="' . base_url('/public/'.$item['image']) . '" alt="' . esc($item['product_name']) . '" width="50">';
        $html .= '<p>' . esc($item['product_name']) . ' - ₹' . esc($item['offer_price']) . ' x ' . esc($item['qty']) . '</p>';
        $html .= '</div>';
    }
    return $html;
}*/
private function getCartHtml($cart)
{
    $html = '';
    $subTotal = 0;

    if (empty($cart)) {
        return [
            'html' => '<p class="text-center">Your cart is empty.</p>',
            'subtotal' => '0.00'
        ];
    }

    foreach ($cart as $item) {

        // Calculate subtotal
        $subTotal += ($item['offer_price'] * $item['qty']);

        $html .= '<div class="cart-item">';
        $html .= '<img src="' . base_url('public/' . $item['image']) . '" 
                        alt="' . esc($item['product_name']) . '" width="50">';
        $html .= '<p>' 
                . esc($item['product_name']) 
                . ' - ₹' . number_format($item['offer_price'], 2) 
                . ' x ' . (int)$item['qty'] 
                . '</p>';
        $html .= '</div>';
    }

    return [
        'html' => $html,
        'subtotal' => number_format($subTotal, 2)
    ];
}


    }
  


