<?php
session_start();
include "includes/db_connect.php";
global $conn;


/* =====================================================
   ORDER ID
===================================================== */

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($orderId <= 0) {
    die("Invalid Order ID.");
}


/* =====================================================
   FETCH ORDER
===================================================== */

$sql = "
    SELECT *
    FROM userorder
    WHERE id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $orderId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Order not found.");
}

$order = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* =====================================================
   UPDATE ORDER
===================================================== */

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customerName =
        trim($_POST['customer_name'] ?? '');

    $customerNumber =
        trim($_POST['customer_number'] ?? '');

    $shippingAddress =
        trim($_POST['shipping_address'] ?? '');

    $city =
        trim($_POST['city'] ?? '');

    $state =
        trim($_POST['state'] ?? '');

    $pin =
        trim($_POST['pin'] ?? '');

    $paymentMethod =
        trim($_POST['payment_method'] ?? 'Cash On Delivery');

    $paymentStatus =
        trim($_POST['payment_status'] ?? 'Pending');

    $orderStatus =
        trim($_POST['order_status'] ?? 'Pending');

    $deliveryStatus =
        trim($_POST['delivery_status'] ?? 'Preparing');

    $trackingNumber =
        trim($_POST['tracking_number'] ?? '');

    $estimatedDelivery =
        !empty($_POST['estimated_delivery'])
        ? $_POST['estimated_delivery']
        : null;

    $deliveryCharge =
        (float)($_POST['delivery_charge'] ?? 0);

    $couponCode =
        trim($_POST['coupon_code'] ?? '');

    $discountAmount =
        (float)($_POST['discount_amount'] ?? 0);

    $cancelReason =
        trim($_POST['cancel_reason'] ?? '');

    $cancelNote =
        trim($_POST['cancel_note'] ?? '');


    /* =================================================
       VALIDATION
    ================================================= */

    if ($customerName === '') {

        $error = "Customer name is required.";

    } elseif ($customerNumber === '') {

        $error = "Customer number is required.";

    } elseif ($orderStatus === 'Cancelled'
        && $cancelReason === '') {

        $error = "Please enter cancellation reason.";

    } else {


        /* =============================================
           CANCEL DATE
        ============================================= */

        $cancelledAt = $order['cancelled_at'];

        if ($orderStatus === 'Cancelled') {

            if (empty($cancelledAt)) {
                $cancelledAt = date('Y-m-d H:i:s');
            }

        } else {

            $cancelledAt = null;
            $cancelReason = '';
            $cancelNote = '';
        }


        /* =============================================
           UPDATE
        ============================================= */

        $updateSql = "
            UPDATE userorder
            SET

                customer_name = ?,
                customer_number = ?,

                shipping_address = ?,
                city = ?,
                state = ?,
                pin = ?,

                payment_method = ?,
                payment_status = ?,

                order_status = ?,
                delivery_status = ?,

                tracking_number = ?,
                estimated_delivery = ?,

                delivery_charge = ?,
                coupon_code = ?,
                discount_amount = ?,

                cancel_reason = ?,
                cancel_note = ?,
                cancelled_at = ?

            WHERE id = ?
        ";


        $updateStmt =
            mysqli_prepare(
                $conn,
                $updateSql
            );


        if (!$updateStmt) {

            $error =
                "Update Error: "
                . mysqli_error($conn);

        } else {


            mysqli_stmt_bind_param(
                $updateStmt,
                "ssssssssssssdsddssi",
                $customerName,
                $customerNumber,
                $shippingAddress,
                $city,
                $state,
                $pin,
                $paymentMethod,
                $paymentStatus,
                $orderStatus,
                $deliveryStatus,
                $trackingNumber,
                $estimatedDelivery,
                $deliveryCharge,
                $couponCode,
                $discountAmount,
                $cancelReason,
                $cancelNote,
                $cancelledAt,
                $orderId
            );


            if (
                mysqli_stmt_execute(
                    $updateStmt
                )
            ) {

                $success =
                    "Order updated successfully.";

                /* Refresh data */

                $stmt =
                    mysqli_prepare(
                        $conn,
                        "
                        SELECT *
                        FROM userorder
                        WHERE id = ?
                        LIMIT 1
                        "
                    );

                mysqli_stmt_bind_param(
                    $stmt,
                    "i",
                    $orderId
                );

                mysqli_stmt_execute($stmt);

                $result =
                    mysqli_stmt_get_result(
                        $stmt
                    );

                $order =
                    mysqli_fetch_assoc(
                        $result
                    );

                mysqli_stmt_close($stmt);

            } else {

                $error =
                    "Update failed: "
                    . mysqli_stmt_error(
                        $updateStmt
                    );
            }


            mysqli_stmt_close(
                $updateStmt
            );
        }
    }
}


/* =====================================================
   VALUES
===================================================== */

$productName =
    $order['product_name'] ?? 'N/A';

$productImage =
    trim(
        $order['product_image'] ?? ''
    );

$quantity =
    (int)(
        $order['quantity'] ?? 0
    );

$itemPrice =
    (float)(
        $order['item_price'] ?? 0
    );

$grandTotal =
    (float)(
        $order['grand_total'] ?? 0
    );

if ($grandTotal <= 0) {

    $grandTotal =
        (float)(
            $order['total_amount'] ?? 0
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

<title>
    Edit Order -
    <?php
    echo htmlspecialchars(
        $order['order_number']
        ?? ''
    );
    ?>
</title>


<link
    rel="stylesheet"
    href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"
>

    <link rel="icon" type="image/png" href="weblogo.png">


<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
>


<style>

/* =====================================================
   GLOBAL
===================================================== */

* {
    box-sizing: border-box;
}

body {
    background: #f5f7fb;
    font-family: "Inter", "Segoe UI", sans-serif;
    color: #172033;
}

.edit-order-wrapper {
    margin: 30px 4% 60px 20%;
    width: calc(100% - 25%);
    max-width: 1450px;
}


/* =====================================================
   HEADER
===================================================== */

.edit-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    margin-bottom: 25px;
}

.edit-title {
    display: flex;
    align-items: center;
    gap: 14px;
}

.edit-title-icon {
    width: 52px;
    height: 52px;

    border-radius: 15px;

    background: linear-gradient(
        135deg,
        #111827,
        #374151
    );

    color: white;

    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow:
        0 10px 25px rgba(17,24,39,.16);
}

.edit-title h1 {
    margin: 0;
    font-size: 27px;
    font-weight: 800;
}

.edit-title p {
    margin: 4px 0 0;
    color: #8992a3;
    font-size: 13px;
}


/* =====================================================
   GRID
===================================================== */

.edit-grid {
    display: grid;
    grid-template-columns:
        minmax(0, 1.65fr)
        minmax(300px, .75fr);

    gap: 22px;
}


/* =====================================================
   CARD
===================================================== */

.edit-card {
    background: #fff;

    border: 1px solid #e8ebf1;

    border-radius: 18px;

    padding: 24px;

    box-shadow:
        0 10px 35px rgba(31,41,55,.06);

    margin-bottom: 20px;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 10px;

    margin-bottom: 20px;

    font-size: 17px;
    font-weight: 800;
}

.card-title i {
    color: #6b7280;
}


/* =====================================================
   FORM
===================================================== */

.form-label {
    font-size: 12px;
    font-weight: 700;
    color: #596273;

    margin-bottom: 7px;
}

.form-control,
.form-select {

    min-height: 46px;

    border: 1px solid #e1e5eb;

    border-radius: 11px;

    background: #fafbfc;

    font-size: 14px;

    transition: .2s;
}

.form-control:focus,
.form-select:focus {

    border-color: #94a3b8;

    background: #fff;

    box-shadow:
        0 0 0 4px rgba(148,163,184,.12);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}


/* =====================================================
   STATUS SELECT
===================================================== */

.status-select {
    font-weight: 650;
}


/* =====================================================
   ALERT
===================================================== */

.premium-alert {

    border: none;

    border-radius: 13px;

    padding: 14px 17px;

    font-size: 14px;

    margin-bottom: 20px;
}


/* =====================================================
   PRODUCT CARD
===================================================== */

.product-preview {

    display: flex;

    gap: 15px;

    padding: 15px;

    background: #fafbfc;

    border: 1px solid #edf0f4;

    border-radius: 14px;
}

.product-preview img {

    width: 75px;
    height: 75px;

    object-fit: cover;

    border-radius: 12px;
}

.product-preview h4 {

    margin: 0 0 5px;

    font-size: 15px;

    font-weight: 750;
}

.product-preview p {

    margin: 3px 0;

    color: #7b8495;

    font-size: 13px;
}


/* =====================================================
   ORDER SUMMARY
===================================================== */

.summary-row {

    display: flex;

    justify-content: space-between;

    padding: 11px 0;

    border-bottom: 1px solid #edf0f4;

    color: #747d8d;

    font-size: 14px;
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-row strong {
    color: #202938;
}

.summary-total {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 12px;

    padding-top: 16px;

    border-top: 1px solid #e5e8ee;
}

.summary-total span {

    font-weight: 750;
}

.summary-total strong {

    font-size: 23px;

    font-weight: 850;
}


/* =====================================================
   ACTION BUTTONS
===================================================== */

.form-actions {

    display: flex;

    justify-content: flex-end;

    gap: 10px;

    margin-top: 5px;
}

.btn-premium {

    border: none;

    border-radius: 11px;

    padding: 11px 19px;

    font-size: 14px;

    font-weight: 700;

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    gap: 8px;
}

.btn-save {

    background: #111827;

    color: white;
}

.btn-cancel {

    background: #fff;

    color: #374151;

    border: 1px solid #e1e5eb;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1100px) {

    .edit-order-wrapper {

        margin-left: 3%;

        width: 94%;
    }

    .edit-grid {

        grid-template-columns: 1fr;
    }

}

@media(max-width:650px) {

    .edit-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;
    }

    .edit-card {

        padding: 18px;
    }

    .form-actions {

        flex-direction: column;
    }

    .btn-premium {

        justify-content: center;

        width: 100%;
    }

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


<div class="edit-order-wrapper">


    <!-- =================================================
         HEADER
    ================================================= -->

    <div class="edit-header">


        <div class="edit-title">


            <div class="edit-title-icon">

                <i class="fas fa-pen"></i>

            </div>


            <div>

                <h1>
                    Edit Order
                </h1>

                <p>

                    Update order
                    information and status

                </p>

            </div>


        </div>


        <div>

            <a
                href="order_list.php"
                class="btn-premium btn-cancel"
            >

                <i class="fas fa-arrow-left"></i>

                Back to Orders

            </a>

        </div>


    </div>


    <!-- =================================================
         ALERTS
    ================================================= -->

    <?php if ($success !== '') { ?>

        <div
            class="
            alert
            alert-success
            premium-alert
            "
        >

            <i
                class="
                fas
                fa-circle-check
                me-2
                "
            ></i>

            <?php
            echo htmlspecialchars(
                $success
            );
            ?>

        </div>

    <?php } ?>


    <?php if ($error !== '') { ?>

        <div
            class="
            alert
            alert-danger
            premium-alert
            "
        >

            <i
                class="
                fas
                fa-circle-exclamation
                me-2
                "
            ></i>

            <?php
            echo htmlspecialchars(
                $error
            );
            ?>

        </div>

    <?php } ?>


    <!-- =================================================
         FORM
    ================================================= -->

    <form
        method="POST"
        action=""
    >


        <div class="edit-grid">


            <!-- =========================================
                 LEFT
            ========================================== -->

            <div>


                <!-- CUSTOMER -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-user"></i>

                        Customer Information

                    </div>


                    <div class="row g-3">


                        <div class="col-md-6">

                            <label class="form-label">
                                Customer Name
                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['customer_name']
                                    ?? ''
                                );
                                ?>"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Customer Number
                            </label>

                            <input
                                type="text"
                                name="customer_number"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['customer_number']
                                    ?? ''
                                );
                                ?>"
                                required
                            >

                        </div>


                    </div>

                </div>


                <!-- SHIPPING -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-location-dot"></i>

                        Shipping Information

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Shipping Address
                        </label>

                        <textarea
                            name="shipping_address"
                            class="form-control"
                        ><?php
                        echo htmlspecialchars(
                            $order['shipping_address']
                            ?? ''
                        );
                        ?></textarea>

                    </div>


                    <div class="row g-3">


                        <div class="col-md-4">

                            <label class="form-label">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['city']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                State
                            </label>

                            <input
                                type="text"
                                name="state"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['state']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                PIN
                            </label>

                            <input
                                type="text"
                                name="pin"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['pin']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                    </div>

                </div>


                <!-- STATUS -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-sliders"></i>

                        Order & Delivery Status

                    </div>


                    <div class="row g-3">


                        <div class="col-md-4">

                            <label class="form-label">
                                Order Status
                            </label>

                            <select
                                name="order_status"
                                class="form-select status-select"
                            >

                                <?php

                                $statuses = [
                                    'Pending',
                                    'Confirmed',
                                    'Processing',
                                    'Shipped',
                                    'Delivered',
                                    'Cancelled'
                                ];

                                foreach (
                                    $statuses
                                    as $status
                                ) {

                                ?>

                                    <option
                                        value="<?php
                                        echo $status;
                                        ?>"
                                        <?php
                                        echo (
                                            ($order['order_status']
                                            ?? 'Pending')
                                            === $status
                                        )
                                        ? 'selected'
                                        : '';
                                        ?>
                                    >

                                        <?php
                                        echo $status;
                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Delivery Status
                            </label>

                            <select
                                name="delivery_status"
                                class="form-select"
                            >

                                <?php

                                $deliveryStatuses = [
                                    'Preparing',
                                    'On the way',
                                    'Near you',
                                    'Delivered'
                                ];

                                foreach (
                                    $deliveryStatuses
                                    as $status
                                ) {

                                ?>

                                    <option
                                        value="<?php
                                        echo $status;
                                        ?>"
                                        <?php
                                        echo (
                                            ($order['delivery_status']
                                            ?? 'Preparing')
                                            === $status
                                        )
                                        ? 'selected'
                                        : '';
                                        ?>
                                    >

                                        <?php
                                        echo $status;
                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Tracking Number
                            </label>

                            <input
                                type="text"
                                name="tracking_number"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['tracking_number']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                    </div>


                    <div class="row g-3 mt-1">


                        <div class="col-md-6">

                            <label class="form-label">
                                Estimated Delivery
                            </label>

                            <input
                                type="date"
                                name="estimated_delivery"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['estimated_delivery']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                    </div>

                </div>


                <!-- PAYMENT -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-credit-card"></i>

                        Payment Information

                    </div>


                    <div class="row g-3">


                        <div class="col-md-6">

                            <label class="form-label">
                                Payment Method
                            </label>

                            <select
                                name="payment_method"
                                class="form-select"
                            >

                                <?php

                                $methods = [
                                    'Cash On Delivery',
                                    'UPI',
                                    'Card',
                                    'Net Banking'
                                ];

                                foreach (
                                    $methods
                                    as $method
                                ) {

                                ?>

                                    <option
                                        value="<?php
                                        echo $method;
                                        ?>"
                                        <?php
                                        echo (
                                            ($order['payment_method']
                                            ?? '')
                                            === $method
                                        )
                                        ? 'selected'
                                        : '';
                                        ?>
                                    >

                                        <?php
                                        echo $method;
                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Payment Status
                            </label>

                            <select
                                name="payment_status"
                                class="form-select"
                            >

                                <?php

                                $paymentStatuses = [
                                    'Pending',
                                    'Paid',
                                    'Failed'
                                ];

                                foreach (
                                    $paymentStatuses
                                    as $status
                                ) {

                                ?>

                                    <option
                                        value="<?php
                                        echo $status;
                                        ?>"
                                        <?php
                                        echo (
                                            ($order['payment_status']
                                            ?? 'Pending')
                                            === $status
                                        )
                                        ? 'selected'
                                        : '';
                                        ?>
                                    >

                                        <?php
                                        echo $status;
                                        ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>


                    </div>

                </div>


                <!-- DISCOUNT -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-tag"></i>

                        Charges & Discount

                    </div>


                    <div class="row g-3">


                        <div class="col-md-4">

                            <label class="form-label">
                                Delivery Charge
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="delivery_charge"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['delivery_charge']
                                    ?? '0'
                                );
                                ?>"
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Coupon Code
                            </label>

                            <input
                                type="text"
                                name="coupon_code"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['coupon_code']
                                    ?? ''
                                );
                                ?>"
                            >

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Discount Amount
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="discount_amount"
                                class="form-control"
                                value="<?php
                                echo htmlspecialchars(
                                    $order['discount_amount']
                                    ?? '0'
                                );
                                ?>"
                            >

                        </div>


                    </div>

                </div>


                <!-- CANCELLATION -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-ban"></i>

                        Cancellation Details

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Cancel Reason
                        </label>

                        <input
                            type="text"
                            name="cancel_reason"
                            class="form-control"
                            value="<?php
                            echo htmlspecialchars(
                                $order['cancel_reason']
                                ?? ''
                            );
                            ?>"
                        >

                    </div>


                    <div>

                        <label class="form-label">
                            Cancel Note
                        </label>

                        <textarea
                            name="cancel_note"
                            class="form-control"
                        ><?php
                        echo htmlspecialchars(
                            $order['cancel_note']
                            ?? ''
                        );
                        ?></textarea>

                    </div>

                </div>


                <!-- ACTION -->
                <div class="form-actions">


                    <a
                        href="view_order.php?id=<?php
                            echo $orderId;
                        ?>"
                        class="btn-premium btn-cancel"
                    >

                        <i class="fas fa-eye"></i>

                        View Order

                    </a>


                    <button
                        type="submit"
                        class="btn-premium btn-save"
                    >

                        <i class="fas fa-check"></i>

                        Save Changes

                    </button>


                </div>


            </div>


            <!-- =========================================
                 RIGHT
            ========================================== -->

            <div>


                <!-- ORDER -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-receipt"></i>

                        Order Summary

                    </div>


                    <div class="product-preview">


                        <?php if (
                            $productImage !== ''
                        ) { ?>

                            <img
                                src="../images/<?php
                                echo htmlspecialchars(
                                    $productImage
                                );
                                ?>"
                                alt="Product"
                            >

                        <?php } else { ?>

                            <div
                                style="
                                width:75px;
                                height:75px;
                                border-radius:12px;
                                background:#f0f2f5;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                color:#9ca3af;
                                "
                            >

                                <i class="fas fa-image"></i>

                            </div>

                        <?php } ?>


                        <div>

                            <h4>

                                <?php
                                echo htmlspecialchars(
                                    $productName
                                );
                                ?>

                            </h4>


                            <p>

                                Quantity:
                                <strong>
                                    <?php
                                    echo $quantity;
                                    ?>
                                </strong>

                            </p>


                            <p>

                                Price:
                                <strong>

                                    ₹<?php
                                    echo number_format(
                                        $itemPrice,
                                        2
                                    );
                                    ?>

                                </strong>

                            </p>

                        </div>


                    </div>


                </div>


                <!-- TOTAL -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-wallet"></i>

                        Current Total

                    </div>


                    <div class="summary-row">

                        <span>
                            Item Price
                        </span>

                        <strong>
                            ₹<?php
                            echo number_format(
                                $itemPrice,
                                2
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Quantity
                        </span>

                        <strong>
                            ×<?php
                            echo $quantity;
                            ?>
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Delivery
                        </span>

                        <strong>
                            ₹<?php
                            echo number_format(
                                (float)(
                                    $order['delivery_charge']
                                    ?? 0
                                ),
                                2
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Discount
                        </span>

                        <strong style="color:#16a34a;">

                            -₹<?php
                            echo number_format(
                                (float)(
                                    $order['discount_amount']
                                    ?? 0
                                ),
                                2
                            );
                            ?>

                        </strong>

                    </div>


                    <div class="summary-total">

                        <span>
                            Grand Total
                        </span>

                        <strong>

                            ₹<?php
                            echo number_format(
                                $grandTotal,
                                2
                            );
                            ?>

                        </strong>

                    </div>


                </div>


                <!-- ORDER INFO -->
                <div class="edit-card">


                    <div class="card-title">

                        <i class="fas fa-info-circle"></i>

                        Order Information

                    </div>


                    <div class="summary-row">

                        <span>
                            Order ID
                        </span>

                        <strong>
                            #<?php
                            echo $orderId;
                            ?>
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Order Number
                        </span>

                        <strong>

                            <?php
                            echo htmlspecialchars(
                                $order['order_number']
                                ?? ''
                            );
                            ?>

                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Created
                        </span>

                        <strong>

                            <?php

                            echo !empty(
                                $order['created_at']
                            )
                            ? date(
                                "d M Y",
                                strtotime(
                                    $order['created_at']
                                )
                            )
                            : 'N/A';

                            ?>

                        </strong>

                    </div>


                </div>


            </div>


        </div>


    </form>


</div>


<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>