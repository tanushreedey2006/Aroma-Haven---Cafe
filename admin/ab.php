<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("includes/db_connect.php");
include("function.php");

/** @var mysqli $conn */

$query = mysqli_query($conn, "
    SELECT
        s.id,
        s.user_id,
        s.sender,
        s.message,
        s.notification,
        s.created_at,
        c.name,
        c.email,
        c.mobile
    FROM support_messages s
    LEFT JOIN clients c
        ON s.user_id = c.id
    WHERE s.sender = 'User'
    ORDER BY s.created_at DESC
");

if (!$query) {
    die("Database Error: " . mysqli_error($conn));
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

    <title>Customer Support | Aroma Haven</title>


    <!-- ==================================================
         FAVICON
    ================================================== -->

    <link
        rel="icon"
        type="image/png"
        href="weblogo.png"
    >


    <!-- ==================================================
         FONT AWESOME
    ================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >


    <!-- ==================================================
         BOOTSTRAP
    ================================================== -->

    <link
        rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"
    >


    <!-- ==================================================
         ADMIN PANEL CSS
    ================================================== -->

    <link
        rel="stylesheet"
        href="admin_panel.css"
    >


    <style>

        /* ==================================================
           SUPPORT PAGE ONLY
        ================================================== */

        .support-content {

            width: 100%;

            padding: 30px;

            box-sizing: border-box;

        }


        /* ==================================================
           SUPPORT HEADER
        ================================================== */

        .support-page-heading {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

            gap: 20px;

        }


        .support-page-title {

            margin:0%  20%;

            color: #6F4E37;

            font-size: 30px;

            font-weight: 700;

        }


        .support-page-title i {

            margin-right: 8px;

        }


        .support-request-count {

            background: #6F4E37;

            color: #ffffff;

            padding: 9px 17px;

            border-radius: 30px;

            font-size: 14px;

            white-space: nowrap;

        }


        /* ==================================================
           SUPPORT CARD
        ================================================== */

        .support-customer-card {

            width: 100%;

            background: #ffffff;

            border-radius: 18px;

            padding: 22px;

            margin-bottom: 18px;

            border: 1px solid #eee7e0;

            box-shadow:
                0 8px 25px
                rgba(0, 0, 0, 0.07);

            transition: 0.3s ease;

        }


        .support-customer-card:hover {

            transform: translateY(-3px);

            box-shadow:
                0 14px 35px
                rgba(0, 0, 0, 0.10);

        }


        /* ==================================================
           CUSTOMER INFORMATION
        ================================================== */

        .support-customer-header {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 20px;

        }


        .support-customer-name {

            margin: 0;

            color: #3d2b20;

            font-size: 19px;

            font-weight: 700;

        }


        .support-customer-email {

            margin: 7px 0 0;

            color: #777;

            font-size: 14px;

        }


        .support-customer-phone {

            margin: 5px 0 0;

            color: #888;

            font-size: 13px;

        }


        /* ==================================================
           NEW BADGE
        ================================================== */

        .support-new-badge {

            background: #dc3545;

            color: #ffffff;

            padding: 6px 12px;

            border-radius: 30px;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

        }


        .support-read-badge {

            background: #eeeeee;

            color: #666666;

            padding: 6px 12px;

            border-radius: 30px;

            font-size: 12px;

            white-space: nowrap;

        }


        /* ==================================================
           MESSAGE BOX
        ================================================== */

        .support-message-box {

            margin-top: 18px;

            background: #faf7f3;

            border-left: 4px solid #6F4E37;

            padding: 16px 18px;

            border-radius: 10px;

        }


        .support-message-title {

            color: #6F4E37;

            font-size: 14px;

            font-weight: 700;

            margin-bottom: 8px;

        }


        .support-message-title i {

            margin-right: 6px;

        }


        .support-message-text {

            color: #444444;

            line-height: 1.7;

            word-break: break-word;

        }


        /* ==================================================
           DATE
        ================================================== */

        .support-message-footer {

            margin-top: 18px;

            padding-top: 14px;

            border-top: 1px solid #eeeeee;

        }


        .support-message-date {

            color: #888888;

            font-size: 13px;

        }


        .support-message-date i {

            margin-right: 5px;

        }


        /* ==================================================
           EMPTY STATE
        ================================================== */

        .support-empty {

            width: 100%;

            background: #ffffff;

            padding: 70px 20px;

            border-radius: 18px;

            text-align: center;

            border: 1px solid #eee7e0;

            box-shadow:
                0 8px 25px
                rgba(0, 0, 0, 0.06);

        }


        .support-empty i {

            font-size: 55px;

            color: #C08B5C;

            margin-bottom: 15px;

        }


        .support-empty h4 {

            color: #4d3526;

            font-weight: 600;

            margin-bottom: 8px;

        }


        .support-empty p {

            color: #888888;

            margin: 0;

        }


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 768px) {

            .support-content {

                padding: 20px 15px;

            }


            .support-page-heading {

                flex-direction: column;

                align-items: flex-start;

            }


            .support-page-title {

                font-size: 24px;

            }


            .support-customer-header {

                flex-direction: column;

            }

        }

    </style>

</head>


<body>


<!-- ======================================================
     SIDEBAR
====================================================== -->

<?php include "sidebar.php"; ?>


<!-- ======================================================
     MAIN DASHBOARD AREA
====================================================== -->

<div class="main-content" style="margin-left:-2%; margin-top: -1.8%;  min-width:104%;">


    <!-- ==================================================
         ADMIN HEADER
    ================================================== -->
<div class="">
  <?php include "header.php"; ?>
</div></div>



    <!-- ==================================================
         SUPPORT CONTENT
    ================================================== -->

    <main class="support-content">


        <!-- ==================================================
             PAGE TITLE
        ================================================== -->

        <div class="support-page-heading">


            <h2 class="support-page-title">

                <i class="fa-solid fa-headset"></i>

                Customer Support

            </h2>


            <span class="support-request-count">

                <i class="fa-solid fa-envelope"></i>

                <?= mysqli_num_rows($query) ?>

                Requests

            </span>


        </div>


        <!-- ==================================================
             SUPPORT REQUESTS
        ================================================== -->

        <?php

        if (mysqli_num_rows($query) > 0) {

            while ($row = mysqli_fetch_assoc($query)) {

        ?>


                <!-- ==========================================
                     CUSTOMER CARD
                ========================================== -->

                <div class="support-customer-card">


                    <!-- ======================================
                         CUSTOMER INFORMATION
                    ====================================== -->

<div class="support-customer-header">

    <div>

        <h5 class="support-customer-name">

            <?= htmlspecialchars(
                $row['name'] ?? 'Unknown Customer'
            ) ?>

        </h5>

        <p class="support-customer-email">

            <i class="fa-solid fa-envelope"></i>

            <?= htmlspecialchars(
                $row['email'] ?? 'Email not available'
            ) ?>

        </p>

        <?php if (!empty($row['mobile'])) { ?>

            <p class="support-customer-phone">

                <i class="fa-solid fa-phone"></i>

                <?= htmlspecialchars($row['mobile']) ?>

            </p>

        <?php } ?>

    </div>


    <?php if ((int)$row['notification'] === 1) { ?>

        <span class="support-new-badge">

            <i class="fa-solid fa-bell"></i>

            New

        </span>

    <?php } else { ?>

        <span class="support-read-badge">

            Read

        </span>

    <?php } ?>

</div>


                    <!-- ======================================
                         CUSTOMER MESSAGE
                    ====================================== -->

                    <div class="support-message-box">


                        <div class="support-message-title">

                            <i class="fa-solid fa-message"></i>

                            Customer Message

                        </div>


                        <div class="support-message-text">

                            <?= nl2br(
                                htmlspecialchars(
                                    $row['message']
                                )
                            ) ?>

                        </div>


                    </div>


                    <!-- ======================================
                         DATE
                    ====================================== -->

                    <div class="support-message-footer">


                        <span class="support-message-date">

                            <i class="fa-regular fa-clock"></i>

                            <?= date(
                                "d M Y, h:i A",
                                strtotime(
                                    $row['created_at']
                                )
                            ) ?>

                        </span>


                    </div>


                </div>


        <?php

            }

        } else {

        ?>


            <!-- ==================================================
                 EMPTY STATE
            ================================================== -->

            <div class="support-empty">


                <i class="fa-solid fa-headset"></i>


                <h4>

                    No Support Requests

                </h4>


                <p>

                    There are currently no customer
                    support messages.

                </p>


            </div>


        <?php

        }


        ?>


    </main>


</div>


<!-- ======================================================
     BOOTSTRAP JS
====================================================== -->

<script
    src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>
