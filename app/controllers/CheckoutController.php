<?php

namespace App\controllers;

use App\core\Controller;
use App\models\Cart;
use App\models\Order;
use App\core\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /login?redirect=/checkout');
            exit;
        }
    }

    public function index()
    {
        $cart = Cart::getItems();

        // if (empty($cart)) {
        //     header('Location: /cart');
        //     exit;
        // }

        $subtotal = Cart::getSubtotal();
        $shipping = Cart::calculateShipping();
        $total = Cart::getTotal();

        $this->view('checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total
        ]);
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /checkout');
            exit;
        }

        // Validate cart
        $cart = Cart::getItems();
        if (empty($cart)) {
            header('Location: /cart');
            exit;
        }

        // Validate shipping address
        $shippingAddress = $this->validateAddress($_POST);
        if (!$shippingAddress) {
            $_SESSION['error'] = 'Invalid shipping address';
            header('Location: /checkout');
            exit;
        }

        // Process payment
        try {
            $paymentResult = $this->processPayment($_POST);
            if (!$paymentResult) {
                throw new \Exception('Payment failed');
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::user()['id'],
                'items' => $cart,
                'shipping_address' => $shippingAddress,
                'payment_id' => $paymentResult['payment_id'],
                'subtotal' => Cart::getSubtotal(),
                'shipping' => Cart::calculateShipping(),
                'total' => Cart::getTotal(),
            ]);

            // Clear cart
            Cart::clear();

            // Redirect to success page
            header("Location: /checkout/success/{$order->id}");
            exit;

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /checkout');
            exit;
        }
    }

    public function success($orderId)
    {
        $order = Order::find($orderId);
        if (!$order || $order->user_id !== Auth::user()['id']) {
            header('Location: /');
            exit;
        }

        $this->view('checkout-success', ['order' => $order]);
    }

    private function validateAddress($data)
    {
        $required = ['first_name', 'last_name', 'email', 'address', 'city', 'country', 'zip_code', 'phone'];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }

        return [
            'first_name' => strip_tags($data['first_name']),
            'last_name' => strip_tags($data['last_name']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'address' => strip_tags($data['address']),
            'city' => strip_tags($data['city']),
            'country' => strip_tags($data['country']),
            'zip_code' => strip_tags($data['zip_code']),
            'phone' => strip_tags($data['phone'])
        ];
    }

    private function processPayment($data)
    {
        // Implement payment gateway integration here
        // This is just a placeholder
        $paymentMethod = $data['payment_method'] ?? '';
        
        switch ($paymentMethod) {
            case 'credit_card':
                // Process credit card payment
                break;
            case 'paypal':
                // Process PayPal payment
                break;
            case 'bank_transfer':
                // Process bank transfer
                break;
            default:
                return false;
        }

        // Return payment result
        return [
            'payment_id' => uniqid('pay_'),
            'status' => 'success'
        ];
    }
}




