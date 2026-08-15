<?php
session_start();
include ("includes/db_connect.php");
global $conn;
/** @var mysqli $conn */


if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

   $checksqli = "SELECT * FROM clients WHERE email='$email' AND role='admin'";
$run = mysqli_query($conn, $checksqli);


if(mysqli_num_rows($run) > 0){

    $data = mysqli_fetch_assoc($run);

    // ✅ FIX HERE
    if(
    $password === $data['password'] ||
    md5($password) === $data['password']
){

        $_SESSION['user_name'] = $data['name'];
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        if($_SESSION['role'] == 'admin'){

            header('location:admin_panel.php');
            exit();

        } else {

            echo "<script>
                    alert('You are not admin');
                    window.location.href='admin_login.php';
                  </script>";
        }

    } else {

        echo "<script>
                alert('Wrong Password');
                window.location.href='admin_login.php';
              </script>";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="weblogo.png">

<title>Admin Login</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    width:100%;
    height:100vh;
    overflow:hidden;
    display:flex;
    justify-content:center;
    align-items:center;
    position:relative;
    /* background:#000; */
}

/* VIDEO */

.video-bg{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:-2;
}

.video-bg video{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* DARK OVERLAY */

.overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    z-index:-1;
}

/* FORM */

.form{
    width:380px;
    padding:40px 35px;
    border-radius:25px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.2);
    box-shadow:0 10px 40px rgba(0,0,0,0.4);
    animation:cardMove 3s ease-in-out infinite;
    margin-top:3%;
}

@keyframes cardMove{
    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-10px);
    }

    100%{
        transform:translateY(0px);
    }
}

.form h1{
    color:#fff;
    text-align:center;
    margin-bottom:30px;
    font-size:32px;
}

/* INPUT */

.input-box{
    position:relative;
    margin-bottom:25px;
}

.input-box input{
    width:100%;
    height:55px;
    border:none;
    outline:none;
    border-radius:14px;
    padding-left:50px;
    font-size:16px;
    background:rgba(255,255,255,0.15);
    color:#fff;
    border:1px solid rgba(255,255,255,0.2);
}

.input-box input::placeholder{
    color:#ddd;
}

.input-box i{
    position:absolute;
    left:18px;
    top:18px;
    color:#fff;
    font-size:18px;
}

/* BUTTON */

button{
    width:100%;
    height:55px;
    border:none;
    border-radius:14px;
    background:linear-gradient(45deg,#2563eb,#4f46e5);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.4s;
    position:relative;
}

button:hover{
    transform:translateY(-3px);
    background:linear-gradient(45deg,#7c3aed,#db2777);
}

.btn-text{
    transition:0.3s;
}

.icon{
    position:absolute;
    right:25px;
    top:18px;
    opacity:0;
    transition:0.3s;
}

button:hover .btn-text{
    transform:translateX(-10px);
}

button:hover .icon{
    opacity:1;
    right:18px;
}

/* RESPONSIVE */

@media(max-width:500px){

    .form{
        width:90%;
        padding:35px 25px;
    }

    .form h1{
        font-size:28px;
    }

}

</style>
</head>

<body>

<!-- VIDEO BACKGROUND -->

<div class="video-bg">

    <video autoplay muted loop playsinline>
        <!-- <source src="coffeemaking.mp4" type="video/mp4"> -->
        <source src="../images/loginvideo.mp4" type="video/mp4">
    </video>

</div>

<!-- OVERLAY -->

<div class="overlay"></div>

<!-- LOGIN FORM -->

<div class="form">

    <h1>Admin Login</h1>

    <form onsubmit="return signup()" method="POST">

        <div class="input-box">
            <i class="fa-solid fa-envelope"></i>

            <input type="email"
                   name="email"
                   id="email"
                   placeholder="Enter Email">
        </div>

        <div class="input-box">

            <i class="fa-solid fa-lock"></i>

            <input type="password"
                   name="password"
                   id="password"
                   placeholder="Enter Password">
        </div>

        <button type="submit" name="login">

            <div class="btn-text">
                Login
            </div>

            <i class="fas fa-paper-plane icon"></i>

        </button>

    </form>

</div>

<script>

function signup(){

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if(email == "" || password == ""){

        alert("All fields are mandatory");
        return false;
    }

    return true;
}

</script>

</body>
</html>