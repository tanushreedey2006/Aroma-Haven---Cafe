<?php
include('connect.php');
global $conn;
/** @var mysqli $conn */

if($_SERVER['REQUEST_METHOD']==="POST" &&  isset($_POST['userResistrationbtn'])) {
    $name=mysqli_real_escape_string($conn, trim($_POST['name']));
    $email_id=mysqli_real_escape_string($conn, trim($_POST['email']));
    $address=mysqli_real_escape_string($conn, trim($_POST['address']));
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    


     $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'images/'. $file_name;
         move_uploaded_file($tempname, $folder);
         
  $checksql ="SELECT * FROM Clients WHERE email='$email_id'";  //$email == ?
        $run = mysqli_query($conn, $checksql);
        if(mysqli_num_rows($run) == 0){
            $sql = "INSERT INTO clients(name,email,address,image, password)
                VALUES ('$name', '$email_id', '$address',' $file_name ','$password')";

            if (mysqli_query($conn, $sql)) {
                // echo "<script>alert('signin Successful!');
                //      window.location.href='register.php';
                // </script>";
                header("Location: register.php?success=1 "); //redirect with success
            } else {
                // echo "Error: " . mysqli_error($conn);


                //   echo "<script>alert('email already exits');
                //  window.location.href='register.php';
                //  </script> ";

                header("Location: register.php?error=database&email=" . urlencode($email_id)); // database error

            }
        } else {
            // echo "<script>alert('email already exits');
            //     window.location.href='register.php';
            // </script> ";

                header("Location: register.php?error=email_exists&email=" . urlencode($email_id)); //email exists


        }
        exit(); //important to stop scropt
}  
?>


