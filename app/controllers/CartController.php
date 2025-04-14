<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getItems();
        $this->view("cart", ['cart' => $cart]);
    }

    public function add($productId)
    {
        Cart::add($productId);
        header("Location: /cart");
    }

    public function remove($productId)
    {
        Cart::remove($productId);
        header("Location: /cart");
    }
}