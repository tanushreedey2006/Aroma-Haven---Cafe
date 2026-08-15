
<?php

session_start();

include("includes/db_connect.php");

global $conn;
/** @var mysqli $conn */


// ==========================
// GET SUBCATEGORY ID
// ==========================

$id = $_GET['id'];


// ==========================
// FETCH SUBCATEGORY DATA
// ==========================

$sql = "
    SELECT *
    FROM subcategories
    WHERE id='$id'
";

$run = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($run);


// ==========================
// FETCH CATEGORIES
// ==========================

$cat_sql = "
    SELECT *
    FROM categories
    ORDER BY name ASC
";

$cat_run = mysqli_query($conn, $cat_sql);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Edit Subcategory</title>

    <link rel="icon"
        type="image/png"
        href="weblogo.png">

    <link rel="stylesheet"
        href="../assets/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- FONT AWESOME -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <style>

        /*====================================
        PREMIUM EDIT SUBCATEGORY
        ====================================*/


        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

            font-family: 'Poppins', sans-serif;

        }


        body {

            background:
                linear-gradient(
                    135deg,
                    #eef2ff,
                    #f8fafc,
                    #ffffff
                );

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

            animation:
                floatShape 8s
                ease-in-out
                infinite;

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

                transform:
                    translateY(0);

            }

            50% {

                transform:
                    translateY(-30px);

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

            background:
                rgba(
                    255,
                    255,
                    255,
                    .78
                );

            backdrop-filter:
                blur(18px);

            border:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .5
                );

            border-radius: 30px;

            overflow: hidden;

            box-shadow:
                0 20px 60px
                rgba(0, 0, 0, .12);

            animation:
                fadeUp .7s ease;

        }


        @keyframes fadeUp {

            from {

                opacity: 0;

                transform:
                    translateY(30px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        /*==========================
        HEADER
        ==========================*/


        .edit-header {

            display: flex;

            justify-content:
                space-between;

            align-items: center;

            padding: 28px 35px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

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

            background:
                rgba(
                    255,
                    255,
                    255,
                    .15
                );

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

            transform:
                translateY(-3px);

        }


        /*==========================
        FORM
        ==========================*/


        form {

            padding: 35px;

        }


        /*==========================
        PREMIUM BOX
        ==========================*/


        .premium-box {

            background: #fff;

            border-radius: 22px;

            padding: 28px;

            border:
                1px solid #edf2f7;

            box-shadow:
                0 10px 30px
                rgba(0, 0, 0, .06);

            height: 100%;

            transition: .35s;

        }


        .premium-box:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 20px 45px
                rgba(
                    37,
                    99,
                    235,
                    .12
                );

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
        LABEL
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

            border:
                2px solid #e5e7eb;

            box-shadow: none;

            transition: .35s;

        }


        .premium-input:focus {

            border-color: #2563eb;

            box-shadow:
                0 0 0 4px
                rgba(
                    37,
                    99,
                    235,
                    .12
                );

        }


        textarea.premium-input {

            height: 150px;

            resize: vertical;

            padding-top: 15px;

        }


        /*==========================
        INPUT GROUP
        ==========================*/


        .input-group-text {

            background: #2563eb;

            color: #fff;

            border: none;

            border-radius:
                14px 0 0 14px;

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
                0 15px 35px
                rgba(0, 0, 0, .18);

            transition: .45s;

        }


        .premium-preview:hover {

            transform:
                scale(1.03);

        }


        /*==========================
        UPLOAD BOX
        ==========================*/


        .upload-box {

            margin-top: 25px;

            padding: 30px;

            border:
                2px dashed #2563eb;

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

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            font-size: 17px;

            font-weight: 700;

            color: #fff;

            transition: .35s;

        }


        .premium-btn:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0 18px 35px
                rgba(
                    37,
                    99,
                    235,
                    .35
                );

        }


        /*==========================
        RESPONSIVE
        ==========================*/


        @media(max-width: 992px) {

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


        @media(max-width: 576px) {

            .edit-wrapper {

                padding:
                    20px 10px;

            }


            .edit-card {

                border-radius: 20px;

            }


            .edit-header {

                padding:
                    25px 20px;

            }


            .edit-header h2 {

                font-size: 23px;

            }


            .icon-box {

                width: 60px;

                height: 60px;

                font-size: 24px;

            }


            .premium-box {

                padding: 20px;

            }


            form {

                padding: 15px;

            }


            .back-btn {

                width: 100%;

                text-align: center;

            }


            .premium-preview {

                height: 250px;

            }

        }

    </style>

</head>


<body>


    <!-- BACKGROUND SHAPES -->

    <div class="bg-shape shape1"></div>

    <div class="bg-shape shape2"></div>

    <div class="bg-shape shape3"></div>


    <!-- MAIN -->

    <div class="edit-wrapper">


        <div class="edit-card">


            <!-- ==========================
            HEADER
            =========================== -->

            <div class="edit-header">


                <div class="header-left">


                    <div class="icon-box">

                        <i class="fas fa-layer-group"></i>

                    </div>


                    <div>

                        <h2>

                            Edit Subcategory

                        </h2>


                        <p>

                            Update subcategory
                            details, description
                            and image.

                        </p>

                    </div>


                </div>


                <a
                    href="admin_panel.php"
                    class="back-btn">

                    <i
                        class="fas fa-arrow-left">
                    </i>

                    Back

                </a>


            </div>


            <!-- ==========================
            FORM
            =========================== -->

            <form
                action="edisubcate_action.php"
                method="POST"
                enctype="multipart/form-data">


                <!-- HIDDEN ID -->

                <input
                    type="hidden"
                    name="id"
                    value="<?php
                        echo $data['id'];
                    ?>">


                <div class="row g-4">


                    <!-- ==========================
                    LEFT SIDE
                    =========================== -->


                    <div class="col-lg-7">


                        <div
                            class="premium-box">


                            <h5>

                                <i
                                    class="fas fa-pen">
                                </i>

                                Subcategory Information

                            </h5>


                            <!-- CATEGORY -->

                            <div class="mb-4">


                                <label>

                                    Select Category

                                </label>


                                <select
                                    class="form-select premium-input"
                                    name="category_id"
                                    required>


                                    <option
                                        value="">

                                        -- Select Category --

                                    </option>


                                    <?php

                                    while (
                                        $catRow =
                                        mysqli_fetch_assoc(
                                            $cat_run
                                        )
                                    ) {

                                    ?>


                                        <option
                                            value="<?php
                                                echo $catRow['id'];
                                            ?>"

                                            <?php

                                            if (
                                                $data[
                                                    'category_id'
                                                ]
                                                ==
                                                $catRow[
                                                    'id'
                                                ]
                                            ) {

                                                echo "selected";

                                            }

                                            ?>>

                                            <?php

                                            echo htmlspecialchars(
                                                $catRow['name']
                                            );

                                            ?>

                                        </option>


                                    <?php

                                    }

                                    ?>


                                </select>


                            </div>


                            <!-- SUBCATEGORY NAME -->

                            <div class="mb-4">


                                <label>

                                    Subcategory Name

                                </label>


                                <div
                                    class="input-group">


                                    <span
                                        class="input-group-text">

                                        <i
                                            class="fas fa-layer-group">
                                        </i>

                                    </span>


                                    <input
                                        type="text"
                                        class="form-control premium-input"
                                        name="name"
                                        id="nameInput"
                                        value="<?php
                                            echo htmlspecialchars(
                                                $data['name']
                                            );
                                        ?>"
                                        required>


                                </div>


                            </div>


                            <!-- DESCRIPTION -->

                            <div class="mb-4">


                                <label>

                                    Description

                                </label>


                                <textarea
                                    class="form-control premium-input"
                                    name="descri"
                                    id="descriptionInput"
                                    placeholder="Enter subcategory description..."><?php

                                    echo htmlspecialchars(
                                        $data['descri']
                                    );

                                    ?></textarea>


                            </div>


                            <!-- STATUS -->

                            <div class="mb-3">


                                <label>

                                    Status

                                </label>


                                <select
                                    class="form-select premium-input"
                                    name="status">


                                    <option
                                        value="1"

                                        <?php

                                        if (
                                            $data[
                                                'status'
                                            ] == 1
                                        ) {

                                            echo "selected";

                                        }

                                        ?>>

                                        🟢 Active

                                    </option>


                                    <option
                                        value="0"

                                        <?php

                                        if (
                                            $data[
                                                'status'
                                            ] == 0
                                        ) {

                                            echo "selected";

                                        }

                                        ?>>

                                        🔴 Inactive

                                    </option>


                                </select>


                            </div>


                        </div>


                    </div>


                    <!-- ==========================
                    RIGHT SIDE
                    =========================== -->


                    <div class="col-lg-5">


                        <div
                            class="premium-box image-box">


                            <h5>

                                <i
                                    class="fas fa-image">
                                </i>

                                Subcategory Image

                            </h5>


                            <!-- CURRENT IMAGE -->


                            <?php

                            if (
                                !empty(
                                    $data['image']
                                )
                            ) {

                                ?>

                                <img
                                    src="../images/<?php
                                        echo htmlspecialchars(
                                            $data['image']
                                        );
                                    ?>"
                                    id="imgpreview"
                                    class="premium-preview"
                                    alt="Subcategory Image">

                            <?php

                            } else {

                                ?>

                                <div
                                    id="noImage"
                                    class="premium-preview d-flex align-items-center justify-content-center bg-light">

                                    <i
                                        class="fas fa-image fa-4x text-secondary">
                                    </i>

                                </div>

                            <?php

                            }

                            ?>


                            <!-- UPLOAD BOX -->


                            <label
                                for="imginput"
                                class="upload-box">


                                <i
                                    class="fas fa-cloud-upload-alt">
                                </i>


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


                            <!-- UPDATE BUTTON -->


                            <div
                                class="d-grid mt-4">


                                <button
                                    type="submit"
                                    name="updateBtn"
                                    class="btn premium-btn"
                                    id="updateBtn">


                                    <i
                                        class="fas fa-save">
                                    </i>

                                    Update Subcategory


                                </button>


                            </div>


                        </div>


                    </div>


                </div>


            </form>


        </div>


    </div>


    <!-- ==========================
    JAVASCRIPT
    =========================== -->


    <script>


        /*================================
        LIVE IMAGE PREVIEW
        =================================*/


        const input =
            document.getElementById(
                "imginput"
            );


        const preview =
            document.getElementById(
                "imgpreview"
            );


        const uploadBox =
            document.querySelector(
                ".upload-box"
            );


        input.addEventListener(
            "change",
            function () {


                if (
                    this.files &&
                    this.files[0]
                ) {


                    const file =
                        this.files[0];


                    /* CHECK IMAGE */

                    if (
                        !file.type.startsWith(
                            "image/"
                        )
                    ) {

                        alert(
                            "Please select a valid image."
                        );

                        input.value = "";

                        return;

                    }


                    const imageURL =
                        URL.createObjectURL(
                            file
                        );


                    /* IF OLD IMAGE DOES NOT EXIST */

                    let imageElement =
                        document.getElementById(
                            "imgpreview"
                        );


                    if (!imageElement) {


                        const noImage =
                            document.getElementById(
                                "noImage"
                            );


                        imageElement =
                            document.createElement(
                                "img"
                            );


                        imageElement.id =
                            "imgpreview";


                        imageElement.className =
                            "premium-preview";


                        imageElement.alt =
                            "Subcategory Image";


                        noImage.replaceWith(
                            imageElement
                        );

                    }


                    /* ANIMATION */

                    imageElement.style.opacity =
                        "0";


                    setTimeout(
                        function () {


                            imageElement.src =
                                imageURL;


                            imageElement.style.opacity =
                                "1";


                            imageElement.style.transform =
                                "scale(1.04)";


                            setTimeout(
                                function () {

                                    imageElement.style.transform =
                                        "scale(1)";

                                },
                                250
                            );


                        },
                        150
                    );


                }

            }
        );


        /*================================
        DRAG & DROP
        =================================*/


        uploadBox.addEventListener(
            "dragover",
            function (e) {

                e.preventDefault();

                uploadBox.style.background =
                    "#eef5ff";

                uploadBox.style.borderColor =
                    "#2563eb";

            }
        );


        uploadBox.addEventListener(
            "dragleave",
            function () {

                uploadBox.style.background =
                    "";

                uploadBox.style.borderColor =
                    "#2563eb";

            }
        );


        uploadBox.addEventListener(
            "drop",
            function (e) {


                e.preventDefault();


                uploadBox.style.background =
                    "";

                uploadBox.style.borderColor =
                    "#2563eb";


                const files =
                    e.dataTransfer.files;


                if (
                    files.length
                ) {


                    const file =
                        files[0];


                    if (
                        !file.type.startsWith(
                            "image/"
                        )
                    ) {

                        alert(
                            "Please drop a valid image."
                        );

                        return;

                    }


                    /* SET FILE */

                    input.files =
                        files;


                    /* PREVIEW */

                    let imageElement =
                        document.getElementById(
                            "imgpreview"
                        );


                    if (!imageElement) {


                        const noImage =
                            document.getElementById(
                                "noImage"
                            );


                        imageElement =
                            document.createElement(
                                "img"
                            );


                        imageElement.id =
                            "imgpreview";


                        imageElement.className =
                            "premium-preview";


                        imageElement.alt =
                            "Subcategory Image";


                        noImage.replaceWith(
                            imageElement
                        );

                    }


                    imageElement.src =
                        URL.createObjectURL(
                            file
                        );

                }


            }
        );


        /*================================
        LIVE NAME PREVIEW
        =================================*/


        const nameInput =
            document.getElementById(
                "nameInput"
            );


        nameInput.addEventListener(
            "input",
            function () {

                document.title =
                    "Edit Subcategory - "
                    +
                    (
                        this.value ||
                        "Subcategory"
                    );

            }
        );


        /*================================
        INPUT ANIMATION
        =================================*/


        document
            .querySelectorAll(
                ".premium-input"
            )
            .forEach(
                function (input) {


                    input.addEventListener(
                        "focus",
                        function () {

                            this.parentElement.style
                                .transform =
                                "translateY(-2px)";

                        }
                    );


                    input.addEventListener(
                        "blur",
                        function () {

                            this.parentElement.style
                                .transform =
                                "translateY(0px)";

                        }
                    );


                }
            );


        /*================================
        CARD HOVER EFFECT
        =================================*/


        document
            .querySelectorAll(
                ".premium-box"
            )
            .forEach(
                function (card) {


                    card.addEventListener(
                        "mousemove",
                        function (e) {


                            const rect =
                                card.getBoundingClientRect();


                            const x =
                                e.clientX -
                                rect.left;


                            const y =
                                e.clientY -
                                rect.top;


                            card.style.background =
                                `radial-gradient(
                                    circle at ${x}px ${y}px,
                                    rgba(37,99,235,.08),
                                    #fff 60%
                                )`;


                        }
                    );


                    card.addEventListener(
                        "mouseleave",
                        function () {

                            card.style.background =
                                "#fff";

                        }
                    );


                }
            );


        /*================================
        BUTTON LOADING
        =================================*/


        const form =
            document.querySelector(
                "form"
            );


        const btn =
            document.getElementById(
                "updateBtn"
            );


        form.addEventListener(
            "submit",
            function () {


                btn.disabled =
                    true;


                btn.innerHTML = `
                    <span
                        class="spinner-border spinner-border-sm">
                    </span>

                    Updating Subcategory...
                `;


            }
        );


        /*================================
        PAGE LOAD ANIMATION
        =================================*/


        window.addEventListener(
            "load",
            function () {


                const card =
                    document.querySelector(
                        ".edit-card"
                    );


                card.style.opacity =
                    "0";


                card.style.transform =
                    "translateY(40px)";


                setTimeout(
                    function () {


                        card.style.transition =
                            ".8s";


                        card.style.opacity =
                            "1";


                        card.style.transform =
                            "translateY(0)";


                    },
                    100
                );


            }
        );


    </script>


</body>

</html>

