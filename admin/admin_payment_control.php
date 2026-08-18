<?php

session_start();
global $conn;
include "includes/db_connect.php";
include "function.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_payment'])) {

    $id = (int)$_POST['id'];
    $payment_status = $_POST['payment_status'];

    $allowed_status = ['Pending', 'Paid', 'Failed'];

    if (in_array($payment_status, $allowed_status)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE userorder 
             SET payment_status = ? 
             WHERE id = ? AND is_deleted = 0"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $payment_status,
            $id
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


/** @var mysqli $conn */

?>
<!DOCTYPE html>
<html>

<head>

    <link rel="icon" type="image/png" href="weblogo.png">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

    <link rel="stylesheet" href="admin_panel.css">
    <title>Payment Control</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #eef2f7, #f8fafc);
            animation: fadeBody 0.6s ease-in;
        }

        /* FADE IN PAGE */
        @keyframes fadeBody {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CONTAINER */
        .container {
            width: 96%;
            margin: auto;
        }

        /* TITLE */
        .title {
            font-size: 28px;
            font-weight: 800;
            color: #111827;
            letter-spacing: 0.5px;
            animation: slideLeft 0.5s ease-in;
        }

        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* FILTER BUTTONS */
        .filter a {
            padding: 10px 18px;
            border-radius: 30px;
            background: rgba(17, 24, 39, 0.9);
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            margin-right: 8px;
            display: inline-block;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .filter a:hover {
            background: #2563eb;
            transform: translateY(-3px) scale(1.05);
        }

        /* TABLE CARD */
        .table {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            animation: fadeUp 0.5s ease-in;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* HEADER */
        thead.table-info {
            background: linear-gradient(90deg, #111827, #1f2937) !important;
            color: white;
        }

        /* ROW ANIMATION */
        tr {
            transition: 0.25s;
        }

        tr:hover {
            background: #f1f5f9 !important;
            transform: scale(1.01);
        }

        /* CELLS */
        th,
        td {
            padding: 14px !important;
            font-size: 14px;
            vertical-align: middle !important;
        }

        /* BADGES */
        .paid {
            background: #16a34a;
            color: white;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.3);
        }

        .pending {
            background: #f59e0b;
            color: white;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .failed {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        /* SELECT */
        select {
            padding: 6px;
            border-radius: 8px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.2s;
        }

        select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }

        /* BUTTON */
        button {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 600;
        }

        button:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        /* PAGINATION */
        .btn {
            border-radius: 8px;
            padding: 6px 12px;
            margin: 3px;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* IMAGE */
        img {
            border-radius: 10px;
        }

        /* GLASS EFFECT HEADER AREA (optional enhancement) */
        .table-responsive {
            backdrop-filter: blur(6px);
        }

        /*==========================
PAYMENT SUMMARY
==========================*/

        .payment-cards {

            display: grid;

            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));

            gap: 25px;

            margin: 25px 18%;

            width: 80%;

        }

        .pay-card {

            background: white;

            border-radius: 18px;

            padding: 25px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

            transition: .35s;

            position: relative;

            overflow: hidden;

        }

        .pay-card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            width: 6px;

            height: 100%;

        }

        .pay-card.total::before {

            background: #3b82f6;

        }

        .pay-card.success::before {

            background: #16a34a;

        }

        .pay-card.pending::before {

            background: #f59e0b;

        }

        .pay-card.failed::before {

            background: #ef4444;

        }

        .pay-card:hover {

            transform: translateY(-8px);

        }

        .pay-card h5 {

            font-size: 14px;

            color: #777;

            margin-bottom: 8px;

        }

        .pay-card h2 {

            font-weight: 800;

            margin: 0;

        }

        .pay-card i {

            font-size: 45px;

            opacity: .15;

        }

        /*==========================
TABLE
==========================*/

        .payment-table {

            background: white;

            border-radius: 20px;

            overflow: hidden;

            box-shadow: 0 15px 45px rgba(0, 0, 0, .08);

        }

        .payment-table table {

            margin: 0;

        }

        .payment-table thead {

            background: linear-gradient(90deg, #111827, #1e293b);

            color: white;

        }

        .payment-table th {

            padding: 18px;

            font-size: 14px;

            font-weight: 700;

            border: none;

        }

        .payment-table td {

            padding: 18px;

            border-bottom: 1px solid #f0f0f0;

        }

        .payment-table tbody tr {

            transition: .3s;

        }

        .payment-table tbody tr:hover {

            background: #f8fbff;

            transform: scale(1.01);

        }

        /*==========================
CUSTOMER
==========================*/

        .customer-box {

            display: flex;

            align-items: center;

            gap: 12px;

        }

        .avatar {

            width: 48px;

            height: 48px;

            border-radius: 50%;

            background: linear-gradient(135deg, #3b82f6, #2563eb);

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 18px;

            font-weight: bold;

        }

        .name {

            font-weight: 700;

        }

        .phone {

            font-size: 12px;

            color: #888;

        }

        /*==========================
METHOD
==========================*/

        .method {

            padding: 8px 16px;

            border-radius: 40px;

            font-size: 13px;

            font-weight: 700;

            display: inline-flex;

            gap: 8px;

            align-items: center;

        }

        .online {

            background: #dbeafe;

            color: #2563eb;

        }

        .cod {

            background: #fef3c7;

            color: #92400e;

        }

        /*==========================
AMOUNT
==========================*/

        .amount {

            font-size: 18px;

            font-weight: 800;

            color: #111827;

        }

        /*==========================
BUTTON
==========================*/

        .updateBtn {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            padding: 10px 18px;

            border: none;

            border-radius: 10px;

            color: white;

            font-weight: 600;

            transition: .3s;

        }

        .updateBtn:hover {

            transform: translateY(-3px);

            box-shadow: 0 10px 25px rgba(37, 99, 235, .35);

        }

        /*==========================
STATUS
==========================*/

        .paid,
        .pending,
        .failed {

            padding: 8px 18px;

            border-radius: 30px;

            font-weight: 700;

            font-size: 13px;

            display: inline-block;

        }


        /*==============================
 GOOGLE FONT
==============================*/
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {

            background: #f4f7fb;

            background-image:

                radial-gradient(circle at top left, #dbeafe 0%, transparent 30%),

                radial-gradient(circle at bottom right, #ede9fe 0%, transparent 35%);

            min-height: 100vh;

            overflow-x: hidden;

        }


        /*==============================
CUSTOM SCROLLBAR
==============================*/

        ::-webkit-scrollbar {

            width: 10px;

        }

        ::-webkit-scrollbar-thumb {

            background: #3b82f6;

            border-radius: 20px;

        }

        ::-webkit-scrollbar-track {

            background: #eef2ff;

        }


        /*==============================
PAGE CONTAINER
==============================*/

        .main-wrapper {

            margin-left: 18%;

            width: 80%;

            padding: 25px;

        }


        /*==============================
PAGE TITLE
==============================*/

        .page-title {

            font-size: 30px;

            font-weight: 800;

            color: #1e293b;

            margin-bottom: 5px;

        }

        .page-subtitle {

            font-size: 14px;

            color: #64748b;

            margin-bottom: 25px;

        }


        /*==============================
TOP HEADER CARD
==============================*/

        .hero-card {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            border-radius: 24px;

            padding: 35px;

            color: #fff;

            position: relative;

            overflow: hidden;

            box-shadow: 0 20px 40px rgba(37, 99, 235, .25);

            margin-bottom: 30px;

            animation: fadeUp .5s;

        }

        .hero-card::before {

            content: "";

            position: absolute;

            right: -80px;

            top: -80px;

            width: 260px;

            height: 260px;

            background: rgba(255, 255, 255, .08);

            border-radius: 50%;

        }

        .hero-card::after {

            content: "";

            position: absolute;

            bottom: -70px;

            left: -70px;

            width: 180px;

            height: 180px;

            background: rgba(255, 255, 255, .08);

            border-radius: 50%;

        }

        .hero-card h2 {

            font-size: 32px;

            font-weight: 800;

            margin-bottom: 8px;

        }

        .hero-card p {

            opacity: .9;

            font-size: 15px;

        }


        /*==============================
SUMMARY CARDS
==============================*/

        .dashboard-cards {

            display: grid;

            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));

            gap: 22px;

            margin-bottom: 30px;

        }

        .stat-card {

            background: #fff;

            border-radius: 22px;

            padding: 22px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .07);

            position: relative;

            overflow: hidden;

            transition: .35s;

        }

        .stat-card:hover {

            transform: translateY(-8px);

            box-shadow: 0 25px 45px rgba(0, 0, 0, .12);

        }

        .stat-card::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            width: 6px;

            height: 100%;

        }

        .stat-card.blue::before {

            background: #2563eb;

        }

        .stat-card.green::before {

            background: #22c55e;

        }

        .stat-card.orange::before {

            background: #f59e0b;

        }

        .stat-card.red::before {

            background: #ef4444;

        }

        .stat-card h6 {

            font-size: 13px;

            color: #64748b;

            margin-bottom: 10px;

            font-weight: 600;

        }

        .stat-card h3 {

            font-size: 30px;

            font-weight: 800;

            color: #111827;

        }

        .stat-card i {

            position: absolute;

            right: 20px;

            top: 20px;

            font-size: 50px;

            opacity: .08;

        }


        /*==============================
FILTER BAR
==============================*/

        .toolbar {

            background: #fff;

            padding: 20px;

            border-radius: 20px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            box-shadow: 0 8px 25px rgba(0, 0, 0, .06);

            flex-wrap: wrap;

            gap: 15px;

        }

        .search-box {

            position: relative;

            width: 350px;

        }

        .search-box input {

            width: 100%;

            padding: 13px 18px 13px 48px;

            border: none;

            border-radius: 14px;

            background: #f8fafc;

            font-size: 14px;

            transition: .3s;

        }

        .search-box input:focus {

            outline: none;

            background: #fff;

            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);

        }

        .search-box i {

            position: absolute;

            left: 18px;

            top: 15px;

            color: #94a3b8;

        }

        .filter-buttons {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;

        }

        .filter-buttons a {

            text-decoration: none;

            padding: 10px 18px;

            background: #eff6ff;

            color: #2563eb;

            font-weight: 600;

            border-radius: 30px;

            transition: .3s;

        }

        .filter-buttons a:hover {

            background: #2563eb;

            color: #fff;

            transform: translateY(-3px);

        }


        /*==============================
PREMIUM TABLE
==============================*/

        .payment-card {
            width: 70em;
            margin-left: -12em;
            background: #fff;

            border-radius: 22px;

            padding: 20px;

            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

            overflow: hidden;

        }

        .payment-card table {

            margin: 0;

            border-collapse: separate;

            border-spacing: 0 12px;

        }

        .payment-card thead th {

            background: #111827;

            color: #fff;

            padding: 18px;

            border: none;

            font-size: 14px;

            font-weight: 700;

        }

        .payment-card thead th:first-child {

            border-radius: 14px 0 0 14px;

        }

        .payment-card thead th:last-child {

            border-radius: 0 14px 14px 0;

        }

        .payment-card tbody tr {

            background: #fff;

            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);

            transition: .3s;

        }

        .payment-card tbody tr:hover {

            transform: translateY(-4px);

            box-shadow: 0 18px 35px rgba(0, 0, 0, .09);

        }

        .payment-card td {

            padding: 18px;

            border: none;

            vertical-align: middle;

        }


        /*==============================
STATUS BADGES
==============================*/

        .paid,

        .pending,

        .failed {

            display: inline-block;

            padding: 8px 18px;

            border-radius: 40px;

            font-size: 13px;

            font-weight: 700;

        }

        .paid {

            background: #dcfce7;

            color: #15803d;

        }

        .pending {

            background: #fef3c7;

            color: #b45309;

        }

        .failed {

            background: #fee2e2;

            color: #dc2626;

        }


        /*==============================
PAYMENT METHOD
==============================*/

        .method {

            padding: 8px 15px;

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;

            display: inline-flex;

            align-items: center;

            gap: 8px;

        }

        .method.online {

            background: #dbeafe;

            color: #2563eb;

        }

        .method.cod {

            background: #fff7ed;

            color: #c2410c;

        }


        /*==============================
BUTTON
==============================*/

        .updateBtn {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            border: none;

            padding: 10px 18px;

            color: #fff;

            border-radius: 12px;

            font-weight: 600;

            transition: .3s;

        }

        .updateBtn:hover {

            transform: translateY(-3px);

            box-shadow: 0 10px 25px rgba(37, 99, 235, .35);

        }


        /*==============================
SELECT
==============================*/

        select {

            padding: 10px 14px;

            border-radius: 12px;

            border: 1px solid #dbe4f0;

            background: #fff;

            font-size: 14px;

            margin-right: 8px;

        }

        select:focus {

            outline: none;

            border-color: #2563eb;

            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);

        }


        /*==============================
PAGINATION
==============================*/

        .pagination-area {

            display: flex;

            justify-content: center;

            gap: 10px;

            margin-top: 30px;

        }

        .pagination-area a {

            text-decoration: none;

            padding: 10px 18px;

            background: #fff;

            color: #334155;

            border-radius: 12px;

            font-weight: 600;

            box-shadow: 0 5px 15px rgba(0, 0, 0, .06);

            transition: .3s;

        }

        .pagination-area a:hover {

            background: #2563eb;

            color: #fff;

            transform: translateY(-3px);

        }

        .pagination-area .active {

            background: #2563eb;

            color: #fff;

        }


        /*==============================
ANIMATION
==============================*/

        @keyframes fadeUp {

            from {

                opacity: 0;

                transform: translateY(20px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }


        /*==============================
RESPONSIVE
==============================*/

        @media(max-width:992px) {

            .main-wrapper {

                margin-left: 0;

                width: 100%;

                padding: 15px;

            }

            .toolbar {

                flex-direction: column;

                align-items: stretch;

            }

            .search-box {

                width: 100%;

            }

            .dashboard-cards {

                grid-template-columns: 1fr;

            }

        }

        /*=========================
PREMIUM TABLE
=========================*/

        .premium-payment-table {

            border-collapse: separate;

            border-spacing: 0 14px;

        }

        .premium-payment-table tbody tr {

            background: white;

            transition: .35s;

            box-shadow: 0 8px 22px rgba(0, 0, 0, .06);

        }

        .premium-payment-table tbody tr:hover {

            transform: translateY(-6px);

            box-shadow: 0 18px 40px rgba(0, 0, 0, .10);

        }

        .premium-payment-table td {

            border: none;

            padding: 22px 18px;

            vertical-align: middle;

        }

        .order-box {

            font-weight: 700;

            color: #2563eb;

            font-size: 15px;

        }

        .customer-info {

            display: flex;

            align-items: center;

            gap: 15px;

        }

        .customer-avatar {

            width: 55px;

            height: 55px;

            border-radius: 50%;

            background: linear-gradient(135deg, #3b82f6, #2563eb);

            display: flex;

            justify-content: center;

            align-items: center;

            color: white;

            font-size: 20px;

            font-weight: 700;

        }

        .customer-name {

            font-weight: 700;

            font-size: 15px;

            color: #1e293b;

        }

        .customer-phone {

            font-size: 13px;

            color: #64748b;

            margin-top: 4px;

        }

        .payment-method {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 10px 18px;

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;

        }

        .payment-method.online {

            background: #dbeafe;

            color: #2563eb;

        }

        .payment-method.cod {

            background: #fff7ed;

            color: #c2410c;

        }

        .amount-box {

            font-size: 22px;

            font-weight: 800;

            color: #0f172a;

        }

        .status-pill {

            display: inline-block;

            padding: 9px 18px;

            border-radius: 40px;

            font-size: 13px;

            font-weight: 700;

        }

        .status-pill.paid {

            background: #dcfce7;

            color: #15803d;

        }

        .status-pill.pending {

            background: #fef3c7;

            color: #b45309;

        }

        .status-pill.failed {

            background: #fee2e2;

            color: #dc2626;

        }

        .action-form {

            display: flex;

            align-items: center;

            gap: 10px;

        }

        .action-form select {

            min-width: 120px;

        }

        .saveBtn {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            color: white;

            border: none;

            padding: 10px 20px;

            border-radius: 12px;

            font-weight: 600;

            transition: .3s;

        }

        .saveBtn:hover {

            transform: translateY(-3px);

            box-shadow: 0 10px 20px rgba(37, 99, 235, .30);

        }


        /*==============================
PAGINATION
==============================*/

        .pagination-wrapper {

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 12px;

            margin-top: 35px;

            flex-wrap: wrap;

        }

        .page-btn {

            background: white;

            padding: 12px 18px;

            border-radius: 14px;

            text-decoration: none;

            color: #1e293b;

            font-weight: 600;

            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);

            transition: .3s;

        }

        .page-btn:hover {

            background: #2563eb;

            color: white;

            transform: translateY(-4px);

        }

        .page-btn.active {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

            color: white;

        }

        /*==============================
EMPTY STATE
==============================*/

        .empty-state {

            padding: 60px;

            text-align: center;

        }

        .empty-state i {

            font-size: 65px;

            color: #cbd5e1;

            margin-bottom: 20px;

        }

        .empty-state h3 {

            font-weight: 700;

            color: #334155;

            margin-bottom: 10px;

        }

        .empty-state p {

            color: #94a3b8;

            font-size: 15px;

        }

        /*==============================
TABLE ANIMATION
==============================*/

        .premium-payment-table tbody tr {

            animation: fadeRow .4s ease;

        }

        @keyframes fadeRow {

            from {

                opacity: 0;

                transform: translateY(20px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }
        }

        /*==============================
STATUS GLOW
==============================*/

        .status-pill.paid {

            box-shadow: 0 0 15px rgba(34, 197, 94, .25);

        }

        .status-pill.pending {

            box-shadow: 0 0 15px rgba(245, 158, 11, .25);

        }

        .status-pill.failed {

            box-shadow: 0 0 15px rgba(239, 68, 68, .25);

        }

        /*==============================
CARD HOVER
==============================*/

        .stat-card:hover i {

            transform: scale(1.2) rotate(10deg);

            transition: .4s;

        }

        /*==============================
BUTTON RIPPLE
==============================*/

        .saveBtn {

            position: relative;

            overflow: hidden;

        }

        .saveBtn::after {

            content: "";

            position: absolute;

            width: 0;

            height: 0;

            background: rgba(255, 255, 255, .35);

            border-radius: 50%;

            left: 50%;

            top: 50%;

            transform: translate(-50%, -50%);

            transition: .45s;

        }

        .saveBtn:hover::after {

            width: 220px;

            height: 220px;

        }

        /*==============================
RESPONSIVE
==============================*/

        @media(max-width:992px) {

            .hero-card {

                padding: 25px;

            }

            .hero-card h2 {

                font-size: 24px;

            }

            .customer-info {

                flex-direction: column;

                text-align: center;

            }

            .action-form {

                flex-direction: column;

            }

            .action-form select,

            .saveBtn {

                width: 100%;

            }

            .premium-payment-table {

                min-width: 900px;

            }

        }
    </style>
</head>

<body>
    <?php



    $limit = 5;

    /* ---------------- PAGE SAFE CHECK ---------------- */
    $page = $_GET['page'] ?? 1;

    if (!ctype_digit(strval($page))) {
        $page = 1;
    } else {
        $page = (int)$page;
    }

    /* ---------------- SEARCH ---------------- */
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $search_escaped = mysqli_real_escape_string($conn, $search);

    /* ---------------- PAYMENT TYPE FILTER ---------------- */
    $type = $_GET['type'] ?? 'all'; // all | online | cod

    /* ---------------- OFFSET ---------------- */
    $offset = ($page - 1) * $limit;

    /* ---------------- WHERE CONDITION ---------------- */
    $where = "WHERE is_deleted = 0";

    /* SEARCH FILTER */
    if ($search != '') {
        $where .= " AND (
        customer_name LIKE '%$search_escaped%'
        OR order_number LIKE '%$search_escaped%'
        OR product_name LIKE '%$search_escaped%'
        OR payment_status LIKE '%$search_escaped%'
        OR order_status LIKE '%$search_escaped%'
    )";
    }

    /* PAYMENT FILTER */
    if ($type == 'online') {
        $where .= " AND payment_method != 'Cash On Delivery'";
    }

    if ($type == 'cod') {
        $where .= " AND payment_method = 'Cash On Delivery'";
    }

    /* ---------------- TOTAL RECORDS ---------------- */
    $total_sql = "SELECT COUNT(*) AS total FROM userorder $where";
    $total_query = mysqli_query($conn, $total_sql);

    if (!$total_query) {
        die("Count Query Error: " . mysqli_error($conn));
    }

    $total_row = mysqli_fetch_assoc($total_query);
    $total_records = (int)$total_row['total'];

    /* ---------------- TOTAL PAGES ---------------- */
    $total_pages = ceil($total_records / $limit);

    if ($total_pages < 1) {
        $total_pages = 1;
    }

    if ($page > $total_pages) {
        $page = $total_pages;
    }

    /* FIX OFFSET AGAIN AFTER PAGE CHANGE */
    $offset = ($page - 1) * $limit;

    /* ---------------- MAIN QUERY ---------------- */
    $sql = "SELECT * FROM userorder $where ORDER BY id DESC LIMIT $limit OFFSET $offset";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Main Query Error: " . mysqli_error($conn));
    }

    ?>

    <div class="container" style="margin-left:-1%; min-width:102%;">

        <?php include "sidebar.php"; ?>

        <?php include "header.php"; ?>
        <div class="">

        </div>
    </div>

    </div>

    <!-- <div class="payment-cards"  style="margin:2% 21%; ">

    <div class="pay-card total">
        <div>
            <h5>Total Orders</h5>
            <h2><?= $total_records ?></h2>
        </div>
        <i class="fa-solid fa-cart-shopping"></i>
    </div>

    <div class="pay-card success">
        <div>
            <h5>Paid</h5>
            <h2>
                <?php
                $paid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM userorder WHERE payment_status='Paid' AND is_deleted=0"));
                echo $paid['total'];
                ?>
            </h2>
        </div>
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <div class="pay-card pending">
        <div>
            <h5>Pending</h5>
            <h2>
                <?php
                $pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM userorder WHERE payment_status='Pending' AND is_deleted=0"));
                echo $pending['total'];
                ?>
            </h2>
        </div>
        <i class="fa-solid fa-clock"></i>
    </div>

    <div class="pay-card failed">
        <div>
            <h5>Failed</h5>
            <h2>
                <?php
                $failed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) total FROM userorder WHERE payment_status='Failed' AND is_deleted=0"));
                echo $failed['total'];
                ?>
            </h2>
        </div>
        <i class="fa-solid fa-circle-xmark"></i>
    </div>

</div> -->


    <!-- <div class="table-responsive" style="margin:3% 18%; width:80%;">

    <div class="d-flex justify-content-between align-items-center mb-3"  style="margin:1% 3%; ">

            <h1  class="title">💳 Admin Payment Control Panel</h1>

<div class="filter mb-3">
    <a href="?type=all">All</a>
    <a href="?type=online">Online</a>
    <a href="?type=cod">Cash On Delivery</a>
</div>

</div> -->

    <div class="main-wrapper">

        <div class="hero-card">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h2>
                        <i class="fa-solid fa-credit-card"></i>
                        Payment Control
                    </h2>

                    <p>
                        Manage customer payments, monitor transactions and update payment status.
                    </p>

                </div>

                <div class="text-end">

                    <h5 style="font-weight:700;">
                        <i class="fa-solid fa-calendar-days"></i>

                        <?= date("d M Y"); ?>

                    </h5>

                    <small>Administrator Dashboard</small>

                </div>

            </div>

        </div>

        <?php

        $totalOrder = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM userorder
WHERE is_deleted=0
"));

        $paid = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM userorder
WHERE payment_status='Paid'
AND is_deleted=0
"));

        $pending = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM userorder
WHERE payment_status='Pending'
AND is_deleted=0
"));

        $failed = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM userorder
WHERE payment_status='Failed'
AND is_deleted=0
"));

        $revenue = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(grand_total) total
FROM userorder
WHERE payment_status='Paid'
AND is_deleted=0
"));

        ?>

        <div class="dashboard-cards">

            <div class="stat-card blue">

                <i class="fa-solid fa-cart-shopping"></i>

                <h6>Total Orders</h6>

                <h3><?= $totalOrder['total']; ?></h3>

            </div>

            <div class="stat-card green">

                <i class="fa-solid fa-circle-check"></i>

                <h6>Paid</h6>

                <h3><?= $paid['total']; ?></h3>

            </div>

            <div class="stat-card orange">

                <i class="fa-solid fa-clock"></i>

                <h6>Pending</h6>

                <h3><?= $pending['total']; ?></h3>

            </div>

            <div class="stat-card red">

                <i class="fa-solid fa-circle-xmark"></i>

                <h6>Failed</h6>

                <h3><?= $failed['total']; ?></h3>

            </div>

            <div class="stat-card blue">

                <i class="fa-solid fa-wallet"></i>

                <h6>Revenue</h6>

                <h3>

                    ₹<?= number_format($revenue['total'] ?? 0); ?>

                </h3>

            </div>

        </div>

        <div class="toolbar">

            <form method="GET" class="search-box">

                <i class="fa-solid fa-search"></i>

                <input

                    type="text"

                    name="search"

                    placeholder="Search order number, customer..."

                    value="<?= htmlspecialchars($search); ?>">

            </form>

            <div class="filter-buttons">

                <a href="?type=all">

                    <i class="fa-solid fa-layer-group"></i>

                    All

                </a>

                <a href="?type=online">

                    <i class="fa-solid fa-credit-card"></i>

                    Online

                </a>

                <a href="?type=cod">

                    <i class="fa-solid fa-money-bill-wave"></i>

                    COD

                </a>

            </div>

            <div id="liveClock"></div>

        </div>

        <!-- <table class="table table-bordered table-striped align-middle">

<thead class="table-info text-center">

<tr>
    <th>Order No</th>
    <th>Customer</th>
    <th>Method</th>
    <th>Amount</th>
    <th>Status</th>
    <th>Action</th>
</tr>

</thead> -->

        <!-- <div class="payment-table"  style="margin:3% 3%; width:80%;"> -->

        <div class="main-wrapper">

            <div class="payment-card">

                <!-- <table class="table align-middle mb-0">

<thead>

<tr>

<th>#</th>
<th>Customer</th>
<th>Payment</th>
<th>Amount</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody> -->

                <table class="table premium-payment-table align-middle">

                    <thead>

                        <tr>

                            <th width="8%">Order</th>

                            <th width="28%">Customer</th>

                            <th width="15%">Payment</th>

                            <th width="12%">Amount</th>

                            <th width="15%">Status</th>

                            <th width="22%">Action</th>

                        </tr>

                    </thead>

                    <tbody>






                        <!-- <?php while ($row = mysqli_fetch_assoc($res)) { ?> -->

                        <?php

                                    if (mysqli_num_rows($res) > 0) {

                                        while ($row = mysqli_fetch_assoc($res)) {

                        ?>

                                <!-- <tr>
    <td><?php echo $row['order_number']; ?></td>


    <td>

<div class="customer-box">

<div class="avatar">
<?= strtoupper(substr($row['customer_name'], 0, 1)); ?>
</div>

<div>

<div class="name">
<?= $row['customer_name']; ?>
</div>

<div class="phone">
<?= $row['customer_number']; ?>
</div>

</div>

</div>

</td>

    <td>

<?php
                                            if ($row['payment_method'] == "Cash On Delivery") {
?>
<span class="method cod">
<i class="fa-solid fa-money-bill-wave"></i>
COD
</span>

<?php
                                            } else {
?>
<span class="method online">
<i class="fa-solid fa-credit-card"></i>
Online
</span>

<?php
                                            }
?>

</td>



    <td>

<div class="amount">

₹<?= number_format($row['grand_total']); ?>

</div>

</td>


    <td>
        <span class="<?php echo strtolower($row['payment_status']); ?>">
            <?php echo $row['payment_status']; ?>
        </span>
    </td>

<td>

    
<form method="POST" action="update_payment_control.php">

    <input type="hidden" name="id" value="<?= $row['id']; ?>">

    <select name="payment_status" required>
        <option value="Pending">Pending</option>
        <option value="Paid">Paid</option>
        <option value="Failed">Failed</option>
    </select>


    <button class="updateBtn">

<i class="fa-solid fa-rotate"></i>

Update

</button>

</form>

</td>
</tr> -->

                                <tr>

                                    <td>

                                        <div class="order-box">

                                            #<?= $row['order_number']; ?>

                                        </div>

                                    </td>

                                    <td>

                                        <div class="customer-info">

                                            <div class="customer-avatar">

                                                <?= strtoupper(substr($row['customer_name'], 0, 1)); ?>

                                            </div>

                                            <div>

                                                <div class="customer-name">

                                                    <?= $row['customer_name']; ?>

                                                </div>

                                                <div class="customer-phone">

                                                    <i class="fa-solid fa-phone"></i>

                                                    <?= $row['customer_number']; ?>

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <?php

                                            if ($row['payment_method'] == "Cash On Delivery") {

                                        ?>

                                            <span class="payment-method cod">

                                                <i class="fa-solid fa-money-bill-wave"></i>

                                                COD

                                            </span>

                                        <?php

                                            } else {

                                        ?>

                                            <span class="payment-method online">

                                                <i class="fa-solid fa-credit-card"></i>

                                                Online

                                            </span>

                                        <?php

                                            }

                                        ?>

                                    </td>

                                    <td>

                                        <div class="amount-box">

                                            ₹<?= number_format($row['grand_total']); ?>

                                        </div>

                                    </td>

                                    <td>

                                        <?php

                                            $status = strtolower($row['payment_status']);

                                        ?>

                                        <!-- <span class="status-pill <?= $status ?>"> -->

                                        <span class="status-pill <?= $status ?>">

                                            <?php

                                            if ($status == "paid") {

                                                echo "🟢 ";
                                            } elseif ($status == "pending") {

                                                echo "🟡 ";
                                            } else {

                                                echo "🔴 ";
                                            }

                                            ?>

                                            <?= htmlspecialchars($row['payment_status']); ?>

                                        </span>

                                    </td>

                                    <td>

                                        <form

                                            method="POST"

                                            action="update_payment_control.php"

                                            class="action-form">

                                            <input

                                                type="hidden"

                                                name="id"

                                                value="<?= $row['id']; ?>">

                                            <select

                                                name="payment_status"

                                                required>

                                                <option value="Pending"

                                                    <?= ($row['payment_status'] == "Pending") ? 'selected' : ''; ?>>

                                                    Pending

                                                </option>

                                                <option value="Paid"

                                                    <?= ($row['payment_status'] == "Paid") ? 'selected' : ''; ?>>

                                                    Paid

                                                </option>

                                                <option value="Failed"

                                                    <?= ($row['payment_status'] == "Failed") ? 'selected' : ''; ?>>

                                                    Failed

                                                </option>

                                            </select>

                                            <button

                                                type="submit"

                                                class="saveBtn">

                                                <i class="fa-solid fa-floppy-disk"></i>

                                                Save

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php

                                    } else {

                        ?>

                            <tr>

                                <td colspan="6">

                                    <div class="empty-state">

                                        <i class="fa-solid fa-credit-card"></i>

                                        <h3>No Payments Found</h3>

                                        <p>

                                            There are currently no payment records matching your filters.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                    <?php

                                    }
                                }

                    ?>

                    </tbody>

                </table>

            </div>


        </div>

        <!-- <div class="text-center mt-4">

<?php if ($total_pages > 1) { ?>

    <?php if ($page > 1) { ?>
        <a class="btn btn-primary"
           href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
            ← Previous
        </a>
    <?php } ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a class="btn <?php echo ($i == $page) ? 'btn-dark' : 'btn-light'; ?>"
           href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
            <?php echo $i; ?>
        </a>
    <?php } ?>

    <?php if ($page < $total_pages) { ?>
        <a class="btn btn-primary"
           href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
            Next →
        </a>
    <?php } ?>

<?php } ?>

</div> -->

        <div class="pagination-wrapper">

            <?php if ($page > 1) { ?>

                <a class="page-btn"
                    href="?page=<?= ($page - 1) ?>&type=<?= $type ?>&search=<?= urlencode($search) ?>">

                    <i class="fa-solid fa-angle-left"></i>

                    Previous

                </a>

            <?php } ?>

            <?php

            for ($i = 1; $i <= $total_pages; $i++) {

            ?>

                <a

                    href="?page=<?= $i ?>&type=<?= $type ?>&search=<?= urlencode($search) ?>"

                    class="page-btn <?= ($i == $page) ? 'active' : ''; ?>">

                    <?= $i ?>

                </a>

            <?php

            }

            ?>

            <?php if ($page < $total_pages) { ?>

                <a

                    class="page-btn"

                    href="?page=<?= ($page + 1) ?>&type=<?= $type ?>&search=<?= urlencode($search) ?>">

                    Next

                    <i class="fa-solid fa-angle-right"></i>

                </a>

            <?php } ?>

        </div>

    </div>


    <script>
        setInterval(function() {

            const now = new Date();

            document.getElementById("liveClock").innerHTML =

                now.toLocaleTimeString();

        }, 1000);
    </script>
</body>

</html>