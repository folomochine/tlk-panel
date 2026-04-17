<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administration — <?php echo htmlspecialchars($settings["site_name"]); ?></title>
  <?php if (!empty($settings['favicon'])): ?>
    <link rel="icon" href="<?php echo $settings['favicon']; ?>" type="image/png">
  <?php endif; ?>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --bg:#050a18;--card:#0f172a;--border:#1e293b;
      --primary:#3b82f6;--primary-g:rgba(59,130,246,.12);--hover:#2563eb;--accent:#a855f7;
      --text:#f1f5f9;--muted:#94a3b8;--dim:#64748b;
      --input:#1e293b;--input-b:#334155;
      --danger-bg:rgba(239,68,68,.1);--danger-b:rgba(239,68,68,.25);--danger-t:#fca5a5;
      --ok-bg:rgba(34,197,94,.1);--ok-b:rgba(34,197,94,.25);--ok-t:#86efac;
    }
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:var(--bg);color:var(--text);line-height:1.6;min-height:100vh;display:flex;flex-direction:column;overflow-x:hidden}

    /* BACKGROUND */
    .bg-wrap{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
    .bg-blob{position:absolute;border-radius:50%;filter:blur(80px);opacity:.12}
    .bg-blob-1{width:500px;height:500px;background:var(--primary);top:-15%;right:-10%}
    .bg-blob-2{width:400px;height:400px;background:var(--accent);bottom:-10%;left:-8%}
    .bg-grid{position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.03) 1px,transparent 1px);background-size:32px 32px}

    /* LAYOUT */
    .page{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 20px;position:relative;z-index:1}

    /* CARD */
    .lcard{width:100%;max-width:420px;background:var(--card);border:1px solid var(--border);border-radius:16px;padding:36px 30px;position:relative;overflow:hidden}
    .lcard::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--primary),var(--accent))}

    /* LOGO */
    .logo-area{text-align:center;margin-bottom:24px}
    .logo-area img{max-height:40px;margin-bottom:12px}
    .logo-area h1{font-size:20px;font-weight:700;margin-bottom:4px}
    .logo-area p{font-size:13px;color:var(--muted)}

    /* SHIELD ICON */
    .shield{width:52px;height:52px;margin:0 auto 14px;background:var(--primary-g);border:1px solid rgba(59,130,246,.2);border-radius:14px;display:flex;align-items:center;justify-content:center}
    .shield svg{width:26px;height:26px;color:var(--primary)}

    /* ALERTS */
    .alert{padding:10px 14px;border-radius:8px;margin-bottom:16px;font-size:13px;font-weight:500}
    .alert-err{background:var(--danger-bg);border:1px solid var(--danger-b);color:var(--danger-t)}
    .alert-ok{background:var(--ok-bg);border:1px solid var(--ok-b);color:var(--ok-t)}

    /* FORM */
    .fg{margin-bottom:14px}
    .fg label{display:block;font-size:12px;font-weight:500;color:var(--muted);margin-bottom:5px}
    .input-wrap{position:relative}
    .input-wrap svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:var(--dim);pointer-events:none}
    .fg input[type=text],.fg input[type=password],.fg input[type=number]{
      width:100%;padding:11px 14px 11px 38px;background:var(--input);border:1px solid var(--input-b);
      border-radius:8px;color:var(--text);font-size:14px;outline:none;transition:.2s}
    .fg input:focus{border-color:var(--primary)}
    .fg input::placeholder{color:var(--dim)}
    /* Hide number spinners */
    .fg input[type=number]::-webkit-inner-spin-button,.fg input[type=number]::-webkit-outer-spin-button{-webkit-appearance:none;margin:0}
    .fg input[type=number]{-moz-appearance:textfield}

    /* 2FA SECTION */
    .tfa-section{border-top:1px solid var(--border);margin-top:6px;padding-top:14px}
    .tfa-label{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--dim);margin-bottom:8px;display:flex;align-items:center;gap:6px}
    .tfa-label svg{width:14px;height:14px;color:var(--accent)}

    /* CHECKBOX */
    .form-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;font-size:12px;margin-top:18px}
    .checkbox-r{display:flex;align-items:center;gap:6px;color:var(--muted);cursor:pointer}
    .checkbox-r input{width:15px;height:15px;accent-color:var(--primary);cursor:pointer}

    /* BUTTON */
    .btn-login{width:100%;padding:13px;background:var(--primary);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;transition:.2s;letter-spacing:.3px;display:flex;align-items:center;justify-content:center;gap:8px}
    .btn-login:hover{background:var(--hover)}
    .btn-login svg{width:18px;height:18px}

    /* BACK LINK */
    .back-link{text-align:center;margin-top:18px;font-size:12px;color:var(--dim)}
    .back-link a{color:var(--primary);text-decoration:none;font-weight:600}
    .back-link a:hover{text-decoration:underline}

    /* FOOTER */
    .login-footer{text-align:center;padding:16px 20px;font-size:11px;color:var(--dim);position:relative;z-index:1}

    /* ANIMATIONS */
    @keyframes fu{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
    .lcard{animation:fu .6s ease forwards}

    /* RESPONSIVE */
    @media(max-width:480px){
      .lcard{padding:28px 20px;border-radius:12px}
      .page{padding:24px 14px}
    }
  </style>
</head>
<body>

<div class="bg-wrap">
  <div class="bg-blob bg-blob-1"></div>
  <div class="bg-blob bg-blob-2"></div>
  <div class="bg-grid"></div>
</div>

<div class="page">
  <div class="lcard">

    <div class="logo-area">
      <div class="shield">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
      </div>
      <?php if (!empty($settings['site_logo'])): ?>
        <img src="<?php echo $settings['site_logo']; ?>" alt="<?php echo htmlspecialchars($settings['site_name']); ?>">
      <?php endif; ?>
      <h1>Administration</h1>
      <p>Connectez-vous au panneau d'administration</p>
    </div>

    <?php if (!empty($success)): ?>
      <div class="alert alert-ok"><?php echo $successText; ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-err"><?php echo $errorText; ?></div>
    <?php endif; ?>

    <form method="post" action="#" autocomplete="off">

      <div class="fg">
        <label for="username">Nom d'utilisateur</label>
        <div class="input-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <input type="text" id="username" name="username" placeholder="Entrez votre identifiant" autofocus required>
        </div>
      </div>

      <div class="fg">
        <label for="password">Mot de passe</label>
        <div class="input-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
          <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
        </div>
      </div>

      <div class="tfa-section">
        <div class="tfa-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Authentification à deux facteurs
        </div>
        <div class="fg" style="margin-bottom:0">
          <div class="input-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/></svg>
            <input type="number" id="two_factor_code" name="two_factor_code" placeholder="Code 2FA (si activé)">
          </div>
        </div>
      </div>

      <div class="form-row">
        <label class="checkbox-r">
          <input type="checkbox" name="remember" id="remember" value="1">
          Se souvenir de moi
        </label>
      </div>

      <button type="submit" class="btn-login">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Se connecter
      </button>

    </form>

    <div class="back-link">
      <a href="/">&larr; Retour au site</a>
    </div>

  </div>
</div>

<div class="login-footer">
  &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($settings['site_name']); ?> — Administration
</div>

</body>
</html>
