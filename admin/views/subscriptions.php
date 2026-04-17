<?php include 'header.php'; ?>
<div class="container-fluid">
   <ul class="nav nav-tabs">
      <li class="<?php if( $status == "all"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions")?>">Tout</a></li>
      <li class="<?php if( $status == "active"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/active")?>">Actif</a></li>
      <li class="<?php if( $status == "paused"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/paused")?>">En pause</a></li>
      <li class="<?php if( $status == "completed"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/completed")?>">Termine</a></li>
      <li class="<?php if( $status == "canceled"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/canceled")?>">Annule</a></li>
      <li class="<?php if( $status == "expired"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/expired")?>">Expire</a></li>
      <li class="<?php if( $status == "limit"): echo "active"; endif; ?>"><a href="<?=site_url("admin/subscriptions/1/limit")?>">Abonnement limite</a></li>
      <li class="pull-right custom-search">
         <form class="form-inline" action="<?=site_url("admin/subscriptions")?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Rechercher">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="order_id" <?php if( $search_where == "order_id" ): echo 'selected'; endif; ?> >ID</option>
                     <option value="order_url" <?php if( $search_where == "order_url" ): echo 'selected'; endif; ?> >Lien</option>
                     <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Nom d'utilisateur</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fas fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
   </ul>
<div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">
                        <div class="container-fluid pd-t-20 pd-b-20">
                            <ul class="nav nav-tabs pull-right dborder-0">
                                <li class="pull-right export-li">
                                    
                                </li>
                            </ul>
   <table class="table">
      <thead>
         <tr>
            <th class="checkAll-th">
               <div class="checkAll-holder">
                  <input type="checkbox" id="checkAll">
                  <input type="hidden" id="checkAllText" value="order">
               </div>
               <div class="action-block">
                  <ul class="action-list">
                     <li><span class="countOrders"></span> commandes sélectionnées</li>
                      <li>
                         <div class="dropdown">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Opérations groupées<span class="caret"></span></button>
                           <ul class="dropdown-menu">
                              <li>
                                 <?php if( $status  ==  "active" ): ?>
                                 <a class="bulkorder" data-type="paused">Tout mettre en pause</a>
                                 <?php endif; ?>
                                 <?php if( $status  ==  "active" || $status  ==  "paused" ): ?>
                                 <a class="bulkorder" data-type="completed">Tout terminer</a>
                                 <?php endif; ?>
                                 <?php if( $status  ==  "active" || $status  ==  "paused" ): ?>
                                 <a class="bulkorder" data-type="canceled">Tout annuler</a>
                                 <?php endif; ?>
                                 <?php if( $status  ==  "expired" || $status  ==  "paused" || $status  ==  "canceled" ): ?>
                                 <a class="bulkorder" data-type="active">Tout activer</a>
                                 <?php endif; ?>
                              </li>
                           </ul>
                        </div>
                     </li>
                  </ul>
               </div>
            </th>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Lien</th>
            <th>Montant</th>
            <th>Publications</th>
            <th>Delai</th>
            <th class="dropdown-th">
              Service
            </th>
            <th>Statut</th>
            <th>Date de creation</th>
            <th>Derniere mise a jour</th>
            <th>Date de fin</th>
            <th></th>
         </tr>
      </thead>
      <form id="changebulkForm" action="<?php echo site_url("admin/subscriptions/multi-action") ?>" method="post">
        <tbody>
          <?php foreach( $orders as $order ): ?>
              <tr>
                 <td><input type="checkbox" <?php if( $status == "all" || $status == "canceled" ): echo "disabled"; else: echo 'class="selectOrder"'; endif; ?> name="order[<?php echo $order["order_id"] ?>]" value="1" style="border:1px solid var(--border)"></td>
                 <td class="p-l"><?php echo $order["order_id"] ?></td>
                 <td><?php echo $order["username"] ?></td>
                 <td><?php echo $order["order_url"]; ?></td>
                 <td><?php echo $order["subscriptions_min"]."-".$order["subscriptions_max"]; ?></td>
                 <td><?php echo "<a href='".site_url("admin/orders?subscription=".$order["order_id"])."'>".$order["subscriptions_delivery"]."</a>/".$order["subscriptions_posts"]; ?></td>
                 <td><?php if( $order["subscriptions_delay"] == 0 ): echo "Pas de delai"; else: echo $order["subscriptions_delay"]/60; echo " minutes"; endif; ?></td>
                 <td><?php echo $order["service_name"]; ?></td>
                 <td><?php echo orderStatu($order["subscriptions_status"]); ?></td>
                 <td><?php echo date("d.m.Y H:i:s", strtotime($order["order_create"])); ?></td>
                 <td><?php echo date("d.m.Y H:i:s", strtotime($order["last_check"])); ?></td>
                 <td><?php if( $order["subscriptions_expiry"] != "1970-01-01" ): echo date("d.m.Y", strtotime($order["subscriptions_expiry"])); endif; ?></td>
                 <td class="service-block__action">
                   <div class="dropdown pull-right">
                     <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options<span class="caret"></span></button>
                     <ul class="dropdown-menu">
                       <?php if( $order["subscriptions_status"] == "active" || $order["subscriptions_status"] == "paused" ): ?>
                         <li><a href="#"  data-toggle="modal" data-target="#subsDiv" data-action="subscriptions_expiry" data-subs="1" data-id="<?php echo $order["order_id"] ?>">Definir la date de fin</a></li>
                       <?php endif; ?>
                       <?php if( $order["subscriptions_status"] == "active" ): ?>
                         <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/subscriptions/subscriptions_pause/".$order["order_id"])?>">Mettre en pause</a></li>
                       <?php endif; ?>
                       <?php if( $order["subscriptions_status"] == "paused" || $order["subscriptions_status"] == "active" ): ?>
                         <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/subscriptions/subscriptions_complete/".$order["order_id"])?>">Terminer l'abonnement</a></li>
                       <?php endif; ?>
                       <?php if( $order["subscriptions_status"] == "paused" || $order["subscriptions_status"] == "expired" || $order["subscriptions_status"] == "canceled" ): ?>
                         <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/subscriptions/subscriptions_active/".$order["order_id"])?>">Activer l'abonnement</a></li>
                       <?php endif; ?>
                       <?php if( $order["subscriptions_status"] == "paused" || $order["subscriptions_status"] == "active" ): ?>
                         <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/subscriptions/subscriptions_canceled/".$order["order_id"])?>">Annuler l'abonnement</a></li>
                       <?php endif; ?>
                     </ul>
                   </div>
                 </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
   </table>
   <?php if( $paginationArr["count"] > 1 ): ?>
     <div class="row">
        <div class="col-sm-8">
           <nav>
              <ul class="pagination">
                <?php if( $paginationArr["current"] != 1 ): ?>
                 <li class="prev"><a href="<?php echo site_url("admin/subscriptions/1/".$status.$search_link) ?>">&laquo;</a></li>
                 <li class="prev"><a href="<?php echo site_url("admin/subscriptions/".$paginationArr["previous"]."/".$status.$search_link) ?>">&lsaquo;</a></li>
                 <?php
                     endif;
                     for ($page=1; $page<=$pageCount; $page++):
                       if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                 ?>
                 <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/subscriptions/".$page."/".$status.$search_link) ?>"><?=$page?></a></li>
                 <?php endif; endfor;
                       if( $paginationArr["current"] != $paginationArr["count"] ):
                 ?>
                 <li class="next"><a href="<?php echo site_url("admin/subscriptions/".$paginationArr["next"]."/".$status.$search_link) ?>" data-page="1">&rsaquo;</a></li>
                 <li class="next"><a href="<?php echo site_url("admin/subscriptions/".$paginationArr["count"]."/".$status.$search_link) ?>" data-page="1">&raquo;</a></li>
                 <?php endif; ?>
              </ul>
           </nav>
        </div>
     </div>
   <?php endif; ?>
</div>
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <h4>Etes-vous sur de vouloir mettre a jour le statut ?</h4>
            <div align="center">
               <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
               <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'footer.php'; ?>
