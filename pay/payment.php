<?php
require_once('db.php');

if(!isset($_GET["user"])){
        echo "error";
        exit();
}

$MerchantID = '10b379f4-c907-11e7-b1cf-005056a205be'; //Required
$Amount = $_GET['pay']; //Amount will be based on Toman - Required
$Description = $_GET['Des']; // Required
$CallbackURL = 'http://mehrdadseyfi.ir/pay/verify.php'; // Required
$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
$result = $client->PaymentRequest(
[
'MerchantID' => $MerchantID,
'Amount' => $Amount,
'Description' => $Description,
'Email' => $Email,
'Mobile' => $Mobile,
'CallbackURL' => $CallbackURL,
]
);

$authority =$result->Authority ;
$userId = $_GET["user"];
$db = Db::getInstance();
$jok=$db->query("INSERT INTO product_transaction (user_id, authority) VALUES (:user_id, :authority)", array(
      'user_id' => $userId,
      'authority' => $authority
    ));




//Redirect to URL You can do it also by creating a form
if ($result->Status == 100) {
    $url='https://www.zarinpal.com/pg/StartPay/'.$authority;
    echo '<script type="text/javascript">';
    echo 'window.location.href="'.$url.'";';
    echo '</script>';
    echo '<noscript>';
    echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
    echo '</noscript>'; exit;
//برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
//Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
} else {
echo'ERR: '.$result->Status;
}
?>