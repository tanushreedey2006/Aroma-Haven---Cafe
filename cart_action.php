<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();

include("connect.php");
/** @var mysqli $conn */

header("Content-Type: application/json");



/* =========================
   LOGIN CHECK
========================= */

if(!isset($_SESSION['user_id'])){

    echo json_encode([

        "cart_html" => "",

        "cart_count" => 0

    ]);

    exit();

}



$email = $_SESSION['user_email'];

$userQuery = mysqli_query($conn,

"SELECT * FROM clients
WHERE email='$email'");

$userData = mysqli_fetch_assoc($userQuery);

$user_id = $userData['id'];

$action = $_POST['action'] ?? '';





/* =========================
   ADD TO CART
========================= */

if($action == "add"){

    $product_id = $_POST['product_id'];

    $name = $_POST['name'];

    $image = $_POST['image'];

    $price = $_POST['price'];



    $check = mysqli_query($conn,

    "SELECT * FROM addtocart

    WHERE user_id='$user_id'

    AND product_id='$product_id'

    AND status='active'");



    if(mysqli_num_rows($check) == 0){

        mysqli_query($conn,

        "INSERT INTO addtocart(

        user_id,
        product_id,
        name,
        image,
        price,
        quantity,
        status

        )

        VALUES(

        '$user_id',
        '$product_id',
        '$name',
        '$image',
        '$price',
        '1',
        'active'

        )");

    }

}





/* =========================
   REMOVE FROM CART
========================= */

if($action == "remove"){

    $product_id = $_POST['product_id'];

    mysqli_query($conn,

    "DELETE FROM addtocart

    WHERE user_id='$user_id'

    AND product_id='$product_id'");

}





/* =========================
   UPDATE QUANTITY
========================= */

if($action == "plus" || $action == "minus"){

    $id = $_POST['id'];



    $getCart = mysqli_query($conn,

    "SELECT * FROM addtocart

    WHERE id='$id'");



    if(mysqli_num_rows($getCart) > 0){

        $row = mysqli_fetch_assoc($getCart);

        $qty = $row['quantity'];



        if($action == "plus"){

            $qty++;

        }

        else{

            if($qty > 1){

                $qty--;

            }

        }



        mysqli_query($conn,

        "UPDATE addtocart

        SET quantity='$qty'

        WHERE id='$id'");

    }

}





/* =========================
   LOAD CART
========================= */

$query = mysqli_query($conn,

"SELECT * FROM addtocart

WHERE user_id='$user_id'

AND status='active'

ORDER BY id ASC");



$cart_html = "";

$cart_count = 0;

$total = 0;





while($row = mysqli_fetch_assoc($query)){



    $cart_count += $row['quantity'];



    $subtotal =
    $row['price'] * $row['quantity'];



    $total += $subtotal;





    $cart_html .= '

    <div class="sidebar-item">

        <img src="images/'.$row['image'].'"

        style="
        width:80px;
        height:80px;
        object-fit:cover;
        border-radius:14px;
        ">

        <div class="sidebar-info">

            <h4>'.$row['name'].'</h4>

            <p>

            ₹'.$row['price'].'

            </p>



            <div class="qty-flex">

                <button

                class="qty-btn"

                onclick="updateQty('.$row['id'].', \'minus\')">

                -

                </button>



                <span>

                '.$row['quantity'].'

                </span>



                <button

                class="qty-btn"

                onclick="updateQty('.$row['id'].', \'plus\')">

                +

                </button>

            </div>



            <br>



            <button

            class="remove-btn"

            onclick="removeCart('.$row['product_id'].')">

            Remove

            </button>

        </div>

    </div>

    ';

}





/* =========================
   EMPTY CART
========================= */

if($cart_count == 0){

$cart_html .= '

<div style="
padding:40px 20px;
text-align:center;
">

<img src="images/emptycart.png"

style="
width:140px;
opacity:0.9;
margin-bottom:20px;
">



<h3 style="
color:#58260f;
margin-bottom:10px;
font-size:26px;
font-weight:800;
">

Your Cart is Empty

</h3>



<p style="
color:#777;
font-size:15px;
margin-bottom:25px;
">

Add premium coffee products to continue ☕

</p>



<a href="catalogue.php"

style="
display:inline-block;
padding:14px 26px;
background:linear-gradient(135deg,#58260f,#7a1f06);
color:#fff;
border-radius:14px;
text-decoration:none;
font-weight:bold;
box-shadow:0 10px 20px rgba(88,38,15,0.25);
">

Start Shopping

</a>

</div>

';

}





/* =========================
   CART TOTAL
========================= */

if($cart_count > 0){

$cart_html .= '

<div style="
padding:20px;
margin-top:20px;
border-top:2px solid #eee;
">

<h3 style="
display:flex;
justify-content:space-between;
font-weight:800;
color:#58260f;
">

<span>Total:</span>

<span>₹'.$total.'</span>

</h3>



<a href="checkout.php"

style="
display:block;
margin-top:18px;
padding:14px;
text-align:center;
background:linear-gradient(135deg,#58260f,#7a1f06);
color:#fff;
border-radius:14px;
text-decoration:none;
font-weight:bold;
">

Proceed To Checkout

</a>

</div>

';

}





/* =========================
   FINAL JSON RESPONSE
========================= */

echo json_encode([

    "cart_count" => $cart_count,

    "cart_html" => $cart_html

]);

?>