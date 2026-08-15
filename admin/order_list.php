<?php
session_start();
include "includes/db_connect.php";
include "function.php";

global $conn;

/* =========================================================
   BASIC SETTINGS
========================================================= */

$limit = 5;


/* =========================================================
   PAGE
========================================================= */

$page = $_GET['page'] ?? 1;

if (!ctype_digit((string)$page) || (int)$page < 1) {
    $page = 1;
}

$page = (int)$page;


/* =========================================================
   SEARCH
========================================================= */

$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : '';

$search_escaped = mysqli_real_escape_string(
    $conn,
    $search
);


/* =========================================================
   WHERE CONDITION
========================================================= */

$where = "WHERE COALESCE(is_deleted, 0) = 0";


if ($search !== '') {

    $where .= " AND (

        customer_name LIKE '%$search_escaped%'

        OR customer_number LIKE '%$search_escaped%'

        OR order_number LIKE '%$search_escaped%'

        OR product_name LIKE '%$search_escaped%'

        OR payment_status LIKE '%$search_escaped%'

        OR order_status LIKE '%$search_escaped%'

        OR delivery_status LIKE '%$search_escaped%'

    )";
}


/* =========================================================
   TOTAL ORDERS
========================================================= */

$total_sql = "
    SELECT COUNT(*) AS total
    FROM userorder
    $where
";

$total_query = mysqli_query(
    $conn,
    $total_sql
);

if (!$total_query) {

    die(
        "Count Query Error: "
        . mysqli_error($conn)
    );
}

$total_row = mysqli_fetch_assoc($total_query);

$total_records = (int)$total_row['total'];


/* =========================================================
   TOTAL PAGES
========================================================= */

$total_pages = max(
    1,
    (int)ceil($total_records / $limit)
);


/* =========================================================
   FIX INVALID PAGE
========================================================= */

if ($page > $total_pages) {

    $page = $total_pages;
}


/* =========================================================
   OFFSET
========================================================= */

$offset = ($page - 1) * $limit;


/* =========================================================
   ORDER STATISTICS
========================================================= */

/* Delivered */

$delivered_query = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM userorder
    WHERE COALESCE(is_deleted,0)=0
    AND order_status='Delivered'
    "
);

$delivered = 0;

if ($delivered_query) {

    $delivered_row =
        mysqli_fetch_assoc($delivered_query);

    $delivered =
        (int)$delivered_row['total'];
}


/* Processing */

$processing_query = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM userorder
    WHERE COALESCE(is_deleted,0)=0
    AND order_status='Processing'
    "
);

$processing = 0;

if ($processing_query) {

    $processing_row =
        mysqli_fetch_assoc($processing_query);

    $processing =
        (int)$processing_row['total'];
}


/* Cancelled */

$cancelled_query = mysqli_query(
    $conn,
    "
    SELECT COUNT(*) AS total
    FROM userorder
    WHERE COALESCE(is_deleted,0)=0
    AND order_status='Cancelled'
    "
);

$cancelled = 0;

if ($cancelled_query) {

    $cancelled_row =
        mysqli_fetch_assoc($cancelled_query);

    $cancelled =
        (int)$cancelled_row['total'];
}


/* =========================================================
   MAIN ORDER QUERY
========================================================= */

$sql = "
SELECT

    id,
    customer_id,
    customer_name,
    product_id,
    product_name,
    product_image,
    quantity,
    order_number,
    item_price,
    total_amount,
    customer_number,
    shipping_address,
    payment_method,
    payment_status,
    order_status,
    city,
    state,
    pin,
    delivery_charge,
    tracking_number,
    estimated_delivery,
    coupon_code,
    discount_amount,
    grand_total,
    created_at,
    cancel_reason,
    cancel_note,
    cancelled_at,
    is_deleted,
    current_lat,
    current_lng,
    delivery_status

FROM userorder

$where

ORDER BY id DESC

LIMIT $limit
OFFSET $offset
";


$res = mysqli_query(
    $conn,
    $sql
);


if (!$res) {

    die(
        "Main Query Error: "
        . mysqli_error($conn)
    );
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Order Management</title>

    <link rel="icon" type="image/png" href="weblogo.png">


<!-- Bootstrap -->

<link
    rel="stylesheet"
    href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"
>


<!-- Font Awesome -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
>


<style>

/* =========================================================
   GLOBAL
========================================================= */

*{
    box-sizing:border-box;
}

body{

    margin:0;

    background:#f5f7fb;

    font-family:
        "Poppins",
        Arial,
        sans-serif;

    overflow-x:hidden;
}


/* =========================================================
   MAIN WRAPPER
========================================================= */

.order-wrapper{

    /*
       IMPORTANT FIX

       OLD:
       margin:3% 19%;
       width:80%;

       That becomes more than 100%.

       NEW:
    */

    margin-left:18%;

    margin-top:35px;

    width:calc(82% - 35px);

    max-width:none;

    padding-bottom:40px;
}


/* =========================================================
   PAGE TITLE
========================================================= */

.title{

    margin:0;

    color:#17213b;

    font-size:30px;

    font-weight:800;

    letter-spacing:-0.5px;

    display:flex;

    align-items:center;

    gap:12px;
}

.title i{

    color:#315bea;
}


/* =========================================================
   TITLE UNDERLINE
========================================================= */

.title-wrap{

    margin-bottom:22px;

    position:relative;
}




/* =========================================================
   STAT CARDS
========================================================= */

.order-stats{

    display:grid;

    grid-template-columns:
        repeat(4, minmax(0,1fr));

    gap:18px;

    margin-bottom:25px;
}


.stat-card{

    background:#ffffff;

    border-radius:18px;

    padding:20px;

    min-height:125px;

    position:relative;

    overflow:hidden;

    border:1px solid #e9edf5;

    box-shadow:
        0 8px 25px rgba(30,45,80,.07);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.stat-card:hover{

    transform:translateY(-4px);

    box-shadow:
        0 15px 35px rgba(30,45,80,.12);
}


.stat-card::before{

    content:"";

    position:absolute;

    left:0;

    top:0;

    width:5px;

    height:100%;

    background:#315bea;
}


.stat-card.delivered::before{

    background:#16a34a;
}


.stat-card.processing::before{

    background:#f59e0b;
}


.stat-card.cancelled::before{

    background:#ef4444;
}


.stat-icon{

    width:45px;

    height:45px;

    border-radius:13px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:19px;

    margin-bottom:12px;
}


.stat-card.total .stat-icon{

    background:#eaf0ff;

    color:#315bea;
}


.stat-card.delivered .stat-icon{

    background:#eafaf0;

    color:#16a34a;
}


.stat-card.processing .stat-icon{

    background:#fff7e6;

    color:#f59e0b;
}


.stat-card.cancelled .stat-icon{

    background:#fff0f0;

    color:#ef4444;
}


.stat-number{

    font-size:27px;

    font-weight:800;

    color:#17213b;

    line-height:1;

    margin-bottom:6px;
}


.stat-label{

    font-size:13px;

    color:#8a94a6;

    font-weight:600;
}


/* =========================================================
   TABLE CARD
========================================================= */

.table-card{

    background:#fff;

    border:1px solid #e6eaf1;

    border-radius:20px;

    padding:0;

    overflow:hidden;

    box-shadow:
        0 10px 35px rgba(30,45,80,.08);
}


/* =========================================================
   TABLE RESPONSIVE
========================================================= */

.order-table-wrapper{

    width:100%;

    overflow:hidden;
}


/* =========================================================
   TABLE
========================================================= */

.order-table{

    width:100%;

    margin:0;

    table-layout:fixed;

    border-collapse:separate;

    border-spacing:0;

    font-size:13px;
}


/* =========================================================
   COLUMN WIDTHS
========================================================= */

.order-table .col-id{
    width:5%;
}

.order-table .col-order{
    width:8%;
}

.order-table .col-customer{
    width:13%;
}

.order-table .col-product{
    width:10%;
}

.order-table .col-image{
    width:9%;
}

.order-table .col-qty{
    width:5%;
}

.order-table .col-total{
    width:9%;
}

.order-table .col-payment{
    width:9%;
}

.order-table .col-status{
    width:8%;
}

.order-table .col-delivery{
    width:7%;
}

.order-table .col-action{
    width:4%;
}


/* =========================================================
   TABLE HEADER
========================================================= */

.premium-thead th{

    background:
        linear-gradient(
            135deg,
            #17213b,
            #263c78
        );

    color:#ffffff;

    border:0;

    padding:17px 10px;

    font-size:10px;

    font-weight:700;

    letter-spacing:.7px;

    text-transform:uppercase;

    white-space:nowrap;

    vertical-align:middle;
}


.premium-thead th:first-child{

    padding-left:18px;
}


/* =========================================================
   TABLE ROW
========================================================= */

.order-table tbody tr{

    background:#ffffff;

    transition:
        background .2s ease;
}


.order-table tbody tr:hover{

    background:#f8faff;
}


/* =========================================================
   TABLE CELLS
========================================================= */

.order-table tbody td{

    padding:16px 9px;

    border-bottom:1px solid #edf0f5;

    vertical-align:middle;

    color:#26324a;

    overflow:hidden;
}


.order-table tbody tr:last-child td{

    border-bottom:0;
}


/* =========================================================
   COLUMN BACKGROUNDS
========================================================= */

.order-table tbody td:nth-child(1){

    background:#fafbff;
}


.order-table tbody td:nth-child(2){

    background:#f8faff;
}


.order-table tbody td:nth-child(3){

    background:#ffffff;
}


.order-table tbody td:nth-child(4){

    background:#fffdf9;
}


.order-table tbody td:nth-child(5){

    background:#fbfcff;
}


.order-table tbody td:nth-child(6){

    background:#ffffff;
}


.order-table tbody td:nth-child(7){

    background:#f9fffc;
}


.order-table tbody td:nth-child(8){

    background:#fffdf7;
}


.order-table tbody td:nth-child(9){

    background:#fbf9ff;
}


.order-table tbody td:nth-child(10){

    background:#f8fcff;
}


.order-table tbody td:nth-child(11){

    background:#ffffff;
}


/* =========================================================
   ID
========================================================= */

.order-id{

    font-weight:800;

    color:#26324a;

    white-space:nowrap;
}


/* =========================================================
   ORDER NUMBER
========================================================= */

.order-number{

    display:inline-block;

    background:#eef3fa;

    color:#35435c;

    border-radius:8px;

    padding:7px 8px;

    font-size:10px;

    font-weight:700;

    max-width:100%;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;
}


/* =========================================================
   CUSTOMER
========================================================= */

.customer-cell{

    display:flex;

    align-items:center;

    gap:9px;

    min-width:0;
}


.customer-avatar{

    width:35px;

    height:35px;

    min-width:35px;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#e9eeff;

    color:#315bea;

    font-weight:800;

    font-size:13px;
}


.customer-info{

    min-width:0;
}


.customer-info strong{

    display:block;

    color:#17213b;

    font-size:12px;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;
}


.customer-info small{

    display:block;

    color:#8c98ab;

    font-size:9px;

    margin-top:3px;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;
}


/* =========================================================
   PRODUCT
========================================================= */

.product-name{

    font-size:11px;

    font-weight:600;

    color:#344054;

    display:block;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;
}


/* =========================================================
   IMAGE
========================================================= */

.order-product-img{

    width:55px;

    height:55px;

    object-fit:cover;

    border-radius:12px;

    display:block;

    margin:auto;

    box-shadow:
        0 5px 15px rgba(0,0,0,.12);

    border:3px solid #fff;
}


.no-image{

    width:55px;

    height:55px;

    border-radius:12px;

    background:#f0f2f6;

    color:#a0a8b8;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:auto;
}


/* =========================================================
   QUANTITY
========================================================= */

.quantity-badge{

    min-width:30px;

    height:30px;

    padding:0 8px;

    background:#edf2fb;

    color:#344054;

    border-radius:9px;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    font-weight:800;

    font-size:11px;
}


/* =========================================================
   TOTAL
========================================================= */

.order-total{

    color:#17213b;

    font-size:12px;

    white-space:nowrap;
}


/* =========================================================
   PAYMENT BADGES
========================================================= */

.payment-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:5px;

    padding:7px 9px;

    border-radius:20px;

    font-size:9px;

    font-weight:700;

    white-space:nowrap;
}


.payment-badge.paid{

    background:#e8faf1;

    color:#0d9b5b;
}


.payment-badge.pending{

    background:#fff7df;

    color:#c68100;
}


.payment-badge.failed{

    background:#fff0f0;

    color:#e53935;
}


/* =========================================================
   STATUS
========================================================= */

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:7px 9px;

    border-radius:20px;

    font-size:9px;

    font-weight:700;

    white-space:nowrap;
}


.status-pending{

    background:#fff5df;

    color:#c98200;
}


.status-confirmed{

    background:#eaf3ff;

    color:#2563eb;
}


.status-processing{

    background:#f0eaff;

    color:#713cff;
}


.status-shipped{

    background:#e8f8ff;

    color:#0284c7;
}


.status-delivered{

    background:#e6faf0;

    color:#0a9b5b;
}


.status-cancelled{

    background:#ffeded;

    color:#dc2626;
}


/* =========================================================
   DELIVERY
========================================================= */

.delivery-status{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    font-size:9px;

    font-weight:700;

    white-space:nowrap;

    color:#526071;
}


/* =========================================================
   ACTION
========================================================= */

.action-btn{

    width:32px;

    height:32px;

    border:1px solid #e2e7ef;

    border-radius:9px;

    background:#ffffff;

    color:#68758a;

    display:flex;

    align-items:center;

    justify-content:center;

    cursor:pointer;

    transition:.2s;
}


.action-btn:hover{

    background:#edf3ff;

    color:#315bea;

    border-color:#cbd8ff;
}


.dropdown-menu{

    border:0;

    border-radius:12px;

    padding:7px;

    box-shadow:
        0 12px 35px rgba(0,0,0,.14);
}


.dropdown-item{

    border-radius:8px;

    padding:9px 12px;

    font-size:12px;

    font-weight:600;
}


.dropdown-item:hover{

    background:#f2f5fb;
}


/* =========================================================
   NO ORDERS
========================================================= */

.no-orders{

    text-align:center;

    padding:70px 20px !important;

    background:#ffffff !important;
}


.no-orders i{

    font-size:42px;

    color:#c4ccda;

    margin-bottom:15px;
}


.no-orders h4{

    color:#27344d;

    font-weight:700;

    margin-bottom:5px;
}


.no-orders p{

    color:#8d98a9;

    font-size:13px;

    margin:0;
}


/* =========================================================
   PAGINATION
========================================================= */

.pagination-area{

    display:flex;

    justify-content:center;

    align-items:center;

    gap:7px;

    margin-top:25px;

    flex-wrap:wrap;
}


.page-btn{

    min-width:40px;

    height:40px;

    border-radius:11px;

    border:1px solid #e2e7ef;

    background:#ffffff;

    color:#455267;

    display:flex;

    align-items:center;

    justify-content:center;

    text-decoration:none;

    font-size:12px;

    font-weight:700;

    transition:.2s;

    padding:0 14px;
}


.page-btn:hover{

    background:#edf3ff;

    color:#315bea;

    border-color:#cbd8ff;
}


.page-btn.active{

    background:
        linear-gradient(
            135deg,
            #4f46e5,
            #2563eb
        );

    color:#ffffff;

    border-color:transparent;

    box-shadow:
        0 6px 15px rgba(49,91,234,.25);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){

    .order-wrapper{

        margin-left:18%;

        width:calc(82% - 20px);
    }

    .order-table{

        font-size:11px;
    }

    .premium-thead th{

        font-size:9px;

        padding:14px 6px;
    }

    .order-table tbody td{

        padding:12px 6px;
    }

    .order-product-img,
    .no-image{

        width:48px;

        height:48px;
    }

    .customer-avatar{

        width:30px;

        height:30px;

        min-width:30px;
    }
}


/* =========================================================
   TABLET
========================================================= */

@media(max-width:900px){

    .order-wrapper{

        margin-left:15px;

        margin-right:15px;

        width:calc(100% - 30px);

        margin-top:25px;
    }

    .order-stats{

        grid-template-columns:
            repeat(2,1fr);
    }

    /*
       Keep table compact instead of creating
       a giant horizontal page.
    */

    .order-table{

        font-size:10px;
    }

    .premium-thead th{

        font-size:8px;
    }

    .customer-info strong{

        font-size:10px;
    }

    .customer-info small{

        font-size:8px;
    }
}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:650px){

    .order-wrapper{

        margin:20px 10px;

        width:calc(100% - 20px);
    }

    .title{

        font-size:23px;
    }

    .order-stats{

        grid-template-columns:1fr 1fr;

        gap:10px;
    }

    .stat-card{

        padding:15px;

        min-height:110px;
    }

    .stat-number{

        font-size:22px;
    }

    /*
       Mobile table becomes scrollable INSIDE
       table card only, not entire page.
    */

    .order-table-wrapper{

        overflow-x:auto;

        -webkit-overflow-scrolling:touch;
    }

    .order-table{

        min-width:1050px;
    }

    body{

        overflow-x:hidden;
    }
}


/* =========================================================
   ORDER ACTION DROPDOWN
   OPEN MENU TO THE LEFT
========================================================= */

.order-table .action-dropdown {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}


/* 3 DOT BUTTON */

.order-table .action-btn {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #e2e8f0;
    background: #ffffff;

    border-radius: 10px;

    color: #64748b;

    cursor: pointer;

    transition: all 0.25s ease;

    box-shadow: 0 3px 10px rgba(15, 23, 42, 0.06);
}


.order-table .action-btn:hover {
    background: #f1f5ff;
    border-color: #4f46e5;
    color: #4f46e5;

    transform: translateY(-1px);

    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.15);
}


/* =====================================================
   ACTION COLUMN
===================================================== */

.action-cell {
    position: relative;
    width: 70px;
    min-width: 70px;
    text-align: center;
    overflow: visible !important;
}


/* =====================================================
   DETAILS WRAPPER
===================================================== */

.order-action {
    position: relative;
    display: inline-block;
}


/* =====================================================
   REMOVE DEFAULT SUMMARY ARROW
===================================================== */

.order-action summary {
    list-style: none;
}

.order-action summary::-webkit-details-marker {
    display: none;
}

.order-action summary::marker {
    display: none;
}


/* =====================================================
   THREE DOT BUTTON
===================================================== */

.action-btn {
    width: 40px;
    height: 40px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0;
    margin: 0;

    border: 1px solid #e5e7eb;
    border-radius: 12px;

    background: #ffffff;

    color: #64748b;

    font-size: 16px;

    cursor: pointer;

    transition:
        all 0.2s ease;

    box-shadow:
        0 2px 8px rgba(15, 23, 42, 0.06);
}


.action-btn:hover {
    background: #f4f6ff;

    color: #315bea;

    border-color: #cbd5ff;

    transform: translateY(-1px);

    box-shadow:
        0 5px 14px rgba(49, 91, 234, 0.12);
}


/* When menu is open */

.order-action[open] .action-btn {
    background: #eef2ff;

    color: #315bea;

    border-color: #c7d2fe;

    box-shadow:
        0 5px 15px rgba(49, 91, 234, 0.14);
}


/* =====================================================
   ACTION MENU
   Opens to LEFT
===================================================== */

.action-menu {
    position: absolute;

    right: 48px;
    top: 50%;

    transform: translateY(-50%);

    width: 175px;

    padding: 7px;

    background: #ffffff;

    border: 1px solid #e8ebf2;

    border-radius: 14px;

    box-shadow:
        0 18px 45px rgba(15, 23, 42, 0.14),
        0 4px 12px rgba(15, 23, 42, 0.06);

    z-index: 9999;

    animation: actionMenuIn 0.16s ease;
}


/* =====================================================
   MENU SMALL ARROW
===================================================== */

.action-menu::after {
    content: "";

    position: absolute;

    right: -6px;
    top: 50%;

    width: 11px;
    height: 11px;

    background: #ffffff;

    border-top: 1px solid #e8ebf2;
    border-right: 1px solid #e8ebf2;

    transform:
        translateY(-50%)
        rotate(45deg);
}


/* =====================================================
   MENU ITEM
===================================================== */

.action-menu-item {
    width: 100%;

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 10px 11px;

    margin: 2px 0;

    border-radius: 10px;

    text-decoration: none;

    color: #334155;

    font-size: 13px;

    font-weight: 600;

    transition:
        background 0.18s ease,
        color 0.18s ease,
        transform 0.18s ease;
}


.action-menu-item:hover {
    background: #f7f8fc;

    color: #1e293b;

    transform: translateX(-2px);
}


/* =====================================================
   ICON BOX
===================================================== */

.action-menu-icon {
    width: 30px;
    height: 30px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 9px;

    font-size: 12px;
}


/* View */

.view-icon {
    background: #eff6ff;

    color: #2563eb;
}


/* Edit */

.edit-icon {
    background: #fff7ed;

    color: #f59e0b;
}


/* =====================================================
   ANIMATION
===================================================== */

@keyframes actionMenuIn {

    from {
        opacity: 0;
        transform:
            translateY(-50%)
            translateX(7px);
    }

    to {
        opacity: 1;
        transform:
            translateY(-50%)
            translateX(0);
    }

}


/* =====================================================
   IMPORTANT TABLE FIX
===================================================== */

.order-table td,
.order-table th {
    overflow: visible;
}


/*
   Wrapper must also allow the menu
   to come outside the table.
*/

.order-table-wrapper {
    overflow-x: auto;
    overflow-y: visible !important;
}


/*
   Table card should NOT hide dropdown
*/

.table-card {
    overflow: visible !important;
}


/*
   Bootstrap .table-responsive often uses overflow:auto.
   Do not use it around this table if possible.
*/

.table-responsive {
    overflow-x: auto;
    overflow-y: visible !important;
}







</style>

</head>


<body>


<div class="container"   style="margin-left:-1%;min-width:102%;">

<?php include "sidebar.php"; ?>

<?php include "header.php"; ?>
<div class="">

</div>
</div>
</div>


<!-- =====================================================
     MAIN ORDER WRAPPER
===================================================== -->

<div class="order-wrapper">


    <!-- =================================================
         TITLE
    ================================================== -->

    <div class="title-wrap">

        <h1 class="title">

            <i class="fa-solid fa-cart-shopping"></i>

            Order Details

        </h1>

    </div>


    <!-- =================================================
         STATISTICS
    ================================================== -->

    <div class="order-stats">


        <!-- TOTAL -->

        <div class="stat-card total">

            <div class="stat-icon">

                <i class="fas fa-shopping-cart"></i>

            </div>

            <div class="stat-number">

                <?php echo $total_records; ?>

            </div>

            <div class="stat-label">

                Total Orders

            </div>

        </div>


        <!-- DELIVERED -->

        <div class="stat-card delivered">

            <div class="stat-icon">

                <i class="fas fa-circle-check"></i>

            </div>

            <div class="stat-number">

                <?php echo $delivered; ?>

            </div>

            <div class="stat-label">

                Delivered

            </div>

        </div>


        <!-- PROCESSING -->

        <div class="stat-card processing">

            <div class="stat-icon">

                <i class="fas fa-box"></i>

            </div>

            <div class="stat-number">

                <?php echo $processing; ?>

            </div>

            <div class="stat-label">

                Processing

            </div>

        </div>


        <!-- CANCELLED -->

        <div class="stat-card cancelled">

            <div class="stat-icon">

                <i class="fas fa-ban"></i>

            </div>

            <div class="stat-number">

                <?php echo $cancelled; ?>

            </div>

            <div class="stat-label">

                Cancelled

            </div>

        </div>


    </div>


    <!-- =================================================
         TABLE CARD
    ================================================== -->

    <div class="table-card">


        <div class="order-table-wrapper">


            <table class="table order-table align-middle">


                <!-- ================================
                     HEADER
                ================================= -->

                <thead class="premium-thead">

                    <tr>

                        <th class="col-id">
                            #
                        </th>

                        <th class="col-order">
                            Order
                        </th>

                        <th class="col-customer">
                            Customer
                        </th>

                        <th class="col-product">
                            Product
                        </th>

                        <th class="col-image">
                            Image
                        </th>

                        <th class="col-qty">
                            Qty
                        </th>

                        <th class="col-total">
                            Total
                        </th>

                        <th class="col-payment">
                            Payment
                        </th>

                        <th class="col-status">
                            Order Status
                        </th>

                        <th class="col-delivery">
                            Delivery
                        </th>

                        <th class="col-action">
                            Action
                        </th>

                    </tr>

                </thead>


                <!-- ================================
                     BODY
                ================================= -->

                <tbody>


                <?php if (mysqli_num_rows($res) > 0) { ?>


                    <?php while ($row = mysqli_fetch_assoc($res)) { ?>


                        <tr>


                            <!-- =====================
                                 ID
                            ====================== -->

                            <td>

                                <span class="order-id">

                                    #<?php
                                    echo (int)$row['id'];
                                    ?>

                                </span>

                            </td>


                            <!-- =====================
                                 ORDER
                            ====================== -->

                            <td>

                                <span class="order-number">

                                    <?php

                                    echo htmlspecialchars(
                                        $row['order_number'] ?? ''
                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =====================
                                 CUSTOMER
                            ====================== -->

                            <td>

                                <?php

                                $customerName =
                                    $row['customer_name'] ?? '';

                                $firstLetter =
                                    $customerName !== ''
                                    ? strtoupper(
                                        substr(
                                            $customerName,
                                            0,
                                            1
                                        )
                                    )
                                    : '?';

                                ?>


                                <div class="customer-cell">


                                    <div class="customer-avatar">

                                        <?php
                                        echo $firstLetter;
                                        ?>

                                    </div>


                                    <div class="customer-info">

                                        <strong>

                                            <?php

                                            echo htmlspecialchars(
                                                $customerName
                                            );

                                            ?>

                                        </strong>


                                        <small>

                                            <?php

                                            echo htmlspecialchars(
                                                $row['customer_number']
                                                ?? ''
                                            );

                                            ?>

                                        </small>

                                    </div>


                                </div>

                            </td>


                            <!-- =====================
                                 PRODUCT
                            ====================== -->

                            <td>

                                <span class="product-name">

                                    <?php

                                    echo htmlspecialchars(
                                        $row['product_name'] ?? ''
                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =====================
                                 IMAGE
                            ====================== -->

                            <td>

                                <?php

                                $image = trim(
                                    $row['product_image']
                                    ?? ''
                                );

                                ?>


                                <?php if ($image !== '') { ?>


                                    <img
                                        src="../images/<?php
                                            echo htmlspecialchars(
                                                $image
                                            );
                                        ?>"
                                        class="order-product-img"
                                        alt="Product"
                                    >


                                <?php } else { ?>


                                    <div class="no-image">

                                        <i class="fas fa-image"></i>

                                    </div>


                                <?php } ?>

                            </td>


                            <!-- =====================
                                 QUANTITY
                            ====================== -->

                            <td>

                                <span class="quantity-badge">

                                    <?php

                                    echo (int)(
                                        $row['quantity'] ?? 0
                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =====================
                                 TOTAL
                            ====================== -->

                            <td>

                                <?php

                                $grandTotal =
                                    (float)(
                                        $row['grand_total']
                                        ?? 0
                                    );


                                if ($grandTotal <= 0) {

                                    $grandTotal =
                                        (float)(
                                            $row['total_amount']
                                            ?? 0
                                        );
                                }

                                ?>


                                <strong class="order-total">

                                    ₹<?php

                                    echo number_format(
                                        $grandTotal,
                                        2
                                    );

                                    ?>

                                </strong>

                            </td>


                            <!-- =====================
                                 PAYMENT
                            ====================== -->

                            <td>

                                <?php

                                $payment =
                                    strtolower(
                                        trim(
                                            $row['payment_status']
                                            ?? 'Pending'
                                        )
                                    );

                                ?>


                                <?php if (
                                    $payment === 'paid'
                                ) { ?>


                                    <span
                                        class="payment-badge paid"
                                    >

                                        <i
                                            class="fas
                                            fa-check-circle"
                                        ></i>

                                        Paid

                                    </span>


                                <?php } elseif (
                                    $payment === 'failed'
                                ) { ?>


                                    <span
                                        class="payment-badge failed"
                                    >

                                        <i
                                            class="fas
                                            fa-times-circle"
                                        ></i>

                                        Failed

                                    </span>


                                <?php } else { ?>


                                    <span
                                        class="payment-badge pending"
                                    >

                                        <i
                                            class="fas
                                            fa-clock"
                                        ></i>

                                        Pending

                                    </span>


                                <?php } ?>

                            </td>


                            <!-- =====================
                                 ORDER STATUS
                            ====================== -->

                            <td>

                                <?php

                                $orderStatus =
                                    strtolower(
                                        trim(
                                            $row['order_status']
                                            ?? 'Pending'
                                        )
                                    );


                                $statusClass =
                                    'status-pending';


                                if (
                                    $orderStatus ===
                                    'confirmed'
                                ) {

                                    $statusClass =
                                        'status-confirmed';

                                } elseif (
                                    $orderStatus ===
                                    'processing'
                                ) {

                                    $statusClass =
                                        'status-processing';

                                } elseif (
                                    $orderStatus ===
                                    'shipped'
                                ) {

                                    $statusClass =
                                        'status-shipped';

                                } elseif (
                                    $orderStatus ===
                                    'delivered'
                                ) {

                                    $statusClass =
                                        'status-delivered';

                                } elseif (
                                    $orderStatus ===
                                    'cancelled'
                                ) {

                                    $statusClass =
                                        'status-cancelled';
                                }

                                ?>


                                <span
                                    class="status-badge
                                    <?php
                                    echo $statusClass;
                                    ?>"
                                >

                                    <?php

                                    echo htmlspecialchars(
                                        $row['order_status']
                                        ?? 'Pending'
                                    );

                                    ?>

                                </span>

                            </td>


                            <!-- =====================
                                 DELIVERY
                            ====================== -->

                            <td>

                                <?php

                                $deliveryStatus =
                                    $row['delivery_status']
                                    ?? 'Preparing';


                                $deliveryLower =
                                    strtolower(
                                        trim(
                                            $deliveryStatus
                                        )
                                    );

                                ?>


                                <div class="delivery-status">


                                    <?php if (
                                        $deliveryLower ===
                                        'delivered'
                                    ) { ?>


                                        <i
                                            class="
                                            fas
                                            fa-circle-check
                                            text-success
                                            "
                                        ></i>


                                    <?php } elseif (
                                        $deliveryLower ===
                                        'near you'
                                    ) { ?>


                                        <i
                                            class="
                                            fas
                                            fa-location-dot
                                            text-primary
                                            "
                                        ></i>


                                    <?php } elseif (
                                        $deliveryLower ===
                                        'on the way'
                                    ) { ?>


                                        <i
                                            class="
                                            fas
                                            fa-truck
                                            text-warning
                                            "
                                        ></i>


                                    <?php } else { ?>


                                        <i
                                            class="
                                            fas
                                            fa-box
                                            text-secondary
                                            "
                                        ></i>


                                    <?php } ?>


                                    <span>

                                        <?php

                                        echo htmlspecialchars(
                                            $deliveryStatus
                                        );

                                        ?>

                                    </span>


                                </div>

                            </td>


                            <!-- =====================
                                 ACTION
                            ====================== -->
<!-- =====================
     ACTION
====================== -->

<td class="action-cell">

    <details class="order-action">

        <summary class="action-btn" title="Order Actions">

            <i class="fas fa-ellipsis-v"></i>

        </summary>


        <div class="action-menu">

            <a
                href="view_order.php?id=<?php echo (int)$row['id']; ?>"
                class="action-menu-item"
            >

                <span class="action-menu-icon view-icon">
                    <i class="fas fa-eye"></i>
                </span>

                <span>
                    View Order
                </span>

            </a>


            <a
                href="edit_order.php?id=<?php echo (int)$row['id']; ?>"
                class="action-menu-item"
            >

                <span class="action-menu-icon edit-icon">
                    <i class="fas fa-pen"></i>
                </span>

                <span>
                    Edit Order
                </span>

            </a>

        </div>

    </details>

</td>



                        </tr>


                    <?php } ?>


                <?php } else { ?>


                    <!-- ============================
                         NO ORDERS
                    ============================= -->

                    <tr>

                        <td
                            colspan="11"
                            class="no-orders"
                        >

                            <div>

                                <i
                                    class="
                                    fas
                                    fa-box-open
                                    "
                                ></i>


                                <h4>
                                    No Orders Found
                                </h4>


                                <p>

                                    There are no orders
                                    matching your search.

                                </p>

                            </div>

                        </td>

                    </tr>


                <?php } ?>


                </tbody>


            </table>


        </div>


    </div>


    <!-- =================================================
         PAGINATION
    ================================================== -->

    <?php if ($total_records > 0) { ?>


        <div class="pagination-area">


            <!-- PREVIOUS -->

            <?php if ($page > 1) { ?>


                <a
                    class="page-btn"
                    href="?page=<?php
                        echo $page - 1;
                    ?>&search=<?php
                        echo urlencode($search);
                    ?>"
                >

                    <i
                        class="fas fa-arrow-left me-2"
                    ></i>

                    Previous

                </a>


            <?php } ?>


            <!-- PAGE NUMBERS -->

            <?php for (
                $i = 1;
                $i <= $total_pages;
                $i++
            ) { ?>


                <a
                    class="
                    page-btn
                    <?php
                    echo (
                        $i == $page
                    )
                    ? 'active'
                    : '';
                    ?>
                    "
                    href="?page=<?php
                        echo $i;
                    ?>&search=<?php
                        echo urlencode($search);
                    ?>"
                >

                    <?php
                    echo $i;
                    ?>

                </a>


            <?php } ?>


            <!-- NEXT -->

            <?php if (
                $page < $total_pages
            ) { ?>


                <a
                    class="page-btn"
                    href="?page=<?php
                        echo $page + 1;
                    ?>&search=<?php
                        echo urlencode($search);
                    ?>"
                >

                    Next

                    <i
                        class="
                        fas
                        fa-arrow-right
                        ms-2
                        "
                    ></i>

                </a>


            <?php } ?>


        </div>


    <?php } ?>


</div>


<!-- =====================================================
     BOOTSTRAP JS
====================================================== -->

<script
    src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>