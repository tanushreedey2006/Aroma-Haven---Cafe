<?php
session_start();
include "includes/db_connect.php";
include "function.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>

    <link rel="icon" type="image/png" href="weblogo.png">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.7/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="admin_panel.css">

    <style>
        /* =========================================
   CUSTOM DELETE CONFIRMATION CARD
========================================= */

        .delete-overlay {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(15, 23, 42, .55);

            backdrop-filter: blur(7px);

            display: none;

            align-items: center;
            justify-content: center;

            z-index: 99999;

            animation: deleteOverlayIn .25s ease;

        }

        .delete-overlay.show {

            display: flex;

        }


        /* CARD */

        .delete-confirm-card {

            width: 430px;

            max-width: 90%;

            background: #fff;

            border-radius: 26px;

            padding: 35px;

            text-align: center;

            box-shadow:
                0 30px 80px rgba(0, 0, 0, .25);

            animation: deleteCardIn .35s ease;

        }


        /* DELETE ICON */

        .delete-icon-box {

            width: 75px;
            height: 75px;

            margin: 0 auto 20px;

            border-radius: 22px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: linear-gradient(135deg,
                    #fee2e2,
                    #fecaca);

            color: #dc2626;

            font-size: 30px;

            box-shadow:
                0 12px 30px rgba(220, 38, 38, .15);

        }


        /* TITLE */

        .delete-confirm-card h2 {

            margin: 0 0 12px;

            color: #0f172a;

            font-size: 24px;

            font-weight: 800;

        }


        /* DESCRIPTION */

        .delete-confirm-card p {

            margin: 0 auto 18px;

            color: #64748b;

            font-size: 14px;

            line-height: 1.7;

        }

        .delete-confirm-card p strong {

            color: #1e293b;

            font-weight: 700;

        }


        /* WARNING */

        .delete-warning {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 9px 15px;

            border-radius: 30px;

            background: #fff7ed;

            color: #c2410c;

            font-size: 12px;

            font-weight: 600;

            margin-bottom: 25px;

        }


        /* BUTTON AREA */

        .delete-card-actions {

            display: flex;

            justify-content: center;

            gap: 12px;

        }


        /* CANCEL */

        .cancel-delete-btn {

            border: none;

            padding: 11px 22px;

            border-radius: 12px;

            background: #f1f5f9;

            color: #334155;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: .3s;

        }

        .cancel-delete-btn:hover {

            background: #e2e8f0;

            transform: translateY(-2px);

        }


        /* CONFIRM DELETE */

        .confirm-delete-btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding: 11px 22px;

            border-radius: 12px;

            background: linear-gradient(135deg,
                    #ef4444,
                    #dc2626);

            color: #fff;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            box-shadow:
                0 10px 25px rgba(220, 38, 38, .25);

            transition: .3s;

        }

        .confirm-delete-btn:hover {

            color: #fff;

            transform: translateY(-3px);

            box-shadow:
                0 15px 30px rgba(220, 38, 38, .35);

        }


        /* ANIMATION */

        @keyframes deleteOverlayIn {

            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }

        }

        @keyframes deleteCardIn {

            from {

                opacity: 0;

                transform:
                    translateY(25px) scale(.92);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0) scale(1);

            }

        }


        /* MOBILE */

        @media(max-width:576px) {

            .delete-confirm-card {

                padding: 28px 20px;

            }

            .delete-card-actions {

                flex-direction: column;

            }

            .cancel-delete-btn,
            .confirm-delete-btn {

                width: 100%;

            }

        }


        .view-btn {
            width: 35px;
            height: 35px;
            border-radius: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: #fff;
            text-decoration: none;
            transition: .3s;
        }

        .view-btn:hover {
            transform: translateY(-5px) scale(1.08);
            color: #fff;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .2);
        }


        .category-id {

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 8px 16px;

            border-radius: 30px;

            background: linear-gradient(135deg, #ede9fe, #ddd6fe);

            color: #6d28d9;

            font-weight: 700;

            font-size: 13px;

            letter-spacing: .5px;

            border: 1px solid #c4b5fd;

            transition: .35s;

        }

        .category-id:hover {

            transform: translateY(-3px);

            box-shadow: 0 12px 25px rgba(109, 40, 217, .18);

            background: linear-gradient(135deg, #8b5cf6, #7c3aed);

            color: #fff;

        }

        /*==========================================
        PREMIUM SUBCATEGORY PAGE
==========================================*/

        body {
            background: #eef4fb;
            font-family: Poppins, sans-serif;
            overflow-x: hidden;
        }

        .main-content {
            margin: 25px 20px 25px 300px;
            width: calc(100% - 320px);
            animation: fadePage .8s;
        }

        .subcategory-card {
            background: #fff;
            border-radius: 28px;
            padding: 30px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            border: 1px solid #eef2f7;
            overflow: hidden;
            animation: cardUp .8s;
        }

        .table-responsive {
            overflow-x: hidden;
        }

        /*==========================================
                HERO
==========================================*/

        .subcategory-hero {

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 35px;

            margin-bottom: 30px;

            border-radius: 28px;

            background: linear-gradient(135deg, #0f172a, #1d4ed8, #2563eb);

            color: #fff;

            position: relative;

            overflow: hidden;

            box-shadow: 0 25px 60px rgba(37, 99, 235, .28);

        }

        .subcategory-hero::before {

            content: "";

            position: absolute;

            right: -70px;
            top: -70px;

            width: 240px;
            height: 240px;

            background: rgba(255, 255, 255, .08);

            border-radius: 50%;

        }

        .subcategory-hero::after {

            content: "";

            position: absolute;

            left: -80px;
            bottom: -80px;

            width: 180px;
            height: 180px;

            background: rgba(255, 255, 255, .06);

            border-radius: 50%;

        }

        .subcategory-hero h2 {

            font-size: 34px;

            font-weight: 700;

            margin-bottom: 10px;

            position: relative;

            z-index: 2;

        }

        .subcategory-hero p {

            font-size: 15px;

            opacity: .9;

            margin: 0;

            position: relative;

            z-index: 2;

        }

        /*==========================================
            PREMIUM ADD BUTTON
==========================================*/

        .premium-add-btn {

            padding: 14px 28px;

            border-radius: 15px;

            text-decoration: none;

            font-weight: 600;

            display: inline-flex;

            align-items: center;

            gap: 10px;

            color: #fff;

            background: linear-gradient(135deg, #06b6d4, #2563eb);

            box-shadow: 0 15px 35px rgba(0, 0, 0, .25);

            transition: .35s;

            position: relative;

            z-index: 2;

        }

        .premium-add-btn:hover {

            background: linear-gradient(135deg, #0284c7, #1d4ed8);

            transform: translateY(-4px);

            box-shadow: 0 20px 45px rgba(37, 99, 235, .45);

            color: #fff;

        }

        /*==========================================
            PREMIUM STATS
==========================================*/

        .stats-grid {

            display: grid;

            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));

            gap: 22px;

            margin-bottom: 30px;

        }

        .stat-card {

            position: relative;

            overflow: hidden;

            background: #fff;

            border-radius: 24px;

            padding: 28px;

            display: flex;

            align-items: center;

            gap: 20px;

            transition: .35s;

            box-shadow: 0 15px 40px rgba(15, 23, 42, .08);

            border: 1px solid #edf2f7;

        }

        .stat-card:hover {

            transform: translateY(-8px);

            box-shadow: 0 25px 55px rgba(0, 0, 0, .14);

        }

        .stat-card::before {

            content: "";

            position: absolute;

            right: -30px;
            top: -30px;

            width: 120px;
            height: 120px;

            border-radius: 50%;

            opacity: .12;

        }

        .total-card::before {

            background: #2563eb;

        }

        .active-card::before {

            background: #16a34a;

        }

        .inactive-card::before {

            background: #ef4444;

        }

        .category-card::before {

            background: #7c3aed;

        }

        .stat-icon {

            width: 75px;

            height: 75px;

            border-radius: 20px;

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 30px;

            color: #fff;

            flex-shrink: 0;

        }

        .total-card .stat-icon {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

        }

        .active-card .stat-icon {

            background: linear-gradient(135deg, #22c55e, #15803d);

        }

        .inactive-card .stat-icon {

            background: linear-gradient(135deg, #ef4444, #b91c1c);

        }

        .category-card .stat-icon {

            background: linear-gradient(135deg, #8b5cf6, #6d28d9);

        }

        .stat-info {

            flex: 1;

        }

        .stat-info h3 {

            font-size: 34px;

            font-weight: 700;

            margin-bottom: 4px;

            color: #0f172a;

        }

        .stat-info p {

            margin: 0;

            font-size: 15px;

            font-weight: 500;

            color: #64748b;

        }

        /*==========================================
            PREMIUM TABLE
==========================================*/

        .premium-table {

            border-collapse: separate;

            border-spacing: 0;

            margin-bottom: 0;

        }

        .table-id {

            display: inline-block;

            padding: 8px 16px;

            background: #eff6ff;

            border-radius: 30px;

            font-weight: 700;

            color: #2563eb;

        }

        .category-box {

            display: flex;

            align-items: center;

            gap: 14px;

        }

        .category-icon {

            width: 52px;

            height: 52px;

            border-radius: 16px;

            display: flex;

            justify-content: center;

            align-items: center;

            background: linear-gradient(135deg, #2563eb, #60a5fa);

            color: #fff;

            font-size: 22px;

        }

        .subcategory-name {

            font-weight: 600;

            font-size: 15px;

            color: #0f172a;

        }

        .description-box {

            max-width: 220px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            color: #64748b;

        }

        .subcategory-image {

            width: 85px;

            height: 85px;

            border-radius: 18px;

            object-fit: cover;

            transition: .35s;

            box-shadow: 0 10px 25px rgba(0, 0, 0, .12);

        }

        .subcategory-image:hover {

            transform: scale(1.12);

        }

        .price-tag {

            display: inline-block;

            padding: 10px 18px;

            border-radius: 40px;

            font-weight: 700;

            background: #dcfce7;

            color: #15803d;

        }

        .status-badge {

            padding: 8px 12px;

            border-radius: 30px;

            font-size: 13px;

            font-weight: 600;

            display: inline-flex;

            align-items: center;

            gap: 8px;

        }

        .status-badge.active {

            background: #dcfce7;

            color: #15803d;

        }

        .status-badge.inactive {

            background: #fee2e2;

            color: #dc2626;

        }

        .action-buttons {

            display: flex;

            gap: 12px;

        }

        .edit-btn,
        .delete-btn {

            width: 35px;
            height: 35px;

            border-radius: 14px;

            display: flex;

            justify-content: center;

            align-items: center;

            text-decoration: none;

            color: #fff;

            transition: .3s;

        }

        .edit-btn {

            background: linear-gradient(135deg, #2563eb, #1d4ed8);

        }

        .delete-btn {

            background: linear-gradient(135deg, #ef4444, #dc2626);

        }

        .edit-btn:hover,
        .delete-btn:hover {

            transform: translateY(-5px) scale(1.08);

            color: #fff;

            box-shadow: 0 12px 28px rgba(0, 0, 0, .2);

        }

        /*==========================================
        PREMIUM TABLE HEADER
==========================================*/

        .premium-head {

            background: linear-gradient(135deg, #0F172A, #1E3A8A, #2563EB);

        }

        .premium-head th {

            background: transparent !important;

            color: #fff !important;

            padding: 18px 14px;

            font-size: 13px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: .7px;

            text-align: center;

            border: none;

            white-space: nowrap;

            position: relative;

        }

        .premium-head th:not(:last-child)::after {

            content: "";

            position: absolute;

            top: 20%;

            right: 0;

            width: 1px;

            height: 60%;

            background: rgba(255, 255, 255, .25);

        }

        .premium-head th:first-child {

            border-radius: 18px 0 0 0;

        }

        .premium-head th:last-child {

            border-radius: 0 18px 0 0;

        }

        .premium-head i {

            margin-right: 6px;

            color: #60A5FA;

            font-size: 5px;

        }

        /*==========================================
            PREMIUM TABLE BODY
==========================================*/

        .table tbody td {

            padding: 16px 8px;

            vertical-align: middle;

            border-bottom: 1px solid #edf2f7;

            transition: .35s;

        }

        .table tbody tr {

            transition: .35s;

        }

        .table tbody tr:hover {

            background: #f8fbff;

            transform: scale(1.01);

            box-shadow: 0 8px 25px rgba(0, 0, 0, .06);

        }
    </style>

</head>

<body>
    <?php


    global $conn;
    /** @var mysqli $conn */

    $search = isset($_GET['search'])
        ? mysqli_real_escape_string($conn, $_GET['search'])
        : '';


    // Product Query
    $query = "SELECT
products.*,
categories.name AS category
FROM products
LEFT JOIN categories
ON products.category_id = categories.id";

    if (!empty($search)) {
        $query .= "
    WHERE
    products.name LIKE '%$search%'
    OR categories.name LIKE '%$search%'
    ";
    }

    $query .= " ORDER BY products.id ASC";

    $res = mysqli_query($conn, $query);


    ?>


    <div class="container" style="margin-left:-1%; min-width:102%;">

        <!-- Sidebar -->
        <?php include "sidebar.php"; ?>

        <!-- Header -->
        <?php include "header.php"; ?>
        <div class="">

        </div>
    </div>


    </div>

    <!-- <div class="table-responsive" style="margin:1% 19%; width:80%;"> -->
    <div class="main-content">

        <div class="subcategory-hero">

            <div>

                <h2>
                    <i class="fa-solid fa-box-open"></i>
                    Product Management
                </h2>

                <p>
                    Manage all products from one premium enterprise dashboard.
                </p>

            </div>



        </div>







        <div class="d-flex justify-content-between align-items-center mb-3">

            <h1 class="title">Product Details</h1>

            <a href="add_product.php">

                <button class="btn btn-primary">

                    <i class="fas fa-plus"></i>
                    Add New

                </button>

            </a>

        </div>


        <?php

        $totalProduct = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM products
"));

        $activeProduct = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM products
WHERE status=1
"));

        $inactiveProduct = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT COUNT(*) total
FROM products
WHERE status=0
"));

        $totalStock = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT SUM(stock) total
FROM products
"));

        ?>

        <div class="stats-grid">

            <div class="stat-card total-card">

                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalProduct['total']; ?></h3>
                    <p>Total Products</p>
                </div>

            </div>


            <div class="stat-card active-card">

                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $activeProduct['total']; ?></h3>
                    <p>Active Products</p>
                </div>

            </div>


            <div class="stat-card inactive-card">

                <div class="stat-icon">
                    <i class="fas fa-ban"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $inactiveProduct['total']; ?></h3>
                    <p>Inactive Products</p>
                </div>

            </div>


            <div class="stat-card category-card">

                <div class="stat-icon">
                    <i class="fas fa-cubes"></i>
                </div>

                <div class="stat-info">
                    <h3><?php echo $totalStock['total']; ?></h3>
                    <p>Total Stock</p>
                </div>

            </div>

        </div>

        <!-- <table id="myTable"
    class="table table-bordered table-striped align-middle"
    style="width:100%;"> -->

        <div class="product-card">

            <div class="table-responsive">

                <table id="myTable"
                    class="table premium-table align-middle">

                    <!-- <thead class="table-info"> -->
                    <thead class="premium-head">

                        <tr>

                            <th>ID</th>
                            <th>Category ID</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if (mysqli_num_rows($res) > 0) {

                            while ($row = mysqli_fetch_assoc($res)) {

                        ?>

                                <tr>

                                    <!-- ID -->
                                    <!-- <td><?php echo $row['id']; ?></td> -->
                                    <td>

                                        <span class="table-id">

                                            #<?php echo $row['id']; ?>

                                        </span>

                                    </td>

                                    <!-- Category ID -->
                                    <!-- <td><?php echo $row['category_id']; ?></td> -->
                                    <td>

                                        <span class="category-id">
                                            <?php echo $row['category_id']; ?>

                                        </span>

                                    </td>

                                    <!-- Category -->
                                    <!-- <td><?php echo $row['category']; ?></td> -->

                                    <td>

                                        <div class="category-box">

                                            <div>

                                                <b>

                                                    <?php echo $row['category']; ?>

                                                </b>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- Product Name -->
                                    <!-- <td><?php echo $row['name']; ?></td> -->
                                    <td>

                                        <div class="subcategory-name">

                                            <?php echo $row['name']; ?>

                                        </div>

                                    </td>

                                    <td>

                                        <img

                                            src="<?php echo !empty($row['image']) ? '../images/' . $row['image'] : '../images/default.avif'; ?>"

                                            class="subcategory-image">

                                    </td>

                                    <!-- Price -->
                                    <!-- <td>₹<?php echo $row['price']; ?></td> -->
                                    <td>

                                        <div class="price-tag">

                                            ₹<?php echo number_format($row['price']); ?>

                                        </div>

                                    </td>

                                    <!-- Stock -->
                                    <!-- <td><?php echo $row['stock']; ?></td> -->
                                    <td>

                                        <?php

                                        if ($row['stock'] == 0) {

                                        ?>

                                            <span class="status-badge inactive">

                                                <i class="fas fa-circle"></i>

                                                Out Of Stock

                                            </span>

                                        <?php

                                        } elseif ($row['stock'] <= 5) {

                                        ?>

                                            <span class="status-badge" style="background:#FEF3C7;color:#D97706;">

                                                <i class="fas fa-circle"></i>

                                                <?php echo $row['stock']; ?> Left

                                            </span>

                                        <?php

                                        } else {

                                        ?>

                                            <span class="status-badge active">

                                                <i class="fas fa-circle"></i>

                                                <?php echo $row['stock']; ?> Available

                                            </span>

                                        <?php } ?>

                                    </td>

                                    <!-- Image -->
                                    <!-- <td>

                    <img
                    src="<?php echo !empty($row['image']) ? '../images/' . $row['image'] : '../images/default.avif'; ?>"
                    style="height:80px;
                    width:90px;
                    object-fit:cover;
                    border-radius:10px;">

                </td> -->

                                    <!-- Status -->
                                    <td>

                                        <?php

                                        // echo $row['status']
                                        // ? '<span class="text-success fw-bold">Active</span>'
                                        // : '<span class="text-danger fw-bold">Inactive</span>';



                                        if ($row['status'] == 1) {

                                        ?>

                                            <span class="status-badge active">

                                                <i class="fas fa-circle"></i>

                                                Active

                                            </span>

                                        <?php

                                        } else {

                                        ?>

                                            <span class="status-badge inactive">

                                                <i class="fas fa-circle"></i>

                                                Inactive

                                            </span>

                                        <?php } ?>

                                    </td>

                                    <!-- Created -->
                                    <td>

                                        <?php

                                        echo !empty($row['create_at'])
                                            ? date("d M Y h:i:s A", strtotime($row['create_at']))
                                            : '-';

                                        ?>

                                    </td>

                                    <!-- Action -->



                                    <!-- Edit -->


                                    <!-- <a href="admin_view_product.php?id=<?php echo $row['id']; ?>">
                    <i class="fa-solid fa-eye text-primary"></i></a>

                    
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>">

                        <i class="fa-solid fa-pen-to-square "
                        style="color:darkblue;"></i></a>

                    <a href="delete_action.php?type=products&id=<?php echo $row['id']; ?>&btn=user"

                    onclick="return confirm('Are you sure to delete this Product?')">

                        <i class="fa-solid fa-trash "
                        style="color:red;"></i>

                    </a> -->

                                    <td>

                                        <div class="action-buttons">

                                            <a href="admin_view_product.php?id=<?php echo $row['id']; ?>" class="view-btn">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="edit-btn">

                                                <i class="fas fa-pen"></i>

                                            </a>

                                            <a
                                                href="javascript:void(0);"
                                                class="delete-btn"
                                                onclick="openDeleteCard(
    <?php echo $row['id']; ?>,
    '<?php echo htmlspecialchars(addslashes($row['name'])); ?>'
)">

                                                <i class="fas fa-trash"></i>

                                            </a>

                                        </div>



                                    </td>

                                </tr>

                            <?php

                            }
                        } else {

                            ?>

                            <tr>

                                <td colspan="10"
                                    class="text-danger text-center">

                                    No Product Found.

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>







    </div>

    <!-- =========================================
     CUSTOM DELETE CONFIRMATION CARD
========================================= -->

    <div id="deleteOverlay" class="delete-overlay">

        <div class="delete-confirm-card">

            <div class="delete-icon-box">
                <i class="fas fa-trash"></i>
            </div>

            <h2>Delete Product?</h2>

            <p>
                Are you sure you want to delete
                <strong id="deleteProductName"></strong>?
            </p>

            <span class="delete-warning">
                <i class="fas fa-triangle-exclamation"></i>
                This action cannot be undone.
            </span>

            <div class="delete-card-actions">

                <button
                    type="button"
                    class="cancel-delete-btn"
                    onclick="closeDeleteCard()">

                    <i class="fas fa-xmark"></i>
                    Cancel

                </button>

                <a
                    href="#"
                    id="confirmDeleteBtn"
                    class="confirm-delete-btn">

                    <i class="fas fa-trash"></i>
                    Delete

                </a>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#myTable').DataTable({

                paging: true,
                searching: false,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 7

            });

        });


        function openDeleteCard(productId, productName) {

            const overlay =
                document.getElementById("deleteOverlay");

            const productNameElement =
                document.getElementById("deleteProductName");

            const confirmButton =
                document.getElementById("confirmDeleteBtn");


            /* Product name show */

            productNameElement.textContent =
                productName;


            /* Create delete URL */

            confirmButton.href =
                "delete_action.php?type=products&id=" +
                productId +
                "&btn=user";


            /* Show card */

            overlay.classList.add("show");

        }


        /* =========================================
           CLOSE DELETE CARD
        ========================================= */

        function closeDeleteCard() {

            const overlay =
                document.getElementById("deleteOverlay");

            overlay.classList.remove("show");

        }


        /* =========================================
           CLICK OUTSIDE CARD = CLOSE
        ========================================= */

        document.getElementById("deleteOverlay")
            .addEventListener("click", function(e) {

                if (e.target === this) {

                    closeDeleteCard();

                }

            });


        /* =========================================
           ESC KEY = CLOSE
        ========================================= */

        document.addEventListener("keydown", function(e) {

            if (e.key === "Escape") {

                closeDeleteCard();

            }

        });
    </script>

</body>

</html>