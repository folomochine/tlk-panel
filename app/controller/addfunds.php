<?php
if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}
define("ADDFUNDS", TRUE);
$title .= " Add Funds";

if ($_SESSION["toutlike_userlogin"] != 1 || $user["client_type"] == 1) {
    header("Location:" . site_url('logout'));
}
if ($settings["email_confirmation"] == 1 && $user["email_type"] == 1) {
    header("Location:" . site_url('confirm_email'));
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $paymentMethods = $conn->prepare("SELECT * FROM paymentmethods WHERE methodStatus=:status ORDER BY methodPosition ASC");
    $paymentMethods->execute(["status" => 1]);

    $methodsList = array();

    if ($paymentMethods->rowCount()) {
        $paymentMethods = $paymentMethods->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($paymentMethods); $i++) {
            $methodsList[] = [
                "id" => $paymentMethods[$i]["methodId"],
                "name" => $paymentMethods[$i]["methodVisibleName"],
                "instructions" => trim(htmlspecialchars_decode($paymentMethods[$i]["methodInstructions"])),
                "fee" => $paymentMethods[$i]["methodFee"]
            ];
            $paymentMethodsJSON = json_encode(array_group_by($methodsList, "id"), 1);
        }
    } else {
        $methodsList[] = [
            "id" => 0,
            "name" => "No payment gateway activated"
        ];
    }

    $methodNames = $conn->prepare("SELECT methodId,methodVisibleName,methodFee,methodCurrency FROM paymentmethods");
    $methodNames->execute();
    $methodNames = $methodNames->fetchAll(PDO::FETCH_ASSOC);
    $methodNames = array_group_by($methodNames, "methodId");

    $transactions = $conn->prepare("SELECT payment_id,payment_create_date,payment_method,payment_amount,payment_note,t_id FROM payments WHERE payment_status=:status && payment_delivery=:delivery && client_id=:id ORDER BY payment_id DESC");
    $transactions->execute([
        "status" => 3,
        "delivery" => 2,
        "id" => $user["client_id"]
    ]);
    $transactions = $transactions->fetchAll(PDO::FETCH_ASSOC);

    $paymentHistory = [];
    for ($i = 0; $i < count($transactions); $i++) {
        $isManual = (intval($transactions[$i]["payment_method"]) === 0);
        if ($isManual) {
            $methodName = "Manuel";
            $methodConfig = ["methodVisibleName" => "Manuel", "methodCurrency" => $settings["site_base_currency"]];
        } else {
            $methodConfig = $methodNames[$transactions[$i]["payment_method"]][0];
            $methodName = $methodConfig["methodVisibleName"];
        }
        $displayAmount = from_to($currencies_array, $settings["site_base_currency"], $user["currency_type"], $transactions[$i]["payment_amount"]);
        $displayAmountText = format_amount_string($user["currency_type"], $displayAmount);

        if (!$isManual && intval($transactions[$i]["payment_method"]) === 21) {
            $orangeMoneyBreakdown = get_orange_money_payment_breakdown($transactions[$i], $methodConfig, $currencies_array, $settings);
            $displayAmount = from_to($currencies_array, $methodConfig["methodCurrency"], $user["currency_type"], $orangeMoneyBreakdown["input_amount"]);
            if (strtoupper($user["currency_type"]) === strtoupper($methodConfig["methodCurrency"])) {
                $displayAmountText = format_amount_string_exact($user["currency_type"], $displayAmount);
            } else {
                $displayAmountText = format_amount_string($user["currency_type"], $displayAmount);
            }
        }

        $paymentHistory[] = [
            "id" => $transactions[$i]["payment_id"],
            "date" => $transactions[$i]["payment_create_date"],
            "name" => $methodName,
            "amount" => $displayAmountText
        ];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "getForm") {
    $formData .= "";
    $selectedMethod = $_POST["selectedMethod"];
    include("addfunds/getForm.php");
    $response = [];
    $response["success"] = true;
    $response["content"] = $formData;
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($response, true);
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methodId = intval($_POST["payment_type"] ?: 0);

    $method = $conn->prepare("SELECT * FROM paymentmethods WHERE methodId=:id AND methodStatus=:status");
    $method->execute([
        "id" => $methodId,
        "status" => 1
    ]);
    if ($method->rowCount()) {
        $method = $method->fetch(PDO::FETCH_ASSOC);
        $methodId = $method["methodId"];
        $methodMin = number_format($method["methodMin"], 2, '.', '');
        $methodMax = number_format($method["methodMax"], 2, '.', '');
        $methodCurrency = $method["methodCurrency"];
        $methodCurrencySymbol = $currencies_array[$methodCurrency][0]["currency_symbol"] ?: $methodCurrency;
        $methodCallback = $method["methodCallback"];
        $methodExtras = json_decode($method["methodExtras"], 1);
        $paymentFee = $method["methodFee"];
        $paymentBonus = $method["methodBonusPercentage"];
        $paymentBonusStartAmount = $method["methodBonusStartAmount"];

        $paymentAmount = floatval($_POST["payment_amount"] ?: 0);
        $paymentEnteredAmount = $paymentAmount;
        $paymentGatewayAmount = $paymentAmount;
        $paymentRecordedAmount = $paymentAmount;
        $paymentFeeAmount = 0;
        $paymentMetadata = "";
        $paymentNote = "No";
        $response = [];

        if ($paymentEnteredAmount <= 0) {
            errorExit("Veuillez saisir un montant valide.");
        }

        if ($methodId == 21) {
            if ($paymentEnteredAmount < $methodMin) {
                errorExit("Montant minimum : $methodCurrencySymbol $methodMin");
            }
            if ($paymentEnteredAmount > $methodMax) {
                errorExit("Montant maximum : $methodCurrencySymbol $methodMax");
            }

            $paymentFeeAmount = calculate_percentage_fee_amount($paymentEnteredAmount, $paymentFee);
            $paymentGatewayAmount = round($paymentEnteredAmount + $paymentFeeAmount, 4);
            $paymentRecordedAmount = from_to($currencies_array, $methodCurrency, $settings["site_base_currency"], $paymentEnteredAmount);

            $orangeMoneyBreakdown = [
                "input_amount" => $paymentEnteredAmount,
                "fee_amount" => $paymentFeeAmount,
                "gateway_amount" => $paymentGatewayAmount,
                "credited_base_amount" => $paymentRecordedAmount,
                "method_currency" => $methodCurrency,
                "base_currency" => $settings["site_base_currency"]
            ];
            $paymentNote = build_orange_money_payment_note($orangeMoneyBreakdown);
            $paymentMetadata = build_orange_money_payment_metadata($paymentEnteredAmount, $paymentFeeAmount, $paymentGatewayAmount, $paymentRecordedAmount, $methodCurrency, $settings["site_base_currency"]);
        } else {
            if ($paymentFee > 0) {
                $fee = ($paymentAmount * ($paymentFee / 100));
                $paymentAmount += $fee;
            }
            $paymentGatewayAmount = $paymentAmount;
            $paymentRecordedAmount = $paymentAmount;

            if ($paymentAmount < $methodMin) {
                errorExit("Minimum amount : $methodCurrencySymbol $methodMin");
            }
            if ($paymentAmount > $methodMax) {
                errorExit("Maximum amount : $methodCurrencySymbol $methodMax");
            }
        }

        if ($method["methodId"] == 1) {
            require("addfunds/Initiators/payTMCheckout.php");
        }
        if ($method["methodId"] == 2) {
            require("addfunds/Initiators/payTMMerchant.php");
        }
        if ($method["methodId"] == 3) {
            require("addfunds/Initiators/perfectMoney.php");
        }
        if ($method["methodId"] == 4) {
            require("addfunds/Initiators/coinbaseCommerce.php");
        }
        if ($method["methodId"] == 5) {
            require("addfunds/Initiators/kashier.php");
        }
        if ($method["methodId"] == 6) {
            require("addfunds/Initiators/razorPay.php");
        }
        if ($method["methodId"] == 7) {
            require("addfunds/Initiators/phonepe.php");
        }
        if ($method["methodId"] == 8) {
            require("addfunds/Initiators/easypaisa.php");
        }
        if ($method["methodId"] == 9) {
            require("addfunds/Initiators/jazzcash.php");
        }
        if ($method["methodId"] == 10) {
            require("addfunds/Initiators/instamojo.php");
        }
        if ($method["methodId"] == 11) {
            require("addfunds/Initiators/cashmaal.php");
        }
        if ($method["methodId"] == 12) {
            require("addfunds/Initiators/alipay.php");
        }
        if ($method["methodId"] == 13) {
            require("addfunds/Initiators/payU.php");
        }
        if ($method["methodId"] == 14) {
            require("addfunds/Initiators/upiapi.php");
        }
        if ($method["methodId"] == 15) {
            require("addfunds/Initiators/opay.php");
        }
        if ($method["methodId"] == 16) {
            require("addfunds/Initiators/flutterwave.php");
        }
        if ($method["methodId"] == 17) {
            require("addfunds/Initiators/stripe.php");
        }
        if ($method["methodId"] == 18) {
            require("addfunds/Initiators/payeer.php");
        }
        if ($method["methodId"] == 19) {
            require("addfunds/Initiators/boishakhipay.php");
        }
        if ($method["methodId"] == 20) {
            require("addfunds/Initiators/uddoktapay.php");
        }
        if ($method["methodId"] == 21) {
            require("addfunds/Initiators/lengopay.php");
        }
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($response, true);
        exit;
    } else {
        errorExit("Selectionnez une methode de paiement valide.");
    }
}
?>
