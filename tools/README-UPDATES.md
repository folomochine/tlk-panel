# ToutLike — Système de mises à jour en ligne (OTA)

Mettez à jour votre panel en production en un clic depuis l'admin, sans FTP.

---

## Pour l'administrateur (une seule fois)

1. Créez un **dépôt GitHub** (public ou privé peu importe, mais les ZIP doivent être accessibles publiquement).
   - Exemple : `https://github.com/toutlike/panel`
2. Déployez la version actuelle sur Namecheap (une seule fois, par FTP classique).
3. Connectez-vous à l'admin → **Paramètres → Mises à jour**.
4. Collez l'URL "Raw" de votre `version.json` :
   ```
   https://raw.githubusercontent.com/toutlike/panel/main/dist/version.json
   ```
5. Cliquez sur **Enregistrer**.

Et voilà — plus jamais besoin de FTP.

---

## Pour publier une nouvelle version

### Sur votre machine locale

1. Modifiez le code.
2. Ouvrez PowerShell dans le dossier du projet.
3. Lancez :
   ```powershell
   pwsh tools\release.ps1 -Version 1.1.0 -Repo "toutlike/panel" -Changelog `
     "Ajout du popup compact mobile-first", `
     "Correction du bug XYZ", `
     "Amélioration du dashboard"
   ```
4. Le script génère :
   - `dist/update-1.1.0.zip` — l'archive complète
   - `dist/version.json` — le fichier de check mis à jour

### Sur GitHub

5. Créez une nouvelle **Release** :
   - Tag : `v1.1.0`
   - Uploadez `dist/update-1.1.0.zip`
   - Publiez.
6. Committez et poussez `dist/version.json` sur la branche `main` :
   ```bash
   git add dist/version.json VERSION
   git commit -m "Release v1.1.0"
   git push
   ```

### Sur votre panel en prod

7. Allez dans **Admin → Paramètres → Mises à jour** → **Vérifier** → **Installer**.

Terminé. La mise à jour prend ~30 secondes.

---

## Comment ça marche ?

- Le panel lit `VERSION` en local pour connaître sa version.
- Il télécharge `version.json` depuis GitHub pour voir la dernière.
- Si supérieure, il télécharge le ZIP depuis la Release GitHub.
- Il vérifie le SHA-256 (si fourni).
- Il crée une **sauvegarde automatique** dans `public/backups/backup-YYYYMMDD-HHMMSS.zip` contenant tous les fichiers qui seront écrasés.
- Il extrait le nouveau ZIP par-dessus, **sans toucher** aux fichiers protégés.
- Il met à jour `VERSION`.

## Fichiers protégés (jamais écrasés)

Ces fichiers sont préservés lors de chaque mise à jour — vous pouvez modifier la liste dans `admin/controller/settings/update.php` (fonction `tl_updater_preserve_list()`) :

- `app/database.php` — vos identifiants MySQL
- `.env` — variables d'environnement
- `public/uploads/` — fichiers envoyés par les clients
- `public/admin/uploads/`
- `img/panel/` — logos, favicons
- `public/backups/` — les sauvegardes elles-mêmes
- `currencies.json` — cache des devises

## Rollback

En cas de problème, dans **Admin → Paramètres → Mises à jour**, section "Sauvegardes", cliquez sur **Restaurer** à côté d'une sauvegarde.

## Prérequis serveur

- PHP 7.4+
- Extension `ZipArchive` (standard sur Namecheap)
- `curl` ou `allow_url_fopen` activé
- Droits d'écriture sur le dossier du projet

---

## Structure du `version.json`

```json
{
  "version": "1.1.0",
  "date": "2026-04-17",
  "zip_url": "https://github.com/user/repo/releases/download/v1.1.0/update-1.1.0.zip",
  "sha256": "abc123...",
  "min_php": "7.4",
  "changelog": ["Note 1", "Note 2"]
}
```

Les champs `sha256` et `min_php` sont optionnels.
