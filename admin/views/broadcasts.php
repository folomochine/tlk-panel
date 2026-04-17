<?php include 'header.php'; ?>


<div class="container-fluid">
  <div class="row">    
   <div class=" col-md-12">
   <ul class="nav nav-tabs">
   
          <a href="<?php echo site_url("admin/broadcasts/create") ?>" <button type="button" class="btn btn-default" data-toggle="modal" data-target="" data-action="">Creer une notification </button> </a>
   
     
	
	  
   </ul>
<br>
   <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">
                        <div class="container-fluid pd-t-20 pd-b-20">
                            
                                     
   
   <table class="table order-table">
      <thead>
         <tr>
            <th width="5%">ID</th>
            <th width="20%">Titre</th>
            <th width="10%">Type</th>
            <th width="30%">Lien d'action</th>
            <th width="10%">Tous les utilisateurs</th>
            <th width="10%">Date d'expiration</th>
            <th width="5%">Statut</th>
            <th width="10%">Action</th>
         </tr>
      </thead>
      
        <tbody>
          <?php foreach($notifications as $notification ): ?>
              <tr>
                 
                 <td><?php echo $notification["id"] ?></td>
                 <td><?php echo $notification["title"] ?></td>
                 <td><span class="badge badge-<?php echo $notification["type"];?>"><?php echo ucfirst($notification["type"]);?></span></td>
                 <td><?php echo $notification["action_link"]?></td>
                 <td><?php if($notification["isAllUser"]){ echo 'Non';}else{ echo 'Oui';}   ?></td>
                 <td><?php echo $notification["expiry_date"] ?></td>
                 <td><?php if($notification["status"] == 1){ echo 'Actif';}else{ echo 'Inactif';}   ?></td>
                 <td>
                   <form id="changebulkForm" class="tl-confirm-form" data-title="Supprimer la notification" data-message="Cette notification sera définitivement supprimée." data-confirm-label="Oui, supprimer" action="<?php echo site_url("admin/broadcasts/delete") ?>" method="post">
					   <div class="btn-group">
                     <input type="hidden" name="notification_id" value="<?php echo $notification["id"] ?>">
					   
					   <button type="submit" class="btn btn-danger btn-xs">Supprimer</button>
                     
                     <a href="<?php echo site_url("admin/broadcasts/edit/".$notification["id"]) ?>" class="btn btn-info btn-xs">Modifier</a>
					    </div>
                    </form>
                 </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
        
   </table>
  
</div>
</div>
</div>

<?php

include 'footer.php'; ?>
