<?php

require_once __DIR__ . '/assets/lib/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/builder/mailBuilder.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getMailerInstance() {
    $mail = new PHPMailer(true);
    
    try {
        // Configurazione server Mailjet
        $mail->isSMTP();
        $mail->Host       = 'in-v3.mailjet.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '14de26fbf5928362f092f82407cf6c1c';
        $mail->Password   = '9ecf49a7e10b8b4bbb2812aeb66826ab';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        
        return $mail;
    } catch (Exception $e) {
        return null;
    }
}

function calcolaGiorniRimanenti($scadenza) {
    $oggi = new DateTime();
    $data_scadenza = new DateTime($scadenza);
    $differenza = $oggi->diff($data_scadenza);
    return $differenza->days;
}

function getOggettoEmail($nome_dominio, $scadenza) {
    $giorni = calcolaGiorniRimanenti($scadenza);
    return "Promemoria Scadenza Dominio: {$nome_dominio} scade tra {$giorni} giorni";
}

function sendMail($email_destinatario, $nome_dominio, $scadenza, $nome_destinatario) {
    $mail = getMailerInstance();
    if (!$mail) return false;
    
    try {
        $mail->setFrom('noreply@tuodominio.com', 'Tuo Nome Azienda');
        $mail->addAddress($email_destinatario, $nome_destinatario);
        
        $mail->isHTML(true);
        $mail->Subject = getOggettoEmail($nome_dominio, $scadenza);
        $mail->Body = getBodyEmail($nome_dominio, $scadenza, $nome_destinatario);
        
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        return false;
    }
}

// Esecuzione principale
$connessione = getDBConnection();
$dataOdierna = new DateTime();
$scadenza_breve = (clone $dataOdierna)->modify("+7 days")->format('Y-m-d');
$scadenza_lunga = (clone $dataOdierna)->modify("+30 days")->format('Y-m-d');

$sql = "SELECT * FROM domini, utenti WHERE domini.id_utente = utenti.ID AND (scadenza = '$scadenza_breve' OR scadenza = '$scadenza_lunga')";
$result = $connessione->query($sql);

if ($result) {
    while($row = $result->fetch_assoc()) {
        sendMail($row['Email'], $row['nome_dominio'], $row['scadenza'], $row['Nome']);
    }
}

$connessione->close();