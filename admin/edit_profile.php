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

/* GET USER */
$query = mysqli_query($conn, "SELECT * FROM clients WHERE email='$email' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if(!$user){
    die("User not found");
}

/* UPDATE PROFILE */
if(isset($_POST['update'])){

    $name       = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile     = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $membership = mysqli_real_escape_string($conn, $_POST['membership']);

    $imgName = $user['image'];

    /* IMAGE UPLOAD */
    if(!empty($_FILES['image']['name'])){
        $imgName = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $imgName);
    }

    mysqli_query($conn, "
        UPDATE clients SET 
            name='$name',
            mobile='$mobile',
            address='$address',
            membership='$membership',
            image='$imgName'
        WHERE email='$email'
    ");

    header("Location: admin_profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>

:root{

    --gold:#d4af37;
    --cream:#fff7e8;
    --brown:#6b4020;
    --blue:#2563eb;

}



*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

body{

min-height:100vh;

font-family:'Inter',sans-serif;


background:


radial-gradient(circle at top left,
rgba(212,175,55,.30),
transparent 35%),


radial-gradient(circle at bottom right,
rgba(120,75,30,.25),
transparent 45%),


linear-gradient(
135deg,
#fff8e7,
#e7c98a
);



color:#4b2b14;


display:flex;

align-items:center;

justify-content:center;


overflow:hidden;


}



@keyframes bgMove{


from{

background-position:left;

}


to{

background-position:right;

}


}





/* floating glow */


body::before{


content:"☕";


position:fixed;



font-size:260px;


opacity:.08;


right:70px;


top:50px;


animation:coffee 6s infinite alternate;


}



@keyframes coffee{


from{

transform:translateY(0);

}


to{

transform:translateY(50px);

}


}





/* MAIN CARD */

.container{


width:650px;

max-width:92%;


height:85vh;


overflow-y:auto;


padding:45px;


background:


linear-gradient(
145deg,
rgba(255,255,255,.85),
rgba(255,248,230,.75)
);



backdrop-filter:blur(30px);



border-radius:40px;



border:

1px solid rgba(212,175,55,.5);



box-shadow:

0 40px 100px rgba(80,45,15,.25);



animation:show 1s ease;



}

.container::-webkit-scrollbar{

width:10px;

}


.container::-webkit-scrollbar-track{


background:

rgba(212,175,55,.12);


border-radius:50px;


margin:20px 0;


}



.container::-webkit-scrollbar-thumb{


background:

linear-gradient(
180deg,
#e2c06b,
#a87320
);


border-radius:50px;


border:2px solid transparent;


background-clip:padding-box;


}



.container::-webkit-scrollbar-thumb:hover{


background:

linear-gradient(
180deg,
#f1d889,
#8b5e20
);


}

@keyframes show{


from{

opacity:0;

transform:

translateY(60px)
scale(.9);


}



to{

opacity:1;

transform:none;


}


}




h2{


text-align:center;


font-family:'Playfair Display',serif;


font-size:35px;


color:#5a3418;


margin-bottom:35px;


}



.upload-box{

    position:relative;

    width:100%;

    height:130px;


    border-radius:25px;


    background:

    linear-gradient(
    135deg,
    #fff8e8,
    #f3d79b
    );


    border:

    2px dashed #d4af37;



    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;



    color:#8b5e20;


    gap:10px;


    cursor:pointer;


    transition:.4s;


}



.upload-box i{

    font-size:38px;


    color:#c79a45;


}



.upload-box span{


    font-weight:700;


    font-size:15px;


}



.upload-box:hover{


    transform:translateY(-5px);


    box-shadow:

    0 20px 40px rgba(212,175,55,.35);


    border-color:#8b5e20;


}




.upload-box input{


    position:absolute;


    inset:0;


    opacity:0;


    cursor:pointer;


}

/* PROFILE IMAGE */


img{


width:140px;


height:140px;


border-radius:50%;


object-fit:cover;



display:block;


margin:0 auto 25px;



border:

6px solid white;



box-shadow:

0 0 40px rgba(212,175,55,.6);



transition:.5s;


}



img:hover{


transform:

scale(1.08)
rotate(3deg);



}






/* INPUT AREA */


label{


font-size:12px;


font-weight:700;


letter-spacing:1px;


color:#8b6b45;


text-transform:uppercase;


}





input,
textarea{


width:100%;


padding:16px 20px;


margin-top:10px;


margin-bottom:22px;


border-radius:18px;



border:

1px solid #e7c98b;



background:

rgba(255,255,255,.8);



color:#4b2b14;



font-size:15px;



outline:none;



transition:.3s;


}





input:focus,
textarea:focus{


border-color:var(--gold);


transform:

translateY(-3px);



box-shadow:

0 15px 35px rgba(212,175,55,.25);


}





textarea{


height:120px;


resize:none;


}






/* FILE INPUT */


input[type=file]{


background:

linear-gradient(
135deg,
#fff,
#fff4dc
);


padding:15px;


border:

2px dashed #d4af37;


border-radius:20px;



color:#8b5e20;


cursor:pointer;



transition:.4s;



}


input[type=file]:hover{


transform:translateY(-3px);



box-shadow:

0 15px 35px rgba(212,175,55,.35);



border-color:#a87320;


}





/* BUTTON */


button{


width:100%;


padding:17px;



border:none;


border-radius:50px;



background:


linear-gradient(

135deg,

#d4af37,

#a87320

);



color:white;



font-size:16px;



font-weight:700;



cursor:pointer;



box-shadow:


0 20px 40px rgba(168,115,32,.35);



transition:.4s;


}



button:hover{


transform:

translateY(-5px)
scale(1.03);



box-shadow:


0 30px 60px rgba(168,115,32,.5);


}





/* MOBILE */


@media(max-width:700px){


.container{


width:92%;


padding:30px;


}


h2{

font-size:28px;

}


}

.upload-box small{

    font-size:12px;

    color:#6b4020;

    max-width:90%;

    overflow:hidden;

    text-overflow:ellipsis;

    white-space:nowrap;

}

</style>
</head>

<body>

<div class="container">

    <h2><i class="fa fa-user-edit"></i> Edit Profile</h2>

    <img src="<?php echo !empty($user['image']) ? '../images/'.$user['image'] : '../images/default-user.png'; ?>">

    <form method="POST" enctype="multipart/form-data">

        <label>Name</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

        <label>Mobile</label>
        <input type="text" name="mobile" value="<?php echo $user['mobile']; ?>">

        <label>Address</label>
        <textarea name="address"><?php echo $user['address']; ?></textarea>

        <label>Membership</label>
        <input type="text" name="membership" value="<?php echo $user['membership']; ?>">

        <label>Change Profile Image</label>
       <div class="upload-box">

    <i class="fa fa-cloud-arrow-up"></i>

    <span>Upload Profile Image</span>

    <small id="file-name">
        No image selected
    </small>

    <input 
        type="file" 
        name="image" 
        id="file"
        onchange="showFile(this)"
    >

</div>

        <button type="submit" name="update">
            <i class="fa fa-save"></i> Save Changes
        </button>

    </form>

</div>
<script>

function showFile(input){

    let name = input.files[0] 
        ? input.files[0].name 
        : "No image selected";


    document.getElementById("file-name").innerHTML = name;

}

</script>
</body>
</html>