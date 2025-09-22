
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

