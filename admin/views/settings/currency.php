<div>
	<div class="settings-header__table">
		<button type="button" class="btn btn-default m-b" data-toggle="modal" data-target="#modalDiv" data-action="add_currency">Ajouter une devise</button>
	</div>
	<div class="col-md-12">
   <table class="table report-table" style="border:1px solid var(--border)">
      <thead>
         <tr>
            <th>Nom de la devise</th>
            <th>Symbole</th>
   <th>Taux de change</th>
   <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($currencies as $currencie): ?>
         <tr class="<?php if( $currencie["status"] == 2 ): echo "grey "; endif; ?>" data-toggle="<?php echo $currencie["id"]; ?>" data-id="<?php echo $currencie["id"]; ?>">
            <td> <?php echo $currencie["name"];  ?></td>
<td> <?php echo $currencie["symbol"]; ?></td>
<td> <?php echo $currencie["value"]; ?></td>
            <td class="text-right col-md-1">
              <div class="dropdown pull-right">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li>
                <a  data-toggle="modal" data-target="#modalDiv" data-action="edit_currency" data-id="<?= $currencie["id"] ?>">Modifier</a>
					
                  </li>

                    <li>
                      <a href="<?php echo site_url('admin/settings/currency/delete/'.$currencie["id"]) ?>">
                        Supprimer
                      </a>
                    </li>
</td>
                  
                </ul>
              </div>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
