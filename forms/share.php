<?php  
// Mengaktifkan session  
session_start();  

// Fungsi untuk membersihkan input  
function sanitizeInput($data) {  
    return htmlspecialchars(stripslashes(trim($data)));  
}  

// Memeriksa apakah form telah di-submit  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Mendapatkan data dari form  
    $name = sanitizeInput($_POST['name']);  
    $email = sanitizeInput($_POST['email']);  
    $subject = sanitizeInput($_POST['subject']);  
    $message = sanitizeInput($_POST['message']);  
    
    // Verifikasi reCAPTCHA  
    $recaptcha_secret = "YOUR_SECRET_KEY"; // Ganti dengan secret key Anda  
    $recaptcha_response = $_POST['g-recaptcha-response'];  

    // Memastikan reCAPTCHA diisi  
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");  
    $response_keys = json_decode($response, true);  

    // Jika reCAPTCHA valid  
    if (intval($response_keys["success"]) !== 1) {  
        echo "Please complete the CAPTCHA.";  
    } else {  
        // Mengatur email  
        $to = "hurihmeranti@gmail.com"; // Alamat email penerima  
        $headers = "From: $name <$email>\r\n";  
        $headers .= "Reply-To: $email\r\n";  
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";  

        // Mengirim email  
        $mail_sent = mail($to, $subject, $message, $headers);  

        if ($mail_sent) {  
            echo "Your message has been sent. Thank you!";  
        } else {  
            echo "Could not send the message. Please try again.";  
        }  
    }  
}  
?>  