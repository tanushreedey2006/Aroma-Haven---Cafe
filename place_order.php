<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connect.php");
/** @var mysqli $conn */

if (!isset($_SESSION['user_email'])) {
    header("Location: register.php");
    exit();
}

$email = $_SESSION['user_email'];

$user_query = mysqli_query(
    $conn,
    "SELECT * FROM clients WHERE email='$email' LIMIT 1"
);

if (!$user_query || mysqli_num_rows($user_query) == 0) {
    die("User not found.");
}

$user = mysqli_fetch_assoc($user_query);
$user_id = $user['id'];

if (empty($_SESSION['checkout_items'])) {
    die("No items found in checkout.");
}

/* SHIPPING DETAILS */
$name    = mysqli_real_escape_string($conn, $_POST['customer_name'] ?? '');
$phone   = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$city    = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
$state   = mysqli_real_escape_string($conn, $_POST['state'] ?? '');
$pincode = mysqli_real_escape_string($conn, $_POST['pin'] ?? '');

/* VALID PAYMENT METHOD */
$payment_method = $_POST['payment_method'] ?? 'Cash On Delivery';

$allowed_methods = [
    'Cash On Delivery',
    'UPI',
    'Card',
    'Net Banking'
];

if (!in_array($payment_method, $allowed_methods)) {
    $payment_method = 'Cash On Delivery';
}

/* SAME ORDER NUMBER FOR ALL ITEMS */
$order_number = "ORD" . time() . rand(100, 999);

/* CALCULATE GRAND TOTAL FIRST */
$grand_total = 0;

foreach ($_SESSION['checkout_items'] as $item) {

    $product_id = (int)$item['product_id'];
    $qty = (int)$item['quantity'];

    $product = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT * FROM products
             WHERE id='$product_id'
             AND status=1"
        )
    );

    if (!$product) {
        die("Product not found or inactive.");
    }

    if ($product['stock'] <= 0) {
        die("{$product['name']} is out of stock.");
    }

    if ($qty > $product['stock']) {
        die("Not enough stock for {$product['name']}.");
    }

    $grand_total += ($product['price'] * $qty);
}

/* INSERT ORDERS */
foreach ($_SESSION['checkout_items'] as $item) {

    $product_id = (int)$item['product_id'];
    $qty = (int)$item['quantity'];

    $product = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT * FROM products
             WHERE id='$product_id'
             AND status=1"
        )
    );

    $price = $product['price'];
    $total = $price * $qty;

    $insert = mysqli_query($conn, "
        INSERT INTO userorder
        (
            order_number,
            customer_id,
            customer_name,
            product_id,
            product_name,
            product_image,
            quantity,
            item_price,
            total_amount,
            grand_total,
            customer_number,
            shipping_address,
            city,
            state,
            pin,
            payment_method,
            payment_status,
            order_status
        )
        VALUES
        (
            '$order_number',
            '$user_id',
            '$name',
            '$product_id',
            '{$product['name']}',
            '{$product['image']}',
            '$qty',
            '$price',
            '$total',
            '$grand_total',
            '$phone',
            '$address',
            '$city',
            '$state',
            '$pincode',
            '$payment_method',
            'Pending',
            'Processing'
        )
    ");

    if (!$insert) {
        die("Order Insert Error: " . mysqli_error($conn));
    }

    $update_stock = mysqli_query($conn, "
        UPDATE products
        SET stock = stock - $qty
        WHERE id='$product_id'
    ");

    if (!$update_stock) {
        die("Stock Update Error: " . mysqli_error($conn));
    }
}

/* CLEAR CHECKOUT */
unset($_SESSION['checkout_items']);

header("Location: order_success.php?order_no=$order_number");
exit();
?>