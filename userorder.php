
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Coffee Orders</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

<link rel="stylesheet" type="text/css" href="coffee.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet"  type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />
<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_SESSION['user_email'])){
    header("Location: register.php");
    exit();
}

$email = $_SESSION['user_email'];

$user = mysqli_query($conn,"
SELECT * FROM clients
WHERE email='$email'
");

$user_row = mysqli_fetch_assoc($user);

$user_id = $user_row['id'];


$orderGroups = mysqli_query($conn,"SELECT 
order_number,
MAX(order_status) as order_status,
COUNT(*) as item_count,
MAX(created_at) as order_date,
SUM(grand_total) as total_amount
FROM userorder
WHERE customer_id='$user_id'
AND is_deleted=0
GROUP BY order_number
ORDER BY MAX(created_at) DESC
");


/* TOTAL UNIQUE ORDERS */
$totalOrdersQuery = mysqli_query($conn,"SELECT COUNT(DISTINCT order_number) as total
FROM userorder
WHERE customer_id='$user_id'
");

$totalOrdersData = mysqli_fetch_assoc($totalOrdersQuery);
$totalOrders = $totalOrdersData['total'];

/* DELIVERED */
$delivered = mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT order_number
FROM userorder
WHERE customer_id='$user_id'
AND is_deleted=0
AND order_status='Delivered'
"));

/* ACTIVE */
$active = mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT order_number
FROM userorder
WHERE customer_id='$user_id'
AND is_deleted=0
AND order_status!='Delivered'
AND order_status!='Cancelled'
"));

/* TOTAL SPENT */
$totalSpentQuery = mysqli_query($conn,"SELECT SUM(grand_total) as total
FROM userorder
WHERE customer_id='$user_id'
");

$totalSpentData = mysqli_fetch_assoc($totalSpentQuery);
$totalSpent = $totalSpentData['total'] ?? 0;

?>
<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

/* ================= GLOBAL ================= */
body{
    /* margin:0; */
    font-family:Poppins,sans-serif;
    background:
    radial-gradient(circle at top left,#fff6ef,#f1e3d6),
    radial-gradient(circle at bottom right,#f9eee5,#e9d7c6);
    /* min-height:100vh; */
    overflow-x:hidden;
}

/* ================= HEADER ================= */
.premium-header{
    width:92%;
    margin:-5%  auto;
    padding:50px 0;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.premium-header h1{
    font-size:55px;
    color:#4a2410;
    margin:0;
}

.premium-header p{
    color:#777;
}

.dashboard-stats{
    width:92%;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
    margin-top:30px;
}

.stat-box{
    background:white;
    padding:25px;
    border-radius:25px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,.08);
    transition:.4s;
}

.stat-box:hover{
    transform:translateY(-8px);
}

.stat-box i{
    font-size:35px;
    color:#a65935;
}

.stat-box h2{
    margin:15px 0 5px;
    color:#4a2410;
}

.stat-box span{
    color:#777;
}
/* ================= GRID ================= */
.order-grid{
    width:92%;
    margin: 2% auto;
    display:none;
    grid-template-columns:repeat(auto-fit,minmax(340px,1fr));
    gap:30px;
    padding:40px 0 80px;
}

/* ================= CARD ================= */
.order-card{
    background:#fff;
    border-radius:30px;
    overflow:hidden;
    position:relative;
    box-shadow:
    0 15px 40px rgba(0,0,0,.08);
     animation:fadeUp .8s ease;

    transition:.4s;
    border:1px solid #f1e6dd;
}

.order-card:hover{
    transform:translateY(-12px);
    box-shadow:
    0 25px 70px rgba(166,89,53,.25);
}

/* TOP */
.order-top{
    display:flex;
    justify-content:space-between;
    padding:15px 20px;
    background:linear-gradient(90deg,#fff3e8,#fff);
}

.order-id{
    font-weight:700;
    color:#4a2410;
}

/* IMAGE */
.product-img{
    width:100%;
    height:250px;
    object-fit:cover;
    transition:.6s;
}
.order-card:hover .product-img{
    transform:scale(1.08);
}

.order-card::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:linear-gradient(
        120deg,
        transparent,
        rgba(255,255,255,.4),
        transparent
    );
    transition:.8s;
}

.order-card:hover::before{
    left:100%;
}

/* BODY */
.order-body{
    padding:20px;
}

.order-body h2{
    font-size:24px;
    color:#3e1d0b;
    margin-bottom:8px;
}

.price{
    font-size:32px;
    font-weight:800;
    color:#b1682d;
}

/* INFO */
.info p{
    margin:6px 0;
    color:#5b5b5b;
}

/* STATUS BADGE */
.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    color:#fff;
}

.Pending{background:#ff9800;}
.Processing{background:#17a2b8;}
.Delivered{background:#28a745;}
.Cancelled{background:#dc3545;}

/* BUTTONS */
.actions{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.btn{
    border:none;
    border-radius:15px;
    padding:12px;
    font-weight:700;
    transition:.3s;
    text-decoration:none;
    text-align:center;
}

/* TRACK ORDER */
.track{
    background:linear-gradient(135deg,#4a2410,#7a3d1a);
    color:white;
    box-shadow:0 10px 25px rgba(74,36,16,.25);
}

.track:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(74,36,16,.35);
}

/* INVOICE */
.invoice{
    background:linear-gradient(135deg,#0d6efd,#4da3ff);
    color:white;
    box-shadow:0 10px 25px rgba(13,110,253,.25);
}

.invoice:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(13,110,253,.35);
}

/* REORDER */
.reorder{
    background:linear-gradient(135deg,#28a745,#52d769);
    color:white;
    box-shadow:0 10px 25px rgba(40,167,69,.25);
}

.reorder:hover{
    transform:translateY(-4px) rotate(-3deg);
}

/* DELETE */
.delete-btn{
    background:linear-gradient(135deg,#6c757d,#9ca3af);
    color:white;
    box-shadow:0 10px 25px rgba(108,117,125,.20);
}

.delete-btn:hover{
    transform:translateY(-4px);
}

/* CANCEL */
.cancel{
    background:linear-gradient(135deg,#dc3545,#ff6b81);
    color:white;
    box-shadow:0 10px 25px rgba(220,53,69,.25);
}

.cancel:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 35px rgba(220,53,69,.35);
}

/* EMPTY */
.empty{
    text-align:center;
    padding:120px;
}

.empty a{
    background:#4a2410;
    color:white;
    padding:12px 25px;
    border-radius:25px;
    text-decoration:none;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-box{
    background:white;
    padding:25px;
    width:360px;
    border-radius:20px;
    animation:pop .3s ease;
}


/* ================= RESULT CARD ================= */

.result-card{
    max-width:420px;
}

.success-result-icon{
    background:#e8f8ee;
    color:#28a745;
    box-shadow:0 10px 30px rgba(40,167,69,.20);
}

.error-result-icon{
    background:#fff0f0;
    color:#dc3545;
    box-shadow:0 10px 30px rgba(220,53,69,.18);
}

.result-continue-btn{

    background:
        linear-gradient(
            135deg,
            #4a2410,
            #8b4513
        );

    color:white;

    box-shadow:
        0 8px 20px
        rgba(74,36,16,.25);

}

.result-continue-btn:hover{

    transform:translateY(-3px);

}

@keyframes pop{
    from{transform:scale(.7);opacity:0;}
    to{transform:scale(1);opacity:1;}
}

.modal-box h2{
    color:#4a2410;
}

.modal-box select,
.modal-box textarea{
    width:100%;
    margin-top:10px;
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
}

.modal-actions{
    display:flex;
    justify-content:space-between;
    margin-top:15px;
}

.btn-cancel{
    background:#777;
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
}

.progress-box{
    width:100%;
    height:10px;
    background:#eee;
    border-radius:30px;
    overflow:hidden;
    margin:15px 0;
}

.progress-fill{
    height:100%;
    border-radius:30px;
    background:linear-gradient(
        90deg,
        #a65935,
        #d88c56
    );
    transition:1s;
}

.btn-confirm{
    background:#dc3545;
    color:white;
    border:none;
    padding:10px;
    border-radius:10px;
    cursor:pointer;
}
.floating-coffee{
    position:fixed;
    width:250px;
    height:250px;
    background:rgba(166,89,53,.08);
    border-radius:50%;
    filter:blur(80px);
    top:10%;
    left:10%;
    animation:float 10s infinite ease-in-out;
    z-index:-1;
}

.coffee2{
    top:50%;
    right:10%;
    left:auto;
    animation-delay:2s;
}

.coffee3{
    top:80%;
    left:40%;
    animation-delay:4s;
}

@keyframes float{
    0%,100%{
        transform:translateY(0px);
    }
    50%{
        transform:translateY(-40px);
    }
}




.status-ribbon{
    position:absolute;
    top:20px;
    right:-35px;
    background:#28a745;
    color:white;
    padding:8px 45px;
    transform:rotate(45deg);
    font-size:12px;
    font-weight:bold;
    z-index:5;
}

.header{
    text-align:center;
    padding:80px 20px 40px;
}

.header h1{
    font-size:58px;
    color:#4a2410;
    margin:0;
}

.header p{
    color:#7c6a5c;
    font-size:18px;
}

.steam{
    position:absolute;
    width:20px;
    height:80px;
    background:rgba(255,255,255,.4);
    filter:blur(10px);
    border-radius:50%;
    animation:steam 3s infinite;
}

.steam1{
    left:40%;
    top:170px;
}

.steam2{
    left:50%;
    top:165px;
    animation-delay:.5s;
}

.steam3{
    left:60%;
    top:170px;
    animation-delay:1s;
}

.empty i{
    font-size:100px;
    color:#a65935;
    margin-bottom:20px;
}

@keyframes steam{
    from{
        opacity:.8;
        transform:translateY(0);
    }
    to{
        opacity:0;
        transform:translateY(-80px);
    }
}
.img-wrap{
    height:260px;
    overflow:hidden;
    position:relative;
}

.floating-status{
    position:absolute;
    top:15px;
    right:15px;
    background: #ff9800;
    color:#fff;
    padding:8px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
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
.hero{
    text-align:center;
    padding:80px 20px;
}

.hero h1{
    font-size:60px;
    color:#4a2410;
    margin-top: 40px ;
    margin-right: 10%;
}

.hero p{
    color:#777;
    font-size:18px;
    margin-right: 10%;
}




.order-list{
    width:92%;
    height: fit-content;
    margin:30px auto;
}
.order-item{
    background:#fff;
    border-radius:20px;
    margin-top:3%;
    overflow:hidden;
    border:1px solid #eee;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    transition:.3s;
    contain:layout;
}

.order-item:hover{
    transform:translateY(-5px);
}

.order-main{
    padding:20px;
    
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.order-left{
    display:flex;
    gap:20px;
    align-items:center;
}

.product-thumb{
    width:90px;
    height:90px;
    border-radius:12px;
    object-fit:cover;
}

.top-line{
    display:flex;
    gap:15px;
    margin-bottom:8px;
}

.status-pill{
    background:#e8f7e8;
    color:#28a745;
    padding:6px 14px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.date{
    color:#777;
    font-size:14px;
}

.order-details h3{
    margin:0;
    color:#4a2410;
}

.order-details p{
    margin:6px 0;
    color:#666;
}

.order-details h2{
    margin:0;
    color:#000;
}

.toggle-btn{
    width:50px;
    height:50px;
    border:none;
    border-radius:50%;
    cursor:pointer;
    background:#f3f3f3;
    font-size:18px;
    transition:.3s;
}

.toggle-btn:hover{
    background:#4a2410;
    color:white;
}

.order-expand{
    max-height:0;
    overflow:hidden;
    transition:max-height .6s ease;
}


.order-item.active .order-expand{
    max-height:5000px;
    overflow:visible;
    padding:20px;
}
.order-item.active .toggle-btn i{
    transform:rotate(90deg);
}

.order-page-wrapper{
    isolation:isolate;
    position:relative;
}
.order-list{
    width:92%;
    margin:30px auto;
    overflow:hidden;
}

.action-row{
    margin-top:20px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}

.action-btn{
    padding:12px 20px;
    border:none;
    border-radius:12px;
    text-decoration:none;
    color:white;
    font-weight:600;
}

.track-btn{
    background:#8b4513;
}

.invoice-btn{
    background:#0d6efd;
}

.buy-btn{
    background:#28a745;
}

.cancel-btn{
    background:#dc3545;
}

@media(max-width:768px){

    .order-left{
        flex-direction:column;
        align-items:flex-start;
    }

    .expand-grid{
        grid-template-columns:1fr;
    }

}

.order-summary{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-bottom:25px;
}

@media(max-width:768px){
    .order-summary,
    .expand-grid{
        grid-template-columns:1fr;
    }
}


.product-row{
    display:flex;
    gap:15px;
    align-items:center;
    padding:10px 0;
    border-bottom:1px solid #eee;
}

.product-row h4{
    margin:0;
    color:#4a2410;
}

.product-row p{
    margin:3px 0;
    color:#666;
}
.order-summary div{
    background: #fafafa;
   
    border:1px solid #eee;
    border-radius:15px;
    padding:15px;
}

.order-summary span{
    color:#888;
    font-size:13px;
}

.order-summary h3,
.order-summary h4{
    margin:8px 0 0;
    color:#4a2410;
}

.expand-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
    margin-bottom:25px;
}

.expand-grid div{
    background:#fff;
    border:1px solid #eee;
    padding:15px;
    border-radius:12px;
}

.expand-grid strong{
    display:block;
    color:#4a2410;
    margin-bottom:5px;
}

.expand-grid p{
    margin:0;
    color:#666;
}

.expand-grid-full{
    grid-column:1/-1;
    background:#fff;
    border:1px solid #eee;
    padding:15px;
    border-radius:12px;
}

/* ================= PREMIUM REVIEW BUTTON ================= */
.review-btn{
    background: linear-gradient(135deg,#ffb703,#fb8500);
    color:white;
    box-shadow: 0 10px 25px rgba(255,183,3,0.3);
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:8px;
}

.review-btn:hover{
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(255,183,3,0.45);
}

/* ================= PREMIUM MODAL ================= */
#reviewModal{
    backdrop-filter: blur(8px);
}

#reviewModal .modal-box{
    border-radius: 25px;
    padding: 30px;
    width: 380px;
    background: #fff;
    box-shadow: 0 25px 60px rgba(0,0,0,0.2);
}

/* Title */
#reviewModal h2{
    text-align:center;
    color:#4a2410;
    margin-bottom:10px;
}

/* Product name */
.review-product-name{
    text-align:center;
    font-size:14px;
    color:#777;
    margin-bottom:15px;
}

/* Star rating */
.rating-stars{
    display:flex;
    justify-content:center;
    gap:5px;
    font-size:25px;
    cursor:pointer;
    margin-bottom:15px;
}

.rating-stars i{
    color:#ddd;
    transition:0.2s;
}

.rating-stars i.active{
    color:#ffb703;
    transform: scale(1.2);
}

/* textarea */
#reviewModal textarea{
    height:90px;
    resize:none;
}

/* submit button */
.btn-confirm{
    background: linear-gradient(135deg,#28a745,#52d769);
    box-shadow:0 10px 25px rgba(40,167,69,0.3);
}

.btn-confirm:hover{
    transform: translateY(-3px);
}

/* ================= CUSTOM CONFIRMATION MODALS ================= */

.custom-confirm-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(35,20,12,.55);
    backdrop-filter:blur(8px);
    justify-content:center;
    align-items:center;
    z-index:9999;
    padding:20px;
}

.custom-confirm-card{
    width:100%;
    max-width:430px;
    background:#fff;
    border-radius:28px;
    padding:35px 30px;
    text-align:center;
    box-shadow:0 25px 80px rgba(0,0,0,.25);
    animation:confirmPop .35s ease;
}

@keyframes confirmPop{
    from{
        opacity:0;
        transform:scale(.8) translateY(30px);
    }

    to{
        opacity:1;
        transform:scale(1) translateY(0);
    }
}

.confirm-icon{
    width:80px;
    height:80px;
    margin:0 auto 20px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:32px;
}

.delete-icon{
    background:#fff0f0;
    color:#dc3545;
}

.cancel-icon{
    background:#fff3f3;
    color:#dc3545;
}

.custom-confirm-card h2{
    color:#4a2410;
    font-size:27px;
    margin-bottom:12px;
}

.custom-confirm-card p{
    color:#777;
    font-size:15px;
    line-height:1.6;
    margin-bottom:20px;
}

.confirm-order-box{
    background:#fff6ef;
    border:1px dashed #d9b7a1;
    padding:13px;
    border-radius:14px;
    margin-bottom:25px;
}

.confirm-order-box span{
    display:block;
    font-size:12px;
    color:#888;
    margin-bottom:4px;
}

.confirm-order-box strong{
    color:#4a2410;
    font-size:15px;
}

.custom-confirm-actions{
    display:flex;
    gap:12px;
}

.custom-btn{
    flex:1;
    border:none;
    padding:13px 10px;
    border-radius:14px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.keep-btn{
    background:#f1f1f1;
    color:#555;
}

.keep-btn:hover{
    background:#e4e4e4;
    transform:translateY(-2px);
}

.confirm-delete-btn,
.confirm-cancel-btn{
    background:linear-gradient(135deg,#dc3545,#ff6b6b);
    color:white;
    box-shadow:0 8px 20px rgba(220,53,69,.25);
}

.confirm-delete-btn:hover,
.confirm-cancel-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 28px rgba(220,53,69,.35);
}

@media(max-width:500px){

    .custom-confirm-actions{
        flex-direction:column;
    }

    .custom-confirm-card{
        padding:30px 20px;
    }
}


</style>
</head>

<body>
   

<div class="order-page-wrapper">
    <?php include("header.php") ?>
<div class="floating-coffee"></div>
<div class="floating-coffee coffee2"></div>
<div class="floating-coffee coffee3"></div>
<div class="hero">

    <h1>☕ My Orders</h1>

    <p>
        Track orders, download invoices,
        reorder your favourites
    </p>

</div>

<div class="premium-header">

    

    <div class="dashboard-stats">

    <div class="stat-box">
        <i class="fa-solid fa-cart-shopping"></i>
        <h2><?php echo $totalOrders; ?></h2>
        <span>Total Orders</span>
    </div>

    <div class="stat-box">
        <i class="fa-solid fa-box"></i>
        <h2><?php echo $active; ?></h2>
        <span>Active Orders</span>
    </div>

    <div class="stat-box">
        <i class="fa-solid fa-circle-check"></i>
        <h2><?php echo $delivered; ?></h2>
        <span>Delivered</span>
    </div>

    <div class="stat-box">
        <i class="fa-solid fa-indian-rupee-sign"></i>
        <h2>₹<?php echo number_format($totalSpent); ?></h2>
        <span>Total Spent</span>
    </div>

</div>

</div>




<?php if(mysqli_num_rows($orderGroups) > 0){ ?>

<div class="order-list">
<?php while($order = mysqli_fetch_assoc($orderGroups)){ ?>

<?php
$order_number = $order['order_number'];

$itemsQuery = mysqli_query($conn,"
SELECT * FROM userorder
WHERE order_number='$order_number'
");

$itemCount = mysqli_num_rows($itemsQuery);

$itemsArray = [];
while($row = mysqli_fetch_assoc($itemsQuery)){
    $itemsArray[] = $row;
}

$firstItem = $itemsArray[0];

$order_number = $order['order_number'];

$detailsQuery = mysqli_query($conn,"
SELECT * FROM userorder
WHERE order_number='".$order_number."'
LIMIT 1
");

$orderDetails = mysqli_fetch_assoc($detailsQuery);
?>

<div class="order-item">

    <div class="order-main">

        <div class="order-left">

            <img src="images/<?php echo $firstItem['product_image']; ?>" class="product-thumb">

            <div class="order-details">

                <div class="top-line">


                    <span class="status-pill">
                        <?php echo ($itemCount == 1) ? "Single Order" : "Order Group"; ?>
                    </span>

                     <?php if($orderDetails['order_status'] == "Cancelled"){ ?>
        <span class="status-pill" style="background:#dc3545; color:white;">
            Cancelled
        </span>
    <?php } ?>
                    <span class="date">
                        <?php echo date("d M Y",strtotime($order['order_date'])); ?>
                    </span>

                    <span class="status <?php echo strtolower(str_replace(' ','',$orderDetails['order_status'])); ?>">
                        <?php echo $orderDetails['order_status']; ?>
                    </span>

                </div>

                <h3>
                    <?php echo ($itemCount == 1) ? $firstItem['product_name'] : "Order #" . $order['order_number']; ?>
                </h3>

                <p><?php echo $itemCount; ?> item(s)</p>

                <h2>₹<?php echo number_format($order['total_amount']); ?></h2>

            </div>

        </div>

        <!-- ✅ ARROW ALWAYS (single + multiple both) -->
        <button class="toggle-btn" onclick="toggleOrder(this)">
            <i class="fa-solid fa-angle-right"></i>
        </button>

    </div>

    <!-- ================= EXPAND (NOW FOR BOTH SINGLE + MULTIPLE) ================= -->
    <div class="order-expand">

        <div class="ordered-products">

            <?php foreach($itemsArray as $item){ ?>

            <div class="product-row">

                <img src="images/<?php echo $item['product_image']; ?>"
                     style="width:80px;height:80px;object-fit:cover;border-radius:12px;">

                <div>
                    <h4><?php echo $item['product_name']; ?></h4>
                    <p>Qty: <?php echo $item['quantity']; ?></p>
                    <p>₹<?php echo number_format($item['item_price']); ?></p>
                </div>
            
            </div>

            <?php } ?>

        </div>

        <!-- ORDER SUMMARY -->
        <div class="order-summary">
            <span>Order Total</span>
            <h3>₹<?php echo number_format($order['total_amount']); ?></h3>
        </div>

        <!-- FULL DETAILS -->
        <div class="expand-grid">

            <div>
                <strong>Customer Name</strong>
                <p><?php echo $orderDetails['customer_name']; ?></p>
            </div>

            <div>
                <strong>Mobile Number</strong>
                <p><?php echo $orderDetails['customer_number']; ?></p>
            </div>

            <div>
                <strong>Payment Method</strong>
                <p><?php echo $orderDetails['payment_method']; ?></p>
            </div>

            <div>
                <strong>Payment Status</strong>
                <p><?php echo $orderDetails['payment_status']; ?></p>
            </div>

            <div>
                <strong>Order Status</strong>
                <p><?php echo $orderDetails['order_status']; ?></p>
            </div>

            <div>
                <strong>Tracking Number</strong>
                <p><?php echo $orderDetails['tracking_number'] ?: 'Not Assigned'; ?></p>
            </div>

            <div>
                <strong>Expected Delivery</strong>
                <p>
                    <?php
                    echo $orderDetails['estimated_delivery']
                    ? date("d M Y",strtotime($orderDetails['estimated_delivery']))
                    : "Pending";
                    ?>
                </p>
            </div>

            <div>
                <strong>Order Date</strong>
                <p><?php echo date("d M Y",strtotime($orderDetails['created_at'])); ?></p>
            </div>

            <div class="expand-grid-full">
                <strong>Shipping Address</strong>
                <p>
                    <?php echo $orderDetails['shipping_address']; ?>,
                    <?php echo $orderDetails['city']; ?>,
                    <?php echo $orderDetails['state']; ?> -
                    <?php echo $orderDetails['pin']; ?>
                </p>
            </div>

        </div>

        <!-- ACTION BUTTONS -->
        <div class="action-row">

<?php if(($orderDetails['order_status'] ?? '') === "Delivered"){ ?>

    <?php foreach($itemsArray as $item){ ?>

        <button
            class="action-btn review-btn"
            onclick="openReviewModal(
                '<?php echo $item['product_id']; ?>',
                '<?php echo $order_number; ?>',
                '<?php echo htmlspecialchars($item['product_name'], ENT_QUOTES); ?>'
            )">

            <i class="fa-solid fa-star"></i>
            Review <?php echo htmlspecialchars($item['product_name']); ?>

        </button>

    <?php } ?>

<?php } ?>



            <a href="track_order.php?order_id=<?php echo $orderDetails['id']; ?>"
               class="action-btn track-btn">
                Track Order
            </a>

            <a href="invoice.php?order_id=<?php echo $orderDetails['id']; ?>"
               class="action-btn invoice-btn">
                Invoice
            </a>
<?php if(
    ($order['order_status'] ?? '') != "Delivered" &&
    ($order['order_status'] ?? '') != "Cancelled"
){ ?>
            <button class="action-btn cancel-btn"
                    onclick="openCancelModal('<?php echo $order_number; ?>')">
                Cancel Order
            </button>
            <?php } ?>

         <!-- <button class="action-btn delete-btn"
            onclick="deleteOrder('<?php echo $order_number; ?>')">
            Delete Order
            </button> -->

            <button class="action-btn delete-btn"
    onclick="openDeleteModal('<?php echo $order_number; ?>')">
    <i class="fa-solid fa-trash"></i>
    Delete Order
</button>

        </div>

    </div>

</div>

<?php } ?>


<?php } else { ?>

<!-- ================= EMPTY STATE ================= -->
<div class="empty">
    <i class="fa-solid fa-mug-hot"></i>
    <h2>No Orders Yet</h2>

    <p>Your coffee adventure starts here.</p>

    <a href="catalogue.php">Start Shopping</a>
</div>

<?php } ?>   <!-- ✅ END IF ORDER LIST -->

<!-- ================= CANCEL MODAL (ALWAYS OUTSIDE IF) ================= -->
<!-- ================= CANCEL MODAL ================= -->
<div id="cancelModal" class="modal">

    <div class="modal-box">

        <h2>Cancel Order</h2>

        <p>Tell us why you're cancelling</p>

        <form id="cancelOrderForm"
              method="POST"
              action="order_action.php">

            <input type="hidden"
                   name="order_number"
                   id="order_number">

            <input type="hidden"
                   name="customer_id"
                   value="<?php echo $user_id; ?>">

            <input type="hidden"
                   name="action"
                   value="cancel">

            <select name="reason" id="cancel_reason" required>

                <option value="">Select Reason</option>

                <option>Changed my mind</option>

                <option>Too expensive</option>

                <option>Ordered by mistake</option>

                <option>Late delivery</option>

                <option>Other</option>

            </select>

            <textarea name="note"
                      placeholder="Optional note"></textarea>

            <div class="modal-actions">

                <button type="button"
                        class="btn-cancel"
                        onclick="closeModal()">

                    Close

                </button>

                <button type="button"
                        class="btn-confirm"
                        onclick="showCancelConfirmation()">

                    Continue

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ================= CANCEL CONFIRMATION MODAL ================= -->

<div id="cancelConfirmModal"
     class="custom-confirm-overlay">

    <div class="custom-confirm-card">

        <div class="confirm-icon cancel-icon">

            <i class="fa-solid fa-ban"></i>

        </div>

        <h2>Cancel This Order?</h2>

        <p>
            Are you sure you want to cancel this order?
            Once cancelled, this action cannot be undone.
        </p>

        <div class="confirm-order-box">

            <span>Order Number</span>

            <strong id="cancelOrderNumberText"></strong>

        </div>

        <div class="custom-confirm-actions">

            <button type="button"
                    class="custom-btn keep-btn"
                    onclick="backToCancelModal()">

                <i class="fa-solid fa-arrow-left"></i>
                Go Back

            </button>


            <button type="button"
                    class="custom-btn confirm-cancel-btn"
                    onclick="submitCancelOrder()">

                <i class="fa-solid fa-ban"></i>
                Yes, Cancel

            </button>

        </div>

    </div>

</div>
</div>


<div id="reviewModal" class="modal">
    <div class="modal-box">

        <h2>⭐ Write a Review</h2>
        <div class="review-product-name" id="review_product_name"></div>

        <form method="POST" action="review_action.php">

            <input type="hidden" name="product_id" id="review_product_id">
            <input type="hidden" name="order_number" id="review_order_number">
            <input type="hidden" name="rating" id="rating_input">

            <!-- STAR UI -->
            <div class="rating-stars" id="starBox">
                <i class="fa-solid fa-star" data-value="1"></i>
                <i class="fa-solid fa-star" data-value="2"></i>
                <i class="fa-solid fa-star" data-value="3"></i>
                <i class="fa-solid fa-star" data-value="4"></i>
                <i class="fa-solid fa-star" data-value="5"></i>
            </div>

            <textarea name="review" placeholder="Share your experience..." required></textarea>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeReview()">Close</button>
                <button type="submit" class="btn-confirm">Submit Review</button>
            </div>

        </form>

    </div>
</div>
   <?php include('footer.php') ?>
<!-- ================= DELETE ORDER MODAL ================= -->
<div id="deleteModal" class="custom-confirm-overlay">

    <div class="custom-confirm-card">

        <div class="confirm-icon delete-icon">
            <i class="fa-solid fa-trash-can"></i>
        </div>

        <h2>Delete Order?</h2>

        <p>
            Are you sure you want to delete this order?
            This order will be moved from your active orders.
        </p>

        <div class="confirm-order-box">
            <span>Order Number</span>
            <strong id="deleteOrderNumberText"></strong>
        </div>

        <div class="custom-confirm-actions">

            <button type="button"
                    class="custom-btn keep-btn"
                    onclick="closeDeleteModal()">
                <i class="fa-solid fa-arrow-left"></i>
                Keep Order
            </button>

            <button type="button"
                    class="custom-btn confirm-delete-btn"
                    onclick="confirmDeleteOrder()">
                <i class="fa-solid fa-trash"></i>
                Yes, Delete
            </button>

        </div>

    </div>

</div>

<!-- ================= ACTION RESULT MODAL ================= -->

<div id="actionResultModal"
     class="custom-confirm-overlay">

    <div class="custom-confirm-card result-card">

        <!-- Dynamic Icon -->

        <div id="resultIcon"
             class="confirm-icon success-result-icon">

            <i class="fa-solid fa-check"></i>

        </div>


        <!-- Dynamic Title -->

        <h2 id="resultTitle">

            Success!

        </h2>


        <!-- Dynamic Message -->

        <p id="resultMessage">

            Your action was completed successfully.

        </p>


        <div class="custom-confirm-actions">

            <button type="button"
                    class="custom-btn result-continue-btn"
                    onclick="closeActionResult()">

                <i class="fa-solid fa-arrow-left"></i>

                Back to My Orders

            </button>

        </div>

    </div>

</div>

<script src="script.js"></script>
    <script src="search.js"></script>
   
    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

<script>

/* =========================================================
   ACTION RESULT CARD
========================================================= */

function showActionResult(type, title, message){

    const modal = document.getElementById("actionResultModal");
    const icon = document.getElementById("resultIcon");
    const titleElement = document.getElementById("resultTitle");
    const messageElement = document.getElementById("resultMessage");

    titleElement.innerText = title;
    messageElement.innerText = message;

    if(type === "success"){

        icon.className = "confirm-icon success-result-icon";

        icon.innerHTML =
            '<i class="fa-solid fa-check"></i>';

    }else{

        icon.className = "confirm-icon error-result-icon";

        icon.innerHTML =
            '<i class="fa-solid fa-xmark"></i>';

    }

    modal.style.display = "flex";
}


/* =========================================================
   CLOSE RESULT CARD
========================================================= */

function closeActionResult(){

    window.location.href = "userorder.php";

}


/* =========================================================
   TOGGLE ORDER DETAILS
========================================================= */

function toggleOrder(button){

    const card = button.closest(".order-item");

    if(card){

        card.classList.toggle("active");

    }

}


/* =========================================================
   CANCEL ORDER MODAL
========================================================= */

function openCancelModal(order_number){

    document.getElementById("cancelModal").style.display = "flex";

    document.getElementById("order_number").value = order_number;

}


function closeModal(){

    document.getElementById("cancelModal").style.display = "none";

}


/* =========================================================
   CANCEL CONFIRMATION
========================================================= */

function showCancelConfirmation(){

    const orderNumber =
        document.getElementById("order_number").value;

    const reason =
        document.getElementById("cancel_reason").value;


    /* CUSTOM ERROR CARD INSTEAD OF ALERT */

    if(reason === ""){

        showActionResult(
            "error",
            "Select a Reason",
            "Please select a cancellation reason before continuing."
        );

        return;

    }


    document.getElementById("cancelOrderNumberText").innerText =
        "#" + orderNumber;


    document.getElementById("cancelModal").style.display =
        "none";


    document.getElementById("cancelConfirmModal").style.display =
        "flex";

}


function backToCancelModal(){

    document.getElementById("cancelConfirmModal").style.display =
        "none";


    document.getElementById("cancelModal").style.display =
        "flex";

}


/* =========================================================
   SUBMIT CANCEL ORDER
========================================================= */

function submitCancelOrder(){

    const form =
        document.getElementById("cancelOrderForm");


    const formData =
        new FormData(form);


    fetch("order_action.php", {

        method: "POST",

        body: formData

    })

    .then(res => res.text())

    .then(res => {

        if(res.trim() === "success"){

            document.getElementById(
                "cancelConfirmModal"
            ).style.display = "none";


            showActionResult(
                "success",
                "Order Cancelled!",
                "Your order has been cancelled successfully."
            );

        }else{

            document.getElementById(
                "cancelConfirmModal"
            ).style.display = "none";


            showActionResult(
                "error",
                "Cancellation Failed!",
                "Something went wrong. Please try again."
            );

        }

    })

    .catch(err => {

        console.error(err);


        document.getElementById(
            "cancelConfirmModal"
        ).style.display = "none";


        showActionResult(
            "error",
            "Something Went Wrong!",
            "Unable to process your request."
        );

    });

}


/* =========================================================
   DELETE ORDER
========================================================= */

let selectedDeleteOrder = null;


/* OPEN DELETE MODAL */

function openDeleteModal(order_number){

    selectedDeleteOrder = order_number;


    document.getElementById(
        "deleteOrderNumberText"
    ).innerText = "#" + order_number;


    document.getElementById(
        "deleteModal"
    ).style.display = "flex";

}


/* CLOSE DELETE MODAL */

function closeDeleteModal(){

    document.getElementById(
        "deleteModal"
    ).style.display = "none";


    selectedDeleteOrder = null;

}


/* CONFIRM DELETE */

function confirmDeleteOrder(){

    if(!selectedDeleteOrder){

        return;

    }


    fetch("order_action.php", {

        method: "POST",

        headers: {

            "Content-Type":
                "application/x-www-form-urlencoded"

        },

        body:

            "order_number=" +
            encodeURIComponent(selectedDeleteOrder) +

            "&action=delete"

    })

    .then(res => res.text())

    .then(res => {

        if(res.trim() === "success"){

            closeDeleteModal();


            showActionResult(

                "success",

                "Order Deleted!",

                "Your order has been deleted successfully."

            );

        }else{

            closeDeleteModal();


            showActionResult(

                "error",

                "Delete Failed!",

                "Something went wrong. Please try again."

            );

        }

    })

    .catch(err => {

        console.error(err);


        closeDeleteModal();


        showActionResult(

            "error",

            "Something Went Wrong!",

            "Unable to process your request."

        );

    });

}


/* =========================================================
   REVIEW MODAL
========================================================= */

let selectedRating = 0;


function openReviewModal(
    product_id,
    order_number,
    product_name
){

    document.getElementById(
        "reviewModal"
    ).style.display = "flex";


    document.getElementById(
        "review_product_id"
    ).value = product_id;


    document.getElementById(
        "review_order_number"
    ).value = order_number;


    document.getElementById(
        "review_product_name"
    ).innerText = product_name || "";

}


function closeReview(){

    document.getElementById(
        "reviewModal"
    ).style.display = "none";

}


/* =========================================================
   STAR RATING
========================================================= */

const stars =
    document.querySelectorAll("#starBox i");


const ratingInput =
    document.getElementById("rating_input");


stars.forEach(star => {

    star.addEventListener(
        "click",

        function(){

            selectedRating =
                this.getAttribute("data-value");


            ratingInput.value =
                selectedRating;


            updateStars(selectedRating);

        }

    );


    star.addEventListener(
        "mouseover",

        function(){

            updateStars(
                this.getAttribute("data-value")
            );

        }

    );


    star.addEventListener(
        "mouseout",

        function(){

            updateStars(selectedRating);

        }

    );

});


function updateStars(rating){

    stars.forEach(star => {

        if(
            star.getAttribute("data-value")
            <= rating
        ){

            star.classList.add("active");

        }else{

            star.classList.remove("active");

        }

    });

}


/* =========================================================
   CLOSE MODALS WHEN CLICKING OUTSIDE
========================================================= */

window.addEventListener(
    "click",

    function(e){


        /* NORMAL CANCEL MODAL */

        if(
            e.target ===
            document.getElementById("cancelModal")
        ){

            closeModal();

        }


        /* DELETE MODAL */

        if(
            e.target ===
            document.getElementById("deleteModal")
        ){

            closeDeleteModal();

        }


        /* CANCEL CONFIRMATION MODAL */

        if(
            e.target ===
            document.getElementById("cancelConfirmModal")
        ){

            document.getElementById(
                "cancelConfirmModal"
            ).style.display = "none";

        }


        /* REVIEW MODAL */

        if(
            e.target ===
            document.getElementById("reviewModal")
        ){

            closeReview();

        }


        /* RESULT MODAL */

        if(
            e.target ===
            document.getElementById("actionResultModal")
        ){

            document.getElementById(
                "actionResultModal"
            ).style.display = "none";

        }

    }

);

</script>

</body>
</html>