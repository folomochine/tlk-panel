<?php
$updater = $tl_updater ?? [
  "current_version" => "1.0.0",
  "update_url"      => "",
  "backups"         => [],
  "php_version"     => PHP_VERSION,
  "has_zip"         => class_exists('ZipArchive'),
  "has_curl"        => function_exists('curl_init'),
];
?>
<style>
.tl-upd{display:flex;flex-direction:column;gap:18px;max-width:1060px}
.tl-upd-card{background:var(--card);border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 8px 24px -12px rgba(15,23,42,.12)}
.tl-upd-head{display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid var(--border);background:linear-gradient(135deg,rgba(59,130,246,.06),rgba(124,58,237,.04))}
.tl-upd-ico{width:48px;height:48px;border-radius:14px;display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:20px;flex-shrink:0;background:linear-gradient(135deg,#3b82f6,#7c3aed);box-shadow:0 10px 22px rgba(59,130,246,.3)}
.tl-upd-head h3{margin:0;font-size:16px;font-weight:800;color:var(--text)}
.tl-upd-head p{margin:2px 0 0;font-size:12px;color:var(--muted)}
.tl-upd-body{padding:18px 20px}
.tl-upd-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:14px}
.tl-upd-kpi{padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)}
.tl-upd-kpi .k{font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)}
.tl-upd-kpi .v{font-size:20px;font-weight:800;color:var(--text);margin-top:4px;word-break:break-word}
.tl-upd-kpi .badge-ok{display:inline-block;padding:3px 8px;font-size:10px;font-weight:800;background:rgba(16,185,129,.12);color:#047857;border-radius:999px;border:1px solid rgba(16,185,129,.3);margin-top:4px}
.tl-upd-kpi .badge-ko{display:inline-block;padding:3px 8px;font-size:10px;font-weight:800;background:rgba(239,68,68,.12);color:#b91c1c;border-radius:999px;border:1px solid rgba(239,68,68,.3);margin-top:4px}
.tl-upd-row{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;margin-bottom:12px}
.tl-upd-field{flex:1;min-width:260px;display:flex;flex-direction:column;gap:6px}
.tl-upd-field label{font-size:12px;font-weight:700;color:var(--text)}
.tl-upd-field input{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:10px;background:var(--bg);color:var(--text);font-size:13px;transition:border-color .15s}
.tl-upd-field input:focus{outline:0;border-color:var(--primary);box-shadow:0 0 0 3px rgba(59,130,246,.15)}
.tl-upd-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 16px;border-radius:10px;font-weight:700;font-size:13px;border:0;cursor:pointer;min-height:40px;text-decoration:none;transition:all .15s}
.tl-upd-btn.primary{background:linear-gradient(135deg,#3b82f6,#7c3aed);color:#fff;box-shadow:0 8px 18px rgba(59,130,246,.25)}
.tl-upd-btn.primary:hover{filter:brightness(1.08)}
.tl-upd-btn.success{background:linear-gradient(135deg,#10B981,#06B6D4);color:#fff;box-shadow:0 8px 18px rgba(16,185,129,.25)}
.tl-upd-btn.success:hover{filter:brightness(1.08)}
.tl-upd-btn.ghost{background:rgba(148,163,184,.14);color:var(--text)}
.tl-upd-btn.ghost:hover{background:rgba(148,163,184,.24)}
.tl-upd-btn.danger{background:rgba(239,68,68,.12);color:#b91c1c;border:1px solid rgba(239,68,68,.3)}
.tl-upd-btn.danger:hover{background:rgba(239,68,68,.2)}
.tl-upd-btn[disabled]{opacity:.55;cursor:not-allowed}
.tl-upd-status{padding:12px 14px;border-radius:10px;font-size:13px;line-height:1.5;margin-top:10px;display:none}
.tl-upd-status.show{display:block}
.tl-upd-status.ok{background:rgba(16,185,129,.08);color:#047857;border:1px solid rgba(16,185,129,.3)}
.tl-upd-status.err{background:rgba(239,68,68,.08);color:#b91c1c;border:1px solid rgba(239,68,68,.3)}
.tl-upd-status.warn{background:rgba(245,158,11,.08);color:#b45309;border:1px solid rgba(245,158,11,.3)}
.tl-upd-banner{display:flex;gap:12px;align-items:center;padding:14px 16px;border-radius:12px;margin-bottom:14px}
.tl-upd-banner.ok{background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(6,182,212,.04));border:1px solid rgba(16,185,129,.3)}
.tl-upd-banner.new{background:linear-gradient(135deg,rgba(59,130,246,.08),rgba(124,58,237,.06));border:1px solid rgba(59,130,246,.3)}
.tl-upd-banner .ico{width:36px;height:36px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0}
.tl-upd-banner.ok .ico{background:linear-gradient(135deg,#10B981,#06B6D4)}
.tl-upd-banner.new .ico{background:linear-gradient(135deg,#3b82f6,#7c3aed)}
.tl-upd-banner strong{display:block;font-size:14px;color:var(--text)}
.tl-upd-banner span{font-size:12px;color:var(--muted)}
.tl-upd-changelog{background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:14px;margin-top:10px;max-height:220px;overflow:auto}
.tl-upd-changelog h4{margin:0 0 8px;font-size:13px;font-weight:800;color:var(--text)}
.tl-upd-changelog ul{margin:0;padding-left:18px}
.tl-upd-changelog li{font-size:12px;color:var(--muted);margin-bottom:4px;line-height:1.5}
.tl-upd-bk{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:10px}
.tl-upd-bk-item{padding:12px 14px;border:1px solid var(--border);border-radius:10px;background:var(--bg);display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
.tl-upd-bk-info .n{font-size:13px;font-weight:700;color:var(--text);font-family:ui-monospace,Menlo,monospace}
.tl-upd-bk-info .d{font-size:11px;color:var(--muted);margin-top:2px}
.tl-upd-help{padding:14px 16px;border:1px dashed var(--border);border-radius:12px;font-size:12px;color:var(--muted);line-height:1.6}
.tl-upd-help code{background:var(--bg);padding:2px 6px;border-radius:4px;font-family:ui-monospace,Menlo,monospace;color:var(--text)}
.tl-upd-help b{color:var(--text)}
.tl-upd-spin{display:inline-block;width:14px;height:14px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:tlSpin .7s linear infinite}
@keyframes tlSpin{to{transform:rotate(360deg)}}
</style>

<div class="tl-upd">

  <!-- Statut système -->
  <div class="tl-upd-card">
    <div class="tl-upd-head">
      <div class="tl-upd-ico"><i class="fas fa-rocket"></i></div>
      <div>
        <h3>Mises à jour du panel</h3>
        <p>Déployez vos nouvelles versions en un clic depuis GitHub, sans FTP.</p>
      </div>
    </div>
    <div class="tl-upd-body">
      <div class="tl-upd-grid">
        <div class="tl-upd-kpi">
          <div class="k">Version installée</div>
          <div class="v" id="tlUpdCurrent">v<?= htmlspecialchars($updater['current_version']) ?></div>
        </div>
        <div class="tl-upd-kpi">
          <div class="k">PHP</div>
          <div class="v"><?= htmlspecialchars($updater['php_version']) ?></div>
        </div>
        <div class="tl-upd-kpi">
          <div class="k">ZipArchive</div>
          <div class="v"><?= $updater['has_zip'] ? '<span class="badge-ok"><i class="fas fa-check"></i> Disponible</span>' : '<span class="badge-ko"><i class="fas fa-times"></i> Indisponible</span>' ?></div>
        </div>
        <div class="tl-upd-kpi">
          <div class="k">cURL</div>
          <div class="v"><?= $updater['has_curl'] ? '<span class="badge-ok"><i class="fas fa-check"></i> Disponible</span>' : '<span class="badge-ko"><i class="fas fa-times"></i> Indisponible</span>' ?></div>
        </div>
      </div>

      <!-- Source de mise à jour -->
      <div class="tl-upd-row">
        <div class="tl-upd-field">
          <label for="tlUpdUrl"><i class="fab fa-github"></i> URL du fichier <code>version.json</code> (GitHub raw)</label>
          <input id="tlUpdUrl" type="text" value="<?= htmlspecialchars($updater['update_url']) ?>" placeholder="https://raw.githubusercontent.com/votre-user/votre-repo/main/version.json">
        </div>
        <button class="tl-upd-btn ghost" onclick="tlUpdSave()"><i class="fas fa-save"></i> Enregistrer</button>
        <button class="tl-upd-btn primary" onclick="tlUpdCheck()"><i class="fas fa-sync-alt"></i> Vérifier</button>
      </div>

      <div class="tl-upd-help">
        <b>Comment ça marche ?</b> Publiez une <b>Release GitHub</b> avec un ZIP de votre projet + un petit fichier <code>version.json</code> qui pointe vers ce ZIP.
        Collez ici l'URL "Raw" du <code>version.json</code>, cliquez sur <b>Vérifier</b>, puis <b>Installer</b>. Une sauvegarde automatique est créée avant chaque mise à jour.
      </div>

      <div id="tlUpdStatus" class="tl-upd-status"></div>
      <div id="tlUpdResult"></div>
    </div>
  </div>

  <!-- Sauvegardes -->
  <div class="tl-upd-card">
    <div class="tl-upd-head">
      <div class="tl-upd-ico" style="background:linear-gradient(135deg,#f97316,#ef4444)"><i class="fas fa-history"></i></div>
      <div>
        <h3>Sauvegardes (rollback)</h3>
        <p>Restaurez une version précédente en cas de problème.</p>
      </div>
    </div>
    <div class="tl-upd-body">
      <?php if (empty($updater['backups'])): ?>
        <div class="tl-upd-help">Aucune sauvegarde disponible pour le moment. Une sauvegarde sera créée automatiquement à la prochaine mise à jour.</div>
      <?php else: ?>
        <div class="tl-upd-bk">
          <?php foreach ($updater['backups'] as $b): ?>
            <div class="tl-upd-bk-item">
              <div class="tl-upd-bk-info">
                <div class="n"><i class="fas fa-archive"></i> <?= htmlspecialchars($b['file']) ?></div>
                <div class="d"><?= htmlspecialchars($b['created']) ?> — <?= number_format($b['size'] / 1024, 1) ?> Ko</div>
              </div>
              <button class="tl-upd-btn danger" onclick="tlUpdRollback('<?= htmlspecialchars($b['file']) ?>')"><i class="fas fa-undo"></i> Restaurer</button>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</div>

<script>
var TL_UPD_ENDPOINT = 'admin/settings/update';
var TL_UPD_LATEST = null;

function tlUpdStatus(type, html) {
  var el = document.getElementById('tlUpdStatus');
  el.className = 'tl-upd-status show ' + type;
  el.innerHTML = html;
}

function tlUpdHideStatus() {
  document.getElementById('tlUpdStatus').className = 'tl-upd-status';
}

function tlUpdPost(data, cb) {
  var fd = new FormData();
  Object.keys(data).forEach(function(k) { fd.append(k, data[k]); });
  fetch(TL_UPD_ENDPOINT, { method: 'POST', body: fd, credentials: 'same-origin' })
    .then(function(r) { return r.text(); })
    .then(function(t) {
      try { cb(JSON.parse(t)); }
      catch (e) { cb({ ok: false, msg: 'Réponse invalide du serveur.' }); }
    })
    .catch(function() { cb({ ok: false, msg: 'Erreur réseau.' }); });
}

function tlUpdSave() {
  var url = document.getElementById('tlUpdUrl').value.trim();
  tlUpdStatus('warn', '<span class="tl-upd-spin" style="border-color:rgba(180,83,9,.3);border-top-color:#b45309"></span> Enregistrement…');
  tlUpdPost({ updater_action: 'save', update_url: url }, function(r) {
    tlUpdStatus(r.ok ? 'ok' : 'err', (r.ok ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-exclamation-triangle"></i> ') + r.msg);
  });
}

function tlUpdCheck() {
  var url = document.getElementById('tlUpdUrl').value.trim();
  if (!url) { tlUpdStatus('err', '<i class="fas fa-exclamation-triangle"></i> Veuillez saisir l\'URL du version.json.'); return; }
  tlUpdStatus('warn', '<span class="tl-upd-spin" style="border-color:rgba(180,83,9,.3);border-top-color:#b45309"></span> Vérification en cours…');
  document.getElementById('tlUpdResult').innerHTML = '';
  tlUpdPost({ updater_action: 'check', update_url: url }, function(r) {
    if (!r.ok) { tlUpdStatus('err', '<i class="fas fa-exclamation-triangle"></i> ' + r.msg); return; }
    TL_UPD_LATEST = r;
    tlUpdHideStatus();
    tlUpdRenderResult(r);
  });
}

function tlUpdRenderResult(r) {
  var html = '';
  if (r.has_update) {
    html += '<div class="tl-upd-banner new">'
         + '<div class="ico"><i class="fas fa-gift"></i></div>'
         + '<div style="flex:1;min-width:0">'
         + '<strong>Nouvelle version disponible : v' + r.remote + '</strong>'
         + '<span>Version actuelle : v' + r.current + (r.date ? ' • Publiée le ' + r.date : '') + '</span>'
         + '</div>'
         + '<button class="tl-upd-btn success" onclick="tlUpdInstall()"><i class="fas fa-download"></i> Installer maintenant</button>'
         + '</div>';
  } else {
    html += '<div class="tl-upd-banner ok">'
         + '<div class="ico"><i class="fas fa-check"></i></div>'
         + '<div style="flex:1;min-width:0">'
         + '<strong>Votre panel est à jour (v' + r.current + ')</strong>'
         + '<span>Aucune nouvelle version disponible pour le moment.</span>'
         + '</div>'
         + '</div>';
  }
  if (r.changelog && r.changelog.length) {
    html += '<div class="tl-upd-changelog"><h4><i class="fas fa-list-ul"></i> Notes de version</h4><ul>';
    r.changelog.forEach(function(line) { html += '<li>' + tlUpdEscape(String(line)) + '</li>'; });
    html += '</ul></div>';
  }
  document.getElementById('tlUpdResult').innerHTML = html;
}

function tlUpdEscape(s) {
  return s.replace(/[&<>"']/g, function(m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m];
  });
}

function tlUpdInstall() {
  if (!TL_UPD_LATEST) return;
  if (!confirm('Installer la version ' + TL_UPD_LATEST.remote + ' ?\n\nUne sauvegarde sera créée automatiquement. L\'opération peut prendre 30 secondes.')) return;
  tlUpdStatus('warn', '<span class="tl-upd-spin" style="border-color:rgba(180,83,9,.3);border-top-color:#b45309"></span> Téléchargement & installation en cours… ne fermez pas cette page.');
  tlUpdPost({
    updater_action: 'install',
    zip_url: TL_UPD_LATEST.zip_url,
    remote: TL_UPD_LATEST.remote,
    sha256: TL_UPD_LATEST.sha256 || ''
  }, function(r) {
    if (!r.ok) { tlUpdStatus('err', '<i class="fas fa-exclamation-triangle"></i> ' + r.msg); return; }
    tlUpdStatus('ok', '<i class="fas fa-check-circle"></i> ' + r.msg + ' (' + r.written + ' fichiers mis à jour, ' + r.skipped + ' préservés)');
    document.getElementById('tlUpdCurrent').textContent = 'v' + r.version;
    setTimeout(function() { location.reload(); }, 2500);
  });
}

function tlUpdRollback(file) {
  if (!confirm('Restaurer la sauvegarde « ' + file + ' » ?\n\nLes fichiers actuels seront écrasés par ceux de la sauvegarde.')) return;
  tlUpdStatus('warn', '<span class="tl-upd-spin" style="border-color:rgba(180,83,9,.3);border-top-color:#b45309"></span> Restauration en cours…');
  tlUpdPost({ updater_action: 'rollback', backup: file }, function(r) {
    tlUpdStatus(r.ok ? 'ok' : 'err', (r.ok ? '<i class="fas fa-check-circle"></i> ' : '<i class="fas fa-exclamation-triangle"></i> ') + r.msg);
    if (r.ok) setTimeout(function() { location.reload(); }, 2000);
  });
}
</script>
