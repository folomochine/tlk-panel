<?php include 'header.php'; ?>
<style>
.sp-wrap{padding:20px}
.sp-header{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}
.sp-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.sp-title i{color:var(--primary);font-size:18px}
.sp-table-wrap{overflow-x:auto;background:var(--card);border:1px solid var(--border);border-radius:12px}
.sp-table{width:100%;border-collapse:collapse;font-size:13px}
.sp-table thead th{padding:12px 14px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
.sp-table tbody td{padding:10px 14px;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--text)}
.sp-table tbody tr:last-child td{border-bottom:none}
.sp-table tbody tr:hover{background:var(--primary-g)}
.sp-loader{text-align:center;padding:40px;color:var(--muted)}
.sp-loader svg{width:32px;height:32px;animation:spin .7s linear infinite}
</style>

<div class="sp-wrap">
  <div class="sp-header">
    <div class="sp-title"><i class="fas fa-tag"></i> Tarifs spéciaux</div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <button class="cl-btn cl-btn-primary" type="button" id="openCreateSP"><i class="fas fa-plus"></i> Créer tarif spécial</button>
      <button class="cl-btn" type="button" style="color:#ef4444;border-color:rgba(239,68,68,.3)" data-ajax="true" data-action-ajax="admin/special-pricing/delete-all"><i class="fas fa-trash-alt"></i> Tout supprimer</button>
    </div>
  </div>

  <div class="sp-table-wrap">
    <table class="sp-table" id="spTable">
      <thead>
        <tr>
          <th>Utilisateur</th>
          <th>Service</th>
          <th>Prix coût</th>
          <th>Prix vente</th>
          <th>Prix spécial</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="spBody">
        <tr><td colspan="6" class="sp-loader">
          <svg viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="20" stroke="var(--primary)" stroke-width="4" stroke-dasharray="80" stroke-linecap="round"/></svg>
          <div style="margin-top:8px">Chargement...</div>
        </td></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="spModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Créer tarif spécial</h4>
      </div>
      <div class="modal-body" id="spModalBody">
        <div class="sp-loader">
          <svg viewBox="0 0 48 48" fill="none" style="width:28px;height:28px"><circle cx="24" cy="24" r="20" stroke="var(--primary)" stroke-width="4" stroke-dasharray="80" stroke-linecap="round"/></svg>
          Chargement...
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  // Load special pricing data
  if(typeof populate_special_prices === 'function'){
    populate_special_prices();
  }

  $('#openCreateSP').click(function(){
    $.getJSON('admin/special-pricing?action=create_special_price', function(resp){
      if(resp.success){
        var content = resp.content.replace(/form-select/g,'form-control').replace(/data-bs-dismiss/g,'data-dismiss');
        $('#spModalBody').html(content);
        if(typeof initialize_tomselect === 'function') initialize_tomselect();
      }
    });
    $('#spModal').modal('show');
  });
});
</script>

<?php include 'footer.php'; ?>
