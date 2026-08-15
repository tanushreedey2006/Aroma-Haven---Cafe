<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


header("Content-Type: application/json");

$autoload = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoload)) {
    die("Composer autoload not found. Run composer install in project folder.");
}

require $autoload;

use Razorpay\Api\Api;

$key_id = "rzp_test_SwcmXOKlPUQUeI";
$key_secret = "zOYG7p45ePG7Dtrd51VQfFzY";

$api = new Api($key_id, $key_secret);

$amount = (int)$_POST['amount'] * 100;

$order = $api->order->create([
    'receipt' => 'rcpt_' . rand(1000,9999),
    'amount' => $amount,
    'currency' => 'INR',
    'payment_capture' => 1
]);

echo json_encode([
    "order_id" => $order['id'],
    "amount" => $amount,
    "key" => $key_id
]);
?>