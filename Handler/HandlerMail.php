<?php

require_once __DIR__ . '/../assets/lib/vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../builders/mailbuilder.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getMailerInstance() {
    $mail = new PHPMailer(true);
    
    try {
        // Configurazione server Mailjet
        $mail->isSMTP();
        $mail->Host       = 'pro.turbo-smtp.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bucignoscuola@gmail.com';
        $mail->Password   = 'Andre@2308.11';
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
    return $differenza->days+1;
}


function getDatiDominiUtente($ids_domini) {
    $connessione = getDBConnection();
    $domini_utente = [];
    
    if (empty($ids_domini)) {
        return $domini_utente;
    }
    
    $placeholders = implode(',', array_fill(0, count($ids_domini), '?'));
    $sql = "SELECT id, nome_dominio, scadenza FROM domini WHERE id IN ($placeholders) ORDER BY scadenza ASC";
    
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($ids_domini)), ...$ids_domini);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $domini_utente[] = $row;
    }
    
    $stmt->close();
    $connessione->close();
    
    return $domini_utente;
}

// FUNZIONE AGGIUNTA: Recupera dati utente
function getDatiUtente($connessione, $id_utente) {
    $sql_utente = "SELECT email, nome FROM utenti WHERE ID = ?";
    $stmt = $connessione->prepare($sql_utente);
    $stmt->bind_param('i', $id_utente);
    $stmt->execute();
    $result_utente = $stmt->get_result();
    
    if ($row_utente = $result_utente->fetch_assoc()) {
        $stmt->close();
        return $row_utente;
    }
    
    $stmt->close();
    return null;
}

function sendMail($email_destinatario, $ids_domini, $nome_destinatario) {
    $mail = getMailerInstance();
    if (!$mail) return false;
    
    try {
        // Recupera i dati completi dei domini
        $domini_utente = getDatiDominiUtente($ids_domini);
        
        if (empty($domini_utente)) {
            error_log("Nessun dominio trovato per l'utente: $nome_destinatario");
            return false;
        }
        
        $mail->setFrom('SoftwareEngineering@ingin.com', 'SOFTWAREENGINEERING');
        $mail->addAddress($email_destinatario, $nome_destinatario);
        
        $mail->isHTML(true);
        $mail->Subject = "Promemoria Scadenze Domini - " . $nome_destinatario;
        $mail->Body = getBodyEmail($domini_utente, $nome_destinatario);
        
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("Errore invio mail a $email_destinatario: " . $e->getMessage());
        return false;
    }
}

// Esecuzione principale
$connessione = getDBConnection();
$dataOdierna = new DateTime();
$scadenza_breve = (clone $dataOdierna)->modify("+7 days")->format('Y-m-d');
$scadenza_lunga = (clone $dataOdierna)->modify("+30 days")->format('Y-m-d');

$sql = "SELECT * FROM domini, utenti 
WHERE domini.id_utente = utenti.ID 
AND (
    scadenza BETWEEN DATE_ADD('$scadenza_breve', INTERVAL -7 DAY) 
                AND DATE_ADD('$scadenza_breve', INTERVAL 7 DAY)
    OR 
    scadenza BETWEEN DATE_ADD('$scadenza_lunga', INTERVAL -7 DAY) 
                AND DATE_ADD('$scadenza_lunga', INTERVAL 7 DAY)
)
ORDER BY utenti.ID ASC , domini.scadenza ASC;";

$result = $connessione->query($sql);



$invii_gia_esistenti = [];
$sql_invii = "SELECT id_dominio FROM invii WHERE DATEDIFF(CURDATE(),data_invio)<=7";
$result_invii = $connessione->query($sql_invii);

if ($result_invii && $result_invii->num_rows > 0) {
    while ($row_invio = $result_invii->fetch_assoc()) {
        $invii_gia_esistenti[] = $row_invio['id_dominio']; 
    }
}

$nuovi_invii = [];
$tabella = [];

foreach($result as $row){
    if (in_array($row['id'], $invii_gia_esistenti)) { 
        continue;
    } else {
        $tabella[$row['id_utente']][] = $row['id']; 
        $nuovi_invii[] = $row['id']; 
    }
}

foreach ($tabella as $id_utente => $ids_domini) {
    $dati_utente = getDatiUtente($connessione, $id_utente);
    if ($dati_utente) {
        $email_destinatario = $dati_utente['email'];
        $nome_destinatario  = $dati_utente['nome'];
        
        $invio_riuscito = sendMail($email_destinatario, $ids_domini, $nome_destinatario);
        if (!$invio_riuscito) die("errore1");
    } else {
        die("errore2");
    }
    sleep(1);
}


$sql = "INSERT INTO invii (id_dominio, data_invio) VALUES (?, CURDATE())";
$stmt = $connessione->prepare($sql);

foreach ($nuovi_invii as $invio) {
    $stmt->bind_param("i", $invio);
    $stmt->execute();
}

$stmt->close();
$connessione->close();

