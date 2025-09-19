<?php
session_start();

// Controllo sessione - solo admin possono accedere
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Stabilire la connessione al database all'inizio
$connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}

//  ELIMINA FILE
if (isset($_POST['elimina_file_id'])) {
    $file_id = trim($_POST['elimina_file_id']);

    $sql = "UPDATE files SET disponibile = 'false' WHERE id = ?";
    $stmt = $connessione->prepare($sql);
    if (!$stmt) {
        die("Errore prepare: " . $connessione->error);
    }
    $stmt->bind_param("i", $file_id);

    if ($stmt->execute()) {
        $message = "File eliminato correttamente";
        $messageType = "success";
    } else {
        $message = "Errore nell'eliminazione del file: " . $stmt->error;
        $messageType = "danger";
    }
    $stmt->close();
}

//MODIFICA FILE

// MODIFICA FILE - Sposta questo codice all'inizio, prima di qualsiasi output
if (isset($_POST['modifica_file_id'])) {
    $file_id     = intval($_POST['modifica_file_id']);
    $id_utente   = intval($_POST['modifica_id_utente']); // Aggiungi questa riga
    $nome_file   = trim($_POST['nome_file']);
    $disponibile = $_POST['disponibile'] ?? 'false';

    if ($disponibile !== 'true' && $disponibile !== 'false') {
        $disponibile = 'false';
    }

    $sql = "UPDATE files SET disponibile = ?, nome_file = ? WHERE id = ? AND id_utente = ?";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("ssii", $disponibile, $nome_file, $file_id, $id_utente);

    //SUPERFLUO PERCHE FACCIAMO IL REDIRECT PER EVITARE CHE VENGA ESEGUITO IL CODICE DI INS3ERIMENTO PRIMA CHE FACCIAMO I CAMBIAMENTI
    if ($stmt->execute()) {
        $message = "File modificato correttamente";
        $messageType = "success";
    } else {
        $message = "Errore nella modifica del file: " . $stmt->error;
        $messageType = "danger";
    }
    $stmt->close();

    // Reindirizza per evitare che venga eseguito il codice di inserimento
    header("Location: admin.php");
    exit();
}





$modal_tmp = file_get_contents('view/modal.View.html');
$modal_edit = file_get_contents('view/modalModify.View.html');
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gestione form utente
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
        $name = trim($_POST["name"]);
        $numero = trim($_POST["numero"]);
        $NomeAzienda = trim($_POST["NomeAzienda"]);
        $ruolo = trim($_POST["ruolo"]);
        $dataRegistrazione = trim($_POST["dataRegistrazione"]);
        $Attivo = trim($_POST["Attivo"]);
        $password = trim($_POST["password"]);

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
    }

    // Gestione form dominio
    if (isset($_POST["nome_dominio"])) {
        $id_utente = trim($_POST["id_utente"]);
        $nome_dominio = trim($_POST["nome_dominio"]);

        $checkSql = "SELECT nome_dominio FROM domini WHERE nome_dominio = '$nome_dominio'";
        $check_stmt = $connessione->query($checkSql);
        if ($check_stmt->num_rows > 0) {
            $message = "Dominio già registrato";
            $messageType = "danger";
        } else {

            $sql = "INSERT INTO domini (id_utente, nome_dominio, data_registrazione) VALUES (?, ?, CURDATE())";
            $stmt = $connessione->prepare($sql);
            $stmt->bind_param("is", $id_utente, $nome_dominio);

            if ($stmt->execute()) {
                $message = "Dominio registrato correttamente";
                $messageType = "success";
            } else {
                $message = "Errore nella registrazione del dominio";
                $messageType = "danger";
            }
            $stmt->close();
        }
    }
}


//Costruzione form file

if (isset($_POST["nome_file"])) {
    $id_utente = trim($_POST['id_utente']);
    $nome_file = trim($_POST['nome_file']);
    $data_ora_corrente = time();
    $data_ora_corrente .= "_" . $nome_file;

    $sql = "INSERT INTO files(id_utente,nome_file,data_upload,disponibile) VALUES (?,?,CURDATE(),true)";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("is", $id_utente, $data_ora_corrente);
    if ($stmt->execute()) {
        $message = "Dominio registrato correttamente";
        $messageType = "success";
    } else {
        $message = "Errore nella registrazione del dominio";
        $messageType = "danger";
    }
    $stmt->close();
}

// Costruzione SELECT ID Utente
$SELECT_ID = "<select class='form-select' name='id_utente' id='id_utente' required>
                <option value='' disabled selected>Seleziona ID Utente</option>";
$sql = "SELECT ID, Email FROM utenti";
$result = $connessione->query($sql);
foreach ($result as $row) {
    $SELECT_ID .= "<option value='" . $row['ID'] . "'>" . $row['ID'] . " - " . $row['Email'] . "</option>";
}

$SELECT_ID .= "</select>";

//costruzione form PER EMaiL

if (isset($_POST['email_form_email'])) {
    $nome_email = trim($_POST['email_form_email']);
    $id_utente = trim($_POST['id_utente']);
    $id_dominio = trim($_POST['id_dominio']);

    $checkSql = "SELECT nome_email FROM email WHERE nome_email = '$nome_email'";
    $check_stmt = $connessione->query($checkSql);
    if ($check_stmt->num_rows > 0) {
        $message = "Email già registrata";
        $messageType = "danger";
    } else {

        $sql = "INSERT INTO email (id_utente, nome_email, id_dominio) VALUES (?, ?, ?)";
        $stmt = $connessione->prepare($sql);
        $stmt->bind_param("isi", $id_utente, $nome_email, $id_dominio);

        if ($stmt->execute()) {
            $message = "Email registrato correttamente";
            $messageType = "success";
        } else {
            $message = "Errore nella registrazione dell'email";
            $messageType = "danger";
        }
        $stmt->close();
    }
}

// Costruzione SELECT ID Utente
$SELECT_ID_DOMINIO = "<select class='form-select' name='id_dominio' id='id_dominio' required>
                <option value='' disabled selected>Seleziona ID Utente</option>";
$sql = "SELECT id, nome_dominio FROM domini ";
$result = $connessione->query($sql);
foreach ($result as $row) {
    $SELECT_ID_DOMINIO .= "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['nome_dominio'] . "</option>";
}

$SELECT_ID_DOMINIO .= "</select>";

// Costruzione utenti registrati
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
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                </td>
                <td><a href='admin.php?filter_id=" . $row['ID'] . "' class='btn btn-success btn-sm'><i class='bi bi-filter'></i>Filtra</a></td>
            </tr>";
}

// Recupero filter_id da URL
$filter_id = isset($_GET['filter_id']) ? $_GET['filter_id'] : null;

// Costruzione domini registrati
$TABELLA_DOMINI = "";

// Condizione che verifica se filter_id esiste per filtrare le tabelle
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
                    <button class='btn btn-danger btn-sm'>
                        <i class='bi bi-trash'></i> Elimina
                    </button> 
                </td>
            </tr>";
}

// Costruzione files registrati
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
                    <button class='btn btn-danger btn-sm btn-rimuovi-file' data-id='" . $row['id'] . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                    <i class='bi bi-trash'></i> Elimina
                </button>
                </td>
            </tr>";
}

// Costruzione email registrati
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
        <!-- Colonna sinistra - Form creazione utente e dominio -->
        <div class="col-lg-4">
            <div class="admin-container">';

if (!empty($message)) {
    $body .= '<div class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

$body = '<div class="container-fluid">
    <div class="row">
        <!-- Colonna sinistra - Form creazione utente, dominio e file -->
        <div class="col-lg-4">
            <div class="admin-container">';

if (!empty($message)) {
    $body .= '<div class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

$body = '<div class="container-fluid">
    <div class="row">
        <!-- Colonna sinistra - Form creazione utente, dominio e file -->
        <div class="col-lg-4">
            <div class="admin-container">';

if (!empty($message)) {
    $body .= '<div class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

$body .= $modal_edit . $modal_tmp;

$body .= '<!-- Bottone toggle per utente -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formUtente" aria-expanded="false" aria-controls="formUtente" id="toggleFormButton">
                        <i class="bi bi-person-fill-add"></i>
                        Crea Nuovo Utente
                    </button>
                </div>

                <!-- Form utente collassabile -->
                <div class="collapse mb-4 form-collapse" id="formUtente">
                    <div class="card-body">
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

                <!-- Bottone toggle per dominio -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formDominio" aria-expanded="false" aria-controls="formDominio" id="toggleFormButton2">
                        <i class="bi bi-globe"></i>
                        Crea Nuovo Dominio
                    </button>
                </div>

                <!-- Form dominio collassabile -->
                <div class="collapse mb-4 form-collapse" id="formDominio">
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm2">
                            <div class="mb-3">
                                <label for="id_utente" class="form-label">ID Utente</label>
                                ' . $SELECT_ID . '
                            </div>
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

                <!-- Bottone toggle per file -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formFile" aria-expanded="false" aria-controls="formFile" id="toggleFormButton3">
                        <i class="bi bi-file-earmark-plus"></i>
                        Aggiungi un nuovo file
                    </button>
                </div>

                <!-- Form file collassabile -->
                <div class="collapse mb-4 form-collapse" id="formFile">
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm3">
                            <div class="mb-3">
                                <label for="id_utente_file" class="form-label">ID Utente</label>
                                ' . $SELECT_ID . '
                            </div>
                            <div class="mb-3">
                                <label for="nome_file" class="form-label">Nome File</label>
                                <input type="text" class="form-control" id="nome_file" name="nome_file" required> 
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Upload a file</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block">Aggiungi File</button>
                            </div>
                        </form>
                    </div>
                </div>

            <!-- Bottone toggle per file -->
                <div class="text-center mb-3">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formEmail" aria-expanded="false" aria-controls="formEmail" id="toggleFormButton4">
                        <i class="bi bi-envelope"></i>
                        Collega una nuova mail.
                    </button>
                </div>



                <!-- Form file collassabile -->
                <div class="collapse mb-4 form-collapse" id="formEmail">
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm4">
                        <div class="mb-3">    
                        <label for="id_utente_email" class="form-label">ID Utente</label>
                                ' . $SELECT_ID . '
                            </div>
                            
                            <div class="mb-3">
                            <label for="id_dominio_email" class="form-label">ID Dominio</label>
                                ' . $SELECT_ID_DOMINIO . '
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email_form_email" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-block">Aggiungi File</button>
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
                    <a class="btn btn-secondary mb-3" href="admin.php">
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
                                ' . $TABELLE_UTENTI . '
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
                               ' . $TABELLA_DOMINI . '
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
                        <table class="table table-dark table-striped tabelle" id="tabella3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ID_UTENTE</th>
                                    <th>NOME FILE</th>
                                    <th>DATA UPLOAD</th>
                                    <th>DISPONIBILE</th>
                                    <th>AZIONI</th>
                                </tr>
                            </thead>
                            <tbody>
                               ' . $TABELLA_FILES . '
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
                        <table class="table table-dark table-striped tabelle" id="tabella4">
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
                               ' . $TABELLA_EMAIL . '
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
