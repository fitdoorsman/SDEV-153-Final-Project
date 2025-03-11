<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output
        $mail->SMTPDebug = 2; // 🔹 Change to 0 when done testing
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com'; // Outlook's SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'j_hollin@hotmail.com'; // User's Outlook email
        $mail->Password = 'Outdoors_1'; // Replace with Outlook password or app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Recipient
        $mail->setFrom($email, $name);
        $mail->addAddress('j_hollin@hotmail.com'); // Send emails to the same Outlook account

        // Email Content
        $mail->isHTML(false);
        $mail->Subject = 'New Contact Form Message';
        $mail->Body    = "Name: $name\nEmail: $email\nMessage:\n$message";

        // Send Email
        if ($mail->send()) {
            echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact.html?clearCache=' + new Date().getTime();</script>";
        } else {
            echo "<script>alert('Error: Email could not be sent.'); console.error('Mailer Error: " . $mail->ErrorInfo . "');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: Email not sent. Debug: " . $mail->ErrorInfo . "');</script>";
    }
}
?>
