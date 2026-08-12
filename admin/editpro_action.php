<?php

include "includes/db_connect.php";
global $conn;

/** @var mysqli $conn */

$id          = $_POST['id'];
$category_id = $_POST['category_id'];
$name        = $_POST['name'];
$price       = $_POST['price'];
$stock       = $_POST['stock'];
$status      = $_POST['status'];

$image = "";

if($_FILES['image']['name']!=""){

    $image = time().$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../images/".$image
    );

    mysqli_query($conn,"
    UPDATE products
    SET image='$image'
    WHERE id='$id'
    ");
}

mysqli_query($conn,"
UPDATE products
SET
category_id='$category_id',
name='$name',
price='$price',
stock='$stock',
status='$status'
WHERE id='$id'
");

header("Location: product_list.php");
exit;
?>