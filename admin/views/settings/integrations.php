<div>
<?php if($active){ ?>
   <div class="settings-emails__block">
      <div class="settings-emails__block-title">
         Actif
      </div>
      <div class="settings-emails__block-body">
         <table>
            <thead>
               <tr>
                  <th></th>
                  <th class="settings-emails__th-name"></th>
                  <th class="settings-emails__th-actions"></th>
               </tr>
            </thead>
            <tbody>
              <?php foreach( $active as $int ){ ?>
               <tr class="settings-emails__row settings-emails__row">
                  <td class="settings-emails__row-img">
                     <img src="<?=$int['icon_url']?>" alt="<?=$int['name']?>">
                  </td>
                  <td>
                     <div class="settings-emails__row-name">
                       <?=$int['name']?>
                     </div>
                     <div class="settings-emails__row-description">
                       <?=$int['description']?>
                     </div>
                  </td>
                  <td class="settings-emails__td-actions">
                  <?php if($int["id"] == 13){ ?>
                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_google">Modifier</button>
                 <?php }elseif($int["id"] == 14){ ?>
                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_seo">Modifier</button>
                 <?php }else{ ?>
                 
                  <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="edit_code" data-id="<?=$int['id']?>">Modifier</button>
                 <?php } ?>
                  </td>
               </tr>
              <?php } ?>
            </tbody>
         </table>
      </div>
    </div>
              <?php } ?>

<?php if($other){ ?>
<div class="settings-emails__block">
      <div class="settings-emails__block-title">
         Autre
      </div>
      <div class="settings-emails__block-body">
         <table>
            <thead>
               <tr>
                  <th></th>
                  <th class="settings-emails__th-name"></th>
                  <th class="settings-emails__th-actions"></th>
               </tr>
            </thead>
            <tbody>
              <?php foreach( $other as $int ){ ?>
               <tr class="settings-emails__row settings-emails__row-disable">
                  <td class="settings-emails__row-img">
                     <img src="<?=$int['icon_url']?>" alt="<?=$int['name']?>">
                  </td>
                  <td>
                     <div class="settings-emails__row-name">
                        <?=$int['name']?>
                     </div>
                     <div class="settings-emails__row-description">
                        <?=$int['description']?>
                     </div>
                  </td>
                  <td class="settings-emails__td-actions">
                     <a class="btn btn-xs btn-default activate-integration" href="/admin/settings/integrations/enabled/<?=$int['id']?>">
                       Activer
                     </a>
                  </td>
               </tr>
              <?php } ?>
            </tbody>
         </table>
      </div>
    </div>
<?php } ?>


   </div>
