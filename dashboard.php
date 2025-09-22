<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "user") {
    header("Location: login.php");
    exit();
}

// OTTENGO LA CONNESSIONE AL DATABASE
$connessione = getDBConnection();

//COSTRUZIONE TABELLA DOMINI
$user_id = $_SESSION['id_utente'];
$sql = "SELECT * FROM domini WHERE id_utente = '$user_id'";

$result = $connessione->query($sql);
$TABELLA_DOMINI = "";

for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $TABELLA_DOMINI .= "<tr>
                <td>" . $row['nome_dominio'] . "</td>
                <td>" . $row['data_registrazione'] . "</td>
            </tr>";
}

//COSTRUZIONE TABELLA FILES
$sql = "SELECT * FROM files WHERE id_utente = '$user_id' AND disponibile = 'true'";

$result = $connessione->query($sql);
$TABELLA_FILES = "";

for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $TABELLA_FILES .= "<tr>
                <td>" . substr($row['nome_file'], 11) . "</td>
                <td>
                    <button class='btn btn-primary btn-sm'>
                        <i class='bi bi-download'></i> Download
                    </button>
                </td>
                <td>" . $row['data_upload'] . "</td>    
            </tr>";
}

//COSTRUZIONE TABELLA EMAIL
$sql = "SELECT * FROM email WHERE id_utente = '$user_id'";

$result = $connessione->query($sql);
$TABELLA_EMAIL = "";
for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $TABELLA_EMAIL .= "<tr>
                <td>" . $row['nome_email'] . "</td>
            </tr>";
}

$connessione->close();

$title = "Dashboard Utente";

$body = '
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="admin-container-large">
                <h4 class="page-title mb-4"><i class="bi bi-person-circle"></i> La tua Dashboard</h4>
                
                <!-- Tabella Domini -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="bi bi-globe2"></i> I tuoi domini</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle">
                            <thead>
                                <tr>
                                    <th>DOMINIO</th>
                                    <th>DATA REGISTRAZIONE</th>
                                </tr>
                            </thead>
                            <tbody>
                                ' . $TABELLA_DOMINI . '
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                
                <!-- Tabella Files -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="bi bi-archive"></i> I tuoi file</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle">
                            <thead>
                                <tr>
                                    <th>NOME FILE</th>
                                    <th>AZIONI</th>
                                    <th>DATA UPLOAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                ' . $TABELLA_FILES . '
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                
                <!-- Tabella Email -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="bi bi-envelope-fill"></i> Le tue email</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle">
                            <thead>
                                <tr>
                                    <th>EMAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                ' . $TABELLA_EMAIL . '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';

$template = file_get_contents('inc/template.inc.php');
$template = str_replace('{{title}}', $title, $template);
$template = str_replace('{{body}}', $body, $template);
echo $template;
