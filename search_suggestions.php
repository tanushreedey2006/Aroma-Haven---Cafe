<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

global $conn;
include("connect.php");

header("Content-Type: application/json");

$search = trim($_GET['search'] ?? '');

if ($search === '') {
    echo json_encode([]);
    exit;
}

$searchLike = "%" . $search . "%";

$suggestions = [];


/*
==========================================================
SEARCH PRODUCTS
==========================================================
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        id,
        name,
        price,
        image
     FROM products
    WHERE status = 'active'
AND (
    name LIKE ?
    OR category_name LIKE ?
)
     ORDER BY name ASC
     LIMIT 6"
);

if ($stmt) {

   mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $searchLike,
    $searchLike
);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {

        $suggestions[] = [

            'type' => 'Product',

            'title' => $row['name'],

            'price' => $row['price'],

            'image' => $row['image'],

            'url' =>
'viewproduct.php?id=' .
    $row['id']

        ];
    }

    mysqli_stmt_close($stmt);
}


/*
==========================================================
SEARCH CATEGORIES
==========================================================
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT
        id,
        name
     FROM categories
     WHERE name LIKE ?
     ORDER BY name ASC
     LIMIT 4"
);

if ($stmt) {

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $searchLike
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {

        $suggestions[] = [

            'type' => 'Category',

            'title' => $row['name'],

            'price' => '',

            'image' => '',

            'url' =>
            'catalogue.php?search=' .
                urlencode($row['name'])

        ];
    }

    mysqli_stmt_close($stmt);
}


echo json_encode(
    array_slice($suggestions, 0, 8)
);
