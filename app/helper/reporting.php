<?php
// [PHASE 2] ToutLike — Module rapports financiers (extrait de data_control.php)

function dayPayments($day, $ay, $year, $extra = null) {
    global $conn;
    $where = "";
    if (is_array($extra["methods"] ?? null) && count($extra["methods"])) {
        $where = "&& ( ";
        foreach ($extra["methods"] as $method) { $where .= "payment_method='$method' || "; }
        $where = substr($where, 0, -3) . ") ";
    }
    $first = "$year-$ay-$day 00:00:00";
    $last = "$year-$ay-$day 23:59:59";
    $row = $conn->query("SELECT SUM(payment_amount) FROM payments WHERE payment_delivery='2' && payment_status='3' && payment_create_date<='$last' && payment_create_date>='$first' $where")->fetch(PDO::FETCH_ASSOC);
    return number_format($row['SUM(payment_amount)'], 2, ".", ",");
}

function monthPayments($ay, $year, $extra = null) {
    global $conn;
    $where = "";
    if (is_array($extra["methods"] ?? null) && count($extra["methods"])) {
        $where = "&& ( ";
        foreach ($extra["methods"] as $method) { $where .= "payment_method='$method' || "; }
        $where = substr($where, 0, -3) . ") ";
    }
    $first = "$year-$ay-1 00:00:00";
    $last = "$year-$ay-31 23:59:59";
    $row = $conn->query("SELECT SUM(payment_amount) FROM payments WHERE payment_delivery='2' && payment_status='3' && payment_create_date<='$last' && payment_create_date>='$first' $where")->fetch(PDO::FETCH_ASSOC);
    return number_format($row['SUM(payment_amount)'], 2, ".", ",");
}

function _build_order_where($extra) {
    $where = "";
    if (is_array($extra["status"] ?? null) && count($extra["status"])) {
        $where = "&& ( ";
        if (in_array("cron", $extra["status"])) $where .= "order_detail='cronpending' || ";
        if (in_array("fail", $extra["status"])) $where .= "order_error!='-' || ";
        foreach ($extra["status"] as $statu) {
            if ($statu != "cron" && $statu != "fail") $where .= "order_status='$statu' || ";
        }
        $where = substr($where, 0, -3) . ") ";
    }
    if (is_array($_POST["services"] ?? null) && count($_POST["services"])) {
        $where .= "&& ( ";
        foreach ($extra["services"] as $service) { $where .= " service_id='$service' || "; }
        $where = substr($where, 0, -3) . ") ";
    }
    return $where;
}

function dayCharge($day, $ay, $year, $extra = null) {
    global $conn;
    $where = _build_order_where($extra);
    $first = "$year-$ay-$day 00:00:00";
    $last = "$year-$ay-$day 23:59:59";
    $row = $conn->prepare("SELECT SUM(order_charge) FROM orders WHERE order_create<='$last' && order_create>='$first' && dripfeed='1' && subscriptions_type='1' $where");
    $row->execute();
    return number_format($row->fetch(PDO::FETCH_ASSOC)['SUM(order_charge)'], 2, ".", ",");
}

function monthCharge($month, $year, $extra = null) {
    global $conn;
    $where = _build_order_where($extra);
    $first = "$year-$month-1 00:00:00";
    $last = "$year-$month-31 23:59:59";
    $row = $conn->prepare("SELECT SUM(order_charge) FROM orders WHERE order_create<='$last' && order_create>='$first' && dripfeed='1' && subscriptions_type='1' $where");
    $row->execute();
    return number_format($row->fetch(PDO::FETCH_ASSOC)['SUM(order_charge)'], 2, ".", ",");
}

function monthChargeNet($month, $year, $extra = null) {
    global $conn;
    $where = _build_order_where($extra);
    $first = "$year-$month-1 00:00:00";
    $last = "$year-$month-31 23:59:59";
    $row = $conn->prepare("SELECT SUM(order_profit) FROM orders WHERE order_create<='$last' && order_create>='$first' && dripfeed='1' && subscriptions_type='1' && order_api!='0' $where");
    $row->execute();
    $row2 = $conn->prepare("SELECT SUM(order_charge) FROM orders WHERE order_create<='$last' && order_create>='$first' && dripfeed='1' && subscriptions_type='1' $where");
    $row2->execute();
    $charge = $row2->fetch(PDO::FETCH_ASSOC)['SUM(order_charge)'] - $row->fetch(PDO::FETCH_ASSOC)['SUM(order_profit)'];
    return number_format($charge, 2, ".", ",");
}

function dayOrders($day, $month, $year, $extra = null) {
    global $conn;
    $where = _build_order_where($extra);
    $first = "$year-$month-$day 00:00:00";
    $last = "$year-$month-$day 23:59:59";
    return $conn->query("SELECT order_id FROM orders WHERE order_create<='$last' && order_create>='$first' $where")->rowCount();
}

function monthOrders($month, $year, $extra = null) {
    global $conn;
    $where = _build_order_where($extra);
    $first = "$year-$month-1 00:00:00";
    $last = "$year-$month-31 23:59:59";
    return $conn->query("SELECT order_id FROM orders WHERE order_create<='$last' && order_create>='$first' $where")->rowCount();
}
