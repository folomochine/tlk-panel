<?php include 'header.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
		 <div class="panel panel-default">
          <div class="panel-body">
      <form action="admin/account" method="post" enctype="multipart/form-data">
     
          <div class="form-group">
            <label for="charge_current" class="control-label">Mot de passe actuel</label>
            <input type="password" id="charge_current" class="form-control" value="" name="current_password">
          </div>

          <div class="form-group">
            <label for="charge_new" class="control-label">Nouveau mot de passe</label>
            <input type="password" id="charge_new" class="form-control" value="" name="password">
          </div>

          <div class="form-group">
            <label for="charge_confirm" class="control-label">Confirmer le mot de passe</label>
            <input type="password" id="charge_confirm" class="form-control" value="" name="confirm_password">
          </div>
          <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
      </div><br>

      </div>
</div>

    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
