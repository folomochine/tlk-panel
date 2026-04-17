<?php
// [PHASE 2] ToutLike — Configuration via .env
require_once __DIR__ . '/env.php';

define('PATH', realpath('.'));
define('SUBFOLDER', env('APP_SUBFOLDER', false));
define('URL', env('APP_URL', 'http://127.0.0.1'));
define('STYLESHEETS_URL', env('APP_STYLESHEETS_URL', '//127.0.0.1'));

date_default_timezone_set(env('APP_TIMEZONE', 'Africa/Conakry'));

// En local : afficher les erreurs fatales (pas les warnings/notices du code legacy).
// En production : tout masquer.
if (env('APP_ENV', 'local') === 'local') {
    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

return [
  'db' => [
    'name'    => env('DB_NAME', 'smmrx_local'),
    'host'    => env('DB_HOST', 'localhost'),
    'user'    => env('DB_USER', 'root'),
    'pass'    => env('DB_PASS', ''),
    'charset' => env('DB_CHARSET', 'utf8mb4')
  ]
];
