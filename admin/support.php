<!-- 
<?php
session_start();
include("includes/db_connect.php");
include("function.php");

/** @var mysqli $conn */

mysqli_query($conn, "
UPDATE support_messages
SET notification=0
WHERE sender='User'
");

// if(!isset($_SESSION['admin_id'])){
//     header("Location: login.php");
//     exit();
// }

$query = mysqli_query($conn, "
SELECT
    c.id,
    c.name,
    c.email,
    MAX(s.created_at) AS last_message,
    (
        SELECT COUNT(*)
        FROM support_messages sm
        WHERE sm.user_id=c.id
        AND sm.sender='User'
        AND sm.notification=1
    ) AS unread

FROM clients c

INNER JOIN support_messages s
ON c.id=s.user_id

GROUP BY c.id

ORDER BY last_message DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Customer Support</title>

<link rel="icon" href="weblogo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

body{
background:#f5f3ef;
font-family:Poppins,sans-serif;
}

.wrapper{
max-width:1200px;
margin:35px auto;
}

.title{
margin-bottom:25px;
font-size:30px;
font-weight:700;
color:#6F4E37;
}

.customer-card{

background:white;

border-radius:20px;

padding:20px;

margin-bottom:18px;

box-shadow:0 10px 30px rgba(0,0,0,.08);

display:flex;

justify-content:space-between;

align-items:center;

transition:.3s;

}

.customer-card:hover{

transform:translateY(-4px);

}

.left h5{

margin:0;

font-weight:700;

}

.left p{

margin:4px 0;

color:#777;

}

.badge1{

background:#ff4d4d;

color:white;

padding:7px 14px;

border-radius:30px;

font-size:13px;

}

.open-btn{

background:#6F4E37;

color:white;

padding:10px 24px;

border-radius:12px;

text-decoration:none;

transition:.3s;

}

.open-btn:hover{

background:#4d3526;

color:white;

}

</style>

</head>

<body>

<div class="wrapper">

<h2 class="title">
<i class="fa-solid fa-headset"></i>
Customer Support
</h2>

<?php
while ($row = mysqli_fetch_assoc($query)) {
?>

<div class="customer-card">

<div class="left">

<h5><?= htmlspecialchars($row['name']) ?></h5>

<p><?= htmlspecialchars($row['email']) ?></p>

<small>

Last Message :
<?= date("d M Y h:i A", strtotime($row['last_message'])) ?>

</small>

</div>

<div>

<?php
    if ($row['unread'] > 0) {
?>

<span class="badge1">

<?= $row['unread'] ?>

New

</span>

<?php
    }
?>

<a
href="support_chat.php?user_id=<?= $row['id'] ?>"
class="open-btn">

Open Chat

</a>

</div>

</div>

<?php
}
?>

</div>

</body>

</html> -->


<?php

include("includes/db_connect.php");
include("function.php");

/** @var mysqli $conn */


// ======================================================
// FETCH SUPPORT REQUESTS
// ======================================================

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

    INNER JOIN clients c
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
        content="width=device-width, initial-scale=1.0">

    <title>Customer Support</title>


    <link
        rel="icon"
        href="weblogo.png">


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <style>
        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

            font-family: Poppins, sans-serif;

        }


        body {

            background: #f5f3ef;

            padding: 30px;

        }


        /* ==================================================
           MAIN WRAPPER
        ================================================== */

        .support-wrapper {

            max-width: 1100px;

            margin: auto;

        }


        /* ==================================================
           PAGE HEADER
        ================================================== */

        .support-page-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 25px;

        }


        .support-title {

            margin: 0;

            color: #6F4E37;

            font-size: 30px;

            font-weight: 700;

        }


        .support-title i {

            margin-right: 8px;

        }


        .support-request-count {

            background: #6F4E37;

            color: white;

            padding: 8px 15px;

            border-radius: 30px;

            font-size: 14px;

        }


        /* ==================================================
           SUPPORT CARD
        ================================================== */

        .support-card {

            background: white;

            border-radius: 20px;

            padding: 22px;

            margin-bottom: 18px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .07);

            transition: .3s;

        }


        .support-card:hover {

            transform: translateY(-3px);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .10);

        }


        /* ==================================================
           CUSTOMER HEADER
        ================================================== */

        .support-card-header {

            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 20px;

        }


        .customer-name {

            margin: 0;

            color: #3d2b20;

            font-size: 19px;

            font-weight: 700;

        }


        .customer-email {

            margin: 7px 0 0;

            color: #777;

            font-size: 14px;

        }


        .customer-phone {

            margin: 5px 0 0;

            color: #888;

            font-size: 13px;

        }


        /* ==================================================
           NEW / READ
        ================================================== */

        .new-badge {

            background: #dc3545;

            color: white;

            padding: 6px 12px;

            border-radius: 30px;

            font-size: 12px;

            font-weight: 600;

            white-space: nowrap;

        }


        .read-badge {

            background: #e9ecef;

            color: #666;

            padding: 6px 12px;

            border-radius: 30px;

            font-size: 12px;

            white-space: nowrap;

        }


        /* ==================================================
           MESSAGE
        ================================================== */

        .support-message {

            margin-top: 18px;

            background: #faf7f3;

            border-left: 4px solid #6F4E37;

            padding: 15px 18px;

            border-radius: 10px;

        }


        .support-message-title {

            color: #6F4E37;

            font-size: 14px;

            font-weight: 700;

            margin-bottom: 8px;

        }


        .support-message-text {

            color: #444;

            line-height: 1.7;

            word-break: break-word;

        }


        /* ==================================================
           FOOTER
        ================================================== */

        .support-card-footer {

            margin-top: 18px;

            padding-top: 15px;

            border-top: 1px solid #eee;

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .support-date {

            color: #888;

            font-size: 13px;

        }


        .support-date i {

            margin-right: 5px;

        }


        .view-btn {

            background: #6F4E37;

            color: white;

            padding: 9px 18px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 13px;

            transition: .3s;

        }


        .view-btn:hover {

            background: #4d3526;

            color: white;

        }


        /* ==================================================
           EMPTY
        ================================================== */

        .support-empty {

            background: white;

            padding: 70px 20px;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .06);

        }


        .support-empty i {

            font-size: 55px;

            color: #C08B5C;

            margin-bottom: 15px;

        }


        .support-empty h4 {

            color: #4d3526;

            font-weight: 600;

        }


        .support-empty p {

            color: #888;

        }


        /* ==================================================
           MOBILE
        ================================================== */

        @media(max-width:768px) {

            body {

                padding: 15px;

            }


            .support-page-header {

                flex-direction: column;

                align-items: flex-start;

                gap: 12px;

            }


            .support-title {

                font-size: 24px;

            }


            .support-card-header {

                flex-direction: column;

            }


            .support-card-footer {

                flex-direction: column;

                align-items: flex-start;

                gap: 12px;

            }

        }
    </style>

</head>


<body>



    <div class="support-wrapper">


        <!-- ==================================================
         PAGE HEADER
    ================================================== -->

        <div class="support-page-header">


            <h2 class="support-title">

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


                <!-- ==================================================
                 CUSTOMER CARD
            ================================================== -->

                <div class="support-card">


                    <!-- CUSTOMER INFORMATION -->

                    <div class="support-card-header">


                        <div>


                            <h5 class="customer-name">

                                <?= htmlspecialchars(
                                    $row['name']
                                ) ?>

                            </h5>


                            <p class="customer-email">

                                <i class="fa-solid fa-envelope"></i>

                                <?= htmlspecialchars(
                                    $row['email']
                                ) ?>

                            </p>


                            <?php

                            if (!empty($row['mobile'])) {

                            ?>

                                <p class="customer-phone">

                                    <i class="fa-solid fa-phone"></i>

                                    <?= htmlspecialchars(
                                        $row['mobile']
                                    ) ?>

                                </p>

                            <?php

                            }

                            ?>


                        </div>


                        <!-- NEW / READ -->

                        <?php

                        if ($row['notification'] == 1) {

                        ?>

                            <span class="new-badge">

                                <i class="fa-solid fa-bell"></i>

                                New

                            </span>

                        <?php

                        } else {

                        ?>



                        <?php

                        }

                        ?>


                    </div>


                    <!-- ==================================================
                     MESSAGE
                ================================================== -->

                    <div class="support-message">


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


                    <!-- ==================================================
                     FOOTER
                ================================================== -->

                    <div class="support-card-footer">


                        <span class="support-date">

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

                    Customers haven't submitted any support
                    requests yet.

                </p>


            </div>


        <?php

        }


        ?>


    </div>


</body>

</html>