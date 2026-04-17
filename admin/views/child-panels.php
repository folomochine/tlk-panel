<?php include 'header.php'; ?>

<div class="container-fluid">
  <div class="row">    
   <div style="overflow-x:scroll;">
   
    <table  class="table table-responsive" id="dt">
<thead>
    <tr>
<th class="p-l">ID</th>
<th>Utilisateur</th>
<th>Domaine</th>
<th>Date de creation</th>
<th>Statut</th>
<th>Actions</th>
</tr>
</thead>
    <tbody>
<?php foreach($payments as $payment): ?>
<tr>
    <td class="p-l"><?php echo $payment["id"] ?></td>
    <td><?php echo $payment["username"] ?></td>
    <td><?php echo $payment["domain"] ?></td>
    <td><?php echo $payment["created_on"]; ?></td>
    <td><?php echo $payment["child_panel_status"]; ?></td>
    <td>

<div class="dropdown pull-right">
<button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Actions <span class="caret"></span></button>
<ul class="dropdown-menu">
<li>
<a href="<?php echo site_url("admin/child-panels/".$payment["id"]."/activate");?>">Statut Actif</a>
<a href="<?php echo site_url("admin/child-panels/".$payment["id"]."/suspend");?>">Statut Suspendu</a>
</li>

</ul>
</div>
</td>
</tr>
<?php endforeach; ?>
    </tbody>
    </table>
</div>
    </div>
</div>


<?php include 'footer.php'; ?>
