<?php if( !route(4) ): ?>
<div>
   <table class="table report-table" style="border:1px solid var(--border)">
      <thead>
         <tr>
            <th>Nom de la page</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($pageList as $page): ?>
         <tr>
            <td> <?php echo $page["page_name"]; ?> </td>
            <td class="text-right col-md-1">
               <div class="dropdown">
                  <a href="<?php echo site_url('admin/settings/pages/edit/'.$page["page_get"]) ?>" class="btn btn-default btn-xs">
                  Modifier
                  </a>
              </div>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
<?php elseif( route(3) == "edit" ): ?>
<div>
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/settings/pages/edit/'.route(4)) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label class="control-label">Nom de la page</label>
               <input type="text" class="form-control" readonly value="<?=$page["page_name"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Contenu de la page</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" placeholder=""><?php echo $page["page_content"]; ?></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
         </form>
      </div>
   </div>
</div>
<?php endif; ?>
