<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminCouponController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
       
    }
    public function viewCoupan()
    {
        $data['title'] = 'Pawar Handloom  & FITNESS Admin | Coupon'; // page title
        $data['page'] = 'admin/coupan/viewCoupan'; //page name
        $data['page_title'] = 'Coupon'; //Page Title Name 
        $data['active_link'] = 'admin/ViewCoupan'; //Page active link 
        //Get Coupon List
        $where = [
            'is_deleted' => '1',
        ];
        $data['couponList'] =  $this->adminModel->select_data(TBL_COUPON,$where);
        //Get Coupon Type
        $where1 = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['couponTypeList'] = $this->adminModel->select_data(TBL_COUPONTYPE,$where1);
        
        return view('admin/includes/pages',$data);        
    }
    public function addCoupan()
    {
        $data['title'] = 'Pawar Handloom  & FITNESS Admin | Add Coupon'; // page title
        $data['page'] = 'admin/coupan/addCoupan'; //page name
        $data['page_title'] = 'Coupon'; //Page Title Name
        $data['active_link'] = 'admin/addCoupan'; //Page active link 
        $where = [
            'is_deleted' => '1',
            'status' => '1',
        ];
        $data['couponTypeList'] = $this->adminModel->select_data(TBL_COUPONTYPE,$where);
        //insert Coupan
        if (isset($_POST['addCoupan'])) {
            $coupan_name = $this->request->getPost('coupan_name');
            $coupan_type = $this->request->getPost('coupan_type');
            $coupan_value = $this->request->getPost('coupan_value');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');
            
            $minimum_amount	 = $this->request->getPost('minimum_amount') ?: 0;
            $user_limit = $this->request->getPost('user_limit') ?: 0;

            //echo"coupan_name :- ".$coupan_name."<pre>coupan_description:- ".$coupan_type."<pre> period_time:- ".$start_date."<pre> period_time_hour:- ".$end_date;
            //die;
            $data = [
                'name' => $coupan_name,
                'coupon_type' => $coupan_type,
                'coupan_value' => $coupan_value,
                'user_limit'    => $user_limit,
                'minimum_amount' => $minimum_amount,
                'start_date	' => $start_date,
                'end_date' => $end_date,
            ];
            $this->adminModel->insert_data(TBL_COUPON,$data);
            return redirect()->to('admin/ViewCoupan')->with('status','Save Your Coupon Successfully !');
        }
        
        return view('admin/includes/pages',$data);        
    }

    

   public function edit_coupon($u_id){        
        $data['title'] = "Neeta's Online Store Admin | Coupon Edit"; // page title
        $data['page'] = 'admin/coupan/addCoupan'; //page name
        $data['page_title'] = 'Coupon Edit'; //Page Title Name
        $data['active_link'] = 'admin/addCoupan'; //Page active link 
        $where = [
                    'is_deleted' => '1',
                    'status' => '1',
                ];
        $data['couponTypeList'] = $this->adminModel->select_data(TBL_COUPONTYPE,$where);

        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getCouponData'] =  $this->adminModel->select_row(TBL_COUPON,$where);
        
        return view('admin/includes/pages',$data);
    }
    
           
    public function update_coupon() {
        
        //Update Coupan
        if (isset($_POST['addCoupan'])) {
            //$Edit_id = $this->request->getVar('id');
            $Edit_id = base64_decode(urldecode($this->request->getVar('id'))); 
            $coupan_name = $this->request->getPost('coupan_name');
            $coupan_type = $this->request->getPost('coupan_type');
            $coupan_value = $this->request->getPost('coupan_value');
            $start_date = $this->request->getPost('start_date');
            $end_date = $this->request->getPost('end_date');

            $where = ['id' => $Edit_id];
            $data = [
                'name' => $coupan_name,
                'coupon_type' => $coupan_type,
                'coupan_value' => $coupan_value,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];
            $this->adminModel->update_data(TBL_COUPON,$where,$data);
            return redirect()->to('admin/ViewCoupan')->with('status','Update Your Coupon Successfully !');
        }
        
        // $result = $this->adminModel->update_data(TBL_GALLERYCAT, $where, $data);
        // return json_encode($result);
    }
    
    
    
    
    
}
