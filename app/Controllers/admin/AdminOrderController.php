<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminOrderController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
    }
    public function vieworderlist()
    {
        $data['title'] = 'Pawar Handloom Admin | Resaller Orders List'; // page title
        $data['page'] = 'admin/order/order_list'; //page name
        $data['page_title'] = 'Resallers Orders'; //Page Title Name
        $data['active_link'] = 'admin/ViewOrders'; //Page active link 

        //Get Order
        $where = [
            'is_deleted' => '1',
        ];
        $order_by = ['column' => 'order_id', 'direction' => 'DESC'];
       // $data['orderList'] =  $this->adminModel->select_data(TBL_ORDER,$where,'',$order_by); getResallerOrders
       $data['orderList'] =  $this->adminModel->getResallerOrders();
    //   echo"check Data:- <pre>";
    //   print_r($data['orderList']);
    //   die;

        return view('admin/includes/pages',$data);
    }
    
   public function viewCustomerOrderlist()
    {
        $data['title'] = 'Pawar Handloom Admin | Customers Orders List'; // page title
        $data['page'] = 'admin/order/customer_order_list'; //page name
        $data['page_title'] = 'Customers Orders'; //Page Title Name
        $data['active_link'] = 'admin/ViewCustomerOrders'; //Page active link 

        //Get Order
        // $where = [
        //     'is_deleted' => '1',
        //     //'role' => 2
        // ];
        $order_by = ['column' => 'order_id', 'direction' => 'DESC'];
        //$data['orderList'] =  $this->adminModel->select_data(TBL_ORDER,$where,'',$order_by);
         $data['orderList'] =  $this->adminModel->getCustomerOrders();
        //  echo"<pre>";
        //  print_r($data['orderList']);die;

        return view('admin/includes/pages',$data);
    }
    

    public function update_order_status()
    {
        $orderId  = $this->request->getPost('order_id');
        $statusId = $this->request->getPost('status_id');
        $table    = $this->request->getPost('table');

        $where = ['order_id' => $orderId];
        $updateData = ['order_status' => $statusId];

        $result = $this->adminModel->update_data($table, $where, $updateData);


         //Accept Order and send Email
         if($statusId == 2){
            $order_id = $orderId;
            $where = ['order_id' => $order_id];
                        
            $result = $this->adminModel->select_row(TBL_ORDER, $where);
            $result1 = $this->adminModel->select_data(TBL_ORDERITEMS, $where);
            if ($result) {
                $to = $result->email_id;
                $customer_name = $result->first_name." ".$result->last_name;
                $phone = $result->phone;
                $address = $result->address;
                $city = $result->city;
                $total_amount = $result->total_amount;
        
                // Build the email message
                $message = "
                    Dear $customer_name,<br><br>
                    Thank you for your order with <strong>Your Store</strong>. We are happy to inform you that your order has been <strong>accepted</strong>.<br><br>
                    
                    <strong>Order Details:</strong><br>
                    Order ID: <strong>#$order_id</strong><br>
                    Name: $customer_name<br>
                    Email: $to<br>
                    Phone: $phone<br>
                    Shipping Address: $address, $city<br>
                    Total Amount: ₹$total_amount<br><br>
        
                    <strong>Order Summary:</strong><br>
                    <table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>";
        
                foreach ($result1 as $item) {
                    $subtotal = $item->price * $item->qty;
                    $message .= "
                        <tr>
                            <td>{$item->product_name}</td>
                            <td>{$item->qty}</td>
                            <td>₹{$item->price}</td>
                            <td>₹{$subtotal}</td>
                        </tr>";
                }
        
                $message .= "
                        </tbody>
                    </table><br>
                    We will notify you when your order is shipped.<br><br>
                    Best regards,<br>
                    <strong>Your Store Team</strong>
                ";
        
                // Load and configure email service
                //$to = $email_id;  // Customer's email
                $admin_email = "info@pawarhandloom.com";  // Admin email
                $subject = "Order #$order_id Accepted - Pawar Handloom";

                // Email headers
                $headers = "From: info@pawarhandloom.com" . "\r\n" .
                           "Reply-To: info@pawarhandloom.com" . "\r\n" .
                           "Content-Type: text/plain; charset=UTF-8";
        
                // Send email to customer
                mail($to, $subject, $message, $headers);
                
                // Send email to admin
                mail($admin_email, "Accept Order - Order ID: #$order_id", $message, $headers);
            }
        }
        //Accept order and send email



        
        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }



    
}
