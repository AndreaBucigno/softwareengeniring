<?php

function getDBConnection()
{
    $connessione = new mysqli("localhost", "admin_Bucigno_Consalvi", "Tommaso1234_", "admin_progettopcto_bucignoconsalvi");
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }
    return $connessione;
}
