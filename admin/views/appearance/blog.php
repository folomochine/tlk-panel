<?php if( !route(3) ): ?>

            
<div class="settings-header__table">

            <div class="col-md-8">
	<div class="settings-header__table">
	<a href="admin/appearance/blog/new" >	<button type="button" class="btn btn-default m-b">Créer un article</button></a>
	</div>
	

   <table class="table report-table" style="border:1px solid var(--border)">
      <thead>
         <tr>
            <th>Titre de l'article</th>
<th>Date de création</th>
<th>Visibilité</th>
            <th width="20%">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($blogs as $blog): ?>
         <tr>
<td> <?php echo $blog["title"]; ?> </td>
            <td> <?php echo $blog["published_at"]; ?> </td>
<td><?php if($blog["status"]==1){ echo 'Publié';}else{ echo 'Non publié';}   ?></td>

			 
			 
			 
			
            <td>
                  <a href="<?php echo site_url('admin/appearance/blog/edit/'.$blog["id"]) ?>" class="btn btn-default btn-xs">
                  Modifier
                  </a>
                  <a href="<?php echo site_url('admin/appearance/blog/delete/'.$blog["id"]) ?>" class="btn btn-default btn-xs btn-danger">
                  Supprimer
                  </a>
              
            </td>
         </tr>
         <?php endforeach; ?>



      </tbody>
   </table>
</div>
</div>



<?php elseif( route(3) == "new" ): ?>
<div>
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/appearance/blog/new') ?>" method="post" enctype="multipart/form-data">
<div class="form-group">
               <label class="control-label">Image de l'article (<a href="https://imgur.com/upload"> Télécharger ici </a>)</label>
               <input type="text" class="form-control" name="url" value="">
            </div>
        
            <div class="form-group">
               <label class="control-label">Titre de l'article</label>
               <input type="text" class="form-control" name="title" value="">
            </div>
            <div class="form-group">
               <label class="control-label">Contenu de la page</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" placeholder=""></textarea>
            </div>
<hr>
                    <div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("blog/")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="blogurl" value="">                   </div>
                    </div>
<div class="form-group">
          <label class="control-label">Visibilité
            </label>
          <select class="form-control" name="status">
            <option value="2">Non publié</option>
            <option value="1">Publié</option>
          </select>
</div> 
            <hr>
            <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
         </form>
      </div>
   </div>
</div>

<?php elseif( route(3) == "edit" ): ?>
         
<div>
   <div class="panel panel-default">
      <div class="panel-body">
<form action="<?php echo site_url('admin/appearance/blog/edit/'.route(4)) ?>" method="post" enctype="multipart/form-data">

         <div class="form-group">
               <label class="control-label">Image de l'article</label>
               <input type="text" class="form-control" name="url" value="<?=$bloge["image_file"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Titre de l'article</label>
               <input type="text" class="form-control" name="title" value="<?=$bloge["title"];?>">
            </div>
            <div class="form-group">
               <label class="control-label">Contenu de l'article</label>
               <textarea class="form-control" id="summernoteExample" rows="5" name="content" ><?=$bloge["content"];?></textarea>
            </div>
                           
                    <hr>
                    <div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("blog/")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="blogurl" value="<?=$bloge["blog_get"];?>">                   </div>
                    </div>
                    

        <div class="form-group">
          <label class="control-label">Visibilité
            </label>
          <select class="form-control" name="status">
            <option value="2" <?= $bloge["status"] == 2 ? "selected" : null; ?> >Non publié</option>
            <option value="1" <?= $bloge["status"] == 1 ? "selected" : null; ?>>Publié</option>
          </select>
</div>
            <hr>
<button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
                                            <a class="btn btn-link pull-right delete-btn" href="/admin/appearance/delete-blog/<?= $bloge["id"]; ?>"data-title="Supprimer cet article ?">Supprimer</a>
         </form>
      </div>
   </div>
</div>
         
<?php endif; ?>
