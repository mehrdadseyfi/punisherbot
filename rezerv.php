<?php
function rezerv($text,$chat_id,$username){
    $user_id=$chat_id;
    $db = Db::getInstance();
    $member = $db->query("SELECT * FROM rezerv WHERE user_id=:user_id", array(
        'user_id' => $user_id,
    ));
    $state_re = $member[0][state];

    if(count($member)== 1){
        $state_re = $member[0][state];
    }
    else{
        $db = Db::getInstance();
        $db->query("INSERT INTO rezerv (user_id,username) VALUES ('".$user_id."','".$username."')");
        $state_re = 0;
    }
    if($text == 'رزرو میز' && $state_re == 0){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"ساعت و تاریخ و شماره میز خود را وارد نمایید تا ادمین تاییدیه را به شما بدهد",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE rezerv SET state=:state WHERE user_id=:user_id", array(
            'state' => 1,
            'user_id' => $user_id,
        ));

        }elseif($text == 'رزرو میز' && $state_re == 2){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"شما قبلا میز رزرو کرده اید برای اصلاح رزرو قبلی بروی دکمه زیر کلید نمایید",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('رزرو میز'),

            )

        )));
        $db = Db::getInstance();
        $db->modify("UPDATE rezerv SET state=:state WHERE user_id=:user_id", array(
            'state' => 0,
            'user_id' => $user_id,
        ));

        }elseif($state_re == 1){
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"پایان",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('منو اصلی'),

            )

        )));
        MessageRequestJson("sendMessage", array('chat_id' =>'@punisher_rezerv','text'=>"این فرد این میز را رزرو کرده است"."\n"."@"."$username"."\n"."$text"."\n"."لطفا در صورت خالی بودن میز در این زمان و تاریخ تاییدیه را به فرد بدهید"));
        $db = Db::getInstance();
        $db->modify("UPDATE rezerv SET  text=:text,state=:state ,comp=:comp WHERE user_id=:user_id", array(
            'text' => $text,
            'state' => 2,
            'comp'=>1,
            'user_id' => $user_id,
        ));

    }
}
?>