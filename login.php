<?php
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $utenti = json_decode(file_get_contents("data/utenti.json"), true);
    if (isset($utenti[$email])) {
        if ($utenti[$email]["password"] === $password) {
            header('Location: dashboard.php');
        } else {
            $message = "Password non corretta.";
            $messageType = "danger";
        }
    } else {
        $message = "Email non trovata nel database.";
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