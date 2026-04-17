<div>
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="" method="post" enctype="multipart/form-data">
  
<div class="form-group">
          <label for="" class="control-label">Système d'affiliation</label>
          <select class="form-control" name="affiliates_status">
         
          <option value="1"  <?= $settings["referral_status"] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $settings["referral_status"] == 2 ? "selected" : null; ?>>Activé</option>
          
          </select>
        </div>
  <div class="form-group">
          <label for="" class="control-label">Taux de commission, %</label>
          <input type="number" class="form-control" name="commision" value="<?=$settings["referral_commision"]?>">
        </div>
        <div class="form-group">  
          <label for="" class="control-label">Paiement minimum</label>
          <input type="number" class="form-control" name="minimum" value="<?=$settings["referral_payout"]?>">
        </div>
        
<hr>
<div class="childpanels-settings">
<div class="form-group">
          <label for="" class="control-label">Vente de panel enfant</label>
          <select class="form-control" name="selling">
         
<option value="1"  <?= $settings[""] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $settings["childpanel_selling"] == 2 ? "selected" : null; ?>>Activé</option>
         
          </select>
        </div>
        

<div class="form-group">
<label for="" class="control-label">Prix du panel enfant</label>
<input type="text" class="form-control" name="price" value="<?=$settings["childpanel_price"]?>">
</div> 
<div style="padding:4px; background-color:var(--bg);border:1px solid var(--border); border-radius:4px;width:max-content;">
<small>Prix de base du panel enfant : ₹ 500</small></div>

</div>

<hr>


<div class="form-group">
          <label for="" class="control-label">Solde gratuit</label>
          <select class="form-control" name="freebalance">
         
                    <option value="1"  <?= $settings["freebalance"] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $settings["freebalance"] == 2 ? "selected" : null; ?>>Activé</option>
         
          </select>
        </div>
<div class="form-group">
          <label for="" class="control-label">Montant gratuit</label>
          <input type="text" class="form-control" name="freeamount" value="<?=$settings["freeamount"]?>">
        </div> 
<hr>
<div class="form-group">
          <label for="" class="control-label">Promotion vidéo</label>
          <select class="form-control" name="promotion">
         
                    <option value="1"  <?= $settings["promotion"] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $settings["promotion"] == 2 ? "selected" : null; ?>>Activé</option>
         
          </select>
        </div>

<div class="form-group">
          <label for="" class="control-label">Journal des mises à jour</label>
          <select class="form-control" name="updates_show">
         
                    <option value="1"  <?= $general["updates_show"] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $general["updates_show"] == 2 ? "selected" : null; ?>>Activé</option>
         
          </select>
        </div>


<div class="form-group">
          <label for="" class="control-label">Commande en masse</label>
          <select class="form-control" name="massorder">
         
                    <option value="1"  <?= $general["massorder"] == 1 ? "selected" : null; ?>>Désactivé</option>
          <option value="2" <?= $general["massorder"] == 2 ? "selected" : null; ?>>Activé</option>
         
          </select>
        </div>


<hr>
        <center><button type="submit" class="btn btn-primary">Enregistrer les modifications</button></center>
      </form>
      
    </div>
  </div>
</div>


<div>
    <div class="panel panel-default">
    <div class="panel-body">
<?php  

$google_login = json_decode($settings["google_login"],true);

?>

<?php if($google_login["purchased"] != "1"){ ?>
<div data-addon="google_login" class="product-card">
  <div class="product-icon"><img src="https://i.postimg.cc/WbnmCB4D/google.png" alt="Product Icon"></div>
  <div class="product-details">
    <h2 class="product-name">Module Connexion Google</h2>  </div>
</div>

<?php } else { ?>
 <div class="settings-emails__block-body">
<table>
<thead>
<tr>
<th class="settings-emails__th-name"></th>
<th class="settings-emails__th-actions"></th>
</tr>
</thead>
<tbody>
<tr class="settings-emails__row">
                    <td>
                        <div class="settings-emails__row-name">Connexion Google</div>
<div class="settings-emails__row-description">Les utilisateurs pourront se connecter avec leur compte Google.</div>
</td>

<td class="settings-emails__td-actions">  
    <label class="switch">
      <input  data-addon="google_login"  type="checkbox" class="switch-input addon"  <?php echo $google_login["status"] ? "checked" : "";?>>
      <span class="switch-label" data-on="On" data-off="Off"></span>
      <span class="switch-handle"></span>
    </label>

 </td>
</tr>
</tbody>
</table>

<?php } ?>



</div>
