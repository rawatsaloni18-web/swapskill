<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendMail($to, $subject, $message){

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        $mail->Username   = 'swpskill@gmail.com';
        $mail->Password   = 'axoi wahf uyja rrvl'; // 🔥 YOUR APP PASSWORD

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('swpskill@gmail.com', 'SwapSkill');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
?>