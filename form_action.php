<?php

include('connect.php');
global $conn;

/** @var mysqli $conn */

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['userResistrationbtn'])) {

    $name = mysqli_real_escape_string(
        $conn,
        trim($_POST['name'])
    );

    $email_id = mysqli_real_escape_string(
        $conn,
        trim($_POST['email'])
    );

    $mobile = mysqli_real_escape_string(
        $conn,
        trim($_POST['mobile'])
    );

    $address = mysqli_real_escape_string(
        $conn,
        trim($_POST['address'])
    );

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );


    // Validate mobile number
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        header(
            "Location: register.php?error=invalid_mobile&email=" .
            urlencode($email_id)
        );
        exit();
    }


    // Image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $file_name = basename($_FILES['image']['name']);
        $tempname = $_FILES['image']['tmp_name'];

        $folder = 'images/' . $file_name;

        move_uploaded_file($tempname, $folder);

    } else {

        header(
            "Location: register.php?error=image"
        );
        exit();
    }


    // Check whether email already exists
    $checksql = "SELECT id FROM clients WHERE email='$email_id'";

    $run = mysqli_query($conn, $checksql);


    if (mysqli_num_rows($run) == 0) {

        // Insert new user
        $sql = "INSERT INTO clients
                (name, email, mobile, password, address, image)
                VALUES
                ('$name', '$email_id', '$mobile', '$password', '$address', '$file_name')";


        if (mysqli_query($conn, $sql)) {

            header(
                "Location: register.php?success=1"
            );
            exit();

        } else {

            header(
                "Location: register.php?error=database&email=" .
                urlencode($email_id)
            );
            exit();
        }

    } else {

        // Email already exists
        header(
            "Location: register.php?error=email_exists&email=" .
            urlencode($email_id)
        );
        exit();
    }
}
?>