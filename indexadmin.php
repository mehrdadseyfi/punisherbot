<?php
require_once('coreadmin.php');
require_once('db.php');
require_once('timeadmin.php');
require_once('pointadmin.php');


$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chat_id = $update["message"]['chat']['id'];
$text = $update["message"]['text'];
$message_id = $update["message"]['message_id'];
$username=$update["message"]['chat']["username"];
$user_id=$chat_id;
$db = Db::getInstance();


/////
////anger con db
////
//////////////
/// ////////////
/// //////////////main page
/// ////////////////
///
///
///
pointadmin($text,$chat_id,$username);
timeadmin($text,$chat_id,$username);

//give file id json
$res =MessageRequestJson("getChatMember", array('chat_id' =>'@coaches21','user_id'=>$chat_id));

$res = json_decode($res, true);

$member_result = $res['ok'];

$member_status = $res['result']['status'];
if($text=="/start"||$text=="منو اصلی") {

    if ($user_id=='55446143' ||$user_id=='181500340' ||$user_id=='55446143' ) {
        $start="از بین گزینه های زیر یک گزینه را انتخاب نمایید";
        MessageRequestJson("sendMessage", array('chat_id' => $chat_id, 'text' => $start, 'reply_markup' => array(resize_keyboard => true,


            "keyboard" => array(

                array('دادن امتیاز',"ثبت نام نموده در مسابقات"),
               
                array('اضافه کردن ساعت کاری',"ثبت نام کرده در ربات"),
                array("ثبت نام کرده در مسابقات بدون پرداخت")
              

            )

        )));
    } else{
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"شما از ادمین ها punisher  نیستید",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('منو اصلی')
            )

        )));
    }

       

    }elseif ($text=="ثبت نام نموده در مسابقات"){
    $db = Db::getInstance();

    $member_t=$db->query("SELECT sabtenam.first_name, sabtenam.mobile,tour.fifa FROM tour INNER JOIN sabtenam ON tour.user_id = sabtenam.user_id where (pes=1 OR fifa=1) AND pay=1");

    $user_tour="";
    $user_tour_mobile="";
    for ($x = 0; $x <= count($member_t); $x++) {
       if($member_t[$x]['fifa']==1) {
           $user_tour = "f " . $user_tour . "\n" . $member_t[$x]['first_name'] . " \n " . $member_t[$x]['mobile'] . "\n" . "--------------------";
       }else{
           $user_tour = "p " . $user_tour . "\n" . $member_t[$x]['first_name'] . " \n " . $member_t[$x]['mobile'] . "\n" . "--------------------";

       }
    }
    MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>$user_tour."\n".$user_tour_mobile,'reply_markup' => array(resize_keyboard =>true,

        "keyboard"=>array(

            array('منو اصلی')
        )

    )));

}elseif ($text=="ثبت نام کرده در مسابقات بدون پرداخت"){
    $db = Db::getInstance();

    $member_t=$db->query("SELECT sabtenam.first_name, sabtenam.mobile,tour.fifa FROM tour INNER JOIN sabtenam ON tour.user_id = sabtenam.user_id where (pes=1 OR fifa=1) AND pay is null ");

    $user_tour="";
    $user_tour_mobile="";
    for ($x = 0; $x <= count($member_t); $x++) {
       if($member_t[$x]['fifa']==1) {
           $user_tour = "f " . $user_tour . "\n" . $member_t[$x]['first_name'] . " \n " . $member_t[$x]['mobile'] . "\n" . "--------------------";
       }else{
           $user_tour = "p " . $user_tour . "\n" . $member_t[$x]['first_name'] . " \n " . $member_t[$x]['mobile'] . "\n" . "--------------------";

       }
    }
    MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>$user_tour."\n".$user_tour_mobile,'reply_markup' => array(resize_keyboard =>true,

        "keyboard"=>array(

            array('منو اصلی')
        )

    )));

}elseif ($text=="ثبت نام کرده در ربات"){
    $db = Db::getInstance();

    $member_t=$db->query("SELECT `username`,`first_name`,`mobile` FROM `sabtenam` WHERE `comp`=1; ");

    $user_tour="";
    $user_tour_mobile="";
    for ($x = 0; $x <= count($member_t); $x++) {

           $user_tour = "f " . $user_tour . "\n" . $member_t[$x]['first_name'] . " \n " . $member_t[$x]['mobile'] . "\n" ."@". $member_t[$x]['username'] . "\n" . "--------------------";



    }
    MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>$user_tour."\n".$user_tour_mobile,'reply_markup' => array(resize_keyboard =>true,

        "keyboard"=>array(

            array('منو اصلی')
        )

    )));

}
?>