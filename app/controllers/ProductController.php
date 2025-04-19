<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $topSellingProducts = Product::getTopSelling(3); // Get top 3 selling products for sidebar
        $this->view("products", [
            'products' => $products,
            'topSellingProducts' => $topSellingProducts
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            http_response_code(404);
            return $this->view("404");
        }
        
        $related = Product::getRelated($id);
        $topSellingProducts = Product::getTopSelling(3); // Get top 3 selling products for sidebar
        
        $this->view("productDetails", compact('product', 'related', 'topSellingProducts'));
    }
}
