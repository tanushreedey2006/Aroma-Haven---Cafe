
<!DOCTYPE html>
<html>
<head>
<title>Track Order</title>
<link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

$order_id = $_GET['order_id'] ?? 0;

$order = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM userorder WHERE id='$order_id'"
));

if(!$order){
    die("Order not found");
}

$status = $order['order_status'];




?>
<style>

/* ===== GLOBAL ===== */
body{
   body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#f4f5f7;
}
}

.coffee-loader{
    text-align:center;
    font-size:18px;
    margin:20px 0;
    animation:float 2s infinite;
}

@keyframes float{
    50%{
        transform:translateY(-6px);
    }
} 
.top-banner{
    background:linear-gradient(135deg,#4a2410,#8b5a2b);
    color:white;
    padding:35px;
    border-radius:25px;
    margin-bottom:25px;
    margin-top:5%;
    box-shadow:0 15px 40px rgba(0,0,0,.15);
}

.top-banner h1{
    margin:0;
    font-size:32px;
}

.top-banner p{
    opacity:.9;
}

.dashboard{
    display:grid;
    grid-template-columns:380px 1fr;
    gap:25px;
}

@media(max-width:1000px){
    .dashboard{
        grid-template-columns:1fr;
    }
}

.glass-card{
    background:white;
    border-radius:25px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.status-bar{
    height:12px;
    background:#eee;
    border-radius:20px;
    overflow:hidden;
    margin-top:20px;
}

.status-progress{
    height:100%;
    background:linear-gradient(90deg,#8b5a2b,#c68b59);
    border-radius:20px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin-top:20px;
}

.stat-box{
    background:#fff7f0;
    padding:15px;
    border-radius:15px;
    text-align:center;
}

.stat-box h4{
    margin:5px 0;
    color:#4a2410;
}

.delivery-live{
    background:linear-gradient(135deg,#e8fff0,#ffffff);
    border:1px solid #d7f3df;
    padding:20px;
    border-radius:20px;
    margin-top:20px;
}

.delivery-live h3{
    color:#28a745;
}

.product-large{
    width:180px;
    height:180px;
    border-radius:20px;
    object-fit:cover;
    margin-bottom:15px;
}

.order-details-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.order-details-table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

.order-details-table td:first-child{
    font-weight:600;
    color:#555;
}

.live-dot{
    width:10px;
    height:10px;
    background:#28a745;
    border-radius:50%;
    display:inline-block;
    animation:blink 1s infinite;
}

@keyframes blink{
    50%{
        opacity:.3;
    }
}

/* LEFT PANEL */
.left{
    width:95%;
    background:white;
   
    max-width:1500px;
    margin:30px auto;
    padding:30px;

    overflow:auto;
    box-shadow:5px 0 20px rgba(0,0,0,0.1);
}


/* ORDER INFO CARD */
.card{
    background:#fff7f0;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

/* STATUS BADGE */
.badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    color:white;
    background: #4a2410;
}

/* TIMELINE */
.timeline{
    margin-top:20px;
}

.step{
    display:flex;
    align-items:center;
    margin-bottom:25px;
    position:relative;
}

.step::before{
    content:"";
    position:absolute;
    left:14px;
    top:30px;
    width:2px;
    height:40px;
    background:#ddd;
}

.step:last-child::before{
    display:none;
}

.icon{
    width:28px;
    height:28px;
    border-radius:50%;
    background:#ddd;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-right:12px;
    color:white;
}

/* DONE */
.step.done .icon{
    background:#28a745;
}

/* ACTIVE */
.step.active .icon{
    background:#4a2410;
    animation:pulse 1.5s infinite;
}

@keyframes pulse{
    0%{box-shadow:0 0 0 0 rgba(74,36,16,0.5);}
    100%{box-shadow:0 0 0 12px rgba(74,36,16,0);}
}

.main-grid{
    display:grid;
    grid-template-columns:420px 1fr;
    gap:30px;
    align-items:start;
}

@media(max-width:900px){
    .main-grid{
        grid-template-columns:1fr;
    }
}
/* TEXT */
.step p{
    margin:0;
    font-weight:600;
    color:#333;
}

/* MAP LABEL */
.map-label{
    position:absolute;
    top:70px;
    left:400px;
    background:white;
    padding:10px 15px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.summary-card{
    background:white;
    border-radius:25px;
    padding:20px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,.08);
    margin-bottom:20px;
}

.summary-img{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:5px solid #f5ece4;
}

.summary-card h2{
    color:#4a2410;
    margin:10px 0;
}

.order-no{
    color:#777;
}

.price{
    font-size:30px;
    font-weight:700;
    color:#a65935;
}

.delivery-box{
    background:white;
    padding:20px;
    border-radius:20px;
    margin-bottom:20px;
}

.delivery-item{
    display:flex;
    gap:15px;
    margin-bottom:15px;
}

.delivery-item i{
    width:45px;
    height:45px;
    background:#fff3e8;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#5b2c06;
}

.partner-card{
    background:white;
    border-radius:20px;
    padding:15px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:20px;
}

.partner-card img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
}

.partner-card a{
    width:45px;
    height:45px;
    background:#28a745;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
}

.timeline-title{
    color:#4a2410;
}

.activity-card{
    background:white;
    padding:20px;
    border-radius:20px;
    margin-top:25px;
}

.activity-card ul{
    padding-left:18px;
}

.activity-card li{
    margin-bottom:12px;
    color:#555;
}
.delivery-success{
    background:#e8fff0;
    border:1px solid #28a745;
    padding:25px;
    border-radius:20px;
    text-align:center;
    margin-top:20px;
}

.delivery-success i{
    font-size:60px;
    color:#28a745;
}

.review-btn{
    margin-top:15px;
    background:#4a2410;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:12px;
    cursor:pointer;
}

.btn{
    display:inline-block;
    /* width: 10%;
    height: 5vh; */
    margin-top:15px;
    padding:12px 20px;
    background: #4a2410;
    color:white;
    text-decoration:none;
    border-radius:12px;
}


</style>
</head>

<body>


   <?php include('header.php') ?>

<div class="left">

<div class="top-banner">
    <h1>☕ Track Your Coffee Order</h1>
    <p>Order #<?php echo $order['id']; ?> • Premium Coffee Delivery</p>
</div>

<div class="dashboard">

    <!-- LEFT SIDE -->
    <div>

        <div class="glass-card" style="text-align:center;">

            <img src="images/<?php echo $order['product_image']; ?>"
                 class="product-large">

            <h2><?php echo $order['product_name']; ?></h2>

            <div class="price">
                ₹<?php echo $order['grand_total']; ?>
            </div>

            <span class="badge">
                <?php echo $status; ?>
            </span>

        </div>

        <div class="glass-card">

            <h3>Delivery Partner</h3>

            <div class="partner-card">

                <img src="./images/deliveryboy.jpg">

                <div>
                    <h3>Rahul Kumar</h3>
                    <p>Delivery Executive</p>
                </div>

                <a href="#">
                    <i class="fa fa-phone"></i>
                </a>

            </div>

        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div>

        <div class="glass-card">

            <h2>
                <span class="live-dot"></span>
                Live Tracking
            </h2>
            <?php if($status=="Processing"){ ?>

<div class="coffee-loader">
    ☕ Brewing Fresh Coffee...
</div>

<?php } ?>
            <div class="timeline">

<?php
$steps = ["Processing","Packed","Shipped","Delivered"];
$found = false;

foreach($steps as $step){

    $class = "";

    if($step == $status){
        $class = "active";
        $found = true;
    }
    elseif(!$found){
        $class = "done";
    }
?>

<div class="step <?php echo $class; ?>">

    <div class="icon">
        <i class="fa fa-check"></i>
    </div>

    <div>
        <h4><?php echo $step; ?></h4>

        <small>
        <?php
        if($step=="Processing") echo "Order Confirmed & Payment Verified";
        if($step=="Packed") echo "Freshly Prepared & Packed";
        if($step=="Shipped") echo "Out For Delivery";
        if($step=="Delivered") echo "Successfully Delivered";
        ?>

        <div class="status-bar">

                <div class="status-progress"
                style="
                width:
                <?php
                if($status=='Processing') echo '25%';
                elseif($status=='Packed') echo '50%';
                elseif($status=='Shipped') echo '75%';
                elseif($status=='Delivered') echo '100%';
                ?>">
                </div>

            </div>
        </small>

    </div>

</div>

<?php } ?>

</div>

            

        </div>

        <div class="stats">

            <div class="stat-box">
                <i class="fa fa-box"></i>
                <h4>Tracking ID</h4>
                <small>TRK<?php echo $order['id']; ?></small>
            </div>

            <div class="stat-box">
                <i class="fa fa-clock"></i>
                <h4>ETA</h4>
                <small>Today 7:30 PM</small>
            </div>

            <div class="stat-box">
                <i class="fa fa-credit-card"></i>
                <h4>Payment</h4>
                <small><?php echo $order['payment_status']; ?></small>
            </div>

        </div>
        

        <div class="delivery-live">

            <?php

if($status=="Processing"){
    $eta = "30-45 Minutes";
}
elseif($status=="Packed"){
    $eta = "20-30 Minutes";
}
elseif($status=="Shipped"){
    $eta = "10-15 Minutes";
}
else{
    $eta = "Delivered";
}

?>
           

            <h3>🚚 Delivery Update</h3>
                <p>
            Estimated Arrival:
            <b><?php echo $eta; ?></b>
            </p>
            <p>
                Your coffee order is currently
                <b><?php echo $status; ?></b>.
                We are preparing it with care and it will
                reach you shortly.
            </p>

            <?php if($status=="Delivered"){ ?>

<div class="delivery-success">

    <i class="fa-solid fa-circle-check"></i>

    <h2>Order Delivered Successfully</h2>

    <p>
        Enjoy your freshly brewed coffee ☕
    </p>

</div>

<?php } ?>

<?php if($status=="Delivered"){ ?>

<div class="glass-card">

    <h2>Rate Your Experience</h2>

    <div class="stars">
        ⭐⭐⭐⭐⭐
    </div>

    <textarea
        placeholder="Write a review..."
        style="
        width:100%;
        height:120px;
        padding:15px;
        border-radius:15px;
        border:1px solid #ddd;
        margin-top:15px;
        ">
    </textarea>

    <button class="review-btn">
        Submit Review
    </button>

</div>

<?php } ?>

        </div>

        <div class="glass-card">

            <h2>Order Details</h2>

            <table class="order-details-table">
                <tr>
                    <td>Order Date</td>
                    <td>
                        <?php
                        echo date(
                            "d M Y h:i A",
                            strtotime($order['created_at'])
                        );
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Order ID</td>
                    <td>#<?php echo $order['id']; ?></td>
                </tr>

                <tr>
                    <td>Product</td>
                    <td><?php echo $order['product_name']; ?></td>
                </tr>

                <tr>
                    <td>Quantity</td>
                    <td><?php echo $order['quantity']; ?></td>
                </tr>

                <tr>
                    <td>Total Amount</td>
                    <td>₹<?php echo $order['grand_total']; ?></td>
                </tr>

                <tr>
                    <td>Payment Method</td>
                    <td><?php echo $order['payment_method']; ?></td>
                </tr>

            </table>
            <br>
<a href="invoice.php?order_id=<?php echo $order['id']; ?>" class="btn track">
    🧾 Invoice
</a>

        </div>

    </div>

</div>

</div>



   <?php include('footer.php') ?>


</body>
</html>