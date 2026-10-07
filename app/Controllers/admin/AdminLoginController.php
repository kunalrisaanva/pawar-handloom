<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;
use App\Models\UserModel;
#use App\Libraries\Hash; // Libraries for encrypt password

class AdminLoginController extends BaseController
{
    public function index()
    {
        $data['title'] = 'Pawar Handloom Admin | Login'; // page title
        // $data['page'] = 'admin/dashboard'; //page name
        // $data['page_title'] = 'Dashboard'; //Page Title Name
        // $data['active_link'] = 'admin/Dashboard'; //Page active link 
      
        return view('admin/login',$data);

    }
    public function authenticate()
    {
        $session = session();
        $AdminModel = new AdminModel();
 
        $user_name = $this->request->getVar('user_name');
        $password = $this->request->getVar('password');


        $change_pwd = md5($password);
         
        $user = $AdminModel->select_row(TBL_LOGIN,["user_name"=>$user_name,"password"=>$change_pwd]);
        file_put_contents('debug_login.txt', "User: $user_name\nPwd: $password\nHash: $change_pwd\nDB Result: " . json_encode($user) . "\nSQL: " . (string)$AdminModel->db->getLastQuery() . "\n");
        // echo"Hiii <pre>";
        //  print_r($user_name);
        //  echo"Password:- <pre>";
        //  echo $password;
        //  die;
            // start Checking for login 
    //    echo $change_pwd."<pre>";
    //    print_r($user);
    //    echo"<pre>".$user->password;
    //    die;
        // $pwd_verify = password_verify($change_pwd, $user->password);
        // if ($pwd_verify === true) {
        //    echo"Check All <pre>";
        //     print_r($user);
        // }else{
        //     echo"Pwd Not match";
        // }
        // die;
            // end Checking for login
        if ($user) {
            $ses_data = [
                'id' => $user->id,
                'user_name' => $user->user_name,
                'email'=> $user->email,
                'user_image' => $user->user_image,
                'display_name' => $user->display_name,
                'isLoggedIn' => TRUE
            ];
     
            $session->set($ses_data);
             //echo"Hello <pre>";print_r($_SESSION[$ses_data]);die;
            return redirect()->to('admin/Dashboard');
            
        }else{
            return redirect()->to('/LgAdmin')->with('status','User Name and Password Not match  !');
            //echo"Pwd not match";
        }         
        
    }
 
    public function logout() {
        session_destroy();
        return redirect()->to('/LgAdmin');
    }

    
    public function forgotPassword()
    {
        //die('HiiForgot');
        $data['title'] = 'Pawar Handloom By Piyush Pawar Admin | Forgot Password'; // Page title
        //$data['description'] = 'Pawar Handloom By Piyush Pawar Admin'; // Page description
        //$data['page'] = 'admin/Forgot_password'; // Page name
        // Fetch Dynamic Menu
       // $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        //echo "Request method: " . $this->request->getMethod(); // This will output "get" or "post"
        //die;
        if ($this->request->getMethod() == 'POST') {
            //die('If');
            $rules = [
                'email' => 'required|valid_email'
            ];
    
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
    
            $email = $this->request->getPost('email');
            
            // echo"Check Email:- <pre>";
            // print_r($email);
            // die;
            
            $userModel =  new UserModel();
            $user = $userModel->where('email', $email)->first();
            
            // echo"Check Email Details:- <pre>";
            // print_r($user);
            // die;
    
            if (!$user) {
                return redirect()->back()->withInput()->with('error', 'Email not found.');
            }
            //echo"Check User:- <pre>";
            //print_r($user);
            //echo"User Id :- ". $user['id'];
            //die;
            $token = bin2hex(random_bytes(50));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            //echo"Token :- ". $token."<pre>";
            //echo"expiry :- ". $expiry."<pre>";
            
            
            $userModel->update($user['id'], [
                'reset_token' => $token,
                'token_expiry' => $expiry
            ]);
            
            //die("After Update");
            $resetLink = base_url("reset-password/$token");
            log_message('info', "Password reset link (dev mode): $resetLink");
            // Send email with token 

                $to = $email;  // Customer's email
                //$admin_email = "info@pawarhandloom.com";  // Admin email
                $subject = "Reset Password - Pawar Handloom";
    
                $message = "
                        <h3>Hi {$user['name']},</h3>
                        <p>You requested to reset your password for your Pawar Handloom account.</p>
                        <p>Please click the button below to reset your password. This link will expire in 1 hour.</p>
                        <p>
                            <a href='{$resetLink}' style='padding: 10px 20px; background: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>
                                Reset Password
                            </a>
                        </p>
                        <p>If you did not request a password reset, please ignore this email.</p>
                        <br><p>Regards,<br>Pawar Handloom Team</p>
                    ";
    
                // Email headers
                $headers = "MIME-Version: 1.0" . "\r\n".
                           "From: info@pawarhandloom.com" . "\r\n" .
                           "Reply-To: info@pawarhandloom.com" . "\r\n" .
                           "Content-Type: text/html; charset=UTF-8";
    
                // Send email to customer
                mail($to, $subject, $message, $headers);

    
            return redirect()->back()->with('success', 'A password reset link has been sent to your email address.');
        }


        return view('admin/Forgot_password',$data);
    }
    
    
}
