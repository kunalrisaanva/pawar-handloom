<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminCustomerController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
       
    }
    public function viewCustomer()
    {
        $data['title'] = 'Pawar Handloom Admin | Customer List'; // page title
        $data['page'] = 'admin/customer/viewCustomer'; //page name
        $data['page_title'] = 'Customer List'; //Page Title Name 
        $data['active_link'] = 'admin/viewCustomer'; //Page active link 
        //Get Customer List
        $where = [
            'is_deleted' => '1',
        ];
        $data['customerList'] =  $this->adminModel->select_data(TBL_USER,$where);
        return view('admin/includes/pages',$data);        
    }
}
