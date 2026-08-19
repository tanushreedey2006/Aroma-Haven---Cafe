<?php

session_start();

include("connect.php");

/** @var mysqli $conn */

$action = $_POST['action'] ?? '';

$status = "error";
$message = "Something went wrong. Please try again.";
$title = "Oops!";


/* =========================================================
   CANCEL ORDER
========================================================= */

if ($action === "cancel") {

    $order_number = $_POST['order_number'] ?? '';
    $reason       = $_POST['reason'] ?? '';
    $note         = $_POST['note'] ?? '';


    if (!empty($order_number)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE userorder
             SET
                order_status = 'Cancelled',
                cancel_reason = ?,
                cancel_note = ?,
                cancelled_at = NOW()
             WHERE order_number = ?"
        );


        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $reason,
                $note,
                $order_number
            );


            if (mysqli_stmt_execute($stmt)) {

                if (mysqli_stmt_affected_rows($stmt) > 0) {

                    $status = "success";
                    $title = "Order Cancelled!";
                    $message = "Your order has been cancelled successfully.";

                } else {

                    $status = "error";
                    $title = "Order Not Found!";
                    $message = "We could not find this order.";

                }

            }

            mysqli_stmt_close($stmt);
        }
    }
}


/* =========================================================
   DELETE ORDER
========================================================= */

elseif ($action === "delete") {

    $order_number = $_POST['order_number'] ?? '';


    if (!empty($order_number)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE userorder
             SET is_deleted = 1
             WHERE order_number = ?"
        );


        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "s",
                $order_number
            );


            if (mysqli_stmt_execute($stmt)) {

                if (mysqli_stmt_affected_rows($stmt) > 0) {

                    $status = "success";
                    $title = "Order Deleted!";
                    $message = "Your order has been removed successfully.";

                } else {

                    $status = "error";
                    $title = "Order Not Found!";
                    $message = "This order could not be deleted.";

                }

            }

            mysqli_stmt_close($stmt);
        }
    }
}


/* =========================================================
   INVALID ACTION
========================================================= */

else {

    $status = "error";
    $title = "Invalid Request!";
    $message = "The requested action is not valid.";

}

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title><?php echo $title; ?> | Aroma Haven</title>

<link rel="icon"
      type="image/png"
      href="weblogo.png">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

/* ================= PAGE ================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    font-family:Arial,sans-serif;

    background:
        radial-gradient(circle at top left,#fff6ef,#f1e3d6),
        radial-gradient(circle at bottom right,#f9eee5,#e9d7c6);

    overflow:hidden;
}


/* ================= BACKGROUND BLOBS ================= */

.blob{

    position:fixed;

    width:300px;

    height:300px;

    border-radius:50%;

    background:rgba(166,89,53,.12);

    filter:blur(70px);

    z-index:-1;

}

.blob1{

    top:-100px;

    left:-100px;

}

.blob2{

    bottom:-100px;

    right:-100px;

}


/* ================= OVERLAY ================= */

.success-overlay{

    width:100%;

    min-height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;

    padding:20px;

}


/* ================= CARD ================= */

.success-card{

    width:100%;

    max-width:430px;

    background:#ffffff;

    border-radius:30px;

    padding:45px 35px;

    text-align:center;

    box-shadow:
        0 25px 80px rgba(74,36,16,.20);

    animation:popCard .5s ease;

}


/* ================= ANIMATION ================= */

@keyframes popCard{

    from{

        opacity:0;

        transform:
            scale(.7)
            translateY(50px);

    }

    to{

        opacity:1;

        transform:
            scale(1)
            translateY(0);

    }

}


/* ================= ICON ================= */

.success-icon{

    width:90px;

    height:90px;

    margin:0 auto 25px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:40px;

}


.success-icon.success{

    background:#e8f8ee;

    color:#28a745;

    box-shadow:
        0 10px 30px
        rgba(40,167,69,.20);

}


.success-icon.error{

    background:#fff0f0;

    color:#dc3545;

    box-shadow:
        0 10px 30px
        rgba(220,53,69,.18);

}


/* ================= TEXT ================= */

.success-card h1{

    color:#4a2410;

    font-size:28px;

    margin-bottom:12px;

}

.success-card p{

    color:#777;

    line-height:1.7;

    font-size:15px;

    margin-bottom:30px;

}


/* ================= BUTTON ================= */

.continue-btn{

    width:100%;

    border:none;

    padding:15px;

    border-radius:15px;

    background:
        linear-gradient(
            135deg,
            #4a2410,
            #8b4513
        );

    color:white;

    font-size:15px;

    font-weight:600;

    cursor:pointer;

    transition:.3s;

    box-shadow:
        0 10px 25px
        rgba(74,36,16,.25);

}


.continue-btn:hover{

    transform:translateY(-3px);

    box-shadow:
        0 15px 35px
        rgba(74,36,16,.35);

}


/* ================= ERROR BUTTON ================= */

.error-btn{

    background:
        linear-gradient(
            135deg,
            #dc3545,
            #ff6b6b
        );

}

</style>

</head>


<body>


<div class="blob blob1"></div>

<div class="blob blob2"></div>


<div class="success-overlay">


<div class="success-card">


<!-- ICON -->

<div class="success-icon <?php echo $status; ?>">

    <?php if($status === "success"){ ?>

        <i class="fa-solid fa-check"></i>

    <?php } else { ?>

        <i class="fa-solid fa-xmark"></i>

    <?php } ?>

</div>


<!-- TITLE -->

<h1>

    <?php echo htmlspecialchars($title); ?>

</h1>


<!-- MESSAGE -->

<p>

    <?php echo htmlspecialchars($message); ?>

</p>


<!-- BUTTON -->

<button

    class="continue-btn
    <?php echo $status === 'error' ? 'error-btn' : ''; ?>"

    onclick="goBack()">

    <?php if($status === "success"){ ?>

        <i class="fa-solid fa-arrow-left"></i>

        Back to My Orders

    <?php } else { ?>

        <i class="fa-solid fa-arrow-left"></i>

        Go Back

    <?php } ?>

</button>


</div>

</div>


<script>

function goBack(){

    window.location.href = "userorder.php";

}

</script>


</body>

</html>