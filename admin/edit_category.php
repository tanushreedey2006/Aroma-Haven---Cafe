

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Category</title>
    <link rel="icon" type="image/png" href="weblogo.png">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

<?php
include "includes/db_connect.php";
global $conn;
/** @var mysqli $conn */
$id=$_GET['id'];
$sql="SELECT * FROM categories WHERE id='$id' ";
$run=mysqli_query($conn,$sql);
$data=mysqli_fetch_assoc($run);
?> 
<link rel="stylesheet" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

<style>

    /* SUCCESS CARD */

.success-overlay {
    position: fixed;
    inset: 0;

    display: flex;
    justify-content: center;
    align-items: center;

    background: rgba(0,0,0,.65);

    z-index: 9999;
}

.success-card {
    width: 90%;
    max-width: 400px;

    position: relative;

    padding: 40px 30px;

    text-align: center;

    background: #ffffff;

    border-radius: 22px;

    box-shadow: 0 25px 60px rgba(0,0,0,.4);

    animation: successPopup .4s ease;
}

.success-icon {
    width: 75px;
    height: 75px;

    margin: 0 auto 20px;

    display: flex;
    justify-content: center;
    align-items: center;

    border-radius: 50%;

    background: #e7f8ed;
    color: #28a745;

    font-size: 32px;
}

.success-card h3 {
    color: #30261c;
    font-weight: 700;
    margin-bottom: 12px;
}

.success-card p {
    color: #666;
    margin-bottom: 25px;
}

.success-card button {
    border: none;

    padding: 11px 30px;

    border-radius: 10px;

    background: #ff9800;
    color: white;

    font-weight: 600;

    cursor: pointer;
}

.success-card button:hover {
    background: #e68900;
}

@keyframes successPopup {
    from {
        opacity: 0;
        transform: scale(.8);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}


body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(rgba(0,0,0,.65),rgba(0,0,0,.65)),
    url("../images/gl1.webp");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    font-family:'Poppins',sans-serif;
}

.form-control::placeholder{

    color:#8a8f98;

    font-weight:500;

    opacity:1;

}

    .form-container{

    width:480px;

    padding:35px;
    margin-top: 2%;

    border-radius:22px;

    background:rgba(255,255,255,.12);

    backdrop-filter:blur(18px);

    -webkit-backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,.18);

    box-shadow:
    0 25px 60px rgba(0,0,0,.45);

    animation:popup .7s ease;
}

    .form-title{

    color:#fff;

    font-size:32px;

    font-weight:700;

    text-align:center;

    margin-bottom:30px;

    letter-spacing:1px;
}

.form-label{

    color:#fff;

    font-weight:600;

    margin-bottom:8px;
}

.form-control,
.form-select{

    height:52px;

    border-radius:12px;

    border:1px solid rgba(255,255,255,.15);

    background:rgba(255,255,255,.92);

    color:#2d3748;

    font-size:15px;

    font-weight:500;

    transition:.35s;

    box-shadow:none;

}

.form-control:focus,
.form-select:focus{

    background:#fff;

    color:#1a202c;

    border-color:#ff9800;

    box-shadow:0 0 0 4px rgba(255,152,0,.25);

    transform:scale(1.02);

}
textarea.form-control{

    height:120px;

    resize:none;

    color:#2d3748;

}

    .img-preview{

    width:100%;

    height:220px;

    border-radius:18px;

    object-fit:cover;

    border:3px solid rgba(255,255,255,.3);

    box-shadow:0 15px 35px rgba(0,0,0,.35);
}

 .btn-custom{

    width:100%;

    height:52px;

    border:none;

    border-radius:12px;

    font-size:17px;

    font-weight:700;

    color:#fff;

    background:linear-gradient(135deg,#ff9800,#ff6f00);

    transition:.35s;
}

.btn-custom:hover{

    transform:translateY(-4px);

    box-shadow:
    0 15px 30px rgba(255,152,0,.45);

    background:linear-gradient(135deg,#ffb300,#ff8f00);
}


@keyframes popup{

from{

opacity:0;

transform:translateY(50px) scale(.9);

}

to{

opacity:1;

transform:translateY(0) scale(1);

}

}
</style>

</head>

<body>

<div class="form-container">
    <h3 class="form-title">Edit Category</h3>

    <form action="editcate_action.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug" value="<?php echo $data['slug']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="descri"><?php echo $data['descri']; ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input class="form-control" name="price" value="<?php echo $data['price']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Image</label>
            <input type="file" class="form-control" name="image" id="imginput" accept="image/*">
        </div>

        <div class="mb-3 text-center">
            <img src="../images/<?php echo $data['image']; ?>" id="imgpreview" class="img-preview">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="1" <?php if($data['status']==1) echo "selected"; ?>>Active</option>
                <option value="0" <?php if($data['status']==0) echo "selected"; ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" name="updateBtn" class="btn btn-primary btn-custom">
            Update Category
        </button>

    </form>
</div>
<?php if(isset($_GET['updated'])) { ?>

<div class="success-overlay" id="successOverlay">

    <div class="success-card">

        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h3>Updated Successfully!</h3>

        <p>
            The category has been updated successfully.
        </p>

        <button onclick="closeSuccessCard()">
            Continue
        </button>

    </div>

</div>

<?php } ?>


<script>

document.getElementById('imginput').onchange = function(){ 
    document.getElementById('imgpreview').src = URL.createObjectURL(this.files[0]); 
}

function closeSuccessCard() {
    window.location.href = "category_list.php";
}
</script> 

<script src="../assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script> 

</body> 
</html>

