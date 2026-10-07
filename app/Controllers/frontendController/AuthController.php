<?php

namespace App\Controllers\FrontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendModel;
use App\Models\UserModel;
use Config\Services;

class AuthController extends BaseController
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
        helper(['url', 'form',]);
    }
    public function register()
    {
        helper(['form']);

        // Define validation rules
        $validationRules = [
            'company_name' => 'required',
            'email' => 'required|valid_email|is_unique[' . TBL_USER . '.email]',
            'phone' => 'required|numeric',
            'whatsapp_no' => 'required|numeric',
            'address' => 'required',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        // Custom validation messages
        $customMessages = [
            'company_name' => [
                'required' => 'The Company Name field is required.',
            ],
            'email' => [
                'required' => 'The Email Address field is required.',
                'valid_email' => 'Please enter a valid Email Address.',
                'is_unique' => 'This Email Address is already registered.',
            ],
            'phone' => [
                'required' => 'The Phone field is required.',
                'numeric' => 'The Phone field must be a number.',
            ],
            'whatsapp_no' => [
                'required' => 'The WhatsApp Number field is required.',
                'numeric' => 'The WhatsApp Number must be a number.',
            ],
            'address' => [
                'required' => 'The Address field is required.',
            ],
            'password' => [
                'required' => 'The Password field is required.',
                'min_length' => 'The Password must be at least 6 characters long.',
            ],
            'confirm_password' => [
                'required' => 'Please confirm your password.',
                'matches' => 'The Confirm Password field does not match the Password field.',
            ],
        ];

        // Validate input data
        $validation = Services::validation();
        $validation->setRules($validationRules, $customMessages);

        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Validation failed', 'errors' => $validation->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Save user data
        $userModel = new UserModel();
        $userData = [
            'company_name' => $this->request->getPost('company_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'whatsapp_no' => $this->request->getPost('whatsapp_no'),
            'address' => $this->request->getPost('address'),
            //'password'     => hash('sha256', trim($this->request->getPost('password'))),
            'password' => $this->request->getPost('password'),
            'role' => 1,
            //'password' => md5(trim($this->request->getPost('password'))),
        ];

        $userModel->insert($userData);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Registration successful! Please login after Approved.']);
        }
        return redirect()->to('/register')->with('success', 'Registration successful! Please login after Approved.');
    }
    //Login function 
    public function login()
    {
        //die('Hii Login');
        helper(['form', 'url', 'session']);
        $session = session();

        // Define validation rules
        $validationRules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        // Custom validation messages
        $customMessages = [
            'email' => [
                'required' => 'The Email Address field is required.',
                'valid_email' => 'Please enter a valid Email Address.',
            ],
            'password' => [
                'required' => 'The Password field is required.',
            ],
        ];

        // Validate input
        $validation = Services::validation();
        $validation->setRules($validationRules, $customMessages);

        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Validation failed', 'errors' => $validation->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = trim($this->request->getPost('password'));
        // $newPassword = password_hash(trim($password), PASSWORD_DEFAULT);

        $user = $userModel->where('email', $email)->first();
        //echo $userModel->getLastQuery();  
        //  exit;
        // if ($user) {
        //     echo "User not found"; 
        //     exit;
        // }else{
        //     echo"Check User";
        //     exit;
        // }
        // $new =  hash('sha256', trim('123456'));
        $hashedPassword = hash('sha256', trim($password));
        // echo $hashedPassword."<pre>";
        // echo"Password :- <pre>"; echo $password."<pre>".$user['password']."<pre>";

        // if ($hashedPassword === $user['password']) {
        //     echo "Password is correct";
        // } else {
        //     echo "Password is incorrect <pre>";
        // }
        // if ($hashedPassword === $user['password']) {
        //     echo "✅ Password is correct";
        // } else {
        //     echo "❌ Password is incorrect";
        // }
        // exit;
        if ($user['is_deleted'] == '0') {
            if ($this->request->isAJAX())
                return $this->response->setJSON(['status' => 'error', 'message' => 'Your account has been deleted.']);
            return redirect()->back()->withInput()->with('error', 'Your account has been deleted. Please register again or contact the admin.');
        }
        if ($user['status'] == '0') {
            if ($this->request->isAJAX())
                return $this->response->setJSON(['status' => 'error', 'message' => 'After approval, you can log in. Please wait.']);
            return redirect()->back()->withInput()->with('error', 'After approval, you can log in. Please wait.');
        }


        if (!$user || $hashedPassword !== $user['password']) {
            if ($this->request->isAJAX())
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password.']);
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if (!empty($user)) {
            if ($hashedPassword === $user['password']) {
                // Set session data
                $sessionData = [
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'company_name' => $user['company_name'],
                    'role' => $user['role'],
                    'is_logged_in' => true
                ];
                //$session = session();
                $session->set($sessionData);

                if ($this->request->isAJAX())
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Login successful!']);
                return redirect()->to('/')->with('success', 'Login successful!');
            } else {
                if ($this->request->isAJAX())
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email or password.']);
                return redirect()->back()->with('error', 'Invalid email or password.');
            }
        } else {
            if ($this->request->isAJAX())
                return $this->response->setJSON(['status' => 'error', 'message' => 'User not found.']);
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    public function logout()
    {
        $session = session();
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logged out successfully.');
    }


    public function forgotPassword()
    {
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Forgot Password'; // Page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
        $data['page'] = 'frontend/Forgot_password'; // Page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
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
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

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
            $headers = "MIME-Version: 1.0" . "\r\n" .
                "From: info@pawarhandloom.com" . "\r\n" .
                "Reply-To: info@pawarhandloom.com" . "\r\n" .
                "Content-Type: text/html; charset=UTF-8";

            // Send email to customer
            mail($to, $subject, $message, $headers);


            return redirect()->back()->with('success', 'A password reset link has been sent to your email address.');
        }


        return view('frontend/includes/pages', $data);
    }

    public function lostPassword()
    {
        $data['title'] = 'Pawar Handloom By Piyush Pawar | Customer Forget Password'; // Page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
        $data['page'] = 'frontend/Lost_Password'; // Page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
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
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

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
            $headers = "MIME-Version: 1.0" . "\r\n" .
                "From: info@pawarhandloom.com" . "\r\n" .
                "Reply-To: info@pawarhandloom.com" . "\r\n" .
                "Content-Type: text/html; charset=UTF-8";

            // Send email to customer
            mail($to, $subject, $message, $headers);


            return redirect()->back()->with('success', 'A password reset link has been sent to your email address.');
        }


        return view('frontend/includes/pages', $data);
    }

    public function resetPassword($token)
    {

        $data['title'] = 'Pawar Handloom By Piyush Pawar | Reset Password'; // Page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // Page description
        $data['page'] = 'frontend/Reset_password'; // Page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
        $data['token'] = $token;

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user || strtotime($user['token_expiry']) < time()) {
            return redirect()->to('/forgotPassword')->with('error', 'The reset link is invalid or has expired.');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                $data['errors'] = $this->validator->getErrors();
                return view('frontend/includes/pages', $data);
            }

            $newPassword = trim($this->request->getPost('password'));


            $userModel->update($user['id'], [
                'password' => $newPassword,
                'reset_token' => null,
                'token_expiry' => null
            ]);

            return redirect()->to('/login')->with('success', 'Password has been reset successfully. You can now log in.');
        }

        return view('frontend/includes/pages', $data);
    }







}
