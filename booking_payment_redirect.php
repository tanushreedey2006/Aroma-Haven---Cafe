<?php

session_start();

/*
|--------------------------------------------------------------------------
| CHECK REQUEST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: catalogue.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK PAYMENT METHOD
|--------------------------------------------------------------------------
*/

$payment_method = trim($_POST['payment_method'] ?? '');

if ($payment_method === '') {

    echo "<script>
        alert('Please select a payment method.');
        history.back();
    </script>";

    exit;
}


/*
|--------------------------------------------------------------------------
| CHECK SPECIAL EVENT
|--------------------------------------------------------------------------
*/

$special_event = trim($_POST['special_event'] ?? '');

if ($special_event === '') {
    $special_event = 'None';
}


/*
|--------------------------------------------------------------------------
| SAVE BOOKING DATA
|--------------------------------------------------------------------------
*/

$_SESSION['booking_data'] = $_POST;

/*
 * Make sure the exact selected occasion is saved.
 */
$_SESSION['booking_data']['special_event'] = $special_event;


/*
|--------------------------------------------------------------------------
| ONLINE PAYMENT METHODS
|--------------------------------------------------------------------------
*/

$onlineMethods = [
    'PhonePe',
    'Google Pay',
    'Paytm'
];


/*
|--------------------------------------------------------------------------
| REDIRECT FOR ONLINE PAYMENT
|--------------------------------------------------------------------------
*/

if (in_array($payment_method, $onlineMethods, true)) {

    header("Location: booking_payment.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| CASH / PAY AT CAFE
|--------------------------------------------------------------------------
*/

if ($payment_method === 'Cash On Arrival') {

    header("Location: book_action.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| UNKNOWN PAYMENT METHOD
|--------------------------------------------------------------------------
*/

echo "<script>
    alert('Invalid payment method selected.');
    history.back();
</script>";

exit;

?>