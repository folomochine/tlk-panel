<?php include 'header.php'; ?>
<style>
.cs-wrap{padding:20px;max-width:600px}
.cs-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;margin-bottom:18px}
.cs-title i{color:var(--primary);font-size:18px}
.cs-list{background:var(--card);border:1px solid var(--border);border-radius:12px;overflow:hidden}
.cs-list .list-group-item{background:var(--card);border:none;border-bottom:1px solid var(--border);padding:12px 16px;color:var(--text);font-size:13px;cursor:grab;display:flex;align-items:center;gap:10px}
.cs-list .list-group-item:last-child{border-bottom:none}
.cs-list .list-group-item:hover{background:var(--primary-g)}
.cs-list .list-group-item .handle{color:var(--muted);cursor:grab}
</style>

<div class="cs-wrap">
  <div class="cs-title"><i class="fas fa-sort"></i> Tri des catégories</div>
  <div class="cs-list">
    <ul id="category-list" class="list-group category-sortable">
      <?=$list?>
    </ul>
  </div>
</div>

<?php include 'footer.php'; ?>
