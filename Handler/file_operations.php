<?php
require_once 'config/database.php';

// Elimina file
function eliminaFile($file_id)
{
    $connessione = getDBConnection();

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
