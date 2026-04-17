<?php include 'header.php'; ?>


<div class="container-fluid">
  <div class="row">    
   <div class=" col-md-12">
   <ul class="nav nav-tabs">
      <li class="p-b"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalDiv" data-action="yeni_kupon">Creer un coupon</button></li>
     
   </ul>
   
   <table class="table report-table">
      <thead>
         <tr>
            
            
            <th width="33%">Code coupon</th>
            <th width="15%">Quantite</th>
            <th width="33%">Montant</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" class="tl-confirm-form" data-title="Supprimer le coupon" data-message="Cette action est irréversible. Continuer ?" data-confirm-label="Oui, supprimer" action="<?php echo site_url("admin/kuponlar/delete") ?>" method="post">
        <tbody>
          <?php foreach($kuponlar as $kupon ): ?>
              <tr>
                 
                 <td><?php echo $kupon["kuponadi"] ?></td>
                 <td><?php echo $kupon["adet"] ?></td>
                 <td><?php echo $kupon["tutar"] ?></td>
                 <td><input type="hidden" name="kupon_id" value="<?php echo $kupon["id"] ?>"><button type="submit" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret">Supprimer</button></td>
                 
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table>
   <hr>
   <h4>Coupons utilises</h4>
 
   
   <table class="table report-table">
      <thead>
         <tr>
            
            
            <th width="33%">Numero membre</th>
            <th width="15%">Code coupon</th>
            <th width="33%">Montant</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" class="tl-confirm-form" data-title="Supprimer le coupon" data-message="Cette action est irréversible. Continuer ?" data-confirm-label="Oui, supprimer" action="<?php echo site_url("admin/kuponlar/delete") ?>" method="post">
        <tbody>
          <?php foreach($kupon_kullananlar as $kupons ): ?>
              <tr>
                 
                 <td><?php echo $kupons["uye_id"] ?></td>
                 <td><?php echo $kupons["kuponadi"] ?></td>
                 <td><?php echo $kupons["tutar"] ?></td>
            
                 
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
