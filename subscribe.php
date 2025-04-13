<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoload
session_start();

// Rate limiting (1 menit per IP)
$ip = $_SERVER['REMOTE_ADDR'];
$lastSubmit = $_SESSION['last_submit'][$ip] ?? 0;

if (time() - $lastSubmit < 60) {
    exit('Please wait a minute before submitting again.');
}
$_SESSION['last_submit'][$ip] = time();

// Validasi & sanitasi input email
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        exit('Invalid email address.');
    }

    $mail = new PHPMailer(true);
    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com'; // ubah ke email kamu
        $mail->Password = 'your_app_password';    // gunakan app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Informasi pengirim dan penerima
        $mail->setFrom('your_email@gmail.com', 'Your Website');
        $mail->addAddress($email); // alamat tujuan dari form

        // Isi email
        $mail->isHTML(true);
        $mail->Subject = 'Thank you for subscribing!';
        $mail->Body    = 'You have successfully subscribed to our newsletter.';

        $mail->send();
        echo 'Subscription email has been sent.';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request method.';
}
?>
