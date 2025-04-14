<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::getItems();
        $this->view('wishlist', ['items' => $items]);
    }

    public function add($productId)
    {
        Wishlist::add($productId);
        header("Location: /wishlist");
    }

    public function remove($productId)
    {
        Wishlist::remove($productId);
        header("Location: /wishlist");
    }
}