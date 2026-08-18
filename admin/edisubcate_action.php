<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("includes/db_connect.php");

global $conn;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}


/* =========================
   GET FORM DATA
========================= */

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
$name = trim($_POST['name'] ?? '');
$desc = trim($_POST['descri'] ?? '');
$status = isset($_POST['status']) ? (int)$_POST['status'] : 0;


/* =========================
   DEBUG
========================= */

// TEMPORARY
// eta diye check korbo form theke data ashche kina

if ($id <= 0) {
    die("Invalid ID. Received ID = " . $id);
}

if ($category_id <= 0) {
    die("Invalid Category ID.");
}

if ($name === '') {
    die("Subcategory name is required.");
}


/* =========================
   CHECK SUBCATEGORY
========================= */

$check_sql = "
    SELECT *
    FROM subcategories
    WHERE id = $id
    LIMIT 1
";

$check_result = mysqli_query($conn, $check_sql);

if (!$check_result) {
    die("Subcategory query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($check_result) == 0) {
    die("Subcategory not found.");
}

$old_data = mysqli_fetch_assoc($check_result);

$old_image = $old_data['image'] ?? '';

$image = $old_image;


/* =========================
   CHECK CATEGORY
========================= */

$cat_sql = "
    SELECT id
    FROM categories
    WHERE id = $category_id
    LIMIT 1
";

$cat_result = mysqli_query($conn, $cat_sql);

if (!$cat_result) {
    die("Category query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($cat_result) == 0) {
    die("Selected category not found.");
}


/* =========================
   IMAGE UPLOAD
========================= */

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === UPLOAD_ERR_OK
) {

    $file_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $extension = strtolower(
        pathinfo($file_name, PATHINFO_EXTENSION)
    );

    $allowed = [
        'jpg',
        'jpeg',
        'png',
        'webp',
        'avif'
    ];

    if (!in_array($extension, $allowed)) {
        die("Invalid image format.");
    }

    $new_image = time() . "_" . basename($file_name);

    $upload_path = "../images/" . $new_image;

    if (!move_uploaded_file($tmp_name, $upload_path)) {
        die("Image upload failed.");
    }

    // Delete old image
    if (
        !empty($old_image) &&
        file_exists("../images/" . $old_image)
    ) {

        unlink("../images/" . $old_image);
    }

    $image = $new_image;
}


/* =========================
   ESCAPE DATA
========================= */

$name = mysqli_real_escape_string($conn, $name);
$desc = mysqli_real_escape_string($conn, $desc);
$image = mysqli_real_escape_string($conn, $image);


/* =========================
   UPDATE
========================= */

$sql = "
    UPDATE subcategories
    SET
        category_id = $category_id,
        name = '$name',
        descri = '$desc',
        image = '$image',
        status = $status
    WHERE id = $id
";

$result = mysqli_query($conn, $sql);


/* =========================
   CHECK UPDATE
========================= */

if (!$result) {

    die("UPDATE FAILED:<br><br>" .
        mysqli_error($conn));
}


/* =========================
   SUCCESS
========================= */

header("Location: subcategory_list.php?updated=1");
exit;
