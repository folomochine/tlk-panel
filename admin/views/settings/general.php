<div>
  <div class="panel panel-default smmpanelbdlab-panel">
    <div class="panel-body smmpanelbdlab-settings-form">
    
      <form action="" method="post" enctype="multipart/form-data">
        <!-- Branding Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-branding-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-paint-brush"></i> Identité</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
  <div class="row">
    <div class="col-md-10">
      <label for="preferenceLogo" class="control-label">Logo du site</label>
      <div class="smmpanelbdlab-file-input">
        <span class="smmpanelbdlab-file-label">Choisir un fichier</span>
        <input type="file" name="logo" id="preferenceLogo" class="smmpanelbdlab-file-control" accept="image/*">
      </div>
      <small class="form-text text-muted">Taille recommandée : 180×50px (PNG ou JPG)</small>
    </div>
    <div class="col-md-2 text-right">
      <?php if($settings["site_logo"]): ?>
        <div class="smmpanelbdlab-image-preview" id="currentLogoPreview">
          <img class="img-thumbnail" src="<?=$settings["site_logo"]?>">
          <a href="" class="smmpanelbdlab-remove-btn" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-logo")?>">
            <i class="fas fa-times-circle"></i>
          </a>
        </div>
      <?php endif; ?>
      <div class="smmpanelbdlab-image-preview d-none" id="newLogoPreview">
        <img class="img-thumbnail" id="logoPreviewImage" src="#" alt="Logo preview">
        <button type="button" class="smmpanelbdlab-remove-btn" id="cancelLogoUpload">
          <i class="fas fa-times-circle"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="form-group smmpanelbdlab-form-group">
  <div class="row">
    <div class="col-md-10">
      <label for="preferenceFavicon" class="control-label">Favicon du site</label>
      <div class="smmpanelbdlab-file-input">
        <span class="smmpanelbdlab-file-label">Choisir un fichier</span>
        <input type="file" name="favicon" id="preferenceFavicon" class="smmpanelbdlab-file-control" accept="image/*">
      </div>
      <small class="form-text text-muted">Taille recommandée : 32×32px (ICO ou PNG)</small>
    </div>
    <div class="col-md-2 text-right">
      <?php if($settings["favicon"]): ?>
        <div class="smmpanelbdlab-image-preview" id="currentFaviconPreview">
          <img class="img-thumbnail" src="<?=$settings["favicon"]?>">
          <a href="" class="smmpanelbdlab-remove-btn" data-toggle="modal" data-target="#confirmChange" data-href="<?=site_url("admin/settings/general/delete-favicon")?>">
            <i class="fas fa-times-circle"></i>
          </a>
        </div>
      <?php endif; ?>
      <div class="smmpanelbdlab-image-preview d-none" id="newFaviconPreview">
        <img class="img-thumbnail" id="faviconPreviewImage" src="#" alt="Favicon preview">
        <button type="button" class="smmpanelbdlab-remove-btn" id="cancelFaviconUpload">
          <i class="fas fa-times-circle"></i>
        </button>
      </div>
    </div>
  </div>
</div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Nom du panel</label>
            <input type="text" class="form-control smmpanelbdlab-input" name="name" value="<?=$settings["site_name"]?>">
          </div>
        </div>
        
        <!-- System Status Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-status-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-cog"></i> Statut système</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Mode maintenance</label>
            <select class="form-control smmpanelbdlab-select" name="site_maintenance">
              <option value="2" <?= $settings["site_maintenance"] == 2 ? "selected" : null; ?>>Inactif</option>
              <option value="1" <?= $settings["site_maintenance"] == 1 ? "selected" : null; ?>>Actif</option>
            </select>
          </div>
        </div>
        
          <!-- Google Login Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-google-section">
          <h4 class="smmpanelbdlab-section-title"><svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
  <g fill="none" fill-rule="evenodd">
    <path d="M17.64 9.2045c0-.6381-.0573-1.2518-.1636-1.8409H9v3.4818h4.8436c-.2086 1.125-.8427 2.0782-1.7772 2.7218v2.2582h2.9087c1.7018-1.5668 2.6836-3.8741 2.6836-6.621z" fill="#4285F4"></path>
    <path d="M9 18c2.43 0 4.47-.806 5.96-2.181l-2.909-2.258c-.806.54-1.836.86-3.05.86-2.345 0-4.328-1.581-5.036-3.712H.957v2.332C2.44 16.512 5.482 18 9 18z" fill="#34A853"></path>
    <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71s.102-1.17.282-1.71V4.958H.957C.347 6.175 0 7.55 0 9s.347 2.825.957 4.042l3.007-2.332z" fill="#FBBC05"></path>
    <path d="M9 3.579c1.321 0 2.508.454 3.44 1.345l2.582-2.582C13.463.891 11.426 0 9 0 5.48 0 2.44 1.488.957 3.958L3.964 6.29C4.672 4.159 6.655 3.58 9 3.58z" fill="#EA4335"></path>
</g>
</svg> Connexion Google</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <div class="form-group" style="margin-bottom: 15px;">
        <label class="control-label" style="font-weight: bold; color: var(--text);">Client ID</label>
        <input type="text" class="form-control" name="clientid" value="<?=$settings["client_id"]?>" style="border-radius: 5px; border: 1px solid var(--border);">
    </div>
    <div class="form-group" style="margin-bottom: 15px;">
        <label class="control-label" style="font-weight: bold; color: var(--text);">Client Secret</label>
        <input type="text" class="form-control" name="clientsecret" value="<?=$settings["client_secret"]?>" style="border-radius: 5px; border: 1px solid var(--border);">
          </div>
        </div></div>
        
        <!-- Membership Levels Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-membership-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-medal"></i> Niveaux de membre</h4>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Membre Bronze</label>
                <div class="smmpanelbdlab-input-group">
                  <span class="smmpanelbdlab-input-addon">$</span>
                  <input type="text" class="form-control smmpanelbdlab-input" name="bronz_statu" value="<?=$settings["bronz_statu"]?>">
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Membre Argent</label>
                <div class="smmpanelbdlab-input-group">
                  <span class="smmpanelbdlab-input-addon">$</span>
                  <input type="text" class="form-control smmpanelbdlab-input" name="silver_statu" value="<?=$settings["silver_statu"]?>">
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Membre Or</label>
                <div class="smmpanelbdlab-input-group">
                  <span class="smmpanelbdlab-input-addon">$</span>
                  <input type="text" class="form-control smmpanelbdlab-input" name="gold_statu" value="<?=$settings["gold_statu"]?>">
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Revendeur</label>
                <div class="smmpanelbdlab-input-group">
                  <span class="smmpanelbdlab-input-addon">$</span>
                  <input type="text" class="form-control smmpanelbdlab-input" name="bayi_statu" value="<?=$settings["bayi_statu"]?>">
                </div>
              </div>
            </div>
          </div>
          
          <div class="smmpanelbdlab-help-block">
            <i class="fas fa-info-circle"></i> Entrez le montant minimum de dépenses requis pour chaque niveau de membre.
          </div>
        </div>
        
        <!-- Security Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-security-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-shield-alt"></i> Sécurité</h4>
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Réinitialisation du mot de passe</label>
                <select class="form-control smmpanelbdlab-select" name="resetpass">
                  <option value="2" <?= $settings["resetpass_page"] == "2" ? "selected" : null; ?>>Activé</option>
                  <option value="1" <?= $settings["resetpass_page"] == "1" ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Réinitialisation SMS</label>
                <select class="form-control smmpanelbdlab-select" name="resetsms">
                  <option value="2" <?= $settings["resetpass_sms"] == "2" ? "selected" : null; ?>>Activé</option>
                  <option value="1" <?= $settings["resetpass_sms"] == "1" ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Réinitialisation par e-mail</label>
                <select class="form-control smmpanelbdlab-select" name="resetmail">
                  <option value="2" <?= $settings["resetpass_email"] == "2" ? "selected" : null; ?>>Activé</option>
                  <option value="1" <?= $settings["resetpass_email"] == "1" ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Ticket System Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-ticket-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-ticket-alt"></i> Système de tickets</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Statut du système de tickets</label>
            <select class="form-control smmpanelbdlab-select" name="ticket_system">
              <option value="1" <?= $settings["ticket_system"] == "1" ? "selected" : null; ?>>Activé</option>
              <option value="2" <?= $settings["ticket_system"] == "2" ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Max tickets en attente</label>
            <select class="form-control smmpanelbdlab-select" name="tickets_per_user">
              <?php for($i=1; $i<=10; $i++): ?>
                <option value="<?=$i?>" <?= $settings["tickets_per_user"] == $i ? "selected" : null; ?>><?=$i?></option>
              <?php endfor; ?>
              <option value="9999999999" <?= $settings["tickets_per_user"] == 9999999999 ? "selected" : null; ?>>Illimité</option>
            </select>
          </div>
        </div>
        
        <!-- Registration Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-registration-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-user-plus"></i> Paramètres d'inscription</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Page d'inscription</label>
            <select class="form-control smmpanelbdlab-select" name="registration_page">
              <option value="2" <?= $settings["register_page"] == "2" ? "selected" : null; ?>>Activé</option>
              <option value="1" <?= $settings["register_page"] == "1" ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
          
          <div class="row">
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Champs nom</label>
                <select class="form-control smmpanelbdlab-select" name="name_fileds">
                  <option value="1" <?= $settings["name_fileds"] == 1 ? "selected" : null; ?>>Activé</option>
                  <option value="2" <?= $settings["name_fileds"] == 2 ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Champs Skype</label>
                <select class="form-control smmpanelbdlab-select" name="skype_feilds">
                  <option value="1" <?= $settings["skype_feilds"] == 1 ? "selected" : null; ?>>Activé</option>
                  <option value="2" <?= $settings["skype_feilds"] == 2 ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group smmpanelbdlab-form-group">
                <label class="control-label">Confirmation par e-mail</label>
                <select class="form-control smmpanelbdlab-select" name="email_confirmation">
                  <option value="1" <?= $settings["email_confirmation"] == 1 ? "selected" : null; ?>>Activé</option>
                  <option value="2" <?= $settings["email_confirmation"] == 2 ? "selected" : null; ?>>Désactivé</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Frais de transfert (%)</label>
            <input type="number" class="form-control smmpanelbdlab-input" name="fundstransfer_fees" value="<?=$settings["fundstransfer_fees"]?>">
          </div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Max renvois de lien</label>
            <input type="text" class="form-control smmpanelbdlab-input" name="resend_max" value="<?=$settings["resend_max"]?>">
          </div>
        </div>
        
        <!-- Service Settings Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-service-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-list-alt"></i> Paramètres des services</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Visibilité de la liste des services</label>
            <select class="form-control smmpanelbdlab-select" name="service_list">
              <option value="2" <?= $settings["service_list"] == "2" ? "selected" : null; ?>>Public (tout le monde)</option>
              <option value="1" <?= $settings["service_list"] == "1" ? "selected" : null; ?>>Privé (utilisateurs uniquement)</option>
            </select>
          </div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Afficher le temps moyen</label>
            <select class="form-control smmpanelbdlab-select" name="services_average_time">
              <option value="1" <?= $settings["services_average_time"] == "1" ? "selected" : null; ?>>Activé</option>
              <option value="0" <?= $settings["services_average_time"] == "0" ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
        </div>
        
        <!-- Custom Code Section -->
        <div class="smmpanelbdlab-setting-section smmpanelbdlab-code-section">
          <h4 class="smmpanelbdlab-section-title"><i class="fas fa-code"></i> Code personnalisé</h4>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Code d'en-tête</label>
            <textarea class="form-control smmpanelbdlab-textarea" rows="5" name="custom_header" placeholder='<style type="text/css">...</style>'><?=$settings["custom_header"]?></textarea>
          </div>
          
          <div class="form-group smmpanelbdlab-form-group">
            <label class="control-label">Code de pied de page</label>
            <textarea class="form-control smmpanelbdlab-textarea" rows="5" name="custom_footer" placeholder='<script>...</script>'><?=$settings["custom_footer"]?></textarea>
          </div>
        </div>
        
        <div class="smmpanelbdlab-form-actions">
          <button type="submit" class="btn smmpanelbdlab-btn-primary">
            <i class="fas fa-save"></i> Mettre à jour les paramètres
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal smmpanelbdlab-modal fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="confirmChangeLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmChangeLabel">Confirmer l'action</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Êtes-vous sûr de vouloir effectuer cette action ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn smmpanelbdlab-btn-secondary" data-dismiss="modal">Annuler</button>
        <a href="#" class="btn smmpanelbdlab-btn-danger" id="confirmYes">Confirmer</a>
      </div>
    </div>
  </div>
</div>

<style>
.smmpanelbdlab-panel {
  border: 1px solid var(--border);
  border-radius: 14px;
  background: var(--card);
  box-shadow: var(--shadow);
  margin-bottom: 24px;
}
.smmpanelbdlab-settings-form { padding: 20px; }
.smmpanelbdlab-section-title {
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 16px;
  padding-bottom: 10px;
  border-bottom: 1px solid var(--border);
  color: var(--text);
}
.smmpanelbdlab-section-title i { margin-right: 10px; color: var(--primary); }
.smmpanelbdlab-setting-section {
  background: var(--card);
  border-radius: 12px;
  padding: 18px;
  margin-bottom: 16px;
  border: 1px solid var(--border);
}
.smmpanelbdlab-branding-section,
.smmpanelbdlab-status-section,
.smmpanelbdlab-google-section,
.smmpanelbdlab-membership-section,
.smmpanelbdlab-security-section,
.smmpanelbdlab-ticket-section,
.smmpanelbdlab-registration-section,
.smmpanelbdlab-service-section,
.smmpanelbdlab-code-section { border-left: 3px solid var(--primary); }
.smmpanelbdlab-form-group { margin-bottom: 16px; }
.smmpanelbdlab-input,
.smmpanelbdlab-select,
.smmpanelbdlab-textarea {
  border-radius: 10px;
  border: 1px solid var(--border);
  padding: 10px 14px;
  height: auto;
  box-shadow: none;
  background: var(--card);
  color: var(--text);
  transition: all .2s;
}
.smmpanelbdlab-input:focus,
.smmpanelbdlab-select:focus,
.smmpanelbdlab-textarea:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(59,130,246,.15);
  outline: none;
}
.smmpanelbdlab-select {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 15px;
}
.smmpanelbdlab-textarea { min-height: 120px; }
.smmpanelbdlab-file-input { position: relative; display: inline-block; width: 100%; }
.smmpanelbdlab-file-label {
  display: block;
  padding: 10px 15px;
  background: var(--bg);
  border: 1px dashed var(--border);
  border-radius: 10px;
  text-align: center;
  cursor: pointer;
  transition: .2s;
  color: var(--muted);
}
.smmpanelbdlab-file-label:hover { border-color: var(--primary); color: var(--primary); }
.smmpanelbdlab-file-control { position: absolute; left: 0; top: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
.smmpanelbdlab-image-preview { position: relative; width: 80px; height: 80px; margin-left: auto; margin-bottom: 10px; }
.smmpanelbdlab-image-preview img { width: 100%; height: 100%; object-fit: contain; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); }
.smmpanelbdlab-remove-btn { position: absolute; top: -10px; right: -10px; width: 25px; height: 25px; background: var(--red); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; cursor: pointer; border: none; }
.smmpanelbdlab-input-group { display: flex; }
.smmpanelbdlab-input-addon { padding: 10px 15px; background: var(--bg); border: 1px solid var(--border); border-right: none; border-radius: 10px 0 0 10px; color: var(--muted); }
.smmpanelbdlab-input-group .smmpanelbdlab-input { border-radius: 0 10px 10px 0; flex: 1; }
.smmpanelbdlab-help-block { background: rgba(59,130,246,.08); padding: 10px 15px; border-radius: 10px; font-size: 13px; color: var(--muted); margin-top: 10px; border: 1px solid rgba(59,130,246,.2); }
.smmpanelbdlab-help-block i { margin-right: 5px; color: var(--primary); }
.smmpanelbdlab-btn-primary { background: var(--primary); color: #fff; border: 1px solid var(--primary); padding: 10px 25px; border-radius: 10px; font-weight: 600; transition: .2s; }
.smmpanelbdlab-btn-primary:hover { background: var(--hover); border-color: var(--hover); color: #fff; }
.smmpanelbdlab-btn-secondary { background: var(--card); color: var(--text); border: 1px solid var(--border); padding: 8px 20px; border-radius: 10px; transition: .2s; }
.smmpanelbdlab-btn-secondary:hover { border-color: var(--primary); color: var(--primary); background: rgba(59,130,246,.08); }
.smmpanelbdlab-btn-danger { background: var(--red); color: #fff; border: 1px solid var(--red); padding: 8px 20px; border-radius: 10px; transition: .2s; }
.smmpanelbdlab-btn-danger:hover { background: #dc2626; border-color: #dc2626; color: #fff; }
.smmpanelbdlab-form-actions { margin-top: 20px; text-align: right; }
.smmpanelbdlab-modal .modal-content { border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow-lg); background: var(--card); }
.smmpanelbdlab-modal .modal-header { border-bottom: 1px solid var(--border); padding: 15px 20px; }
.smmpanelbdlab-modal .modal-title { font-weight: 700; color: var(--text); }
.smmpanelbdlab-modal .modal-body { padding: 20px; color: var(--text); }
.smmpanelbdlab-modal .modal-footer { border-top: 1px solid var(--border); padding: 15px 20px; }
body.dark-mode .smmpanelbdlab-settings-form .form-control,
body.dark-mode .smmpanelbdlab-settings-form input,
body.dark-mode .smmpanelbdlab-settings-form select,
body.dark-mode .smmpanelbdlab-settings-form textarea {
  background: rgba(30,41,59,.92) !important;
  border-color: var(--border) !important;
  color: var(--text) !important;
}
body.dark-mode .smmpanelbdlab-settings-form .control-label,
body.dark-mode .smmpanelbdlab-settings-form small,
body.dark-mode .smmpanelbdlab-settings-form .text-muted {
  color: var(--muted) !important;
}
#logoPreviewImage, #faviconPreviewImage { display: none; }
.d-none { display: none !important; }
@media (max-width: 768px) { .smmpanelbdlab-settings-form { padding: 15px; } .smmpanelbdlab-setting-section { padding: 15px; } .smmpanelbdlab-form-actions { text-align: center; } }
@media (max-width: 576px) { .smmpanelbdlab-section-title { font-size: 16px; } .smmpanelbdlab-input, .smmpanelbdlab-select { padding: 8px 12px; } }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const logoInput = document.getElementById('preferenceLogo');
  const logoPreview = document.getElementById('newLogoPreview');
  const logoPreviewImage = document.getElementById('logoPreviewImage');
  const cancelLogoBtn = document.getElementById('cancelLogoUpload');
  const currentLogoPreview = document.getElementById('currentLogoPreview');

  logoInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        logoPreview.classList.remove('d-none');
        logoPreviewImage.src = e.target.result;
        logoPreviewImage.style.display = 'block';
        if (currentLogoPreview) { currentLogoPreview.classList.add('d-none'); }
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  cancelLogoBtn.addEventListener('click', function() {
    logoInput.value = '';
    logoPreview.classList.add('d-none');
    logoPreviewImage.style.display = 'none';
    if (currentLogoPreview) { currentLogoPreview.classList.remove('d-none'); }
  });

  const faviconInput = document.getElementById('preferenceFavicon');
  const faviconPreview = document.getElementById('newFaviconPreview');
  const faviconPreviewImage = document.getElementById('faviconPreviewImage');
  const cancelFaviconBtn = document.getElementById('cancelFaviconUpload');
  const currentFaviconPreview = document.getElementById('currentFaviconPreview');

  faviconInput.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        faviconPreview.classList.remove('d-none');
        faviconPreviewImage.src = e.target.result;
        faviconPreviewImage.style.display = 'block';
        if (currentFaviconPreview) { currentFaviconPreview.classList.add('d-none'); }
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  cancelFaviconBtn.addEventListener('click', function() {
    faviconInput.value = '';
    faviconPreview.classList.add('d-none');
    faviconPreviewImage.style.display = 'none';
    if (currentFaviconPreview) { currentFaviconPreview.classList.remove('d-none'); }
  });
});
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
  $('#confirmChange').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var url = button.data('href');
    var modal = $(this);
    modal.find('#confirmYes').attr('href', url);
  });
});
</script>
