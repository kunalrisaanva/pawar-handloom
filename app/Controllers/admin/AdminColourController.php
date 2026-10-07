<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminColourController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
       
    }
    public function viewColourlist(){
        $data['title'] = 'Pawar Handloom Admin | Colour'; // page title
        $data['page'] = 'admin/colour/viewColour'; //page name
        $data['page_title'] = 'Colour'; //Page Title Name
        $data['active_link'] = 'admin/ViewColours'; //Page active link 
    
        $where = [
            'is_deleted' => '1',
        ];
       // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
        $data['colourList'] =  $this->adminModel->select_data(TBL_COLOURS,$where);
        
        return view('admin/includes/pages',$data);
    
    }
    public function addColour(){
        $data['title'] = 'Pawar Handloom Admin | Add Colour'; // page title
        $data['page'] = 'admin/colour/addColour'; //page name
        $data['page_title'] = 'Add Colour'; //Page Title Name
        $data['active_link'] = 'admin/AddColours'; //Page active link 
        
            //insert Slider
        if (isset($_POST['addColour'])) {
            $colour_name = $this->request->getPost('colour_name');
            $colour_code = $this->request->getPost('colour_code');
            
            list($hex, $rgb) = explode('|', $colour_code);

            $hex = trim($hex);
            $rgb = trim($rgb);
            
            // echo "Colour HEX:- " . $hex . "<br>";
            // echo "Colour RGB:- " . $rgb . "<br>";
            
            // echo "Colour Name:- ".$colour_name."<pre>";
            // echo "Colour Code:- ".$colour_code."<pre>";
            // die("Check");

            $validated = $this->validate([
                'colour_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Colour Name is Required',
                    ]
                ], 
                            
            ]);
            if (!$validated) {
               // die('Hello This not validated');
               $data['validation']  = $this->validator;
                return view('admin/includes/pages',$data);
    
            }else{
                $data = [
                    'colour_name' => $colour_name,
                    'colour_code' => $hex,
                    'colour_rgb	' => $rgb,
                    
                ];
                $this->adminModel->insert_data(TBL_COLOURS,$data);
                return redirect()->to('admin/ViewColours')->with('status','Save Your Colour Successfully !');
                }      
    
        }    
        
        return view('admin/includes/pages',$data);
    
    }
    public function edit_colour($u_id){        
        $data['title'] = 'Pawar Handloom Admin | Colour Edit'; // page title
        $data['page'] = 'admin/colour/addColour'; //page name
        $data['page_title'] = 'Edit Colour'; //Page Title Name
        $data['active_link'] = 'admin/AddColours'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getColourData'] =  $this->adminModel->select_row(TBL_COLOURS,$where);
        return view('admin/includes/pages',$data);
    }
    public function update_colour() {
        
        //die("hi");
        $Edit_id = $this->request->getVar('Edit_id');
        //echo $Edit_id;
        //die("hello");
        $colour_name = $this->request->getVar('colour_name');
        $colour_code = $this->request->getVar('colour_code');
        
        // echo $Edit_id."<pre>";
        // echo $colour_name."<pre>";
        // echo $colour_code."<pre>";
        
        // die("hello");
        
        list($hex, $rgb) = explode('|', $colour_code);

            $hex = trim($hex);
            $rgb = trim($rgb);
    
        $where = ['id' => $Edit_id];
        $data = [
            'colour_name' => $colour_name,
            'colour_code' => $hex,
            'colour_rgb' => $rgb,
        ];
        

        $result = $this->adminModel->update_data(TBL_COLOURS, $where, $data);
        return json_encode($result);
    }
           
       
}