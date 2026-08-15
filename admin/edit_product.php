<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <?php
    session_start();
    include("includes/db_connect.php");

    global $conn;
    /** @var mysqli $conn */


    $id = $_GET['id'];

    $product = mysqli_query($conn, "
SELECT *
FROM products
WHERE id='$id'
");

    $data = mysqli_fetch_assoc($product);

    $cat = mysqli_query($conn, "
SELECT *
FROM categories
ORDER BY name ASC
");
    ?>

    <style>
        /*====================================
        PREMIUM EDIT PRODUCT
=====================================*/

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {

            background: linear-gradient(135deg, #eef2ff, #f8fafc, #ffffff);

            min-height: 100vh;

            overflow-x: hidden;

            position: relative;

        }

        /*==========================
BACKGROUND SHAPES
==========================*/

        .bg-shape {

            position: fixed;

            border-radius: 50%;

            filter: blur(70px);

            opacity: .35;

            z-index: -1;

            animation: floatShape 8s ease-in-out infinite;

        }

        .shape1 {

            width: 260px;
            height: 260px;

            background: #4f46e5;

            top: -70px;
            left: -60px;

        }

        .shape2 {

            width: 320px;
            height: 320px;

            background: #60a5fa;

            bottom: -100px;
            right: -80px;

            animation-delay: 2s;

        }

        .shape3 {

            width: 220px;
            height: 220px;

            background: #06b6d4;

            top: 40%;

            left: 55%;

            animation-delay: 4s;

        }

        @keyframes floatShape {

            0%,
            100% {

                transform: translateY(0);

            }

            50% {

                transform: translateY(-30px);

            }

        }

        /*==========================
MAIN WRAPPER
==========================*/

        .edit-wrapper {

            max-width: 1280px;

            margin: auto;

            padding: 45px 20px;

        }

        /*==========================
MAIN CARD
==========================*/

        .edit-card {

            background: rgba(255, 255, 255, .78);

            backdrop-filter: blur(18px);

            border: 1px solid rgba(255, 255, 255, .5);

            border-radius: 30px;

            overflow: hidden;

            box-shadow:
                0 20px 60px rgba(0, 0, 0, .12);

            animation: fadeUp .7s ease;

        }

        @keyframes fadeUp {

            from {

                opacity: 0;

                transform: translateY(30px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }

        /*==========================
HEADER
==========================*/

        .edit-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 28px 35px;

            background: linear-gradient(135deg, #2563eb, #4f46e5);

            color: #fff;

        }

        .header-left {

            display: flex;

            align-items: center;

            gap: 20px;

        }

        .icon-box {

            width: 70px;

            height: 70px;

            border-radius: 18px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: rgba(255, 255, 255, .15);

            font-size: 28px;

        }

        .edit-header h2 {

            font-size: 28px;

            font-weight: 700;

            margin: 0;

        }

        .edit-header p {

            margin-top: 5px;

            opacity: .9;

            font-size: 14px;

        }

        /*==========================
BACK BUTTON
==========================*/

        .back-btn {

            padding: 12px 22px;

            background: #fff;

            color: #2563eb;

            border-radius: 12px;

            font-weight: 600;

            text-decoration: none;

            transition: .35s;

        }

        .back-btn:hover {

            background: #111827;

            color: #fff;

            transform: translateY(-3px);

        }

        /*==========================
CONTENT
==========================*/

        form {

            padding: 35px;

        }

        /*==========================
BOXES
==========================*/

        .premium-box {

            background: #fff;

            border-radius: 22px;

            padding: 28px;

            border: 1px solid #edf2f7;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .06);

            height: 100%;

            transition: .35s;

        }

        .premium-box:hover {

            transform: translateY(-5px);

            box-shadow:
                0 20px 45px rgba(37, 99, 235, .12);

        }

        .premium-box h5 {

            margin-bottom: 25px;

            font-size: 20px;

            font-weight: 700;

            color: #111827;

            display: flex;

            align-items: center;

            gap: 12px;

        }

        /*==========================
LABELS
==========================*/

        label {

            font-weight: 600;

            margin-bottom: 10px;

            display: block;

            color: #374151;

        }

        /*==========================
INPUTS
==========================*/

        .premium-input {

            height: 56px;

            border-radius: 14px;

            border: 2px solid #e5e7eb;

            box-shadow: none;

            transition: .35s;

        }

        .premium-input:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .12);

        }

        .input-group-text {

            background: #2563eb;

            color: #fff;

            border: none;

            border-radius: 14px 0 0 14px;

            padding: 0 18px;

            font-weight: 700;

        }

        /*==========================
IMAGE
==========================*/

        .image-box {

            text-align: center;

        }

        .premium-preview {

            width: 100%;

            height: 320px;

            object-fit: cover;

            border-radius: 22px;

            border: 5px solid #fff;

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .18);

            transition: .45s;

        }

        .premium-preview:hover {

            transform: scale(1.03);

        }

        .upload-box {

            margin-top: 25px;

            padding: 30px;

            border: 2px dashed #2563eb;

            border-radius: 18px;

            cursor: pointer;

            transition: .35s;

        }

        .upload-box:hover {

            background: #eff6ff;

        }

        .upload-box i {

            font-size: 45px;

            color: #2563eb;

            margin-bottom: 15px;

            display: block;

        }

        .upload-box h6 {

            font-weight: 700;

            margin-bottom: 6px;

        }

        .upload-box p {

            margin: 0;

            color: #6b7280;

            font-size: 14px;

        }

        /*==========================
BUTTON
==========================*/

        .premium-btn {

            height: 58px;

            border: none;

            border-radius: 15px;

            background: linear-gradient(135deg, #2563eb, #4f46e5);

            font-size: 17px;

            font-weight: 700;

            color: #fff;

            transition: .35s;

        }

        .premium-btn:hover {

            transform: translateY(-4px);

            box-shadow:
                0 18px 35px rgba(37, 99, 235, .35);

        }

        /*==========================
RESPONSIVE
==========================*/

        @media(max-width:992px) {

            .edit-header {

                flex-direction: column;

                gap: 20px;

                text-align: center;

            }

            .header-left {

                flex-direction: column;

            }

            form {

                padding: 20px;

            }

        }
    </style>

</head>

<body>

    <div class="bg-shape shape1"></div>
    <div class="bg-shape shape2"></div>
    <div class="bg-shape shape3"></div>

    <div class="edit-wrapper">

        <div class="edit-card">

            <!-- Header -->

            <div class="edit-header">

                <div class="header-left">

                    <div class="icon-box">

                        <i class="fas fa-box-open"></i>

                    </div>

                    <div>

                        <h2>Edit Product</h2>

                        <p>
                            Update product details, pricing, inventory and image.
                        </p>

                    </div>

                </div>

                <a href="admin_panel.php" class="back-btn">

                    <i class="fas fa-arrow-left"></i>

                    Back

                </a>

            </div>

            <form
                action="editpro_action.php"
                method="POST"
                enctype="multipart/form-data">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $data['id']; ?>">

                <div class="row g-4">

                    <!-- LEFT -->

                    <div class="col-lg-7">

                        <div class="premium-box">

                            <h5>

                                <i class="fas fa-pen"></i>

                                Basic Information

                            </h5>

                            <div class="mb-4">

                                <label>

                                    Category

                                </label>

                                <select
                                    class="form-select premium-input"
                                    name="category_id"
                                    required>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($cat)) {
                                    ?>

                                        <option
                                            value="<?php echo $row['id']; ?>"

                                            <?php
                                            if ($data['category_id'] == $row['id'])
                                                echo "selected";
                                            ?>>

                                            <?php echo $row['name']; ?>

                                        </option>

                                    <?php
                                    }
                                    ?>

                                </select>

                            </div>

                            <div class="mb-4">

                                <label>

                                    Product Name

                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">

                                        <i class="fas fa-coffee"></i>

                                    </span>

                                    <input
                                        type="text"
                                        class="form-control premium-input"
                                        name="name"
                                        value="<?php echo $data['name']; ?>"
                                        required>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="mb-4">

                                        <label>

                                            Price

                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">

                                                ₹

                                            </span>

                                            <input
                                                type="number"
                                                class="form-control premium-input"
                                                name="price"
                                                value="<?php echo $data['price']; ?>"
                                                required>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="mb-4">

                                        <label>

                                            Stock

                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">

                                                <i class="fas fa-layer-group"></i>

                                            </span>

                                            <input
                                                type="number"
                                                class="form-control premium-input"
                                                name="stock"
                                                value="<?php echo $data['stock']; ?>"
                                                required>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label>

                                    Status

                                </label>

                                <select
                                    class="form-select premium-input"
                                    name="status">

                                    <option value="1"
                                        <?php if ($data['status'] == 1) echo "selected"; ?>>

                                        🟢 Active

                                    </option>

                                    <option value="0"
                                        <?php if ($data['status'] == 0) echo "selected"; ?>>

                                        🔴 Inactive

                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->

                    <div class="col-lg-5">

                        <div class="premium-box image-box">

                            <h5>

                                <i class="fas fa-image"></i>

                                Product Image

                            </h5>

                            <img
                                src="../images/<?php echo $data['image']; ?>"
                                id="imgpreview"
                                class="premium-preview">

                            <label
                                for="imginput"
                                class="upload-box">

                                <i class="fas fa-cloud-upload-alt"></i>

                                <h6>

                                    Choose New Image

                                </h6>

                                <p>

                                    JPG • PNG • WEBP

                                </p>

                            </label>

                            <input
                                type="file"
                                name="image"
                                id="imginput"
                                accept="image/*"
                                hidden>

                            <div class="d-grid mt-4">

                                <button
                                    type="submit"
                                    name="updateBtn"
                                    class="btn premium-btn">

                                    <i class="fas fa-save"></i>

                                    Update Product

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>
        /*==========================
LIVE IMAGE PREVIEW
==========================*/

        const input = document.getElementById("imginput");
        const preview = document.getElementById("imgpreview");

        input.addEventListener("change", function() {

            if (this.files && this.files[0]) {

                preview.style.opacity = "0";

                setTimeout(function() {

                    preview.src = URL.createObjectURL(input.files[0]);

                    preview.style.opacity = "1";

                    preview.style.transform = "scale(1.04)";

                    setTimeout(function() {

                        preview.style.transform = "scale(1)";

                    }, 250);

                }, 200);

            }

        });


        /*==========================
        DRAG & DROP
        ==========================*/

        const uploadBox = document.querySelector(".upload-box");

        uploadBox.addEventListener("dragover", function(e) {

            e.preventDefault();

            uploadBox.style.background = "#eef5ff";

            uploadBox.style.borderColor = "#2563eb";

        });

        uploadBox.addEventListener("dragleave", function() {

            uploadBox.style.background = "";

            uploadBox.style.borderColor = "#2563eb";

        });

        uploadBox.addEventListener("drop", function(e) {

            e.preventDefault();

            uploadBox.style.background = "";

            uploadBox.style.borderColor = "#2563eb";

            const files = e.dataTransfer.files;

            if (files.length) {

                input.files = files;

                preview.src = URL.createObjectURL(files[0]);

            }

        });


        /*==========================
        BUTTON LOADING
        ==========================*/

        const form = document.querySelector("form");

        const btn = document.querySelector(".premium-btn");

        form.addEventListener("submit", function() {

            btn.disabled = true;

            btn.innerHTML = `
    <span class="spinner-border spinner-border-sm"></span>
    Updating Product...
    `;

        });


        /*==========================
        INPUT ANIMATION
        ==========================*/

        document.querySelectorAll(".premium-input").forEach(function(input) {

            input.addEventListener("focus", function() {

                this.parentElement.style.transform = "translateY(-2px)";

            });

            input.addEventListener("blur", function() {

                this.parentElement.style.transform = "translateY(0px)";

            });

        });


        /*==========================
        CARD HOVER EFFECT
        ==========================*/

        document.querySelectorAll(".premium-box").forEach(function(card) {

            card.addEventListener("mousemove", function(e) {

                const rect = card.getBoundingClientRect();

                const x = e.clientX - rect.left;

                const y = e.clientY - rect.top;

                card.style.background =
                    `radial-gradient(circle at ${x}px ${y}px,
        rgba(37,99,235,.08),
        #fff 60%)`;

            });

            card.addEventListener("mouseleave", function() {

                card.style.background = "#fff";

            });

        });


        /*==========================
        IMAGE PARALLAX
        ==========================*/

        preview.addEventListener("mousemove", function(e) {

            const rect = this.getBoundingClientRect();

            const x = (e.clientX - rect.left) / rect.width;

            const y = (e.clientY - rect.top) / rect.height;

            this.style.transform =
                `rotateY(${(x-.5)*10}deg)
     rotateX(${(.5-y)*10}deg)
     scale(1.03)`;

        });

        preview.addEventListener("mouseleave", function() {

            this.style.transform = "rotateY(0) rotateX(0) scale(1)";

        });


        /*==========================
        PAGE LOAD ANIMATION
        ==========================*/

        window.addEventListener("load", function() {

            document.querySelector(".edit-card").style.opacity = "0";

            document.querySelector(".edit-card").style.transform = "translateY(40px)";

            setTimeout(function() {

                document.querySelector(".edit-card").style.transition = ".8s";

                document.querySelector(".edit-card").style.opacity = "1";

                document.querySelector(".edit-card").style.transform = "translateY(0)";

            }, 100);

        });
    </script>

</body>

</html>