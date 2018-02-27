<?php
function timeadmin($text,$chat_id,$username){
    $user_id=$chat_id;
	        $db = Db::getInstance();
  	$member = $db->query("SELECT * FROM time WHERE id=:id", array(
        'id' => 1
    ));
			
        $state_p = $member[0][state];
		if($state_p==3){
        $db = Db::getInstance();
	
		$db->modify("UPDATE time SET state=:state WHERE id=:id", array(
            'state' => 0,
              'id' => 1
        ));     
	
		}
    if($text == 'اضافه کردن ساعت کاری' && $state_p == 0){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>" ساعت باز شدن مغازه در امروز را وارد کنید",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE time SET state=:state WHERE id=:id", array(
            'state' => 1,
            'id' => 1,
        ));

        }elseif( $state_p == 1){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>" ساعت بسته شدن مغازه در امروز را وارد کنید",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE time SET time=:time,state=:state WHERE id=:id", array(
            'state' => 2,
			'time'=>$text,
            'id' => 1,
        ));

        }elseif($state_p == 2){
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"پایان",'reply_markup' => array(resize_keyboard =>true,
            "keyboard"=>array(

                array('منو اصلی'),
            )

        )));
        $db = Db::getInstance();
         $db->modify("UPDATE time SET time_down=:time_down,state=:state WHERE id=:id", array(
            'state' => 3,
			'time_down'=>$text,
            'id' => 1,
        ));
	

    }
}
?>