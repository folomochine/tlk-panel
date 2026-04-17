function generatePassword() {
    var length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}
function UserPassword() {
  $("#user_password").val(generatePassword())
}

$(document).ready(function(){

  var site_url  = $('head base').attr('href');
  var serviceActionTitles = {
    new_service: "Créer un service",
    new_subscriptions: "Créer un abonnement",
    new_category: "Créer une catégorie",
    edit_service: "Modifier le service",
    edit_service_name: "Modifier le nom du service",
    edit_description: "Modifier la description",
    edit_time: "Modifier le temps moyen",
    edit_category: "Modifier la catégorie"
  };

  function enhanceModalContent(modalSelector, titleSelector, contentSelector){
    var $modal = $(modalSelector);
    if (!$modal.length) { return; }

    var $content = $modal.find(contentSelector);
    if (!$content.length) { return; }

    var $footer = $content.find('.modal-footer');
    if ($footer.length) {
      $footer.find('button[type="submit"], .btn-primary[type="button"]').each(function(){
        var rawTxt = $.trim($(this).text());
        var txt = rawTxt.toLowerCase();
        if (txt === 'register user') { $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Créer l\'utilisateur'); }
        if (txt === 'update settings' || txt === 'update') { $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Enregistrer'); }
        if (txt === 'confirm') { $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Confirmer'); }
        if ($(this).find('i').length) { return; }
        if (txt.indexOf('save') !== -1 || txt.indexOf('update') !== -1 || txt.indexOf('apply') !== -1 || txt.indexOf('submit') !== -1) {
          $(this).prepend('<i class="fas fa-check"></i> ');
        } else if (txt.indexOf('confirm') !== -1 || txt.indexOf('yes') !== -1) {
          $(this).prepend('<i class="fas fa-check-circle"></i> ');
        }
      });

      $footer.find('[data-dismiss="modal"], .btn-default, .btn-danger').each(function(){
        var rawTxt = $.trim($(this).text());
        var txt = rawTxt.toLowerCase();
        if (txt === 'cancel' || txt === 'close') { $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Fermer'); }
        if (txt === 'no') { $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Non'); }
        if ($(this).find('i').length) { return; }
        if (txt.indexOf('cancel') !== -1 || txt.indexOf('close') !== -1 || txt.indexOf('no') !== -1) {
          $(this).prepend('<i class="fas fa-times"></i> ');
        }
      });
    }

    $content.find('.service-mode__block').addClass('tl-modal-card');

    var action = $modal.data('modal-action');
    if (action && serviceActionTitles[action]) {
      $content.find('form').addClass('tl-service-modal-form');
      $content.find('.modal-footer .btn-primary').each(function(){
        var t = $.trim($(this).text()).toLowerCase();
        if (t.indexOf('update') !== -1) {
          $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Enregistrer');
        } else if (t.indexOf('save') !== -1) {
          $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Enregistrer');
        }
      });
      $content.find('.modal-footer [data-dismiss="modal"], .modal-footer .btn-default, .modal-footer .btn-danger').each(function(){
        var t = $.trim($(this).text()).toLowerCase();
        if (t === 'cancel' || t === 'close') {
          $(this).contents().filter(function(){ return this.nodeType === 3; }).first().replaceWith(' Fermer');
        }
      });
    }
  }

  function normalizeAdminModalTitle(title){
    if (!title) { return title; }
    var t = $.trim(title);
    var lower = t.toLowerCase();
    var replacements = [
      { from: 'new user registration', to: 'Créer un utilisateur' },
      { from: 'user specific services', to: 'Services spécifiques utilisateur' },
      { from: 'order details', to: 'Détails de commande' },
      { from: 'error details', to: 'Détails des erreurs' },
      { from: 'promotion details', to: 'Détails de promotion' },
      { from: 'subscription end date', to: 'Date de fin d\'abonnement' },
      { from: 'user details', to: 'Détails utilisateur' },
      { from: 'payment details', to: 'Détails du paiement' },
      { from: 'edit', to: 'Modifier' }
    ];

    for (var i = 0; i < replacements.length; i++) {
      if (lower.indexOf(replacements[i].from) === 0) {
        t = replacements[i].to + t.substring(replacements[i].from.length);
        break;
      }
    }

    t = t.replace(/\(\s*id:/i, '(ID:');
    return t;
  }

  function decorateModalTitle(titleSelector){
    var $title = $(titleSelector);
    if (!$title.length) { return; }
    var text = normalizeAdminModalTitle($title.text());
    $title.text(text);
    $title.addClass('tl-modal-title-enhanced');
  }

  $("#serviceList").click(function(){
    $("#serviceListContent").html('<center><div class="modal-body"><svg class="spinner_2" viewBox="0 0 48 48"><circle class="path_2" cx="24" cy="24" r="20" fill="none" stroke-width="3"></circle></svg></div></center>');
    var href  = $(this).attr("data-href");
    var active= $(this).attr("data-active");
    $.post(site_url+href, {active:active }, function(data){
     $("#serviceListContent").html(data);
    });
  });

  $('#modalDiv').on('show.bs.modal', function(e) {
    var modalAction = $(e.relatedTarget).data('action');
    $(this).data('modal-action', modalAction || '');
    $("#modalContent").html('<center><div class="modal-body"><svg class="spinner_2 large" viewBox="0 0 48 48"><circle class="path_2" cx="24" cy="24" r="20" fill="none" stroke-width="3"></circle></svg></div></center>');
    $.post(site_url+'admin/ajax_data', {action:$(e.relatedTarget).data('action'),id:$(e.relatedTarget).data('id') }, function(data){
      var forcedTitle = serviceActionTitles[modalAction] ? serviceActionTitles[modalAction] : normalizeAdminModalTitle(data.title);
      $("#modalTitle").text(forcedTitle);
    $("#modalContent").html(data.content);
      $(".datetime").datepicker({
         format: "dd/mm/yyyy",
          language: "fr",
         startDate: new Date(),
       }).on('change', function(ev){
         $(".datetime").datepicker('hide');
       });
    },'json');
  });
  $('#modalDiv').on('shown.bs.modal', function() {
    decorateModalTitle('#modalTitle');
    enhanceModalContent('#modalDiv', '#modalTitle', '#modalContent');
  });
  $('#modalDiv').on('hidden.bs.modal', function () {
    $(this).removeData('modal-action');
    $("#modalTitle").html('');
    $("#modalContent").html('');
  });

  $('#subsDiv').on('show.bs.modal', function(e) {
    $.post(site_url+'admin/ajax_data', {action:$(e.relatedTarget).data('action'),id:$(e.relatedTarget).data('id') }, function(data){
      $("#subsTitle").text(normalizeAdminModalTitle(data.title));
      $("#subsContent").html(data.content);
      $(".datetime").datepicker({
         format: "dd/mm/yyyy",
          language: "fr",
         startDate: new Date(),
       }).on('change', function(ev){
         $(".datetime").datepicker('hide');
       });
    },'json');
  });
  $('#subsDiv').on('shown.bs.modal', function() {
    decorateModalTitle('#subsTitle');
    enhanceModalContent('#subsDiv', '#subsTitle', '#subsContent');
  });

  $(document).on('shown.bs.modal', '.modal', function() {
    var $title = $(this).find('.modal-title').first();
    if ($title.length) {
      $title.text(normalizeAdminModalTitle($title.text()));
      $title.addClass('tl-modal-title-enhanced');
    }
    var $footer = $(this).find('.modal-footer').first();
    if ($footer.length) {
      $footer.find('.btn').addClass('tl-modal-action-btn');
    }
  });

  $('[id^="delete_rate_button-"]').click(function(){
    var id = $(this).attr("data-service");
    $("#rate-"+id).val("");
    $('#delete_rate_button-'+id).css("visibility","hidden");
  });

  $('[id^="delete_rate_button-"]').each(function() {
      var id    = $(this).attr("data-service");
      var price = $('#rate-'+id).val().length;
        if( price > 0 ){
          $("#delete_rate_button-"+id).css("visibility","visible");
        }
  });

  $('[id^="rate-"]').on('keyup', function(){
    var id    = $(this).attr("data-service");
    var price = $('#rate-'+id).val().length;
      if( price > 0 ){
        $("#delete_rate_button-"+id).css("visibility","visible");
      }else{
        $("#delete_rate_button-"+id).css("visibility","hidden");
      }
  });

  $('[id^="collapedAdd-"]').click(function(){
    var id = $(this).attr("data-category");
    if( $(this).attr("class") == "service-block__collapse-button" ){
      $(".Service"+id).hide();
      $(this).addClass(" collapsed");
    }else{
      $(".Service"+id).show();
      $(this).removeClass(" collapsed");
    }
  });

  $('#allServices').click(function(){
    if( $(this).attr("class") == "service-block__hide-all fa fa-compress" ){
      $('#allServices').removeClass("fa fa-compress");
      $('#allServices').addClass("fa fa-expand");
      $('[class^="Servicecategory-"]').each(function(){
        $(this).hide();
      });
      $('[id^="collapedAdd-"]').each(function(){
        $(this).addClass(" collapsed");
      });
    }else{
      $('#allServices').removeClass("fa fa-expand");
      $('#allServices').addClass("fa fa-compress");
      $('[class^="Servicecategory-"]').each(function(){
        $(this).show();
      });
      $('[id^="collapedAdd-"]').each(function(){
        $(this).removeClass(" collapsed");
      });
    }
  });

  $("#priceSearch").on('keyup',function(){
    var search = $(this).val();
    var filter = search.toUpperCase();
    var i = 0;
    $('[id^="servicepriceList-"]').each(function() {
      i++;
      var name = String($(this).attr("data-name") || "");
      if (name.toUpperCase().indexOf(filter) > -1) {
          $(this).show();
      } else {
          $(this).hide();
      }
    });
  });

  $("#priceService").on('keyup',function(){
    var search = $(this).val();
    var filter = search.toUpperCase();
    var i = 0;
    $('[data-id^="service-"]').each(function() {
      var name      = String($(this).attr("data-service") || "");
      var category  = $(this).attr("data-category");
      if (name.toUpperCase().indexOf(filter) > -1) {
          $(this).show();
          $(this).attr("id","serviceshow"+category);
      } else {
          $(this).hide();
          $(this).attr("id","servicehide");
      }

    });
      $('[id^="Servicecategory-"]').each(function() {
        var id       = $(this).attr("data-id");
        var rowCount = $('#servicesTableList > tbody > tr#serviceshow'+id).length;
          if (rowCount == 0) {
            $("#"+id).hide();
          }else{
            $("#"+id).show();
          }
      });
  });
  $(".tiny-toggle").tinyToggle({
    onCheck: function() {
      var id     = $(this).attr("data-id");
      var action = $(this).attr("data-url")+"?type=on&id="+id;
        $.ajax({
        url:  action,
        type: 'GET',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
        }).done(function(result){
          if( result == 1 ){
            $('[data-toggle="'+id+'"]').removeClass("grey");
          }else{
            $.toast({
                heading: "Échec",
                text: "Échec de l'opération",
                icon: "error",
                loader: true,
                loaderBg: "#9EC600"
            });
          }
        })
        .fail(function(){
          $.toast({
              heading: "Échec",
              text: "Échec de l'opération",
              icon: "error",
              loader: true,
              loaderBg: "#9EC600"
          });
        });
    },
    onUncheck: function() {
      var id     = $(this).attr("data-id");
      var action = $(this).attr("data-url")+"?type=off&id="+id;
        $.ajax({
        url:  action,
        type: 'GET',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false
        }).done(function(result){
          if( result == 1 ){
            $('[data-toggle="'+id+'"]').addClass("grey");
          }else{
            $.toast({
                heading: "Échec",
                text: "Échec de l'opération",
                icon: "error",
                loader: true,
                loaderBg: "#9EC600"
            });
          }
        })
        .fail(function(){
          $.toast({
              heading: "Échec",
              text: "Échec de l'opération",
              icon: "error",
              loader: true,
              loaderBg: "#9EC600"
          });
        });
    },
  });

  $("#provider").change(function(){
    var provider = $(this).val();
    getProviderServices(provider,site_url);
  });

  getProvider();
  $("#serviceMode").change(function(){
    getProvider();
  });

  getSalePrice();
  $("#saleprice_cal").change(function(){
    getSalePrice();
  });

  getSubscription();
  $("#subscription_package").change(function(){
    getSubscription();
  });

  $('#confirmChange').on('show.bs.modal', function(e) {
      $(this).find('#confirmYes').attr('href', $(e.relatedTarget).data('href'));
      if (!$(this).find('#confirmYes i').length) {
        $(this).find('#confirmYes').prepend('<i class="fas fa-check-circle"></i> ');
      }
      $(this).find('[data-dismiss="modal"]').each(function(){
        if (!$(this).find('i').length) {
          $(this).prepend('<i class="fas fa-times"></i> ');
        }
      });
  });
  $('#confirmYes').click(function(){
      if( $(this).attr("href") == null ){
        $("#changebulkForm").submit();
        return false;
      }
  });
  $('.bulkorder').click(function (){
     var status = $(this).attr("data-type");
      $("#bulkStatus").val(status);
      $("#confirmYes").removeAttr('href');
      $("#confirmChange").modal('show');
  });

  function toggleBulkActionState(){
    var count = $('.selectOrder').filter(':checked').length;
    $('.countOrders').html(count);
    if( count > 0 ){
      $('.checkAll-th').addClass("show-action-menu");
      $('.action-block').show();
    }else{
      $('.checkAll-th').removeClass("show-action-menu");
      $('.action-block').hide();
    }
  }
  $("#checkAll").click(function () {
   if ( $(this).prop('checked') == true ) {
     $('.selectOrder').not(this).prop('checked', true);
   }else{
     $('.selectOrder').not(this).prop('checked', false);
   }
   toggleBulkActionState();
 });
 $(".selectOrder").click(function () {
    toggleBulkActionState();
 });
 toggleBulkActionState();


});

function getProviderServices(provider,site_url){
  if( provider == 0 ){
    $("#provider_service").hide();
  }else{
    $.post(site_url+'admin/ajax_data',{action:'providers_list',provider:provider}).done(function( data ) {
      $("#provider_service").show();
      $("#provider_service").html(data);
    }).fail(function(){
      alert("Une erreur est survenue !");
    });
  }
}

function getProvider(){
  var mode = $("#serviceMode").val();
    if( mode == 1 ){
      $("#autoMode").hide();
    }else{
      $("#autoMode").show();
    }
}

function getSalePrice(){
  var type = $("#saleprice_cal").val();
    if( type == "normal" ){
      $("#saleprice").hide();
      $("#servicePrice").show();
    }else{
      $("#saleprice").show();
      $("#servicePrice").hide();
    }
}

function getSubscription(){
  var type = $("#subscription_package").val();
    if( type == "11" || type == "12" ){
      $("#unlimited").show();
      $("#limited").hide();
    }else{
      $("#unlimited").hide();
      $("#limited").show();
    }
}
