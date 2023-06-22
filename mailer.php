<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'mail.teamxdarkwarrior.x10.mx'; // Replace with your SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'tbudufap@teamxdarkwarrior.x10.mx'; // Replace with your email address
    $mail->Password = 'dword:00000000'; // Replace with your email password
    $mail->SMTPSecure = 'tls'; // Replace with the encryption type (tls or ssl)
    $mail->Port = 589; // Replace with the appropriate SMTP port

    // Sender and recipient details
    $mail->setFrom('sender@example.com', 'Sender Name'); // Replace with the sender's email address and name
    $mail->addAddress('recipient@example.com', 'Recipient Name'); // Replace with the recipient's email address and name

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Hello from PHPMailer';
    $mail->Body = 'This is a test email.';

    // Send the email
    $mail->send();
    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo 'Email sending failed. Error: ' . $mail->ErrorInfo;
}
?>
