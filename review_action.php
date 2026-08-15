<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_SESSION['user_id'])){
    die("Login required");
}

$user_id = $_SESSION['user_id'];

// SAFE INPUTS
$product_id = intval($_POST['product_id']);
$rating = intval($_POST['rating']);
$review = mysqli_real_escape_string($conn, $_POST['review']);

// OPTIONAL NAME (not needed if you use clients table)
$name = mysqli_real_escape_string($conn, $_POST['name'] ?? 'User');

// ❌ REMOVED order_number completely (THIS FIXES YOUR ERROR)

// INSERT REVIEW
$query = "
INSERT INTO product_reviews
(user_id, product_id, rating, review, created_at)
VALUES
('$user_id', '$product_id', '$rating', '$review', NOW())
";

if(mysqli_query($conn, $query)){
    header("Location: viewproduct.php?id=$product_id");
    exit();
} else {
    echo "Error submitting review";
}
?>