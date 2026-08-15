<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

require("vendor/autoload.php");

use Razorpay\Api\Api;

$key_id = "rzp_test_SwcmXOKlPUQUeI";
$key_secret = "zOYG7p45ePG7Dtrd51VQfFzY";

$api = new Api($key_id, $key_secret);

$attributes = [
    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
    'razorpay_order_id' => $_POST['razorpay_order_id'],
    'razorpay_signature' => $_POST['razorpay_signature']
];

try {

    // VERIFY PAYMENT
    $api->utility->verifyPaymentSignature($attributes);

    // GET REAL DATA (IMPORTANT)
    $user_id = $_SESSION['user_id'];

    $product_id = $_SESSION['product_id'];
    $qty = $_SESSION['quantity'];
    $total = $_SESSION['total_amount'];

    // FETCH PRODUCT
    $product = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM products WHERE id='$product_id'"
    ));

    // INSERT REAL ORDER
    mysqli_query($conn, "INSERT INTO userorder
    (customer_id, customer_name, product_id, product_name, product_image,
     quantity, item_price, total_amount, customer_number,
     shipping_address, city, state, pin,
     payment_method, payment_status, order_status)

    VALUES
    ('$user_id','Online User','$product_id','{$product['name']}','{$product['image']}',
     '$qty','{$product['price']}','$total',
     '$_SESSION[phone]','$_SESSION[address]',
     '$_SESSION[city]','$_SESSION[state]','$_SESSION[pin]',
     'RAZORPAY','Paid','Processing')");

    echo "success";

} catch (Exception $e) {
    echo "failed";
}
?>