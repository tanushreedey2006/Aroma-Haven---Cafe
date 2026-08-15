<!DOCTYPE html>
<html>
<head>

<title>Booking Confirmed</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">


<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}



body{

    height:100vh;

    display:flex;

    justify-content:center;

    align-items:center;


    font-family:'Inter',sans-serif;


    background:


    radial-gradient(circle at top,
    #fff0c7,
    transparent 35%),


    linear-gradient(
    135deg,
    #fff8e8,
    #e8c98b
    );


    overflow:hidden;


}



/* floating coffee glow */


body::before{


content:"☕";


position:absolute;


font-size:220px;


opacity:.08;


top:50px;


left:80px;


animation:float 6s infinite alternate;


}


@keyframes float{


from{

transform:translateY(0);

}


to{

transform:translateY(40px);

}


}



/* CARD */


.box{


width:450px;


padding:50px 40px;


text-align:center;


background:

rgba(255,255,255,.65);



border-radius:35px;



border:

1px solid rgba(199,154,69,.4);



backdrop-filter:blur(25px);



box-shadow:

0 40px 90px rgba(100,60,20,.25);



animation:

show 1s ease;



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

transform:

translateY(0)
scale(1);


}


}




/* ICON */


.icon{


font-size:65px;


animation:

pop 1.2s infinite alternate;


}


@keyframes pop{


from{

transform:scale(1);

}


to{

transform:scale(1.15);

}


}





h1{


margin-top:15px;


font-family:'Playfair Display',serif;


font-size:36px;


color:#6b4020;


}



p{


margin-top:15px;


color:#7a5635;


font-size:16px;


}





/* BUTTONS */


a{


display:inline-block;


margin:25px 8px 0;


padding:13px 28px;


border-radius:50px;


text-decoration:none;


font-weight:600;


transition:.4s;


}





.home{


background:#6b4020;


color:white;


}




.view-btn{


background:

linear-gradient(

135deg,

#d8ad55,

#a87320

);


color:white;


box-shadow:

0 15px 30px rgba(168,115,32,.35);


}





a:hover{


transform:

translateY(-5px)
scale(1.05);


}




/* coffee steam */


.steam{


font-size:25px;


animation:steam 2s infinite;


}



@keyframes steam{


0%{

opacity:0;

transform:translateY(10px);

}


50%{

opacity:1;

}


100%{

opacity:0;

transform:translateY(-20px);

}


}



</style>

</head>


<body>


<div class="box">


<div class="icon">

☕✨

</div>


<h1>
Booking Confirmed!
</h1>


<p>
Your premium table experience has been reserved successfully.
</p>


<div class="steam">
♨️
</div>



<a href="index.php" class="home">
🏠 Go Home
</a>



<a href="my_bookings.php" class="view-btn">

👑 View My Bookings

</a>



</div>


</body>
</html>