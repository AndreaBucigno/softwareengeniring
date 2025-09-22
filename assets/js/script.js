
  $(document).ready(function () {
    $('.tabelle').DataTable(); 
  });
  

   $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut();
        }, 5000);
    });

    $(".btn-rimuovi-file").on('click', function() {
      var t=$(this);
      var id=t.data('id');
      $('#eliminaFileId').val(id);
    });

    
   $(document).ready(function() {
    $(".btn-modifica-file").on('click', function() {
        var t = $(this);
        var id = t.data('id');
        $("#modificaFileId").val(id);
        var row = t.closest('tr');
        var nomeFile = row.find('td').eq(2).text().trim();
        var disponibile = row.find('td').eq(4).text().trim();
        var idUtente = row.find('td').eq(1).text().trim(); // Aggiungi questa riga

        // Imposta i valori nel form del modal
        $("#editFileNome").val(nomeFile);
        $("#editFileDisponibile").val(disponibile);
        $("#modificaIdUtente").val(idUtente); // Aggiungi questa riga
    });
});


// Gestione modal modifica email
$(document).ready(function() {
    $(".btn-modifica-email").on('click', function() {
        var t = $(this);
        var id = t.data('id');
        $("#modificaEmailId").val(id);
        
        var row = t.closest('tr');
        var idUtente = row.find('td').eq(1).text().trim();
        var idDominio = row.find('td').eq(2).text().trim();
        var nomeEmail = row.find('td').eq(3).text().trim();

        // Imposta i valori nel form del modal
        $("#editEmailNome").val(nomeEmail);
        $("#modificaEmailIdUtente").val(idUtente);
        $("#editEmailIdDominio").val(idDominio);
        
        // Popola la select dei domini
        populateDomainSelect();
    });
});

// Funzione per popolare la select dei domini nel modal
function populateDomainSelect() {
    var selectDominio = $("#editEmailIdDominio");
    selectDominio.empty();
    selectDominio.append('<option value="" disabled selected>Seleziona ID Dominio</option>');
    
    // Scansiona la tabella domini per popolare le opzioni
    $("#tabella2 tbody tr").each(function() {
        var idDominio = $(this).find('td').eq(0).text().trim();
        var nomeDominio = $(this).find('td').eq(2).text().trim();
        selectDominio.append('<option value="' + idDominio + '">' + idDominio + ' - ' + nomeDominio + '</option>');
    });
}