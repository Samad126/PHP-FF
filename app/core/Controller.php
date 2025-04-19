<?php

namespace App\core;

class Controller
{
    protected function view($view, $data = [])
    {
        // Add cart and wishlist counts to all views
        $data['cartCount'] = \App\models\Cart::getItems() ? count(\App\models\Cart::getItems()) : 0;
        $data['wishlistCount'] = \App\models\Wishlist::getItems() ? count(\App\models\Wishlist::getItems()) : 0;
        
        $viewPath = "../app/views/$view.php";
        extract($data);
        require "../app/views/layout.php";
    }
}
