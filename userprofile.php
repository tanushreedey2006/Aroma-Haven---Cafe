

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
    <link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet" href="coffee.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<link rel="stylesheet" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"/>



<?php
session_start();
include("connect.php");
global $conn;

if(!isset($_SESSION['user_email'])){
    header("Location: register.php");
    exit();
}

$email = $_SESSION['user_email'];

$query = "SELECT * FROM clients WHERE email='$email'";
$run = mysqli_query($conn,$query);
$row = mysqli_fetch_array($run);

$initial = strtoupper(substr($row['name'],0,1));
?>
<style>

body{
    background:#f3f4f6;
    font-family:Arial;
}

.nav{
    z-index:1000;
}

.dashboard{
    display:flex;
    max-width:1200px;
    margin:120px auto 40px auto;
    gap:20px;
}

.sidebar{
    width:250px;
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 0 15px rgba(0,0,0,0.05);
    height:fit-content;
    position:sticky;
    top:120px;
}

.user-box{
    text-align:center;
    padding-bottom:20px;
    border-bottom:1px solid #eee;
}

.avatar{
    width:70px;
    height:70px;
    border-radius:50%;
    background:#5b2c06;
    color:#fff;
    font-size:28px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 10px;
}

.sidebar a{
    display:block;
    padding:12px;
    margin-top:10px;
    text-decoration:none;
    color:#333;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#5b2c06;
    color:#fff;
}

.main{
    flex:1;
}

.top-card{
    background:linear-gradient(135deg,#5b2c06,#8a4b1a);
    color:white;
    padding:30px;
    border-radius:15px;
}

.stats{
    display:flex;
    gap:15px;
    margin-top:20px;
}

.stat-box{
    flex:1;
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
    text-align:center;
}

.profile-info{
    margin-top:20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:15px;
}

.info-card{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
}

.info-card h4{
    color:#5b2c06;
    margin-bottom:10px;
}

.edit-btn{
    margin:7% 20em;
}

.edit-btn a{
    padding:10px 25px;
    background:#5b2c06;
    color:white;
    border-radius:25px;
    text-decoration:none;
    transition:0.3s;
}

.edit-btn a:hover{
    background:#3e1f04;
}

.nav-user{
    color:white;
    display:flex;
    align-items:center;
    gap:10px;
}
/* BODY */

body{
    background:linear-gradient(to right,#f7f2ed,#fffaf6);
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

/* DASHBOARD ANIMATION */

.dashboard{
    display:flex;
    max-width:1200px;
    margin:120px auto 40px auto;
    gap:25px;
    animation:fadeUp 1s ease;
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

/* SIDEBAR */

.sidebar{
    width:260px;
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(15px);
    border-radius:25px;
    padding:25px;
    box-shadow:0 8px 30px rgba(0,0,0,0.08);
    height:fit-content;
    position:sticky;
    top:120px;
    transition:0.4s;
}

.sidebar:hover{
    transform:translateY(-5px);
}

/* USER BOX */

.user-box{
    text-align:center;
    padding-bottom:25px;
    border-bottom:1px solid #eee;
}

/* AVATAR */

.avatar{
    width:85px;
    height:85px;
    border-radius:50%;
    background:linear-gradient(135deg,#5b2c06,#c17530);
    color:#fff;
    font-size:34px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 15px;
    box-shadow:0 10px 25px rgba(193,117,48,0.4);
    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%{
        transform:scale(1);
    }
    50%{
        transform:scale(1.08);
    }
    100%{
        transform:scale(1);
    }
}

/* SIDEBAR LINKS */

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    margin-top:12px;
    text-decoration:none;
    color:#333;
    border-radius:15px;
    transition:0.4s;
    font-weight:600;
}

.sidebar a:hover{
    background:linear-gradient(135deg,#5b2c06,#c17530);
    color:#fff;
    transform:translateX(8px);
    box-shadow:0 10px 20px rgba(91,44,6,0.25);
}

/* MAIN */

.main{
    flex:1;
}

/* TOP CARD */

.top-card{
    background:linear-gradient(135deg,#5b2c06,#c17530);
    color:white;
    padding:35px;
    border-radius:25px;
    position:relative;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(91,44,6,0.3);
}

.top-card::before{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    background:rgba(255,255,255,0.1);
    border-radius:50%;
    top:-80px;
    right:-60px;
}

/* STATS */

.stats{
    display:flex;
    gap:20px;
    margin-top:25px;
}

/* STAT BOX */

.stat-box{
    flex:1;
    background:rgba(255,255,255,0.8);
    backdrop-filter:blur(12px);
    padding:30px;
    border-radius:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
    text-align:center;
    transition:0.4s;
    position:relative;
    overflow:hidden;
}

.stat-box:hover{
    transform:translateY(-10px) scale(1.03);
}

.stat-box::after{
    content:'';
    position:absolute;
    width:100px;
    height:100px;
    background:rgba(193,117,48,0.08);
    border-radius:50%;
    top:-30px;
    right:-20px;
}

.stat-box h3{
    font-size:40px;
    color:#5b2c06;
    font-weight:bold;
}

/* PROFILE INFO */

.profile-info{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

/* INFO CARD */

.info-card{
    background:rgba(255,255,255,0.8);
    backdrop-filter:blur(12px);
    padding:25px;
    border-radius:22px;
    box-shadow:0 10px 20px rgba(0,0,0,0.05);
    transition:0.4s;
    border:1px solid rgba(255,255,255,0.3);
}

.info-card:hover{
    transform:translateY(-8px);
    box-shadow:0 18px 35px rgba(0,0,0,0.1);
}

.info-card h4{
    color:#5b2c06;
    margin-bottom:12px;
    font-weight:700;
}

/* EDIT BUTTON */

.edit-btn{
    margin-top:40px;
    text-align:center;
}

.edit-btn a{
    padding:14px 40px;
    background:linear-gradient(135deg,#5b2c06,#c17530);
    color:white;
    border-radius:40px;
    text-decoration:none;
    font-weight:600;
    transition:0.4s;
    box-shadow:0 10px 25px rgba(91,44,6,0.25);
}

.edit-btn a:hover{
    transform:translateY(-4px);
    background:linear-gradient(135deg,#3e1f04,#d48b42);
    box-shadow:0 15px 35px rgba(91,44,6,0.35);
}

/* NAV USER */

.user-select{
    cursor:pointer;
    font-weight:bold;
    transition:0.3s;
}

.user-select:hover{
    transform:scale(1.08);
}

/* ICONS */

.cart,
.logicon{
    transition:0.3s;
}

.cart:hover{
    transform:scale(1.2);
    color:#ffc107 !important;
}

.logicon:hover{
    transform:scale(1.2);
}

/* RESPONSIVE */

@media(max-width:992px){

    .dashboard{
        flex-direction:column;
        padding:0 15px;
    }

    .sidebar{
        width:100%;
        position:relative;
        top:0;
    }

    .stats{
        flex-direction:column;
    }

}


.avatar{
    width:85px;
    height:85px;
    border-radius:50%;
    background:linear-gradient(135deg,#5b2c06,#c17530);
    color:#fff;
    font-size:34px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(193,117,48,0.4);
    animation:pulse 2s infinite;
}

.avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:50%;
}

@media(max-width:768px){

    .top-card h2{
        font-size:24px;
    }

    .profile-info{
        grid-template-columns:1fr;
    }

}


/* =========================================================
   MOBILE RESPONSIVE - 750px
========================================================= */

@media screen and (max-width: 750px) {

    /* BODY */
    body {
        width: 100%;
        overflow-x: hidden;
    }

    /* DASHBOARD */
    .dashboard {
        width: 100%;
        max-width: 100%;
        margin: 90px 0 30px 0;
        padding: 0 12px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        box-sizing: border-box;
    }

    /* SIDEBAR */
    .sidebar {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        position: relative;
        top: auto;
        padding: 20px 15px;
        border-radius: 20px;
        transform: none;
    }

    .sidebar:hover {
        transform: none;
    }

    /* USER BOX */
    .user-box {
        padding-bottom: 18px;
    }

    .user-box h5 {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .user-box small {
        font-size: 12px;
        word-break: break-word;
    }

    /* AVATAR */
    .avatar {
        width: 75px;
        height: 75px;
        font-size: 30px;
        margin-bottom: 12px;
    }

    /* SIDEBAR LINKS */
    .sidebar a {
        width: 100%;
        box-sizing: border-box;
        padding: 12px;
        margin-top: 8px;
        font-size: 14px;
        gap: 10px;
    }

    .sidebar a:hover {
        transform: none;
    }

    /* MAIN */
    .main {
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    /* TOP CARD */
    .top-card {
        width: 100%;
        box-sizing: border-box;
        padding: 24px 18px;
        border-radius: 20px;
    }

    .top-card h2 {
        font-size: 22px;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .top-card p {
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* STATS */
    .stats {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 18px;
    }

    /* STAT BOX */
    .stat-box {
        width: 100%;
        box-sizing: border-box;
        padding: 22px 15px;
        border-radius: 18px;
        min-height: 120px;
    }

    .stat-box:hover {
        transform: none;
    }

    .stat-box h3 {
        font-size: 32px;
        margin-bottom: 5px;
    }

    .stat-box p {
        font-size: 14px;
        margin-bottom: 0;
    }

    /* EMPTY BOX */
    .empty-box {
        width: 100%;
        box-sizing: border-box;
    }

    .empty-box h5 {
        font-size: 16px;
        margin: 8px 0 4px;
    }

    .empty-box span {
        font-size: 12px;
        display: block;
        line-height: 1.4;
    }

    .empty-icon {
        font-size: 25px;
    }

    /* PROFILE INFORMATION */
    .profile-info {
        width: 100%;
        box-sizing: border-box;
        margin-top: 18px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    /* INFO CARD */
    .info-card {
        width: 100%;
        box-sizing: border-box;
        padding: 20px 17px;
        border-radius: 18px;
    }

    .info-card:hover {
        transform: none;
    }

    .info-card h4 {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .info-card p {
        font-size: 14px;
        margin-bottom: 0;
        word-break: break-word;
        overflow-wrap: anywhere;
    }

    /* EDIT BUTTON */
    .edit-btn {
        width: 100%;
        margin-top: 25px;
        text-align: center;
    }

    .edit-btn a {
        display: inline-block;
        padding: 12px 30px;
        font-size: 14px;
    }

}


/* =========================================================
   VERY SMALL PHONES
========================================================= */

@media screen and (max-width: 400px) {

    .dashboard {
        padding: 0 8px;
        margin-top: 85px;
    }

    .sidebar {
        padding: 17px 12px;
    }

    .avatar {
        width: 68px;
        height: 68px;
        font-size: 27px;
    }

    .top-card {
        padding: 20px 15px;
    }

    .top-card h2 {
        font-size: 19px;
    }

    .top-card p {
        font-size: 12px;
    }

    .stat-box {
        padding: 20px 12px;
    }

    .info-card {
        padding: 18px 14px;
    }

    .sidebar a {
        font-size: 13px;
        padding: 11px;
    }

}



</style>
</head>

<body>

<?php include('header.php') ?>

<div class="dashboard">

    <div class="sidebar">

        <div class="user-box">
            
        <div class="avatar">

    <?php
    // Get user's name safely
    $userName = trim($row['name'] ?? '');

    // Get first letter
    $initial = $userName !== ''
        ? strtoupper(substr($userName, 0, 1))
        : 'U';

    // Get image safely
    $userImage = trim($row['image'] ?? '');
    ?>

    <?php if ($userImage !== '') { ?>

        <img
            src="images/<?php echo htmlspecialchars($userImage); ?>"
            alt="<?php echo htmlspecialchars($userName); ?>"
            style="
                width:100%;
                height:100%;
                border-radius:50%;
                object-fit:cover;
            "
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
        >

        <!-- Fallback if image cannot be loaded -->
        <span
            class="avatar-fallback"
            style="
                display:none;
                width:100%;
                height:100%;
                border-radius:50%;
                align-items:center;
                justify-content:center;
            "
        >
            <?php echo htmlspecialchars($initial); ?>
        </span>

    <?php } else { ?>

        <!-- No image in database -->
        <span
            class="avatar-fallback"
            style="
                display:flex;
                width:100%;
                height:100%;
                border-radius:50%;
                align-items:center;
                justify-content:center;
            "
        >
            <?php echo htmlspecialchars($initial); ?>
        </span>

    <?php } ?>

</div>
            <h5><?php echo $row['name']; ?></h5>
            <small><?php echo $row['email']; ?></small>
        </div>

        
        <a href="userorder.php"><i class="fa fa-box"></i> My Orders</a>
        <a href="userwishlist.php"><i class="fa fa-heart"></i> Wishlist</a>
        <a href="usercart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
        <a href="my_bookings.php"><i class="fa fa-calendar"></i> My Bookings</a>
        <a href="editprofile.php"><i class="fa fa-gear"></i> Settings</a>

    </div>

    <div class="main">

        <div class="top-card">
            <h2>Welcome, <?php echo $row['name']; ?> 👋</h2>
            <p>Manage your orders, wishlist and profile</p>
        </div>

<?php

$user_id = $row['id'];


$order_query = mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM userorder 
WHERE customer_id='$user_id'
");
$order_data = mysqli_fetch_assoc($order_query);
$total_orders = $order_data['total'];

$wish_query = mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM wishlist 
WHERE user_id='$user_id' 
AND status='active'
");
$wish_data = mysqli_fetch_assoc($wish_query);
$total_wishlist = $wish_data['total'];

$cart_query = mysqli_query($conn,"
    SELECT SUM(quantity) AS total
    FROM addtocart
    WHERE user_id='$user_id'
    AND status='active'
");
$cart_data = mysqli_fetch_assoc($cart_query);
$total_cart = $cart_data['total'] ?? 0;
?>
<div class="stats">

    <div class="stat-box">

        <?php if($total_orders > 0){ ?>

            <h3><?php echo $total_orders; ?></h3>
            <p>Total Orders</p>

        <?php } else { ?>

            <div class="empty-box">
                <i class="fa fa-box-open empty-icon"></i>
                <h5>No Orders Yet</h5>
                <span>Start ordering your favorite coffee ☕</span>
            </div>

        <?php } ?>

    </div>

    <!-- WISHLIST -->
    <div class="stat-box">

        <?php if($total_wishlist > 0){ ?>

            <h3><?php echo $total_wishlist; ?></h3>
            <p>Wishlist Items</p>

        <?php } else { ?>

            <div class="empty-box">
                <i class="fa fa-heart empty-icon"></i>
                <h5>Wishlist Empty</h5>
                <span>Save products you love ❤️</span>
            </div>

        <?php } ?>

    </div>

    <!-- CART -->
    <div class="stat-box">

        <?php if($total_cart > 0){ ?>

            <h3><?php echo $total_cart; ?></h3>
            <p>Cart Items</p>

        <?php } else { ?>

            <div class="empty-box">
                <i class="fa fa-cart-shopping empty-icon"></i>
                <h5>Your Cart is Empty</h5>
                <span>Add delicious coffees to cart 🛒</span>
            </div>

        <?php } ?>

    </div>

</div>

        <div class="profile-info">

            <div class="info-card">
                <h4><i class="fa fa-user"></i> Name</h4>
                <p><?php echo $row['name']; ?></p>
            </div>

            <div class="info-card">
                <h4><i class="fa fa-envelope"></i> Email</h4>
                <p><?php echo $row['email']; ?></p>
            </div>

            <div class="info-card">
                <h4><i class="fa fa-phone"></i> Phone</h4>
                <p><?php echo $row['mobile']; ?></p>
            </div>

            <div class="info-card">
                <h4><i class="fa fa-location-dot"></i> Address</h4>
                <p><?php echo $row['address']; ?></p>
            </div>
            

        </div>

        <div class="edit-btn">
            <a href="editprofile.php">Edit Profile</a>
            </div>

    </div>

</div>




<?php include('footer.php') ?>

</div>
<script src="script.js"></script>
<script src="search.js"></script>
   
    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
 <script>
      function redirectPage(select){

    let page = select.value;

    if(page != ""){

        window.location.href = page;
    }

    select.selectedIndex = 0;
}
</script>
</body>
</html>













