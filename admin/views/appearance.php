<?php include 'header.php'; ?>

<style>
.tl-appearance{display:flex;gap:16px;min-height:calc(100vh - var(--top-h) - 32px)}
.tl-appear-sb{width:240px;flex-shrink:0;background:var(--card);border:1px solid var(--border);border-radius:12px;padding:8px;align-self:flex-start;position:sticky;top:calc(var(--top-h) + 16px)}
body.dark-mode .tl-appear-sb{background:var(--card);border-color:var(--border)}
.tl-appear-sb-title{font-size:12px;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);font-weight:700;padding:14px 14px 10px}
.tl-appear-link{display:flex;align-items:center;gap:10px;padding:10px 14px;color:var(--muted);text-decoration:none!important;font-size:13px;font-weight:500;border-radius:8px;transition:all .15s;margin:2px 0}
.tl-appear-link:hover{background:var(--primary-g,rgba(59,130,246,.08));color:var(--primary)}
.tl-appear-link.active{background:var(--primary)!important;color:#fff!important;box-shadow:0 2px 8px rgba(59,130,246,.3)}
.tl-appear-link i{width:20px;text-align:center;font-size:13px}
.tl-appear-link.active i{color:#fff}
.tl-appear-sb .tl-appear-link.active,
.tl-appear-sb .tl-appear-link.active span,
.tl-appear-sb .tl-appear-link.active i{color:#fff!important}
.tl-appear-content{flex:1;min-width:0}
.tl-appear-content>.panel:first-child{margin-top:0}
.tl-appear-content .col-md-8{width:100%!important}

@media(max-width:991px){
  .tl-appearance{flex-direction:column}
  .tl-appear-sb{width:100%;position:static}
  .tl-appear-sb-nav{display:flex;flex-wrap:wrap;gap:4px;padding:0 8px 8px}
  .tl-appear-link{padding:7px 14px;font-size:12px}
  .tl-appear-sb-title{padding:10px 14px 6px}
}
</style>

<div class="tl-appearance">

  <div class="tl-appear-sb">
    <div class="tl-appear-sb-title">Apparence</div>
    <div class="tl-appear-sb-nav">
    <?php
    $appearIcons = [
      "themes"        => "fas fa-paint-brush",
      "new_year"      => "fas fa-snowflake",
      "pages"         => "fas fa-file-alt",
      "news"          => "fas fa-bullhorn",
      "meta"          => "fas fa-search",
      "blog"          => "fas fa-blog",
      "menu"          => "fas fa-bars",
      "language"      => "fas fa-language",
      "integrations"  => "fas fa-plug",
      "files"         => "fas fa-images"
    ];
    foreach ($menuList as $menuName => $menuLink):
      $icon = $appearIcons[$menuLink] ?? "fas fa-circle";
      $isActive = ($route["2"] == $menuLink);
    ?>
      <a class="tl-appear-link <?php if ($isActive) echo 'active'; ?>" href="<?= site_url("admin/appearance/" . $menuLink) ?>">
        <i class="<?= $icon ?>"></i> <?= htmlspecialchars($menuName) ?>
      </a>
    <?php endforeach; ?>
    </div>
  </div>

  <div class="tl-appear-content">
    <?php if ($access): ?>
      <?php include admin_view('appearance/' . route(2)); ?>
    <?php else: ?>
      <?php include admin_view('settings/access'); ?>
    <?php endif; ?>
  </div>

</div>

<?php include 'footer.php'; ?>
