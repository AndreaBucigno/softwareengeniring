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
            $message = "Utento registrato correttamente";
            $messageType = "success";
        } else {
            $message = "Errore nella registazione dell'utente";
            $messageType = "danger";
        }
        $stmt->close();
    }
    $check_stmt->close();
    $connessione->close();
}

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftwareEngeniring - AdiminPage</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container fluid">
        <div class="admin-container">
            <div class="text-center mb-4">
                <a class="navbar-brand" href="login.php">
                    <img src="assets/images/logo_softwarengineering_blubordobianco.png" alt="Logo" class="Logo">
                </a>
            </div>

            <!-- Alert Bootstrap -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Bottone toggle -->
            <div class="text-center mb-3">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formUtente" aria-expanded="false" aria-controls="formUtente">
                    Crea Nuovo Utente
                </button>
            </div>

            <!-- Form collassabile -->
            <div class="collapse" id="formUtente">
                <div class="card card-body shadow-sm">
                    <form class="needs-validation" novalidate method="POST" action="admin.php">
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
                                <option value="utente">Utente</option>
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

    <script>
        // sparisce dopo 5 secondi
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>


</html>