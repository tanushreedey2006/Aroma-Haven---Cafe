
<?php

include "connect.php";
global $conn;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['usersigninbtn'])
) {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check empty fields
    if ($email === '' || $password === '') {

        echo "<script>
            alert('Please enter email and password.');
            window.location.href='register.php';
        </script>";
        exit;
    }

    // Get user
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, email, password, role
         FROM clients
         WHERE email = ?
         LIMIT 1"
    );

    if (!$stmt) {
        die("Database error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Email does not exist
    if (!$result || mysqli_num_rows($result) === 0) {

        echo "<script>
            alert('Email does not exist.');
            window.location.href='register.php';
        </script>";
        exit;
    }

    $data = mysqli_fetch_assoc($result);

    $storedPassword = $data['password'];
    $passwordMatched = false;

    /*
    =====================================================
    1. CHECK NEW BCRYPT PASSWORD
    =====================================================
    */

    if (
        !empty($storedPassword) &&
        password_get_info($storedPassword)['algo'] !== 0
    ) {

        if (password_verify($password, $storedPassword)) {
            $passwordMatched = true;
        }
    }

    /*
    =====================================================
    2. CHECK OLD MD5 PASSWORD
    =====================================================
    */

    if (
        !$passwordMatched &&
        strlen($storedPassword) === 32 &&
        ctype_xdigit($storedPassword)
    ) {

        if (md5($password) === $storedPassword) {

            $passwordMatched = true;

            /*
            IMPORTANT:
            Automatically convert old MD5 password
            into secure bcrypt password.
            */

            $newHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $updateStmt = mysqli_prepare(
                $conn,
                "UPDATE clients
                 SET password = ?
                 WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $updateStmt,
                "si",
                $newHash,
                $data['id']
            );

            mysqli_stmt_execute($updateStmt);

            mysqli_stmt_close($updateStmt);
        }
    }

    /*
    =====================================================
    3. PASSWORD RESULT
    =====================================================
    */

    if ($passwordMatched) {

        $_SESSION['user_id'] = $data['id'];
        $_SESSION['user_name'] = $data['name'];
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['user_role'] = $data['role'];

        header("Location: dashboard.php");
        exit;

    } else {

        echo "<script>
            alert('Password does not match.');
            window.location.href='register.php';
        </script>";
        exit;
    }

    mysqli_stmt_close($stmt);
}

?>

