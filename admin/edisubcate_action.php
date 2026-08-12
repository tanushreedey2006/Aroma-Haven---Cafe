<?php
include ("includes/db_connect.php");
global $conn;

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateBtn'])){

    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    // fetch category name from categories table
    $cat_query = mysqli_query($conn,
    "SELECT name FROM categories WHERE id='$category_id'");

    $cat_data = mysqli_fetch_assoc($cat_query);

    if(!$cat_data){
        die("Category not found");
    }

    $category_name = $cat_data['name'];

    // DEBUG fixing
    // echo "Category ID = ".$category_id;
    // echo "<br>";
    // echo "Category Name = ".$category_name;
    // exit;

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['descri']);
    $price = $_POST['price'];
    $status = $_POST['status'];

    // get old image
    $old_sql = "SELECT image FROM subcategories WHERE id='$id' ";
    $old_res = mysqli_query($conn, $old_sql);
    $old_img = mysqli_fetch_assoc($old_res)['image'];

    $image = $old_img; // keep old image

    // if new image uploaded
    if($_FILES['image']['name'] != ''){

        $new_img = $_FILES['image']['name'];

        // delete old image
        if($old_img != '' && file_exists("../images/".$old_img)){
            unlink("../images/".$old_img);
        }

        move_uploaded_file($_FILES['image']['tmp_name'], "../images/".$new_img);

        $image = $new_img;
    }




    // UPDATE query
    $sql = "UPDATE subcategories SET 
            category_id='$category_id',
            category_name='$category_name',
            name='$name',
            descri='$desc',
            price='$price',
            image='$image',
            status='$status'
            WHERE id='$id'
";
// download postman



    $run = mysqli_query($conn, $sql);

    if($run){
        echo "<script>
        alert('Update successful !!');
        window.location='subcategory_list.php';
        </script>";
    }else{
        echo mysqli_error($conn);
    }
}
?>