
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>My Wishlist</title>
 <link rel="stylesheet" type="text/css" href="coffee.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet"  type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<?php

session_start();
include("connect.php");
/** @var mysqli $conn */

if(!isset($_SESSION['user_id'])){

    header("location:register.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,

"SELECT * FROM wishlist

WHERE user_id='$user_id'
AND status='active'

ORDER BY wishlist_id DESC");

?>

<style>

/* =========================
   PREMIUM WISHLIST PAGE
========================= */

body{

    margin:0;
    padding:0;

    font-family:'Poppins',sans-serif;

    background:
    linear-gradient(135deg,#fff8f2,#fdf1e7);

    overflow-x:hidden;
}


/* TOP AREA */

/* =========================
   PREMIUM TOP SECTION
========================= */

.wishlist-top{
   
    width:100%;

    height:fit-content;

    position:relative;

    overflow:hidden;

    padding:95px 8%;

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    background:
    linear-gradient(135deg,
    #1a0902,
    #58260f,
    #7a1f06);

    border-radius:0 0 30px 30px;
    box-shadow:
    0 20px 50px rgba(0,0,0,0.28);
}


/* DARK OVERLAY */

.overlay{

    position:absolute;

    inset:0;

    background:
    radial-gradient(circle at top right,
    rgba(255,255,255,0.08),
    transparent 40%);

    pointer-events:none;
}


/* LEFT AREA */

.wishlist-left{

    position:relative;

    z-index:2;

    max-width:650px;
}


/* MINI TAG */

.mini-tag{

    display:inline-block;

    background:
    rgba(255,255,255,0.12);

    color:#fff;
    margin-top: 10%;
    padding:12px 22px;

    border-radius:40px;

    font-size:14px;

    font-weight:600;

    backdrop-filter:blur(10px);

    border:
    1px solid rgba(255,255,255,0.15);
}


/* TITLE */

.wishlist-left h1{

    margin-top:15px;

    font-size:48px;

    line-height:1.1;

    color:#fff;

    font-weight:900;

    letter-spacing:1px;
}


/* DESCRIPTION */

.wishlist-left p{

    margin-top:12px;

    color:#f5d9c7;

    font-size:15px;

    line-height:1.6;

    max-width:500px;
}


/* STATS */

.wishlist-stats{

    display:flex;

    gap:15px;

    flex-wrap:wrap;

    margin-top:20px;
}

.stat-box{

    min-width:140px;

    padding:22px;

    border-radius:24px;

    background:
    rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border:
    1px solid rgba(255,255,255,0.12);

    text-align:center;

    transition:0.35s ease;
}

.stat-box:hover{

    transform:translateY(-6px);

    background:
    rgba(255,255,255,0.13);
}

.stat-box h2{

    margin:0;

    color:#fff;

    font-size:24px;

    font-weight:800;
}

.stat-box span{

    color:#f1c8aa;

    font-size:12px;
}


/* RIGHT AREA */

.wishlist-right{

    position:relative;

    z-index:2;

    display:flex;

    flex-direction:column;

    align-items:center;

    gap:35px;
}


/* HEART CIRCLE */

.coffee-circle{

    width:120px;
    height:120px;

    border-radius:50%;

    background:
    linear-gradient(135deg,
    #ff2d55,
    #ff6b81);

    display:flex;

    align-items:center;

    justify-content:center;

    box-shadow:
    0 20px 40px rgba(255,45,85,0.35);

    animation:floatHeart 3s ease-in-out infinite;
}

.coffee-circle i{

    color:#fff;

    font-size:48px;
}


/* BUTTON */

.back-shop{

    text-decoration:none;

    background:#fff;

    color:#58260f;

    
    font-weight:700;

    padding:14px 24px;

    border-radius:14px;

    font-size:14px;

    transition:0.35s ease;

    box-shadow:
    0 12px 30px rgba(0,0,0,0.15);
}

.back-shop i{

    margin-right:10px;
}

.back-shop:hover{

    transform:translateY(-5px);

    background:#ffe6d2;
}


/* FLOAT ANIMATION */

@keyframes floatHeart{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-14px);
    }

    100%{
        transform:translateY(0px);
    }
}


/* MOBILE */

@media(max-width:900px){

    .wishlist-top{

        text-align:center;

        justify-content:center;

        gap:50px;
    }

    .wishlist-left h1{

        font-size:50px;
    }

    .wishlist-stats{

        justify-content:center;
    }
}
.wishlist-heading{

    color:#fff;
}

.wishlist-heading h1{

    margin:0;

    font-size:48px;
    font-weight:800;
}

.wishlist-heading p{

    margin-top:10px;

    font-size:17px;

    opacity:0.9;
}


/* GRID */

.wishlist-container{

    width:92%;
    margin:auto;

    padding:60px 0;
}

.wishlist-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;
}


/* CARD */

.wishlist-card{

    position:relative;

    background:#fff;

    border-radius:30px;

    overflow:hidden;

    transition:0.4s ease;

    box-shadow:
    0 18px 40px rgba(0,0,0,0.08);
}

.wishlist-card:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 25px 50px rgba(88,38,15,0.18);
}


/* IMAGE */

.wishlist-image{

    position:relative;

    width:100%;
     height:240px;
    overflow:hidden;
}

.wishlist-image img{

    width:100%;
    height:100%;

    object-fit:cover;

    transition:0.5s;
}

.wishlist-card:hover
.wishlist-image img{

    transform:scale(1.08);
}


/* HEART */

.wishlist-badge{

    position:absolute;

    top:18px;
    right:18px;

    width:52px;
    height:52px;

    border-radius:50%;

    background:
    linear-gradient(135deg,#ff2d55,#ff5c8a);

    display:flex;
    align-items:center;
    justify-content:center;

    color:#fff;

    font-size:20px;

    box-shadow:
    0 12px 25px rgba(255,45,85,0.35);
}


/* CONTENT */

.wishlist-content{

    padding:28px;
}

.wishlist-content h3{

    margin:0;

    color:#2a2a2a;

    font-size:22px;
    font-weight:700;
}


/* PRICE */

.price-area{

    display:flex;
    align-items:center;

    gap:14px;

    margin-top:18px;
}

.old-price{

    color:#999;

    font-size:18px;

    text-decoration:line-through;
}

.new-price{

    color:#58260f;

     font-size:28px;

    font-weight:800;
}


/* =========================
   BEST SELLER BADGE
========================= */

.best-badge{

    position:absolute;

    top:18px;
    left:18px;

    background:
    linear-gradient(135deg,#ff9800,#ff5722);

    color:#fff;

    padding:10px 18px;

    border-radius:30px;

    font-size:13px;

    font-weight:700;

    z-index:5;

    box-shadow:
    0 10px 25px rgba(255,87,34,0.35);
}


/* =========================
   RATING
========================= */

.rating-area{

    display:flex;

    align-items:center;

    gap:5px;

    margin-top:14px;

    color:#ffb400;

    font-size:15px;
}

.rating-area span{

    color:#777;

    margin-left:8px;

    font-weight:600;
}


/* =========================
   BUTTONS
========================= */

.action-buttons{

    margin-top:28px;
    display:flex;
    gap:10px;
}

.move-cart{
        flex:1;
    width:100%;

    height:58px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(135deg,#1f1f1f,#3d3d3d);

    color:#fff;

    font-size:15px;

    font-weight:700;

    letter-spacing:0.5px;

    cursor:pointer;

    transition:0.35s ease;

    box-shadow:
    0 15px 30px rgba(0,0,0,0.18);
}

@media(max-width:1200px){

    .wishlist-grid{
        grid-template-columns:repeat(3,1fr);
    }

}

@media(max-width:900px){

    .wishlist-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:600px){

    .wishlist-grid{
        grid-template-columns:1fr;
    }

}

.move-cart i{

    margin-right:10px;
}

.move-cart:hover{

    transform:translateY(-4px);

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    box-shadow:
    0 20px 40px rgba(88,38,15,0.30);
}



.order-btn{

    flex:1;

    height:58px;

    display:flex;
    align-items:center;
    justify-content:center;

    text-decoration:none;

    border-radius:18px;

    /* background:linear-gradient(135deg,#58260f,#7a1f06); */

    background:linear-gradient(135deg,#f7b733,#fc4a1a);

    color:#fff;

    font-size:17px;

    font-weight:700;

    transition:0.35s ease;

    box-shadow:0 15px 30px rgba(88,38,15,0.18);
}

.order-btn i{
    margin-right:8px;
}

.order-btn:hover{

    color:#fff;

    transform:translateY(-4px);

    box-shadow:0 20px 40px rgba(88,38,15,0.30);

    background:linear-gradient(135deg,#7a1f06,#58260f);
}

/* =========================
   HEART ICON
========================= */

.wishlist-badge{

    position:absolute;

    top:18px;
    right:18px;

    width:58px;
    height:58px;

    border-radius:50%;

    background:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;

    transition:0.35s ease;

    box-shadow:
    0 12px 28px rgba(0,0,0,0.15);

    z-index:10;
}

.wishlist-badge i{

    color:#ff2d55;

    font-size:23px;

    transition:0.3s;
}

.wishlist-badge:hover{

    transform:scale(1.12);

    background:#ff2d55;
}

.wishlist-badge:hover i{

    color:#fff;
}


/* EMPTY */

.empty-wishlist{

    width:100%;

    text-align:center;

    padding:120px 20px;
}

.empty-wishlist h2{

    color:#58260f;

    font-size:38px;
}

.empty-wishlist p{

    color:#777;

    font-size:18px;
}

.wishlist-badge{

    position:absolute;

    top:18px;
    right:18px;

    width:55px;
    height:55px;

    border-radius:50%;

    background:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;

    transition:0.35s ease;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.12);

    z-index:10;
}

.wishlist-badge i{

    color:#ff2d55;

    font-size:22px;

    transition:0.3s;
}

.wishlist-badge:hover{

    transform:scale(1.12);

    background:#ff2d55;
}

.wishlist-badge:hover i{

    color:#fff;
}

</style>

</head>
<body>

   <?php include('header.php') ?>

<div class="wishlist-top" style="margin-top:-0.1px;">

    <div class="overlay"></div>

    <div class="wishlist-left">

        <span class="mini-tag">
            ✨ Premium Collection
        </span>

        <h1>
            My Wishlist
        </h1>

        <p>
            Save your favorite handcrafted coffees,
            luxury brews & exclusive café specials.
        </p>

        <div class="wishlist-stats">

            <?php

                $totalProducts = mysqli_query($conn,
                "SELECT COUNT(*) AS total 
                FROM wishlist 
                WHERE user_id='$user_id' 
                AND status='active'");

                $productData = mysqli_fetch_assoc($totalProducts);

                ?>

        <div class="stat-box">

            <h2>
                <?php echo $productData['total']; ?>+
            </h2>

            <span>Coffee Items</span>

        </div>

            <div class="stat-box">
                <h2>4.9★</h2>
                <span>Top Rated</span>
            </div>

            <div class="stat-box">
                <h2>100%</h2>
                <span>Fresh Beans</span>
            </div>

        </div>

    </div>

    <div class="wishlist-right">

        <div class="coffee-circle">

            <i class="fa-solid fa-heart"></i>

        </div>

        <a href="catalogue.php"
        class="back-shop">

            <i class="fa-solid fa-bag-shopping"></i>

            Continue Shopping

        </a>

    </div>

</div>

<div class="wishlist-container">

<?php

if(mysqli_num_rows($query) > 0){

?>

<div class="wishlist-grid">

<?php

while($row = mysqli_fetch_assoc($query)){

?>

<div class="wishlist-card">

    <!-- IMAGE -->
    <div class="wishlist-image">

        <img src="images/<?php echo $row['product_image']; ?>">

        <!-- BEST SELLER -->
       <?php if($row['price'] >= 300){ ?>

            <div class="best-badge">
                🔥 Best Seller
            </div>

            <?php } ?>

        <!-- HEART -->
        <div class="wishlist-badge"
        onclick="removeWishlist(
        <?php echo $row['wishlist_id']; ?>
        )">

            <i class="fa-solid fa-heart"></i>

        </div>

    </div>


    <!-- CONTENT -->
    <div class="wishlist-content">

        <!-- PRODUCT NAME -->
        <h3>
            <?php echo $row['product_name']; ?>
        </h3>

        <!-- RATING -->
        <div class="rating-area">

            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star"></i>
            <i class="fa-solid fa-star-half-stroke"></i>

            <span>(4.8)</span>

        </div>

        <!-- PRICE -->
        <div class="price-area">

            <span class="old-price">
                ₹<?php echo $row['price'] + 120; ?>
            </span>

            <span class="new-price">
                ₹<?php echo $row['price']; ?>
            </span>

        </div>

        <!-- BUTTON -->
      <?php

$pid = $row['product_id'];

$cartCheck = mysqli_query($conn,

"SELECT id
FROM addtocart
WHERE user_id='$user_id'
AND product_id='$pid'
AND status='active'");

$inCart = mysqli_num_rows($cartCheck) > 0;

?>

<div class="action-buttons">

<?php if($inCart){ ?>

   <button class="move-cart"
onclick="moveToCart(<?php echo $row['wishlist_id']; ?>)">
    <i class="fa-solid fa-cart-shopping"></i>
    Add To Cart
</button>

<?php } else { ?>

    <button class="move-cart"
    onclick="moveToCart(<?php echo $row['wishlist_id']; ?>)">

        <i class="fa-solid fa-cart-shopping"></i>
        Add To Cart

    </button>

<?php } ?>

    <!-- <a href="checkout.php?product_id=<?php echo $row['product_id']; ?>"
       class="order-btn">

        <i class="fa-solid fa-bolt"></i>
        Order Now

    </a> -->
<!-- 
<a href="checkout.php?source=wishlist&id=<?php echo $row['wishlist_id']; ?>" class="order-btn">
    <i class="fa-solid fa-bolt"></i> Order Now
</a> -->


<a href="checkout.php?source=wishlist&id=<?php echo $row['wishlist_id']; ?>" class="order-btn">
    Order Now
</a>


</div>



</div>
    </div>

<?php

}

?>

</div>

<?php

}else{

?>

<div class="empty-wishlist">

<h2>❤️ Wishlist Empty</h2>

<p>
Save your favorite coffee products here
</p>

</div>

<?php } ?>

</div>

   <?php include('footer.php') ?>
  
   
</div>

 <script src="script.js"></script>
    <script src="search.js"></script>
   
    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>

function moveToCart(wishlist_id){

fetch("wishlist_action.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`wishlist_id=${wishlist_id}
&action=move_to_cart`

})

.then(res => res.json())

.then(data => {

if(data.success){

showToast("🛒 Product moved to cart");

setTimeout(() => {

location.reload();

},700);

}

});

}


function removeFromCart(product_id){

fetch("wishlist_action.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`product_id=${product_id}&action=remove_from_cart`

})

.then(res => res.json())

.then(data => {

if(data.success){

showToast("🗑️ Removed From Cart");

setTimeout(() => {

location.reload();

},700);

}

});

}


function removeWishlist(wishlist_id){

fetch("wishlist_action.php",{

method:"POST",

headers:{
"Content-Type":"application/x-www-form-urlencoded"
},

body:
`wishlist_id=${wishlist_id}
&action=remove`

})

.then(res => res.json())

.then(data => {

showToast("💔 Removed From Wishlist");

setTimeout(() => {

location.reload();

},600);

});

}



function showToast(message){

let toast = document.createElement("div");

toast.innerHTML = message;

toast.style.position = "fixed";
toast.style.bottom = "30px";
toast.style.right = "30px";
toast.style.background = "#1f1f1f";
toast.style.color = "#fff";
toast.style.padding = "14px 22px";
toast.style.borderRadius = "14px";
toast.style.fontWeight = "bold";
toast.style.zIndex = "99999";

document.body.appendChild(toast);

setTimeout(() => {

toast.remove();

},2000);

}











</script>

</body>
</html>