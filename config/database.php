<?php

function getDBConnection()
{
    $connessione = new mysqli("localhost", "root", "", "progettopcto_bucignoconsalvi");
    if ($connessione->connect_error) {
        die("Connessione fallita: " . $connessione->connect_error);
    }
    return $connessione;
}
