
<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("connect.php");
global $conn;
/* ==============================
   STYLISH ERROR PAGE
================================ */
function showError(string $message): void
{
    exit('
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="weblogo.png">

        <title>Order Error | Aroma Haven</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #f5ebe0, #d6b89c);
            }

            .error-box {
                width: 100%;
                max-width: 520px;
                background: #fff;
                padding: 50px 35px;
                text-align: center;
                border-radius: 20px;
                box-shadow: 0 15px 45px rgba(70, 40, 20, 0.18);
            }

            .logo {
                color: #6f4e37;
                font-size: 14px;
                font-weight: bold;
                letter-spacing: 2px;
                text-transform: uppercase;
                margin-bottom: 25px;
            }

            .icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 25px;
                border-radius: 50%;
                background: #fde8e8;
                color: #c0392b;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 42px;
                font-weight: bold;
            }

            h2 {
                color: #3e2723;
                margin-bottom: 15px;
            }

            p {
                color: #666;
                line-height: 1.7;
                margin-bottom: 30px;
            }

            .back-btn {
                display: inline-block;
                background: #6f4e37;
                color: white;
                text-decoration: none;
                padding: 13px 30px;
                border-radius: 8px;
            }

            .back-btn:hover {
                background: #4e342e;
            }
        </style>
    </head>

    <body>

        <div class="error-box">

            <div class="logo">Aroma Haven</div>

            <div class="icon">!</div>

            <h2>Oops! Something went wrong</h2>

            <p>' . htmlspecialchars($message) . '</p>

            <a href="javascript:history.back()" class="back-btn">
                Go Back
            </a>

        </div>

    </body>
    </html>
    ');
}


/* ==============================
   CHECK LOGIN
================================ */
if (!isset($_SESSION['user_email'])) {
    header("Location: register.php");
    exit();
}

$email = mysqli_real_escape_string(
    $conn,
    $_SESSION['user_email']
);


/* ==============================
   GET USER
================================ */
$user_query = mysqli_query(
    $conn,
    "SELECT * FROM clients WHERE email='$email' LIMIT 1"
);

if (!$user_query || mysqli_num_rows($user_query) === 0) {
    showError("User not found. Please log in again.");
}

$user = mysqli_fetch_assoc($user_query);
$user_id = (int)$user['id'];


/* ==============================
   CHECK CHECKOUT ITEMS
================================ */
if (
    empty($_SESSION['checkout_items']) ||
    !is_array($_SESSION['checkout_items'])
) {
    showError("No items found in checkout.");
}


/* ==============================
   GET FORM DATA
================================ */
$name = mysqli_real_escape_string(
    $conn,
    trim($_POST['customer_name'] ?? '')
);

$phone = mysqli_real_escape_string(
    $conn,
    trim($_POST['phone'] ?? '')
);

$customer_email = mysqli_real_escape_string(
    $conn,
    trim($_POST['email'] ?? '')
);

$address = mysqli_real_escape_string(
    $conn,
    trim($_POST['address'] ?? '')
);


/* ==============================
   VALIDATE FORM
================================ */
if (
    $name === '' ||
    $phone === '' ||
    $customer_email === '' ||
    $address === ''
) {
    showError("Please fill in all delivery details.");
}


/* ==============================
   PAYMENT METHOD
================================ */
$payment_method = $_POST['payment_method'] ?? 'COD';

$allowed_methods = [
    'COD',
    'RAZORPAY'
];

if (!in_array($payment_method, $allowed_methods, true)) {
    $payment_method = 'COD';
}

$payment_method = mysqli_real_escape_string(
    $conn,
    $payment_method
);


/* ==============================
   GENERATE ORDER NUMBER
================================ */
$order_number = "ORD" . time() . rand(1000, 9999);


/* ==============================
   CHECK STOCK
   CALCULATE TOTAL
================================ */
$grand_total = 0;
$validated_items = [];

foreach ($_SESSION['checkout_items'] as $item) {

    $product_id = (int)($item['product_id'] ?? 0);
    $qty = (int)($item['quantity'] ?? 0);

    if ($product_id <= 0 || $qty <= 0) {
        showError("Invalid product or quantity.");
    }

    $product_query = mysqli_query(
        $conn,
        "SELECT * FROM products
         WHERE id='$product_id'
         AND status=1
         LIMIT 1"
    );

    if (!$product_query) {
        showError("Unable to verify product information.");
    }

    $product = mysqli_fetch_assoc($product_query);

    if (!$product) {
        showError("A product in your checkout is no longer available.");
    }

    /* OUT OF STOCK */
    if ((int)$product['stock'] <= 0) {
        showError(
            "Sorry! " . $product['name'] .
                " is currently out of stock and cannot be ordered at the moment."
        );
    }

    /* NOT ENOUGH STOCK */
    if ($qty > (int)$product['stock']) {
        showError(
            "Sorry! Only " .
                $product['stock'] .
                " item(s) of " .
                $product['name'] .
                " are currently available."
        );
    }

    $price = (float)$product['price'];
    $total = $price * $qty;

    $grand_total += $total;

    $validated_items[] = [
        'product' => $product,
        'product_id' => $product_id,
        'qty' => $qty,
        'price' => $price,
        'total' => $total
    ];
}


/* ==============================
   START TRANSACTION
================================ */
mysqli_begin_transaction($conn);

try {

    foreach ($validated_items as $item) {

        $product = $item['product'];
        $product_id = $item['product_id'];
        $qty = $item['qty'];
        $price = $item['price'];
        $total = $item['total'];

        $product_name = mysqli_real_escape_string(
            $conn,
            $product['name']
        );

        $product_image = mysqli_real_escape_string(
            $conn,
            $product['image']
        );


        /* INSERT ORDER */
        $insert = mysqli_query(
            $conn,
            "INSERT INTO userorder
            (
                order_number,
                customer_id,
                customer_name,
                product_id,
                product_name,
                product_image,
                quantity,
                item_price,
                total_amount,
                grand_total,
                customer_number,
                shipping_address,
                payment_method,
                payment_status,
                order_status
            )
            VALUES
            (
                '$order_number',
                '$user_id',
                '$name',
                '$product_id',
                '$product_name',
                '$product_image',
                '$qty',
                '$price',
                '$total',
                '$grand_total',
                '$phone',
                '$address',
                '$payment_method',
                'Pending',
                'Processing'
            )"
        );

        if (!$insert) {
            throw new Exception(
                "Unable to place your order. Please try again."
            );
        }


        /* UPDATE STOCK */
        $update_stock = mysqli_query(
            $conn,
            "UPDATE products
             SET stock = stock - $qty
             WHERE id = $product_id
             AND stock >= $qty"
        );

        if (
            !$update_stock ||
            mysqli_affected_rows($conn) === 0
        ) {
            throw new Exception(
                "Sorry! " . $product['name'] .
                    " is no longer available in the requested quantity."
            );
        }
    }


    /* SAVE ALL CHANGES */
    mysqli_commit($conn);


    /* CLEAR CHECKOUT */
    unset($_SESSION['checkout_items']);


    /* REDIRECT */
    header(
        "Location: order_success.php?order_no=" .
            urlencode($order_number)
    );

    exit();
} catch (Exception $e) {

    mysqli_rollback($conn);

    showError($e->getMessage());
}
?>

