<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::getFeatured();
        $this->view("home", ['products' => $products]);
    }
}