<?php

session_start();

include "connect.php";

/** @var mysqli $conn */


/* =====================================================
   DATABASE CHECK
===================================================== */

if (!$conn) {

    die(
        "Database connection failed: " .
        mysqli_connect_error()
    );

}


/* =====================================================
   LOGIN CHECK
===================================================== */

$user_id = $_SESSION['user_id'] ?? 0;

if (!$user_id) {

    $_SESSION['error'] =
        "Please login before making a reservation.";

    header("Location: login.php");

    exit();

}


/* =====================================================
   GET BOOKING DATA
===================================================== */

$data = $_SESSION['booking_data'] ?? [];

if (empty($data)) {

    $_SESSION['error'] =
        "Booking information was lost. Please try again.";

    header("Location: catalogue.php");

    exit();

}


/* =====================================================
   GET FORM DATA
===================================================== */

$name = trim(
    $data['customer_name'] ?? ''
);

$phone = trim(
    $data['customer_phone'] ?? ''
);

$date = trim(
    $data['booking_date'] ?? ''
);

$time = trim(
    $data['booking_time'] ?? ''
);

$people = (int)(
    $data['people'] ?? 1
);

if ($people <= 0) {
    $people = 1;
}

$booking_table = trim(
    $data['booking_table'] ?? ''
);

$event_image = trim(
    $data['event_image'] ?? ''
);

$table_id = trim(
    $data['table_id'] ?? ''
);

$amount = (float)(
    $data['amount'] ?? 0
);

$special_event = trim(
    $data['special_event'] ?? ''
);

$payment_method = trim(
    $data['payment_method'] ?? ''
);

$payment_status = trim(
    $data['payment_status'] ?? 'Pending'
);

$message = trim(
    $data['message'] ?? ''
);


/* =====================================================
   PAYMENT STATUS
===================================================== */

if ($payment_status === '') {

    $payment_status = 'Pending';

}


/* =====================================================
   VALID OCCASIONS
===================================================== */

$validOccasions = [

    'None',
    'Birthday',
    'Anniversary',
    'Date',
    'Business Meeting',
    'Family Gathering',
    'Success Celebration',
    'Friend Reunion',
    'Group Study',
    'Other'

];


/* =====================================================
   OCCASION VALIDATION
===================================================== */

if (
    $special_event === '' ||
    !in_array(
        $special_event,
        $validOccasions,
        true
    )
) {

    $_SESSION['error'] =
        "Please select a valid occasion.";

    $_SESSION['booking_data'] = $data;

    header(
        "Location: book.php?" .
        "img=" . urlencode($event_image) .
        "&price=" . urlencode($amount) .
        "&table=" . urlencode($table_id)
    );

    exit();

}


/* =====================================================
   SPECIAL ORDER
===================================================== */

if ($special_event === 'None') {

    $special_order = 'No';

} else {

    $special_order = 'Yes';

}


/* =====================================================
   VALIDATION
===================================================== */

if (
    $name === '' ||
    $phone === '' ||
    $date === '' ||
    $time === '' ||
    $table_id === '' ||
    $payment_method === ''
) {

    $_SESSION['error'] =
        "Please fill all required fields and select a payment method.";

    $_SESSION['booking_data'] = $data;

    header(
        "Location: book.php?" .
        "img=" . urlencode($event_image) .
        "&price=" . urlencode($amount) .
        "&table=" . urlencode($table_id)
    );

    exit();

}


/* =====================================================
   DATE VALIDATION
===================================================== */

$dateObject = DateTime::createFromFormat(
    'Y-m-d',
    $date
);

if (
    !$dateObject ||
    $dateObject->format('Y-m-d') !== $date
) {

    $_SESSION['error'] =
        "Invalid booking date.";

    $_SESSION['booking_data'] = $data;

    header(
        "Location: book.php?" .
        "img=" . urlencode($event_image) .
        "&price=" . urlencode($amount) .
        "&table=" . urlencode($table_id)
    );

    exit();

}


/* =====================================================
   TIME VALIDATION
===================================================== */

$timeObject = DateTime::createFromFormat(
    'H:i',
    $time
);

if (!$timeObject) {

    $_SESSION['error'] =
        "Invalid booking time.";

    $_SESSION['booking_data'] = $data;

    header(
        "Location: book.php?" .
        "img=" . urlencode($event_image) .
        "&price=" . urlencode($amount) .
        "&table=" . urlencode($table_id)
    );

    exit();

}


/* =====================================================
   CHECK TABLE AVAILABILITY
===================================================== */

$checkSql = "

    SELECT id

    FROM bookings

    WHERE table_id = ?

    AND booking_date = ?

    AND booking_time = ?

    AND status <> 'Cancelled'

    LIMIT 1

";


$checkStmt = mysqli_prepare(
    $conn,
    $checkSql
);


if (!$checkStmt) {

    die(
        "Availability check error: " .
        mysqli_error($conn)
    );

}


/*
    table_id = VARCHAR
    date = VARCHAR
    time = VARCHAR
*/

mysqli_stmt_bind_param(
    $checkStmt,
    "sss",
    $table_id,
    $date,
    $time
);


if (!mysqli_stmt_execute($checkStmt)) {

    $error =
        mysqli_stmt_error($checkStmt);

    mysqli_stmt_close($checkStmt);

    die(
        "Availability check failed: " .
        $error
    );

}


$checkResult =
    mysqli_stmt_get_result(
        $checkStmt
    );


/* =====================================================
   ALREADY BOOKED
===================================================== */

if (
    $checkResult &&
    mysqli_num_rows($checkResult) > 0
) {

    mysqli_stmt_close($checkStmt);

    $_SESSION['error'] =
        "❌ This table is already booked for the selected date and time.";

    $_SESSION['booking_data'] = $data;

    header(
        "Location: book.php?" .
        "img=" . urlencode($event_image) .
        "&price=" . urlencode($amount) .
        "&table=" . urlencode($table_id)
    );

    exit();

}


mysqli_stmt_close($checkStmt);


/* =====================================================
   BOOKING VALUES
===================================================== */

$status = 'Pending';

$is_paid = 0;


/* =====================================================
   INSERT BOOKING
===================================================== */

$sql = "

INSERT INTO bookings

(
    user_id,
    customer_name,
    customer_phone,
    booking_table,
    booking_date,
    booking_time,
    people,
    special_event,
    special_order,
    event_image,
    message,
    status,
    table_id,
    is_paid,
    amount,
    payment_method,
    payment_status
)

VALUES

(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
)

";


$stmt = mysqli_prepare(
    $conn,
    $sql
);


if (!$stmt) {

    die(
        "SQL Prepare Error: " .
        mysqli_error($conn)
    );

}


/*
=========================================================
17 VARIABLES

1  user_id          i
2  customer_name    s
3  customer_phone   s
4  booking_table    s
5  booking_date     s
6  booking_time     s
7  people           i
8  special_event    s
9  special_order    s
10 event_image      s
11 message          s
12 status           s
13 table_id         s
14 is_paid          i
15 amount           d
16 payment_method   s
17 payment_status   s

TYPE STRING:

isssssisssssisdss
=========================================================
*/


mysqli_stmt_bind_param(

    $stmt,

    "isssssisssssisdss",

    $user_id,

    $name,

    $phone,

    $booking_table,

    $date,

    $time,

    $people,

    $special_event,

    $special_order,

    $event_image,

    $message,

    $status,

    $table_id,

    $is_paid,

    $amount,

    $payment_method,

    $payment_status

);


/* =====================================================
   EXECUTE
===================================================== */

if (mysqli_stmt_execute($stmt)) {


    $booking_id =
        mysqli_insert_id($conn);


    $_SESSION['booking_id'] =
        $booking_id;


    $_SESSION['success'] =
        "🎉 Your reservation has been successfully created!";


    unset(
        $_SESSION['booking_data']
    );


    mysqli_stmt_close($stmt);


    header(
        "Location: booking_success.php"
    );

    exit();

}


/* =====================================================
   INSERT ERROR
===================================================== */

$error =
    mysqli_stmt_error($stmt);


mysqli_stmt_close($stmt);


$_SESSION['error'] =
    "Database error: " . $error;


/*
   Keep the data
*/

$_SESSION['booking_data'] =
    $data;


/* =====================================================
   RETURN TO BOOKING PAGE
===================================================== */

header(

    "Location: book.php?" .

    "img=" .
    urlencode($event_image) .

    "&price=" .
    urlencode($amount) .

    "&table=" .
    urlencode($table_id)

);

exit();

?>