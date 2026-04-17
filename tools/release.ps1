# ============================================================
#  ToutLike - Outil de packaging pour Release GitHub
# ------------------------------------------------------------
#  Génère :
#   - dist/update-<version>.zip   (archive déployable)
#   - dist/version.json           (fichier de check)
#
#  Usage :
#   pwsh tools/release.ps1 -Version 1.1.0 -Repo "user/repo" -Changelog "Ligne 1","Ligne 2"
#
# ============================================================

param(
  [Parameter(Mandatory = $true)] [string]$Version,
  [Parameter(Mandatory = $true)] [string]$Repo,
  [string[]]$Changelog = @("Nouvelle version"),
  [string]$Date = (Get-Date -Format "yyyy-MM-dd"),
  [string]$MinPhp = "7.4"
)

$ErrorActionPreference = 'Stop'

# Racine du projet = parent du dossier tools/
$root = Split-Path -Parent $PSScriptRoot
Set-Location $root

$dist = Join-Path $root "dist"
if (-not (Test-Path $dist)) { New-Item -ItemType Directory -Path $dist | Out-Null }

$zipName = "update-$Version.zip"
$zipPath = Join-Path $dist $zipName
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

Write-Host ""
Write-Host "==> Packaging v$Version..." -ForegroundColor Cyan

# Fichiers/dossiers à exclure du ZIP (ceux qui ne doivent pas être déployés)
$exclude = @(
  ".git", ".github", ".vscode", ".idea",
  "dist", "node_modules", "vendor/cache",
  "public/backups", "public/uploads", "public/admin/uploads",
  "img/panel",
  ".env", "app/database.php", "currencies.json",
  "tools", ".DS_Store"
)

# Met à jour le fichier VERSION local AVANT de zipper
Set-Content -Path (Join-Path $root "VERSION") -Value "$Version`n" -NoNewline

# Construire la liste des fichiers à inclure
Write-Host "    Collecte des fichiers..." -ForegroundColor Gray
$allFiles = Get-ChildItem -Path $root -Recurse -File | Where-Object {
  $rel = $_.FullName.Substring($root.Length).TrimStart('\', '/').Replace('\', '/')
  $skip = $false
  foreach ($e in $exclude) {
    if ($rel -eq $e -or $rel -like "$e/*") { $skip = $true; break }
  }
  -not $skip
}
Write-Host "    $($allFiles.Count) fichiers à archiver." -ForegroundColor Gray

# Créer le ZIP (Compress-Archive peut être lent pour beaucoup de fichiers)
Write-Host "    Création de l'archive ZIP..." -ForegroundColor Gray
Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem
$mode = [System.IO.Compression.ZipArchiveMode]::Create
$level = [System.IO.Compression.CompressionLevel]::Optimal
$zipFs = [System.IO.Compression.ZipFile]::Open($zipPath, $mode)
try {
  foreach ($f in $allFiles) {
    $rel = $f.FullName.Substring($root.Length).TrimStart('\', '/').Replace('\', '/')
    [void][System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zipFs, $f.FullName, $rel, $level)
  }
} finally {
  $zipFs.Dispose()
}

$zipSize = (Get-Item $zipPath).Length
$sha256 = (Get-FileHash -Algorithm SHA256 -Path $zipPath).Hash.ToLower()

Write-Host "    ZIP   : $zipPath ($('{0:N2}' -f ($zipSize / 1MB)) Mo)" -ForegroundColor Green
Write-Host "    SHA256: $sha256" -ForegroundColor Gray

# Génère version.json
$versionJson = [ordered]@{
  version   = $Version
  date      = $Date
  zip_url   = "https://github.com/$Repo/releases/download/v$Version/$zipName"
  sha256    = $sha256
  min_php   = $MinPhp
  changelog = $Changelog
}
$jsonPath = Join-Path $dist "version.json"
$versionJson | ConvertTo-Json -Depth 5 | Set-Content -Path $jsonPath -Encoding UTF8
Write-Host "    JSON  : $jsonPath" -ForegroundColor Green

Write-Host ""
Write-Host "  Packaging terminé !" -ForegroundColor Green
Write-Host ""
Write-Host "  Étapes suivantes :" -ForegroundColor Yellow
Write-Host "   1. Allez sur https://github.com/$Repo/releases/new"
Write-Host "   2. Tag : v$Version"
Write-Host "   3. Uploadez : $zipPath"
Write-Host "   4. Publiez la Release"
Write-Host "   5. Committez ET poussez dist/version.json sur le repo (branche main)"
Write-Host "   6. Sur votre admin, cliquez sur 'Vérifier' puis 'Installer' "
Write-Host ""
