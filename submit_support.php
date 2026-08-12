<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

/** @var mysqli $conn */

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: support.php");
    exit();
}

$message = trim($_POST['message'] ?? '');

if ($message === '') {
    die("Message cannot be empty.");
}


/* ==========================================
   INSERT USER SUPPORT MESSAGE
========================================== */

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO support_messages
    (user_id, sender, message, notification, created_at)
    VALUES (?, 'User', ?, 1, NOW())"
);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $user_id,
    $message
);

if (!mysqli_stmt_execute($stmt)) {
    die(
        "Message could not be sent: "
        . mysqli_stmt_error($stmt)
    );
}

mysqli_stmt_close($stmt);


/* ==========================================
   RETURN TO SUPPORT PAGE
========================================== */

header("Location: support.php?success=1");
exit();

?>