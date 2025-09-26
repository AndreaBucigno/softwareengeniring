<?php
session_start();
require_once 'config/database.php';
require_once 'builders/resetPass.php'; // Funzione getBodyEmail()

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'assets/lib/vendor/autoload.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Ottengo la connessione al database
    $connessione = getDBConnection();

    // Recupero Email e password (ATTENZIONE: password in chiaro)
    $sql = "SELECT Email, password, nome FROM utenti WHERE Email = ? AND attivo = 'true' LIMIT 1";
    $stmt = $connessione->prepare($sql);

    if ($stmt === false) {
        $message = "Errore interno (prepare).";
        $messageType = "danger";
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $userEmail = $user['Email'];
            $userPassword = $user['password']; // IN CHIARO
            $userName = !empty($user['nome']) ? $user['nome'] : '';

            // Configura e invia la mail con PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'pro.turbo-smtp.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'bucignoscuola@gmail.com';
                $mail->Password   = 'Andre@2308.11';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('bucignoscuola@gmail.com', 'SoftwareEngineering'); 
                $mail->addAddress($userEmail, $userName);

                $mail->isHTML(true);
                $mail->Subject = 'Recupero password';
                $mail->Body    = getBodyEmail($userPassword);
                $mail->AltBody = 'La tua password è: ' . $userPassword;

                $mail->send();

                $message = "Ti abbiamo inviato la password via email (controlla la posta).";
                $messageType = "success";

            } catch (Exception $e) {
                $message = "Si è verificato un errore durante l'invio della mail. Riprova più tardi.";
                $messageType = "danger";
            }

        } else {
            $message = "L'email non è registrata o l'account non è attivo. Verifica se l'hai inserita correttamente, nel caso contrario chiedi ad un amministratore di registrarti.";
            $messageType = "danger";
        }

        $stmt->close();
        $connessione->close();
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftwareEngineering - Password Recovery</title>

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

        <!--Alert Bootstrap-->
        <?php if (!empty($message)) : ?>
            <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> text-center">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form class="needs-validation" method="POST" action="recupera-pass.php" novalidate>
            <div class="mb-3">
                <label for="recoveryEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="recoveryEmail" name="email" placeholder="Inserisci l'email" required>
                <div class="form-text">Ti invieremo le istruzioni per recuperare la password.</div>
                <div class="invalid-feedback">
                    Please provide a valid email address.
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block mb-4">Recupera password</button>
            </div>

            <div class="text-center">
                <p>Ricordi la password? <a href="login.php">Torna al login</a></p>
            </div>

        </form>
    </div>
</body>

<script>
    // Basic bootstrap validation
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })();

    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>

</html>
