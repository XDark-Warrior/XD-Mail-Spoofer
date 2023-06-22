<?php
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';
require 'path/to/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderName = $_POST['s_name'];
    $senderEmail = $_POST['s_email'];
    $subject = $_POST['subject'];
    $recipientEmail = $_POST['r_email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'mail.teamxdarkwarrior.x10.mx'; // Replace with your SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'support@teamxdarkwarrior.x10.mx'; // Replace with your email address
        $mail->Password = '@XDWar999'; // Replace with your email password
        $mail->SMTPSecure = 'tls'; // Replace with the encryption type (tls or ssl)
        $mail->Port = 587; // Replace with the appropriate SMTP port

        // Sender and recipient details
        $mail->setFrom($senderEmail, $senderName);
        $mail->addAddress($recipientEmail);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo 'Email sending failed. Error: ' . $mail->ErrorInfo;
    }
}
?>
