<?php include('header.php') ?>

<?php if (($_SESSION["information"])) : $info = $_SESSION["information"]; ?>
<div class="alert alert-<?= $info["type"] ?>" role="alert">
    <?= $info["message"] ?>
</div>
    <script>setTimeout(() => { <?php $_SESSION["information"] = array(); ?> }, 2000);</script>
<?php endif; ?>

<style>
.aps-wrap{padding:24px;max-width:1200px;margin:0 auto}
.aps-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.aps-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px}
.aps-title i{color:var(--primary)}

.aps-steps{display:flex;align-items:center;gap:0;background:var(--card);border:1px solid var(--border);border-radius:14px;overflow:hidden;margin-bottom:24px}
.aps-step{flex:1;text-align:center;padding:14px 16px;font-size:13px;font-weight:600;color:var(--muted);cursor:default;transition:all .2s;position:relative;white-space:nowrap}
.aps-step:hover{color:var(--text)}
.aps-step.active{color:var(--primary);background:rgba(59,130,246,.08)}
.aps-step.active::after{content:'';position:absolute;bottom:0;left:16px;right:16px;height:2px;background:var(--primary);border-radius:2px}
.aps-step .aps-step-num{display:flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:50%;font-size:11px;font-weight:700;margin:0 auto 6px;background:rgba(59,130,246,.1);color:var(--primary)}
.aps-step.active .aps-step-num{background:var(--primary);color:#fff}
.aps-step.done{color:var(--green)}
.aps-step.done .aps-step-num{background:rgba(34,197,94,.15);color:var(--green)}

.aps-form-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:24px;max-width:480px;margin:0 auto}
.aps-form-card .form-group{margin-bottom:16px}
.aps-form-card label{display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:6px}
.aps-form-card .form-control{border-radius:10px;padding:9px 14px;font-size:13px}
.aps-form-card .input-group-addon{background:var(--bg);border:1px solid var(--border);color:var(--muted);font-size:12px;padding:9px 12px;border-radius:0 10px 10px 0}
.aps-submit{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px 16px;font-size:13px;font-weight:600;border-radius:10px;border:none;background:var(--primary);color:#fff;cursor:pointer;transition:all .2s}
.aps-submit:hover{background:var(--hover);transform:translateY(-1px);box-shadow:0 4px 12px rgba(59,130,246,.3)}

/* ── Action bar (sticky en haut) ── */
.aps-action-bar{
  position:sticky;top:0;z-index:20;
  display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
  padding:12px 18px;margin-bottom:14px;
  background:var(--card);border:1px solid var(--border);border-radius:12px;
  box-shadow:0 4px 16px rgba(0,0,0,.15);
}
.aps-action-bar__left{display:flex;align-items:center;gap:14px}
.aps-check-label{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--text);cursor:pointer;user-select:none}
.aps-check-label input[type="checkbox"]{width:16px;height:16px;accent-color:var(--primary);cursor:pointer}
.aps-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:rgba(59,130,246,.12);color:var(--primary);border-radius:8px;font-size:12px;font-weight:600}
.aps-flow-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:10px 20px;border-radius:10px;border:none;
  background:var(--primary);color:#fff;
  font-size:13px;font-weight:700;cursor:pointer;transition:.2s;
}
.aps-flow-btn:hover{background:var(--hover);box-shadow:0 4px 12px rgba(59,130,246,.35)}
.aps-flow-btn:disabled{opacity:.5;cursor:not-allowed}
.aps-flow-btn i{font-size:12px}

/* ── Tableau ── */
.aps-table-wrap{background:var(--card);border:1px solid var(--border);border-radius:14px;overflow-x:auto}
.aps-table{width:100%;border-collapse:collapse;font-size:13px}
.aps-table thead th{padding:12px 14px;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;border-bottom:1px solid var(--border);white-space:nowrap}
.aps-table tbody td{padding:10px 14px;border-bottom:1px solid var(--border);vertical-align:middle;color:var(--text)}
.aps-table tbody tr:last-child td{border-bottom:none}
.aps-table tbody tr:hover{background:rgba(59,130,246,.04)}
.aps-table tbody tr.aps-row-checked{background:rgba(59,130,246,.08)}
.aps-table input[type="text"],.aps-table input[type="number"],.aps-table select,.aps-table textarea{border-radius:8px;padding:7px 10px;font-size:12px;background:var(--bg);border:1px solid var(--border);color:var(--text);width:100%;transition:border-color .2s}
.aps-table input[type="text"]:focus,.aps-table input[type="number"]:focus,.aps-table select:focus,.aps-table textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(59,130,246,.15);outline:none}
.aps-table textarea{resize:vertical;min-height:60px}
.aps-table .grey{color:var(--muted);font-size:11px}

/* ── Search ── */
.aps-search{display:flex;align-items:center;gap:8px;padding:10px 14px;background:var(--card);border:1px solid var(--border);border-radius:12px;margin-bottom:14px}
.aps-search i{color:var(--muted);font-size:14px}
.aps-search input{flex:1;border:none;outline:none;background:transparent;color:var(--text);font-size:13px}

/* ── Info banner ── */
.aps-info{display:flex;align-items:center;gap:12px;padding:14px 18px;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.2);border-radius:10px;margin-bottom:14px;font-size:13px;color:var(--text)}
.aps-info i{color:var(--primary);font-size:16px;flex-shrink:0}
.aps-info b{color:var(--text)}
.aps-info-text{color:var(--muted);font-size:12px}
.aps-info--warn{background:rgba(245,158,11,.08);border-color:rgba(245,158,11,.25)}
.aps-info--warn i{color:var(--orange)}

/* ── Provider / Price badges ── */
.aps-provider{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;background:rgba(139,92,246,.1);color:var(--text);border-radius:8px;font-size:11px;font-weight:600}
.aps-price{font-size:11px;color:var(--muted);margin-top:2px}
.aps-price b{color:var(--text)}
.aps-price .sell{color:var(--orange)}
.aps-price .profit{color:var(--green)}

/* ── Empty state ── */
.aps-empty{text-align:center;padding:48px 24px;color:var(--muted)}
.aps-empty h4{font-size:15px;font-weight:600;color:var(--text);margin-bottom:8px}
.aps-empty code{font-size:12px;color:var(--red);background:var(--bg);padding:4px 10px;border-radius:6px}

/* ── Confirm modal ── */
#apsConfirmModal .modal-dialog{max-width:380px;margin-top:180px}
#apsConfirmModal .modal-content{background:var(--card);border:1px solid var(--border);border-radius:14px}
#apsConfirmModal .aps-confirm-body{padding:28px 24px;text-align:center}
#apsConfirmModal .aps-confirm-icon{font-size:38px;color:var(--primary);margin-bottom:14px}
#apsConfirmModal .aps-confirm-text{font-size:14px;font-weight:600;color:var(--text);margin-bottom:20px}
#apsConfirmModal .btn{min-width:90px;border-radius:8px;font-weight:600;font-size:13px;padding:8px 18px}

/* ── Responsive ── */
@media(max-width:768px){
  .aps-wrap{padding:14px}
  .aps-steps{flex-direction:column}
  .aps-action-bar{flex-direction:column;align-items:stretch;gap:10px}
  .aps-action-bar__left{justify-content:space-between}
  .aps-flow-btn{justify-content:center;width:100%}
  .aps-table input[type="text"],.aps-table input[type="number"],.aps-table select,.aps-table textarea{min-width:80px}
}
</style>

<div class="aps-wrap">
  <div class="aps-header">
    <div class="aps-title"><i class="fas fa-plug"></i> Services API</div>
  </div>

  <div class="aps-steps">
    <div class="aps-step <?= !route(2) ? 'active' : '' ?> <?= route(2) ? 'done' : '' ?>">
      <div class="aps-step-num"><?= route(2) ? '<i class="fas fa-check" style="font-size:10px"></i>' : '1' ?></div>
      Fournisseur
    </div>
    <div class="aps-step <?= route(2) == 'ajax_services_update' ? 'active' : '' ?> <?= route(2) == 'ajax_services_last' ? 'done' : '' ?>">
      <div class="aps-step-num"><?= route(2) == 'ajax_services_last' ? '<i class="fas fa-check" style="font-size:10px"></i>' : '2' ?></div>
      Catégories
    </div>
    <div class="aps-step <?= route(2) == 'ajax_services_last' ? 'active' : '' ?>">
      <div class="aps-step-num">3</div>
      Services
    </div>
  </div>

  <?php /* ═══════════════════════════════════════════
       ÉTAPE 1 — Sélection du fournisseur + marge
  ═══════════════════════════════════════════ */ ?>
  <?php if (!route(2)) : ?>

  <div class="aps-form-card">
    <form method="post" action="<?= site_url('admin/api-services/ajax_services_update') ?>">
      <div class="form-group">
        <label>Sélectionner l'API</label>
        <select id="api_fetch_id" name="api_fetch_id" class="form-control" required>
        <?php foreach ($providers as $provider) : ?>
          <option value="<?= $provider['id'] ?>"><?= $provider['api_name'] ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Marge bénéficiaire (%)</label>
        <div class="input-group">
          <input class="form-control" name="profit" id="profit" value="10" required type="number">
          <div class="input-group-addon"><label>%</label></div>
        </div>
      </div>
      <button type="submit" class="aps-submit">Étape suivante <i class="fas fa-arrow-right"></i></button>
    </form>
  </div>

  <?php /* ═══════════════════════════════════════════
       ÉTAPE 2 — Sélection des catégories
       Form ENVELOPPE le tableau (HTML valide)
  ═══════════════════════════════════════════ */ ?>
  <?php elseif (route(2) == "ajax_services_update") : ?>

  <form action="<?= site_url('admin/api-services/ajax_services_add') ?>" method="post" id="changebulkForm">
    <input type="hidden" name="status" id="bulkStatus" value="1">
    <input type="hidden" name="import" id="importValue" value="categories">

    <div class="aps-action-bar">
      <div class="aps-action-bar__left">
        <label class="aps-check-label">
          <input type="checkbox" id="apsCheckAll"> Tout sélectionner
        </label>
        <span class="aps-badge" id="apsSelectedCount">0 sélectionné(s)</span>
      </div>
      <button type="button" class="aps-flow-btn" id="apsContinueBtn" onclick="submitStep2()">
        Continuer vers les services <i class="fas fa-arrow-right"></i>
      </button>
    </div>

    <div class="aps-info">
      <i class="fas fa-info-circle"></i>
      <div class="aps-info-text"><b><?= $servicesCount ?></b> catégories trouvées — sélectionnez celles que vous souhaitez importer (10-15 max recommandé par lot).</div>
    </div>

    <div class="aps-search">
      <i class="fas fa-search"></i>
      <input type="text" id="apsSearch" placeholder="Rechercher des catégories..." value="">
    </div>

    <div class="aps-table-wrap">
      <table class="aps-table">
        <thead>
          <tr>
            <th style="width:40px"></th>
            <th>#</th>
            <th>Catégorie API</th>
            <th>Mapper vers</th>
            <th>Nom local</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$services->error) :
        $grouped = array_group_by($services, 'category');
        $category_id = 0;
        foreach ($grouped as $category) :
            $category_id++; ?>
          <tr data-name="<?= $category[0]->category ?>">
            <td><input class="aps-check-item" name="checkbox[<?= $category_id ?>]" value="<?= $category_id ?>" type="checkbox"></td>
            <td><?= $category_id ?></td>
            <td>
              <input class="form-control" value="<?= $category[0]->category ?>" style="max-width:320px" name="category_name[<?= $category_id ?>]" type="text">
              <input value="<?= $category[0]->category ?>" name="old_category_name[<?= $category_id ?>]" type="hidden">
            </td>
            <td>
              <select class="form-control" name="category_ids[<?= $category_id ?>]">
                <option value="0">Créer nouveau</option>
                <?php foreach ($categoriesData as $cat) : ?>
                  <option value="<?= $cat["category_id"] ?>" class="<?= $cat["category_type"] == 1 ? 'tl-text-muted' : '' ?>"><?= $cat['category_name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php else : ?>
          <tr><td colspan="5" class="aps-empty">
            <h4>Aucune catégorie trouvée</h4>
            <code><?= $services->error ?></code>
          </td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </form>

  <?php /* ═══════════════════════════════════════════
       ÉTAPE 3 — Sélection des services
       Form ENVELOPPE le tableau (HTML valide)
       Ordre hidden inputs : service_profit_percentage[0], import[1], status[2]
  ═══════════════════════════════════════════ */ ?>
  <?php elseif (route(2) == "ajax_services_last") : ?>

  <form action="<?= site_url('admin/api-services/ajax_services_addNow') ?>" method="post" id="servicesAddForm">
    <input type="hidden" name="service_profit_percentage" value="<?= $profit ?>">
    <input type="hidden" name="import" id="importValue" value="services">
    <input type="hidden" name="status" id="bulkStatus" value="2">

    <div class="aps-action-bar">
      <div class="aps-action-bar__left">
        <label class="aps-check-label">
          <input type="checkbox" id="apsCheckAll"> Tout sélectionner
        </label>
        <span class="aps-badge" id="apsSelectedCount">0 sélectionné(s)</span>
      </div>
      <button type="button" class="aps-flow-btn" id="apsImportBtn" onclick="submitStep3()">
        <i class="fas fa-download"></i> Importer les services
      </button>
    </div>

    <div class="aps-info">
      <i class="fas fa-server"></i>
      <div class="aps-info-text"><b><?= $servicesCount ?></b> services trouvés — <span class="aps-provider"><i class="fas fa-plug"></i> <?= $provider["api_name"] ?></span> &nbsp; <span class="aps-provider"><?= $provider["currency"] ?></span></div>
    </div>

    <?php if (!empty($pageMessage)) : ?>
    <div class="aps-info aps-info--warn">
      <i class="fas fa-exclamation-triangle"></i>
      <div class="aps-info-text"><?= $pageMessage ?></div>
    </div>
    <?php endif; ?>

    <div class="aps-search">
      <i class="fas fa-search"></i>
      <input type="text" id="apsSearch" placeholder="Rechercher des services..." value="">
    </div>

    <div class="aps-table-wrap">
      <table class="aps-table">
        <thead>
          <tr>
            <th style="width:40px"></th>
            <th>#</th>
            <th>Catégorie</th>
            <th>Service local</th>
            <th>Nom API</th>
            <th>Type</th>
            <th>Fournisseur</th>
            <th>Prix [+<?= $profit ?>%]</th>
            <th>Min</th>
            <th>Max</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 0;
        foreach ($getServicesByCategory as $categoryId => $services) :
          foreach ($services as $service) :
            if ($provider["api_type"] == 1) {
                $servicePrice = $service->rate;
                $SELLER_PRICE = $servicePrice;
            } elseif ($provider["api_type"] == 4) {
                $servicePrice = $service->cost;
                $SELLER_PRICE = $servicePrice;
            }
            $servicePrice = from_to(get_currencies_array("all"),$provider["currency"],$settings["site_base_currency"],$servicePrice);
            $numberToAdd = ($profit / 100) * $servicePrice;
            $price = $servicePrice + $numberToAdd;
            $finalPrice = $price;
        ?>
          <tr data-name="<?= $service->name ?>">
            <td>
              <input class="aps-check-item" name="checkbox[<?= $i ?>]" value="1" type="checkbox">
              <input type="hidden" value="<?= $service->refill ?>" name="service_refill_array[<?= $i ?>]">
              <input type="hidden" value="<?= $provider["id"] ?>" name="service_provider_array[<?= $i ?>]">
              <input type="hidden" value="<?= $SELLER_PRICE ?>" name="service_api_prices[<?= $i ?>]">
            </td>
            <td><?= $i + 1 ?></td>
            <td>
              <select class="form-control" name="category_ids_array[<?= $i ?>]">
                <?php foreach ($allCategories as $category) : if ($category["category_id"] == $categoryId) : ?>
                  <option value="<?= $category["category_id"] ?>" selected="selected"><?= $category["category_name"] ?></option>
                <?php endif; endforeach; ?>
              </select>
            </td>
            <td>
              <select class="form-control" name="our_services_ids_array[<?= $i ?>]">
                <option value="0">Créer nouveau</option>
                <?php foreach ($allServices as $serv) : ?>
                  <option value="<?= $serv["service_id"] ?>"><?= $serv["service_name"] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td>
              <input class="form-control" value="<?= $service->name ?>" name="service_name_array[<?= $i ?>]" type="text">
            </td>
            <td><?= $service->type ?>
              <input type="hidden" value="<?= $service->type ?>" name="service_type_array[<?= $i ?>]">
            </td>
            <td>
              <span class="aps-provider"><?= $provider["api_name"] ?></span>
              <div class="grey"><?= $service->service ?></div>
              <input name="api_service_id_array[<?= $i ?>]" value="<?= $service->service ?>" type="hidden">
            </td>
            <td>
              <input style="width:120px" class="form-control" value="<?= $finalPrice ?>" name="prices_array[<?= $i ?>]" type="text">
              <div class="aps-price">
                <?php if($provider["currency"] !== $settings["site_base_currency"]){ ?>
                  <b class="profit">≈ <?= format_amount_string($settings["site_base_currency"],$finalPrice) ?></b>
                  <span class="sell">Coût : ≈ <?= format_amount_string($settings["site_base_currency"],from_to(get_currencies_array("all"),$provider["currency"],$settings["site_base_currency"],$SELLER_PRICE)) ?></span>
                <?php } else { ?>
                  <b class="profit"><?= format_amount_string($settings["site_base_currency"],$finalPrice) ?></b>
                <?php } ?>
              </div>
            </td>
            <td><input style="width:70px" class="form-control" value="<?= $service->min ?>" name="min_array[<?= $i ?>]" type="text"></td>
            <td><input style="width:70px" class="form-control" value="<?= $service->max ?>" name="max_array[<?= $i ?>]" type="text"></td>
            <td><textarea class="form-control" style="min-width:120px;min-height:50px" name="description_array[<?= $i ?>]" type="text"><?= empty($service->desc) ? $service->description : $service->desc ?></textarea></td>
          </tr>
        <?php $i++; endforeach; endforeach; ?>
        </tbody>
      </table>
    </div>
  </form>

  <?php endif; ?>

  <!-- ═══ Modal de confirmation (partagé étapes 2 et 3) ═══ -->
  <div class="modal fade" id="apsConfirmModal" tabindex="-1" role="dialog" data-backdrop="static" style="display:none">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="aps-confirm-body">
          <div class="aps-confirm-icon"><i class="fas fa-question-circle"></i></div>
          <div class="aps-confirm-text">Êtes-vous sûr de vouloir continuer ?</div>
          <button type="button" class="btn btn-primary" id="apsConfirmYes">Oui, continuer</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ Modales existantes (description, catégorie) ═══ -->
  <div class="modal fade" id="modifyCategory" tabindex="-1" role="dialog" data-backdrop="static" style="display:none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modifier la catégorie</h4>
        </div>
        <form action="" method="post" id="modify-category">
          <div class="modal-body">
            <div class="alert alert-danger hide" id="modify-category-error"></div>
            <div class="form-group">
              <label>Nom de la catégorie <span class="badge">Anglais US</span></label>
              <input name="name-_en" class="form-control" value="" type="text">
            </div>
            <div class="form-group">
              <label>Visibilité</label>
              <select name="visibility" class="form-control">
                <option value="1">Activé</option>
                <option value="0" selected="selected">Désactivé</option>
              </select>
            </div>
          </div>
          <input name="id" value="1" type="hidden">
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="modify-category-button">Modifier</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editDescription" tabindex="-1" role="dialog" data-backdrop="static" style="display:none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modifier la description</h4>
        </div>
        <div id="editdescriptionBody"></div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-center" id="confirmChange" tabindex="-1" role="dialog" data-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h4>Êtes-vous sûr de vouloir réinitialiser les tarifs personnalisés pour tous les utilisateurs de ce service ?</h4>
          <input type="hidden" name="service_id" value="0" id="reset_service_id">
          <input type="hidden" name="reset_all_price_service" value="reset_all_price_service">
          <div align="center">
            <button class="btn btn-primary">Oui</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<?php include('footer.php') ?>

<script src="public/admin/main.js"></script>
<script>
(function(){
  /* ── Checkboxes (classes aps-check-* pour éviter conflit main.js) ── */
  var checkAll = document.getElementById('apsCheckAll');
  var items    = function(){ return document.querySelectorAll('.aps-check-item'); };

  function updateCount(){
    var n = document.querySelectorAll('.aps-check-item:checked').length;
    var el = document.getElementById('apsSelectedCount');
    if(el) el.textContent = n + ' sélectionné(s)';
    items().forEach(function(cb){
      var tr = cb.closest('tr');
      if(tr) tr.classList.toggle('aps-row-checked', cb.checked);
    });
  }

  if(checkAll){
    checkAll.addEventListener('change', function(){
      items().forEach(function(cb){ cb.checked = checkAll.checked; });
      updateCount();
    });
  }

  document.addEventListener('change', function(e){
    if(e.target.classList.contains('aps-check-item')) updateCount();
  });

  /* ── Recherche ── */
  var searchInput = document.getElementById('apsSearch');
  if(searchInput){
    searchInput.addEventListener('keyup', function(){
      var q = this.value.toUpperCase();
      document.querySelectorAll('.aps-table tbody tr[data-name]').forEach(function(tr){
        var name = (tr.getAttribute('data-name') || '').toUpperCase();
        tr.style.display = name.indexOf(q) > -1 ? '' : 'none';
      });
    });
  }

  /* ── Étape 2 : soumettre les catégories ── */
  window.submitStep2 = function(){
    var checked = document.querySelectorAll('.aps-check-item:checked').length;
    if(checked === 0){
      if(typeof iziToast !== 'undefined'){
        iziToast.show({icon:'fa fa-exclamation-triangle',title:'Attention',message:'Sélectionnez au moins une catégorie.',color:'orange',position:'topCenter'});
      } else { alert('Sélectionnez au moins une catégorie.'); }
      return;
    }
    $('#apsConfirmModal').modal('show');
    $('#apsConfirmYes').off('click').on('click', function(){
      $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i> Traitement...');
      var frm = $('#changebulkForm');
      var formData = JSON.stringify(frm.serialize());
      $('<input>').attr({type:'hidden',name:'form_data'}).val(formData).appendTo(frm);
      frm[0].submit();
    });
  };

  /* ── Étape 3 : soumettre les services ── */
  window.submitStep3 = function(){
    var checked = document.querySelectorAll('.aps-check-item:checked').length;
    if(checked === 0){
      if(typeof iziToast !== 'undefined'){
        iziToast.show({icon:'fa fa-exclamation-triangle',title:'Attention',message:'Sélectionnez au moins un service.',color:'orange',position:'topCenter'});
      } else { alert('Sélectionnez au moins un service.'); }
      return;
    }
    $('#apsConfirmModal').modal('show');
    $('#apsConfirmYes').off('click').on('click', function(){
      $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i> Import en cours...');
      var frm = $('#servicesAddForm');
      var formData = JSON.stringify(frm.serializeArray());
      $('<input>').attr({type:'hidden',name:'form_data'}).val(formData).appendTo(frm);
      frm[0].submit();
    });
  };

})();
</script>
