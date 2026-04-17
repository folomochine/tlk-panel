<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

if (!$admin["access"]["super_admin"]){
header("Location:" . site_url(""));
}

if( route(1) == "account" && $_POST ){

  $current_pass = $_POST["current_password"];
  $new_pass     = $_POST["password"];
  $new_again    = $_POST["confirm_password"];
  $stored_hash  = $admin["password"];

  $current_valid = false;
  if (function_exists('toutlike_verify_password')) {
      $current_valid = toutlike_verify_password($current_pass, $stored_hash);
  } else {
      $current_valid = ($stored_hash === md5(sha1(md5($current_pass))) || $stored_hash === md5($current_pass));
  }

  if (!$current_valid) {
    $error      = 1;
    $errorText  = "Mot de passe actuel incorrect";
    $icon       = "error";
  } elseif (strlen($new_pass) < 8) {
    $error    = 1;
    $errorText = $languageArray["error.account.password.length"] ?? "Le mot de passe doit contenir au moins 8 caracteres";
  } elseif ($new_pass != $new_again) {
    $error    = 1;
    $errorText = $languageArray["error.account.passwords.notmach"] ?? "Les mots de passe ne correspondent pas";
  } else {
    $hashed = function_exists('toutlike_hash_password') ? toutlike_hash_password($new_pass) : password_hash($new_pass, PASSWORD_BCRYPT);
    $update = $conn->prepare("UPDATE admins SET password=:pass WHERE admin_id=:id");
    $update->execute(array("id" => $admin["admin_id"], "pass" => $hashed));
    header("Location:" . site_url("admin/logout"));
    exit;
  }

}
require admin_view('account');
?>