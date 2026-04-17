<?php include 'header.php'; ?>
<style>
.up-wrap{padding:20px;max-width:600px}
.up-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;margin-bottom:18px}
.up-title i{color:var(--primary);font-size:18px}
.up-card{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.up-card-head{padding:14px 18px;border-bottom:1px solid var(--border);font-size:15px;font-weight:600;color:var(--text)}
.up-card-body{padding:18px}
.up-card-foot{padding:14px 18px;border-top:1px solid var(--border);text-align:right}
.up-fg{margin-bottom:16px}
.up-fg label{display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:4px}
.up-fg select,.up-fg input{width:100%;padding:9px 12px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:13px}
.up-fg select:focus,.up-fg input:focus{border-color:var(--primary);outline:none}
.up-ig{display:flex}
.up-ig input{border-radius:8px 0 0 8px;flex:1}
.up-ig span{padding:9px 14px;background:var(--border);border:1px solid var(--border);border-left:none;border-radius:0 8px 8px 0;color:var(--muted);font-size:14px;display:flex;align-items:center}
</style>

<div class="up-wrap">
  <div class="up-title"><i class="fas fa-cloud-upload-alt"></i> Mettre à jour les prix</div>
  <div class="up-card">
    <div class="up-card-head">Mise à jour des prix</div>
    <form action="admin/update-prices" method="POST">
      <div class="up-card-body">
        <div class="up-fg">
          <label>Type de services</label>
          <select name="service_type" id="special_pricing_service_type">
            <option value="all_services">Tous les services</option>
            <option value="seller_services">Services fournisseur</option>
            <option value="manual_services">Services manuels</option>
          </select>
        </div>
        <div style="display:none" id="special-pricing-seller-select-div" class="up-fg">
          <label>Fournisseurs</label>
          <select name="sellers[]" id="select-seller" multiple>
            <?=$providers_option;?>
          </select>
        </div>
        <div class="up-fg">
          <label>Pourcentage de profit</label>
          <div class="up-ig">
            <input type="number" name="profit-percent-value" id="profit-percent-value" placeholder="10">
            <span>%</span>
          </div>
        </div>
        <div class="up-fg" id="action_type_div"></div>
      </div>
      <div class="up-card-foot">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div>
</div>

<script>
$(function(){
  $('#special_pricing_service_type').change(function(){
    if($(this).val()=='seller_services'){
      $('#special-pricing-seller-select-div').show();
    } else {
      $('#special-pricing-seller-select-div').hide();
    }
  });
});
</script>

<?php include 'footer.php'; ?>


