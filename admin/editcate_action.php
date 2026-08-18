<?php
session_start();
include ("includes/db_connect.php");

/** @var mysqli $conn */



      if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['updateBtn'])){
         $id = mysqli_real_escape_string($conn, $_POST['id']);
         $name = mysqli_real_escape_string($conn, $_POST['name']);
         $slug = mysqli_real_escape_string($conn, $_POST['slug']);
         $desc = mysqli_real_escape_string($conn, $_POST['descri']);
         $price = $_POST['price'];
         $status = $_POST['status'];





        //get old image name
        $old_sql="SELECT image FROM categories WHERE id='$id'";
        $old_res= mysqli_query($conn,$old_sql);
        $old_img= mysqli_fetch_assoc($old_res)['image'];
        $image = $old_img; //keep old image


        //if old img upload
        if($_FILES['image']['name']!=''){
          $new_img= $_FILES['image']['name'];

          //delete old img
          if($old_img != '' && file_exists("../images/".$old_img)){
            unlink("../images/".$old_img);
          }
           move_uploaded_file($_FILES['image']['tmp_name'], "../images/".$new_img);
           $image=$new_img;
        }



 $sql = "UPDATE `categories` SET `name`='$name',`slug`='$slug',`descri`='$desc',`price`='$price',`image`='$image',`status`='$status' WHERE id = '$id'" ; 
            $run=mysqli_query($conn,$sql);
            
            // echo "<script>alert('update successful !!'); window.location='category_list.php'; </script>";

            header("Location: edit_category.php?id=$id&updated=1");
            exit();




     
      }
    
          
        
      
     


?>





