<?php

session_start();

include("connect.php");
/** @var mysqli $conn */

if(!isset($_SESSION['user_email'])){

    header("Location: register.php");
    exit();

}

$email = $_SESSION['user_email'];


/* =========================
   GET USER
========================= */

$email_safe = mysqli_real_escape_string($conn, $email);

$userQuery = mysqli_query($conn,

    "SELECT id FROM clients 
     WHERE email='$email_safe'
     LIMIT 1"

);

$user = mysqli_fetch_assoc($userQuery);


if(!$user){

    header("Location: register.php");
    exit();

}


$user_id = (int)$user['id'];


/* =========================
   CLEAR OLD CHECKOUT
========================= */

$_SESSION['checkout_items'] = [];


/* =========================
   GET ALL ACTIVE CART ITEMS
========================= */

$query = mysqli_query($conn,

    "SELECT 
        id,
        product_id,
        name,
        image,
        price,
        quantity,
        total_price
     FROM addtocart
     WHERE user_id='$user_id'
     AND status='active'
     ORDER BY id DESC"

);


if(mysqli_num_rows($query) <= 0){

    header("Location: cart.php");
    exit();

}


/* =========================
   STORE ALL CART ITEMS
========================= */

while($row = mysqli_fetch_assoc($query)){

    $_SESSION['checkout_items'][] = [

        'cart_id'    => (int)$row['id'],

        'product_id' => (int)$row['product_id'],

        'name'       => $row['name'],

        'image'      => $row['image'],

        'price'      => (float)$row['price'],

        'quantity'   => (int)$row['quantity']

    ];

}


/* =========================
   REDIRECT TO CHECKOUT
========================= */

header("Location: checkout.php?source=cart_all");

exit();

?>