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
                $statusCode = match ($e->getMessage()) {
                    'This item is already in your cart' => 400,
                    'This item is out of stock' => 400,
                    'Please login to add items to cart' => 401,
                    default => 500
                };
                
                http_response_code($statusCode);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }
            
            $_SESSION['error'] = $e->getMessage();
            if ($e->getMessage() === 'Please login to add items to cart') {
                header("Location: /login?redirect=/cart");
            } else {
                header("Location: /cart");
            }
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
