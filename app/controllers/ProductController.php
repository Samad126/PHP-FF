<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;
use App\models\Category;
use App\models\Brand;
use App\models\Wishlist;
use App\models\Cart;
use App\models\Review;
use App\core\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // Get cart items
        $cartItems = [];
        if (Auth::check()) {
            $cartProducts = Cart::getItems();
            $cartItems = array_map(function($item) {
                return (int)$item['id']; // Ensure IDs are integers
            }, $cartProducts);
        }

        $filters = [
            'q' => isset($_GET['q']) ? trim($_GET['q']) : null,
            'category' => $_GET['category'] ?? null,
            'brand' => $_GET['brand'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
            'sort' => $_GET['sort'] ?? 'newest',
            'per_page' => $_GET['per_page'] ?? 20,
            'page' => $_GET['page'] ?? 1
        ];

        $products = Product::getFiltered($filters);
        $categories = Category::getAllWithCount();
        $brands = Brand::getAllWithCount();
        $topSellingProducts = Product::getTopSelling(3);
        $priceRange = Product::getPriceRange();

        $wishlistItems = Auth::check() ? array_column(Wishlist::getItems(), 'product_id') : [];

        $this->view("products", [
            'products' => $products['items'],
            'total' => $products['total'],
            'categories' => $categories,
            'brands' => $brands,
            'filters' => $filters,
            'topSellingProducts' => $topSellingProducts,
            'priceRange' => $priceRange,
            'wishlistItems' => $wishlistItems,
            'cartItems' => $cartItems
        ]);
    }

    public function show($id)
    {
        $product = Product::findWithDetails($id);
        if (!$product) {
            http_response_code(404);
            return $this->view("404");
        }
        
        $page = isset($_GET['review_page']) ? max(1, (int)$_GET['review_page']) : 1;
        $perPage = 5;
        
        $related = Product::getRelated($id);
        $reviewData = Review::forProduct($id, $page, $perPage);
        $reviewStats = Review::getProductStats($id);
        
        $wishlistItems = Auth::check() ? array_column(Wishlist::getItems(), 'product_id') : [];
        $cartItems = Auth::check() ? array_column(Cart::getItems(), 'id') : [];
        
        $this->view("productDetails", compact(
            'product', 
            'related', 
            'reviewData',
            'reviewStats',
            'wishlistItems',
            'cartItems'
        ));
    }
}
