<?php

session_start();

include("connect.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

global $conn;


/* =====================================
   CHECK LOGIN
===================================== */

if (!isset($_SESSION['user_email'])) {

    header("Location: register.php");
    exit();

}


/* =====================================
   GET LOGGED-IN USER
===================================== */

$email = mysqli_real_escape_string(
    $conn,
    $_SESSION['user_email']
);


$userQuery = mysqli_query(
    $conn,
    "SELECT *
     FROM clients
     WHERE email='$email'
     LIMIT 1"
);


$user = mysqli_fetch_assoc($userQuery);


if (!$user) {

    die("User not found");

}


$user_id = (int)$user['id'];


/* =====================================
   CHECKOUT SESSION
===================================== */

if (
    !isset($_SESSION['checkout_items']) ||
    !is_array($_SESSION['checkout_items']) ||
    empty($_SESSION['checkout_items'])
) {

    header("Location: catalogue.php");
    exit();

}


/* =====================================
   VALIDATE CHECKOUT PRODUCTS
===================================== */

$valid_items = [];


foreach (
    $_SESSION['checkout_items']
    as $checkoutItem
) {

    $product_id = (int)(
        $checkoutItem['product_id'] ?? 0
    );


    $quantity = max(
        1,
        (int)(
            $checkoutItem['quantity'] ?? 1
        )
    );


    if ($product_id <= 0) {
        continue;
    }


    /* Get latest product information */

    $productQuery = mysqli_query(
        $conn,
        "SELECT *
         FROM products
         WHERE id='$product_id'
         LIMIT 1"
    );


    $product = mysqli_fetch_assoc(
        $productQuery
    );


    if ($product) {

        $valid_items[] = [

            'product_id' =>
                (int)$product['id'],

            'name' =>
                $product['name'],

            'image' =>
                $product['image'],

            'price' =>
                (float)$product['price'],

            'quantity' =>
                $quantity
        ];

    }

}


/* =====================================
   UPDATE CHECKOUT SESSION
===================================== */

$_SESSION['checkout_items'] = $valid_items;


/* =====================================
   CHECK EMPTY CHECKOUT
===================================== */

if (
    empty($_SESSION['checkout_items'])
) {

    header("Location: catalogue.php");
    exit();

}


/* =====================================
   CURRENT CHECKOUT STEP
===================================== */

$current_step = 2;


/* =====================================
   CALCULATE SUBTOTAL
===================================== */

$subtotal = 0;


foreach (
    $_SESSION['checkout_items']
    as $checkoutItem
) {

    $price = (float)(
        $checkoutItem['price'] ?? 0
    );


    $quantity = (int)(
        $checkoutItem['quantity'] ?? 1
    );


    $subtotal +=
        $price * $quantity;

}


/* =====================================
   DELIVERY CHARGE
===================================== */

$delivery_charge = 0;


/* =====================================
   FINAL TOTAL
===================================== */

$total =
    $subtotal +
    $delivery_charge;

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Checkout | Aroma Haven</title>

<link
    rel="icon"
    type="image/png"
    href="weblogo.png"
>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<style>

/* =========================
   BASE
========================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


body {

    background:
        linear-gradient(
            135deg,
            #fff8f2,
            #f5ece6
        );

    padding: 40px;

    font-family:
        Arial,
        sans-serif;

}


/* =========================
   STEPS
========================= */

.checkout-steps {

    display: flex;

    justify-content: space-between;

    position: relative;

    max-width: 1400px;

    margin:
        0 auto
        35px;

}


.checkout-steps::before {

    content: "";

    position: absolute;

    top: 22px;

    width: 100%;

    height: 4px;

    background: #ddd;

    z-index: 0;

}


.progress-line {

    position: absolute;

    top: 22px;

    left: 0;

    width: 33.33%;

    height: 4px;

    background:
        linear-gradient(
            90deg,
            #58260f,
            #c17530
        );

    z-index: 1;

}


.step {

    text-align: center;

    flex: 1;

    z-index: 2;

}


.step-circle {

    width: 45px;

    height: 45px;

    border-radius: 50%;

    background: #ddd;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: auto;

}


.step.active .step-circle {

    background: #58260f;

    color: white;

}


.step-label {

    margin-top: 10px;

    font-size: 14px;

}


/* =========================
   MAIN LAYOUT
========================= */

.checkout-container {

    max-width: 1400px;

    margin: auto;

    display: grid;

    grid-template-columns:
        2fr 1fr;

    gap: 35px;

}


.checkout-card,
.summary-card {

    background: white;

    border-radius: 25px;

    box-shadow:
        0 20px 50px
        rgba(0,0,0,.08);

}


/* =========================
   LEFT CARD
========================= */

.checkout-card {

    padding: 35px;

}


.title {

    font-size: 32px;

    color: #58260f;

    margin-bottom: 25px;

}


.coffee-info-box {

    background: #fff3e8;

    border-left:
        5px solid #a65935;

    padding: 16px;

    border-radius: 12px;

    margin-bottom: 25px;

}


.shipping-grid {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 20px;

}


.full-width {

    grid-column: 1 / -1;

}


.input-group {

    margin-bottom: 10px;

}


.input-group label {

    display: block;

    margin-bottom: 8px;

    color: #58260f;

    font-weight: bold;

}


.input-group input {

    width: 100%;

    padding: 15px;

    border:
        2px solid #ead8cb;

    border-radius: 14px;

    outline: none;

}


.input-group input:focus {

    border-color: #a65935;

}


/* =========================
   PAYMENT
========================= */

.payment-title {

    margin:
        25px 0 15px;

    color: #58260f;

}


.payment-options {

    display: flex;

    flex-direction: column;

    gap: 15px;

}


.payment-card {

    cursor: pointer;

}


.payment-card input {

    display: none;

}


.payment-content {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 18px;

    border:
        2px solid #ead8cb;

    border-radius: 18px;

}


.payment-content i {

    font-size: 25px;

    color: #a65935;

}


.payment-card
input:checked
+ .payment-content {

    border-color: #a65935;

    background: #fff6ef;

}


/* =========================
   SUMMARY
========================= */

.summary-card {

    padding: 25px;

    height: fit-content;

    position: sticky;

    top: 20px;

}


.checkout-product {

    display: flex;

    align-items: center;

    gap: 15px;

    padding:
        15px 0;

    border-bottom:
        1px solid #eee;

}


.summary-product-img {

    width: 75px;

    height: 75px;

    object-fit: cover;

    border-radius: 12px;

}


.product-info {

    flex: 1;

}


.product-info h4 {

    color: #58260f;

    margin-bottom: 5px;

}


.product-info p {

    color: #666;

    margin: 3px 0;

}


.remove-item-btn {

    width: 35px;

    height: 35px;

    border-radius: 50%;

    background: #ffefef;

    color: #dc3545;

    display: flex;

    align-items: center;

    justify-content: center;

    text-decoration: none;

}


.add-more-btn {

    display: block;

    text-align: center;

    margin: 20px 0;

    padding: 13px;

    border-radius: 12px;

    text-decoration: none;

    background: #f5ece6;

    color: #58260f;

    font-weight: bold;

}


.summary-row {

    display: flex;

    justify-content: space-between;

    margin-top: 15px;

}


.total {

    font-size: 22px;

    font-weight: bold;

}


.place-btn {

    width: 100%;

    margin-top: 25px;

    padding: 18px;

    border: none;

    border-radius: 14px;

    background:
        linear-gradient(
            135deg,
            #58260f,
            #a65935
        );

    color: white;

    font-size: 17px;

    cursor: pointer;

}


/* =========================
   CUSTOM ALERT
========================= */

.custom-alert-overlay {

    position: fixed;

    inset: 0;

    background:
        rgba(40,20,10,.45);

    display: none;

    align-items: center;

    justify-content: center;

    padding: 20px;

    z-index: 9999;

    backdrop-filter:
        blur(5px);

}


.custom-alert-overlay.show {

    display: flex;

}


.custom-alert-card {

    width: 100%;

    max-width: 420px;

    background: white;

    padding: 35px;

    border-radius: 25px;

    text-align: center;

}


.custom-alert-icon {

    width: 70px;

    height: 70px;

    margin:
        0 auto
        20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #fff0ee;

    color: #dc3545;

    font-size: 32px;

}


.custom-alert-card h3 {

    color: #58260f;

    margin-bottom: 12px;

}


.custom-alert-card p {

    color: #777;

    margin-bottom: 25px;

}


.custom-alert-btn {

    width: 100%;

    padding: 14px;

    border: none;

    border-radius: 12px;

    background: #58260f;

    color: white;

    cursor: pointer;

}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:900px) {

    body {
        padding: 20px;
    }

    .checkout-container {
        grid-template-columns: 1fr;
    }

}


@media(max-width:600px) {

    .shipping-grid {
        grid-template-columns: 1fr;
    }

    .full-width {
        grid-column: auto;
    }

    .step-label {
        font-size: 11px;
    }

}

</style>

</head>


<body>


<form
    id="checkoutForm"
    action="place_order.php"
    method="POST"
>


<input
    type="hidden"
    name="total_amount"
    id="totalAmount"
    value="<?php echo $total; ?>"
>


<!-- =====================
     STEPS
===================== -->

<div class="checkout-steps">

    <div class="progress-line"></div>

    <?php

    $steps = [
        "Cart",
        "Checkout",
        "Payment",
        "Complete"
    ];

    for ($i = 1; $i <= 4; $i++) {

    ?>

        <div
            class="step
            <?php echo $i <= $current_step ? 'active' : ''; ?>"
        >

            <div class="step-circle">

                <?php echo $i; ?>

            </div>

            <div class="step-label">

                <?php echo $steps[$i - 1]; ?>

            </div>

        </div>

    <?php } ?>

</div>



<div class="checkout-container">


<!-- =====================
     DELIVERY DETAILS
===================== -->

<div class="checkout-card">

<h2 class="title">

    <i class="fa-solid fa-mug-hot"></i>

    Brewing Delivery Details

</h2>


<div class="coffee-info-box">

    <i class="fa-solid fa-seedling"></i>

    Freshly roasted coffee delivered safely to your doorstep.

</div>


<div class="shipping-grid">


<div class="input-group">

<label>

    <i class="fa-solid fa-user"></i>

    Full Name

</label>

<input
    type="text"
    name="customer_name"
    value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
    required
>

</div>



<div class="input-group">

<label>

    <i class="fa-solid fa-phone"></i>

    Mobile Number

</label>

<input
    type="text"
    name="phone"
    value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>"
    required
>

</div>



<div class="input-group full-width">

<label>

    <i class="fa-solid fa-envelope"></i>

    Email Address

</label>

<input
    type="email"
    name="email"
    value="<?php echo htmlspecialchars($email); ?>"
    required
>

</div>



<div class="input-group full-width">

<label>

    <i class="fa-solid fa-location-dot"></i>

    Delivery Address

</label>

<input
    type="text"
    name="address"
    value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"
    required
>

</div>


</div>


<h3 class="payment-title">

    <i class="fa-solid fa-wallet"></i>

    Choose Payment Method

</h3>


<div class="payment-options">


<label class="payment-card">

<input
    type="radio"
    name="payment_method"
    value="COD"
    checked
>

<div class="payment-content">

    <i class="fa-solid fa-money-bill-wave"></i>

    <div>

        <h4>Cash On Delivery</h4>

        <p>
            Pay when your coffee arrives
        </p>

    </div>

</div>

</label>



<label class="payment-card">

<input
    type="radio"
    name="payment_method"
    value="RAZORPAY"
>

<div class="payment-content">

    <i class="fa-solid fa-credit-card"></i>

    <div>

        <h4>Online Payment</h4>

        <p>
            UPI, Card, Net Banking & Wallets
        </p>

    </div>

</div>

</label>


</div>


</div>



<!-- =====================
     ORDER SUMMARY
===================== -->

<div class="summary-card">

<h2>

    Order Summary

</h2>


<?php foreach ($_SESSION['checkout_items'] as $item): ?>

<?php

$line_total =
    (float)$item['price']
    *
    (int)$item['quantity'];

?>


<div class="checkout-product">


<img
    src="images/<?php echo htmlspecialchars($item['image']); ?>"
    class="summary-product-img"
>


<div class="product-info">

<h4>

    <?php
    echo htmlspecialchars($item['name']);
    ?>

</h4>


<p>

    Qty:
    <?php echo (int)$item['quantity']; ?>

</p>


<p>

    ₹<?php echo number_format($line_total, 2); ?>

</p>

</div>


<a
    href="remove_checkout_item.php?id=<?php echo (int)$item['product_id']; ?>"
    class="remove-item-btn"
    title="Remove Item"
>

    <i class="fa-solid fa-xmark"></i>

</a>


</div>


<?php endforeach; ?>


<a
    href="catalogue.php"
    class="add-more-btn"
>

    <i class="fa-solid fa-plus"></i>

    Add More Items

</a>


<hr>


<div class="summary-row">

<span>

    Subtotal

</span>

<span>

    ₹<?php echo number_format($subtotal, 2); ?>

</span>

</div>


<?php if ($delivery_charge > 0): ?>

<div class="summary-row">

<span>

    Delivery

</span>

<span>

    ₹<?php echo number_format($delivery_charge, 2); ?>

</span>

</div>

<?php endif; ?>


<div class="summary-row total">

<span>

    Total

</span>

<span>

    ₹<?php echo number_format($total, 2); ?>

</span>

</div>


<button
    type="submit"
    class="place-btn"
>

    Place Order

</button>


</div>

</div>

</form>



<!-- =====================
     CUSTOM ALERT
===================== -->

<div
    id="customAlert"
    class="custom-alert-overlay"
>

<div class="custom-alert-card">


<div class="custom-alert-icon">

    <i class="fa-solid fa-circle-exclamation"></i>

</div>


<h3 id="customAlertTitle">

    Oops!

</h3>


<p id="customAlertMessage">

    Something went wrong.

</p>


<button
    type="button"
    class="custom-alert-btn"
    onclick="closeCustomAlert()"
>

    Continue

</button>


</div>

</div>



<script>


/* =========================
   CUSTOM ALERT
========================= */

function showCustomAlert(title, message) {

    document
        .getElementById("customAlertTitle")
        .innerText = title;

    document
        .getElementById("customAlertMessage")
        .innerText = message;

    document
        .getElementById("customAlert")
        .classList
        .add("show");
}


function closeCustomAlert() {

    document
        .getElementById("customAlert")
        .classList
        .remove("show");
}



/* =========================
   FORM SUBMIT
========================= */

document
    .getElementById("checkoutForm")
    .addEventListener(
        "submit",
        function(e) {

            const selected =
                document.querySelector(
                    'input[name="payment_method"]:checked'
                );


            if (!selected) {

                e.preventDefault();

                showCustomAlert(
                    "Payment Method Required",
                    "Please select a payment method."
                );

                return;
            }


            /*
             COD
            */

            if (
                selected.value === "COD"
            ) {

                return true;
            }


            /*
             RAZORPAY
            */

            if (
                selected.value === "RAZORPAY"
            ) {

                e.preventDefault();

                startRazorpay();
            }

        }
    );



/* =========================
   RAZORPAY
========================= */

function startRazorpay() {

    const btn =
        document.querySelector(".place-btn");


    btn.disabled = true;

    btn.innerHTML =
        "Processing Payment...";


    const amount =
        document.getElementById("totalAmount").value;


    fetch(
        "create_order.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/x-www-form-urlencoded"

            },

            body:
                "amount=" +
                encodeURIComponent(amount)

        }
    )

    .then(res => res.text())

    .then(text => {

        let data;


        try {

            data =
                JSON.parse(text);

        }

        catch(error) {

            showCustomAlert(
                "Server Error",
                "Unable to create payment order."
            );

            btn.disabled = false;

            btn.innerHTML =
                "Place Order";

            return;
        }


        const options = {

            key: data.key,

            amount: data.amount,

            currency: "INR",

            order_id: data.order_id,

            name: "Aroma Haven",

            description:
                "Coffee Order Payment",


            theme: {

                color: "#58260f"

            },


            handler:
            function(response) {

                verifyPayment(
                    response,
                    amount,
                    btn
                );

            },


            modal: {

                ondismiss:
                function() {

                    btn.disabled = false;

                    btn.innerHTML =
                        "Place Order";

                }

            }

        };


        const rzp =
            new Razorpay(options);


        rzp.open();

    })


    .catch(() => {

        showCustomAlert(
            "Payment Error",
            "Something went wrong. Please try again."
        );

        btn.disabled = false;

        btn.innerHTML =
            "Place Order";

    });

}



/* =========================
   VERIFY PAYMENT
========================= */

function verifyPayment(
    response,
    amount,
    btn
) {

    btn.innerHTML =
        "Verifying Payment...";


    fetch(
        "verify_payment.php",
        {

            method: "POST",

            headers: {

                "Content-Type":
                    "application/x-www-form-urlencoded"

            },


            body:

                "razorpay_payment_id=" +
                encodeURIComponent(
                    response.razorpay_payment_id
                )

                +

                "&razorpay_order_id=" +
                encodeURIComponent(
                    response.razorpay_order_id
                )

                +

                "&razorpay_signature=" +
                encodeURIComponent(
                    response.razorpay_signature
                )

                +

                "&amount=" +
                encodeURIComponent(
                    amount
                )

        }
    )

    .then(res => res.text())

    .then(result => {

        if (
            result.trim() === "success"
        ) {

            /*
             Submit actual order
            */

            document
                .getElementById("checkoutForm")
                .submit();

        }

        else {

            showCustomAlert(
                "Payment Failed",
                "Payment verification failed. Please try again."
            );

            btn.disabled = false;

            btn.innerHTML =
                "Place Order";

        }

    })

    .catch(() => {

        showCustomAlert(
            "Verification Error",
            "Unable to verify payment."
        );

        btn.disabled = false;

        btn.innerHTML =
            "Place Order";

    });

}

</script>

</body>

</html>