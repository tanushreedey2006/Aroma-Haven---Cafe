

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="icon" type="image/png" href="weblogo.png">

<?php
include('includes/db_connect.php');
global $conn;
/** @var mysqli $conn */

if(isset($_POST['add_product'])){

    $category_id = $_POST['category_id'];
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    // $descri = mysqli_real_escape_string($conn, $_POST['descri']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    // $status = $_POST['status'];

    // Image Upload
    $file_name = '';

    if(!empty($_FILES['image']['name'])){

        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];

        move_uploaded_file($tempname, '../images/'.$file_name);
    }

    $insert = "INSERT INTO products
    (category_id, category_name, name, price, stock, image)
    VALUES
    ('$category_id', '$category_name', '$name', '$price', '$stock' ,  '$file_name')";

    $result = mysqli_query($conn, $insert);

    if($result){

        echo "<script>
        alert('Product Added Successfully');
        window.location.href='product_list.php';
        </script>";

    }else{

        echo mysqli_error($conn);
    }
}

$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

$subcategory_query = "SELECT * FROM subcategories";
$subcategory_result = mysqli_query($conn, $subcategory_query);
?>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background: linear-gradient(135deg, #fdf7f2, #f8ebe1);
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    position:relative;
    overflow-x:hidden;
    padding:40px 0;
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

/* Main Container */
.container{
    max-width:1000px;
    margin:auto;
    background:rgba(255,255,255,0.96);
    border-radius:30px;
    padding:40px;
    box-shadow:0 15px 40px rgba(0,0,0,0.08);
    backdrop-filter:blur(10px);
    animation:floatCard 5s ease-in-out infinite;
}

/* Animation */
@keyframes floatCard{
    0%,100%{
        transform:translateY(0px);
    }
    50%{
        transform:translateY(-6px);
    }
}

/* Heading */
h2{
    text-align:center;
    font-size:36px;
    color:#8b5e3c;
    margin-bottom:35px;
    font-weight:700;
    letter-spacing:1px;
}

/* Form Row */
.form-row{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:5%;
    margin-bottom:20px;
}

.form-group{
    width:47%;
}

.full-width{
    width:100%;
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
    box-shadow: inset 2px 2px 6px rgba(0,0,0,0.03);
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
    background:#fff8f2;
}

.upload-box i{
    font-size:48px;
    color:#8b5e3c;
    margin-bottom:15px;
}
.upload-box p{
    color:#6b7280;
    margin-top:10px;
}

/* Image Preview */
#imgpreview{
    width:100%;
    height: 260px;
    object-fit:cover;
    border-radius:16px;
    margin-top:15px;
}

/* Button */
button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:18px;
    background:linear-gradient(135deg,#c79062,#8b5e3c);
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
    margin-top:15px;
    box-shadow:0 10px 20px rgba(199,144,98,0.35);
}

button:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 25px rgba(199,144,98,0.45);
}

/* Mobile */
@media(max-width:768px){

    .container{
        width:92%;
        padding:25px;
    }

    .form-group{
        width:100%;
    }

    h2{
        font-size:28px;
    }

}

</style>

</head>
<body>

<div class="container">

    <h2>Add Product</h2>

    <form method="POST" enctype="multipart/form-data">

        <!-- Category & Subcategory -->
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

                    <?php
                    }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <label>Select Subcategory</label>

                <select name="subcategory_id" required>

                    <option value="">-- Select Subcategory --</option>

                    <?php
                    while($sub = mysqli_fetch_assoc($subcategory_result)){
                    ?>

                    <option value="<?= $sub['id']; ?>">
                        <?= $sub['name']; ?>
                    </option>

                    <?php
                    }
                    ?>

                </select>
            </div>

        </div>

        <!-- Product Name & Price -->
        <div class="form-row">

            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" placeholder="Enter Product Name" required>
            </div>

            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" placeholder="Enter Product Price" required>
            </div>

        </div>

        <!-- Stock & Status -->
        <div class="form-row">

            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" placeholder="Enter Stock Quantity" required>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status">
                    <option value="1">🟢 Active</option>
                    <option value="0">🔴 Inactive</option>
                </select>
            </div>

        </div>

        <!-- Image & Description -->
        <div class="form-row">

            <div class="form-group">

                <label>Product Image</label>

                <div class="upload-box">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <p>Upload Product Image</p>


                    <input type="file" name="image" accept="image/*" id="imginput" hidden>

                    <img src="" id="imgpreview">

                </div>

            </div>

          

        </div>

        <!-- Submit -->
        <div class="form-row">
            <div class="form-group full-width">

                <button type="submit" name="add_product">
                    Add Product
                </button>

            </div>
        </div>

    </form>

</div>

<script>
const uploadBox = document.querySelector('.upload-box');
const fileInput = document.getElementById('imginput');

uploadBox.addEventListener('click', () => fileInput.click());

fileInput.onchange = function(){

    if(this.files[0]){
        document.getElementById('imgpreview').src = URL.createObjectURL(this.files[0]);
    }
}
</script>

</body>
</html>

