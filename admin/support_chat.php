<?php
session_start();
include("includes/db_connect.php");
include("function.php");
/** @var mysqli $conn */

if(!isset($_GET['user_id'])){
    header("Location:support.php");
    exit();
}

$user_id=(int)$_GET['user_id'];

/* Mark user notifications as read */
mysqli_query($conn,"
UPDATE support_messages
SET notification=0
WHERE user_id='$user_id'
AND sender='User'
");

$user=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT id,name,email
FROM clients
WHERE id='$user_id'
"));

if(!$user){
    die("User not found.");
}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Support Chat</title>

<link rel="icon" href="weblogo.png">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

body{
background:#f5f3ef;
font-family:Poppins,sans-serif;
}

.chat-wrapper{

max-width:1100px;

height:90vh;

margin:20px auto;

background:#fff;

border-radius:25px;

overflow:hidden;

box-shadow:0 20px 60px rgba(0,0,0,.12);

display:flex;

flex-direction:column;

}

.chat-header{

background:linear-gradient(135deg,#6F4E37,#C08B5C);

padding:20px 25px;

color:#fff;

display:flex;

justify-content:space-between;

align-items:center;

}

.chat-header h4{

margin:0;

font-weight:700;

}

.chat-body{

flex:1;

padding:25px;

overflow-y:auto;

background:#fffaf5;

}

.user-msg{

display:flex;

justify-content:flex-start;

margin-bottom:18px;

}

.admin-msg{

display:flex;

justify-content:flex-end;

margin-bottom:18px;

}

.user-bubble{

background:#ece7e1;

padding:15px;

border-radius:18px 18px 18px 0;

max-width:70%;

}

.admin-bubble{

background:#6F4E37;

color:#fff;

padding:15px;

border-radius:18px 18px 0 18px;

max-width:70%;

}

.time{

font-size:11px;

margin-top:8px;

opacity:.7;

}

.footer{

padding:18px;

display:flex;

gap:15px;

background:#fff;

border-top:1px solid #ddd;

}

.footer textarea{

resize:none;

height:55px;

}

.send{

background:#6F4E37;

color:#fff;

border:none;

padding:12px 28px;

border-radius:15px;

}

.send:hover{

background:#4d3526;

}

</style>

</head>

<body>

<div class="chat-wrapper">

<div class="chat-header">

<div>

<h4><?= htmlspecialchars($user['name']) ?></h4>

<small><?= htmlspecialchars($user['email']) ?></small>

</div>

<a href="support.php" class="btn btn-light">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

<div id="chatBox" class="chat-body">

</div>

<div class="footer">

<textarea
id="message"
class="form-control"
placeholder="Type your reply..."></textarea>

<button id="send" class="send">

<i class="fa-solid fa-paper-plane"></i>

Send

</button>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>

function loadChat(){

$("#chatBox").load("admin_fetch.php?user_id=<?= $user_id; ?>",function(){

$("#chatBox").scrollTop(
$("#chatBox")[0].scrollHeight
);

});

}

loadChat();

setInterval(loadChat,3000);

$("#send").click(function(){

let msg=$("#message").val();

if(msg.trim()=="")
return;

$.post("admin_send.php",{

user_id:<?= $user_id; ?>,

message:msg

},function(){

$("#message").val("");

loadChat();

});

});

</script>

</body>

</html>