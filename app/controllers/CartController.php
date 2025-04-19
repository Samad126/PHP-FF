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
            $quantity = 1;
            
            // Check if quantity was provided in request
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $json = file_get_contents('php://input');
                $data = json_decode($json, true);
                if (isset($data['quantity'])) {
                    $quantity = (int)$data['quantity'];
                }
            }

            Cart::add($productId, $quantity);
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
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
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
                exit;
            }
            
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER'] ?? '/cart');
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
