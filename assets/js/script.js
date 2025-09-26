$(document).ready(function () {
    $('.tabelle').DataTable(); 
});

$('.alert').each(function() {
    const alert = $(this);
    setTimeout(function() {
        alert.fadeOut();
    }, 5000);
});

// Gestione eliminazione file
$(".btn-rimuovi-file").on('click', function() {
    var t = $(this);
    var id = t.data('id');
    $('#eliminaFileId').val(id);
});

// Gestione modifica file
$(".btn-modifica-file").on('click', function() {
    var button = $(this);
    var id = button.data('id');
    
    $('#modificaFileId').val(id);
});

// Gestione modifica email
$(".btn-modifica-email").on('click', function() {
    var button = $(this);
    var id = button.data('id');
    
    $('#modificaEmailId').val(id);
});

// Gestione modifica utente
$(".btn-modifica-utente").on('click', function() {
    var button = $(this);
    
    $('#modificaUtenteId').val(button.data('id'));
    $('#editUtenteEmail').val(button.data('email'));
    $('#editUtenteNome').val(button.data('nome'));
    $('#editUtenteNumero').val(button.data('numero'));
    $('#editUtenteAzienda').val(button.data('azienda'));
    $('#editUtenteRuolo').val(button.data('ruolo'));
    $('#editUtenteAttivo').val(button.data('attivo'));
    $('#editUtenteDataRegistrazione').val(button.data('data'));
});

// Gestione modifica dominio (AGGIORNATO)
$(".btn-modifica-dominio").on('click', function() {
    var button = $(this);
    
    $('#modificaDominioId').val(button.data('id'));
    $('#editDominioIdUtente').val(button.data('id-utente')); // Hidden field
    $('#editDominioNome').val(button.data('nome-dominio'));
    $('#editDominioScadenza').val(button.data('scadenza'));
});

// Funzione per popolare il select domini nel modal email
function populateDomainSelectInEmailModal() {
    const mainDomainSelect = document.getElementById('id_dominio');
    const modalDomainSelect = document.getElementById('editEmailIdDominio');
    
    if (mainDomainSelect && modalDomainSelect) {
        modalDomainSelect.innerHTML = mainDomainSelect.innerHTML;
        const firstOption = modalDomainSelect.querySelector('option[disabled]');
        if (firstOption) {
            firstOption.textContent = 'Seleziona ID Dominio';
        }
    }
}

// Event listeners per quando le modal vengono mostrate
$(document).ready(function() {
    // Solo per il modal email (il modal dominio non ne ha più bisogno)
    $('#editEmailModal').on('show.bs.modal', function() {
        populateDomainSelectInEmailModal();
    });
});

// Validazione form Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();