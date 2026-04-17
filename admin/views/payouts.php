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
<th class="p-l">#</th>
<th>Code</th>
<th>Utilisateur</th>
<th>Montant demandé</th>
<th>Statut</th>
<th>Date de demande</th>
<th>Date de mise à jour</th>
<th>Actions</th>
</tr>
</thead>
<form id="changebulkForm" action="<?php echo site_url("admin/payouts") ?>" method="post">
<tbody>
<?php foreach ($referral_payouts as $referral_payout) : ?>
<tr>
<td><?php echo $referral_payout["r_p_id"] ?></td>
<td><?php echo $referral_payout["r_p_code"] ?></td>
<td><?php echo $referral_payout["username"] ?></td>
<td><?php echo $referral_payout["r_p_amount_requested"] ?></td>
<td><?php if ($referral_payout["r_p_status"] == 0) {
    echo '<span class="label label-warning">En attente</span>';
} elseif ($referral_payout["r_p_status"] == 1) {
    echo '<span class="label label-danger">Refusé</span>';
} elseif ($referral_payout["r_p_status"] == 2) {
    echo '<span class="label label-success">Approuvé</span>';
} else {
    echo '<span class="label label-default">Rejeté</span>';
} ?></td>
<td><?php echo $referral_payout["r_p_requested_at"] ?></td>
<td><?php echo $referral_payout["r_p_updated_at"] ?></td>
<td class="service-block__action">
<div class="dropdown pull-right">
<button type="button" class="btn btn-primary btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Action</button>
<ul class="dropdown-menu">
<?php if ($referral_payout["r_p_status"] == 0) : ?>
<li><a href="<?= site_url("admin/payouts?approve=" . $referral_payout["r_p_id"]) ?>">Approuver</a></li>
<li><a href="<?= site_url("admin/payouts?disapprove=" . $referral_payout["r_p_id"]) ?>">Refuser</a></li>
<li><a href="<?= site_url("admin/payouts?reject=" . $referral_payout["r_p_id"]) ?>">Rejeter</a></li>
<?php else : ?>
<li><a href="javascript:void(0)">Aucune action disponible</a></li>
<?php endif; ?>
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
