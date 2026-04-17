<?php
// [PHASE 2] ToutLike — Loader .env
// Charge le fichier .env et rend les variables accessibles via env()

function load_env($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Ignorer les commentaires
        if (strpos($line, '#') === 0) continue;
        // Ignorer les lignes sans =
        if (strpos($line, '=') === false) continue;
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        // Supprimer les guillemets autour de la valeur
        $value = trim($value, '"\'');
        
        // Ne pas écraser les variables déjà définies (ex: par le serveur)
        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

/**
 * Récupère une variable d'environnement avec valeur par défaut.
 * Usage : env('DB_HOST', 'localhost')
 */
function env($key, $default = null) {
    $value = $_ENV[$key] ?? getenv($key);
    if ($value === false || $value === null) {
        return $default;
    }
    // Convertir les booléens texte
    if ($value === 'true') return true;
    if ($value === 'false') return false;
    if ($value === 'null') return null;
    return $value;
}

// Charger le .env à la racine du projet
load_env(__DIR__ . '/../.env');
