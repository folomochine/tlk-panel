<?php include 'header.php'; ?>
<style>
/* === ToutLike Admin — Clients Page === */
.cl-wrap{padding:20px}
.cl-header{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}
.cl-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.cl-title i{color:var(--primary);font-size:18px}
.cl-actions{display:flex;flex-wrap:wrap;gap:8px}
.cl-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:12px;font-weight:600;cursor:pointer;transition:.2s;text-decoration:none!important}
.cl-btn:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-g)}
.cl-btn i{font-size:13px;color:var(--muted)}
.cl-btn:hover i{color:var(--primary)}
.cl-btn-primary{background:var(--primary);color:#fff!important;border-color:var(--primary)}
.cl-btn-primary:hover{background:var(--hover);border-color:var(--hover)}
.cl-btn-primary i{color:#fff}

/* Search */
.cl-search{display:flex;gap:8px;margin-bottom:18px;flex-wrap:wrap}
.cl-search input[type=text]{flex:1;min-width:200px;padding:9px 14px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;outline:none;transition:.2s}
.cl-search input:focus{border-color:var(--primary)}
.cl-search select{padding:9px 12px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:12px;outline:none;cursor:pointer}
.cl-search button{padding:9px 16px;background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:13px;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:6px}
.cl-search button:hover{background:var(--hover)}

/* Table */
.cl-table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;background:var(--card);border:1px solid var(--border);border-radius:12px}
.cl-table{width:100%;border-collapse:collapse;font-size:13px}
.cl-table thead th{padding:12px 14px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
.cl-table tbody td{padding:10px 14px;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--text)}
.cl-table tbody tr:last-child td{border-bottom:none}
.cl-table tbody tr:hover{background:var(--primary-g)}
.cl-table tbody tr.deactivated{opacity:.5}
.cl-user{display:flex;flex-direction:column}
.cl-user-name{font-weight:600;color:var(--text)}
.cl-user-email{font-size:11px;color:var(--muted);display:flex;align-items:center;gap:4px}
.cl-user-email .fa-check-circle{color:#22c55e;font-size:12px}
.cl-amount{font-weight:600;font-size:13px;white-space:nowrap}
.cl-amount-green{color:#22c55e}
.cl-amount-orange{color:#f59e0b}
.cl-tag{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:var(--primary-g);border:1px solid var(--border);border-radius:6px;font-size:11px;font-weight:600;color:var(--muted);cursor:pointer;transition:.2s;text-decoration:none!important}
.cl-tag:hover{border-color:var(--primary);color:var(--primary)}
.cl-tag .badge{background:var(--primary);color:#fff;font-size:10px;padding:2px 6px;border-radius:6px}
.cl-date{font-size:11px;color:var(--muted);white-space:nowrap}

/* Action dropdown */
.cl-action-btn{padding:5px 12px;background:var(--primary);color:#fff;border:none;border-radius:6px;font-size:11px;font-weight:600;cursor:pointer;transition:.2s}
.cl-action-btn:hover{background:var(--hover)}

/* Pagination */
.cl-pagination{display:flex;justify-content:center;padding:18px 0;gap:4px;flex-wrap:wrap}
.cl-pagination a{display:inline-flex;align-items:center;justify-content:center;min-width:34px;height:34px;padding:0 8px;background:var(--card);border:1px solid var(--border);border-radius:8px;color:var(--muted);font-size:12px;font-weight:600;text-decoration:none;transition:.2s}
.cl-pagination a:hover{border-color:var(--primary);color:var(--primary)}
.cl-pagination a.pg-active{background:var(--primary);color:#fff;border-color:var(--primary)}

@media(max-width:768px){
  .cl-header{flex-direction:column;align-items:flex-start}
  .cl-actions{width:100%;overflow-x:auto;flex-wrap:nowrap;padding-bottom:4px}
  .cl-btn{white-space:nowrap;flex-shrink:0}
}
</style>

<div class="cl-wrap">

  <!-- Header -->
  <div class="cl-header">
    <div class="cl-title"><i class="fas fa-users"></i> Utilisateurs</div>
    <div class="cl-actions">
      <button class="cl-btn cl-btn-primary" type="button" data-toggle="modal" data-target="#modalDiv" data-action="new_user_v2"><i class="fas fa-plus"></i> Ajouter</button>
      <button class="cl-btn" type="button" data-toggle="modal" data-target="#modalDiv" data-action="export_user"><i class="fas fa-download"></i> Backup</button>
      <button class="cl-btn" type="button" data-toggle="modal" data-target="#modalDiv" data-action="alert_user"><i class="fas fa-bell"></i> Notification</button>
      <button class="cl-btn" type="button" data-toggle="modal" data-target="#modalDiv" data-action="all_numbers"><i class="fas fa-phone"></i> Contacts</button>
      <button class="cl-btn" type="button" data-toggle="modal" data-target="#modalDiv" data-action="details"><i class="fas fa-info-circle"></i> Détails</button>
    </div>
  </div>

  <!-- Search -->
  <form class="cl-search" action="" method="get">
    <input type="text" name="search" value="<?=$search_word?>" placeholder="Rechercher un utilisateur...">
    <select name="search_type">
      <option value="username" <?php if($search_where=="username") echo 'selected'; ?>>Nom d'utilisateur</option>
      <option value="name" <?php if($search_where=="name") echo 'selected'; ?>>Nom</option>
      <option value="email" <?php if($search_where=="email") echo 'selected'; ?>>Email</option>
      <option value="telephone" <?php if($search_where=="telephone") echo 'selected'; ?>>Téléphone</option>
    </select>
    <button type="submit"><i class="fas fa-search"></i> Chercher</button>
  </form>

  <!-- Table -->
  <div class="cl-table-wrap">
    <table class="cl-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Utilisateur</th>
          <th>Solde</th>
          <th>Dépenses</th>
          <th>Cmd.</th>
          <th>Remise</th>
          <th>Tarifs spéciaux</th>
          <th>Inscription</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($clients as $client): ?>
        <tr class="<?php if($client["client_type"]==1) echo 'deactivated'; ?>">
          <td><strong>#<?= $client["client_id"] ?></strong></td>
          <td>
            <div class="cl-user">
              <span class="cl-user-name"><?= htmlspecialchars($client["username"]) ?></span>
              <span class="cl-user-email">
                <?= htmlspecialchars($client["email"]) ?>
                <?php if($client["verified"]=="Yes"): ?><i class="fas fa-check-circle"></i><?php endif; ?>
              </span>
            </div>
          </td>
          <td><span class="cl-amount cl-amount-green"><?= format_amount_string($settings["site_base_currency"],$client["balance"]) ?></span></td>
          <td><span class="cl-amount cl-amount-orange"><?= format_amount_string($settings["site_base_currency"],$client["spent"]) ?></span></td>
          <td><?= countRow(["table"=>"orders","where"=>["client_id"=>$client["client_id"]]]) ?></td>
          <td>
            <button type="button" class="cl-tag" data-toggle="modal" data-target="#modalDiv" data-id="<?= $client["client_id"] ?>" data-action="set_discount_percentage">
              <i class="fas fa-percent"></i> <?= $client["discount_percentage"] ?>%
            </button>
          </td>
          <td>
            <a class="cl-tag" href="<?= site_url("admin/special-pricing/".$client["client_id"]) ?>">
              <i class="fas fa-tag"></i> Tarifs
              <span class="badge"><?= countRow(["table"=>"clients_price","where"=>["client_id"=>$client["client_id"]]]) ?></span>
            </a>
          </td>
          <td><span class="cl-date"><?= date('d/m/Y H:i',strtotime($client["register_date"])) ?></span></td>
          <td>
            <div class="dropdown">
              <button type="button" class="cl-action-btn dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-ellipsis-h"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <li><a class="dcs-pointer" data-toggle="modal" data-target="#modalDiv" data-action="edit_user" data-id="<?=$client["client_id"]?>"><i class="fas fa-edit"></i> Modifier</a></li>
                <li><a href="<?= site_url("admin/clients/view/".$client["client_id"]) ?>"><i class="fas fa-eye"></i> Voir le compte</a></li>
                <li><a class="dcs-pointer" data-toggle="modal" data-target="#modalDiv" data-action="pass_user" data-id="<?=$client["client_id"]?>"><i class="fas fa-key"></i> Mot de passe</a></li>
                <li><a class="dcs-pointer" data-toggle="modal" data-target="#modalDiv" data-action="secret_user" data-id="<?=$client["client_id"]?>"><i class="fas fa-th-list"></i> Catégories</a></li>
                <li><a href="<?= site_url("admin/clients/change_apikey/".$client["client_id"]) ?>"><i class="fas fa-sync"></i> Nouvelle clé API</a></li>
                <?php if($client["client_type"]==1): $type="active"; else: $type="deactive"; endif; ?>
                <li><a class="tl-confirm"
                       data-title="<?php echo $client["client_type"]==1?'Activer le compte':'Désactiver le compte'; ?>"
                       data-message="<?php echo $client["client_type"]==1?'Le compte ':'Le compte '; ?><?= htmlspecialchars($client["username"]) ?><?php echo $client["client_type"]==1?' sera réactivé.':' sera suspendu et ne pourra plus se connecter.'; ?>"
                       <?php if($client["client_type"]!=1) echo 'data-danger="1"'; ?>
                       data-confirm-label="<?php echo $client["client_type"]==1?'Activer':'Désactiver'; ?>"
                       href="<?= site_url("admin/clients/".$type."/".$client["client_id"]) ?>">
                  <i class="fas fa-<?php echo $client["client_type"]==1?'check':'ban'; ?>"></i>
                  <?php echo $client["client_type"]==1?'Activer':'Désactiver'; ?>
                </a></li>
                <li><a class="tl-confirm" data-title="Réinitialiser les tarifs" data-message="Tous les tarifs spéciaux du client <?= htmlspecialchars($client["username"]) ?> seront supprimés." data-danger="1" data-confirm-label="Oui, réinitialiser" href="<?= site_url("admin/clients/del_price/".$client["client_id"]) ?>"><i class="fas fa-trash-alt"></i> Réinit. tarifs</a></li>
              </ul>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if($paginationArr["count"]>1): ?>
  <div class="cl-pagination">
    <?php if($paginationArr["current"]!=1): ?>
      <a href="<?= site_url("admin/clients/1".$search_link) ?>">&laquo;</a>
      <a href="<?= site_url("admin/clients/".$paginationArr["previous"].$search_link) ?>">&lsaquo;</a>
    <?php endif;
    for($page=1;$page<=$pageCount;$page++):
      if($page>=($paginationArr['current']-5) && $page<=($paginationArr['current']+5)): ?>
      <a href="<?= site_url("admin/clients/".$page.$search_link) ?>" class="<?php if($page==$paginationArr["current"]) echo 'pg-active'; ?>"><?=$page?></a>
    <?php endif; endfor;
    if($paginationArr["current"]!=$paginationArr["count"]): ?>
      <a href="<?= site_url("admin/clients/".$paginationArr["next"].$search_link) ?>">&rsaquo;</a>
      <a href="<?= site_url("admin/clients/".$paginationArr["count"].$search_link) ?>">&raquo;</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</div>

<!-- Confirm Modal -->
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-center" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h4>Êtes-vous sûr de vouloir changer le statut ?</h4>
        <div align="center">
          <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>