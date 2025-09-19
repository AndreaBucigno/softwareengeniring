
  $(document).ready(function () {
    $('.tabelle').DataTable(); 
  });
  

   $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut();
        }, 5000);
    });


    
    $(document).ready(function () {
    // Inizializza DataTables
    $('.tabelle').DataTable(); 
    
    // Gestione automatica sparizione alert
    $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut();
        }, 5000);
    });

    // Gestione click sul bottone elimina file
    $('.btn-elimina-file').on('click', function() {
        // Recupera i dati dal bottone cliccato
        const fileId = $(this).data('file-id');
        const fileName = $(this).data('file-nome');
        
        // Popola il modal con i dati
        $('#eliminaFileId').val(fileId);
        $('#nomeFileModal').text(fileName);
    });
});


