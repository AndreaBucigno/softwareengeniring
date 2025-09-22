<?php
require_once 'config/database.php';

// Elimina file
function eliminaFile($file_id)
{
    $connessione = getDBConnection();
    // se ti ci serve il button elimina <button class='btn btn-danger btn-sm btn-rimuovi-file' data-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>
    //<i class='bi bi-trash'></i> Elimina </button>
    $sql = "UPDATE files SET disponibile = 'false' WHERE id = ?";
    $stmt = $connessione->prepare($sql);
    if (!$stmt) {
        return ['message' => "Errore prepare: " . $connessione->error, 'type' => 'danger'];
    }
    $stmt->bind_param("i", $file_id);

    if ($stmt->execute()) {
        $result = ['message' => "File eliminato correttamente", 'type' => 'success'];
    } else {
        $result = ['message' => "Errore nell'eliminazione del file: " . $stmt->error, 'type' => 'danger'];
    }

    $stmt->close();
    $connessione->close();
    return $result;
}



// Modifica file
function modificaFile($file_id, $id_utente, $nome_file, $disponibile)
{
    $connessione = getDBConnection();

    if ($disponibile !== 'true' && $disponibile !== 'false') {
        $disponibile = 'false';
    }

    $sql = "UPDATE files SET disponibile = ?, nome_file = ? WHERE id = ? AND id_utente = ?";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("ssii", $disponibile, $nome_file, $file_id, $id_utente);

    if ($stmt->execute()) {
        $result = ['message' => "File modificato correttamente", 'type' => 'success'];
    } else {
        $result = ['message' => "Errore nella modifica del file: " . $stmt->error, 'type' => 'danger'];
    }

    $stmt->close();
    $connessione->close();
    return $result;
}



function getNome($id_file, $nome_file)
{
    $connessione = getDBConnection();

    $sql = "SELECT nome_file FROM files WHERE id = ?";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("i", $id_file);

    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_array();

    if ($nome_file === $row['nome_file']) {
        return $nome_file;
    } else {
        $time_stamp = substr($row['nome_file'], 0, 11);
        return $time_stamp . $nome_file;
    }
}


function modificaEmail($email_id, $id_utente, $nome_email, $id_dominio)
{
    $connessione = getDBConnection();

    // Controllo se la nuova email esiste già (escludendo quella corrente)
    $checkSql = "SELECT nome_email FROM email WHERE nome_email = ? AND id != ?";
    $check_stmt = $connessione->prepare($checkSql);
    $check_stmt->bind_param("si", $nome_email, $email_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $result = ['message' => "Errore: L'email '$nome_email' è già registrata nel sistema", 'type' => 'danger'];
    } else {
        $sql = "UPDATE email SET nome_email = ?, id_utente = ?, id_dominio = ? WHERE id = ?";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("siii", $nome_email, $id_utente, $id_dominio, $email_id);

        if ($stmt->execute()) {
            $result = ['message' => "Email modificata correttamente", 'type' => 'success'];
        } else {
            $result = ['message' => "Errore nella modifica dell'email: " . $stmt->error, 'type' => 'danger'];
        }
        $stmt->close();
    }

    $check_stmt->close();
    $connessione->close();
    return $result;
}


function modificaUtente($user_id, $email, $nome, $numero, $azienda, $ruolo, $data_registrazione, $attivo, $password)
{
    $connessione = getDBConnection();

    // Controllo se la nuova email esiste già 
    $checkSql = "SELECT Email FROM utenti WHERE Email = ? AND ID != ?";
    $check_stmt = $connessione->prepare($checkSql);
    $check_stmt->bind_param("si", $email, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $result = ['message' => "Errore: L'email '$email' è già registrata nel sistema", 'type' => 'danger'];
    } else {

        if (!empty($password)) {
            $sql = "UPDATE utenti SET Email = ?, Nome = ?, numero = ?, azienda = ?, ruolo = ?, data_registrazione = ?, attivo = ?, password = ? WHERE ID = ?";
            $stmt = $connessione->prepare($sql);
            $stmt->bind_param("ssssssssi", $email, $nome, $numero, $azienda, $ruolo, $data_registrazione, $attivo, $password, $user_id);
        } else {

            $sql = "UPDATE utenti SET Email = ?, Nome = ?, numero = ?, azienda = ?, ruolo = ?, data_registrazione = ?, attivo = ? WHERE ID = ?";
            $stmt = $connessione->prepare($sql);
            $stmt->bind_param("sssssssi", $email, $nome, $numero, $azienda, $ruolo, $data_registrazione, $attivo, $user_id);
        }

        if ($stmt->execute()) {
            $result = ['message' => "Utente modificato correttamente", 'type' => 'success'];
        } else {
            $result = ['message' => "Errore nella modifica dell'utente: " . $stmt->error, 'type' => 'danger'];
        }
        $stmt->close();
    }

    $check_stmt->close();
    $connessione->close();
    return $result;
}
