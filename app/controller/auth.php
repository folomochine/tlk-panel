<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

if( !route(1) ){
    $route[1] = "login";
}

if( route(1) == "login" ){ 
    $title .= $pagetitle;
}elseif( route(1) == "register" ){
    $title .= $languageArray["signup.title"];
}

if( ( route(1) == "login" || route(1) == "register") && $_SESSION["toutlike_userlogin"] ){
     header("Location:".site_url());exit();
}
if(route(1) == "neworder" || route(1) == "orders" || route(1) == "tickets" || route(1) == "addfunds" || route(1) == "account" || route(1) == "dripfeeds" || route(1) == "reference" || route(1) == "subscriptions" ) {
    header("Location:".site_url()); exit();
}

$google_login_content = '';

$settings["google_login"] = json_decode($settings["google_login"],true)["status"];

if($_SERVER["REQUEST_METHOD"] == "GET" && $settings["google_login"] == "1"){

$google_login_content = '<hr><button type="button" id="login-with-google-btn" class="login-with-google-btn btn btn-secondary" onclick="window.location.href=\'?login-with-google\';"><svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
  <g fill="none" fill-rule="evenodd">
    <path d="M17.64 9.2045c0-.6381-.0573-1.2518-.1636-1.8409H9v3.4818h4.8436c-.2086 1.125-.8427 2.0782-1.7772 2.7218v2.2582h2.9087c1.7018-1.5668 2.6836-3.8741 2.6836-6.621z" fill="#4285F4"></path>
    <path d="M9 18c2.43 0 4.47-.806 5.96-2.181l-2.909-2.258c-.806.54-1.836.86-3.05.86-2.345 0-4.328-1.581-5.036-3.712H.957v2.332C2.44 16.512 5.482 18 9 18z" fill="#34A853"></path>
    <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71s.102-1.17.282-1.71V4.958H.957C.347 6.175 0 7.55 0 9s.347 2.825.957 4.042l3.007-2.332z" fill="#FBBC05"></path>
    <path d="M9 3.579c1.321 0 2.508.454 3.44 1.345l2.582-2.582C13.463.891 11.426 0 9 0 5.48 0 2.44 1.488.957 3.958L3.964 6.29C4.672 4.159 6.655 3.58 9 3.58z" fill="#EA4335"></path>
</g>
</svg>&nbsp;&nbsp;Sign in with Google</button>';


$client_id =($settings["client_id"]);
$client_secret =($settings["client_secret"]);
$redirect_uri = site_url("");
$client = new Google\Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('email');
$client->addScope('profile');
if(array_key_exists("login-with-google",$_GET)){
$auth_url = $client->createAuthUrl();
header('Location: ' .filter_var($auth_url, FILTER_SANITIZE_URL));
exit();
}
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode(urldecode($_GET['code']));
  $client->setAccessToken($token['access_token']);
  $oauth2 = new Google\Service\Oauth2($client);
  $userinfo = $oauth2->userinfo->get();
  $_SESSION['email'] = $userinfo->email;
  $check_if_username_exists = $conn->prepare("SELECT * FROM clients WHERE email=:email");
  $check_if_username_exists->execute([
   "email" => $userinfo->email
  ]);
  if($check_if_username_exists->rowCount()){
    // SIGN IN 
  $check_if_username_exists = $check_if_username_exists->fetch(PDO::FETCH_ASSOC);
  $currency_hash = $check_if_username_exists["currency_type"];
   $_SESSION["toutlike_userlogin"] = 1;
$_SESSION["toutlike_userid"] = $check_if_username_exists["client_id"];
$_SESSION["toutlike_userpass"] = $check_if_username_exists["password"];
$_SESSION["currency_hash"] = $currency_hash;
setcookie("u_id", $check_if_username_exists["client_id"], strtotime('+1 days'), '/', null, null, true);
setcookie("u_password", $check_if_username_exists["password"], strtotime('+1 days'), '/', null, null, true);
setcookie("u_login", 'ok', strtotime('+1 days'), '/', null, null, true);setcookie("currency_hash",$currency_hash,strtotime('+1 days'),'/',null,null,true);
header("Location: ".site_url(""));
exit();
  } else {
    // SIGN UP
 $username =  generateUsername($userinfo->name);
 $ref_code =  substr(bin2hex(random_bytes(18)), 5, 6);
 $apikey = md5(openssl_random_pseudo_bytes(16));
 $pass = openssl_random_pseudo_bytes(16);
  $conn->beginTransaction();
  $insert = $conn->prepare("INSERT INTO clients SET name=:name, username=:username, email=:email, password=:pass, lang=:lang, telephone=:phone, register_date=:date, apikey=:key , ref_code=:ref_code, email_type=:type, balance=:spent, spent=:spent,currency_type=:currency_type");
    // [SECURITE] Phase 1 — Google OAuth signup en bcrypt
    $insert = $insert->execute(array("lang" => "en", "name" => $userinfo->name, "username" => $username, "email" => $userinfo->email, "pass" => toutlike_hash_password($pass), "phone" => "", "date" => date("Y.m.d H:i:s"), 'key' => $apikey, "ref_code" => $ref_code, "type"=> 2, "spent"=> "0.0000","currency_type"=>get_default_currency()));
  $conn->commit();
 $user =   $conn->prepare("SELECT * FROM clients WHERE email=:email");
 $user->execute([
  "email" => $userinfo->email
  ]);
 $user = $user->fetch(PDO::FETCH_ASSOC);
$_SESSION["toutlike_userid"] = $user["client_id"];
 $_SESSION["toutlike_userpass"] = $user["password"];
$currency_hash = $user["currency_type"];
$_SESSION["toutlike_userlogin"] = 1;
$_SESSION["currency_hash"] = $currency_hash;

setcookie("u_id", $row["client_id"], strtotime('+1 days'), '/', null, null, true);
setcookie("u_password", $row["password"], strtotime('+1 days'), '/', null, null, true);
setcookie("u_login", 'ok', strtotime('+1 days'), '/', null, null, true);
setcookie("currency_hash",$currency_hash,strtotime('+1 days'),'/',null,null,true);
header("Location: ".site_url(""));
exit();
}
}



}





if( $route[1] == "login" && $_POST ){

$username       = $_POST["username"];
$mail = "@";
// Test if string contains the word 

$username       = $_POST["username"];
    $username = strip_tags($username);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $pass           = $_POST["password"];
    $captcha        = $_POST['g-recaptcha-response'];
    $remember       = $_POST["remember"];
    $googlesecret   = $settings["recaptcha_secret"];
 $captcha_control= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
 $captcha_control= json_decode($captcha_control);


if(strpos($username, $mail) == false){

    if( $settings["recaptcha"] == 2 && $captcha_control->success == false && $_SESSION["recaptcha"]  ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.recaptcha"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }elseif( !userdata_check("username",$username) ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.username"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    // [SECURITE] Phase 1 — bcrypt avec migration transparente MD5
    }elseif( !($row = toutlike_login_check($conn, 'username', $username, $pass)) ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.notmatch"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }elseif( countRow(["table"=>"clients","where"=>["username"=>$username,"client_type"=>1]]) ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.deactive"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }else{
        $access = json_decode($row["access"],true);


$_SESSION["toutlike_userlogin"] = 1;
$_SESSION["toutlike_userid"] = $row["client_id"];
$_SESSION["toutlike_userpass"]       = $row["password"];
$_SESSION["recaptcha"]= false;
$update = $conn->prepare("UPDATE clients SET broadcast_id=:bid WHERE client_id=:cid");
$update->execute(array(
"bid" => 0,
"cid" => $row["client_id"]
));
$currency_hash = get_currency_hash_by_code(get_default_currency());

$_SESSION["currency_hash"] = $currency_hash;

        if( $access["admin_access"] ):
            $_SESSION["toutlike_adminlogin"] = 1;
            $_SESSION["login_referrer"] = true;
        endif;
        if( $remember ){
            if($access["admin_access"]):
                setcookie("a_login", 'ok', strtotime('+28 days'), '/', null, null, true);
            endif;
            setcookie("u_id", $row["client_id"], strtotime('+28 days'), '/', null, null, true);
            setcookie("u_password", $row["password"], strtotime('+28 days'), '/', null, null, true);
            setcookie("u_login", 'ok', strtotime('+28 days'), '/', null, null, true);
            setcookie("currency_hash",$currency_hash,strtotime('+28 days'),'/',null,null,true);
        }else{
            setcookie("u_id", $row["client_id"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_password", $row["password"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_login", 'ok', strtotime('+7 days'), '/', null, null, true );
            setcookie("currency_hash",$currency_hash,strtotime('+7 days'),'/',null,null,true);
        }
        
        header('Location:'.site_url(''));
        $insert = $conn->prepare("INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ");
        $insert->execute(array("c_id"=>$row["client_id"],"action"=>"Member logged in.","ip"=>GetIP(),"date"=>date("Y-m-d H:i:s") ));
        $update = $conn->prepare("UPDATE clients SET login_date=:date, login_ip=:ip WHERE client_id=:c_id ");
        $update->execute(array("c_id"=>$row["client_id"],"date"=>date("Y.m.d H:i:s"),"ip"=>GetIP() ));
    }









} else {


// [SECURITE] Phase 1 — login par email avec bcrypt + migration MD5
$row_email = toutlike_login_check($conn, 'email', $username, $pass);
$usersname = $row_email ? $row_email["username"] : null;

if( $settings["recaptcha"] == 2 && $captcha_control->success == false && $_SESSION["recaptcha"]  ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.recaptcha"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }elseif( !userdata_check("email",$username) ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.username"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }elseif( !$row_email ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.notmatch"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }elseif( countRow(["table"=>"clients","where"=>["username"=>$username,"client_type"=>1]]) ){
        $error      = 1;
        $errorText  = $languageArray["error.signin.deactive"];
        if( $settings["recaptcha"] == 2 ){ $_SESSION["recaptcha"]  = true; }
    }else{
        $row    = $row_email;
        $access = json_decode($row["access"],true);

     
    $_SESSION["toutlike_userlogin"]      = 1;
        $_SESSION["toutlike_userid"]         = $row["client_id"];
        $_SESSION["toutlike_userpass"]       = $row["password"];
        $_SESSION["recaptcha"]                = false;
        $update = $conn->prepare("UPDATE clients SET broadcast_id=:bid WHERE client_id=:cid");
$update->execute(array(
"bid" => 0,
"cid" => $row["client_id"]
));
$currency_hash = get_currency_hash_by_code(get_default_currency());

$_SESSION["currency_hash"] = $currency_hash;
        if( $access["admin_access"] ):
            $_SESSION["toutlike_adminlogin"] = 1;
            $_SESSION["login_referrer"] = true;
        endif;
        if( $remember ){
            if($access["admin_access"]):
                setcookie("a_login", 'ok', strtotime('+7 days'), '/', null, null, true);
            endif;
            setcookie("u_id", $row["client_id"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_password", $row["password"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_login", 'ok', strtotime('+7 days'), '/', null, null, true);
        }else{
            setcookie("u_id", $row["client_id"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_password", $row["password"], strtotime('+7 days'), '/', null, null, true);
            setcookie("u_login", 'ok', strtotime('+7 days'), '/', null, null, true );
            setcookie("currency_hash",$currency_hash,strtotime('+7 days'),'/',null,null,true);
        }
        
        header('Location:'.site_url(''));
        $insert = $conn->prepare("INSERT INTO client_report SET client_id=:c_id, action=:action, report_ip=:ip, report_date=:date ");
        $insert->execute(array("c_id"=>$row["client_id"],"action"=>"Member  in.","ip"=>GetIP(),"date"=>date("Y-m-d H:i:s") ));
        $update = $conn->prepare("UPDATE clients SET login_date=:date, login_ip=:ip WHERE client_id=:c_id ");
        $update->execute(array("c_id"=>$row["client_id"],"date"=>date("Y.m.d H:i:s"),"ip"=>GetIP() ));
    }


    
} 
}

     