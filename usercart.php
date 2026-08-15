
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Shopping Cart</title>
    <link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet"

href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<?php

session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_SESSION['user_email'])){

    header("location:register.php");
    exit();

}

$email = $_SESSION['user_email'];


/* =========================
   GET USER
========================= */

$user = mysqli_query($conn,

"SELECT * FROM clients
WHERE email='$email'");

$user_row = mysqli_fetch_assoc($user);

$user_id = $user_row['id'];


/* =========================
   GET CART PRODUCTS
========================= */

$query = mysqli_query($conn,

"SELECT * FROM addtocart

WHERE user_id='$user_id'
AND status='active'

ORDER BY id DESC");

$total = 0;

?>

<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:
    linear-gradient(135deg,#f8f3ee,#fffdfb);

    font-family:'Poppins',sans-serif;

    overflow-x:hidden;
}


/* =========================
   MAIN CONTAINER
========================= */

.cart-container{

    width:94%;
    margin:45px auto;
}


/* =========================
   TOP BANNER
========================= */

.cart-top{

    position:relative;

    overflow:hidden;

    background:
    linear-gradient(135deg,#3b1803,#7a3b09,#c17530);

    padding:55px;

    border-radius:35px;
   
    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;

    margin-bottom:45px;

    box-shadow:
    0 25px 60px rgba(0,0,0,0.18);
}

.cart-top::before{

    content:"";

    position:absolute;

    width:280px;
    height:280px;

    background:rgba(255,255,255,0.08);

    border-radius:50%;

    top:-100px;
    right:-80px;
}

.cart-top::after{

    content:"";

    position:absolute;

    width:180px;
    height:180px;

    background:rgba(255,255,255,0.05);

    border-radius:50%;

    bottom:-70px;
    left:40%;
}

.cart-top h1{

    color:#fff;
 margin-top: 7%;

    font-size:52px;

    font-weight:800;

    letter-spacing:1px;

    position:relative;

    z-index:2;
}

.cart-top p{

    color:#ffe6cf;

    margin-top:12px;

    font-size:17px;

    position:relative;

    z-index:2;
}

.shop-btn{

    position:relative;
    z-index:2;

    text-decoration:none;

    background:#fff;

    color:#5b2c06;

    padding:16px 32px;

    border-radius:50px;

    font-weight:700;

    font-size:16px;

    transition:0.35s;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.15);
}

.shop-btn:hover{

    transform:
    translateY(-4px) scale(1.03);

    background:#fff2e5;
}


/* =========================
   LAYOUT
========================= */

.cart-layout{

    display:grid;

    grid-template-columns:2fr 1fr;

    gap:35px;
}

@media(max-width:950px){

.cart-layout{

    grid-template-columns:1fr;
}

}


/* =========================
   CART CARD
========================= */

.cart-card{

    position:relative;

    display:flex;

    background:
    linear-gradient(145deg,#ffffff,#fff8f2);

    border-radius:32px;

    overflow:hidden;

    margin-bottom:30px;

    box-shadow:
    0 20px 45px rgba(0,0,0,0.08);

    transition:0.4s ease;
}

.cart-card:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 30px 60px rgba(91,44,6,0.18);
}


/* IMAGE */

.cart-card img{

    width:260px;
    height:250px;

    object-fit:cover;

    transition:0.5s;
}

.cart-card:hover img{

    transform:scale(1.06);
}


/* DETAILS */

.cart-details{

    padding:30px;

    width:100%;

    position:relative;
}

.cart-details h2{

    color:#3b1803;

    font-size:31px;

    font-weight:700;
}


/* BADGE */

.product-badge{

    position:absolute;

    top:25px;
    right:25px;

    background:
    linear-gradient(135deg,#ff8a00,#ffb347);

    color:#fff;

    padding:10px 18px;

    border-radius:40px;

    font-size:13px;

    font-weight:700;

    box-shadow:
    0 10px 25px rgba(255,138,0,0.3);
}


/* PRICE */

.price{

    color:#c17530;

    font-size:32px;

    font-weight:800;

    margin-top:12px;
}


/* RATING */

.rating{

    margin-top:12px;

    color:#ffb400;

    font-size:15px;
}


/* QUANTITY */

.qty-box{

    margin-top:24px;

    display:flex;
    align-items:center;

    gap:18px;
}

.qty-btn{

    width:42px;
    height:42px;

    border:none;

    border-radius:50%;

    background:
    linear-gradient(135deg,#5b2c06,#8a4711);

    color:#fff;

    font-size:20px;

    cursor:pointer;

    transition:0.3s;

    box-shadow:
    0 8px 18px rgba(91,44,6,0.22);
}

.qty-btn:hover{

    transform:scale(1.12);
}

.qty-number{

    font-size:22px;

    font-weight:700;

    color:#3b1803;
}


/* TOTAL */

.total{

    margin-top:22px;

    font-size:22px;

    color:#222;

    font-weight:600;
}


/* REMOVE */

.remove-btn, .order-btn{

    margin-top:24px;

    border:none;
    text-decoration:none;
    background: linear-gradient(135deg,#ff355e,#ff6a88);

    color:#fff;

    padding:13px 24px;

    border-radius:50px;

    cursor:pointer;

    font-weight:700;

    transition:0.35s;

    box-shadow:
    0 10px 20px rgba(255,53,94,0.22);
}

.remove-btn:hover, .order-btn:hover{

    transform:
    translateY(-4px) scale(1.03);
}


/* =========================
   SUMMARY BOX
========================= */

.summary-box{

    background:
    linear-gradient(145deg,#ffffff,#fff8f1);

    padding:38px;

    border-radius:35px;

    height:fit-content;

    position:sticky;
    top:20px;

    box-shadow:
    0 20px 50px rgba(0,0,0,0.08);
}

.summary-box h2{

    color:#5b2c06;

    font-size:32px;

    margin-bottom:30px;
}

.summary-row{

    display:flex;
    justify-content:space-between;

    margin-bottom:22px;

    font-size:19px;

    color:#444;
}

.summary-total{

    border-top:2px dashed #ddd;

    padding-top:24px;

    font-size:28px;

    font-weight:800;

    color:#3b1803;
}


/* CHECKOUT */

.checkout-btn{

    width:100%;

    margin-top:35px;

    padding:18px;

    border:none;

    border-radius:60px;

    background:
    linear-gradient(135deg,#3b1803,#7a3b09,#c17530);

    color:#fff;

    font-size:18px;

    font-weight:700;

    cursor:pointer;

    transition:0.35s;

    box-shadow:
    0 18px 35px rgba(91,44,6,0.22);
}

.checkout-btn:hover{

    transform:
    translateY(-5px);

    letter-spacing:1px;
}


/* =========================
   EMPTY CART
========================= */

.empty-cart{

    height:75vh;

    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;

    gap:20px;
}

.empty-cart i{

    font-size:120px;

    color:#c17530;
}

.empty-cart h2{

    font-size:48px;

    color:#5b2c06;
}

.empty-cart p{

    color:#777;

    font-size:19px;
}


/* =========================
   TOAST
========================= */

.toast{

    position:fixed;

    bottom:30px;
    right:30px;

    background:
    linear-gradient(135deg,#1e1e1e,#353535);

    color:#fff;

    padding:16px 28px;

    border-radius:18px;

    z-index:9999;

    font-weight:600;

    box-shadow:
    0 15px 35px rgba(0,0,0,0.25);

    animation:toastPop 0.3s ease;
}

@keyframes toastPop{

    from{
        transform:translateY(20px);
        opacity:0;
    }

    to{
        transform:translateY(0);
        opacity:1;
    }
}


    .best-badge{
    position:absolute;
    top:15px;
    left:15px;

    background:linear-gradient(135deg,#ff9800,#ff5722);

    color:#fff;

    padding:8px 15px;

    border-radius:25px;

    font-size:12px;

    font-weight:700;

    z-index:10;

    box-shadow:0 8px 20px rgba(255,87,34,0.35);
}

.product-image-box{
    position:relative;
}


/* =========================================================
   MOBILE RESPONSIVE - 750px
   ========================================================= */

@media screen and (max-width: 750px) {

    /* ---------- PAGE ---------- */

    body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* ---------- SIDEBAR ---------- */

    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        min-height: auto;

        display: flex;
        flex-direction: column;
        align-items: center;

        padding: 20px 15px;
        margin: 0;

        overflow: visible;
    }

    .sidebar .user-box {
        width: 100%;
        text-align: center;

        display: flex;
        flex-direction: column;
        align-items: center;

        margin-bottom: 20px;
    }

    .sidebar .user-box .avatar {
        width: 85px;
        height: 85px;
        min-width: 85px;

        margin-bottom: 10px;
    }

    .sidebar .user-box h5 {
        margin: 5px 0;
        font-size: 18px;

        max-width: 100%;
        overflow-wrap: break-word;
    }

    .sidebar .user-box small {
        font-size: 13px;

        max-width: 100%;
        overflow-wrap: anywhere;
    }


    /* ---------- SIDEBAR LINKS ---------- */

    .sidebar > a {
        width: 100%;
        max-width: 500px;

        display: flex;
        align-items: center;

        padding: 13px 16px;
        margin: 4px 0;

        font-size: 15px;
        box-sizing: border-box;
    }

    .sidebar > a i {
        width: 25px;
        margin-right: 10px;
        text-align: center;
    }


    /* ---------- MAIN ---------- */

    .main {
        width: 100%;
        max-width: 100%;

        margin: 0;
        padding: 15px;

        box-sizing: border-box;
    }


    /* ---------- TOP CARD ---------- */

    .top-card {
        width: 100%;
        box-sizing: border-box;

        padding: 22px 18px;
        margin-bottom: 15px;

        text-align: center;
    }

    .top-card h2 {
        font-size: 24px;
        line-height: 1.3;

        margin-bottom: 8px;
    }

    .top-card p {
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }


    /* =====================================================
       STAT BOXES
       ===================================================== */

    .stat-box {
        width: 100%;
        min-width: 0;

        box-sizing: border-box;

        margin: 0 0 15px 0;
        padding: 20px 15px;

        text-align: center;

        overflow: hidden;
    }

    .stat-box h3 {
        font-size: 28px;
        margin-bottom: 5px;
    }

    .stat-box p {
        font-size: 14px;
    }


    /* ---------- EMPTY BOX ---------- */

    .empty-box {
        width: 100%;
        box-sizing: border-box;

        padding: 15px 8px;

        text-align: center;
    }

    .empty-box .empty-icon {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .empty-box h5 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .empty-box span {
        display: block;

        font-size: 12px;
        line-height: 1.5;

        overflow-wrap: break-word;
    }


    /* =====================================================
       PROFILE INFORMATION
       ===================================================== */

    .profile-info {
        width: 100%;

        display: grid;

        grid-template-columns: 1fr;

        gap: 12px;

        box-sizing: border-box;
    }

    .info-card {
        width: 100%;
        min-width: 0;

        box-sizing: border-box;

        padding: 17px 15px;

        overflow: hidden;
    }

    .info-card h4 {
        font-size: 15px;

        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 8px;
    }

    .info-card h4 i {
        flex-shrink: 0;
    }

    .info-card p {
        font-size: 14px;

        margin: 0;

        overflow-wrap: anywhere;
        word-break: break-word;
    }


    /* ---------- EDIT BUTTON ---------- */

    .edit-btn {
        width: 100%;

        display: flex;
        justify-content: center;

        margin-top: 18px;
    }

    .edit-btn a {
        width: 100%;
        max-width: 300px;

        box-sizing: border-box;

        text-align: center;

        padding: 12px 20px;

        font-size: 14px;
    }

}


/* =========================================================
   EXTRA SMALL DEVICES
   ========================================================= */

@media screen and (max-width: 400px) {

    .sidebar {
        padding: 15px 10px;
    }

    .sidebar .user-box .avatar {
        width: 75px;
        height: 75px;
        min-width: 75px;
    }

    .sidebar .user-box h5 {
        font-size: 16px;
    }

    .sidebar .user-box small {
        font-size: 12px;
    }

    .sidebar > a {
        padding: 12px;
        font-size: 14px;
    }

    .main {
        padding: 10px;
    }

    .top-card {
        padding: 18px 12px;
    }

    .top-card h2 {
        font-size: 21px;
    }

    .top-card p {
        font-size: 13px;
    }

    .stat-box {
        padding: 17px 10px;
    }

    .info-card {
        padding: 15px 12px;
    }

}

</style>

</head>

<body>
    <?php include("header.php")  ?>

<div class="cart-container">


<!-- TOP -->

<div class="cart-top">

<div>

<h1>Shopping Cart 🛒</h1>

<p>
Premium handcrafted coffee products
</p>

</div>

<a href="catalogue.php"
class="shop-btn">

Continue Shopping →

</a>

</div>



<?php

if(mysqli_num_rows($query) > 0){

?>

<div class="cart-layout">


<!-- LEFT -->

<div>

<?php

while($row = mysqli_fetch_assoc($query)){

$total += $row['total_price'];

?>

<div class="cart-card">

<img src="images/<?php echo $row['image']; ?>">

<div class="cart-details">

<h2>

<?php echo $row['name']; ?>

</h2>

<?php if($row['price'] >= 300){ ?>
<div class="product-badge">
    🔥 Best Seller
</div>
<?php } ?>

<div class="price">

₹ <?php echo $row['price']; ?>

</div>


<!-- QUANTITY -->

<div class="qty-box">

<button class="qty-btn"

onclick="updateQty(
<?php echo $row['id']; ?>,
'minus'
)">

-

</button>

<div class="qty-number">

<?php echo $row['quantity']; ?>

</div>

<button class="qty-btn"

onclick="updateQty(
<?php echo $row['id']; ?>,
'plus'
)">

+

</button>

</div>


<!-- TOTAL -->

<div class="total">

Total :
₹ <?php echo $row['total_price']; ?>

</div>


<!-- REMOVE -->

<button class="remove-btn"

onclick="removeCart(
<?php echo $row['product_id']; ?>
)">

<i class="fa-solid fa-trash"></i>

Remove

</button>


<!-- <a class="order-btn"
   href="place_order.php?cart_id=<?php echo $row['id']; ?>">
   Order
</a> -->

<a href="checkout.php?source=cart&id=<?php echo $row['id']; ?>" class="order-btn">
    Order Now
</a>


</div>

</div>

<?php } ?>

</div>



<!-- RIGHT -->

<div class="summary-box">

<h2>Order Summary</h2>

<div class="summary-row">

<span>Subtotal</span>

<span>
₹ <?php echo $total; ?>
</span>

</div>

<div class="summary-row">

<span>Delivery</span>

<span>
₹ 50
</span>

</div>

<div class="summary-row summary-total">

<span>Total</span>

<span>
₹ <?php echo $total + 50; ?>
</span>

</div>

<button class="checkout-btn">

Proceed To Checkout

</button>

</div>

</div>

<?php } else { ?>


<!-- EMPTY -->

<div class="empty-cart">

<i class="fa-solid fa-cart-shopping"></i>

<h2>Your Cart Is Empty</h2>

<p>
Add premium coffee products now ☕
</p>

</div>

<?php } ?>

</div>

<?php include("footer.php") ?>

<script>


/* =========================
   REMOVE CART
========================= */

function removeCart(product_id){

fetch("cart_action.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`product_id=${product_id}
&action=remove`

})

.then(res => res.json())

.then(data => {

showToast("🗑 Product Removed");

setTimeout(() => {

location.reload();

},700);

});

}




/* =========================
   UPDATE QUANTITY
========================= */

function updateQty(id,action){

fetch("cart_action.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`id=${id}
&action=${action}`

})

.then(res => res.json())

.then(data => {

location.reload();

});

}




/* =========================
   TOAST
========================= */

function showToast(message){

let toast = document.createElement("div");

toast.classList.add("toast");

toast.innerHTML = message;

document.body.appendChild(toast);

setTimeout(() => {

toast.remove();

},2000);

}

</script>

</body>
</html>