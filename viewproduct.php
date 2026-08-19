
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="coffee.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet"  type="text/css" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />
    <link rel="stylesheet" href="coffee.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<title>
viewproduct
</title>

<link rel="stylesheet"
href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

/* =========================
   PRODUCT FETCH
========================= */
if(!isset($_GET['id'])){
    header("location:catalogue.php");
    exit();
}

$product_id = intval($_GET['id']);

$query = "SELECT * FROM products WHERE id='$product_id'";
$run = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($run);

if(!$row){
    header("location:catalogue.php");
    exit();
}

/* =========================
   USER ID FIX (IMPORTANT)
========================= */
$user_id = null;

if(isset($_SESSION['user_email'])){
    $email = $_SESSION['user_email'];

    $u = mysqli_query($conn,
    "SELECT id FROM clients WHERE email='$email'");

    if($u && $ur = mysqli_fetch_assoc($u)){
        $user_id = $ur['id'];
    }
}

/* =========================
   WISHLIST + CART STATE
========================= */
$userWishlist = [];
$userCart = [];

if($user_id){

    $w = mysqli_query($conn,
    "SELECT product_id FROM wishlist WHERE user_id='$user_id'");

    while($r = mysqli_fetch_assoc($w)){
        $userWishlist[] = (int)$r['product_id'];
    }

    $c = mysqli_query($conn,
    "SELECT product_id FROM addtocart WHERE user_id='$user_id'");

    while($r = mysqli_fetch_assoc($c)){
        $userCart[] = (int)$r['product_id'];
    }
}

/* normalize */
$userWishlist = array_map('intval', $userWishlist);
$userCart = array_map('intval', $userCart);

/* =========================
   CURRENT PRODUCT STATE
========================= */
$id = $row['id'];

$inWishlist = in_array($id, $userWishlist);
$inCart     = in_array($id, $userCart);
?>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f8f4ef;
    font-family:Poppins,sans-serif;
 
    overflow-x:hidden;
    
}

/* =========================
   HERO
========================= */

.product-wrapper{
    width:95%;
    margin:120px auto 50px;
}

/* =========================
   MAIN BOX
========================= */

.product-main{

    background:#fff;

    border-radius:35px;

    padding:40px;

    box-shadow:
    0 20px 50px rgba(0,0,0,0.08);

    overflow:hidden;

    position:relative;
}

.product-main::before{

    content:"";

    position:absolute;

    top:-120px;
    right:-120px;

    width:300px;
    height:300px;

    border-radius:50%;

    background:
    rgba(193,117,48,0.12);

}

/* =========================
   IMAGE SECTION
========================= */

.image-box{
    position:sticky;
    top:120px;
}

.big-image{

    width:100%;
    height:620px;
    background-size:100% 100%;
    object-fit:cover;

    border-radius:28px;
    transition:0.4s;
}

.thumb-flex{

    display:flex;
    gap:14px;

    margin-top:18px;
}

.small-img{

    width:95px;
    height:95px;

    border-radius:18px;

    object-fit:cover;

    cursor:pointer;

    border:3px solid transparent;

    transition:0.3s;
}

.small-img:hover{

    border-color:#7a3b09;

    transform:scale(1.05);
}

/* =========================
   RIGHT SIDE
========================= */

.product-tag{

    display:inline-block;

    padding:8px 18px;

    background:#f5e2d1;

    color:#7a3b09;

    border-radius:40px;

    font-size:14px;

    font-weight:700;

    margin-bottom:18px;
}

.product-title{

    font-size:55px;

    font-weight:900;

    color:#3a1b05;

    line-height:1.1;
}

.rating-flex{

    display:flex;
    align-items:center;

    gap:15px;

    margin-top:25px;
}

.star{

    color:#ffb400;
    font-size:20px;
}

.review-count{

    color:#777;
    font-size:15px;
}

.price-flex{

    display:flex;
    align-items:center;

    gap:18px;

    margin-top:28px;
}

.old-price{
    color:#999;
    text-decoration:line-through;
    font-size:28px;
}

.new-price{
    color:#7a1f06;
    font-size:48px;
    font-weight:900;
}

.save-box{
    background:#ffe9e9;
    color:#d60000;

    padding:8px 16px;

    border-radius:40px;

    font-weight:bold;
}

.desc{

    margin-top:30px;

    color:#666;

    line-height:34px;

    font-size:17px;
}

/* =========================
   FEATURE
========================= */

.feature-grid{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:18px;

    margin-top:35px;
}

.feature-card{

    background:#fff7f0;

    border-radius:22px;

    padding:20px;

    text-align:center;
}

.feature-card i{

    font-size:28px;

    color:#7a3b09;

    margin-bottom:10px;
}

.feature-card h5{

    margin:0;

    color:#3a1b05;

    font-size:16px;
}

.feature-card p{

    margin-top:6px;

    color:#777;

    font-size:13px;
}

/* =========================
   QUANTITY
========================= */

.action-area{

    margin-top:40px;
}

.qty-flex{

    display:flex;
    align-items:center;

    gap:15px;
}

.qty-btn{

    width:50px;
    height:50px;

    border:none;

    border-radius:50%;

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    color:#fff;

    font-size:20px;

    cursor:pointer;
}

.qty-input{

    width:90px;
    height:50px;

    border:none;

    background:#f3f3f3;

    border-radius:14px;

    text-align:center;

    font-size:20px;

    font-weight:bold;
}

/* =========================
   BUTTONS
========================= */

.btn-flex{

    display:flex;
    gap:18px;

    margin-top:30px;

    flex-wrap:wrap;
}

.cart-btn{

    flex:1;

    height:60px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    color:#fff;

    font-size:18px;

    font-weight:800;

    cursor:pointer;

    transition:0.3s;
}

.cart-btn:hover{

    transform:translateY(-4px);

    box-shadow:
    0 14px 30px rgba(88,38,15,0.25);
}

.buy-btn{

    flex:1;

    height:60px;

    border:none;

    border-radius:18px;

    background:#111;

    color:#fff;

    font-size:18px;

    font-weight:800;

    cursor:pointer;
}

.wish-btn{

    width:60px;
    height:60px;

    border:none;

    border-radius:18px;

    background:#fff0f4;

    color:#ff2d55;

    font-size:24px;
}

/* =========================
   OFFER
========================= */

.offer-box{

    margin-top:40px;

    background:
    linear-gradient(135deg,#58260f,#7a3b09);

    padding:25px;

    border-radius:24px;

    color:#fff;
}

.offer-box h4{
    font-weight:800;
}

.offer-box p{
    margin-top:8px;
    color:#f3d9c1;
}

/* =========================
   TABS
========================= */

.info-section{

    margin-top:60px;
}

.custom-box{

    background:#fff;

    border-radius:28px;

    padding:35px;

    box-shadow:
    0 15px 35px rgba(0,0,0,0.06);
}

.custom-box h2{

    color:#3a1b05;

    font-weight:800;

    margin-bottom:25px;
}

.info-text{

    color:#666;

    line-height:32px;
}

/* =========================
   REVIEW
========================= */

.review-grid{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));

    gap:25px;
}

.review-card{

    background:#fff;

    border-radius:24px;

    padding:25px;

    box-shadow:
    0 10px 25px rgba(0,0,0,0.06);
}

.review-top{

    display:flex;
    align-items:center;

    justify-content:space-between;
}

.review-user{

    display:flex;
    align-items:center;

    gap:15px;
}

.user-circle{

    width:55px;
    height:55px;

    border-radius:50%;

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:22px;
    font-weight:bold;
}

.review-card p{

    margin-top:18px;

    color:#666;

    line-height:28px;
}

/* =========================
   ADD REVIEW
========================= */

.review-form{

    margin-top:35px;

    background:#fff;

    border-radius:28px;

    padding:35px;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.06);
}

.review-form input,
.review-form textarea{

    width:100%;

    border:none;

    background:#f5f5f5;

    padding:16px;

    border-radius:14px;

    margin-bottom:20px;
}

.review-form textarea{
    height:160px;
    resize:none;
}

.product-video-box{
margin-top:25px;
background:#fff;
padding:15px;
border-radius:25px;
box-shadow:0 15px 35px rgba(0,0,0,.08);
}

.product-video-box h4{
font-size:18px;
font-weight:800;
margin-bottom:15px;
}

.review-btn{

    border:none;

    padding:15px 35px;

    border-radius:40px;

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    color:#fff;

    font-weight:800;
}

/* =========================
   RELATED
========================= */

.related-grid{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));

    gap:28px;
}

.related-card{

    background:#fff;

    border-radius:28px;

    overflow:hidden;

    transition:0.4s;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.06);
}

.related-card:hover{

    transform:translateY(-8px);
}

.related-img{

    width:100%;
    height:280px;

    object-fit:cover;
}

.related-content{
    padding:22px;
}

.related-title{

    color:#3a1b05;

    font-weight:800;
}

.related-price{

    color:#7a1f06;

    font-size:24px;

    font-weight:bold;

    margin-top:10px;
}

.view-btn{

    border:none;

    border-radius:14px;

    background:
    linear-gradient(135deg, #58260f, #7a1f06);

    color:#fff;

    font-weight:bold;

    margin-top:18px;
}

/* =========================
   MOBILE
========================= */

@media(max-width:900px){

.product-title{
    font-size:40px;
}

.big-image{
    height:420px;
}

.feature-grid{
    grid-template-columns:1fr;
}

}

.rating-summary{
padding:30px;
background:#fff;
border-radius:25px;
text-align:center;
margin-bottom:35px;
box-shadow:0 15px 35px rgba(0,0,0,.06);
}

/* ================= PREMIUM REVIEW SECTION ================= */

.premium-review-section{
    margin-top:50px;
    padding:40px;
    background:linear-gradient(135deg,#fff8f2,#ffffff);
    border-radius:30px;
    box-shadow:0 20px 60px rgba(0,0,0,0.08);
}

.review-header h2{
    color:#3a1b05;
    font-weight:900;
    margin-bottom:5px;
}

.review-header p{
    color:#777;
    margin-bottom:25px;
}

/* CARD */
.premium-review-card{
    display:flex;
    flex-direction:column;
    gap:18px;
}

/* INPUT BOX */
.input-box{
    display:flex;
    align-items:center;
    gap:12px;
    background:#fff;
    padding:14px 18px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
    transition:0.3s;
}

.input-box i{
    color:#7a3b09;
    font-size:18px;
}

.input-box input,
.input-box textarea{
    width:100%;
    border:none;
    outline:none;
    font-size:15px;
    background:transparent;
}

.input-box textarea{
    height:120px;
    resize:none;
}

.input-box:focus-within{
    transform:translateY(-3px);
    box-shadow:0 18px 40px rgba(122,59,9,0.15);
}


/* STICKY BUY BAR */

/* RATING */
.rating-box{
    background:#fff;
    padding:18px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}
/* FLOATING BUY NOW */

.sticky-buy-btn{

    position:fixed;

    bottom:25px;
    right:25px;

    z-index:9999;

    background:
    linear-gradient(135deg,#58260f,#7a1f06);

    color:#fff;

    text-decoration:none;

    padding:18px 32px;

    border-radius:60px;

    font-size:18px;

    font-weight:800;

    display:flex;
    align-items:center;
    gap:10px;

    box-shadow:
    0 15px 40px rgba(122,31,6,.35);

    transition:.35s;
}

.sticky-buy-btn:hover{

    color:#fff;

    transform:
    translateY(-5px)
    scale(1.05);

    box-shadow:
    0 20px 50px rgba(122,31,6,.45);
}

@keyframes pulseBuy{

    0%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.06);
    }

    100%{
        transform:scale(1);
    }
}

.sticky-buy-btn{

    animation:
    pulseBuy 2s infinite;
}

@media(max-width:768px){

    .sticky-buy-btn{

        bottom:15px;
        right:15px;

        padding:15px 24px;

        font-size:15px;
    }
}


.rating-box label{
    font-weight:700;
    color:#3a1b05;
}

.stars{
    display:flex;
    flex-direction:row-reverse;
    justify-content:flex-end;
    gap:6px;
    margin-top:10px;
}

.stars input{
    display:none;
}

.stars label{
    font-size:32px;
    color:#ddd;
    cursor:pointer;
    transition:0.3s;
}

/* hover effect */
.stars label:hover,
.stars label:hover ~ label{
    color:#ffb400;
    transform:scale(1.2);
}

/* selected */
.stars input:checked ~ label{
    color:#ffb400;
    animation:starPop 0.3s ease;
}

@keyframes starPop{
    0%{transform:scale(1);}
    50%{transform:scale(1.4);}
    100%{transform:scale(1);}
}

/* rating text */
.rating-text{
    margin-top:10px;
    font-weight:600;
    color:#7a3b09;
}

/* SUBMIT BUTTON */
.premium-submit{
    background:linear-gradient(135deg,#58260f,#7a1f06);
    color:white;
    border:none;
    padding:16px;
    border-radius:18px;
    font-size:16px;
    font-weight:800;
    cursor:pointer;
    transition:0.3s;
}

.premium-submit:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(122,31,6,0.25);
}
/* =========================
   PREMIUM PRODUCT PAGE
========================= */

.product-main{
    background:linear-gradient(
    145deg,
    #ffffff,
    #fff9f4
    );

    box-shadow:
    0 30px 80px rgba(0,0,0,.10);
}

/* IMAGE HOVER */

.big-image{
    cursor:zoom-in;
}

.big-image:hover{
    transform:scale(1.03);
}

/* PRODUCT TITLE */

.product-title{
    background:linear-gradient(
    135deg,
    #3a1b05,
    #7a3b09
    );

    -webkit-background-clip:text;
    background-clip: text;
    -webkit-text-fill-color:transparent;
}
/* =========================
   COFFEE FACTS
========================= */

.coffee-facts{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
    margin:50px 0;
}

.fact-card{
    background:linear-gradient(
    135deg,
    #ffffff,
    #fff6ef);

    border-radius:25px;

    padding:35px 20px;

    text-align:center;

    box-shadow:
    0 15px 35px rgba(0,0,0,0.08);

    transition:.4s;

    position:relative;

    overflow:hidden;
}
.fact-card i{
    font-size:32px;
    color:#c17530;
    margin-bottom:15px;
}

.fact-card::before{

    content:"";

    position:absolute;

    top:-60px;
    right:-60px;

    width:140px;
    height:140px;

    border-radius:50%;

    background:
    rgba(193,117,48,.12);
}

/* TRUST STRIP */

.trust-strip{

    display:flex;
    flex-wrap:wrap;
    gap:15px;

    margin-top:25px;
}

.trust-pill{

    background:rgba(255,255,255,.9);

    backdrop-filter:blur(15px);

    border:1px solid rgba(255,255,255,.4);

    padding:14px 20px;

    border-radius:50px;

    display:flex;
    align-items:center;
    gap:10px;

    box-shadow:
    0 10px 25px rgba(0,0,0,.08);

    transition:.3s;
}

.trust-pill:hover{

    transform:translateY(-5px);

    box-shadow:
    0 15px 35px rgba(122,59,9,.15);
}

.trust-pill i{

    color:#c17530;
    font-size:18px;
}

.trust-pill span{

    font-weight:700;
    color:#3a1b05;
}

/* GUARANTEE SECTION */

.premium-guarantee{

    display:grid;
        height:40vh;
    grid-template-columns:
    repeat(3,1fr);

    gap:25px;

    margin-top:40px;
}

.guarantee-card{

    background:
    linear-gradient(
    145deg,
    #ffffff,
    #fff6ef);

    border-radius:25px;

    padding:30px;

    text-align:center;

    box-shadow:
    0 15px 35px rgba(0,0,0,.08);

    transition:.4s;

    position:relative;

    overflow:hidden;
}

.guarantee-card::before{

    content:"";

    position:absolute;

    width:140px;
    height:140px;

    background:
    rgba(193,117,48,.10);

    border-radius:50%;

    top:-50px;
    right:-50px;
}

.guarantee-card:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 25px 50px rgba(122,59,9,.18);
}

.g-icon{

    width:75px;
    height:75px;

    margin:auto;

    border-radius:50%;

    background:
    linear-gradient(
    135deg,
    #58260f,
    #c17530);

    display:flex;
    align-items:center;
    justify-content:center;

    margin-bottom:18px;
}

.g-icon i{

    color:white;
    font-size:28px;
}

.guarantee-card h4{

    color:#3a1b05;

    font-weight:700;

    margin-bottom:10px;
}

.guarantee-card p{

    color:#666;

    line-height:26px;
}

@media(max-width:768px){

    .premium-guarantee{

        grid-template-columns:1fr;
    }

    .trust-strip{

        justify-content:center;
    }
}
.fact-card:hover{

    transform:
    translateY(-10px);

    box-shadow:
    0 25px 50px rgba(122,59,9,.18);
}

.fact-card h3{

    font-size:48px;

    font-weight:900;

    margin-bottom:10px;

    background:
    linear-gradient(
    135deg,
    #58260f,
    #c17530);

    -webkit-background-clip:text;
    background-clip: text;
    -webkit-text-fill-color:transparent;
}

.fact-card p{

    margin:0;

    color:#666;

    font-size:16px;

    font-weight:600;

    letter-spacing:.5px;
}

/* MOBILE */

@media(max-width:768px){

    .coffee-facts{
        grid-template-columns:1fr;
    }

    .fact-card h3{
        font-size:38px;
    }

}
/* PRICE */

.new-price{

    text-shadow:
    0 8px 25px rgba(122,31,6,.15);
}

/* FEATURES */

.feature-card{

    transition:.35s;
}

.feature-card:hover{

    transform:translateY(-8px);

    box-shadow:
    0 18px 35px rgba(0,0,0,.08);
}

/* BUTTONS */

.buy-btn,
.cart-btn{

    transition:.35s;
}

.buy-btn:hover,
.cart-btn:hover{

    transform:translateY(-4px);
}

/* OFFER */

.offer-box{

    position:relative;
    overflow:hidden;
}
.live-sale{
position:fixed;
bottom:25px;
left:25px;
background:#fff;
padding:15px 20px;
border-radius:20px;
box-shadow:0 10px 35px rgba(0,0,0,.15);
z-index:999;
animation:slideUp .6s ease;
}

@keyframes slideUp{
from{
transform:translateY(100px);
opacity:0;
}
to{
transform:translateY(0);
opacity:1;
}
}
.offer-box::before{

    content:"";

    position:absolute;

    width:250px;
    height:250px;

    border-radius:50%;

    background:
    rgba(255,255,255,.08);

    top:-100px;
    right:-100px;
}

/* REVIEW CARD */

.review-card{

    transition:.35s;
}

.review-card:hover{

    transform:translateY(-8px);

    box-shadow:
    0 18px 40px rgba(0,0,0,.08);
}

/* RELATED CARD */

.related-card:hover{

    transform:
    translateY(-10px)
    scale(1.02);
}

/* THUMBNAIL */

.small-img.active{

    border:3px solid #7a3b09;
}

/* SCROLLBAR */

::-webkit-scrollbar{
    width:10px;
}

::-webkit-scrollbar-thumb{

    background:
    linear-gradient(
    #58260f,
    #7a3b09
    );

    border-radius:20px;
}

/* PREMIUM BADGE */

.premium-badge{

    display:inline-flex;
    align-items:center;
    gap:8px;

    background:#fff7ef;

    padding:10px 18px;

    border-radius:40px;

    color:#7a3b09;

    font-weight:700;

    margin-top:15px;
}

/* TRUST BAR */

.trust-bar{

    display:flex;
    flex-wrap:wrap;

    gap:15px;

    margin-top:25px;
}

.trust-item{

    background:#fff;

    padding:12px 18px;

    border-radius:16px;

    box-shadow:
    0 10px 25px rgba(0,0,0,.05);

    font-size:14px;

    font-weight:600;
}
</style>

</head>

<body>
    
      <?php include('header.php') ?>

<div class="product-wrapper">

<div class="product-main">

<div class="row g-5">

<!-- LEFT -->

<div class="col-lg-6">

<div class="image-box">

<img
src="images/<?php echo $row['image']; ?>"
id="mainImage"
class="big-image">

<div class="thumb-flex">

<img
src="images/<?php echo $row['image']; ?>"
class="small-img"
onclick="changeImage(this.src)">

<img
src="images/<?php echo $row['image']; ?>"
class="small-img"
onclick="changeImage(this.src)">

<img
src="images/<?php echo $row['image']; ?>"
class="small-img"
onclick="changeImage(this.src)">

</div>



<div class="product-video-box">

<h4>
<i class="fa-solid fa-circle-play"></i>
 Product Experience
</h4>


<video   autoplay muted loop  style="border-radius: 10px;  width:70%;   height:50vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
    <source src="./images/coldbeverage.mp4" type="video/mp4" >
</video>

</div>

</div>

</div>

<!-- RIGHT -->

<div class="col-lg-6">

<div class="product-tag">

☕ Premium Coffee Collection

</div>

<h1 class="product-title">

<?php echo $row['name']; ?>

</h1>

<div class="rating-flex">

<div>

<i class="fa-solid fa-star star"></i>
<i class="fa-solid fa-star star"></i>
<i class="fa-solid fa-star star"></i>
<i class="fa-solid fa-star star"></i>
<i class="fa-solid fa-star-half-stroke star"></i>

</div>

<span class="review-count">
(248 Reviews)
</span>

</div>

<div class="price-flex">

<div class="old-price">
₹ <?php echo $row['price'] + 150; ?>
</div>

<div class="new-price">
₹ <?php echo $row['price']; ?>
</div>

<div class="save-box">
25% OFF
</div>

</div>

<div class="premium-badge">
🔥 Best Seller • 2.4K+ Customers
</div>

<div class="trust-strip">

<div class="trust-pill">
<i class="fa-solid fa-mug-hot"></i>
<span>Premium Beans</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-truck-fast"></i>
<span>Fast Delivery</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-gift"></i>
<span>Gift Packaging</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-lock"></i>
<span>Secure Payment</span>
</div>

</div>



<p class="desc">

Experience rich aroma and handcrafted premium taste with our
special coffee collection. Freshly prepared for coffee lovers
with authentic flavor and luxury presentation.

</p>

<!-- FEATURES -->

<div class="feature-grid">

<div class="feature-card">

<i class="fa-solid fa-mug-hot"></i>

<h5>Fresh Brewed</h5>

<p>Premium quality beans</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-truck-fast"></i>

<h5>Fast Delivery</h5>

<p>Delivered within 2-5 days</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-shield-heart"></i>

<h5>100% Safe</h5>

<p>Hygienic packaging</p>

</div>

</div>

<!-- STOCK -->

<div style="margin-top:30px;">

<h5 style="color:#3a1b05; font-weight:800;">

Available Stock :
<span style="color:#7a1f06;">
<?php echo $row['stock']; ?>
</span>

</h5>

</div>

<div class="stock-progress">

<div class="stock-fill"
style="width:75%;"></div>

</div>

<p class="stock-alert">
🔥 Only <?php echo $row['stock']; ?> items left in stock
</p>

<!-- QUANTITY -->

<div class="action-area">

<div class="qty-flex">

<button class="qty-btn"
onclick="minusQty()">

-

</button>

<input
type="number"
value="1"
min="1"
id="qty"
class="qty-input">

<button class="qty-btn"
onclick="plusQty()">

+

</button>

</div>

<div class="btn-flex">



<button class="cart-btn"
    data-state="<?php echo $inCart ? 'remove' : 'add'; ?>"
    onclick="toggleCart(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
    id="cartBtn<?php echo $id; ?>">

<?php if($inCart){ ?>
    <i class="fa-solid fa-trash"></i> Remove From Cart
<?php } else { ?>
    <i class="fa-solid fa-cart-shopping"></i> Add To Cart
<?php } ?>

</button>



<a href="checkout.php?source=product&id=<?php echo $row['id']; ?>" class="buy-btn" style="text-decoration:none; padding-top:15px; text-align:center;">
    Buy Now
</a>


<div class="wishlist-icon <?php echo $inWishlist ? 'active' : ''; ?>"
onclick="toggleWishlist(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
id="wishBtn<?php echo $id; ?>">
<i class="fa-solid fa-heart"></i>
</div>

</div>

</div>

<div class="premium-guarantee">

<div class="guarantee-card">

<div class="g-icon">
<i class="fa-solid fa-award"></i>
</div>

<h4>Premium Coffee Beans</h4>

<p>
Handpicked beans with rich aroma and cafe-quality taste.
</p>

</div>

<div class="guarantee-card">

<div class="g-icon">
<i class="fa-solid fa-certificate"></i>
</div>

<h4>100% Authentic</h4>

<p>
Freshly sourced products with guaranteed originality.
</p>

</div>

<div class="guarantee-card">

<div class="g-icon">
<i class="fa-solid fa-gift"></i>
</div>

<h4>Gift Packaging</h4>

<p>
Luxury wrapping available for special occasions.
</p>

</div>

</div>
<!-- OFFER -->

<div class="offer-box">

<h4>

🎉 Special Offer Available

</h4>

<p>

Get free delivery + premium gift wrapping
on orders above ₹999.

</p>

</div>

<div class="why-choose">

<h2>Why Coffee Lovers Choose Us</h2>

<div class="trust-strip">

<div class="trust-pill">
<i class="fa-solid fa-mug-hot"></i>
<span>Premium Beans</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-truck-fast"></i>
<span>Fast Delivery</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-gift"></i>
<span>Gift Packaging</span>
</div>

<div class="trust-pill">
<i class="fa-solid fa-lock"></i>
<span>Secure Payment</span>
</div>

</div>

</div>

</div>

</div>

</div>

<!-- DESCRIPTION -->

<div class="info-section">

<div class="custom-box">

<h2>

Product Description

</h2>

<p class="info-text">

This premium handcrafted coffee product is specially prepared
for coffee lovers who enjoy rich aroma, smooth texture,
and luxury cafe-style experience. Carefully selected ingredients
ensure perfect taste and freshness in every sip.

</p>

</div>

</div>

<!-- SHIPPING -->

<div class="info-section">

<div class="custom-box">

<h2>

Shipping & Delivery

</h2>

<p class="info-text">

✔ Fast delivery within 2-5 business days<br><br>

✔ Secure packaging for safe transportation<br><br>

✔ Free shipping on premium orders<br><br>

✔ Easy return and replacement policy

</p>

</div>

</div>

<!-- REVIEWS -->

<?php
$avgQuery = mysqli_query($conn,"
SELECT
COUNT(*) as total_reviews,
ROUND(AVG(rating),1) as avg_rating
FROM product_reviews
WHERE product_id='$product_id'
");

$avgData = mysqli_fetch_assoc($avgQuery);

$avgRating = $avgData['avg_rating'] ?? 0;
$totalReviews = $avgData['total_reviews'] ?? 0;
?>






<div class="info-section">

<div class="coffee-facts">

    <div class="fact-card">
        <?php

$userCountQuery = mysqli_query($conn,
"SELECT COUNT(*) as total_users FROM clients");

$userCount = mysqli_fetch_assoc($userCountQuery);

?>
        <i class="fa-solid fa-users"></i>
        <h3><?php echo $userCount['total_users']; ?>+</h3>
        <p>Happy Customers</p>
    </div>

    <div class="fact-card">
        <?php

$reviewStats = mysqli_query($conn,"
SELECT
COUNT(*) as total_reviews,
SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) as positive_reviews
FROM product_reviews
");

$stats = mysqli_fetch_assoc($reviewStats);

$positivePercent = 0;

if($stats['total_reviews'] > 0){

    $positivePercent =
    round(
        ($stats['positive_reviews'] /
        $stats['total_reviews']) * 100
    );
}

?>
        <i class="fa-solid fa-star"></i>
        <h3><?php echo $positivePercent; ?>%</h3>
        <p>Positive Reviews</p>
    </div>

    <div class="fact-card">
        <?php

$productQuery = mysqli_query($conn,
"SELECT COUNT(*) as total_products FROM products");

$productCount = mysqli_fetch_assoc($productQuery);

?>
        
        <i class="fa-solid fa-mug-hot"></i>
        <h3><?php echo $productCount['total_products']; ?>+</h3>
        <p>Premium Products</p>
    </div>

</div>

<?php

$reviewQuery = mysqli_query($conn,"
SELECT *
FROM product_reviews
WHERE product_id='$product_id'
ORDER BY created_at DESC
");

?>

<h2 style="font-weight:900; color:#3a1b05; margin-bottom:30px;">
Customer Reviews
</h2>

<div class="review-grid">

<?php if(mysqli_num_rows($reviewQuery) > 0){ ?>

    <?php while($rev = mysqli_fetch_assoc($reviewQuery)){ ?>

        <?php
        $name = $rev['user_name'] ?? 'User';
        $initial = strtoupper($name[0]);
        ?>

        <div class="review-card">

            <div class="review-top">

                <div class="review-user">

                    <div class="user-circle">
                        <?php echo $initial; ?>
                    </div>

                    <div>
                        <h5><?php echo htmlspecialchars($name); ?></h5>

                        <div style="color:#ffb400;">
                            <?php
                            for($i=1;$i<=5;$i++){
                                if($i <= $rev['rating']){
                                    echo "★";
                                } else {
                                    echo "☆";
                                }
                            }
                            ?>
                        </div>

                    </div>

                </div>

            </div>

            <p>
                <?php echo htmlspecialchars($rev['review']); ?>
            </p>

            <small style="color:#999;">
                <?php echo date("d M Y", strtotime($rev['created_at'])); ?>
            </small>

        </div>

    <?php } ?>

<?php } else { ?>

    <p style="color:#777;">No reviews yet. Be the first to review this product.</p>

<?php } ?>

</div>
</div>
<!-- ADD REVIEW -->
<!-- ================= PREMIUM ADD REVIEW ================= -->
<div class="premium-review-section">

    <div class="review-header">
        <h2>☕ Share Your Experience</h2>
        <p>Help other coffee lovers by rating this product</p>
    </div>

    <form method="POST" action="review_action.php" class="premium-review-card">

        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

        <!-- NAME -->
        <div class="input-box">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="name" placeholder="Your Name" required>
        </div>

        <!-- STAR RATING -->
        <div class="rating-box">
            <label>Your Rating</label>

            <div class="stars" id="starContainer">

                <input type="radio" name="rating" value="5" id="r5">
                <label for="r5">★</label>

                <input type="radio" name="rating" value="4" id="r4">
                <label for="r4">★</label>

                <input type="radio" name="rating" value="3" id="r3">
                <label for="r3">★</label>

                <input type="radio" name="rating" value="2" id="r2">
                <label for="r2">★</label>

                <input type="radio" name="rating" value="1" id="r1">
                <label for="r1">★</label>

            </div>

            <div id="ratingText" class="rating-text"></div>
        </div>

        <!-- REVIEW -->
        <div class="input-box textarea">
            <i class="fa-solid fa-pen"></i>
            <textarea name="review" placeholder="Write your coffee experience..." required></textarea>
        </div>

        <button type="submit" class="premium-submit">
            <i class="fa-solid fa-paper-plane"></i>
            Submit Review
        </button>

        

    </form>

    
</div>
<!-- RELATED PRODUCTS -->

<div class="info-section">

<h2 style="font-weight:900; color:#3a1b05; margin-bottom:35px;">

Related Products

</h2>

<div class="related-grid">

<?php

$related = "SELECT * FROM products
WHERE category_name= 'Coffee'
LIMIT 8";

$related_run = mysqli_query($conn,$related);

while($related_row = mysqli_fetch_assoc($related_run)){

?>

<div class="related-card">

<img
src="images/<?php echo $related_row['image']; ?>"
class="related-img">

<div class="related-content">

<h4 class="related-title">

<?php echo $related_row['name']; ?>

</h4>

<div class="related-price">

₹ <?php echo $related_row['price']; ?>

</div>

<a href="viewproduct.php?id=<?php echo $related_row['id']; ?>">

<button class="view-btn">

View Product

</button>

</a>

</div>

</div>

<?php } ?>

</div>

</div>
<?php

$orderQuery = mysqli_query($conn,"
    SELECT customer_name, city, product_name, created_at
    FROM userorder
    ORDER BY created_at DESC
    LIMIT 1
");

$order = mysqli_fetch_assoc($orderQuery);

function timeAgo($datetime){
    $time = time() - strtotime($datetime);

    if($time < 3600){
        return floor($time / 60) . " min ago";
    } elseif($time < 86400){
        return floor($time / 3600) . " hr ago";
    } else {
        return floor($time / 86400) . " day ago";
    }
}
?>

<div class="live-sale">
    🔥 <?php echo htmlspecialchars($order['customer_name']); ?>
    from <?php echo htmlspecialchars($order['city']); ?>
    purchased
    <?php echo htmlspecialchars($order['product_name']); ?>
    <?php echo timeAgo($order['created_at']); ?>
</div>


</div>
    

</div>
<a
href="checkout.php?source=product&id=<?php echo $row['id']; ?>"
class="sticky-buy-btn">

<i class="fa-solid fa-bag-shopping"></i>
Buy Now

</a>

<?php include('footer.php') ?>

 <script src="script.js"></script>
    <script src="search.js"></script>
   
    <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>

function changeImage(src){

document.getElementById("mainImage").src = src;

}

function plusQty(){

let qty =
document.getElementById("qty");

qty.value =
parseInt(qty.value) + 1;

}

function minusQty(){

let qty =
document.getElementById("qty");

if(parseInt(qty.value) > 1){

qty.value =
parseInt(qty.value) - 1;

}

}

const ratingText = document.getElementById("ratingText");

document.querySelectorAll(".stars input").forEach((input)=>{
    input.addEventListener("change", function(){

        let value = this.value;

        let text = "";

        switch(value){
            case "5": text = "🔥 Excellent! Loved it"; break;
            case "4": text = "👍 Very Good"; break;
            case "3": text = "👌 Good"; break;
            case "2": text = "😐 Okay"; break;
            case "1": text = "😞 Poor"; break;
        }

        ratingText.innerHTML = text;
    });
});

</script>


</body>
</html>