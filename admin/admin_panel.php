<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
        <link rel="icon" type="image/png" href="weblogo.png">

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="admin_panel.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <?php
    session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: admin_login.php");
    exit();
}
include "includes/db_connect.php";
global $conn;
/** @var mysqli $conn */

?>

    <style>


.pagination-box{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin:35px 0 10px;
    flex-wrap:wrap;
    animation:fadePagination .7s ease;
}

.pagination-box a,
.pagination-box span{

    min-width:45px;
    height:45px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:14px;

    text-decoration:none;

    font-weight:700;
    font-size:15px;

    transition:.35s;

}

.pagination-box a{

    background:#ffffff;
    color:#444;

    border:1px solid #e5e7eb;

    box-shadow:
    0 5px 15px rgba(0,0,0,.06);

}

.pagination-box a:hover{

    background:linear-gradient(135deg,#2563eb,#4f46e5);

    color:#fff;

    transform:translateY(-4px);

    box-shadow:
    0 12px 25px rgba(37,99,235,.35);

}

.pagination-box .active-page{

    background:linear-gradient(135deg,#2563eb,#4f46e5);

    color:#fff;

    box-shadow:
    0 12px 30px rgba(37,99,235,.45);

    animation:pulsePage 1.2s infinite alternate;

}

.pagination-box .prev-next{

    padding:0 18px;

    width:auto;

    background:#111827;

    color:#fff;

}

.pagination-box .prev-next:hover{

    background:#2563eb;

    color:#fff;

}

@keyframes pulsePage{

    from{

        transform:scale(1);

    }

    to{

        transform:scale(1.08);

    }

}

@keyframes fadePagination{

    from{

        opacity:0;
        transform:translateY(20px);

    }

    to{

        opacity:1;
        transform:translateY(0);

    }

}


/*=================================
 PREMIUM ORDER PAGINATION
=================================*/

#orders_pagination{

    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;

    margin-top:25px;

    flex-wrap:wrap;

    animation:fadeOrderPagination .6s ease;

}

#orders_pagination a,
#orders_pagination span,
#orders_pagination button{

    min-width:45px;
    height:45px;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:0 18px;

    border:none;
    border-radius:14px;

    text-decoration:none;

    font-weight:700;

    transition:.35s;

}

/* Number Buttons */

#orders_pagination a{

    background:#ffffff;

    color:#374151;

    border:1px solid #e5e7eb;

    box-shadow:0 5px 15px rgba(0,0,0,.06);

}

/* Hover */

#orders_pagination a:hover{

    background:linear-gradient(135deg,#2563eb,#4f46e5);

    color:#fff;

    transform:translateY(-4px);

    box-shadow:0 12px 30px rgba(37,99,235,.35);

}

/* Current Page */

#orders_pagination .active,
#orders_pagination .current{

    background:linear-gradient(135deg,#2563eb,#4f46e5);

    color:#fff;

    box-shadow:0 12px 30px rgba(37,99,235,.45);

    animation:pulseOrder 1s infinite alternate;

}

/* Previous / Next */

#orders_pagination .prev,
#orders_pagination .next{

    background:#111827;

    color:#fff;

}

#orders_pagination .prev:hover,
#orders_pagination .next:hover{

    background:#2563eb;

}

@keyframes pulseOrder{

    from{

        transform:scale(1);

    }

    to{

        transform:scale(1.08);

    }

}

@keyframes fadeOrderPagination{

    from{

        opacity:0;

        transform:translateY(20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}




.table-card{

    background:#fff;
    border-radius:24px;
    padding:25px;
    margin-top:30px;

    border:1px solid #edf2f7;

    box-shadow:
    0 15px 40px rgba(0,0,0,.08);

    overflow:hidden;

    animation:tableFade .8s ease;

}

.table-card:hover{

    transform:translateY(-4px);

    box-shadow:
    0 25px 60px rgba(37,99,235,.12);

}

.table-responsive{

    overflow-x:auto;

    border-radius:18px;

}



.data-table{

    width:100%;
    border-collapse:separate;
    border-spacing:0;

}



.data-table thead th{

    background:linear-gradient(135deg,#2563eb,#4f46e5);

    color:#fff;

    padding:18px;

    font-size:14px;

    font-weight:700;

    text-transform:uppercase;

    letter-spacing:.7px;

    border:none;

    position:sticky;

    top:0;

    z-index:2;

}

.data-table thead th:first-child{

    border-radius:15px 0 0 15px;

}

.data-table thead th:last-child{

    border-radius:0 15px 15px 0;

}



.data-table tbody tr{

    transition:.35s;

}

.data-table tbody tr:nth-child(even){

    background:#fafcff;

}

.data-table tbody tr:hover{

    background:#eef6ff;

    transform:scale(1.01);

}


.data-table td{

    padding:18px;

    border-bottom:1px solid #eef2f7;

    vertical-align:middle;

    font-size:15px;

}



.data-table td img{

    width:70px;

    height:70px;

    object-fit:cover;

    border-radius:18px;

    border:3px solid #fff;

    box-shadow:
    0 8px 20px rgba(0,0,0,.15);

    transition:.4s;

}

.data-table td img:hover{

    transform:scale(1.15) rotate(-3deg);

}



.data-table td:nth-child(2){

    font-size:16px;

    font-weight:700;

    color:#1f2937;

}



.data-table td:nth-child(3){

    color:#2563eb;

    font-size:17px;

    font-weight:700;

}



.data-table td:nth-child(4){

    font-weight:700;

    color:#059669;

}



.badge{

    padding:8px 18px;

    border-radius:50px;

    font-size:12px;

    font-weight:700;

    letter-spacing:.5px;

}

.bg-success{

    background:#16a34a !important;

    color:#fff;

}

.bg-danger{

    background:#dc2626 !important;

    color:#fff;

}



.data-table td a{

    width:42px;

    height:42px;

    display:inline-flex;

    justify-content:center;

    align-items:center;

    margin-right:8px;

    border-radius:12px;

    text-decoration:none;

    transition:.35s;

}

.data-table td a:first-child{

    background:#e0edff;

    color:#2563eb;

}

.data-table td a:last-child{

    background:#fff4dd;

    color:#f59e0b;

}

.data-table td a:hover{

    transform:translateY(-5px) scale(1.08);

    box-shadow:0 10px 25px rgba(0,0,0,.18);

}



.table-responsive::-webkit-scrollbar{

    height:8px;

}

.table-responsive::-webkit-scrollbar-thumb{

    background:#2563eb;

    border-radius:20px;

}

.table-responsive::-webkit-scrollbar-track{

    background:#eef2f7;

}



@keyframes tableFade{

    from{

        opacity:0;

        transform:translateY(25px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}











/* ===============================
   ADMIN PANEL HEADER FIX
==================================*/

/* .header{
    width:calc(100% - 260px) !important;
    margin-left:260px !important;
    padding:0 30px !important;

    display:flex;
    justify-content:space-between;
    align-items:center;
} */

.search-bar{
    width:420px !important;
    flex:none !important;
}

.header-actions{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:22px;
}

/* Notification */

.notification{
    width:45px !important;
    height:45px !important;

    display:flex;
    justify-content:center;
    align-items:center;

    border-radius:50%;
    position:relative;

    background:#f8fafc;
    transition:.3s;
}

.notification:hover{
    background:#eef4ff;
}

.notification i{
    font-size:20px !important;
    color:#475569;
}


.notification .badge{
    position:absolute;

    top:2px;
    right:22px;
    padding-left: 7%;
    padding-right: 4%;
    width:10px;
    height:10px;
    /* margin-left: 4%; */
    display:flex;
    justify-content:center;
    /* align-items:center; */

    border-radius:50%;
    /* background-color: red; */
    background:#ef4444;
    color:#fff;

    font-size:11px;
    font-weight:700;

    border:2px solid #fff;
}



/* Profile */

.user-profile{
    display:flex;
    align-items:center;
    gap:12px;
    padding-left:10px;
}

.user-info{
    display:flex;
    flex-direction:column;
}

.user-name{
    font-size:15px;
    font-weight:700;
    color:#111827;
}

.user-role{
    font-size:13px;
    color:#6b7280;
}



/* ===== MATCH USER LIST HEADER ===== */

.header{
    width:calc(100% - 260px) !important;
    margin-left:260px !important;

    height:70px !important;

    padding:0 30px !important;

    display:flex !important;
    align-items:center !important;
    justify-content:space-between !important;

    position:sticky !important;
    top:0 !important;

    background:#fff;

    z-index:1000;
}


.search-bar{
    width:420px !important;
    flex:none !important;
}


.header-actions{
    display:flex !important;
    align-items:center !important;
    gap:5px !important;
}
    </style>


    <?php


$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn,$_GET['search'])
    : '';
$sql="select count(*) as total_user from clients;";


$run=mysqli_query($conn,$sql);
$result=mysqli_fetch_assoc($run);
$total_user=$result['total_user'];


$order_count_query = mysqli_query($conn,"
SELECT COUNT(*) as total_orders
FROM userorder
");

$order_count_data = mysqli_fetch_assoc($order_count_query);
$total_orders = $order_count_data['total_orders'] ?? 0;

$revenue_query = mysqli_query($conn,"
SELECT SUM(grand_total) AS total_revenue
FROM userorder
WHERE payment_status='Paid'
");

$revenue_data = mysqli_fetch_assoc($revenue_query);

$total_revenue = $revenue_data['total_revenue'] ?? 0;

// Total Users
$user_query = mysqli_query($conn,"
SELECT COUNT(*) as total_users
FROM clients
WHERE role='user'
");

$user_data = mysqli_fetch_assoc($user_query);
$total_users = $user_data['total_users'] ?? 0;


// Total Orders
$order_query = mysqli_query($conn,"
SELECT COUNT(*) as total_orders
FROM userorder
");

$order_data = mysqli_fetch_assoc($order_query);
$total_orders = $order_data['total_orders'] ?? 0;


// Conversion Rate
if($total_users > 0){
    $conversion_rate = round(($total_orders / $total_users) * 100, 2);
}else{
    $conversion_rate = 0;
}
?>

<?php
$current_users = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM clients
WHERE role='user'
AND MONTH(addwithus) = MONTH(CURRENT_DATE())
"))['total'];

$last_users = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM clients
WHERE role='user'
AND MONTH(addwithus) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
"))['total'];

$user_change = ($last_users > 0)
? round((($current_users - $last_users) / $last_users) * 100, 1)
: 100;
?>

<?php
$current_revenue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(grand_total) as total
FROM userorder
WHERE payment_status='Paid'
AND MONTH(created_at) = MONTH(CURRENT_DATE())
"))['total'];

$last_revenue = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(grand_total) as total
FROM userorder
WHERE payment_status='Paid'
AND MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
"))['total'];

$current_revenue = $current_revenue ?? 0;
$last_revenue = $last_revenue ?? 0;

$revenue_change = ($last_revenue > 0)
? round((($current_revenue - $last_revenue) / $last_revenue) * 100, 1)
: 100;
?>

<?php
$current_orders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM userorder
WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
"))['total'];

$last_orders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total
FROM userorder
WHERE MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH)
"))['total'];

$order_change = ($last_orders > 0)
? round((($current_orders - $last_orders) / $last_orders) * 100, 1)
: 100;
?>
  </head>
  <body>
    <div class="container">
      <?php include "sidebar.php";?>
      <?php
        include "header.php";
        ?>
         <div class="">

    </div>
     

        </div>
      </div>




      <div class="main-content">
        <div class="page-title">
          <div class="title">Dashboard</div>
         
        </div>

        <div class="stats-cards">
          <div class="stat-card">
            <div class="card-header">
              <div>
                <div class="card-value"><?=$total_user?></div>
                <div class="card-label">Total Users</div>
              </div>
              <div class="card-icon purple">
                <i class="fas fa-users"></i>
              </div>
            </div>
            <div class="card-change positive">
              <div class="card-change <?= ($user_change >= 0 ? 'positive' : 'negative') ?>">
                  <i class="fas fa-arrow-<?= ($user_change >= 0 ? 'up' : 'down') ?>"></i>
                  <span><?= $user_change ?>% from last month</span>
              </div>
            </div>
          </div>

          <div class="stat-card">
            <div class="card-header">
              <div>
                <div class="card-value">
                  ₹<?= number_format($total_revenue,2) ?>
                  </div>
                <div class="card-label">Total Revenue</div>
              </div>
              <div class="card-icon blue">
                <i class="fas fa-dollar-sign"></i>
              </div>
            </div>
            <div class="card-change positive">
                  <div class="card-change <?= ($revenue_change >= 0 ? 'positive' : 'negative') ?>">
                    <i class="fas fa-arrow-<?= ($revenue_change >= 0 ? 'up' : 'down') ?>"></i>
                    <span><?= $revenue_change ?>% from last month</span>
                </div>
            </div>
          </div>

          <div class="stat-card">
            <div class="card-header">
              <div>

                <div class="card-value"><?=$total_orders?></div>
                <div class="card-label">Total Orders</div>
              </div>
              <div class="card-icon green">
                <i class="fas fa-shopping-cart"></i>
              </div>
            </div>
            <div class="card-change negative">
              <div class="card-change <?= ($order_change >= 0 ? 'positive' : 'negative') ?>">
                  <i class="fas fa-arrow-<?= ($order_change >= 0 ? 'up' : 'down') ?>"></i>
                  <span><?= $order_change ?>% from last month</span>
              </div>
            </div>
          </div>

          <div class="stat-card">
            <div class="card-header">
              <div>
               <div class="card-value">
                  <?php echo $conversion_rate; ?>%
              </div>

              <div class="card-label">
                  Conversion Rate
              </div>
              </div>
              <div class="card-icon orange">
                <i class="fas fa-chart-line"></i>
              </div>
            </div>
            <div class="card-change positive">
              <i class="fas fa-arrow-up"></i>
              <span>4.6% from last month</span>
            </div>
          </div>
        </div>


   <!-- <?php


$product_query = "SELECT * FROM products";
$product_run = mysqli_query($conn,$product_query);

$total_products = mysqli_num_rows($product_run);

$view_all =
isset($_GET['view']) &&
$_GET['view'] == 'all';

$active_query =
"SELECT * FROM products WHERE status=1";

if(!$view_all){

    $active_query .= " LIMIT 5";

}

$active_run =
mysqli_query($conn,$active_query);

$active_products =
mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM products WHERE status=1")
);



$inactive_query =
"SELECT * FROM products WHERE status=0";

if(!$view_all){

    $inactive_query .= " LIMIT 5";

}

$inactive_run =
mysqli_query($conn,$inactive_query);

$inactive_products =
mysqli_num_rows(
mysqli_query($conn,
"SELECT * FROM products WHERE status=0")
);

?> -->


<?php
$active_products = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as c FROM products WHERE status=1"))['c'];

$inactive_products = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as c FROM products WHERE status=0"))['c'];
?>




<div class="table-card mb-4">

<div class="card-title d-flex justify-content-between align-items-center">

<h3 style="font-weight:700;">

<i class="fas fa-cube"></i>
Product Analytics

</h3>
<?php
$view_all =
isset($_GET['view']) &&
$_GET['view'] == 'all';
?>



<a href="?view=<?php echo $view_all ? 'less' : 'all'; ?>"
   style="
   text-decoration:none;
   font-weight:600;
   padding:10px 18px;
   background:#f4f4f4;
   border-radius:12px;
   color:#111;
">
   <?php echo $view_all ? 'Show Less' : 'View All'; ?>
</a>

</div>



<div class="row p-4 g-4">


<!-- <div class="col-md-6">

<div class="stat-card"

      style="
      border:none;
      border-radius:25px;
      background:linear-gradient(135deg,#f6fff8,#eafff0);
      box-shadow:0 10px 25px rgba(0,0,0,0.08);
      ">

      <div class="card-header">

      <div>

      <h1
      style="
      font-size:40px;
      font-weight:800;
      color:#0f9d58;
      margin:0;
      ">

      <?php echo $active_products; ?>

      </h1>

      <p
      style="
      margin:0;
      font-weight:600;
      color:#555;
      ">

      Active Products

      </p>

      </div>

      <div class="card-icon green">

      <i class="fas fa-check-circle"></i>

      </div>

      </div>

      <hr>

      <?php
      while($active = mysqli_fetch_assoc($active_run)){
      ?>

      <div

      style="
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:12px;
      background:#fff;
      border-radius:18px;
      margin-bottom:15px;
      box-shadow:0 4px 15px rgba(0,0,0,0.06);
      ">

      <div
      style="
      display:flex;
      align-items:center;
      gap:15px;
      ">

<img
src="../images/<?php echo $active['image']; ?>"

style="
width:70px;
height:70px;
object-fit:cover;
border-radius:16px;
border:3px solid #d4ffe0;
">

<div>

<h5
style="
margin:0;
font-weight:700;
">

<?php echo $active['name']; ?>

</h5>

<p
style="
margin:0;
color:#666;
font-size:14px;
">

₹<?php echo $active['price']; ?>

</p>

</div>

</div>

<span
style="
display:inline-flex;
align-items:center;
gap:6px;
background:#ecfdf3;
color:#067647;
border:1px solid #abefc6;
padding:7px 14px;
border-radius:999px;
font-size:12px;
font-weight:600;
">
<i class='fas fa-circle' style='font-size:8px;'></i>
Published
</span>

</div>

<?php } ?>

</div>

</div> -->




<!-- replace -->

<!-- <div class="col-md-6">

<h2 style="margin-bottom:10px;">Active Products</h2>



<select id="limit_active"
onchange="loadProducts('active')"
style="padding:8px;">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
</select>

<div id="active_container"></div>


</div> -->


<!-- replace end -->








<!-- <div class="col-md-6">

<div class="stat-card"

style="
border:none;
border-radius:25px;
background:linear-gradient(135deg,#fff7f7,#ffecec);
box-shadow:0 10px 25px rgba(0,0,0,0.08);
">

<div class="card-header">

<div>

<h1
style="
font-size:40px;
font-weight:800;
color:#d93025;
margin:0;
">

<?php echo $inactive_products; ?>

</h1>

<p
style="
margin:0;
font-weight:600;
color:#555;
">

Inactive Products

</p>

</div>

<div class="card-icon orange">

<i class="fas fa-times-circle"></i>

</div>

</div>

<hr>

<?php
while($inactive = mysqli_fetch_assoc($inactive_run)){
?>

<div

style="
display:flex;
align-items:center;
justify-content:space-between;
padding:12px;
background:#fff;
border-radius:18px;
margin-bottom:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.06);
">

<div
style="
display:flex;
align-items:center;
gap:15px;
">

<img
src="../images/<?php echo $inactive['image']; ?>"

style="
width:70px;
height:70px;
object-fit:cover;
border-radius:16px;
border:3px solid #ffd7d7;
">

<div>

<h5
style="
margin:0;
font-weight:700;
">

<?php echo $inactive['name']; ?>

</h5>

<p
style="
margin:0;
color:#666;
font-size:14px;
">

₹<?php echo $inactive['price']; ?>

</p>

</div>

</div>

<span
style="
display:inline-flex;
align-items:center;
gap:6px;
background:#f8f9fc;
color:#667085;
border:1px solid #d0d5dd;
padding:7px 14px;
border-radius:999px;
font-size:12px;
font-weight:600;
">
<i class='fas fa-circle' style='font-size:8px;'></i>
Draft
</span>

</div>

<?php } ?>

</div>

</div> -->



<!-- rechange -->


<!-- <div class="col-md-6">

<h2>Inactive Products</h2>


<select id="limit_inactive" onchange="loadProducts('inactive')">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
</select>

<div id="inactive_container"></div>

</div>

</div>

</div> -->

<!-- rechange end -->






<?php

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page-1) * $limit;

$total_products = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM products
"));

$total_products = $total_products['total'];

$total_pages = ceil($total_products / $limit);

$product_query = mysqli_query($conn,"
SELECT *
FROM products
ORDER BY id DESC
LIMIT $start,$limit
");

?>

<div class="table-card">



<div class="table-responsive">

<table class="data-table">

<thead>

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php
while($row=mysqli_fetch_assoc($product_query)){
?>

<tr>

<td>

<img src="../images/<?php echo $row['image'];?>"
width="60"
style="border-radius:10px;">

</td>

<td><?php echo $row['name']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['stock']; ?></td>

<td>

<?php
if($row['status']==1){
?>
<span class="badge bg-success">Active</span>
<?php
}else{
?>
<span class="badge bg-danger">Inactive</span>
<?php
}
?>

</td>

<td>

<a href="admin_view_product.php?id=<?=$row['id']?>">

<i class="fas fa-eye"></i></a>

<a href="edit_product.php?id=<?=$row['id']?>">

<i class="fas fa-edit"></i>

</a>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</div>

<div class="pagination-box">

<?php

if($page>1){

echo "<a class='prev-next' href='?page=".($page-1)."'>
<i class='fas fa-angle-left'></i>&nbsp;Prev
</a>";

}

for($i=1;$i<=$total_pages;$i++){

if($i==$page){

echo "<span class='active-page'>$i</span>";

}else{

echo "<a href='?page=$i'>$i</a>";

}

}

if($page<$total_pages){

echo "<a class='prev-next' href='?page=".($page+1)."'>
Next&nbsp;<i class='fas fa-angle-right'></i>
</a>";

}

?>

</div>


<?php
/* =========================================
   ADMIN MANAGE TIMETABLE
========================================= */

$weekDays = [
    [
        'name' => 'Monday',
        'short' => 'MON',
        'status' => 'open',
        'open' => '08:00 AM',
        'close' => '11:00 PM'
    ],
    [
        'name' => 'Tuesday',
        'short' => 'TUE',
        'status' => 'open',
        'open' => '08:00 AM',
        'close' => '11:00 PM'
    ],
    [
        'name' => 'Wednesday',
        'short' => 'WED',
        'status' => 'closed',
        'open' => '',
        'close' => ''
    ],
    [
        'name' => 'Thursday',
        'short' => 'THU',
        'status' => 'open',
        'open' => '09:00 AM',
        'close' => '10:00 PM'
    ],
    [
        'name' => 'Friday',
        'short' => 'FRI',
        'status' => 'open',
        'open' => '08:00 AM',
        'close' => '11:00 PM'
    ],
    [
        'name' => 'Saturday',
        'short' => 'SAT',
        'status' => 'open',
        'open' => '09:00 AM',
        'close' => '11:30 PM'
    ],
    [
        'name' => 'Sunday',
        'short' => 'SUN',
        'status' => 'closed',
        'open' => '',
        'close' => ''
    ]
];


/*
|--------------------------------------------------------------------------
| Current week's Monday
|--------------------------------------------------------------------------
*/

$monday = new DateTime('monday this week');

foreach ($weekDays as $index => &$day) {

    $date = clone $monday;

    if ($index > 0) {
        $date->modify("+".$index." day");
    }

    $day['date'] = $date->format('d F Y');
    $day['date_value'] = $date->format('Y-m-d');
}

unset($day);
?>


<!-- =========================================
     ADMIN MANAGE TIMETABLE
========================================= -->

<div class="table-card timetable-card" id="adminTimetable">


    <!-- HEADER -->

    <div class="timetable-header">

        <div class="timetable-title">

            <div class="timetable-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>

            <div>

                <h3>
                    Manage Timetable
                </h3>

                <p>
                    Manage your café schedule, reservations and special events.
                </p>

            </div>

        </div>


        <div class="timetable-actions">

            <button type="button"
                    class="schedule-btn"
                    id="addScheduleBtn">

                <i class="fas fa-plus"></i>

                Add Schedule

            </button>


            <button type="button"
                    class="calendar-btn"
                    id="weeklyViewBtn">

                <i class="fas fa-calendar"></i>

                Weekly View

            </button>

        </div>

    </div>


    <!-- =====================================
         SUMMARY
    ====================================== -->

    <div class="timetable-summary">


        <div class="time-stat">

            <div class="time-stat-icon">

                <i class="fas fa-clock"></i>

            </div>

            <div>

                <span>
                    Today's Hours
                </span>

                <strong id="todayHours">
                    --
                </strong>

            </div>

        </div>


        <div class="time-stat">

            <div class="time-stat-icon">

                <i class="fas fa-users"></i>

            </div>

            <div>

                <span>
                    Today's Reservations
                </span>

                <strong>
                    24 Bookings
                </strong>

            </div>

        </div>


        <div class="time-stat">

            <div class="time-stat-icon">

                <i class="fas fa-calendar-check"></i>

            </div>

            <div>

                <span>
                    Upcoming Events
                </span>

                <strong>
                    3 Events
                </strong>

            </div>

        </div>

    </div>


    <!-- =====================================
         FULL WEEK
    ====================================== -->

    <div class="schedule-list" id="timetableWeeklyList">


        <?php foreach ($weekDays as $index => $day): ?>

            <?php
            $isOpen = ($day['status'] === 'open');

            $rowClass = $isOpen
                ? 'schedule-day'
                : 'schedule-day closed';

            $statusClass = $isOpen
                ? 'schedule-status open'
                : 'schedule-status closed-status';
            ?>


            <div class="<?= $rowClass ?>"

                 data-day="<?= htmlspecialchars($day['name']) ?>"

                 data-date="<?= htmlspecialchars($day['date_value']) ?>"

                 data-status="<?= htmlspecialchars($day['status']) ?>"

                 data-open="<?= htmlspecialchars($day['open']) ?>"

                 data-close="<?= htmlspecialchars($day['close']) ?>">


                <!-- DAY -->

                <div class="day-info">

                    <div class="day-circle">

                        <?= $day['short'] ?>

                    </div>


                    <div>

                        <h4>
                            <?= htmlspecialchars($day['name']) ?>
                        </h4>

                        <p>
                            <?= htmlspecialchars($day['date']) ?>
                        </p>

                    </div>

                </div>


                <!-- TIME -->

                <div class="schedule-time">

                    <?php if ($isOpen): ?>

                        <i class="fas fa-sun"></i>

                        <span class="open-time">
                            <?= htmlspecialchars($day['open']) ?>
                        </span>

                        <b>–</b>

                        <span class="close-time">
                            <?= htmlspecialchars($day['close']) ?>
                        </span>

                    <?php else: ?>

                        <i class="fas fa-moon"></i>

                        <span>
                            Closed
                        </span>

                    <?php endif; ?>

                </div>


                <!-- STATUS -->

                <span class="<?= $statusClass ?>">

                    <i class="fas fa-circle"></i>

                    <span class="status-text">

                        <?= $isOpen ? 'Open' : 'Closed' ?>

                    </span>

                </span>


                <!-- EDIT -->

                <div class="schedule-edit">

                    <button type="button"
                            class="edit-schedule-btn"
                            title="Edit Schedule">

                        <i class="fas fa-pen"></i>

                    </button>

                </div>


            </div>

        <?php endforeach; ?>


    </div>

</div>



<!-- =========================================
     EDIT SCHEDULE MODAL
========================================= -->

<div class="schedule-modal"
     id="scheduleModal">


    <div class="schedule-modal-box">


        <!-- HEADER -->

        <div class="schedule-modal-header">

            <div>

                <h3>

                    <i class="fas fa-calendar-alt"></i>

                    Edit Schedule

                </h3>

                <p id="modalDayName">
                    Schedule
                </p>

            </div>


            <button type="button"
                    class="modal-close"
                    id="closeScheduleModal">

                <i class="fas fa-times"></i>

            </button>

        </div>


        <!-- BODY -->

        <div class="schedule-modal-body">


            <!-- STATUS -->

            <div class="form-group">

                <label>
                    Schedule Status
                </label>


                <div class="status-switch">


                    <button type="button"
                            class="status-option active"
                            id="openOption">

                        <i class="fas fa-door-open"></i>

                        Open

                    </button>


                    <button type="button"
                            class="status-option"
                            id="closedOption">

                        <i class="fas fa-door-closed"></i>

                        Closed

                    </button>


                </div>

            </div>


            <!-- TIME -->

            <div class="time-input-row">


                <div class="form-group">

                    <label>
                        Opening Time
                    </label>

                    <input type="time"
                           id="scheduleOpenTime">

                </div>


                <div class="time-divider">
                    to
                </div>


                <div class="form-group">

                    <label>
                        Closing Time
                    </label>

                    <input type="time"
                           id="scheduleCloseTime">

                </div>


            </div>


        </div>


        <!-- FOOTER -->

        <div class="schedule-modal-footer">


            <button type="button"
                    class="cancel-schedule"
                    id="cancelSchedule">

                Cancel

            </button>


            <button type="button"
                    class="save-schedule"
                    id="saveSchedule">

                <i class="fas fa-check"></i>

                Save Changes

            </button>


        </div>


    </div>

</div>



<?php
/* =========================
   RECENT ORDERS (AJAX READY)
========================= */
?>

<div class="table-card">

<div class="card-title d-flex justify-content-between align-items-center">

<h3 style="font-weight:700;">
<i class="fas fa-shopping-bag"></i>
Recent Orders
</h3>

<a href="order_list.php"
style="
text-decoration:none;
padding:10px 18px;
background:#111;
color:#fff;
border-radius:12px;
font-weight:600;
">
View All
</a>

</div>

<div class="table-responsive">

<table class="data-table">

<thead>
<tr>
<th>Image</th>
<th>Customer</th>
<th>Product</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Date</th>
</tr>
</thead>

<tbody id="orders_container">
<!-- AJAX DATA WILL LOAD HERE -->
 
</tbody>

</table>

</div>

<div id="orders_pagination" style="margin-top:15px;"></div>

</div>

</div>

</div>


<script>

function loadProducts(type, page = 1){

    let limit = $("#limit_" + type).val();

    $.ajax({
        url: "product_ajax.php",
        type: "POST",
        data: {
            type: type,
            page: page,
            search: <?= json_encode($search) ?>,
            limit: limit
        },
        success: function(res){
            $("#" + type + "_container").html(res);
        },
        error: function(xhr){
            console.log("Product AJAX Error:");
            console.log(xhr.responseText);
        }
    });

}

function loadOrders(page = 1){

    $.ajax({
        url: "orders_ajax.php",
        type: "POST",
        data: {
            page: page
        },
        dataType: "json",

        success: function(res){

            $("#orders_container").html(res.data);
            $("#orders_pagination").html(res.pagination);

        },

        error: function(xhr){

            console.log("Order AJAX Error:");
            console.log(xhr.responseText);

        }
    });

}

$(document).ready(function(){

    // Active Products
    loadProducts('active',1);

    // Inactive Products
    loadProducts('inactive',1);

    // Recent Orders
    loadOrders(1);

});

/* Product Pagination */
$(document).on("click", ".pg-btn", function(){

    let type = $(this).data("type");
    let page = $(this).data("page");

    loadProducts(type, page);

});

/* Order Pagination */
$(document).on("click", ".order-pg-btn", function(){

    let page = $(this).data("page");

    loadOrders(page);

});









/* =========================================
   ADMIN TIMETABLE JAVASCRIPT
========================================= */

document.addEventListener("DOMContentLoaded", function () {


    let selectedSchedule = null;
    let selectedStatus = "open";


    const modal =
        document.getElementById("scheduleModal");

    const openOption =
        document.getElementById("openOption");

    const closedOption =
        document.getElementById("closedOption");

    const openTime =
        document.getElementById("scheduleOpenTime");

    const closeTime =
        document.getElementById("scheduleCloseTime");

    const modalDayName =
        document.getElementById("modalDayName");


    /* =====================================
       OPEN MODAL
    ===================================== */

    document.querySelectorAll(".edit-schedule-btn")
        .forEach(function(button) {

            button.addEventListener("click", function () {

                selectedSchedule =
                    this.closest(".schedule-day");


                if (!selectedSchedule) {
                    return;
                }


                /* Day */

                const day =
                    selectedSchedule.dataset.day;

                modalDayName.textContent =
                    day;


                /* Status */

                selectedStatus =
                    selectedSchedule.dataset.status || "open";


                /* Time */

                const open =
                    selectedSchedule.dataset.open;

                const close =
                    selectedSchedule.dataset.close;


                if (open) {

                    openTime.value =
                        convertTo24Hour(open);

                } else {

                    openTime.value =
                        "08:00";

                }


                if (close) {

                    closeTime.value =
                        convertTo24Hour(close);

                } else {

                    closeTime.value =
                        "23:00";

                }


                updateStatusButtons();


                modal.classList.add("show");

            });

        });


    /* =====================================
       OPEN STATUS
    ===================================== */

    openOption.addEventListener("click", function () {

        selectedStatus = "open";

        updateStatusButtons();

    });


    /* =====================================
       CLOSED STATUS
    ===================================== */

    closedOption.addEventListener("click", function () {

        selectedStatus = "closed";

        updateStatusButtons();

    });


    /* =====================================
       STATUS BUTTON UI
    ===================================== */

    function updateStatusButtons() {

        openOption.classList.remove("active");

        closedOption.classList.remove("active");


        if (selectedStatus === "open") {

            openOption.classList.add("active");

        } else {

            closedOption.classList.add("active");

        }

    }


    /* =====================================
       SAVE
    ===================================== */

    document
        .getElementById("saveSchedule")
        .addEventListener("click", function () {


            if (!selectedSchedule) {
                return;
            }


            /* CLOSED */

            if (selectedStatus === "closed") {


                selectedSchedule.dataset.status =
                    "closed";

                selectedSchedule.dataset.open =
                    "";

                selectedSchedule.dataset.close =
                    "";


                selectedSchedule.classList.add("closed");


                /* Time */

                const timeBox =
                    selectedSchedule
                        .querySelector(".schedule-time");


                timeBox.innerHTML = `

                    <i class="fas fa-moon"></i>

                    <span>
                        Closed
                    </span>

                `;


                /* Status */

                const statusBox =
                    selectedSchedule
                        .querySelector(".schedule-status");


                statusBox.className =
                    "schedule-status closed-status";


                statusBox.innerHTML = `

                    <i class="fas fa-circle"></i>

                    <span class="status-text">
                        Closed
                    </span>

                `;


            }


            /* OPEN */

            else {


                if (!openTime.value ||
                    !closeTime.value) {

                    alert(
                        "Please select opening and closing time."
                    );

                    return;

                }


                if (openTime.value >= closeTime.value) {

                    alert(
                        "Closing time must be later than opening time."
                    );

                    return;

                }


                const formattedOpen =
                    formatTime(openTime.value);

                const formattedClose =
                    formatTime(closeTime.value);


                selectedSchedule.dataset.status =
                    "open";

                selectedSchedule.dataset.open =
                    formattedOpen;

                selectedSchedule.dataset.close =
                    formattedClose;


                selectedSchedule.classList.remove("closed");


                /* Time */

                const timeBox =
                    selectedSchedule
                        .querySelector(".schedule-time");


                timeBox.innerHTML = `

                    <i class="fas fa-sun"></i>

                    <span class="open-time">
                        ${formattedOpen}
                    </span>

                    <b>–</b>

                    <span class="close-time">
                        ${formattedClose}
                    </span>

                `;


                /* Status */

                const statusBox =
                    selectedSchedule
                        .querySelector(".schedule-status");


                statusBox.className =
                    "schedule-status open";


                statusBox.innerHTML = `

                    <i class="fas fa-circle"></i>

                    <span class="status-text">
                        Open
                    </span>

                `;

            }


            updateTodayHours();

            closeModal();

        });


    /* =====================================
       CLOSE MODAL
    ===================================== */

    function closeModal() {

        modal.classList.remove("show");

        selectedSchedule = null;

    }


    document
        .getElementById("closeScheduleModal")
        .addEventListener("click", closeModal);


    document
        .getElementById("cancelSchedule")
        .addEventListener("click", closeModal);


    /* Click outside */

    modal.addEventListener("click", function(e) {

        if (e.target === modal) {

            closeModal();

        }

    });


    /* ESC */

    document.addEventListener("keydown", function(e) {

        if (e.key === "Escape") {

            closeModal();

        }

    });


    /* =====================================
       WEEKLY VIEW
    ===================================== */

    document
        .getElementById("weeklyViewBtn")
        .addEventListener("click", function() {

            document
                .getElementById("timetableWeeklyList")
                .scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

        });


    /* =====================================
       ADD SCHEDULE
    ===================================== */

    document
        .getElementById("addScheduleBtn")
        .addEventListener("click", function() {

            /*
             * প্রথমে Monday edit করবে।
             * পরে চাইলে এখানে Add New Schedule
             * database functionality করা যাবে।
             */

            const firstDay =
                document.querySelector(".schedule-day");


            if (firstDay) {

                const editButton =
                    firstDay.querySelector(
                        ".edit-schedule-btn"
                    );


                if (editButton) {

                    editButton.click();

                }

            }

        });


    /* =====================================
       TIME FORMAT
    ===================================== */

    function formatTime(time) {

        let parts =
            time.split(":");

        let hours =
            parseInt(parts[0]);

        let minutes =
            parts[1];


        let period =
            hours >= 12
                ? "PM"
                : "AM";


        let displayHour =
            hours % 12 || 12;


        return (
            String(displayHour).padStart(2, "0")
            + ":"
            + minutes
            + " "
            + period
        );

    }


    /* =====================================
       CONVERT 12H -> 24H
    ===================================== */

    function convertTo24Hour(time) {

        if (!time) {
            return "";
        }


        const parts =
            time.trim().split(" ");


        const hm =
            parts[0].split(":");


        let hours =
            parseInt(hm[0]);

        const minutes =
            hm[1];


        const period =
            parts[1];


        if (period === "PM" && hours !== 12) {

            hours += 12;

        }


        if (period === "AM" && hours === 12) {

            hours = 0;

        }


        return (
            String(hours).padStart(2, "0")
            + ":"
            + minutes
        );

    }


    /* =====================================
       TODAY HOURS
    ===================================== */

    function updateTodayHours() {

        const today =
            new Date();


        const dayIndex =
            today.getDay();


        /*
         * JS:
         * Sunday = 0
         * Monday = 1
         * ...
         */


        let index =
            dayIndex === 0
                ? 6
                : dayIndex - 1;


        const rows =
            document.querySelectorAll(".schedule-day");


        if (!rows[index]) {
            return;
        }


        const row =
            rows[index];


        const status =
            row.dataset.status;


        const todayHours =
            document.getElementById("todayHours");


        if (status === "closed") {

            todayHours.textContent =
                "Closed";

        } else {

            todayHours.textContent =
                row.dataset.open
                + " – "
                + row.dataset.close;

        }

    }


    /* Initial */

    updateTodayHours();


});

</script>
  </body>
</html>