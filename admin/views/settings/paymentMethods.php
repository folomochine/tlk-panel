<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
<script src="https://unpkg.com/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
.pm-page{
  display:flex;
  flex-direction:column;
  gap:18px;
}
.pm-topbar{
  display:flex;
  align-items:center;
  gap:12px;
  padding:12px 16px;
  background:var(--card);
  border:1px solid var(--border);
  border-radius:14px;
}
.pm-topbar i{
  color:var(--muted);
  font-size:14px;
}
.pm-topbar input{
  flex:1;
  border:none;
  outline:none;
  background:transparent;
  color:var(--text);
  font-size:13px;
}
.pm-topbar input::placeholder{color:var(--dim);}
.pm-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(270px,1fr));
  gap:14px;
}
.pm-card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:18px;
  padding:18px;
  display:flex;
  flex-direction:column;
  gap:12px;
  box-shadow:0 4px 14px rgba(15,23,42,.06);
  transition:.2s;
}
.pm-card:hover{
  box-shadow:0 8px 24px rgba(15,23,42,.1);
}
.pm-card-top{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:10px;
}
.pm-logo{
  max-height:30px;
  max-width:110px;
  object-fit:contain;
}
.pm-toggle{
  position:relative;
  width:40px;
  height:22px;
  border-radius:999px;
  border:none;
  cursor:pointer;
  flex-shrink:0;
  transition:background .2s;
}
.pm-toggle::after{
  content:'';
  position:absolute;
  top:3px;
  width:16px;
  height:16px;
  border-radius:50%;
  background:#fff;
  transition:left .2s;
}
.pm-toggle.is-on{background:#22c55e;}
.pm-toggle.is-on::after{left:21px;}
.pm-toggle.is-off{background:#cbd5e1;}
.pm-toggle.is-off::after{left:3px;}
body.dark-mode .pm-toggle.is-off{background:#334155;}
.pm-name{
  color:var(--text);
  font-size:14px;
  font-weight:700;
  line-height:1.3;
}
.pm-range{
  display:flex;
  gap:8px;
}
.pm-range-pill{
  padding:4px 10px;
  border-radius:8px;
  font-size:11px;
  font-weight:700;
}
.pm-range-min{background:rgba(22,163,74,.1);color:#16a34a;}
.pm-range-max{background:rgba(220,38,38,.1);color:#dc2626;}
.pm-card-foot{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding-top:12px;
  border-top:1px solid var(--border);
  gap:10px;
}
.pm-drag{
  cursor:grab;
  color:var(--dim);
  font-size:15px;
  padding:4px 6px;
  border-radius:6px;
  transition:.2s;
}
.pm-drag:hover{color:var(--primary);}
.pm-drag:active{cursor:grabbing;}
.pm-edit-btn{
  display:inline-flex;
  align-items:center;
  gap:6px;
  padding:7px 14px;
  background:var(--primary);
  color:#fff;
  border:1px solid var(--primary);
  border-radius:10px;
  font-size:12px;
  font-weight:700;
  cursor:pointer;
  transition:.2s;
  outline:none;
  position:relative;
  z-index:2;
  pointer-events:auto;
}
.pm-edit-btn:hover{
  background:var(--hover);
  border-color:var(--hover);
  color:#fff;
}
.pm-loader{
  display:flex;
  align-items:center;
  gap:10px;
  color:var(--muted);
  font-size:13px;
  padding:32px 0;
}
.pm-spinner{
  width:22px;
  height:22px;
  border:2px solid var(--border);
  border-top-color:var(--primary);
  border-radius:50%;
  animation:pmspin .7s linear infinite;
}
@keyframes pmspin{to{transform:rotate(360deg);}}
.ql-toolbar.ql-snow{border-color:var(--border)!important;border-radius:8px 8px 0 0!important;}
.ql-container.ql-snow{border-color:var(--border)!important;border-radius:0 0 8px 8px!important;font-size:13px!important;}
body.dark-mode .ql-toolbar.ql-snow,
body.dark-mode .ql-container.ql-snow{border-color:var(--border)!important;}
body.dark-mode .ql-snow .ql-stroke{stroke:#a0aec0;}
body.dark-mode .ql-editor{color:var(--text);background:var(--card);}
.pm-form-footer{
  display:flex;
  justify-content:flex-end;
  gap:8px;
  margin-top:18px;
  padding-top:14px;
  border-top:1px solid var(--border);
}

/* ===== Payment method edit modal ===== */
#modalDiv .modal-dialog { width: 640px; max-width: 94%; }
.pm-modal-form .modal-body {
  padding: 18px 20px !important;
  max-height: 72vh;
  overflow-y: auto;
  background: var(--card) !important;
  color: var(--text) !important;
}
.pm-modal-form .pm-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px 16px;
}
.pm-modal-form .pm-row .pm-full { grid-column: 1 / -1; }
.pm-modal-form .form-group { margin-bottom: 14px !important; }
.pm-modal-form .form-group:last-child { margin-bottom: 0 !important; }
.pm-modal-form .control-label {
  display: block !important;
  margin-bottom: 6px !important;
  font-size: 12px !important;
  font-weight: 700 !important;
  color: var(--muted) !important;
  text-transform: uppercase;
  letter-spacing: .04em;
}
.pm-modal-form .form-control {
  width: 100%;
  height: 40px;
  padding: 8px 12px !important;
  font-size: 14px !important;
  color: var(--text) !important;
  background: var(--card) !important;
  border: 1px solid var(--border) !important;
  border-radius: 10px !important;
  outline: none;
  transition: border-color .15s ease, box-shadow .15s ease;
  box-shadow: none !important;
}
body.dark-mode .pm-modal-form .form-control {
  background: rgba(15,23,42,.55) !important;
  color: #E5E7EB !important;
  border-color: rgba(148,163,184,.25) !important;
}
.pm-modal-form textarea.form-control { height: auto; min-height: 80px; }
.pm-modal-form select.form-control { height: 40px; appearance: none; }
.pm-modal-form .form-control:focus {
  border-color: #6366F1 !important;
  box-shadow: 0 0 0 3px rgba(99,102,241,.18) !important;
}
.pm-modal-form .input-group {
  display: flex !important;
  align-items: stretch;
  width: 100%;
}
.pm-modal-form .input-group .form-control {
  border-top-right-radius: 0 !important;
  border-bottom-right-radius: 0 !important;
}
.pm-modal-form .input-group-addon {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  padding: 0 12px !important;
  min-width: 44px;
  border: 1px solid var(--border) !important;
  border-left: 0 !important;
  border-radius: 0 10px 10px 0 !important;
  background: rgba(99,102,241,.10) !important;
  color: #4f46e5 !important;
  font-weight: 800;
}
body.dark-mode .pm-modal-form .input-group-addon {
  background: rgba(99,102,241,.15) !important;
  color: #a5b4fc !important;
  border-color: rgba(148,163,184,.25) !important;
}
.pm-modal-form .extraContents {
  min-height: 120px;
  max-height: 240px;
  overflow-y: auto;
  padding: 10px 12px;
  background: var(--card) !important;
  color: var(--text) !important;
  border: 1px solid var(--border);
  border-radius: 10px;
}
body.dark-mode .pm-modal-form .extraContents {
  background: rgba(15,23,42,.55) !important;
  color: #E5E7EB !important;
}
.pm-modal-form .pm-section {
  margin: 6px 0 12px;
  padding: 10px 12px;
  background: rgba(99,102,241,.10);
  border: 1px solid rgba(99,102,241,.22);
  border-radius: 10px;
  font-size: 12px;
  font-weight: 800;
  color: #4338ca;
  letter-spacing: .04em;
  text-transform: uppercase;
}
body.dark-mode .pm-modal-form .pm-section {
  color: #a5b4fc;
  background: rgba(99,102,241,.18);
  border-color: rgba(99,102,241,.30);
}
.pm-modal-form .modal-footer {
  padding: 14px 20px !important;
  background: var(--card) !important;
  border-top: 1px solid var(--border) !important;
  display: flex !important;
  justify-content: flex-end;
  gap: 10px;
}
.pm-modal-form .modal-footer .btn {
  min-height: 38px;
  padding: 8px 16px !important;
  border-radius: 10px !important;
  font-weight: 700 !important;
}
.pm-modal-form .modal-footer .btn-primary {
  background: linear-gradient(135deg,#6366F1,#3B82F6) !important;
  border-color: transparent !important;
  color: #fff !important;
  box-shadow: 0 10px 22px rgba(99,102,241,.28) !important;
}
.pm-modal-form .modal-footer .btn-default {
  background: var(--card) !important;
  border: 1px solid var(--border) !important;
  color: var(--text) !important;
}

/* ===== Self-managed modal (no Bootstrap dependency) ===== */
.pm-overlay {
  position: fixed; inset: 0; z-index: 10000;
  background: rgba(15,23,42,.55);
  display: none;
  align-items: flex-start;
  justify-content: center;
  padding: 40px 16px;
  overflow-y: auto;
  backdrop-filter: blur(3px);
}
.pm-overlay.open { display: flex; }
.pm-dialog {
  width: 640px;
  max-width: 100%;
  background: var(--card);
  color: var(--text);
  border: 1px solid var(--border);
  border-radius: 14px;
  box-shadow: 0 24px 56px rgba(0,0,0,.45);
  overflow: hidden;
  animation: pmPop .2s ease-out;
}
@keyframes pmPop { from { transform: scale(.96); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.pm-dlg-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 18px;
  border-bottom: 1px solid var(--border);
  background: var(--card);
}
.pm-dlg-head h3 {
  margin: 0; font-size: 16px; font-weight: 800; color: var(--text);
  display: inline-flex; align-items: center; gap: 8px;
}
.pm-dlg-head h3::before {
  content: ""; width: 8px; height: 8px; border-radius: 2px;
  background: #6366F1;
  box-shadow: 0 0 0 4px rgba(99,102,241,.18);
}
.pm-dlg-close {
  background: transparent; border: 0; color: var(--text);
  font-size: 22px; line-height: 1; cursor: pointer; opacity: .7;
}
.pm-dlg-close:hover { opacity: 1; }
@media (max-width: 640px) {
  .pm-modal-form .pm-row { grid-template-columns: 1fr; }
}
</style>

<!-- Self-managed modal for editing payment methods -->
<div class="pm-overlay" id="pm-overlay">
  <div class="pm-dialog">
    <div class="pm-dlg-head">
      <h3>Modifier la méthode de paiement</h3>
      <button type="button" class="pm-dlg-close" id="pm-dlg-close" aria-label="Fermer">&times;</button>
    </div>
    <div id="pm-dlg-body"></div>
  </div>
</div>

<div class="pm-page">
  <div class="pm-topbar">
    <i class="fas fa-search"></i>
    <input type="text" id="pm-search" placeholder="Rechercher une méthode de paiement...">
  </div>

  <div id="pm-loader" class="pm-loader">
    <div class="pm-spinner"></div> Chargement des méthodes de paiement...
  </div>

  <div class="pm-grid" id="pm-grid" style="display:none;"></div>
</div>

<script>
$(document).ready(function() {
  var pmSequence = [];
  var pmQuill    = null;

  function loadMethods() {
    $.ajax({
      url : 'admin/settings/paymentMethods?action=getData',
      type: 'GET',
      success: function(data) {
        $('#pm-loader').hide();
        var html = '';
        for (var i = 0; i < data.length; i++) {
          var m = data[i];
          var on = m.status == 1;
          html += '<div class="pm-card" data-method-id="' + m.id + '">';
          html += '  <div class="pm-card-top">';
          html += '    <img class="pm-logo" src="' + m.logo + '" alt="' + m.name + '">';
          html += '    <button class="pm-toggle method-status ' + (on ? 'is-on' : 'is-off') + '"'
                + '      title="' + (on ? 'Désactiver' : 'Activer') + '"'
                + '      data-method-id="' + m.id + '"></button>';
          html += '  </div>';
          html += '  <div class="pm-name">' + m.name + '</div>';
          html += '  <div class="pm-range">';
          html += '    <span class="pm-range-pill pm-range-min">Min : ' + m.min + '</span>';
          html += '    <span class="pm-range-pill pm-range-max">Max : ' + m.max + '</span>';
          html += '  </div>';
          html += '  <div class="pm-card-foot">';
          html += '    <span class="pm-drag method-sort-handle"><i class="fas fa-grip-vertical"></i></span>';
          html += '    <button class="pm-edit-btn" type="button" data-method-id="' + m.id + '">'
                + '      <i class="fas fa-pencil-alt"></i> Modifier'
                + '    </button>';
          html += '  </div>';
          html += '</div>';
        }
        $('#pm-grid').html(html).show();
        pmSequence = data.map(function(m){ return '' + m.id; });

        if (typeof Sortable !== 'undefined') {
          Sortable.create(document.getElementById('pm-grid'), {
            handle   : '.method-sort-handle',
            animation: 150,
            onEnd    : function() {
              var updated = [];
              $('#pm-grid .pm-card').each(function(){
                updated.push('' + $(this).data('method-id'));
              });
              $.ajax({
                url : 'admin/settings/paymentMethods/sort',
                data: 'sortData=' + window.btoa(JSON.stringify(updated)),
                type: 'POST'
              });
              pmSequence = updated;
            }
          });
        }
      }
    });
  }

  loadMethods();

  $(document).on('click', '.pm-toggle', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var el = $(this);
    var id = el.data('method-id');
    var on = el.hasClass('is-on');
    $.ajax({
      url : 'admin/settings/paymentMethods/' + (on ? 'deactivate' : 'activate'),
      data: 'methodId=' + id,
      type: 'POST',
      success: function() {
        el.toggleClass('is-on is-off');
        el.attr('title', on ? 'Activer' : 'Désactiver');
      }
    });
  });

  $(document).on('keyup', '#pm-search', function() {
    var q = $(this).val().toLowerCase();
    $('#pm-grid .pm-card').each(function() {
      $(this).toggle($(this).find('.pm-name').text().toLowerCase().indexOf(q) >= 0);
    });
  });

  function pmOpenModal()  { $('#pm-overlay').addClass('open'); document.body.style.overflow='hidden'; }
  function pmCloseModal() { $('#pm-overlay').removeClass('open'); document.body.style.overflow=''; $('#pm-dlg-body').empty(); pmQuill = null; }

  $(document).on('click', '#pm-dlg-close, [data-pm-close]', pmCloseModal);
  $(document).on('click', '#pm-overlay', function(e){ if (e.target === this) pmCloseModal(); });

  $(document).on('click', '.pm-edit-btn', function(e){
    e.preventDefault();
    e.stopPropagation();
    var btn = $(this);
    var id  = btn.data('method-id');
    if (!id) return;

    pmQuill = null;
    $('#pm-dlg-body').html('<div style="padding:40px;text-align:center;color:var(--muted);"><i class="fa fa-spinner fa-spin"></i> Chargement...</div>');
    pmOpenModal();

    $.ajax({
      url : 'admin/settings/paymentMethods/getForm',
      data: 'methodId=' + id,
      type: 'POST',
      success: function(raw) {
        var resp = (typeof raw === 'object') ? raw : null;
        if (!resp) {
          try { resp = JSON.parse(raw); } catch(e) { resp = null; }
        }
        if (!resp || !resp.content) {
          $('#pm-dlg-body').html('<div style="padding:24px;color:#b91c1c;">Réponse vide du serveur.</div>');
          return;
        }

        var wrapped =
          '<form method="POST" action="admin/settings/paymentMethods/edit" class="pm-modal-form" id="pm-edit-form">' +
            '<div class="modal-body">' + resp.content + '</div>' +
            '<div class="modal-footer">' +
              '<button type="button" class="btn btn-default" data-pm-close>Annuler</button>' +
              '<button type="submit" class="btn btn-primary" data-loading-text="Enregistrement...">' +
                '<i class="fa fa-check" style="margin-right:6px;"></i>Enregistrer' +
              '</button>' +
            '</div>' +
          '</form>';

        $('#pm-dlg-body').html(wrapped);

        if (typeof Quill !== 'undefined' && $('#pm-dlg-body #editor').length) {
          setTimeout(function() {
            try {
              pmQuill = new Quill('#pm-dlg-body #editor', {
                theme  : 'snow',
                modules: { toolbar: [
                  ['bold','italic','underline'],
                  ['link','image'],
                  [{ list:'ordered'},{ list:'bullet'}],
                  ['clean']
                ]}
              });
            } catch(err) { console.warn('Quill init failed', err); }
          }, 120);
        }
      },
      error: function(xhr, status, err) {
        console.error('pmEdit AJAX error:', status, err, xhr.responseText);
        $('#pm-dlg-body').html('<div style="padding:24px;color:#b91c1c;">Erreur de chargement (' + status + ').</div>');
      }
    });
  });

  $(document).on('submit', '#pm-edit-form', function(e) {
    e.preventDefault();
    var $form = $(this);
    var url   = $form.attr('action');
    var data  = $form.serialize();
    if ($form.find('.extraContents').length && pmQuill) {
      data += '&' + $form.find('.extraContents').attr('name') + '=' + encodeURIComponent(pmQuill.root.innerHTML);
    }
    var btn     = $form.find("button[type='submit']");
    var btnHtml = btn.html();
    btn.attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enregistrement...');
    $.ajax({
      url    : url,
      type   : 'POST',
      data   : data,
      success: function(resp) {
        if (typeof resp === 'string') {
          try { resp = JSON.parse(resp); } catch(ex) { resp = {success:false,message:'Erreur serveur'}; }
        }
        btn.removeAttr('disabled').html(btnHtml);
        if (resp && resp.success) {
          if (typeof iziToast !== 'undefined') {
            iziToast.show({ icon:'fa fa-check', title: resp.message || 'Enregistré', color:'green', position:'topCenter' });
          }
          pmCloseModal();
          loadMethods();
        } else {
          var msg = (resp && resp.message) ? resp.message : 'Erreur';
          if (typeof iziToast !== 'undefined') {
            iziToast.show({ icon:'fa fa-times', title: msg, color:'red', position:'topCenter' });
          } else {
            alert(msg);
          }
        }
      },
      error: function(xhr, status, err) {
        btn.removeAttr('disabled').html(btnHtml);
        console.error('pmSave AJAX error:', status, err);
        if (typeof iziToast !== 'undefined') {
          iziToast.show({ icon:'fa fa-times', title:'Erreur serveur', color:'red', position:'topCenter' });
        } else {
          alert('Erreur serveur');
        }
      }
    });
  });

});
</script>