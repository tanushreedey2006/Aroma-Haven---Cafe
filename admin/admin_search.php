<?php

include "includes/db_connect.php";

/** @var mysqli $conn */


/* =====================================================
   SEARCH VALUE
===================================================== */

$search = "";

if (isset($_POST['search'])) {

    $search = trim($_POST['search']);

    $search = mysqli_real_escape_string(
        $conn,
        $search
    );
}


/* =====================================================
   CURRENT PAGE
===================================================== */

$current_page = $_POST['page'] ?? '';


/* =====================================================
   EMPTY SEARCH
===================================================== */

if ($search === "") {
    exit;
}


/* =====================================================
   SQL
===================================================== */

$sql = "";


/* =====================================================
   CUSTOMER SEARCH
===================================================== */

if ($current_page === "user_list.php") {

    $sql = "
        SELECT name
        FROM clients
        WHERE name LIKE '$search%'
        ORDER BY name
        LIMIT 8
    ";

}


/* =====================================================
   PRODUCT SEARCH
===================================================== */

elseif ($current_page === "product_list.php") {

    $sql = "
        SELECT name
        FROM products
        WHERE name LIKE '$search%'
        ORDER BY name
        LIMIT 8
    ";

}


/* =====================================================
   CATEGORY SEARCH
===================================================== */

elseif ($current_page === "category_list.php") {

    $sql = "
        SELECT name
        FROM categories
        WHERE name LIKE '$search%'
        ORDER BY name
        LIMIT 8
    ";

}


/* =====================================================
   SUBCATEGORY SEARCH
===================================================== */

elseif ($current_page === "subcategory_list.php") {

    $sql = "
        SELECT name
        FROM subcategories
        WHERE name LIKE '$search%'
        ORDER BY name
        LIMIT 8
    ";

}


/* =====================================================
   ORDER SEARCH
===================================================== */

elseif ($current_page === "order_list.php") {

    /*
     * IMPORTANT:
     * userorder table uses `id`, NOT `order_id`.
     *
     * We alias `id` as `name` so that the existing
     * result HTML below continues to work.
     */

    $sql = "
        SELECT id AS name
        FROM userorder
        WHERE CAST(id AS CHAR) LIKE '$search%'
        ORDER BY id DESC
        LIMIT 8
    ";

}


/* =====================================================
   PAYMENT CONTROL SEARCH
===================================================== */

elseif ($current_page === "admin_payment_control.php") {

    $sql = "
        SELECT name
        FROM clients
        WHERE name LIKE '$search%'
        ORDER BY name
        LIMIT 8
    ";

}


/* =====================================================
   BOOKING SEARCH
===================================================== */

elseif ($current_page === "admin_manage_bookings.php") {

    $sql = "
        SELECT customer_name AS name
        FROM bookings
        WHERE customer_name LIKE '$search%'
        ORDER BY customer_name
        LIMIT 8
    ";

}


/* =====================================================
   UNKNOWN PAGE
===================================================== */

else {

    exit;

}


/* =====================================================
   EXECUTE QUERY
===================================================== */

$result = mysqli_query(
    $conn,
    $sql
);


/* =====================================================
   QUERY ERROR PROTECTION
===================================================== */

if (!$result) {

    /*
     * Don't expose SQL/database details to the browser.
     */

    echo "
        <div class='search-item'>
            Search unavailable
        </div>
    ";

    exit;
}


/* =====================================================
   RESULTS
===================================================== */

if (mysqli_num_rows($result) > 0) {


    while ($row = mysqli_fetch_assoc($result)) {

        ?>

        <div
            class="search-item"
            data-value="<?php
                echo htmlspecialchars(
                    $row['name'] ?? ''
                );
            ?>"
        >

            <?php

            echo htmlspecialchars(
                $row['name'] ?? ''
            );

            ?>

        </div>

        <?php

    }


}


/* =====================================================
   NO RESULT
===================================================== */

else {

    echo "
        <div class='search-item'>
            No result found
        </div>
    ";

}

?>