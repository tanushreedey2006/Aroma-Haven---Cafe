<?php
session_start();
include "includes/db_connect.php";
global $conn;

/* =====================================================
   GET ORDER ID
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
   SAFE VALUES
===================================================== */

$orderNumber = $order['order_number'] ?? 'N/A';
$customerName = $order['customer_name'] ?? 'N/A';
$customerNumber = $order['customer_number'] ?? 'N/A';

$productName = $order['product_name'] ?? 'N/A';
$productImage = trim($order['product_image'] ?? '');

$quantity = (int)($order['quantity'] ?? 0);

$itemPrice = (float)($order['item_price'] ?? 0);
$totalAmount = (float)($order['total_amount'] ?? 0);
$deliveryCharge = (float)($order['delivery_charge'] ?? 0);
$discountAmount = (float)($order['discount_amount'] ?? 0);
$grandTotal = (float)($order['grand_total'] ?? 0);

if ($grandTotal <= 0) {
    $grandTotal = $totalAmount;
}

$paymentMethod = $order['payment_method'] ?? 'Cash On Delivery';
$paymentStatus = $order['payment_status'] ?? 'Pending';

$orderStatus = $order['order_status'] ?? 'Pending';
$deliveryStatus = $order['delivery_status'] ?? 'Preparing';

$shippingAddress = $order['shipping_address'] ?? '';
$city = $order['city'] ?? '';
$state = $order['state'] ?? '';
$pin = $order['pin'] ?? '';

$trackingNumber = $order['tracking_number'] ?? '';
$estimatedDelivery = $order['estimated_delivery'] ?? '';

$couponCode = $order['coupon_code'] ?? '';

$cancelReason = $order['cancel_reason'] ?? '';
$cancelNote = $order['cancel_note'] ?? '';
$cancelledAt = $order['cancelled_at'] ?? '';

$createdAt = $order['created_at'] ?? '';

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
    View Order - <?php echo htmlspecialchars($orderNumber); ?>
</title>


    <link rel="icon" type="image/png" href="weblogo.png">

    
<link
    rel="stylesheet"
    href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"
>

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
    color: #172033;
    font-family: "Inter", "Segoe UI", sans-serif;
}

.view-order-wrapper {
    margin: 30px 4% 50px 20%;
    width: calc(100% - 25%);
    max-width: 1450px;
}


/* =====================================================
   TOP BAR
===================================================== */

.order-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 25px;
}

.order-heading {
    display: flex;
    align-items: center;
    gap: 15px;
}

.order-heading-icon {
    width: 52px;
    height: 52px;
    border-radius: 15px;
    background: linear-gradient(135deg, #111827, #374151);
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;

    box-shadow:
        0 10px 25px rgba(17,24,39,.18);
}

.order-heading h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 800;
}

.order-heading p {
    margin: 3px 0 0;
    color: #7b8495;
    font-size: 14px;
}

.top-actions {
    display: flex;
    gap: 10px;
}

.btn-premium {
    border: none;
    padding: 11px 18px;
    border-radius: 11px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-back {
    background: #fff;
    color: #374151;
    border: 1px solid #e4e8ef;
}

.btn-edit {
    background: #111827;
    color: #fff;
}


/* =====================================================
   MAIN GRID
===================================================== */

.order-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.8fr) minmax(300px, .9fr);
    gap: 22px;
}


/* =====================================================
   CARD
===================================================== */

.premium-card {
    background: #fff;
    border: 1px solid #e8ebf1;
    border-radius: 18px;
    padding: 24px;

    box-shadow:
        0 10px 35px rgba(31,41,55,.06);
}

.card-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 22px;
}

.card-heading h3 {
    margin: 0;
    font-size: 17px;
    font-weight: 800;
}

.card-heading i {
    color: #8b93a3;
}


/* =====================================================
   ORDER HERO
===================================================== */

.order-hero {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding-bottom: 20px;
    border-bottom: 1px solid #edf0f5;
}

.order-number-large {
    font-size: 21px;
    font-weight: 800;
}

.order-date {
    margin-top: 5px;
    color: #8992a3;
    font-size: 13px;
}


/* =====================================================
   STATUS
===================================================== */

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    padding: 8px 13px;
    border-radius: 30px;

    font-size: 12px;
    font-weight: 700;
}

.status-pending {
    background: #fff7df;
    color: #9a6700;
}

.status-confirmed {
    background: #eaf2ff;
    color: #2563eb;
}

.status-processing {
    background: #fff1df;
    color: #c66a00;
}

.status-shipped {
    background: #eeeaff;
    color: #6845d8;
}

.status-delivered {
    background: #e9f9ef;
    color: #15803d;
}

.status-cancelled {
    background: #fff0f0;
    color: #dc2626;
}


/* =====================================================
   PRODUCT
===================================================== */

.product-box {
    display: flex;
    align-items: center;
    gap: 18px;

    padding: 18px;

    background: #fafbfc;
    border: 1px solid #edf0f4;
    border-radius: 14px;
}

.product-image {
    width: 85px;
    height: 85px;

    border-radius: 13px;
    object-fit: cover;

    border: 1px solid #e6e9ef;
}

.no-product-image {
    width: 85px;
    height: 85px;

    border-radius: 13px;
    background: #f0f2f5;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #9ca3af;
    font-size: 24px;
}

.product-info h4 {
    margin: 0 0 6px;

    font-size: 16px;
    font-weight: 750;
}

.product-info p {
    margin: 3px 0;
    color: #7b8495;
    font-size: 13px;
}


/* =====================================================
   INFORMATION GRID
===================================================== */

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.info-item {
    padding: 14px 15px;

    background: #fafbfc;

    border: 1px solid #edf0f4;
    border-radius: 12px;
}

.info-label {
    display: block;

    color: #8a93a3;

    font-size: 11px;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: .5px;

    margin-bottom: 5px;
}

.info-value {
    font-size: 14px;
    font-weight: 650;
    color: #1f2937;
}


/* =====================================================
   CUSTOMER
===================================================== */

.customer-profile {
    display: flex;
    align-items: center;
    gap: 13px;

    margin-bottom: 20px;
}

.customer-avatar-large {
    width: 52px;
    height: 52px;

    border-radius: 15px;

    background: linear-gradient(
        135deg,
        #111827,
        #4b5563
    );

    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-weight: 800;
    font-size: 20px;
}

.customer-profile h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 750;
}

.customer-profile p {
    margin: 3px 0 0;
    color: #8a93a3;
    font-size: 13px;
}


/* =====================================================
   PRICE
===================================================== */

.price-list {
    display: flex;
    flex-direction: column;
    gap: 13px;
}

.price-row {
    display: flex;
    justify-content: space-between;

    color: #70798a;
    font-size: 14px;
}

.price-row strong {
    color: #202938;
}

.price-total {
    border-top: 1px solid #e8ebf0;

    padding-top: 16px;
    margin-top: 5px;

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-total span {
    font-size: 15px;
    font-weight: 700;
}

.price-total strong {
    font-size: 23px;
    font-weight: 850;
    color: #111827;
}


/* =====================================================
   DELIVERY TRACK
===================================================== */

.delivery-box {
    display: flex;
    align-items: center;
    gap: 12px;

    padding: 14px;

    border-radius: 13px;

    background: #f8fafc;
    border: 1px solid #edf0f4;
}

.delivery-icon {
    width: 42px;
    height: 42px;

    border-radius: 12px;

    background: #eef4ff;
    color: #2563eb;

    display: flex;
    align-items: center;
    justify-content: center;
}

.delivery-box strong {
    display: block;
    font-size: 14px;
}

.delivery-box small {
    color: #8b94a4;
}


/* =====================================================
   ADDRESS
===================================================== */

.address-box {
    line-height: 1.7;

    padding: 15px;

    background: #fafbfc;
    border: 1px solid #edf0f4;

    border-radius: 13px;

    color: #596273;
    font-size: 14px;
}


/* =====================================================
   CANCELLED
===================================================== */

.cancel-box {
    background: #fff5f5;
    border: 1px solid #ffd9d9;
    border-radius: 13px;
    padding: 15px;
}

.cancel-box strong {
    color: #dc2626;
}

.cancel-box p {
    margin: 7px 0 0;
    color: #6b7280;
    font-size: 13px;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width: 1100px) {

    .view-order-wrapper {
        margin-left: 3%;
        width: 94%;
    }

    .order-grid {
        grid-template-columns: 1fr;
    }

}

@media(max-width: 650px) {

    .order-topbar {
        flex-direction: column;
        align-items: flex-start;
    }

    .top-actions {
        width: 100%;
    }

    .btn-premium {
        flex: 1;
        justify-content: center;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .order-hero {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
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



<div class="view-order-wrapper">


    <!-- TOP -->
    <div class="order-topbar">

        <div class="order-heading">

            <div class="order-heading-icon">
                <i class="fas fa-receipt"></i>
            </div>

            <div>

                <h1>Order Details</h1>

                <p>
                    Manage and review order information
                </p>

            </div>

        </div>


        <div class="top-actions">

            <a
                href="order_list.php"
                class="btn-premium btn-back"
            >
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <a
                href="edit_order.php?id=<?php echo $orderId; ?>"
                class="btn-premium btn-edit"
            >
                <i class="fas fa-pen"></i>
                Edit Order
            </a>

        </div>

    </div>


    <div class="order-grid">


        <!-- =================================================
             LEFT
        ================================================= -->

        <div>


            <!-- ORDER -->
            <div class="premium-card">

                <div class="order-hero">

                    <div>

                        <div class="order-number-large">

                            <?php echo htmlspecialchars($orderNumber); ?>

                        </div>

                        <div class="order-date">

                            <i class="far fa-calendar me-1"></i>

                            <?php
                            echo $createdAt
                                ? date(
                                    "d M Y, h:i A",
                                    strtotime($createdAt)
                                )
                                : "Date unavailable";
                            ?>

                        </div>

                    </div>


                    <span class="status-pill
                        <?php
                        echo 'status-' .
                            strtolower(
                                $orderStatus
                            );
                        ?>"
                    >

                        <i class="fas fa-circle"></i>

                        <?php echo htmlspecialchars($orderStatus); ?>

                    </span>

                </div>


                <div style="margin-top:22px;">


                    <div class="card-heading">

                        <h3>
                            <i class="fas fa-box me-2"></i>
                            Product
                        </h3>

                    </div>


                    <div class="product-box">


                        <?php if ($productImage !== '') { ?>

                            <img
                                src="../images/<?php
                                    echo htmlspecialchars(
                                        $productImage
                                    );
                                ?>"
                                class="product-image"
                                alt="Product"
                            >

                        <?php } else { ?>

                            <div class="no-product-image">

                                <i class="fas fa-image"></i>

                            </div>

                        <?php } ?>


                        <div class="product-info">

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
                                    <?php echo $quantity; ?>
                                </strong>
                            </p>

                            <p>
                                Unit Price:
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

            </div>


            <!-- CUSTOMER -->
            <div class="premium-card mt-4">

                <div class="card-heading">

                    <h3>
                        <i class="fas fa-user me-2"></i>
                        Customer Information
                    </h3>

                </div>


                <div class="customer-profile">

                    <div class="customer-avatar-large">

                        <?php
                        echo strtoupper(
                            substr(
                                $customerName,
                                0,
                                1
                            )
                        );
                        ?>

                    </div>

                    <div>

                        <h4>
                            <?php
                            echo htmlspecialchars(
                                $customerName
                            );
                            ?>
                        </h4>

                        <p>
                            <i class="fas fa-phone me-1"></i>
                            <?php
                            echo htmlspecialchars(
                                $customerNumber
                            );
                            ?>
                        </p>

                    </div>

                </div>


                <div class="info-grid">

                    <div class="info-item">

                        <span class="info-label">
                            Customer ID
                        </span>

                        <span class="info-value">
                            #<?php
                            echo (int)$order['customer_id'];
                            ?>
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Payment Method
                        </span>

                        <span class="info-value">
                            <?php
                            echo htmlspecialchars(
                                $paymentMethod
                            );
                            ?>
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Payment Status
                        </span>

                        <span class="info-value">
                            <?php
                            echo htmlspecialchars(
                                $paymentStatus
                            );
                            ?>
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Order Status
                        </span>

                        <span class="info-value">
                            <?php
                            echo htmlspecialchars(
                                $orderStatus
                            );
                            ?>
                        </span>

                    </div>

                </div>

            </div>


            <!-- SHIPPING -->
            <div class="premium-card mt-4">

                <div class="card-heading">

                    <h3>
                        <i class="fas fa-location-dot me-2"></i>
                        Shipping Address
                    </h3>

                </div>


                <div class="address-box">

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $shippingAddress
                        )
                    );
                    ?>

                    <br>

                    <?php
                    echo htmlspecialchars($city);
                    ?>,

                    <?php
                    echo htmlspecialchars($state);
                    ?>

                    -

                    <?php
                    echo htmlspecialchars($pin);
                    ?>

                </div>

            </div>


            <?php if (
                strtolower($orderStatus) === 'cancelled'
            ) { ?>

                <div class="premium-card mt-4">

                    <div class="card-heading">

                        <h3 style="color:#dc2626;">
                            <i class="fas fa-ban me-2"></i>
                            Cancellation Details
                        </h3>

                    </div>


                    <div class="cancel-box">

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $cancelReason ?: "Order Cancelled"
                            );
                            ?>
                        </strong>

                        <?php if ($cancelNote !== '') { ?>

                            <p>
                                <?php
                                echo htmlspecialchars(
                                    $cancelNote
                                );
                                ?>
                            </p>

                        <?php } ?>


                        <?php if ($cancelledAt) { ?>

                            <p>
                                Cancelled on:
                                <?php
                                echo date(
                                    "d M Y, h:i A",
                                    strtotime($cancelledAt)
                                );
                                ?>
                            </p>

                        <?php } ?>

                    </div>

                </div>

            <?php } ?>


        </div>


        <!-- =================================================
             RIGHT
        ================================================= -->

        <div>


            <!-- PAYMENT -->
            <div class="premium-card">

                <div class="card-heading">

                    <h3>
                        <i class="fas fa-wallet me-2"></i>
                        Payment Summary
                    </h3>

                </div>


                <div class="price-list">

                    <div class="price-row">

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


                    <div class="price-row">

                        <span>
                            Quantity
                        </span>

                        <strong>
                            ×<?php echo $quantity; ?>
                        </strong>

                    </div>


                    <div class="price-row">

                        <span>
                            Delivery Charge
                        </span>

                        <strong>
                            ₹<?php
                            echo number_format(
                                $deliveryCharge,
                                2
                            );
                            ?>
                        </strong>

                    </div>


                    <?php if ($discountAmount > 0) { ?>

                        <div class="price-row">

                            <span>
                                Discount
                            </span>

                            <strong style="color:#16a34a;">
                                -₹<?php
                                echo number_format(
                                    $discountAmount,
                                    2
                                );
                                ?>
                            </strong>

                        </div>

                    <?php } ?>


                    <?php if ($couponCode !== '') { ?>

                        <div class="price-row">

                            <span>
                                Coupon
                            </span>

                            <strong>
                                <?php
                                echo htmlspecialchars(
                                    $couponCode
                                );
                                ?>
                            </strong>

                        </div>

                    <?php } ?>


                    <div class="price-total">

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

            </div>


            <!-- DELIVERY -->
            <div class="premium-card mt-4">

                <div class="card-heading">

                    <h3>
                        <i class="fas fa-truck me-2"></i>
                        Delivery
                    </h3>

                </div>


                <div class="delivery-box">

                    <div class="delivery-icon">

                        <i class="fas fa-truck"></i>

                    </div>

                    <div>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $deliveryStatus
                            );
                            ?>
                        </strong>

                        <small>
                            Current delivery status
                        </small>

                    </div>

                </div>


                <?php if ($trackingNumber !== '') { ?>

                    <div class="info-item mt-3">

                        <span class="info-label">
                            Tracking Number
                        </span>

                        <span class="info-value">
                            <?php
                            echo htmlspecialchars(
                                $trackingNumber
                            );
                            ?>
                        </span>

                    </div>

                <?php } ?>


                <?php if ($estimatedDelivery !== '') { ?>

                    <div class="info-item mt-3">

                        <span class="info-label">
                            Estimated Delivery
                        </span>

                        <span class="info-value">

                            <?php
                            echo date(
                                "d M Y",
                                strtotime(
                                    $estimatedDelivery
                                )
                            );
                            ?>

                        </span>

                    </div>

                <?php } ?>

            </div>


            <!-- PAYMENT METHOD -->
            <div class="premium-card mt-4">

                <div class="card-heading">

                    <h3>
                        <i class="fas fa-credit-card me-2"></i>
                        Payment
                    </h3>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Method
                    </span>

                    <span class="info-value">
                        <?php
                        echo htmlspecialchars(
                            $paymentMethod
                        );
                        ?>
                    </span>

                </div>


                <div class="info-item mt-3">

                    <span class="info-label">
                        Status
                    </span>

                    <span class="info-value">

                        <?php
                        echo htmlspecialchars(
                            $paymentStatus
                        );
                        ?>

                    </span>

                </div>

            </div>


        </div>


    </div>

</div>


<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>