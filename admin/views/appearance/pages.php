
<?php if(! route(3) ): ?>
<div>
            <a class="btn btn-default m-b" href="/admin/appearance/pages/create">Ajouter une page</a>            <table class="table">
               

   <table class="table report-table" style="border:1px solid var(--border)">
      <thead>
         <tr>
            <th><div style="float:left;">Nom de la page</div></th>
<th>Visibilité</th>
<th>Dernière modification</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($pageList as $page): ?>
         <tr>
            <td> <div style="float:left;"><?php echo $page["page_name"]; ?></div> </td>
            
               <td>
                        <input type="checkbox" class="tiny-toggle" data-tt-palette="blue" data-url="<?=site_url("admin/appearance/pages/type")?>" data-id="<?php echo $page["page_id"]; ?>" <?php if( $page["page_status"]==1 ): echo "checked"; endif; ?>> </td>


<?php if( $page["last_modified"]== "0000-00-00 00:00:00"): ?>
<td> Jamais</td>
<?php else: ?>
<td> <?php echo $page["last_modified"]; ?> </td>

<?php endif; ?>

             <td >     <a href="<?php echo site_url('admin/appearance/pages/edit/'.$page["page_get"]) ?>" class="btn btn-default btn-xs">
                  Modifier
                  </a>

				 <?php if( $page["del"]== "1"): ?>
				 
				 <a href="<?php echo site_url('admin/appearance/pages/delete/'.$page["page_id"]) ?>" class="btn btn-default btn-xs btn-danger">
                  Supprimer
                  </a>
               <?php endif; ?>
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
         <form action="<?php echo site_url('admin/appearance/pages/edit/'.route(4)) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label class="control-label">Nom de la page</label>
               <input type="text" class="form-control" value="<?=$page["page_name"];?>" readonly>
            </div>
            <div class="form-group">
               <label class="control-label">Contenu HAUT de la page</label>
               <textarea class="form-control" id="summernote" rows="5" name="content" placeholder=""><?php echo $page["page_content"]; ?></textarea>
            </div>
			  <div class="form-group">
               <label class="control-label">Contenu BAS de la page</label>
               <textarea class="form-control" id="summernote1" rows="5" name="content2" placeholder=""><?php echo $page["page_content2"]; ?></textarea>
            </div>

<hr>
    <div class="appearance-seo__block">
        <div class="appearance-seo__block-title">    Aperçu dans les moteurs de recherche     </div>
        <a class="other_services" href="#collapse-languages-seo" role="button" data-toggle="collapse">   <span>
  Modifier le SEO de la page </span>
    </a>        <div class="seo-preview">
             <div class="seo-preview__title edit-seo__title"></div>

             <div class="seo-preview__title edit-seo__title"><?=$page["seo_title"];?></div>
    <div class="seo-preview__url"><?=site_url("")?><span class="edit-seo__url"><?=$page["page_get"];?></span>
 <div class="seo-preview__description edit-seo__meta"><?=$page["seo_description"];?></div>
         
</div>
            <div class="seo-preview__description edit-seo__meta"></div>
        </div>
    </div>
    <div class="collapse appearance-seo__block-collapse" id="collapse-languages-seo">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_title">Titre de la page</label>            <input type="text" id="editpageform-seo_title" class="form-control" name="seo_title" value="<?=$page["seo_title"];?>">        </div>

            <div class="form-group">
            <label class="control-label" for="editpageform-seo_description">Mots-clés méta</label>            <textarea id="editpageform-seo_keywords" class="form-control" name="seo_keywords" rows="5"><?=$page["seo_keywords"];?></textarea>        </div>
    <div class="form-group">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_description">Méta-description</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_description" rows="5"><?=$page["seo_description"];?></textarea>        </div>
    </div>
</div>                                                                
                       

            <hr>
            <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
			  
			 <?php if( $page["del"]== "1"): ?>
			 <a class="btn btn-link pull-right delete-btn" href="/admin/appearance/delete-page/<?= $page["page_id"]; ?>"data-title="Supprimer cette page ?">Supprimer</a>
			 <?php endif; ?>
			 
         </form>
      </div>
   </div>
</div>


<?php elseif( route(3) == "create" ): ?>
<div>
   <div class="panel panel-default">
      <div class="panel-body">
         <form action="<?php echo site_url('admin/appearance/pages/create') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <label class="control-label">Nom de la page</label>
               <input type="text" class="form-control"  name="name"  value="">
            </div>
            <div class="form-group">
               <label class="control-label">Contenu HAUT de la page</label>
               <textarea class="form-control" id="summernote" rows="5" name="content" placeholder=""></textarea>
            </div>
			  <div class="form-group">
               <label class="control-label">Contenu BAS de la page</label>
               <textarea class="form-control" id="summernote1" rows="5" name="content2" placeholder=""></textarea>
            </div>
<div class="form-group" >
                        <label class="control-label" for="createblogform-url">URL</label>                        <div class="input-group">
                            <span class="input-group-addon" id="sizing-addon2"><?=site_url("")?></span>
                            <input type="text" id="createblogform-url" class="form-control" name="pageget" value="">                   </div>
                    </div>

<hr>
    <div class="appearance-seo__block">
        <div class="appearance-seo__block-title">    Aperçu dans les moteurs de recherche     </div>
        <a class="other_services" href="#collapse-languages-seo" role="button" data-toggle="collapse">   <span>
  Modifier le SEO de la page </span>
    </a>        <div class="seo-preview">
             <div class="seo-preview__title edit-seo__title"></div>

             <div class="seo-preview__title edit-seo__title"><?=$page["seo_title"];?></div>
    <div class="seo-preview__url"><?=site_url("")?><span class="edit-seo__url"><?=$page["page_get"];?></span>
 <div class="seo-preview__description edit-seo__meta"><?=$page["seo_description"];?></div>
         
</div>
            <div class="seo-preview__description edit-seo__meta"></div>
        </div>
    </div>
    <div class="collapse appearance-seo__block-collapse" id="collapse-languages-seo">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_title">Titre de la page</label>            <input type="text" id="editpageform-seo_title" class="form-control" name="seo_title" value="">        </div>

		
		
		
            <div class="form-group">
            <label class="control-label" for="editpageform-seo_keywords">Mots-clés méta</label> 
				
 
				<textarea id="editpageform-seo_description" class="form-control" name="seo_keywords" rows="5"></textarea>        </div>
    <div class="form-group">
        <div class="form-group">
            <label class="control-label" for="editpageform-seo_description">Méta-description</label>            <textarea id="editpageform-seo_description" class="form-control" name="seo_description" rows="5"></textarea>                </div>
    </div>
</div>                                                                
                       

            <hr>
            <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
         </form>
      </div>
   </div>
</div>
	

<?php endif; ?>
