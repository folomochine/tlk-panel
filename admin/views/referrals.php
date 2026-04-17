<?php include 'header.php'; ?>
<div class="container-fluid">
<ul class="nav nav-tabs">
<li class="<?php if(route(1)=='referrals') echo 'active'; ?>"><a href="<?= site_url('admin/referrals') ?>">Affiliations</a></li>
<li class="<?php if(route(1)=='payouts') echo 'active'; ?>"><a href="<?= site_url('admin/payouts') ?>">Demandes de paiement</a></li>
<li class="pull-right p-b">
<form class="form-inline" action="" method="GET">
<div class="input-group">
<input type="text" name="search" class="form-control" placeholder="Rechercher">
<input type="hidden" name="type" value="referrals">
<span class="input-group-btn">
<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
</span>
</div>
</form>
</li>
</ul>
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th class="p-l">ID</th>
<th>Utilisateur</th>
<th>Visites totales</th>
<th>Inscriptions</th>
<th>Taux de conversion</th>
<th>Fonds totaux</th>
<th>Commission gagnée</th>
<th>Commission demandée</th>
<th>Commission totale</th>
<th>Statut</th>
<th>Actions</th>
</tr>
</thead>
<form id="changebulkForm" action="<?php echo site_url("admin/payments/online/multi-action") ?>" method="post">
<tbody>
<?php foreach ($referrals as $referral) : ?>
<tr>
<td><?php echo $referral["referral_id"] ?></td>
<td><?php echo $referral["username"] ?></td>
<td><?php echo $referral["referral_clicks"] ?></td>
<td><?php echo $referral["referral_sign_up"] ?></td>
<td><?php echo ($referral["referral_sign_up"]/$referral["referral_clicks"])*100 ?>%</td>
<td><?php echo $referral["referral_totalFunds_byReffered"] ?></td>
<td><?php echo $referral["referral_earned_commision"] ?></td>
<td><?php echo $referral["referral_requested_commision"] ?></td>
<td><?php echo $referral["referral_total_commision"] ?></td>
<td><?php if($referral["referral_status"]==2){echo '<span class="label label-success">Actif</span>';}else{echo '<span class="label label-default">Inactif</span>';}  ?></td>
<td class="service-block__action">
<div class="dropdown pull-right">
<button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
<ul class="dropdown-menu">
<li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="reffered_users" data-id="<?php echo $referral["referral_code"] ?>">Voir les affiliés</a></li>
</ul>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
<input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
</form>
</table>
</div>
</div>

<?php include 'footer.php'; ?>
