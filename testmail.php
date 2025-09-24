<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configurazione server Gmail
    $mail->isSMTP();
    $mail->Host       = 'in-v3.mailjet.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '14de26fbf5928362f092f82407cf6c1c';     // la tua Gmail
    $mail->Password   = '9ecf49a7e10b8b4bbb2812aeb66826ab';          // la password per le app
    $mail->SMTPSecure = 'ssl';                   
    $mail->Port       = 465;                     // 587 TLS, 465 SSL

    // Mittente e destinatario
    $mail->setFrom('14de26fbf5928362f092f82407cf6c1c', 'Il tuo nome');
    $mail->addAddress('destinatario@email.com');

    // Contenuto
    $mail->isHTML(true);
    $mail->Subject = 'Test PHPMailer con Gmail';
    $mail->Body    = 'Ciao, questa è una <b>mail inviata da Gmail con PHPMailer!</b>';

    $mail->send();
    echo "✅ Email inviata con successo!";
} catch (Exception $e) {
    echo "❌ Errore: {$mail->ErrorInfo}";
}
