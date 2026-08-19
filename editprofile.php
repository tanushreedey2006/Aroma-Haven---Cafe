

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profile</title>
    <link rel="icon" type="image/png" href="weblogo.png">

<link rel="stylesheet" href="coffee.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
<link rel="stylesheet" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"/>
<?php
session_start();
include("connect.php");
global $conn;
/** @var mysqli $conn */


if(!isset($_SESSION['user_email'])){
    header("Location: register.php");
    exit();
}

$email = $_SESSION['user_email'];

$query = "SELECT * FROM clients WHERE email='$email'";
$run = mysqli_query($conn,$query);
$row = mysqli_fetch_array($run);

$initial = strtoupper(substr($row['name'],0,1));

if(isset($_POST['update'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $mobile = mysqli_real_escape_string($conn,$_POST['mobile']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $update = "UPDATE clients 
               SET name='$name',
                   mobile='$mobile',
                   address='$address'
               WHERE email='$email'";

    $run_update = mysqli_query($conn,$update);

   if($run_update){ 
    $_SESSION['user_name'] = $name; 

    echo "<script>
        window.location.href='editprofile.php?updated=1';
    </script>";

    exit();
}

}
?>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:linear-gradient(135deg,#f8efe5,#f4d7b5);
    min-height:100vh;
    font-family:Arial;
    overflow-x:hidden;
}

/* MAIN BOX */

.edit-container{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:120px 20px 50px;
}

/* CARD */

.edit-card{
    width:100%;
    max-width:950px;
    background:#fff;
    border-radius:35px;
    overflow:hidden;
    display:flex;
    box-shadow:0 20px 60px rgba(0,0,0,0.12);
    animation:fadeUp 1s ease;
}

/* LEFT */

.left-side{
    width:38%;
    background:linear-gradient(180deg,#5b2c06,#8b4513);
    padding:50px 30px;
    color:#fff;
    position:relative;
    overflow:hidden;
}

.left-side::before{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:rgba(255,255,255,0.07);
    border-radius:50%;
    top:-80px;
    left:-80px;
}

.left-side::after{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    background:rgba(255,255,255,0.06);
    border-radius:50%;
    bottom:-60px;
    right:-60px;
}

.profile-box{
    position:relative;
    z-index:2;
    text-align:center;
}

.avatar{
    width:110px;
    height:110px;
    border-radius:50%;
    background:#fff;
    color:#5b2c06;
    font-size:45px;
    font-weight:bold;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:auto;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    animation:pulse 2s infinite;
}

.profile-box h2{
    margin-top:20px;
    font-size:30px;
    font-weight:bold;
}

.profile-box p{
    margin-top:10px;
    color:#f7d9b8;
    font-size:15px;
}

/* RIGHT */

.right-side{
    width:62%;
    padding:50px;
    background:#fff;
}

.right-side h1{
    color:#5b2c06;
    font-size:38px;
    font-weight:bold;
    margin-bottom:10px;
}

.right-side p{
    color:#777;
    margin-bottom:35px;
}

/* FORM */

.input-group{
    margin-bottom:25px;
    position:relative;
}

.input-group label{
    font-weight:bold;
    color:#5b2c06;
    margin-bottom:10px;
    display:block;
}

.input-group i{
    position:absolute;
    left:18px;
    top:50px;
    color:#8b4513;
    font-size:18px;
}

.input-group input,
.input-group textarea{
    width:100%;
    padding:15px 18px 15px 50px;
    border-radius:15px;
    border:2px solid #eee;
    outline:none;
    font-size:16px;
    transition:0.3s;
    background:#fafafa;
}

.input-group textarea{
    min-height:120px;
    resize:none;
}

.input-group input:focus,
.input-group textarea:focus{
    border-color:#8b4513;
    background:#fff;
    box-shadow:0 0 15px rgba(139,69,19,0.15);
    transform:scale(1.01);
}

/* BUTTON */

.update-btn{
    width:100%;
    border:none;
    padding:16px;
    border-radius:50px;
    background:linear-gradient(135deg,#5b2c06,#8b4513);
    color:#fff;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.4s;
    margin-top:10px;
    position:relative;
    overflow:hidden;
}

.update-btn:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 25px rgba(91,44,6,0.25);
}

.update-btn::before{
    content:'';
    position:absolute;
    width:0;
    height:100%;
    background:rgba(255,255,255,0.2);
    left:0;
    top:0;
    transition:0.5s;
}

.update-btn:hover::before{
    width:100%;
}

/* ANIMATION */

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(50px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

@keyframes pulse{
    0%{
        transform:scale(1);
    }

    50%{
        transform:scale(1.06);
    }

    100%{
        transform:scale(1);
    }
}

/* RESPONSIVE */

@media(max-width:900px){

    .edit-card{
        flex-direction:column;
    }

    .left-side,
    .right-side{
        width:100%;
    }

    .right-side{
        padding:35px 25px;
    }

}

/* =========================================
   CUSTOM SUCCESS CARD
========================================= */

.success-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.55);
    backdrop-filter:blur(8px);
    -webkit-backdrop-filter:blur(8px);

    display:none;

    justify-content:center;
    align-items:center;

    z-index:99999;
}

.success-card{
    width:420px;
    max-width:90%;

    background:rgba(255,255,255,0.97);

    border-radius:30px;

    padding:40px 30px;

    text-align:center;

    box-shadow:
        0 25px 70px rgba(0,0,0,0.3);

    animation:successCardShow .45s ease;
}

.success-icon{
    width:85px;
    height:85px;

    margin:0 auto 20px;

    border-radius:50%;

    background:linear-gradient(
        135deg,
        #5b2c06,
        #8b4513
    );

    color:white;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:40px;

    box-shadow:
        0 10px 30px rgba(91,44,6,0.35);
}

.success-card h2{
    color:#5b2c06;
    font-size:28px;
    font-weight:700;

    margin-bottom:10px;
}

.success-card p{
    color:#777;
    font-size:16px;

    margin-bottom:25px;
}

.success-card button{
    border:none;

    padding:13px 40px;

    border-radius:50px;

    background:
        linear-gradient(
            135deg,
            #5b2c06,
            #8b4513
        );

    color:white;

    font-size:16px;
    font-weight:bold;

    cursor:pointer;

    transition:.3s;
}

.success-card button:hover{
    transform:translateY(-3px);

    box-shadow:
        0 10px 25px rgba(91,44,6,0.3);
}

@keyframes successCardShow{

    from{
        opacity:0;
        transform:scale(.7) translateY(30px);
    }

    to{
        opacity:1;
        transform:scale(1) translateY(0);
    }

}

</style>
</head>

<body>

<div class="edit-container">

    <div class="edit-card">

        <!-- LEFT -->

        <div class="left-side">

            <div class="profile-box">

                <div class="avatar">
                    <?php echo $initial; ?>
                </div>

                <h2><?php echo $row['name']; ?></h2>

                <p>
                    Welcome back to Aroma Haven ☕
                </p>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="right-side">

            <h1>Edit Profile</h1>

            <p>
                Update your personal information here.
            </p>

            <form method="POST">

                <div class="input-group">

                    <label>Full Name</label>

                    <i class="fa fa-user"></i>

                    <input 
                    type="text" 
                    name="name"
                    value="<?php echo $row['name']; ?>"
                    required>

                </div>

                <div class="input-group">

                    <label>Email Address</label>

                    <i class="fa fa-envelope"></i>

                    <input 
                    type="email"
                    value="<?php echo $row['email']; ?>"
                    readonly>

                </div>

                <div class="input-group">

                    <label>Phone Number</label>

                    <i class="fa fa-phone"></i>

                    <input 
                    type="text"
                    name="mobile"
                    value="<?php echo $row['mobile']; ?>"
                    required>

                </div>

                <div class="input-group">

                    <label>Address</label>

                    <i class="fa fa-location-dot"></i>

                    <textarea 
                    name="address"
                    required><?php echo $row['address']; ?></textarea>

                </div>

                <button type="submit" name="update" class="update-btn">
                    Update Profile
                </button>

            </form>

        </div>

    </div>

</div>

<!-- SUCCESS CARD -->
<div id="successOverlay" class="success-overlay">
    
    <div class="success-card">
        
        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2>Profile Updated!</h2>

        <p>
            Your profile has been updated successfully 🎉
        </p>

        <button type="button" onclick="continueToProfile()">
            Continue
        </button>

    </div>

</div>

<script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

<script>
    function continueToProfile(){

    window.location.href = "userprofile.php";

}

<?php if(isset($_GET['updated']) && $_GET['updated'] == '1'): ?>

document.addEventListener("DOMContentLoaded", function(){

    document.getElementById("successOverlay").style.display = "flex";

});

<?php endif; ?>
</script>


</body>
</html>