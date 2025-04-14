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
        $related = Product::getRelated($id);
        $this->view("product-details", compact('product', 'related'));
    }
}