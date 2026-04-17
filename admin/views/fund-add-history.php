<?php include 'header.php'; ?>
<style>
.fah-wrap{padding:20px}
.fah-header{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}
.fah-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.fah-title i{color:var(--primary);font-size:18px}
.fah-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;background:var(--card);border:1px solid var(--border);border-radius:12px}
.fah-table{width:100%;border-collapse:collapse;font-size:13px}
.fah-table thead th{padding:12px 14px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
.fah-table tbody td{padding:10px 14px;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--text)}
.fah-table tbody tr:last-child td{border-bottom:none}
.fah-table tbody tr:hover{background:var(--primary-g)}
.fah-loader{text-align:center;padding:40px;color:var(--muted)}
.fah-loader svg{width:32px;height:32px;animation:spin .7s linear infinite}
.fah-amount-pos{color:#22c55e;font-weight:600}
.fah-amount-neg{color:#ef4444;font-weight:600}
/* ===== Premium modal Ajouter/Déduire ===== */
.fah-modal .modal-dialog { width: 560px; max-width: 94%; }
.fah-modal .modal-content { border-radius: 18px !important; overflow: hidden; }
.fah-modal .modal-header { padding: 16px 20px !important; }
.fah-modal .modal-title { font-size: 15px !important; font-weight: 800 !important; }
.fah-modal .modal-body { padding: 18px 20px !important; }
.fah-modal .form-group { margin-bottom: 16px !important; }
.fah-modal .form-label {
  display: inline-flex !important; align-items: center; gap: 6px;
  margin-bottom: 8px !important;
  font-size: 11px !important; font-weight: 800 !important;
  letter-spacing: .06em; text-transform: uppercase;
  color: var(--muted, #64748b) !important;
}
.fah-modal .form-label i { color: #6366F1; font-size: 12px; }

/* Banner at the top of the form */
.fah-modal .fah-banner {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 16px;
  background: linear-gradient(135deg, rgba(99,102,241,.10), rgba(59,130,246,.08));
  border: 1px solid rgba(99,102,241,.22);
  border-radius: 14px;
  margin-bottom: 18px;
}
.fah-modal .fah-banner-ico {
  width: 44px; height: 44px; border-radius: 12px;
  display: inline-flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg,#6366F1,#3B82F6);
  color: #fff; font-size: 18px;
  box-shadow: 0 10px 22px rgba(99,102,241,.30);
  flex-shrink: 0;
}
.fah-modal .fah-banner-title { font-size: 14px; font-weight: 800; color: var(--text); }
.fah-modal .fah-banner-sub   { font-size: 12px; color: var(--muted); margin-top: 2px; }

/* 2-column row for the top fields */
.fah-modal .fah-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 560px) { .fah-modal .fah-row { grid-template-columns: 1fr; } }

/* Inputs: strong contrast, rounded, with optional suffix */
.fah-modal .fah-input-wrap { position: relative; }
.fah-modal .fah-suffix {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  font-size: 11px; font-weight: 800; letter-spacing: .04em;
  color: #4f46e5; background: rgba(99,102,241,.12);
  padding: 3px 8px; border-radius: 6px;
  pointer-events: none;
}
.fah-modal .form-control {
  border-radius: 12px !important;
  padding: 11px 14px !important;
  font-size: 14px !important;
  height: 44px !important;
}
.fah-modal textarea.form-control { height: auto !important; min-height: 88px !important; }

/* Add/Deduct segmented toggle */
.fah-modal .fah-toggle {
  display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
}
.fah-modal .fah-toggle-opt {
  margin: 0; cursor: pointer; display: block;
}
.fah-modal .fah-toggle-opt input { position: absolute; opacity: 0; pointer-events: none; }
.fah-modal .fah-toggle-opt span {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  padding: 12px 14px;
  border-radius: 12px;
  border: 1px solid var(--border, #e2e8f0);
  background: var(--card, #fff);
  font-size: 13px; font-weight: 700;
  color: var(--text, #0f172a);
  transition: transform .15s ease, border-color .15s ease, background .15s ease, color .15s ease;
}
.fah-modal .fah-toggle-opt:hover span { border-color: rgba(99,102,241,.35); transform: translateY(-1px); }
.fah-modal .fah-toggle-opt input:checked + span {
  background: linear-gradient(135deg, rgba(99,102,241,.16), rgba(59,130,246,.10));
  border-color: #6366F1;
  color: #4f46e5;
  box-shadow: inset 0 0 0 1px rgba(99,102,241,.28);
}
body.dark-mode .fah-modal .fah-toggle-opt input:checked + span { color: #a5b4fc; }
.fah-modal .fah-toggle-opt span i { font-size: 14px; }

/* Footer */
.custom-modal-footer {
  display: flex; justify-content: flex-end; gap: 10px;
  padding: 14px 20px;
  border-top: 1px solid var(--border, #e2e8f0);
  margin: 16px -20px -18px;
  background: transparent;
}
.fah-modal .btn-primary i { margin-right: 6px; }
.cl-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;font-size:13px;font-weight:600;border-radius:8px;border:1px solid var(--border);background:var(--card);color:var(--text);cursor:pointer;transition:all .2s ease;text-decoration:none}
.cl-btn:hover{opacity:.85}
.cl-btn-primary{background:var(--primary);color:#fff;border-color:var(--primary)}
.cl-btn-primary:hover{background:var(--hover);color:#fff}
body.dark-mode .cl-btn{background:var(--primary);color:#fff;border-color:var(--primary)}
@media(max-width:768px){.fah-header{flex-direction:column;align-items:flex-start}}
</style>

<div class="fah-wrap">
  <div class="fah-header">
    <div class="fah-title"><i class="fas fa-money-bill-alt"></i> Historique des fonds</div>
    <button class="cl-btn cl-btn-primary" type="button" id="openAddBalance"><i class="fas fa-plus"></i> Ajouter / Déduire solde</button>
  </div>

  <div class="fah-table-wrap">
    <table class="fah-table" id="fahTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Utilisateur</th>
          <th>Méthode</th>
          <th>Solde</th>
          <th>Montant</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="fahBody">
        <tr><td colspan="8" class="fah-loader">
          <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="20" stroke="var(--primary)" stroke-width="4" stroke-dasharray="80" stroke-linecap="round"/></svg>
          <div style="margin-top:8px">Chargement...</div>
        </td></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Ajouter/Déduire (Bootstrap 3 compatible) -->
<div class="modal fade fah-modal" id="addBalanceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter / Déduire le solde</h4>
      </div>
      <div class="modal-body" id="addBalanceBody">
        <div class="fah-loader">
          <svg viewBox="0 0 48 48" fill="none" style="width:28px;height:28px"><circle cx="24" cy="24" r="20" stroke="var(--primary)" stroke-width="4" stroke-dasharray="80" stroke-linecap="round"/></svg>
          Chargement...
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Load fund-add-history data
$(function(){
  $.getJSON('admin/fund-add-history?action=getData', function(data){
    var html = '';
    if(!data.length){
      html = '<tr><td colspan="8" style="text-align:center;padding:30px;color:var(--muted)">Aucune donnée</td></tr>';
    } else {
      for(var i=0;i<data.length;i++){
        var d = data[i];
        var amtClass = parseFloat(d.amount) >= 0 ? 'fah-amount-pos' : 'fah-amount-neg';
        html += '<tr>';
        html += '<td><strong>#'+d.id+'</strong></td>';
        html += '<td>'+d.username+'</td>';
        html += '<td>'+d.method+'</td>';
        html += '<td>'+d.user_balance+'</td>';
        html += '<td class="'+amtClass+'">'+d.amount+'</td>';
        html += '<td>'+d.status+'</td>';
        html += '<td style="font-size:11px;color:var(--muted)">'+d.created_at+'</td>';
        html += '<td>'+(d.extra ? d.extra : '-')+'</td>';
        html += '</tr>';
      }
    }
    $('#fahBody').html(html);
  });

  // Open modal and load form
  $('#openAddBalance').click(function(){
    $.getJSON('admin/fund-add-history?action=add_remove_balance', function(resp){
      if(resp.success){
        // Convert BS5 form to BS3 compatible
        var content = resp.content
          .replace(/form-select/g, 'form-control')
          .replace('data-bs-dismiss="modal"', 'data-dismiss="modal"')
          .replace('action="admin/fund-add-history/manage-funds"', 'action="admin/fund-add-history/manage-funds" id="fahForm"');
        $('#addBalanceBody').html(content);
      }
    });
    $('#addBalanceModal').modal('show');
  });

  // Handle form submit via AJAX
  $(document).on('submit','#fahForm', function(e){
    e.preventDefault();
    var $btn = $(this).find('button[type=submit]');
    $btn.prop('disabled',true).text('Envoi...');
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: $(this).serialize(),
      success: function(resp){
        var payload = resp;
        if (typeof resp === 'string') {
          try { payload = JSON.parse(resp); } catch (e) { payload = null; }
        }
        if (payload && payload.success === true) {
          $('#addBalanceModal').modal('hide');
          iziToast.show({icon:'fa fa-check',title:(payload.message || 'Succès'),message:'',color:'green',position:'topCenter'});
          setTimeout(function(){ window.location.reload(); },800);
          return;
        }
        $btn.prop('disabled',false).text('Appliquer');
        iziToast.show({icon:'fa fa-times',title:(payload && payload.message ? payload.message : 'Erreur de validation'),message:'',color:'red',position:'topCenter'});
      },
      error: function(){
        $btn.prop('disabled',false).text('Appliquer');
        iziToast.show({icon:'fa fa-times',title:'Erreur',message:'',color:'red',position:'topCenter'});
      }
    });
  });
});
</script>

<?php include 'footer.php'; ?>
