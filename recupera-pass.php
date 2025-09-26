<?php
session_start();
require_once 'config/database.php';
require_once 'builders/resetPass.php'; // se contiene getBodyEmail()

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'assets/lib/vendor/autoload.php';

$message = "";
$messageType = "";

/**
 * Genera una password sicura casuale
 */
function generateRandomPassword($length = 12) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%&*()?'; 
    $max = strlen($chars) - 1;
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }
    return $password;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Inserisci un'email valida.";
        $messageType = "danger";
    } else {
        $connessione = getDBConnection();

        $sql = "SELECT id, Email, nome FROM utenti WHERE Email = ? AND attivo = 'true' LIMIT 1";
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
                $userName = !empty($user['nome']) ? $user['nome'] : '';

                // Genera nuova password
                $newPass = generateRandomPassword(12);
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);

                // Aggiorna la password nel DB
                $updateStmt = $connessione->prepare("UPDATE utenti SET password = ? WHERE id = ? LIMIT 1");
                if ($updateStmt === false) {
                    $message = "Errore interno (prepare update).";
                    $messageType = "danger";
                } else {
                    $updateStmt->bind_param("si", $newHash, $user['id']);
                    if ($updateStmt->execute()) {
                        // Invia la nuova password via email
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
                            $mail->Body    = getBodyEmail($newPass);
                            $mail->AltBody = 'La tua nuova password è: ' . $newPass;

                            $mail->send();
                            $message = "Ti abbiamo inviato la nuova password via email. Controlla la tua casella di posta.";
                            $messageType = "success";

                        } catch (Exception $e) {
                            $message = "Errore durante l'invio della mail. Riprova più tardi.";
                            $messageType = "danger";
                        }

                    } else {
                        $message = "Errore durante l'aggiornamento della password.";
                        $messageType = "danger";
                    }
                    $updateStmt->close();
                }

            } else {
                $message = "L'email non è registrata o l'account non è attivo.";
                $messageType = "danger";
            }

            $stmt->close();
            $connessione->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoftwareEngineering - Password Recovery</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<div class="container login-container mt-3">
    <div class="text-center mb-4">
        <img src="assets/images/logo_softwarengineering_blubordobianco.png" alt="Logo" class="Logo">
    </div>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?> text-center">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form class="needs-validation" method="POST" action="recupera-pass.php" >
        <div class="mb-3">
            <label for="recoveryEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="recoveryEmail" name="email" placeholder="Inserisci l'email" required>
            <div class="form-text">Ti invieremo la nuova password generata.</div>
            <div class="invalid-feedback">
                Inserisci un indirizzo email valido.
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

<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms).forEach(function (form) {
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
</body>
</html>