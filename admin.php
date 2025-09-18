<?php
session_start();

// Controllo sessione - solo admin possono accedere
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $name = trim($_POST["name"]);
    $numero = trim($_POST["numero"]);
    $NomeAzienda = trim($_POST["NomeAzienda"]);
    $ruolo = trim($_POST["ruolo"]);
    $dataRegistrazione = trim($_POST["dataRegistrazione"]);
    $Attivo = trim($_POST["Attivo"]);
    $password = trim($_POST["password"]);

    $connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }

    // Controllo se l'email esiste già
    $check_sql = "SELECT Email FROM utenti WHERE Email = ?";
    $check_stmt = $connessione->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "Errore: L'email '$email' è già registrata nel sistema";
        $messageType = "danger";
    } else {
        // Email non esiste, procedo con l'inserimento
        $sql = "INSERT INTO utenti (Email, Nome, numero, azienda, ruolo, data_registrazione, attivo, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("ssssssss", $email, $name, $numero, $NomeAzienda, $ruolo, $dataRegistrazione, $Attivo, $password);

        if ($stmt->execute()) {
            $message = "Utente registrato correttamente";
            $messageType = "success";
        } else {
            $message = "Errore nella registrazione dell'utente";
            $messageType = "danger";
        }
        $stmt->close();
    }
    $check_stmt->close();
    $connessione->close();
}


$connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}
//Costruzione SELECT ID Utente
$SELECT_ID = "<select class='form-select' name='id_utente' id='id_utente' required>
                <option value='' disabled selected>Seleziona ID Utente</option>";
$sql = "SELECT ID, Email FROM utenti";
$result = $connessione->query($sql);
foreach ($result as $row) {
    $SELECT_ID .= "<option value='" . $row['ID'] . "'>" . $row['ID'] . " - " . $row['Email'] . "</option>";
}
$SELECT_ID .= "</select>";







//Costruione utenti registrati

$connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}

$TABELLE_UTENTI = "";
$sql = "SELECT * FROM utenti";
$result = $connessione->query($sql);
foreach($result as $row) {
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
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                   
                </td>
                
                <td><a href='admin.php?filter_id=" . $row['ID'] . "' class='btn btn-success btn-sm'><i class='bi bi-filter'></i>Filtra</a></td>
            </tr>";
}


//Recupero filter_id da URL
$filter_id = isset($_GET['filter_id']) ? $_GET['filter_id'] : null;

//Costruione domini registrati

$TABELLA_DOMINI="";

//condizione che verifica se filte id esiste per filtrare le tabelle
if($filter_id){
    $sql="SELECT * FROM domini WHERE id_utente = $filter_id";
}else{
    $sql="SELECT * FROM domini"; 
}

$result = $connessione->query($sql);
foreach($result as $row) {
    $TABELLA_DOMINI .= "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['id_utente'] . "</td>
                <td>" . $row['nome_dominio'] . "</td>
                <td>" . $row['data_registrazione'] . "</td>
                
                <td>
                    <button class='btn btn-warning btn-sm me-2'>
                        <i class='bi bi-pencil-square'></i> Modifica
                    </button>
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                </td>
            </tr>";
}

//Costruione files registrati

$TABELLA_FILES="";
if($filter_id){
    $sql="SELECT * FROM files WHERE id_utente = $filter_id";
}else{
    $sql="SELECT * FROM files"; 
}
$result = $connessione->query($sql);
foreach($result as $row) {
    $TABELLA_FILES .= "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['id_utente'] . "</td>
                <td>" . $row['nome_file'] . "</td>
                <td>" . $row['data_upload'] . "</td>
                
                <td>
                    <button class='btn btn-warning btn-sm me-2'>
                        <i class='bi bi-pencil-square'></i> Modifica
                    </button>
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                </td>
            </tr>";
}

//Costruione email registrati

$TABELLA_EMAIL="";
if($filter_id){
    $sql="SELECT * FROM email WHERE id_utente = $filter_id";
}else{
    $sql="SELECT * FROM email";
}
$result = $connessione->query($sql);
foreach($result as $row) {
    $TABELLA_EMAIL .= "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['id_utente'] . "</td>
                <td>" . $row['id_dominio'] . "</td>
                <td>" . $row['nome_email'] . "</td>
                
                <td>
                    <button class='btn btn-warning btn-sm me-2'>
                        <i class='bi bi-pencil-square'></i> Modifica
                    </button>
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                </td>
            </tr>";
}

$connessione->close();

$title = "AdminPage";

$body = '<div class="container-fluid">
    <div class="row">
        <!-- Colonna sinistra - Form creazione utente -->
        <div class="col-lg-4">
            <div class="admin-container">';

if (!empty($message)) {
    $body .= '<div class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">
            ' . $message . '
        </div>';
}

$body .= '<!-- Bottone toggle -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formUtente" aria-expanded="false" aria-controls="formUtente" id="toggleFormButton">
                        <i class="bi bi-person-fill-add"></i>
                        Crea Nuovo Utente
                    </button>
                </div>

                <!-- Form collassabile -->
                <div class="collapse" id="formUtente">
                    <div class="card card-body shadow-sm">
                        <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome e Cognome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="numero" class="form-label">Numero di Telefono</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>

                            <div class="mb-3">
                                <label for="NomeAzienda" class="form-label">Nome azienda</label>
                                <input type="text" class="form-control" id="NomeAzienda" name="NomeAzienda" required>
                            </div>

                            <div class="mb-3">
                                <label for="ruolo" class="form-label">Ruolo</label>
                                <select class="form-select" name="ruolo" id="ruolo" required>
                                    <option value="" disabled selected>Seleziona tipo di utente</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Utente</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="dataRegistrazione" class="form-label">Data Registrazione</label>
                                <input type="date" class="form-control" id="dataRegistrazione" name="dataRegistrazione" required>
                            </div>

                            <div class="mb-3">
                                <label for="Attivo" class="form-label">Stato Attivo</label>
                                <select class="form-select" name="Attivo" id="Attivo" required>
                                    <option value="" disabled selected>Seleziona Stato</option>
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block">Crea Utente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottone toggle 2  -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formUtente" aria-expanded="false" aria-controls="formUtente" id="toggleFormButton">
                        <i class="bi bi-person-fill-add"></i>
                        Crea Nuovo Utente
                    </button>
                </div>
                <!-- Form collassabile -->
                <div class="collapse" id="formUtente">
                    <div class="card card-body shadow-sm">
                        <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm">
                            ' . $SELECT_ID . '
                            <div class="mb-3">
                                <label for="nome_dominio" class="form-label">Nome Dominio</label>
                                <input type="text" class="form-control" id="nome_dominio" name="nome_dominio" required> 
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block">Crea Dominio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonna destra - Riquadro con le tabelle -->
        <div class="col-lg-8">
            <div class="admin-container-large">
                <h4 class="page-title mb-4">
                     Gestione dati
                </h4>
                <hr>
                
                <!-- Prima tabella -->
                <div class="mb-4">
                    <h5 class="mb-3">
                       Gestione Utenti
                    </h5>
                    <a class="btn btn-secondary mb-3" href="admin.php?filter_id="' .null.'">
                        <i class="bi bi-x-circle"></i> Rimuovi Filtro</a>
                     <br>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle" id="tabella1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>EMAIL</th>
                                    <th>NOME</th>
                                    <th>RUOLO</th>
                                    <th>ATTIVO</th>
                                    <th>DATA REGISTRAZIONE</th>
                                    <th>Azioni</th>
                                    <th>Filtra</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$TABELLE_UTENTI.'
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <!-- Seconda tabella -->
                <div class="mb-4">
                    <h5 class="mb-3">
                          Gestione Domini
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle" id="tabella2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID_UTENTE</th>
                                    <th>NOME DOMINIO</th>
                                    <th>DATA CREAZIONE</th>
                                    <th>AZIONI</th>
                                </tr>
                            </thead>
                            <tbody>
                               '.$TABELLA_DOMINI.'
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <!-- Terza tabella -->
                <div class="mb-4">
                    <h5 class="mb-3">
                          Gestione Files
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle" id="tabella2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID_UTENTE</th>
                                    <th>NOME FILE</th>
                                    <th>DATA UPLOAD</th>
                                    <th>AZIONI</th>
                                </tr>
                            </thead>
                            <tbody>
                               '.$TABELLA_FILES.'
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <!-- Quarta tabella -->
                <div class="mb-4">
                    <h5 class="mb-3">
                          Gestione Email
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped tabelle" id="tabella2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID_UTENTE</th>
                                    <th>ID_DOMINIO</th>
                                    <th>EMAIL</th>
                                    <th>AZIONI</th>
                                </tr>
                            </thead>
                            <tbody>
                               '.$TABELLA_EMAIL.'
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';

$template = file_get_contents('inc/template.inc.php');
$template = str_replace('{{title}}', $title, $template);
$template = str_replace('{{body}}', $body, $template);
echo $template;
?>