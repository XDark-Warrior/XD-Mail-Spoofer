<?php
// SMTP server details
$smtpServer = 'mail.teamxdarkwarrior.x10.mx';
$smtpUsername = 'support@teamxdarkwarrior.x10.mx';
$smtpPassword = '@XDWar999';
$smtpPort = 587;

// Sender and recipient details
$senderEmail = 'sender@example.com';
$senderName = 'Sender Name';
$recipientEmail = 'recipient@example.com';
$recipientName = 'Recipient Name';

// Email content
$subject = 'Hello from SMTP';
$message = 'This is a test email.';

// Create the headers
$headers = "From: $senderName <$senderEmail>\r\n";
$headers .= "Reply-To: $senderName <$senderEmail>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Construct the email
$email = [
    'to' => "$recipientName <$recipientEmail>",
    'subject' => $subject,
    'message' => $message,
    'headers' => $headers
];

// Open a connection to the SMTP server
$smtpConnection = fsockopen($smtpServer, $smtpPort, $errorNumber, $errorMessage, 10);
if (!$smtpConnection) {
    die("Failed to connect to the SMTP server: $errorMessage");
}

// Read the welcome message from the server
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '220') {
    die("Error: Unexpected SMTP server response: $smtpResponse");
}

// Send the EHLO command to initiate the SMTP conversation
fputs($smtpConnection, "EHLO example.com\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '250') {
    die("Error: EHLO command failed: $smtpResponse");
}

// Send the STARTTLS command to switch to a secure connection
fputs($smtpConnection, "STARTTLS\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '220') {
    die("Error: STARTTLS command failed: $smtpResponse");
}

// Establish a secure connection
if (!stream_socket_enable_crypto($smtpConnection, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
    die("Error: Failed to establish a secure connection to the SMTP server");
}

// Authenticate with the server
fputs($smtpConnection, "AUTH LOGIN\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '334') {
    die("Error: AUTH LOGIN command failed: $smtpResponse");
}

fputs($smtpConnection, base64_encode($smtpUsername) . "\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '334') {
    die("Error: Failed to send username: $smtpResponse");
}

fputs($smtpConnection, base64_encode($smtpPassword) . "\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '235') {
    die("Error: Failed to send password: $smtpResponse");
}

// Send the MAIL FROM command
fputs($smtpConnection, "MAIL FROM: <$senderEmail>\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '250') {
    die("Error: MAIL FROM command failed: $smtpResponse");
}

// Send the RCPT TO command
fputs($smtpConnection, "RCPT TO: <$recipientEmail>\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '250') {
    die("Error: RCPT TO command failed: $smtpResponse");
}

// Send the DATA command to start sending the email content
fputs($smtpConnection, "DATA\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '354') {
    die("Error: DATA command failed: $smtpResponse");
}

// Send the email headers
fputs($smtpConnection, $email['headers']);

// Send the email body
fputs($smtpConnection, "\r\n" . $email['message']);

// Send the terminating sequence
fputs($smtpConnection, "\r\n.\r\n");
$smtpResponse = fgets($smtpConnection);
if (substr($smtpResponse, 0, 3) != '250') {
    die("Error: Failed to send email: $smtpResponse");
}

// Send the QUIT command to close the connection
fputs($smtpConnection, "QUIT\r\n");
fclose($smtpConnection);

echo 'Email sent successfully.';
?>
