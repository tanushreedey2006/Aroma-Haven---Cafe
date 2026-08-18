<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Booking Management</title>

    <link rel="icon" href="weblogo.png">

    <link rel="stylesheet" href="admin_panel.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">


    <?php
    session_start();
    include("includes/db_connect.php");

    global $conn;




    /* STATUS UPDATE */
    if (isset($_GET['action']) && isset($_GET['id'])) {

        $id = (int)$_GET['id'];
        $status = mysqli_real_escape_string($conn, $_GET['action']);

        $allowed = ['Pending', 'Confirmed', 'Cancelled'];

        if (in_array($status, $allowed)) {

            // Confirm korle automatically Paid hobe
            if ($status == 'Confirmed') {

                mysqli_query(
                    $conn,
                    "UPDATE bookings
                 SET status='$status',
                     is_paid=1
                 WHERE id='$id'"
                );
            } else {

                // Pending ba Cancelled hole Unpaid thakbe
                mysqli_query(
                    $conn,
                    "UPDATE bookings
                 SET status='$status',
                     is_paid=0
                 WHERE id='$id'"
                );
            }

            header("Location: admin_manage_bookings.php");
            exit;
        }
    }


    $search = isset($_GET['search'])
        ? mysqli_real_escape_string($conn, $_GET['search'])
        : '';


    $limit = 5;

    $page = isset($_GET['page'])
        ? (int)$_GET['page']
        : 1;

    if ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $limit;


    $total_sql = "
SELECT COUNT(*) as total
FROM bookings
WHERE 1
";

    if ($search != '') {

        $total_sql .= "
    AND(
        customer_name LIKE '%$search%'
        OR customer_phone LIKE '%$search%'
        OR booking_table LIKE '%$search%'
        OR special_event LIKE '%$search%'
        OR status LIKE '%$search%'
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


    $sql = "
SELECT *
FROM bookings
WHERE 1
";

    if ($search != '') {

        $sql .= "
    AND(
        customer_name LIKE '%$search%'
        OR customer_phone LIKE '%$search%'
        OR booking_table LIKE '%$search%'
        OR special_event LIKE '%$search%'
        OR status LIKE '%$search%'
    )
    ";
    }

    $sql .= "
ORDER BY id DESC
LIMIT $offset,$limit
";

    $res = mysqli_query($conn, $sql);



    $totalBookings = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
")
    )['total'];

    $confirmed = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE status='Confirmed'
")
    )['total'];

    $pending = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE status='Pending'
")
    )['total'];

    $cancelled = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE status='Cancelled'
")
    )['total'];

    $todayBookings = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE booking_date = CURDATE()
")
    )['total'];

    $calendarBookings = mysqli_query($conn, "
SELECT booking_date,
COUNT(*) total
FROM bookings
GROUP BY booking_date
");

    $tables = [
        "Table-1",
        "Table-2",
        "Table-3",
        "VIP-1",
        "VIP-2",
        "Family-1"
    ];


    $paidBookings = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE is_paid=1
")
    )['total'];

    $unpaidBookings = mysqli_fetch_assoc(
        mysqli_query($conn, "
SELECT COUNT(*) total
FROM bookings
WHERE is_paid=0
")
    )['total'];



    ?>

</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {

        background: #eef4fb;

        background-image:

            radial-gradient(circle at top right, #dbeafe 0%, transparent 35%),

            radial-gradient(circle at bottom left, #dbeafe 0%, transparent 30%);

    }


    .main-content {

        margin: 30px 18%;

        width: 79%;

        padding-bottom: 40px;

        animation: fadeIn .7s ease;

    }

    @keyframes fadeIn {

        from {

            opacity: 0;

            transform: translateY(25px);

        }

        to {

            opacity: 1;

            transform: translateY(0);

        }

    }

    .dashboard-hero {

        background:

            linear-gradient(135deg, #0f172a, #1d4ed8, #2563eb);

        border-radius: 30px;

        padding: 35px;

        display: flex;

        justify-content: space-between;

        align-items: center;

        color: #fff;

        margin-bottom: 35px;

        overflow: hidden;

        position: relative;

        box-shadow:

            0 30px 60px rgba(37, 99, 235, .25);

    }

    .dashboard-hero::before {

        content: "";

        position: absolute;

        width: 260px;

        height: 260px;

        background: rgba(255, 255, 255, .08);

        border-radius: 50%;

        right: -70px;

        top: -70px;

    }

    .dashboard-hero::after {

        content: "";

        position: absolute;

        width: 170px;

        height: 170px;

        background: rgba(255, 255, 255, .05);

        border-radius: 50%;

        left: -50px;

        bottom: -50px;

    }

    .hero-title {

        position: relative;

        z-index: 2;

    }

    .hero-title h1 {

        font-size: 34px;

        font-weight: 800;

        margin-bottom: 10px;

    }

    .hero-title p {

        opacity: .9;

        font-size: 15px;

    }

    .hero-buttons {

        display: flex;

        gap: 12px;

        position: relative;

        z-index: 2;

    }

    .hero-buttons button {

        border: none;

        padding: 13px 22px;

        border-radius: 14px;

        font-weight: 600;

        transition: .35s;

    }

    .hero-buttons button:hover {

        transform: translateY(-4px);

    }

    .stats-grid {

        display: grid;

        grid-template-columns:

            repeat(auto-fit, minmax(220px, 1fr));

        gap: 22px;

        margin-bottom: 35px;

    }

    .stat-card {

        background:

            linear-gradient(145deg, #ffffff, #f7fbff);

        border-radius: 24px;

        padding: 28px;

        position: relative;

        overflow: hidden;

        box-shadow:

            0 10px 30px rgba(15, 23, 42, .08);

        transition: .35s;

        border: 1px solid #edf2f7;

    }

    .stat-card::before {

        content: "";

        position: absolute;

        width: 95px;

        height: 95px;

        right: -35px;

        top: -35px;

        background: rgba(37, 99, 235, .08);

        border-radius: 50%;

    }

    .stat-card:hover {

        transform: translateY(-8px);

        box-shadow:

            0 25px 40px rgba(37, 99, 235, .15);

    }

    .stat-card i {

        font-size: 42px;

        margin-bottom: 18px;

        color: #2563eb;

    }

    .stat-card h3 {

        font-size: 34px;

        font-weight: 700;

        margin-bottom: 6px;

    }

    .stat-card p {

        color: #64748b;

        margin: 0;

        font-size: 14px;

        font-weight: 500;

    }

    .dashboard-grid {

        display: grid;

        grid-template-columns: 2fr 1fr;

        gap: 24px;

        margin-bottom: 30px;

    }

    .dashboard-card {

        background: #fff;

        border-radius: 24px;

        padding: 25px;

        box-shadow:

            0 10px 30px rgba(15, 23, 42, .08);

    }

    .dashboard-card h4 {

        font-size: 18px;

        font-weight: 700;

        margin-bottom: 20px;

        color: #0f172a;

    }

    .table-map {

        display: grid;

        grid-template-columns: repeat(2, 1fr);

        gap: 15px;

    }

    .table-box {

        background:

            linear-gradient(145deg, #ffffff, #f7fbff);

        border: 1px solid #e5e7eb;

        padding: 22px;

        border-radius: 18px;

        font-weight: 700;

        text-align: center;

        transition: .35s;

        cursor: pointer;

        position: relative;

        overflow: hidden;

    }

    .table-box::before {

        content: "";

        position: absolute;

        width: 70px;

        height: 70px;

        border-radius: 50%;

        background: rgba(37, 99, 235, .08);

        top: -20px;

        right: -20px;

    }

    .table-box:hover {

        background:

            linear-gradient(135deg, #2563eb, #1d4ed8);

        color: white;

        transform: translateY(-6px);

        box-shadow:

            0 15px 35px rgba(37, 99, 235, .25);

    }

    .table-toolbar {

        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 15px;

        margin-bottom: 20px;

        flex-wrap: wrap;

    }

    .search-box {

        position: relative;

        width: 330px;

    }

    .search-box input {

        padding-left: 42px;

        height: 48px;

        border-radius: 14px;

        border: 1px solid #dbe4f0;

    }

    .search-box i {

        position: absolute;

        left: 15px;

        top: 16px;

        color: #64748b;

    }

    .toolbar-actions {

        display: flex;

        gap: 12px;

    }

    .booking-card {

        background: #fff;

        padding: 25px;

        border-radius: 25px;

        box-shadow:

            0 15px 35px rgba(15, 23, 42, .08);

    }

    .booking-table {

        margin: 0;

        border-collapse: separate;

        border-spacing: 0;

    }

    .booking-table thead {

        background:

            linear-gradient(135deg, #0f172a, #1e293b);

        color: #fff;

    }

    .booking-table th {

        padding: 18px;

        font-size: 14px;

        font-weight: 600;

        border: none;

        white-space: nowrap;

    }

    .booking-table td {

        padding: 16px;

        vertical-align: middle;

        border-bottom: 1px solid #edf2f7;

    }

    .booking-table tbody tr {

        transition: .3s;

    }

    .booking-table tbody tr:hover {

        background: #f8fbff;

        transform: scale(1.003);

    }

    .customer-box {

        display: flex;

        align-items: center;

        gap: 14px;

        min-width: 220px;

    }

    .customer-avatar {

        width: 52px;

        height: 52px;

        border-radius: 50%;

        display: flex;

        justify-content: center;

        align-items: center;

        font-size: 20px;

        font-weight: 700;

        color: #fff;

        background:

            linear-gradient(135deg, #2563eb, #1d4ed8);

        box-shadow:

            0 10px 25px rgba(37, 99, 235, .25);

        flex-shrink: 0;

    }

    .customer-info b {

        display: block;

        font-size: 15px;

        color: #0f172a;

    }

    .customer-info span {

        font-size: 13px;

        color: #64748b;

    }

    .status {

        padding: 8px 16px;

        border-radius: 50px;

        font-size: 13px;

        font-weight: 700;

        display: inline-block;

    }

    .status-confirm {

        background: #dcfce7;

        color: #15803d;

    }

    .status-pending {

        background: #fef3c7;

        color: #b45309;

    }

    .status-cancel {

        background: #fee2e2;

        color: #dc2626;

    }

    .payment-paid {

        background: #d1fae5;

        color: #047857;

        padding: 8px 16px;

        border-radius: 30px;

        font-weight: 700;

    }

    .payment-unpaid {

        background: #fee2e2;

        color: #dc2626;

        padding: 8px 16px;

        border-radius: 30px;

        font-weight: 700;

    }



    .booking-img {

        width: 95px;

        height: 65px;

        border-radius: 15px;

        object-fit: cover;

        border: 4px solid #fff;

        box-shadow:

            0 8px 20px rgba(0, 0, 0, .15);

        transition: .3s;

    }

    .booking-img:hover {

        transform: scale(1.08);

    }


    .action-buttons {

        display: flex;

        gap: 8px;

        flex-wrap: wrap;

    }

    .btn-action {

        border: none;

        padding: 10px 16px;

        border-radius: 12px;

        font-size: 13px;

        font-weight: 600;

        transition: .3s;

    }

    .btn-confirm {

        background: #16a34a;

        color: #fff;

    }

    .btn-confirm:hover {

        background: #15803d;

        transform: translateY(-3px);

    }

    .btn-pending {

        background: #f59e0b;

        color: #fff;

    }

    .btn-pending:hover {

        background: #d97706;

        transform: translateY(-3px);

    }

    .btn-cancel {

        background: #ef4444;

        color: #fff;

    }

    .btn-cancel:hover {

        background: #dc2626;

        transform: translateY(-3px);

    }

    .btn-view {

        background: #2563eb;

        color: #fff;

    }

    .btn-view:hover {

        background: #1d4ed8;

        transform: translateY(-3px);

    }

    .btn-history {

        background: #0f172a;

        color: #fff;

    }

    .btn-history:hover {

        background: #020617;

        transform: translateY(-3px);

    }

    .modal-content {

        border: none;

        border-radius: 22px;

        overflow: hidden;

        box-shadow:

            0 20px 50px rgba(0, 0, 0, .2);

    }

    .modal-header {

        background:

            linear-gradient(135deg, #1d4ed8, #2563eb);

        color: white;

        border: none;

    }

    .modal-header .btn-close {

        filter: invert(1);

    }

    .modal-body {

        padding: 28px;

    }

    .modal-body p {

        padding: 10px 0;

        border-bottom: 1px solid #eef2f7;

        margin: 0;

    }

    .pagination-box {

        display: flex;

        justify-content: center;

        align-items: center;

        gap: 10px;

        margin-top: 35px;

        flex-wrap: wrap;

    }

    .pagination-box a {

        width: 42px;

        height: 42px;

        display: flex;

        justify-content: center;

        align-items: center;

        border-radius: 12px;

        text-decoration: none;

        background: #fff;

        color: #0f172a;

        font-weight: 700;

        box-shadow:

            0 6px 18px rgba(0, 0, 0, .08);

        transition: .3s;

    }

    .pagination-box a:hover {

        background: #2563eb;

        color: #fff;

        transform: translateY(-3px);

    }

    .pagination-box .active {

        background: #2563eb;

        color: #fff;

    }

    ::-webkit-scrollbar {

        width: 8px;

        height: 8px;

    }

    ::-webkit-scrollbar-thumb {

        background: #2563eb;

        border-radius: 20px;

    }

    ::-webkit-scrollbar-track {

        background: #e5e7eb;

    }


    @media(max-width:1400px) {

        .dashboard-grid {

            grid-template-columns: 1fr;

        }

    }

    @media(max-width:992px) {

        .main-content {

            margin: 20px;

            width: auto;

        }

        .dashboard-hero {

            flex-direction: column;

            align-items: flex-start;

            gap: 20px;

        }

        .hero-buttons {

            width: 100%;

        }

        .stats-grid {

            grid-template-columns: repeat(2, 1fr);

        }

    }

    @media(max-width:768px) {

        .stats-grid {

            grid-template-columns: 1fr;

        }

        .table-toolbar {

            flex-direction: column;

            align-items: stretch;

        }

        .search-box {

            width: 100%;

        }

        .customer-box {

            min-width: 180px;

        }

        .booking-table {

            font-size: 13px;

        }

    }

    @keyframes floatCard {

        0% {

            transform: translateY(0);

        }

        50% {

            transform: translateY(-5px);

        }

        100% {

            transform: translateY(0);

        }

    }














    .stat-card {

        animation: floatCard 5s ease-in-out infinite;

    }

    .booking-table tbody tr {

        border-left: 5px solid transparent;

    }

    .booking-table tbody tr:hover {

        border-left: 5px solid #2563eb;

    }

    .stat-card {

        position: relative;

        overflow: hidden;

    }

    .stat-card::after {

        content: "";

        position: absolute;

        width: 120px;

        height: 120px;

        background: rgba(37, 99, 235, .08);

        border-radius: 50%;

        top: -40px;

        right: -40px;

    }

    .summary-bar {

        background: white;

        padding: 25px;

        border-radius: 25px;

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 25px;

        box-shadow: 0 15px 35px rgba(0, 0, 0, .08);

    }
</style>

<body>


    <div class="container" style="margin-left:-1%;min-width:102%;">

        <?php include "sidebar.php"; ?>

        <?php include "header.php"; ?>
        <div class="">

        </div>
    </div>
    </div>




    <div class="main-content">


        <div class="dashboard-hero">

            <div class="hero-title">

                <h1>
                    <i class="fas fa-calendar-check"></i>
                    Booking Control Center
                </h1>

                <p>

                    Manage reservations, VIP events, confirmations and customer bookings with one modern dashboard.

                </p>


                <div id="clock"></div>

            </div>

            <?php

            ?>



        </div>


        <div class="stats-grid">

            <div class="stat-card">

                <i class="fas fa-calendar-day"></i>

                <h3><?= $todayBookings ?></h3>

                <p>Today's Bookings</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-calendar-check"></i>

                <h3><?= $totalBookings ?></h3>

                <p>Total Reservations</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-check-circle"></i>

                <h3><?= $confirmed ?></h3>

                <p>Confirmed</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-clock"></i>

                <h3><?= $pending ?></h3>

                <p>Pending</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-times-circle"></i>

                <h3><?= $cancelled ?></h3>

                <p>Cancelled</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-wallet"></i>

                <h3><?= $paidBookings ?></h3>

                <p>Paid</p>

            </div>



            <div class="stat-card">

                <i class="fas fa-credit-card"></i>

                <h3><?= $unpaidBookings ?></h3>

                <p>Unpaid</p>

            </div>

        </div>

        <div class="dashboard-grid">


            <div class="dashboard-card">

                <h4>

                    <i class="fas fa-chart-line"></i>

                    Booking Overview

                </h4>

                <canvas id="bookingChart" height="130"></canvas>

            </div>



            <div class="dashboard-card">

                <h4>

                    <i class="fas fa-chair"></i>

                    Table Availability

                </h4>

                <div class="table-map">

                    <?php foreach ($tables as $tb) { ?>

                        <div class="table-box">

                            <i class="fas fa-chair fa-2x mb-3"></i>

                            <h5><?= $tb ?></h5>

                            <span class="badge bg-success">

                                Available

                            </span>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>



        <div class="booking-card">

            <div class="table-toolbar">

                <form method="GET"

                    style="display:flex;gap:15px;flex-wrap:wrap;width:100%;">

                    <div class="search-box">

                        <i class="fas fa-search"></i>

                        <input

                            type="text"

                            name="search"

                            value="<?= htmlspecialchars($search); ?>"

                            class="form-control"

                            placeholder="Search customer, phone, table...">

                    </div>


                    <select

                        class="form-select"

                        style="width:180px;">

                        <option>

                            All Status

                        </option>

                        <option>

                            Confirmed

                        </option>

                        <option>

                            Pending

                        </option>

                        <option>

                            Cancelled

                        </option>

                    </select>

                    <button

                        class="btn btn-primary">

                        <i class="fas fa-search"></i>

                        Search

                    </button>

                    <a

                        href="admin_manage_bookings.php"

                        class="btn btn-secondary">

                        Reset

                    </a>

                </form>

            </div>



            <div class="table-responsive">


                <table class="table booking-table">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Customer</th>

                            <th>Reservation</th>

                            <th>Guests</th>

                            <th>Event</th>

                            <th>Payment</th>

                            <th>Status</th>

                            <th>Photo</th>

                            <th width="280">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (mysqli_num_rows($res) > 0) {

                            while ($row = mysqli_fetch_assoc($res)) {

                        ?>

                                <tr>

                                    <td>

                                        <b>#<?= $row['id']; ?></b>

                                    </td>

                                    <td>

                                        <div class="customer-box">

                                            <div class="customer-avatar">

                                                <?= strtoupper(substr($row['customer_name'], 0, 1)); ?>

                                            </div>

                                            <div class="customer-info">

                                                <b>

                                                    <?= $row['customer_name']; ?>

                                                </b>

                                                <span>

                                                    <?= $row['customer_phone']; ?>

                                                </span>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <b><?= $row['booking_table']; ?></b>

                                        <br>

                                        <small>

                                            <?= date("d M Y", strtotime($row['booking_date'])); ?>

                                        </small>

                                        <br>

                                        <small>

                                            <?= date("h:i A", strtotime($row['booking_time'])); ?>

                                        </small>

                                    </td>



                                    <td>

                                        <?= $row['people']; ?>

                                        People

                                    </td>

                                    <td>

                                        <?= $row['special_event']; ?>

                                    </td>

                                    <td>

                                        <?php

                                        if ($row['is_paid']) {

                                        ?>

                                            <span class="payment-paid">

                                                <i class="fas fa-check-circle"></i>

                                                Paid

                                            </span>

                                        <?php

                                        } else {

                                        ?>

                                            <span class="payment-unpaid">

                                                <i class="fas fa-times-circle"></i>

                                                Unpaid

                                            </span>

                                        <?php

                                        }

                                        ?>

                                    </td>

                                    <td>

                                        <?php

                                        if ($row['status'] == "Confirmed") {

                                            echo "<span class='status status-confirm'>Confirmed</span>";
                                        } elseif ($row['status'] == "Cancelled") {

                                            echo "<span class='status status-cancel'>Cancelled</span>";
                                        } else {

                                            echo "<span class='status status-pending'>Pending</span>";
                                        }

                                        ?>

                                    </td>

                                    <td>

                                        <?php

                                        if (!empty($row['event_image'])) {

                                        ?>

                                            <!-- <img
src="../images/<?php echo $row['event_image']; ?>"
style="
width:60px;
height:60px;
object-fit:cover;
border-radius:10px;"> -->

                                            <img

                                                src="../images/<?php echo $row['event_image']; ?>"

                                                class="booking-img">

                                        <?php

                                        } else {

                                            echo "No Image";
                                        }

                                        ?>

                                    </td>



















                                    <td class="text-center">

                                        <!-- ONLY 3 DOTS WILL BE VISIBLE -->

                                        <div class="dropdown">

                                            <button
                                                class="btn btn-light btn-sm action-menu"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">

                                                <i class="fas fa-ellipsis-v"></i>

                                            </button>


                                            <ul class="dropdown-menu dropdown-menu-end shadow">



                                                <!-- CONFIRM -->

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="?action=Confirmed&id=<?php echo $row['id']; ?>">

                                                        <i class="fas fa-check-circle me-2 text-success"></i>

                                                        Confirm

                                                    </a>

                                                </li>


                                                <!-- PENDING -->

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="?action=Pending&id=<?php echo $row['id']; ?>">

                                                        <i class="fas fa-clock me-2 text-warning"></i>

                                                        Pending

                                                    </a>

                                                </li>


                                                <!-- CANCEL -->

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="?action=Cancelled&id=<?php echo $row['id']; ?>">

                                                        <i class="fas fa-times-circle me-2 text-danger"></i>

                                                        Cancel

                                                    </a>

                                                </li>


                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>


                                                <!-- BOOKING HISTORY -->

                                                <li>

                                                    <a
                                                        class="dropdown-item"
                                                        href="customer_booking_history.php?phone=<?php echo urlencode($row['customer_phone']); ?>">

                                                        <i class="fas fa-history me-2 text-secondary"></i>

                                                        Booking History

                                                    </a>

                                                </li>


                                            </ul>

                                        </div>

                                    </td>







                                </tr>

                            <?php

                            }
                        } else {

                            ?>

                            <tr>

                                <td colspan="12"
                                    class="text-center text-danger">

                                    No Booking Found

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

                <!-- PAGINATION -->

                <!-- <div class="text-center mt-4">

<?php if ($page > 1) { ?>

<a class="btn btn-primary"
href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">

← Previous

</a>

<?php } ?>

<?php for ($p = 1; $p <= $total_pages; $p++) { ?>

<a
class="btn <?php echo ($p == $page) ? 'btn-dark' : 'btn-outline-primary'; ?>"
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

</div> -->

                <div class="pagination-box">

                    <?php if ($page > 1) { ?>

                        <a
                            href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">

                            <i class="fas fa-angle-left"></i>

                        </a>

                    <?php } ?>

                    <?php

                    for ($p = 1; $p <= $total_pages; $p++) {

                    ?>

                        <a

                            class="<?= ($p == $page) ? 'active' : '' ?>"

                            href="?page=<?= $p ?>&search=<?= urlencode($search) ?>">

                            <?= $p ?>

                        </a>

                    <?php } ?>

                    <?php if ($page < $total_pages) { ?>

                        <a
                            href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">

                            <i class="fas fa-angle-right"></i>

                        </a>

                    <?php } ?>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById("bookingChart");

        if (ctx) {

            new Chart(ctx, {

                type: "line",

                data: {

                    labels: [
                        "Mon",
                        "Tue",
                        "Wed",
                        "Thu",
                        "Fri",
                        "Sat",
                        "Sun"
                    ],

                    datasets: [

                        {

                            label: "Bookings",

                            data: [4, 8, 6, 12, 9, 15, 11],

                            borderColor: "#2563eb",

                            backgroundColor: "rgba(37,99,235,.1)",

                            fill: true,

                            tension: .4

                        },

                        {

                            label: "Revenue",

                            data: [1, 3, 2, 6, 5, 8, 7],

                            borderColor: "#16a34a",

                            backgroundColor: "rgba(22,163,74,.1)",

                            fill: true,

                            tension: .4

                        },

                        {

                            label: "Cancelled",

                            data: [0, 1, 2, 1, 1, 0, 2],

                            borderColor: "#dc2626",

                            backgroundColor: "rgba(220,38,38,.08)",

                            fill: true,

                            tension: .4

                        }

                    ]

                },

                options: {

                    plugins: {

                        legend: {

                            display: false

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true

                        }

                    }

                }

            });

        }



        setInterval(function() {

            document.getElementById("clock").innerHTML =

                new Date().toLocaleTimeString();

        }, 1000);
    </script>
    </div>
    </div>
    <script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>