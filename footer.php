<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="coffee.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet"  type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
 <style>
@media (max-width:750px){

.share-container {
  gap: 7px;
}
}


 </style>
</head>
<body>
    
  <div class="foo-main" id="foo-main">
    <div class="footer" >
      <h1 class=" fw-bold m-0 p-0">Join in and get </h1>
      <h1 class=" fw-bold m-0 p-0">15% Off</h1>
      <p class=" fw-bold fs-5">Subscribe us and get 15% Off discount</p>     
      <div class="d-flex gap-3 respon flex-wrap">
          <input type="text" placeholder=" Mail Message" style="border: none; background-color: #fff; height: 6vh;" class="rounded-5">
       
        
        <button class="btn text-light rounded-5" type="submit"  style="height: 6vh; background-color: #30261c; border: none;" onclick="abc()" id="a1">Subscribe</button>
        <script>
          let a1=document.getElementById("a1");
            function abc() {
              // console.log(a1);
              confirm("Thanks For Subscribe 🎉🎉")
            }
        </script>
        </div>
      </div>
    </div>
    <div class="foolast" style="background-color: #30261c; ">
    <div class="d-flex text-light justify-content-evenly org" >
      <div class="fw-bold aro" >
        <h1 style="color: #c17530;"><i><b>Aroma Haven</b></i></h1>
         <div class="share-container" style="padding-top: 30px;">
       
        <a href="#" class="share-btn" data-label="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="share-btn" data-label="Twitter">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="share-btn" data-label="Instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="share-btn" data-label="GitHub">
            <i class="fab fa-github"></i>
        </a>
        <a href="#" class="share-btn" data-label="Linkedin">
            <i class="fab fa-linkedin-in "></i>
        </a>
    </div>
      </div>

      <div class="check">
        <h4><b>PRIVACY</b></h4>
        <p class="m-0 p-0" >Terms of use</p>
        <p class="m-0 p-0">Privacy policy</p>
        <p class="m-0 p-0">Cookies</p>
      </div>
      <div class="check" >
        <h4><b>SERVICES</b></h4>
        <p class="m-0 p-0">Shop</p>
        <p class="m-0 p-0">Order ahead</p>
        <p class="m-0 p-0">Menu</p>
      </div>
      <div class="check" >
        <h4><b>ABOUT US</b></h4>
        <p class="m-0 p-0">Find a location</p>
        <p class="m-0 p-0">About us</p>
        <p class="m-0 p-0">Our story</p>
        <p class="m-0 p-0">Contact</p>
      </div>
      <div class="check" >
        <h4><b>INFORMATION</b></h4>
        <p class="m-0 p-0">Plans & pricing</p>
        <p class="m-0 p-0">Sell your products</p>
        <p class="m-0 p-0">Jobs</p>
      </div>
      </div>
      <div class="copylast">
     
         <p style="color: #fff;">&copy; Awesome Coffee, All rights reserved by Tanushree Dey</p>
      </div>
    </div>
   
</div>
   
    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>