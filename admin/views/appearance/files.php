<style>
.files-mgr__head{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;padding-bottom:12px;border-bottom:2px solid var(--primary)}
.files-mgr__head h4{margin:0;font-size:16px;font-weight:600;color:var(--text)}
.files-mgr__head .badge{margin-left:8px;font-size:11px;vertical-align:middle;background:var(--primary);color:#fff}

.files-mgr__upload{background:var(--card);border:2px dashed var(--border);border-radius:10px;padding:28px;text-align:center;margin-bottom:22px;transition:all .2s;cursor:pointer;position:relative}
.files-mgr__upload:hover{border-color:var(--primary);background:rgba(59,130,246,.03)}
.files-mgr__upload.drag-over{border-color:var(--primary);background:rgba(59,130,246,.06)}
.files-mgr__upload-icon{font-size:34px;color:var(--primary);margin-bottom:8px}
.files-mgr__upload-txt{font-size:14px;color:var(--muted);margin-bottom:4px}
.files-mgr__upload-hint{font-size:12px;color:var(--dim);margin-bottom:14px}
.files-mgr__upload input[type="file"]{display:none}

.files-mgr__card{background:var(--card);border:1px solid var(--border);border-radius:10px;box-shadow:0 1px 3px rgba(0,0,0,.04);overflow:hidden}
.files-mgr__bar{display:flex;align-items:center;justify-content:space-between;padding:10px 18px;background:var(--bg);border-bottom:1px solid var(--border);font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.files-mgr__bar span:last-child{font-weight:400;text-transform:none;letter-spacing:0;font-size:12px;color:var(--dim)}

.files-mgr__empty{padding:36px 20px;text-align:center;color:var(--dim);font-size:14px}

.files-mgr__row{display:flex;align-items:center;padding:10px 18px;border-bottom:1px solid var(--border);transition:background .12s}
.files-mgr__row:last-child{border-bottom:none}
.files-mgr__row:hover{background:rgba(59,130,246,.03)}

.files-mgr__thumb{width:42px;height:42px;border-radius:6px;overflow:hidden;border:1px solid var(--border);flex-shrink:0;display:flex;align-items:center;justify-content:center;background:var(--bg)}
.files-mgr__thumb img{max-width:100%;max-height:100%;object-fit:cover}

.files-mgr__info{flex:1;margin-left:14px;min-width:0}
.files-mgr__path{display:flex;align-items:center;gap:7px;font-size:13px}
.files-mgr__path a{color:var(--primary);text-decoration:none;word-break:break-all}
.files-mgr__path a:hover{text-decoration:underline;opacity:.8}
.files-mgr__copy{color:var(--dim);cursor:pointer;font-size:12px;flex-shrink:0;transition:color .12s;padding:2px}
.files-mgr__copy:hover{color:var(--primary)}
.files-mgr__copy.ok{color:#16a34a}
.files-mgr__date{font-size:11px;color:var(--dim);margin-top:2px}

.files-mgr__actions{flex-shrink:0;margin-left:14px}
.files-mgr__btn{display:inline-flex;align-items:center;gap:5px;padding:5px 14px;font-size:12px;color:var(--muted);background:0 0;border:1px solid var(--border);border-radius:6px;cursor:pointer;transition:all .12s}
.files-mgr__btn:hover{color:#fff;background:#dc2626;border-color:#dc2626}

.files-mgr__overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.4);z-index:1050;align-items:center;justify-content:center}
.files-mgr__overlay.on{display:flex}
.files-mgr__modal{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:24px;max-width:370px;width:90%;text-align:center;box-shadow:0 16px 48px rgba(0,0,0,.2)}
body.dark-mode .files-mgr__modal{box-shadow:0 16px 48px rgba(0,0,0,.5)}
.files-mgr__modal-icon{font-size:38px;color:#dc2626;margin-bottom:10px}
.files-mgr__modal h5{margin:0 0 6px;font-size:16px;font-weight:600;color:var(--text)}
.files-mgr__modal p{font-size:13px;color:var(--muted);margin:0 0 18px}
.files-mgr__modal-btns{display:flex;gap:10px;justify-content:center}
.files-mgr__modal-btns .btn{padding:7px 24px;border-radius:6px;font-size:13px;font-weight:500}
</style>

<div class="files-mgr">

    <div class="files-mgr__head">
        <h4><i class="fas fa-images" style="margin-right:8px;color:var(--primary)"></i>Images uploadees <span class="badge"><?= count($fileList) ?></span></h4>
    </div>

    <form action="/admin/appearance/files" method="POST" enctype="multipart/form-data" id="filesUploadForm">
        <div class="files-mgr__upload" id="filesDropZone" onclick="document.getElementById('filesFileInput').click()">
            <div class="files-mgr__upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <div class="files-mgr__upload-txt">Cliquer ou glisser-deposer une image</div>
            <div class="files-mgr__upload-hint">JPG, JPEG, PNG, GIF</div>
            <button type="button" class="btn btn-primary" onclick="event.stopPropagation();document.getElementById('filesFileInput').click()">
                <i class="fas fa-plus" style="margin-right:6px"></i>Choisir un fichier
            </button>
            <input type="file" name="logo" accept="image/*" id="filesFileInput">
        </div>
    </form>

    <div class="files-mgr__card">
        <div class="files-mgr__bar">
            <span>Bibliotheque</span>
            <span><?= count($fileList) ?> fichier(s)</span>
        </div>

        <?php if (empty($fileList)): ?>
            <div class="files-mgr__empty">
                <i class="fas fa-folder-open" style="font-size:28px;display:block;margin-bottom:10px"></i>
                Aucun fichier uploade
            </div>
        <?php else: ?>
            <?php foreach ($fileList as $file): ?>
            <div class="files-mgr__row">
                <div class="files-mgr__thumb">
                    <img src="<?= $file['link'] ?>" onerror="this.parentElement.innerHTML='<i class=\'fas fa-image\' style=\'color:var(--dim);font-size:18px\'></i>'">
                </div>
                <div class="files-mgr__info">
                    <div class="files-mgr__path">
                        <a href="<?= $file['link'] ?>" target="_blank"><?= str_ireplace(site_url(),"",$file["link"]) ?></a>
                        <i class="fas fa-copy files-mgr__copy" title="Copier l'URL" onclick="fmCopy('<?= $file['link'] ?>',this)"></i>
                    </div>
                    <div class="files-mgr__date"><?= $file['date'] ?></div>
                </div>
                <div class="files-mgr__actions">
                    <button class="files-mgr__btn" onclick="fmDel('<?= $file['id'] ?>')">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<div class="files-mgr__overlay" id="fmOverlay">
    <div class="files-mgr__modal">
        <div class="files-mgr__modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h5>Supprimer le fichier</h5>
        <p>Etes-vous sur de vouloir supprimer ce fichier ? Cette action est irreversible.</p>
        <div class="files-mgr__modal-btns">
            <button class="btn btn-default" onclick="document.getElementById('fmOverlay').classList.remove('on')">Annuler</button>
            <button class="btn btn-danger" id="fmDelBtn">Supprimer</button>
        </div>
    </div>
</div>

<script>
var fi=document.getElementById('filesFileInput');
fi.addEventListener('change',function(){if(this.files.length)document.getElementById('filesUploadForm').submit()});

var dz=document.getElementById('filesDropZone');
dz.addEventListener('dragover',function(e){e.preventDefault();this.classList.add('drag-over')});
dz.addEventListener('dragleave',function(e){e.preventDefault();this.classList.remove('drag-over')});
dz.addEventListener('drop',function(e){e.preventDefault();this.classList.remove('drag-over');if(e.dataTransfer.files.length){fi.files=e.dataTransfer.files;document.getElementById('filesUploadForm').submit()}});

function fmCopy(u,el){navigator.clipboard.writeText(u).then(function(){el.classList.add('ok');el.title='Copie!';setTimeout(function(){el.classList.remove('ok');el.title="Copier l'URL"},1500)})}

function fmDel(id){document.getElementById('fmOverlay').classList.add('on');document.getElementById('fmDelBtn').onclick=function(){window.location.href='/admin/appearance/files/delete/'+id}}
document.getElementById('fmOverlay').addEventListener('click',function(e){if(e.target===this)this.classList.remove('on')});
</script>
