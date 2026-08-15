<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" type="text/css" href="coffee.css"  />
   
    <link rel="stylesheet"  type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css"  />
    <link rel="icon" type="image/png" href="weblogo.png">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
        <?php
session_start();
?>

<style>

@media (max-width: 750px) {
 .serim{
      /* width: 40%; */
      /* margin-top: -12em !important; */
      margin-left: -3em !important;
      padding:30px ;
  }

  .service{
  margin-top: 3em !important;
  }

}
</style>
</head>
<body>
    <?php include("header.php"); ?>
  

     <div style="padding-top: 5%;" class="sertop" >
      <h1  class="serh1">Help Center</h1>
  <div class="service d-flex gap-5 " >
    <div class=" d-flex justify-content-center align-items-center ">
      <img src="./images/IMG-20250823-WA0024.jpg" class="serim">
    </div>
    <div class="ourser">
      <h1 class="d-flex justify-content-center p-3 fw-bold ">OUR SERVICE</h1>
     
      <div class="d-flex gap-3  ico">
        <img src="./Png/maker.png" style="width: 15%; height: 10vh;">
        <div class=" " >
            <h3 class="  fs-5 fw-bold">THE COFFEE MACHINE</h3>
            <p class="m-0 p-0 ">Lorem ipsum dolor sit amet consectetur adipisic </p>
            <p class="m-0 p-0">elit Recusandae, illo rerum mollitia nobis quo  </p>
            <p class="m-0 p-0"> voluptates facere </p>
        </div>
      </div>
      <div class="d-flex gap-3 pt-4 ico">
        <img src="./Png/bean.png" style="width: 15%; height: 10vh;">
        <div class=" ">
            <h3 class="fs-5 fw-bold">SUPREME BEANS</h3>
            <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur adipisic</p>
            <p class="m-0 p-0"> elit Recusandae, illo rerum mollitia nobis quo  </p>
            <p class="m-0 p-0"> voluptates facere </p>
        </div>
      </div>
      <div class="d-flex gap-3 pt-4 ico">
        <img src="./Png/cup.png" style="width: 15%; height: 10vh;">
        <div class=" ">
            <h3 class="fs-5 fw-bold">THE PERFACT CUP</h3>
            <p class="m-0 p-0">Lorem ipsum dolor sit amet consectetur adipisic</p>
            <p class="m-0 p-0">elit Recusandae, illo rerum mollitia nobis quo   </p>
            <p class="m-0 p-0"> voluptates facere </p>
        </div>
      </div>
    </div>
  </div>
</div>



   
    <?php include("footer.php"); ?>




<script src="script.js"></script>
<script src="search.js"></script>
   
    <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>