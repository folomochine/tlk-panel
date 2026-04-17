$(document).ready(function(){

  var site_url  = $('head base').attr('href');

  $(document).on('submit', 'form[data-xhr]', function(event){
      event.preventDefault();
      var action    = $(this).attr('action');
      var method    = $(this).attr('method');
      var formData  = new FormData($(this)[0]);
        $.ajax({
          url:  action,
          type: method,
          dataType: 'json',
          data: formData,
          cache: false,
          contentType: false,
          processData: false
        })
        .done(function(result){
              /* İşlem Success, dönen sonucu ekrana bastır */
                if( result.s == "error" ){
                  var heading = "Échec";
                }else{
                  var heading = "Succès";
                }
          $.toast({
              heading: heading,
              text: result.m,
              icon: result.s,
              loader: true,
              loaderBg: "#9EC600"
          });
          if (result.r!=null) {
            if( result.time ==null ){ result.time = 3; }
              /* Yönlendirilecek adres boş değil ise yönlendir */
            setTimeout(function(){
              window.location.href  = result.r;
            },result.time*1000);
          }

        })
        .fail(function(){
             /* Ajax işlemi Failed, hata bas */
             $.toast({
                 heading: "Une erreur est survenue !",
                 text: "La requête n'a pas pu être exécutée...",
                 icon: 'error',
                 loader: true,
                 loaderBg: "#9EC600"
             });
        })
  });


  $("#delete-row").click(function(){
    var action = $(this).attr("data-url");
    swal({
      title: "Êtes-vous sûr de vouloir supprimer ?",
      text: "Si vous confirmez, ce contenu sera supprimé, il sera peut-être impossible de le restaurer.",
      icon: "warning",
      buttons: true,
      dangerMode: true,
      buttons: ["Annuler", "Oui, je suis sur !"],
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url:  action,
          type: "GET",
          dataType: "json",
          cache: false,
          contentType: false,
          processData: false
        })
        .done(function(result){
          if( result.s == "error" ){
            var heading = "Échec";
          }else{
            var heading = "Succès";
          }
            $.toast({
                heading: heading,
                text: result.m,
                icon: result.s,
                loader: true,
                loaderBg: "#9EC600"
            });
            if (result.r!=null) {
              if( result.time ==null ){ result.time = 3; }
              setTimeout(function(){
                window.location.href  = result.r;
              },result.time*1000);
            }
        })
        .fail(function(){
          $.toast({
              heading: "Échec",
              text: "La requête n'a pas pu être satisfaite...",
              icon: "error",
              loader: true,
              loaderBg: "#9EC600"
          });
        });
        /* İçerik silinmesi onaylandı */
      } else {
          $.toast({
              heading: "Échec",
              text: "Demande de suppression refusée...",
            icon: "error",
            loader: true,
            loaderBg: "#9EC600"
        });
      }
    });
  });


});
