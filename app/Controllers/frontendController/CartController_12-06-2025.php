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
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    //die('Hello');
    $session = session();

    // Get post data
    $id = $this->request->getPost('id');
    $name = $this->request->getPost('product_name');
    $price = $this->request->getPost('offer_price');
    $qty = $this->request->getPost('qty');
    $image = $this->request->getPost('image'); // Capture image

    // Fetch existing cart from session
    $cart = $session->get('cart') ?? [];

    // If product already exists, increase quantity
    if (isset($cart[$id])) {
        $cart[$id]['qty'] += $qty;
    } else {
        // Add new item
        $cart[$id] = [
            'id' => $id,
            'product_name' => $name,
            'offer_price' => $price,
            'qty' => $qty,
            'image' => $image // Store image in cart
        ];
    }

    // Save cart back to session
    $session->set('cart', $cart);

    // Prepare response
    $response = [
        'status' => 'success',
        'message' => 'Product added to cart!',
        'totalItems' => count($cart),
        'cartHtml' => $this->getCartHtml($cart) // Function to update mini-cart dynamically
    ];

    return $this->response->setJSON($response);
}


    public function showCart()
    {
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        // echo"Cate Items :- <pre>";
        // print_r($data['cartItems']);die;

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

    public function checkout(){
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];

        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Checkout'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        
        return view('frontend/includes/pages',$data);

    }
  public function placeOrder()
{
    $session = session();

    $data['title'] = 'Pawar Handloom By Piyush Pawar'; // Page title
    $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
    $data['page'] = 'frontend/Success'; // Page name
    // Fetch Dynamic Menu
    $data['categoryMenu'] = getCategoryMenu($this->frontModel);

    if (isset($_POST['placeOrder'])) {
        $loginUserId = $session->get('user_id'); // Get logged-in user ID
        
        $cartItems = $session->get('cart') ?? [];

        $first_name = $this->request->getPost('first_name') ?? '';
        $last_name  = $this->request->getPost('last_name') ?? '';
        $company    = $this->request->getPost('company_name') ?? '';
        $address    = $this->request->getPost('address') ?? '';
        $city       = $this->request->getPost('city') ?? '';
        $phone      = $this->request->getPost('phone') ?? '';
        $email_id   = $this->request->getPost('email') ?? '';
        $notes      = $this->request->getPost('notes') ?? '';
        
        // Calculate total amount
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
            'phone' => $phone,
            'email_id' => $email_id,
            'notes' => $notes,
            'total_amount' => $total_amount,
        ];
        
        $order_id = $this->frontModel->insert_data(TBL_ORDER, $orderData);

        if ($order_id) {
            // Insert cart items into order_items table
            foreach ($cartItems as $item) {
                $itemData = [
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['offer_price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['offer_price'] * $item['qty'],
                    'image' => $item['image'],
                ];
                $this->frontModel->insert_data(TBL_ORDERITEMS, $itemData);
            }

            // Clear cart session
            $session->remove('cart');

            // Send order confirmation email
            $to = $email_id;  // Customer's email
            $admin_email = "info@pawarhandloom.com";  // Admin email
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

            // Email headers
            $headers = "From: info@pawarhandloom.com" . "\r\n" .
                       "Reply-To: info@pawarhandloom.com" . "\r\n" .
                       "Content-Type: text/plain; charset=UTF-8";

            // Send email to customer
            mail($to, $subject, $message, $headers);
            
            // Send email to admin
            mail($admin_email, "New Order Received - Order ID: #$order_id", $message, $headers);

            return redirect()->to('success')->with('status', 'Your order has been placed successfully!');
        }
    }

    return view('frontend/includes/pages', $data);
}



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
        $data['title'] = 'Pawar Handloom By Piyush Pawar'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Success'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        return view('frontend/includes/pages',$data);
    }
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

    private function getCartHtml($cart)
{
    $html = '';
    foreach ($cart as $item) {
        $html .= '<div class="cart-item">';
        $html .= '<img src="' . base_url($item['image']) . '" alt="' . esc($item['product_name']) . '" width="50">';
        $html .= '<p>' . esc($item['product_name']) . ' - ₹' . esc($item['offer_price']) . ' x ' . esc($item['qty']) . '</p>';
        $html .= '</div>';
    }
    return $html;
}



    }
  


