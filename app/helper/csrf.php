<?php
// [SECURITE] ToutLike Phase 1 — Protection CSRF
// Génère et vérifie des tokens CSRF sur tous les formulaires POST.

/**
 * Génère ou retourne le token CSRF de la session courante.
 */
function csrf_token() {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

/**
 * Retourne le champ HTML hidden à inclure dans chaque formulaire.
 * Usage dans Twig : {{ csrf_field()|raw }}
 */
function csrf_field() {
    return '<input type="hidden" name="_csrf_token" value="' . csrf_token() . '">';
}

/**
 * Vérifie que le token CSRF soumis est valide.
 * À appeler en début de tout traitement POST.
 * Retourne true si valide, false sinon.
 */
function csrf_verify() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return true; // Pas de POST, pas de vérification
    }
    $submitted = $_POST['_csrf_token'] ?? '';
    $stored = $_SESSION['_csrf_token'] ?? '';
    if (empty($stored) || !hash_equals($stored, $submitted)) {
        return false;
    }
    return true;
}

/**
 * Vérifie le CSRF et arrête l'exécution si invalide.
 * Exclut les routes API (qui utilisent une clé API à la place).
 */
function csrf_protect() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    // Exclure l'API publique (auth par clé API) et les callbacks de paiement
    global $route;
    $excluded_routes = ['api', 'payment', 'ajax_data', 'admin'];
    if (isset($route[0]) && in_array($route[0], $excluded_routes)) {
        return;
    }
    if (!csrf_verify()) {
        http_response_code(403);
        die('Session expirée ou requête invalide. Veuillez rafraîchir la page.');
    }
}
