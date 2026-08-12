<?php
session_start();
include("connect.php");
/** @var mysqli $conn */


if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['message']) && !empty(trim($_POST['message']))) {

    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    mysqli_query($conn, "INSERT INTO support_messages
    (user_id,sender,message,notification)
    VALUES
    ('$user_id','User','$message',1)");
}
?>