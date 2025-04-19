<?php

namespace App\controllers;

use App\core\Controller;
use App\core\Auth;
use App\models\Cart;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            header('Location: /login?redirect=/cart');
            exit;
        }
        
        $cart = Cart::getItems();
        $this->view("cart", ['cart' => $cart]);
    }

    public function add($productId)
    {
        try {
            Cart::add($productId);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                // For AJAX requests
                echo json_encode([
                    'success' => true,
                    'message' => 'Product added to cart successfully',
                    'cartCount' => count(Cart::getItems())
                ]);
                exit;
            }
            
            header("Location: /cart");
            exit;
            
        } catch (\Exception $e) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                // For AJAX requests
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }
            
            header("Location: /login?redirect=/cart");
            exit;
        }
    }

    public function remove($productId)
    {
        try {
            Cart::remove($productId);
            header("Location: /cart");
            exit;
        } catch (\Exception $e) {
            header("Location: /login?redirect=/cart");
            exit;
        }
    }
}
