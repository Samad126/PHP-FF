<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Auth;
use App\models\Review;

class ReviewController extends Controller
{
    public function add()
    {
        if (!Auth::check()) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Please login to submit a review'
                ]);
                exit;
            }
            
            header('Location: /login?redirect=' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }

        try {
            // Validate input
            if (empty($_POST['product_id']) || empty($_POST['comment']) || empty($_POST['rating'])) {
                throw new \Exception('Please fill in all required fields');
            }

            $data = [
                'product_id' => $_POST['product_id'],
                'user_id' => Auth::user()['id'],
                'rating' => (int)$_POST['rating'],
                'title' => $_POST['title'] ?? null,
                'comment' => $_POST['comment']
            ];

            // Add review to database
            $reviewId = Review::create($data);

            $_SESSION['success'] = 'Review submitted successfully';
            header("Location: /products/{$_POST['product_id']}#reviews");
            exit;

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /products/{$_POST['product_id']}#review-form");
            exit;
        }
    }
}
