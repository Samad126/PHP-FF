<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $this->view("products", ['products' => $products]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            http_response_code(404);
            return $this->view("404");
        }
        
        $related = Product::getRelated($id);
        
        $this->view("productDetails", compact('product', 'related'));
    }
}
