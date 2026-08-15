<?php
session_start();
include("includes/db_connect.php");
/** @var mysqli $conn */

$user_id=(int)$_GET['user_id'];

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

<div class="user-msg">

<div class="user-bubble">

<?= nl2br(htmlspecialchars($row['message'])) ?>

<div class="time">

<?= date("d M Y h:i A",strtotime($row['created_at'])) ?>

</div>

</div>

</div>

<?php
}
else
{
?>

<div class="admin-msg">

<div class="admin-bubble">

<?= nl2br(htmlspecialchars($row['message'])) ?>

<div class="time">

<?= date("d M Y h:i A",strtotime($row['created_at'])) ?>

</div>

</div>

</div>

<?php
}

}
?>