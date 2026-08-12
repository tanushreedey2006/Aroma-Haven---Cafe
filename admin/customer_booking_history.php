
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Booking History</title>

    <link rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


<?php

session_start();

include("includes/db_connect.php");

global $conn;
/** @var mysqli $conn */


// ==========================================
// GET CUSTOMER PHONE
// ==========================================

$phone = mysqli_real_escape_string(
    $conn,
    $_GET['phone'] ?? ''
);


if ($phone == '') {

    die("Customer not found");

}


// ==========================================
// CUSTOMER INFO
// ==========================================

$customer = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT *
        FROM bookings
        WHERE customer_phone='$phone'
        ORDER BY id DESC
        LIMIT 1
        "
    )
);


if (!$customer) {

    die("Customer not found");

}


// ==========================================
// TOTAL BOOKINGS
// ==========================================

$totalBookings = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) total
        FROM bookings
        WHERE customer_phone='$phone'
        "
    )
)['total'];


// ==========================================
// CONFIRMED BOOKINGS
// ==========================================

$confirmed = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) total
        FROM bookings
        WHERE customer_phone='$phone'
        AND status='Confirmed'
        "
    )
)['total'];


// ==========================================
// PAID BOOKINGS
// ==========================================

$paid = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT COUNT(*) total
        FROM bookings
        WHERE customer_phone='$phone'
        AND is_paid=1
        "
    )
)['total'];


// ==========================================
// BOOKING HISTORY
// ==========================================

$history = mysqli_query(
    $conn,
    "
    SELECT *
    FROM bookings
    WHERE customer_phone='$phone'
    ORDER BY id DESC
    "
);


// ==========================================
// TOTAL SPENT
// ==========================================

$totalSpent = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT SUM(amount) total
        FROM bookings
        WHERE customer_phone='$phone'
        AND is_paid=1
        "
    )
)['total'] ?? 0;


// ==========================================
// FAVOURITE EVENT
// ==========================================

$fav = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT special_event, COUNT(*) total
        FROM bookings
        WHERE customer_phone='$phone'
        GROUP BY special_event
        ORDER BY total DESC
        LIMIT 1
        "
    )
);


// ==========================================
// LAST VISIT
// ==========================================

$last = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT booking_date
        FROM bookings
        WHERE customer_phone='$phone'
        ORDER BY booking_date DESC
        LIMIT 1
        "
    )
);


// ==========================================
// LOYALTY
// ==========================================

if ($totalBookings >= 15) {

    $loyalty = "Platinum";
    $loyaltyIcon = "fa-gem";

} elseif ($totalBookings >= 8) {

    $loyalty = "Gold";
    $loyaltyIcon = "fa-crown";

} else {

    $loyalty = "Silver";
    $loyaltyIcon = "fa-medal";

}


// ==========================================
// CUSTOMER INITIAL
// ==========================================

$customerName = $customer['customer_name'];

$initial = strtoupper(
    substr(
        trim($customerName),
        0,
        1
    )
);

?>

<style>

/* =====================================================
   GLOBAL
===================================================== */

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    min-height: 100vh;

    background:
        radial-gradient(
            circle at 10% 10%,
            rgba(99,102,241,.12),
            transparent 30%
        ),
        radial-gradient(
            circle at 90% 90%,
            rgba(14,165,233,.10),
            transparent 30%
        ),
        #f5f7fb;

    color: #111827;

    font-family:
        "Poppins",
        "Segoe UI",
        sans-serif;

}


/* =====================================================
   PAGE WRAPPER
===================================================== */

.history-wrapper {

    max-width: 1400px;

    margin: auto;

    padding:
        35px 25px 60px;

}


/* =====================================================
   TOP BAR
===================================================== */

.top-bar {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

}


.page-title {

    display: flex;

    align-items: center;

    gap: 14px;

}


.page-title-icon {

    width: 48px;

    height: 48px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

    box-shadow:
        0 10px 25px
        rgba(37,99,235,.25);

}


.page-title h1 {

    font-size: 25px;

    font-weight: 800;

    margin: 0;

}


.page-title p {

    margin: 3px 0 0;

    color: #6b7280;

    font-size: 13px;

}


/* =====================================================
   BACK BUTTON
===================================================== */

.back-btn {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding:
        11px 18px;

    border-radius: 12px;

    background: white;

    color: #374151;

    text-decoration: none;

    font-weight: 600;

    border:
        1px solid #e5e7eb;

    box-shadow:
        0 6px 18px
        rgba(0,0,0,.06);

    transition: .3s;

}


.back-btn:hover {

    color: #2563eb;

    transform:
        translateY(-2px);

    box-shadow:
        0 10px 25px
        rgba(37,99,235,.12);

}


/* =====================================================
   CUSTOMER HERO
===================================================== */

.customer-hero {

    position: relative;

    overflow: hidden;

    border-radius: 28px;

    padding: 35px;

    color: white;

    background:
        linear-gradient(
            135deg,
            #111827 0%,
            #1e3a8a 48%,
            #4338ca 100%
        );

    box-shadow:
        0 22px 55px
        rgba(30,58,138,.25);

    margin-bottom: 25px;

}


.customer-hero::before {

    content: "";

    position: absolute;

    width: 280px;

    height: 280px;

    border-radius: 50%;

    background:
        rgba(255,255,255,.07);

    right: -90px;

    top: -120px;

}


.customer-hero::after {

    content: "";

    position: absolute;

    width: 180px;

    height: 180px;

    border-radius: 50%;

    background:
        rgba(96,165,250,.10);

    right: 160px;

    bottom: -120px;

}


.hero-content {

    position: relative;

    z-index: 2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 30px;

}


.customer-main {

    display: flex;

    align-items: center;

    gap: 22px;

}


.customer-avatar {

    width: 92px;

    height: 92px;

    flex-shrink: 0;

    border-radius: 25px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 36px;

    font-weight: 800;

    background:
        linear-gradient(
            135deg,
            #60a5fa,
            #818cf8
        );

    border:
        4px solid
        rgba(255,255,255,.25);

    box-shadow:
        0 12px 30px
        rgba(0,0,0,.25);

}


.customer-details h2 {

    font-size: 29px;

    font-weight: 800;

    margin: 0 0 8px;

}


.customer-details p {

    margin: 4px 0;

    color:
        rgba(255,255,255,.78);

    font-size: 14px;

}


.customer-details i {

    width: 20px;

}


.vip-badge {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    margin-top: 8px;

    padding:
        7px 13px;

    border-radius: 30px;

    color: #78350f;

    background:
        linear-gradient(
            135deg,
            #fde68a,
            #fbbf24
        );

    font-size: 12px;

    font-weight: 800;

}


.hero-spending {

    min-width: 220px;

    padding: 20px 25px;

    border-radius: 20px;

    background:
        rgba(255,255,255,.10);

    border:
        1px solid
        rgba(255,255,255,.14);

    backdrop-filter:
        blur(12px);

}


.hero-spending small {

    display: block;

    color:
        rgba(255,255,255,.65);

    font-size: 12px;

    margin-bottom: 7px;

}


.hero-spending strong {

    display: block;

    font-size: 30px;

    font-weight: 800;

}


.hero-spending span {

    color:
        rgba(255,255,255,.65);

    font-size: 12px;

}


/* =====================================================
   STAT CARDS
===================================================== */

.stats-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 18px;

    margin-bottom: 25px;

}


.stat-card {

    position: relative;

    overflow: hidden;

    background: white;

    border:
        1px solid #edf0f5;

    border-radius: 20px;

    padding: 23px;

    box-shadow:
        0 10px 28px
        rgba(15,23,42,.06);

    transition: .35s;

}


.stat-card:hover {

    transform:
        translateY(-5px);

    box-shadow:
        0 18px 35px
        rgba(15,23,42,.10);

}


.stat-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 18px;

}


.stat-icon {

    width: 45px;

    height: 45px;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 18px;

}


.stat-card:nth-child(1)
.stat-icon {

    color: #2563eb;

    background: #eff6ff;

}


.stat-card:nth-child(2)
.stat-icon {

    color: #16a34a;

    background: #f0fdf4;

}


.stat-card:nth-child(3)
.stat-icon {

    color: #9333ea;

    background: #faf5ff;

}


.stat-card:nth-child(4)
.stat-icon {

    color: #d97706;

    background: #fffbeb;

}


.stat-label {

    color: #6b7280;

    font-size: 13px;

    font-weight: 600;

}


.stat-value {

    font-size: 28px;

    font-weight: 800;

    color: #111827;

}


.stat-description {

    margin-top: 5px;

    color: #9ca3af;

    font-size: 11px;

}


/* =====================================================
   INSIGHT CARDS
===================================================== */

.insights-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 28px;

}


.insight-card {

    background: white;

    border-radius: 20px;

    padding: 23px;

    border:
        1px solid #edf0f5;

    box-shadow:
        0 10px 28px
        rgba(15,23,42,.05);

    transition: .3s;

}


.insight-card:hover {

    transform:
        translateY(-4px);

}


.insight-heading {

    display: flex;

    align-items: center;

    gap: 12px;

    color: #6b7280;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .5px;

}


.insight-icon {

    width: 38px;

    height: 38px;

    border-radius: 11px;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #4f46e5;

    background: #eef2ff;

}


.insight-value {

    margin-top: 17px;

    font-size: 19px;

    font-weight: 800;

    color: #111827;

}


.loyalty-pill {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding:
        7px 13px;

    margin-top: 15px;

    border-radius: 30px;

    background: #fef3c7;

    color: #92400e;

    font-weight: 700;

    font-size: 12px;

}


/* =====================================================
   TIMELINE CONTAINER
===================================================== */

.history-card {

    background: white;

    border-radius: 25px;

    border:
        1px solid #edf0f5;

    box-shadow:
        0 15px 40px
        rgba(15,23,42,.07);

    overflow: hidden;

}


.history-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding:
        24px 28px;

    border-bottom:
        1px solid #eef0f4;

}


.history-title {

    display: flex;

    align-items: center;

    gap: 12px;

}


.history-title-icon {

    width: 43px;

    height: 43px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    color: #2563eb;

    background: #eff6ff;

}


.history-title h3 {

    margin: 0;

    font-size: 19px;

    font-weight: 800;

}


.history-title p {

    margin: 3px 0 0;

    font-size: 11px;

    color: #9ca3af;

}


/* =====================================================
   TIMELINE
===================================================== */

.timeline {

    position: relative;

    padding:
        30px 30px 10px;

}


.timeline::before {

    content: "";

    position: absolute;

    left: 51px;

    top: 35px;

    bottom: 25px;

    width: 2px;

    background:
        linear-gradient(
            to bottom,
            #dbeafe,
            #e5e7eb
        );

}


.timeline-item {

    position: relative;

    display: grid;

    grid-template-columns:
        45px 1fr;

    gap: 18px;

    margin-bottom: 25px;

}


.timeline-dot {

    position: relative;

    z-index: 2;

    width: 45px;

    height: 45px;

    border-radius: 14px;

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    box-shadow:
        0 7px 18px
        rgba(0,0,0,.12);

}


.dot-confirmed {

    background:
        linear-gradient(
            135deg,
            #22c55e,
            #16a34a
        );

}


.dot-pending {

    background:
        linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );

}


.dot-cancelled {

    background:
        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );

}


.dot-default {

    background:
        linear-gradient(
            135deg,
            #64748b,
            #475569
        );

}


.booking-event {

    border:
        1px solid #edf0f5;

    border-radius: 18px;

    padding: 19px 21px;

    background: #fff;

    transition: .3s;

}


.booking-event:hover {

    transform:
        translateX(4px);

    box-shadow:
        0 10px 25px
        rgba(15,23,42,.07);

}


.booking-event-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-bottom: 12px;

}


.booking-date {

    font-size: 15px;

    font-weight: 800;

    color: #111827;

}


.booking-time {

    color: #6b7280;

    font-size: 12px;

    margin-top: 3px;

}


.status-badge {

    padding:
        6px 11px;

    border-radius: 30px;

    font-size: 11px;

    font-weight: 800;

}


.status-confirmed {

    color: #166534;

    background: #dcfce7;

}


.status-pending {

    color: #92400e;

    background: #fef3c7;

}


.status-cancelled {

    color: #991b1b;

    background: #fee2e2;

}


.status-default {

    color: #475569;

    background: #f1f5f9;

}


.booking-info {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;

}


.info-chip {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding:
        8px 11px;

    border-radius: 10px;

    background: #f8fafc;

    color: #4b5563;

    font-size: 11px;

    border:
        1px solid #eef2f7;

}


.info-chip i {

    color: #2563eb;

}


.booking-message {

    margin-top: 13px;

    padding:
        12px 14px;

    border-radius: 11px;

    background: #f8fafc;

    color: #6b7280;

    font-size: 12px;

}


.booking-message i {

    color: #6366f1;

    margin-right: 5px;

}


/* =====================================================
   EMPTY STATE
===================================================== */

.empty-history {

    text-align: center;

    padding: 60px 20px;

    color: #9ca3af;

}


.empty-history i {

    font-size: 45px;

    margin-bottom: 15px;

    color: #cbd5e1;

}


.empty-history h5 {

    color: #475569;

    font-weight: 700;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 1100px) {

    .stats-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media(max-width: 900px) {

    .hero-content {

        flex-direction: column;

        align-items: flex-start;

    }


    .hero-spending {

        width: 100%;

    }


    .insights-grid {

        grid-template-columns:
            1fr;

    }

}


@media(max-width: 650px) {

    .history-wrapper {

        padding:
            20px 12px 40px;

    }


    .top-bar {

        align-items: flex-start;

        gap: 15px;

        flex-direction: column;

    }


    .page-title h1 {

        font-size: 21px;

    }


    .customer-hero {

        padding: 25px 20px;

        border-radius: 22px;

    }


    .customer-main {

        align-items: flex-start;

    }


    .customer-avatar {

        width: 70px;

        height: 70px;

        border-radius: 20px;

        font-size: 27px;

    }


    .customer-details h2 {

        font-size: 22px;

    }


    .stats-grid {

        grid-template-columns: 1fr 1fr;

        gap: 12px;

    }


    .stat-card {

        padding: 17px;

    }


    .stat-value {

        font-size: 22px;

    }


    .timeline {

        padding:
            25px 15px 10px;

    }


    .timeline::before {

        left: 36px;

    }


    .timeline-item {

        grid-template-columns:
            30px 1fr;

        gap: 12px;

    }


    .timeline-dot {

        width: 30px;

        height: 30px;

        border-radius: 9px;

        font-size: 11px;

    }


    .booking-event {

        padding: 15px;

    }


    .booking-event-top {

        align-items: flex-start;

        flex-direction: column;

    }


    .history-header {

        padding:
            20px 17px;

    }

}


@media(max-width: 430px) {

    .stats-grid {

        grid-template-columns: 1fr;

    }


    .customer-main {

        flex-direction: column;

    }

}

</style>

</head>


<body>


<div class="history-wrapper">


    <!-- ==========================================
         TOP BAR
    =========================================== -->

    <div class="top-bar">


        <div class="page-title">

            <div class="page-title-icon">

                <i class="fas fa-user-clock"></i>

            </div>

            <div>

                <h1>Customer Booking History</h1>

                <p>
                    Complete reservation activity and customer insights
                </p>

            </div>

        </div>


        <a
            href="admin_manage_bookings.php"
            class="back-btn">

            <i class="fas fa-arrow-left"></i>

            Back to Bookings

        </a>


    </div>


    <!-- ==========================================
         CUSTOMER HERO
    =========================================== -->

    <div class="customer-hero">


        <div class="hero-content">


            <div class="customer-main">


                <div class="customer-avatar">

                    <?php echo $initial; ?>

                </div>


                <div class="customer-details">


                    <h2>

                        <?php
                        echo htmlspecialchars(
                            $customerName
                        );
                        ?>

                    </h2>


                    <?php if ($totalBookings >= 3) { ?>

                        <span class="vip-badge">

                            <i class="fas fa-star"></i>

                            VIP Customer

                        </span>

                    <?php } ?>


                    <p>

                        <i class="fas fa-phone"></i>

                        <?php
                        echo htmlspecialchars(
                            $customer['customer_phone']
                        );
                        ?>

                    </p>


                </div>


            </div>


            <div class="hero-spending">


                <small>

                    Total Customer Spend

                </small>


                <strong>

                    ₹<?php
                    echo number_format(
                        $totalSpent
                    );
                    ?>

                </strong>


                <span>

                    Across paid bookings

                </span>


            </div>


        </div>


    </div>


    <!-- ==========================================
         STATISTICS
    =========================================== -->

    <div class="stats-grid">


        <div class="stat-card">


            <div class="stat-top">

                <span class="stat-label">

                    Total Bookings

                </span>

                <div class="stat-icon">

                    <i class="fas fa-calendar-check"></i>

                </div>

            </div>


            <div class="stat-value">

                <?php echo $totalBookings; ?>

            </div>


            <div class="stat-description">

                Lifetime reservations

            </div>


        </div>


        <div class="stat-card">


            <div class="stat-top">

                <span class="stat-label">

                    Confirmed

                </span>

                <div class="stat-icon">

                    <i class="fas fa-circle-check"></i>

                </div>

            </div>


            <div class="stat-value">

                <?php echo $confirmed; ?>

            </div>


            <div class="stat-description">

                Successful bookings

            </div>


        </div>


        <div class="stat-card">


            <div class="stat-top">

                <span class="stat-label">

                    Paid Bookings

                </span>

                <div class="stat-icon">

                    <i class="fas fa-credit-card"></i>

                </div>

            </div>


            <div class="stat-value">

                <?php echo $paid; ?>

            </div>


            <div class="stat-description">

                Completed payments

            </div>


        </div>


        <div class="stat-card">


            <div class="stat-top">

                <span class="stat-label">

                    Total Spent

                </span>

                <div class="stat-icon">

                    <i class="fas fa-indian-rupee-sign"></i>

                </div>

            </div>


            <div class="stat-value">

                ₹<?php
                echo number_format(
                    $totalSpent
                );
                ?>

            </div>


            <div class="stat-description">

                Paid reservation value

            </div>


        </div>


    </div>


    <!-- ==========================================
         CUSTOMER INSIGHTS
    =========================================== -->

    <div class="insights-grid">


        <!-- FAVOURITE EVENT -->

        <div class="insight-card">


            <div class="insight-heading">

                <div class="insight-icon">

                    <i class="fas fa-champagne-glasses"></i>

                </div>

                Favourite Event

            </div>


            <div class="insight-value">

                <?php

                echo htmlspecialchars(
                    $fav['special_event']
                    ?? 'None'
                );

                ?>

            </div>


        </div>


        <!-- LAST VISIT -->

        <div class="insight-card">


            <div class="insight-heading">

                <div class="insight-icon">

                    <i class="fas fa-calendar-day"></i>

                </div>

                Last Visit

            </div>


            <div class="insight-value">

                <?php

                echo !empty(
                    $last['booking_date']
                )
                    ? date(
                        "d M Y",
                        strtotime(
                            $last['booking_date']
                        )
                    )
                    : "No visit yet";

                ?>

            </div>


        </div>


        <!-- LOYALTY -->

        <div class="insight-card">


            <div class="insight-heading">

                <div class="insight-icon">

                    <i class="fas <?php echo $loyaltyIcon; ?>"></i>

                </div>

                Loyalty Level

            </div>


            <div class="insight-value">

                <?php echo $loyalty; ?>

            </div>


            <span class="loyalty-pill">

                <i class="fas fa-award"></i>

                Customer Loyalty

            </span>


        </div>


    </div>


    <!-- ==========================================
         BOOKING HISTORY
    =========================================== -->

    <div class="history-card">


        <div class="history-header">


            <div class="history-title">


                <div class="history-title-icon">

                    <i class="fas fa-clock-rotate-left"></i>

                </div>


                <div>

                    <h3>

                        Booking Timeline

                    </h3>


                    <p>

                        Complete reservation history

                    </p>

                </div>


            </div>


            <span class="badge rounded-pill text-bg-light">

                <?php echo $totalBookings; ?>

                Bookings

            </span>


        </div>


        <div class="timeline">


            <?php

            if (
                mysqli_num_rows(
                    $history
                ) > 0
            ) {


                while (
                    $row =
                    mysqli_fetch_assoc(
                        $history
                    )
                ) {


                    $status =
                        strtolower(
                            $row['status']
                        );


                    /* STATUS CLASS */

                    if (
                        $status ===
                        'confirmed'
                    ) {

                        $statusClass =
                            'status-confirmed';

                        $dotClass =
                            'dot-confirmed';

                        $icon =
                            'fa-check';

                    } elseif (
                        $status ===
                        'pending'
                    ) {

                        $statusClass =
                            'status-pending';

                        $dotClass =
                            'dot-pending';

                        $icon =
                            'fa-clock';

                    } elseif (
                        $status ===
                        'cancelled'
                    ) {

                        $statusClass =
                            'status-cancelled';

                        $dotClass =
                            'dot-cancelled';

                        $icon =
                            'fa-xmark';

                    } else {

                        $statusClass =
                            'status-default';

                        $dotClass =
                            'dot-default';

                        $icon =
                            'fa-calendar';

                    }

            ?>


                <div class="timeline-item">


                    <!-- DOT -->

                    <div
                        class="timeline-dot
                        <?php echo $dotClass; ?>">

                        <i
                            class="fas
                            <?php echo $icon; ?>">
                        </i>

                    </div>


                    <!-- BOOKING -->

                    <div class="booking-event">


                        <div class="booking-event-top">


                            <div>


                                <div class="booking-date">

                                    <?php

                                    echo !empty(
                                        $row[
                                            'booking_date'
                                        ]
                                    )

                                        ? date(
                                            "d M Y",
                                            strtotime(
                                                $row[
                                                    'booking_date'
                                                ]
                                            )
                                        )

                                        : "Date unavailable";

                                    ?>

                                </div>


                                <div class="booking-time">

                                    <i
                                        class="far fa-clock">
                                    </i>

                                    <?php

                                    echo !empty(
                                        $row[
                                            'booking_time'
                                        ]
                                    )

                                        ? date(
                                            "h:i A",
                                            strtotime(
                                                $row[
                                                    'booking_time'
                                                ]
                                            )
                                        )

                                        : "Time unavailable";

                                    ?>

                                </div>


                            </div>


                            <span
                                class="status-badge
                                <?php echo $statusClass; ?>">

                                <?php

                                echo htmlspecialchars(
                                    $row['status']
                                );

                                ?>

                            </span>


                        </div>


                        <!-- BOOKING INFORMATION -->

                        <div class="booking-info">


                            <span class="info-chip">

                                <i
                                    class="fas fa-chair">
                                </i>

                                Table

                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $row[
                                            'booking_table'
                                        ]
                                    );

                                    ?>

                                </strong>

                            </span>


                            <span class="info-chip">

                                <i
                                    class="fas fa-users">
                                </i>

                                <?php

                                echo htmlspecialchars(
                                    $row['people']
                                );

                                ?>

                                People

                            </span>


                            <?php if (
                                !empty(
                                    $row[
                                        'special_event'
                                    ]
                                )
                            ) { ?>


                                <span class="info-chip">

                                    <i
                                        class="fas fa-champagne-glasses">
                                    </i>

                                    <?php

                                    echo htmlspecialchars(
                                        $row[
                                            'special_event'
                                        ]
                                    );

                                    ?>

                                </span>


                            <?php } ?>


                            <?php if (
                                isset(
                                    $row['is_paid']
                                )
                            ) { ?>


                                <span class="info-chip">

                                    <i
                                        class="fas
                                        <?php

                                        echo $row[
                                            'is_paid'
                                        ]
                                            ? 'fa-circle-check'
                                            : 'fa-circle-xmark';

                                        ?>">
                                    </i>

                                    <?php

                                    echo $row[
                                        'is_paid'
                                    ]
                                        ? 'Paid'
                                        : 'Unpaid';

                                    ?>

                                </span>


                            <?php } ?>


                        </div>


                        <!-- MESSAGE -->

                        <?php if (
                            !empty(
                                $row['message']
                            )
                        ) { ?>


                            <div class="booking-message">

                                <i
                                    class="fas fa-comment-dots">
                                </i>

                                <?php

                                echo htmlspecialchars(
                                    $row['message']
                                );

                                ?>

                            </div>


                        <?php } ?>


                    </div>


                </div>


            <?php

                }

            } else {

            ?>


                <div class="empty-history">


                    <i
                        class="fas fa-calendar-xmark">
                    </i>


                    <h5>

                        No Booking History

                    </h5>


                    <p>

                        This customer has no reservations yet.

                    </p>


                </div>


            <?php

            }

            ?>


        </div>


    </div>


</div>


<script
    src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>

