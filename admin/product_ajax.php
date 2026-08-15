<?php
include "includes/db_connect.php";
global $conn;

/** @var mysqli $conn */

$type   = $_POST['type'] ?? 'active';
$page   = $_POST['page'] ?? 1;
$limit  = $_POST['limit'] ?? 5;
$search = $_POST['search'] ?? '';

$page = max(1, (int)$page);
$limit = (int)$limit;
$offset = ($page - 1) * $limit;

$status = ($type == "active") ? 1 : 0;

$where = "WHERE status='$status'";

if($search != ''){
    $search = mysqli_real_escape_string($conn,$search);
    $where .= " AND name LIKE '%$search%'";
}

/* TOTAL PRODUCTS */
$total_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM products $where"
);

$total_row = mysqli_fetch_assoc($total_query);

$total_rows = $total_row['total'];
$total_pages = ceil($total_rows / $limit);

if($total_pages < 1){
    $total_pages = 1;
}

/* PRODUCTS */
$query = mysqli_query(
    $conn,
    "SELECT *
     FROM products
     $where
     ORDER BY id DESC
     LIMIT $offset,$limit"
);
?>

<style>
.product-card{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    padding:15px;
    margin-bottom:15px;
    background:#fff;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
}

.product-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.product-img{
    width:75px;
    height:75px;
    object-fit:cover;
    border-radius:12px;
}

.product-name{
    font-weight:700;
}

.product-price{
    color:#666;
}

.product-actions{
    display:flex;
    gap:10px;
}

.edit-btn{
    text-decoration:none;
    background:#4f46e5;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
}

.delete-btn{
    text-decoration:none;
    background:#dc2626;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
}

.active-badge{
    background:#dcfce7;
    color:#15803d;
    padding:4px 10px;
    border-radius:20px;
}

.inactive-badge{
    background:#fee2e2;
    color:#dc2626;
    padding:4px 10px;
    border-radius:20px;
}

.pagination{
    margin-top:20px;
    text-align:center;
}

.pg-btn{
    border:none;
    padding:8px 14px;
    margin:3px;
    border-radius:8px;
    cursor:pointer;
    background:#f1f5f9;
}

.pg-btn.active{
    background:#4f46e5;
    color:#fff;
}
</style>

<?php if(mysqli_num_rows($query) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($query)){ ?>

        <div class="product-card">

            <div class="product-left">

                <img
                    src="../images/<?php echo $row['image']; ?>"
                    class="product-img"
                >

                <div>

                    <div class="product-name">
                        <?php echo $row['name']; ?>
                    </div>

                    <div class="product-price">
                        ₹<?php echo $row['price']; ?>
                    </div>

                    <div style="margin-top:6px;">
    <span style="
        background:<?php echo ($row['stock'] > 10) ? '#16a34a' : (($row['stock'] > 0) ? '#f59e0b' : '#dc2626'); ?>;
        color:#fff;
        padding:4px 10px;
        border-radius:20px;
        font-size:12px;
        font-weight:600;
    ">
        Stock: <?php echo $row['stock']; ?>
    </span>
    
</div>

                    <div style="margin-top:8px;">

                        <?php if($row['status']==1){ ?>

                            <span class="active-badge">
                                Active
                            </span>

                        <?php } else { ?>
                                <p style="color:red; padding-bottom:6px;">Please wait until product comes in stock</p>
                            <span class="inactive-badge">
                                Inactive
                            </span>

                        <?php } ?>

                    </div>

                </div>

            </div>

            <div class="product-actions">

                <a
                    href="edit_product.php?id=<?php echo $row['id']; ?>"
                    class="edit-btn"
                >
                    Edit
                </a>

                <a
                    href="delete_action.php?type=products&id=<?php echo $row['id']; ?>"
                    class="delete-btn"
                    onclick="return confirm('Delete this product?')"
                >
                    Delete
                </a>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <div class="text-center text-danger">
        No Products Found
    </div>

<?php } ?>

<div class="pagination">

    <?php if($page > 1){ ?>

        <button
            class="pg-btn"
            data-type="<?php echo $type; ?>"
            data-page="<?php echo $page-1; ?>"
        >
            Prev
        </button>

    <?php } ?>

    <?php for($i=1; $i<=$total_pages; $i++){ ?>

        <button
            class="pg-btn <?php echo ($i==$page)?'active':''; ?>"
            data-type="<?php echo $type; ?>"
            data-page="<?php echo $i; ?>"
        >
            <?php echo $i; ?>
        </button>

    <?php } ?>

    <?php if($page < $total_pages){ ?>

        <button
            class="pg-btn"
            data-type="<?php echo $type; ?>"
            data-page="<?php echo $page+1; ?>"
        >
            Next
        </button>

    <?php } ?>

</div>