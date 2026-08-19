<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="coffee.css" />
    <link rel="icon" type="image/png" href="weblogo.png">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        @media (max-width:750px) {

            .share-container {
                gap: 7px;
            }
        }


        .foo-main {
            position: relative;
        }

        .subscribe-card {
            display: none;
            position: absolute;
            z-index: 1000;

            width: 320px;
            padding: 30px 25px;

            background: #ffffff;
            border-radius: 18px;
            text-align: center;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .subscribe-card.show {
            display: block;
            animation: cardShow 0.3s ease;
        }

        .subscribe-success-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #e8f5e9;
            color: #28a745;

            font-size: 28px;
        }

        .subscribe-card h3 {
            color: #30261c;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subscribe-card p {
            color: #666;
            margin-bottom: 0;
        }

        @keyframes cardShow {
            from {
                opacity: 0;
                transform: translate(-50%, -45%) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }


        .subscribe-card {
            display: none;
            position: absolute;
            z-index: 1000;

            width: 320px;
            padding: 30px 25px;

            background: #ffffff;
            border-radius: 18px;
            text-align: center;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);

            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .close-card {
            position: absolute;
            top: 12px;
            right: 15px;

            width: 32px;
            height: 32px;

            border: none;
            background: transparent;

            color: #30261c;
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
        }

        .close-card:hover {
            color: #c17530;
            transform: scale(1.1);
        }

        .continue-btn {
            margin-top: 18px;
            padding: 10px 0px;
            border: none;
            border-radius: 25px;
            width: 40% !important;
            background: #30261c;
            color: #fff;

            cursor: pointer;
            transition: 0.3s;
        }

        .continue-btn:hover {
            background: #c17530;
        }
    </style>
</head>

<body>

    <div class="foo-main" id="foo-main">
        <div class="footer">
            <h1 class=" fw-bold m-0 p-0">Join in and get </h1>
            <h1 class=" fw-bold m-0 p-0">15% Off</h1>
            <p class=" fw-bold fs-5">Subscribe us and get 15% Off discount</p>
            <div class="d-flex gap-3 respon flex-wrap">
                <input type="text" placeholder=" Mail Message" style="border: none; background-color: #fff; height: 6vh;" class="rounded-5">


                <button class="btn text-light rounded-5" type="submit" style="height: 6vh; background-color: #30261c; border: none;"
                    onclick="abc()" id="a1">Subscribe</button>


                <div class="subscribe-card" id="subscribeCard">

                    <button type="button" class="close-card" onclick="closeCard()">
                        &times;
                    </button>

                    <div class="subscribe-success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <h3>Thank You!</h3>

                    <p>Thanks for subscribing to Aroma Haven! 🎉</p>

                    <button type="button" class="continue-btn" onclick="closeCard()">
                        Continue
                    </button>

                </div>

                <script>
                    function abc() {
                        document.getElementById("subscribeCard").classList.add("show");
                    }

                    function closeCard() {
                        document.getElementById("subscribeCard").classList.remove("show");
                    }
                </script>


            </div>
        </div>
    </div>
    <div class="foolast" style="background-color: #30261c; ">
        <div class="d-flex text-light justify-content-evenly org">
            <div class="fw-bold aro">
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
                <p class="m-0 p-0">Terms of use</p>
                <p class="m-0 p-0">Privacy policy</p>
                <p class="m-0 p-0">Cookies</p>
            </div>
            <div class="check">
                <h4><b>SERVICES</b></h4>
                <p class="m-0 p-0">Shop</p>
                <p class="m-0 p-0">Order ahead</p>
                <p class="m-0 p-0">Menu</p>
            </div>
            <div class="check">
                <h4><b>ABOUT US</b></h4>
                <p class="m-0 p-0">Find a location</p>
                <p class="m-0 p-0">About us</p>
                <p class="m-0 p-0">Our story</p>
                <p class="m-0 p-0">Contact</p>
            </div>
            <div class="check">
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

    <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>