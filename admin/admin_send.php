<?php
session_start();
include("includes/db_connect.php");
/** @var mysqli $conn */

$user_id=(int)$_POST['user_id'];
$message=mysqli_real_escape_string($conn,trim($_POST['message']));

if($message!="")
{
    mysqli_query($conn,"
    INSERT INTO support_messages
    (user_id,sender,message,notification)
    VALUES
    ('$user_id','Admin','$message',1)
    ");
}
?>