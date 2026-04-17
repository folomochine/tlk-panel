<?php include 'header.php'; ?>
<div class="container-fluid">

  <ul class="nav nav-tabs">
     <li class="pull-right custom-search">
        <form class="form-inline" action="<?=site_url("admin/logs")?>" method="get">
           <div class="input-group">
              <input type="text" name="search" class="form-control" value="<?=$search_word?>" placeholder="Rechercher">
              <span class="input-group-btn search-select-wrap">
                 <select class="form-control search-select" name="search_type">
                    <option value="username" <?php if( $search_where == "username" ): echo 'selected'; endif; ?> >Nom d'utilisateur</option>
                    <option value="action" <?php if( $search_where == "action" ): echo 'selected'; endif; ?> >Action</option>
                 </select>
                 <button type="submit" class="btn btn-default"><span class="fas fa-search" aria-hidden="true"></span></button>
              </span>
           </div>
        </form>
     </li>
  </ul>

   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-default">
            <div class="panel-heading">
              Journaux des mises a jour
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                          <th class="checkAll-th">
                             <div class="checkAll-holder">
                                <input type="checkbox" id="checkAll">
                                <input type="hidden" id="checkAllText" value="order">
                             </div>
                             <div class="action-block">
                                <ul class="action-list" style="margin:5px 0 0 0!important">
                                    <li><span class="countlogs"></span> Journaux sélectionnés</li>
                                    <li>
                                       <div class="dropdown">
                                          <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Opérations groupées <span class="caret"></span></button>
                                         <ul class="dropdown-menu">
                                            <li>
                                              <a class="bulkorder" data-type="delete">Supprimer</a>
                                            </li>
                                         </ul>
                                      </div>
                                   </li>
                                </ul>
                             </div>
                          </th>
                           <th>Id</th>
                           <th>ID Service</th>
                         
<th>Action</th>
<th>Description</th>
                           <th>Date</th>
                           <th></th>

                        </tr>
                     </thead>
                     <form id="changebulkForm" action="<?php echo site_url("admin/updates/multi-action") ?>" method="post">
                       <tbody>
                         <?php if( !$logs ): ?>
                           <tr>
                             <td colspan="7"><center>Aucun journal trouve</center></td>
                           </tr>
                         <?php endif; ?>
                         <?php foreach($logs as $log): ?>
                          <tr>
                            <td><input type="checkbox" class="selectOrder" name="log[<?php echo $log["u_id"] ?>]" value="1" style="border:1px solid var(--border)"></td>
                             <td><?php echo $log["u_id"] ?></td>
                             <td><?php echo $log["service_id"] ?></td>
<td><?php echo $log["action"] ?></td>
                             <td><?php echo $log["description"] ?></td>
                             <td><?php echo $log["date"] ?></td>
                             <td> <a href="<?php echo site_url("admin/updates/delete/".$log["id"]) ?>" style="font-size:12px">Supprimer</a> </td>
                          </tr>
                        <?php endforeach; ?>
                       </tbody>
                       <input type="hidden" name="bulkStatus" id="bulkStatus" value="0">
                     </form>
                  </table>
               </div>
            </div>
         </div>
         <?php if( $paginationArr["count"] > 1 ): ?>
           <div class="row">
              <div class="col-sm-8">
                 <nav>
                    <ul class="pagination">
                      <?php if( $paginationArr["current"] != 1 ): ?>
                       <li class="prev"><a href="<?php echo site_url("admin/updates/1/".$search_link) ?>">&laquo;</a></li>
                       <li class="prev"><a href="<?php echo site_url("admin/updates/".$paginationArr["previous"]."/".$search_link) ?>">&lsaquo;</a></li>
                       <?php
                           endif;
                           for ($page=1; $page<=$pageCount; $page++):
                             if( $page >= ($paginationArr['current']-9) and $page <= ($paginationArr['current']+9) ):
                       ?>
                       <li class="<?php if( $page == $paginationArr["current"] ): echo "active"; endif; ?> "><a href="<?php echo site_url("admin/updates/".$page."/".$status.$search_link) ?>"><?=$page?></a></li>
                       <?php endif; endfor;
                             if( $paginationArr["current"] != $paginationArr["count"] ):
                       ?>
                       <li class="next"><a href="<?php echo site_url("admin/updates/".$paginationArr["next"]."/".$search_link) ?>" data-page="1">&rsaquo;</a></li>
                       <li class="next"><a href="<?php echo site_url("admin/updates/".$paginationArr["count"]."/".$search_link) ?>" data-page="1">&raquo;</a></li>
                       <?php endif; ?>
                    </ul>
                 </nav>
              </div>
           </div>
         <?php endif; ?>
      </div>
   </div>
</div>

<div class="modal modal-center fade" id="confirmChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
   <div class="modal-dialog modal-dialog-center" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <h4>Etes-vous sur de vouloir continuer ?</h4>
            <div align="center">
               <a class="btn btn-primary" href="" id="confirmYes">Oui</a>
               <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include 'footer.php'; ?>
