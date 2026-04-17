<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
$title .= $languageArray["resetpassword.title"];

if( $_SESSION["toutlike_userlogin"] == 1  || $user["client_type"] == 1 || $settings["resetpass_page"] == 1  ){
  header("Location:".site_url());
}
if( !route(1) ){ 

if( $_POST ):

$captcha = $_POST['g-recaptcha-response'];
$googlesecret   = $settings["recaptcha_secret"];
$captcha_control = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
$captcha_control = json_decode($captcha_control);
$resetPasswordSuccessText = $languageArray["error.resetpassword.success"];
$user = trim($_POST["user"]);
$row = $conn->prepare("SELECT * FROM clients WHERE username=:user OR email=:user LIMIT 1");
    $row->execute(array("user"=>$user));
    if( empty($user) ):
      $error      = 1;
      $errorText  = $languageArray["error.resetpassword.user.empty"];
    elseif( $settings["recaptcha"] == 2 && $captcha_control->success == false ):
      $error      = 1;
      $errorText  = $languageArray["error.resetpassword.recaptcha"];
    elseif( !$row->rowCount() ):
      $success    = 1;
      $successText= $resetPasswordSuccessText;

    else:
      $row    = $row->fetch(PDO::FETCH_ASSOC);
      $token   = md5($row["email"].$row["username"].rand(9999,2324332));
      $update = $conn->prepare("UPDATE clients SET passwordreset_token=:pass WHERE client_id=:id ");
      $update->execute(array("id"=>$row["client_id"],"pass"=> $token ));
    
        
$htmlContent = "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été reçue pour votre compte.<br>Pour définir un nouveau mot de passe, utilisez le lien suivant : ". site_url()."resetpassword/$token";  
$to = $row["email"]; 
$fromName = $_SERVER["HTTP_HOST"]; 
$from =  "noreply@smmemail.com"; 
$subject = "Réinitialisation du mot de passe"; 
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "mail.smmemail.com";   
$mail->SMTPDebug  = 0;                     
$mail->SMTPAuth   = true;                 
$mail->Port       = 587;               
$mail->Username   = $from;        
$mail->Password   = "tJCz4dcV6FCNSrL";
$mail->setFrom($from,$fromName);   
$mail->addAddress($to);
$mail->isHTML(true); 
$mail->Subject = $subject;
$mail->Body   = $htmlContent;
@ $mail->send();
$success    = 1;
$successText= $resetPasswordSuccessText;
        


    endif;

endif;
} else {
$templateDir  = "setnewpassword";
$passwordreset_token = route(1);
$user = $conn->prepare("SELECT * FROM clients WHERE passwordreset_token=:id");
$user->execute(array("id"=> route(1) ));
$user = $user->fetch(PDO::FETCH_ASSOC);

$client= $conn->prepare("SELECT * FROM clients WHERE passwordreset_token=:email ");
    $client->execute(array("email"=>$passwordreset_token));
 
if( !$client->rowCount() ):
header("Location: ".site_url("resetpassword"));
endif;
if( $_POST ):
$pass = $_POST["password"];

  $again = $_POST["password_again"];
$passwordreset_token = route(1);
if($pass != $again):
$error      = 1;
      $errorText  = "Les mots de passe ne correspondent pas.";
else:
// [SECURITE] Phase 1 — reset password en bcrypt
$update = $conn->prepare("UPDATE clients SET password=:pass, passwordreset_token=:token WHERE client_id=:id ");
      $update->execute(array("id"=> $user["client_id"],"token" => "" ,"pass"=> toutlike_hash_password($pass) ));

if( $update ):
        $success    = 1;
        $successText= "Votre mot de passe a été mis à jour avec succès.";
        echo '<script>setTimeout(function(){window.location="'.site_url().'"},2000)</script>';
      else:
        $error      = 1;
        $errorText  = $languageArray["error.resetpassword.fail"];
      endif;


    endif;
endif;
    
      




} 


