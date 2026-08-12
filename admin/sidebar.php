<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

global $conn;

/* DATABASE CONNECTION */
include "includes/db_connect.php";

/* ==============================
   GET ADMIN
============================== */

$email = $_SESSION['user_email'] ?? null;
$admin = null;

if ($email) {

    $emailSafe = mysqli_real_escape_string($conn, $email);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM clients WHERE email='$emailSafe' LIMIT 1"
    );

    if ($query) {
        $admin = mysqli_fetch_assoc($query);
    }
}


/* ==============================
   ADMIN IMAGE
============================== */

$img = 'default-user.png';

if (
    !empty($admin) &&
    !empty($admin['image'])
) {
    $img = $admin['image'];
}


/* ==============================
   CURRENT PAGE
============================== */

$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!-- =====================================================
     SIDEBAR CSS
===================================================== -->

<link rel="stylesheet" href="admin_panel.css">

<style>

    /* =========================================
       MOBILE MENU BUTTON
    ========================================= */

    .menu-toggle {
        display: none;
    }


    /* =========================================
       SIDEBAR LINK RESET
    ========================================= */

    .sidebar .nav-item a {
        text-decoration: none !important;
        color: #fff !important;
    }


    .sidebar .nav-item a:hover {
        text-decoration: none !important;
        color: #fff !important;
    }


    /* =========================================
       PROFILE IMAGE
    ========================================= */



    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 750px) {

        .menu-toggle {

            display: flex;

            justify-content: center;

            align-items: center;

            width: 42px;

            height: 42px;

            border: none;

            border-radius: 10px;

            background: #2e6bec;

            color: #fff;

            cursor: pointer;

            font-size: 18px;

            position: fixed;

            top: 15px;

            left: 15px;

            z-index: 1100;

        }


        .sidebar {

            transform: translateX(-100%);

            transition: transform .3s ease;

            z-index: 1050;

        }


        .sidebar.mobile-open {

            transform: translateX(0);

        }


        .sidebar-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background: rgba(0,0,0,.45);

            z-index: 1040;

        }


        .sidebar-overlay.show {

            display: block;

        }


        .admin-profile-image {

            width: 90px;

            height: 90px;

        }

    }

</style>


<!-- =====================================================
     MOBILE MENU BUTTON
===================================================== -->

<button
    type="button"
    class="menu-toggle"
    id="menuToggle"
    aria-label="Open menu"
    aria-expanded="false"
>

    <i class="fas fa-bars"></i>

</button>


<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar" id="adminSidebar">

    <!-- ===============================================
         LOGO / ADMIN PROFILE
    ================================================ -->

<div class="logo-brand">

    <div class="brand-name">

        <img
            src="logo.jpeg"
            class="brand-logo-image"
            alt="Aroma Haven Logo"
        >

    </div>
    <h3 style="color: #d4af37;">Aroma Haven</h3>

</div>


    <!-- ===============================================
         NAVIGATION
    ================================================ -->

    <div class="nav-menu">


        <!-- =========================================
             TOP MENU
        ========================================== -->

        <div class="top">


            <!-- DASHBOARD -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'admin_panel.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="admin_panel.php">

                    <i class="fas fa-chart-pie"></i>

                    <span>
                        Dashboard
                    </span>

                </a>

            </div>


            <!-- CUSTOMER -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'user_list.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="user_list.php">

                    <i class="fas fa-users"></i>

                    <span>
                        Customer
                    </span>

                </a>

            </div>


            <!-- CATEGORY -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'category_list.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="category_list.php">

                    <i class="fa-solid fa-layer-group"></i>

                    <span>
                        Category list
                    </span>

                </a>

            </div>


            <!-- SUBCATEGORY -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'subcategory_list.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="subcategory_list.php">

                    <i class="fas fa-boxes"></i>

                    <span>
                        Subcategory list
                    </span>

                </a>

            </div>


            <!-- PRODUCT -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'product_list.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="product_list.php">

                    <i class="fa fa-tasks"></i>

                    <span>
                        Product list
                    </span>

                </a>

            </div>


            <!-- ORDERS -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'order_list.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="order_list.php?page=1">

                    <i class="fa-solid fa-list"></i>

                    <span>
                        Order list
                    </span>

                </a>

            </div>


            <!-- PAYMENT -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage ===
                    'admin_payment_control.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="admin_payment_control.php?page=1">

                    <i class="fa fa-credit-card"></i>

                    <span>
                        Payment Control
                    </span>

                </a>

            </div>


            <!-- BOOKINGS -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage ===
                    'admin_manage_bookings.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="admin_manage_bookings.php?page=1">

                    <i class="fa-solid fa-clipboard-list"></i>

                    <span>
                        Bookings
                    </span>

                </a>

            </div>


            <!-- SUPPORT -->

            <div
                class="nav-item
                <?php
                echo (
                    $currentPage === 'support.php'
                )
                ? 'active'
                : '';
                ?>"
            >

                <a href="support.php?page=1">

                    <i class="fa fa-headset"></i>

                    <span>
                        Support
                    </span>

                </a>

            </div>


            <!-- HOME -->

            <div class="nav-item">

                <a href="../index.php">

                    <i class="fa-solid fa-house"></i>

                    <span>
                        Home Page
                    </span>

                </a>

            </div>


        </div>


        <!-- =========================================
             BOTTOM MENU
        ========================================== -->

        <div class="down">


            <!-- LOGOUT -->

            <div class="nav-item">

                <a href="../logout.php">

                    <i class="fa fa-sign-out"></i>

                    <span>
                        Logout
                    </span>

                </a>

            </div>


        </div>

        <div class="logo">

        <div class="name">

            <img
                src="../images/<?php echo htmlspecialchars($img); ?>"
                class="admin-profile-image"
                alt="Admin"
            >

        </div>
            <p>The Operator</p>


    </div>


    </div>

</div>


<!-- =====================================================
     MOBILE OVERLAY
===================================================== -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<!-- =====================================================
     MOBILE MENU JS
===================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const menuToggle =
            document.getElementById("menuToggle");

        const sidebar =
            document.getElementById("adminSidebar");

        const overlay =
            document.getElementById("sidebarOverlay");


        /*
        |--------------------------------------------------------------------------
        | SAFETY CHECK
        |--------------------------------------------------------------------------
        */

        if (
            !menuToggle ||
            !sidebar ||
            !overlay
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | OPEN / CLOSE
        |--------------------------------------------------------------------------
        */

        function toggleSidebar() {

            sidebar.classList.toggle(
                "mobile-open"
            );

            overlay.classList.toggle(
                "show"
            );


            const isOpen =
                sidebar.classList.contains(
                    "mobile-open"
                );


            menuToggle.setAttribute(
                "aria-expanded",
                isOpen
            );


            /*
             * Change icon
             */

            const icon =
                menuToggle.querySelector("i");


            if (icon) {

                icon.className = isOpen
                    ? "fas fa-times"
                    : "fas fa-bars";

            }

        }


        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        menuToggle.addEventListener(
            "click",
            toggleSidebar
        );


        /*
        |--------------------------------------------------------------------------
        | OVERLAY
        |--------------------------------------------------------------------------
        */

        overlay.addEventListener(
            "click",
            toggleSidebar
        );


        /*
        |--------------------------------------------------------------------------
        | CLOSE AFTER CLICKING LINK
        |--------------------------------------------------------------------------
        */

        const links =
            sidebar.querySelectorAll("a");


        links.forEach(function (link) {

            link.addEventListener(
                "click",
                function () {

                    if (
                        window.innerWidth <= 750
                    ) {

                        sidebar.classList.remove(
                            "mobile-open"
                        );

                        overlay.classList.remove(
                            "show"
                        );

                    }

                }
            );

        });


        /*
        |--------------------------------------------------------------------------
        | RESET WHEN DESKTOP
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            "resize",
            function () {

                if (
                    window.innerWidth > 750
                ) {

                    sidebar.classList.remove(
                        "mobile-open"
                    );

                    overlay.classList.remove(
                        "show"
                    );

                    menuToggle.setAttribute(
                        "aria-expanded",
                        "false"
                    );

                    const icon =
                        menuToggle.querySelector("i");


                    if (icon) {

                        icon.className =
                            "fas fa-bars";

                    }

                }

            }
        );

    }

);

</script>