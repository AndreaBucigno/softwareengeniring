<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SoftwareEngeniring - {{title}}</title>
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  
  <!-- Il tuo CSS personalizzato (DEVE essere dopo gli altri per sovrascriverli) -->
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
 
<nav class="navbar fixed-top bg-dark">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <img src="assets/images/logo_softwarengineering_blubordobianco.png" alt="Logo" class="Logo">
    <div class="text-end">
      <a href="logout.php" class="btn btn-danger">
        <i class="bi bi-box-arrow-left"></i>
        Logout
      </a>
    </div>
  </div>
</nav>

{{body}}

<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Il tuo script personalizzato -->
<script src="assets/js/script.js"></script>

</body>
</html>