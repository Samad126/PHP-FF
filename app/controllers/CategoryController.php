<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Category;

class CategoryController extends Controller
{
    public function index($name)
    {
        $products = Category::getProductsByName($name);
        $this->view('category', ['products' => $products, 'category' => $name]);
    }
}