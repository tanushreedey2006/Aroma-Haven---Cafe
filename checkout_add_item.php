<?php

session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_GET['product_id'])){
    die("Product Missing");
}

$product_id = (int)$_GET['product_id'];

$product = mysqli_fetch_assoc(

    mysqli_query(
        $conn,
        "SELECT * FROM products
         WHERE id='$product_id'"
    )

);

if(!$product){
    die("Product Not Found");
}

if(!isset($_SESSION['checkout_items'])){
    $_SESSION['checkout_items'] = [];
}

$found = false;

foreach($_SESSION['checkout_items'] as &$item){

    if($item['product_id'] == $product_id){

        $item['quantity']++;

        $found = true;
        break;
    }
}

if(!$found){

    $_SESSION['checkout_items'][] = [

        'product_id' => $product_id,
        'name'       => $product['name'],
        'image'      => $product['image'],
        'price'      => $product['price'],
        'quantity'   => 1

    ];
}

header("Location: checkout.php");
exit;