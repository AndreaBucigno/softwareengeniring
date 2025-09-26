<?php
function getBodyEmail($domini_utente, $nome_destinatario) {
    // Calcola il totale dei domini
    $totale_domini = count($domini_utente);

    $body = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Promemoria Scadenze Domini</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">

    <!-- Container principale -->
    <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 10px; overflow: hidden; border: 1px solid #ddd;">

        <!-- Header -->
        <div style="background-color: #667eea; color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; font-size: 22px;">🔔 Promemoria Scadenze Domini</h1>
            <p style="margin: 0; font-size: 16px;">Hai <strong>' . $totale_domini . ' dominio/i</strong> in scadenza</p>
        </div>

        <!-- Contenuto -->
        <div style="padding: 30px;">
            <p style="margin: 0 0 20px 0;">Ciao <strong>' . htmlspecialchars($nome_destinatario) . '</strong>,</p>

            <p style="margin: 0 0 20px 0;">Ti informiamo che i seguenti domini registrati stanno per scadere:</p>';

    // TABELLA DOMINI
    $body .= '<table style="width: 100%; border-collapse: collapse; margin: 20px 0; background: white; font-size: 14px;" cellpadding="10" cellspacing="0">
                <tr style="background: #f8f9fa;">
                    <th style="border: 1px solid #ddd; text-align: left; padding: 10px;">Dominio</th>
                    <th style="border: 1px solid #ddd; text-align: left; padding: 10px;">Scadenza</th>
                    <th style="border: 1px solid #ddd; text-align: left; padding: 10px;">Giorni Rimanenti</th>
                </tr>';

    foreach ($domini_utente as $dominio) {
        $giorni_rimanenti = calcolaGiorniRimanenti($dominio['scadenza']);
        $stile_riga = $giorni_rimanenti <= 7 ? ' style="background: #fff3cd;"' : '';

        $body .= '<tr' . $stile_riga . '>
                    <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">🌐 ' . htmlspecialchars($dominio['nome_dominio']) . '</td>
                    <td style="border: 1px solid #ddd; padding: 10px;">' . htmlspecialchars($dominio['scadenza']) . '</td>
                    <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold; color: ' . ($giorni_rimanenti <= 7 ? '#e74c3c' : '#27ae60') . ';">' . $giorni_rimanenti . ' giorni</td>
                </tr>';
    }

    $body .= '</table>';

    // BOX AVVISO
    $body .= '<div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <strong>⚠️ Importante:</strong> Per evitare l\'interruzione del servizio e la possibile perdita dei domini, 
                ti consigliamo di rinnovare prima delle date di scadenza.
              </div>';

    // SE C'È ALMENO UN DOMINIO IN SCADENZA IMMINENTE
    $scadenze_imminenti = array_filter($domini_utente, function($dominio) {
        return calcolaGiorniRimanenti($dominio['scadenza']) <= 7;
    });

    if (count($scadenze_imminenti) > 0) {
        $body .= '<div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 20px 0; border-radius: 4px;">
                    <strong>🚨 Attenzione Urgente:</strong> Alcuni domini scadono entro 7 giorni! 
                    Procedi al rinnovo immediato per evitare la sospensione.
                  </div>';
    }

    $body .= '<p style="margin: 0 0 20px 0;">Se hai già provveduto al rinnovo, ignora pure questa email.</p>

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
