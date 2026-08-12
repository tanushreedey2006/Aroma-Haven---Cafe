
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="icon" type="image/png" href="weblogo.png">

    <link rel="stylesheet" scr="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">
</head>
<?php
    include "index.php";
   
    if(isset($_SESSION['user_name'])){
            

?>
<body>


  
</body>
</html>

<?php
    
        }
        else{
            header("location:register.php");
            exit();
        }
        ?>