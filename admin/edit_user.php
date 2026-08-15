<?php
include "includes/db_connect.php";
global $conn;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM clients WHERE id='$id'";
$run = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($run);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Client</title>

<link rel="stylesheet" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

<style>
body {
    background: #f4f6f9;
}

.form-container {
    max-width: 600px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.form-title {
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
}

.img-preview {
    width: 100%;
    height: 300px;
    /* object-fit: cover; */
    background-repeat: no-repeat;
  background-size: 100% 100%;
  background-position: center;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.btn-custom {
    width: 100%;
    padding: 10px;
    font-weight: 500;
    border-radius: 8px;
}
</style>

</head>

<body>

<div class="form-container">
    <h3 class="form-title">Edit Client</h3>

    <form action="edituser_action.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name"
                   value="<?php echo htmlspecialchars($data['name']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email"
                   value="<?php echo htmlspecialchars($data['email']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address"><?php echo htmlspecialchars($data['address']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Image</label>
            <input type="file" class="form-control" name="image" id="imginput" accept="image/*">
        </div>

        <div class="mb-3 text-center">
            <img src="../images/<?php echo $data['image']; ?>" id="imgpreview" class="img-preview">
        </div>

        <button type="submit" name="updateBtn" class="btn btn-primary btn-custom">
            Update Client
        </button>

    </form>
</div>

<script>
document.getElementById('imginput').onchange = function(){
    if(this.files && this.files[0]){
        document.getElementById('imgpreview').src = URL.createObjectURL(this.files[0]);
    }
}
</script>

<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>