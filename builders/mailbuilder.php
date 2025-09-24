<?php

function getBodyEmail($nome_dominio,$scadenza,$nome_destinatario){
    $body = '<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    
    <!-- Container principale -->
    <div style="max-width: 600px; margin: 0 auto; background-color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0 0 10px 0; font-size: 24px;">🔔 Promemoria Scadenza Dominio</h1>
            <p style="margin: 0; font-size: 16px;">Il tuo dominio scade il</p>
            <div style="font-size: 28px; color: #ffeb3b; font-weight: bold; margin: 10px 0;">
                <?php echo $scadenza> giorni
            </div>
        </div>

        <!-- Contenuto -->
        <div style="padding: 30px;">
            <p style="margin: 0 0 20px 0;">Ciao <strong><?php echo $nome_destinatario; ?></strong>,</p>
            
            <p style="margin: 0 0 20px 0;">Ti informiamo che il tuo dominio registrato sta per scadere.</p>
            
            <!-- Box dominio -->
            <div style="background: white; padding: 15px; border-left: 4px solid #667eea; margin: 20px 0; font-size: 18px; font-weight: bold; border: 1px solid #e0e0e0;">
                🌐 <?php echo $nome_dominio; ?>
            </div>

            <!-- Tabella informazioni -->
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;" cellpadding="8" cellspacing="0">
                <tr>
                    <td style="border-bottom: 1px solid #ddd; font-weight: bold; width: 30%;">Dominio:</td>
                    <td style="border-bottom: 1px solid #ddd;"><?php echo $nome_dominio; ?></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #ddd; font-weight: bold;">Data di scadenza:</td>
                    <td style="border-bottom: 1px solid #ddd;"><?php echo $scadenza; ?></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #ddd; font-weight: bold;">Registrante:</td>
                    <td style="border-bottom: 1px solid #ddd;"><?php echo $nome_destinatario; ?></td>
                </tr>
            </table>

            <!-- Box avviso -->
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-left: 4px solid #fdcb6e; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <strong>⚠️ Importante:</strong> Per evitare l\'interruzione del servizio e la possibile perdita del dominio, 
                ti consigliamo di rinnovare prima della data di scadenza.
            </div>

            <p style="margin: 0 0 20px 0;">Se hai già provveduto al rinnovo, ignora pure questa email.</p>

            <p style="margin: 0 0 20px 0;">Per qualsiasi domanda o assistenza, non esitare a contattarci.</p>

            <p style="margin: 0;">
                Cordiali saluti,<br>
                <strong>Il Team di <?php echo SOFTWAREENGINEERING; ?></strong>
            </p>
        </div>    
';

    return $body;
}


function getOggettoEmail(){
    $oggetto='<p>Uno dei tuoi domini è in scadenza</p>';
    return $oggetto;
}