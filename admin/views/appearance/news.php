<div>

<ul class="nav nav-tabs">
    <li class="p-b">
<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalDiv" data-action="new_news">Ajouter une annonce</button>        
 </li>
  </ul>
<div style="overflow-x:scroll;">
   <table class="table report-table">
      <thead>
         <tr>
            <th><div style="float:left;">Icône de l'annonce</div></th>
            <th>Titre de l'annonce</th>
            <th>Date de l'annonce</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($newsList as $new): ?>
         <tr>
<td><div style="float:left;"><img src="<?php echo GET_IMAGE_URL_BY_ID($new["news_icon"]);?>" width="32" height="32"></div></td>
     <td><?=$new["news_title"]?></td>
 
  <td><?=$new["news_date"]?></td>
  
            <td class="text-right col-md-1">
              <div class="dropdown pull-right">
             
<button type="button" class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalDiv" data-action="edit_news" data-id="<?=$new['id']?>">Modifier</button>         

</div>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table></div>
</div>
