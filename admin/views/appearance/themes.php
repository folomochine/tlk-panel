<?php if( !route(3) ): ?>
<div>
<table class="table">
<thead>
<tr>
<th>Thème</th>
<th>Dernière modification</th>
<th></th>
</tr>
</thead>
<tbody>
<?php foreach($themes as $theme): ?>
<tr>
<td> <?php echo $theme["theme_name"]; if( $settings["site_theme"] == $theme["theme_dirname"] ): echo ' <span class="badge">Actif</span>'; endif; ?> 
</td>
<td> <?php echo $theme["last_modified"]; ?>   <?php if( $settings["site_theme"] == $theme["theme_dirname"] ):
 if( $theme["colour"] == "2" && $theme["theme_dirname"] == "Simplify"):
 echo ' 
<div class="dropdown pull-right">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Changer la couleur <span class="caret"></span></button>
<ul class="dropdown-menu">
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<select class="form-control" name="site_theme_alt"><option value="Red" >Rouge</option>
<option value="Blue" >Bleu</option>
<option value="Lime" >Vert citron</option>
<option value="Grapes" >Raisin</option>
<option value="Dark" >Sombre</option>
																		<option value="Cyan" >Cyan</option>
																		<option value="Coral" >Corail</option>
																		<option value="Green" >Vert</option>
																		<option value="Grey" >Gris</option>
																		<option value="Lilac" >Lilas</option>
<option value="Orange">Orange</option>
          </select>
        </div> 
     <center>  
        <button type="submit" class="btn btn-default">Mettre à jour</button></center>
      </form>
				 </ul>';
endif;
if( $theme["colour"] == "2" && $theme["theme_dirname"] == "Eternity"):
echo ' 
<div class="dropdown pull-right">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Changer la couleur <span class="caret"></span></button>
<ul class="dropdown-menu">
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<select class="form-control" name="site_theme_alt">
<option value="lilac" >Eternity Lilas</option>
<option value="coral" >Eternity Corail</option>
<option value="azure" >Eternity Azur</option>
<option value="grey" >Eternity Gris</option>
<option value="lime" >Eternity Vert citron</option>
<option value="navy" >Eternity Bleu marine</option>
<option value="pink" >Eternity Rose</option>
<option value="raspberry" >Eternity Framboise</option>
<option value="cyan" >Eternity Cyan</option>
<option value="purple" >Eternity Violet</option>
</select>
        </div> 
     <center>  
        <button type="submit" class="btn btn-default">Mettre à jour</button></center>
      </form>
				 </ul>';

endif;
if( $theme["colour"] == "2" && $theme["theme_dirname"] == "pitchy"):
echo ' 
<div class="dropdown pull-right">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Changer la couleur <span class="caret"></span></button>
<ul class="dropdown-menu">
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
<select class="form-control" name="site_theme_alt">
<option value="green">Clementine Vert</option>
<option value="parrot">Clementine Perroquet</option>
<option value="orange">Clementine Orange</option>
</select>
        </div> 
     <center>  
        <button type="submit" class="btn btn-default">Mettre à jour</button></center>
      </form>
				 </ul>';
endif;

endif; ?></td>
            <td class="text-right col-md-1">
              <div class="dropdown pull-right">
				  
                <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <?php if( $settings["site_theme"] != $theme["theme_dirname"] ): ?>
                    <li>
                      <a href="<?php echo site_url('admin/appearance/themes/active/'.$theme["id"]) ?>">
                        Activer
                      </a>
                    </li>
                  <?php endif; ?>
                  <li>
                                <a href="<?php echo site_url('admin/appearance/themes/'.$theme["id"]) ?>">
                                    Modifier
                                </a>
                            </li>
                </ul>
              </div>
            </td>
			
         </tr>
          <?php endforeach; ?>
       </tbody>
   </table>

  
<?php elseif( route(3) ):

?>
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-heading edit-theme-title"><strong><?php echo $theme["theme_name"] ?></strong> modifier le thème nommé</div>

        <div class="row">
          <div class="col-md-3 padding-md-right-null">

            <div class="panel-body edit-theme-body">
              <div class="twig-editor-block">
                <?php





                  $layouts  = [
                    "HTML"=>[
"header.twig","footer.twig","account.twig","addfunds.twig","api.twig","child-panels.twig",
                    "login.twig","neworder.twig","open_ticket.twig","orders.twig","refill.twig","signup.twig",
                    "services.twig","tickets.twig","refer.twig","dripfeeds.twig","subscriptions.twig",
                    "resetpassword.twig","setnewpassword.twig","updates.twig","blog.twig","blogpost.twig",
                    "terms.twig","faq.twig"],
                    "CSS"=>["bootstrap.css","style.css"],
                    "JS"=>["bootstrap.js","script.js"]
                  ];
                foreach ($layouts as $style => $layout):
                  echo '<div class="twig-editor-list-title" data-toggle="collapse" href="#folder_'.$style.'"><span class="fas fa-folder-open"></span>'.$style.'</div><ul class="twig-editor-list collapse in" id="folder_'.$style.'">';
                  foreach ($layouts[$style] as $layout) :
                    if( $lyt == $layout ):
                      $active = ' class="active file-modified" ';
                    else:
                      $active = '';
                    endif;
                    echo '
                      <li '. $active .'><a href="'.site_url('admin/appearance/themes/'.$theme["id"]).'?file='.$layout.'">'.$layout.'</a></li>';
                  endforeach;
                  echo '</ul>';
                endforeach;
              ?>
              </div>

            </div>
          </div>
          <div class="col-md-9 padding-md-left-null edit-theme__block-editor">
            <?php if( !$lyt ): ?>
              <div class="panel-body">
                <div class="row">
                   <div class="col-md-12">
                    <div class="theme-edit-block">
                      <div class="alert alert-info" role="alert">
                       Sélectionnez un fichier dans la barre latérale gauche pour commencer l'édition.
                      </div>
                    </div>
                  </div>
                  </div>
              </div>
            <?php else: ?>
                  
                  <div id="fullscreen">

               <div class="panel-body">

                <?php
                $file = fopen($fn, "r");
                $size = filesize($fn);
                $text = fread($file, $size);
                $text = str_replace("<","&lt;",$text);
                $text = str_replace(">","&gt;",$text);
                $text = str_replace('"',"&quot;",$text);
                fclose($file);
                ?>

                <div class="row">
                    <div class="col-md-8">
                      <strong class="edit-theme-filename"><?=$dir."/".$lyt?></strong>
                        </div>
                        <div class="col-md-4 text-right">
                                    <a class="btn btn-xs btn-default fullScreenButton">
                                        <span class="fas fa-expand"></span>
                                        Modifier en plein écran </a>
                                </div>
                  </div>
           

                <form action="<?php echo site_url("admin/appearance/themes/".$theme["id"]."?file=".$lyt) ?>" method="post" class="twig-editor__form">
                  <textarea id="code" name="code" class="codemirror-textarea"><?=$text;?></textarea>
                  <div class="edit-theme-body-buttons text-right">
                      
                    <button class="btn btn-primary click">Enregistrer</button>
                  </div>
                </form>

              </div>
            <?php endif; ?>
          </div>
        </div>

    </div>
  </div>


<?php endif; ?>









    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
      <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
