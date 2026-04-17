<?php require 'header.php'; ?>

<div class="container-fluid">
    <div class="col-md-12">


        <ul class="nav nav-tabs p-b">


<li class="pull-right p-b">
<?php if (route(2) == "admins") : ?>
<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalDiv" data-action="add_admin">Ajouter un admin</button>
<?php endif; ?>


</li>
</ul>

<?php if (route(2) == "admins") : ?>

<div class="row">
<center>
    <h3><strong>Super Administrateur</strong></h3>
</center>
<div  style="overflow:scroll;height:140px;" class="">

<table  class="table">
    <thead>
        <tr>

<th>Nom</th>
            <th>E-mail</th>
            <th>Nom d'utilisateur</th>
            <th>Statut</th>


<th nowrap="">Date de creation</th>
<th nowrap="">Derniere connexion</th>

            <th></th>
        </tr>
    </thead>



    <tbody>
        <?php foreach ($admins as $mainadmin): ?>



                <tr>

<td><?php echo $mainadmin["admin_name"] ?></td>
<td><?php echo $mainadmin["admin_email"] ?></td>
<td><?php echo $mainadmin["username"] ?></td>
<td><?php echo $mainadmin["client_type"] == 2 ? "Actif"  : "Inactif" ?></td>

<td><?php echo $mainadmin["register_date"] ?></td>
<td><?php echo $mainadmin["login_date"] ?></td>


<td class="td-caret">
    <div class="dropdown pull-right">
        <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown" aria-expanded="true">
          Actions <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">

            <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="edit_admin" data-id="<?php echo $mainadmin["admin_id"] ?>">Modifier le compte</a></li>


        </ul>
    </div>
</td>
                </tr>
        
   <?php    endforeach; ?>



    </tbody>
</table>
                </div>
<center>
    <h3><strong>Personnel</strong></h3>
</center>
<div style="overflow:scroll;"><br>




<table class="table">
    <thead>
        <tr>

            <th>Nom</th>
            <th>E-mail</th>
            <th>Nom d'utilisateur</th>
            <th>Statut</th>

            <th nowrap="">Date de creation</th>
            <th nowrap="">Derniere connexion</th>

            <th></th>
        </tr>
    </thead>



    <tbody>

        <?php foreach ($staffsData as $staff ) : ?>



                <tr>

<td><?php echo $staff["admin_name"] ?></td>
<td><?php echo $staff["admin_email"] ?></td>
<td><?php echo $staff["username"] ?></td>
<td><?php echo $staff["client_type"] == 2 ? "Actif"  : "Inactif" ?></td>

<td><?php echo $staff["register_date"] ?></td>
<td><?php echo $staff["login_date"] ?></td>




                <td class="td-caret">
<div class="dropdown pull-right">
    <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown"
    data-boundary="window"
    aria-haspopup="true"
    aria-expanded="false">
      Actions <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">

        <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="edit_admin" data-id="<?php echo $staff["admin_id"] ?>">Modifier le compte</a></li>
        <li><a href="#" data-toggle="modal" data-target="#modalDiv" data-action="edit_admin_password" data-id="<?php echo $staff["admin_id"] ?>">Changer le mot de passe</a></li>
<li><a href="/admin/manager/admins/delete_staff/<?php echo $staff["admin_id"]?>">Supprimer le membre</a></li>
    </ul>
</div>
                </td>
            </tr>
    <?php    endforeach; ?>



    </tbody>
</table>
                </div>
            </div>

        <?php endif; ?>
        
    </div>
</div>
<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-dialog-center" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4>Confirmez-vous l'action ?</h4>
                <div align="center">
<a class="btn btn-primary" href="" id="confirmYes">Confirmer</a>
<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require 'footer.php'; ?>
