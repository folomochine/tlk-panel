<?php include 'header.php'; ?>

          <div class="container container-md"> <div class="row"><div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-body">
  <center> <h3>Modifier la diffusion</h3></center>

          <hr>
<form class="form" action="<?php echo site_url("admin/broadcasts/edit"); ?> " method="POST" >
<div class="form-group">
<label class="form-group__service-name">Titre</label>
<input type="hidden" name="id" value="<?= $notifData['id']; ?>">
                <input type="text" class="form-control" name="title" value="<?= $notifData['title']; ?>" required>
              </div>
<div class="form-group">

<label class="form-group__service-name">Type</label>
<select class="form-control" name="broadcast_type">
<option value="info" <?php if($notifData['type']== "info"){ echo 'selected'; }?>>Info</option>
<option value="success" <?php if($notifData['type']== "success"){ echo 'selected'; }?>>Succès</option>
<option value="error" <?php if($notifData['type']== "error"){ echo 'selected'; }?>>Erreur</option>
<option value="warning" <?php if($notifData['type']== "warning"){ echo 'selected'; }?>>Attention</option>
</select>
</div>
               <div class="form-group">
                        <label class="form-group__service-name">Lien d'action</label>
                        <input type="text" class="form-control" name="action_link" value="<?= $notifData['action_link']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Texte du bouton (optionnel)</label>
                        <input type="text" class="form-control" name="action_text" value="<?= $notifData['action_text']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Description</label>
         <textarea class="form-control" id="summernote" rows="5" name="description" placeholder="" required> <?= $notifData['description']; ?> </textarea>

                </div>

<div class="form-group">
                        <label class="form-group__service-name">Sélectionner les utilisateurs</label>
                        <input type="radio" class="" name="isAllUser" value="0" <?php if ($notifData['isAllUser']==0) { echo 'checked'; } ?>> Tous les utilisateurs</br>
                        <input type="radio" class="" name="isAllUser" value="1" <?php if ($notifData['isAllUser']==1) { echo 'checked'; } ?>> Utilisateurs connectés
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Date d'expiration</label>
                        <input type="date" class="form-control" name="expiry_date" value="<?= $notifData['expiry_date']; ?>">
                </div>
                <div class="form-group">
                        <label class="form-group__service-name">Statut</label>
                        <select class="form-control" name="status">
                                <option value="0" >Sélectionné : <?php if($notifData['status']==0){echo "Inactif";}else{echo "Actif";}  ?></option>
                            <option value="0" <?php if($notifData['status']==0){ echo 'selected'; } ?>>Inactif</option>
                            <option value="1" <?php if($notifData['status']==1){ echo 'selected'; } ?>>Actif</option>
                        </select>    
                </div>
              <button type="submit" class="btn btn-primary">Mettre à jour</button>  
         <a href="<?=site_url("admin/broadcasts")?>" class="btn btn-default">
         <span class="export-title">Retour</span>
         </a>
        </form>
    
  


<?php include 'footer.php'; ?>
<script>
$('input#isAllPage').change(function() {
if ($('input#isAllPage').prop('checked')) {    
   $('div#allPages').hide();
}else{
    $('div#allPages').show();
}

});
</script>
