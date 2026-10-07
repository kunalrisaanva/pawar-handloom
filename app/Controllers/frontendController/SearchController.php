<?php

namespace App\Controllers\frontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendModel;


class SearchController extends BaseController
{
    protected $frontModel;
    public function __construct()
    {
        $this->frontModel = new FrontendModel();
        helper(['url','form',]);
        //$session = session();
        // Check authenticate
        helper('text');
       
    }
    
    public function ajaxSearch()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

        if ($this->request->getMethod() === 'OPTIONS' || $this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        $keyword = trim($this->request->getPost('keyword'));

        if (strlen($keyword) < 2) {
            return $this->response->setJSON([
                'status' => 'empty',
                'html'   => ''
            ]);
        }

        $frontModel = new FrontendModel();
        $results = $frontModel->searchProducts($keyword, 10);

        // BUILD HTML
        $html = '';

        if (!empty($results)) {
            foreach ($results as $row) {
                $html .= '
                <div class="search-item">
                    <a href="'.base_url('detail/'.$row['id']).'">
                        <strong>'.$row['product_name'].'</strong><br>
                        <small>'
                            .$row['category_name'].' → '
                            .$row['subcategory_name'].' → '
                            .$row['subsub_category_name'].
                        '</small>
                    </a>
                </div>';
            }
        } else {
            $html = '<p class="text-center">No products found</p>';
        }

        return $this->response->setJSON([
            'status' => 'success',
            'html'   => $html
        ]);
    }
    


    
}