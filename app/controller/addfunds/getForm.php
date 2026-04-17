<?php 
if (!defined('ADDFUNDS')) {
    http_response_code(404);
    die();
}

$amountField = '<div class="form-group">
<label class="control-label">Montant</label>
<input type="number" id="paymentAmount" class="form-control" name="payment_amount" step="0.01" placeholder="Entrez le montant" required />
</div>';
$orangeMoneyAmountField = '<div class="om-amount-wrap">
<input type="number" id="paymentAmount" class="form-control" name="payment_amount" step="1" min="1" placeholder="Ex : 20000" required />
<span class="om-amount-unit">GNF</span>
</div>';
$feeField = '<div id="fee_fields"></div>';
$paymentBtn = '<button type="submit" class="btn btn-block btn-primary">[text]</button>';
$orangeMoneyPaymentBtn = '<button type="submit" class="om-submit">Payer via Orange Money</button>';

if($selectedMethod == 1){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 2){
    $formData .= '<div class="form-group">
    <label class="control-label">Order ID</label>
    <input type="text" class="form-control" name="payTMOrderId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 3){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 4){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 5){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 6){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 7){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="PhonePeTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 8){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="EasypaisaTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 9){
    $formData .= '<div class="form-group">
    <label class="control-label">Transaction ID</label>
    <input type="text" class="form-control" name="JazzcashTransactionId"  required />
    </div>';
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Verify Transaction");
}

if($selectedMethod == 10){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}


if($selectedMethod == 11){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 12){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 13){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 14){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 15){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 16){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 17){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if($selectedMethod == 18){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}

if ($selectedMethod == 19) {
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn, "Pay");
}

if($selectedMethod == 20){
    $formData .= $amountField;
    $formData .= $feeField;
    $formData .= replaceText($paymentBtn,"Pay");
}
if ($selectedMethod == 21) {
    $formData .= $orangeMoneyAmountField;
    $formData .= $feeField;
    $formData .= $orangeMoneyPaymentBtn;
}
?>