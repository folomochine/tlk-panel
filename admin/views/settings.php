<?php include 'header.php'; ?>

<style>
.tl-settings{display:flex;gap:16px;min-height:calc(100vh - var(--top-h) - 32px)}
.tl-set-sb{width:240px;flex-shrink:0;background:var(--card);border:1px solid var(--border);border-radius:12px;padding:8px;align-self:flex-start;position:sticky;top:calc(var(--top-h) + 16px)}
.tl-set-sb-title{font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);font-weight:700;padding:14px 14px 10px}
.tl-set-link{display:flex;align-items:center;gap:10px;padding:10px 14px;color:var(--muted);text-decoration:none!important;font-size:13px;font-weight:500;border-radius:8px;transition:all .15s;margin:2px 0}
.tl-set-link:hover{background:var(--primary-g,rgba(59,130,246,.08));color:var(--primary)}
.tl-set-link.active{background:var(--primary)!important;color:#fff!important;box-shadow:0 2px 8px rgba(59,130,246,.3)}
.tl-set-link i{width:20px;text-align:center;font-size:13px}
.tl-set-link.active i{color:#fff}
.tl-set-sb .tl-set-link.active,
.tl-set-sb .tl-set-link.active span,
.tl-set-sb .tl-set-link.active i{color:#fff!important}
.tl-set-link .tl-set-badge{margin-left:auto;background:rgba(59,130,246,.15);color:var(--primary);font-size:10px;font-weight:700;padding:2px 7px;border-radius:10px;line-height:1.4}
.tl-set-link.active .tl-set-badge{background:rgba(255,255,255,.2);color:#fff}
.tl-set-content{flex:1;min-width:0}
.tl-set-content>.panel:first-child{margin-top:0}
.tl-set-content .col-md-8{width:100%!important}

@media(max-width:991px){
  .tl-settings{flex-direction:column}
  .tl-set-sb{width:100%;position:static}
  .tl-set-sb-nav{display:flex;flex-wrap:wrap;gap:4px;padding:0 8px 8px}
  .tl-set-link{padding:7px 14px;font-size:12px}
  .tl-set-sb-title{padding:10px 14px 6px}
}
</style>

<div class="tl-settings">

  <div class="tl-set-sb">
    <div class="tl-set-sb-title">Parametres</div>
    <div class="tl-set-sb-nav">
    <?php
    $setIcons = [
      "general"          => "fas fa-cog",
      "providers"        => "fas fa-store",
      "paymentMethods"   => "fas fa-credit-card",
      "bank-accounts"    => "fas fa-university",
      "modules"          => "fas fa-puzzle-piece",
      "subject"          => "fas fa-headset",
      "payment-bonuses"  => "fas fa-gift",
      "currency-manager" => "fas fa-coins",
      "alert"            => "fas fa-bell",
      "site_count"       => "fas fa-chart-bar",
      "update"           => "fas fa-cloud-download-alt"
    ];
    foreach ($menuList as $menuName => $menuLink):
      $icon = $setIcons[$menuLink] ?? "fas fa-circle";
      $isActive = ($route["2"] == $menuLink);
      $badge = "";
      if ($menuLink == "providers"):
        $badge = '<span class="tl-set-badge">'.$sellers_count.'</span>';
      endif;
      if ($menuLink == "currency-manager"):
        $badge = '<span class="tl-set-badge">'.$currencies_count.'</span>';
      endif;
      if ($menuLink == "site_count"):
        $badge = '<span class="tl-set-badge">'.$orders_count.'</span>';
      endif;
    ?>
      <a class="tl-set-link <?php if ($isActive) echo 'active'; ?>" href="<?= site_url("admin/settings/" . $menuLink) ?>">
        <i class="<?= $icon ?>"></i> <?= htmlspecialchars($menuName) ?> <?= $badge ?>
      </a>
    <?php endforeach; ?>
    </div>
  </div>

  <div class="tl-set-content">
    <?php if ($access): ?>
      <?php include admin_view('settings/' . route(2)); ?>
    <?php else: ?>
      <?php include admin_view('settings/access'); ?>
    <?php endif; ?>
  </div>

</div>

<?php include 'footer.php'; ?>
