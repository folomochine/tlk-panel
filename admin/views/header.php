<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <base href="<?= site_url() ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $settings["site_name"] ?> — Administration</title>
  <?php if (!empty($settings['favicon'])): ?>
    <link rel="shortcut icon" type="image/ico" href="<?= $settings['favicon'] ?>">
  <?php endif; ?>

  <!-- Dependencies (kept for admin views compatibility) -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="public/admin/bootstrap.css">
  <link rel="stylesheet" href="public/admin/style.css">
  <link rel="stylesheet" href="public/admin/toastDemo.css">
  <link rel="stylesheet" href="public/admin/tooltip.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
  <link rel="stylesheet" href="public/admin/tinytoggle.min.css">
  <link rel="stylesheet" href="public/admin/iziToast.min.css">
  <script src="public/admin/iziToast.min.js"></script>
  <link href="//gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="/public/global/rq6gso8oois098nss.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
  <link rel="stylesheet" href="https://itsjavi.com/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css">
  <link rel="stylesheet" href="public/css/admin/image-picker.css">
  <link href="public/css/admin/main.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- TL Admin global styles â€” MUST be last to override old CSS -->
  <link href="public/admin/tl-admin.css" rel="stylesheet">
  <link href="public/admin/tl-modal.css" rel="stylesheet">

  <style>
/* ============================================================
   ToutLike Admin — Modern Sidebar Layout
   Mobile-first, Dark Mode, French
   ============================================================ */
 :root{
  --sb-w:260px;
  --top-h:56px;
  --bg:#f1f5f9;--card:#fff;--border:#e2e8f0;
  --text:#0f172a;--muted:#64748b;--dim:#94a3b8;
  --primary:#3B82F6;--hover:#2563EB;--primary-g:rgba(59,130,246,.08);
  --accent:#8B5CF6;
  --sb-bg:#0F172A;--sb-text:#64748b;--sb-hover:#1E293B;--sb-active:rgba(59,130,246,.1);
  --green:#22C55E;--green-g:rgba(34,197,94,.1);
  --orange:#F59E0B;--orange-g:rgba(245,158,11,.1);
  --red:#EF4444;--red-g:rgba(239,68,68,.1);
  --blue:#3B82F6;--blue-g:rgba(59,130,246,.1);
  --purple:#8B5CF6;--purple-g:rgba(139,92,246,.1);
  --radius:12px;--radius-lg:16px;--radius-xl:22px;
  --shadow:0 1px 3px rgba(0,0,0,.06);
  --shadow-md:0 4px 12px rgba(0,0,0,.08);
  --shadow-lg:0 10px 30px rgba(0,0,0,.12);
  --font:-apple-system,BlinkMacSystemFont,'Inter','Segoe UI',Roboto,sans-serif;
}
/* DARK MODE — Fintech */
body.dark-mode{
  --bg:#0F172A;--card:#1E293B;--border:#334155;
  --text:#E5E7EB;--text-secondary:#94A3B8;--muted:#94A3B8;--dim:#64748B;
  --sb-bg:#1E293B;--sb-hover:rgba(59,130,246,.08);
  --shadow:0 1px 3px rgba(0,0,0,.3);
  --shadow-md:0 4px 12px rgba(0,0,0,.4);
  --shadow-lg:0 10px 30px rgba(0,0,0,.5);
}
*{box-sizing:border-box}
html,body{margin:0;padding:0;font-family:var(--font);background:var(--bg);color:var(--text);overflow-x:hidden}

/* LOADING */
#loading{position:fixed;inset:0;display:flex;justify-content:center;align-items:center;background:rgba(255,255,255,.7);z-index:9999}
body.dark-mode #loading{background:rgba(15,23,42,.85)}
.loader{width:36px;height:36px;border:3px solid var(--border);border-top-color:var(--primary);border-radius:50%;animation:spin .7s linear infinite;text-indent:-9999em;font-size:0}
@keyframes spin{to{transform:rotate(360deg)}}

/* SIDEBAR — matches card background for unified design */
.tl-sidebar{position:fixed;top:0;left:0;width:var(--sb-w);height:100vh;background:var(--card);z-index:1001;display:flex;flex-direction:column;transition:transform .3s ease;overflow-y:auto;overflow-x:hidden;-webkit-overflow-scrolling:touch;border-right:1px solid var(--border)}
.tl-sidebar::-webkit-scrollbar{width:3px}
.tl-sidebar::-webkit-scrollbar-thumb{background:rgba(148,163,184,.15);border-radius:4px}
.tl-sb-brand{padding:16px 20px;border-bottom:1px solid var(--border);min-height:64px;display:flex;align-items:center;gap:12px}
.tl-sb-brand img{max-height:32px;border-radius:8px}
.tl-sb-brand span{color:var(--text);font-weight:700;font-size:15px;white-space:nowrap;letter-spacing:-.2px;overflow:hidden;text-overflow:ellipsis}
.tl-sb-nav{flex:1;padding:12px 12px 8px}
.tl-sb-label{padding:20px 12px 8px;font-size:14px;text-transform:uppercase;letter-spacing:1.6px;color:var(--muted);font-weight:700;opacity:.7}
.tl-sb-item{display:flex;align-items:center;gap:10px;padding:10px 14px;color:var(--muted);text-decoration:none!important;font-size:18px;font-weight:500;transition:all .2s ease;border-radius:10px;margin:1px 0;border:none;letter-spacing:.1px}
.tl-sb-item:hover{background:rgba(59,130,246,.1);color:var(--text)}
.tl-sb-item.active{background:var(--primary);color:#fff;box-shadow:0 2px 12px rgba(59,130,246,.3)}
.tl-sb-item.active i{color:#fff}
.tl-sb-item i{width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;text-align:center;font-size:15px;flex-shrink:0;color:var(--muted);transition:color .2s ease}
.tl-sb-item:hover i{color:var(--primary)}
.tl-sb-item.active i{color:#fff}
.tl-sb-badge{margin-left:auto;background:var(--red);color:#fff;font-size:9px;font-weight:700;padding:2px 7px;border-radius:10px;line-height:1.5}
.tl-sb-submenu{display:none;padding-left:12px;margin:2px 0 4px 10px;border-left:1px solid var(--border);overflow:hidden;max-height:0;transition:max-height .3s ease}
.tl-sb-submenu.open{display:block;max-height:500px}
.tl-sb-submenu .tl-sb-item{padding:9px 14px;font-size:17px;gap:8px;border-radius:8px}
.tl-sb-submenu .tl-sb-item i{display:inline-flex}
.tl-sb-parent{cursor:pointer;user-select:none}
.tl-sb-parent .tl-sb-arrow{margin-left:auto;font-size:10px;transition:transform .25s ease;color:var(--muted)}
.tl-sb-parent.open .tl-sb-arrow{transform:rotate(90deg)}
.tl-sb-parent.open{color:var(--text)}
.tl-sb-section{padding:14px 12px 8px;font-size:15px;text-transform:uppercase;letter-spacing:1.2px;color:var(--muted);font-weight:600;display:flex;align-items:center;justify-content:space-between;cursor:pointer;user-select:none;transition:all .2s ease;border-radius:10px}
.tl-sb-section-main{display:flex;align-items:center;gap:10px;min-width:0}
.tl-sb-section-icon{width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;text-align:center;font-size:15px;color:var(--muted);flex-shrink:0;transition:color .2s ease}
.tl-sb-section:hover{background:rgba(59,130,246,.1);color:var(--text)}
.tl-sb-section:hover .tl-sb-section-icon{color:var(--primary)}
.tl-sb-section.open,
.tl-sb-section.active{color:var(--text)}
.tl-sb-section.open .tl-sb-section-icon,
.tl-sb-section.active .tl-sb-section-icon{color:var(--primary)}
.tl-sb-section .tl-sb-arrow{font-size:9px;transition:transform .25s ease;color:var(--muted)}
.tl-sb-section.open .tl-sb-arrow{transform:rotate(90deg)}

/* PROFILE FOOTER */
.tl-sb-profile{padding:12px;border-top:1px solid var(--border);margin-top:auto}
.tl-sb-profile-card{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;text-decoration:none!important;transition:all .2s ease;background:transparent}
.tl-sb-profile-card:hover{background:rgba(59,130,246,.1)}
.tl-sb-profile-icon{width:36px;height:36px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.tl-sb-profile-icon i{color:#fff;font-size:15px}
.tl-sb-profile-info{flex:1;min-width:0}
.tl-sb-profile-name{color:var(--text);font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.tl-sb-profile-role{color:var(--muted);font-size:11px}
.tl-sb-logout{display:flex;align-items:center;gap:10px;padding:9px 12px;color:var(--muted);text-decoration:none!important;font-size:13px;font-weight:500;transition:all .2s ease;border-radius:10px;margin-top:4px}
.tl-sb-logout:hover{background:var(--red-g);color:var(--red)}
.tl-sb-logout i{width:18px;text-align:center;font-size:14px}

/* TOPBAR */
.tl-topbar{position:fixed;top:0;left:var(--sb-w);right:0;height:var(--top-h);background:var(--card);border-bottom:1px solid var(--border);z-index:1000;display:flex;align-items:center;justify-content:space-between;padding:0 20px;transition:left .3s ease}
.tl-topbar-left{display:flex;align-items:center;gap:10px}
.tl-burger{display:none;background:none;border:1px solid var(--border);border-radius:6px;padding:5px 8px;cursor:pointer;color:var(--muted);font-size:18px;line-height:1}
.tl-topbar-title{font-size:14px;font-weight:600;color:var(--text)}
.tl-topbar-right{display:flex;align-items:center;gap:8px}
.tl-top-btn{background:none;border:1px solid var(--border);border-radius:6px;padding:5px 10px;cursor:pointer;color:var(--muted);font-size:12px;font-weight:500;transition:.2s;text-decoration:none!important;display:flex;align-items:center;gap:5px}
.tl-top-btn:hover{border-color:var(--primary);color:var(--primary)}
.tl-top-btn i{font-size:13px}

/* MAIN */
.tl-main{margin-left:var(--sb-w);margin-top:var(--top-h);min-height:calc(100vh - var(--top-h));padding:8px;transition:margin-left .3s ease;background:var(--bg)}
.tl-main .container{width:100%!important;max-width:100%!important;background:transparent!important}

/* Hide OLD bootstrap navbar */
body > .navbar,.tl-main > .navbar,.tl-main > nav.navbar,nav.navbar.navbar-default{display:none!important}

/* === DARK MODE — force blue-gray palette everywhere === */
body.dark-mode .tl-main{
  background:var(--bg)!important;
}
body.dark-mode .tl-main .container-fluid,
body.dark-mode .tl-main .container,
body.dark-mode .tl-main .content-body,
body.dark-mode .tl-main .row,
body.dark-mode .tl-main [class*="col-md-"],
body.dark-mode .tl-main [class*="col-sm-"],
body.dark-mode .tl-main [class*="col-lg-"],
body.dark-mode .tl-main [class*="col-xs-"]{
  background-color:var(--bg)!important;
}
body.dark-mode .tl-main .panel,
body.dark-mode .tl-main .panel-heading,
body.dark-mode .tl-main .panel-body,
body.dark-mode .tl-main .panel-footer,
body.dark-mode .tl-main .well,
body.dark-mode .tl-main .card,
body.dark-mode .tl-main .card-body{
  background-color:var(--card)!important;
  color:var(--text)!important;
  border-color:var(--border)!important;
}
body.dark-mode .tl-main .ui-state-default,
body.dark-mode .tl-main .ui-widget-content{
  background-color:var(--card)!important;
  color:var(--text)!important;
}
body.dark-mode .tl-main .modal-content{
  background-color:var(--card)!important;
}
body.dark-mode .tl-main .form-control,
body.dark-mode .tl-main input[type="text"],
body.dark-mode .tl-main input[type="number"],
body.dark-mode .tl-main input[type="email"],
body.dark-mode .tl-main input[type="password"],
body.dark-mode .tl-main input[type="url"],
body.dark-mode .tl-main input[type="date"],
body.dark-mode .tl-main textarea,
body.dark-mode .tl-main select{
  background-color:rgba(30,41,59,.9)!important;
  color:var(--text)!important;
  border-color:var(--border)!important;
}
body.dark-mode .tl-main .table,
body.dark-mode .tl-main .table td,
body.dark-mode .tl-main .table th{
  background-color:transparent!important;
  color:var(--text)!important;
  border-color:var(--border)!important;
}
body.dark-mode .tl-main .table > thead > tr > th{
  color:var(--muted)!important;
}
body.dark-mode .tl-main .nav > li > a,
body.dark-mode .tl-main .nav-tabs > li > a,
body.dark-mode .tl-main .nav-pills > li > a{
  color:var(--muted)!important;
}
body.dark-mode .tl-main .dropdown-menu,
body.dark-mode .tl-main .dropdown-menu > li > a{
  background-color:var(--card)!important;
  color:var(--text)!important;
}
body.dark-mode .tl-main .alert{
  background-color:var(--card)!important;
}
body.dark-mode .tl-main label,
body.dark-mode .tl-main .control-label{
  color:var(--muted)!important;
}
body.dark-mode .tl-main p,
body.dark-mode .tl-main span,
body.dark-mode .tl-main td,
body.dark-mode .tl-main th,
body.dark-mode .tl-main li,
body.dark-mode .tl-main small{
  color:var(--text)!important;
}
body.dark-mode .tl-main a{color:var(--primary)!important}
body.dark-mode .tl-main a:hover{color:var(--hover)!important}
body.dark-mode .tl-main .close{color:var(--text)!important}
body.dark-mode .tl-main .modal-backdrop{background-color:rgba(15,23,42,.85)!important}
body.dark-mode .tl-main .checkAll-holder{background:var(--card)!important;border-color:var(--border)!important}
body.dark-mode .tl-main .input-group-addon{background:var(--bg)!important;border-color:var(--border)!important;color:var(--muted)!important}

/* MOBILE */
@media(max-width:991px){
  .tl-sidebar{transform:translateX(-100%)}
  .tl-sidebar.open{transform:translateX(0)}
  .tl-topbar{left:0}
  .tl-main{margin-left:0}
  .tl-burger{display:flex}
  .tl-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;backdrop-filter:blur(2px)}
  .tl-overlay.show{display:block}
}
@media(max-width:576px){
  .tl-topbar{padding:0 10px}
  .tl-topbar-title{font-size:12px}
  .tl-top-btn span{display:none}
  .tl-top-btn{padding:5px 8px}
}

/* Global overrides */
.btn-primary{background-color:var(--primary)!important;border-color:var(--primary)!important}
.btn-primary:hover,.btn-primary:focus,.btn-primary:active,.btn-primary.active{background-color:var(--hover)!important;border-color:var(--hover)!important}
.nav-pills>li.active>a,.nav-pills>li.active>a:focus,.nav-pills>li.active>a:hover{background-color:var(--primary)!important}
.text-primary{color:var(--primary)!important}
a{color:var(--primary)}
.badge-success{background-color:var(--green)!important}
.badge-danger,.badge-error{background-color:var(--red)!important}
.badge-warning{background-color:var(--orange)!important}
.badge-info{background-color:var(--blue)!important}
.list-group-item.active,.list-group-item.active:hover,.list-group-item.active:focus{background-color:var(--primary);border-color:var(--primary)}
.btn-danger{background-color:var(--red);border-color:var(--red)}
.btn-success{background-color:var(--green);border-color:var(--green)}
.navbar-default .navbar-nav>.active>a{background-color:var(--primary)!important}
  </style>
</head>

<body class="<?php if($admin["mode"]=="dark"): echo "dark-mode"; endif; ?>">

<div id="loading"><div class="loader">Chargement...</div></div>

<!-- OVERLAY (mobile) -->
<div class="tl-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside class="tl-sidebar" id="sidebar">
  <div class="tl-sb-brand">
    <?php if (!empty($settings['site_logo'])): ?>
      <img src="<?= $settings['site_logo'] ?>" alt="">
    <?php endif; ?>
    <span><?= htmlspecialchars($settings['site_name']) ?></span>
  </div>

  <nav class="tl-sb-nav">
<?php if ($admin["access"]["admin_access"] && $_SESSION["toutlike_adminlogin"]): ?>
    <?php
      $sbUsersActive = in_array(route(1), ["clients", "fund-add-history", "special-pricing"], true);
      $sbPaymentsActive = (route(1)=="settings" && route(2)=="paymentMethods") || (route(1)=="payments" && route(2)=="bank");
      $sbServicesActive = in_array(route(1), ["services", "update-prices", "bulk", "category-sort", "bulkc", "synced_logs"], true);
      $sbOrdersActive = in_array(route(1), ["orders", "tasks", "dripfeeds", "subscriptions"], true);
      $sbExtrasActive = in_array(route(1), ["referrals", "broadcasts", "logs", "reports", "earn", "kuponlar", "child-panels", "updates"], true);
      $sbSystemActive = (route(1)=="settings" && route(2)!="paymentMethods") || in_array(route(1), ["manager", "account"], true);
    ?>

    <div class="tl-sb-label">Principal</div>
    <a class="tl-sb-item <?php if(route(1)=="index") echo 'active'; ?>" href="<?= site_url("admin") ?>">
      <i class="fas fa-chart-line"></i> Tableau de bord
    </a>

    <?php if ($admin["access"]["users"]): ?>
    <div class="tl-sb-section <?php if($sbUsersActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-user-friends tl-sb-section-icon"></i><span>Utilisateurs</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-users">
      <a class="tl-sb-item <?php if(route(1)=="clients") echo 'active'; ?>" href="<?= site_url("admin/clients") ?>">Utilisateurs</a>
      <a class="tl-sb-item <?php if(route(1)=="fund-add-history") echo 'active'; ?>" href="<?= site_url("admin/fund-add-history") ?>">Historique fonds</a>
      <a class="tl-sb-item <?php if(route(1)=="special-pricing") echo 'active'; ?>" href="<?= site_url("admin/special-pricing") ?>">Tarifs spéciaux</a>
    </div>

    <div class="tl-sb-section <?php if($sbPaymentsActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-wallet tl-sb-section-icon"></i><span>Paiements</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-payments">
      <a class="tl-sb-item <?php if(route(1)=="settings" && route(2)=="paymentMethods") echo 'active'; ?>" href="<?= site_url("admin/settings/paymentMethods") ?>">Méthodes de paiement</a>
    <?php if ($admin["access"]["news"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="payments" && route(2)=="bank") echo 'active'; ?>" href="<?= site_url("admin/payments/bank") ?>">
        Notif. paiement
        <?php $bnk=countRow(["table"=>"payments","where"=>["payment_method"=>4,"payment_status"=>1]]); if($bnk>0): ?>
          <span class="tl-sb-badge"><?=$bnk?></span>
        <?php endif; ?>
      </a>
    <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($admin["access"]["services"]): ?>
    <div class="tl-sb-section <?php if($sbServicesActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-layer-group tl-sb-section-icon"></i><span>Services</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-services">
      <a class="tl-sb-item <?php if(route(1)=="services") echo 'active'; ?>" href="<?= site_url("admin/services") ?>">Services</a>
      <?php if ($admin["access"]["update-prices"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="update-prices") echo 'active'; ?>" href="<?= site_url("admin/update-prices") ?>">Maj prix</a>
      <?php endif; ?>
      <?php if ($admin["access"]["bulk"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="bulk") echo 'active'; ?>" href="<?= site_url("admin/bulk") ?>">Éditeur en masse</a>
      <a class="tl-sb-item <?php if(route(1)=="category-sort") echo 'active'; ?>" href="<?= site_url("admin/category-sort") ?>">Tri catégories</a>
      <?php endif; ?>
      <?php if ($admin["access"]["bulkc"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="bulkc") echo 'active'; ?>" href="<?= site_url("admin/bulkc") ?>">Éditeur catégories</a>
      <?php endif; ?>
      <?php if ($admin["access"]["synced-logs"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="synced_logs") echo 'active'; ?>" href="<?= site_url("admin/synced_logs") ?>">Logs synchronisés</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($admin["access"]["orders"]): ?>
    <div class="tl-sb-section <?php if($sbOrdersActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-clipboard-list tl-sb-section-icon"></i><span>Commandes</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-orders">
      <a class="tl-sb-item <?php if(route(1)=="orders") echo 'active'; ?>" href="<?= site_url("admin/orders") ?>">Commandes</a>
      <?php if ($admin["access"]["tasks"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="tasks") echo 'active'; ?>" href="<?= site_url("admin/tasks") ?>">Recharges / Annulations</a>
      <?php endif; ?>
      <?php if (($admin["access"]["dripfeed"] ?? false) && countRow(["table"=>"orders","where"=>["dripfeed"=>2]])>0): ?>
      <a class="tl-sb-item <?php if(route(1)=="dripfeeds") echo 'active'; ?>" href="<?= site_url("admin/dripfeeds") ?>">Drip-feeds</a>
      <?php endif; ?>
      <?php if (countRow(["table"=>"orders","where"=>["subscriptions_type"=>2]])>0): ?>
      <a class="tl-sb-item <?php if(route(1)=="subscriptions") echo 'active'; ?>" href="<?= site_url("admin/subscriptions") ?>">Abonnements</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($admin["access"]["tickets"]): ?>
    <div class="tl-sb-label">Support</div>
    <a class="tl-sb-item <?php if(route(1)=="tickets") echo 'active'; ?>" href="<?= site_url("admin/tickets") ?>">
      <i class="fas fa-headset"></i> Tickets
      <?php $unr=countRow(["table"=>"tickets","where"=>["client_new"=>2]]); if($unr>0): ?>
        <span class="tl-sb-badge"><?=$unr?></span>
      <?php endif; ?>
    </a>
    <?php endif; ?>

    <?php if ($admin["access"]["additionals"] ?? false): ?>
    <div class="tl-sb-section <?php if($sbExtrasActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-puzzle-piece tl-sb-section-icon"></i><span>Extras</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-extras">
      <?php if ($admin["access"]["referral"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="referrals") echo 'active'; ?>" href="<?= site_url("admin/referrals") ?>">Affiliations</a>
      <?php endif; ?>
      <?php if ($admin["access"]["broadcast"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="broadcasts") echo 'active'; ?>" href="<?= site_url("admin/broadcasts") ?>">Diffusions</a>
      <?php endif; ?>
      <?php if ($admin["access"]["logs"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="logs") echo 'active'; ?>" href="<?= site_url("admin/logs") ?>">Logs</a>
      <?php endif; ?>
      <?php if ($admin["access"]["reports"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="reports") echo 'active'; ?>" href="<?= site_url("admin/reports") ?>">Rapports</a>
      <?php endif; ?>
      <?php if ($admin["access"]["videop"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="earn") echo 'active'; ?>" href="<?= site_url("admin/earn") ?>">Promotion</a>
      <?php endif; ?>
      <?php if ($admin["access"]["coupon"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="kuponlar") echo 'active'; ?>" href="<?= site_url("admin/kuponlar") ?>">Coupons</a>
      <?php endif; ?>
      <?php if ($admin["access"]["child-panels"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="child-panels") echo 'active'; ?>" href="<?= site_url("admin/child-panels") ?>">Panels enfants</a>
      <?php endif; ?>
      <?php if ($admin["access"]["updates"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="updates") echo 'active'; ?>" href="<?= site_url("admin/updates") ?>">Mises à jour</a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($admin["access"]["appearance"] ?? false): ?>
    <div class="tl-sb-label">Apparence</div>
    <a class="tl-sb-item <?php if(route(1)=="appearance") echo 'active'; ?>" href="<?= site_url("admin/appearance") ?>"><i class="fas fa-palette"></i> Apparence</a>
    <?php endif; ?>

    <div class="tl-sb-section <?php if($sbSystemActive) echo 'active'; ?>" onclick="toggleSection(this)">
      <span class="tl-sb-section-main"><i class="fas fa-tools tl-sb-section-icon"></i><span>Système</span></span>
      <i class="fas fa-chevron-right tl-sb-arrow"></i>
    </div>
    <div class="tl-sb-submenu" id="sb-system">
      <?php if ($admin["access"]["users"]): ?>
      <a class="tl-sb-item <?php if(route(1)=="settings" && route(2)!="paymentMethods") echo 'active'; ?>" href="<?= site_url("admin/settings") ?>">Paramètres</a>
      <?php endif; ?>
      <?php if ($admin["access"]["manager"] ?? false): ?>
      <a class="tl-sb-item <?php if(route(1)=="manager") echo 'active'; ?>" href="<?= site_url("admin/manager") ?>">Gestionnaire</a>
      <?php endif; ?>
      <a class="tl-sb-item <?php if(route(1)=="account") echo 'active'; ?>" href="<?= site_url("admin/account") ?>">Mon compte</a>
    </div>

<?php endif; ?>
  </nav>

  <!-- Profile + Logout -->
  <div class="tl-sb-profile">
    <a class="tl-sb-profile-card" href="<?= site_url('admin/account') ?>">
      <div class="tl-sb-profile-icon"><i class="fas fa-user-shield"></i></div>
      <div class="tl-sb-profile-info">
        <div class="tl-sb-profile-name"><?= htmlspecialchars($settings['site_name']) ?></div>
        <div class="tl-sb-profile-role"><?= htmlspecialchars($admin['username'] ?? 'admin') ?> — admin</div>
      </div>
    </a>
    <a class="tl-sb-logout" href="admin/logout">
      <i class="fas fa-sign-out-alt"></i> Déconnexion
    </a>
  </div>
</aside>

<!-- TOPBAR -->
<header class="tl-topbar">
  <div class="tl-topbar-left">
    <button class="tl-burger" onclick="toggleSidebar()" aria-label="Menu"><i class="fas fa-bars"></i></button>
    <span class="tl-topbar-title"><?= htmlspecialchars($settings['site_name']) ?></span>
  </div>
  <div class="tl-topbar-right">
    <?php if ($admin["mode"] == "dark"): ?>
      <button class="tl-top-btn" id="enable-light-mode"><i class="fas fa-sun"></i><span>Clair</span></button>
    <?php else: ?>
      <button class="tl-top-btn" id="enable-dark-mode"><i class="fas fa-moon"></i><span>Sombre</span></button>
    <?php endif; ?>
    <a class="tl-top-btn" href="/"><i class="fas fa-external-link-alt"></i><span>Site</span></a>
    <a class="tl-top-btn" href="admin/logout" style="color:#ef4444;border-color:rgba(239,68,68,.3)"><i class="fas fa-sign-out-alt"></i><span>Quitter</span></a>
  </div>
</header>

<!-- MAIN CONTENT WRAPPER -->
<div class="tl-main">

<script>
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('sidebarOverlay').classList.toggle('show');
}
function toggleSection(el){
  var sub=el.nextElementSibling;
  if(!sub||!sub.classList.contains('tl-sb-submenu'))return;
  el.classList.toggle('open');
  sub.classList.toggle('open');
}
document.querySelectorAll('.tl-sb-item').forEach(function(el){
  el.addEventListener('click',function(){
    if(window.innerWidth<=991){
      document.getElementById('sidebar').classList.remove('open');
      document.getElementById('sidebarOverlay').classList.remove('show');
    }
  });
});
(function(){
  document.querySelectorAll('.tl-sb-submenu .tl-sb-item.active').forEach(function(el){
    var sub=el.closest('.tl-sb-submenu');
    if(sub){
      sub.classList.add('open');
      var sec=sub.previousElementSibling;
      if(sec)sec.classList.add('open');
    }
  });
})();
</script>
