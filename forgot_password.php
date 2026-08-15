<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<style>

body{
background:#f5f5f5;
font-family:Arial;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{

width:420px;

background:white;

padding:30px;

border-radius:15px;

box-shadow:0 10px 30px rgba(0,0,0,.15);

}

input{

width:100%;

padding:14px;

margin-top:15px;

}

button{

width:100%;

padding:15px;

margin-top:20px;

background:#7b4b2a;

color:white;

border:none;

cursor:pointer;

}

</style>

</head>

<body>

<div class="box">

<h2>Forgot Password</h2>

<form action="forgot_password_action.php" method="POST">

<input
type="email"
name="email"
placeholder="Enter your Email"
required>

<button type="submit">
Send Reset Link
</button>

</form>

</div>

</body>

</html>