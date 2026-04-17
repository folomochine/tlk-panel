<?php include 'header.php';?>
<style>
/* Services Page - Modern Design */
.services-page { padding: 0; }
.services-page__header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
.services-page__title { font-size: 18px; font-weight: 700; color: var(--text); margin: 0; display: flex; align-items: center; gap: 10px; }
.services-page__title i { color: var(--primary); }
.services-page__actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.services-page__search { display: flex; align-items: center; gap: 8px; }
.services-page__search .form-control { width: 200px; }

.services-page .nav-tabs__service { 
    background: var(--card); 
    border: 1px solid var(--border); 
    border-radius: 12px; 
    padding: 12px 16px; 
    margin-bottom: 16px;
    display: flex !important;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}
.services-page .nav-tabs__service .btn { 
    font-size: 12px; 
    padding: 6px 14px; 
    border-radius: 8px;
    font-weight: 600;
}
.services-page .nav-tabs__service .btn-primary {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
}

.services-page .services-table {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 16px;
}

.services-page .service-block__header {
    background: var(--card);
    border: none;
    border-bottom: 1px solid var(--border);
    border-radius: 0;
}
.services-page .service-block__header th {
    background: var(--card);
    color: var(--muted);
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    font-weight: 600;
    border: none;
    border-bottom: 1px solid var(--border);
}

.services-page .service-block__category {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px;
    margin: 12px;
    overflow: hidden;
}

.services-page .service-block__category-title {
    background: var(--bg);
    border: none;
    border-bottom: 1px solid var(--border);
    padding: 14px 16px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 10px;
}

.services-page .service-block__packages {
    background: transparent;
}

.services-page .service-block__packages table {
    margin: 0;
}

.services-page .service-block__packages td {
    padding: 12px 14px;
    font-size: 13px;
    color: var(--text);
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.services-page .ui-state-default {
    background: transparent !important;
    border: none !important;
    border-bottom: 1px solid var(--border) !important;
    box-shadow: none !important;
}
.services-page .ui-state-default:hover {
    background: var(--primary-g) !important;
}

.services-page .service-block__id {
    font-weight: 600;
    color: var(--primary);
    width: 60px;
}
.services-page .service-block__service {
    font-weight: 500;
    max-width: 250px;
}
.services-page .service-block__minorder,
.services-page .service-block__rate,
.services-page .service-block__provider {
    font-size: 12px;
}
.services-page .service-block__provider-value {
    font-size: 11px;
    color: var(--dim);
    margin-top: 2px;
}
.services-page .service-block__visibility {
    font-weight: 600;
    font-size: 11px;
}
.services-page .service-block__visibility .text-danger {
    margin-left: 4px;
}

.services-page .label-api {
    background: var(--blue-g);
    color: var(--primary);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
}
.services-page .badge-secondary {
    background: var(--blue-g);
    color: var(--primary);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 10px;
}

.services-page .category-name {
    font-weight: 600;
    color: var(--text);
}
.services-page .category-visibility {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
}
.services-page .category-visible {
    background: var(--green);
    box-shadow: 0 0 0 3px var(--green-g);
}
.services-page .category-invisible {
    background: var(--red);
    box-shadow: 0 0 0 3px var(--red-g);
}
.services-page .service-block__collapse-button {
    cursor: pointer;
}

.services-page .checkAll-holder {
    padding: 6px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background: var(--card);
}

.services-page .action-block {
    display: none;
    background: var(--card);
    padding: 8px 12px;
    border-radius: 8px;
    margin-left: 10px;
}
.services-page .action-block.show {
    display: inline-flex;
    align-items: center;
    gap: 12px;
}
.services-page .action-list {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    padding: 0;
    list-style: none;
    font-size: 12px;
    color: var(--muted);
}

.services-page .service-block__action .dropdown-menu {
    min-width: 180px;
    padding: 6px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--card);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
.services-page .service-block__action .dropdown-menu li a {
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    color: var(--text);
}
.services-page .service-block__action .dropdown-menu li a:hover {
    background: var(--primary-g);
    color: var(--primary);
}

.services-page .pagination {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin: 20px 0;
    padding: 0;
}
.services-page .pagination li a {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--muted);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.services-page .pagination li a:hover {
    border-color: var(--primary);
    color: var(--primary);
}
.services-page .pagination li.active a {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}

/* Tooltips */
.services-page .tooltip5 {
    position: relative;
    display: inline-block;
    margin-left: 4px;
}
.services-page .tooltip5 .tooltiptext5 {
    visibility: hidden;
    background: var(--card);
    color: var(--text);
    border: 1px solid var(--border);
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 11px;
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    opacity: 0;
    transition: opacity 0.2s;
}
.services-page .tooltip5:hover .tooltiptext5 {
    visibility: visible;
    opacity: 1;
}

/* Dark mode fixes */
body.dark-mode .container-fluid,
body.dark-mode .services-page .services-table,
body.dark-mode .services-page .service-block__header,
body.dark-mode .services-page .service-block__category-title,
body.dark-mode .services-page .service-block__packages,
body.dark-mode .services-page .service-block__body,
body.dark-mode .services-page .sticker-head,
body.dark-mode .services-page .ui-state-default,
body.dark-mode .services-page td,
body.dark-mode .services-page th {
    background-color: var(--card) !important;
    background: var(--card) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode .services-page .service-block__category {
    background-color: var(--card) !important;
}
body.dark-mode .services-page .ui-state-default:hover td {
    background-color: var(--bg) !important;
}
body.dark-mode .services-page .service-block__header th {
    background-color: var(--card) !important;
    color: var(--muted) !important;
}
body.dark-mode .services-page .service-block__packages td {
    background-color: transparent !important;
}
body.dark-mode .services-page .category-name,
body.dark-mode .services-page .service-block__service {
    color: var(--text) !important;
}
body.dark-mode .services-page .checkAll-holder {
    background: var(--card) !important;
    border-color: var(--border) !important;
}
body.dark-mode .services-page .action-block {
    background: var(--card) !important;
}
body.dark-mode .services-page .nav-tabs__service {
    background: var(--card) !important;
    border-color: var(--border) !important;
}
body.dark-mode .services-page .nav-tabs__service .btn-default {
    background: var(--card) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode .services-page .form-control {
    background: var(--bg) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
/* UI Sortable fix */
body.dark-mode .services-page .ui-sortable,
body.dark-mode .services-page .ui-sortable .ui-state-default,
body.dark-mode .services-page .serviceSortable,
body.dark-mode .services-page .category-sortable,
body.dark-mode .services-page .service-sortable {
    background-color: transparent !important;
}
body.dark-mode .services-page .ui-sortable .ui-state-default td,
body.dark-mode .services-page .serviceSortable .ui-state-default td,
body.dark-mode .services-page .service-sortable .ui-state-default td {
    background-color: var(--card) !important;
    color: var(--text) !important;
}
body.dark-mode .services-page .ui-sortable .ui-state-default:hover td,
body.dark-mode .services-page .serviceSortable .ui-state-default:hover td {
    background-color: var(--bg) !important;
}
body.dark-mode .services-page .ui-sortable-helper {
    background-color: var(--bg) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.4) !important;
}
body.dark-mode .services-page .category-sortable .categories,
body.dark-mode .services-page .categories {
    background: transparent !important;
}
/* Drag handles and icons */
body.dark-mode .services-page .service-block__drag svg,
body.dark-mode .services-page .service-block__drag path {
    fill: var(--muted) !important;
}
body.dark-mode .services-page .service-block__drag:hover svg,
body.dark-mode .services-page .service-block__drag:hover path {
    fill: var(--text) !important;
}
body.dark-mode .services-page .category-sortable .handle svg,
body.dark-mode .services-page .handle svg {
    fill: var(--muted) !important;
}
body.dark-mode .services-page .category-sortable .handle:hover svg,
body.dark-mode .services-page .handle:hover svg {
    fill: var(--text) !important;
}
/* Checkbox */
body.dark-mode .services-page .service-block__checkbox input[type="checkbox"] {
    background: var(--bg) !important;
    border-color: var(--border) !important;
}
body.dark-mode .services-page .checkAll-holder input[type="checkbox"] {
    background: var(--bg) !important;
    border-color: var(--border) !important;
}
/* Modal dark mode fixes for #modalDiv */
body.dark-mode #modalDiv .modal-content {
    background-color: var(--card) !important;
    border-color: var(--border) !important;
    box-shadow: 0 16px 48px rgba(0,0,0,.3) !important;
}
body.dark-mode #modalDiv .modal-header {
    border-bottom-color: var(--border) !important;
}
body.dark-mode #modalDiv .modal-body {
    background-color: var(--card) !important;
    color: var(--text) !important;
}
body.dark-mode #modalDiv .row,
body.dark-mode #modalDiv [class*="col-md-"],
body.dark-mode #modalDiv [class*="col-sm-"],
body.dark-mode #modalDiv [class*="col-lg-"],
body.dark-mode #modalDiv [class*="col-xs-"] {
    background: transparent !important;
    background-color: transparent !important;
}
body.dark-mode #modalDiv .modal-footer {
    background-color: var(--card) !important;
    border-top-color: var(--border) !important;
}
body.dark-mode #modalDiv .modal-header .close {
    color: var(--text) !important;
}
body.dark-mode #modalDiv .form-control,
body.dark-mode #modalDiv input[type="text"],
body.dark-mode #modalDiv input[type="number"],
body.dark-mode #modalDiv input[type="email"],
body.dark-mode #modalDiv input[type="password"],
body.dark-mode #modalDiv textarea,
body.dark-mode #modalDiv select {
    background-color: rgba(30,41,59,.9) !important;
    color: var(--text) !important;
    border-color: var(--border) !important;
}
body.dark-mode #modalDiv .btn-default {
    background-color: rgba(30,41,59,.9) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode #modalDiv .btn-default:hover {
    background-color: var(--border) !important;
    border-color: var(--primary) !important;
    color: var(--primary) !important;
}
body.dark-mode #modalDiv .dropdown-menu {
    background-color: var(--card) !important;
    border-color: var(--border) !important;
}
body.dark-mode #modalDiv .dropdown-menu > li > a {
    color: var(--text) !important;
}
body.dark-mode #modalDiv .dropdown-menu > li > a:hover {
    background-color: var(--primary-g) !important;
    color: var(--primary) !important;
}
body.dark-mode #modalDiv .panel,
body.dark-mode #modalDiv .well {
    background-color: var(--card) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode #modalDiv .panel-heading {
    background-color: rgba(30,41,59,.9) !important;
    border-bottom-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode #modalDiv .panel-body {
    background-color: var(--card) !important;
    color: var(--text) !important;
}
/* service-mode__wrapper fix (loaded by AJAX) */
body.dark-mode #modalDiv .service-mode__wrapper,
body.dark-mode #modalDiv .service-mode__block {
    background-color: var(--card) !important;
    border-color: var(--border) !important;
    color: var(--text) !important;
}
body.dark-mode #modalDiv .service-mode__wrapper label,
body.dark-mode #modalDiv .service-mode__block label,
body.dark-mode #modalDiv .form-group label,
body.dark-mode #modalDiv label {
    color: var(--text) !important;
}
/* Modal backdrop */
body.dark-mode .modal-backdrop {
    background-color: rgba(15,23,42,.8) !important;
    opacity: .8 !important;
}

/* ================================================================
   Fix dropdown "Options" clipping when only 1-2 services are listed
   The parent containers were masking the overflow of the menu.
   ================================================================ */
.services-page,
.services-page .services-table,
.services-page .service-block__body,
.services-page .service-block__body-scroll,
.services-page .service-block__packages,
.services-page .service-block__category,
.services-page .categories,
.services-page .serviceSortable,
.services-page .collapse.in,
.services-page .service-sortable,
.services-page table,
.services-page tbody,
.services-page tr,
.services-page td.service-block__action {
    overflow: visible !important;
}
.services-page .service-block__body,
.services-page .service-block__body-scroll {
    overflow-x: auto !important;
    overflow-y: visible !important;
}
.services-page .dropdown { position: relative; }
.services-page .dropdown.open { z-index: 2000; }
.services-page .dropdown-menu {
    z-index: 2000 !important;
    min-width: 220px;
    right: 0;
    left: auto;
    margin-top: 6px !important;
    padding: 6px 0 !important;
    border-radius: 12px !important;
    border: 1px solid var(--border, #e2e8f0) !important;
    background: var(--card, #fff) !important;
    box-shadow: 0 18px 40px rgba(15,23,42,.18) !important;
}
.services-page .dropdown-menu > li > a {
    padding: 9px 14px !important;
    font-size: 13px !important;
    color: var(--text, #0f172a) !important;
    border-radius: 0 !important;
    transition: background .15s ease, color .15s ease;
}
.services-page .dropdown-menu > li > a:hover {
    background: rgba(99,102,241,.10) !important;
    color: #4f46e5 !important;
}
body.dark-mode .services-page .dropdown-menu > li > a:hover {
    color: #a5b4fc !important;
}
/* Flip dropdown upward if the row is close to the bottom of the viewport */
.services-page .dropdown.dropup .dropdown-menu {
    top: auto !important;
    bottom: 100% !important;
    margin-bottom: 6px !important;
}
</style>
<div class="container-fluid services-page">
    <ul class="nav nav-tabs nav-tabs__service">
        <br>
        <li class="p-b"><button class="btn btn-default" data-toggle="modal" data-target="#modalDiv" data-action="new_service"><i class="fas fa-plus"></i> Nouveau service</button></li>
        <li class="p-b"><button class="btn btn-default m-l" data-toggle="modal" data-target="#modalDiv" data-action="new_subscriptions"><i class="fas fa-plus-circle"></i> Nouvel abonnement</button></li>
        <li class="p-b"><button class="btn btn-default m-l" data-toggle="modal" data-target="#modalDiv" data-action="new_category"><i class="fas fa-folder-plus"></i> Nouvelle catégorie</button></li>

<li class="pull-right">
<a class="btn btn-primary" href="<?= site_url('admin/api-services') ?>"><i class="fas fa-plus-circle"></i> Importer des services</a>
        </li>




<li class="pull-right">
<div class="form-inline">
<label for="service-search-input" class="service-search__icon"></label>
<input class="form-control" placeholder="Rechercher" id="priceService" type="text" value="">
</div>
</li>
    </ul>
    <ul></ul>
    <div class="services-table">
        <div class="sticker-head">
            <table class="service-block__header" id="sticker">
                <thead>
<th class="checkAll-th service-block__checker null">
    <div class="checkAll-holder">
        <input type="checkbox" id="checkAll">
        <input type="hidden" id="checkAllText" value="order">
    </div>
    <div class="action-block">
        <ul class="action-list">
            <li><span class="countOrders"></span> Services sélectionnés</li>
            <li>
                <div class="dropdown">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Opérations groupées<span class="caret"></span></button>
<ul class="dropdown-menu">
    <li>
        <a class="bulkorder" data-type="active">Activer les services sélectionnés</a>
        <a class="bulkorder" data-type="deactive">Désactiver les services sélectionnés</a>
        <a class="bulkorder" data-type="secret">Rendre les services sélectionnés secrets</a>
        <a class="bulkorder" data-type="desecret">Retirer les services sélectionnés des secrets</a>
        <a class="bulkorder" data-type="del_price">Supprimer les tarifs personnalisés sélectionnés</a>
        <a class="bulkorder" data-type="del_service">Supprimer les services sélectionnés</a>
        <a class="bulkorder" data-type="refill-active">Activer le rechargement des services sélectionnés</a>
        <a class="bulkorder" data-type="refill-inactive">Désactiver le rechargement des services sélectionnés</a>
        <a class="bulkorder" data-type="cancel-active">Activer l'annulation des services sélectionnés</a>
        <a class="bulkorder" data-type="cancel-inactive">Désactiver l'annulation des services sélectionnés</a>
    </li>
</ul>
                </div>
            </li>
        </ul>
    </div>
</th>
<th class="service-block__id">ID</th>
<th class="service-block__service">Service</th>

<th>Type de service</th>
<th class="service-block__minorder">Rechargement</th>
<th class="service-block__minorder">Annulation</th>
<th class="service-block__provider">Fournisseur</th>
<th class="service-block__rate">Prix</th>
<th class="service-block__minorder">Min</th>
<th class="service-block__minorder">Max</th>
<th class="service-block__visibility">Statut</th>
<th class="service-block__action text-right"><span id="allServices" class="service-block__hide-all fa fa-compress"></span></th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="service-block__body">
        <div class="service-block__body-scroll">
            <div style="width: 100%; height: 0px;"></div>


<form action="<?php echo site_url("admin/services/multi-action") ?>" method="post" id="changebulkForm">
<div style="" class="category-sortable">
<?php $c = 0; foreach ($serviceList as $category => $services): $c++; ?>
<div class="categories" data-id="<?=$services[0]["category_id"] ?>">
    <div class="<?php if ($services[0]["category_type"] == 1): echo 'grey'; endif; ?>  service-block__category ">
        <div class="service-block__category-title" class="categorySortable" data-category="<?=$category ?>" id="category-<?=$c ?>">
            <div class="service-block__drag handle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
<title>Drag-Handle</title>
<path d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                </svg>
            </div>
<?php if ($services[0]["category_secret"] == 1): echo '<small data-toggle="tooltip" data-placement="top" title="" data-original-title="gizli kategori"><i class="fa fa-lock"></i></small> '; endif; 

if($services[0]["category_type"] == 2){
echo '<span data-post="category_id='.$services[0]["category_id"].'" class="category-visibility category-visible"></span>';
} 
if($services[0]["category_type"] == 1){
echo '<span data-post="category_id='.$services[0]["category_id"].'" class="category-visibility category-invisible"></span>';
} 

$category_icon_array = json_decode($services[0]["category_icon"],true);

$category_icon_type = $category_icon_array["icon_type"];

if($category_icon_type == "image"){

$icon = "<img style=\"margin-right:10px;\" src=\"".$images[$category_icon_array["image_id"]][0]["link"]."\" class=\"img-responsive btn-group-vertical\">";
} elseif($category_icon_type == "icon"){

$icon = "<i style=\"margin-right:10px;font-size:18px;\" class=\"".$category_icon_array["icon_class"]."\" aria-hidden=\"true\"></i>";
} else {
    $icon = "";
    
}


echo '<span class="category-name">'.$icon.$category.'</span>'; ?>
<span style="margin-left:10px;margin-right:10px;font-weight:bold;">|</span>

<a style="margin-right:15px;" class="dcs-pointer" data-toggle="modal" data-target="#modalDiv" data-action="edit_category" data-id="<?=$services[0]["category_id"]?>"><i class="fas fa-pen"></i></a>
<a class="text-danger" href="<?php echo site_url("admin/services/del_category/".$services[0]["category_id"]) ?>" data-action="del_category"><i class="fas fa-trash"></i></a>

<?php if (!empty($services[0]["service_id"])): ?>

            <div class="service-block__collapse-block">
                <div id="collapedAdd-<?=$c ?>" class="service-block__collapse-button" data-category="category-<?=$c ?>"></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="collapse in">
            <div class="service-block__packages">
                <table id="servicesTableList" class="Servicecategory-<?=$c ?>">
<tbody class="service-sortable">
    <div class="serviceSortable" id="Servicecategory-<?=$c ?>" data-id="category-<?=$c ?>">
        <?php for ($i = 0; $i < count($services); $i++): 
      if($services[$i]["service_deleted"] == 0):
        $api_detail = json_decode($services[$i]["api_detail"], true); ?>
        <tr id="serviceshowcategory-<?=$c ?>" class="ui-state-default <?php if ($services[$i]["service_type"] == 1): echo "grey"; endif; ?>" data-category="category-<?=$c ?>" data-id="service-<?php echo $services[$i]["service_id"] ?>" data-service="<?php echo $services[$i]["service_name"] ?>">
<?php if (!empty($services[0]["service_id"])): ?>
<td class="service-block__checker">
<?php if ($services[$i]["api_servicetype"] == 1): echo '<div class="service-block__danger"></div>'; endif; ?>
<span></span>
<div class="service-block__checkbox">
    <div class="service-block__drag handle">
        <svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Drag-Handle</title>
                <path d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
            </svg>
        </svg>
    </div>
    <input type="checkbox" class="selectOrder" name="service[<?php echo $services[$i]["service_id"] ?>]" value="1" style="border:1px solid var(--border)">
</div>
</td>

<td class="service-block__id"><?php echo $services[$i]["service_id"] ?></td>
<td class="service-block__service"><?php if ($services[$i]["service_secret"] == 1): echo '<small data-toggle="tooltip" data-placement="top" title="" data-original-title="Service secret"><i class="fa fa-lock"></i></small> '; endif; echo htmlspecialchars($services[$i]["service_name"]); ?></td>
<td width="10%"><?php echo servicePackageType($services[$i]["service_package"]); ?><?php if ($services[$i]["time"] != "Not enough data"): ?><div class="tooltip5">
&nbsp;<i class="fas fa-clock"></i><span class="tooltiptext5"><?php echo $services[$i]["time"]; ?> </span>
</div>
<?php endif; ?><?php if ($services[$i]["show_refill"] == "true"): echo '<div  class="tooltip5">&nbsp;<i class="fas fa-sync"></i></span><span class="tooltiptext5" >Bouton de rechargement activé</span></div>'; endif; ?>
<?php if ($services[$i]["cancelbutton"] == 1): echo '<div  class="tooltip5">&nbsp;<i  class="fas fa-ban"></i></span><span class="tooltiptext5" >Bouton d\'annulation activé</span></div>'; endif; ?>

</td>
<?php if ($services[$i]["show_refill"] == "true"): $type = "refill-deactive"; else : $type = "refill-active"; endif; ?>

<td class="service-block__minorder"> <a href="<?php echo site_url("admin/services/".$type."/".$services[$i]["service_id"]) ?>"> <?php if ($services[$i]["show_refill"] == "false"): echo "Désactivé"; else : echo "Activé"; endif; ?></a></td>

<?php if ($services[$i]["cancelbutton"] == 2): $type = "cancelbutton-active"; else : $type = "cancelbutton-deactive"; endif; ?>
<td class="service-block__minorder"> <a href="<?php echo site_url("admin/services/".$type."/".$services[$i]["service_id"]) ?>"> <?php if ($services[$i]["cancelbutton"] == "2"): echo "Désactivé"; else : echo "Activé"; endif; ?></a></td>


<td class="service-block__provider"><?php if ($services[$i]["service_api"] != 0): echo $services[$i]["api_name"]." <span class=\"badge badge-secondary\">".$services[$i]["currency"]."</span><br><span class=\"label label-api\">".$services[$i]["api_service"]."</span>"; else : echo "Manuel"; endif; ?></td>

<td class="service-block__rate">
<?php
$api_price = $api_detail["rate"];
?>
<div style="width:100px;<?php if (!$api_detail["rate"]): echo "Empty"; elseif ($services[$i]["service_api"] != 0 && from_to(get_currencies_array("all"), $settings["site_base_currency"], "INR", $services[$i]["service_price"]) > from_to(get_currencies_array("enabled"), $services[$i]["currency"], "INR", $api_price)):
    echo "color: #38E54D;";
    elseif ($services[$i]["service_api"] != 0 && from_to(get_currencies_array("all"), $settings["site_base_currency"], "INR", $services[$i]["service_price"]) < from_to(get_currencies_array("all"), $services[$i]["currency"], "INR", $api_price)):
echo "color: #D2001A;";elseif($services[$i]["service_api"] != 0 && from_to(get_currencies_array("all"), $settings["site_base_currency"], "INR", $services[$i]["service_price"]) == from_to(get_currencies_array("all"), $services[$i]["currency"], "INR", $api_price)):
echo "color: #FFB200;";
endif;?>">
    <?php if ($settings["site_base_currency"] !== $services[$i]["currency"]) {
        echo "≈ ".format_amount_string($settings["site_base_currency"], $services[$i]["service_price"]);
    } elseif ($settings["site_base_currency"] == $services[$i]["currency"]) {
        echo format_amount_string($settings["site_base_currency"], $services[$i]["service_price"]);
    }
    ?>
</div>
<div class="service-block__provider-value">
    <?php if ($services[$i]["service_api"] != 0 && $api_detail["rate"]):
    if ($settings["site_base_currency"] !== $services[$i]["currency"]) {
        echo "≈ ".format_amount_string($settings["site_base_currency"], from_to(get_currencies_array("all"), $services[$i]["currency"], $settings["site_base_currency"], $api_detail["rate"]));
    } elseif ($settings["site_base_currency"] == $services[$i]["currency"]) {

        echo format_amount_string($settings["site_base_currency"], from_to(get_currencies_array("all"), $services[$i]["currency"], $settings["site_base_currency"], $api_detail["rate"]));

    }
    endif; ?>
</div>
</td>
<td class="service-block__minorder">
<div>
    <?php echo $services[$i]["service_min"] ?>
</div>
<?php if ($services[$i]["service_api"] != 0): echo '<div class="service-block__provider-value">'.$api_detail["min"].'</div>'; endif; ?>
</td>
<td class="service-block__minorder">
<div>
    <?php echo $services[$i]["service_max"] ?>
</div>
<?php if ($services[$i]["service_api"] != 0): echo '<div class="service-block__provider-value">'.$api_detail["max"].'</div>'; endif; ?>
</td>
<td class="service-block__visibility"><?php if ($services[$i]["service_type"] == 1): echo "Désactivé"; else : echo "Activé"; endif; ?> <?php if ($services[$i]["api_servicetype"] == 1): echo '<span class="text-danger" title="Le fournisseur a supprimé ce service"><span class="fa fa-exclamation-circle"></span></span>'; endif; ?> </td>
<td class="service-block__action">
<div class="dropdown pull-right">
    <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_service" data-id="<?=$services[$i]["service_id"] ?>">Modifier le service</a></li>
        <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_service_name" data-id="<?=$services[$i]["service_id"] ?>">Modifier le nom du service</a></li>
        <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_description" data-id="<?=$services[$i]["service_id"] ?>">Modifier la description</a></li>
        <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_time" data-id="<?=$services[$i]["service_id"] ?>">Modifier le temps moyen</a></li>
        <?php if ($services[$i]["service_type"] == 1): $type = "service-active"; else : $type = "service-deactive"; endif; ?>
        <li><a href="<?php echo site_url("admin/services/".$type."/".$services[$i]["service_id"]) ?>"><?php if ($services[$i]["service_type"] == 1): echo "Activer"; else : echo "Désactiver"; endif; ?> le service</a></li>

        <?php if ($services[$i]["show_refill"] == "true"): $type = "refill-deactive"; else : $type = "refill-active"; endif; ?>
        <li><a href="<?php echo site_url("admin/services/".$type."/".$services[$i]["service_id"]) ?>">Rechargement : <?php if ($services[$i]["show_refill"] == "true"): echo "Désactiver"; else : echo "Activer"; endif; ?></a></li>

        <?php if ($services[$i]["cancelbutton"] == 2): $type = "cancelbutton-active"; else : $type = "cancelbutton-deactive"; endif; ?>
        <li><a href="<?php echo site_url("admin/services/".$type."/".$services[$i]["service_id"]) ?>">Annulation : <?php if ($services[$i]["cancelbutton"] == 1): echo "Désactiver"; else : echo "Activer"; endif; ?></a></li>


        <li><a href="<?php echo site_url("admin/services/delete/".$services[$i]["service_id"]) ?>">Supprimer le service</a></li>
    </ul>
</div>
</td>
<?php endif; ?>
        </tr>
        <?php 
        endif;
        endfor; ?>
    </div>
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php
$services = $conn->prepare("SELECT * FROM services LEFT JOIN service_api ON service_api.id = services.service_api WHERE services.category_id=:c_id ORDER BY services.service_line ASC ");
$services -> execute(array("c_id" => 0));
$services = $services->fetchAll(PDO::FETCH_ASSOC);
if ($services):
?>
<div class="service-block__category ">
    <div class="service-block__category-title" class="categorySortable" data-category="notcategory" id="category-0">
        Non classé
        <div class="service-block__collapse-block">
            <div id="collapedAdd-0" class="service-block__collapse-button" data-category="category-0"></div>
        </div>
    </div>
    <div class="collapse in">
        <div class="service-block__packages">
            <table id="servicesTableList" class="Servicecategory-0">
                <tbody class="service-sortable">
<div class="serviceSortable" id="Servicecategory-0" data-id="category-0">
    <?php foreach ($services as $service): $api_detail = json_decode($service["api_detail"], true); ?>
    <tr id="serviceshowcategory-0" class="ui-state-default <?php if ($service["service_type"] == 1): echo "grey"; endif; ?>" data-category="category-0" data-id="service-<?php echo $service["service_id"] ?>" data-service="<?php echo mb_convert_encoding($service["service_name"], "UTF-8", "UTF-8") ?>">
        <td class="service-block__checker">
<!-- <div class="service-block__danger"></div> //Servis diğer sitede pasifse burayı aktif et-->
<span></span>
<div class="service-block__checkbox">
<div class="service-block__drag handle">
    <svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Drag-Handle</title>
            <path d="M7 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm6-8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 6c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
        </svg>
    </svg>
</div>
<input type="checkbox" class="selectOrder" name="service[<?php echo $service["service_id"] ?>]" value="1" style="border:1px solid var(--border)">
</div>
        </td>
        <td class="service-block__id"><?php echo $service["service_id"] ?></td>
        <td class="service-block__service"><?php if (mb_convert_encoding($service["service_secret"], "UTF-8", "UTF-8") == 1): echo '<small data-toggle="tooltip" data-placement="top" title="" data-original-title="Secret service"><i class="fa fa-lock"></i></small> '; endif; echo htmlspecialchars(mb_convert_encoding($service["service_name"], "UTF-8", "UTF-8")); ?></td>
        <td class="service-block__type" nowrap=""><?php echo servicePackageType($service["service_package"]); ?></td>
        <td class="service-block__provider"><?php if ($service["service_api"] != 0): echo $service["api_name"]; else : echo "Manuel"; endif; ?></td>
        <td class="service-block__rate">
<?php
$api_price = 0;
if ($api_detail["currency"] == "USD"):
$api_price = $api_detail["rate"];
endif;
?>
<div style="<?php if ($service["service_api"] != 0 && $service["service_price"] > $api_price): echo "color: green"; elseif ($service["service_api"] != 0 && $service["service_price"] < $api_price): echo "color: red"; endif ?>">
<?php echo $service["service_price"] ?>
</div>
<?php if ($service["service_api"] != 0): echo '<div class="service-block__provider-value"><i class="fa fa-'.strtolower($api_detail["currency"]).'"></i> '.priceFormat($api_detail["rate"]).'</div>'; endif; ?>
        </td>
        <td class="service-block__minorder">
<div>
<?php echo $service["service_min"] ?>
</div>
<?php if ($service["service_api"] != 0): echo '<div class="service-block__provider-value">'.$api_detail["min"].'</div>'; endif; ?>
        </td>
        <td class="service-block__minorder">
<div>
<?php echo $service["service_max"] ?>
</div>
<?php if ($service["service_api"] != 0): echo '<div class="service-block__provider-value">'.$api_detail["max"].'</div>'; endif; ?>
        </td>
        <td class="service-block__visibility"><?php if ($service["service_type"] == 1): echo "Désactivé"; else : echo "Activé"; endif; ?> </td>
        <td class="service-block__action">
<div class="dropdown pull-right">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
<ul class="dropdown-menu">
    <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_service" data-id="<?=$service["service_id"] ?>">Modifier le service</a></li>
    <li><a style="cursor:pointer;" data-toggle="modal" data-target="#modalDiv" data-action="edit_description" data-id="<?=$service["service_id"] ?>">Modifier la description</a></li>
    <?php if ($service["service_type"] == 1): $type = "service-active"; else : $type = "service-deactive"; endif; ?>
    <li><a href="<?php echo site_url("admin/services/".$type."/".$service["service_id"]) ?>"><?php if ($service["service_type"] == 1): echo "Activer"; else : echo "Désactiver"; endif; ?> le service</a></li>
    <li><a href="<?php echo site_url("admin/services/del_price/".$service["service_id"]) ?>">Supprimer le tarif</a></li>
    <li><a href="<?php echo site_url("admin/services/delete/".$services[$i]["service_id"]) ?>">Supprimer le service</a></li>
</ul>
</div>
        </td>
    </tr>
    <?php endforeach; ?>
</div>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php endif; ?>
</div>

<input type="hidden" name="bulkStatus" id="bulkStatus" value="-1">
            </form>
        </div>
    </div>
    
</div>



<?php if( $paginationArr["count"] > 1 ): ?>
     <div class="row">
        <div class="col-sm-8">
  <nav>
 <ul class="pagination">
 <?php if( $paginationArr["current"] != 1 ): ?>
  <li class="prev"><a href="<?php echo site_url("admin/services/1".$search_link) ?>">&laquo;</a></li>
  <li class="prev"><a href="<?php echo site_url("admin/services/".$paginationArr["previous"].$search_link) ?>">&lsaquo;</a></li>
  <?php
      endif;
      for ($page=1; $page<=$pageCount; $page++):
        if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
  ?>
  <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/services/".$page.$search_link) ?>"><?=$page?></a></li>
  <?php endif; endfor;
        if( $paginationArr["current"] != $paginationArr["count"] ):
  ?>
  <li class="next"><a href="<?php echo site_url("admin/services/".$paginationArr["next"].$search_link) ?>" data-page="1">&rsaquo;</a></li>
  <li class="next"><a href="<?php echo site_url("admin/services/".$paginationArr["count"].$search_link) ?>" data-page="1">&raquo;</a></li> 
  <?php endif; ?>
 </ul>
  </nav>
        </div>
     </div>
   <?php endif; ?>









    <div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
        <div class="modal-dialog modal-dialog-center" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
<h4>Êtes-vous sûr de vouloir continuer ?</h4>
<div align="center">
    <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
    <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
</div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
