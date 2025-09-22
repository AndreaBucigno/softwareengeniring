<?php
require_once 'config/database.php';

// Costruisce tabella utenti
function buildUsersTable()
{
    $connessione = getDBConnection();

    $TABELLE_UTENTI = "";
    $sql = "SELECT * FROM utenti";
    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $TABELLE_UTENTI .= "<tr>
                    <td>" . $row['ID'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['Nome'] . "</td>
                    <td>" . $row['ruolo'] . "</td>
                    <td>" . $row['attivo'] . "</td>
                    <td>" . $row['data_registrazione'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm me-2'>
                            <i class='bi bi-pencil-square'></i> Modifica
                        </button>
                    </td>
                    <td><a href='admin.php?filter_id=" . $row['ID'] . "' class='btn btn-success btn-sm'><i class='bi bi-filter'></i>Filtra</a></td>
                </tr>";
    }

    $connessione->close();
    return $TABELLE_UTENTI;
}

// Costruisce tabella domini
function buildDomainsTable($filter_id = null)
{
    $connessione = getDBConnection();

    $TABELLA_DOMINI = "";
    if ($filter_id) {
        $sql = "SELECT * FROM domini WHERE id_utente = $filter_id";
    } else {
        $sql = "SELECT * FROM domini";
    }

    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $TABELLA_DOMINI .= "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['id_utente'] . "</td>
                    <td>" . $row['nome_dominio'] . "</td>
                    <td>" . $row['data_registrazione'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm me-2'>
                            <i class='bi bi-pencil-square'></i> Modifica
                        </button>
                        
                    </td>
                </tr>";
    }

    $connessione->close();
    return $TABELLA_DOMINI;
}

// Costruisce tabella files
function buildFilesTable($filter_id = null)
{
    $connessione = getDBConnection();

    $TABELLA_FILES = "";
    if ($filter_id) {
        $sql = "SELECT * FROM files WHERE id_utente = $filter_id";
    } else {
        $sql = "SELECT * FROM files";
    }

    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $TABELLA_FILES .= "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['id_utente'] . "</td>
                    <td>" . $row['nome_file'] . "</td>
                    <td>" . $row['data_upload'] . "</td>
                    <td>" . $row['disponibile'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm me-2 btn-modifica-file' data-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#editFileModal'>
                            <i class='bi bi-pencil-square'></i> Modifica
                        </button>
                        
                    </td>
                </tr>";
    }

    $connessione->close();
    return $TABELLA_FILES;
}

// Costruisce tabella email
function buildEmailsTable($filter_id = null)
{
    $connessione = getDBConnection();

    $TABELLA_EMAIL = "";
    if ($filter_id) {
        $sql = "SELECT * FROM email WHERE id_utente = $filter_id";
    } else {
        $sql = "SELECT * FROM email";
    }

    $result = $connessione->query($sql);
    foreach ($result as $row) {
        $TABELLA_EMAIL .= "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['id_utente'] . "</td>
                    <td>" . $row['id_dominio'] . "</td>
                    <td>" . $row['nome_email'] . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm me-2 btn-modifica-email' data-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#editEmailModal'>
                            <i class='bi bi-pencil-square'></i> Modifica
                        </button>
                    </td>
                </tr>";
    }

    $connessione->close();
    return $TABELLA_EMAIL;
}
