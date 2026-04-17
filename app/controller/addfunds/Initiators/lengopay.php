<?php
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$licenseKey = $methodExtras["license_key"];
$websiteId = $methodExtras["website_id"]; 
$apiUrl = "https://portal.lengopay.com/api/v1/payments";
$returnURL = site_url("payment/lengopay"); 
$orderId = md5(RAND_STRING(5) . time());
$enteredAmount = floatval($paymentEnteredAmount ?? 0);
$gatewayAmount = round(floatval($paymentGatewayAmount ?? $paymentAmount), 2);
$recordedAmount = round(floatval($paymentRecordedAmount ?? $enteredAmount), 4);
$paymentNote = $paymentNote ?? "Orange Money";
$paymentMetadata = $paymentMetadata ?? "";

$insert = $conn->prepare("INSERT INTO payments SET client_id=:client_id, payment_amount=:amount, payment_method=:method, payment_mode=:mode, payment_create_date=:date, payment_ip=:ip, payment_extra=:extra, payment_note=:note, t_id=:tid");
$insert->execute([
    "client_id" => $user["client_id"],
    "amount" => $recordedAmount,
    "method" => $methodId,
    "mode" => "Automatic",
    "date" => date("Y.m.d H:i:s"),
    "ip" => GetIP(),
    "extra" => $orderId,
    "note" => $paymentNote,
    "tid" => $paymentMetadata
]);

$requestData = [
    'websiteid'  => $websiteId,
    'amount'     => $gatewayAmount,
    'currency'   => $method["methodCurrency"], 
    'return_url' => $returnURL
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl, 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($requestData),
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic " . $licenseKey, 
        "Accept: application/json", 
        "Content-Type: application/json"
    ],
]);

$upresponse = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    errorExit("cURL Error #:" . $err);
} else {
    $result = json_decode($upresponse, true);
    
    if (isset($result['pay_id']) && isset($result['payment_url'])) { 
        $_SESSION['lengo_pay_id'] = $result['pay_id']; 
        $_SESSION['lengo_order_id'] = $orderId;

        $paymentUrl = $result['payment_url']; 
        $redirectForm = '<form method="GET" action="' . $paymentUrl . '" name="lengopayForm"></form>
        <script type="text/javascript">document.lengopayForm.submit();</script>';
    } else {
        errorExit("Erreur Orange Money : " . (isset($result['status']) ? $result['status'] : 'Requete echouee'));
    }
}

$response["success"] = true;
$response["message"] = "Redirection vers Orange Money...";
$response["content"] = $redirectForm;