<?php
session_start();


$message = "";
$messageType = "";
$connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM utenti WHERE Email = ?";
    $stmt = $connessione->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if ($row['attivo'] == "false") {
            $message = "Account non attivo. Contatta l'amministratore per l'attivazione.";
            $messageType = "warning";
        }elseif (password_verify($password, $row['password']) || $password === $row['password']) {

            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $row['Email'];
            $_SESSION["ruolo"] = $row['ruolo'];
            $_SESSION["id_utente"] = $row['ID'];
            $_SESSION["ultimo_accesso"] = $row['ultimo_accesso'];
                $data_ora_corrente = date("Y-m-d H:i:s");   
                $update_sql = "UPDATE utenti SET ultimo_accesso = ? WHERE ID = ?";
                $update_stmt = $connessione->prepare($update_sql);
                $update_stmt->bind_param("si", $data_ora_corrente, $row['ID']);
                $update_stmt->execute();
                $update_stmt->close();
            if ($row["ruolo"] === "admin") {
                
                header('Location: admin.php');
                exit();
            } else {

                header('Location: dashboard.php');
                exit();
            }
        } else {
            $message = "Credenziali non corrette.";
            $messageType = "danger";
        }
    } else {
        $message = "Credenziali non corrette.";
        $messageType = "danger";
    }
    $stmt->close();
    $connessione->close();
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftwareEngeniring - Login</title>

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
        <div class="login-container">
        <div class="text-center mb-4">
            <img src="assets/images/logo_softwarengineering_blubordobianco.png" alt="Logo" class="Logo">
        </div>

        <!-- Alert Bootstrap -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form class="needs-validation" novalidate method="POST" action="login.php">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                <div id="emailHelp" class="form-text">Non mostreremo mai a nessuno la tua mail.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
            </div>
            
            <div class="forgot-pass">
                <a href="recupera-pass.php">Password dimenticata?</a>
            </div>
            <br><br>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
            </div>
            <div class="text-center">
                <a href="index.php" id="bottone" class="btn btn-primary">TORNA ALLA HOME</a>
            </div>
        </form>
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