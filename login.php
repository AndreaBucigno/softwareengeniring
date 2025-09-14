<?php

session_start();

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $utenti = json_decode(file_get_contents("data/utenti.json"), true);

    if (isset($utenti[$email])) {
        // Controllo stato attivo (gestisce sia booleano che stringa)
        if ($utenti[$email]["attivo"] === false) {
            $message = "Il tuo account non è attivo. Contatta l'amministratore.";
            $messageType = "warning";
        } elseif ($password === $utenti[$email]["password"]) {
            $_SESSION["loggedin"] = true;
            $_SESSION['user'] = $email;
            $_SESSION['user_name'] = $utenti[$email]["nome"] ?? "UtenteGuest"; //se l'utente non ha un nome prende il nome di utenteGuest
            $_SESSION['login_time'] = time();

            // Aggiorna ultimo accesso
            $utenti[$email]["ultimo_accesso"] = date('Y-m-d H:i:s');
            file_put_contents("data/utenti.json", json_encode($utenti, JSON_PRETTY_PRINT), LOCK_EX);  // LOCK_EX per evitare problemi di concorrenza cioè più utenti che scrivono contemporaneamente

            header('Location: dashboard.php');
            exit();
            // Perché exit()?
            // header() dice al browser "vai a user-page.php"
            // Ma il PHP continuerebbe a eseguire il resto del codice!
            // exit() ferma tutto, così il redirect funziona correttamente


        } else {
            $message = "Credenziali non corrette.";
            $messageType = "danger";
        }
    } else {
        $message = "Credenziali non corrette.";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftwarEngeniring - Login</title>

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
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
            </div>
            <div class="text-center">
                <a href="index.php" id="bottone" class="btn btn-primary">TORNA ALLA HOME</a>
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