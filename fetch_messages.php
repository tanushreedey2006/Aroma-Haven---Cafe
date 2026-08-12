<?php
session_start();
include("connect.php");
/** @var mysqli $conn */


if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];

mysqli_query($conn,"
UPDATE support_messages
SET notification=0
WHERE user_id='$user_id'
AND sender='Admin'
");

$query=mysqli_query($conn,"
SELECT *
FROM support_messages
WHERE user_id='$user_id'
ORDER BY id ASC
");

while($row=mysqli_fetch_assoc($query))
{

if($row['sender']=="User")
{
?>

<div class="user-message">

<div class="user-bubble">

<?= nl2br(htmlspecialchars($row['message'])) ?>

<div class="message-time">

<?= date("d M Y h:i A",strtotime($row['created_at'])) ?>

</div>

</div>

</div>

<?php
}
else
{
?>

<div class="admin-message">

<div class="admin-bubble">

<?= nl2br(htmlspecialchars($row['message'])) ?>

<div class="message-time">

<?= date("d M Y h:i A",strtotime($row['created_at'])) ?>

</div>

</div>

</div>

<?php
}

}
?>