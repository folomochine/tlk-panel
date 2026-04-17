<?php
/**
 * ToutLike — Updater OTA (Over-The-Air)
 * --------------------------------------------------------------
 * Permet de mettre à jour le panel depuis l'admin en 1 clic,
 * sans FTP. Utilise une source publique (GitHub Releases).
 *
 * Actions (POST) :
 *   - check    : lit le version.json distant et compare
 *   - install  : télécharge le ZIP, backup, extrait par-dessus
 *   - rollback : restaure la dernière sauvegarde
 *   - save     : enregistre l'URL du version.json
 *
 * GET :
 *   - liste les backups
 *   - affiche la vue
 */

if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}
if ($admin["access"]["admin_access"] != 1) {
    header("Location:" . site_url("admin"));
    exit();
}

// ------------------------------------------------------------------
// Helpers
// ------------------------------------------------------------------
function tl_updater_root()
{
    return realpath($_SERVER['DOCUMENT_ROOT']) ?: dirname(dirname(dirname(dirname(__FILE__))));
}

function tl_updater_current_version()
{
    $f = tl_updater_root() . DIRECTORY_SEPARATOR . 'VERSION';
    if (file_exists($f)) {
        return trim(file_get_contents($f));
    }
    return '1.0.0';
}

function tl_updater_http_get($url)
{
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ToutLike-Updater/1.0');
        $out = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $code >= 200 && $code < 300 ? $out : false;
    }
    $ctx = stream_context_create(["http" => ["header" => "User-Agent: ToutLike-Updater/1.0\r\n", "timeout" => 60]]);
    return @file_get_contents($url, false, $ctx);
}

function tl_updater_download_to_file($url, $dest)
{
    $fp = fopen($dest, 'w+');
    if (!$fp) return false;
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ToutLike-Updater/1.0');
        $ok = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);
        return $ok && $code >= 200 && $code < 300;
    }
    $data = tl_updater_http_get($url);
    if ($data === false) {
        fclose($fp);
        return false;
    }
    fwrite($fp, $data);
    fclose($fp);
    return true;
}

/**
 * Liste des chemins à NE JAMAIS écraser lors d'une mise à jour.
 * Relatifs au document root.
 */
function tl_updater_preserve_list()
{
    return [
        'app/database.php',
        '.env',
        'VERSION',                // garde notre fichier version, mais on le remet à jour à la fin
        'public/uploads',
        'public/admin/uploads',
        'img/panel',
        'public/backups',
        'currencies.json',
    ];
}

function tl_updater_is_preserved($relPath, $preserveList)
{
    $relPath = str_replace('\\', '/', $relPath);
    foreach ($preserveList as $p) {
        $p = str_replace('\\', '/', $p);
        if ($relPath === $p || strpos($relPath, $p . '/') === 0) {
            return true;
        }
    }
    return false;
}

function tl_updater_backups_dir()
{
    $dir = tl_updater_root() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'backups';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
        @file_put_contents($dir . DIRECTORY_SEPARATOR . 'index.html', '');
        @file_put_contents($dir . DIRECTORY_SEPARATOR . '.htaccess', "Order deny,allow\nDeny from all\n");
    }
    return $dir;
}

function tl_updater_log($line)
{
    $log = tl_updater_backups_dir() . DIRECTORY_SEPARATOR . 'updater.log';
    @file_put_contents($log, '[' . date('Y-m-d H:i:s') . '] ' . $line . PHP_EOL, FILE_APPEND);
}

function tl_updater_list_backups()
{
    $dir = tl_updater_backups_dir();
    $out = [];
    foreach (glob($dir . DIRECTORY_SEPARATOR . 'backup-*.zip') as $f) {
        $out[] = [
            'file'    => basename($f),
            'size'    => filesize($f),
            'created' => date('Y-m-d H:i:s', filemtime($f)),
        ];
    }
    usort($out, function ($a, $b) { return strcmp($b['created'], $a['created']); });
    return $out;
}

/**
 * Crée une archive ZIP des fichiers qui vont être écrasés.
 * Parcourt le contenu du ZIP fraîchement téléchargé et zippe
 * les fichiers correspondants du projet courant.
 */
function tl_updater_make_backup($newZipPath)
{
    $root = tl_updater_root();
    $backup = tl_updater_backups_dir() . DIRECTORY_SEPARATOR . 'backup-' . date('Ymd-His') . '.zip';
    $newZip = new ZipArchive();
    if ($newZip->open($newZipPath) !== true) return false;

    $backupZip = new ZipArchive();
    if ($backupZip->open($backup, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        $newZip->close();
        return false;
    }

    // Préfixe racine à ignorer (si ZIP contient un dossier racine)
    $rootPrefix = '';
    if ($newZip->numFiles > 0) {
        $first = $newZip->getNameIndex(0);
        if (strpos($first, '/') !== false) {
            $parts = explode('/', $first);
            $candidate = $parts[0] . '/';
            $ok = true;
            for ($i = 1; $i < min(20, $newZip->numFiles); $i++) {
                $n = $newZip->getNameIndex($i);
                if (strpos($n, $candidate) !== 0) { $ok = false; break; }
            }
            if ($ok) $rootPrefix = $candidate;
        }
    }

    $preserveList = tl_updater_preserve_list();
    $count = 0;
    for ($i = 0; $i < $newZip->numFiles; $i++) {
        $name = $newZip->getNameIndex($i);
        if ($rootPrefix !== '' && strpos($name, $rootPrefix) === 0) {
            $relPath = substr($name, strlen($rootPrefix));
        } else {
            $relPath = $name;
        }
        if ($relPath === '' || substr($relPath, -1) === '/') continue;
        if (tl_updater_is_preserved($relPath, $preserveList)) continue;
        $abs = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);
        if (file_exists($abs) && is_file($abs)) {
            $backupZip->addFile($abs, $relPath);
            $count++;
        }
    }
    $newZip->close();
    $backupZip->close();

    if ($count === 0) {
        @unlink($backup);
        return 'empty';
    }
    return $backup;
}

/**
 * Applique un ZIP téléchargé : extrait chaque entrée vers DOCUMENT_ROOT
 * sauf les chemins protégés.
 */
function tl_updater_apply_zip($zipPath, $rootPrefixDetect = true)
{
    $root = tl_updater_root();
    $zip = new ZipArchive();
    if ($zip->open($zipPath) !== true) return ['ok' => false, 'msg' => "Impossible d'ouvrir l'archive."];

    $rootPrefix = '';
    if ($rootPrefixDetect && $zip->numFiles > 0) {
        $first = $zip->getNameIndex(0);
        if (strpos($first, '/') !== false) {
            $parts = explode('/', $first);
            $candidate = $parts[0] . '/';
            $ok = true;
            for ($i = 1; $i < min(20, $zip->numFiles); $i++) {
                $n = $zip->getNameIndex($i);
                if (strpos($n, $candidate) !== 0) { $ok = false; break; }
            }
            if ($ok) $rootPrefix = $candidate;
        }
    }

    $preserveList = tl_updater_preserve_list();
    $written = 0;
    $skipped = 0;
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $name = $zip->getNameIndex($i);
        if ($rootPrefix !== '' && strpos($name, $rootPrefix) === 0) {
            $relPath = substr($name, strlen($rootPrefix));
        } else {
            $relPath = $name;
        }
        if ($relPath === '') continue;
        $abs = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);
        if (substr($relPath, -1) === '/') {
            if (!is_dir($abs)) @mkdir($abs, 0755, true);
            continue;
        }
        if (tl_updater_is_preserved($relPath, $preserveList)) { $skipped++; continue; }
        $dir = dirname($abs);
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $stream = $zip->getStream($name);
        if (!$stream) { $skipped++; continue; }
        $contents = stream_get_contents($stream);
        fclose($stream);
        if (@file_put_contents($abs, $contents) === false) { $skipped++; continue; }
        $written++;
    }
    $zip->close();
    return ['ok' => true, 'written' => $written, 'skipped' => $skipped];
}

// ------------------------------------------------------------------
// Routing AJAX
// ------------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['updater_action'])) {
    header("Content-Type: application/json; charset=utf-8");
    $action = $_POST['updater_action'];

    // --- Sauvegarder l'URL du version.json ---
    if ($action === 'save') {
        $url = trim($_POST['update_url'] ?? '');
        $update = $conn->prepare("UPDATE settings SET update_url=:u WHERE id=1");
        try {
            $update->execute(["u" => $url]);
        } catch (Exception $e) {
            // Colonne inexistante : on la crée
            $conn->exec("ALTER TABLE settings ADD COLUMN update_url VARCHAR(500) NULL DEFAULT NULL");
            $update->execute(["u" => $url]);
        }
        echo json_encode(["ok" => true, "msg" => "URL enregistrée."]);
        exit;
    }

    // --- Check version distante ---
    if ($action === 'check') {
        $url = trim($_POST['update_url'] ?? ($settings['update_url'] ?? ''));
        if (empty($url)) { echo json_encode(["ok" => false, "msg" => "URL du version.json manquante."]); exit; }
        $raw = tl_updater_http_get($url);
        if ($raw === false) { echo json_encode(["ok" => false, "msg" => "Impossible de contacter le serveur distant."]); exit; }
        $info = json_decode($raw, true);
        if (!is_array($info) || empty($info['version']) || empty($info['zip_url'])) {
            echo json_encode(["ok" => false, "msg" => "Fichier version.json invalide."]); exit;
        }
        $current = tl_updater_current_version();
        $hasUpdate = version_compare($info['version'], $current, '>');
        echo json_encode([
            "ok"         => true,
            "current"    => $current,
            "remote"     => $info['version'],
            "date"       => $info['date'] ?? null,
            "zip_url"    => $info['zip_url'],
            "sha256"     => $info['sha256'] ?? null,
            "changelog"  => $info['changelog'] ?? [],
            "min_php"    => $info['min_php'] ?? null,
            "has_update" => $hasUpdate,
        ]);
        exit;
    }

    // --- Installer la mise à jour ---
    if ($action === 'install') {
        $zipUrl = trim($_POST['zip_url'] ?? '');
        $remote = trim($_POST['remote'] ?? '');
        $sha256 = trim($_POST['sha256'] ?? '');
        if (empty($zipUrl) || empty($remote)) {
            echo json_encode(["ok" => false, "msg" => "Paramètres manquants (zip_url/remote)."]); exit;
        }
        if (!class_exists('ZipArchive')) {
            echo json_encode(["ok" => false, "msg" => "Extension ZipArchive requise mais absente."]); exit;
        }

        @set_time_limit(300);
        @ini_set('memory_limit', '256M');

        $tmpDir = tl_updater_backups_dir() . DIRECTORY_SEPARATOR . '_tmp';
        if (!is_dir($tmpDir)) @mkdir($tmpDir, 0755, true);
        $zipPath = $tmpDir . DIRECTORY_SEPARATOR . 'update-' . date('Ymd-His') . '.zip';

        tl_updater_log("Download: $zipUrl");
        if (!tl_updater_download_to_file($zipUrl, $zipPath)) {
            echo json_encode(["ok" => false, "msg" => "Échec du téléchargement de l'archive."]); exit;
        }
        if (!empty($sha256)) {
            $real = hash_file('sha256', $zipPath);
            if (strcasecmp($real, $sha256) !== 0) {
                @unlink($zipPath);
                echo json_encode(["ok" => false, "msg" => "Signature SHA-256 invalide. Mise à jour annulée."]); exit;
            }
        }

        // Backup
        $backupPath = tl_updater_make_backup($zipPath);
        if ($backupPath === false) {
            @unlink($zipPath);
            echo json_encode(["ok" => false, "msg" => "Impossible de créer la sauvegarde."]); exit;
        }
        tl_updater_log("Backup: " . (is_string($backupPath) ? $backupPath : 'empty'));

        // Apply
        $res = tl_updater_apply_zip($zipPath);
        @unlink($zipPath);
        if (!$res['ok']) {
            echo json_encode(["ok" => false, "msg" => $res['msg']]); exit;
        }

        // Update VERSION file
        @file_put_contents(tl_updater_root() . DIRECTORY_SEPARATOR . 'VERSION', $remote . "\n");
        tl_updater_log("Applied v{$remote} : {$res['written']} fichiers écrits, {$res['skipped']} ignorés.");

        echo json_encode([
            "ok"       => true,
            "msg"      => "Mise à jour installée avec succès.",
            "version"  => $remote,
            "written"  => $res['written'],
            "skipped"  => $res['skipped'],
            "backup"   => is_string($backupPath) ? basename($backupPath) : null,
        ]);
        exit;
    }

    // --- Rollback ---
    if ($action === 'rollback') {
        $file = basename($_POST['backup'] ?? '');
        if (empty($file) || !preg_match('/^backup-[0-9\-]+\.zip$/', $file)) {
            echo json_encode(["ok" => false, "msg" => "Fichier de sauvegarde invalide."]); exit;
        }
        $path = tl_updater_backups_dir() . DIRECTORY_SEPARATOR . $file;
        if (!file_exists($path)) {
            echo json_encode(["ok" => false, "msg" => "Sauvegarde introuvable."]); exit;
        }
        $res = tl_updater_apply_zip($path, false);
        if (!$res['ok']) { echo json_encode(["ok" => false, "msg" => $res['msg']]); exit; }
        tl_updater_log("Rollback depuis {$file} : {$res['written']} fichiers restaurés.");
        echo json_encode(["ok" => true, "msg" => "Version précédente restaurée.", "written" => $res['written']]);
        exit;
    }

    echo json_encode(["ok" => false, "msg" => "Action inconnue."]);
    exit;
}

// ------------------------------------------------------------------
// Préparation données pour la vue
// ------------------------------------------------------------------
$tl_updater = [
    "current_version" => tl_updater_current_version(),
    "update_url"      => $settings['update_url'] ?? '',
    "backups"         => tl_updater_list_backups(),
    "php_version"     => PHP_VERSION,
    "has_zip"         => class_exists('ZipArchive'),
    "has_curl"        => function_exists('curl_init'),
];
