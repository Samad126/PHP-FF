<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Product;
use App\models\Category;
use App\models\Brand;

class ProductController extends Controller
{
    public function index()
    {
        $filters = [
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

        $this->view("products", [
            'products' => $products['items'],
            'total' => $products['total'],
            'categories' => $categories,
            'brands' => $brands,
            'filters' => $filters,
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
