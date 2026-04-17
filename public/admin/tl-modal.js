/* ============================================================
   TL-Modal — Unified admin modal helper (2026 UI)
   Global API : window.TLModal.{confirm, danger, success, warning, info}
   Intercepts :
     - [data-tl-confirm] / [data-target="#confirmChange"]
     - Native window.confirm() for elements with class .tl-confirm
   Works alongside Bootstrap 3 $.fn.modal — does NOT break existing #modalDiv behaviour.
   ============================================================ */
(function () {
  'use strict';

  // ----- Internal DOM --------------------------------------------------------
  var $root = null;

  function ensureRoot() {
    if ($root) return $root;
    $root = document.createElement('div');
    $root.id = 'tlConfirm';
    $root.innerHTML =
      '<div class="tlc-dialog" role="dialog" aria-modal="true">' +
      '  <div class="tlc-head"><div class="tlc-ico"><i class="fa fa-question"></i></div>' +
      '    <h4 class="tlc-title"></h4>' +
      '  </div>' +
      '  <div class="tlc-body"><p class="tlc-msg"></p></div>' +
      '  <div class="tlc-foot">' +
      '    <button type="button" class="tlc-btn tlc-btn-no">Annuler</button>' +
      '    <button type="button" class="tlc-btn tlc-btn-yes">Confirmer</button>' +
      '  </div>' +
      '</div>';
    document.body.appendChild($root);

    $root.querySelector('.tlc-btn-no').addEventListener('click', close);
    $root.addEventListener('click', function (e) {
      if (e.target === $root) close();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && $root.classList.contains('open')) close();
    });
    return $root;
  }

  function setVariant(kind) {
    var el = ensureRoot();
    el.classList.remove('tlc-danger', 'tlc-success', 'tlc-warning', 'tlc-info');
    if (kind) el.classList.add('tlc-' + kind);
    var ico = el.querySelector('.tlc-ico i');
    if (!ico) return;
    var map = {
      danger : 'fa-exclamation-triangle',
      success: 'fa-check',
      warning: 'fa-exclamation-circle',
      info   : 'fa-info-circle'
    };
    ico.className = 'fa ' + (map[kind] || 'fa-question');
  }

  function open(options) {
    var el = ensureRoot();
    options = options || {};
    setVariant(options.kind || 'info');
    el.querySelector('.tlc-title').textContent = options.title || 'Confirmation';
    el.querySelector('.tlc-msg').textContent   = options.message || '';
    var yes = el.querySelector('.tlc-btn-yes');
    var no  = el.querySelector('.tlc-btn-no');
    yes.textContent = options.confirmLabel || (options.kind === 'danger' ? 'Supprimer' : 'Confirmer');
    no.textContent  = options.cancelLabel  || 'Annuler';
    yes.onclick = function () {
      if (typeof options.onYes === 'function') options.onYes();
      if (!options.keepOpen) close();
    };
    el.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    if (!$root) return;
    $root.classList.remove('open');
    document.body.style.overflow = '';
  }

  // ----- Public API ----------------------------------------------------------
  var TLModal = {
    confirm : function (opts) { open(Object.assign({ kind: 'info' },    opts || {})); },
    danger  : function (opts) { open(Object.assign({ kind: 'danger' },  opts || {})); },
    success : function (opts) { open(Object.assign({ kind: 'success' }, opts || {})); },
    warning : function (opts) { open(Object.assign({ kind: 'warning' }, opts || {})); },
    info    : function (opts) { open(Object.assign({ kind: 'info' },    opts || {})); },
    close   : close
  };
  window.TLModal = TLModal;

  // Polyfill Object.assign for very old browsers
  if (typeof Object.assign !== 'function') {
    Object.assign = function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var src = arguments[i]; if (!src) continue;
        for (var k in src) if (Object.prototype.hasOwnProperty.call(src, k)) target[k] = src[k];
      }
      return target;
    };
  }

  // ----- Legacy interceptors -------------------------------------------------
  // 1) Any element with [data-tl-confirm] OR pointing to #confirmChange
  //    will open a TL-Modal danger/info dialog instead of the legacy duplicate.
  document.addEventListener('click', function (e) {
    var el = e.target.closest && e.target.closest(
      '[data-tl-confirm], [data-target="#confirmChange"], a.tl-confirm, button.tl-confirm'
    );
    if (!el) return;

    // Only intercept when this click was meant for the legacy confirmChange modal
    // (data-toggle="modal" + data-target="#confirmChange")
    var href   = el.getAttribute('data-href') || el.getAttribute('href') || '';
    if (href === '#' || href === '') {
      // nothing to do without a target URL, let default behaviour
      return;
    }

    e.preventDefault();
    e.stopPropagation();

    var title   = el.getAttribute('data-title')   || 'Confirmer l\'action';
    var message = el.getAttribute('data-message') || 'Voulez-vous vraiment continuer ?';
    var danger  = el.getAttribute('data-danger') === '1' || el.classList.contains('tl-confirm-danger');
    var label   = el.getAttribute('data-confirm-label') || (danger ? 'Oui, continuer' : 'Confirmer');

    TLModal[ danger ? 'danger' : 'confirm' ]({
      title       : title,
      message     : message,
      confirmLabel: label,
      onYes       : function () {
        // Submit form if it's a form-targeted element, else navigate
        var method = (el.getAttribute('data-method') || 'GET').toUpperCase();
        if (method === 'POST') {
          var f = document.createElement('form');
          f.method = 'POST'; f.action = href;
          document.body.appendChild(f); f.submit();
        } else {
          window.location.href = href;
        }
      }
    });
  }, true);

  // 2) Forms that previously used onsubmit="return confirm('...')"
  //    can add class="tl-confirm-form" data-message="..." to get modern UX.
  document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form || !form.classList || !form.classList.contains('tl-confirm-form')) return;
    if (form.__tlConfirmed) { form.__tlConfirmed = false; return; }
    e.preventDefault();
    TLModal.danger({
      title       : form.getAttribute('data-title')   || 'Confirmer',
      message     : form.getAttribute('data-message') || 'Voulez-vous vraiment continuer ?',
      confirmLabel: form.getAttribute('data-confirm-label') || 'Oui, supprimer',
      onYes       : function () { form.__tlConfirmed = true; form.submit(); }
    });
  }, true);

  // ----- Auto-banner injection on modal open ----------------------------------
  // Maps a trigger data-action value to a banner (icon + title + subtitle + tone).
  // Tone : default (indigo), success, warning, danger.
  // No `title` in the banner — the modal-header already shows the title.
  // Just an icon + a helpful short subtitle, tone-coloured.
  var BANNER_MAP = {
    // ----- Users -----
    new_user_v2              : { icon: 'fa-user-plus',     sub: 'Nouveau compte client sur Toutlike.' },
    new_user                 : { icon: 'fa-user-plus',     sub: 'Nouveau compte client sur Toutlike.' },
    edit_user                : { icon: 'fa-user-edit',     sub: 'Mise \u00e0 jour des informations du compte.' },
    pass_user                : { icon: 'fa-key',           sub: 'Le client devra utiliser ce mot de passe \u00e0 sa prochaine connexion.', tone: 'warning' },
    alert_user               : { icon: 'fa-bell',          sub: 'Affich\u00e9 dans le tableau de bord du client.' },
    secret_user              : { icon: 'fa-lock',          sub: 'Autoriser l\'acc\u00e8s aux services cach\u00e9s.' },
    export_user              : { icon: 'fa-download',      sub: 'Sauvegarde de la base clients.' },
    all_numbers              : { icon: 'fa-phone',         sub: 'Num\u00e9ros enregistr\u00e9s des clients.' },
    details                  : { icon: 'fa-info-circle',   sub: 'Informations compl\u00e9mentaires.' },
    set_discount_percentage  : { icon: 'fa-percent',       sub: 'Pourcentage appliqu\u00e9 sur tous les services.' },
    // ----- Services & cat\u00e9gories -----
    new_service              : { icon: 'fa-stream',        sub: 'Ajouter un service manuel ou API au catalogue.' },
    edit_service             : { icon: 'fa-edit',          sub: 'Param\u00e8tres, prix et fournisseur.' },
    edit_service_name        : { icon: 'fa-tag',           sub: 'Le libell\u00e9 visible par le client.' },
    edit_description         : { icon: 'fa-align-left',    sub: 'Description affich\u00e9e au client.' },
    edit_time                : { icon: 'fa-clock',         sub: 'Dur\u00e9e estim\u00e9e pour la commande.' },
    new_subscriptions        : { icon: 'fa-sync-alt',      sub: 'Service r\u00e9current programm\u00e9.' },
    new_category             : { icon: 'fa-folder-plus',   sub: 'Classer les services par plateforme.' },
    edit_category            : { icon: 'fa-folder',        sub: 'Nom, ic\u00f4ne et visibilit\u00e9.' },
    // ----- Orders -----
    order_comment            : { icon: 'fa-comments',      sub: 'Contenu personnalis\u00e9 de la commande.' },
    order_errors             : { icon: 'fa-exclamation-triangle', sub: 'Historique des erreurs fournisseur.', tone: 'danger' },
    order_details            : { icon: 'fa-receipt',       sub: 'Informations compl\u00e8tes de la commande.' },
    order_orderurl           : { icon: 'fa-link',          sub: 'Changer le lien de cible.' },
    order_startcount         : { icon: 'fa-play',          sub: 'Valeur de d\u00e9part de la commande.' },
    order_partial            : { icon: 'fa-adjust',        sub: 'Le client sera rembours\u00e9 au prorata.', tone: 'warning' },
    // ----- Tickets / coupons / news -----
    new_ticket               : { icon: 'fa-life-ring',     sub: 'Ouvrir une demande de support interne.' },
    edit_ticket              : { icon: 'fa-edit',          sub: 'Mise \u00e0 jour de la demande.' },
    yeni_kupon               : { icon: 'fa-ticket-alt',    sub: 'Code promo cr\u00e9dit\u00e9 sur le solde.' },
    new_news                 : { icon: 'fa-newspaper',     sub: 'Publi\u00e9e dans le tableau de bord client.' },
    edit_news                : { icon: 'fa-newspaper',     sub: 'Mise \u00e0 jour de l\'annonce.' },
    // ----- Currencies / payments -----
    'site-add-currency'      : { icon: 'fa-dollar-sign',   sub: 'Ajouter une nouvelle devise.' },
    edit_integration         : { icon: 'fa-plug',          sub: 'Param\u00e8tres de la cl\u00e9 tierce.' },
    edit_paymentmethod       : { icon: 'fa-credit-card',   sub: 'Cl\u00e9s API et options de la passerelle.' },
    import_services          : { icon: 'fa-cloud-download-alt', sub: 'R\u00e9cup\u00e9ration depuis un fournisseur API.' },
    edit_code                : { icon: 'fa-code',          sub: '\u00c9diteur de code avanc\u00e9.' },
    edit_google              : { icon: 'fa-google',        sub: 'Param\u00e8tres OAuth / API Google.' }
  };

  var lastAction = null;
  // Capture the clicked trigger's data-action just before Bootstrap opens the modal.
  document.addEventListener('click', function (e) {
    var el = e.target.closest && e.target.closest('[data-action]');
    if (el && (el.getAttribute('data-toggle') === 'modal' || el.getAttribute('data-target') || el.getAttribute('data-bs-toggle') === 'modal')) {
      lastAction = el.getAttribute('data-action');
    }
  }, true);

  function injectBanner(modalEl, action) {
    if (!modalEl || !action) return;
    if (!BANNER_MAP[action]) return;
    var info = BANNER_MAP[action];
    var body = modalEl.querySelector('.modal-body') || modalEl.querySelector('#modalContent') || modalEl.querySelector('#subsContent');
    if (!body) return;
    if (body.querySelector('.tl-banner')) return; // already injected
    var tone = info.tone ? (' ' + info.tone) : '';
    // Banner is icon + subtitle only — title stays in modal-header to avoid duplication.
    var bannerHTML =
      '<div class="tl-banner tl-banner--slim">' +
        '<div class="tl-banner-ico' + tone + '"><i class="fa ' + info.icon + '"></i></div>' +
        '<div class="tl-banner-sub">' + info.sub + '</div>' +
      '</div>';
    body.insertAdjacentHTML('afterbegin', bannerHTML);
  }

  // Observe the legacy shared modals for content injection and banner placement.
  function hookModal(id) {
    var modal = document.getElementById(id);
    if (!modal) return;
    var bodyContainer = modal.querySelector('#modalContent, #subsContent, .modal-body');
    if (!bodyContainer) return;
    var mo = new MutationObserver(function () {
      if (!lastAction) return;
      setTimeout(function () { injectBanner(modal, lastAction); }, 10);
    });
    mo.observe(bodyContainer, { childList: true, subtree: false });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () { hookModal('modalDiv'); hookModal('subsDiv'); });
  } else {
    hookModal('modalDiv'); hookModal('subsDiv');
  }
})();
