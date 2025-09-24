<?php
require_once 'config/database.php';

// Gestione form utente
function handleUserForm($postData)
{
    $connessione = getDBConnection();

    $email = trim($postData["email"]);
    $name = trim($postData["name"]);
    $numero = trim($postData["numero"]);
    $NomeAzienda = trim($postData["NomeAzienda"]);
    $ruolo = trim($postData["ruolo"]);
    $dataRegistrazione = trim($postData["dataRegistrazione"]);
    $Attivo = trim($postData["Attivo"]);
    $password = trim($postData["password"]);

    // Controllo se l'email esiste già
    $check_sql = "SELECT Email FROM utenti WHERE Email = ?";
    $check_stmt = $connessione->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $result = [
            'message' => "Errore: L'email '$email' è già registrata nel sistema",
            'type' => 'danger'
        ];
    } else {
        $sql = "INSERT INTO utenti (Email, Nome, numero, azienda, ruolo, data_registrazione, attivo, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("ssssssss", $email, $name, $numero, $NomeAzienda, $ruolo, $dataRegistrazione, $Attivo, $password);

        if ($stmt->execute()) {
            $result = [
                'message' => "Utente registrato correttamente",
                'type' => 'success'
            ];
        } else {
            $result = [
                'message' => "Errore nella registrazione dell'utente",
                'type' => 'danger'
            ];
        }
        $stmt->close();
    }
    $check_stmt->close();
    $connessione->close();
    return $result;
}

// Gestione form dominio
function handleDomainForm($postData)
{
    $connessione = getDBConnection();

    $id_utente = trim($postData["id_utente"]);
    $nome_dominio = trim($postData["nome_dominio"]);
    $scadenza = trim($postData["scadenza"]);

    $checkSql = "SELECT nome_dominio FROM domini WHERE nome_dominio = ?";
    $check_stmt = $connessione->prepare($checkSql);
    $check_stmt->bind_param("s", $nome_dominio);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $result = [
            'message' => "Dominio già registrato",
            'type' => 'danger'
        ];
    } else {
        $sql = "INSERT INTO domini (id_utente, nome_dominio, data_registrazione, scadenza) VALUES (?, ?, CURDATE(), ?)";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("iss", $id_utente, $nome_dominio,$scadenza);

        if ($stmt->execute()) {
            $result = [
                'message' => "Dominio registrato correttamente",
                'type' => 'success'
            ];
        } else {
            $result = [
                'message' => "Errore nella registrazione del dominio",
                'type' => 'danger'
            ];
        }
        $stmt->close();
    }
    $check_stmt->close();
    $connessione->close();
    return $result;
}

// Gestione form file
function handleFileForm($postData)
{
    $connessione = getDBConnection();

    $id_utente = trim($postData['id_utente']);
    $nome_file = trim($postData['nome_file']);
    $data_ora_corrente = time();
    $data_ora_corrente .= "_" . $nome_file;

    $sql = "INSERT INTO files(id_utente,nome_file,data_upload,disponibile) VALUES (?,?,CURDATE(),true)";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("is", $id_utente, $data_ora_corrente);

    if ($stmt->execute()) {
        $result = [
            'message' => "File registrato correttamente",
            'type' => 'success'
        ];
    } else {
        $result = [
            'message' => "Errore nella registrazione del file",
            'type' => 'danger'
        ];
    }

    $stmt->close();
    $connessione->close();
    return $result;
}

// Gestione form email
function handleEmailForm($postData)
{
    $connessione = getDBConnection();

    $nome_email = trim($postData['email_form_email']);
    $id_utente = trim($postData['id_utente']);
    $id_dominio = trim($postData['id_dominio']);

    $checkSql = "SELECT nome_email FROM email WHERE nome_email = ?";
    $check_stmt = $connessione->prepare($checkSql);
    $check_stmt->bind_param("s", $nome_email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $result = [
            'message' => "Email già registrata",
            'type' => 'danger'
        ];
    } else {
        $sql = "INSERT INTO email (id_utente, nome_email, id_dominio) VALUES (?, ?, ?)";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("isi", $id_utente, $nome_email, $id_dominio);

        if ($stmt->execute()) {
            $result = [
                'message' => "Email registrata correttamente",
                'type' => 'success'
            ];
        } else {
            $result = [
                'message' => "Errore nella registrazione dell'email",
                'type' => 'danger'
            ];
        }
        $stmt->close();
    }
    $check_stmt->close();
    $connessione->close();
    return $result;
}
