<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminReviewController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
    }
    public function viewreviewlist()
    {
        $data['title'] = 'Pawar Handloom Admin | Review'; // page title
        $data['page'] = 'admin/review/review_list'; //page name
        $data['page_title'] = 'Reviews'; //Page Title Name
        $data['active_link'] = 'admin/Dashboard'; //Page active link 

        //Get Review
        $where = [
            'is_deleted' => '1',
        ];
        $order_by = ['column' => 'id', 'direction' => 'DESC'];
        $data['reviewList'] =  $this->adminModel->select_data(TBL_REVIEW,$where,'',$order_by);

        return view('admin/includes/pages',$data);
    }

    
}