<?php
include "connect.php";
/** @var mysqli $conn */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if(isset($_POST['email'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $check = mysqli_query($conn,"SELECT * FROM clients WHERE email='$email' LIMIT 1");

    // Show same message even if email doesn't exist
    if(mysqli_num_rows($check)==0){

        echo "<script>
        alert('If this email exists, a reset link has been sent.');
        window.location='register.php';
        </script>";
        exit;
    }

    $user = mysqli_fetch_assoc($check);

    // Secure Token
    $token = bin2hex(random_bytes(32));

    // 15 minutes expiry
    $expiry = date("Y-m-d H:i:s",strtotime("+15 minutes"));

    mysqli_query($conn,"UPDATE clients SET
        reset_token='$token',
        reset_expiry='$expiry'
        WHERE id='".$user['id']."'");

    $link="http://localhost/CoffeeShop2/reset_password.php?token=".$token;

    $mail=new PHPMailer(true);

    try{

        $mail->isSMTP();

        $mail->Host='smtp.gmail.com';

        $mail->SMTPAuth=true;

        $mail->Username='yourgmail@gmail.com';

        $mail->Password='YOUR_GMAIL_APP_PASSWORD';

        $mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port=587;

        $mail->setFrom('yourgmail@gmail.com','Coffee Shop');

        $mail->addAddress($email,$user['name']);

        $mail->isHTML(true);

        $mail->Subject='Reset Your Password';

        $mail->Body="

        <h2>Hello ".$user['name']."</h2>

        <p>Click the button below to reset your password.</p>

        <br>

        <a href='$link'
        style='background:#7b4b2a;
        color:white;
        padding:12px 25px;
        text-decoration:none;
        border-radius:8px;'>

        Reset Password

        </a>

        <br><br>

        <p>This link expires in <b>15 minutes</b>.</p>

        <p>If you didn't request this, ignore this email.</p>
        ";

        $mail->send();

        echo "<script>
        alert('Password reset link sent to your email.');
        window.location='register.php';
        </script>";

    }catch(Exception $e){

        echo "Mailer Error : ".$mail->ErrorInfo;

    }

}
?>