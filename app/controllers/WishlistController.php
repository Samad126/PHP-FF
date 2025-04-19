<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Wishlist;
use App\core\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /login?redirect=/wishlist');
            exit;
        }
    }

    public function index()
    {
        $items = Wishlist::getItems();
        $this->view('wishlist', ['items' => $items]);
    }

    public function add($productId)
    {
        try {
            Wishlist::add($productId);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                echo json_encode([
                    'success' => true,
                    'message' => 'Product added to wishlist successfully'
                ]);
                exit;
            }
            
            header("Location: /wishlist");
            exit;
        } catch (\Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }
            
            header("Location: /login?redirect=/wishlist");
            exit;
        }
    }

    public function remove($productId)
    {
        try {
            Wishlist::remove($productId);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                echo json_encode([
                    'success' => true,
                    'message' => 'Product removed from wishlist successfully'
                ]);
                exit;
            }
            
            header("Location: /wishlist");
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
            
            header("Location: /login?redirect=/wishlist");
            exit;
        }
    }
}
