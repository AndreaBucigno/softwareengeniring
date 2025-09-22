<?php
session_start();

// Controllo sessione
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Include tutti i file necessari
require_once 'config/database.php';
require_once 'Handler/form_handlers.php';
require_once 'Handler/file_operations.php';
require_once 'builders/table_builders.php';
require_once 'builders/html_builder.php';

$message = "";
$messageType = "";

// GESTIONE ELIMINAZIONE FILE
if (isset($_POST['elimina_file_id'])) {
    $file_id = trim($_POST['elimina_file_id']);
    $result = eliminaFile($file_id);
    $message = $result['message'];
    $messageType = $result['type'];
}

// GESTIONE MODIFICA EMAIL
if (isset($_POST['modifica_email_id'])) {
    $email_id = intval($_POST['modifica_email_id']);
    $id_utente = intval($_POST['modifica_email_id_utente']);
    $nome_email = trim($_POST['nome_email']);
    $id_dominio = intval($_POST['modifica_email_id_dominio']);

    $result = modificaEmail($email_id, $id_utente, $nome_email, $id_dominio);
    $message = $result['message'];
    $messageType = $result['type'];

    // Redirect per evitare ri-esecuzione
    header("Location: admin.php");
    exit();
}

// GESTIONE MODIFICA FILE
if (isset($_POST['modifica_file_id'])) {
    $file_id = intval($_POST['modifica_file_id']);
    $id_utente = intval($_POST['modifica_id_utente']);
    $nome_file = trim($_POST['nome_file']);
    $disponibile = $_POST['disponibile'] ?? 'false';

    $nome_file = getNome($file_id, $nome_file);
    $result = modificaFile($file_id, $id_utente, $nome_file, $disponibile);
    $message = $result['message'];
    $messageType = $result['type'];

    // Redirect per evitare ri-esecuzione
    header("Location: admin.php");
    exit();
}

// GESTIONE MODIFICA UTENTE
if (isset($_POST['modifica_utente_id'])) {
    $user_id = intval($_POST['modifica_utente_id']);
    $email = trim($_POST['email']);
    $nome = trim($_POST['name']);
    $numero = trim($_POST['numero']);
    $azienda = trim($_POST['NomeAzienda']);
    $ruolo = trim($_POST['ruolo']);
    $data_registrazione = trim($_POST['dataRegistrazione']);
    $attivo = trim($_POST['Attivo']);
    $password = trim($_POST['password']); // Può essere vuota

    $result = modificaUtente($user_id, $email, $nome, $numero, $azienda, $ruolo, $data_registrazione, $attivo, $password);
    $message = $result['message'];
    $messageType = $result['type'];

    // Redirect per evitare ri-esecuzione
    header("Location: admin.php");
    exit();
}

// GESTIONE FORM POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form utente
    if (isset($_POST["email"]) && !isset($_POST['modifica_utente_id'])) {
        $result = handleUserForm($_POST);
        $message = $result['message'];
        $messageType = $result['type'];
    }

    // Form dominio
    if (isset($_POST["nome_dominio"])) {
        $result = handleDomainForm($_POST);
        $message = $result['message'];
        $messageType = $result['type'];
    }

    // Form file
    if (isset($_POST["nome_file"])) {
        $result = handleFileForm($_POST);
        $message = $result['message'];
        $messageType = $result['type'];
    }

    // Form email
    if (isset($_POST['email_form_email'])) {
        $result = handleEmailForm($_POST);
        $message = $result['message'];
        $messageType = $result['type'];
    }
}

// Recupero filter_id da URL
$filter_id = isset($_GET['filter_id']) ? $_GET['filter_id'] : null;

// Costruzione tabelle
$TABELLE_UTENTI = buildUsersTable();
$TABELLA_DOMINI = buildDomainsTable($filter_id);
$TABELLA_FILES = buildFilesTable($filter_id);
$TABELLA_EMAIL = buildEmailsTable($filter_id);

// Caricamento modali
$modal_edit_Email = file_get_contents("view/modalEditEmail.html");
$modal_edit = file_get_contents('view/modalModify.View.html');
$modal_edit_Utente = file_get_contents('view/modalEditUtente.html');

// Costruzione HTML body
$body = buildHTMLBody($message, $messageType, $TABELLE_UTENTI, $TABELLA_DOMINI, $TABELLA_FILES, $TABELLA_EMAIL, $modal_edit, $modal_edit_Email, $modal_edit_Utente);

// Output finale
$title = "AdminPage";
$template = file_get_contents('inc/template.inc.php');
$template = str_replace('{{title}}', $title, $template);
$template = str_replace('{{body}}', $body, $template);
echo $template;
