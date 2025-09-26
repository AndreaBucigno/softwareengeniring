<?php
require_once 'builders/select_builders.php';

function buildHTMLBody($message, $messageType, $TABELLE_UTENTI, $TABELLA_DOMINI, $TABELLA_FILES, $TABELLA_EMAIL, $modal_edit, $modal_edit_Email, $modal_edit_Utente,$modal_edit_Dominio)
{
    $SELECT_ID = buildUserSelect();
    $SELECT_ID_DOMINIO = buildDomainSelect();

    $body = '<div class="container-fluid">
        <div class="row">
            <!-- Colonna sinistra - Form creazione utente, dominio e file -->
            <div class="col-lg-4">
                <div class="admin-container">';

    if (!empty($message)) {
        $body .= '<div class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">
                ' . $message . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    $body .= $modal_edit . $modal_edit_Email . $modal_edit_Utente . $modal_edit_Dominio;
    $ts=time();

    $body .= '<!-- Bottone toggle per utente -->
                    <div class="text-center mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formUtente" aria-expanded="false" aria-controls="formUtente" id="toggleFormButton">
                            <i class="bi bi-person-fill-add"></i>
                            Crea Nuovo Utente
                        </button>
                    </div>

                    <!-- Form utente collassabile -->
                    <div class="collapse mb-4 form-collapse" id="formUtente">
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nome e Cognome</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="numero" class="form-label">Numero di Telefono</label>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>

                                <div class="mb-3">
                                    <label for="NomeAzienda" class="form-label">Nome azienda</label>
                                    <input type="text" class="form-control" id="NomeAzienda" name="NomeAzienda" required>
                                </div>

                                <div class="mb-3">
                                    <label for="ruolo" class="form-label">Ruolo</label>
                                    <select class="form-select" name="ruolo" id="ruolo" required>
                                        <option value="" disabled selected>Seleziona tipo di utente</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Utente</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="dataRegistrazione" class="form-label">Data Registrazione</label>
                                    <input type="date" class="form-control" id="dataRegistrazione" name="dataRegistrazione" required>
                                </div>

                                <div class="mb-3">
                                    <label for="Attivo" class="form-label">Stato Attivo</label>
                                    <select class="form-select" name="Attivo" id="Attivo" required>
                                        <option value="" disabled selected>Seleziona Stato</option>
                                        <option value="true">true</option>
                                        <option value="false">false</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <input type="hidden" name="timeStamp" value="'.$ts.'">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">Crea Utente</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Form dominio -->
                    <div class="text-center mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formDominio" aria-expanded="false" aria-controls="formDominio" id="toggleFormButton2">
                            <i class="bi bi-globe"></i>
                            Crea Nuovo Dominio
                        </button>
                    </div>

                    <div class="collapse mb-4 form-collapse" id="formDominio">
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm2">
                                <div class="mb-3">
                                    <label for="id_utente" class="form-label">ID Utente</label>
                                    ' . $SELECT_ID . '
                                </div>
                                <div class="mb-3">
                                    <label for="nome_dominio" class="form-label">Nome Dominio</label>
                                    <input type="text" class="form-control" id="nome_dominio" name="nome_dominio" required> 
                                </div>

                                <div class="mb-3">
                                    <label for="scadenza" class="form-label">Data di Scadenza del Dominio</label>
                                    <input type="date" class="form-control" id="scadenza" name="scadenza" required>
                                </div>

                                <input name="timeStamp" type="hidden" value="'.$ts.'">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">Crea Dominio</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Form file -->
                    <div class="text-center mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formFile" aria-expanded="false" aria-controls="formFile" id="toggleFormButton3">
                            <i class="bi bi-file-earmark-plus"></i>
                            Aggiungi un nuovo file
                        </button>
                    </div>

                    <div class="collapse mb-4 form-collapse" id="formFile">
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm3">
                                <div class="mb-3">
                                    <label for="id_utente_file" class="form-label">ID Utente</label>
                                    ' . $SELECT_ID . '
                                </div>
                                <div class="mb-3">
                                    <label for="nome_file" class="form-label">Nome File</label>
                                    <input type="text" class="form-control" id="nome_file" name="nome_file" required> 
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload a file</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>

                                <input name="timeStamp" type="hidden" value="'.$ts.'">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">Aggiungi File</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Form email -->
                    <div class="text-center mb-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formEmail" aria-expanded="false" aria-controls="formEmail" id="toggleFormButton4">
                            <i class="bi bi-envelope"></i>
                            Collega una nuova mail.
                        </button>
                    </div>

                    <div class="collapse mb-4 form-collapse" id="formEmail">
                        <div class="card-body">
                            <form class="needs-validation" novalidate method="POST" action="admin.php" id="adminForm4">
                            <div class="mb-3">    
                            <label for="id_utente_email" class="form-label">ID Utente</label>
                                    ' . $SELECT_ID . '
                                </div>
                                
                                <div class="mb-3">
                                <label for="id_dominio_email" class="form-label">ID Dominio</label>
                                    ' . $SELECT_ID_DOMINIO . '
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email_form_email" required>
                                </div>

                                <input name="timeStamp" type="hidden" value="'.$ts.'">

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block">Aggiungi Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonna destra - Tabelle -->
            <div class="col-lg-8">
                <div class="admin-container-large">
                    <h4 class="page-title mb-4">Gestione dati</h4>
                    <hr>
                    
                    <!-- Tabella Utenti -->
                    <div class="mb-4">
                        <h5 class="mb-3">Gestione Utenti</h5>
                        <a class="btn btn-secondary mb-3" href="admin.php">
                            <i class="bi bi-x-circle"></i> Rimuovi Filtro</a>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped tabelle" id="tabella1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>EMAIL</th>
                                        <th>NOME</th>
                                        <th>RUOLO</th>
                                        <th>ATTIVO</th>
                                        <th>DATA REGISTRAZIONE</th>
                                        <th>Azioni</th>
                                        <th>Filtra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ' . $TABELLE_UTENTI . '
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Tabella Domini -->
                    <div class="mb-4">
                        <h5 class="mb-3">Gestione Domini</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped tabelle" id="tabella2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID_UTENTE</th>
                                        <th>NOME DOMINIO</th>
                                        <th>DATA CREAZIONE</th>
                                        <th>SCADENZA</td>
                                        <th>AZIONI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   ' . $TABELLA_DOMINI . '
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Tabella Files -->
                    <div class="mb-4">
                        <h5 class="mb-3">Gestione Files</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped tabelle" id="tabella3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID_UTENTE</th>
                                        <th>NOME FILE</th>
                                        <th>DATA UPLOAD</th>
                                        <th>DISPONIBILE</th>
                                        <th>AZIONI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   ' . $TABELLA_FILES . '
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Tabella Email -->
                    <div class="mb-4">
                        <h5 class="mb-3">Gestione Email</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped tabelle" id="tabella4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID_UTENTE</th>
                                        <th>ID_DOMINIO</th>
                                        <th>EMAIL</th>
                                        <th>AZIONI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   ' . $TABELLA_EMAIL . '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';

    return $body;
}
