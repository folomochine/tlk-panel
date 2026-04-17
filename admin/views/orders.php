<?php include 'header.php'; ?>
<style>
.od-wrap{padding:20px}
.od-header{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}
.od-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.od-title i{color:var(--primary);font-size:18px}
.od-filters{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;align-items:center}
.od-f{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:12px;font-weight:600;text-decoration:none!important;transition:.2s;white-space:nowrap}
.od-f:hover{border-color:var(--primary);color:var(--primary)}
.od-f.active{background:var(--primary);color:#fff;border-color:var(--primary)}
.od-f .badge{font-size:10px;padding:2px 6px;border-radius:6px;margin-left:3px;background:rgba(255,255,255,.2)}
.od-f.active .badge{background:rgba(255,255,255,.25)}
.od-f-fail.active{background:#dc2626;border-color:#dc2626}
.od-search{display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;margin-left:auto}
.od-search input{padding:7px 12px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:12px;outline:none;min-width:160px}
.od-search input:focus{border-color:var(--primary)}
.od-search select{padding:7px 10px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:11px;outline:none}
.od-search button{padding:7px 14px;background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:12px;cursor:pointer}
.od-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;background:var(--card);border:1px solid var(--border);border-radius:12px;margin-bottom:16px}
.od-table{width:100%;border-collapse:collapse;font-size:12px}
.od-table thead th{padding:10px 12px;text-align:left;font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
.od-table tbody td{padding:8px 12px;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--text)}
.od-table tbody tr:last-child td{border-bottom:none}
.od-table tbody tr:hover{background:var(--primary-g)}
.od-charge{font-weight:600;white-space:nowrap}
.od-profit{color:#22c55e;font-weight:600;white-space:nowrap}
.od-link{max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;color:var(--muted);font-size:11px}
.od-link:hover{color:var(--primary)}
.od-svc{font-size:11px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.od-svc-id{background:rgba(59,130,246,.08);color:var(--primary);padding:1px 5px;border-radius:4px;font-size:10px;font-weight:700;margin-right:4px}
.od-date{font-size:10px;color:var(--muted);white-space:nowrap}
.od-mode{font-size:10px;padding:3px 8px;border-radius:6px;font-weight:600}
.od-mode-manual{background:rgba(217,119,6,.1);color:#d97706}
.od-mode-auto{background:rgba(8,145,178,.1);color:#0891b2}
.od-action{padding:4px 10px;background:var(--card);border:1px solid var(--border);border-radius:6px;font-size:11px;font-weight:600;cursor:pointer;color:var(--muted);transition:.2s}
.od-action:hover{border-color:var(--primary);color:var(--primary)}
.od-bulk{display:flex;align-items:center;gap:8px;padding:8px 14px;background:var(--card);border:1px solid var(--border);border-radius:10px;margin-bottom:12px;font-size:12px;color:var(--muted)}
.od-pagination{display:flex;justify-content:center;padding:14px 0;gap:4px;flex-wrap:wrap}
.od-pagination a{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;padding:0 6px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:11px;font-weight:600;text-decoration:none;transition:.2s}
.od-pagination a:hover{border-color:var(--primary);color:var(--primary)}
.od-pagination a.pg-active{background:var(--primary);color:#fff;border-color:var(--primary)}
.od-counter{font-size:11px;color:var(--muted);text-align:center;padding:4px 0}
/* Fix "Options" dropdown clipping when few orders are listed */
.od-wrap,
.od-table-wrap,
.od-table,
.od-table tbody,
.od-table tr,
.od-table td,
.od-table th{overflow:visible!important}
.od-table-wrap{overflow-x:auto!important;overflow-y:visible!important}
.od-wrap .dropdown{position:relative}
.od-wrap .dropdown.open{z-index:2000}
.od-wrap .dropdown-menu{
  z-index:2000!important;
  min-width:220px;
  right:0;left:auto;
  margin-top:6px!important;
  padding:6px 0!important;
  border-radius:12px!important;
  border:1px solid var(--border,#e2e8f0)!important;
  background:var(--card,#fff)!important;
  box-shadow:0 18px 40px rgba(15,23,42,.18)!important;
}
.od-wrap .dropdown-menu > li > a{
  padding:9px 14px!important;font-size:13px!important;
  color:var(--text,#0f172a)!important;border-radius:0!important;
  transition:background .15s ease,color .15s ease;
}
.od-wrap .dropdown-menu > li > a:hover{
  background:rgba(99,102,241,.10)!important;color:#4f46e5!important;
}
body.dark-mode .od-wrap .dropdown-menu > li > a:hover{color:#a5b4fc!important}
.od-wrap .dropdown.dropdown-submenu{position:relative}
.od-wrap .dropdown-submenu > .dropdown-menu{
  top:0;left:100%;margin-left:4px;margin-top:0!important;
}
@media(max-width:768px){.od-filters{gap:4px}.od-f{padding:5px 8px;font-size:11px}.od-search{width:100%}.od-search input{flex:1}}
</style>

<div class="od-wrap">
  <div class="od-header">
    <div class="od-title"><i class="fas fa-shopping-bag"></i> Commandes</div>
  </div>

  <?php if($success): ?><div class="alert alert-success"><?=$successText?></div><?php endif; ?>
  <?php if($error): ?><div class="alert alert-danger"><?=$errorText?></div><?php endif; ?>

  <!-- Filters + Search -->
  <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-start;margin-bottom:16px">
    <div class="od-filters" style="margin-bottom:0;flex:1">
      <a class="od-f <?php if($status=="all") echo 'active'; ?>" href="<?=site_url("admin/orders")?>">Toutes <span class="badge"><?=countRow(["table"=>"orders"])?></span></a>
      <a class="od-f <?php if($status=="cronpending") echo 'active'; ?>" href="<?=site_url("admin/orders/1/cronpending")?>">En attente <span class="badge"><?php if($cronpendingcount) echo $cronpendingcount; ?></span></a>
      <a class="od-f <?php if($status=="pending") echo 'active'; ?>" href="<?=site_url("admin/orders/1/pending")?>">En attente <span class="badge"><?php if($pendingcount) echo $pendingcount; ?></span></a>
      <a class="od-f <?php if($status=="processing") echo 'active'; ?>" href="<?=site_url("admin/orders/1/processing")?>">Traitement <span class="badge"><?php if($processingcount) echo $processingcount; ?></span></a>
      <a class="od-f <?php if($status=="inprogress") echo 'active'; ?>" href="<?=site_url("admin/orders/1/inprogress")?>">En cours <span class="badge"><?php if($inprogresscount) echo $inprogresscount; ?></span></a>
      <a class="od-f <?php if($status=="completed") echo 'active'; ?>" href="<?=site_url("admin/orders/1/completed")?>">Termin&eacute;es <span class="badge"><?php if($completedcount) echo $completedcount; ?></span></a>
      <a class="od-f <?php if($status=="partial") echo 'active'; ?>" href="<?=site_url("admin/orders/1/partial")?>">Partielles <span class="badge"><?php if($partialcount) echo $partialcount; ?></span></a>
      <a class="od-f <?php if($status=="canceled") echo 'active'; ?>" href="<?=site_url("admin/orders/1/canceled")?>">Annul&eacute;es <span class="badge"><?php if($canceledcount) echo $canceledcount; ?></span></a>
      <a class="od-f od-f-fail <?php if($status=="fail") echo 'active'; ?>" href="<?=site_url("admin/orders/1/fail")?>">&Eacute;chec <span class="badge"><?php if($failCount) echo $failCount; ?></span></a>
    </div>
    <form class="od-search" action="<?=site_url("admin/orders")?>" method="get" style="margin-bottom:0">
      <input type="text" name="search" value="<?=$search_word?>" placeholder="Rechercher...">
      <select name="search_type">
        <option value="order_id" <?php if($search_where=="order_id") echo 'selected'; ?>>ID commande</option>
        <option value="order_url" <?php if($search_where=="order_url") echo 'selected'; ?>>URL</option>
        <option value="username" <?php if($search_where=="username") echo 'selected'; ?>>Utilisateur</option>
      </select>
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>
  </div>

  <!-- Table -->
  <div class="od-table-wrap">
    <table class="od-table" id="dt">
      <thead>
        <tr>
          <th class="checkAll-th" style="width:30px">
            <div class="checkAll-holder"><input type="checkbox" id="checkAll"><input type="hidden" id="checkAllText" value="order"></div>
            <div class="action-block">
              <ul class="action-list">
                <li><span class="countOrders"></span> s&eacute;lectionn&eacute;es</li>
                <li>
                  <div class="dropdown">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Actions <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <?php if($status=="fail"): ?><li><a class="bulkorder" data-type="resend">Renvoyer</a></li><?php endif; ?>
                      <li><a class="bulkorder" data-type="pending">En attente</a></li>
                      <li><a class="bulkorder" data-type="inprogress">En cours</a></li>
                      <li><a class="bulkorder" data-type="completed">Termin&eacute;e</a></li>
                      <li><a class="bulkorder" data-type="canceled">Annuler &amp; rembourser</a></li>
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
          </th>
          <th>ID</th>
          <th>Utilisateur</th>
          <th>Montant</th>
          <th>Profit</th>
          <th>Lien</th>
          <th>Fournisseur</th>
          <th>D&eacute;but</th>
          <th>Qt&eacute;</th>
          <th>
            <div class="dropdown">
              <button class="btn btn-default btn-xs dropdown-toggle" data-active="<?=$_GET["service_id"]?>" type="button" id="serviceList" data-href="admin/orders/counter" data-toggle="dropdown">Service <span class="caret"></span></button>
              <ul class="dropdown-menu" id="serviceListContent" style="max-height:275px;overflow-y:auto"></ul>
            </div>
          </th>
          <th>Statut</th>
          <th>Reste</th>
          <th>Date</th>
          <th>
            <div class="dropdown">
              <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Mode <span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li class="<?php if(!$_GET["mode"]) echo 'active'; ?>"><a href="<?=site_url("admin/orders/1/".$status)?>">Tous</a></li>
                <li class="<?php if($_GET["mode"]=="manuel") echo 'active'; ?>"><a href="<?=site_url("admin/orders/1/".$status)?>?mode=manuel">Manuel</a></li>
                <li class="<?php if($_GET["mode"]=="auto") echo 'active'; ?>"><a href="<?=site_url("admin/orders/1/".$status)?>?mode=auto">API</a></li>
              </ul>
            </div>
          </th>
          <th></th>
        </tr>
      </thead>
      <form id="changebulkForm" action="<?=site_url("admin/orders/multi-action")?>" method="post">
        <tbody>
          <?php foreach($orders as $order): ?>
          <tr>
            <td><input type="checkbox" class="selectOrder" name="order[<?=$order["order_id"]?>]" value="1"></td>
            <td>
              <strong><?=$order["order_id"]?></strong>
              <?php if($order["api_orderid"]!=0): echo '<div class="label label-api">'.$order["api_orderid"].'</div>'; endif; ?>
            </td>
            <td><?=$order["username"]?><?php if($order["order_where"]=="api"): echo ' <span class="label label-api">API</span>'; endif; ?></td>
            <td><span class="od-charge"><?=format_amount_string($settings["site_base_currency"],$order["order_charge"])?></span>
              <?php if($order["service_api"]!=0): echo '<div style="font-size:10px;color:var(--muted)">'.format_amount_string($settings["site_base_currency"],$order["api_charge"]).'</div>'; endif; ?>
            </td>
            <td><span class="od-profit"><?=format_amount_string($settings["site_base_currency"],$order["order_profit"])?></span></td>
            <td>
              <a class="od-link" href="https://href.li/<?=$order["order_url"]?>" target="_blank" title="<?=htmlspecialchars($order["order_url"])?>"><?=$order["order_url"]?></a>
              <?php if(!empty($order["order_extras"]) && $order["order_extras"]!="[]"): ?>
                <a href="#" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalDiv" data-action="order_comment" data-id="<?=$order["order_id"]?>">Commentaires</a>
              <?php endif; ?>
            </td>
            <td style="font-size:11px"><?=GET_API_NAME_BY_ID($order["order_api"])?></td>
            <td><?=$order["order_start"]?></td>
            <td><?=$order["order_quantity"]?></td>
            <td><span class="od-svc"><span class="od-svc-id"><?=$order["service_id"]?></span><?=$order["service_name"]?></span></td>
            <td><?=orderStatu($order["order_status"],$order["order_error"],$order["order_detail"])?></td>
            <td><?php if($order["order_status"]=="completed" && substr($order["order_remains"],0,1)=="-"): echo "+".substr($order["order_remains"],1); else: echo $order["order_remains"]; endif; ?></td>
            <td><span class="od-date"><?=$order["order_create"]?></span></td>
            <td><span class="od-mode <?php echo $order["api_service"]==0?'od-mode-manual':'od-mode-auto'; ?>"><?php echo $order["api_service"]==0?'Manuel':'API'; ?></span></td>
            <td>
              <div class="dropdown pull-right">
                <button type="button" class="od-action dropdown-toggle" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <?php if($order["order_error"]!="-" && $order["service_api"]!=0): ?>
                    <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="order_errors" data-id="<?=$order["order_id"]?>"><i class="fas fa-exclamation-triangle"></i> Erreurs</a></li>
                    <li><a href="<?=site_url("admin/orders/order_resend/".$order["order_id"])?>"><i class="fas fa-redo"></i> Renvoyer</a></li>
                  <?php endif; ?>
                  <?php if($order["order_error"]=="-" && $order["service_api"]!=0): ?>
                    <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="order_details" data-id="<?=$order["order_id"]?>"><i class="fas fa-info-circle"></i> D&eacute;tails</a></li>
                  <?php endif; ?>
                  <?php if($order["service_api"]==0 || $order["order_error"]!="-"): ?>
                    <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="order_orderurl" data-id="<?=$order["order_id"]?>"><i class="fas fa-link"></i> Modifier URL</a></li>
                  <?php endif; ?>
                  <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="order_startcount" data-id="<?=$order["order_id"]?>"><i class="fas fa-play"></i> Modifier d&eacute;but</a></li>
                  <?php if($order["order_status"]!="partial"): ?>
                    <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="order_partial" data-id="<?=$order["order_id"]?>"><i class="fas fa-adjust"></i> Marquer partielle</a></li>
                  <?php endif; ?>
                  <?php if($order["refill"]=="0" || $order["refill"]=="2" || $order["status_order"]=="Completed"): ?>
                    <li><a class="tl-confirm" data-title="Activer le rechargement" data-message="Le rechargement automatique sera activé pour la commande #<?=$order["order_id"]?>." data-confirm-label="Activer" href="<?=site_url("admin/orders/order_refill_activate/".$order["order_id"])?>"><i class="fas fa-sync"></i> Activer recharge</a></li>
                  <?php endif; ?>
                  <li class="dropdown dropdown-submenu">
                    <a href="#" class="dropdown_menu"><i class="fas fa-exchange-alt"></i> Changer statut</a>
                    <ul class="dropdown-menu submenu_drop">
                      <?php if($order["order_status"]=="pending" || $order["order_status"]=="completed" || $order["order_status"]=="processing" || $order["order_status"]=="partial" || $order["order_status"]=="fail"): ?>
                        <li><a class="tl-confirm" data-title="Annuler et rembourser" data-message="La commande #<?=$order["order_id"]?> sera annulée et le client remboursé. Action irréversible." data-danger="1" data-confirm-label="Oui, annuler" href="<?=site_url("admin/orders/order_cancel/".$order["order_id"])?>">Annuler &amp; rembourser</a></li>
                      <?php endif; ?>
                      <?php if($order["order_status"]=="pending" || $order["order_status"]=="inprogress" || $order["order_status"]=="processing"): ?>
                        <li><a class="tl-confirm" data-title="Marquer comme terminée" data-message="La commande #<?=$order["order_id"]?> sera marquée comme terminée." data-confirm-label="Confirmer" href="<?=site_url("admin/orders/order_complete/".$order["order_id"])?>">Termin&eacute;e</a></li>
                      <?php endif; ?>
                      <?php if($order["order_status"]=="pending" || $order["order_status"]=="processing"): ?>
                        <li><a class="tl-confirm" data-title="Passer en cours" data-message="La commande #<?=$order["order_id"]?> passera à l'état En cours." data-confirm-label="Confirmer" href="<?=site_url("admin/orders/order_inprogress/".$order["order_id"])?>">En cours</a></li>
                      <?php endif; ?>
                    </ul>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
        <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
      </form>
    </table>
  </div>

  <!-- Pagination -->
  <?php if($paginationArr["count"]>1): ?>
  <div class="od-pagination">
    <?php if($paginationArr["current"]!=1): ?>
      <a href="<?=site_url("admin/orders/1/".$status.$search_link)?>">&laquo;</a>
      <a href="<?=site_url("admin/orders/".$paginationArr["previous"]."/".$status.$search_link)?>">&lsaquo;</a>
    <?php endif;
    for($page=1;$page<=$pageCount;$page++):
      if($page>=($paginationArr['current']-5) && $page<=($paginationArr['current']+5)): ?>
      <a href="<?=site_url("admin/orders/".$page."/".$status.$search_link)?>" class="<?php if($page==$paginationArr["current"]) echo 'pg-active'; ?>"><?=$page?></a>
    <?php endif; endfor;
    if($paginationArr["current"]!=$paginationArr["count"]): ?>
      <a href="<?=site_url("admin/orders/".$paginationArr["next"]."/".$status.$search_link)?>">&rsaquo;</a>
      <a href="<?=site_url("admin/orders/".$paginationArr["count"]."/".$status.$search_link)?>">&raquo;</a>
    <?php endif; ?>
  </div>
  <div class="od-counter"><?=$count?> commandes &mdash; affichage <?=$where+1?> &agrave; <?php echo ($where+$to>$count)?$count:$where+$to; ?></div>
  <?php endif; ?>
</div>

<!-- Confirm Modal -->
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-center" role="document">
    <div class="modal-content">
      <div class="modal-body text-center" style="padding:28px">
        <h4 style="margin-bottom:16px">&Ecirc;tes-vous s&ucirc;r de vouloir continuer ?</h4>
        <a class="btn btn-primary" href="" id="confirmYes" style="margin-right:8px">Oui</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>