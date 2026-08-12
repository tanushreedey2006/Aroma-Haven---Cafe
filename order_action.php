<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

$action = $_POST['action'] ?? '';

/* ================= CANCEL ORDER ================= */
if($action === "cancel"){

    $order_number = $_POST['order_number'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $note = $_POST['note'] ?? '';

    if($order_number == ''){
        echo "error";
        exit();
    }

    $query = mysqli_query($conn,"
        UPDATE userorder 
        SET order_status='Cancelled',
            cancel_reason='$reason',
            cancel_note='$note',
            cancelled_at=NOW()
        WHERE order_number='$order_number'
    ");

    echo $query ? "success" : "error";
    exit();
}

/* ================= DELETE ORDER ================= */
if($action === "delete"){

    $order_number = $_POST['order_number'] ?? '';

    $query = mysqli_query($conn,"
        UPDATE userorder 
        SET is_deleted=1 
        WHERE order_number='$order_number'
    ");

    echo $query ? "success" : "error";
    exit();
}
?>