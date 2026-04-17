<div>
  <div class="settings-header__table">
    <button type="button"  class="btn btn-default m-b" data-toggle="modal" data-target="#modalDiv" data-action="new_bankaccount" >Nouveau compte bancaire</button>
  </div>
   <table class="table">
      <thead>
         <tr>
            <th>
              Nom de la banque
            </th>
            <th>
               Nom du bénéficiaire	
            </th>
            <th>
              IBAN
            </th>
            <th></th>
         </tr>
      </thead>
      <tbody class="methods-sortable">
         <?php foreach($bankList as $bank): ?>
           <tr>
            <td>
               <?php echo $bank["bank_name"]; ?>
            </td>
            <td><?php echo $bank["bank_alici"]; ?></td>
            <td><?php echo $bank["bank_iban"]; ?></td>
            <td class="p-r">
               <button type="button" class="btn btn-default btn-xs pull-right edit-payment-method" data-toggle="modal" data-target="#modalDiv" data-action="edit_bankaccount" data-id="<?php echo $bank["id"]; ?>">Modifier</button>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
