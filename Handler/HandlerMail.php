<?php

require __DIR__ . '/assets/lib//vendor/autoload.php';
require_once '/config/database.php';
require_once '/builder/mailBuilder.php';

use LDAP\Result;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$connessione = getDBConnection();

$scadenza_breve = new DateTime('Y-m-d')->modify("+7 days");
$scadenza_lunga = new DateTime('Y-m-d')->modify("+30 days");


$sql = "SELECT * FROM domini,utenti WHERE domini.id_utente = utenti.ID AND scadenza = $scadenza_breve OR scadenza = $scadenza_lunga";
$result=$connessione->query($sql);
$row = $result->fetch_array();
foreach($result as $row){
    sendMail($row['Email'],$row['nome_dominio'],$row['scadenza'],$row['Nome']);
}

$connessione->close();


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


function sendMail($email_destinatario,$nome_dominio,$scadenza,$nome_destinatario){
    $mail = getMailerInstance();

    $mail = getMailerInstance();
    if (!$mail) return false;
    
    try {
        $mail->setFrom('14de26fbf5928362f092f82407cf6c1c');
        $mail->addAddress($email_destinatario, $nome_destinatario);
        
        $mail->isHTML(true);
        $mail->Subject = getOggettoEmail();
        $mail->Body = getBodyEmail($nome_dominio,$scadenza,$nome_destinatario);
        
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        return false;
    }

}
