<?php
include("includes/db_connect.php");
/** @var mysqli $conn */

$query = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM support_messages
WHERE sender='User'
AND notification=1
");

$data = mysqli_fetch_assoc($query);

echo $data['total'];
?>