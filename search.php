<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("connect.php");

/** @var mysqli $conn */

$search = trim($_GET['search'] ?? '');

$results = [];


/*
==========================================================
SEARCH
==========================================================
*/

if ($search !== '') {

    $searchLike = "%" . $search . "%";


    /*
    ==========================================================
    SEARCH PRODUCTS
    ==========================================================
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            p.id,
            p.name,
            p.price,
            p.image,
            c.name AS category_name
         FROM products p
         LEFT JOIN categories c
            ON p.category_id = c.id
         WHERE p.status = 'active'
         AND (
                p.name LIKE ?
                OR c.name LIKE ?
         )
         ORDER BY
            CASE
                WHEN p.name LIKE ? THEN 1
                WHEN c.name LIKE ? THEN 2
                ELSE 3
            END,
            p.name ASC"
    );


    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $searchLike,
            $searchLike,
            $searchLike,
            $searchLike
        );

        mysqli_stmt_execute($stmt);

        $productResult = mysqli_stmt_get_result($stmt);


        while ($row = mysqli_fetch_assoc($productResult)) {

            $results[] = [
                'type' => 'Product',

                'title' => $row['name'],

                'description' =>
                    !empty($row['category_name'])
                        ? $row['category_name']
                        : 'Product available in our catalogue',

                'price' => $row['price'],

                'image' => $row['image'],

                /*
                IMPORTANT:
                Open the actual product directly.
                */

                'url' =>
                    'viewproduct.php?id=' .
                    urlencode($row['id'])
            ];
        }


        mysqli_stmt_close($stmt);
    }


    /*
    ==========================================================
    SEARCH CATEGORIES
    ==========================================================
    */

    /*
    Only show a category result when the search
    actually matches a category.

    Example:
    "Snacks" -> Snacks category
    "Herbal" -> Tea & Herbal category
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            id,
            name
         FROM categories
         WHERE name LIKE ?
         ORDER BY name ASC"
    );


    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $searchLike
        );

        mysqli_stmt_execute($stmt);

        $categoryResult = mysqli_stmt_get_result($stmt);


        while ($row = mysqli_fetch_assoc($categoryResult)) {

            $results[] = [

                'type' => 'Category',

                'title' => $row['name'],

                'description' =>
                    'Browse all products in this category',

                'price' => '',

                'image' => '',

                /*
                Send category search back to this page.
                */

                'url' =>
                    'search.php?search=' .
                    urlencode($row['name'])
            ];
        }


        mysqli_stmt_close($stmt);
    }
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
        <?php
        echo $search !== ''
            ? 'Search: ' . htmlspecialchars($search)
            : 'Search - Aroma Haven';
        ?>
    </title>


    <link
        rel="stylesheet"
        href="coffee.css"
    >

    <link
        rel="icon"
        href="weblogo.png"
    >

    <link
        rel="stylesheet"
        href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >


    <style>

        body {
            margin: 0;
            background: #fffaf4;
            font-family: Arial, sans-serif;
        }


        .search-page {

            padding: 140px 40px 60px;

            max-width: 1200px;

            margin: auto;

        }


        .search-title {

            color: #58260f;

            font-size: 38px;

            font-weight: 800;

            margin-bottom: 10px;

        }


        .search-subtitle {

            color: #777;

            margin-bottom: 35px;

        }


        .search-grid {

            display: grid;

            grid-template-columns:
                repeat(auto-fit, minmax(260px, 1fr));

            gap: 25px;

        }


        .search-card {

            background: #fff;

            border-radius: 18px;

            overflow: hidden;

            border: 1px solid #ead7c5;

            box-shadow:
                0 10px 30px rgba(88, 38, 15, .10);

            transition: .3s;

        }


        .search-card:hover {

            transform: translateY(-5px);

            box-shadow:
                0 16px 35px rgba(88, 38, 15, .18);

        }


        .search-image {

            width: 100%;

            height: 230px;

            object-fit: cover;

            display: block;

        }


        .search-content {

            padding: 20px;

        }


        .search-type {

            display: inline-block;

            background: #f1dfcc;

            color: #58260f;

            padding: 5px 12px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 10px;

        }


        .search-card h3 {

            margin: 0 0 10px;

            color: #333;

            font-size: 21px;

        }


        .search-card p {

            color: #777;

            margin-bottom: 15px;

        }


        .search-price {

            color: #58260f;

            font-size: 20px;

            font-weight: bold;

            margin-bottom: 15px;

        }


        .search-open {

            display: inline-block;

            padding: 10px 18px;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #58260f,
                    #7a1f06
                );

            color: #fff;

            text-decoration: none;

            font-weight: bold;

            transition: .3s;

        }


        .search-open:hover {

            color: #fff;

            transform: translateY(-2px);

        }


        .no-results {

            background: #fff;

            padding: 50px 25px;

            text-align: center;

            border-radius: 20px;

            box-shadow:
                0 10px 30px rgba(0,0,0,.08);

        }


        .no-results i {

            font-size: 50px;

            color: #d5b8a0;

            margin-bottom: 15px;

        }


        .no-results h3 {

            color: #58260f;

        }


        @media (max-width: 750px) {

            .search-page {

                padding: 120px 15px 40px;

            }


            .search-title {

                font-size: 30px;

            }


            .search-grid {

                grid-template-columns: 1fr;

            }

        }

    </style>

</head>


<body>


<?php include("header.php"); ?>


<div class="search-page">


    <?php if ($search !== '') { ?>


        <h1 class="search-title">

            Search Results

        </h1>


        <p class="search-subtitle">

            Results for:

            <strong>
                <?php
                echo htmlspecialchars($search);
                ?>
            </strong>

            —

            <?php
            echo count($results);
            ?>

            result(s) found.

        </p>


        <?php if (!empty($results)) { ?>


            <div class="search-grid">


                <?php foreach ($results as $result) { ?>


                    <div class="search-card">


                        <?php if (!empty($result['image'])) { ?>


                            <img
                                src="images/<?php
                                    echo htmlspecialchars(
                                        $result['image']
                                    );
                                ?>"
                                class="search-image"
                                alt="<?php
                                    echo htmlspecialchars(
                                        $result['title']
                                    );
                                ?>"
                                onerror="this.style.display='none';"
                            >


                        <?php } ?>


                        <div class="search-content">


                            <span class="search-type">

                                <?php
                                echo htmlspecialchars(
                                    $result['type']
                                );
                                ?>

                            </span>


                            <h3>

                                <?php
                                echo htmlspecialchars(
                                    $result['title']
                                );
                                ?>

                            </h3>


                            <p>

                                <?php
                                echo htmlspecialchars(
                                    $result['description']
                                );
                                ?>

                            </p>


                            <?php if ($result['price'] !== '') { ?>


                                <div class="search-price">

                                    ₹<?php
                                    echo htmlspecialchars(
                                        $result['price']
                                    );
                                    ?>

                                </div>


                            <?php } ?>


                            <a
                                href="<?php
                                    echo htmlspecialchars(
                                        $result['url']
                                    );
                                ?>"
                                class="search-open"
                            >

                                <?php if ($result['type'] === 'Product') { ?>

                                    View Product

                                <?php } else { ?>

                                    View Category

                                <?php } ?>

                            </a>


                        </div>

                    </div>


                <?php } ?>


            </div>


        <?php } else { ?>


            <div class="no-results">

                <div>

                    <i class="fa-solid fa-magnifying-glass"></i>

                </div>


                <h3>

                    No results found

                </h3>


                <p>

                    We couldn't find anything matching

                    "<?php
                    echo htmlspecialchars($search);
                    ?>".

                </p>


            </div>


        <?php } ?>


    <?php } else { ?>


        <div class="no-results">

            <div>

                <i class="fa-solid fa-magnifying-glass"></i>

            </div>


            <h3>

                Search Aroma Haven

            </h3>


            <p>

                Enter a product, category, or keyword
                in the search bar.

            </p>


        </div>


    <?php } ?>


</div>


<script src="script.js"></script>

<script src="search.js"></script>

<script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>