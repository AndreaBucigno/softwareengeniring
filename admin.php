<?php
session_start();
$message = "";
$messageType = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
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

    $sql = "INSERT INTO utenti (Email, Nome, numero, azienda, ruolo, data_registrazione, attivo, password) VALUES ('$email', '$name', '$numero', '$NomeAzienda', '$ruolo', '$dataRegistrazione', '$Attivo', '$password')";
    if ($connessione->query($sql) === true) {
        $message = "Nuovo record creato con successo";
        $messageType = "success";
    } else {
        $message = "Errore: " . $sql . "<br>" . $connessione->error;
        $messageType = "danger";
    }
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
    <div class="container login-container mt-3">
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
        
        <form class="needs-validation" novalidate method="POST" action="admin.php">
            <div class="mb-3">

                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                
                <br>
                <label for="name" class="form-label">Nome e Cognome</label>
                <input type="text" class="form-control" id="name" name="name" required>

                <br>
                <label for="numero" class="form-label">Numero di  Telefono</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
                
                <br>
                <label for="NomeAzienda" class="form-label">Nome azienda</label>
                <input type="text" class="form-control" id="NomeAzienda" name="NomeAzienda" required>
                
                <br>
                <label for="ruolo" class="form-label">Ruolo</label>
                <input type="text" class="form-control" id="ruolo" name="ruolo" required>
                
                <br>
                <label for="dataRegistrazione">Data Registrazione</label>
                <input type="date" class="form-control" id="dataRegistrazione" name="dataRegistrazione" required>
                
                <br>
                <label for="Attivo" class="form-label">Stato Attivo (true/false)</label>
                <select class="form-select" aria-label="Default select example" name="Attivo" id="Attivo" required>
                    <option selected>Seleziona Stato</option>
                    <option value="true">true</option>
                    <option value="false">false</option>
                </select>
                
                    <br>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                
                <br>
                <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
                </div>
            </div>
        </form>


        
    </div>

    <script>
        // sparisce dopo 5 secondi
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>

</html>