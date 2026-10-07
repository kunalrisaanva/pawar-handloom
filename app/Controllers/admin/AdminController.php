<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;


class AdminController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
       
    }
    public function dashboard(){
        $data['title'] = 'Pawar Handloom Admin | Dashboard'; // page title
        $data['page'] = 'admin/dashboard'; //page name
        $data['page_title'] = 'Dashboard'; //Page Title Name
        $data['active_link'] = 'admin/Dashboard'; //Page active link 

        return view('admin/includes/pages',$data);
    }
  
    public function update_status(){
        $id = $this->request->getPost('id');
        $status  = $this->request->getPost('status');
        $tableName  = $this->request->getPost('tableName');
        $deletecategory  = $this->request->getPost('deletecategory');
       //echo"Hii <pre> D:- ".$tableName."<pre>status:- ".$status;die;
        $AdminModel = new AdminModel();
       
        $where = ($tableName === 'TBL_SUBCAT') ? ['sub_cat_id' => $id] : (($tableName === 'TBL_CHILDCAT') ? ['child_id' => $id] : ['id' => $id]);
        
        $status = ($deletecategory === 'Yes' && $status == 1) ? ['is_deleted' => '0'] : ($status == 1 ? ['status' => '1'] : ['status' => '0']);
             //echo"Hello";
             //print_r($status);die;
        $AdminModel->update_category_status($tableName,$where,$status);
    }
 
// Profile Function
    public function view_profile(){
        
        $data['title'] = 'Pawar Handloom Admin | Profile'; // page title
        $data['page'] = 'admin/profile/viewProfile'; //page name
        $data['page_title'] = 'Profile'; //Page Title Name
        $data['active_link'] = 'admin/ViewProfile'; //Page active link 
            //$AdminModel = new AdminModel();
            $where = [
                'is_delete' => '1',
            ];
        $data['profileData'] =  $this->adminModel->select_data(TBL_LOGIN);
         //echo"Check Session data:- <pre>";
         //print_r($_SESSION['display_name']);die;
        
        return view('admin/includes/pages',$data);
       
    }

    public function update_profile(){
        $Edit_id = $this->request->getVar('Edit_id');
        $user_name = $this->request->getVar('user_name');
        $password = $this->request->getVar('password');
        $display_name = $this->request->getVar('display_name');
        $file = $this->request->getFile('user_image');
    
        $where = ['id' => $Edit_id];
        $data = [
            'user_name' => $user_name,
            'display_name'=> $display_name,
            'update_date' => date('Y-m-d H:i:s'),
        ];
    
        if (!empty($password)) {
            $data['password'] = md5($password);
        }
    
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/admin/profile', $newName);
            $data['user_image'] = $newName;
        }
    
        // Retrieve the old image name if not updating image
        if (!isset($data['user_image'])) {
            $oldImage = $this->adminModel->select_row(TBL_LOGIN, $where);
            if ($oldImage->user_image) {
                $data['user_image'] = $oldImage->user_image;
            }
        }
    
        $result = $this->adminModel->update_data(TBL_LOGIN, $where, $data);
        return json_encode($result);
    }
    
    
}
