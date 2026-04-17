<?php include 'header.php'; ?>

<div class="container-fluid">

        <div class="row row-xs">

            <div class="col">
                <div class="card dwd-100">
                    <div class="card-body pd-20 table-responsive dof-inherit">

                        <div class="container-fluid">
                            <ul class="nav nav-tabs mg-b-20 dborder-0">
                                <li class="<?php if( $status == "all"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds")?>" class="btn btn-outline-light mg-r-5">Tout</a></li>
                                <li class="<?php if( $status == "active"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/active")?>" class="btn btn-outline-light mg-r-5">Actif</a></li>
                                <li class="<?php if( $status == "completed"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/completed")?>" class="btn btn-outline-light mg-r-5">Termine</a></li>
                                <li class="<?php if( $status == "canceled"): echo "active"; endif; ?>"><a href="<?=site_url("admin/dripfeeds/1/canceled")?>" class="btn btn-outline-light mg-r-5">Annule</a></li>
                                 <li class="pull-right custom-search">
         <form class="form-inline" action="<?=site_url("admin/dripfeeds")?>" method="get">
            <div class="input-group">
               <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Rechercher">
               <span class="input-group-btn search-select-wrap">
                  <select class="form-control search-select" name="search_type">
                     <option value="order_id" <?php if( $search_where == "order_id" ): echo 'selected'; endif; ?> >ID Commande</option>
                     <option value="order_url" <?php if( $search_where == "order_url" ): echo 'selected'; endif; ?> >Lien</option>
                     <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Nom d'utilisateur</option>
                  </select>
                  <button type="submit" class="btn btn-default"><span class="fas fa-search" aria-hidden="true"></span></button>
               </span>
            </div>
         </form>
      </li>
   </ul>

        <div class="table-responsive">
                            <table class="table" id="dt">
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
                                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Actions groupées</button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <?php if( $status  ==  "active" ): ?>
                                                                    <a class="bulkorder" data-type="completed">Terminer tout</a>
                                                                    <a class="bulkorder" data-type="canceled">Annuler tout</a>
                                                                    <a class="bulkorder" data-type="canceledbalance">Rembourser tout</a>
                                                                    <?php endif; ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Utilisateur</th>
                                        <th>Montant</th>
                                        <th>Lien</th>
                                        <th>Quantite</th>
                                        <th class="dropdown-th">
                                            Service
                                        </th>
                                        <th>Type</th>
                                        <th>Intervalle</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <form id="changebulkForm" action="<?php echo site_url("admin/dripfeeds/multi-action") ?>" method="post">
                                    <tbody>
                                        <?php foreach( $orders as $order ): ?>
                                        <tr>
                                            <td><input type="checkbox" <?php if( $status == "all" || $status == "canceled" ): echo "class=\"dborder-1-solid\" disabled"; else: echo 'class="selectOrder dborder-1-solid"'; endif; ?> name="order[<?php echo $order["order_id"] ?>]" value="1"></td>
                                            <td class="p-l"><?php echo $order["order_id"] ?></td>
                                            <td><?php echo $order["username"] ?></td>
                                            <td><?php echo $order["dripfeed_totalcharges"] ?></td>
                                            <td><?php echo $order["order_url"]; ?></td>
                                            <td><?php echo $order["order_quantity"]; ?></td>
                                            <td><?php echo $order["service_name"]; ?></td>
                                            <td><?php echo "<a href='".site_url("admin/orders?dripfeed=".$order["order_id"])."'>".$order["dripfeed_delivery"]."</a>/".$order["dripfeed_runs"]; ?></td>
                                            <td><?php echo $order["dripfeed_interval"]; ?></td>
                                            <td><?php echo $order["dripfeed_totalquantity"]; ?></td>
                                            <td><?php echo date("d.m.Y H:i:s", strtotime($order["order_create"])); ?></td>
                                            <td><?php echo orderStatu($order["dripfeed_status"]); ?></td>
                                            <td class="service-block__action">
                                                <?php if( $order["dripfeed_status"] == "active" ): ?>
                                                <div class="dropdown pull-right">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_canceled/".$order["order_id"])?>">Annuler</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_completed/".$order["order_id"])?>">Terminer</a></li>
                                                        <li><a href="#" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/dripfeeds/dripfeed_canceledbalance/".$order["order_id"])?>">Annuler et rembourser</a></li>
                                                    </ul>
                                                </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
                                </form>
                            </table></div>
                        </div>
                        <div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-center" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <h4>Etes-vous sur de vouloir mettre a jour ?</h4>
                                        <div align="center">
                                            <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php include 'footer.php'; ?>

<script src="/assets/js/datatable/drip.js"></script>
