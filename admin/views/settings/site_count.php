<div>
  <div class="panel panel-default">
    <div class="panel-body">
<h1>Fausses commandes</h1><a href="<?php echo site_url("admin/settings/site_count/service_enable_disable");?>" style="float:right;margin-top:-45px;" class="btn btn-primary btn-sm"><?php if($settings["fake_order_service_enabled"] == 0){ echo "Activer le service";} else { echo  "Désactiver le service";}?></a>
<center>
<p><i>Utilisez ces paramètres pour accélérer les commandes du panel.</i></p></center>
<form class="form  <?php if($settings["fake_order_service_enabled"] == 0){ echo "disabledDiv"; }?>" action="" method="post">
<div class="form-group">
<label class="">Nombre minimum de fausses commandes</label>
<input class="form-control" type="number" name="min_count" value="<?php if(is_numeric($settings["fake_order_min"])){
echo $settings["fake_order_min"];}?>">
</div>
<div class="form-group">
<label class="">Nombre maximum de fausses commandes</label>
<input class="form-control" type="number" name="max_count" value="<?php if(is_numeric($settings["fake_order_max"])){
echo $settings["fake_order_max"];}?>">
</div>
<div class="alert alert-info">Laisser vide pour un choix aléatoire.</div>
<div class="form-group">
<button class="btn btn-primary" type="submit">Mettre à jour les paramètres</button>
</div>
</form>
<div class="alert alert-info">
Note : Lorsque activé, les commandes sont incrémentées toutes les 5 minutes.</div>
<hr><hr>
<div class="form-group">
<label class="">PROCHAIN ID DE COMMANDE</label>
<input class="form-control" type="number" id="next_order_id_value" value="<?=$settings["panel_orders"] + 1?>">
<small class="text-muted">
Doit être supérieur à <?=$settings["panel_orders"]?>.
</small>
</div>
<div class="form-group">
<button type="button" id="next_order_id_value_btn" class="btn btn-primary">Enregistrer</button>
</div>
<div class="alert alert-info">
Note : Le paramètre ci-dessus créera une fausse commande avec l'ID saisi. Le prochain ID de commande commencera à partir de cet ID.<br>Exemple, ID COMMANDE : 2000<br>PROCHAIN ID : 2001</div>


<hr><hr>

<label class="">Modèle du total des commandes</label>

<p style="font-weight:bold;"><span>Préfixe du total</span>
<span style="float:right;" class="">Suffixe du total</span></p>
<div class="form-group">
<div class="input-group">
<?php 
$sff = json_decode($settings["panel_orders_pattern"],true);
$prefix = $sff["panel_orders_prefix"];
$suffix = $sff["panel_orders_suffix"];

?>
<input type="number" class="form-control" id="total_orders_prefix" value="<?=$prefix?>" placeholder="10">
<span class="input-group-addon"><?=$settings["panel_orders"]?></span>

<input type="number" class="form-control" id="total_orders_suffix" value="<?=$suffix?>" placeholder="10">
</div></div>
<div class="form-group">
<button type="button" id="set_total_orders_pattern" class="btn btn-primary">Enregistrer</button>
</div>


<div class="alert alert-info">
Note : L'ID de commande ne sera pas affecté.</div>



</div>


</div>

</div></div>
