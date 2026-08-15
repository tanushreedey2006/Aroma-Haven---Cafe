<?php

error_reporting(0);
ini_set('display_errors', 0);
/** @var mysqli $conn */

session_start();
include("connect.php");

header("Content-Type: application/json");

function jsonResponse($data){
    echo json_encode($data);
    exit();
}

/* =========================
   LOGIN CHECK
========================= */
if(!isset($_SESSION['user_id'])){
    jsonResponse([
        "success" => false,
        "message" => "Login required",
        "wishlist_count" => 0
    ]);
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

/* =========================
   GET COUNT FUNCTION
========================= */
function getWishlistCount($conn, $user_id){
    $q = mysqli_query($conn,
        "SELECT COUNT(*) AS total 
         FROM wishlist 
         WHERE user_id='$user_id' AND status='active'"
    );
    $row = mysqli_fetch_assoc($q);
    return (int)$row['total'];
}

/* =========================
   ADD TO WISHLIST
========================= */
if($action == "add"){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $price = $_POST['price'];

    $check = mysqli_query($conn,
        "SELECT * FROM wishlist 
         WHERE user_id='$user_id'
         AND product_id='$product_id'
         AND status='active'"
    );

    if(mysqli_num_rows($check) == 0){

        mysqli_query($conn,
            "INSERT INTO wishlist(
                user_id,
                product_id,
                product_name,
                product_image,
                price,
                status
            ) VALUES(
                '$user_id',
                '$product_id',
                '$product_name',
                '$product_image',
                '$price',
                'active'
            )"
        );
    }

    jsonResponse([
        "success" => true,
        "wishlist_count" => getWishlistCount($conn, $user_id)
    ]);
}

/* =========================
   REMOVE WISHLIST
========================= */
if($action == "remove"){

    $wishlist_id = $_POST['wishlist_id'];

    mysqli_query($conn,
        "DELETE FROM wishlist
         WHERE wishlist_id='$wishlist_id'
         AND user_id='$user_id'"
    );

    jsonResponse([
        "success" => true,
        "wishlist_count" => getWishlistCount($conn, $user_id)
    ]);
}

/* =========================
   MOVE TO CART
========================= */
if($action == "move_to_cart"){

    $wishlist_id = $_POST['wishlist_id'];

    $wishQuery = mysqli_query($conn,
        "SELECT * FROM wishlist
         WHERE wishlist_id='$wishlist_id'
         AND user_id='$user_id'"
    );

    $wish = mysqli_fetch_assoc($wishQuery);

    if($wish){

        $product_id = $wish['product_id'];

        $checkCart = mysqli_query($conn,
            "SELECT * FROM addtocart
             WHERE user_id='$user_id'
             AND product_id='$product_id'
             AND status='active'"
        );

        if(mysqli_num_rows($checkCart) == 0){

            mysqli_query($conn,
                "INSERT INTO addtocart(
                    user_id,
                    product_id,
                    name,
                    image,
                    price,
                    quantity,
                    status
                ) VALUES(
                    '$user_id',
                    '$product_id',
                    '".$wish['product_name']."',
                    '".$wish['product_image']."',
                    '".$wish['price']."',
                    1,
                    'active'
                )"
            );
        }
    }

    jsonResponse([
        "success" => true,
        "wishlist_count" => getWishlistCount($conn, $user_id)
    ]);
}

/* =========================
   LOAD WISHLIST (IMPORTANT FIX)
========================= */
if($action == "load"){

    $query = mysqli_query($conn,
        "SELECT * FROM wishlist
         WHERE user_id='$user_id'
         AND status='active'
         ORDER BY wishlist_id DESC"
    );

    $response = "";
    $count = 0;

    while($row = mysqli_fetch_assoc($query)){
        $count++;

        $response .= '
        <div class="wish-card" data-wish-id="'.$row['wishlist_id'].'">
            <div class="wish-img">
                <img src="images/'.trim($row['product_image']).'">
            </div>

            <div class="wish-content">
                <h3>'.$row['product_name'].'</h3>
                <h2>₹'.$row['price'].'</h2>

                <div class="wish-btn-flex">

                    <button class="move-btn"
                        onclick="moveToCart('.$row['wishlist_id'].')">
                        Move To Cart
                    </button>

                    <button class="delete-btn"
                        onclick="removeWishlist('.$row['wishlist_id'].')">
                        Remove
                    </button>

                </div>
            </div>
        </div>';
    }

    jsonResponse([
        "success" => true,
        "wishlist_html" => $response,
        "wishlist_count" => $count
    ]);
}

?>