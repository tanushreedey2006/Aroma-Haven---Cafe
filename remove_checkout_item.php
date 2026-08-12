<?php

session_start();

$product_id = (int)($_GET['id'] ?? 0);

if(isset($_SESSION['checkout_items'])){

    foreach($_SESSION['checkout_items'] as $key => $item){

        if($item['product_id'] == $product_id){

            unset($_SESSION['checkout_items'][$key]);
        }
    }

    $_SESSION['checkout_items'] =
        array_values($_SESSION['checkout_items']);
}

header("Location: checkout.php?source=session");
exit();