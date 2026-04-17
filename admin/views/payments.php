<?php include 'header.php'; ?>
<div class="container-fluid">
            <?php if( $success ): ?>
          <div class="alert alert-success "><?php echo $successText; ?></div>
        <?php endif; ?>
           <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
   <ul class="nav nav-tabs">
        <li class="p-b">
         <button class="btn btn-default" data-toggle="modal" data-target="#modalDiv" data-action="payment_new">
         <span class="export-title">Ajouter/Retirer Solde</span>
         </button>
      </li>
      
      <li class="pull-right custom-search">
         <form class="form-inline" action="<?php echo site_url("admin/payments/online") ?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Rechercher...">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Nom d'utilisateur</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fas fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
      
   </ul>
<div style="overflow-x:scroll">
   <table class="table payments-table">
      <thead>
         <tr>
            <th class="p-l">ID</th>
           <th>Utilisateur</th>
             <th>Solde</th>
             <th>Montant</th>
             <th>Statut</th>
             <th>Details</th>
             <th>Date</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" action="<?php echo site_url("admin/payments/online/multi-action") ?>" method="post">
        <tbody>
          <?php foreach($payments as $payment ): ?>
              <tr>
                 <td class="p-l"><?php echo $payment["payment_id"] ?></td>
                 <td><span class="label-id"><?php echo $payment["client_id"] ?></span><?php echo $payment["username"] ?></td>
                 <td><?php echo $payment["client_balance"] ?></td>
                 <td><?php
                     $displayAmount = $payment["payment_amount"];
                     if (isset($payment["gateway_method_id"]) && intval($payment["gateway_method_id"]) === 21) {
                         $orangeMoneyBreakdown = get_orange_money_payment_breakdown($payment, [
                             "methodFee" => $payment["gateway_method_fee"],
                             "methodCurrency" => $payment["gateway_method_currency"]
                         ], $currencies_array, $settings);
                         $displayAmount = format_amount_string_exact($payment["gateway_method_currency"], $orangeMoneyBreakdown["input_amount"]) . '<br><small>' . format_amount_string_exact($settings["site_base_currency"], $orangeMoneyBreakdown["credited_base_amount"]) . '</small>';
                     }
                     echo $displayAmount;
                 ?></td>
                 <td>
 				  
 			<?php if( $payment['payment_status'] == 1 ): ?>
 					 En attente
 					 
 					 <?php endif; ?>
 			<?php if( $payment['payment_status'] == 2 ): ?>
 <strong class="tl-status-rejected">Echoue</strong>
 <?php endif; ?>
 <?php if( $payment['payment_status'] == 3 ): ?>
 <strong class="tl-status-active">Termine</strong>
 <?php endif; ?>
 </td>
 <td style="width:30%"><?php echo $payment["method_name"] ?> - <?php if( $payment["payment_mode"] == "Auto" ): ?>Automatique
 <?php else: ?>
 Manuel<?php endif; ?><br>ID Commande :<?php echo $payment["payment_extra"] ?> <br>Note speciale : <?php echo $payment["payment_note"] ?></td>
 				  
 				  
 				 
 				  
                 <td><?php echo $payment["payment_create_date"] ?></td>
 				  
 				  
 				  
                 <td class="service-block__action">
                   <div class="dropdown pull-right">
                     <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Actions <span class="caret"></span></button>
                     <ul class="dropdown-menu">
                     <?php if( $payment["payment_mode"] == "Auto" ): ?>
                       <li><a href="#"  data-toggle="modal" data-target="#modalDiv" data-action="payment_detail" data-id="<?php echo $payment["payment_id"] ?>">Details du paiement</a></li>
                     <?php endif; ?>
                       
 					 
                     </ul>
                   </div>
                 </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table></div>
   <?php if( $paginationArr["count"] > 1 ): ?>
     <div class="row">
        <div class="col-sm-8">
           <nav>
              <ul class="pagination">
                <?php if( $paginationArr["current"] != 1 ): ?>
                  <li class="prev"><a href="<?php echo site_url("admin/payments/online/1".$search_link) ?>">&laquo;</a></li>
                 <li class="prev"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["previous"].$search_link) ?>">&lsaquo;</a></li>
                 <?php
                     endif;
                     for ($page=1; $page<=$pageCount; $page++):
                       if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                 ?>
                 <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/payments/online/".$page.$search_link) ?>"><?=$page?></a></li>
                 <?php endif; endfor;
                       if( $paginationArr["current"] != $paginationArr["count"] ):
                 ?>
                 <li class="next"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["next"].$search_link) ?>" data-page="1">&rsaquo;</a></li>
                 <li class="next"><a href="<?php echo site_url("admin/payments/online/".$paginationArr["next"].$search_link) ?>" data-page="1">&raquo;</a></li>
                 <?php endif; ?>
              </ul>
           </nav>
        </div>
     </div>
   <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
