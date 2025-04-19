<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;
use App\models\Wishlist;
use App\models\Cart;
use App\core\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $topSellingProducts = Product::getTopSelling();
        $newProducts = Product::getNewProducts(); // Changed from getNew() to getNewProducts()
        
        // Get cart items
        $cartItems = [];
        if (Auth::check()) {
            $cartProducts = Cart::getItems();
            $cartItems = array_map(function($item) {
                return (int)$item['id'];
            }, $cartProducts);
        }

        // Get wishlist items
        $wishlistItems = Auth::check() ? array_column(Wishlist::getItems(), 'product_id') : [];

        $this->view('home', [
            'topSellingProducts' => $topSellingProducts,
            'newProducts' => $newProducts,
            'cartItems' => $cartItems,
            'wishlistItems' => $wishlistItems
        ]);
    }
}
