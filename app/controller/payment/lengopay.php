<?php
if (!defined('PAYMENT')) {
    http_response_code(404);
    die();
}

$pay_id = $_SESSION['lengo_pay_id'] ?? "";
$orderId = $_SESSION['lengo_order_id'] ?? "";

if (empty($pay_id) || empty($orderId)) {
    errorExit("Session expirée ou transaction introuvable.");
}

$licenseKey = $methodExtras["license_key"];
$websiteId = $methodExtras["website_id"];
$checkUrl = "https://portal.lengopay.com/api/v1/transaction/status";

$checkData = [
    'pay_id' => $pay_id,
    'websiteid' => $websiteId
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $checkUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($checkData),
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic " . $licenseKey,
        "Accept: application/json",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$curlError = curl_error($curl);
curl_close($curl);

if ($curlError) {
    errorExit("Erreur Orange Money : " . $curlError);
}

$data = json_decode($response, true);

unset($_SESSION['lengo_pay_id']);
unset($_SESSION['lengo_order_id']);

if (isset($data['status']) && $data['status'] === 'SUCCESS') {
    $paymentDetails = $conn->prepare("SELECT * FROM payments WHERE payment_extra=:orderId");
    $paymentDetails->execute(["orderId" => $orderId]);
    $payment = $paymentDetails->fetch(PDO::FETCH_ASSOC);

    if ($payment) {
        if ($payment['payment_status'] == 3) {
            header("Location: " . site_url("addfunds?success=true"));
            exit();
        }

        $client = $conn->prepare("SELECT * FROM clients WHERE client_id=:id");
        $client->execute(["id" => $payment["client_id"]]);
        $user = $client->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $orangeMoneyBreakdown = get_orange_money_payment_breakdown($payment, $paymentMethod, $currencies_array, $settings);
            $paidAmount = floatval($orangeMoneyBreakdown["credited_base_amount"]);
            $paymentNote = build_orange_money_payment_note($orangeMoneyBreakdown);

            if ($paymentBonusStartAmount != 0 && $orangeMoneyBreakdown["input_amount"] >= $paymentBonusStartAmount) {
                $bonusAmount = calculate_percentage_fee_amount($orangeMoneyBreakdown["input_amount"], $paymentBonus);
                $paidAmount += from_to($currencies_array, $methodCurrency, $settings["site_base_currency"], $bonusAmount);
                $paymentNote .= " | Bonus : " . format_amount_string_exact($methodCurrency, $bonusAmount);
            }

            try {
                $conn->beginTransaction();

                $updatePayment = $conn->prepare("UPDATE payments SET client_balance=:balance, payment_status=:status, payment_delivery=:delivery, payment_note=:note WHERE payment_id=:id");
                $updatePayment->execute([
                    "balance" => $user["balance"],
                    "status" => 3,
                    "delivery" => 2,
                    "note" => $paymentNote,
                    "id" => $payment["payment_id"]
                ]);

                $updateBalance = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id");
                $updateBalance->execute([
                    "balance" => $user["balance"] + $paidAmount,
                    "id" => $user["client_id"]
                ]);

                $conn->commit();
                header("Location: " . site_url("addfunds?success=true"));
                exit();
            } catch (Exception $e) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }
            }
        }
    }
}

header("Location: " . site_url("addfunds?error=true"));
exit();
