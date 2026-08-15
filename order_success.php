<?php
session_start();

/* checkout session clear */
unset($_SESSION['checkout_items']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Successful</title>

<link rel="icon" href="weblogo.png">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;

background:
linear-gradient(
135deg,
#fff8f2,
#f7ece4,
#fff4eb
);
}

/* animated blobs */

.blob{
position:absolute;
border-radius:50%;
filter:blur(80px);
opacity:.25;
animation:float 8s infinite ease-in-out;
}

.blob1{
width:300px;
height:300px;
background:#a65935;
top:-100px;
left:-100px;
}

.blob2{
width:350px;
height:350px;
background:#ffb27d;
bottom:-120px;
right:-120px;
animation-delay:2s;
}

@keyframes float{
0%{transform:translateY(0);}
50%{transform:translateY(-40px);}
100%{transform:translateY(0);}
}

/* card */

.success-card{

width:650px;
max-width:95%;

background:white;

padding:50px;

border-radius:35px;

text-align:center;

box-shadow:
0 30px 60px rgba(0,0,0,.12);

position:relative;
z-index:5;

animation:popup .6s ease;
}

@keyframes popup{

from{
transform:scale(.7);
opacity:0;
}

to{
transform:scale(1);
opacity:1;
}

}

/* success icon */

.success-icon{

width:130px;
height:130px;

margin:auto;

border-radius:50%;

background:
linear-gradient(
135deg,
#28a745,
#6ee787
);

display:flex;
justify-content:center;
align-items:center;

color:white;

font-size:60px;

box-shadow:
0 0 0 15px rgba(40,167,69,.15);

animation:pulse 2s infinite;
}

@keyframes pulse{

0%{
box-shadow:
0 0 0 0 rgba(40,167,69,.35);
}

70%{
box-shadow:
0 0 0 25px rgba(40,167,69,0);
}

100%{
box-shadow:
0 0 0 0 rgba(40,167,69,0);
}

}

h1{

margin-top:25px;

font-size:42px;

color:#58260f;
}

.success-text{

margin-top:15px;

font-size:18px;

line-height:1.8;

color:#666;
}

.order-id{

margin-top:25px;

display:inline-block;

padding:14px 28px;

background:#fff3ea;

border-radius:15px;

font-weight:700;

color:#58260f;
}

.info-box{

margin-top:25px;

background:#f8f8f8;

padding:18px;

border-radius:15px;

color:#555;
}

.btn-group{

display:flex;
gap:15px;

margin-top:30px;

justify-content:center;
flex-wrap:wrap;
}

.btn{

padding:16px 28px;

border:none;

border-radius:15px;

text-decoration:none;

font-weight:700;

transition:.3s;
}

.track-btn{

background:#58260f;
color:white;
}

.shop-btn{

background:#fff3ea;
color:#58260f;
}

.btn:hover{

transform:translateY(-4px);
}

/* auto redirect */

.redirect{

margin-top:25px;
color:#888;
font-size:14px;
}

/* confetti */

.confetti{
position:absolute;
width:10px;
height:10px;
top:-20px;
animation:fall linear forwards;
}

@keyframes fall{

to{
transform:translateY(110vh) rotate(720deg);
opacity:0;
}

}

</style>
</head>
<body>

<div class="blob blob1"></div>
<div class="blob blob2"></div>

<div class="success-card">

<div class="success-icon">
<i class="fa-solid fa-check"></i>
</div>

<h1>Order Confirmed!</h1>

<p class="success-text">
Thank you for your purchase ☕<br>
Your order has been placed successfully and is being prepared.
</p>

<div class="order-id">
Order Received Successfully
</div>

<div class="info-box">
<i class="fa-solid fa-truck-fast"></i>
 Estimated Delivery: 2 - 4 Days
</div>

<div class="btn-group">

<a href="userorder.php"
class="btn track-btn">

<i class="fa-solid fa-location-dot"></i>
 Track Order

</a>

<a href="catalogue.php"
class="btn shop-btn">

<i class="fa-solid fa-cart-shopping"></i>
 Continue Shopping

</a>

</div>

<div class="redirect">
Redirecting to My Orders in
<span id="count">10</span>s
</div>

</div>

<script>

/* countdown */

let sec = 10;

let timer = setInterval(()=>{

sec--;

document.getElementById("count").innerHTML = sec;

if(sec<=0){

clearInterval(timer);

window.location =
"userorder.php";

}

},1000);

/* confetti */

for(let i=0;i<120;i++){

let c =
document.createElement("div");

c.classList.add("confetti");

c.style.left =
Math.random()*100+"vw";

c.style.background =
`hsl(${Math.random()*360},80%,60%)`;

c.style.animationDuration =
(3+Math.random()*4)+"s";

c.style.width =
(6+Math.random()*8)+"px";

c.style.height =
c.style.width;

document.body.appendChild(c);

}

</script>

</body>
</html>