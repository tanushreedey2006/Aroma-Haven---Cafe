<?php
include('includes/db_connect.php');
global $conn;
/** @var mysqli $conn */
if(isset($_POST['add_subcategory'])){

    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $descri = mysqli_real_escape_string($conn, $_POST['descri']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Fetch Category Name
    $cat_query = "SELECT name FROM categories WHERE id='$category_id'";
    $cat_result = mysqli_query($conn, $cat_query);
    $cat_data = mysqli_fetch_assoc($cat_result);

    $category_name = $cat_data['name'];

    // Image Upload
    $file_name = "";

    if(!empty($_FILES['image']['name'])){

        $file_name = time().'_'.$_FILES['image']['name'];

        $tempname = $_FILES['image']['tmp_name'];

        move_uploaded_file($tempname, '../images/'.$file_name);
    }

    // Insert Query
    $insert = "INSERT INTO subcategories
    (category_id, category_name, name, descri, image, price, status)
    VALUES
    ('$category_id', '$category_name', '$name', '$descri', '$file_name', '$price', '$status')";

    $result = mysqli_query($conn, $insert);

    if($result){

        echo "
        <script>
            alert('Subcategory Added Successfully');
            window.location.href='subcategory_list.php';
        </script>
        ";

    }else{

        echo mysqli_error($conn);
    }
}

$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subcategory</title>

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

/* Container */

.container{
    max-width:900px;
    margin:auto;
    background:rgba(255,255,255,0.96);
    border-radius:30px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
    backdrop-filter:blur(10px);

    /* Animation */
    animation:floatCard 4s ease-in-out infinite;
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

/* Apply Animation */

.container{
    animation:floatCard 4s ease-in-out infinite;
}
/* Heading */

h2{
    text-align:center;
    font-size:34px;
    color:#8b5e3c;
    margin-bottom:35px;
    font-weight:700;
}

/* Form Layout */

.form-row{
    display:flex;
    flex-wrap:wrap;
    justify-content:space-between;
    gap:20px;
    margin-bottom:20px;
}

.form-group{
    flex:1;
    min-width:250px;
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
    min-height:140px;
}

/* Upload Box */

.upload-box{
    border:2px dashed #d6d9e0;
    border-radius:20px;
    padding:25px;
    text-align:center;
    background:#fafafa;
    cursor:pointer;
    transition:0.3s;
}

.upload-box:hover{
    border-color:#8b5e3c;
    background:#f7f7ff;
}

.upload-box i{
    font-size:42px;
    color:#8b5e3c;
    margin-bottom:10px;
}

.upload-box p{
    color:#777;
    font-size:14px;
}

/* Image Preview */

#imgpreview{
    width:100%;
    height:220px;
    object-fit:cover;
    border-radius:16px;
    margin-top:15px;
    display:none;
}

/* Button */

button{
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

button:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 25px rgba(199,144,98,0.45);
}

/* Responsive */

@media(max-width:768px){

    .container{
        padding:25px;
    }

    h2{
        font-size:28px;
    }

    .form-row{
        flex-direction:column;
    }
}

</style>

</head>
<body>

<div class="container">

    <h2>Add Subcategory</h2>

    <form method="POST" enctype="multipart/form-data">

        <!-- Row 1 -->

        <div class="form-row">

            <div class="form-group">

                <label>Select Category</label>

                <select name="category_id" required>

                    <option value="">-- Select Category --</option>

                    <?php
                    while($cat = mysqli_fetch_assoc($category_result)){
                    ?>

                    <option value="<?= $cat['id']; ?>">
                        <?= $cat['name']; ?>
                    </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Subcategory Name</label>

                <input type="text" name="name" required>

            </div>

        </div>

        <!-- Row 2 -->

        <div class="form-row">

            <div class="form-group">

                <label>Image</label>

                <div class="upload-box">

                    <i class="fa-solid fa-cloud-arrow-up"></i>

                    <p>Upload subcategory image</p>

                    <input type="file"
                    name="image"
                    accept="image/*"
                    id="imginput"
                    hidden>

                    <img src="" id="imgpreview">

                </div>

            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea
                name="descri"
                placeholder="Write subcategory description..."></textarea>

            </div>

        </div>

        <!-- Row 3 -->

        <div class="form-row">

            <div class="form-group">

                <label>Price</label>

                <input type="number" name="price" required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select name="status">

                    <option value="1">🟢 Active</option>
                    <option value="0">🔴 Inactive</option>

                </select>

            </div>

        </div>

        <!-- Button -->

        <div class="form-row">

            <div class="form-group">

                <button type="submit" name="add_subcategory">
                    Add Subcategory
                </button>

            </div>

        </div>

    </form>

</div>

<script>

const uploadBox = document.querySelector('.upload-box');
const fileInput = document.getElementById('imginput');
const preview = document.getElementById('imgpreview');

uploadBox.addEventListener('click', () => {

    fileInput.click();
});

fileInput.onchange = function(){

    if(this.files && this.files[0]){

        preview.style.display = "block";

        preview.src = URL.createObjectURL(this.files[0]);
    }
}

</script>

</body>
</html>