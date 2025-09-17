<?php

session_start();

// Distruggo tutte le variabili di sessione
$_SESSION = array();

// Distruggo la sessione

session_destroy();

// Reindirizzo alla pagina di login
header("Location: login.php");
exit();