
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

/*document.addEventListener("DOMContentLoaded", function() {
    const eliminaButtons = document.querySelectorAll(".elimina-file-btn");
    const modalInput = document.getElementById("eliminaFileId"); // deve corrispondere all'id dell'input hidden nel modal
    
    eliminaButtons.forEach(button => {
        button.addEventListener("click", function() {
            const fileId = this.getAttribute("data-id");
            console.log("ID file da eliminare:", fileId); // debug console
            modalInput.value = fileId;
        });
    });
});*/