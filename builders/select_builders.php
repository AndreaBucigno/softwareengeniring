<?php
require_once 'config/database.php';

// Costruisce select per ID utente
function buildUserSelect()
{
    $connessione = getDBConnection();

    $SELECT_ID = "<select class='form-select' name='id_utente' id='id_utente' required>
                    <option value='' disabled selected>Seleziona ID Utente</option>";
    $sql = "SELECT ID, Email FROM utenti";
    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $SELECT_ID .= "<option value='" . $row['ID'] . "'>" . $row['ID'] . " - " . $row['Email'] . "</option>";
    }
    $SELECT_ID .= "</select>";

    $connessione->close();
    return $SELECT_ID;
}

// Costruisce select per ID dominio
function buildDomainSelect()
{
    $connessione = getDBConnection();

    $SELECT_ID_DOMINIO = "<select class='form-select' name='id_dominio' id='id_dominio' required>
                    <option value='' disabled selected>Seleziona ID Dominio</option>";
    $sql = "SELECT id, nome_dominio FROM domini";
    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $SELECT_ID_DOMINIO .= "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['nome_dominio'] . "</option>";
    }
    $SELECT_ID_DOMINIO .= "</select>";

    $connessione->close();
    return $SELECT_ID_DOMINIO;
}
