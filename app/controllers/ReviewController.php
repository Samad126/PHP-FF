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

    public function edit($reviewId)
    {
        if (!Auth::check()) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Please login to edit your review'
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
            if (empty($_POST['comment']) || empty($_POST['rating'])) {
                throw new \Exception('Please fill in all required fields');
            }

            $data = [
                'rating' => (int)$_POST['rating'],
                'title' => $_POST['title'] ?? null,
                'comment' => $_POST['comment']
            ];

            // Update review
            $updated = Review::update($reviewId, Auth::user()['id'], $data);
            
            if (!$updated) {
                throw new \Exception('Unable to update review');
            }

            $_SESSION['success'] = 'Review updated successfully';
            header("Location: /products/{$_POST['product_id']}#reviews");
            exit;

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: /products/{$_POST['product_id']}#review-form");
            exit;
        }
    }

    public function delete($id)
    {
        try {
            if (!Auth::check()) {
                throw new \Exception('Please login to delete reviews');
            }

            $review = Review::find($id);
            
            if (!$review) {
                throw new \Exception('Review not found');
            }

            if ($review['user_id'] !== Auth::user()['id']) {
                throw new \Exception('You can only delete your own reviews');
            }

            Review::delete($id);

            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                echo json_encode([
                    'success' => true,
                    'message' => 'Review deleted successfully'
                ]);
                exit;
            }

            $_SESSION['success'] = 'Review deleted successfully';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;

        } catch (\Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }

            $_SESSION['error'] = $e->getMessage();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
