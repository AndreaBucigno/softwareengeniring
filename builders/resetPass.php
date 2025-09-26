<?php
function getBodyEmail($password) {
    $pass = htmlspecialchars($password); // password in chiaro, sicura per l'HTML

    $body = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Promemoria Scadenze Domini</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">

    <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 10px; overflow: hidden; border: 1px solid #ddd;">

        <div style="background-color: #667eea; color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; font-size: 22px;">🔔 RESET DELLA PASSWORD</h1>
        </div>

        <div style="padding: 30px;">
            
            <div style="background: #b90606ff; border: 1px solid #980000ff; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <strong><p style="margin: 0 0 20px 0;">Password : ' . $pass . ' </p></strong>
            </div>

            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <strong>⚠️ Importante:</strong> Non condividere la password.
            </div>

            <p style="margin: 0 0 20px 0;">Se hai già provveduto all\'accesso, ignora pure questa email.</p>

            <p style="margin: 0 0 20px 0;">Per qualsiasi domanda o assistenza, non esitare a contattarci.</p>

            <p style="margin: 0;">
                Cordiali saluti,<br>
                <strong>Il Team di SOFTWAREENGINEERING</strong>
            </p>
        </div>
    </div>
</body>
</html>';

    return $body;
}
?>
