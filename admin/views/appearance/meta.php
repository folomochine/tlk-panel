<div>
  <div class="panel panel-default">
    <div class="panel-body">
      <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
          <label for="" class="control-label">Titre affiché sur Google</label>
          <input type="text" class="form-control" name="seo" value="<?=$settings["site_seo"]?>">
        </div>
        <div class="form-group">
          <label for="" class="control-label">Titre du site</label>
          <input type="text" class="form-control" name="title" value="<?=$settings["site_title"]?>">
        </div>
        <div class="form-group">
          <label for="" class="control-label">Mots-clés du site</label>
          <input type="text" class="form-control" name="keywords" value="<?=$settings["site_keywords"]?>">
        </div>
        <div class="form-group">
          <label class="control-label">Description du site</label>
          <textarea class="form-control" rows="3" name="description" placeholder=''><?=$settings["site_description"]?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
      </form>
    </div>
  </div>
</div>
