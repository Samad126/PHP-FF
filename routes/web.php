<?php

use App\core\Router;
use App\controllers\AuthController;
use App\controllers\HomeController;
use App\controllers\ProductController;
use App\controllers\CartController;
use App\controllers\CheckoutController;
use App\controllers\WishlistController;
use App\controllers\ReviewController;

// Auth routes
Router::get('/login', [AuthController::class, 'login']);
Router::post('/login', [AuthController::class, 'login']);
Router::get('/register', [AuthController::class, 'register']);
Router::post('/register', [AuthController::class, 'register']);
Router::get('/logout', [AuthController::class, 'logout']);

// Home routes
Router::get('/', [HomeController::class, 'index']);

// Review routes
Router::post('/reviews/add', [ReviewController::class, 'add']);
Router::post('/reviews/edit/{id}', [ReviewController::class, 'edit']);
Router::post('/reviews/delete/{id}', [ReviewController::class, 'delete']);

// Product routes
Router::get('/products', [ProductController::class, 'index']);
Router::get('/products/{id}', [ProductController::class, 'show']);

// Cart routes
Router::get('/cart', [CartController::class, 'index']);
Router::post('/cart/add/{id}', [CartController::class, 'add']);
Router::post('/cart/remove/{id}', [CartController::class, 'remove']);

// Wishlist routes
Router::get('/wishlist', [WishlistController::class, 'index']);
Router::post('/wishlist/add/{id}', [WishlistController::class, 'add']);
Router::post('/wishlist/remove/{id}', [WishlistController::class, 'remove']);

// Checkout routes
Router::get('/checkout', [CheckoutController::class, 'index']);
Router::post('/checkout/process', [CheckoutController::class, 'process']);

//fghfsdhgjdfghj
