<?php
 
if (!isset($_POST['HASH']) || !empty($_POST['HASH'])) {
 
    //begin HASH verification
    $arParams = $_POST;
    unset($arParams['HASH']);
 
    $hashString = "";
    foreach ($arParams as $val) {
        $hashString .= strlen($val) . $val;
    }
 
    $secretKey = 'SECRET_KEY';
    $expectedHash = hash_hmac("md5", $hashString, $secretKey);
    if ($expectedHash != $_POST["HASH"]) {
        echo "FAILED. Hash mismatch";
        die;
    }
    //end hash verification
     
    //Use the information below to match against your database record.
    $payuTranReference = $_POST['REFNO'];
    $amount = $_POST['AMOUNT'];
    $currency = $_POST['CURRENCY'];
    $installments_no = $_POST['INSTALLMENTS_NO'];
 
    if ($_POST['STATUS'] == "SUCCESS") {
        //Update status of the transaction in your database.
        echo "SUCCESS [PayU reference number: " . $payuTranReference . "]";
    } else {
        echo "FAILED ". $_POST['RETURN_MESSAGE'] ."[". $_POST['RETURN_CODE'] ."]";
        echo " [PayU reference number: " . $payuTranReference . "]";
    }
} else {
    echo "FAILED. Hash missing";
}
?>