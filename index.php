        <?php
        include('connect.php');
        session_start();

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <title>Document</title>
            <link rel="stylesheet" type="text/css" href="coffee.css" />

            <link rel="stylesheet" href="assets/bootstrap-5.3.7-dist/css/bootstrap.min.css" />
            <link rel="icon" type="image/png" href="weblogo.png">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

            <style>
                .seat-title {
                    text-align: center;
                    padding: 60px 0 30px;
                    font-size: 40px;
                    font-weight: 700;
                    color: #6f4325;
                    letter-spacing: 1px;
                }

                .seat-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                    gap: 25px;
                    padding: 20px 8%;
                }

                /* CARD */
                .seat-card {
                    background: rgba(255, 255, 255, 0.65);
                    backdrop-filter: blur(18px);
                    border-radius: 28px;
                    overflow: hidden;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
                    transition: 0.5s;
                    position: relative;
                }

                .seat-card:hover {
                    transform: translateY(-12px) scale(1.02);
                    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.18);
                }

                .contact-card {
                    display: none;
                    position: fixed;
                    z-index: 9999;

                    width: 90%;
                    max-width: 380px;

                    padding: 35px 30px;

                    background: #ffffff;
                    border-radius: 20px;

                    text-align: center;

                    top: 50%;
                    left: 50%;

                    transform: translate(-50%, -50%);

                    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.25);
                }

                .contact-card.show {
                    display: block;
                    animation: contactShow 0.3s ease;
                }

                .close-contact {
                    position: absolute;
                    top: 12px;
                    right: 16px;

                    border: none;
                    background: transparent;

                    font-size: 28px;
                    color: #30261c;

                    cursor: pointer;
                }

                .contact-success-icon {
                    width: 70px;
                    height: 70px;

                    margin: 0 auto 18px;

                    display: flex;
                    align-items: center;
                    justify-content: center;

                    border-radius: 50%;

                    background: #f3e4d3;
                    color: #c17530;

                    font-size: 30px;
                }

                .contact-card h3 {
                    color: #30261c;
                    font-weight: bold;
                    margin-bottom: 12px;
                }

                .contact-card p {
                    color: #666;
                    line-height: 1.6;
                }

                .contact-continue-btn {
                    margin-top: 15px;

                    border: none;
                    border-radius: 25px;

                    padding: 10px 30px;

                    background: #30261c;
                    color: white;

                    cursor: pointer;

                    transition: 0.3s;
                }

                .contact-continue-btn:hover {
                    background: #c17530;
                }

                @keyframes contactShow {
                    from {
                        opacity: 0;
                        transform: translate(-50%, -45%) scale(0.9);
                    }

                    to {
                        opacity: 1;
                        transform: translate(-50%, -50%) scale(1);
                    }
                }

                /* IMAGE */
                .img-box {
                    position: relative;
                    height: 230px;
                    overflow: hidden;
                }

                .img-box img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: 0.6s;
                }


                .seat-card:hover img {
                    transform: scale(1.12);
                }

                /* BADGE */
                .badge {
                    position: absolute;
                    top: 15px;
                    left: 15px;
                    padding: 6px 14px;
                    border-radius: 30px;
                    font-size: 12px;
                    font-weight: 700;
                    background: #fff;
                    color: #6f4325;
                    letter-spacing: 1px;
                }


                .overlay {
                    position: absolute;
                    inset: 0;
                    background: linear-gradient(to top,
                            rgba(0, 0, 0, 0.5),
                            transparent);
                }

                /* PRICE TAG */
                .price-tag {
                    position: absolute;
                    bottom: 15px;
                    right: 15px;
                    background: rgba(255, 255, 255, 0.9);
                    padding: 6px 14px;
                    border-radius: 20px;
                    font-weight: 700;
                    color: #6f4325;
                    font-size: 14px;
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                }

                .vip-badge {
                    background: linear-gradient(135deg, #ffd700, #ffb300);
                    color: #000;
                    box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
                }

                /* INFO */
                .seat-info {
                    padding: 22px;
                }

                .seat-info h3 {
                    font-size: 20px;
                    margin-bottom: 8px;
                    color: #3b2415;
                }

                .price {
                    display: inline-block;
                    background: #fff3e0;
                    padding: 5px 12px;
                    border-radius: 20px;
                    font-weight: bold;
                    color: #8a5b18;
                    margin-bottom: 15px;
                }

                /* BUTTON */
                .book-btn {
                    width: 100%;
                    padding: 13px;
                    border: none;
                    border-radius: 40px;
                    background: linear-gradient(135deg, #6f4325, #c79a45);
                    color: white;
                    font-weight: 700;
                    cursor: pointer;
                    transition: 0.4s;
                    letter-spacing: 0.5px;
                }

                .book-btn:hover {
                    transform: scale(1.05);
                    box-shadow: 0 15px 30px rgba(199, 154, 69, 0.4);
                }

                .vip-price {
                    background: linear-gradient(135deg, #ffd700, #ffb300);
                    color: #000;
                }

                .vip-btn {
                    background: linear-gradient(135deg, #ffd700, #ffb300);
                    color: #000;
                }

                .vip-overlay {
                    background: linear-gradient(to top,
                            rgba(255, 215, 0, 0.25),
                            transparent);
                }

                /* VIP STYLE */
                .vip {
                    border: 2px solid gold;
                    box-shadow: 0 0 25px rgba(255, 215, 0, 0.3);
                }

                .seat-info p {
                    font-size: 13px;
                    color: #7a5a3a;
                    margin-bottom: 15px;
                }

                .vip-btn {
                    background: linear-gradient(135deg, gold, #ffb300);
                    color: #000;
                }

                .class {
                    border-radius: 10px;
                    width: 70%;
                    height: 40vh;
                    object-fit: cover;
                    filter: brightness(100%) contrast(110%);
                }

                /* ===========================
   RESPONSIVE (750px)
=========================== */
                @media (max-width:750px) {

                    /* Hero Section */
                    .about {
                        flex-direction: column-reverse;
                        align-items: center;
                        text-align: center;
                        gap: 30px;
                        padding: 20px;
                        margin: 15%;
                    }

                    .left {
                        width: 100%;
                    }

                    .order {
                        display: flex;

                    }

                    .left h1 {
                        font-size: 40px;
                        margin-top: -15%;
                    }

                    .left h5 {
                        font-size: 24px !important;
                    }

                    .left p {
                        font-size: 16px !important;
                    }

                    .Slider-Right {
                        width: 100%;
                        display: flex;
                        justify-content: center;
                    }

                    .Slider-Right img {
                        width: 220px;
                        height: auto;
                    }

                    /* Hero Buttons */
                    .left .d-flex.gap-4 {
                        justify-content: center;
                        flex-wrap: wrap;
                    }

                    #button,
                    #button1 {
                        width: 180px;
                        justify-content: center;
                    }

                    /* Feature Cards */
                    .special {

                        position: static !important;
                        flex-direction: column;
                        padding: 10%;
                        gap: 20px;
                        /* overflow: hidden; */


                    }

                    .special>div {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* Videos */
                    div[style*="padding: 200px"] {
                        flex-wrap: wrap;
                        padding: 40px 15px !important;
                    }

                    div[style*="padding: 200px"] video {
                        width: 100% !important;
                        height: 220px !important;
                    }

                    /* Offer */
                    .details .d-flex {
                        flex-direction: column;
                        gap: 40px;
                    }



                    .picture {
                        margin-left: 0 !important;
                        align-items: center;
                    }



                    .explain p {
                        justify-content: center !important;
                        font-size: 16px !important;
                    }

                    #button3 {
                        width: 200px !important;
                        margin: 30px auto !important;
                        display: block;
                    }

                    /* Coffee Section */
                    /* .new{
    flex-direction:column;
    text-align:center;
    gap:20px;
} */

                    .new>div {
                        width: 100% !important;
                    }

                    .new img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* Popular Images */
                    .popular img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    .popular .d-flex {
                        flex-direction: column;
                        gap: 20px;
                    }

                    /* Shop */
                    .test {
                        height: auto !important;
                    }

                    .test>.d-flex {
                        flex-direction: column;
                    }

                    .test img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    .img1,
                    .img2 {
                        width: 100% !important;
                        text-align: center;
                    }

                    /* Opening */
                    .hr+div img {
                        width: 90% !important;
                        margin: auto !important;
                        display: block;
                        height: auto !important;
                    }

                    /* Why Choose */
                    div[style*="background-color: #f4e3e6"] .d-flex {
                        flex-direction: column;
                        text-align: center;
                    }

                    div[style*="background-color: #f4e3e6"] img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* Contact */
                    .neww .d-flex {
                        flex-direction: column;
                    }



                    /* Footer Contact Form */
                    .cont input,
                    .cont textarea,
                    .cont button {
                        width: 100%;
                    }

                }

                /* ==========================================
   RESPONSIVE DESIGN (750px)
========================================== */

                @media (max-width:750px) {

                    * {
                        box-sizing: border-box;
                    }

                    body {
                        overflow-x: hidden;
                    }

                    .main {
                        width: 100%;
                        overflow: hidden;
                    }

                    /* HERO */

                    .about {
                        flex-direction: column-reverse;
                        padding: 25px 20px;
                        text-align: center;
                        gap: 30px;
                        margin: 0;
                    }

                    .left,
                    .Slider-Right {
                        width: 100%;
                    }

                    .left h1 {
                        font-size: 36px;
                    }

                    .left h5 {
                        font-size: 24px !important;
                    }

                    .left p {
                        font-size: 16px !important;
                    }

                    .left .d-flex.gap-4 {
                        justify-content: center;
                        flex-wrap: wrap;
                    }

                    #button,
                    #button1 {
                        width: 180px;
                        justify-content: center;

                    }

                    /* SLIDER */

                    .Slider-Right {
                        display: flex;
                        justify-content: center;
                    }

                    .Slider-Right img {
                        width: 230px;
                        height: auto;
                    }

                    /* SPECIAL CARDS */

                    .special {
                        position: static !important;
                        flex-direction: column;
                        width: 100% !important;
                        padding: 20px;
                        gap: 20px;
                    }

                    .special>div {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* VIDEO */

                    div[style*="padding: 200px"] {
                        display: grid !important;
                        grid-template-columns: 1fr;
                        gap: 20px;
                        padding: 40px 15px !important;
                    }

                    div[style*="padding: 200px"] video {
                        width: 100% !important;
                        height: 230px !important;
                    }

                    /* OFFER */

                    .details {
                        margin-top: 20px !important;
                    }

                    .details .d-flex {
                        flex-direction: column;
                        gap: 40px;
                    }



                    .picture {
                        margin-left: 0 !important;
                        align-items: center;
                    }

                    .abimg,
                    .abimg1 {
                        width: 220px;
                        height: 220px;
                    }

                    .explain {
                        padding: 10px 40px !important;
                        text-align: center;
                        margin-top: -30em !important;

                    }

                    .explain p {
                        font-size: 16px !important;
                        justify-content: center !important;
                    }

                    #button3 {
                        width: 220px !important;
                        margin: 35px auto !important;
                        display: block;
                    }

                    /* NEW SECTION */

                    .new {
                        flex-direction: column;
                        padding: 20px;
                        text-align: center;
                    }

                    .new>div {
                        width: 100% !important;
                    }

                    .new img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* POPULAR */

                    .popular {
                        padding: 20px !important;
                    }

                    .popular .d-flex {
                        flex-direction: column;
                    }

                    .popular img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* SHOP */

                    .test {
                        height: auto !important;
                        padding: 20px 0;
                    }

                    .test>.d-flex {
                        flex-direction: column;
                        align-items: center;
                    }

                    .img1,
                    .img2 {
                        width: 100% !important;
                        text-align: center;
                    }

                    .test img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    /* OPENING */

                    .hr+div {
                        height: auto !important;
                    }

                    .hr+div img {
                        width: 95% !important;
                        height: auto !important;
                        margin: auto !important;
                        display: block;
                    }

                    /* SEATING */

                    .seat-title {
                        font-size: 32px;
                    }

                    .seat-grid {
                        grid-template-columns: 1fr;
                        padding: 20px;
                    }

                    .img-box {
                        height: 240px;
                    }

                    /* WHY CHOOSE */

                    div[style*="background-color: #f4e3e6"] .d-flex {
                        flex-direction: column;
                    }

                    div[style*="background-color: #f4e3e6"]>div>div {
                        width: 100% !important;
                    }

                    div[style*="background-color: #f4e3e6"] img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    div[style*="background-color: #f4e3e6"] h2,
                    div[style*="background-color: #f4e3e6"] p {
                        text-align: center;
                    }

                    /* TESTIMONIAL */

                    .carousel-item .d-flex {
                        flex-direction: column;
                        align-items: center;
                    }

                    .bg,
                    .bg1,
                    .bg3,
                    .bg5 {
                        position: static !important;
                        width: 95% !important;
                        height: auto !important;
                        margin: 20px auto !important;
                    }

                    .carousel-item img {
                        width: 180px !important;
                        height: 180px !important;
                        margin: auto !important;
                    }

                    /* CONTACT */

                    .neww .d-flex {
                        flex-direction: column;
                    }


                    .meet,
                    .cont {
                        width: 100%;
                    }



                    .cont input,
                    .cont textarea,
                    .cont button {
                        width: 100%;
                    }

                    .cont textarea {
                        height: 120px;
                    }

                    /* FOOTER */

                    footer {
                        text-align: center;
                    }

                    /* ALL IMAGES */

                    img {
                        max-width: 100%;
                    }

                }

                @media (max-width:750px) {

                    .left .d-flex.gap-4 {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 15px !important;
                    }

                    #button,
                    #button1 {
                        width: 220px;
                        height: 50px !important;
                        display: flex !important;
                        justify-content: center;
                        align-items: center;
                    }

                    .respon {
                        margin-top: 4.5em;
                    }

                    .abc {
                        display: none;
                    }


                    .order {
                        margin-top: 10%;
                    }

                }


                @media (max-width: 576px) {

                    .mainvideo {
                        width: 100% !important;
                        padding: 60px 15px !important;

                        display: grid !important;
                        grid-template-columns: repeat(6, 180px) !important;
                        grid-auto-flow: column !important;

                        gap: 10px !important;

                        overflow-x: scroll !important;
                        overflow-y: hidden !important;

                        justify-content: start !important;
                        box-sizing: border-box !important;
                    }

                    .mainvideo .video {
                        width: 100px !important;
                        height: 30vh !important;

                        min-width: 180px !important;
                        max-width: 180px !important;

                        margin: 0 !important;
                    }

                    .mainvideo::-webkit-scrollbar {
                        height: 6px;
                    }

                    .dark {
                        padding-left: 2%;
                        padding-right: 3%;
                        font-size: 16px;
                    }


                }


                .need {
                    display: flex;
                    justify-content: space-evenly;
                    width: 100%;
                }

                @media (max-width: 576px) {

                    .need {
                        display: grid !important;
                        grid-template-columns: 1fr 1fr !important;
                        gap: 40px 20px !important;
                        width: 100% !important;
                        padding: 30px 25px !important;
                        box-sizing: border-box !important;
                    }

                    .need .type {
                        width: 100% !important;
                        text-align: center !important;
                        margin: 0 !important;
                    }

                }

                @media (max-width: 576px) {

                    .about_details {
                        width: 100%;
                        margin-top: 5% !important;
                        padding-bottom: 20%;
                        /* height: 10vh !important; */

                    }


                    /* LEFT CONTENT */

                    .explain {
                        width: 98% !important;
                        /* padding: 15px 8px !important; */
                        margin-top: -63em !important;

                    }


                    .explain h1 {
                        font-size: 28px !important;
                        /* margin-top: -50em !important; */
                        padding-left: 2px;

                    }

                    .explain p {
                        display: block !important;
                        font-size: 15px !important;
                        line-height: 1.9 !important;
                        /* padding: 3em !important; */
                        /* text-align: center !important; */
                        margin-left: -3em !important;
                        /* margin-right: 3em !important; */
                        margin-top: -2% !important;

                    }

                    .line {
                        margin-left: 10em !important;
                        width: 15% !important;
                    }

                    /* RIGHT IMAGES */

                    .picture {
                        width: 50% !important;
                        /* margin-top: -3em !important; */
                        margin-left: 35em !important;
                        /* margin-right: -55%; */
                        margin-bottom: 35em;
                        display: flex !important;
                        flex-direction: column !important;

                        gap: 10px !important;
                    }

                    .abimg,
                    .abimg1 {
                        width: 95px !important;
                        height: 95px !important;
                        object-fit: cover;
                        margin-left: 15em;
                    }

                    .abimg1 {
                        margin-left: 25em !important;
                        margin-top: -6.5em !important;
                    }

                    .abimg {
                        margin-left: 1em !important;
                        /* margin-top: -30px !important; */

                    }

                    /* BUTTON */

                    a:has(#button3),
                    a:has(#button3):hover,
                    a:has(#button3):focus,
                    a:has(#button3):active,
                    a:has(#button3):visited {
                        text-decoration: none !important;
                    }

                    #button3,
                    #button3:hover,
                    #button3:focus,
                    #button3:active {
                        width: 100px !important;
                        font-size: 11px !important;
                        padding: 8px 5px !important;
                        margin: 20px auto !important;
                        text-decoration: none !important;
                    }



                }



                .about_details {
                    margin-top: 2%;
                }

                @media (max-width: 576px) {

                    .new {
                        width: 100% !important;
                        margin-top: 1em !important;
                        background-color: #f3ebeb !important;
                        display: flex !important;
                        flex-direction: row !important;
                        align-items: center !important;
                        gap: 0 !important;
                        padding: 15px 5px !important;
                    }

                    .new>div:first-child {
                        width: 50% !important;
                    }

                    .new>div:last-child {
                        width: 50% !important;
                        padding-top: 0 !important;
                    }

                    .new>div:first-child img {
                        width: 70% !important;
                        height: 200px !important;
                        object-fit: cover;
                        margin-left: -65px;
                    }

                    .new h1 {
                        font-size: 22px !important;
                        line-height: 1.2;
                        margin-top: -1em;
                        margin-left: -10em;
                    }

                    .new p {
                        font-size: 13px !important;
                        line-height: 1.4;
                        padding-top: 8% !important;
                        margin-left: -68px !important;
                    }

                    .new .pt-5 {
                        padding-top: 45px !important;
                    }

                    .new .pt-4 {
                        padding-top: 8px !important;
                    }

                    .new button {
                        font-size: 9px !important;
                        padding: 6px -8px !important;
                        margin: 2px !important;
                    }



                }

                @media (max-width: 576px) {

                    .popular {
                        padding: 20px 8px !important;
                        width: 100% !important;
                    }

                    .popular h1 {
                        font-size: 24px !important;
                        padding-top: 15px !important;
                        text-align: center;
                    }

                    /* Main container */
                    .popular>div {
                        width: 100% !important;
                    }

                    /* Each row */
                    .popular>div>div {
                        width: 100% !important;
                        display: flex !important;
                        flex-direction: row !important;
                        flex-wrap: nowrap !important;
                        justify-content: center !important;
                        align-items: center !important;
                        gap: 10px !important;
                        padding-top: 15px !important;
                    }

                    /* ALL images */
                    .popular img {
                        flex-shrink: 0 !important;
                        object-fit: cover !important;
                    }

                    /* Image 1 and 4 */
                    .popular img.scrol {
                        width: 105% !important;
                        height: 180px !important;

                    }

                    /* Image 2 and 3 */
                    .popular img.scroll {
                        width: 65% !important;
                        height: 128px !important;
                    }
                }

                @media (max-width: 576px) {

                    .neww {
                        width: 100% !important;
                        overflow: hidden !important;
                    }

                    .neww>div {
                        width: 100% !important;
                    }

                    .neww h1 {
                        font-size: 28px !important;
                        padding: 25px 10px !important;
                    }

                    .neww>div>.d-flex {
                        display: flex !important;
                        flex-direction: column !important;
                        gap: 25px !important;
                        padding: 20px 15px !important;
                        width: 100% !important;
                    }


                    .neww .map iframe {
                        width: 25.5em !important;
                        height: 250px !important;
                        display: block;
                        margin-left: -8.5em;
                    }

                    /* Meet Us */
                    .neww .meet {
                        width: 20% !important;
                        margin-right: 22em !important;
                    }

                    .neww .meet h1 {
                        font-size: 25px !important;
                        padding: 10px 0 !important;
                    }

                    .neww .meet p {
                        font-size: 14px !important;
                        margin-bottom: 0 !important;
                    }

                    /* Contact form */
                    .neww .cont {
                        width: 70% !important;
                    }

                    .neww .cont h2 {
                        font-size: 24px !important;
                        padding: 10px !important;
                    }

                    .neww .cont input,
                    .neww .cont textarea {
                        width: 100% !important;
                        box-sizing: border-box !important;
                        margin-bottom: 12px !important;
                        padding: 10px !important;
                    }

                    .neww .cont input {
                        height: 45px !important;
                    }

                    .neww .cont textarea {
                        height: 120px !important;
                        resize: none;
                    }

                    .neww .cont button {
                        width: 100px !important;
                        padding: 8px 15px !important;
                    }
                }



                @media (max-width: 750px) {

                    .SHOP .test {
                        height: auto !important;
                        padding: 20px 10px;
                    }

                    /* =========================
       FIRST ROW
       IMAGE LEFT | CONTENT RIGHT
    ========================= */

                    .SHOP .test>div:first-child {
                        display: flex !important;
                        flex-direction: row !important;
                        flex-wrap: nowrap !important;
                        align-items: center;
                        width: 100% !important;
                        gap: 5px;
                    }

                    .SHOP .test>div:first-child .img1 {
                        width: 38% !important;
                        margin-left: -14%;
                    }

                    .SHOP .test>div:first-child .img1 img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    .SHOP .test>div:first-child>div:nth-child(2) {
                        width: 30% !important;
                        padding: 5px !important;
                        text-align: center;
                    }

                    .SHOP .test>div:first-child>div:nth-child(2) h1 {
                        font-size: 22px;
                        line-height: 1.1;
                    }

                    .SHOP .test>div:first-child>div:nth-child(2) #button3 {
                        font-size: 13px;
                        padding: 6px 10px;
                    }

                    .SHOP .test>div:first-child .img2 {
                        width: 32% !important;
                    }

                    .SHOP .test>div:first-child .img2 img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    .SHOP .test>div:first-child .img2 p {
                        font-size: 10px !important;
                        width: 100%;
                        text-align: center;
                    }


                    /* =========================
       SECOND ROW
       CONTENT LEFT | IMAGE RIGHT
    ========================= */

                    .SHOP .test>div:last-child {
                        display: flex !important;
                        flex-direction: row !important;
                        flex-wrap: nowrap !important;
                        align-items: center;
                        width: 100% !important;
                        gap: 10px !important;
                        margin-top: 25px;
                    }

                    .SHOP .test>div:last-child .img1 {
                        width: 40% !important;
                    }

                    .SHOP .test>div:last-child .img1 h1 {
                        font-size: 22px;
                        line-height: 1.1;
                    }

                    .SHOP .test>div:last-child .img1 p {
                        font-size: 10px !important;
                    }

                    .SHOP .test>div:last-child .img1 #button3 {
                        font-size: 13px;
                        padding: 6px 10px;
                    }

                    /* First image */
                    .SHOP .test>div:last-child>div:nth-child(2) {
                        width: 30% !important;
                    }

                    /* Second image */
                    .SHOP .test>div:last-child .img2 {
                        width: 30% !important;
                    }

                    .SHOP .test>div:last-child img {
                        width: 100% !important;
                        height: auto !important;
                    }

                    .open {
                        width: 80% !important;
                        margin-left: 6%;
                    }
                }


                @media (max-width: 750px) {

                    .seat-grid {
                        grid-template-columns: repeat(2, 1fr) !important;
                        gap: 15px !important;
                        padding: 10px !important;
                    }

                    .seat-card {
                        width: 100% !important;
                    }

                    .img-box img {
                        width: 100% !important;
                        height: 200px !important;
                        object-fit: cover;
                    }

                    .seat-info {
                        padding: 12px !important;
                    }

                    .seat-info h3 {
                        font-size: 18px !important;
                    }

                    .seat-info p {
                        font-size: 13px !important;
                    }

                    .book-btn {
                        font-size: 12px !important;
                        padding: 8px 10px !important;
                    }

                    .price-tag {
                        font-size: 15px !important;
                    }

                    .badge {
                        font-size: 10px !important;
                    }
                }


                @media (max-width: 500px) {

                    .seat-grid {
                        grid-template-columns: 1fr !important;
                        gap: 20px !important;
                        width: 90%;
                    }

                    .img-box img {
                        height: 230px !important;
                    }

                    .seat-info h3 {
                        font-size: 20px !important;
                    }

                    .seat-info p {
                        font-size: 14px !important;
                    }

                    .book-btn {
                        width: 100%;
                        font-size: 13px !important;
                    }
                }


                @media (max-width: 750px) {

                    /* Main section */
                    .why-us {
                        width: 100%;
                        margin-top: 4em !important;
                    }

                    /* Heading */
                    .why-us h1 {
                        font-size: 32px !important;
                    }

                    /* Main content */
                    .why-us>div:nth-child(2) {
                        flex-direction: column !important;
                        align-items: center;
                        width: 100% !important;
                    }

                    /* Image */
                    .why-us>div:nth-child(2)>div:first-child {
                        width: 100% !important;
                        text-align: center;
                    }

                    .why-us>div:nth-child(2)>div:first-child img {
                        width: 60% !important;
                        height: auto !important;
                    }

                    /* Text content */
                    .why-us>div:nth-child(2)>div:last-child {
                        width: 100%;
                        padding: 20px;
                        text-align: center;
                    }

                    .why-us>div:nth-child(2)>div:last-child h2 {
                        font-size: 22px !important;
                    }

                    .why-us>div:nth-child(2)>div:last-child p {
                        font-size: 13px !important;
                        margin-left: -5% !important;
                    }

                    /* Explore button */
                    .why-us #button3 {
                        width: 50% !important;
                        height: auto !important;
                        padding: 10px !important;
                    }
                }

                @media (max-width: 750px) {

                    .contact1 {
                        margin-top: 4em;
                        width: 100%;
                        overflow: hidden;
                    }

                    .contact1 .container-fluid {
                        padding: 0 !important;
                    }

                    /* Heading */
                    .tesi1 h1,
                    .tesi2 h1,
                    .tesi3 h1 {
                        font-size: 26px !important;
                        padding-top: 10px !important;
                    }

                    .tesi1,
                    .tesi2,
                    .tesi3 {
                        width: 115% !important;
                        margin-left: -3em !important;
                        padding: 0 10px !important;
                    }


                    /* =================================
       SLIDE 1
       OLIVIA TOP-LEFT
       ANIL BOTTOM-RIGHT
    ================================= */

                    .tesi1 .d-flex.justify-content-around {
                        position: relative !important;
                        display: block !important;
                        width: 100% !important;
                        height: 430px !important;
                    }

                    /* Olivia image */
                    .tesi1 .d-flex.justify-content-around>div:nth-child(1) {
                        position: absolute !important;
                        top: 0 !important;
                        left: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi1 .d-flex.justify-content-around>div:nth-child(1) img {
                        width: 90% !important;
                        height: 100px !important;
                        margin: auto !important;
                        object-fit: cover;
                    }

                    /* Olivia content */
                    .tesi1 .d-flex.justify-content-around>div:nth-child(2) {
                        position: absolute !important;
                        top: 105px !important;
                        left: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi1 .d-flex.justify-content-around>div:nth-child(2).bg5 {
                        position: relative !important;
                        width: 60% !important;
                        height: auto !important;
                        margin: -2em 0 !important;
                    }

                    /* Anil image */
                    .tesi1 .d-flex.justify-content-around>div:nth-child(3) {
                        position: absolute !important;
                        top: 170px !important;
                        right: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi1 .d-flex.justify-content-around>div:nth-child(3) img {
                        width: 90% !important;
                        height: 100px !important;
                        margin: 3em 0 !important;
                        object-fit: cover;
                    }

                    /* Anil content */
                    .tesi1 .d-flex.justify-content-around>div:nth-child(4) {
                        position: absolute !important;
                        top: 275px !important;
                        right: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi1 .d-flex.justify-content-around>div:nth-child(4).bg5 {
                        position: relative !important;
                        width: 60% !important;
                        height: auto !important;
                        margin: -7em 10em !important;
                    }


                    /* =================================
       SLIDE 2
       JENNA TOP-LEFT
       JACOB BOTTOM-RIGHT
    ================================= */

                    .tesi2 .d-flex.justify-content-around {
                        position: relative !important;
                        display: block !important;
                        width: 100% !important;
                        height: 400px !important;
                    }

                    .tesi2 .d-flex.justify-content-around>div:first-child {
                        position: absolute !important;
                        top: 0 !important;
                        left: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi2 .d-flex.justify-content-around>div:last-child {
                        position: absolute !important;
                        top: 180px !important;
                        right: 2% !important;
                        width: 45% !important;
                        margin: 0 !important;
                    }

                    .tesi2 .bg3 {
                        position: relative !important;
                        width: 100% !important;
                        height: auto !important;
                        margin: -8% 0 !important;
                    }

                    .tesi2 img {
                        width: 60% !important;
                        height: 100px !important;
                        margin: auto !important;
                        object-fit: cover;
                    }


                    /* =================================
       SLIDE 3
       JULIYANA TOP-LEFT
       ANNA BOTTOM-RIGHT
    ================================= */

                    .tesi3>div>div {
                        position: relative !important;
                        display: block !important;
                        width: 100% !important;
                        height: 400px !important;
                    }

                    .tesi3 .bg {
                        position: absolute !important;
                        top: 20px !important;
                        left: 2% !important;
                        width: 45% !important;
                        height: auto !important;
                        margin: 0 !important;
                    }

                    .tesi3 .bg1 {
                        position: absolute !important;
                        top: 190px !important;
                        right: 2% !important;
                        width: 45% !important;
                        height: auto !important;
                        margin: 0 !important;
                    }

                    .tesi3 .bg-light {
                        display: none !important;
                    }

                    .tesi3 .bg img,
                    .tesi3 .bg1 img {
                        width: 55% !important;
                        height: 90px !important;
                        margin: auto !important;
                    }


                    /* =================================
       TEXT
    ================================= */

                    .tesi1 .bg5 p,
                    .tesi2 .bg3 p,
                    .tesi3 .bg p,
                    .tesi3 .bg1 p {
                        font-size: 11px !important;
                        line-height: 1.3 !important;
                    }

                    .tesi1 .bg5 p:last-child,
                    .tesi2 .bg3 p:last-child {
                        font-size: 15px !important;
                    }


                    /* Carousel buttons */
                    .contact1 .carousel-control-prev,
                    .contact1 .carousel-control-next {
                        width: 7% !important;
                    }
                }

                @media (max-width: 750px) {

                    .neww {
                        width: 100% !important;
                        overflow: hidden;
                    }

                    .neww>div {
                        width: 100% !important;
                    }

                    /* Heading */
                    .neww h1 {
                        font-size: 30px !important;
                    }

                    /* Main content */
                    .neww .d-flex.gap-5.p-5 {
                        display: flex !important;
                        flex-direction: column !important;
                        align-items: center !important;
                        gap: 25px !important;
                        padding: 25px 15px !important;
                    }




                    /* Meet Us */
                    .neww .meet {
                        width: 100% !important;
                        text-align: center;
                    }

                    .neww .meet h1 {
                        padding: 10px !important;
                        font-size: 26px !important;
                    }

                    .neww .meet .d-flex {
                        justify-content: center !important;
                    }

                    .neww .meet p {
                        margin: 0 !important;
                        font-size: 15px;
                    }

                    /* Contact form */
                    .neww .cont {
                        width: 65% !important;
                        margin-top: -23em !important;
                        margin-left: 5em !important;
                        text-align: center;
                        height: 45vh !important;
                    }

                    .neww .cont h2 {
                        font-size: 25px !important;
                    }

                    .neww .cont input,
                    .neww .cont textarea {
                        width: 90% !important;
                        display: block;
                        margin: 10px auto !important;
                        box-sizing: border-box;
                    }

                    .neww .cont input {
                        height: 45px;
                    }

                    .neww .cont textarea {
                        height: 120px;
                    }

                    .neww .cont button {
                        width: 40% !important;
                        padding: 8px !important;
                    }


                    .get {
                        margin-top: -3em !important;
                    }



                    .featur {
                        display: flex;
                        flex-wrap: wrap;
                        height: 95vh;
                        margin-top: 4em !important;
                    }

                    .featur h1 {
                        margin-top: 2px !important;
                    }

                    .explain p {
                        font-size: 12px;
                        text-align: center;
                        margin-right: -10% !important;
                        /* padding-left: 4em !important; */
                    }


                }
            </style>


        </head>

        <body>

            <div class="main ">
                <?php include("header.php"); ?>



                <div class="position-relative d-flex respon">
                    <div class="about d-flex justify-center  gap-5" id="home">
                        <div class="left ">
                            <div class="d-flex flex-column ">
                                <h1 class="text "><i> Best Coffee</i></h1>
                                <h5 class="fs-2 pt-3 p-0 m-0">Make your day great with our</h5>
                                <h5 class="fs-2 p-0 m-0">special coffee!</h5>
                                <p style="font-size: 22px;" class="pt-2 p-0 m-0">Welcome to our Coffee paradise, where every bean tells</p>
                                <p style="font-size: 22px;" class="p-0 m-0">a story and every cup sparkes joy</p>
                            </div>
                            <div class="d-flex gap-4 pt-4 order">

                                <a href="catalogue.php"
                                    class="btn  order"
                                    id="button"
                                    style="display:inline-block; text-decoration:none; cursor:pointer; position:relative; z-index:1; pointer-events:auto; height:6vh;">
                                    Order Now
                                </a>
                                <a href="support.php"
                                    id="button1"
                                    style="display:inline-flex;
          align-items:center;
          gap:8px;
          padding:8px 28px;
          background:#ffffff;
          color:#000;
          text-decoration:none;
          border-radius:50px;
          border:2px solid #6F4E37;
          cursor:pointer;
          position:relative;
          z-index:1;
          pointer-events:auto;">
                                    <i class="fa-solid fa-headset"></i> Support
                                </a>
                            </div>
                        </div>
                        <div class="Slider-Right gap-4">
                            <div class="Slider-Right-inner">
                                <img src="./images/cup1.png" />
                                <img src="./images/cup2.png" />
                                <img src="./images/cup3.png" />
                            </div>
                        </div>
                    </div>


                    <!-- <h1>Special Features :</h1> -->
                    <div class="position-absolute  special d-flex gap-5 justify-content-center " style="width: 100%;">
                        <div class="bg-light rounded-3 border  abc" style="width: 100%; height: 30vh;">
                            <div class="d-flex justify-content-between p-2">
                                <h3 class="paragraph">Our Catering</h3>
                                <img src="./Png/plate-removebg-preview.png" style="width: 15%; height: 9vh;" />
                            </div>
                            <p class="px-3 " style="width: 90%; font-size: 17px;">Catering involves preparing and serving food , handling everything from menu planning and cooking to service , allowing hosts to focus on guests.</p>
                        </div>
                        <div class="bg-light rounded-3  border  abc" style="width: 100%; height: 30vh;">
                            <div class="d-flex justify-content-between p-2">
                                <h3 class="paragraph">The food</h3>
                                <img src="./images/burger.png" style="width: 15%; height: 9vh;" />
                            </div>
                            <p class="px-3 " style="width: 90%; font-size: 17px;">Coffee snacks range from sweet treats like donuts, croissants, and chocolate to savory options such as bacon, grilled cheese, and hard cheeses. </p>
                        </div>
                        <div class="bg-light rounded-3  border abc" style="width: 100%; height: 30vh;">
                            <div class="d-flex justify-content-between p-2">
                                <h3 class="paragraph">The Gelato</h3>
                                <img src="./Png/gelato-removebg-preview.png" style="width: 15%; height: 9vh;" />
                            </div>
                            <p class="px-3 " style="width: 90%; font-size: 17px;">Gelato is a traditional a dense, creamy , achieved by using more milk than cream, less air, and a slower churning process than traditional ice cream. </p>
                        </div>
                    </div>
                </div>

                <!-- <div class="footer1">
          <img src="./images/firstfooter.jpg" style=" background-repeat: no-repeat; background-size: 100% 100%; margin: 2% 5%; width: 90%; height: 40vh;">
        </div> -->

                <div class="mainvideo" style="width:99%; display:flex; justify-content:center; gap:10px; padding: 200px  50px; ">


                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/coffeemaking.mp4" type="video/mp4">
                    </video>

                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/snacks.mp4" type="video/mp4">
                    </video>



                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/coldbeverage.mp4" type="video/mp4">
                    </video>



                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/dessert.mp4" type="video/mp4">
                    </video>

                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/pastry.mp4" type="video/mp4">
                    </video>

                    <video class="video" autoplay muted loop style="border-radius: 10px;  width:70%;   height:40vh; object-fit:cover; filter:brightness(100%) contrast(110%);">
                        <source src="./images/icecream.mp4" type="video/mp4">
                    </video>




                </div>



                <div class="details d-flex flex-column text-center " style="margin-top:-10%;">
                    <h1 class="text offer pt-5">OUR DELICIOUR OFFER</h1>
                    <h5 class="pt-2 dark">I am hoping to see you at the Savor Seattle show ! If you want to</h5>
                    <h5 class="dark">visit my booth, please here for the address</h5>
                    <!-- <div class="d-flex justify-content-evenly pt-5  need"> -->
                    <div class="need pt-5">
                        <div class="type">
                            <img src="./Png/cup.png" class="logo" />
                            <h4 class="pt-2">TYPE OF COFFEE</h4>
                            <p class="dark pt-2 p-0 m-0">This is the standard in coffee. It is the </p>
                            <p class="dark p-0 m-0">most common and most popular</p>
                            <p class="dark p-0 m-0">style.</p>
                        </div>
                        <div class="type">
                            <img src="./Png/bean.png" class="logo" />
                            <h4 class="pt-3">BEAN VARIETIES</h4>
                            <p class="dark pt-2 p-0 m-0">The experimental design included a</p>
                            <p class="dark p-0 m-0">randomized complete block.</p>
                        </div>
                        <div class="type">
                            <img src="./Png/base.png" class="logo" />
                            <h4 class="pt-2">COFFEE & PASTRY</h4>
                            <p class="dark pt-2 p-0 m-0">This is standard in coffee & pastry. It</p>
                            <p class="dark p-0 m-0">is the most common and most</p>
                            <p class="dark p-0 m-0">popular style.</p>
                        </div>
                        <div class="type">
                            <img src="./Png/glass.png" class="logo" style="width: 18%;" />
                            <h4 class="pt-2">COFFEE TO GO</h4>
                            <p class="dark pt-2 p-0 m-0">Experimental design included a</p>
                            <p class="dark p-0 m-0">randomized complete block design</p>
                            <p class="dark p-0 m-0">with there</p>
                        </div>
                    </div>
                </div>


                <div class="about_details">
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
                            <a href="about.php"><button class="btn" type="submit" id="button3" style="width:15%;  margin:5% 43%; ">Explore more</button></a>

                        </div>
                    </div>
                </div>



                <div class="new d-flex ">
                    <div class="" style="width: 50%;">
                        <img src="./images/realman.jpg" style="width: 80%; height: 60vh;" />
                    </div>
                    <div class="pt-5" style="width: 60%;">
                        <h1>Indian New Excusive Coffee</h1>
                        <p class="dark pt-5 p-0 m-0 fs-5">Our <span class="text-warning">CoffeeShop </span>uses all type of coffee. All commercially Produced coffee originates</p>
                        <p class="dark  p-0 m-0 fs-5"> from India. The coffee is balanced by its sweet honey notes, creating soft, light</p>
                        <p class="dark p-0 m-0 fs-5"> notes with a light character. There are people who can't start their day without</p>
                        <p class="dark p-0 m-0 fs-5"> having a freshly brewed cup of coffe and we understand them.</p>
                        <div class="pt-4 ">
                            <a href="service.php"><button class="btn btn-dark" type="submit">READ MORE</button></a>
                            <button class="btn btn-dark" type="submit">SHOP NOW</button>
                        </div>
                    </div>
                </div>
                <div class="footer2">

                </div>


                <div class="popular p-5 ">
                    <h1 class="d-flex justify-content-center pt-5">POPULAR CATEGORIES</h1>
                    <div class="d-flex justify-content-around ">
                        <div class="d-flex gap-5 pt-3 flex-wrap">
                            <div class="d-flex justify-content-center align-items-center gap-5" style="width: 100%;">
                                <img src="./images/IMG-20250823-WA0054.jpg" style="width: 30%; height: 50vh;" class="rounded-3 scrol wow animate__animated animate__zoomIn" data-wow-delay="0.1s">
                                <img src="./images/IMG-20250823-WA0027.jpg" style="width: 20%; height: 35vh;" class="rounded-3 scroll wow animate__animated animate__zoomIn" data-wow-delay="0.1s">
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-5" style="width: 100%;">
                                <img src="./images/IMG-20250823-WA0026.jpg" style="width: 20%; height: 35vh;" class="rounded-3 scroll wow animate__animated animate__zoomIn" data-wow-delay="0.1s">
                                <img src="./images/IMG-20250823-WA0055.jpg" style="width: 30%; height: 50vh;" class="rounded-3 scrol wow animate__animated animate__zoomIn" data-wow-delay="0.1s">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="SHOP">
                    <div class="test d-flex  justify-content-center align-items-center flex-wrap " style="width: 100%; height: 100vh;  ">
                        <div class="d-flex  p-2" style="width: 100%;">
                            <div class="d-flex align-items-center justify-center img1" style="width: 37%;">
                                <img src="./images/IMG-20250823-WA0031.jpg" style="width: 90%; height: 45vh;">
                            </div>
                            <div class="d-flex flex-column align-items-center justify-center p-3" style="width: 33%;">
                                <h1 class="p-0 m-0">Change To</h1>
                                <h1 class="p-0 m-0">Have An</h1>
                                <h1 class="p-0 m-0">Amazing</h1>
                                <h1>Morning</h1>
                                <button class="btn" type="submit" id="button3"><a href="catalogue.php" style="text-decoration: none; color:#fff;">Order Now</a></button>
                            </div>
                            <div class="d-flex align-items-center justify-center flex-column img2" style="width: 50%;">
                                <img src="./images/IMG-20250823-WA0030-removebg-preview.png " style="width: 80%; height: 35vh;">
                                <p class="p-0 m-0 fs-5">Lorem ipsum dolor sit amet consectetur </p>
                                <p class="p-0 m-0 fs-5">adipisicing elit. Veritatis eum hujiu vits</p>
                                <p class="p-0 m-0  fs-5">voluptatibus corporis vitae repellat ghy</p>
                                <p class="p-0 m-0 fs-5">saepe gsoluta a maiores eaque ghgryy</p>
                            </div>
                        </div>


                        <div class="d-flex gap-5" style="width: 100%;">
                            <div class=" img1" style="width: 40%;">
                                <h1 class="p-0 m-0">Choose Your</h1>
                                <h1 class="p-0 m-0">Favorite</h1>
                                <h1 class="p-0 m-0">Test</h1>
                                <p class="p-0 m-0 fs-5">Lorem ipsum dolor sit amet consectetur </p>
                                <p class="p-0 m-0 fs-5">adipisicing elit. Veritatis eum hujiu vits</p>
                                <p class="p-0 m-0 fs-5">voluptatibus corporis vitae repellat ghy</p>
                                <button class="btn" type="submit" id="button3"><a href="gallery.php" style="text-decoration: none; color:#fff;">Order Now</a></button>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-center">
                                <img src="./images/IMG-20250823-WA0025.jpg" style="width: 100%; height: 42vh;">
                            </div>
                            <div class="d-flex align-items-center justify-center flex-column img2">
                                <img src="./images/IMG-20250823-WA0034.jpg" style="width: 100%; height: 42vh;">
                            </div>
                        </div>
                    </div>
                </div>






                <!-- timing -->
                <div style="padding-top: 7%;">
                    <div class="">
                        <h1 class="fw-bold  text-center text-warning-emphasis " style="text-decoration: underline;">OPENING</h1>
                        <div class="hr">
                            <p class="text-warning fs-2" style="padding-top: 8px;">...Opening hours...</p>
                        </div>
                        <div class="open" style="width: 100%; height: 60vh;">
                            <img src="./images/time.png" style="width: 35%; height: 60vh; margin-left: 33%;">
                        </div>
                    </div>
                </div>
                <!-- timing end -->


                <!-- seating arrangement -->


                <h1 class="seat-title">☕ Seating Arrangement</h1>

                <div class="seat-grid">

                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat1.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹500</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat1.jpeg&price=500&table=1">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>

                    <!-- VIP CARD -->
                    <div class="seat-card vip">

                        <div class="img-box">
                            <img src="./images/seat2.jpeg">

                            <div class="overlay vip-overlay"></div>

                            <span class="badge vip-badge">VIP LOUNGE</span>

                            <div class="price-tag vip-price">₹2500</div>
                        </div>

                        <div class="seat-info">

                            <h3>Royal Lounge Table</h3>

                            <p>Exclusive private seating with premium service & priority care</p>

                            <a href="book.php?img=seat2.jpeg&price=2500&special=1&table=2">
                                <button class="book-btn vip-btn">Unlock Luxury Table</button>
                            </a>

                        </div>

                    </div>





                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat3.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹1000</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat3.jpeg&price=1000&table=3">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>





                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat4.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹500</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat4.jpeg&price=500&table=4">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>







                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat5.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹900</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat5.jpeg&price=900&table=5">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>



                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat6.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹1000</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat6.jpeg&price=1000&table=6">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>



                    <div class="seat-card vip">

                        <div class="img-box">
                            <img src="./images/seat7.jpeg">

                            <div class="overlay vip-overlay"></div>

                            <span class="badge vip-badge">VIP LOUNGE</span>

                            <div class="price-tag vip-price">₹2500</div>
                        </div>

                        <div class="seat-info">

                            <h3>Royal Lounge Table</h3>

                            <p>Exclusive private seating with premium service & priority care</p>

                            <a href="book.php?img=seat7.jpeg&price=2500&special=2&table=7">
                                <button class="book-btn vip-btn">Unlock Luxury Table</button>
                            </a>

                        </div>

                    </div>




                    <!-- CARD -->
                    <div class="seat-card">

                        <div class="img-box">
                            <img src="./images/seat8.jpeg">

                            <div class="overlay"></div>

                            <span class="badge" style="color: #e47908;">Standard</span>

                            <div class="price-tag">₹1000</div>
                        </div>

                        <div class="seat-info">

                            <h3>Cozy Corner Table</h3>

                            <p>Private warm seating with café view ambience</p>

                            <a href="book.php?img=seat8.jpeg&price=1000&table=8">
                                <button class="book-btn">Reserve Experience</button>
                            </a>

                        </div>
                    </div>



                    <div class="seat-card vip">

                        <div class="img-box">
                            <img src="./images/seat9.jpeg">

                            <div class="overlay vip-overlay"></div>

                            <span class="badge vip-badge">VIP LOUNGE</span>

                            <div class="price-tag vip-price">₹3500</div>
                        </div>

                        <div class="seat-info">

                            <h3>Royal Lounge Table</h3>

                            <p>Exclusive private seating with premium service & priority care</p>

                            <a href="book.php?img=seat9.jpeg&price=3500&special=3&table=9">
                                <button class="book-btn vip-btn">Unlock Luxury Table</button>
                            </a>

                        </div>

                    </div>


                </div>





                <!-- seating arrangement -->

                <!-- why Choose -->
                <div style="margin-top: 3%; background-color: #f4e3e6; " class="why-us">
                    <div class="p-5">
                        <h1 class="d-flex justify-content-center   fw-bold fs-1" style="color: #be9058;">Why Choose Us</h1>
                    </div>
                    <div class="d-flex justify-content-center " style="width:100%;">
                        <div class="p-2" style="width: 33%;">
                            <img src="./images/IMG-20250823-WA0029.jpg" style="width: 85%; height: 55vh;">
                        </div>
                        <div class="">
                            <h2 class="fw-bold m-0 p-0">Unleash The Flavor Of Perfect Coffee</h2>
                            <p class="m-0 p-0 fs-5">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque quas praesent.</p>
                            <p class="m-0 p-0 fs-5">omnis ab molestiae optio iure! Enim provident, itaque consequuntur mollitia</p>

                            <div class="m-0 p-0">
                                <img src=>
                                <h2 class="fw-bold m-0 p-0">50+ Kinds of Coffee Beans</h2>
                            </div>
                            <p class="m-0 p-0 fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                            <p class="m-0 p-0 fs-5">Praesentium suscipit officia recusandae assumenda </p>

                            <div class="">
                                <img src=>
                                <h2 class="fw-bold m-0 p-0">100% IOS Certification</h2>
                            </div>

                            <p class="m-0 p-0 fs-5">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            <p class="m-0 p-0 fs-5">Praesentium suscipit officia recusandae assumenda </p>
                            <div class="pt-2">
                                <a href="about.php"><button class="btn " type="submit" id="button3" style="width: 22%; height: 6vh;">Explore more</button></a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- why Choose end -->



                <!-- testimonial -->
                <div class="contact1 " id="Testimonial">
                    <div class="container-fluid ">
                        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item  active ">
                                    <div class="tesi1 ">
                                        <h1 class="d-flex justify-content-center pt-3 ">Testimonial</h1>
                                        <div class="">
                                            <div class="d-flex justify-content-around  pt-2 ">
                                                <div class="" style="margin-left: -5%;">
                                                    <img src="./images/tes1.jpg" class="rounded-bottom-5 rounded-end-0    d-flex" style="width: 80%;  height: 23vh;">

                                                </div>
                                                <div class="bg5  position-absolute rounded-3" style="width: 21%; height: 42vh; margin-left: -17%; margin-top: 4%;">

                                                    <p class="pt-3 text-center fs-5 m-0 p-2"><i class="fa-solid fa-quote-left text-warning "></i> It's a great experience to be part of Tanushree's this <span class="text-warning">"Aroma Haven"</span>.
                                                        She is a amazing person and powerful source of support. It's her supportive throughtout the journey. <i class="fa-solid fa-quote-right text-warning"></i>
                                                    <div class="m-0 p-0 text-warning text-center"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star text-light"></i></div>
                                                    </p>
                                                    <p class=" m-0 p-0 fs-4 text-center text-warning-emphasis fw-bold">- Olivia Wilson</p>
                                                </div>

                                                <div class="">
                                                    <img src="./images/tes2.jpg" class="rounded-top-5 rounded-end-0 d-flex" style="width: 80%; height: 23vh; margin-left: -26%;">
                                                </div>
                                                <div class="bg5 position-absolute rounded-3   anil" style="width: 21%; height: 42vh; margin-left: 47%; margin-top: 4%;">
                                                    <p class="pt-3 text-center fs-5 m-0 p-2"><i class="fa-solid fa-quote-left text-warning "></i> It's a great experience to be part of Tanushree's this <span class="text-warning">"Aroma Haven"</span>.
                                                        She is a amazing person and powerful source of support. It's her supportive throughtout the journey. <i class="fa-solid fa-quote-right text-warning"></i>
                                                    <div class="m-0 p-0 text-warning text-center"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star text-light"></i></div>
                                                    </p>
                                                    <p class=" m-0 p-0 fs-4 text-center text-warning-emphasis fw-bold">- Anil Sharma</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="carousel-item">
                                    <div class="tesi2">
                                        <h1 class="d-flex justify-content-center pt-3">Testimonial</h1>
                                        <div class="">
                                            <div class="d-flex justify-content-around ">
                                                <div class="">
                                                    <div class=" position-relative z-3 pt-4">
                                                        <img src="./images/tes3.jpg" class="rounded-circle d-flex bg4" style="width: 90%; height: 16vh; margin-left: 9%;">
                                                    </div>
                                                    <div class="bg3 opacity-75 position-absolute rounded-3" style="width: 28%; height: 40vh; margin-left: -9%; margin-top: -5%;">
                                                        <div class="m-0 p-0 text-warning text-center  star"><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star text-success-emphasis"></i></div>
                                                        <p class="text-success-emphasis fs-5 p-2 m-0"><i class="fa-solid fa-quote-left text-light "></i> I really like their service, the seller's response is fast, and the delivery of the goods
                                                            are fast and better quality of the product is really good. <i class="fa-solid fa-quote-right text-light"></i></p>
                                                        <p class="m-0 p-0 fs-4 text-center text-light fw-bold">- Jenna Williams</p>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="position-relative z-3 pt-3">
                                                        <img src="./images/tes4.jpeg " class="rounded-circle d-flex bg4 " style="width: 100%; height: 17vh; margin-left: -14%;">
                                                    </div>
                                                    <div class="bg3 opacity-75 position-absolute rounded-3" style="width:   28%; height: 40vh;  margin-left: -11%; margin-top: -5%; ">
                                                        <div class="m-0 p-0 text-warning text-center  star"><i class="fa-solid fa-star "></i><i class="fa-solid fa-star "></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star text-success-emphasis"></i></div>
                                                        <p class="text-success-emphasis fs-5 p-2 m-0"><i class="fa-solid fa-quote-left text-light "></i> I really like their service, the seller's response is fast, and the delivery of the goods
                                                            are fast and better quality of the product is really good. <i class="fa-solid fa-quote-right text-light"></i></p>
                                                        <p class="m-0 p-0 text-center fs-4 text-light fw-bold">- Jacob Green</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="">
                                        <div class="tesi3">
                                            <h1 class="d-flex justify-content-center  pt-3">Testimonial</h1>
                                            <div class="">
                                                <div class="d-flex justify-content-around gap-5 pt-3">
                                                    <div class="bg-light opacity-75 position-absolute rounded-4" style="width: 26%; height: 45vh; margin-left: -30%;">
                                                        <div class="text-center p-2 ">
                                                            <i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>
                                                        </div>
                                                        <p class="fs-4 text-center m-0 p-0">- Juliyana Silva</p>

                                                    </div>

                                                    <div class="bg position-relative  rounded-3 " style=" margin-top: 8%; width: 32%; height: 30vh; ">
                                                        <p class="m-0 p-2 fs-5 "> <i class="fa-solid fa-quote-left text-warning"></i> It's a great experience to be part of Tanushree's this <span class="text-warning">"Aroma Haven"</span>.
                                                            She is a amazing person and powerful source of support. It's her supportive throughtout the journey. <i class="fa-solid fa-quote-right text-warning"></i></p>
                                                        <div class="" style="padding-left: 29%;">
                                                            <img src="./images/tes5.jpg" class="rounded-circle d-flex border border-5 border-white " style="width: 50%; height: 17vh; ">
                                                        </div>

                                                    </div>
                                                    <div class="bg-light opacity-75 position-absolute rounded-4" style="width: 26%; height: 45vh; margin-left: 30%;">
                                                        <div class="text-center p-2 ">
                                                            <i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i><i class="fa-solid fa-star text-warning"></i>
                                                        </div>
                                                        <p class="fs-4 text-center m-0 p-0">- Anna Jacob</p>
                                                    </div>
                                                    <div class="bg1 position-relative  rounded-3 " style=" margin-top: 7.5%; width: 32%; height: 30vh;   margin-left: -19%; ">
                                                        <p class="m-0 p-2 fs-5 "> <i class="fa-solid fa-quote-left text-warning "></i> It's a great experience to be part of Tanushree's this <span class="text-warning">"Aroma Haven"</span>.
                                                            She is a amazing person and powerful source of support. It's her supportive throughtout the journey. <i class="fa-solid fa-quote-right text-warning"></i></p>
                                                        <div class="" style="padding-left: 29%;">
                                                            <img src="./images/tes6.jpg" class="rounded-circle d-flex border border-5 border-white" style="width: 52%; height: 17vh;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- testimonial  end-->

                    <!-- contact -->
                    <div class="neww" id="contact">

                        <div class="">
                            <div class="footer4"></div>
                            <h1 class="text-center text-light p-5 fw-bold   get">Get in touch</h1>


                            <div class="d-flex gap-5 p-5">
                                <div class="map ">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29660.96048245819!2d87.56314247175585!3d21.67863239395886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a032d15a99538cf%3A0x2cbfb146e598b778!2sRamnagar%20I%2C%20West%20Bengal%20721441!5e0!3m2!1sen!2sin!4v1761633902809!5m2!1sen!2sin" width="470" height="270" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                                <div class="meet ">
                                    <h1 class="fw-bold py-4">Meet Us</h1>
                                    <div class="d-flex gap-2 ">
                                        <i class="fa-solid fa-phone p-1"></i>
                                        <p>+9645746985</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <i class="fa-brands fa-instagram p-1"></i>
                                        <p>contact@admin.com</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <i class="fa-solid fa-location-dot p-1"></i>
                                        <p>1784 Ramnagar Road</p>
                                    </div>
                                </div>
                                <div class="cont">

                                    <h2 class="p-3 fw-bold">Contact Us</h2>

                                    <input
                                        type="text"
                                        id="contactName"
                                        placeholder="Name"
                                        required>

                                    <textarea
                                        id="contactMessage"
                                        placeholder="Message"
                                        required></textarea>

                                    <button
                                        class="btn rounded-4 text-light"
                                        type="button"
                                        onclick="sendMessage()">

                                        Send

                                    </button>

                                </div>

                                <div class="contact-card" id="contactCard">

                                    <button
                                        type="button"
                                        class="close-contact"
                                        onclick="closeContactCard()">

                                        &times;

                                    </button>

                                    <div class="contact-success-icon">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </div>

                                    <h3>Message Sent!</h3>

                                    <p>
                                        Thank you for contacting Aroma Haven.
                                        We'll get back to you soon!
                                    </p>

                                    <button
                                        type="button"
                                        class="contact-continue-btn"
                                        onclick="closeContactCard()">

                                        Continue

                                    </button>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>



                <?php include("footer.php"); ?>



            </div>

            <script src="script.js"></script>
            <script src="search.js"></script>

            <script src="assets/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function redirectPage(select) {

                    let page = select.value;

                    if (page != "") {

                        window.location.href = page;
                    }

                    select.selectedIndex = 0;
                }


                function toggleCart(id, name, image, price) {

                    let btn = document.getElementById("cartBtn" + id);

                    let action =
                        btn.innerText.includes("Add") ?
                        "add" :
                        "remove";

                    fetch("cart_action.php", {

                            method: "POST",

                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },

                            body:

                                `product_id=${id}
        &name=${encodeURIComponent(name)}
        &image=${encodeURIComponent(image)}
        &price=${price}
        &action=${action}`

                        })

                        .then(res => res.json())

                        .then(data => {

                            document.getElementById("cartCount")
                                .innerText = data.cart_count;

                            document.getElementById("cartItems")
                                .innerHTML = data.cart_html;





                            if (action == "add") {

                                btn.innerHTML =
                                    `<i class="fa-solid fa-trash"></i>
            Remove`;

                                btn.style.background =
                                    "linear-gradient(135deg,#c40000,#ff2020)";

                                showToast("🛒 Added To Cart");

                            } else {

                                btn.innerHTML =
                                    `<i class="fa-solid fa-cart-shopping"></i>
            Add To Cart`;

                                btn.style.background =
                                    "linear-gradient(135deg,#58260f,#7a1f06)";

                                showToast("❌ Removed From Cart");

                            }

                        });

                }

                function toggleWishlist(id, name, image, price) {

                    let icon = event.target;

                    let action = icon.classList.contains("active") ?
                        "remove" :
                        "add";

                    fetch("wishlist_action.php", {

                            method: "POST",

                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },

                            body:

                                `product_id=${id}
&product_name=${encodeURIComponent(name)}
&product_image=${encodeURIComponent(image)}
&price=${price}
&action=${action}`

                        })

                        .then(res => res.json())

                        .then(data => {

                            if (action == "add") {

                                icon.classList.remove("fa-regular");
                                icon.classList.add("fa-solid");
                                icon.classList.add("active");

                                showToast("❤️ Added To Wishlist");

                            } else {

                                icon.classList.remove("fa-solid");
                                icon.classList.remove("active");
                                icon.classList.add("fa-regular");

                                showToast("💔 Removed From Wishlist");

                            }

                            document.getElementById("wishlistCount")
                                .innerText = data.wishlist_count;

                        });

                }



                function loadWishlist() {

                    fetch("wishlist_action.php", {

                            method: "POST",

                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },

                            body: "action=load"

                        })

                        .then(res => res.json())

                        .then(data => {

                            document.getElementById("wishlistCount")
                                .innerText =
                                data.wishlist_count;

                        });

                }




                function removeCart(product_id) {

                    fetch("cart_action.php", {

                            method: "POST",

                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },

                            body: `product_id=${product_id}
        &action=remove`

                        })

                        .then(res => res.json())

                        .then(data => {

                            document.getElementById("cartItems")
                                .innerHTML = data.cart_html;

                            document.getElementById("cartCount")
                                .innerText = data.cart_count;

                            showToast("❌ Removed");

                        });

                }


                function sendMessage() {

                    let name = document.getElementById("contactName").value.trim();
                    let message = document.getElementById("contactMessage").value.trim();

                    if (name === "" || message === "") {
                        return;
                    }

                    document
                        .getElementById("contactCard")
                        .classList
                        .add("show");
                }

                function closeContactCard() {

                    document
                        .getElementById("contactCard")
                        .classList
                        .remove("show");

                    document.getElementById("contactName").value = "";
                    document.getElementById("contactMessage").value = "";
                }
            </script>
        </body>

        </html>