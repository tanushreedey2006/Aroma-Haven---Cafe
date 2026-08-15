<?php
session_start();
include("connect.php");

// payment info (optional)
$order_id = $_GET['order_id'] ?? '';
$payment_id = $_GET['payment_id'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success</title>
<style>
body{
    font-family: Arial;
    background:#f2fff5;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box{
    background:#fff;
    padding:30px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
h1{
    color:green;
}
.btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    background:green;
    color:#fff;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>
<body>

<div class="box">
    <h1>Payment Successful 🎉</h1>
    <p>Your booking has been confirmed.</p>

    <?php if($order_id){ ?>
        <p><b>Order ID:</b> <?php echo htmlspecialchars($order_id); ?></p>
    <?php } ?>

    <?php if($payment_id){ ?>
        <p><b>Payment ID:</b> <?php echo htmlspecialchars($payment_id); ?></p>
    <?php } ?>

    <a class="btn" href="index.php">Go to Home</a>
</div>

</body>
</html>