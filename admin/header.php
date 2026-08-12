
<?php

include "includes/db_connect.php";
global $conn;
/** @var mysqli $conn */
$sql="select count(*) as total_user from clients;";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="icon" type="image/png" href="weblogo.png">

    <link rel="stylesheet" href="admin_panel.css">

   <style>
    .search-bar{
    position:relative;
}

.search-suggestions{

    position:absolute;

    top:100%;
    left:0;

    width:100%;

    background:#fff;

    border-radius:12px;

    box-shadow:0 10px 30px rgba(0,0,0,.15);

    display:none;

    z-index:9999;

    max-height:300px;

    overflow-y:auto;

}

.search-item{

    padding:12px 18px;

    cursor:pointer;

    border-bottom:1px solid #eee;

}

.search-item:hover{

    background:#eef4ff;

}

#searchResults{
    position:absolute;
    top:100%;
    left:0;
    width:100%;
    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
    display:none;
    z-index:9999;
    max-height:250px;
    overflow-y:auto;
}

.search-item{
    padding:12px 15px;
    cursor:pointer;
    border-bottom:1px solid #eee;
}

.search-item:hover{
    background:#f5f5f5;
}


.search-bar{
    position:relative;
}

#searchResults{
    position:absolute;
    top:100%;
    left:0;
    width:100%;
    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    display:none;
    z-index:99999;
    max-height:250px;
    overflow-y:auto;
}

.search-item{
    padding:12px 15px;
    cursor:pointer;
    transition:.3s;
    border-bottom:1px solid #eee;
}

.search-item:last-child{
    border-bottom:none;
}

.search-item:hover{
    background:#8B4513;
    color:#fff;
}


</style> 
</head>


<?php


$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
?>
      <div class="header" style=" height:9vh;">

      <button class="menu-toggle">
    <i class="fas fa-bars"></i>
</button>


<form class="search-bar"
      method="GET"
      action="<?php echo basename($_SERVER['PHP_SELF']); ?>"
      style="display:flex;align-items:center;gap:8px;position:relative; "  id="searchForm">

    <i class="fas fa-search"></i>
  <?php

$current_page = basename($_SERVER['PHP_SELF']);

$placeholder = "Search...";

if($current_page == "user_list.php"){
    $placeholder = "Search Users...";
}
elseif($current_page == "category_list.php"){
    $placeholder = "Search Categories...";
}
elseif($current_page == "subcategory_list.php"){
    $placeholder = "Search Subcategories...";
}
elseif($current_page == "product_list.php"){
    $placeholder = "Search Products...";
}
elseif($current_page == "order_list.php"){
    $placeholder = "Search Orders...";
}
elseif($current_page == "admin_payment_control.php"){
    $placeholder = "Search users payments...";
}
elseif($current_page == "admin_manage_bookings.php"){
    $placeholder = "Search bookings...";
}


?>
    <input
    type="text"
    id="searchInput"
    name="search"
    placeholder="<?php echo $placeholder; ?>"
    value="<?php echo $search; ?>"
    style="padding-right:35px;"
>
<div id="searchResults"></div>
<!-- <div id="searchSuggestions" class="search-suggestions"></div> -->

    <?php if(!empty($_GET['search'])){ ?>
        <span
            id="clearSearch"
            style="
                position:absolute;
                right:10px;
                top:50%;
                transform:translateY(-50%);
                cursor:pointer;
                font-size:18px;
                color:#777;
                z-index:999;
            ">
            &times;
        </span>
    <?php } ?>

</form>

        <div class="header-actions">


         <?php
$notificationQuery = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM support_messages
WHERE sender='User'
AND notification=1
");

$notificationData = mysqli_fetch_assoc($notificationQuery);
?>

<div class="notification">
    <i class="fas fa-bell"></i>

    <div class="badge" id="notificationCount">
        <?= $notificationData['total']; ?>
    </div>
</div>


         

          <div class="user-profile">
            
            <div class="user-info">
                <a href="admin_profile.php"  style="text-decoration:none;">
              <div class="user-name">Admin</div>
             <div class="user-role">
                <?php echo $_SESSION['user_name'] ?? 'Guest'; ?>
                </div>
            </div></a>
        </div>


          
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

// Search Enter
document.querySelector('.search-bar input').addEventListener('keyup', function(e){
    if(e.key === 'Enter'){
        this.form.submit();
    }
});

// Clear Search
document.addEventListener("DOMContentLoaded", function(){

    let clearBtn = document.getElementById("clearSearch");

    if(clearBtn){

        clearBtn.addEventListener("click", function(){

            window.location.href = window.location.pathname;

        });

    }

});

// Load Notification
function loadNotification(){

    $("#notificationCount").load("admin_notification.php");

}

loadNotification();

setInterval(loadNotification,3000);



$(document).ready(function(){

    $("#searchInput").keyup(function(){

        var search = $(this).val();

        if(search.length == 0){
            $("#searchResults").hide();
            return;
        }

        $.ajax({

            url:"admin_search.php",
            type:"POST",

            data:{
                search:search,
                page:"<?= basename($_SERVER['PHP_SELF']); ?>"
            },

            success:function(data){

                $("#searchResults").html(data).show();

            }

        });

    });

    // Click on suggestion
   $(document).on("click",".search-item",function(){

    let value = $(this).text().trim();

    $("#searchInput").val(value);

    $("#searchResults").hide();

    $("#searchForm").submit();

});
    // Hide when clicking outside
    $(document).click(function(e){

        if(!$(e.target).closest(".search-bar").length){

            $("#searchResults").hide();

        }

    });

});

</script>

</body>
</html>


