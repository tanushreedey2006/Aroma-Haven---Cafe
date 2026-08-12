<?php
session_start();
include ("includes/db_connect.php");
// global $conn;
/** @var mysqli $conn */


if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $desci = mysqli_real_escape_string($conn, $_POST['descri']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $parent_id = mysqli_real_escape_string($conn, $_POST['parent_id']);

    // Image Upload
    $file_name = "";

    if(!empty($_FILES['image']['name'])){

        $file_name = time().'_'.$_FILES['image']['name'];

        $tempname = $_FILES['image']['tmp_name'];

        move_uploaded_file($tempname, '../images/'.$file_name);
    }

    $query = "INSERT INTO categories
    (name, slug, descri, price, image, status, parent_id)

    VALUES

    ('$name','$slug','$desci','$price','$file_name','$status','$parent_id')";

    if(mysqli_query($conn, $query)){

        echo "
        <script>
            alert('☕ Category Added Successfully!');
            window.location.href='category_list.php';
        </script>
        ";

    }else{

        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Category</title>

<link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(135deg, #fdf7f2, #f8ebe1);
    min-height:100vh;
    position:relative;
    overflow-x:hidden;
    padding:40px 15px;
}

/* Background Shapes */

body::before,
body::after{
    content:'';
    position:absolute;
    border-radius:50%;
    z-index:-1;
}

body::before{
    width:320px;
    height:320px;
    background:#ffe0cc;
    top:-100px;
    left:-100px;
}

body::after{
    width:260px;
    height:260px;
    background:#ffd9e2;
    bottom:-100px;
    right:-100px;
}

/* Floating Animation */

@keyframes floatCard{

    0%,100%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-10px);
    }
}

/* Main Container */

.container-box{
    max-width:1100px;
    margin:auto;
    background:rgba(255,255,255,0.96);
    border-radius:30px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
    backdrop-filter:blur(10px);

    animation:floatCard 4s ease-in-out infinite;
}

/* Heading */

.page-title{
    text-align:center;
    font-size:34px;
    color:#8b5e3c;
    margin-bottom:35px;
    font-weight:700;
}

/* Layout */

.form-wrapper{
    display:flex;
    gap:25px;
    flex-wrap:wrap;
}

/* Left Side */

.left-side{
    flex:1;
    min-width:280px;
}

/* Right Side */

.right-side{
    flex:2;
    min-width:300px;
}

/* Cards */

.card-box{
    background:#fff;
    border:1px solid #edf0f5;
    border-radius:24px;
    padding:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.04);
    margin-bottom:25px;
}

/* Card Title */

.card-title{
    font-size:18px;
    font-weight:600;
    color:#111827;
    margin-bottom:20px;
}

/* Labels */

label{
    display:block;
    margin-bottom:8px;
    color:#5c4b43;
    font-weight:600;
    font-size:14px;
}

/* Inputs */

input,
textarea,
select{
    width:100%;
    padding:14px 16px;
    border:none;
    border-radius:16px;
    background:#f8f5f2;
    font-size:15px;
    outline:none;
    transition:0.3s;
    border:1px solid transparent;
}

input:focus,
textarea:focus,
select:focus{
    background:#fff;
    border:1px solid #c79062;
    box-shadow:0 0 10px rgba(199,144,98,0.25);
}

textarea{
    resize:none;
    min-height:150px;
}

/* Upload Box */

.upload-box{
    border:2px dashed #d6d9e0;
    border-radius:22px;
    padding:20px;
    background:#fafafa;
    cursor:pointer;
    transition:0.3s;
    text-align:center;
    overflow:hidden;
    position:relative;
    min-height:300px;

    display:flex;
    align-items:center;
    justify-content:center;
}

.upload-box:hover{
    border-color:#8b5e3c;
    background:#fffaf6;
}

/* Upload Content */

.upload-content{
    width:100%;
}

.upload-content i{
    font-size:48px;
    color:#8b5e3c;
    margin-bottom:15px;
}

.upload-content p{
    color:#444;
    font-size:16px;
    font-weight:600;
    margin-bottom:6px;
}

.upload-content span{
    color:#888;
    font-size:13px;
}

/* Preview */

#imgpreview{
    width:100%;
    height:260px;
    object-fit:cover;
    border-radius:18px;
    display:none;
}

/* Button */

.submit-btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:18px;
    background:linear-gradient(135deg,#c79062,#8b5e3c);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
    margin-top:10px;
    box-shadow:0 10px 20px rgba(199,144,98,0.35);
}

.submit-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 25px rgba(199,144,98,0.45);
}

/* Responsive */

@media(max-width:768px){

    .container-box{
        padding:25px;
    }

    .page-title{
        font-size:28px;
    }

    .form-wrapper{
        flex-direction:column;
    }
}

</style>

</head>

<body>

<div class="container-box">

    <h2 class="page-title">Add Coffee Category</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-wrapper">

            <!-- LEFT -->

            <div class="left-side">

               <div class="card-box">

    <h4 class="card-title">Image</h4>

    <div class="upload-box" id="uploadBox">

        <input type="file"
        name="image"
        id="imginput"
        accept="image/*"
        hidden>

        <!-- Upload Content -->

        <div class="upload-content" id="uploadContent">

            <i class="fa-solid fa-cloud-arrow-up"></i>

            <p>Upload category image</p>

            <span>Click to browse image</span>

        </div>

        <!-- Preview -->

        <img src="" id="imgpreview">

    </div>

</div>

                <!-- Status -->

                <div class="card-box">

                    <h4 class="card-title">Status</h4>

                    <label>Set Status</label>

                    <select name="status">

                        <option value="1">🟢 Active</option>
                        <option value="0">🔴 Inactive</option>

                    </select>
                </div>
            </div>

            <!-- RIGHT -->

            <div class="right-side">

                <div class="card-box">

                    <div style="margin-bottom:25px;">

                        <label>Category Name</label>

                        <input type="text"
                        name="name"
                        placeholder="Category Name"
                        required>

                    </div>

                    <div style="margin-bottom:25px;">

                        <label>Slug</label>

                        <input type="text"
                        name="slug"
                        placeholder="coffee-category">

                    </div>

                    <div style="margin-bottom:25px;">

                        <label>Description</label>

                        <textarea
                        name="descri"
                        placeholder="Write category description..."></textarea>

                    </div>

                    <div>

                        <label>Price</label>

                        <input type="text"
                        name="price"
                        placeholder="Price">

                    </div>
                    <!-- Parent Category -->

                <div class="card-box"  style="margin-top:25px;">

                    <h4 class="card-title">Category Details</h4>

                    <label>Parent Category</label>

                    <select name="parent_id">

                        <option value="0">Main Category</option>

                        <?php
                        $cat = mysqli_query($conn,
                        "SELECT * FROM categories WHERE parent_id = 0");

                        while($c = mysqli_fetch_assoc($cat)){
                        ?>

                        <option value="<?= $c['id']; ?>">
                            <?= $c['name']; ?>
                        </option>

                        <?php } ?>

                    </select>

                </div>


                </div>

            </div>

        </div>

        <button type="submit"
        name="submit"
        class="submit-btn">

            Add Category

        </button>

    </form>

</div>

<script>



const uploadBox = document.getElementById('uploadBox');
const fileInput = document.getElementById('imginput');
const preview = document.getElementById('imgpreview');
const uploadContent = document.getElementById('uploadContent');

uploadBox.addEventListener('click', () => {

    fileInput.click();
});

fileInput.onchange = function(){

    if(this.files && this.files[0]){

        preview.style.display = "block";

        uploadContent.style.display = "none";

        preview.src = URL.createObjectURL(this.files[0]);
    }
}



</script>

</body>
</html>