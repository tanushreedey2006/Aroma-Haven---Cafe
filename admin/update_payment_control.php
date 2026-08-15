<?php
include "includes/db_connect.php";
global $conn;
/** @var mysqli $conn */
echo "<pre>";
print_r($_POST);
echo "</pre>";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['id']) && isset($_POST['payment_status'])){

        $id = $_POST['id'];
        $status = $_POST['payment_status'];

        mysqli_query($conn,"
            UPDATE userorder
            SET payment_status='$status'
            WHERE id='$id'
        ");

        header("Location: admin_payment_control.php");
        exit;

    } else {
        echo "Form data missing";
    }

} else {
    echo "Invalid request method";
}
?>