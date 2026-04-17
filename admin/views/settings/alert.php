<div>
      <form action="" method="post" enctype="multipart/form-data">

<label class="control-label">  Notifications utilisateurs</label>
<hr>
<div class="row">
          <div class="col-md-6 form-group">
            <label class="control-label">Bienvenue <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Envoyé aux nouveaux utilisateurs lors de la création de leur compte.</span></div>  </label>
            <select class="form-control" name="welcomemail">
              <option value="2" <?= $settings["alert_welcomemail"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_welcomemail"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>

          <div class="col-md-6 form-group">
            <label class="control-label">Clé API modifiée <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Envoyé aux utilisateurs lorsque leur clé API est modifiée</span></div> </label>
            <select class="form-control" name="apimail">
              <option value="2" <?= $settings["alert_apimail"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_apimail"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>

          <div class="col-md-6 form-group">
            <label class="control-label">Nouveau message <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Envoyé aux utilisateurs lorsqu'ils reçoivent un nouveau message.</span></div> </label>
            <select class="form-control" name="newmessage">
              <option value="2" <?= $settings["alert_newmessage"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_newmessage"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
</div>
<hr>
<label class="control-label">  Notifications administrateur</label> 
   <hr>
     <div class="row">
          <div class="col-md-6 form-group">
            <label class="control-label">Notification solde API</label>
            <select class="form-control" name="alert_apibalance">
              <option value="2" <?= $settings["alert_apibalance"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_apibalance"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>

          <div class="col-md-6 form-group">
            <label class="control-label">Nouveau ticket support</label>
            <select class="form-control" name="alert_newticket">
              <option value="2" <?= $settings["alert_newticket"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_newticket"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>

          <div class="col-md-6 form-group">
            <label class="control-label">Nouvelles commandes manuelles <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Envoyé périodiquement au personnel si de nouvelles commandes manuelles sont reçues.</span></div>  </label>
            <select class="form-control" name="alert_newmanuelservice">
              <option value="2" <?= $settings["alert_newmanuelservice"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_newmanuelservice"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label class="control-label">Commandes échouées <div class="tooltip5">  <span class="fas fa-info-circle"></span><span class="tooltiptext5">Envoyé périodiquement au personnel si des commandes ont le statut Échec.</span></div> </label>
            <select class="form-control" name="orderfail">
              <option value="2" <?= $settings["alert_orderfail"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_orderfail"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
          <div class="col-md-12 form-group">
            <label class="control-label">Modification du fournisseur de services</label>
            <select class="form-control" name="serviceapialert">
              <option value="2" <?= $settings["alert_serviceapialert"] == 2 ? "selected" : null; ?> >Activé</option>
              <option value="1" <?= $settings["alert_serviceapialert"] == 1 ? "selected" : null; ?>>Désactivé</option>
            </select>
          </div>
		 <div class="col-md-12 form-group">
            <label class="control-label">E-mail SMTP</label>
            <input type="text" class="form-control" name="admin_mail" value="<?=$settings["admin_mail"]?>">
			 
          </div>

      
        </div>
      <div class="row">
          <div class="form-group col-md-6">
            <label class="control-label">E-mail</label>
            <input type="text" class="form-control" name="smtp_user" value="<?=$settings["smtp_user"]?>">
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Mot de passe e-mail</label>
            <input type="text" class="form-control" name="smtp_pass" value="<?=$settings["smtp_pass"]?>">
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Serveur SMTP</label>
            <input type="text" class="form-control" name="smtp_server" value="<?=$settings["smtp_server"]?>">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Port SMTP</label>
            <input type="text" class="form-control" name="smtp_port" value="<?=$settings["smtp_port"]?>">
          </div>
          <div class="col-md-3 form-group">
            <label class="control-label">Protocole SMTP</label>
            <select class="form-control" name="smtp_protocol">
              <option value="0" <?= $settings["smtp_protocol"] == 0 ? "selected" : null; ?> >Aucun</option>
              <option value="tls" <?= $settings["smtp_protocol"] == "tls" ? "selected" : null; ?>>TLS</option>
              <option value="ssl" <?= $settings["smtp_protocol"] == "ssl" ? "selected" : null; ?>>SSL</option>
            </select>
          </div>
        </div>
 <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
      

            </table>
        </div>
    </div>

</form>
