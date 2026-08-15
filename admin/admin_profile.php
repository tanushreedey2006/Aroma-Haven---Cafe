
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Profile</title>
<link rel="icon" type="image/png" href="weblogo.png">
<link rel="stylesheet" href="admin_panel.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<?php
session_start();
include("includes/db_connect.php");
global $conn;
/** @var mysqli $conn */

$email = $_SESSION['user_email'] ?? null;

if(!$email){
    header("Location: login.php");
    exit;
}

$query = mysqli_query($conn,
"SELECT * FROM clients WHERE email='$email' LIMIT 1");

$admin = mysqli_fetch_assoc($query);

$img = !empty($admin['image'])
    ? "../images/" . $admin['image']
    : "../images/default-user.png";
?>
<style>

:root{

    --gold:#d4af37;
    --blue:#2563eb;
    --dark:#0f172a;
    --glass:rgba(255,255,255,.75);

}



*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}



body{

    font-family:'Inter',sans-serif;

    min-height:100vh;

    background:


    radial-gradient(circle at top left,
    rgba(212,175,55,.25),
    transparent 35%),


    radial-gradient(circle at bottom right,
    rgba(37,99,235,.18),
    transparent 40%),


    linear-gradient(
    135deg,
    #f8fafc,
    #e2e8f0
    );


    color:#0f172a;


    overflow-x:hidden;

    animation:bg 10s infinite alternate;


}




@keyframes bg{


from{

background-position:left;

}


to{

background-position:right;

}


}



/* floating glow */


body::before{


content:"";

position:fixed;


width:500px;

height:500px;


background:linear-gradient(
135deg,
#d4af37,
#2563eb
);


filter:blur(130px);


opacity:.15;


top:-150px;

right:-150px;


animation:float 8s infinite alternate;


}



@keyframes float{


from{

transform:translate(0);

}


to{

transform:translate(-80px,80px);

}


}





/* MAIN */


.profile-container{


max-width:1200px;


margin:60px auto;


padding:20px;


display:grid;


grid-template-columns:350px 1fr;


gap:30px;


animation:page .8s ease;


}



@keyframes page{


from{

opacity:0;

transform:translateY(40px);

}


to{

opacity:1;

}


}





/* GLASS CARDS */


.profile-card,
.profile-details{


background:

var(--glass);


backdrop-filter:blur(25px);


border:

1px solid rgba(255,255,255,.7);


border-radius:35px;



box-shadow:


0 30px 80px rgba(15,23,42,.15);



transition:.4s;


}



.profile-card:hover,
.profile-details:hover{


transform:translateY(-8px);


box-shadow:


0 40px 100px rgba(15,23,42,.25);


}




/* LEFT */


.profile-card{


padding:40px;


text-align:center;


}



.profile-card img{


width:160px;


height:160px;


border-radius:50%;


object-fit:cover;


border:

6px solid white;



box-shadow:

0 0 40px rgba(212,175,55,.6);



animation:avatar 4s infinite alternate;


}



@keyframes avatar{


from{

transform:rotate(-3deg);

}


to{

transform:rotate(3deg);

}


}



.profile-card h2{


margin-top:20px;


font-size:28px;


font-weight:700;


color:#111827;


}




.badge{


display:inline-flex;


align-items:center;


gap:8px;


margin-top:15px;


padding:10px 22px;


border-radius:50px;



background:

linear-gradient(
135deg,
#fff7d6,
#ffe9a3
);


color:#8a6415;


font-weight:700;


border:1px solid #d4af37;


}





/* RIGHT */


.profile-details{


padding:45px;


}



.profile-details h3{


font-size:30px;


font-family:'Playfair Display',serif;


margin-bottom:30px;


}





/* GRID */


.info-grid{


display:grid;


grid-template-columns:repeat(2,1fr);


gap:20px;


}




.info-box{


background:

rgba(255,255,255,.7);


padding:22px;


border-radius:22px;


border:

1px solid #e2e8f0;


position:relative;


overflow:hidden;


transition:.4s;


}




.info-box::before{


content:"";


position:absolute;


width:80px;


height:80px;


background:#d4af37;


filter:blur(50px);


opacity:0;


transition:.4s;


}



.info-box:hover{


transform:

translateY(-8px);


box-shadow:

0 20px 40px rgba(0,0,0,.1);


}



.info-box:hover::before{


opacity:.5;


}





.label{


font-size:12px;


color:#64748b;


font-weight:700;


letter-spacing:1px;


text-transform:uppercase;


}



.value{


margin-top:10px;


font-size:17px;


font-weight:700;


color:#111827;


}



/* BUTTON */


.edit-btn{


display:inline-flex;


align-items:center;


gap:10px;


margin-top:35px;


padding:15px 30px;


border-radius:50px;


background:


linear-gradient(
135deg,
#2563eb,
#1d4ed8
);


color:white;


text-decoration:none;


font-weight:700;



box-shadow:

0 20px 40px rgba(37,99,235,.35);


transition:.4s;


}



.edit-btn:hover{


transform:

translateY(-5px)
scale(1.05);


box-shadow:

0 30px 60px rgba(37,99,235,.5);


}





@media(max-width:900px){


.profile-container{


grid-template-columns:1fr;


}



.info-grid{


grid-template-columns:1fr;


}


}

</style>
</head>

<body>

<div class="profile-container">

    <!-- LEFT -->
    <div class="profile-card">
        <img src="<?php echo $img; ?>">

        <h2><?php echo htmlspecialchars($admin['name']); ?></h2>

<div class="badge">
    <i class="fa fa-shield"></i>
    <?php echo strtoupper($admin['role']); ?>
</div>

        <p style="margin-top:10px; color:#666;">
            Member since <?php echo date("M Y", strtotime($admin['addwithus'])); ?>
        </p>
    </div>

    <!-- RIGHT -->
    <div class="profile-details">
        <h3>Profile Information</h3>

        <div class="info-grid">

            <div class="info-box">
                <div class="label">Full Name</div>
                <div class="value"><?php echo $admin['name']; ?></div>
            </div>

            <div class="info-box">
                <div class="label">Email</div>
                <div class="value"><?php echo $admin['email']; ?></div>
            </div>

            <div class="info-box">
                <div class="label">Mobile</div>
                <div class="value"><?php echo $admin['mobile']; ?></div>
            </div>

            <div class="info-box">
                <div class="label">Membership</div>
                <div class="value"><?php echo $admin['membership']; ?></div>
            </div>

            <div class="info-box" style="grid-column: span 2;">
                <div class="label">Address</div>
                <div class="value"><?php echo $admin['address']; ?></div>
            </div>

        </div>

        <a href="edit_profile.php" class="edit-btn">
            <i class="fa fa-edit"></i> Edit Profile
        </a>
    </div>

</div>

</body>
</html>