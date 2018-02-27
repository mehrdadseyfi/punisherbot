
<?php
require_once('db.php');
require_once('core.php');
$Authority = $_GET['Authority'];
$db = Db::getInstance();
$qustion_num = $db->query("SELECT * FROM product_transaction WHERE authority='".$Authority."'");
$chat_id=$qustion_num[0]['user_id'];
$MerchantID = '10b379f4-c907-11e7-b1cf-005056a205be';
$Amount = 20000; //Amount will be based on Toman


if ($_GET['Status'] == 'OK') {

$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

$result = $client->PaymentVerification(
[
'MerchantID' => $MerchantID,
'Authority' => $Authority,
'Amount' => $Amount,
]
);

$reference = $result->RefID;
if ($result->Status == 100) {
    $db = Db::getInstance();
$db->modify("UPDATE product_transaction SET reference=:reference,buy=:buy WHERE authority=:authority", array(
      'reference' => $reference,
      'authority' => $Authority,
    'buy'=>true,
    ));
$db->modify("UPDATE tour SET pay=:pay WHERE user_id=:user_id", array(
      'pay' => 1,
      'user_id' => $chat_id
    ));
    $start="$result->RefID";
    $qustion_num = $db->query("SELECT * FROM product_transaction WHERE authority='".$Authority."'");
    $chat_id=$qustion_num[0]['user_id'];
		$qustion_sabt = $db->query("SELECT * FROM sabtenam WHERE user_id='".$chat_id."'");
		$username=$qustion_sabt[0]['username'];
		$name=$qustion_sabt[0]['first_name'];
		$mobile=$qustion_sabt[0]['mobile'];

        MessageRequestJson("sendMessage", array('chat_id' => $chat_id, 'text' => "ثبت نام شما با موفقیت انجام شده است"."\n"."کد رهگیری شما"."$reference"."\n"."شماره موبایل شما"."$mobile"."\n"."در صورت داشتن هر گونه سوال با ایدی زیر در ارتباط باشید"."\n"."@mehradsy", 'reply_markup' => array(resize_keyboard => true,

            "keyboard" => array(

                array('منو اصلی')


            )

        )));
        echo "<html>
<head>
<title>خرید شما با موفقیت انجام شد</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
<style type=\"text/css\">
.style3 {
	border: 1px solid #D8D8D8;
	font-family:Tahoma
}
.style4 {
	font-size: x-large;
}
.style5 {
	font-size: large;
}
</style>
</head>
<body bgcolor=\"#FFFFFF\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" style=\"font-family: Arial; color: #808080\">
<!-- ImageReady Slices (13 copy.psd) -->
<!-- End ImageReady Slices -->
<table style=\"width: 768px\" cellspacing=\"0\" cellpadding=\"0\" class=\"style6\" align=\"center\" dir=\"rtl\">
	<tr>
		<td>&nbsp;
</td>

	</tr>
	<tr>
		<td class=\"style3\" style=\"border-style: dashed\">
		<table style=\"width: 100%\">
			<tr>
				<td>
									<span>
										<img alt=\"Co21\" src='http://dl.co21.ir/co21bot/logo.jpg'  /></span></td>

				<td style=\"width: 100%; height: 100%\" class=\"style4\">به پانیشر گیم کلاب خوش آمدید</td>
			</tr>
		</table>
		<p style=\"padding: 0px 15px 15px 15px; \" class=\"style4\">خرید شما با موفقیت انجام شد</p>
		<p style=\"padding: 0px 15px 15px 15px; font-size: large\">کاربر گرامی، <br><br>

		<br>
	
		<p>کد رهگیری شما</p>
	<p>$start</p>
		</ul>
		<a href=\"http://www.co21.ir\" ><p style=\"padding: 0px 15px 15px 15px; font-size: x-small;color:#FF3300\">پانیشر گیم کلاب</p></a>
		</td>

	</tr>
	</table>
   
</body>
</html>

";

} else {
echo 'Transaction failed. Status:'.$result->Status;
}
} else {
	$db = Db::getInstance();

echo 'Transaction canceled by user';

}
?>
