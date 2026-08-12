<?php
include "connect.php";
session_start();
global $conn;
$user_id=$_SESSION['user_id'];
$sql="SELECT * FROM users WHERE user_id='$user_id' ";
$run=mysqli_query($conn,$sql);
$data=[];
if(mysqli_num_rows($run)){
    $data=mysqli_fetch_assoc($run);
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="form_action.php" method="POST" enetype="multipart/form_data">
    <input type="hidden" name="user_id"  value="<?php echo $data['user_id']; ?>"  />
    <input type="text" name="name"   value="<?php echo $data['name']; ?>"  />
    <button type="submit" name="profile update" value="profile update">Save</button>

</form>
</body>
</html>
    

