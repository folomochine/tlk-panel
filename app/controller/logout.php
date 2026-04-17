<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
  unset($_SESSION["toutlike_userid"]);
  unset($_SESSION["toutlike_userpass"]);
  unset($_SESSION["toutlike_userlogin"]);
  setcookie("u_id", $user["client_id"], time()-(60*60*24*7), '/', null, null, true );
  setcookie("u_password", $user["password"], time()-(60*60*24*7), '/', null, null, true );
  setcookie("u_login", 'ok', time()-(60*60*24*7), '/', null, null, true );
  setcookie("currency_hash", 'ok', time()-(60*60*24*7), '/', null, null, true );
  session_destroy();
  header("Location: ".site_url(''));
?> 