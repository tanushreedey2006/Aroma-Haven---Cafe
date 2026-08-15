<?php
include ("includes/db_connect.php");
global $conn;

/** @var mysqli $conn */


      //  if($row){
      //     if($old){
      //       unlink('../images'.$old);
      //     }

      if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['updateBtn'])){
        $id=$_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];




        //get old image name
        $old_sql="SELECT image FROM clients WHERE id='$id'";
        $old_res= mysqli_query( $conn,$old_sql);
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



 $sql = "UPDATE `clients` SET `name`='$name',`email`='$email',`address`='$address',`image`='$image' WHERE id = '$id'" ; 
            $run=mysqli_query($conn,$sql);
            
            echo "<script>alert('update successful !!'); window.location='user_list.php'; </script>";




     
      }
    
          
        
      
     


?>