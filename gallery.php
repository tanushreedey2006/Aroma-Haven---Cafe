
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="coffee.css" />

    <link rel="stylesheet" type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <style>

        .content {
            padding: 22px;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .premium-tag {
            background: linear-gradient(135deg, #f5d08a, #c78a3a);
            color: #fff;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }

        .rating {
            background: #fff3cd;
            color: #b8860b;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .content h1 {
            font-size: 25px;
            color: #fff;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .category-chip {
            display: inline-block;
            padding: 7px 15px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .15);
            color: #fff;
            margin-bottom: 14px;
            font-size: 12px;
        }

        .dynamic-desc {
            color: #f5f5f5;
            line-height: 1.8;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .product-stats {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .product-stats span {
            background: rgba(255, 255, 255, .12);
            color: #fff;
            padding: 8px 12px;
            border-radius: 25px;
            font-size: 12px;
        }

        .price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .main-price {
            font-size: 34px;
            font-weight: 800;
            color: #ffd27d;
        }

        .instock {
            color: #00d26a;
            font-weight: 700;
        }

        .lowstock {
            color: #ff9800;
            font-weight: 700;
        }

        .outstock {
            color: #ff4d4d;
            font-weight: 700;
        }



        .card-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .view-btn {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;
            border: none;
            /* background:rgba(255,255,255,.15); */
            backdrop-filter: blur(10px);

            color: #fff;
            font-weight: 600;

            transition: .3s;
        }

        .order-btn {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;

            background: linear-gradient(135deg,
                    #d4a574,
                    #f0c78c);

            color: #2c1a10;
            font-weight: 700;

            transition: .3s;
        }

        .sold-btn {
            flex: 1;
            border: none;
            padding: 12px;
            border-radius: 12px;

            background: #666;
            color: white;
        }

        .view-btn:hover,
        .order-btn:hover {
            transform: translateY(-4px);
        }

        .card-buttons button {
            flex: 1;
            /* padding:12px; */
            border-radius: 50px;
            background: white;
            color: #4e2613;
            font-weight: 700;
            transition: .3s;
        }

        .card-buttons button:hover {
            transform: translateY(-4px);
        }

        .card:hover .premium-tag {
            transform: scale(1.05);
        }

        .card:hover .main-price {
            letter-spacing: 1px;
        }


        .premium-pagination {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 50px auto 40px;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.pagination-number {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    text-decoration: none;

    color: #5b3a29;
    background: #fff;

    border: 1px solid #dfcbb9;
    border-radius: 12px;

    font-size: 14px;
    font-weight: 700;

    box-shadow: 0 4px 12px rgba(76, 45, 25, 0.08);

    transition: all 0.3s ease;
}

.pagination-number:hover {
    color: #fff;
    background: linear-gradient(135deg, #70533d, #9a704f);
    border-color: transparent;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(76, 45, 25, 0.20);
}

.pagination-number.active {
    color: #fff;
    background: linear-gradient(135deg, #5b3a29, #9a704f);
    border-color: transparent;
    box-shadow: 0 8px 20px rgba(76, 45, 25, 0.25);
}

.pagination-arrow {
    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    text-decoration: none;

    color: #5b3a29;
    background: #fff;

    border: 1px solid #dfcbb9;
    border-radius: 12px;

    font-size: 12px;

    box-shadow: 0 4px 12px rgba(76, 45, 25, 0.08);

    transition: all 0.3s ease;
}

.pagination-arrow:hover {
    color: #fff;
    background: #70533d;
    border-color: #70533d;
    transform: translateY(-3px);
}

.pagination-arrow.disabled {
    opacity: 0.35;
    pointer-events: none;
}

.pagination-dots {
    width: 25px;
    text-align: center;
    color: #70533d;
    font-weight: 700;
}


/* TABLET */

@media (max-width: 750px) {

    .premium-pagination {
        margin-top: 10em ;
        margin-right: 4em;
        margin-bottom: 10px;
        gap: 6px;
    }

    .pagination-numbers {
        gap: 5px;
    }

    .pagination-number,
    .pagination-arrow {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        font-size: 13px;
    }

    .pagination-dots {
        width: 18px;
        font-size: 13px;
    }
    .sold-btn{
        margin-top: 4%;
        height: 14vh;
    }
}


/* MOBILE */

@media (max-width: 480px) {


    .pagination-numbers {
        gap: 4px;
    }

    .pagination-number,
    .pagination-arrow {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        font-size: 12px;
    }

    .pagination-dots {
        width: 12px;
        font-size: 12px;
    }
}



    </style>
</head>

<body>



    <!-- Gallery start -->
    <h1 style="text-align: center; color: #70533d;" class="gaery">Gallery Section</h1>

    <div class="pro" id="galltext">

        <?php
        include("connect.php");
        /** @var mysqli $conn */

/* =========================
   PAGINATION
========================= */

$limit = 6; // 6 products per page

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

/* Total products */
$countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");

$countRow = mysqli_fetch_assoc($countQuery);

$totalProducts = (int)$countRow['total'];

$totalPages = max(1, ceil($totalProducts / $limit));

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;


/* Products for current page */
$query = mysqli_query($conn, "
    SELECT 
        p.*, 
        s.descri
    FROM products p
    LEFT JOIN subcategories s 
        ON p.category_id = s.id
    ORDER BY p.id DESC
    LIMIT $offset, $limit
");



        while ($row = mysqli_fetch_assoc($query)) {
        ?>

            <div class="card" id="card">
                <div class="circle">
                    <div class="flex">
                        <img src="./images/<?php echo $row['image']; ?>" class="logo" id="logo">

                        <div style="display: flex; justify-content: space-around; gap: 7em;">
                            <div>
                                <h1>Rs. <?php echo $row['price']; ?></h1>
                            </div>

                            <div style="color: gray;">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-comment"></i>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="content">

                    <div class="top-row">

                        <span class="premium-tag">
                            <?php
                            if ($row['price'] >= 400) {
                                echo "👑 Luxury";
                            } elseif ($row['price'] >= 250) {
                                echo "🔥 Bestseller";
                            } else {
                                echo "☕ Popular";
                            }
                            ?>
                        </span>
                        <div class="category-chip">
                            <?php echo $row['category_name']; ?>
                        </div>
                        <span class="rating">
                            ⭐ 4.9
                        </span>

                    </div>

                    <h1><?php echo $row['name']; ?></h1>



                    <p class="dynamic-desc">

                        <?php
                        if (!empty($row['descri'])) {
                            echo substr($row['descri'], 0, 90) . '...';
                        } else {
                            echo "Freshly crafted with premium ingredients and exceptional flavour.";
                        }
                        ?>

                    </p>

                    <div class="product-stats">

                        <span>
                            <i class="fa-solid fa-cube"></i>
                            <?php echo $row['stock']; ?> Stock
                        </span>

                        <span>
                            <i class="fa-solid fa-truck-fast"></i>
                            Fast Delivery
                        </span>

                    </div>

                    <div class="price-section">

                        <div class="main-price">
                            ₹<?php echo number_format($row['price']); ?>
                        </div>

                        <div class="stock-badge">

                            <?php if ($row['stock'] > 20) { ?>
                                <span class="instock">In Stock</span>

                            <?php } elseif ($row['stock'] > 0) { ?>
                                <span class="lowstock">Few Left</span>

                            <?php } else { ?>
                                <span class="outstock">Sold Out</span>
                            <?php } ?>

                        </div>

                    </div>

                    <div class="card-buttons">

                        <a href="viewproduct.php?id=<?php echo $row['id']; ?>" class="view-btn" style="text-decoration:none; border:none;">
                            <i class="fa-solid fa-eye"></i>
                            View
                        </a>

                        <?php if ($row['stock'] > 0) { ?>

                            <a href="checkout_add_item.php?product_id=<?php echo $row['id']; ?>" class="order-btn">
                                <i class="fa-solid fa-bag-shopping"></i>
                                Order
                            </a>

                        <?php } else { ?>

                            <button class="sold-btn" disabled>
                                Sold Out
                            </button>

                        <?php } ?>

                    </div>




                </div>

                <img src="./images/<?php echo $row['image']; ?>" class="product" id="product">
            </div>

        <?php } ?>


        <?php if ($totalPages > 1): ?>

<div class="premium-pagination">

    <!-- Previous -->
    <?php if ($page > 1): ?>

        <a href="?page=<?php echo $page - 1; ?>" class="pagination-arrow">
            <i class="fa-solid fa-chevron-left"></i>
        </a>

    <?php else: ?>

        <span class="pagination-arrow disabled">
            <i class="fa-solid fa-chevron-left"></i>
        </span>

    <?php endif; ?>


    <!-- Page Numbers -->
    <div class="pagination-numbers">

        <?php

        $range = 2;

        if ($page > 3) {
        ?>

            <a href="?page=1" class="pagination-number">
                1
            </a>

            <?php if ($page > 4): ?>

                <span class="pagination-dots">...</span>

            <?php endif; ?>

        <?php
        }


        $start = max(1, $page - $range);
        $end   = min($totalPages, $page + $range);

        for ($i = $start; $i <= $end; $i++) {
        ?>

            <a
                href="?page=<?php echo $i; ?>"
                class="pagination-number <?php echo ($i == $page) ? 'active' : ''; ?>"
            >
                <?php echo $i; ?>
            </a>

        <?php
        }


        if ($page < $totalPages - 2) {

            if ($page < $totalPages - 3) {
        ?>

                <span class="pagination-dots">...</span>

        <?php
            }
        ?>

            <a
                href="?page=<?php echo $totalPages; ?>"
                class="pagination-number"
            >
                <?php echo $totalPages; ?>
            </a>

        <?php } ?>

    </div>


    <!-- Next -->
    <?php if ($page < $totalPages): ?>

        <a href="?page=<?php echo $page + 1; ?>" class="pagination-arrow">
            <i class="fa-solid fa-chevron-right"></i>
        </a>

    <?php else: ?>

        <span class="pagination-arrow disabled">
            <i class="fa-solid fa-chevron-right"></i>
        </span>

    <?php endif; ?>

</div>

<?php endif; ?>

    </div>

    </div>

    <?php include("footer.php"); ?>

    <!-- Gallery end -->





    <script src="script.js"></script>
    <script src="search.js"></script>

    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectPage(select) {

            let page = select.value;

            if (page != "") {

                window.location.href = page;
            }

            select.selectedIndex = 0;
        }
    </script>

</body>

</html>