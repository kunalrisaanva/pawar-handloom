<?php

namespace App\Controllers\FrontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FrontendModel;

class ReviewController extends BaseController
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

    // List all reviews
    public function check(){
        echo"Checking...";
    }
    public function reviewPage()
    {
      $data['title'] = 'Pawar Handloom By Piyush Pawar | Review'; // page title
        $data['description'] = 'Pawar Handloom By Piyush Pawar'; // page description
        $data['page'] = 'frontend/Review'; //page name
        // Fetch Dynamic Menu
        $data['categoryMenu'] = getCategoryMenu($this->frontModel);
         // Get review stats
     $query = $this->frontModel->getReviewStats();

    $totalReviews = 0;
    $totalRating = 0;
    $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    foreach ($query as $row) {
        $ratingCounts[$row['rating']] = $row['count'];
        $totalReviews += $row['count'];
        $totalRating += ($row['rating'] * $row['count']);
    }

    $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;

    $data['averageRating'] = $averageRating;
    $data['totalReviews'] = $totalReviews;
    $data['ratingCounts'] = $ratingCounts;
    
    // Reviews
    $data['productReviews'] = getReviewsWithImages(1) ?? []; //all product reviews
    $data['shopReviews']    = getReviewsWithImages(2) ?? []; // all shop reviews
        
        
        return view('frontend/includes/pages',$data);
    }

    // Show create form
    public function saveReview()
    {
        if (isset($_POST['reviewShop'])) {
        $data = [
            //'product_id' => $this->request->getPost('user_id'),
            'product_id' => $this->request->getPost('product_id') ?? 0,
            'user_id' => $this->request->getPost('user_id'),
            'review_title' => $this->request->getPost('review_title'),
            'rating' => $this->request->getPost('rating'),
            'review_text' => $this->request->getPost('review_text'),
            'YouTube_url' => $this->request->getPost('YouTube_url'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'review_type' => ($this->request->getPost('product_id')) ? 1 : 2, //2= shop review code and 1 is product review 
        ];
        // echo"Review :- <pre>";
        // print_r($data);
        // die();

        
        $review_id = $this->frontModel->insert_data(TBL_REVIEW, $data);
         // ✅ Handle image upload if file is selected
        $files = $this->request->getFiles(); 
        //$imageFile = $this->request->getFile('review_image');
        //echo"Check Image:- <pre>";
        //print_r($imageFile);
        //die;
        if (isset($files['review_image'])) {
            //die("Check Image");
            //foreach ($imageFiles['review_images'] as $imageFile) {
                foreach ($files['review_image'] as $imageFile) {
                if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move(FCPATH . 'public/uploads/review_images/', $newName);

                    // Save into TBL_REVIEW_IMAGE
                    $imageData = [
                        'review_id'    => $review_id,
                        'user_id'      => $this->request->getPost('user_id'),
                        'product_id'   => $this->request->getPost('product_id') ?? 0,
                        'review_image' => $newName,
                        'review_type'  => ($this->request->getPost('product_id')) ? 1 : 2,
                        'status'       => 1,
                        'is_deleted'   => 1,
                        'created_at'   => date('Y-m-d H:i:s'),
                    ];
                    $this->frontModel->insert_data(TBL_REVIEW_IMAGES, $imageData);
                }
            }
        }
        return redirect()->to('/Review')->with('success', 'Your Review submitted successfully.');
    }
    }
    
    //save and show Likes
    public function like()
    {
        $reviewId = $this->request->getPost('id');
        $db = \Config\Database::connect();
    
        // Increment likes safely
        $db->table(TBL_REVIEW)
           ->set('likes', 'likes+1', false)
           ->where('id', $reviewId)
           ->update();
    
        // Get updated like count
        $newLikes = $db->table(TBL_REVIEW)->select('likes')->where('id', $reviewId)->get()->getRow()->likes;
    
        return $this->response->setJSON([
            'status' => 'success',
            'likes' => $newLikes
        ]);
    }

    

    // // Store new review
    // public function store()
    // {
    //     // handle form submit later
    // }

    // Show edit form
    // public function edit($id)
    // {
    //     // load data by $id later
    //     return view('reviews/edit');
    // }

    // Update review
    // public function update($id)
    // {
    //     // handle update later
    // }

    // Delete review
    // public function delete($id)
    // {
    //     // handle delete later
    // }

    // View single review
    // public function show($id)
    // {
    //     // load single review later
    //     return view('reviews/show');
    // }
}
