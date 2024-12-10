<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $to = "15220290@bsi.ac.id";

    $email_subject = "Pesan dari: " . $name . " - " . $subject;

    $email_body = "Anda menerima pesan baru dari formulir kontak website:\n\n";
    $email_body .= "Nama: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n\n";
    $email_body .= "Pesan:\n" . $message . "\n";

    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "<script>alert('Pesan Anda telah dikirim! Terima kasih.'); window.location = 'index.html';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'); window.location = 'index.html';</script>";
    }
}
?>
