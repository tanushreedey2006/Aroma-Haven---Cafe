

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
    <link rel="icon" type="image/png" href="weblogo.png">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<?php
session_start();
include("connect.php");
/** @var mysqli $conn */

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user_email'])){
    header("location:register.php");
    exit();
}

$email = $_SESSION['user_email'];

$userQuery = mysqli_query($conn,
"SELECT * FROM clients WHERE email='$email'"
);

$user = mysqli_fetch_assoc($userQuery);

if(!$user){
    die("User not found");
}

$user_id = $user['id'];

$source = $_GET['source'] ?? '';
$id     = $_GET['id'] ?? 0;

$product_id = 0;
$qty = 1;

/* STEP CONTROL */
$current_step = 1;

/* WISHLIST */
if($source == "wishlist"){

    $current_step = 2;

    $q = mysqli_query($conn,
    "SELECT * FROM wishlist
     WHERE wishlist_id='$id'
     AND user_id='$user_id'"
    );

    $item = mysqli_fetch_assoc($q);
    $product_id = $item['product_id'];
}

/* CART */
elseif($source == "cart"){

    $current_step = 2;

    $q = mysqli_query($conn,
    "SELECT * FROM addtocart
     WHERE id='$id'
     AND user_id='$user_id'"
    );

    $item = mysqli_fetch_assoc($q);

    $product_id = $item['product_id'];
    $qty = $item['quantity'];
}


elseif($source == "session"){

    $current_step = 2;

    if(!empty($_SESSION['checkout_items'])){

        $firstItem = $_SESSION['checkout_items'][0];

        $product_id = $firstItem['product_id'];
        $qty = $firstItem['quantity'];

    }else{

        header("Location: catalogue.php");
        exit();
    }
}
/* DIRECT PRODUCT */
elseif($source == "product"){

    $current_step = 2;
    $product_id = $id;
}
else{

    if(isset($_SESSION['checkout_items']) &&
       count($_SESSION['checkout_items']) > 0){

        $current_step = 2;

        $firstItem = $_SESSION['checkout_items'][0];

        $product_id = $firstItem['product_id'];
        $qty = $firstItem['quantity'];

    }else{

        die("Invalid source");
    }
}

/* PRODUCT */
$pq = mysqli_query($conn,
"SELECT * FROM products WHERE id='$product_id'"
);

$product = mysqli_fetch_assoc($pq);

if(!$product){
    die("Product Not Found");
}





/* =========================
   CHECKOUT SESSION SYSTEM
========================= */

if(!isset($_SESSION['checkout_items'])){
    $_SESSION['checkout_items'] = [];
}

/* first item add only once */
$exists = false;

foreach($_SESSION['checkout_items'] as $item){

    if($item['product_id'] == $product_id){

        $exists = true;
        break;
    }
}

if(!$exists){

    $_SESSION['checkout_items'][] = [

        'product_id' => $product['id'],
        'name'       => $product['name'],
        'image'      => $product['image'],
        'price'      => $product['price'],
        'quantity'   => $qty

    ];
}




$delivery_charge = 50;

$subtotal = 0;

foreach($_SESSION['checkout_items'] as $item){

    $subtotal +=
        $item['price'] *
        $item['quantity'];
}

$total = $subtotal + $delivery_charge;
?>
<style>

/* ---------- BASE ---------- */
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:linear-gradient(135deg,#fff8f2,#f5ece6);
padding:40px;
  font-family: 'Poppins', sans-serif;
}

/* soft animation background */
body::before {
    content: "";
    position: fixed;
    width: 300px;
    height: 300px;
    background: #a65935;
    filter: blur(150px);
    opacity: 0.15;
    top: -100px;
    left: -100px;
    z-index: -1;
}

/* ---------- LAYOUT ---------- */
.checkout-container{
max-width:1400px;
margin:auto;
display:grid;
grid-template-columns:2fr 1fr;
gap:35px;
}

@media(max-width:900px){
.checkout-container{grid-template-columns:1fr;}
}

/* ---------- CARD ---------- */
.checkout-card{
background:white;
padding:35px;
border-radius:30px;
box-shadow:0 20px 50px rgba(0,0,0,0.08);
}

.title{
font-size:35px;
font-weight:800;
color:#58260f;
margin-bottom:25px;
}

/* ---------- INPUT ---------- */
.input-group{margin-bottom:20px;}
.input-group label{display:block;margin-bottom:8px;font-weight:600;}
.input-group input{
width:100%;
padding:15px;
border-radius:15px;
border:1px solid #ddd;
}

/* ---------- STEPS ---------- */
.checkout-steps{
display:flex;
justify-content:space-between;
position:relative;
margin-bottom:35px;
}

.checkout-steps::before{
content:'';
position:absolute;
top:22px;
width:100%;
height:4px;
background:#ddd;
z-index:0;
}

.checkout-card,
.summary-card {
    transition: 0.3s ease;
}

.checkout-card:hover,
.summary-card:hover {
    transform: translateY(-5px);
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    border-radius: 12px;
    transition: 0.3s;
}

.payment-option:hover {
    background: #fff3ea;
    border-color: #58260f;
}


.progress-line{
position:absolute;
top:22px;
left:0;
height:4px;
background:linear-gradient(90deg,#58260f,#c17530);
transition:.6s;
z-index:1;
border-radius:10px;
}

.step{
text-align:center;
flex:1;
z-index:2;

transition: transform 0.3s ease;

}

.step-circle{
width:45px;
height:45px;
border-radius:50%;
background:#ddd;
display:flex;
align-items:center;
justify-content:center;
margin:auto;
transition:.4s;
}

.step-label{margin-top:10px;font-size:14px;}

.step.active .step-circle{
background:#58260f;
color:white;
animation:pulse 1s infinite;
}

.step.completed .step-circle{
background:#198754;
color:white;
}

/* animations */
@keyframes pulse{
0%{box-shadow:0 0 0 0 rgba(88,38,15,0.5);}
70%{box-shadow:0 0 0 12px rgba(88,38,15,0);}
100%{box-shadow:0 0 0 0 rgba(88,38,15,0);}
}

/* ---------- BUTTON ---------- */
.place-btn{
width:100%;
padding:20px;
border:none;
border-radius:15px;
background:linear-gradient(135deg,#58260f,#a65935);
color:white;
font-size:18px;
cursor:pointer;
   position: relative;
    overflow: hidden;
}

.place-btn::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: -100%;
    background: rgba(255,255,255,0.2);
    transition: 0.5s;
}

.place-btn:hover::after {
    left: 100%;
}
.place-btn:hover{
transform:translateY(-3px);
}

/* ---------- SUMMARY ---------- */
.summary-card{
background:white;
padding:25px;
border-radius:25px;
position:sticky;
top:20px;
}

/* .product-img{
width:100%;
height:250px;
object-fit:cover;
border-radius:20px;
} */

.product-image-box{
    height:350px;
    padding:5px;
    border-radius:20px;
    overflow:hidden;
}

.product-img{
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center;
    
}
.product-img:hover{
    transform:scale(1.05);
}
.summary-row{
display:flex;
justify-content:space-between;
margin-top:15px;
}

.total{
font-size:22px;
font-weight:bold;
margin-top:20px;
}

.shipping-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.full-width{
    grid-column:1/-1;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    color:#58260f;
    font-weight:600;
}

.input-group label i{
    margin-right:8px;
    color:#a65935;
}

.input-group input{
    width:100%;
    padding:16px;
    border:2px solid #ead8cb;
    border-radius:16px;
    background:#fffaf6;
    transition:.3s;
}

.input-group input:focus{
    outline:none;
    border-color:#a65935;
    box-shadow:0 0 20px rgba(166,89,53,.15);
}

.coffee-info-box{
    background:#fff3e8;
    border-left:5px solid #a65935;
    padding:16px;
    border-radius:15px;
    margin-bottom:25px;
    color:#6a3a1b;
}

.coffee-delivery-note{
    background:#f6f0ea;
    padding:15px;
    border-radius:15px;
    margin:25px 0;
    color:#6a3a1b;
    font-weight:600;
}

.payment-title{
    margin-bottom:15px;
    color:#58260f;
}

.payment-options{
    display:flex;
    flex-direction:column;
    gap:15px;
}

.payment-card{
    cursor:pointer;
}

.payment-card input{
    display:none;
}

.payment-content{
    display:flex;
    align-items:center;
    gap:15px;
    padding:18px;
    border:2px solid #ead8cb;
    border-radius:18px;
    background:#fff;
    transition:.3s;
}

.payment-content i{
    font-size:28px;
    color:#a65935;
}

.payment-card input:checked + .payment-content{
    border-color:#a65935;
    background:#fff6ef;
    box-shadow:0 10px 25px rgba(166,89,53,.15);
}

.payment-content h4{
    margin:0;
    color:#58260f;
}

.payment-content p{
    margin:4px 0 0;
    color:#777;
    font-size:13px;
}

@media(max-width:768px){
    .shipping-grid{
        grid-template-columns:1fr;
    }

    .full-width{
        grid-column:auto;
    }
}
.add-more-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    text-decoration:none;
    background:#fff3ea;
    color:#58260f;
    padding:15px;
    border-radius:15px;
    border:2px solid #ead8cb;
    margin-top:20px;
    margin-bottom:20px;
    font-weight:600;
    transition:.3s;
}

.add-more-btn:hover{
    background:#58260f;
    color:white;
}
.cart-info{
    background:#fff3ea;
    padding:12px;
    border-radius:12px;
    text-align:center;
    margin-bottom:15px;
    font-weight:700;
    color:#58260f;
}
.mini-product{
    display:flex;
    align-items:center;
    gap:12px;
    margin-top:15px;
    padding:10px;
    border-radius:12px;
    background:#fafafa;
}

.mini-product-img{
    width:60px;
    height:60px;
    object-fit:cover;
    border-radius:10px;
}
.checkout-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.checkout-item-img{
    width:65px;
    height:65px;
    object-fit:cover;
    border-radius:12px;
}

.checkout-item-info{
    flex:1;
}

.checkout-item-info h4{
    margin:0;
    font-size:15px;
    color:#58260f;
}

.checkout-item-info p{
    margin-top:4px;
    color:#666;
    font-size:13px;
}

.checkout-item-price{
    font-weight:700;
    color:#58260f;
}

.checkout-product{
    display:flex;
    gap:15px;
    margin-bottom:20px;
    padding-bottom:15px;
    border-bottom:1px solid #eee;
}

.summary-product-img{
    width:90px;
    height:90px;
    object-fit:cover;
    border-radius:12px;
}

.product-info h4{
    margin-bottom:5px;
    color:#58260f;
}

.product-info p{
    margin:2px 0;
}

.add-more-btn{
    display:block;
    text-align:center;
    margin:20px 0;
    padding:12px;
    border-radius:12px;
    text-decoration:none;
    background:#f5ece6;
    color:#58260f;
    font-weight:600;
}

.checkout-product{
    display:flex;
    align-items:center;
    gap:15px;
    position:relative;
}

.remove-item-btn{
    margin-left:auto;
    width:35px;
    height:35px;
    border-radius:50%;
    background:#ffefef;
    color:#dc3545;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    transition:.3s;
}

.remove-item-btn:hover{
    background:#dc3545;
    color:#fff;
    transform:rotate(90deg);
}
</style>
</head>

<body>

<form id="checkoutForm" action="place_order.php" method="POST">

<input type="hidden" name="source" value="<?php echo $source; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
<input type="hidden" name="quantity" value="<?php echo $qty; ?>">
<input type="hidden" name="total_amount" id="totalAmount" value="<?php echo $total; ?>">

<!-- STEPS -->
<div class="checkout-steps">

<div class="progress-line"
style="width:<?php echo (($current_step-1)/3)*100; ?>%;"></div>

<?php
$steps = ["Cart","Checkout","Payment","Complete"];
for($i=1;$i<=4;$i++){
?>
<div class="step <?php echo $current_step>=$i?'active':''; ?>">
<div class="step-circle"><?php echo $i; ?></div>
<div class="step-label"><?php echo $steps[$i-1]; ?></div>
</div>
<?php } ?>

</div>

<div class="checkout-container">

<!-- LEFT -->
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
        <input type="text"
               name="customer_name"
               value="<?php echo $user['name']; ?>"
               required>
    </div>

    <div class="input-group">
        <label>
            <i class="fa-solid fa-phone"></i>
            Mobile Number
        </label>
        <input type="text"
               name="phone"
               value="<?php echo $user['mobile']; ?>"
               required>
    </div>

    <div class="input-group full-width">
        <label>
            <i class="fa-solid fa-envelope"></i>
            Email Address
        </label>
        <input type="email"
               name="email"
               value="<?php echo $email; ?>"
               required>
    </div>

    <div class="input-group full-width">
        <label>
            <i class="fa-solid fa-location-dot"></i>
            Delivery Address
        </label>
        <input type="text"
               name="address"
               value="<?php echo $user['address']; ?>"
               required>
    </div>

</div>

<div class="coffee-delivery-note">
    <i class="fa-solid fa-truck-fast"></i>
    Estimated Delivery: 2-4 Days
</div>

<h3 class="payment-title">
    <i class="fa-solid fa-wallet"></i>
    Choose Payment Method
</h3>

<div class="payment-options">

    <label class="payment-card">
        <input type="radio"
               name="payment_method"
               value="COD"
               checked>

        <div class="payment-content">
            <i class="fa-solid fa-money-bill-wave"></i>
            <div>
                <h4>Cash On Delivery</h4>
                <p>Pay when your coffee arrives</p>
            </div>
        </div>
    </label>

    <label class="payment-card">
        <input type="radio"
               name="payment_method"
               value="RAZORPAY">


               
<label><input type="radio" name="payment_method" value="RAZORPAY"> Online Payment</label>

        <div class="payment-content">
            <i class="fa-solid fa-credit-card"></i>
            <div>
                <h4>Online Payment</h4>
                <p>UPI, Card, Net Banking & Wallets</p>
            </div>
        </div>
    </label>

</div>

</div>

<!-- RIGHT -->
<!-- RIGHT -->
<div class="summary-card">

<h2 style="margin-bottom:20px;">
    Order Summary
</h2>

<?php

if(isset($_SESSION['checkout_items'])){

    $grand_total = 0;

    foreach($_SESSION['checkout_items'] as $item){

        $line_total =
            $item['price'] *
            $item['quantity'];

        $grand_total += $line_total;
?>

<div class="checkout-product">

    <img src="images/<?php echo $item['image']; ?>"
         class="summary-product-img">

    <div class="product-info">

        <h4>
            <?php echo $item['name']; ?>
        </h4>

        <p>
            Qty :
            <?php echo $item['quantity']; ?>
        </p>

        <p>
            ₹<?php echo $line_total; ?>
        </p>

    </div>

    <a href="remove_checkout_item.php?id=<?php echo $item['product_id']; ?>"
       class="remove-item-btn"
       onclick="return confirm('Remove this item from order?')">

        <i class="fa-solid fa-xmark"></i>

    </a>

</div>

<?php
    }
?>

<a href="catalogue.php"
class="add-more-btn">

<i class="fa-solid fa-plus"></i>
Add More Items

</a>

<hr>

<div class="summary-row total">
    <span>Subtotal</span>
    <span>₹<?php echo $grand_total; ?></span>
</div>

<input
type="hidden"
name="total_amount"
id="totalAmount"
value="<?php echo $grand_total; ?>">

<?php
}
?>

<button type="submit"
class="place-btn">

Place Order

</button>

</div>

</div>

</form>

<script>

window.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("checkoutForm");
    if (!form) return;

    // =========================
    // STEP ANIMATION (premium)
    // =========================
    const steps = document.querySelectorAll(".step");

    steps.forEach((step, i) => {
        setTimeout(() => {
            step.style.transform = "translateY(-6px)";
            step.style.opacity = "1";

            setTimeout(() => {
                step.style.transform = "translateY(0px)";
            }, 200);

        }, i * 120);
    });

    // =========================
    // FORM SUBMIT CONTROL
    // =========================
    form.addEventListener("submit", function (e) {

        const selected = document.querySelector('input[name="payment_method"]:checked');

        if (!selected) {
            e.preventDefault();
            alert("Please select payment method");
            return;
        }

        // COD → normal submit
        if (selected.value === "COD") {
            return true;
        }

        // Razorpay → stop submit
        if (selected.value === "RAZORPAY") {
            e.preventDefault();
            startRazorpay();
        }
    });
});


// =========================
// RAZORPAY FLOW (PRO)
// =========================
function startRazorpay() {

    const btn = document.querySelector(".place-btn");
    btn.innerHTML = "Processing Payment...";
    btn.disabled = true;

    let amount = document.getElementById("totalAmount").value;

    fetch("create_order.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "amount=" + amount
    })
    .then(res => res.text())
    .then(text => {

        console.log("RAW RESPONSE:", text);

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            alert("Server error in create_order.php");
            btn.innerHTML = "Place Order";
            btn.disabled = false;
            return;
        }

        const options = {
            key: data.key,
            amount: data.amount,
            currency: "INR",
            order_id: data.order_id,

            name: "Your Coffee Shop",
            description: "Secure Payment",

            theme: {
                color: "#58260f"
            },

            handler: function (response) {

                btn.innerHTML = "Verifying Payment...";

                fetch("verify_payment.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body:
                        "razorpay_payment_id=" + response.razorpay_payment_id +
                        "&razorpay_order_id=" + response.razorpay_order_id +
                        "&razorpay_signature=" + response.razorpay_signature +
                        "&amount=" + amount
                })
                .then(res => res.text())
                .then(res => {

                    console.log("VERIFY:", res);

                    if (res.trim() === "success") {
                        btn.innerHTML = "Success!";
                        window.location = "order_success.php";
                    } else {
                        alert("Payment verification failed");
                        btn.innerHTML = "Place Order";
                        btn.disabled = false;
                    }

                });
            },

            modal: {
                ondismiss: function () {
                    btn.innerHTML = "Place Order";
                    btn.disabled = false;
                }
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();

        btn.innerHTML = "Place Order";
        btn.disabled = false;
    })
    .catch(err => {
        console.error(err);
        alert("Payment error");
        btn.innerHTML = "Place Order";
        btn.disabled = false;
    });
}
</script>

</body>
</html>