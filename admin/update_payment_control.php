<?php

session_start();

include "includes/db_connect.php";

global $conn;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: admin_payment_control.php");
    exit();
}

$id = isset($_POST['id'])
    ? (int)$_POST['id']
    : 0;

$payment_status =
    $_POST['payment_status'] ?? '';

$allowed_status = [
    'Pending',
    'Paid',
    'Failed'
];

if (
    $id <= 0 ||
    !in_array(
        $payment_status,
        $allowed_status,
        true
    )
) {

    die("Invalid payment update request!");
}


$stmt = mysqli_prepare(
    $conn,
    "UPDATE userorder
     SET payment_status = ?
     WHERE id = ?
     AND is_deleted = 0"
);

if (!$stmt) {

    die("Prepare failed: "
        . mysqli_error($conn));
}


mysqli_stmt_bind_param(
    $stmt,
    "si",
    $payment_status,
    $id
);


if (!mysqli_stmt_execute($stmt)) {

    die("Payment update failed: "
        . mysqli_stmt_error($stmt));
}


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| SUCCESS
|--------------------------------------------------------------------------
| Update করার পর আবার admin_payment_control.php-তে যাবে
*/

header(
    "Location: admin_payment_control.php?updated=1"
);

exit();
