<?php include 'header.php'; ?>

 <div class="container container-md"> <div class="row"><div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-body">
  <center> <h3>Créer une diffusion</h3></center>

<hr>
<form class="form" action="<?php echo site_url("admin/broadcasts/new"); ?> " method="POST" >


<div class="form-group">
<label class="form-group__service-name">Titre</label>
<input type="text" class="form-control" name="title" value="" required>
</div>


<div class="form-group">

<label class="form-group__service-name">Type</label>
<select class="form-control" name="broadcast_type">
<option value="info" selected>Info</option>
<option value="success">Succès</option>
<option value="error">Erreur</option>
<option value="warning">Attention</option>
</select>
</div>


<div class="form-group">
<label class="form-group__service-name">Lien du bouton (optionnel)</label>
<input type="text" class="form-control" name="action_link" value="">
</div>

<div class="form-group">
<label class="form-group__service-name">Texte du bouton (optionnel)</label>
<input type="text" class="form-control" name="action_text" value="">
</div>

<div class="form-group">
<label class="form-group__service-name">Description</label>
<textarea class="form-control" id="summernote" rows="5" name="description" placeholder=""></textarea>

</div>


<div class="form-group">
<label class="form-group__service-name">Sélectionner les utilisateurs</label>
<input type="radio" class="" name="isAllUser" value="0"> Tous les utilisateurs</br>
<input type="radio" class="" name="isAllUser" value="1"> Utilisateurs connectés
</div>

<div class="form-group">
<label class="form-group__service-name">Date d'expiration</label>
<input type="date" class="form-control" name="expiry_date" value="">
</div>
<div class="form-group">

<label class="form-group__service-name">Statut</label>
<select class="form-control" name="status">
<option value="1" selected>Actif</option>
<option value="0">Inactif</option>
</select>
</div>

<button type="submit" class="btn btn-primary">Enregistrer</button>  <a href="<?=site_url("admin/broadcasts")?>" class="btn btn-default">
<span class="export-title">Retour</span></a>
</form>
</div>
</div>

</div>
<?php include 'footer.php'; ?>
