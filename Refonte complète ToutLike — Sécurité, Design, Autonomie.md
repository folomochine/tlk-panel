# Refonte complète ToutLike
## Contexte
SMM Panel acheté (BD Lab), plein de backdoors, design daté, code fragile. Objectif : en faire un projet 100% maîtrisé, sécurisé, maintenable et avec un design moderne.
## Phase 1 — Sécurisation et nettoyage (priorité absolue)
Avant tout changement visuel, verrouiller le projet.
### 1.1 Supprimer les backdoors et le phone-home
* Supprimer `app/hidden/proxy.php` (accès BDD sans auth)
* Supprimer `app/hidden/bridge.php` (scraper Instagram inutile)
* Supprimer `refills.php` (script ALTER TABLE rent control)
* Supprimer la fonction `auto_register_site()` dans `index.php` (lignes 98-120) — envoie l'URL du site à BD Lab à chaque page load
* Supprimer la constante `API_SERVER_ADDR` et `CLIENT_AUTH_KEY`
* Supprimer le check `paidRent` dans `index.php` (lignes 148-157) — le dev original peut bloquer le site à distance
* Mettre `paidRent = 1` en dur ou supprimer la logique complètement
### 1.2 Corriger l'authentification
* Remplacer `md5($pass)` par `password_hash()` / `password_verify()` (bcrypt)
* Migration : au login, si l'ancien hash MD5 match, re-hasher en bcrypt et sauvegarder
* Corriger l'incohérence `md5($pass)` vs `md5(sha1(md5($pass)))` dans `userlogin_check()`
### 1.3 Protections de base
* Activer `autoescape: true` dans Twig (`app/init.php` ligne 115) — protège contre XSS
* Ajouter des tokens CSRF sur tous les formulaires POST
* Activer `SSL_VERIFYPEER` dans `HTTP_REQUEST()` (`data_control.php` ligne 859)
* Ajouter `httpOnly` et `secure` flags sur tous les cookies de session
### 1.4 Nettoyage du code BD Lab
* Supprimer tous les commentaires/headers "SMM Panel BD Lab" / "Shihab Mia" dans les cron jobs et fichiers
* Renommer les préfixes de session `msmbilisim_` en `toutlike_`
* Changer le timezone `Asia/Dhaka` → `Africa/Conakry` dans `app/config.php`
## Phase 2 — Restructuration du code (maintenabilité)
Rendre le projet compréhensible et modifiable sans risque.
### 2.1 Centraliser la configuration
* Créer un vrai fichier `.env` (ou `config/app.php`) avec : URL, BDD, SMTP, timezone, clés API
* Supprimer les credentials en dur dans le code
### 2.2 Organiser le routing
* Créer un système de routes centralisé (tableau route → contrôleur) au lieu du `require controller($route[0])` brut
* Ajouter un middleware d'auth (vérification session avant chaque route protégée)
### 2.3 Séparer la logique
* Extraire les fonctions de `data_control.php` (1262 lignes) en fichiers thématiques :
    * `helpers/auth.php` — validation, login, hash
    * `helpers/orders.php` — prix, commandes
    * `helpers/currency.php` — conversion, formatage
    * `helpers/reporting.php` — rapports financiers
    * `helpers/api.php` — fonctions API
### 2.4 Traduire `fr.php`
* Le fichier `app/language/fr.php` est encore 100% en anglais
* Traduire les 322 clés pour que le système de langue fonctionne correctement
* Cela permettra aussi de retirer les textes en dur des templates Twig
## Phase 3 — Refonte design client (UI/UX)
Nouveau look moderne pour les pages utilisateur.
### 3.1 Choisir une direction design
Options :
* **Option A** : Refaire les templates Twig avec un framework CSS moderne (Tailwind CSS ou Bootstrap 5) — garde l'architecture actuelle
* **Option B** : Créer un front-end séparé (Vue.js/React) qui consomme l'API — plus moderne mais plus complexe
* **Recommandation** : Option A (Twig + Tailwind/Bootstrap 5) — plus rapide, garde la compatibilité
### 3.2 Pages client à refaire (34 templates)
* Page de login/landing (la plus importante — première impression)
* Dashboard / Nouvelle commande
* Liste des commandes + filtres
* Services (catalogue)
* Ajout de fonds
* Page API
* Tickets / Support
* Compte utilisateur
* Toutes les autres pages secondaires
### 3.3 Identité visuelle ToutLike
* Logo personnalisé
* Palette de couleurs Guinée (rouge, jaune, vert) ou palette moderne au choix
* Typographie cohérente
* Responsive mobile-first
## Phase 4 — Refonte admin
Le panneau d'administration (~90 vues PHP, 41 contrôleurs).
### 4.1 Moderniser l'admin
* Remplacer les vues PHP brutes par des templates Twig (comme le côté client)
* Nouveau design admin avec sidebar moderne, tableaux interactifs, graphiques
* Dashboard avec vrais KPIs (revenus, commandes/jour, clients actifs)
### 4.2 Renforcer les permissions
* Revoir le système de permissions JSON (40+ perms) — le rendre plus lisible
* Ajouter un audit log (qui a fait quoi, quand)
### 4.3 Outils admin manquants
* Backup BDD depuis l'admin
* Gestionnaire de mises à jour propre (pas dépendant de BD Lab)
* Monitoring des cron jobs (dernière exécution, erreurs)
## Ordre de priorité recommandé
1. **Phase 1** (sécurité) — à faire IMMÉDIATEMENT, surtout avant toute mise en production
2. **Phase 2.4** (traduction fr.php) — rapide et utile
3. **Phase 3** (design client) — impact visible pour les utilisateurs
4. **Phase 2** (restructuration) — en parallèle avec Phase 3
5. **Phase 4** (admin) — en dernier car seul l'admin y accède
## Estimation de travail
* Phase 1 : 1-2 jours
* Phase 2 : 3-5 jours
* Phase 3 : 5-10 jours (selon complexité design)
* Phase 4 : 5-10 jours
* **Total** : ~2-4 semaines de travail intensif
