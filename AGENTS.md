# Agent : Traduction Francais — Panel SMM (Twig Templates)

## Presentation generale du projet

### Qu'est-ce que ToutLike ?

ToutLike est un **SMM Panel** (Social Media Marketing Panel) — une plateforme web PHP permettant de vendre des services de marketing sur les reseaux sociaux (followers, likes, vues, commentaires, etc.) pour Instagram, Facebook, YouTube, TikTok, Twitter, Spotify, Telegram, LinkedIn, Snapchat et autres.

### Technologie

| Composant | Detail |
|---|---|
| **Framework** | PHP custom (pas Laravel/Symfony) — framework maison MVC |
| **Template** | Twig (`Twig_Environment`) — theme actif : `SMMRX-smmpanelbdlab` |
| **Base de donnees** | MySQL/MariaDB (47 tables) via PDO — pas d'ORM |
| **Auth** | Sessions PHP + cookies "remember me" (MD5 passwords) |
| **Paiements** | 21 passerelles : Stripe, PayPal, Perfect Money, Payeer, Coinbase, Razorpay, PhonePe, Flutterwave, LengoPay (GNF), etc. |
| **API** | REST API publique (`/api/v2`) pour integration tierce |
| **Dev original** | SMM Panel BD Lab (Shihab Mia) — smmpanelbdlab.com |
| **PHP cible** | 7.4.33 (composer.json) |

### Architecture MVC simplifiee

```
index.php (entree unique - 740 lignes)
  |-- app/init.php (bootstrap : session, BDD, Twig, helpers, classes)
  |     |-- app/config.php (URL, BDD, timezone)
  |     |-- app/helper/app.php (routing, URL, IP)
  |     |-- app/helper/data_control.php (1262 lignes : prix, devises, DB, scraping)
  |     |-- app/helper/admin.php (fonctions admin)
  |     |-- app/classes/smm.php (client API cURL vers fournisseurs)
  |     |-- app/classes/mail.php (PHPMailer)
  |     |-- app/classes/sms.php (SMS - bizimsms / netgsm)
  |
  |-- app/controller/{route}.php (48 controleurs utilisateur)
  |-- admin/controller/{route}.php (41 controleurs admin)
  |-- app/views/SMMRX-smmpanelbdlab/{page}.twig (34 templates traduits)
  |-- app/language/{code}.php (5 langues : en, fr, ar, hi, default)
  |-- public/cronjob/*.php (8 taches automatisees)
```

### Structure des dossiers

```
Touttlike Projet/
|-- index.php                 # Point d'entree (routing, Twig render)
|-- .htaccess                 # Rewrite URL vers index.php
|-- composer.json             # Deps : PHPMailer, Google API, Twig, Monolog, etc.
|-- Toutlike SQL.sql          # Dump BDD (47 tables, MariaDB 11.4)
|-- app/
|   |-- config.php           # URL, BDD, timezone
|   |-- init.php             # Bootstrap (session, PDO, Twig, helpers, classes)
|   |-- controller/          # 48 controleurs user (auth, orders, services, etc.)
|   |   |-- payment/        # 18 callbacks paiement
|   |   |-- addfunds/       # 18 initiateurs paiement + getForm
|   |-- helper/             # app.php, data_control.php (1262 lignes), admin.php
|   |-- classes/            # smm.php (API client), mail.php, sms.php
|   |-- language/            # en.php, fr.php, ar.php, hi.php, default.php
|   |-- views/               # SMMRX-smmpanelbdlab/ (34 .twig), maintenance.php, 404.php
|-- admin/
|   |-- controller/          # 41 controleurs (clients, orders, services, settings, etc.)
|   |-- views/               # ~90+ vues PHP admin
|   |-- controller/settings/   # Sous-controleurs paiement
|-- public/
|   |-- js/                 # script.js, ajax.js, toolkit.js
|   |-- css/                 # admin/, panel/, Simplify/
|   |-- cronjob/             # 8 scripts auto (orders, dripfeed, refill, average, payments)
|   |-- admin/               # Assets admin
|   |-- global/              # JS/CSS compiles
|   |-- Simplify/            # Assets paiement
|-- vendor/                    # Dependances Composer
|-- lib/                       # SDK : Alipay, PayPal, Perfect Money, Paytm
|-- img/                       # admin/, files/, integrations/, panel/
|-- css/                       # admin/, panel/
```

---

### Base de donnees (47 tables)

| # | Table | Role |
|---|---|---|
| 1 | `admins` | Comptes admin (login, mot de passe, 2FA, permissions JSON) |
| 2 | `admin_constants` | Statut location (loyer paye ou non) |
| 3 | `clients` | **Comptes utilisateurs** (username, email, mdp MD5, solde, apikey, langue, devise, code parrainage) |
| 4 | `orders` | **Commandes** (statut, lien, quantite, prix, depart, reste, refill, dripfeed, subscription) |
| 5 | `services` | **Catalogue services** (nom, prix, min/max, type, categorie, API fournisseur) |
| 6 | `categories` | Categories de services |
| 7 | `service_api` | **Fournisseurs API** (URL, cle, limite, statut) |
| 8 | `payments` | Transactions (depots, methodes, statuts) |
| 9 | `paymentmethods` | Configuration passerelles (nom, logo, frais, bonus, extras JSON) |
| 10 | `childpanels` | Panels enfants loues par les utilisateurs |
| 11 | `tickets` / `ticket_reply` / `ticket_subjects` | Systeme de support |
| 12 | `referral` / `referral_payouts` | Systeme de parrainage |
| 13 | `settings` | **70+ parametres** globaux (site, email, SMS, features, monnaie, decoration) |
| 14 | `General_options` | Toggles fonctionnalites (coupons, tickets, inscription, etc.) |
| 15 | `currencies` | Devises supportees (code, symbole, taux, hash) |
| 16 | `themes` | Themes Twig (nom, dossier, extras CSS/JS) |
| 17 | `menus` | Menu de navigation (nom, slug, icone, visible) |
| 18 | `pages` | Pages CMS (contenu, SEO) |
| 19 | `blogs` | Articles blog |
| 20 | `news` | Annonces / popup |
| 21 | `integrations` | Integrations tierces (WhatsApp, Tawk.to, etc.) |
| 22 | `kuponlar` / `kupon_kullananlar` | Coupons de reduction |
| 23 | `bank_accounts` | Comptes bancaires pour virement manuel |
| 24 | `earn` | Liens promotionnels pour credits gratuits |
| 25 | `tasks` | Taches de fond (refill, cancel) |
| 26 | `sync_logs` | Logs synchronisation services |
| 27 | `client_report` | Journal d'activite utilisateurs |
| 28 | `client_price` / `clients_service` | Prix personnalises par utilisateur |
| 29 | `files` | Fichiers uploades |
| 30 | `notifications_popup` | Notifications popup |
| 31 | `decoration` | Effets visuels (neige, feux d'artifice, guirlandes) |
| 32 | `custom_settings` | Parser compteur depart, incrementation compteur |
| 33 | `units_per_page` | Pagination (elements par page) |
| 34 | `updates` | Journal modifications services |
| 35 | `panel_info` / `panel_categories` | Info panel + categories labels |
| 36-39 | `languages`, `Mailforms`, `serviceapi_alert`, `bulkedit` | Tables auxiliaires |

---

### Systeme de commandes

Le coeur du panel. 17 types de services supportes :

| Type | Description |
|---|---|
| 1 | Default — lien + quantite |
| 2 | Package — prix fixe, quantite = service_min |
| 3 | Custom Comments — commentaires personnalises |
| 5-10 | Mentions — divers types de mentions |
| 11-13 | Subscriptions — auto-renouvellement (avec date, limite, quantite) |
| 14-15 | Auto-subscriptions — avec limitation de temps |

Options avancees : **Drip Feed** (livraison echelonnee a intervalles reguliers), **Mass Order** (commandes en lot), **Refill** (rechargement automatique si perte), **Annulation**.

Statuts possibles : pending, inprogress, completed, partial, processing, canceled.

---

### Cron jobs (8 taches automatisees)

| Script | Frequence | Role |
|---|---|---|
| `smmpanelbdlab-orders.php` | Continu | Interroge API fournisseurs pour maj statut commandes |
| `smmpanelbdlab-dripfeed.php` | Continu | Traite les drip-feed (echelonne les commandes) |
| `smmpanelbdlab-refill.php` | Continu | Maj taux de change + verifie rechargements + fausses commandes |
| `smmpanelbdlab-payments.php` | Continu | Verifie paiements en attente |
| `smmpanelbdlab-average.php` | Continu | Calcule temps moyen de livraison par service |
| `smmpanelbdlab-seller-sync.php` | Continu | Synchronise services depuis fournisseurs API |
| `smmpanelbdlab-autoreply.php` | Continu | Reponse auto tickets |
| `smmpanelbdlab-autolike.php` | Continu | Traitement auto des likes |

---

### Systeme de paiement (21 passerelles)

| # | Passerelle | Devise |
|---|---|---|
| 1 | PayTM Checkout | INR |
| 2 | PayTM Merchant | INR |
| 3 | Perfect Money | USD |
| 4 | Coinbase Commerce | USD |
| 5 | Kashier | USD |
| 6 | Razorpay | INR |
| 7 | PhonePe | INR |
| 8 | Easypaisa | PKR |
| 9 | JazzCash | PKR |
| 10 | Instamojo | INR |
| 11 | Cashmaal | PKR |
| 12 | Alipay | USD |
| 13 | PayU | INR |
| 14 | UpiApi | INR |
| 15 | Opay Express Checkout | USD |
| 16 | Flutterwave | USD |
| 17 | Stripe | USD |
| 18 | Payeer | USD |
| 19 | BoishakhiPay | BDT |
| 20 | UddoktaPay | BDT |
| **21** | **LengoPay** | **GNF** (active) |
| + | 10 slots manuels (bancaire, crypto, etc.) | Configurable |

---

### API publique

Endpoint : `POST /api/v2`

Actions : `services` (catalogue), `add` (commander), `status` (statut), `balance` (solde), `refill`, `refill_status`, `cancel`.

Auth : cle API dans parametre `key` (generee depuis page Compte).

---

### Systeme parrainage

- Code unique par utilisateur (6 caracteres hex)
- Commission configurable par admin (`referral_commision`)
- Systeme de payouts (demandes de retrait)
- Suivi : clics, inscriptions, fonds de references

---

### Panel enfant

- Location : `child-panels.php` (user) + `admin/controller/child-panels.php` (admin)
- Prix mensuel configurable ($settings["childpanel_price"])
- Utilisateur fournit : domaine, devise, identifiants admin
- Admin valide/suspend/termine les panels
- Serveurs de noms configurables

---

### Systeme de langues

Fichiers : `app/language/{en,fr,ar,hi,default}.php` — tableaux PHP `$languageArray` avec 322 cles.

- Multi-langues dans DB : `category_name_lang`, `menu_name_lang`, `news_title_lang` (JSON)
- RTL support : Arabe = `body-rtl` + `table-rtl`
- Selection : `?lang=fr` en URL, stocke en session
- **Note : `fr.php` existe mais le contenu est encore en anglais (pas traduit dans les tableaux PHP)**

---

### Fonctionnalites admin (41 controleurs)

Dashboard, gestion clients (CRUD, ban, fond, reset), services (CRUD, sync API, bulk price update), commandes (annuler, rembourser), paiements (approuver/rejeter manuels), tickets, reference, coupons, broadcast, rapports financiers, child panels, modules, apparence (themes, pages, menu, blog, meta, news, fichiers, decorations), parametres globaux, 2FA Google, permissions (40+ perms granulaires en JSON).

---

## Points de securite a connaitre

| # | Probleme | Severite | Detail |
|---|---|---|---|
| 1 | **MD5 pour les mots de passe** | **Critique** | Pas de bcrypt/argon2. MD5 est casse depuis 2004. |
| 2 | **`app/hidden/proxy.php` sans auth** | **Critique** | API CRUD sur la BDD sans authentification.任何人 peut lire/modifier/supprimer des donnees. |
| 3 | **Twig `autoescape = false`** | **Haute** | Pas de protection XSS automatique dans les templates. |
| 4 | **Pas de protection CSRF** | **Haute** | Aucun token CSRF sur les formulaires. |
| 5 | **Phone-home vers BD Lab** | **Moyenne** | Chaque page load envoie l'URL du site au serveur du developpeur. |
| 6 | **SSL_VERIFYPEER = 0** dans HTTP_REQUEST() | **Moyenne** | Verification SSL desactives dans les requetes API fournisseurs. |
| 7 | **Fausses commandes inflatees** | **Faible** | Cron job cree/supprime de fausses commandes pour gonfler le compteur. |

---

## Instructions

- Traduire **UNIQUEMENT** les textes visibles par les utilisateurs (labels, boutons, placeholders, messages JavaScript, meta tags SEO)
- Ne **jamais** modifier la logique du code (variables, routes, IDs, classes CSS, Twig directives `{{ }}`, `{% %}`)
- Ne **pas** toucher aux fichiers admin ni vendor
- Toujours relire un fichier **avant** de le modifier
- Si un edit echoue (fichier modifie entre-temps), relire et reappliquer

## Dossier traduit

```
C:\xampp\htdocs\touttlike\app\views\SMMRX-smmpanelbdlab\
```

### Dossiers a ignorer
- `admin/` — panneau d'administration
- `vendor/` — dependances tierces
- Tout fichier ne contenant que du contenu dynamique (`{!! $html !!}`, `{!! $js !!}`)

---

# Modifications apportees

## 1. Setup local XAMPP

### 1.1 Copie du projet
- Source : `C:\Users\irain\Music\Touttlike Projet\`
- Destination : `C:\xampp\htdocs\touttlike\`
- Methode : `xcopy` avec options `/E /I /H /Y`

### 1.2 Base de donnees
- Nom de la BDD locale : `smmrx_local`
- Import du fichier `Toutlike SQL.sql` via `mysql.exe` (47 tables importees)
- Utilisateur : `root`, mot de passe : vide (XAMPP default)

### 1.3 Configuration PHP (`app/config.php`)
| Parametre | Valeur originale (prod) | Valeur locale |
|---|---|---|
| `URL` | `https://smmrx.smmpanelbdlab.xyz` | `http://127.0.0.1` |
| `STYLESHEETS_URL` | `//smmrx.smmpanelbdlab.xyz` | `//127.0.0.1` |
| `db.name` | `smmpanelbdlab_smmrx` | `smmrx_local` |
| `db.user` | `smmpanelbdlab_smmrx` | `root` |
| `db.pass` | `smmpanelbdlab_smmrx` | _(vide)_ |
| `error_reporting` | `0` | `0` (production) |

### 1.4 `.htaccess`
- Supprime : redirection HTTPS forcee (lignes 2-3)
- Supprime : handler cPanel PHP (lignes 5-9)
- Garde : `RewriteEngine On` + reecriture vers `index.php`

### 1.5 Virtual Host Apache
- Fichier : `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
- ServerName : `touttlike.test` (inutilise car hosts non modifie)
- DocumentRoot : `C:/xampp/htdocs/touttlike`

### 1.6 Extensions PHP activees
- `php.ini` restaure depuis `php.ini-development` (fichier original etait vide/corrompu - 3 octets)
- `extension_dir` fix : `C:\xampp\php\ext`
- Extensions activees : `gd`, `pdo_mysql`, `curl`, `mbstring`, `openssl`, `json`, `fileinfo`, `xml`, `iconv`

---

## 2. Traduction Francais des 34 fichiers .twig

### Regles de traduction
- **Bangladesh** remplace par **Guinee**
- **SMM Panel / SMM panel / SMM** supprime ou remplace par **panel** / **panel de services**
- **SMMXZ / BD Lab / smmpanelbdlab** remplace par **ToutLike**
- **Adresse Dhaka** remplace par **Conakry, Guinee**
- Noms de plateformes (Instagram, Facebook, YouTube, TikTok, Twitter, Spotify, Telegram, LinkedIn, Discord, SoundCloud, Snapchat) **non modifies**
- Termes techniques (API, HTTP, JSON, ID, URL, POST) **non modifies**
- Aucune modification de : `{{ }}`, `{% %}`, classes CSS, IDs, attributs HTML, code JS

### Fichiers modifies avec nombre approximatif de remplacements

| # | Fichier | Remplacements | Details |
|---|---|---|---|
| 1 | `header.twig` | ~20 | Menu sidebar (Connecte) : Nouvelle commande, Commandes, Ajouter des fonds, Tickets, Services, Commande en masse, Panel enfant, API, Mises a jour, FAQ, Mon compte, Deconnexion, Solde. Nav (non connecte) : A propos, Contactez-nous, Blog, Services, Connexion, Inscription. Alt text SEO. |
| 2 | `footer.twig` | ~12 | Description societe, Liens rapides (Accueil, A propos, Contactez-nous, Conditions d'utilisation), Adresse Conakry Guinee, E-mail, Tous droits reserves, JS messages (selection fichier, taille fichier) |
| 3 | `login.twig` | ~120+ | Page landing complete : Bienvenue sur, Fournisseur panel Guinee, Connectez-vous au tableau de bord, Nom d'utilisateur, Mot de passe, Se souvenir de moi, Mot de passe oublie, Se connecter, Vous n'avez pas de compte, S'inscrire, Compteurs (Commandes terminees, Services actifs, Utilisateurs actifs, Classement mondial), Section A propos, Section services (9 plateformes), Comment fonctionne (4 etapes), Section gros (Panel enfant, revendeur, API), Temoignages (9 clients), Pourquoi choisir (5 features), Avantages (6 benefits), Paiements, Audience cible (6 categories), FAQ (8 Q/R), Section revendeur |
| 4 | `signup.twig` | ~11 | Inscrivez-vous maintenant, Creation de compte, placeholders, Bouton S'inscrire, Deja un compte |
| 5 | `neworder.twig` | ~30 | Solde actuel, Depenses, Total commandes, ID utilisateur, Nouvelle commande, Ajouter des fonds, Regles, Categorie, Cout, Passer commande, Trafic Web, Veuillez suivre, Regles de commande |
| 6 | `services.twig` | ~20 | Services, Rechercher, Filtrer, Tout, Plateformes, Table headers (Tarif pour 1000, Min/Max, Temps moyen), Voir, Aucun service trouve, Prix pour 1000, Acheter maintenant |
| 7 | `orders.twig` | ~19 | Filtres (Tout, En attente, En cours, Terminee, Partielle, En traitement, Annulee), Headers (Lien, Montant, Depart, Quantite, Restant, Statut, Action rapide), Copie, Recharger, annuler |
| 8 | `addfunds.twig` | ~8 | Ajouter des fonds, Voir l'historique, Historique paiements, Methode |
| 9 | `api.twig` | ~25 | Documentation API, Methode HTTP, URL API, Cle API, Format de reponse, Liste services, Parametres, Ajouter commande, Par defaut/Pack/Commentaires, Statut commande, Rechargement, Annulation, Solde, Exemple code PHP |
| 10 | `faq.twig` | ~18 | Questions frequentes, 8 Q/R completes (serveurs multiples, rechargement, taux fixe, remise, bouton rechargement, mauvais lien, annulation, statut partiel, diffusion programmee) |
| 11 | `about-us.twig` | ~30 | A propos, Description societe Guinee, Nos services, 4 cartes plateformes, Notre vision, Pourquoi choisir, Contactez-nous, Rejoignez-nous |
| 12 | `child-panels.twig` | ~30 | Louer panel enfant, Formulaire (Domaine, Devise, Utilisateur admin, Mot de passe, Prix par mois), Serveurs de noms, 11 FAQ Q/R, Table headers |
| 13 | `tickets.twig` | ~8 | Ticket de support, Creer ticket, Envoyer ticket, Historique tickets |
| 14 | `open_ticket.twig` | ~5 | Champs ticket |
| 15 | `account.twig` | ~3 | Placeholders, Generer nouveau |
| 16 | `refer.twig` | ~12 | Table headers, Labels statut, Demandes de paiement |
| 17 | `refill.twig` | ~7 | Filtres (Tout, Rechargement, Rejete, Erreur), Table headers |
| 18 | `subscriptions.twig` | ~2 | Placeholder recherche |
| 19 | `dripfeeds.twig` | ~2 | Placeholder recherche |
| 20 | `massorder.twig` | ~4 | Titre, description, label, Bouton |
| 21 | `earn.twig` | ~5 | Lien promotion, Envoyer lien, Table headers |
| 22 | `blog.twig` | ~1 | Lire la suite |
| 23 | `singleblog-post.twig` | ~1 | Retour |
| 24 | `resetpassword.twig` | ~3 | Titre, description, Bouton envoyer |
| 25 | `setnewpassword.twig` | ~5 | Labels, placeholders, Bouton changer |
| 26 | `confirm_email.twig` | ~5 | Titre, description, limites, Boutons, copyright |
| 27 | `success.twig` | ~2 | Merci, Fonds ajoutes |
| 28 | `updates.twig` | ~1 | Nom du service |
| 29 | `kupon.twig` | ~2 | Code coupon, Bouton utiliser |
| 30 | `integrations.twig` | ~1 | Message WhatsApp |
| 31 | `contact-us.twig` | ~5 | Titre, description, contact, support, adresse Guinee |
| 32 | `transferfunds.twig` | 0 | Tout en variables `lang[]` |
| 33 | `terms.twig` | 0 | Tout en variable `contentText` |
| 34 | `update.twig` | 0 | Tout en variable `contentText` |

---

## 3. Actions restantes pour upload Namecheap

### 3.1 Restaurer `app/config.php` pour production
```php
define('URL', 'https://toutlike.com' );
define('STYLESHEETS_URL', '//toutlike.com' );
// + BDD Namecheap (nom, user, pass depuis cPanel)
```

### 3.2 Restaurer `.htaccess` original
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
RewriteRule ^([a-zA-Z0-9-_/]+)$ index.php [QSA]
# php -- BEGIN cPanel-generated handler, do not edit
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php74___lsphp .php .php7 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit
```

### 3.3 Upload
1. Export BDD locale si modifiee (phpMyAdmin XAMPP)
2. Uploader fichiers via cPanel File Manager ou FTP vers `public_html/`
3. Importer BDD sur phpMyAdmin Namecheap
4. Permissions : dossiers `755`, fichiers `644`
5. Tester le site en production

### 3.4 Note importante
Les developpeurs anglais peuvent lancer une mise a jour a tout moment qui reinitialisera toutes les modifications. Garder une sauvegarde (`.zip`) des fichiers traduits. L'original non modifie est dans `Touttlike Projet - backup original\`.

---

## 4. Analyse approfondie du code source

### 4.1 Flux d'execution principal (`index.php` — 740 lignes)

1. **Bootstrap** : charge `vendor/autoload.php`, PHPMailer, puis `app/init.php`
2. **Routing** : parse `REQUEST_URI`, split par `/`, premier segment = route (ex: `neworder`, `auth`, `orders`)
3. **Langue** : detecte `?lang=xx` en GET, sinon session, sinon langue par defaut en BDD (`languages.default_language`)
4. **RTL** : si `ar` -> ajoute classes `body-rtl` et `table-rtl`
5. **Phone-home** : appelle `auto_register_site()` a CHAQUE page load — envoie l'URL du site vers `whois.smmpanelbdlab.com/database-check/register_api.php` (base64-encoded)
6. **Controleur** : `require controller($route[0])` — charge `app/controller/{route}.php`
7. **Maintenance** : si `site_maintenance == 1`, affiche `maintenance.php` et exit
8. **Rent check** : si `paidRent == 0` dans `admin_constants`, affiche `suspended.php` et exit
9. **Twig render** : deux branches — utilisateur non-connecte (`client_type == 1`) ou connecte, chacune passe 70+ variables au template
10. **Integrations** : apres le rendu, injecte les codes d'integration (chat, analytics, etc.) selon visibilite

### 4.2 Systeme d'initialisation (`app/init.php`)

- **Session** : `session_start()` + `ob_start()`
- **Connexion PDO** : MySQL via `app/config.php`, charset `utf8mb4`
- **Auth cookie** : verifie `u_id`, `u_login`, `u_password` — si cookie valide, restaure session (compare password hash directement)
- **Admin cookie** : meme logique avec `a_id`, `a_login`, `a_password`
- **Settings** : charge `settings` (table), `General_options`, `decoration`, `panel_info`
- **Twig** : initialise `Twig_Environment` (v2) avec `autoescape = false` (faille XSS)
- **Currency converter** : force la devise de base si le convertisseur est desactive
- **Helpers/Classes** : charge tous les `.php` dans `app/helper/` et `app/classes/` via `glob()`

### 4.3 Helper principal (`app/helper/data_control.php` — 1262 lignes)

Fichier le plus volumineux du projet. Fonctions critiques :

- **Auth** : `userlogin_check()` — password = `md5(sha1(md5($pass)))` (triple hash faible)
- **Validation** : `username_check()` (regex 4-32 chars), `email_check()` (filter_var)
- **DB generiques** : `countRow()`, `getRow()`, `getRows()` — query builder minimal avec `$data["table"]`, `$data["where"]`
- **Prix** : `service_price()`, `client_price()`, `ServicePrice()`, `APIServicePrice()` — prix personnalise par client
- **Devises** : `from_to()` — conversion entre devises via taux + taux inverse; `format_amount_string()` — formatage avec symbole
- **Reporting** : `dayPayments()`, `monthPayments()`, `dayCharge()`, `monthCharge()`, `dayOrders()` — rapports financiers admin
- **Instagram scraping** : `instagramProfilecheck()`, `instagramCount()` — scraping via `file_get_contents()` (casse depuis 2020+)
- **HTTP** : `HTTP_REQUEST()` — cURL avec `SSL_VERIFYPEER = 0` et `SSL_VERIFYHOST = 0`
- **Utilitaires** : `RAND_STRING()`, `priceFormat()`, `ROUND_AMOUNT()`, `APIRoundAmount()`, `generateUsername()`, `uuid()`
- **Shopier** : `generate_shopier_form()` — generateur formulaire paiement Shopier (methode turque)
- **Crypto** : `decrypt()` — AES-256-CBC, `generateKashierOrderHash()` — HMAC SHA256
- **Erreurs JSON** : `errorExit()`, `APIErrorExit()`, `success_response_exit()`

### 4.4 Helpers auxiliaires

- **`app/helper/app.php`** : fonctions routing (`controller()`, `view()`, `route()`, `site_url()`, `GetIP()`, `themeExtras()`)
- **`app/helper/admin.php`** : `admin_controller()`, `admin_view()`, `servicePackageType()`

### 4.5 Classes

- **`app/classes/smm.php`** :
  - `SMMApi` : client API cURL standard pour fournisseurs SMM (action POST, retour JSON)
  - `socialsmedia_api` : client API alternatif (format `jsonapi` wrapping)
- **`app/classes/mail.php`** : wrapper PHPMailer, credentials vides dans le code (configures en BDD `settings.smtp_*`)
- **`app/classes/sms.php`** : deux providers SMS (bizimsms et netgsm), envoi XML, fonctions `SMSUser()` et `SMSToplu()` (envoi groupé)

### 4.6 Systeme d'authentification

- **Inscription** (`signup.php`) :
  - Password stocke en `md5($pass)` (pas de salt)
  - Auto-login apres inscription
  - Systeme de parrainage via cookie `ref`
  - Solde gratuit configurable (`freebalance` / `freeamount`)
  - Confirmation email optionnelle
  - OTP login optionnel
- **Connexion** (`auth.php`) :
  - Login par username OU par email (deux branches)
  - Login Google OAuth2 (`google/apiclient`)
  - Cookies `remember me` (7 ou 28 jours)
  - reCAPTCHA optionnel (apres echec)
  - 2FA Google Authenticator (`pragmarx/google2fa`)
  - Password compare : `md5($pass)` en BDD vs `md5(sha1(md5($pass)))` dans `userlogin_check()` — INCONSISTANCE

### 4.7 Systeme de statuts utilisateur

Dans `index.php` (lignes 480-498), un systeme de statut base sur le total des paiements :
- `VIP` : paiements <= bronze_statu
- `JUNIOR` : bronze < paiements <= silver
- `REGULAR` : silver < paiements <= gold
- `NEW` : paiements > gold OU > bayi

(Variables `$bronz_statu`, `$silver_statu`, `$gold_statu`, `$bayi_statu` — non definies dans les fichiers lus, probablement en BDD settings)

### 4.8 API publique (`app/controller/api.php`)

- **Endpoint** : `POST /api/v2`
- **Auth** : parametre `key` ou `api_token`
- **Actions** :
  - `balance` : retourne solde + devise
  - `status` : statut commande (charge, start_count, status, remains) + support subscriptions/dripfeed
  - `services` : catalogue complet (service, name, type, category, rate, min, max, desc) — avec remise utilisateur
  - `add` : passer commande — supporte Default (1), Package (2), Custom Comments (3,4)
    - Verification : lien requis, quantite min/max, solde suffisant, doublon en cours
    - Commandes manuelles (service_api == 0) : insert + debit solde
    - Commandes API (service_api != 0) : appel fournisseur -> insert -> debit
    - Support prix personnalise (`clients_price`)
  - `refill` / `refill_status` : desactives (retournent erreur)
- **Erreurs** : format JSON `{"success": false, "error": "..."}`

### 4.9 Systeme de paiement (`app/controller/addfunds.php`)

- Architecture en deux etapes :
  1. **Initiator** (`addfunds/Initiators/{method}.php`) : cree le paiement en BDD + redirige vers la passerelle
  2. **Callback** (`app/controller/payment/{method}.php`) : verifie le paiement, credite le solde
- Chaque passerelle a ses extras JSON configures dans `paymentmethods.methodExtras`
- Gestion fees + bonus configurables par methode
- LengoPay (methode 21, active) : API `portal.lengopay.com`, paiements en GNF avec taux de change configurable

### 4.10 Cron jobs en detail

- **`smmpanelbdlab-orders.php`** (158 lignes) : boucle sur toutes les commandes pending/inprogress/processing, interroge l'API fournisseur pour le statut, met a jour la BDD (canceled -> remboursement, completed, partial -> remboursement partiel, etc.), utilise des transactions PDO
- **`smmpanelbdlab-dripfeed.php`** (134 lignes) : gere les livraisons echelonnees, verifie l'intervalle, passe de nouvelles commandes API a chaque cycle
- **Autres** : `smmpanelbdlab-refill.php` (rechargements + faux compteur commandes), `smmpanelbdlab-payments.php` (paiements en attente), `smmpanelbdlab-average.php` (temps moyen), `smmpanelbdlab-seller-sync.php` (sync services), `smmpanelbdlab-autoreply.php` (tickets), `smmpanelbdlab-autolike.php` (likes auto)

### 4.11 Systeme de langue

- **Fichiers** : `app/language/{en,fr,ar,hi,default}.php` — tableau PHP `$languageArray` avec ~322 cles
- **Etat actuel** : `fr.php` et `default.php` ont ete traduits en francais pour les messages publics critiques
- **Important** : les pages publiques non connectees chargent la langue selon `index.php` : `?lang=xx` -> session -> langue par defaut en BDD (`languages.default_language`)
- **Constat local au 2026-04-15** : la langue publique par defaut en base est `en`, donc plusieurs messages visibles doivent aussi etre corriges dans `app/language/en.php`
- Multi-langues DB : champs `*_lang` en JSON (`category_name_lang`, `menu_name_lang`, `news_title_lang`, `news_content_lang`, `name_lang`)
- Selection : `?lang=xx` -> session -> cookie -> defaut BDD

### 4.12 Fichiers caches / backdoors

- **`app/hidden/proxy.php`** (97 lignes) : **ACCES DIRECT SANS AUTH** a la BDD via POST. Actions : `get_tables` (liste tables), `view` (SELECT * LIMIT 50), `update` (UPDATE arbitraire), `delete` (DELETE arbitraire). Headers CORS `*`. **CRITIQUE : n'importe qui peut lire/modifier/supprimer des donnees.**
- **`app/hidden/bridge.php`** (23 lignes) : scraper Instagram via cURL + proxy (proxylist.txt). Contient un bug : `$proxylist` vs `$proxyList` (casse differente).
- **`refills.php`** (racine) : script ALTER TABLE pour ajouter la colonne `paidRent` a `admin_constants`. Semble etre un script d'installation one-shot du mecanisme de controle de "location" (rent control par le developpeur BD Lab).

### 4.13 Mecanisme de "rent control" (paidRent)

- Table `admin_constants` contient un champ `paidRent` (boolean, default 0)
- Dans `index.php` (ligne 154) : si `paidRent == 0`, le site entier est bloque (affiche `suspended.php`)
- Le developpeur BD Lab peut potentiellement remettre `paidRent = 0` a distance via le phone-home ou directement en BDD
- `refills.php` est le script qui cree cette colonne

### 4.14 Dependances Composer

- `twig/twig` ^2.0 (moteur de templates)
- `phpmailer/phpmailer` ^6.7 (emails)
- `stripe/stripe-php` * (paiements Stripe)
- `mollie/mollie-api-php` ^2.0 (paiements Mollie — semble inutilise)
- `paypal/rest-api-sdk-php` (paiements PayPal — present dans vendor mais pas dans addfunds)
- `pragmarx/google2fa` ^8.0 (2FA)
- `bacon/bacon-qr-code` ^2.0 (QR codes pour 2FA)
- `google/apiclient` ^2.0 (Google OAuth login)
- `firebase/php-jwt` (dependance Google)
- `guzzlehttp/guzzle` (HTTP client)
- `monolog/monolog` (logging — semble inutilise dans le code principal)

### 4.15 Themes et templates

- **Theme actif** : `SMMRX-smmpanelbdlab` (stocke dans `settings.site_theme`)
- **34 fichiers `.twig`** dans `app/views/SMMRX-smmpanelbdlab/`
- **Twig v2** : syntaxe `{{ variable }}`, `{% if %}`, `{% for %}`, `{% include %}`
- **Pas d'autoescape** : `['autoescape' => false]` dans init.php
- Templates additionnels disponibles : dossier `Simplify/` dans `public/` (CSS uniquement, theme alternatif)

### 4.16 Assets front-end

- **Panel** : Bootstrap CSS + JS custom (`public/js/script.js`, `public/js/ajax.js`, `public/js/toolkit.js`)
- **Admin** : Bootstrap + ApexCharts + iziToast + TinyToggle + ImagePicker + FancySelect + Tom Select
- **Themes CSS** : `Simplify/` (12 variantes couleur), `pitchy/` (green, orange, parrot), `bero/`
- **Global** : fichiers JS obfusques (hashes dans les noms)

### 4.17 Points d'attention pour le developpement

- **Pas d'ORM** : toutes les requetes sont du SQL brut via PDO. Certaines utilisent `$conn->query()` avec interpolation directe (risque SQL injection dans les fonctions de reporting)
- **Sessions PHP** : prefixe `msmbilisim_` (nom du developpeur original)
- **Pas de CSRF** : aucun token sur les formulaires
- **Erreur display** : `error_reporting(0)` en config (prod), pas de logging visible
- **Encodage** : `utf8mb4` en BDD, `utf-8` dans les mails
- **Timezone** : `Asia/Dhaka` par defaut (Bangladesh, a changer pour la Guinee : `Africa/Conakry` ou `GMT`)
- **Variables turques** : beaucoup de variables en turc dans le code (`$oturum` = session, `$cekilendatalar` = donnees recues, `$sonuc` = resultat, `$uye_id` = user_id, `$bayi_statu` = dealer_status, etc.)

---

## 5. Resume des fichiers par importance

### Fichiers critiques (a comprendre en priorite)
- `index.php` — routeur + rendu Twig (740 lignes)
- `app/init.php` — bootstrap complet
- `app/config.php` — configuration BDD/URL
- `app/helper/data_control.php` — 1262 lignes, coeur logique
- `app/controller/api.php` — API publique REST
- `app/controller/neworder.php` — passage de commande
- `app/controller/auth.php` — login/register
- `app/controller/addfunds.php` — ajout de fonds

### Fichiers de template (traduits en francais)
- `app/views/SMMRX-smmpanelbdlab/*.twig` — 34 fichiers

### Fichiers admin (non traduits, non modifies)
- `admin/controller/*.php` — 41 controleurs
- `admin/views/*.php` — ~90 vues

### Fichiers dangereux (SUPPRIMES en Phase 1)
- ~~`app/hidden/proxy.php`~~ — SUPPRIME (backdoor BDD sans auth)
- ~~`app/hidden/bridge.php`~~ — SUPPRIME (scraper Instagram)
- ~~`app/hidden/proxylist.txt`~~ — SUPPRIME
- ~~`refills.php`~~ — SUPPRIME (script ALTER TABLE rent control)

---

## 6. Phase 1 — Securisation (effectuee le 2026-04-14)

### 6.1 Backdoors et phone-home supprimes
- **`app/hidden/proxy.php`** : SUPPRIME — donnait un acces CRUD complet a la BDD sans aucune authentification
- **`app/hidden/bridge.php`** : SUPPRIME — scraper Instagram non fonctionnel
- **`app/hidden/proxylist.txt`** : SUPPRIME — liste de proxies pour le scraper
- **`refills.php`** (racine) : SUPPRIME — script ALTER TABLE pour le rent control BD Lab
- **`auto_register_site()`** dans `index.php` : SUPPRIME — envoyait l'URL du site a `whois.smmpanelbdlab.com` a chaque page load (constantes `API_SERVER_ADDR`, `CLIENT_AUTH_KEY`, fonctions `decode_data`, `auto_register_site` et l'appel)
- **Check `paidRent`** dans `index.php` : SUPPRIME — le dev BD Lab pouvait bloquer le site a distance en mettant `paidRent=0`

### 6.2 Migration mots de passe MD5 vers bcrypt
- **Nouveau fichier** : `app/helper/password.php` — fonctions `toutlike_hash_password()`, `toutlike_verify_password()`, `toutlike_needs_rehash()`, `toutlike_migrate_password()`, `toutlike_login_check()`
- **Migration transparente** : au login, si le hash stocke est en MD5 (32 chars), on verifie avec MD5 puis on re-hash en bcrypt et on sauvegarde. Les nouveaux mots de passe sont directement en bcrypt.
- **Fichiers modifies** :
  - `app/controller/auth.php` — login username + login email + Google OAuth signup
  - `app/controller/signup.php` — inscription + auto-login post-inscription
  - `app/controller/account.php` — changement de mot de passe
  - `app/controller/resetpassword.php` — reset password
  - `app/helper/data_control.php` — `userlogin_check()` reecrite pour utiliser `toutlike_login_check()`
- **BDD** : colonne `clients.password` et `admins.password` agrandie de TEXT a VARCHAR(255) pour supporter bcrypt (60 chars)
- **Ancienne incohérence corrigee** : `md5($pass)` en BDD vs `md5(sha1(md5($pass)))` dans `userlogin_check()` — maintenant tout passe par bcrypt

### 6.3 Protections de base
- **Autoescape Twig** : active (`'autoescape' => 'html'`) dans `app/init.php` — protege contre XSS dans tous les templates
- **Protection CSRF** : nouveau fichier `app/helper/csrf.php` — token genere en session, verifie sur tous les POST (sauf API publique et callbacks paiement). Fonctions Twig `csrf_token()` et `csrf_field()` disponibles dans les templates.
- **SSL verification** : `SSL_VERIFYPEER` et `SSL_VERIFYHOST` actives dans `HTTP_REQUEST()` (`data_control.php`)
- **Cookies session securises** : `httpOnly`, `SameSite=Lax`, `use_strict_mode` actives dans `app/init.php`

### 6.4 Nettoyage traces BD Lab
- **Headers BD Lab** supprimes dans les 8 cron jobs (`public/cronjob/*.php`) — remplaces par `// ToutLike - Cron Job`
- **Prefixes de session** renommes : `msmbilisim_` → `toutlike_` dans **36 fichiers** (app/, admin/, index.php)
- **Timezone** : `Asia/Dhaka` → `Africa/Conakry` dans `app/config.php`

### 6.5 Utilisation du CSRF dans les templates
Pour que les formulaires fonctionnent avec la nouvelle protection CSRF, ajouter dans chaque `<form method="POST">` :
```
{{ csrf_field() }}
```
Exemple :
```html
<form method="POST" action="/neworder">
  {{ csrf_field() }}
  <!-- champs du formulaire -->
</form>
```
Les routes exclues de la verification CSRF : `api`, `payment`, `ajax_data`, `admin`.

---

## 7. Phase 2 — Restructuration du code (effectuee le 2026-04-14)

### 7.1 Fichier .env + loader de configuration
- **Nouveau fichier** : `.env` a la racine — contient toutes les variables de config (APP_URL, DB_*, SMTP_*, APP_TIMEZONE, APP_ENV)
- **Nouveau fichier** : `app/env.php` — loader qui parse `.env` et expose la fonction `env($key, $default)`
- **`app/config.php`** migre pour utiliser `env()` au lieu de valeurs en dur
- **Mode dev/prod** : si `APP_ENV=local`, affiche les erreurs PHP. Si `APP_ENV=production`, les masque.
- **Important** : `.env` ne doit PAS etre commite en production. Creer un `.env.example` pour la reference.

### 7.2 Routing centralise + middleware auth
- **Nouveau fichier** : `app/routes.php` — tableau de 50+ routes avec indication `auth: true/false` et `admin: true/false`
- **Middleware auth** dans `index.php` — avant de charger le controleur, verifie si la route requiert une session active. Redirige vers `/auth` si non connecte.
- Les routes publiques (auth, signup, services, blog, faq, etc.) sont accessibles sans connexion.
- Les routes protegees (neworder, orders, addfunds, tickets, account, etc.) requierent une session active.

### 7.3 Decoupage de data_control.php en modules
Le fichier monolithique de 1262 lignes a ete decoupe en modules thematiques :
- **`app/helper/currency.php`** — 14 fonctions devises : getCurrencyUnit, get_currencies_array, from_to, format_amount_string, ROUND_AMOUNT, priceFormat, etc.
- **`app/helper/reporting.php`** — 7 fonctions rapports : dayPayments, monthPayments, dayCharge, monthCharge, monthChargeNet, dayOrders, monthOrders + helper _build_order_where
- **`app/helper/password.php`** — (Phase 1) 5 fonctions bcrypt
- **`app/helper/csrf.php`** — (Phase 1) 4 fonctions CSRF
- **`app/helper/data_control.php`** — conserve les fonctions restantes : validation (username_check, email_check, userdata_check), DB generiques (countRow, getRow, getRows), services (service_price, serviceSpeed), utilitaires (array_group_by, HTTP_REQUEST, RAND_STRING, icon, etc.)

### 7.4 Traduction fr.php (322 cles)
- **`app/language/fr.php`** entierement traduit en francais (etait 100% en anglais)
- Adaptations specifiques Guinee : noms de clients guineeens (Mamadou Diallo, Aissatou Barry, Ibrahim Soumah), references ToutLike au lieu de SMM Panel/SEOClevers, devise GNF au lieu de TL
- Les cles `theme1.*` et `theme2.*` (textes landing page) ont ete traduits et localises

### 7.5 Tokens CSRF injectes dans les templates
- **21 templates Twig** mis a jour avec `{{ csrf_field() }}` apres chaque balise `<form>`
- Templates concernes : account, addfunds, api, child-panels, confirm_email, dripfeeds, earn, kupon, login, massorder, neworder, open_ticket, orders, refer, refill, resetpassword, setnewpassword, signup, subscriptions, tickets, transferfunds

### 7.6 Nouveaux fichiers crees en Phase 2
```
.env                        # Variables d'environnement
app/env.php                 # Loader .env
app/routes.php              # Table de routing centralisee
app/helper/currency.php     # Module devises
app/helper/reporting.php    # Module rapports financiers
```

---

## 8. Nettoyage localisation Guinee (effectue le 2026-04-14)

### 8.1 Devise par defaut
- **`settings.site_base_currency`** : `USD` → `GNF`
- **Devises actives** : GNF (principal) + USD (pour les fournisseurs API)
- **Devises desactivees** : INR (Inde), BDT (Bangladesh)
- **Tous les clients** migres vers `currency_type = 'GNF'`

### 8.2 Informations du site
- **Titre SEO** : `ToutLike - Panel N°1 de services reseaux sociaux en Guinee`
- **Description** : Texte en francais, mentionne Guinee, GNF, LengoPay
- **Mots-cles** : toutlike, panel guinee, smm guinee, followers, conakry, gnf, lengopay
- **Pages SEO** : 12 pages avec titres en francais (Connexion, Inscription, Services, etc.)

### 8.3 Passerelles de paiement
- **LengoPay (GNF)** : seule passerelle active (methodId=21, status=1)
- **Methodes manuelles renommees** :
  - 100 : Orange Money (Manuel) — GNF
  - 101 : MTN Mobile Money (Manuel) — GNF
  - 102 : Virement Bancaire (Manuel) — GNF
  - 103 : Crypto USDT (Manuel) — USD
  - 104-109 : Paiement Manuel 5-10 — GNF (reserves)
- **Passerelles etrangeres** (1-20) : toutes desactivees (status=0). Peuvent etre reactivees si besoin (Stripe, Flutterwave, etc.)

### 8.4 Noms localises
- Anciens noms Bangladesh (bKash, Nagad) remplaces par Orange Money, MTN
- Noms de temoignages dans fr.php : Mamadou Diallo, Aissatou Barry, Ibrahim Soumah, Mamadou Camara
- Adresses : Conakry, Guinee

---

## 9. Corrections et ajustements post-deploiement (2026-04-14/15)

### 9.1 Corrections PHP warnings
- **`init.php`** : ajout `!empty()` et `?? 0` sur tous les acces `$_COOKIE`, `$_SESSION`, `$user` pour eviter les "Undefined array key" quand l'utilisateur n'est pas connecte
- **`index.php`** : meme corrections sur `$_GET["lang"]`, `$_SESSION["lang"]`, `$user["auth"]`, `$_SESSION["toutlike_userlogin"]`
- **`data_control.php`** : `countRow()` et `getRows()` — ajout `!empty()` au lieu d'acces direct a `$data["where"]`; `generateKashierOrderHash()` — parametre optionnel `$currency` deplace en dernier
- **`app/config.php`** : `error_reporting` mis a `E_ERROR | E_PARSE` en mode local (le code legacy a des centaines de warnings)

### 9.2 Autoescape Twig — variables `|raw`
L'activation de `autoescape: html` a casse l'affichage de certaines variables contenant du HTML brut. Corrections :
- `login.twig` ligne 280 : `{{ google_login_content|raw }}` — bouton Google Login
- `header.twig` lignes 626 et 749 : `{{ currencies_dropdown|raw }}` — dropdown devises
- `neworder.twig` ligne 380 : `{{ category_html_simplify|raw }}` — select categories
- `addfunds.twig` ligne 243 : `{{ site["paymentMethodsJSON"]|raw }}` — JSON methodes paiement
- `addfunds.twig` ligne 254 : ajout `_csrf_token` dans l'appel AJAX getForm

### 9.3 BDD — corrections colonnes et mode SQL
- `clients.passwordreset_token` : modifie en `VARCHAR(255) DEFAULT NULL`
- `clients.discount_percentage` : modifie en `INT(11) NOT NULL DEFAULT 0`
- `clients.lang` : defaut change de `'tr'` a `'fr'`
- `clients.currency` : defaut change en `'GNF'`
- **Mode SQL strict desactive** : `sql_mode=NO_ENGINE_SUBSTITUTION` dans `my.ini` (le code legacy ne definit pas de valeur par defaut sur beaucoup de colonnes)
- Table `admins` reparee (crash MyISAM apres arret brutal XAMPP) + compte admin recree

### 9.4 Login admin migre vers bcrypt
- **`admin/controller/login.php`** : reecrit pour utiliser `toutlike_verify_password()` avec migration transparente
- Au premier login, le mot de passe en clair est automatiquement hashe en bcrypt
- Route `admin` ajoutee aux exclusions CSRF (le panel admin n'utilise pas Twig)

### 9.5 Passerelles de paiement nettoyees
- Toutes les passerelles sauf LengoPay **supprimees** de la table `paymentmethods` (pas juste desactivees)
- LengoPay : seule passerelle restante (methodId=21)

### 9.6 Systeme de devises corrige
- **Devise interne** : USD (pour compatibilite avec les prix API fournisseurs)
- **Devise client** : GNF (affichage, convertisseur active `site_currency_converter=1`)
- **Taux** : 1 USD = 10 000 GNF (`currency_rate=10000`, `currency_inverse_rate=0.0001`)
- **LengoPay** : `exchange_rate=10000` (convertit USD interne en GNF pour le paiement), min=$2 (=20 000 GNF), max=$5000
- **Soldes clients** divises par 10 000 (correction apres le changement de devise de base)
- **Formatage GNF** : sans decimales, separateur espace, symbole a droite (ex: `≈ 1 840 GNF`)
- **Devises INR et BDT desactivees**, GNF symbole `Fr`, position `right`

### 9.7 SSL corrige pour XAMPP local
- Telecharge `cacert.pem` (Mozilla CA bundle) dans `C:\xampp\php\extras\ssl\`
- Configure `curl.cainfo` et `openssl.cafile` dans `php.ini`

### 9.8 Traduction ajax_data.php
- Tous les labels du formulaire de commande traduits en francais : Lien, Quantite, Commentaires, Diffusion programmee, etc.
- Section "Average time" supprimee du formulaire
- Cron job `smmpanelbdlab-average.php` : textes traduits ("Pas assez de donnees", "X h et Y min")
- Valeurs existantes en BDD mises a jour

### 9.9 Bug JS corrige (script.js)
- Doublon de fonction `category_detail()` dans `public/script.js` — la premiere version (buggee, utilisait `data.services` au lieu de `json.services`) a ete supprimee, la seconde (correcte) conservee

---

## 10. Phase 3 — Refonte design pages publiques (effectuee le 2026-04-15)

### 10.1 Principes de design
- **Mobile-first** : toutes les pages sont responsive, optimisees pour les telephones
- **Zero CDN** : tout le CSS est inline, polices systeme, icones SVG integrees
- **Design sombre** : fond #050a18, cartes #0f172a, accents bleu #3b82f6 et violet #a855f7
- **Animations CSS** : fadeUp au chargement, hover effects sur les cartes
- **Minimaliste** : textes essentiels uniquement, pas de surcharge

### 10.2 Template de base `public_base.twig`
- **Nouveau fichier** : `app/views/SMMRX-smmpanelbdlab/public_base.twig`
- Contient : CSS commun, navbar, footer, structure de page
- Toutes les pages publiques (sauf login/signup) heritent de ce template via `{% extends 'public_base.twig' %}`
- Navbar : Services | A propos | Blog | Contact | [Connexion] [S'inscrire]
- Footer : Services | A propos | Blog | Contact | FAQ | Conditions + copyright
- Sur mobile : liens nav masques, seuls Connexion/S'inscrire visibles

### 10.3 Pages refaites

| Page | Fichier | Design |
|---|---|---|
| **Login** | `login.twig` | Standalone. Hero gauche (badge, titre gradient, icones plateformes SVG) + carte login droite. Sections services, FAQ accordion, CTA. Bouton Google corrige avec SVG. |
| **Inscription** | `signup.twig` | Standalone. Info gauche (3 features avec icones) + formulaire droite (nom, username, email, tel, mdp, conditions). |
| **Reset password** | `resetpassword.twig` | Extends public_base. Formulaire centre simple. |
| **Nouveau password** | `setnewpassword.twig` | Extends public_base. 2 champs mdp + confirmation. |
| **Services** | `services.twig` | Extends public_base. Tableau par categorie avec ID, nom, tarif, min, max. CTA inscription. |
| **A propos** | `about-us.twig` | Extends public_base. Mission + 3 cartes features + contact. |
| **Contact** | `contact-us.twig` | Extends public_base. Email + adresse + CTA ticket support. |
| **FAQ** | `faq.twig` | Extends public_base. 8 questions en accordion. CTA support. |
| **Conditions** | `terms.twig` | Extends public_base. 6 sections juridiques. Supporte contenu dynamique BDD. |
| **Blog** | `blog.twig` | Extends public_base. Grille de cartes articles. Etat vide si pas d'articles. |
| **Article blog** | `singleblog-post.twig` | Extends public_base. Image + titre + contenu. Lien retour. |

### 10.4 Fichiers backup
Tous les anciens templates sont sauvegardes en `.twig.backup` dans le meme dossier.

### 10.5 Note importante
Les pages du **dashboard utilisateur** (une fois connecte) n'ont **PAS** ete modifiees :
- `header.twig`, `footer.twig` (sidebar + layout interne) : inchanges
- `neworder.twig`, `orders.twig`, `addfunds.twig`, `account.twig`, etc. : inchanges
- Le design interne du dashboard client reste tel quel (bleu/noir avec sidebar)

---

## 11. Phase 4 — Refonte design panel admin (effectuee le 2026-04-15)

### 11.1 Page login admin
- **Fichier** : `admin/views/login.php` (ancien sauvegarde en `login.php.backup`)
- **Supprime** : CDN `storage.smmpanelbdlab.com` (CSS BD Lab), CDN Google Fonts Poppins, CDN Font Awesome 6.4, commentaire copyright BD Lab / Shihab Mia, logo cliquable vers smmpanelbdlab.com, toutes les classes CSS `smmpanelbdlab-script-*`
- **Ajoute** : design dark moderne (fond #050a18, carte centree avec gradient top bar violet→bleu), icone bouclier SVG inline, logo dynamique (`$settings['site_logo']`), favicon dynamique, section 2FA visuellement separee, background blobs + grille, animation entree, lien « Retour au site », footer copyright dynamique, tout en francais
- **Messages d'erreur traduits** dans `admin/controller/login.php` : "Please verify..." → "Veuillez verifier...", "Your account is Suspended" → "Votre compte est suspendu", "Invalid Code" → "Code 2FA invalide", "Could not find..." → "Aucun compte administrateur trouve..."

### 11.2 Header admin — Sidebar moderne
- **Fichier** : `admin/views/header.php` (ancien sauvegarde en `header.php.backup`)
- **Architecture** : remplacement de l'ancienne navbar Bootstrap 3 horizontale par un layout **sidebar fixe + topbar + main content**
- **Sidebar** (`aside.tl-sidebar`) :
  - Fond dark violet `#13111c`, largeur 260px
  - Logo + nom du site en haut
  - Items avec padding 11px, font-size 14px, border-radius 10px
  - Item actif : fond violet plein `#7c5cfc` avec glow/ombre (`box-shadow: 0 2px 12px rgba(124,92,252,.35)`)
  - Hover : fond blanc 4% opacity
  - Sections titres en uppercase (Principal, Utilisateurs, Paiements, Services, Commandes, Support, Extras, Apparence, Systeme)
  - Badges notifications (Tickets non lus, notifications paiement) en rouge
  - Profil admin en bas : carte violette semi-transparente avec icone, nom site, username
  - Bouton Deconnexion rouge au hover
  - Scrollbar fine 3px
- **Topbar** (`header.tl-topbar`) :
  - Fixe en haut, fond `var(--card)`
  - Nom du site a gauche
  - Boutons : Mode clair/sombre, Voir le site, Deconnexion
  - Hamburger menu sur mobile (< 991px)
- **Mobile** :
  - Sidebar cachee par defaut, apparait via bouton hamburger
  - Overlay sombre avec backdrop-filter blur
  - Sidebar se ferme au clic sur un lien
  - Boutons topbar : labels masques < 576px, seules icones visibles
- **Tout traduit en francais** : 30+ liens de navigation
- **Ancienne navbar Bootstrap** cachee via CSS (`display:none!important`)
- **Permissions respectees** : chaque lien sidebar est conditionne par `$admin["access"]["..."]`

### 11.3 Dark mode corrige
- **Palette violet-sombre** : `--bg:#0e0b16`, `--card:#15121e`, `--border:#1f1b2e`
- **55+ overrides CSS** pour Bootstrap components : `.panel`, `.panel-heading`, `.table`, `.form-control`, `.modal-content`, `.dropdown-menu`, `.list-group-item`, `.pagination`, `.nav-tabs`, `.nav-pills`, `.alert`, `.close`, `.input-group-addon`, labels, headings h1-h5
- **Couleur accent** : liens en violet clair `#a78bfa`, focus inputs en violet `rgba(124,92,252,.2)`

### 11.4 Dashboard admin (`admin/views/index.php`)
- **Ancien sauvegarde** : `index.php.backup`
- **Supprime** : carte "SMM Script" avec lien vers smmpanelbdlab.com, CDN Google Fonts Inter, CDN Font Awesome 6.0, toutes les classes `smmpanelbdlab-*`
- **11 cartes KPI traduites** : Utilisateurs, Commandes, Recharges en cours, Tickets non lus, Paiements recus, Categories, Services, Commandes (total affiche), Devises actives, Fournisseurs API, Diffusions actives
- **Bandeau 2FA traduit** : "Securisez votre compte !", boutons "Activer 2FA" / "Desactiver 2FA"
- **Modals traduits** : "Etes-vous sur de vouloir continuer ? Oui / Non"
- **Nouvelles classes CSS** : `tl-dash`, `tl-card`, `tl-card-head`, `tl-card-foot`, `tl-2fa-box` avec gradients colores

### 11.5 CSS global admin (`public/admin/tl-admin.css`)
- **Nouveau fichier** : 175 lignes de CSS applique automatiquement a toutes les pages admin
- **Scope `.tl-main`** : tous les selecteurs prefixes par `.tl-main` pour battre la specificite des anciens CSS Bootstrap (~1.2 Mo)
- **Charge en dernier** dans le `<head>` du header.php (apres tous les autres CSS)
- **Composants styles** :
  - `.nav-tabs` → pilules arrondies 8px, actif en violet
  - `.table` → headers uppercase 11px, hover violet, bordures subtiles, wrapper arrondi 12px
  - `.btn` → arrondis 8px, couleurs coherentes (violet, vert, rouge, orange)
  - `.dropdown-menu` → arrondis 10px, ombres, items avec padding et hover violet
  - `.form-control` → arrondis 8px, focus violet avec glow
  - `.alert` → arrondis 10px, bordure gauche coloree
  - `.pagination` → boutons arrondis 8px, actif en violet
  - `.panel` / `.well` → arrondis 12px
  - `.modal-content` → arrondis 14px, dark mode avec fond `#1a1726`
  - Scrollbar fine 6px
  - Responsive mobile (padding reduit, tailles ajustees)

### 11.6 Page Clients refaite (`admin/views/clients.php`)
- **Ancien sauvegarde** : `clients.php.backup`
- **Design** : header avec titre "Utilisateurs" + 5 boutons d'action (Ajouter, Backup, Notification, Contacts, Details)
- **Recherche** : input + select + bouton violet
- **Table** : conteneur arrondi 12px, username+email empiles, solde en vert, depenses en orange, boutons-tags pour remise et tarifs speciaux, date formatee FR, dropdown actions avec icones
- **100% fonctionnel** : tous les `data-toggle="modal"`, `data-action`, `data-id`, liens href preserves

### 11.7 Page Commandes refaite (`admin/views/orders.php`)
- **Ancien sauvegarde** : `orders.php.backup`
- **Filtres** : pilules arrondies (Toutes, En attente, Pending, Traitement, En cours, Terminees, Partielles, Annulees, Echec) avec badges compteurs
- **Recherche** : input + select (ID/URL/Utilisateur) + bouton
- **Table** : montant et profit colores, liens tronques avec tooltip, service avec ID badge, mode Manuel/API avec tags colores, dropdown actions avec icones et sous-menu "Changer statut"
- **Bulk actions** : checkbox + dropdown (Renvoyer, Pending, En cours, Terminee, Annuler & rembourser)
- **Pagination** + compteur total

### 11.8 Pages migrees de `new-header.php` vers `header.php`
4 pages utilisaient un layout alternatif (`new-header.php` + `new-footer.php`, Bootstrap 5). Toutes migrees vers le layout standard :
- **`fund-add-history.php`** : titre "Historique des fonds", bouton "Ajouter/Deduire solde", table AJAX avec montants vert/rouge, modal BS3 avec formulaire dynamique, soumission AJAX + toast iziToast
- **`special-pricing.php`** : titre "Tarifs speciaux", boutons "Creer tarif special" + "Tout supprimer", table AJAX
- **`update-prices.php`** : titre "Mettre a jour les prix", formulaire dans carte moderne (type services, fournisseurs, % profit)
- **`category-sort.php`** : titre "Tri des categories", liste drag-and-drop dans conteneur arrondi

### 11.9 Traduction modals de confirmation
- **12 fichiers** modifies en batch : `api-services.php`, `bulk.php`, `bulkc.php`, `earn.php`, `logs.php`, `orders.php`, `refill.php`, `services.php`, `synced_logs.php`, `tickets.php`, `updates.php`
- "Are you sure you want to update the status?" → "Etes-vous sur de vouloir continuer ?"
- "Are you sure you want to proceed?" → "Etes-vous sur de vouloir continuer ?"
- "Yes" → "Oui", "No" → "Non"

### 11.10 Fichiers backup crees
```
admin/views/login.php.backup
admin/views/header.php.backup
admin/views/index.php.backup
admin/views/clients.php.backup
admin/views/orders.php.backup
admin/views/fund-add-history.php.backup
admin/views/special-pricing.php.backup
admin/views/update-prices.php.backup
admin/views/category-sort.php.backup
```

### 11.11 Nouveaux fichiers crees en Phase 4
```
public/admin/tl-admin.css              # CSS global admin (175 lignes)
admin/views/login.php                   # Page login admin (refaite)
admin/views/header.php                  # Sidebar + topbar (refaite)
admin/views/index.php                   # Dashboard (refait)
admin/views/clients.php                 # Page clients (refaite)
admin/views/orders.php                  # Page commandes (refaite)
admin/views/fund-add-history.php        # Historique fonds (migre)
admin/views/special-pricing.php         # Tarifs speciaux (migre)
admin/views/update-prices.php           # Maj prix (migre)
admin/views/category-sort.php           # Tri categories (migre)
```

### 11.12 Note technique — Dependances CSS
Les anciens fichiers CSS Bootstrap (~1.2 Mo) sont **conserves** car les vues admin non-refaites en dependent :
- `public/admin/bootstrap.css` (177 Ko)
- `public/admin/style.css` (155 Ko)
- `public/admin/custom.css` (446 Ko)
- `public/css/admin/main.css` (273 Ko)
- `public/admin/main.css` (468 Ko)

Le fichier `tl-admin.css` est charge **en dernier** et ses selecteurs sont scopes sous `.tl-main` pour garantir la priorite sur les anciens styles.

---

## 12. Phase 5 — Enrichissement page login + inscription (effectuee le 2026-04-15)

### 12.1 Redesign complet `login.twig`
- **Fichier** : `app/views/SMMRX-smmpanelbdlab/login.twig` — page standalone (n'herite pas de `public_base.twig`)
- **Structure finale** :
  - Navbar fixe glassmorphism avec toggle theme clair/sombre + burger mobile
  - Hero en 2 colonnes : copy gauche + formulaire login droite (inversé sur mobile : login en premier)
  - Bouton ancre mobile fixe "Se connecter maintenant" (`#loginPanel`)
  - Formulaire login complet : username, password, remember me, captcha, bouton submit, Google login
  - Toutes les variables Twig preservees : `{{ csrf_field() }}`, `error/errorText`, `success/successText`, `captcha/captchaKey`, `google_login_content`, `headerCode|raw`, `footerCode|raw`

### 12.2 Blocs de conversion ajoutes au login
- **Compteurs metriques** : 10 000+ clients, 1,2M+ interactions, ~2 min livraison
- **Zone visuel principal** : image TikTok/Guinee (personnage 3D avec drapeau guineen) dans un cadre avec effets gradient + glow
- **Bloc Orange Money** : vraie image du logo Orange Money + description + 3 badges (Recharge rapide, Usage mobile local, Paiement simple)
- **Compte a rebours** : "Promo du jour : -20% sur les likes TikTok" avec compteur heures/minutes/secondes qui se remet a zero a minuit
- **Section services** : 3 cartes (Likes & Followers, Vues & Commentaires, Abonnes & Partages) orientees TikTok/Facebook/Instagram/YouTube
- **FAQ** : 4 questions concretes (Qu'est-ce que le site, Securite, Livraison, Paiement Guinee)
- **Temoignages clients** : 3 avis avec photos reelles, noms guineens, localisations Conakry, textes credibles et detailles
- **CTA final** : "Pret a exploser sur les reseaux ?" avec bouton inscription

### 12.3 Images integrees

| Image | Source | Destination projet | Usage |
|---|---|---|---|
| Visuel TikTok/Guinee | `C:\xampp\htdocs\img\Tiktok.png` | `img/login-tiktok-guinee.png` | Zone hero visuel principal login |
| Logo Orange Money | `C:\xampp\htdocs\img\orange.png` | `img/orange-money.png` | Bloc Orange Money dans la sidebar de preuve |
| Photo Mamadou B. | `C:\xampp\htdocs\img\Mamadou B..jpg` | `img/testimonials/mamadou-b.jpg` | Temoignage client #1 |
| Photo Aissatou D. | `C:\xampp\htdocs\img\Aissatou D.jpg` | `img/testimonials/aissatou-d.jpg` | Temoignage client #2 |
| Photo Ibrahima K. | `C:\xampp\htdocs\img\Ibrahima K..jpg` | `img/testimonials/ibrahima-k.jpg` | Temoignage client #3 |

### 12.4 Textes marketing recrits
- **Positionnement** : services reseaux sociaux (jamais "SMM" — terme interdit par le client)
- **Plateformes mises en avant** : TikTok, Facebook, Instagram, YouTube (les 4 seules utilisees)
- **Ton** : direct, concret, chiffres reels, urgence, preuve sociale locale
- **Badge hero** : `TikTok · Facebook · Instagram · YouTube`
- **Titre hero** : "Boostez vos reseaux sociaux depuis la Guinee"
- **Texte hero** : mentionne likes/followers/vues/commentaires, Orange Money, 2 minutes
- **Temoignages** : histoires concretes (vendeur TikTok 5000 followers, commercante Instagram/Facebook, YouTubeur qui depasse les 100 vues)
- **FAQ** : reponses pratiques (pas de mot de passe demande, lien profil suffit, Orange Money sans compte bancaire)
- **CTA** : "Pret a exploser sur les reseaux ?" + mention des 4 plateformes

### 12.5 Design technique login
- **Theme toggle** : bascule dark/light persistee en `localStorage('tl_theme')`
- **Mobile-first** : login panel passe en premier (`order:-1`) sous 820px
- **Barre fixe mobile** : "Se connecter maintenant" collee en bas de l'ecran
- **Compte a rebours JS** : calcule le temps restant jusqu'a minuit, se remet a zero automatiquement
- **FAQ accordion** : ouverture/fermeture JS natif, premier element ouvert par defaut
- **Image fallback** : si `/img/login-tiktok-guinee.png` echoue, un placeholder "GN" s'affiche via `onerror` + classe CSS `.no-image`
- **Responsive breakpoints** : 1080px (grilles 1 colonne), 820px (mobile nav), 640px (padding reduit)

### 12.6 Page inscription `signup.twig` mise a jour
- **Badge** : `TikTok · Facebook · Instagram · YouTube` (au lieu de "Creer un compte client")
- **Titre** : "Creez votre compte et boostez vos reseaux en 2 minutes"
- **Texte** : mentionne likes/followers/vues/commentaires, Orange Money, commande immediate
- **4 points forts** : Livraison ~2 min, Paiement Orange Money, 4 plateformes couvertes, +10 000 clients
- **3 stats** : 100% mobile, Prix imbattables, Support 24/7
- **Sous-titre formulaire** : oriente vers la commande de likes/followers/vues sur les 4 plateformes
- **Bouton Google** : "S'inscrire avec Google" ajoute sous le formulaire (conditionne par `google_login_content`)
- **Note inscription** : "Inscription gratuite — commencez a commander des que votre compte est cree"

### 12.7 Fichiers modifies en Phase 5
```
app/views/SMMRX-smmpanelbdlab/login.twig    # Refonte complete + enrichissement
app/views/SMMRX-smmpanelbdlab/signup.twig   # Textes recrits + Google signup
```

### 12.8 Fichiers images crees en Phase 5
```
img/login-tiktok-guinee.png                  # Visuel hero (copie de Tiktok.png)
img/orange-money.png                         # Logo Orange Money (copie de orange.png)
img/testimonials/mamadou-b.jpg               # Photo temoignage Mamadou B.
img/testimonials/aissatou-d.jpg              # Photo temoignage Aissatou D.
img/testimonials/ibrahima-k.jpg              # Photo temoignage Ibrahima K.
```

### 12.9 Regles editoriales
- **Terme interdit** : "SMM" — ne jamais utiliser ce terme dans les textes visibles. Utiliser "services reseaux sociaux" ou "services" a la place.
- **4 plateformes** : TikTok, Facebook, Instagram, YouTube — toujours mentionner ces 4, pas d'autres.
- **Paiement** : Orange Money en GNF — c'est le seul mode de paiement client actif.
- **Ton** : direct, concret, chiffres, pas de jargon technique, parler aux createurs et commercants guineens.

---

## 13. Phase 6 — Correction messages d'auth publics (effectuee le 2026-04-15)

### 13.1 Cause reelle
- Les messages du login, reset password et signup n'etaient pas tous corriges car le site public chargeait en pratique `app/language/en.php`
- Verification faite dans `index.php` : pour les visiteurs non connectes, la langue provient de `?lang=xx`, sinon de `$_SESSION["lang"]`, sinon de la langue par defaut stockee dans la table `languages`
- En base locale, la langue publique par defaut etait `en`, ce qui expliquait l'affichage persistant de messages anglais meme apres traduction de `fr.php`

### 13.2 Correctifs appliques
- **`app/language/en.php`** :
  - traduction des erreurs de login en francais
  - traduction des erreurs de reset password en francais
  - traduction des erreurs d'inscription en francais (`error.signup.*`), notamment `Password Notmatch`
- **`app/language/default.php`** :
  - deja aligne auparavant sur des messages francais et des formulations plus professionnelles
- **`app/language/fr.php`** :
  - alignement du message de reset password sur une reponse generique conforme securite
- **`app/controller/resetpassword.php`** :
  - reponse generique si le compte n'existe pas
  - message de succes uniforme en francais
  - correction de la recherche `username OR email`
- **`app/controller/signup.php`** :
  - correction du titre de page (`signup.title` au lieu de `signin.title`)
  - correction du typo `error.signup.usename` -> `error.signup.username`

### 13.3 Resultat valide
- Login invalide : `Identifiants incorrects. Verifiez votre nom d'utilisateur et votre mot de passe.`
- Reset password compte inconnu : `Si un compte correspond, un e-mail de reinitialisation a ete envoye. Verifiez aussi le dossier spam.`
- Inscription mots de passe differents : `Les mots de passe ne correspondent pas.`

---

## 14. Phase 7 — Correction Orange Money / GNF (effectuee le 2026-04-15)

### 14.1 Probleme corrige
- La recharge Orange Money (methode `21`) recevait bien une saisie en **GNF**, mais le flux la traitait partiellement comme si c'etait de l'USD
- Le montant etait ensuite **multiplie une deuxieme fois** par `exchange_rate=10000` dans `app/controller/addfunds/Initiators/lengopay.php`
- Le callback `app/controller/payment/lengopay.php` credita ensuite le solde interne **sans reconversion vers la devise de base USD**
- Les frais etaient mathematiquement faux : le front/back ajoutaient le fee au montant, puis le callback soustrayait encore un pourcentage sur le total deja majore

### 14.2 Nouveau comportement
- Le champ Orange Money dans `app/controller/addfunds.php` traite maintenant la saisie utilisateur comme un **montant net en GNF**
- Exemple de reference :
  - saisie : `20 000 GNF`
  - frais 2.5% : `500 GNF`
  - total envoye a la passerelle : `20 500 GNF`
  - credit interne stocke pour le solde : `2 USD`
- `payments.payment_amount` stocke maintenant pour Orange Money le **montant credite en devise de base** (USD), afin que le solde et les conversions restent coherents

### 14.3 Compatibilite avec les anciens paiements
- Un metadata structure Orange Money est maintenant stocke dans `payments.t_id`
- `payments.payment_note` contient un resume lisible (montant saisi, frais, total paye, credit solde)
- Le callback LengoPay sait gerer :
  - les **nouveaux paiements** (metadata structure present)
  - les **anciens paiements en attente** crees avant le correctif, via une logique de reconstitution inverse des frais

### 14.4 Fichiers touches
- `app/helper/currency.php`
  - nouveaux helpers de calcul des frais, reconstitution legacy, formatage exact, metadata Orange Money
- `app/controller/addfunds.php`
  - validation min/max sur la saisie GNF
  - calcul distinct : montant saisi, frais GNF, total passerelle GNF, montant credite USD
  - historique client corrige pour Orange Money
- `app/controller/addfunds/Initiators/lengopay.php`
  - suppression de la double conversion `* exchange_rate`
  - insertion BDD avec montant net en base + metadata/note
- `app/controller/payment/lengopay.php`
  - conversion correcte vers la devise de base
  - bonus applique sur le montant net GNF puis converti en USD
  - compatibilite legacy
- `app/controller/addfunds/getForm.php`
  - champ Orange Money dedie en GNF
- `app/views/SMMRX-smmpanelbdlab/addfunds.twig`
  - affichage francais des frais
  - quick amounts corriges
  - note explicative `20 000 GNF = 2 USD`
- `admin/controller/settings/paymentMethods/getForm.php`
  - libelles Orange Money explicites pour les champs admin
  - minimum / maximum / seuil de bonus interpretes clairement comme montants GNF
- `admin/controller/settings/paymentMethods/editMethodExtras.php`
  - mise a jour du taux Orange Money synchronise aussi la table `currencies` pour `GNF`
- `admin/controller/fund-add-history.php`
- `admin/controller/payments.php`
- `admin/views/payments.php`
  - affichages admin Orange Money rendus coherents (GNF saisi + credit USD)

### 14.5 Regle de maintenance
- Pour Orange Money, considerer desormais que :
  - **la saisie client est toujours en GNF**
  - **le paiement LengoPay est envoye en GNF**
  - **le solde interne du panel reste en USD base**
  - toute evolution future doit donc conserver ce triplet `GNF saisie -> GNF passerelle -> USD solde`

---


## 15. Phase 8 — Correctifs commandes + responsive addfunds (effectuee le 2026-04-15)

### 15.1 Page commandes (`orders.twig`)
- Le bloc d'actions de la liste des commandes avait ete fragilise par des conditions Twig imbriquees lors des retouches sur les badges de statut
- Resultat : erreur fatale Twig `Unexpected "endfor" tag` a cause d'un `if` mal referme dans `app/views/SMMRX-smmpanelbdlab/orders.twig`
- Le bloc a ete reecrit proprement :
  - badge statut garde sa couleur par statut via style inline calcule
  - actions `Recharger` / `Rechargement` utilisent uniquement `status_raw == 'completed'`
  - la logique ne depend plus du texte traduit `Completed`

### 15.2 Traduction statuts commandes
- Les labels des statuts commandes ont ete harmonises en francais dans les fichiers effectivement utilises :
  - `app/language/en.php`
  - `app/language/default.php`
  - `app/language/fr.php` etait deja correct
- Mapping affiche :
  - `pending` -> `En attente`
  - `inprogress` -> `En cours`
  - `completed` -> `Terminée`
  - `processing` -> `En traitement`
  - `partial` -> `Partielle`
  - `canceled` -> `Annulée`

### 15.3 Responsive page Ajouter des fonds
- Le bouton `Historique des paiements` prenait trop de place en mobile a cause du float
- `app/views/SMMRX-smmpanelbdlab/addfunds.twig` a ete ajuste :
  - remplacement du float par une barre d'actions responsive
  - bouton historique pleine largeur sur petit ecran
  - paddings de la carte Orange Money reduits en mobile

### 15.4 Historique des paiements (addfunds)
- Le modal historique a ete restructure et nettoye
- Typographie augmentee pour une meilleure lisibilite :
  - nom de methode plus grand
  - date plus visible
  - montant plus grand
  - message vide plus lisible

---

## 16. Phase 9 — Simplification dashboard admin (effectuee le 2026-04-15)

### 16.1 Objectif
- Le tableau de bord admin etait juge trop charge et trop "futuriste"
- La demande etait de se rapprocher d'un visuel plus simple : peu d'elements, cartes utiles, lecture rapide

### 16.2 Refonte appliquee
- **Fichier** : `admin/views/index.php`
- Le dashboard affiche maintenant uniquement :
  - un resume compact avec `Flux actif`, `Taux termine`, `A surveiller`
  - 4 cartes KPI essentielles : utilisateurs, commandes, paiements valides, tickets non lus
  - un bloc simple `Activite des commandes` avec les 4 etats principaux et leur progression
  - une colonne `Priorites` avec securite du compte, suivi support et acces utiles
- Le bloc 2FA a ete conserve et reste actionnable directement depuis le dashboard

### 16.3 Regle de style
- Pour les futures evolutions du dashboard admin :
  - garder une mise en page sobre et compacte
  - eviter les effets glow / hero futuristes / blocs decoratifs non essentiels
  - prioriser la lisibilite immediate et les actions vraiment utiles

---

## 17. Phase 10 — Reparation page signup publique (effectuee le 2026-04-16)

### 17.1 Probleme constate
- La page publique `/signup` etait recassee dans `app/views/SMMRX-smmpanelbdlab/signup.twig`
- Le haut du template avait ete tronque : la grille commencait au milieu d'un bloc HTML
- Resultat : structure Twig/HTML incomplete et design signup inutilisable

### 17.2 Recherche utile avant modification
- **Vue principale** : `app/views/SMMRX-smmpanelbdlab/signup.twig`
- **Layout public parent** : `app/views/SMMRX-smmpanelbdlab/public_base.twig`
  - fournit la navbar, le footer, les variables CSS globales, le theme clair/sombre et les blocs Twig `title`, `extra_css`, `content`, `scripts`
- **Controleur reel du flux** : `app/controller/signup.php`
  - attend les champs POST `name`, `username`, `email`, `telephone`, `password`, `password_again`, `terms`
  - utilise aussi `captcha`, `captchaKey`, `google_login_content`, `error`, `errorText`, `success`, `successText`, `data`
- **Reference editoriale** : section `12.6 Page inscription signup.twig mise a jour` dans ce fichier

### 17.3 Technologie et contraintes a respecter
- `signup.twig` **herite** de `public_base.twig` : ne pas le convertir en page standalone sans raison
- Le style repose sur les variables CSS publiques du layout :
  - `--primary`, `--primary-2`, `--accent`
  - `--card2`, `--border`, `--border-strong`
  - `--text`, `--muted`, `--dim`, `--input`, `--input-b`
- Les fonctions/variables Twig a conserver :
  - `{{ csrf_field() }}`
  - `error / errorText`
  - `success / successText`
  - `data['name']`, `data['username']`, `data['email']`, `data['telephone']`
  - `captcha / captchaKey`
  - `google_login_content`
- Le bouton Google doit rester conditionnel
- Le formulaire doit continuer a poster vers `action="/signup/signup"`

### 17.4 Reparation appliquee
- `app/views/SMMRX-smmpanelbdlab/signup.twig` a ete **reecrit entierement**
- Structure restauree :
  - colonne gauche marketing
  - badge `TikTok · Facebook · Instagram · YouTube`
  - titre hero signup
  - 4 points forts : livraison, Orange Money, 4 plateformes, +10 000 clients
  - 3 stats : 100% mobile, prix imbattables, support 24/7
  - colonne droite formulaire avec alerts, captcha, Google signup et note finale
- Le design est de nouveau coherent avec `public_base.twig` et les regles marketing de la phase 5

### 17.5 Methode de validation
- Controle PHP :
  - `app/controller/signup.php` verifie avec `php -l`
- Controle Twig :
  - compilation directe de `signup.twig` avec `Twig\\Environment`
  - un helper `csrf_field` factice doit etre ajoute dans le script de test si on compile le template hors application
  - si la compilation echoue uniquement sur `csrf_field`, ce n'est **pas** un bug du template mais un manque de helper dans l'environnement de test

### 17.6 Regle de maintenance pour les prochaines IA
- Avant de modifier `/signup`, toujours relire **ensemble** :
  - `app/views/SMMRX-smmpanelbdlab/signup.twig`
  - `app/views/SMMRX-smmpanelbdlab/public_base.twig`
  - `app/controller/signup.php`
- Ne jamais recoller un fragment partiel du template sans verifier l'equilibre complet des blocs :
  - `{% block extra_css %}`
  - `{% block content %}`
  - balises `<div>` de la grille signup
- Si la page semble cassée visuellement mais sans erreur PHP, verifier en premier si le haut du bloc marketing ou l'ouverture de `.signup-grid` / `.signup-copy` a ete supprime

---

## 18. Phase 11 — Audit champs Nom / Telephone sur signup (effectuee le 2026-04-16)

### 18.1 Constat reel
- Les champs `name` et `telephone` du signup public etaient **bien stockes en base** dans `clients`
- Mais ils etaient **peu ou pas visibles** dans les interfaces principales :
  - pas affiches dans `app/views/SMMRX-smmpanelbdlab/account.twig`
  - pas visibles dans la liste principale `admin/views/clients.php`
- Ils restaient seulement exploitables de facon secondaire :
  - recherche admin par `name` / `telephone`
  - export utilisateurs
  - modal admin `Contacts` (`admin/controller/ajax_data.php`, action `all_numbers`)

### 18.2 Decision prise
- Comme ces champs n'apportaient pas de valeur claire dans le parcours client courant ni dans l'affichage admin principal, ils ont ete **retirés du formulaire signup public**
- Le but est d'eviter de demander des informations qui ne sont pas vraiment utilisees par l'interface

### 18.3 Fichiers modifies
- `app/views/SMMRX-smmpanelbdlab/signup.twig`
  - suppression des inputs `Nom complet` et `Telephone / WhatsApp`
- `app/controller/signup.php`
  - `name` et `telephone` rendus optionnels/capables d'etre absents du POST
  - suppression des validations bloquantes liees a `name_feilds` / `skype_feilds` pour le signup public
  - conservation d'une insertion compatible en base avec valeurs vides si les champs n'existent plus

### 18.4 Impact Google login
- Verification faite dans `app/controller/auth.php`
- Le parcours Google login / Google signup est **independant** du formulaire `signup.twig`
- Donc la suppression de `name` et `telephone` du signup public **n'affecte pas** le bouton Google ni le flux OAuth
- A ce stade, aucun changement n'a ete applique au flux Google login pour cette raison

### 18.5 Regle pour les prochaines IA
- Si on se demande si un champ signup doit rester :
  1. verifier s'il est vraiment affiche ou utile cote client/admin
  2. verifier s'il est seulement stocke en base sans vraie utilite UI
  3. verifier separement `app/controller/auth.php` pour s'assurer que Google login ne depend pas du formulaire public

---

## 17. Phase 10 — Audit complet panel admin (effectue le 2026-04-16)

### 17.1 Perimetre de l'audit
Audit exhaustif de tous les fichiers du panel admin : controleurs (41 fichiers), vues (~90 fichiers), CSS (tl-admin.css, 972 lignes), JavaScript (script.js, main.js), systeme de modales, dark mode, architecture front-end.

### 17.2 Correctifs appliques immediatement

#### 17.2.1 Bouton "Modifier" paymentMethods (getForm.php)
- **Probleme** : le formulaire utilisait des classes Bootstrap 5 (`form-select`, `form-label`, `input-group-text`, `bi bi-percent`) dans un environnement Bootstrap 3. Le contenu du modal etait invisible (mauvais style, pas de fond sombre).
- **Correctif** : remplacement dans `admin/controller/settings/paymentMethods/getForm.php` :
  - `form-select` -> `form-control` (54 occurrences)
  - `form-label` -> `control-label` (54 occurrences)
  - `input-group-text` -> `input-group-addon` (2 occurrences)
  - `bi bi-percent` -> `fa fa-percent` (2 occurrences)
  - `form-group mb-3` -> `form-group` (54 occurrences)
- **Correctif JS** (precedent) : `paymentMethods.php` — le handler `pmEdit` utilisait `JSON.parse(raw)` sur une reponse deja auto-parsee par jQuery (`Content-Type: application/json`). Corrige avec `typeof raw === 'object'` pour gerer les deux cas.

#### 17.2.2 Changement mot de passe admin (account.php)
- **Probleme** : `admin/controller/account.php` utilisait encore `md5(sha1(md5(...)))` pour verifier et stocker les mots de passe, incompatible avec la migration bcrypt de la Phase 1.
- **Correctif** : verification via `toutlike_verify_password()` (supporte bcrypt ET legacy MD5), stockage via `toutlike_hash_password()` (bcrypt). Ajout `exit` apres la redirection.

#### 17.2.3 Controle d'acces modules.php
- **Probleme** : `admin/controller/modules.php` utilisait `$user["access"]["modules"]` (permissions CLIENT) au lieu de `$admin["access"]["modules"]` (permissions ADMIN). Tout admin pouvait acceder ou etre bloque selon les permissions du mauvais objet.
- **Correctif** : `$user["access"]` -> `$admin["access"]`.

#### 17.2.4 Lot securite / design (suite « tout faire tout », 2026-04-16)
- **SQL prepare** : `clients.php` (email / telephone / categories-services), `manager.php` (unicite email / username / telephone), `services.php` (ligne de service par categorie), `modules.php` (recherches GET `LIKE` + fragments `$search` pour payment_id / order_url via `$conn->quote()`).
- **Secrets** : bloc `pay_rent` dans `ajax_data.php` — MID Paytm et SMTP lus depuis `.env` (`PAYTM_MERCHANT_ID`, `MAIL_*`, `RENT_NOTIFY_EMAIL`, `RENT_NOTIFY_EMAIL_CC`). L’envoi mail est saute si SMTP non configure (plus de mot de passe en dur).
- **Variable variables** : `decoration.php` — liste blanche des champs POST + flash session limite ; `modules.php` (route paiements manuels) — champs POST explicites + flash session limite ; plus de `foreach ($_POST) $$key` sur ces flux.
- **ACL** : `fund-add-history.php` exige `$admin["access"]["payments"]`. `ajax_data_access.php` + appel dans `ajax_data.php` — ACL supplementaire par action (map partielle, extensible).
- **Uploads** : `toutlike_upload_is_allowed_image()` dans `app/helper/app.php` (finfo MIME) ; utilise dans `settings.php` (logo / favicon) et `appearance.php` (fichiers).
- **JS / BS3** : `main.js` / `script.js` — recherche tarifs : `data-name` / `data-service` traites comme chaines (plus de `.textContent` sur une string). `footer.php` — spinner BS5 remplace par `fa fa-spinner fa-spin`.

### 17.3 Inventaire des problemes de securite

| # | Severite | Fichier(s) | Probleme | Statut |
|---|----------|-----------|----------|--------|
| 1 | **CRITIQUE** | `clients.php`, `manager.php`, `services.php`, `orders.php`, `child-panels.php`, `logs.php`, `payments.php`, `broadcasts.php`, `modules.php` | **Injection SQL** : concatenation de variables dans les requetes (`$search_word`, `$search`, `$email`, `$username`, `$category`). Exemple : `$conn->query("SELECT * FROM ... WHERE email='$email'")` | **Partiellement corrige** (clients, manager, services, modules — poursuivre sur orders, logs, payments, broadcasts, child-panels) |
| 2 | **CRITIQUE** | `ajax_data.php` | **Secrets en dur** : mot de passe SMTP `tJCz4dcV6FCNSrL`, host `mail.smmemail.com`, MID Paytm, emails BD Lab | **Corrige** pour le flux `pay_rent` (variables `.env`) |
| 3 | **CRITIQUE** | `account.php` | Mot de passe admin en MD5 au lieu de bcrypt | **Corrige** |
| 4 | **HAUTE** | `modules.php` | Controle d'acces utilise `$user` au lieu de `$admin` | **Corrige** |
| 5 | **HAUTE** | `decoration.php`, `modules.php` | `foreach ($_POST as $key => $value) { $$key = $value; }` — injection de variables PHP via POST | **Corrige** (decoration + branches POST `modules.php` paiements manuels) |
| 6 | **HAUTE** | `fund-add-history.php` | Pas de controle d'acces granulaire, modifie directement les soldes clients | **Corrige** (`payments`) |
| 7 | **HAUTE** | `settings.php`, `appearance.php` | Uploads valides uniquement par `$_FILES["type"]` (MIME declare, falsifiable) | **Corrige** (logo / favicon / fichiers via finfo) |
| 8 | **MOYENNE** | `ajax_data.php` (6858 lignes) | Pas de controle d'acces par action — tout admin peut tout faire | **Partiellement corrige** (`ajax_data_access.php` + map d’actions ; completer les actions restantes) |
| 9 | **MOYENNE** | `login.php` | Hash mot de passe dans cookie `a_password`, mot de passe en clair dans `$_SESSION["toutlike_adminpass"]` pendant 2FA | A corriger |

### 17.4 Inventaire des problemes de design

#### Architecture CSS (3 couches en conflit)
1. **Bootstrap 3 CSS** (~1.2 Mo) : charge en premier
2. **`tl-admin.css`** (972 lignes) : charge apres, surcharge avec `.tl-main` et `!important`
3. **`header.php` style inline** : charge APRES tl-admin.css et peut ecraser certaines regles

**Consequence** : double/triple definition des memes proprietes, difficulte de maintenance, comportements imprevisibles.

**Solution recommandee** : fusionner le `<style>` inline de `header.php` dans `tl-admin.css` pour avoir une seule source de verite.

#### JavaScript (doublons)
- `script.js` et `main.js` definissent les memes fonctions : `generatePassword`, `UserPassword`, `getProviderServices`, `getProvider`, `getSalePrice`, `getSubscription`
- `main.js` n'est charge que sur `api-services.php`, ecrase les fonctions de `script.js`
- Bug dans les deux fichiers : `#priceSearch` utilisait `name.textContent` sur une chaine — **corrige** (attributs `data-name` / `data-service` en string)

**Solution recommandee** : supprimer les doublons de `main.js`, ne garder que les fonctions specifiques a api-services.

#### Melange Bootstrap 3 / Bootstrap 5
- Panel admin est en **Bootstrap 3** (CSS 3.3.6, JS 3.3.7)
- Certains fichiers utilisent des classes BS5 (`form-select`, `form-label`, `spinner-border`, `modal-dialog-centered`, `btn-close`, `data-bs-dismiss`)
- Les classes BS5 ne sont pas stylees par BS3 → problemes visuels en dark mode

**Fichiers concernes** : `getForm.php` (corrige), `general.php`, `footer.php`, `fund-add-history.php`, `special-pricing.php`

#### Variables CSS (dark mode)
Definies dans `header.php` inline, consommees par `tl-admin.css` :

| Variable | Clair | Sombre |
|----------|-------|--------|
| `--bg` | `#f1f5f9` | `#0F172A` |
| `--card` | `#fff` | `#1E293B` |
| `--border` | `#e2e8f0` | `#334155` |
| `--text` | `#0f172a` | `#E5E7EB` |
| `--muted` | `#64748b` | `#94A3B8` |
| `--primary` | `#3B82F6` | (herite) |

### 17.5 Recommandations par priorite

#### Priorite 1 — Immediat (correctifs critiques)
- [x] Corriger getForm.php (classes BS5 -> BS3)
- [x] Aligner account.php sur bcrypt
- [x] Corriger modules.php ($admin au lieu de $user)

#### Priorite 2 — Securite (prochaine session)
- [x] Convertir les requetes SQL les plus exposees en `prepare()` / echappement (`clients`, `manager`, `services`, recherches `modules`) — **reste** : orders, child-panels, logs, payments, broadcasts, export clients (`SELECT $colum`), etc.
- [x] Supprimer les secrets de `ajax_data.php` -> variables `.env` (flux `pay_rent`)
- [x] Supprimer `$$key` de `decoration.php` et branches POST concernees de `modules.php` -> whitelist explicite
- [x] Ajouter controle d'acces a `fund-add-history.php`
- [x] Valider uploads par contenu (`finfo_file`) au lieu du MIME declare (logo / favicon / fichiers)

#### Priorite 3 — Design (amelioration progressive)
- [ ] Fusionner le `<style>` inline de `header.php` dans `tl-admin.css`
- [ ] Eliminer les doublons `main.js` / `script.js`
- [ ] Remplacer toutes les classes BS5 restantes par BS3 dans les vues admin
- [ ] Standardiser les modals : un seul pattern pour toutes les pages

#### Priorite 4 — Futur / Evolution
- [ ] Decouvper `ajax_data.php` (6858 lignes) en modules par domaine
- [x] Ajouter controle d'acces par action dans `ajax_data.php` (fichier `ajax_data_access.php`, map a etendre)
- [ ] Migrer progressivement de Bootstrap 3 vers Bootstrap 5
- [ ] Ajouter un systeme de logs admin (qui fait quoi)
- [ ] Implementer rate limiting sur les endpoints sensibles
- [ ] Ajouter des tests automatises (flux critiques : paiements, commandes)

### 17.6 Fichiers modifies en Phase 10
```
admin/controller/settings/paymentMethods/getForm.php   # BS5 -> BS3
admin/controller/account.php                            # MD5 -> bcrypt
admin/controller/modules.php                            # $user -> $admin + SQL POST whitelist + LIKE
admin/controller/clients.php                            # SQL prepare + categories / services
admin/controller/manager.php                            # SQL prepare + bug $phone -> $telephone
admin/controller/services.php                         # SQL prepare category line
admin/controller/decoration.php                       # Whitelist POST + flash session
admin/controller/fund-add-history.php                 # ACL payments
admin/controller/ajax_data.php                        # env secrets + hook ACL
admin/controller/ajax_data_access.php                 # Map ACL par action
admin/controller/settings.php                         # Upload finfo
admin/controller/appearance.php                       # Upload finfo (files)
app/helper/app.php                                    # toutlike_upload_is_allowed_image
admin/views/footer.php                                # Spinner BS3
public/admin/main.js                                  # Bug priceSearch
public/admin/script.js                                # Bug priceSearch
admin/views/settings/paymentMethods.php                 # Fix JSON.parse + form submit handler
admin/views/api-services.php                            # Rewrite complet (form hors table, bouton sticky)
public/admin/tl-admin.css                               # Ajout regles dark mode pour BS5 classes, action-block, a.btn-*
```

Variables `.env` a renseigner pour le flux loyer / Paytm (si utilise) : `PAYTM_MERCHANT_ID`, `MAIL_SMTP_HOST`, `MAIL_SMTP_PORT`, `MAIL_SMTP_USERNAME`, `MAIL_SMTP_PASSWORD`, `MAIL_FROM_ADDRESS`, `RENT_NOTIFY_EMAIL`, `RENT_NOTIFY_EMAIL_CC`.

---

## 19. Phase 12 — Dashboard admin credible en GNF (effectuee le 2026-04-16)

### 19.1 Objectif
- Le dashboard admin precedent etait plus propre qu'avant mais restait trop leger et peu credible cote business
- La nouvelle demande etait de se rapprocher d'un visuel de dashboard plus complet avec :
  - cartes de statuts commandes cliquables
  - section argent plus serieuse
  - transactions recentes visibles
  - activite mensuelle believable
  - affichage principal en **GNF**

### 19.2 Refonte appliquee
- **Fichier** : `admin/views/index.php`
- Le dashboard a ete reecrit avec une structure en 4 zones :
  1. **Hero de synthese** avec recharges validees, depenses commandes et nombre de clients
  2. **4 cartes commandes** :
     - En attente
     - En cours
     - Terminees
     - Rejetees
  3. **Bloc financier** avec vrais montants issus de la base
  4. **Bloc activite mensuelle** + **dernieres transactions** + **operations rapides**

### 19.3 Sources de donnees utilisees
- `payments.payment_amount`
- `payments.payment_status`
- `payments.payment_delivery`
- `clients.balance`
- `clients.register_date`
- `orders.order_charge`
- `orders.order_profit`
- `orders.order_status`
- `orders.order_error`
- `orders.order_detail`
- `orders.order_create`
- `tickets.client_new`
- `tasks`
- `services`
- `categories`
- `service_api`

### 19.4 Regles de calcul du dashboard
- **Recharges validees** :
  - somme de `payments.payment_amount`
  - uniquement si `payment_status = 3` et `payment_delivery = 2`
- **Solde clients** :
  - somme de `clients.balance`
  - limitee ici aux clients actifs `client_type = 2`
- **Depenses commandes** :
  - somme de `orders.order_charge`
- **Profit estime** :
  - somme de `orders.order_profit`
- **Commandes en attente** :
  - `pending + cronpending`
- **Commandes en cours** :
  - `processing + inprogress`
- **Commandes rejetees** :
  - `canceled + partial + commandes avec order_error`

### 19.5 Regle GNF
- Le dashboard affiche des montants principaux en **GNF**
- La conversion privilegie la regle demandee par le client :
  - **1 USD = 10 000 GNF**
- Si la devise de base du site est deja `GNF`, aucun facteur n'est applique
- Pour une autre devise de base non-USD, le dashboard tente une conversion vers `GNF` via `from_to(...)`
- Les montants en devise de base restent visibles en secondaire pour garder une lecture comptable

### 19.6 Liens directs ajoutes
- Les cartes de statuts pointent directement vers les filtres commandes admin :
  - `admin/orders/1/pending`
  - `admin/orders/1/inprogress`
  - `admin/orders/1/completed`
  - `admin/orders/1/canceled`
- Des acces rapides ont aussi ete ajoutes vers :
  - `admin/fund-add-history`
  - `admin/orders`
  - `admin/clients`
  - `admin/settings/paymentMethods`

### 19.7 Regle de maintenance
- Pour toute future evolution du dashboard admin :
  - garder les **montants principaux en GNF**
  - ne pas remplacer les sommes reelles par des valeurs fictives
  - conserver des cartes de statuts commandes cliquables
  - garder la section transactions recentes basee sur `payments`
  - si de nouveaux KPI financiers sont ajoutes, partir des colonnes reelles (`payment_amount`, `balance`, `order_charge`, `order_profit`) avant toute approximation visuelle


## 19. Phase 12 — Systeme modal unifie TL-Modal (effectue le 2026-04-16)

### 19.1 Objectif
- Unifier tous les popups/modals/confirmations du panel admin avec un seul composant coherent, centre, moderne, dark-mode aware.
- Remplacer les `window.confirm()` natifs, les `#confirmChange` dupliques dans chaque vue et les styles ad-hoc.
- Zero impact sur les controllers existants et sur la logique LengoPay.

### 19.2 Nouveaux fichiers
```
public/admin/tl-modal.css    # Styles premium appliques a tous les .modal + dialog TL-Confirm
public/admin/tl-modal.js     # API TLModal + interception des liens legacy
```

### 19.3 Cablage
- `admin/views/header.php` charge `public/admin/tl-modal.css` juste apres `tl-admin.css`.
- `admin/views/footer.php` charge `public/admin/tl-modal.js` juste avant `script.js`.
- Ces deux fichiers sont **globaux** : tout le panel admin en beneficie automatiquement.

### 19.4 Ce que TL-Modal apporte
- **Centrage flexbox** force sur tous les `.modal` Bootstrap 3 (centres verticalement/horizontalement).
- **Header premium** : barre de couleur en haut, titre avec pastille violette, bouton fermer arrondi avec hover.
- **Animation** douce a l ouverture (fade + scale).
- **Boutons** (`.btn-primary`, `.btn-success`, `.btn-danger`, `.btn-warning`, `.btn-default`) restyles partout : gradient, rayon 10 px, ombre.
- **Form-controls** (`.form-control`, `.input-group-addon`) coherents clair / sombre dans tous les modals.
- **Backcompat** : `#modalDiv`, `#subsDiv` et les `$('#modalDiv').modal('show')` existants fonctionnent exactement pareil. Aucun controller ajax_data n est touche.

### 19.5 Dialog de confirmation `#tlConfirm`
- Cree automatiquement par `tl-modal.js` (pas besoin de markup dans les vues).
- Variants : `info` (violet), `success` (vert), `warning` (orange), `danger` (rouge).
- Icone FontAwesome automatique selon le variant.

### 19.6 API JavaScript
```js
TLModal.confirm({
  title       : 'Confirmer l action',
  message     : 'Voulez-vous continuer ?',
  confirmLabel: 'Oui',
  cancelLabel : 'Non',
  onYes       : function () { /* action */ }
});
TLModal.danger({ title: '...', message: '...', onYes: fn });
TLModal.success({ ... });
TLModal.warning({ ... });
TLModal.info({ ... });
TLModal.close();
```

### 19.7 Markup HTML pour remplacer `#confirmChange`
Remplacer dans les vues :
```html
<a href="#" data-toggle="modal" data-target="#confirmChange" data-href="admin/xxx">...</a>
```
par :
```html
<a class="tl-confirm"
   data-title="Titre du dialog"
   data-message="Message explicatif contextuel."
   data-danger="1"                     <!-- optionnel, style rouge -->
   data-confirm-label="Oui, continuer"
   href="admin/xxx">...</a>
```
Le JS global intercepte le clic, affiche le dialog, et navigue vers `href` seulement si l utilisateur confirme.

### 19.8 Markup pour les formulaires a confirmation
Remplacer :
```html
<form onsubmit="return confirm('...');">
```
par :
```html
<form class="tl-confirm-form"
      data-title="Supprimer ..."
      data-message="Action irreversible."
      data-confirm-label="Oui, supprimer">
```

### 19.9 Pages migrees en Phase 12
- `admin/views/clients.php` : confirmations d activation / desactivation / reinit tarifs
- `admin/views/orders.php` : confirmations d annulation, de completion, de passage en cours, d activation recharge
- `admin/views/kuponlar.php` : suppression de coupons
- `admin/views/broadcasts.php` : suppression de notifications
- `admin/views/settings/paymentMethods.php` : deja en modal custom (Phase 11)

### 19.10 Regles pour les prochaines IA
- Ne **jamais** creer un `<div id="confirmChange">` dupliquer dans une nouvelle vue. Utiliser `TLModal.confirm()` ou la classe `.tl-confirm`.
- Ne **jamais** utiliser `window.confirm()` ou `alert()` dans le panel admin. Utiliser l API TLModal.
- Ne **jamais** redefinir des regles CSS `.modal .*` dans les vues : centralise dans `tl-modal.css`.
- Pour un nouveau formulaire modal, utiliser `data-toggle="modal" data-target="#modalDiv" data-action="xxx"` (pattern existant) ; le nouveau CSS rend automatiquement le rendu premium.
- Pour une nouvelle confirmation, utiliser `.tl-confirm` avec `data-title` / `data-message` / `data-danger`.

### 19.11 Verifications realisees
- `php -l` OK sur tous les fichiers modifies.
- Pas de suppression des modals legacy, donc aucune regression possible sur ajax_data.
- Le bouton LengoPay / paymentMethods continue de fonctionner comme corrige en Phase 11 (modal self-managed `#pm-overlay`).

## 20. Phase 13 - TL-Modal premium applique partout (effectue le 2026-04-17)

### 20.1 Objectif
- Appliquer un style de modal premium coherent sur TOUS les modals du panel admin (50+ actions ajax_data).
- Aucune modification par controller - toute la presentation est centralisee.

### 20.2 Upgrades dans `public/admin/tl-modal.css`
- **Inputs** : hauteur 44px, radius 12px, padding 11x14, bordure #cbd5e1 en clair et `rgba(148,163,184,.35)` en dark.
- **Select** : caret custom SVG a droite, meme hauteur que les inputs.
- **Labels** : uppercase, font-weight 800, letter-spacing, gap pour icones FA en prefixe (couleur #6366F1 en clair, #a5b4fc en dark).
- **Form groups** : margin 16px.
- **custom-modal-footer** (legacy) realigne sur le style tl-modal (footer en bas du modal avec border-top et gap 10).

### 20.3 Helpers CSS reutilisables
Tous disponibles dans `.modal *` et utilisables dans n'importe quel formulaire :
- `.tl-banner` + `.tl-banner-ico[.success|.warning|.danger]` + `.tl-banner-title` + `.tl-banner-sub`
- `.tl-row-2`, `.tl-row-3` (grilles responsives)
- `.tl-input-wrap` + `.tl-suffix` (suffix badge ex: GNF, %)
- `.tl-toggle` + `.tl-toggle-opt` (remplace un `<select>` par un toggle segmente beau)

### 20.4 Auto-enhancer dans `public/admin/tl-modal.js`
- Un MutationObserver surveille `#modalDiv` et `#subsDiv`.
- Au clic sur un trigger `data-action="xxx"`, la valeur est memorisee.
- Des que le body du modal est rempli par ajax_data, un **bandeau premium est automatiquement injecte** selon un mapping `BANNER_MAP`.
- Mapping couvert (cle = data-action) :
  - Utilisateurs : `new_user_v2`, `new_user`, `edit_user`, `pass_user`, `alert_user`, `secret_user`, `export_user`, `all_numbers`, `details`, `set_discount_percentage`
  - Services/Categories : `new_service`, `edit_service`, `edit_service_name`, `edit_description`, `edit_time`, `new_subscriptions`, `new_category`, `edit_category`
  - Commandes : `order_comment`, `order_errors`, `order_details`, `order_orderurl`, `order_startcount`, `order_partial`
  - Support/coupons/news : `new_ticket`, `edit_ticket`, `yeni_kupon`, `new_news`, `edit_news`
  - Devises/paiements : `site-add-currency`, `edit_integration`, `edit_paymentmethod`, `import_services`, `edit_code`, `edit_google`
- Si l'action n'a pas d'entree dans le mapping, rien n'est injecte (compat totale).

### 20.5 Regles pour etendre
- Pour ajouter un modal premium sans toucher au controller : ajouter une entree dans `BANNER_MAP` (icone FA5 + titre FR + sous-titre + tone optionnel).
- Pour creer un modal 100% custom type fund-add-history : utiliser les classes `.tl-banner`, `.tl-row-2`, `.tl-toggle`, `.tl-input-wrap + .tl-suffix` directement dans le HTML retourne par le controller.

### 20.6 Pages migrees / impactees en Phase 13
- `admin/controller/fund-add-history.php` : modal Ajouter/Deduire entierement redessine (banner, toggle Ajouter/Deduire, suffix GNF, row 2-col). Reference design.
- `public/admin/tl-modal.css` : upgrades globaux.
- `public/admin/tl-modal.js` : BANNER_MAP + MutationObserver.
- AGENTS.md : Phase 13.

### 20.7 Verifications
- `php -l` OK sur tous les fichiers touches.
- Aucune modification de logique metier (LengoPay, ajax_data, edit.php, getForm.php).
- Fallback : si JS desactive, modals restent fonctionnels (tl-modal.css seul donne deja le style premium).