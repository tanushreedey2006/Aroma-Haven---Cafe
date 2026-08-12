<?php
include "connect.php";
/** @var mysqli $conn */

$booked = [];
$res = mysqli_query($conn, "SELECT table_id FROM bookings WHERE status != 'Cancelled'");

while($row = mysqli_fetch_assoc($res)){
    $booked[] = $row['table_id'];
}
?>

<div class="table-grid">

<?php for($i=1; $i<=9; $i++){ ?>

    <?php $isBooked = in_array("T".$i, $booked); ?>

    <a href="book.php?table=T<?= $i ?>" 
       class="table-box <?= $isBooked ? 'booked' : '' ?>">

        Table <?= $i ?>

    </a>

<?php } ?>

</div>

<style>
.table-grid{
    display:grid;
    grid-template-columns:repeat(3,120px);
    gap:20px;
    justify-content:center;
    margin-top:50px;
}

.table-box{
    padding:30px;
    background:#22c55e;
    color:#fff;
    text-align:center;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.table-box:hover{
    transform:scale(1.05);
}

.table-box.booked{
    background:#dc2626;
    pointer-events:none;
    opacity:0.6;
}
</style>