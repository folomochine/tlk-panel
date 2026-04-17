<?php
// [PHASE 2] ToutLike — Module devises (extrait de data_control.php)

function getCurrencyUnit() {
    global $conn;
    $lang = $conn->prepare("SELECT site_base_currency FROM settings WHERE id=:id");
    $lang->execute(["id" => 1]);
    return $lang->fetch(PDO::FETCH_ASSOC)["site_base_currency"];
}

function get_currencies_array($all = "enabled", $grouped_by = "currency_code") {
    global $conn;
    $sql = ($all == "enabled") ? " WHERE is_enable=1" : "";
    $currencies = $conn->prepare("SELECT * FROM currencies$sql");
    $currencies->execute();
    return array_group_by($currencies->fetchAll(PDO::FETCH_ASSOC), $grouped_by);
}

function from_to($currencies_array, $from, $to, $amount) {
    global $settings;
    if (empty($from)) $from = getCurrencyUnit();
    if (empty($to)) $to = getCurrencyUnit();
    $amount = floatval($amount);
    $base_currency = strtolower($settings["site_base_currency"] ?? getCurrencyUnit());

    if (!count($currencies_array)) return $amount;
    if (strtolower($from) == strtolower($to)) return $amount;

    if (strtolower($from) != $base_currency && strtolower($to) != $base_currency) {
        $inverse = $currencies_array[$from][0]["currency_inverse_rate"];
        $amount_to_base = $amount * $inverse;
        return $amount_to_base * $currencies_array[$to][0]["currency_rate"];
    } elseif (strtolower($from) == $base_currency && strtolower($to) != $base_currency) {
        return $amount * $currencies_array[$to][0]["currency_rate"];
    } elseif (strtolower($from) != $base_currency && strtolower($to) == $base_currency) {
        return $amount * $currencies_array[$from][0]["currency_inverse_rate"];
    }
    return $amount;
}

function currency_array_group_by_code() {
    global $conn;
    $currencies = $conn->prepare("SELECT * FROM currencies");
    $currencies->execute();
    return array_group_by($currencies->fetchAll(PDO::FETCH_ASSOC), "currency_code");
}

function get_default_currency() {
    global $conn;
    $r = $conn->prepare("SELECT site_base_currency FROM settings WHERE id=:id");
    $r->execute(["id" => 1]);
    $currency = $r->fetch(PDO::FETCH_ASSOC)["site_base_currency"] ?? '';
    // [FIX GNF] Fallback Guinee : si USD ou vide, forcer GNF
    if (empty($currency) || $currency === 'USD') {
        return 'GNF';
    }
    return $currency;
}

function get_currency_hash_by_code($code) {
    global $conn;
    $r = $conn->prepare("SELECT currency_hash FROM currencies WHERE currency_code=:code");
    $r->execute(["code" => $code]);
    return $r->fetch(PDO::FETCH_ASSOC)["currency_hash"];
}

function get_currency_code_by_id($id) {
    global $conn;
    $r = $conn->prepare("SELECT currency_code FROM currencies WHERE id=:id");
    $r->execute(["id" => $id]);
    return $r->fetch(PDO::FETCH_ASSOC)["currency_code"];
}

function get_currency_symbol_by_code($code) {
    global $conn;
    $r = $conn->prepare("SELECT currency_symbol FROM currencies WHERE currency_code=:currency_code");
    $r->execute(["currency_code" => $code]);
    return $r->fetch(PDO::FETCH_ASSOC)["currency_symbol"];
}

function get_symbol_position_by_code($code) {
    global $conn;
    $r = $conn->prepare("SELECT symbol_position FROM currencies WHERE currency_code=:currency_code");
    $r->execute(["currency_code" => $code]);
    return $r->fetch(PDO::FETCH_ASSOC)["symbol_position"];
}

function ROUND_AMOUNT($amount, $precision = 2) {
    $amount = floatval($amount);
    if ($amount < 1) {
        return round(rtrim(sprintf('%f', floatval($amount)), '0'), 4);
    } elseif ($amount > 0) {
        return number_format(round($amount, $precision), 2);
    }
    return $amount;
}

function APIRoundAmount($amount, $precision = 2) {
    $amount = floatval($amount);
    if ($amount < 1) {
        return round(rtrim(sprintf('%f', floatval($amount)), '0'), 4);
    } elseif ($amount > 0) {
        return number_format(round($amount, $precision), 4);
    }
    return $amount;
}


function decode_payment_metadata($rawValue) {
    if (!is_string($rawValue) || trim($rawValue) === "") {
        return [];
    }
    $decoded = json_decode($rawValue, true);
    return is_array($decoded) ? $decoded : [];
}

function calculate_percentage_fee_amount($amount, $percentage, $precision = 4) {
    $amount = floatval($amount);
    $percentage = floatval($percentage);
    if ($amount <= 0 || $percentage <= 0) {
        return 0;
    }
    return round($amount * ($percentage / 100), $precision);
}

function get_amount_before_percentage_fee($grossAmount, $percentage, $precision = 4) {
    $grossAmount = floatval($grossAmount);
    $percentage = floatval($percentage);
    if ($grossAmount <= 0) {
        return 0;
    }
    if ($percentage <= 0) {
        return round($grossAmount, $precision);
    }
    return round($grossAmount / (1 + ($percentage / 100)), $precision);
}

function build_orange_money_payment_metadata($inputAmount, $feeAmount, $gatewayAmount, $creditedBaseAmount, $methodCurrency, $baseCurrency) {
    return json_encode([
        "version" => "orange_money_gnf_v2",
        "input_amount" => round(floatval($inputAmount), 4),
        "fee_amount" => round(floatval($feeAmount), 4),
        "gateway_amount" => round(floatval($gatewayAmount), 4),
        "credited_base_amount" => round(floatval($creditedBaseAmount), 4),
        "method_currency" => $methodCurrency,
        "base_currency" => $baseCurrency
    ]);
}

function get_orange_money_payment_breakdown($payment, $paymentMethod, $currencies_array, $settings) {
    $methodCurrency = $paymentMethod["methodCurrency"] ?? "GNF";
    $baseCurrency = $settings["site_base_currency"] ?? get_default_currency();
    $paymentFee = floatval($paymentMethod["methodFee"] ?? 0);
    $metadata = decode_payment_metadata($payment["t_id"] ?? "");

    $breakdown = [
        "input_amount" => 0,
        "fee_amount" => 0,
        "gateway_amount" => 0,
        "credited_base_amount" => 0,
        "method_currency" => $methodCurrency,
        "base_currency" => $baseCurrency,
        "is_structured" => false
    ];

    if (($metadata["version"] ?? "") === "orange_money_gnf_v2") {
        $breakdown["input_amount"] = floatval($metadata["input_amount"] ?? 0);
        $breakdown["fee_amount"] = floatval($metadata["fee_amount"] ?? 0);
        $breakdown["gateway_amount"] = floatval($metadata["gateway_amount"] ?? ($breakdown["input_amount"] + $breakdown["fee_amount"]));
        $breakdown["credited_base_amount"] = floatval($metadata["credited_base_amount"] ?? ($payment["payment_amount"] ?? 0));
        $breakdown["method_currency"] = $metadata["method_currency"] ?? $methodCurrency;
        $breakdown["base_currency"] = $metadata["base_currency"] ?? $baseCurrency;
        $breakdown["is_structured"] = true;
        return $breakdown;
    }

    $gatewayAmount = floatval($payment["payment_amount"] ?? 0);
    $inputAmount = get_amount_before_percentage_fee($gatewayAmount, $paymentFee);
    $feeAmount = round(max(0, $gatewayAmount - $inputAmount), 4);
    $creditedBaseAmount = from_to($currencies_array, $methodCurrency, $baseCurrency, $inputAmount);

    $breakdown["input_amount"] = $inputAmount;
    $breakdown["fee_amount"] = $feeAmount;
    $breakdown["gateway_amount"] = $gatewayAmount;
    $breakdown["credited_base_amount"] = $creditedBaseAmount;

    return $breakdown;
}
function format_amount_string($currency_code, $amount) {
    $site_base_currency = get_default_currency();
    $currency_sym = get_currency_symbol_by_code($currency_code);
    $symbol_position = get_symbol_position_by_code($currency_code);
    $prefix = ($site_base_currency !== $currency_code) ? "≈ " : "";

    // GNF n'a pas de centimes — arrondir et formater sans décimales
    if ($currency_code === 'GNF') {
        $amount = number_format(round(floatval($amount)), 0, '', ' ');
    } else {
        $amount = ROUND_AMOUNT($amount);
    }

    if ($symbol_position == "left") {
        return $prefix . $currency_sym . " " . $amount;
    } else {
        return $prefix . $amount . " " . $currency_sym;
    }
}

function format_amount_string_exact($currency_code, $amount) {
    $currency_sym = get_currency_symbol_by_code($currency_code);
    $symbol_position = get_symbol_position_by_code($currency_code);

    if ($currency_code === 'GNF') {
        $amount = number_format(round(floatval($amount)), 0, '', ' ');
    } else {
        $amount = ROUND_AMOUNT($amount);
    }

    if ($symbol_position == "left") {
        return $currency_sym . " " . $amount;
    } else {
        return $amount . " " . $currency_sym;
    }
}

function build_orange_money_payment_note($breakdown) {
    return "Orange Money - Montant saisi : " . format_amount_string_exact($breakdown["method_currency"], $breakdown["input_amount"])
        . " | Frais : " . format_amount_string_exact($breakdown["method_currency"], $breakdown["fee_amount"])
        . " | Total paye : " . format_amount_string_exact($breakdown["method_currency"], $breakdown["gateway_amount"])
        . " | Credit solde : " . format_amount_string_exact($breakdown["base_currency"], $breakdown["credited_base_amount"]);
}

function priceFormat($price) {
    $parts = explode(".", $price);
    if (isset($parts[1]) && strlen($parts[1]) == 1) {
        return $price . "0";
    }
    return $price;
}
