<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    include("includes/db_connect.php");
include("function.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>

    <link rel="icon" type="image/png" href="weblogo.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"/>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="admin_panel.css">
<style>
    .main-content{

margin:30px 18%;
width:79%;

}

.customer-hero{

display:flex;
justify-content:space-between;
align-items:center;

padding:30px;

margin-bottom:25px;

border-radius:25px;

background:linear-gradient(135deg,#0f172a,#2563eb);

color:white;

box-shadow:0 20px 50px rgba(37,99,235,.25);

}

.customer-hero h2{

font-weight:700;

}

.customer-hero p{

opacity:.9;

}

.stats-grid{

display:grid;

grid-template-columns:repeat(auto-fit,minmax(220px,1fr));

gap:20px;

margin-bottom:25px;

}

.stat-card{

background:white;

padding:25px;

border-radius:22px;

text-align:center;

box-shadow:0 10px 30px rgba(0,0,0,.08);

transition:.3s;

}

.stat-card:hover{

transform:translateY(-8px);

}

.stat-card i{

font-size:35px;

color:#2563eb;

margin-bottom:10px;

}

.stat-card h3{

font-size:34px;

font-weight:700;

}

.table-card{

background:white;

padding:25px;

border-radius:25px;

box-shadow:0 10px 35px rgba(0,0,0,.08);

}

.table-title{

font-weight:700;

margin-bottom:20px;

}

.premium-table{

border-collapse:separate;

border-spacing:0;

}

.premium-table thead{

background:linear-gradient(135deg,#2563eb,#0f172a);

color:white;

}

.premium-table th{

padding:18px;

border:none;

font-size:14px;

}

.premium-table td{

padding:16px;

vertical-align:middle;

border-bottom:1px solid #eef2f7;

}

.premium-table tbody tr{

transition:.3s;

}

.premium-table tbody tr:hover{

background:#f4f9ff;

transform:scale(1.01);

}

.customer-box{

display:flex;

align-items:center;

gap:15px;

}

.customer-img{

width:55px;

height:55px;

border-radius:50%;

object-fit:cover;

box-shadow:0 10px 25px rgba(0,0,0,.15);

}

.avatar{

width:55px;

height:55px;

border-radius:50%;

background:linear-gradient(135deg,#2563eb,#4f46e5);

color:white;

display:flex;

justify-content:center;

align-items:center;

font-weight:700;

font-size:22px;

}

.table-image{

width:70px;

height:70px;

border-radius:15px;

object-fit:cover;

transition:.3s;

}

.table-image:hover{

transform:scale(1.12);

}

.member-badge{

padding:8px 18px;

border-radius:30px;

font-size:13px;

font-weight:600;

}

.badge-gold{

background:#fff4cc;

color:#a16207;

}

.badge-premium{

background:#ede9fe;

color:#6d28d9;

}

.badge-silver{

background:#e5e7eb;

color:#374151;

}

.dataTables_wrapper .dataTables_paginate .paginate_button.current{

background:#2563eb!important;

color:white!important;

border:none!important;

border-radius:10px;

}













</style>
</head>

<body>

<?php

global $conn;
/** @var mysqli $conn */

$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn,$_GET['search'])
    : '';


    /* ===============================
   FIND CUSTOMER WITH MOST ORDERS
================================= */

$topCustomer = 0;

$q = mysqli_query($conn,"
SELECT customer_id,
SUM(quantity) AS total_items
FROM userorder
WHERE order_status='Delivered'
GROUP BY customer_id
ORDER BY total_items DESC

");

if(mysqli_num_rows($q)>0){
    $top = mysqli_fetch_assoc($q);
    $topCustomer = $top['customer_id'];
}

// $sql = "
//     SELECT * FROM clients
//     WHERE role='user'
// ";

$sql = "
SELECT
    c.*,
    COUNT(u.id) AS total_orders
FROM clients c
LEFT JOIN userorder u
ON c.id = u.customer_id
WHERE c.role='user'
";

if($search != ''){
    $sql .= "
    AND (
        c.name LIKE '%$search%'
        OR c.email LIKE '%$search%'
        OR c.mobile LIKE '%$search%'
    )
    ";
}

$sql .= "
GROUP BY c.id
ORDER BY c.id ASC
";

$res = mysqli_query($conn, $sql);
?>

<div class="container" style="margin-left:-1%; min-width:102%;">

    <?php include "sidebar.php"; ?>
    <?php include "header.php"; ?>
<div class="">

    </div>
    </div>
</div>


<div class="main-content">

<div class="customer-hero">

<div>

<h2>
<i class="fas fa-users"></i>
Customer Management
</h2>

<p>
Manage all registered customers from one premium dashboard.
</p>

</div>

<div>


</div>

</div>


<div class="stats-grid">

<div class="stat-card">

<i class="fas fa-users"></i>

<h3>

<?php
echo mysqli_num_rows($res);
?>

</h3>

<p>Total Customers</p>

</div>

<div class="stat-card">

<i class="fas fa-crown"></i>

<h3>

<?php

    $gold = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM clients
    WHERE role='user'
    AND membership='Gold'
    "));

    echo $gold['total'];

    ?>
</h3>

<p>Gold Members</p>

</div>

<div class="stat-card">

<i class="fas fa-envelope"></i>

<h3>

<?php

$email=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM clients
WHERE email<>''
"));

echo $email['total'];

?>

</h3>

<p>Email Verified</p>

</div>

</div>

<div class="table-card">

<div class="table-responsive">



<!-- <div class="table-responsive" style="margin:2% 19%; width:80%;"> -->

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="table-title">

<i class="fas fa-user-friends"></i>

Customer Directory

</h3>
    </div>

    <!-- <table id="myTable" class="table table-bordered table-striped"> -->
        <table id="myTable" class="table premium-table align-middle">

        <!-- <thead class="table-info text-center"> -->
<thead>
<tr>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">ID</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Name</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Email</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Mobile</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Address</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Image</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Joined</th>
    <th style="background:linear-gradient(135deg,#1E293B,#0F172A);color:#fff;">Membership</th>
</tr>
</thead>

        <tbody>

        <?php if(mysqli_num_rows($res) > 0){ ?>

            <?php while($row = mysqli_fetch_assoc($res)){ ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td>

<div class="customer-box">

<?php

if(!empty($row['image'])){

?>

<!-- <img
src="../images/<?php echo $row['image']; ?>"
class="customer-img"> -->

<?php

}else{

?>

<div class="avatar">

<?php

echo strtoupper(substr($row['name'],0,1));

?>

</div>

<?php } ?>

<div>

<b>

<?php echo $row['name']; ?>

</b>

<br>

<small>

ID :
<?php echo $row['id']; ?>

</small>

</div>

</div>

</td>
                <td><?php echo $row['email'] ?? 'NA'; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td><?php echo $row['address']; ?></td>

                <!-- <td>
                    <img src="<?php echo !empty($row['image']) ? '../images/'.$row['image'] : '../images/default.avif'; ?>"
                         style="height:70px;width:70px;object-fit:cover;border-radius:10px;">
                </td> -->
                <td>

<img

src="<?php echo !empty($row['image']) ? '../images/'.$row['image'] : '../images/default.avif'; ?>"

class="table-image">

</td>

                <td>
                    <?php
                    echo !empty($row['addwithus'])
                        ? date("d M Y", strtotime($row['addwithus']))
                        : '-';
                    ?>
                </td>

                <!-- <td><?php echo $row['membership']; ?></td> -->

                <td>

<?php

if($row['total_orders'] > 5){

    $class = "badge-gold";
    $member = "Gold";

}
elseif($row['total_orders'] > 3){

    $class = "badge-premium";
    $member = "Yes";

}
else{

    $class = "badge-silver";
    $member = "No";

}

?>

<span class="member-badge <?php echo $class; ?>">
    <?php echo $member; ?>
</span>

</td>
            </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="8" class="text-center text-danger">
                    No Users Found
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>
    </div>

</div>
</div>

<!-- ================= JS ================= -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#myTable').DataTable({
        paging: true,
       searching: false,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 5
    });
});
</script>




</body>
</html>