<div class="col-md-8">
<?php if(empty($settings["site_base_currency"])){ ?>
<div style="border:1px solid var(--border);border-radius:10px;" class="col-md-8">
<h3 class="set-currency">Choisir la devise de base</h3>
<div class="form-group">
<select id="choose_currency" class="select">
<?php echo base64_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/currencies.txt"));?>
</select>
<div class="warning-msg">
  <i class="fa fa-warning"></i>
 Vous ne pouvez changer la devise de base qu'une seule fois lors de l'installation du panel. Elle ne peut plus être modifiée par la suite.
</div>
<a class="btn btn-success" id="site_currency_btn" href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?php echo site_url("admin/settings/currency-manager/INR");?>">Définir la devise en Roupie Indienne (INR)</a>
</div>
<?php  } else {

$t = $conn->prepare("SELECT * FROM currencies");
$t->execute();
$t = $t->fetchAll(PDO::FETCH_ASSOC);

$content .= "";
for($i = 0;$i < count($t);$i++){
$cur_id = $t[$i]["id"];
$cur_name = $t[$i]["currency_name"];
$cur_code = $t[$i]["currency_code"];
$cur_symbol = $t[$i]["currency_symbol"];
$sym_pos = $t[$i]["symbol_position"];
$is_enable = $t[$i]["is_enable"];
$cur_rate = $t[$i]["currency_rate"];
$cur_inv_rate = $t[$i]["currency_inverse_rate"];

if($i !== 0){
$content .= '<div style="border:1px solid var(--border);border-radius:5px;padding:15px;margin-bottom:10px;" class="currencies">
<center><h4 style="color:var(--purple);" class="sansita">'.$cur_name.'</h4></center>
<form>
<div class="grid">
<div class="form__group grid__col">
<label class="form__group-title" for="cur_rate">Taux</label>
<div class="form__controls">
<input type="hidden" name="id" value="'.$cur_id.'">
<input id="cur_rate" name="cur_rate" class="form__input form-control input-sm" type="text" value="'.$cur_rate.'">
</div>
</div>

<div class="form__group grid__col">
<label class="form__group-title" for="inv_rate">Taux inverse</label>
<div class="form__controls">
<input id="inv_rate" name="inv_rate" class="form__input form-control input-sm" type="text" value="'.$cur_inv_rate.'">
</div>
</div>


<div class="form__group grid__col">
<label class="form__group-title" for="symbol">Symbole</label>
<div class="form__controls">
<input id="symbol" name="symbol" class="form__input form-control input-sm" type="text" value="'.$cur_symbol.'">
</div>
</div>

<div class="form__group grid__col">
<label class="form__group-title" for="sym_pos">Position du symbole</label>
<div class="form__controls">
<select id="sym_pos" name="sym_pos"  class="form-control"><option value="left" ';
if($sym_pos == "left"){
    $content .= 'selected'; 
}
$content .= '>Avant la valeur (1.00 $)</option><option value="right" ';
if($sym_pos == "right"){
    $content .= 'selected'; 
}
 $content .= '>Après la valeur ($ 1.00)</option></select>
</div></div>
<div class="form__group grid__col">
<label class="form__group-title" for="enable">Activer / Désactiver</label>
<div class="form__controls">
<select id="enable" name="enable"  class="form-control"><option value="1" ';
if($is_enable == "1"){
    $content .= 'selected';
}
$content .= '>Actif</option><option value="0" ';
if($is_enable == "0"){
    $content .= 'selected';
}

$content .= '>Inactif</option></select></div></div>
<div class="form__group grid__col">
<label class="form__group-title">Supprimer</label>
<div class="form__controls">
<button style="width:100%;background-color:var(--red);color:#fff;" type="button" data-currency-id="'.$cur_id.'" class="btn delete-currency">Supprimer</button>
</div>
</div>

<div class="form__group">
<input class="form__submit btn btn-sm currency-values-save-changes" name="save_changes" style="background:var(--primary);color:#fff;" type="submit" value="Enregistrer"></div></div>
</form>
</div>';
}
}
?>



<div class="curr_conv col-md-8">
<h3 class="set-currency b-blue">Paramètres de devise</h3> 


<hr>

<p><span style="font-size:19px;font-weight:bold;font-style:italic;">Convertisseur de devises</span>
<label class="toggle" for="activate_deactivate_curr_conv">
<input type="checkbox" class="toggle__input" id="activate_deactivate_curr_conv" <?php if($settings["site_currency_converter"] == "1"){
echo "checked";
}?>/>
<span class="toggle-track">
<span class="toggle-indicator">
<span class="checkMark">
<svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
<path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
</svg></span></span></span></label></p>

<p><span style="font-size:19px;font-weight:bold;font-style:italic;">Mise à jour automatique des taux</span><br/><small><?php
echo "<i>( Last Updated : ".str_replace(["am","pm"],["AM","PM"],date("j F Y, g:i a",strtotime($settings["last_updated_currency_rates"]))) ." )</i>";
 ?></small>
<label style="margin-top:-25px;" class="toggle" for="rate_update_switch">
<input type="checkbox" class="toggle__input" id="rate_update_switch" <?php if($settings["site_update_rates_automatically"] == "1"){
echo "checked";
}?>/>
<span class="toggle-track">
<span class="toggle-indicator">
<span class="checkMark">
<svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true">
<path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path>
</svg></span></span></span></label></p>

<button class="button-1 update-rates" id="update-rates" role="button">Mettre à jour les taux</button>
<?php 

$currency_codes = $conn->prepare("SELECT currency_code FROM currencies WHERE currency_code!=:code AND is_enable=1");
$currency_codes->execute(["code"=>$settings["site_base_currency"]]);
$currency_codes = $currency_codes->fetchAll(PDO::FETCH_ASSOC);

$count = count($currency_codes);

if($count <= 15){
  
echo '<button class="button-1 add-currency" id="add-currency" id="update-rates" role="button" data-toggle="modal" data-target="#modalDiv" data-action="site-add-currency">Ajouter une devise</button>';
} elseif($count > 15) {
echo '<div style="background-color:var(--red-g);padding:7px;border-radius:4px;margin-top:10px;"><p style="color:var(--red);">
Vous pouvez ajouter au maximum 15 devises au convertisseur. Supprimez ou désactivez certaines devises ci-dessous pour en ajouter d\'autres.</p></div>';
}

?>
<hr>



<?php echo $content;?>



</div>

<?php } ?>
</div>
</div>
<br/><br/><br/>
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
             <h4>Êtes-vous sûr de vouloir définir cette devise ?</h4>
             <div align="center">
                <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            </div>
         </div>
      </div>>
   </div>
</div>
