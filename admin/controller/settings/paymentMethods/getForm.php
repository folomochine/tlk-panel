<?php
// Rendu du formulaire d'edition (champs bruts uniquement).
// Le JS dans admin/views/settings/paymentMethods.php se charge du wrapping
// (form + modal-body + modal-footer).

$mid          = isset($method['methodId']) ? (int) $method['methodId'] : 0;
$amountSuffix = ($mid === 21) ? ' (GNF)' : '';
$isAutomatic  = !in_array($mid, $manualMethods);
$methodExtras = is_array($methodExtras) ? $methodExtras : array();

$hx = function ($v) { return htmlspecialchars((string) $v); };
$xv = function ($key) use ($methodExtras) {
  return isset($methodExtras[$key]) ? htmlspecialchars((string) $methodExtras[$key]) : '';
};

$extraBlocks = array(
  1  => array(array('merchantId','Merchant ID'), array('merchantKey','Merchant Key')),
  2  => array(array('merchantId','Merchant ID')),
  3  => array(array('accountNumber','Identifiant USD'), array('alternatePassPhrase','Pass Phrase alternative')),
  4  => array(array('APIKey','Cle API')),
  5  => array(array('MID','MID'), array('APIKey','Cle API')),
  6  => array(array('APIPublicKey','Cle publique API'), array('APISecretKey','Cle secrete API')),
  7  => array(array('email','Adresse Gmail'), array('password','Mot de passe application')),
  8  => array(array('email','Adresse Gmail'), array('password','Mot de passe application'), array('senderEmail','Email expediteur'), array('emailSubject','Objet du mail')),
  9  => array(array('email','Adresse Gmail'), array('password','Mot de passe application'), array('senderEmail','Email expediteur'), array('emailSubject','Objet du mail')),
  10 => array(array('APIKey','Cle API'), array('authToken','Auth Token')),
  11 => array(array('webId','Web ID')),
  12 => array(array('partnerId','ID partenaire'), array('privateKey','Cle privee')),
  13 => array(array('merchantKey','Merchant Key'), array('merchantSalt','Merchant Salt')),
  14 => array(array('productionAPIToken','Token API production'), array('productionAPISecretKey','Secret API production')),
  15 => array(array('merchantId','Merchant ID'), array('publicKey','Cle publique'), array('secretKey','Cle secrete')),
  16 => array(array('secretKey','Cle secrete')),
  17 => array(array('publishableKey','Publishable Key'), array('secretKey','Secret Key')),
  18 => array(array('shopId','Shop ID'), array('secretKey','Cle secrete')),
  19 => array(array('api_key','Cle API BoishakhiPay'), array('exchange_rate','Taux de change (1 USD = ? BDT)')),
  20 => array(array('api_key','Cle API'), array('api_url','URL API'), array('exchange_rate','Taux de change (1 USD = ? BDT)')),
  21 => array(array('license_key','Cle de licence Orange Money'), array('website_id','Website ID Orange Money'), array('exchange_rate','Taux de change (1 USD = ? GNF)')),
);

$form  = '<input type="hidden" name="method_id" value="' . $hx($mid) . '"/>';

$form .= '<div class="form-group"><label class="control-label">Nom de la methode</label>';
$form .= '<input type="text" name="method_name" class="form-control" value="' . $hx($method['methodVisibleName']) . '"/></div>';

if ($isAutomatic) {
  $form .= '<div class="pm-section">Limites et tarification</div>';
  $form .= '<div class="pm-row">';

  $form .= '<div class="form-group"><label class="control-label">Montant minimum' . $amountSuffix . '</label>';
  $form .= '<input type="number" name="method_min" class="form-control" value="' . $hx($method['methodMin']) . '"/></div>';

  $form .= '<div class="form-group"><label class="control-label">Montant maximum' . $amountSuffix . '</label>';
  $form .= '<input type="number" name="method_max" class="form-control" value="' . $hx($method['methodMax']) . '"/></div>';

  $form .= '<div class="form-group"><label class="control-label">Frais (commission)</label>';
  $form .= '<div class="input-group">';
  $form .= '<input type="number" class="form-control" name="method_fee" step="0.01" value="' . $hx($method['methodFee']) . '">';
  $form .= '<span class="input-group-addon"><i class="fa fa-percent"></i></span>';
  $form .= '</div></div>';

  $form .= '<div class="form-group"><label class="control-label">Bonus client</label>';
  $form .= '<div class="input-group">';
  $form .= '<input type="number" class="form-control" name="method_bonus" step="0.01" value="' . $hx($method['methodBonusPercentage']) . '">';
  $form .= '<span class="input-group-addon"><i class="fa fa-percent"></i></span>';
  $form .= '</div></div>';

  $form .= '<div class="form-group pm-full"><label class="control-label">Seuil de bonus' . $amountSuffix . '</label>';
  $form .= '<input type="number" name="method_bonus_start_amount" class="form-control" value="' . $hx($method['methodBonusStartAmount']) . '"/></div>';

  $form .= '</div>';
}

$form .= '<div class="form-group"><label class="control-label">Statut</label>';
$form .= '<select name="method_status" class="form-control">';
$form .= '<option value="1"' . ($method['methodStatus'] == '1' ? ' selected' : '') . '>Active</option>';
$form .= '<option value="0"' . ($method['methodStatus'] == '0' ? ' selected' : '') . '>Inactive</option>';
$form .= '</select></div>';

$form .= '<div class="form-group"><label class="control-label">Instructions affichees au client</label>';
$form .= '<div id="editor" name="method_instructions" class="extraContents">' . htmlspecialchars_decode((string) $method['methodInstructions']) . '</div></div>';

if (isset($extraBlocks[$mid])) {
  $form .= '<div class="pm-section">Parametres techniques</div>';
  foreach ($extraBlocks[$mid] as $field) {
    list($k, $lbl) = $field;
    $form .= '<div class="form-group"><label class="control-label">' . $hx($lbl) . '</label>';
    $form .= '<input type="text" name="' . $hx($k) . '" class="form-control" value="' . $xv($k) . '"/></div>';
  }
  if ($mid === 5) {
    $modeVal = $methodExtras['mode'] ?? '';
    $form .= '<div class="form-group"><label class="control-label">Environnement</label>';
    $form .= '<select name="mode" class="form-control">';
    $form .= '<option value="live"' . ($modeVal === 'live' ? ' selected' : '') . '>Live</option>';
    $form .= '<option value="test"' . ($modeVal === 'test' ? ' selected' : '') . '>Test</option>';
    $form .= '</select></div>';
  }
}
