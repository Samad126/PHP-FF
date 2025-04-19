<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::getFeatured();
        $newProducts = Product::getNewProducts();
        $this->view("home", [
            'products' => $featuredProducts,
            'newProducts' => $newProducts
        ]);
    }
}
