<?php

$img = $_GET['img'] ?? '';
$price = $_GET['price'] ?? 0;
$special = $_GET['special'] ?? 0;
$table = $_GET['table'] ?? '';

$img = trim($img);
$table = trim($table);
$price = (float)$price;

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Elite Table Booking | Aroma Haven</title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
>

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap"
    rel="stylesheet"
>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --coffee:#6f4325;
    --gold:#c79a45;
    --cream:#fff7e8;
    --brown:#3b2415;
}

body{

    font-family:'Inter',sans-serif;

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:20px;

    background:
        radial-gradient(
            circle at top left,
            #fff0cf,
            transparent 35%
        ),
        radial-gradient(
            circle at bottom right,
            #f0c98b,
            transparent 40%
        ),
        linear-gradient(
            135deg,
            #fffaf0,
            #f7e4c2
        );

    color:var(--brown);

    overflow-y:auto;

    overflow-x:hidden;
}


/* =========================
   MAIN CARD
========================= */

.card{

    width:1000px;

    max-width:95%;

    display:grid;

    grid-template-columns:55% 45%;

    background:rgba(255,255,255,.65);

    border-radius:35px;

    border:1px solid rgba(199,154,69,.4);

    backdrop-filter:blur(20px);

    box-shadow:
        0 40px 90px
        rgba(120,75,30,.25);

    overflow:hidden;

    max-height:90vh;
}


/* =========================
   IMAGE
========================= */

.image{

    position:relative;

    overflow:hidden;

    min-height:600px;
}

.image img{

    width:100%;

    height:100%;

    object-fit:cover;

    display:block;

    animation:imageZoom 10s infinite alternate;
}

@keyframes imageZoom{

    from{
        transform:scale(1);
    }

    to{
        transform:scale(1.12);
    }
}

.image::after{

    content:"";

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.35),
            transparent
        );
}


/* =========================
   CONTENT
========================= */

.content{

    padding:45px;

    overflow-y:auto;

    max-height:90vh;
}

.content::-webkit-scrollbar{
    width:6px;
}

.content::-webkit-scrollbar-thumb{

    background:var(--gold);

    border-radius:20px;
}


/* =========================
   TITLE
========================= */

h1{

    font-family:'Playfair Display',serif;

    font-size:38px;

    color:#4a2b15;

    letter-spacing:1px;
}

.price{

    margin-top:18px;

    display:inline-block;

    padding:10px 22px;

    border-radius:40px;

    background:#fff;

    border:1px solid #d5ae66;

    color:#9b6b22;

    font-weight:600;

    box-shadow:
        0 10px 25px
        rgba(0,0,0,.08);
}

.luxury-badge{

    display:inline-block;

    margin-top:12px;

    padding:8px 18px;

    border-radius:30px;

    background:#fff1c7;

    color:#8a5b18;

    font-weight:700;
}

.special{

    margin-top:20px;

    padding:15px;

    border-radius:18px;

    background:
        linear-gradient(
            135deg,
            #fff1c7,
            #ffe4a0
        );

    border-left:
        5px solid
        var(--gold);

    color:#704512;
}


/* =========================
   SUMMARY
========================= */

.booking-summary{

    margin-top:20px;

    margin-bottom:20px;

    padding:20px;

    background:
        linear-gradient(
            135deg,
            #fff7e5,
            #fff1cc
        );

    border-radius:20px;

    border:1px solid #e8cf95;
}

.booking-summary h3{

    margin-bottom:10px;

    color:#6f4325;
}

.summary-row{

    display:flex;

    justify-content:space-between;

    gap:15px;

    padding:10px 0;

    border-bottom:
        1px dashed
        #d8c08a;
}

.summary-row:last-child{
    border:none;
}


/* =========================
   INPUTS
========================= */

input,
select,
textarea{

    width:100%;

    margin:10px 0;

    padding:15px 18px;

    background:
        rgba(255,255,255,.8);

    border:
        1px solid
        #e3c58c;

    border-radius:15px;

    color:#4a2b15;

    outline:none;

    transition:.3s;

    font-family:inherit;
}

input:focus,
select:focus,
textarea:focus{

    border-color:#c79a45;

    transform:translateY(-2px);

    box-shadow:
        0 10px 25px
        rgba(199,154,69,.25);
}

textarea{

    min-height:100px;

    resize:vertical;
}


/* =========================
   PAYMENT
========================= */

.payment-box{

    margin-top:25px;

    padding:20px;

    background:#fffaf2;

    border-radius:20px;

    border:1px solid #ecd8ae;
}

.payment-box h3{

    margin-bottom:15px;

    font-size:18px;

    color:#6f4325;
}

.payment-grid{

    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:15px;
}

.pay-card{

    position:relative;

    cursor:pointer;

    background:white;

    border:2px solid #eee;

    border-radius:18px;

    padding:18px;

    text-align:center;

    transition:.3s;
}

.pay-card:hover{

    transform:translateY(-5px);

    box-shadow:
        0 15px 35px
        rgba(0,0,0,.08);
}

.pay-card input{

    display:none;
}

.pay-card:has(input:checked){

    border-color:#c79a45;

    box-shadow:
        0 0 25px
        rgba(199,154,69,.35);

    background:#fff8e8;
}

.logo-img{

    width:90px;

    height:50px;

    object-fit:contain;

    margin-bottom:10px;
}

.pay-card i{

    display:block;

    font-size:40px;

    color:#c79a45;

    margin-bottom:10px;
}


/* =========================
   BUTTON
========================= */

button{

    width:100%;

    margin-top:18px;

    padding:17px;

    border:none;

    border-radius:50px;

    background:
        linear-gradient(
            135deg,
            #d9ad59,
            #b47b24
        );

    color:white;

    font-size:16px;

    font-weight:700;

    cursor:pointer;

    transition:.4s;

    box-shadow:
        0 15px 30px
        rgba(180,123,36,.3);
}

button:hover{

    transform:
        translateY(-4px)
        scale(1.02);
}


/* =========================
   MOBILE
========================= */

@media(max-width:900px){

    body{
        padding:10px;
        align-items:flex-start;
    }

    .card{

        width:100%;

        max-width:100%;

        grid-template-columns:1fr;

        max-height:none;

        margin:0;
    }

    .image{

        height:280px;

        min-height:280px;
    }

    .content{

        padding:25px;

        max-height:none;
    }

    h1{

        font-size:30px;
    }

    .payment-grid{

        grid-template-columns:
            repeat(2,1fr);
    }
}

@media(max-width:500px){

    .payment-grid{

        grid-template-columns:1fr;
    }

    .pay-card{

        padding:15px;
    }

}

</style>

</head>


<body>


<div class="card">


    <!-- =========================
         IMAGE
    ========================== -->

    <div class="image">

        <?php if($img !== ''){ ?>

            <img
                src="./images/<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>"
                alt="Aroma Haven Table"
            >

        <?php } ?>

    </div>



    <!-- =========================
         CONTENT
    ========================== -->

    <div class="content">


        <h1>
            ☕ Elite Coffee Lounge
        </h1>


        <div class="luxury-badge">
            ★★★★★ Luxury Reservation
        </div>


        <p
            style="
                margin-top:12px;
                color:#9b6b22;
            "
        >
            Reserve your private table for a premium
            coffee experience.
        </p>



        <?php if($price > 0){ ?>

            <div class="price">

                ☕ ₹
                <?php
                echo number_format($price,2);
                ?>

                | Premium Experience ✨

            </div>

        <?php } ?>



        <?php if((string)$special === '1'){ ?>

            <div class="special">

                👑 VIP Experience Activated —
                Premium Service Included ✨

            </div>

        <?php } ?>



        <!-- =========================
             SUMMARY
        ========================== -->

        <div class="booking-summary">

            <h3>
                Reservation Summary
            </h3>


            <div class="summary-row">

                <span>
                    Table
                </span>

                <b>
                    <?php
                    echo htmlspecialchars(
                        $table,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </b>

            </div>


            <div class="summary-row">

                <span>
                    Package
                </span>

                <b>
                    Premium Reservation
                </b>

            </div>


            <div class="summary-row">

                <span>
                    Amount
                </span>

                <b>

                    ₹
                    <?php
                    echo number_format(
                        $price,
                        2
                    );
                    ?>

                </b>

            </div>

        </div>



        <!-- =========================
             FORM
        ========================== -->

        <form
            action="booking_payment_redirect.php"
            method="POST"
        >


            <input
                type="hidden"
                name="table_id"
                value="<?php
                    echo htmlspecialchars(
                        $table,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>"
            >


            <input
                type="hidden"
                name="booking_table"
                value="<?php
                    echo htmlspecialchars(
                        $img,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>"
            >


            <input
                type="hidden"
                name="event_image"
                value="<?php
                    echo htmlspecialchars(
                        $img,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>"
            >


            <input
                type="hidden"
                name="amount"
                value="<?php
                    echo htmlspecialchars(
                        $price,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                ?>"
            >


            <input
                type="text"
                name="customer_name"
                placeholder="Full Name"
                required
            >


            <input
                type="tel"
                name="customer_phone"
                placeholder="Phone Number"
                required
            >


            <input
                type="date"
                name="booking_date"
                required
            >


            <input
                type="time"
                name="booking_time"
                required
            >


            <input
                type="number"
                name="people"
                placeholder="Guests"
                min="1"
                value="1"
                required
            >



            <!-- =========================
                 OCCASION
            ========================== -->

            <select
                name="special_event"
                required
            >

                <option
                    value=""
                    selected
                    disabled
                >
                    Select Your Occasion
                </option>


                <option value="Birthday">
                    🎂 Birthday Celebration
                </option>


                <option value="Anniversary">
                    ❤️ Anniversary Evening
                </option>


                <option value="Date">
                    🌹 A Special Date
                </option>


                <option value="Business Meeting">
                    💼 Business Meeting
                </option>


                <option value="Family Gathering">
                    👨‍👩‍👧‍👦 Family Gathering
                </option>


                <option value="Success Celebration">
                    🎉 Success Celebration
                </option>


                <option value="Friend Reunion">
                    🍔☕ Friend Reunion
                </option>


                <option value="Group Study">
                    📚🎒 Group Study
                </option>


                <option value="Other">
                    ☕ Other
                </option>

            </select>



            <textarea
                name="message"
                placeholder="Special requests..."
            ></textarea>



            <!-- =========================
                 PAYMENT
            ========================== -->

            <div class="payment-box">

                <h3>

                    <i class="fas fa-credit-card"></i>

                    Choose Payment Method

                </h3>


                <div class="payment-grid">


                    <label class="pay-card">

                        <input
                            type="radio"
                            name="payment_method"
                            value="PhonePe"
                            required
                        >

                        <img
                            src="./images/phonepe-logo.png"
                            class="logo-img"
                            alt="PhonePe"
                        >

                        <span>
                            PhonePe
                        </span>

                    </label>



                    <label class="pay-card">

                        <input
                            type="radio"
                            name="payment_method"
                            value="Google Pay"
                        >

                        <img
                            src="./images/gpay-logo.png"
                            class="logo-img"
                            alt="Google Pay"
                        >

                        <span>
                            Google Pay
                        </span>

                    </label>



                    <label class="pay-card">

                        <input
                            type="radio"
                            name="payment_method"
                            value="Paytm"
                        >

                        <img
                            src="./images/paytm-logo.png"
                            class="logo-img"
                            alt="Paytm"
                        >

                        <span>
                            Paytm
                        </span>

                    </label>



                    <label class="pay-card">

                        <input
                            type="radio"
                            name="payment_method"
                            value="Cash On Arrival"
                        >

                        <i class="fas fa-money-bill-wave"></i>

                        <span>
                            Pay At Cafe
                        </span>

                    </label>


                </div>

            </div>



            <input
                type="hidden"
                name="payment_status"
                value="Pending"
            >


            <button type="submit">

                👑 Reserve My Luxury Table ☕

            </button>


        </form>


    </div>

</div>


</body>

</html>