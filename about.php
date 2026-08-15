  <?php
    session_start();
    ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <style>
          * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
          }

          section {
              background: #f8f1ea;
          }

          /* SECTION */

          .journey-section {
              width: 100%;
              margin-top: 3%;
              padding: 70px 5%;
              overflow: hidden;
          }

          /* TITLE */

          .section-title {
              text-align: center;
              font-size: 60px;
              font-weight: 700;
              color: #111;
              margin-bottom: 20px;
          }

          /* DESCRIPTION */

          .section-desc {
              max-width: 900px;
              margin: auto;
              text-align: center;
              font-size: 22px;
              color: #666;
              line-height: 1.8;
          }

          /* TIMELINE */

          .timeline {
              margin-top: 100px;
              display: flex;
              justify-content: center;
              align-items: flex-start;
              gap: 20px;
              position: relative;
          }

          /* CARD */

          .timeline-card {
              width: 220px;
              background: #fff;
              border-radius: 30px;
              padding: 35px 25px;
              text-align: center;
              position: relative;
              z-index: 2;
              transition: 0.4s;
              cursor: pointer;
          }

          /* STAIRCASE HEIGHTS */

          .timeline-card:nth-child(1) {
              margin-top: 10%;
          }

          .timeline-card:nth-child(2) {
              margin-top: 8%;
          }

          .timeline-card:nth-child(3) {
              margin-top: 6%;
          }

          .timeline-card:nth-child(4) {
              margin-top: 4%;
          }

          .timeline-card:nth-child(5) {
              margin-top: 2%;
          }

          .timeline-card:nth-child(6) {
              /* margin-top:60px; */
              background: #a60000;
              color: white;
          }

          /* YEAR */

          .timeline-card h2 {
              font-size: 42px;
              color: #c69717;
              margin-bottom: 20px;
              font-weight: 700;
          }

          .timeline-card.active h2 {
              color: white;
          }

          /* TEXT */

          .timeline-card p {
              font-size: 18px;
              line-height: 1.8;
              color: #444;
          }

          .timeline-card.active p {
              color: white;
          }


          /* DOTTED LINE BEHIND CARD */

          .timeline-card::after {
              content: '';
              position: absolute;
              left: 50%;
              top: 100%;
              transform: translateX(-50%);

              width: 0;
              height: 245px;

              border-left: 3px dashed #777;

              z-index: -1;
              /* line goes behind the card */
          }

          /* HOVER */

          .timeline-card:hover {
              transform: translateY(-10px);
              box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
          }

          /* ACTIVE CARD */

          .active {
              background: #a60000;
              color: white;
          }

          /* RESPONSIVE */

          @media(max-width:1200px) {

              .timeline {
                  flex-wrap: wrap;
                  justify-content: center;
                  padding-top: -5px;
              }

              .timeline-card {
                  transform: none !important;
                  margin-bottom: 120px;
              }

          }

          @media(max-width:768px) {

              .section-title {
                  font-size: 42px;
              }

              .section-desc {
                  font-size: 16px;
                  padding: 25px;
                  margin-left: -12%;
              }

              .timeline-card {
                  width: 100%;
                  max-width: 350px;
                  margin-left: -14%;
              }


              .explain{
  margin-top: -30em !important;
}
.featur{
  display: flex;
  flex-wrap: wrap;
   height: 95vh;
   /* margin-top: -15em !important ; */
}

.featur h1{
  margin-top: -8em !important;
}

.explain p{
  font-size: 12px;
}

          }

          @media (max-width:750px) {

              video {
                  height: 70vh !important;
                  margin-left: -1em !important;
              }

              .explain h1 {
                  margin-top: 5em;
              }


                  div[style*="height:30vh"]{
        height:auto !important;
        padding:35px 15px;
    }

    div[style*="height:10vh"] h1{
        padding-top:0 !important;
        font-size:30px;
    }

    /* Steps Image */

    img[src*="steps"]{
        width:100% !important;
        height:60vh !important;
    }

    .you{
        margin-top: 9%;
    }



              /* .feature{
    margin-top: -4em !important;
  } */

          }
      </style>
      <link rel="stylesheet" type="text/css" href="coffee.css" />
      <link rel="icon" type="image/png" href="weblogo.png">
      <link rel="stylesheet" type="text/css" href="../CoffeeShop2/assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

  </head>

  <body>
      <?php include("header.php"); ?>





      <div style="position:relative; width:100%; height:100vh; margin-top:1%;">

          <video autoplay muted loop style="border-radius: 10px; width:100%;   height:100vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
              <source src="./images/coffeemaking.mp4" type="video/mp4">
          </video>



      </div>



      <div class="about_details" style="margin-top:-2%;">
          <div class="d-flex pt-5  featur">
              <div class=" picture d-flex flex-column  ms-5 gap-2">
                  <img src="./images/IMG-20250823-WA0053.jpg" class="border rounded-circle  abimg" />
                  <img src="./images/IMG-20250823-WA0052.jpg" class="border rounded-circle  abimg1" />
              </div>
              <div class="explain p-5">
                  <h1 class="d-flex justify-content-center">ABOUT US</h1>
                  <div class="bg-warning  line" style="width: 6%; height: 4px;"></div>
                  <p class="d-flex justify-content-center pt-5 fs-4 p-0 m-0">We at <span class="text-warning">&ensp;CoffeeShop </span>, located in West Bengal, India , are one of the favorite hangouts</p>
                  <p class="d-flex justify-content-center fs-4 p-0 m-0">for coffee and conversations. our goal is to offer the best experience to our guests,</p>
                  <p class="d-flex justify-content-center fs-4  p-0 m-0">ensuring on authentic coffee drinking experience in a sence of relaxation to the city</p>
                  <p class="d-flex justify-content-center fs-4 p-0 m-0">with our cazy space, complete with comfortable couches to lounge in while you </p>
                  <p class="d-flex justify-content-center fs-4 p-0 m-0">enjoy your coffee. Now, we're thrilled to share our authentic, ready-to-eat </p>
                  <p class="d-flex justify-content-center fs-4 p-0 m-0">Indian delights with our domestic market, bringing the same love and </p>
                  <p class="d-flex justify-content-center fs-4 p-0 m-0">care to our customers in India.</p>
              </div>
          </div>
      </div>

      <div class="you" style="background:#fefefe; position:relative; width:100%; height:10vh;">
          <h1 style="text-align:center; padding-top:5%;">Freshness, Delivered to You</h1>
      </div>
      <div class="freshness" style="position:abssolute; margin-top:5%;">
          <img src="./images/steps.png" alt="" style="width:100%; height:150vh;">
      </div>

      <section class="journey-section">

          <h1 class="section-title">Our Journey</h1>

          <p class="section-desc">
              Founded in 1988 from a small coffee farm, our brand grew into a global coffee company serving customers worldwide with premium quality beans.
          </p>

          <div class="timeline">

              <div class="timeline-card">
                  <h2>2022</h2>
                  <p>
                      Started with a humble coffee farm and traditional roasting methods.
                  </p>
              </div>

              <div class="timeline-card">
                  <h2>2023</h2>
                  <p>
                      Established our first coffee processing and packaging unit.
                  </p>
              </div>

              <div class="timeline-card">
                  <h2>2024</h2>
                  <p>
                      Introduced premium roasted coffee blends to local markets.
                  </p>
              </div>

              <div class="timeline-card">
                  <h2>2025</h2>
                  <p>
                      Expanded exports to more than 20 countries globally.
                  </p>
              </div>

              <div class="timeline-card">
                  <h2>2026</h2>
                  <p>
                      Automated production and launched sustainable coffee sourcing.
                  </p>
              </div>

              <div class="timeline-card active">
                  <h2>2027</h2>
                  <p>
                      Serving coffee lovers worldwide with eco-friendly production.
                  </p>
              </div>

          </div>

      </section>

      <?php include("footer.php"); ?>





      <script src="script.js"></script>
      <script src="search.js"></script>

      <script src="../CoffeeShop2/assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
      <script>
          function redirectPage(select) {

              let page = select.value;

              if (page != "") {

                  window.location.href = page;
              }

              select.selectedIndex = 0;
          }
      </script>

  </body>

  </html>