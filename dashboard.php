<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "user") {
    header("Location: login.php");
    exit();
}


$connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}

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

$user_id = $_SESSION['id_utente'];
$sql = "SELECT * FROM files WHERE id_utente = '$user_id'";

$result = $connessione->query($sql);
$TABELLA_FILES = "";

for ($i = 0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $TABELLA_FILES .= "<tr>
                <td>" . $row['nome_file'] . "</td>
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

$title = "User Page";

$body = '
<div class="container">
<div class="admin-container-large">  
    <div class="text-center mb-4">
        <h4><i class="bi bi-globe2"></i> I tuoi domini</h4>
        </div>
    <div class="container-T1">

        <table class="tabelle" id="miaTabella">
            <thead>
                <tr>
                    <th>DOMINIO</th>
                    <th>DATA REGISTRAZIONE</th>
                </tr>
            </thead>
            <tbody>
                '.$TABELLA_DOMINI.'
            </tbody>
        </table>
    </div>
    <hr>
    <div class="container-T2">
    <div class="text-center mb-4">
    
        <h4><i class="bi bi-archive"></i> I tuoi file </h4>
        </div>
        <table class="tabelle" id="miaTabella2">
            <thead>
                <tr>
                    <th>Nome file</th>
                    <th>Azioni</th>
                    <th>Data upload</th>
                </tr>
            </thead>
            <tbody>
                '.$TABELLA_FILES.'
            </tbody>
        </table>
    </div>
<hr>
    <div class="container-T3">
    <div class="text-center mb-4">
        <h4><i class="bi bi-envelope-fill"></i> Le tue email </h4>
        </div>
        <table class="tabelle" id="miaTabella3">
            <thead>
                <tr>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                '.$TABELLA_EMAIL.'
            </tbody>
        </table>
    </div>
</div>
';


$template = file_get_contents('inc/template.inc.php');
$template = str_replace('{{title}}', $title, $template);
$template = str_replace('{{body}}', $body, $template);  
echo $template;
?>