
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SignUp/SignIn Form</title>  
    <link rel="stylesheet"  type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
 <?php
include ("connect.php");
global $conn;

// Getting messages from URL
$success = isset($_GET['success']) ? "✅ Registration Success! Please login now." : "";
$email_error = isset($_GET['error']) && $_GET['error'] == 'email_exists' ? "❌ Email already exists!" : "";
$db_error = isset($_GET['error']) && $_GET['error'] == 'database' ? "❌ Database Error! Try again." : "";
$old_email = isset($_GET['email']) ? $_GET['email'] : "";

 
?>  



<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

    .success { color: green; background: #d4edda; padding: 10px; border-radius: 5px; }
        .error { color: red; background: #f8d7da; padding: 10px; border-radius: 5px; }
        form { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; box-sizing: border-box; }

body{

    display:flex;

    justify-content:center;

    align-items:center;

    min-height:100vh;

    overflow:hidden;

    position:relative;
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

.video-overlay{

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:100%;

    background:
    linear-gradient(
        rgba(0,0,0,.45),
        rgba(88,38,15,.35)
    );

    z-index:-1;
}
.container{

    width:950px;

    max-width:95%;

    min-height:85vh;

    position:relative;

    overflow:hidden;

    border-radius:35px;

    background:
    rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    -webkit-backdrop-filter:blur(18px);

    border:
    1px solid rgba(255,255,255,0.15);

    box-shadow:
    0 25px 70px rgba(0,0,0,.35);
}

/* FORM CONTAINER */
.form-container {
  position: absolute;
  top: 0;
  height: 100%;
  width: 50%;
  transition: all 0.6s ease-in-out;

}

.sign-in-container {
  left: 9;
  width: 50%;
  opacity: 0;
  z-index: 1;
}

.container.right-panel-active .sign-in-container {
  transform: translateX(100%);
  opacity: 1;
  z-index: 2;
  animation: show 0.6s;
}

.sign-up-container {

  width: 50%;
  z-index: 2;
  /* margin-top:-5.8%; */
}

.container.right-panel-active .sign-up-container {
  transform: translateX(-100%);
}

@keyframes show {
  0%, 49.99% {
    opacity: 0;
    z-index: 1;
  }
  50%, 100% {
    opacity: 1;
    z-index: 5;
  }
}
@keyframes shape{
  0%, 100%{
    border-radius:40% 60% 70% 30%/ 40% 40% 60% 50%;
  }
  33%{
    border-radius:70% 30% 50% 50%/ 30% 30% 70% 70%;
  }
  66%{
    border-radius: 100% 60% 60% 100% / 100% 100% 60% 60%;
  }
}



h1 {
  font-weight: bold;
  margin-bottom: 20px;
}

input {
  background: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 100%;
  border-radius: 5px;
}

.upload-box{

    width:100%;

    display:flex;
    flex-direction:column;

    align-items:center;

    gap:15px;

    margin:10px 0;
}

#imginput{
    display:none;
}


input{

    background:
    rgba(255,255,255,.12);

    border:
    1px solid rgba(255,255,255,.2);

    color:white;

    padding:14px 18px;

    margin:10px 0;

    width:100%;

    border-radius:14px;

    outline:none;
}

input::placeholder{

    color:#ddd;
}
.upload-label{

    width:100%;

    padding:15px;

    border-radius:15px;

    cursor:pointer;

    text-align:center;

    background:
    rgba(255,255,255,0.15);

    border:
    2px dashed rgba(255,255,255,0.4);

    color:white;

    transition:.3s;
}

.upload-label:hover{

    background:
    rgba(255,255,255,0.25);
}

.upload-label i{

    font-size:22px;

    display:block;

    margin-bottom:8px;
}

#imgpreview{

    width:120px;

    height:120px;

    border-radius:50%;

    object-fit:cover;

    display:none;

    border:4px solid white;

    box-shadow:
    0 10px 30px rgba(0,0,0,.3);
}

button{

    border:none;

    border-radius:50px;

    background:
    linear-gradient(
        135deg,
        #c17530,
        #7a3b09
    );

    color:white;

    padding:14px 40px;

    font-weight:700;

    transition:.4s;
}

button:hover{

    transform:
    translateY(-4px);

    box-shadow:
    0 15px 30px rgba(193,117,48,.4);
}

button.ghost {
  background-color: #997660;
  border-color: #fff;
}

button:active {
  transform: scale(0.95);
}

.overlay{

    background:
    linear-gradient(
        135deg,
        rgba(255,255,255,.15),
        rgba(193,117,48,.25)
    );

    backdrop-filter:blur(15px);

    color:white;
}

.container::before{

    content:"";

    position:absolute;

    width:350px;

    height:350px;

    background:
    rgba(193,117,48,.20);

    border-radius:50%;

    top:-120px;

    right:-120px;

    filter:blur(60px);
}

.container::after{

    content:"";

    position:absolute;

    width:300px;

    height:300px;

    background:
    rgba(255,255,255,.10);

    border-radius:50%;

    bottom:-100px;

    left:-100px;

    filter:blur(60px);
}
/* OVERLAY */
.overlay-container {
  position: absolute;
  top: 0;
  left: 50%;
  width: 50%;
  height: 100%;
  overflow: hidden;
  transition: transform 0.6s ease-in-out;
  z-index: 100;
  
}

.container.right-panel-active .overlay-container{
  transform: translateX(-100%);
  
}

.overlay {

  color: #523c27;
  position: relative;
  left: -100%;
  height: 100%;
  width: 200%;
  transform: translateX(0);
  transition: transform 0.6s ease-in-out;
}

form{

    background:
    rgba(88,38,15,0.35);

    backdrop-filter:blur(10px);

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    flex-direction:column;

    padding:0 50px;

    height:110%;
    border:none;

    text-align:center;
}

.container.right-panel-active .overlay {
  transform: translateX(50%);
  
}

.overlay-panel {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  padding: 0 40px;
  text-align: center;
  top: 0;
  height: 100%;
  width: 50%;
}

.hello, .hello1{
  padding: 0 40px;

}
.overlay-left {
  left:0;
  transform: translateX(-20%);
 
}

.container.right-panel-active .overlay-left {
  transform: translateX(0);
  
}

.overlay-right {
  right: 0;
  left: 2;
  transform: translateX(0);
}

.container.right-panel-active .overlay-right {
  transform: translateX(20%);

  
}
.overlay-right .img , .overlay-left .img1{
  width: 100%;
  height: 10vh;
}
.overlay-right img, .overlay-left img{
  width: 100%;
  height: 40vh; 
  margin-top:-10% ;
  animation:shape 5s linear infinite;
}
.hello, .hello1{
  padding-top: 13em ;
 
}

/* .hello h1, .hello1 h1{
   font-size:35px;
} */

h1{

    color:white;

    font-size:38px;

    font-weight:900;

    text-shadow:
    0 5px 20px rgba(0,0,0,.3);
}

/* =========================================
   MOBILE RESPONSIVE - MAX 750px
========================================= */



/* =====================================================
   FINAL FORCE MOBILE
===================================================== */

@media screen and (max-width: 768px) {
    body {
        padding: 10px;
        overflow-y: auto;
    }

    .container {
        width: 27em !important;
        height: auto;
        min-height: 680px;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        margin-left: -6.7%;
    }

    /* ফর্ম এবং ওভারলে উপর-নিচ সেটআপ */
    .form-container {
        width: 100em !important;
        height: 65%;
        top: 35%;
        position: absolute;
    }

    .overlay-container {
        width: 100%;
        height: 35%;
        top: 0;
        left: 0;
    }

    /* মোবাইলের জন্য স্লাইডিং অ্যানিমেশন ডিসেবল করা হয়েছে */
    .container.right-panel-active .overlay-container {
        transform: none;
    }

    .overlay {
        width: 100%;
        left: 0;
        transform: none !important;
    }

    .container.right-panel-active .overlay {
        transform: none !important;
    }

    .overlay-panel {
        width: 100%;
        height: 100%;
        padding: 15px;
    }

    /* প্যানেল টগল স্টাইল */
    .overlay-left {
        display: none;
    }
    .container.right-panel-active .overlay-left {
        display: flex;
        transform: none;
    }
    .container.right-panel-active .overlay-right {
        display: none;
    }
    .overlay-right {
        display: flex;
        transform: none;
    }

    .overlay-panel img {
        width: 70px;
        height: 70px;
        margin-bottom: 5px;
    }

    h1 {
        font-size: 22px;
        margin-bottom: 8px;
    }

    .overlay-panel p {
        font-size: 12px;
        margin-top: 2px;
    }

    button.ghost {
        margin-top: 5px;
        padding: 6px 20px;
        font-size: 12px;
    }

    /* ফর্ম কন্টেইনার ফিক্স */
    .sign-up-container {
        opacity: 1;
        z-index: 5;
        transform: none !important;
    }

    .sign-in-container {
        opacity: 0;
        z-index: 1;
        transform: none !important;
    }

    .container.right-panel-active .sign-up-container {
        opacity: 0;
        z-index: 1;
        transform: none !important;
    }

    .container.right-panel-active .sign-in-container {
        opacity: 1;
        z-index: 5;
        transform: none !important;
    }

    form {
        padding: 20px;
    }

    input {
        padding: 10px;
        margin: 5px 0;
        font-size: 14px;
    }

    .upload-label {
        padding: 8px;
        font-size: 13px;
    }


/* ONLY FIX OVERLAY CONTENT POSITION */

.hello,
.hello1 {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

.hello h1,
.hello1 h1 {
    margin-top: 0 !important;
}

.hello p,
.hello1 p {
    margin-top: 3px !important;
}


    
}

@media screen and (max-width: 768px) {

    body {
        padding: 10px;
        overflow: hidden !important;
    }

    .form-container {
        width: 100% !important;
        height: 65%;
        top: 35%;
        position: absolute;

        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    .form-container::-webkit-scrollbar {
        width: 5px !important;
    }

    .form-container::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,.35) !important;
        border-radius: 10px !important;
    }

    .form-container form {
        height: auto !important;
        min-height: 100% !important;
    }
}

/* =========================================
   CREATE ACCOUNT CONTENT SCROLL
========================================= */

.form-container {
    overflow-y: auto;
    overflow-x: hidden;
    max-height: 100%;
    margin-left: -1em !important;
    }

/* Scrollbar */
.form-container::-webkit-scrollbar {
    width: 6px;
}

.form-container::-webkit-scrollbar-track {
    background: transparent;

}

.form-container::-webkit-scrollbar-thumb {
    background: #b88b5a;
    border-radius: 10px;

}

.form-container::-webkit-scrollbar-thumb:hover {
    background: #8f633c;
    margin-left: -8% !important;

}

</style>
</head>
<body>


<div class="video-bg">

    <video autoplay muted loop playsinline>
        <source src="./images/coffee2.mp4" type="video/mp4">
    </video>

</div>

<div class="video-overlay"></div>
<div style="text-align: center;">
        <?php if($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if($email_error): ?>
            <div class="error"><?php echo $email_error; ?></div>
        <?php endif; ?>
        
        <?php if($db_error): ?>
            <div class="error"><?php echo $db_error; ?></div>
        <?php endif; ?>
<div class="container" id="container">


  <div class="form-container sign-up-container">
    <form onsubmit="return signup()" action="form_action.php" method="POST" enctype="multipart/form-data" style="margin:-5% -3%;">
      <h1>Create Account</h1>
      <input type="text" placeholder="Name"   name="name" id="name"  />
      <input type="text" placeholder="Email" name="email" id="email_id"  />
      <input 
    type="tel" 
    placeholder="Mobile Number" 
    name="mobile" 
    id="mobile" 
    maxlength="10"
    pattern="[0-9]{10}"
    inputmode="numeric"
    required
/>
      <input type="text" placeholder="Address" name="address" id="address"  />
      <div class="upload-box">

    <input
    type="file"
    name="image"
    id="imginput"
    accept="image/*"
    required>

    <label for="imginput" class="upload-label">

        <i class="fa-solid fa-cloud-arrow-up"></i>

        <span>Upload Profile Image</span>

    </label>

    <img
    id="imgpreview"
    src=""
    alt="Preview">

</div>
     <input type="password"
placeholder="Password"
name="password"
id="signup_password" />
      <button name="userResistrationbtn" type="submit" value="signup">Sign Up</button>
    </form>
  </div>


  <!-- Sign In -->
  <div class="form-container sign-in-container" style="margin-left:1%;">
    <form   action="login_action.php" method="POST" enctype="multipart/form-data" style="margin-top:-5%;" >
      <h1>SignIn Form</h1>
      <input type="email" placeholder="Email" name="email" id="email" />
      <input type="password"
        placeholder="Password"
        name="password"
        id="signin_password" />
      <button name="usersigninbtn" type="submit" value="login">Sign In</button>
    </form>                                             
  </div>

  <!-- Overlay -->
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left ">
        <div class="img1">
        <img src="../CoffeeShop2/images/IMG-20250823-WA0048.jpg" ></div>
        <div class="hello1">
        <h1>Welcome Back!!! Glad to see you🤩</h1>
        <p>Get wide range of speciality coffee, tea and beverage.</p></div>
        <button class="ghost" id="signUp">Sign Up</button>
      </div>

      <div class="overlay-panel overlay-right">
        <div class="img">
        <img src="../CoffeeShop2/images/IMG-20250823-WA0032.jpg" ></div>
        <div class="hello">
        <h1>Hello, Friend!</h1>
        <h4>Create your account</h4>
        <p>Enter your personal details and start journey with us</p>
        <button class="ghost" id="signIn">Sign In</button></div>
      </div>
    </div>
  </div>

</div>

<script>

const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signInButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

signUpButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});



 function signup(){ 
    const name = document.getElementById('name').value.trim(); 
    const email = document.getElementById('email_id').value.trim(); 
    const mobile = document.getElementById('mobile').value.trim();
    const address = document.getElementById('address').value.trim(); 
    const password = document.getElementById('signup_password').value; 

    if(name === "" || email === "" || mobile === "" || address === "" || password === ""){ 
        alert("All fields are mandatory"); 
        return false; 
    }

    if(!/^[0-9]{10}$/.test(mobile)){
        alert("Please enter a valid 10-digit mobile number");
        return false;
    }

    return true; 
}

        // Image
         const imgInput =
document.getElementById("imginput");

const imgPreview =
document.getElementById("imgpreview");

imgInput.addEventListener("change",function(){

    if(this.files && this.files[0]){

        imgPreview.src =
        URL.createObjectURL(this.files[0]);

        imgPreview.style.display =
        "block";
    }

});

</script>
<script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



