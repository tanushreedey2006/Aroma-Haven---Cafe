<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>

    <link rel="stylesheet" href="coffee.css">
    <link rel="icon" href="weblogo.png">

    <link rel="stylesheet" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .best-badge {
            position: absolute;
            top: 15px;
            left: 15px;

            background: linear-gradient(135deg, #ff9800, #ff5722);

            color: #fff;

            padding: 8px 15px;

            border-radius: 25px;

            font-size: 12px;

            font-weight: 700;

            z-index: 10;

            box-shadow: 0 8px 20px rgba(255, 87, 34, 0.35);
        }

        .product-image-box {
            position: relative;
        }

        .action-flex {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .add-order-btn {
            display: block;
            /* margin-top:12px; */
            text-align: center;
            text-decoration: none;
            background: #000;
            color: #58260f;
            /* padding:7px; */
            border-radius: 12px;
            font-weight: 600;

        }
@media (max-width:768px) {
            .catup{
  margin-top: 8em !important;
}

.category-products{
    margin-left: -2%;
    width: 90%;
}

h1{
    margin-right: 2em;
}
}


    </style>
    <?php
    session_start();
    include("connect.php");
    /** @var mysqli $conn */


    $user_id = null;

    if (isset($_SESSION['user_email'])) {
        $email = $_SESSION['user_email'];

        $getUser = mysqli_query(
            $conn,
            "SELECT id FROM clients WHERE email='$email'"
        );

        if ($row = mysqli_fetch_assoc($getUser)) {
            $user_id = $row['id'];
        }
    }
    ?>
</head>

<?php

$category = $_GET['category'] ?? 'Coffee';

$stmt = $conn->prepare("
SELECT p.*
FROM products p
JOIN categories c ON p.category_id = c.id
WHERE c.name = ?
");


$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();



$newcategory = $_GET['newcategory'] ?? 'Cold Beverages';

$stmt2 = $conn->prepare("
SELECT p.*
FROM products p
JOIN categories c ON p.category_id = c.id
WHERE c.name = ?
");
$stmt2->bind_param("s", $newcategory);
$stmt2->execute();
$result2 = $stmt2->get_result();


$userWishlist = [];
$userCart = [];

if ($user_id) {

    $w = mysqli_query(
        $conn,
        "SELECT product_id FROM wishlist 
WHERE user_id='$user_id' AND status='active'"
    );


    while ($row = mysqli_fetch_assoc($w)) {


        $userWishlist[] = $row['product_id'];
    }

    $c = mysqli_query(
        $conn,
        "SELECT product_id FROM addtocart WHERE user_id='$user_id'"
    );

    while ($row = mysqli_fetch_assoc($c)) {
        $userCart[] = $row['product_id'];
    }
}


$userWishlist = array_map('intval', $userWishlist);
$userCart = array_map('intval', $userCart);
?>

<body>

    <?php include("header.php"); ?>

    <div class="catup">
        <div class="d-flex justify-content-around p-4 cataup">
            <h1 style="color:#58260f;font-weight:bold;">Catalogue</h1>

            <div class="buttons gap-5">
                <a href="catalogue.php?category=<?php echo urlencode('Coffee'); ?>"><button class="btncata">Coffee</button></a>
                <a href="catalogue.php?category=<?php echo urlencode('Pastry'); ?>"><button class="btncata">Pastry</button></a>
                <a href="catalogue.php?category=<?php echo urlencode('Desserts'); ?>"><button class="btncata">Dessert</button></a>
                <a href="catalogue.php?category=<?php echo urlencode('Snacks'); ?>"><button class="btncata">Snacks</button></a>
                <a href="catalogue.php?category=<?php echo urlencode('Golden-brown Croissant pair with Cappuccino'); ?>"><button class="btncata">Croissant</button></a>
                <a href="catalogue.php?category=<?php echo urlencode('Icecream'); ?>"><button class="btncata">Icecream</button></a>
            </div>
        </div>

        <div class="category-section">
            <div class="category-products">

                <?php if ($result->num_rows > 0) { ?>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>

                        <?php
                        $id = $row['id'];
                        $inWishlist = in_array($id, $userWishlist);
                        $inCart = in_array($id, $userCart);
                        ?>

                        <div class="product-card">
                            <div class="product-image-box">

                                <img src="images/<?php echo $row['image']; ?>">

                                <?php if ($row['price'] >= 300) { ?>
                                    <div class="best-badge">
                                        🔥 Best Seller
                                    </div>
                                <?php } ?>

                                <div class="wishlist-icon <?php echo $inWishlist ? 'active' : ''; ?>"
                                    onclick="toggleWishlist(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
                                    id="wishBtn<?php echo $id; ?>">
                                    <i class="fa-solid fa-heart"></i>
                                </div>

                            </div>

                            <div class="product-content">

                                <h4 class="product-title"><?php echo $row['name']; ?></h4>

                                <div class="price-section">
                                    <span class="old-price">Rs. <?php echo $row['price'] + 80; ?></span>
                                    <span class="new-price">Rs. <?php echo $row['price']; ?></span>
                                </div>

                                <div class="size-flex">
                                    <button class="size-btn">250gm</button>
                                    <button class="size-btn">500gm</button>
                                </div>

                                <div class="action-flex">

                                    <button class="cart-btn"
                                        data-state="<?php echo $inCart ? 'remove' : 'add'; ?>"
                                        onclick="toggleCart(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
                                        id="cartBtn<?php echo $id; ?>">

                                        <?php if ($inCart) { ?>
                                            <i class="fa-solid fa-trash" style="font-size:10px;"></i> Remove From Cart
                                        <?php } else { ?>
                                            <i class="fa-solid fa-cart-shopping" style="font-size:12px;"></i>Add To Cart
                                        <?php } ?>

                                    </button>

                                    <a href="viewproduct.php?id=<?php echo $id; ?>">
                                        <button type="button" class="view-btn">
                                            View
                                        </button>
                                    </a>

                                    <a href="checkout_add_item.php?product_id=<?php echo $id; ?>" style="text-decoration:none;">
                                        <button type="button" class="view-btn add-order-btn">
                                            Order<i class="fa-solid fa-plus" style="font-size:10px;"></i>
                                        </button>
                                    </a>

                                </div>

                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <h3 style="text-align:center;color:#58260f;">No Products Found</h3>
                <?php } ?>

            </div>
        </div>

        <!-- NEW COLLECTION -->
        <div class="catup" id="newcollection">

            <div class="d-flex justify-content-around p-5 cataup">
                <h1 style="color:#58260f;font-weight:bold;">NEW COLLECTION</h1>

                <div class="buttons gap-5">
                    <a href="catalogue.php?newcategory=<?php echo urlencode('Cold Beverages'); ?>"><button class="btncata">Cold Beverages</button></a>
                    <a href="catalogue.php?newcategory=<?php echo urlencode('Hot Beverages'); ?>"><button class="btncata">Hot Beverages</button></a>
                    <a href="catalogue.php?newcategory=<?php echo urlencode('Cool Bean Specials'); ?>"><button class="btncata">Cool Bean</button></a>
                    <a href="catalogue.php?newcategory=<?php echo urlencode('Tea & Herbal'); ?>"><button class="btncata">Herbal Tea</button></a>
                    <a href="catalogue.php?newcategory=<?php echo urlencode('Special Combo offer'); ?>"><button class="btncata">Combo</button></a>
                </div>
            </div>

            <div class="category-section">
                <div class="category-products">

                    <?php if ($result2->num_rows > 0) { ?>
                        <?php while ($row = $result2->fetch_assoc()) { ?>

                            <?php
                            $id = $row['id'];
                            $inWishlist = in_array($id, $userWishlist);

                            $inCart = in_array($id, $userCart);
                            ?>

                            <div class="product-card">

                                <div class="product-image-box">

                                    <img src="images/<?php echo $row['image']; ?>">

                                    <?php if ($row['price'] >= 300) { ?>
                                        <div class="best-badge">
                                            🔥 Best Seller
                                        </div>
                                    <?php } ?>

                                    <div class="wishlist-icon <?php echo $inWishlist ? 'active' : ''; ?>"
                                        onclick="toggleWishlist(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
                                        id="wishBtn<?php echo $id; ?>">
                                        <i class="fa-solid fa-heart"></i>
                                    </div>

                                </div>

                                <div class="product-content">

                                    <h4 class="product-title"><?php echo $row['name']; ?></h4>

                                    <div class="price-section">
                                        <span class="old-price">Rs. <?php echo $row['price'] + 80; ?></span>
                                        <span class="new-price">Rs. <?php echo $row['price']; ?></span>
                                    </div>

                                    <div class="action-flex">

                                        <button class="cart-btn"
                                            data-state="<?php echo $inCart ? 'remove' : 'add'; ?>"
                                            onclick="toggleCart(<?php echo $id; ?>,'<?php echo $row['name']; ?>','<?php echo $row['image']; ?>',<?php echo $row['price']; ?>)"
                                            id="cartBtn<?php echo $id; ?>">

                                            <?php if ($inCart) { ?>
                                                <i class="fa-solid fa-trash"></i> Remove from cart
                                            <?php } else { ?>
                                                <i class="fa-solid fa-cart-shopping"></i> Cart to cart
                                            <?php } ?>

                                        </button>

                                        <a href="viewproduct.php?id=<?php echo $id; ?>">
                                            <button type="button" class="view-btn">
                                                View
                                            </button>
                                        </a>

                                        <a href="checkout_add_item.php?product_id=<?php echo $id; ?>" style="text-decoration:none;">
                                            <button type="button" class="view-btn add-order-btn">
                                                Order<i class="fa-solid fa-plus" style="font-size:10px;"></i>

                                            </button>
                                        </a>

                                    </div>

                                </div>
                            </div>

                        <?php } ?>
                    <?php } else { ?>
                        <h3 style="text-align:center;">No Products Found</h3>
                    <?php } ?>

                </div>
            </div>

            <?php include("footer.php"); ?>

            <script src="script.js"></script>
            <script src="search.js"></script>
            <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>