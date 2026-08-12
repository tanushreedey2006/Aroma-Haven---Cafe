<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

$user_id=$_SESSION['user_id'];

$q=mysqli_query($conn,"
SELECT COUNT(*) total
FROM support_messages
WHERE user_id='$user_id'
AND sender='Admin'
AND notification=1
");

$data=mysqli_fetch_assoc($q);

echo $data['total'];
?>