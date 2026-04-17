<?php
// [SECURITE] ToutLike Phase 1 — Migration MD5 vers bcrypt
// Ce fichier remplace toutes les utilisations de md5() pour les mots de passe.

/**
 * Hash un nouveau mot de passe avec bcrypt.
 */
function toutlike_hash_password($plain_password) {
    return password_hash($plain_password, PASSWORD_BCRYPT);
}

/**
 * Vérifie un mot de passe contre un hash stocké en BDD.
 * Supporte bcrypt (nouveau) ET md5 (legacy, pour migration transparente).
 * Retourne true si le mot de passe est correct.
 */
function toutlike_verify_password($plain_password, $stored_hash) {
    // 1. Essayer bcrypt (nouveau format)
    if (password_verify($plain_password, $stored_hash)) {
        return true;
    }
    // 2. Fallback MD5 legacy (hash = 32 chars hex)
    if (strlen($stored_hash) === 32 && $stored_hash === md5($plain_password)) {
        return true;
    }
    return false;
}

/**
 * Vérifie si un hash stocké est encore en MD5 (legacy) et doit être migré.
 */
function toutlike_needs_rehash($stored_hash) {
    // MD5 = 32 caractères hex, bcrypt commence par $2y$
    return (strlen($stored_hash) === 32 && substr($stored_hash, 0, 4) !== '$2y$');
}

/**
 * Migre un mot de passe MD5 vers bcrypt en BDD (transparent, au login).
 */
function toutlike_migrate_password($conn, $client_id, $plain_password) {
    $new_hash = toutlike_hash_password($plain_password);
    $update = $conn->prepare("UPDATE clients SET password=:pass WHERE client_id=:id");
    $update->execute(["pass" => $new_hash, "id" => $client_id]);
    return $new_hash;
}

/**
 * Vérifie le mot de passe d'un utilisateur par son username ou email.
 * Remplace les anciens appels à userdata_check('password', md5($pass)).
 * Retourne le row client si ok, false sinon.
 */
function toutlike_login_check($conn, $field, $identifier, $plain_password) {
    // $field = 'username' ou 'email'
    $row = $conn->prepare("SELECT * FROM clients WHERE $field=:identifier");
    $row->execute(["identifier" => $identifier]);
    if (!$row->rowCount()) {
        return false;
    }
    $client = $row->fetch(PDO::FETCH_ASSOC);
    if (toutlike_verify_password($plain_password, $client["password"])) {
        // Migration transparente si encore en MD5
        if (toutlike_needs_rehash($client["password"])) {
            $new_hash = toutlike_migrate_password($conn, $client["client_id"], $plain_password);
            $client["password"] = $new_hash;
        }
        return $client;
    }
    return false;
}
