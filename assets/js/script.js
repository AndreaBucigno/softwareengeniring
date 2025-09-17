
  $(document).ready(function () {
    $('.tabelle').DataTable(); 
  });
  

   $('.alert').each(function() {
        const alert = $(this);
        setTimeout(function() {
            alert.fadeOut();
        }, 5000);
    });