<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] !== "user") {
    header("Location: login.php");
    exit();
}

$title = "User Page";

$body = '
<div class="container">
    <br><br><br>
    <div class="container-T1">
        <table class="tabelle" id="miaTabella">
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
    <div class="container-T2">
        <table class="tabelle" id="miaTabella2">
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
</div>
';

$template = file_get_contents('inc/template.inc.php');
$template = str_replace('{{title}}', $title, $template);
$template = str_replace('{{body}}', $body, $template);
echo $template;
?>