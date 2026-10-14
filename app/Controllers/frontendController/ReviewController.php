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

    // API: Get all reviews and stats (JSON)
    public function apiGetReviews()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

        helper('review');
        $query = $this->frontModel->getReviewStats();

        $totalReviews = 0;
        $totalRating = 0;
        $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($query as $row) {
            $r = (int)$row['rating'];
            if ($r >= 1 && $r <= 5) {
                $ratingCounts[$r] = (int)$row['count'];
                $totalReviews += (int)$row['count'];
                $totalRating += ($r * (int)$row['count']);
            }
        }

        $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;

        $productReviews = getReviewsWithImages(1) ?? [];
        $shopReviews = getReviewsWithImages(2) ?? [];

        return $this->response->setJSON([
            'status' => 'success',
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'ratingCounts' => $ratingCounts,
            'productReviews' => $productReviews,
            'shopReviews' => $shopReviews
        ]);
    }

    // Show create form / API Save Review
    public function saveReview()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

        $productId = $this->request->getPost('product_id') ?? 0;
        $reviewType = ($productId && $productId != '0') ? 1 : 2;

        $data = [
            'product_id' => $productId,
            'user_id' => $this->request->getPost('user_id') ?? 0,
            'review_title' => $this->request->getPost('review_title') ?? '',
            'rating' => $this->request->getPost('rating') ?? 5,
            'review_text' => $this->request->getPost('review_text') ?? '',
            'YouTube_url' => $this->request->getPost('YouTube_url') ?? '',
            'name' => $this->request->getPost('name') ?? 'Customer',
            'email' => $this->request->getPost('email') ?? '',
            'review_type' => $reviewType,
            'likes' => 0,
            'status' => 1,
            'is_deleted' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        $review_id = $this->frontModel->insert_data(TBL_REVIEW, $data);

        // Handle image upload if files are selected
        $files = $this->request->getFiles(); 
        if (isset($files['review_image'])) {
            $images = is_array($files['review_image']) ? $files['review_image'] : [$files['review_image']];
            foreach ($images as $imageFile) {
                if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                    $newName = $imageFile->getRandomName();
                    $imageFile->move(FCPATH . 'public/uploads/review_images/', $newName);

                    $imageData = [
                        'review_id'    => $review_id,
                        'user_id'      => $this->request->getPost('user_id') ?? 0,
                        'product_id'   => $productId,
                        'review_image' => $newName,
                        'review_type'  => $reviewType,
                        'status'       => 1,
                        'is_deleted'   => 1,
                        'created_at'   => date('Y-m-d H:i:s'),
                    ];
                    $this->frontModel->insert_data(TBL_REVIEW_IMAGES, $imageData);
                }
            }
        }

        $acceptHeader = $this->request->getHeaderLine('Accept');
        if ($this->request->isAJAX() || str_contains($acceptHeader, 'application/json')) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Your review submitted successfully.',
                'review_id' => $review_id
            ]);
        }

        return redirect()->to('/Review')->with('success', 'Your Review submitted successfully.');
    }
    
    //save and show Likes
    public function like()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

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
