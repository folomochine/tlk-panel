<?php
use PragmaRX\Google2FA\Google2FA;
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
 if( $_POST ){

  $username       = $_POST["username"];
  $pass           = $_POST["password"];
  $captcha        = $_POST['g-recaptcha-response'];
  $remember       = $_POST["remember"];
  $two_factor_code = htmlspecialchars($_POST["two_factor_code"]);
  $googlesecret   = $settings["recaptcha_secret"];
  $captcha_control= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
  $captcha_control= json_decode($captcha_control);

  if( $settings["recaptcha"] == 2 && $captcha_control->success == false && $_SESSION["recaptcha"]  ){
    $error      = 1;
    $errorText  = "Veuillez vérifier que vous n'êtes pas un robot.";
      if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
  }elseif( countRow(["table"=>"admins","where"=>["username"=>$username,"client_type"=>1]]) ){
    $error      = 1;
    $errorText  = "Votre compte est suspendu.";
      if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
  }else{
    // [SECURITE] Phase 1 — Login admin avec bcrypt + migration transparente
    $admin = $conn->prepare("SELECT * FROM admins WHERE username=:username");
    $admin->execute(array("username" => $username));
    $admin = $admin->fetch(PDO::FETCH_ASSOC);
    $admin_auth_ok = false;
    if ($admin) {
        // Essayer bcrypt d'abord, puis fallback plain text (legacy)
        if (toutlike_verify_password($pass, $admin["password"])) {
            $admin_auth_ok = true;
            // Migration vers bcrypt si encore en plain text ou MD5
            if (toutlike_needs_rehash($admin["password"]) || strlen($admin["password"]) < 60) {
                $new_hash = toutlike_hash_password($pass);
                $conn->prepare("UPDATE admins SET password=:p WHERE admin_id=:id")->execute(["p" => $new_hash, "id" => $admin["admin_id"]]);
                $admin["password"] = $new_hash;
            }
        } elseif ($admin["password"] === $pass) {
            // Mot de passe en clair (legacy BD Lab) — migrer vers bcrypt
            $admin_auth_ok = true;
            $new_hash = toutlike_hash_password($pass);
            $conn->prepare("UPDATE admins SET password=:p WHERE admin_id=:id")->execute(["p" => $new_hash, "id" => $admin["admin_id"]]);
            $admin["password"] = $new_hash;
        }
    }
    $access = json_decode($admin["access"] ?? '{}', true);
    if ($admin_auth_ok) {
    $_SESSION["toutlike_adminslogin"]      = 1;
	
	    $_SESSION["toutlike_adminid"]         = $admin["admin_id"];
	    $_SESSION["toutlike_adminpass"]       = $admin["password"];
	    $_SESSION["recaptcha"]                = false;
       
   
    if( $access["admin_access"] ){
 if( $admin["two_factor"] == 1){

$google2fa = new Google2FA();

$is_valid = $google2fa->verifyKey($admin["two_factor_secret_key"], $two_factor_code);
}

 if($admin["two_factor"] == 1 && $is_valid == true){
 $_SESSION["toutlike_adminslogin"]= 1;

$_SESSION["toutlike_adminid"]         = $admin["admin_id"];
	    $_SESSION["toutlike_adminpass"]       = $pass ;
	    $_SESSION["recaptcha"]                = false;
setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
	      
	      setcookie("a_id", $admin["admin_id"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_password", $admin["password"], time()+(60*60*24*7), '/', null, null, true );
	      setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
	 header('Location: '.site_url('admin'));
	 exit();
}  elseif($admin["two_factor"] == 1 && $is_valid == false) {
  $error = 1;

$errorText  = "Code 2FA invalide.";
} else {
$_SESSION["toutlike_adminslogin"]= 1;
$_SESSION["toutlike_adminid"] = $admin["admin_id"];
$_SESSION["toutlike_adminpass"] = $pass ;

$_SESSION["recaptcha"] = false;
setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
setcookie("a_id", $admin["admin_id"], time()+(60*60*24*7), '/', null, null, true );
setcookie("a_password", $admin["password"], time()+(60*60*24*7), '/', null, null, true );
setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true );
header('Location: '.site_url('admin'));
}
$update = $conn->prepare("UPDATE admins SET login_date=:date, login_ip=:ip WHERE admin_id=:c_id ");
$update->execute(array("c_id"=>$admin["admin_id"],"date"=>date("Y.m.d H:i:s"),"ip"=>GetIP() ));

 } else {
$error = 1;
$errorText  = "Aucun compte administrateur trouvé avec ces informations.";
 }
    } else {
        $error = 1;
        $errorText = "Nom d'utilisateur ou mot de passe incorrect.";
    }
      
  }
 }

if( $access["admin_access"]  && $_SESSION["toutlike_adminslogin"]  ):
	
	exit();
else:
	require admin_view('login');
endif;