<?php  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Mengambil data dari form dan sanitasi  
    $name = htmlspecialchars(strip_tags(trim($_POST["name"])));  
    $email = htmlspecialchars(strip_tags(trim($_POST["email"])));  
    $subject = htmlspecialchars(strip_tags(trim($_POST["subject"])));  
    $message = htmlspecialchars(strip_tags(trim($_POST["message"])));  

    // Validasi email  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        die("Email tidak valid.");  
    }  

    // Email penerima  
    $to = "hurihmeranti@gmail.com"; // Ganti dengan alamat email tujuan  
    $headers = "From: $name <$email>\r\n";  
    $headers .= "Reply-To: $email\r\n";  
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";  

    // Mengirim email  
    if (mail($to, $subject, $message, $headers)) {  
        echo "Pesan Anda telah dikirim.";  
    } else {  
        echo "Terjadi kesalahan dalam mengirim pesan.";  
    }  
} else {  
    // Jika tidak ada data POST  
    die("Metode permintaan tidak valid.");  
}  
?>  