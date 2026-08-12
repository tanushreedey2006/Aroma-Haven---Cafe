<?php
    include_once("function.php");
    global $conn;
    /** @var mysqli $conn */

    // if($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['btn']=='user'){
    //     $id=$_GET['id'];
    //     $call = delete_data('clients',$id);
    //      if($run){
    //                      echo "<script>alert('user deleted successful.'); window.location.href='user_list.php';</script> ";
    //                 }
    //                 else{
    //                     echo "<script>alert('user delete unsuccessful.'); window.location.href='user_list.php';</script> ";
    //                 }

    // }

    

$type = $_GET['type'];
$id = intval($_GET['id']);

if($type == "categories" || $type == "subcategories" || $type == "products" || $type == "clients" ){
    mysqli_query($conn, "DELETE FROM $type WHERE id=$id");
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit;

?>

    
?>