<?php

include "connect.php";

/** @var mysqli $conn */
$id=$_GET['id'];


mysqli_query($conn,

"UPDATE bookings 
SET status='Cancelled'
WHERE id='$id'"

);


header("Location: my_bookings.php");

exit();

?>