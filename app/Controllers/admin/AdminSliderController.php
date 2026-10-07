<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminSliderController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);
        //$session = session();
        // Check authenticate
       
    }
    public function viewSlider(){
        $data['title'] = 'Pawar Handloom Admin | Slider'; // page title
        $data['page'] = 'admin/slider/viewSlider'; //page name
        $data['page_title'] = 'Slider'; //Page Title Name
        $data['active_link'] = 'admin/ViewSlider'; //Page active link 
    
        $where = [
            'is_deleted' => '1',
        ];
       // $data['categoryList'] = $AdminModel->select_data(TBL_CATEGORY,$where);
        $data['sliderList'] =  $this->adminModel->select_data(TBL_SLIDER,$where);
        
        return view('admin/includes/pages',$data);
    
    }
       
    public function addSlider(){
        $data['title'] = 'Pawar Handloom Admin | Add Slider'; // page title
        $data['page'] = 'admin/slider/addSlider'; //page name
        $data['page_title'] = 'Add Slider'; //Page Title Name
        $data['active_link'] = 'admin/addSlider'; //Page active link 
        
            //insert Slider
        if (isset($_POST['addSlider'])) {
            $slider_title = $this->request->getPost('slider_title');
            $slider_description = $this->request->getPost('slider_description');
            $web_link = $this->request->getPost('web_link');
            $file = $this->request->getFile('slider_image');
            $mobileFile = $this->request->getFile('mobile_slider_image');
    
            if ($file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('public/uploads/admin/slider_image/', $newName);
                //$file->move($path);
            }
            $slideImage = empty($newName) ? 'default_category_image.png' : $newName;
            //Mobile Image slider add

             if ($mobileFile->isValid() && ! $mobileFile->hasMoved()) {
                $newMobileName = $mobileFile->getRandomName();
                $mobileFile->move('public/uploads/admin/slider_image/', $newMobileName);
                //$file->move($path);
            }
            $mobileSliderImage = empty($newMobileName) ? 'default_category_image.png' : $newMobileName;


            $validated = $this->validate([
                'slider_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Slider Title is Required',
                    ]
                ], 
                            
            ]);
            if (!$validated) {
               // die('Hello This not validated');
               $data['validation']  = $this->validator;
                return view('admin/includes/pages',$data);
    
            }else{
                $data = [
                    'slider_title' => $slider_title,
                    'slider_image' => $slideImage,
                    'slider_description	' => $slider_description,
                    'web_link' => $web_link,
                    'mobile_slider_image' => $mobileSliderImage,
                ];
                $this->adminModel->insert_data(TBL_SLIDER,$data);
                return redirect()->to('admin/ViewSlider')->with('status','Save Your Slider Successfully !');
                }      
    
        }    
        
        return view('admin/includes/pages',$data);
    
    }
    public function edit_slider($u_id){        
        $data['title'] = 'Pawar Handloom Admin | Slider Edit'; // page title
        $data['page'] = 'admin/slider/addSlider'; //page name
        $data['page_title'] = 'Slider Edit'; //Page Title Name
        $data['active_link'] = 'admin/addSlider'; //Page active link 
        $id = base64_decode(urldecode($u_id));
        $where = [
            'id' => $id,
        ];
        $data['getSliderData'] =  $this->adminModel->select_row(TBL_SLIDER,$where);
        return view('admin/includes/pages',$data);
    }
     
    public function update_slider() {
        
        //die("hi");
        $Edit_id = $this->request->getVar('Edit_id');
        //echo $Edit_id;
        //die("hello");
        $slider_title = $this->request->getVar('slider_title');
        $slider_description = $this->request->getVar('slider_description');
        $web_link = $this->request->getVar('web_link');
        $file = $this->request->getFile('slider_image');
        $mobileFile = $this->request->getFile('mobile_slider_image');
    
        $where = ['id' => $Edit_id];
        $data = [
            'slider_title' => $slider_title,
            'slider_description' => $slider_description,
            'web_link' => $web_link,
        ];
        if ($file && $file->isValid() && !$file->hasMoved()) {
            //die("Hiiiiiiiiiiiiiii");
            $newName = $file->getRandomName();
            $file->move('public/uploads/admin/slider_image', $newName);
            $data['slider_image'] = $newName;
        }
        // Retrieve the old image name if not updating image
        if (!isset($data['slider_image'])) {
            $where = ['id' => $Edit_id];
            //$AdminModel = new AdminModel();
            $oldImage = $this->adminModel->select_row(TBL_SLIDER, $where);
            // echo"<pre>";
            // print_r($oldImage);die;
            if ($oldImage->slider_image) {
                $data['slider_image'] = $oldImage->cat_image;
            }
        }
        //Add Mobile SLider Image

        if ($mobileFile && $mobileFile->isValid() && !$mobileFile->hasMoved()) {
            //die("Hiiiiiiiiiiiiiii");
            $mobileSliderImage = $mobileFile->getRandomName();
            $mobileFile->move('public/uploads/admin/slider_image', $mobileSliderImage);
            $data['mobile_slider_image'] = $mobileSliderImage;
        }
        // Retrieve the old image name if not updating image
        if (!isset($data['mobile_slider_image'])) {
            $where1 = ['id' => $Edit_id];
            //$AdminModel = new AdminModel();
            $oldImage1 = $this->adminModel->select_row(TBL_SLIDER, $where1);
            // echo"<pre>";
            // print_r($oldImage);die;
            if ($oldImage1->mobile_slider_image) {
                $data['mobile_slider_image'] = $oldImage1->mobile_slider_image;
            }
        }

        //End Mobile Slider Image

        $result = $this->adminModel->update_data(TBL_SLIDER, $where, $data);
        return json_encode($result);
    }
        
}
