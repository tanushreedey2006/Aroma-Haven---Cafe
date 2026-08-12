<?php
session_start();

$data = $_SESSION['booking_data'] ?? [];

if(!$data){
    header("Location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Secure Booking Payment</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif;
}

body{

min-height:100vh;

background:
linear-gradient(135deg,#fff7e6,#f3d49b);

display:flex;
justify-content:center;
align-items:center;
padding:30px;
}

.container{

width:1200px;
max-width:100%;

display:grid;
grid-template-columns:420px 1fr;

gap:30px;
}

.card{

background:rgba(255,255,255,.75);

backdrop-filter:blur(15px);

border-radius:25px;

padding:30px;

box-shadow:
0 25px 60px rgba(0,0,0,.12);
}

/* LEFT */

.summary h2{
margin-bottom:20px;
color:#5b3718;
}

.summary-item{
padding:12px 0;
border-bottom:1px solid #eee;
}

.summary-item span{
font-weight:700;
color:#a36b2d;
}

.amount{

margin-top:25px;

background:
linear-gradient(135deg,#d8ad55,#a87320);

color:white;

padding:20px;

border-radius:15px;

text-align:center;
}

.amount h1{
font-size:38px;
}

/* RIGHT */

.title{
font-size:32px;
font-weight:700;
color:#5b3718;
margin-bottom:10px;
}

.subtitle{
color:#666;
margin-bottom:25px;
}

.methods{

display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
margin-bottom:25px;
}

.method{

background:white;

padding:25px;

border-radius:18px;

text-align:center;

cursor:pointer;

transition:.3s;

border:2px solid transparent;
}

.method:hover{

transform:translateY(-6px);

border-color:#c79a45;
}

.method i{
font-size:45px;
margin-bottom:12px;
}

.phonepe{
color:#5f259f;
}

.gpay{
color:#4285F4;
}

.paytm{
color:#00BAF2;
}

/* QR */

.qr-box{

background:white;

padding:25px;

border-radius:20px;

text-align:center;
}

.qr-box img{

width:220px;

height:220px;

object-fit:cover;

border-radius:12px;

margin-bottom:15px;
}

.pay-btn{

width:100%;

padding:18px;

border:none;

border-radius:50px;

font-size:18px;

font-weight:700;

cursor:pointer;

margin-top:20px;

background:
linear-gradient(135deg,#d8ad55,#a87320);

color:white;

transition:.3s;
}

.pay-btn:hover{

transform:translateY(-4px);

box-shadow:
0 15px 35px rgba(168,115,32,.35);
}

.secure{

margin-top:15px;

text-align:center;

color:#777;
}

@media(max-width:900px){

.container{
grid-template-columns:1fr;
}

.methods{
grid-template-columns:1fr;
}

}

</style>
</head>

<body>

<div class="container">

<!-- LEFT -->

<div class="card summary">

<h2>
☕ Booking Summary
</h2>

<div class="summary-item">
Name:
<span><?= $data['customer_name']; ?></span>
</div>

<div class="summary-item">
Phone:
<span><?= $data['customer_phone']; ?></span>
</div>

<div class="summary-item">
Date:
<span><?= $data['booking_date']; ?></span>
</div>

<div class="summary-item">
Time:
<span><?= $data['booking_time']; ?></span>
</div>

<div class="summary-item">
Guests:
<span><?= $data['people']; ?></span>
</div>

<div class="summary-item">
Event:
<span><?= $data['special_event']; ?></span>
</div>

<h1>
₹<?= $data['amount']; ?>
</h1>

</div>

<!-- RIGHT -->

<div class="card">

<div class="title">
💳 Secure Payment
</div>

<div class="subtitle">
Choose your preferred payment method
</div>

<div class="methods">

<div class="method">
<i class="fas fa-mobile-alt phonepe"></i>
<h4>PhonePe</h4>
</div>

<div class="method">
<i class="fab fa-google-pay gpay"></i>
<h4>Google Pay</h4>
</div>

<div class="method">
<i class="fas fa-wallet paytm"></i>
<h4>Paytm</h4>
</div>

</div>

<div class="qr-box">

<img src="./images/qr.png">

<h4>Scan & Pay</h4>

<p>
UPI ID:
premiumcoffee@paytm
</p>

<form action="payment_success.php" method="POST">

<button class="pay-btn">
✅ Payment Completed
</button>

</form>

<div class="secure">
🔒 256-bit Secure Payment Gateway
</div>

</div>

</div>

</div>

</body>
</html>