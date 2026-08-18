<?php

// if (session_status() === PHP_SESSION_NONE) {
session_start();
// }
include("includes/db_connect.php");
include_once("function.php");
/** @var mysqli $conn */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="admin_panel.css">
    <link rel="icon" type="image/png" href="weblogo.png">

    <style>
        /* ==========================================================
                PREMIUM CATEGORY DASHBOARD
                    PART 2A
========================================================== */

        /* =========================
   CUSTOM DELETE CARD
========================= */

        .delete-overlay {
            position: fixed;
            inset: 0;

            display: none;

            align-items: center;
            justify-content: center;

            background: rgba(15, 23, 42, 0.55);

            z-index: 99999;

            padding: 20px;
        }

        .delete-overlay.show {
            display: flex;
        }

        .delete-card {
            width: 100%;
            max-width: 420px;

            position: relative;

            padding: 38px 30px;

            text-align: center;

            background: #ffffff;

            border-radius: 24px;

            box-shadow: 0 25px 70px rgba(0, 0, 0, .25);

            animation: deleteCardShow .3s ease;
        }

        .delete-close {
            position: absolute;

            top: 12px;
            right: 18px;

            border: none;
            background: transparent;

            font-size: 30px;

            color: #64748b;

            cursor: pointer;
        }

        .delete-close:hover {
            color: #ef4444;
        }

        .delete-icon {
            width: 75px;
            height: 75px;

            margin: 0 auto 20px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #fee2e2;

            color: #ef4444;

            font-size: 30px;
        }

        .delete-card h3 {
            font-size: 25px;

            font-weight: 700;

            color: #0f172a;

            margin-bottom: 12px;
        }

        .delete-card p {
            color: #64748b;

            line-height: 1.6;

            margin-bottom: 28px;
        }

        .delete-actions {
            display: flex;

            justify-content: center;

            gap: 12px;
        }

        .cancel-delete,
        .confirm-delete {
            border: none;

            padding: 12px 22px;

            border-radius: 10px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;
        }

        .cancel-delete {
            background: #e2e8f0;

            color: #334155;
        }

        .confirm-delete {
            background: #ef4444;

            color: #ffffff;
        }

        .confirm-delete:hover {
            background: #dc2626;

            color: #ffffff;
        }

        @keyframes deleteCardShow {

            from {
                opacity: 0;

                transform: scale(.85);
            }

            to {
                opacity: 1;

                transform: scale(1);
            }

        }


        body {

            background:
                linear-gradient(180deg, #f4f7fc 0%, #eef4ff 50%, #ffffff 100%);

            font-family: 'Poppins', sans-serif;

            overflow-x: hidden;

        }

        /* =========================
        MAIN CONTENT
========================= */

        /* .main-content{

margin:28px 18%;

width:79%;


} */

        .main-content {
            margin: 30px 0 30px 18%;
            width: calc(100% - 18%);
            padding: 0 20px;
            box-sizing: border-box;
            animation: pageFade .8s ease;

        }

        /* =========================
         HERO
========================= */

        .hero-section {

            position: relative;

            overflow: hidden;

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 42px;

            border-radius: 30px;

            margin-bottom: 35px;

            background:
                linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #06b6d4 100%);

            color: #fff;

            box-shadow:
                0 25px 60px rgba(37, 99, 235, .25);

        }

        /* Floating Orbs */

        .hero-section::before {

            content: "";

            position: absolute;

            width: 260px;

            height: 260px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .08);

            top: -100px;

            right: -70px;

            animation: float1 9s infinite ease-in-out;

        }

        .hero-section::after {

            content: "";

            position: absolute;

            width: 180px;

            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .05);

            left: -60px;

            bottom: -60px;

            animation: float2 8s infinite ease-in-out;

        }

        .hero-left {

            position: relative;

            z-index: 2;

        }

        .hero-tag {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 9px 18px;

            border-radius: 50px;

            background: rgba(255, 255, 255, .14);

            backdrop-filter: blur(18px);

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 20px;

        }

        .hero-section h1 {

            font-size: 40px;

            font-weight: 700;

            margin-bottom: 12px;

        }

        .hero-section p {

            font-size: 16px;

            max-width: 600px;

            opacity: .95;

            line-height: 28px;

        }

        .hero-right {

            position: relative;

            z-index: 2;

        }

        /* =========================
      ADD BUTTON
========================= */

        .btn-add-category {

            padding: 15px 28px;

            border: none;

            border-radius: 50px;

            background: #fff;

            color: #1d4ed8;

            font-weight: 700;

            font-size: 15px;

            box-shadow:

                0 15px 35px rgba(0, 0, 0, .18);

            transition: .35s;

            text-decoration: none;

        }

        .btn-add-category:hover {

            transform:

                translateY(-5px) scale(1.05);

            background: #0f172a;

            color: #fff;

            box-shadow:

                0 20px 45px rgba(0, 0, 0, .25);

        }

        /* =========================
      STAT GRID
========================= */

        .dashboard-grid {

            display: grid;

            grid-template-columns:

                repeat(auto-fit, minmax(250px, 1fr));

            gap: 25px;

            margin-bottom: 35px;

        }

        /* =========================
      PREMIUM CARD
========================= */

        .dashboard-card {

            position: relative;

            overflow: hidden;

            display: flex;

            align-items: center;

            gap: 20px;

            padding: 28px;

            border-radius: 24px;

            background:

                rgba(255, 255, 255, .72);

            backdrop-filter: blur(18px);

            box-shadow:

                0 18px 40px rgba(0, 0, 0, .08);

            transition: .4s;

            cursor: pointer;

        }

        .dashboard-card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            height: 5px;

        }

        .dashboard-card:hover {

            transform:

                translateY(-12px);

            box-shadow:

                0 28px 60px rgba(0, 0, 0, .15);

        }

        /* Card Glow */

        .dashboard-card::after {

            content: "";

            position: absolute;

            width: 220px;

            height: 220px;

            border-radius: 50%;

            right: -90px;

            top: -90px;

            opacity: .08;

        }

        /* =========================
         COLORS
========================= */

        .blue::before {

            background: #2563eb;

        }

        .blue::after {

            background: #2563eb;

        }

        .green::before {

            background: #10b981;

        }

        .green::after {

            background: #10b981;

        }

        .red::before {

            background: #ef4444;

        }

        .red::after {

            background: #ef4444;

        }

        .purple::before {

            background: #7c3aed;

        }

        .purple::after {

            background: #7c3aed;

        }

        /* =========================
         ICON
========================= */

        .card-icon {

            width: 72px;

            height: 72px;

            border-radius: 22px;

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 30px;

            color: #fff;

            flex-shrink: 0;

            box-shadow:

                0 15px 30px rgba(0, 0, 0, .15);

        }

        .blue .card-icon {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

        }

        .green .card-icon {

            background: linear-gradient(135deg, #10b981, #059669);

        }

        .red .card-icon {

            background: linear-gradient(135deg, #ef4444, #dc2626);

        }

        .purple .card-icon {

            background: linear-gradient(135deg, #8b5cf6, #6d28d9);

        }

        /* =========================
        CARD TEXT
========================= */

        .dashboard-card h2 {

            font-size: 36px;

            font-weight: 700;

            margin-bottom: 5px;

            color: #0f172a;

        }

        .dashboard-card span {

            font-size: 15px;

            font-weight: 500;

            color: #64748b;

        }

        /* =========================
        ANIMATIONS
========================= */

        @keyframes float1 {

            0% {

                transform: translateY(0);

            }

            50% {

                transform: translateY(25px);

            }

            100% {

                transform: translateY(0);

            }

        }

        @keyframes float2 {

            0% {

                transform: translateY(0);

            }

            50% {

                transform: translateY(-20px);

            }

            100% {

                transform: translateY(0);

            }

        }

        @keyframes pageFade {

            from {

                opacity: 0;

                transform: translateY(35px);

            }

            to {

                opacity: 1;

                transform: none;

            }

        }

        /* =====================================================
                PREMIUM TABLE CARD
===================================================== */

        .premium-table-card {

            position: relative;

            background: rgba(255, 255, 255, .82);

            backdrop-filter: blur(22px);

            border-radius: 28px;

            padding: 30px;

            border: 1px solid rgba(255, 255, 255, .5);

            box-shadow:

                0 30px 70px rgba(15, 23, 42, .08);

            overflow: hidden;

            animation: tableFade .8s ease;

        }

        .premium-table-card::before {

            content: "";

            position: absolute;

            left: 0;

            top: 0;

            width: 100%;

            height: 5px;

            background:

                linear-gradient(90deg,

                    #2563eb,

                    #06b6d4,

                    #8b5cf6,

                    #2563eb);

            background-size: 300%;

            animation: borderMove 6s linear infinite;

        }

        /* ==========================================
          TABLE HEADER AREA
========================================== */

        .table-top {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            padding-bottom: 18px;

            border-bottom: 1px solid #edf2f7;

        }

        .table-top h3 {

            margin: 0;

            font-size: 28px;

            font-weight: 700;

            color: #0f172a;

        }

        .table-top h3 i {

            margin-right: 10px;

            color: #2563eb;

        }

        .table-top small {

            display: block;

            margin-top: 8px;

            font-size: 14px;

            color: #64748b;

        }

        .table-top strong {

            color: #2563eb;

        }


        /* ==========================================
             HEADER
========================================== */

        .premium-table thead th {

            position: sticky;

            top: 0;

            z-index: 5;

            padding: 18px;

            font-size: 14px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 1px;

            text-align: center;

            border: none;

            color: #fff;

            background:

                linear-gradient(135deg,

                    #0f172a,

                    #1d4ed8);

        }

        .premium-table thead th:first-child {

            border-top-left-radius: 16px;

            border-bottom-left-radius: 16px;

        }

        .premium-table thead th:last-child {

            border-top-right-radius: 16px;

            border-bottom-right-radius: 16px;

        }

        /* ==========================================
               BODY
========================================== */

        .premium-table tbody tr {

            background: #fff;

            transition: .35s;

            box-shadow:

                0 8px 25px rgba(15, 23, 42, .05);

        }

        .premium-table tbody td {

            padding: 18px 15px;

            vertical-align: middle;

            border: none;

            font-size: 15px;

            color: #334155;

            background: #fff;

        }

        .premium-table tbody td:first-child {

            border-top-left-radius: 16px;

            border-bottom-left-radius: 16px;

            font-weight: 100;

            color: #2563eb;

        }

        .premium-table tbody td:last-child {

            border-top-right-radius: 16px;

            border-bottom-right-radius: 16px;

        }

        /* ==========================================
            ROW HOVER
========================================== */

        .premium-table tbody tr:hover {

            transform:

                translateY(-6px) scale(1.01);

            box-shadow:

                0 20px 45px rgba(37, 99, 235, .15);

        }

        .premium-table tbody tr:hover td {

            background:

                linear-gradient(90deg,

                    #ffffff,

                    #f8fbff);

        }

        /* ==========================================
         ZEBRA EFFECT
========================================== */

        .premium-table tbody tr:nth-child(even) td {

            background: #fbfcfe;

        }

        /* ==========================================
         COLUMN COLORS
========================================== */

        .premium-table tbody td:nth-child(1) {

            font-weight: 700;

            color: #2563eb;

        }

        .premium-table tbody td:nth-child(2) {

            font-weight: 700;

            color: #0f172a;

        }

        .premium-table tbody td:nth-child(3) {

            color: #7c3aed;

            font-weight: 600;

        }

        .premium-table tbody td:nth-child(4) {

            color: #64748b;

            max-width: 240px;

            line-height: 24px;

        }

        .premium-table tbody td:nth-child(5) {

            font-weight: 700;

            color: #10b981;

            font-size: 16px;

        }

        /* ==========================================
           IMAGE
========================================== */

        .premium-table img {

            width: 90px;
            margin-left: -1em;
            height: 90px;

            border-radius: 18px;

            object-fit: cover;

            border: 4px solid #fff;

            box-shadow:

                0 15px 35px rgba(0, 0, 0, .12);

            transition: .4s;

        }

        .premium-table img:hover {

            transform:

                scale(1.18) rotate(2deg);

            box-shadow:

                0 25px 50px rgba(37, 99, 235, .25);

        }

        /* ==========================================
         TABLE SCROLLBAR
========================================== */

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            display: block;
        }



        .table-responsive::-webkit-scrollbar {

            height: 9px;

        }

        .table-responsive::-webkit-scrollbar-thumb {

            background:

                linear-gradient(90deg,

                    #2563eb,

                    #06b6d4);

            border-radius: 20px;

        }

        /* ==========================================
           ANIMATION
========================================== */

        @keyframes tableFade {

            from {

                opacity: 0;

                transform: translateY(40px);

            }

            to {

                opacity: 1;

                transform: none;

            }

        }

        @keyframes borderMove {

            0% {

                background-position: 0%;

            }

            100% {

                background-position: 300%;

            }

        }


        /* ===========================================
             PRICE TAG
=========================================== */

        .price-tag {

            display: inline-flex;

            align-items: center;

            padding: 10px 10px;

            border-radius: 40px;

            font-weight: 700;

            font-size: 15px;

            color: #fff;

            background:

                linear-gradient(135deg, #10b981, #059669);

            box-shadow:

                0 10px 25px rgba(16, 185, 129, .25);

            transition: .35s;

        }

        .price-tag:hover {

            transform: translateY(-4px);

        }

        /* ===========================================
           STATUS BADGES
=========================================== */

        .status-badge {

            display: inline-flex;

            align-items: center;

            gap: 3px;

            padding: 10px 10px;

            border-radius: 50px;

            font-weight: 600;

            font-size: 14px;

            transition: .35s;

        }

        .status-active {

            background:

                linear-gradient(135deg, #22c55e, #16a34a);

            color: #fff;

            box-shadow:

                0 10px 25px rgba(34, 197, 94, .30);

        }

        .status-inactive {

            background:

                linear-gradient(135deg, #ef4444, #dc2626);

            color: #fff;

            box-shadow:

                0 10px 25px rgba(239, 68, 68, .30);

        }

        .status-badge:hover {

            transform:

                scale(1.06);

        }

        /* ===========================================
         PARENT CATEGORY
=========================================== */

        .parent-badge {

            display: inline-flex;

            align-items: center;

            gap: 4px;

            padding: 10px 8px;

            background:

                linear-gradient(135deg, #6366f1, #4338ca);

            color: #fff;

            font-weight: 600;

            border-radius: 40px;

            box-shadow:

                0 12px 25px rgba(99, 102, 241, .25);

        }

        /* ===========================================
            ACTION BUTTONS
=========================================== */

        .action-group {

            display: flex;

            justify-content: center;

            gap: 7px;

        }

        .action-btn {

            width: 44px;

            height: 44px;

            display: flex;

            justify-content: center;

            align-items: center;

            border-radius: 14px;

            text-decoration: none;

            font-size: 17px;

            transition: .35s;

            position: relative;

            overflow: hidden;

        }

        .action-btn::before {

            content: "";

            position: absolute;

            width: 120%;

            height: 120%;

            background:

                rgba(255, 255, 255, .15);

            transform:

                translateX(-150%) rotate(35deg);

            transition: .5s;

        }

        .action-btn:hover::before {

            transform:

                translateX(150%) rotate(35deg);

        }

        /* EDIT */

        .edit-btn {

            background:

                linear-gradient(135deg, #2563eb, #1d4ed8);

            color: #fff;

            box-shadow:

                0 12px 30px rgba(37, 99, 235, .28);

        }

        .edit-btn:hover {

            transform:

                translateY(-6px) rotate(-8deg);

            color: #fff;

        }

        /* DELETE */

        .delete-btn {

            background:

                linear-gradient(135deg, #ef4444, #dc2626);

            color: #fff;

            box-shadow:

                0 12px 30px rgba(239, 68, 68, .28);

        }

        .delete-btn:hover {

            transform:

                translateY(-6px) rotate(8deg);

            color: #fff;

        }

        /*==========================================
      PREMIUM SUBCATEGORY PAGE
==========================================*/

        body {

            background: #eef4fb;

            font-family: Poppins, sans-serif;

        }

        .main-content {

            margin: 30px 18%;

            width: 79%;

            animation: fadePage .8s;

        }

        /*================ HERO =================*/

        .subcategory-hero {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 35px;

            margin-bottom: 30px;

            border-radius: 28px;

            background:
                linear-gradient(135deg, #0f172a, #1d4ed8, #2563eb);

            color: #fff;

            overflow: hidden;

            position: relative;

            box-shadow:

                0 25px 60px rgba(37, 99, 235, .28);

        }

        .subcategory-hero::before {

            content: "";

            position: absolute;

            right: -70px;

            top: -70px;

            width: 240px;

            height: 240px;

            background: rgba(255, 255, 255, .08);

            border-radius: 50%;

        }

        .subcategory-hero::after {

            content: "";

            position: absolute;

            left: -80px;

            bottom: -80px;

            width: 180px;

            height: 180px;

            background: rgba(255, 255, 255, .06);

            border-radius: 50%;

        }

        .subcategory-hero h2 {

            font-size: 34px;

            font-weight: 700;

            margin-bottom: 10px;

            position: relative;

            z-index: 2;

        }

        .subcategory-hero p {

            font-size: 15px;

            opacity: .9;

            margin: 0;

            position: relative;

            z-index: 2;

        }

        /*================ ADD BUTTON =================*/

        .premium-add-btn {

            padding: 14px 28px;

            border-radius: 15px;

            text-decoration: none;

            font-weight: 600;

            color: #fff;

            background:

                linear-gradient(135deg, #06b6d4, #2563eb);

            transition: .35s;

            box-shadow:

                0 15px 35px rgba(0, 0, 0, .25);

            position: relative;

            z-index: 2;

            display: inline-flex;

            align-items: center;

            gap: 10px;

        }

        .premium-add-btn:hover {

            color: #fff;

            transform: translateY(-4px);

            box-shadow:

                0 20px 45px rgba(37, 99, 235, .45);

            background:

                linear-gradient(135deg, #0284c7, #1d4ed8);

        }

        /*================ CONTENT CARD =================*/

        .subcategory-card {

            background: #fff;

            border-radius: 28px;

            padding: 30px;

            box-shadow:

                0 18px 45px rgba(15, 23, 42, .08);

            border: 1px solid #eef2f7;

            overflow: hidden;

            animation: cardUp .8s;

        }

        /*================ TABLE =================*/

        .table {

            margin-bottom: 0;

            border-collapse: separate;

            border-spacing: 0;

        }

        .table thead tr {

            background:

                linear-gradient(135deg, #0f172a, #1e3a8a);

        }

        .table thead th {

            color: #fff;

            padding: 18px;

            border: none;

            font-size: 14px;

            font-weight: 600;

            letter-spacing: .4px;

            white-space: nowrap;

        }

        .table tbody td {

            padding: 16px;

            vertical-align: middle;

            border-bottom: 1px solid #edf2f7;

            transition: .35s;

        }

        .table tbody tr {

            transition: .35s;

        }

        .table tbody tr:hover {

            background: #f8fbff;

            transform: scale(1.01);

            box-shadow:

                0 8px 25px rgba(0, 0, 0, .06);

        }
    </style>

</head>

<body>
    <?php


    $limit = 5;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;

    $search = isset($_GET['search'])
        ? mysqli_real_escape_string($conn, $_GET['search'])
        : '';

    /* TOTAL RECORDS */
    $total_sql = "
SELECT COUNT(*) as total
FROM categories c
LEFT JOIN categories p
ON p.id = c.parent_id
WHERE 1
";

    if ($search != '') {
        $total_sql .= "
    AND (
        c.name LIKE '%$search%'
        OR c.slug LIKE '%$search%'
        OR c.descri LIKE '%$search%'
        OR p.name LIKE '%$search%'
    )
    ";
    }

    $total_query = mysqli_query($conn, $total_sql);
    $total_row = mysqli_fetch_assoc($total_query);

    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    if ($total_pages < 1) {
        $total_pages = 1;
    }

    /* MAIN QUERY */
    $sql = "
SELECT c.*,
       IFNULL(p.name,'Main Category') AS parent_name
FROM categories c
LEFT JOIN categories p
ON p.id = c.parent_id
WHERE 1
";

    if ($search != '') {
        $sql .= "
    AND (
        c.name LIKE '%$search%'
        OR c.slug LIKE '%$search%'
        OR c.descri LIKE '%$search%'
        OR p.name LIKE '%$search%'
    )
    ";
    }

    $sql .= "
ORDER BY c.id ASC
LIMIT $offset,$limit
";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die(mysqli_error($conn));
    }
    ?>
    <div class="container" style="margin-left:-1%; min-width:102%; ">



        <!-- sidebar -->
        <?php
        include "sidebar.php";

        ?>

        <!-- header -->
        <?php
        include "header.php";
        ?>
        <div>

        </div>


    </div>
    </div>



    <!-- <div class="table-responsive" style="margin:3% 19%; width:80%;">
      <div class="d-flex justify-content-between" >
          <h1 class="title" >Category Details</h1>
          <a href="add_category.php"><button class="btn btn-primary">
              <i class="fas fa-plus"></i>
              Add New
            </button></a>
      </div> 
        <table class="table table-bordered">
            <thead>
                <tr class="table-info text-white"  >
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Parent Category</th>
                    <th>Action</th>
                </tr>
            </thead>
     <tbody> -->

    <!-- ===========================
        PREMIUM MAIN CONTENT
=========================== -->

    <div class="main-content">

        <!-- Hero Section -->

        <div class="hero-section">

            <div class="hero-left">

                <span class="hero-tag">
                    <i class="fas fa-layer-group"></i>
                    Category Management
                </span>

                <h1>
                    Premium Category Dashboard
                </h1>

                <p>
                    Manage product categories with a modern enterprise interface.
                </p>

            </div>

            <div class="hero-right">

                <a href="add_category.php" class="btn btn-add-category">

                    <i class="fas fa-plus-circle"></i>

                    Add New Category

                </a>

            </div>

        </div>


        <!-- Analytics Cards -->

        <div class="dashboard-grid">

            <!-- Total -->

            <div class="dashboard-card blue">

                <div class="card-icon">

                    <i class="fas fa-layer-group"></i>

                </div>

                <div>

                    <h2>

                        <?php

                        $total = mysqli_fetch_assoc(mysqli_query($conn, "
                    SELECT COUNT(*) total
                    FROM categories"));

                        echo $total['total'];

                        ?>

                    </h2>

                    <span>Total Categories</span>

                </div>

            </div>



            <!-- Active -->

            <div class="dashboard-card green">

                <div class="card-icon">

                    <i class="fas fa-check-circle"></i>

                </div>

                <div>

                    <h2>

                        <?php

                        $active = mysqli_fetch_assoc(mysqli_query($conn, "
                    SELECT COUNT(*) total
                    FROM categories
                    WHERE status=1"));

                        echo $active['total'];

                        ?>

                    </h2>

                    <span>Active Categories</span>

                </div>

            </div>



            <!-- Inactive -->

            <div class="dashboard-card red">

                <div class="card-icon">

                    <i class="fas fa-ban"></i>

                </div>

                <div>

                    <h2>

                        <?php

                        $inactive = mysqli_fetch_assoc(mysqli_query($conn, "
                    SELECT COUNT(*) total
                    FROM categories
                    WHERE status=0"));

                        echo $inactive['total'];

                        ?>

                    </h2>

                    <span>Inactive</span>

                </div>

            </div>



            <!-- Parent -->

            <div class="dashboard-card purple">

                <div class="card-icon">

                    <i class="fas fa-sitemap"></i>

                </div>

                <div>

                    <h2>

                        <?php

                        $parent = mysqli_fetch_assoc(mysqli_query($conn, "
                    SELECT COUNT(*) total
                    FROM categories
                    WHERE parent_id=0"));

                        echo $parent['total'];

                        ?>

                    </h2>

                    <span>Main Categories</span>

                </div>

            </div>

        </div>


        <!-- Premium Table -->

        <div class="premium-table-card">

            <div class="table-top">

                <div>

                    <h3>

                        <i class="fas fa-table"></i>

                        Category Directory

                    </h3>

                    <small>

                        Total Records :

                        <strong>

                            <?php echo $total_records; ?>

                        </strong>

                    </small>

                </div>



            </div>


            <!-- <div class="table-responsive"> -->

            <table class="table premium-table align-middle">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Category</th>

                        <th>Slug</th>

                        <th>Description</th>

                        <th>Price</th>

                        <th>Image</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th>Parent</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    <!-- &#8377; rupee symbol -->
                    <?php
                    //    $key = "";
                    if (mysqli_num_rows($res) > 0) {
                        // foreach ($data as $key => $row) {
                        while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['slug']; ?></td>
                                <td><?php echo $row['descri']; ?></td>
                                <!-- <td>₹<?php echo $row['price']; ?> </td> -->
                                <td>
                                    <span class="price-tag">
                                        ₹<?php echo number_format($row['price'], 2); ?>
                                    </span>
                                </td>
                                <td><img src="<?php echo !empty($row['image']) ? '../images/' . $row['image'] : '../images/default.avif'; ?>" style="height: 100px ; width:150%;" /></td>
                                <!-- <td>
                                <?php echo $row['status'] ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>' ?>
                            </td> -->

                                <td>

                                    <?php if ($row['status']) { ?>

                                        <span class="status-badge status-active">

                                            <i class="fa-solid fa-circle-check"></i>

                                            Active

                                        </span>

                                    <?php } else { ?>

                                        <span class="status-badge status-inactive">

                                            <i class="fa-solid fa-circle-xmark"></i>

                                            Inactive

                                        </span>

                                    <?php } ?>

                                </td>
                                <!-- <td><?php echo date("d M Y h:i:s A", strtotime($row['create_at'])) ?></td> -->
                                <td>
                                    <?php
                                    echo !empty($row['create_at'])
                                        ? date("d M Y h:i:s A", strtotime($row['create_at']))
                                        : '-';
                                    ?>
                                </td>

                                <!-- <td>

                            <?php
                            // echo ($row['parent_id'] == 0) 
                            //     ? 'Main Category' 
                            //     : $row['parent_name']; 
                            echo $row['parent_name'];
                            ?>
                            </td> -->

                                <td>

                                    <span class="parent-badge">

                                        <i class="fa-solid fa-folder-tree"></i>

                                        <?php echo $row['parent_name']; ?>

                                    </span>

                                </td>

                                <!-- <td>
                                <a href="edit_category.php?id=<?php echo $row['id']; ?>"  ><i class="fa-solid fa-pen-to-square"  style="color:darkblue;"></i></a>
                                <a href="delete_action.php?type=categories&id=<?php echo $row['id']; ?>  & btn=user"  onclick="return confirm('Are you sure to delete this Category?')"><i class="fa-solid fa-trash" style="color:red;"></i></a>

                            </td> -->

                                <td>

                                    <div class="action-group">

                                        <a
                                            href="edit_category.php?id=<?php echo $row['id']; ?>"
                                            class="action-btn edit-btn">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        <!-- <a
href="delete_action.php?type=categories&id=<?php echo $row['id']; ?>&btn=user"
class="action-btn delete-btn"
onclick="return confirm('Delete this category?')">

<i class="fa-solid fa-trash"></i>

</a> -->

                                        <a
                                            href="delete_action.php?type=categories&id=<?php echo $row['id']; ?>&btn=user"
                                            class="action-btn delete-btn"
                                            onclick="openDeleteCard(event, this.href)">

                                            <i class="fa-solid fa-trash"></i>

                                        </a>

                                    </div>

                                </td>
                            </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4" class="text-danger text-center">No record Found.</td>
                        </tr>
                    <?php  } ?>

                </tbody>
            </table>



            <div class="text-center mt-4">

                <?php if ($page > 1) { ?>
                    <a class="btn btn-primary"
                        href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                        ← Previous
                    </a>
                <?php } ?>

                <?php for ($p = 1; $p <= $total_pages; $p++) { ?>
                    <a class="btn <?php echo ($p == $page) ? 'btn-dark' : 'btn-outline-primary'; ?>"
                        href="?page=<?php echo $p; ?>&search=<?php echo urlencode($search); ?>">
                        <?php echo $p; ?>
                    </a>
                <?php } ?>

                <?php if ($page < $total_pages) { ?>
                    <a class="btn btn-primary"
                        href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
                        Next →
                    </a>
                <?php } ?>

            </div>



            <script type="text/javascript" src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

            <div class="delete-overlay" id="deleteOverlay">

                <div class="delete-card">

                    <button class="delete-close" onclick="closeDeleteCard()">
                        &times;
                    </button>

                    <div class="delete-icon">
                        <i class="fa-solid fa-trash"></i>
                    </div>

                    <h3>Delete Category?</h3>

                    <p>
                        Are you sure you want to delete this category?
                        This action cannot be undone.
                    </p>

                    <div class="delete-actions">

                        <button
                            type="button"
                            class="cancel-delete"
                            onclick="closeDeleteCard()">

                            Cancel

                        </button>

                        <a
                            href="#"
                            id="confirmDeleteBtn"
                            class="confirm-delete">

                            Yes, Delete

                        </a>

                    </div>

                </div>

            </div>

            <script>
                function openDeleteCard(event, deleteUrl) {

                    event.preventDefault();

                    document
                        .getElementById("deleteOverlay")
                        .classList
                        .add("show");

                    document
                        .getElementById("confirmDeleteBtn")
                        .href = deleteUrl;
                }


                function closeDeleteCard() {

                    document
                        .getElementById("deleteOverlay")
                        .classList
                        .remove("show");
                }
            </script>
</body>

</html>