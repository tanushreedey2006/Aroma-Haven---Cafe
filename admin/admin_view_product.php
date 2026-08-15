<?php
include "includes/db_connect.php";
global $conn;
/** @var mysqli $conn */

$product_id = intval($_GET['id'] ?? 0);
if(!$product_id){ die("Invalid Product"); }

$product = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT p.*, c.name AS category
FROM products p
LEFT JOIN categories c ON c.id=p.category_id
WHERE p.id='$product_id'
"));

if(!$product){ die("Product not found"); }

$ratingData = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total_reviews, ROUND(AVG(rating),1) avg_rating
FROM product_reviews
WHERE product_id='$product_id'
"));

$revenueData = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(grand_total) total
FROM userorder
WHERE product_id='$product_id'
"));

$revenue = $revenueData['total'] ?? 0;

$sales = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM userorder WHERE product_id='$product_id'"))['c'];
$wishlist = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM wishlist WHERE product_id='$product_id'"))['c'];
$cart = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM addtocart WHERE product_id='$product_id'"))['c'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Coffee Product Intelligence</title>
    <link rel="icon" type="image/png" href="weblogo.png">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>


:root{
    --bg:#f7f3ee;
    --card:#ffffff;
    --coffee:#8b5e3c;
    --caramel:#c98b5b;
    --cream:#2b2b2b;
    --muted:#6b6b6b;
    --line:#e6d5c3;
}

body{
    margin:0;
    font-family:Inter;
    background: radial-gradient(circle at top,
        #fffaf5 0%,
        #f3ebe3 50%,
        #efe3d7 100%
    );
    color:var(--cream);
}

/* soft glow background */
body::before{
    content:"";
    position:fixed;
    top:-200px;
    left:-200px;
    width:700px;
    height:700px;
    background:rgba(201,139,91,0.12);
    filter:blur(140px);
    z-index:-1;
}

/* animation */
@keyframes fadeUp {
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}

.card, .kpi-card, .hero{
    animation:fadeUp 0.5s ease;
    transition:0.25s ease;
}

/* CONTAINER */
.container{
    width:92%;
    margin:40px auto;
}

/* HERO */
.hero{
    background:linear-gradient(135deg,#ffffff,#f7efe7);
    border:1px solid var(--line);
    padding:35px;
    border-radius:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

.hero h1{
    font-family:"Playfair Display";
    font-size:44px;
    margin:0;
    color:#2b1d14;
}

.tag{
    background:var(--coffee);
    color:white;
    padding:6px 14px;
    border-radius:30px;
    font-size:12px;
}

/* CARDS */
.card, .kpi-card{
    background:var(--card);
    border:1px solid var(--line);
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

.card{
    padding:22px;
}

/* KPI */
.kpi{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-top:25px;
}

.kpi-card{
    padding:18px;
}

.kpi-card h2{
    margin:0;
    font-size:28px;
    color:var(--caramel);
}

.kpi-card p{
    color:var(--muted);
    margin:5px 0 0;
    font-size:13px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:22px;
    margin-top:25px;
}

/* IMAGE */
.product-img{
    width:100%;
    height:420px;
    object-fit:cover;
    border-radius:14px;
}

/* TEXT */
.title{
    font-family:"Playfair Display";
    font-size:34px;
    margin:10px 0;
    color:#2b1d14;
}

.price{
    font-size:26px;
    color:var(--coffee);
    font-weight:700;
}

/* STATUS */
.active{
    background:#e8f5e9;
    color:#2e7d32;
    padding:5px 12px;
    border-radius:20px;
}

.inactive{
    background:#fdecea;
    color:#c62828;
    padding:5px 12px;
    border-radius:20px;
}

/* BAR */
.bar{
    height:6px;
    background:#eee;
    border-radius:20px;
    overflow:hidden;
}

.fill{
    height:100%;
    background:linear-gradient(90deg,var(--coffee),var(--caramel));
}

/* REVIEW */
.review{
    position:relative;
    padding:18px 18px 18px 26px;
    margin-bottom:14px;
    border-radius:14px;
    background:#fff;
    border:1px solid var(--line);
    transition:0.25s ease;
}

.review:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.review::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:3px;
    height:100%;
    background:var(--caramel);
}

.avatar{
    width:38px;
    height:38px;
    border-radius:50%;
    background:var(--coffee);
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}

.row{
    display:flex;
    gap:10px;
    align-items:center;
}

.star{
    color:var(--caramel);
    font-size:14px;
}

/* small improvement */
p{
    color:var(--muted);
}


</style>
</head>

<body>

<div class="container">


<div class="hero">
    <div>
        <span class="tag">COFFEE INTELLIGENCE</span>
        <h1><?=$product['name']?></h1>
        <p style="color:var(--muted)">Roast level analytics & customer taste feedback</p>
    </div>

    <div class="card" style="margin-top:20px">
    <h3>📊  Product Insight</h3>

    <?php
    $stock = (int)$product['stock'];
    $statusText = $product['status'] ? "Selling well" : "Not active";

    $insight = "";

    if($sales > 50){
        $insight = "🔥 High demand product with strong purchase flow.";
    } elseif($sales > 10){
        $insight = "📈 Moderate performance, potential for marketing boost.";
    } else {
        $insight = "People started to trust - getting more love.";
    }

    if($stock < 10){
        $insight .= " Stock is critically low.";
    }
    ?>

    <p style="color:var(--muted);line-height:1.6">
        <?= $insight ?>
    </p>
</div>
</div>


<div class="kpi">
    <div class="kpi-card"><h2><?=$sales?></h2><p>Orders Brewed</p></div>
    <div class="kpi-card"><h2><?=$wishlist?></h2><p>Saved Beans</p></div>
    <div class="kpi-card"><h2><?=$cart?></h2><p>Cart Adds</p></div>
    <div class="kpi-card"><h2>₹<?=$revenue?></h2><p>Revenue Flow</p></div>

    
</div>

<div style="margin-top:20px">
    <h3>Sales Trend (Last 7 Days)</h3>

    <div style="display:flex;gap:6px;height:50px;align-items:flex-end">
        <div style="width:10px;height:30%;background:var(--coffee)"></div>
        <div style="width:10px;height:60%;background:var(--coffee)"></div>
        <div style="width:10px;height:40%;background:var(--coffee)"></div>
        <div style="width:10px;height:80%;background:var(--caramel)"></div>
        <div style="width:10px;height:55%;background:var(--coffee)"></div>
        <div style="width:10px;height:70%;background:var(--coffee)"></div>
        <div style="width:10px;height:90%;background:var(--caramel)"></div>
    </div>
</div>

<div class="grid">


<div class="card">
    <img class="product-img" src="../images/<?=$product['image']?>">
    <div class="title"><?=$product['name']?></div>
    <div class="price">₹<?=$product['price']?></div>

    <p style="color:var(--muted)"><?=$product['category']?></p>

    <?php if($product['status']){ ?>
        <span class="active">Available</span>
    <?php } else { ?>
        <span class="inactive">Out of Stock</span>
    <?php } ?>

    <p style="color:var(--muted);margin-top:10px">
        Stock: <?=$product['stock']?>
    </p>
    <?php
$conversion = ($cart > 0) ? round(($sales / $cart) * 100, 2) : 0;
?>

<div class="kpi-card">
    <h2><?=$conversion?>%</h2>
    <p>Conversion Rate</p>
</div>
</div>


<div class="card">
    <h3>Roast Feedback Score</h3>
    
    <p style="color:var(--muted)">Avg Rating: <?=$ratingData['avg_rating']?> / 5</p>

    <?php
    $total = max(1,$ratingData['total_reviews']);
    function bar($c,$t){ return ($c/$t)*100; }
    ?>

    <p>5★ <div class="bar"><div class="fill" style="width:<?=bar(5,$total)?>%"></div></div></p>
    <p>4★ <div class="bar"><div class="fill" style="width:<?=bar(4,$total)?>%"></div></div></p>
    <p>3★ <div class="bar"><div class="fill" style="width:<?=bar(3,$total)?>%"></div></div></p>
<?php
$demand = min(100, ($sales * 2) + ($wishlist * 1.5));
?>

<div style="margin-top:15px">
    <p style="font-size:12px;color:var(--muted)">Demand Meter</p>

    <div class="bar">
        <div class="fill" style="width:<?=$demand?>%"></div>
    </div>

    <small style="color:var(--muted)"><?=$demand?>% market interest</small>
</div>
    
</div>

</div>


<div class="card" style="margin-top:20px">

<h3>Customer Taste Notes</h3>

<?php
$reviews=mysqli_query($conn,"
SELECT pr.*, c.name
FROM product_reviews pr
LEFT JOIN clients c ON c.id=pr.user_id
WHERE pr.product_id='$product_id'
ORDER BY pr.created_at DESC
");

while($r=mysqli_fetch_assoc($reviews)){
?>

<div class="review">

<?php
$avg = $ratingData['avg_rating'] ?? 0;

if($avg >= 4.5){
    $sentiment = "🔥 Loved by customers";
} elseif($avg >= 3.5){
    $sentiment = "🙂 Generally positive";
} else {
    $sentiment = "⚠️ Needs improvement";
}
?>

<div class="tag" style="margin-bottom:10px;display:inline-block">
    <?=$sentiment?>
</div>

<div class="row">
<div class="avatar"><?=strtoupper(substr($r['name'],0,1))?></div>
<b><?=$r['name']?></b>
</div>

<div class="star">
<?php for($i=1;$i<=5;$i++) echo $i<=$r['rating']?'★':'☆'; ?>
</div>

<p style="color:var(--muted)"><?=$r['review']?></p>

</div>

<?php } ?>

</div>

</div>

</body>
</html>




















