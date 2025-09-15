<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
} else {
  // L'utente è loggato, puoi accedere alla pagina quindi prenderà le infromazioni dal file json e compilerà le tabelle
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SoftwareEngeniring - User Page</title>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
  <div class="container">
    <nav class="navbar fixed-top">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="login.php">
          <img src="assets/images/logo_softwarengineering_blubordobianco.png" alt="Logo" class="Logo">
        </a>
      </div>
    </nav>

    <script src="assets/js/script.js"></script>

    <div class="container-T1">
      <table class="tabelle" id="miaTabella" class="display">
        <thead>
          <tr>
            <th>DOMINIO</th>
            <th>DATA REGISTRAZIONE</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>G.COM</td>
            <td>15/02/2023</td>
          </tr>
          <tr>
            <td>C.COM</td>
            <td>05/03/2024</td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr>

    <table class="tabelle" id="miaTabella2" class="display">
      <thead>
        <tr>
          <th>Nome file</th>
          <th>Azioni</th>
          <th>Data upload</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>manuale.pdf</td>
          <td>
            <button class="btn btn-primary">
              <i class="bi bi-download"></i> Download
            </button>
          </td>
          <td>08/09/2025</td>
        </tr>
      </tbody>
    </table>

  </div>
</body>

</html>