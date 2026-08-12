

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Invoice</title>
    <link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_GET['order_id'])){
    die("Invalid Order");
}

$order_id = intval($_GET['order_id']);

$orderQuery = mysqli_query($conn,"
SELECT *
FROM userorder
WHERE id='$order_id'
LIMIT 1
");

$order = mysqli_fetch_assoc($orderQuery);

if(!$order){
    die("Order Not Found");
}
?>
<style>

body{
    margin:0;
    padding:40px;
    font-family:Poppins,sans-serif;

    background:
    radial-gradient(circle at top left,#fff5ee,#f5e6d8),
    linear-gradient(135deg,#f7f1eb,#e9dfd5);

    min-height:100vh;
}
.invoice{
    max-width:1200px;
    margin:auto;

    background:rgba(255,255,255,.92);

    backdrop-filter:blur(12px);

    border-radius:35px;

    padding:50px;

    box-shadow:
    0 25px 60px rgba(0,0,0,.08),
    0 0 0 1px rgba(255,255,255,.4);

    animation:fadeUp .8s ease;
}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(40px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:2px solid #eee;
    padding-bottom:20px;
}

.logo{
    font-size:32px;
    font-weight:bold;
    color:#5b2c06;
}

.invoice-no{
    text-align:right;
}

.invoice-no h2{
    margin:0;
    color:#5b2c06;
}

.section{
    margin-top:30px;
}

.section h3{
    color:#5b2c06;
    margin-bottom:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#5b2c06;
    color:white;
    padding:12px;
}

table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

.total-box{
    margin-top:25px;
    text-align:right;
}

.total-box h2{
    color:#a65935;
}

.badge{

    display:inline-block;

    padding:10px 18px;

    border-radius:50px;

    color:white;

    font-weight:600;

    animation:pulseBadge 2s infinite;
}

@keyframes pulseBadge{

0%{
    box-shadow:0 0 0 0 rgba(0,0,0,.2);
}

70%{
    box-shadow:0 0 0 12px rgba(0,0,0,0);
}

100%{
    box-shadow:0 0 0 0 rgba(0,0,0,0);
}

}
.Pending{
    background:#ff9800;
}

.Processing{
    background:#17a2b8;
}

.Packed{
    background:#795548;
}

.Shipped{
    background:#3f51b5;
}

.Delivered{
    background:#28a745;
}

.Cancelled{
    background:#dc3545;
}

.print-btn{

    background:#5b2c06;

    color:white;
}

@media print{
    .print-btn{
        display:none;
    }

    body{
        background:white;
        padding:0;
    }

    .invoice{
        box-shadow:none;
    }
}



.invoice-header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:40px;

    padding-bottom:25px;

    border-bottom:2px dashed #ead8c7;
}

.brand{
    font-size:42px;

    color:#5b2c06;

    margin:0;

    animation:floatCoffee 3s infinite ease-in-out;
}
.invoice-right{
    text-align:right;
}

@keyframes floatCoffee{

0%{
    transform:translateY(0);
}

50%{
    transform:translateY(-6px);
}

100%{
    transform:translateY(0);
}

}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:30px;
}

.info-card{

    background:white;

    border-radius:25px;

    padding:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.05);

    transition:.4s;
}

.info-card:hover{

    transform:translateY(-8px);

    box-shadow:
    0 20px 40px rgba(0,0,0,.08);

}

.product-section{

    display:flex;

    gap:25px;

    align-items:center;

    background:white;

    border-radius:25px;

    padding:25px;

    margin:35px 0;

    box-shadow:
    0 15px 35px rgba(0,0,0,.06);

    transition:.4s;
}

.product-section:hover{

    transform:translateY(-5px);

}

.product-image{

    width:140px;

    height:140px;

    object-fit:cover;

    border-radius:25px;

    transition:.4s;
}

.product-image:hover{

    transform:scale(1.08);

}


.product-details h2{
    margin:0;
    color:#5b2c06;
}

.total-section{

    width:380px;

    margin-left:auto;

    margin-top:30px;

    background:linear-gradient(
    135deg,
    #fff8f2,
    #ffffff
    );

    border-radius:25px;

    padding:25px;

    box-shadow:
    0 15px 35px rgba(0,0,0,.06);
}
.total-row{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    margin-bottom:12px;
}

.grand{
    border-top:2px solid #eee;
    font-size:22px;
    font-weight:bold;
    color:#a65935;
}

.footer{
    text-align:center;
    margin-top:50px;
    padding-top:25px;
    border-top:1px solid #eee;
}

.footer h3{
    color:#5b2c06;
}

.track-btn{

    background:#28a745;

    color:white;

    margin-left:10px;
}

.print-btn,
.track-btn{

    display:inline-block;

    margin-top:25px;

    border:none;

    padding:14px 28px;

    border-radius:15px;

    font-weight:600;

    text-decoration:none;

    transition:.4s;
}

.print-btn:hover,
.track-btn:hover{

    transform:translateY(-3px);

}


.steam{
    position:relative;
    height:20px;
}

.steam span{

    position:absolute;

    width:8px;
    height:30px;

    background:#ddd;

    border-radius:50px;

    opacity:.4;

    animation:steam 3s infinite;
}

.steam span:nth-child(2){
    left:15px;
    animation-delay:.5s;
}

.steam span:nth-child(3){
    left:30px;
    animation-delay:1s;
}

@keyframes steam{

0%{
    transform:translateY(0);
    opacity:0;
}

50%{
    opacity:.5;
}

100%{
    transform:translateY(-25px);
    opacity:0;
}

}
.timeline{

    margin-top:30px;

    position:relative;

    padding-left:20px;
}

.step{

    display:flex;

    align-items:center;

    margin-bottom:30px;

    position:relative;
}

.icon{

    width:45px;

    height:45px;

    border-radius:50%;

    background:#ddd;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    margin-right:15px;

    font-size:18px;
}

.done .icon{

    background:#28a745;

    box-shadow:0 0 15px #28a74580;

}
.active .icon{

    background:#5b2c06;

    animation:activePulse 1.5s infinite;
}

@keyframes activePulse{

0%{
    box-shadow:0 0 0 0 rgba(91,44,6,.5);
}

100%{
    box-shadow:0 0 0 18px rgba(91,44,6,0);
}

}

</style>
</head>

<body>

<!-- <div class="invoice">

    <div class="top">

        <div>
            <div class="logo">☕ Coffee Shop</div>
            <p>Premium Coffee Experience</p>
        </div>

        <div class="invoice-no">
            <h2>Invoice</h2>
            <p>#INV-<?php echo $order['id']; ?></p>
        </div>

    </div>

    <div class="section">

        <h3>Order Information</h3>

        <p><b>Order ID:</b> <?php echo $order['id']; ?></p>

        <p>
            <b>Order Status:</b>

            <span class="badge <?php echo $order['order_status']; ?>">
                <?php echo $order['order_status']; ?>
            </span>
        </p>

        <p><b>Payment Method:</b> <?php echo $order['payment_method']; ?></p>

        <p><b>Payment Status:</b> <?php echo $order['payment_status']; ?></p>

    </div>

    <div class="section">

        <h3>Product Details</h3>

        <table>

            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>

            <tr>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['quantity']; ?></td>
                <td>₹<?php echo $order['grand_total']; ?></td>
            </tr>

        </table>

    </div>

    <div class="total-box">

        <h2>
            Grand Total :
            ₹<?php echo $order['grand_total']; ?>
        </h2>

    </div>

    <button class="print-btn" onclick="window.print()">
        <i class="fa fa-print"></i>
        Print Invoice
    </button>

</div> -->


<div class="invoice">

    <!-- HEADER -->
    <div class="invoice-header">

        <div>
            <h1 class="brand">☕ Aroma Haven </h1>
            <div class="steam">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <p>Premium Coffee Experience</p>
        </div>

        <div class="invoice-right">
            <h2>INVOICE</h2>

            <p>
                Invoice No:
                <strong>INV-<?php echo $order['id']; ?></strong>
            </p>

            <p>
                Date:
                <strong><?php echo date("d M Y"); ?></strong>
            </p>

        </div>

    </div>

    <!-- CUSTOMER + ORDER -->
    <div class="info-grid">

        <div class="info-card">
            <h3>Customer Details</h3>

            <p><strong>Name:</strong> <?php echo $order['customer_name']; ?></p>


            <p><strong>Phone:</strong> <?php echo $order['customer_number']; ?></p>

           
        <b>Address:</b><br>

          <p><strong>Shipping-address:</strong>  <?php echo $order['shipping_address']; ?></p>

           <p><strong>City:</strong><?php echo $order['city']; ?> </p>
           <p><strong>State:</strong> <?php echo $order['state']; ?> </p>
             <p><strong>Pin:</strong> <?php echo $order['pin']; ?></p>
  
        </div>

        <div class="info-card">
            <h3>Order Details</h3>

            <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>

            <p><strong>Payment:</strong> <?php echo $order['payment_method']; ?></p>

            <p>
                <strong>Status:</strong>

                <span class="badge <?php echo $order['order_status']; ?>">
                    <?php echo $order['order_status']; ?>
                </span>
            </p>

        </div>

    </div>

    <!-- PRODUCT -->
    <div class="product-section">
        <h3>Product Details</h3>

        <img
            src="images/<?php echo $order['product_image']; ?>"
            class="product-image"
        >

        <div class="product-details">

            <h2><?php echo $order['product_name']; ?></h2>

            <p>Premium Fresh Coffee</p>

            <h3>Quantity: <?php echo $order['quantity']; ?></h3>

             <h3>
            Item Price:
            ₹<?php echo $order['item_price']; ?>
            </h3>

        </div>

    </div>

    <!-- TABLE -->
    <table>

        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>

        <tr>
            <td><?php echo $order['product_name']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td>₹<?php echo $order['grand_total']; ?></td>
        </tr>

    </table>

    <div class="section">

<h3>Delivery Information</h3>

<p>
    <b>Tracking Number:</b>

    <?php
    echo $order['tracking_number']
    ? $order['tracking_number']
    : 'Not Assigned';
    ?>
</p>

<p>
    <b>Delivery Status:</b>

    <?php echo $order['delivery_status']; ?>
</p>

<p>
    <b>Estimated Delivery:</b>

    <?php
    echo $order['estimated_delivery']
    ? $order['estimated_delivery']
    : 'Pending';
    ?>
</p>

</div>

    <!-- TOTAL -->
    <div class="total-section">

        <div class="total-row">
            <span>Subtotal</span>
            <span>₹<?php echo $order['grand_total']; ?></span>
        </div>

        <div class="total-row">
    <span>Delivery Charge</span>
    <span>₹<?php echo $order['delivery_charge']; ?></span>
        </div>

        <div class="total-row">
        <span>Discount</span>
        <span>
            - ₹<?php echo $order['discount_amount']; ?>
        </span>
    </div>

        <div class="total-row grand">
            <span>Grand Total</span>
            <span>₹<?php echo $order['grand_total']; ?></span>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">

        <h3>Thank You For Your Order ☕</h3>

        <p>
            We appreciate your business and hope you enjoy
            your premium coffee experience.
        </p>

    </div>

    <div class="section">

<h3>Order Journey</h3>

<div class="timeline">

<?php

$steps = [
    "Pending",
    "Confirmed",
    "Processing",
    "Packed",
    "Shipped",
    "Delivered"
];

$found = false;

foreach($steps as $step){

$class="";

if($step==$order['order_status']){
    $class="active";
    $found=true;
}
elseif(!$found){
    $class="done";
}
?>

<div class="step <?php echo $class; ?>">

    <div class="icon">
        <i class="fa fa-check"></i>
    </div>

    <div>

        <strong><?php echo $step; ?></strong>

    </div>

</div>

<?php } ?>

</div>

</div>

    <button class="print-btn" onclick="window.print()">
        <i class="fa fa-print"></i>
        Print Invoice
    </button>

    <a href="track_order.php?order_id=<?php echo $order['id']; ?>"
   class="track-btn">

   <i class="fa fa-location-dot"></i>
   Track Order

</a>

</div>

</body>
</html>