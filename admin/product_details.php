<?php
include "includes/db_connect.php";
global $conn;

/** @var mysqli $conn */

if(!isset($_GET['id'])){
    header("location:product.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($conn,"
SELECT
products.*,
categories.name as category_name
FROM products
LEFT JOIN categories
ON products.category_id=categories.id
WHERE products.id='$id'
");

$product = mysqli_fetch_assoc($query);

if(!$product){
    die("Product not found");
}
?>

<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>Product Details</title>

<link rel="stylesheet"
href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

body{
background:#f5f7fb;
}

.product-wrapper{
max-width:1400px;
margin:40px auto;
padding:20px;
}

.product-card{
background:#fff;
border-radius:25px;
overflow:hidden;
box-shadow:0 15px 45px rgba(0,0,0,.08);
}

.product-header{
background:linear-gradient(135deg,#4e2613,#a65935);
padding:25px;
color:white;
}

.product-header h2{
font-weight:800;
margin:0;
}

.product-image{
width:100%;
height:550px;
object-fit:cover;
border-radius:20px;
}

.info-card{
background:#fff;
padding:20px;
border-radius:18px;
box-shadow:0 5px 20px rgba(0,0,0,.05);
height:100%;
}

.info-title{
font-size:14px;
color:#777;
margin-bottom:5px;
}

.info-value{
font-size:20px;
font-weight:700;
color:#222;
}

.badge-stock{
font-size:15px;
padding:8px 15px;
border-radius:50px;
}

.stats-box{
padding:18px;
background:#fafafa;
border-radius:15px;
text-align:center;
}

.stats-box h4{
margin:0;
font-weight:800;
}

.stats-box p{
margin:0;
color:#777;
}

.action-btn{
padding:12px 25px;
border-radius:12px;
font-weight:700;
}

.desc-box{
background:white;
padding:25px;
border-radius:20px;
margin-top:25px;
box-shadow:0 5px 20px rgba(0,0,0,.05);
}

</style>

</head>

<body>

<div class="product-wrapper">

<div class="product-card">

<div class="product-header">
<h2>
<i class="fa-solid fa-box"></i>
 Product Details
</h2>
</div>

<div class="p-4">

<div class="row">

<div class="col-lg-5">

<img
src="../images/<?php echo $product['image']; ?>"
class="product-image">

</div>

<div class="col-lg-7">

<div class="row g-3">

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Product ID</div>
<div class="info-value">
#<?php echo $product['id']; ?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Category</div>
<div class="info-value">
<?php echo $product['category_name']; ?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Product Name</div>
<div class="info-value">
<?php echo $product['name']; ?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Price</div>
<div class="info-value text-success">
₹<?php echo number_format($product['price']); ?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Stock</div>
<div class="info-value">
<?php echo $product['stock']; ?>
</div>
</div>
</div>

<div class="col-md-6">
<div class="info-card">
<div class="info-title">Status</div>

<?php if($product['status']==1){ ?>

<span class="badge bg-success badge-stock">
Active
</span>
<?php } else { ?>
<span class="badge bg-danger badge-stock">
Inactive
</span>
<?php } ?>

</div>
</div>

</div>

<div class="row mt-4">

<div class="col-md-4">
<div class="stats-box">
<h4>₹<?php echo number_format($product['price']); ?></h4>
<p>Current Price</p>
</div>
</div>

<div class="col-md-4">
<div class="stats-box">
<h4><?php echo $product['stock']; ?></h4>
<p>Available Stock</p>
</div>
</div>

<div class="col-md-4">
<div class="stats-box">
<h4><?php echo $product['status'] ? 'Live' : 'Hidden'; ?></h4>
<p>Store Status</p>
</div>
</div>

</div>

<div class="mt-4">

<a href="edit_product.php?id=<?php echo $product['id']; ?>"
class="btn btn-primary action-btn">

<i class="fa-solid fa-pen"></i>
Edit Product

</a>

<a href="../viewproduct.php?id=<?php echo $product['id']; ?>"
target="_blank"
class="btn btn-success action-btn">

<i class="fa-solid fa-globe"></i>
View Customer Page

</a>

</div>

</div>

</div>

<div class="desc-box">

<h4>
<i class="fa-solid fa-file-lines"></i>
 Product Description
</h4>

<hr>

<p>
<?php
echo !empty($product['description'])
? $product['description']
: 'No description available';
?>
</p>

</div>

</div>

</div>

</div>

</body>
</html>
