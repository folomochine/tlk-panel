<?php
if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}

if ($admin["access"]["payments"] != 1) {
    header("Location:" . site_url("admin"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["action"] == "getData") {
        $clients = $conn->prepare("SELECT client_id, username FROM clients");
        $clients->execute();
        $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
        $clients = array_group_by($clients, "client_id");
        $payments = $conn->prepare("SELECT payment_id, client_id, client_balance, payment_amount, payment_method, payment_status, payment_delivery, payment_note, payment_mode, payment_extra, payment_create_date, t_id FROM payments ORDER BY payment_id DESC");
        $payments->execute();
        $payments = $payments->fetchAll(PDO::FETCH_ASSOC);
        $methods = $conn->prepare("SELECT methodId,methodVisibleName,methodFee,methodCurrency FROM paymentmethods");
        $methods->execute();
        $methods = $methods->fetchAll(PDO::FETCH_ASSOC);
        $methods = array_group_by($methods, "methodId");
        $gnfRate = $conn->prepare("SELECT methodExtras FROM paymentmethods WHERE methodId = 21");
        $gnfRate->execute();
        $gnfData = $gnfRate->fetch(PDO::FETCH_ASSOC);
        $gnfExtras = json_decode($gnfData["methodExtras"], true);
        $gnfRate = floatval($gnfExtras["exchange_rate"]);
        if ($gnfRate <= 0) { $gnfRate = 1; }
        $PAYMENTS = [];
        for ($i = 0; $i < count($payments); $i++) {
            if ($payments[$i]["payment_status"] == 1 && $payments[$i]["payment_delivery"] == 1) {
                $paymentStatus = '<span class="badge" style="background-color:#f59e0b;color:#1a1a2e;font-weight:600;padding:5px 12px;border-radius:20px;">En attente</span>';
            } elseif ($payments[$i]["payment_status"] == 3 && $payments[$i]["payment_delivery"] == 2) {
                $paymentStatus = '<span class="badge" style="background-color:#10b981;color:#fff;font-weight:600;padding:5px 12px;border-radius:20px;">Complete</span>';
            } elseif ($payments[$i]["payment_status"] == 2 && $payments[$i]["payment_delivery"] == 2) {
                $paymentStatus = '<span class="badge" style="background-color:#ef4444;color:#fff;font-weight:600;padding:5px 12px;border-radius:20px;">Echoue</span>';
            } else {
                $paymentStatus = '<span class="badge" style="background-color:#6b7280;color:#fff;font-weight:600;padding:5px 12px;border-radius:20px;">En attente</span>';
            }
            $pm = $payments[$i];
            $isManual = (intval($pm["payment_method"]) === 0 || strtolower($pm["payment_mode"]) === "manual");
            if (!$isManual) {
                $methodConfig = $methods[$pm["payment_method"]][0];
            }
            $displayAmount = number_format($pm["payment_amount"] * $gnfRate, 0, '.', ' ');
            $methodName = $isManual ? "Manuel" : $methodConfig["methodVisibleName"];
            if (!$isManual && intval($pm["payment_method"]) === 21) {
                $orangeMoneyBreakdown = get_orange_money_payment_breakdown($pm, $methodConfig, $currencies_array, $settings);
                $displayAmount = format_amount_string_exact($methodConfig["methodCurrency"], $orangeMoneyBreakdown["input_amount"]) . ' (' . format_amount_string_exact($settings["site_base_currency"], $orangeMoneyBreakdown["credited_base_amount"]) . ')';
            }
            $PAYMENTS[] = [
                "id" => $pm["payment_id"],
                "cid" => $pm["client_id"],
                "username" => $clients[$pm["client_id"]][0]["username"],
                "method" => $methodName,
                "user_balance" => number_format($pm["client_balance"], 0, '.', ' '),
                "amount" => $displayAmount,
                "status" => $paymentStatus,
                "mode" => $pm["payment_mode"],
                "extra" => $pm["payment_extra"],
                "created_at" => date("m-d-Y h:i A", strtotime($pm["payment_create_date"]))
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($PAYMENTS);
        exit;
    }
    if ($_GET["action"] == "add_remove_balance") {
        $form  = '<form method="POST" action="admin/fund-add-history/manage-funds" class="fah-form">';

        // Intro banner
        $form .= '<div class="fah-banner">';
        $form .= '<div class="fah-banner-ico"><i class="fa fa-coins"></i></div>';
        $form .= '<div><div class="fah-banner-title">Ajustement manuel du solde</div><div class="fah-banner-sub">Les montants sont en GNF (conversion auto vers la devise interne).</div></div>';
        $form .= '</div>';

        $form .= '<div class="fah-row">';
        $form .= '<div class="form-group fah-field"><label class="form-label"><i class="fa fa-user"></i> Nom d\'utilisateur</label>
<div class="fah-input-wrap"><input type="text" name="username" class="form-control" placeholder="Ex : client123" required/></div></div>';

        $form .= '<div class="form-group fah-field"><label class="form-label"><i class="fa fa-money-bill-wave"></i> Montant (GNF)</label>
<div class="fah-input-wrap"><input type="number" name="amount" class="form-control" step="1" min="1" required placeholder="Ex : 10000"/><span class="fah-suffix">GNF</span></div></div>';
        $form .= '</div>';

        $form .= '<div class="form-group"><label class="form-label"><i class="fa fa-exchange-alt"></i> Action</label>
<div class="fah-toggle">'
            . '<label class="fah-toggle-opt"><input type="radio" name="action" value="add" checked><span><i class="fa fa-plus-circle"></i> Ajouter au solde</span></label>'
            . '<label class="fah-toggle-opt"><input type="radio" name="action" value="deduct"><span><i class="fa fa-minus-circle"></i> Déduire du solde</span></label>'
            . '</div></div>';

        $form .= '<div class="form-group"><label class="form-label"><i class="fa fa-hashtag"></i> Référence (optionnel)</label>
<input type="text" name="orderId" class="form-control" placeholder="Numéro de transaction, note interne…"/></div>';

        $form .= '<div class="custom-modal-footer">'
            . '<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>'
            . '<button type="submit" data-loading-text="Envoi..." class="btn btn-primary"><i class="fa fa-check"></i> Appliquer</button>'
            . '</div></form>';
        $response = [
            "success" => true,
            "content" => $form
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }



}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"]));
    $amount = floatval($_POST["amount"]);
    $action = $_POST["action"];
    $orderId = htmlspecialchars($_POST["orderId"]);

    $client = $conn->prepare("SELECT client_id, balance FROM clients WHERE username=:username");
    $client->execute([
        "username" => $username
    ]);
    $client = $client->fetch(PDO::FETCH_ASSOC);

    $rateQuery = $conn->prepare("SELECT methodExtras FROM paymentmethods WHERE methodId = 21");
    $rateQuery->execute();
    $rateData = $rateQuery->fetch(PDO::FETCH_ASSOC);
    $rateExtras = json_decode($rateData["methodExtras"], true);
    $exchangeRate = floatval($rateExtras["exchange_rate"]);
    if ($exchangeRate <= 0) { $exchangeRate = 1; }
    $baseAmount = $amount / $exchangeRate;

    if ($action == "add") {
        $insert = $conn->prepare("INSERT INTO payments SET client_id=:cid, client_balance=:balance, payment_amount=:amount, payment_method=:method, payment_status=:status, payment_delivery=:delivery, payment_mode=:mode, payment_create_date=:date, payment_ip=:ip, payment_extra=:extra");
        $insert->execute([
            "cid" => $client["client_id"],
            "balance" => $client["balance"] + $baseAmount,
            "amount" => +$baseAmount,
            "method" => 0,
            "status" => 3,
            "delivery" => 2,
            "mode" => "Manual",
            "date" => date("Y-m-d H:i:s"),
            "ip" => GetIP(),
            "extra" => $orderId
        ]);
        $update = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id");
        $update->execute([
            "id" => $client["client_id"],
            "balance" => $client["balance"] + $baseAmount
        ]);
        success_response_exit("Record added and amount added to balance.");
    }
    if ($action == "deduct") {
        $insert = $conn->prepare("INSERT INTO payments SET client_id=:cid, client_balance=:balance, payment_amount=:amount, payment_method=:method, payment_status=:status, payment_delivery=:delivery, payment_mode=:mode, payment_create_date=:date, payment_ip=:ip, payment_extra=:extra");
        $insert->execute([
            "cid" => $client["client_id"],
            "balance" => $client["balance"] - $baseAmount,
            "amount" => -$baseAmount,
            "method" => 0,
            "status" => 3,
            "delivery" => 2,
            "mode" => "Manual",
        "date" => date("Y-m-d H:i:s"),
            "ip" => GetIP(),
            "extra" => $orderId
        ]);
        $update = $conn->prepare("UPDATE clients SET balance=:balance WHERE client_id=:id");
        $update->execute([
            "id" => $client["client_id"],
            "balance" => $client["balance"] - $baseAmount
        ]);
        success_response_exit("Record added and amount deducted from balance.");
    }

}

require admin_view("fund-add-history");
?>