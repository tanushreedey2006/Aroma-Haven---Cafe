<?php

session_start();

include "connect.php";

/** @var mysqli $conn */


/* =====================================================
   LOGIN CHECK
===================================================== */

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");

    exit();

}

$user_id = (int)$_SESSION['user_id'];


/* =====================================================
   HELPER
===================================================== */

function cleanValue($value = '')
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/* =====================================================
   OCCASION MAP
===================================================== */

$occasionMap = [

    'Birthday' => [

        'icon' => '🎂',

        'title' =>
            'Birthday Celebration',

        'description' =>
            'A beautiful coffee experience made specially for your celebration.',

        'video' =>
            './images/birthday.mp4'

    ],


    'Anniversary' => [

        'icon' => '❤️',

        'title' =>
            'Anniversary Evening',

        'description' =>
            'Celebrate your special bond with an intimate evening at Aroma Haven.',

        'video' =>
            './images/anniver.mp4'

    ],


    'Date' => [

        'icon' => '🌹',

        'title' =>
            'A Special Date',

        'description' =>
            'Slow down, enjoy your coffee and make another beautiful memory together.',

        'video' =>
            './images/date.mp4'

    ],


    'Business Meeting' => [

        'icon' => '💼',

        'title' =>
            'Business Meeting',

        'description' =>
            'A calm and elegant space for meaningful conversations and ideas.',

        'video' =>
            './images/business.mp4'

    ],


    'Family Gathering' => [

        'icon' => '👨‍👩‍👧‍👦',

        'title' =>
            'Family Gathering',

        'description' =>
            'Bring everyone together for coffee, conversations and unforgettable moments.',

        'video' =>
            './images/family.mp4'

    ],


    'Success Celebration' => [

        'icon' => '🎉',

        'title' =>
            'Success Celebration',

        'description' =>
            'Celebrate your success together with coffee and unforgettable moments.',

        'video' =>
            './images/success.mp4'

    ],


    'Friend Reunion' => [

        'icon' => '🍔☕',

        'title' =>
            'Friend Reunion',

        'description' =>
            'Bring your friends together for coffee and unforgettable moments.',

        'video' =>
            './images/other.mp4'

    ],


    'Group Study' => [

        'icon' => '📚🎒',

        'title' =>
            'Group Study',

        'description' =>
            'Study together with coffee and create unforgettable study moments.',

        'video' =>
            './images/study.mp4'

    ],


    'Other' => [

        'icon' => '☕',

        'title' =>
            'Coffee Experience',

        'description' =>
            'A memorable coffee experience awaits you at Aroma Haven.',

        'video' =>
            './images/coffee3.mp4'

    ],


    'None' => [

        'icon' => '☕',

        'title' =>
            'Coffee Experience',

        'description' =>
            'A memorable coffee experience awaits you at Aroma Haven.',

        'video' =>
            './images/coffee3.mp4'

    ]

];


/* =====================================================
   GET BOOKINGS
===================================================== */

$bookings = [];


$sql = "

    SELECT *

    FROM bookings

    WHERE user_id = ?

    ORDER BY
        booking_date DESC,
        booking_time DESC

";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


if ($stmt) {

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $user_id
    );


    if (mysqli_stmt_execute($stmt)) {

        $result =
            mysqli_stmt_get_result($stmt);


        if ($result) {

            while (
                $row =
                mysqli_fetch_assoc($result)
            ) {

                $bookings[] =
                    $row;

            }

        }

    }


    mysqli_stmt_close($stmt);

}


/* =====================================================
   COUNTS
===================================================== */

$totalBookings =
    count($bookings);

$confirmed = 0;

$pending = 0;


foreach ($bookings as $booking) {

    $bookingStatus =
        strtolower(
            trim(
                $booking['status']
                ?? ''
            )
        );


    if (
        $bookingStatus ===
        'confirmed'
    ) {

        $confirmed++;

    }


    if (
        $bookingStatus ===
        'pending'
    ) {

        $pending++;

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    My Reservations | Aroma Haven
</title>


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{

    background:#f8f2ea;

    color:#241812;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    overflow-x:hidden;
}

:root{

    --dark:#241812;

    --coffee:#5a3828;

    --coffee-light:#8a6048;

    --cream:#f8f2ea;

    --white:#ffffff;

    --muted:#82746b;

    --border:
        rgba(90,56,40,.13);

}


/* =====================================================
   HERO
===================================================== */

.reservation-hero{

    width:100%;

    padding:
        85px
        7%
        75px;

    background:
        linear-gradient(
            135deg,
            #f8f2ea,
            #f0e2d2
        );

    position:relative;

    overflow:hidden;
}

.hero-content{

    max-width:850px;

    position:relative;

    z-index:2;
}

.hero-eyebrow{

    display:inline-flex;

    align-items:center;

    gap:9px;

    padding:
        8px
        14px;

    border:
        1px solid
        rgba(90,56,40,.16);

    border-radius:50px;

    background:
        rgba(255,255,255,.55);

    color:var(--coffee);

    font-size:12px;

    font-weight:700;

    letter-spacing:2px;

    text-transform:uppercase;
}

.hero-content h1{

    margin:
        25px
        0
        15px;

    color:var(--dark);

    font-size:
        clamp(48px,6vw,82px);

    line-height:.98;

    letter-spacing:-3px;
}

.hero-content p{

    max-width:620px;

    color:var(--muted);

    font-size:17px;

    line-height:1.8;
}

.hero-line{

    width:70px;

    height:3px;

    margin-top:32px;

    background:var(--coffee);

    border-radius:20px;
}


/* =====================================================
   SUMMARY
===================================================== */

.reservation-summary{

    width:86%;

    margin:
        -35px
        auto
        75px;

    position:relative;

    z-index:5;

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:18px;
}

.summary-box{

    padding:
        27px
        30px;

    background:var(--white);

    border:
        1px solid
        var(--border);

    border-radius:24px;

    box-shadow:
        0 20px 60px
        rgba(48,31,22,.08);
}

.summary-top{

    display:flex;

    align-items:center;

    justify-content:
        space-between;
}

.summary-label{

    color:var(--muted);

    font-size:12px;

    font-weight:700;

    letter-spacing:1.5px;

    text-transform:uppercase;
}

.summary-icon{

    width:42px;

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:13px;

    background:var(--cream);

    color:var(--coffee);

    font-size:19px;
}

.summary-number{

    margin-top:18px;

    color:var(--dark);

    font-size:43px;

    line-height:1;

    font-weight:700;
}

.summary-caption{

    margin-top:10px;

    color:#9b8d84;

    font-size:13px;
}


/* =====================================================
   EXPERIENCES
===================================================== */

.experiences-section{

    width:86%;

    margin:
        0
        auto
        80px;
}

.experiences-header{

    display:flex;

    align-items:flex-end;

    justify-content:
        space-between;

    margin-bottom:30px;
}

.section-eyebrow{

    color:var(--coffee-light);

    font-size:11px;

    font-weight:800;

    letter-spacing:2px;
}

.experiences-title h2{

    margin:
        8px
        0
        6px;

    color:var(--dark);

    font-size:38px;
}

.experiences-title p{

    color:var(--muted);

    font-size:14px;
}

.experience-count{

    display:flex;

    align-items:baseline;

    gap:7px;

    color:var(--muted);
}

.experience-count strong{

    color:var(--dark);

    font-size:27px;
}


/* =====================================================
   RESERVATION LIST
===================================================== */

.reservations-list{

    display:flex;

    flex-direction:column;

    gap:28px;
}

.reservation-card{

    overflow:hidden;

    background:white;

    border:
        1px solid
        var(--border);

    border-radius:28px;

    box-shadow:
        0 15px 55px
        rgba(48,31,22,.07);
}


/* =====================================================
   HEADER
===================================================== */

.reservation-header{

    min-height:78px;

    padding:
        20px
        28px;

    display:flex;

    align-items:center;

    justify-content:
        space-between;

    border-bottom:
        1px solid
        var(--border);
}

.reservation-meta{

    display:flex;

    align-items:center;

    gap:13px;
}

.reservation-label{

    color:#9b8d84;

    font-size:10px;

    font-weight:800;

    letter-spacing:1.8px;
}

.booking-id{

    color:var(--dark);

    font-size:15px;
}


/* =====================================================
   STATUS
===================================================== */

.status{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:
        8px
        13px;

    border-radius:50px;

    font-size:11px;

    font-weight:800;

    text-transform:uppercase;
}

.status-dot{

    width:7px;

    height:7px;

    border-radius:50%;
}

.status.confirmed{

    background:#edf7ef;

    color:#357344;
}

.status.confirmed .status-dot{

    background:#4e9a5d;
}

.status.pending{

    background:#fff6e6;

    color:#a56b15;
}

.status.pending .status-dot{

    background:#d99a31;
}

.status.cancelled{

    background:#fbeeee;

    color:#a34848;
}

.status.cancelled .status-dot{

    background:#c65b5b;
}


/* =====================================================
   OCCASION VIDEO
===================================================== */

.occasion-card{

    height:350px;

    position:relative;

    overflow:hidden;

    background:#30221b;
}

.occasion-video{

    width:100%;

    height:100%;

    object-fit:cover;

    display:block;
}

.occasion-overlay{

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            90deg,
            rgba(25,16,12,.84),
            rgba(25,16,12,.35),
            rgba(25,16,12,.12)
        );
}

.occasion-content{

    position:absolute;

    left:45px;

    right:30px;

    bottom:42px;

    max-width:520px;

    color:white;
}

.occasion-tag{

    display:inline-block;

    margin-bottom:15px;

    padding:
        7px
        11px;

    border:
        1px solid
        rgba(255,255,255,.3);

    border-radius:50px;

    background:
        rgba(255,255,255,.1);

    font-size:9px;

    font-weight:800;

    letter-spacing:1.8px;
}

.occasion-icon{

    margin-bottom:7px;

    font-size:34px;
}

.occasion-content h3{

    margin-bottom:8px;

    font-size:32px;
}

.occasion-content p{

    color:
        rgba(255,255,255,.78);

    font-size:14px;

    line-height:1.6;
}


/* =====================================================
   DETAILS
===================================================== */

.reservation-details{

    padding:28px;

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:1px;

    background:
        var(--border);
}

.detail-item{

    min-height:90px;

    padding:
        18px
        20px;

    background:white;
}

.detail-label{

    display:block;

    margin-bottom:9px;

    color:#a0958e;

    font-size:9px;

    font-weight:800;

    letter-spacing:1.5px;
}

.detail-value{

    display:flex;

    align-items:center;

    gap:8px;

    color:var(--dark);

    font-size:14px;
}

.detail-icon{
    font-size:17px;
}


/* =====================================================
   FOOTER
===================================================== */

.reservation-footer{

    padding:
        22px
        28px;

    display:flex;

    align-items:center;

    justify-content:
        space-between;

    gap:20px;

    border-top:
        1px solid
        var(--border);
}

.experience-note{

    display:flex;

    align-items:center;

    gap:12px;
}

.experience-note-icon{

    font-size:22px;
}

.experience-note strong{

    display:block;

    color:var(--dark);

    font-size:13px;
}

.experience-note small{

    display:block;

    margin-top:3px;

    color:var(--muted);

    font-size:11px;
}

.cancel{

    display:inline-flex;

    align-items:center;

    gap:7px;

    color:#a34848;

    text-decoration:none;

    font-size:12px;

    font-weight:700;
}

.cancel:hover{

    text-decoration:underline;
}


/* =====================================================
   EMPTY
===================================================== */

.empty-state{

    padding:
        80px
        20px;

    text-align:center;

    background:white;

    border-radius:28px;
}

.empty-icon{

    font-size:50px;

    margin-bottom:15px;
}

.empty-eyebrow{

    color:var(--coffee-light);

    font-size:11px;

    font-weight:800;

    letter-spacing:2px;
}

.empty-state h2{

    margin:
        10px
        0;

    font-size:34px;
}

.empty-state p{

    color:var(--muted);

    margin-bottom:25px;
}

.book-now{

    display:inline-flex;

    gap:10px;

    padding:
        13px
        20px;

    border-radius:50px;

    background:var(--coffee);

    color:white;

    text-decoration:none;

    font-weight:700;
}


/* =====================================================
   MOBILE
===================================================== */

@media(max-width:750px){

    .reservation-hero{

        padding:
            55px
            6%
            65px;
    }

    .hero-content h1{

        font-size:48px;

        letter-spacing:-2px;
    }

    .hero-content p{

        font-size:14px;
    }

    .reservation-summary{

        width:90%;

        grid-template-columns:1fr;

        margin:
            -25px
            auto
            50px;
    }

    .experiences-section{

        width:90%;

        margin-bottom:50px;
    }

    .experiences-header{

        align-items:flex-start;

        flex-direction:column;

        gap:15px;
    }

    .experiences-title h2{

        font-size:30px;
    }

    .reservation-header{

        padding:18px;

        gap:12px;

        align-items:flex-start;

        flex-direction:column;
    }

    .occasion-card{

        height:300px;
    }

    .occasion-content{

        left:25px;

        right:20px;

        bottom:25px;
    }

    .occasion-content h3{

        font-size:25px;
    }

    .occasion-content p{

        font-size:12px;
    }

    .reservation-details{

        grid-template-columns:
            repeat(2,1fr);

        padding:15px;
    }

    .reservation-footer{

        align-items:flex-start;

        flex-direction:column;

        padding:20px;
    }

}

</style>

</head>


<body>


<!-- =====================================================
     HERO
===================================================== -->

<section class="reservation-hero">

    <div class="hero-content">


        <div class="hero-eyebrow">

            <span class="hero-eyebrow-icon">
                ☕
            </span>

            <span>
                Aroma Haven
            </span>

        </div>


        <h1>
            My Reservations
        </h1>


        <p>
            Every reservation is more than a table.
            It's a moment worth remembering.
            Manage your upcoming experiences and
            revisit your special celebrations.
        </p>


        <div class="hero-line"></div>


    </div>

</section>



<!-- =====================================================
     SUMMARY
===================================================== -->

<section class="reservation-summary">


    <div class="summary-box">

        <div class="summary-top">

            <div class="summary-label">
                Total Reservations
            </div>

            <div class="summary-icon">
                ☕
            </div>

        </div>


        <div class="summary-number">
            <?php
            echo $totalBookings;
            ?>
        </div>


        <div class="summary-caption">
            All your experiences
        </div>

    </div>



    <div class="summary-box">

        <div class="summary-top">

            <div class="summary-label">
                Confirmed
            </div>

            <div class="summary-icon">
                ✓
            </div>

        </div>


        <div class="summary-number">
            <?php
            echo $confirmed;
            ?>
        </div>


        <div class="summary-caption">
            Upcoming & confirmed
        </div>

    </div>



    <div class="summary-box">

        <div class="summary-top">

            <div class="summary-label">
                Pending
            </div>

            <div class="summary-icon">
                ◷
            </div>

        </div>


        <div class="summary-number">
            <?php
            echo $pending;
            ?>
        </div>


        <div class="summary-caption">
            Awaiting confirmation
        </div>

    </div>


</section>



<!-- =====================================================
     EXPERIENCES
===================================================== -->

<section class="experiences-section">


    <div class="experiences-header">


        <div class="experiences-title">

            <span class="section-eyebrow">
                YOUR JOURNEY
            </span>


            <h2>
                Your Experiences
            </h2>


            <p>
                Your reservation history & special moments
            </p>

        </div>


        <div class="experience-count">

            <strong>
                <?php
                echo $totalBookings;
                ?>
            </strong>

            <span>
                Reservations
            </span>

        </div>


    </div>



    <?php if (!empty($bookings)) { ?>


        <div class="reservations-list">


            <?php foreach ($bookings as $booking) { ?>


                <?php

                /* =================================================
                   BASIC DATA
                ================================================= */

                $bookingId =
                    $booking['id']
                    ?? '';


                $status =
                    $booking['status']
                    ?? 'Pending';


                $date =
                    $booking['booking_date']
                    ?? '';


                $time =
                    $booking['booking_time']
                    ?? '';


                $guests =
                    $booking['people']
                    ?? 1;


                $table =
                    $booking['table_id']
                    ?? '';


                /*
                 * IMPORTANT:
                 * Read special_event from database.
                 */

                $occasion =
                    trim(
                        $booking['special_event']
                        ?? ''
                    );


                if ($occasion === '') {

                    $occasion = 'Other';

                }


                /*
                 * Find occasion mapping.
                 */

                $occasionData =
                    $occasionMap[$occasion]
                    ?? $occasionMap['Other'];


                $payment =
                    $booking['payment_method']
                    ?? '';


                /*
                 * Browser URL
                 */

                $videoPath =
                    $occasionData['video'];


                /*
                 * Actual server filesystem path
                 */

                $videoFile =
                    __DIR__ .
                    DIRECTORY_SEPARATOR .
                    str_replace(
                        '/',
                        DIRECTORY_SEPARATOR,
                        ltrim(
                            $videoPath,
                            './'
                        )
                    );


                $videoExists =
                    file_exists($videoFile);


                $statusClass =
                    strtolower(
                        trim($status)
                    );

                ?>



                <!-- =================================================
                     CARD
                ================================================== -->

                <article
                    class="reservation-card"
                >


                    <!-- HEADER -->

                    <div class="reservation-header">


                        <div class="reservation-meta">

                            <span class="reservation-label">
                                RESERVATION
                            </span>


                            <strong class="booking-id">

                                #

                                <?php
                                echo cleanValue(
                                    $bookingId
                                );
                                ?>

                            </strong>

                        </div>



                        <div
                            class="status <?php
                                echo cleanValue(
                                    $statusClass
                                );
                            ?>"
                        >

                            <span class="status-dot"></span>

                            <?php
                            echo cleanValue(
                                $status
                            );
                            ?>

                        </div>


                    </div>



                    <!-- =================================================
                         OCCASION VIDEO
                    ================================================== -->

                    <div class="occasion-card">


                        <?php if ($videoExists) { ?>


                            <video
                                class="occasion-video"
                                autoplay
                                muted
                                loop
                                playsinline
                                preload="auto"
                            >

                                <source
                                    src="<?php
                                        echo cleanValue(
                                            $videoPath
                                        );
                                    ?>"
                                    type="video/mp4"
                                >

                            </video>


                        <?php } else { ?>


                            <div
                                class="occasion-video"
                                style="
                                    background:
                                    linear-gradient(
                                        135deg,
                                        #4a2d20,
                                        #8a6048
                                    );
                                "
                            ></div>


                        <?php } ?>


                        <div
                            class="occasion-overlay"
                        ></div>


                        <div
                            class="occasion-content"
                        >


                            <span class="occasion-tag">

                                YOUR SPECIAL MOMENT

                            </span>


                            <div class="occasion-icon">

                                <?php
                                echo $occasionData['icon'];
                                ?>

                            </div>


                            <h3>

                                <?php
                                echo cleanValue(
                                    $occasionData['title']
                                );
                                ?>

                            </h3>


                            <p>

                                <?php
                                echo cleanValue(
                                    $occasionData['description']
                                );
                                ?>

                            </p>


                        </div>

                    </div>



                    <!-- =================================================
                         DETAILS
                    ================================================== -->

                    <div class="reservation-details">


                        <div class="detail-item">

                            <span class="detail-label">
                                DATE
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">
                                    📅
                                </span>

                                <?php
                                echo cleanValue(
                                    $date
                                );
                                ?>

                            </div>

                        </div>



                        <div class="detail-item">

                            <span class="detail-label">
                                TIME
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">
                                    🕐
                                </span>

                                <?php
                                echo cleanValue(
                                    $time
                                );
                                ?>

                            </div>

                        </div>



                        <div class="detail-item">

                            <span class="detail-label">
                                GUESTS
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">
                                    👥
                                </span>

                                <?php
                                echo cleanValue(
                                    $guests
                                );
                                ?>

                            </div>

                        </div>



                        <div class="detail-item">

                            <span class="detail-label">
                                TABLE
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">
                                    🪑
                                </span>

                                <?php
                                echo cleanValue(
                                    $table
                                );
                                ?>

                            </div>

                        </div>



                        <div class="detail-item">

                            <span class="detail-label">
                                OCCASION
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">

                                    <?php
                                    echo $occasionData['icon'];
                                    ?>

                                </span>


                                <?php
                                echo cleanValue(
                                    $occasion
                                );
                                ?>

                            </div>

                        </div>



                        <div class="detail-item">

                            <span class="detail-label">
                                PAYMENT
                            </span>


                            <div class="detail-value">

                                <span class="detail-icon">
                                    💳
                                </span>


                                <?php
                                echo cleanValue(
                                    $payment
                                );
                                ?>

                            </div>

                        </div>


                    </div>



                    <!-- =================================================
                         FOOTER
                    ================================================== -->

                    <div class="reservation-footer">


                        <div class="experience-note">


                            <span class="experience-note-icon">
                                ✨
                            </span>


                            <div>

                                <strong>
                                    Your experience at Aroma Haven
                                </strong>


                                <small>
                                    We look forward to welcoming you.
                                </small>

                            </div>


                        </div>



                        <?php

                        if (
                            $statusClass !== 'cancelled'
                            &&
                            $statusClass !== 'completed'
                        ) {

                        ?>

                            <a
                                class="cancel"
                                href="cancel_booking.php?id=<?php
                                    echo urlencode(
                                        $bookingId
                                    );
                                ?>"
                                onclick="
                                    return confirm(
                                        'Are you sure you want to cancel this reservation?'
                                    );
                                "
                            >

                                <span>
                                    ×
                                </span>

                                Cancel Reservation

                            </a>

                        <?php } ?>


                    </div>


                </article>


            <?php } ?>


        </div>


    <?php } else { ?>


        <!-- =================================================
             EMPTY STATE
        ================================================== -->

        <div class="empty-state">


            <div class="empty-icon">
                ☕
            </div>


            <span class="empty-eyebrow">
                YOUR NEXT EXPERIENCE
            </span>


            <h2>
                No Reservations Yet
            </h2>


            <p>
                Your next memorable coffee experience
                is waiting for you.
            </p>


            <a
                href="catalogue.php"
                class="book-now"
            >

                <span>
                    Explore the Collection
                </span>


                <span>
                    →
                </span>

            </a>


        </div>


    <?php } ?>


</section>


</body>

</html>