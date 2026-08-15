<?php
session_start();
include "includes/db_connect.php";
include "function.php";
global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subcategory List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="weblogo.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"/>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="admin_panel.css">

    <style>
        /*==========================================
      PREMIUM SUBCATEGORY PAGE
==========================================*/

body{

background:#eef4fb;

font-family:Poppins,sans-serif;

}

.main-content{

margin:25px 20px 25px 300px;

width:calc(100% - 320px);

animation:fadePage .8s;

}

body{

overflow-x:hidden;

}

.subcategory-card{

overflow:hidden;

}

.table-responsive{

overflow-x:hidden;

}

/*================ HERO =================*/

.subcategory-hero{

display:flex;

justify-content:space-between;

align-items:center;

padding:35px;

margin-bottom:30px;

border-radius:28px;

background:
linear-gradient(135deg,#0f172a,#1d4ed8,#2563eb);

color:#fff;

overflow:hidden;

position:relative;

box-shadow:

0 25px 60px rgba(37,99,235,.28);

}

.subcategory-hero::before{

content:"";

position:absolute;

right:-70px;

top:-70px;

width:240px;

height:240px;

background:rgba(255,255,255,.08);

border-radius:50%;

}

.subcategory-hero::after{

content:"";

position:absolute;

left:-80px;

bottom:-80px;

width:180px;

height:180px;

background:rgba(255,255,255,.06);

border-radius:50%;

}

.subcategory-hero h2{

font-size:34px;

font-weight:700;

margin-bottom:10px;

position:relative;

z-index:2;

}

.subcategory-hero p{

font-size:15px;

opacity:.9;

margin:0;

position:relative;

z-index:2;

}

/*================ ADD BUTTON =================*/

.premium-add-btn{

padding:14px 28px;

border-radius:15px;

text-decoration:none;

font-weight:600;

color:#fff;

background:

linear-gradient(135deg,#06b6d4,#2563eb);

transition:.35s;

box-shadow:

0 15px 35px rgba(0,0,0,.25);

position:relative;

z-index:2;

display:inline-flex;

align-items:center;

gap:10px;

}

.premium-add-btn:hover{

color:#fff;

transform:translateY(-4px);

box-shadow:

0 20px 45px rgba(37,99,235,.45);

background:

linear-gradient(135deg,#0284c7,#1d4ed8);

}

/*================ CONTENT CARD =================*/

.subcategory-card{

background:#fff;

border-radius:28px;

padding:30px;

box-shadow:

0 18px 45px rgba(15,23,42,.08);

border:1px solid #eef2f7;

overflow:hidden;

animation:cardUp .8s;

}

/*================ TABLE =================*/

.table{

margin-bottom:0;

border-collapse:separate;

border-spacing:0;

}

/* .table thead tr{

background-image: linear-gradient(135deg, #0f172a, #1e3a8a);

} */

.table thead th{

color:#000;

padding:18px;

border:none;

font-size:14px;

font-weight:600;

letter-spacing:.4px;

white-space:nowrap;

}

.table tbody td{

padding:16px 5px;

vertical-align:middle;

border-bottom:1px solid #edf2f7;

transition:.35s;

}

.table tbody tr{

transition:.35s;

}

.table tbody tr:hover{

background:#f8fbff;

transform:scale(1.01);

box-shadow:

0 8px 25px rgba(0,0,0,.06);

}

/*==========================================
        PREMIUM STATS
==========================================*/

.stats-grid{

display:grid;

grid-template-columns:repeat(auto-fit,minmax(230px,1fr));

gap:22px;

margin-bottom:30px;

}

.stat-card{

position:relative;

overflow:hidden;

background:#fff;

border-radius:24px;

padding:28px;

display:flex;

align-items:center;

gap:20px;

transition:.35s;

box-shadow:

0 15px 40px rgba(15,23,42,.08);

border:1px solid #edf2f7;

}

.stat-card:hover{

transform:translateY(-8px);

box-shadow:

0 25px 55px rgba(0,0,0,.14);

}

.stat-card::before{

content:"";

position:absolute;

right:-30px;

top:-30px;

width:120px;

height:120px;

border-radius:50%;

opacity:.12;

}

.total-card::before{

background:#2563eb;

}

.active-card::before{

background:#16a34a;

}

.inactive-card::before{

background:#ef4444;

}

.category-card::before{

background:#7c3aed;

}

.stat-icon{

width:75px;

height:75px;

border-radius:20px;

display:flex;

justify-content:center;

align-items:center;

font-size:30px;

color:#fff;

flex-shrink:0;

}

.total-card .stat-icon{

background:linear-gradient(135deg,#2563eb,#1d4ed8);

}

.active-card .stat-icon{

background:linear-gradient(135deg,#22c55e,#15803d);

}

.inactive-card .stat-icon{

background:linear-gradient(135deg,#ef4444,#b91c1c);

}

.category-card .stat-icon{

background:linear-gradient(135deg,#8b5cf6,#6d28d9);

}

.stat-info{

flex:1;

}

.stat-info h3{

font-size:34px;

font-weight:700;

margin-bottom:4px;

color:#0f172a;

}

.stat-info p{

margin:0;

font-size:15px;

font-weight:500;

color:#64748b;

}

/*==================================
     PREMIUM TABLE
==================================*/

.premium-table{

border-collapse:separate;

border-spacing:0;

}

.table-id{

padding:8px ;

background:#eff6ff;

border-radius:30px;

font-weight:700;

color:#2563eb;

}

.category-box{

display:flex;

align-items:center;

gap:14px;

}

.category-icon{

width:52px;

height:52px;

border-radius:16px;

display:flex;

justify-content:center;

align-items:center;

background:linear-gradient(135deg,#2563eb,#60a5fa);

color:#fff;

font-size:22px;

}

.subcategory-name{

font-weight:600;

font-size:15px;

color:#0f172a;

}

.description-box{

max-width:220px;

white-space:nowrap;

overflow:hidden;

text-overflow:ellipsis;

color:#64748b;

}

.subcategory-image{

width:85px;

height:85px;

border-radius:18px;

object-fit:cover;

transition:.35s;

box-shadow:0 10px 25px rgba(0,0,0,.12);

}

.subcategory-image:hover{

transform:scale(1.12);

}

.price-tag{

display:inline-block;

padding:10px 18px;

border-radius:40px;

font-weight:700;

background:#dcfce7;

color:#15803d;

}

.status-badge{

padding:8px 18px;

border-radius:30px;

font-size:13px;

font-weight:600;

display:inline-flex;

align-items:center;

gap:8px;

}

.status-badge.active{

background:#dcfce7;

color:#15803d;

}

.status-badge.inactive{

background:#fee2e2;

color:#dc2626;

}

.action-buttons{

display:flex;

gap:12px;

}

.edit-btn,

.delete-btn{

width:35px;

height:35px;

border-radius:14px;

display:flex;

justify-content:center;

align-items:center;

text-decoration:none;

color:#fff;

transition:.3s;

}

.edit-btn{

background:linear-gradient(135deg,#2563eb,#1d4ed8);

}

.delete-btn{

background:linear-gradient(135deg,#ef4444,#dc2626);

}

.edit-btn:hover,

.delete-btn:hover{

transform:translateY(-5px) scale(1.08);

color:#fff;

box-shadow:0 12px 28px rgba(0,0,0,.2);

}



/* ===========================
   PREMIUM TABLE HEADER
=========================== */

.premium-head{

background:linear-gradient(135deg,#0F172A,#1E3A8A,#2563EB);


}

.premium-head th{

background:transparent !important;

color:#fff !important;

padding:18px 14px;
font-size:13px;

font-weight:700;

text-transform:uppercase;

letter-spacing:.7px;

text-align:center;

border:none;

white-space:nowrap;

position:relative;

}

/* Premium separator */
.premium-head th:not(:last-child)::after{

content:"";

position:absolute;

top:20%;

right:0;

width:1px;

height:60%;

background:rgba(255,255,255,.25);

}

/* Rounded corners */
.premium-head th:first-child{

border-radius:18px 0 0 0;

}

.premium-head th:last-child{

border-radius:0 18px 0 0;

}

/* Header icons */
.premium-head i{

margin-right:6px;

color:#60A5FA;

font-size:5px;

}


    </style>
</head>

<body>
<?php
/** @var mysqli $conn */

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$offset = ($page - 1) * $limit;

$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn,$_GET['search'])
    : '';

/* TOTAL RECORDS */
$total_sql = "
SELECT COUNT(*) as total
FROM subcategories s
JOIN categories c
ON s.category_id = c.id
WHERE 1
";

if($search != ''){
    $total_sql .= "
    AND (
        s.name LIKE '%$search%'
        OR s.descri LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR s.price LIKE '%$search%'
    )
    ";
}

$total_query = mysqli_query($conn,$total_sql);
$total_row = mysqli_fetch_assoc($total_query);

$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

if($total_pages < 1){
    $total_pages = 1;
}

/* MAIN QUERY */
$sql = "
SELECT
    s.id,
    s.category_id,
    c.name AS category_name,
    s.name,
    s.descri,
    s.image,
    s.price,
    s.status,
    s.create_at
FROM subcategories s
JOIN categories c
ON s.category_id = c.id
WHERE 1
";

if($search != ''){
    $sql .= "
    AND (
        s.name LIKE '%$search%'
        OR s.descri LIKE '%$search%'
        OR c.name LIKE '%$search%'
        OR s.price LIKE '%$search%'
    )
    ";
}

$sql .= "
ORDER BY s.id ASC
LIMIT $offset,$limit
";

$res = mysqli_query($conn,$sql);

if(!$res){
    die(mysqli_error($conn));
}
?>


<div class="container" style="margin-left:-1%; min-width:102%;">

    <!-- Sidebar + Header -->
    <?php include "sidebar.php"; ?>
    <?php include "header.php"; ?>
    <div class="">

    </div>
    </div>

</div>

<!-- ================= TABLE ================= -->
<!-- <div class="table-responsive" style="margin:2% 19%; width:80%;"> -->

<div class="main-content">

<div class="subcategory-hero">

<div>

<h2>
<i class="fa-solid fa-layer-group"></i>
Subcategory Management
</h2>

<p>
Manage all product subcategories from one premium enterprise dashboard.
</p>

</div>



</div>


<?php

$totalSub=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM subcategories
"));

// $activeSub=mysqli_fetch_assoc(mysqli_query($conn,"
// SELECT COUNT(*) total
// FROM subcategories
// WHERE status=1
// "));

$activeSub=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM products
WHERE status=1
"));

// $inactiveSub=mysqli_fetch_assoc(mysqli_query($conn,"
// SELECT COUNT(*) total
// FROM subcategories
// WHERE status=0
// "));
$inactiveSub=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM products
WHERE status=0
"));

$totalCategory=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM categories
"));

?>

<div class="stats-grid">

<div class="stat-card total-card">

<div class="stat-icon">
<i class="fas fa-layer-group"></i>
</div>

<div class="stat-info">

<h3>

<?php echo $totalSub['total']; ?>

</h3>

<p>Total Subcategories</p>

</div>

</div>


<div class="stat-card active-card">

<div class="stat-icon">
<i class="fas fa-check-circle"></i>
</div>

<div class="stat-info">

<h3>

<?php echo $activeSub['total']; ?>

</h3>

<p>Active</p>

</div>

</div>


<div class="stat-card inactive-card">

<div class="stat-icon">
<i class="fas fa-ban"></i>
</div>

<div class="stat-info">

<h3>

<?php echo $inactiveSub['total']; ?>

</h3>

<p>Inactive</p>

</div>

</div>


<div class="stat-card category-card">

<div class="stat-icon">
<i class="fas fa-folder-tree"></i>
</div>

<div class="stat-info">

<h3>

<?php echo $totalCategory['total']; ?>

</h3>

<p>Main Categories</p>

</div>

</div>

</div>




    <!-- <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="title">Subcategory Details</h1>

        <a href="add_subcategory.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div> -->

    <!-- <table class="table table-bordered table-striped"> -->
        <div class="subcategory-card">

<div class="table-responsive">

<table class="table premium-table align-middle">

<!-- <thead>

<tr>

<th>ID</th>

<th>Category</th>

<th>Subcategory</th>

<th>Description</th>

<th>Image</th>

<th>Price</th>

<th>Status</th>

<th>Created</th>

<th>Action</th>

</tr>

</thead> -->

<thead class="premium-head">
<tr>

<th>ID</th>

<th>Category</th>

<th>Subcategory</th>

<th>Description</th>

<th>Image</th>

<th>Price</th>

<th>Status</th>

<th>Created</th>

<th>Action</th>

</tr>
</thead>



 <tbody>

        <?php if(mysqli_num_rows($res) > 0){ ?>

            <?php while($row = mysqli_fetch_assoc($res)){ ?>

          <tr>

<td>

<span class="table-id">

#<?php echo $row['id']; ?>

</span>

</td>

<td>

<div class="category-box">



<div>

<b>

<?php echo $row['category_name']; ?>

</b>




</div>

</div>

</td>

<td>

<div class="subcategory-name">

<?php echo $row['name']; ?>

</div>

</td>

<td>

<div class="description-box">

<?php echo $row['descri']; ?>

</div>

</td>

<td>

<img

src="<?php echo !empty($row['image']) ? '../images/'.$row['image'] : '../images/default.avif'; ?>"

class="subcategory-image"

>

</td>

<td>

<div class="price-tag">

₹<?php echo number_format($row['price']); ?>

</div>

</td>

<td>

<?php

if($row['status']==1){

?>

<span class="status-badge active">

<i class="fas fa-circle"></i>

Active

</span>

<?php

}else{

?>

<span class="status-badge inactive">

<i class="fas fa-circle"></i>

Inactive

</span>

<?php } ?>

</td>

<td>

<?php

echo !empty($row['create_at'])

? date("d M Y",strtotime($row['create_at']))

: "-";

?>

</td>

<td>

<div class="action-buttons">

<a

href="edit_subcategory.php?id=<?php echo $row['id']; ?>"

class="edit-btn"

>

<i class="fas fa-pen"></i>

</a>

<a

href="delete_action.php?type=subcategories&id=<?php echo $row['id']; ?>"

class="delete-btn"

onclick="return confirm('Delete this Subcategory?')"

>

<i class="fas fa-trash"></i>

</a>

</div>

</td>

</tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="10" class="text-center text-danger">
                    No Subcategories Found
                </td>
            </tr>

        <?php } ?>

        </tbody> 


        

</table>

</div>

</div>


    <div class="text-center mt-4 mb-4">

<?php if($page > 1){ ?>
    <a class="btn btn-primary"
       href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">
        ← Previous
    </a>
<?php } ?>

<?php for($p=1; $p<=$total_pages; $p++){ ?>

    <a class="btn <?php echo ($p==$page)?'btn-dark':'btn-outline-primary'; ?>"
       href="?page=<?php echo $p; ?>&search=<?php echo urlencode($search); ?>">
        <?php echo $p; ?>
    </a>

<?php } ?>

<?php if($page < $total_pages){ ?>
    <a class="btn btn-primary"
       href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">
        Next →
    </a>
<?php } ?>

</div>


</div>

<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>