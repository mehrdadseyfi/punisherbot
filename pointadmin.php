<?php
function pointadmin($text,$chat_id,$username){
    $user_id=$chat_id;
	        $db = Db::getInstance();
  	$member = $db->query("SELECT * FROM point WHERE id=:id", array(
        'id' => 1
    ));
			
        $state_p = $member[0][state];
		if($state_p==3){
        $db = Db::getInstance();
	
		$db->modify("UPDATE point SET state=:state WHERE id=:id", array(
            'state' => 0,
              'id' => 1
        ));     
	
		}
    if($text == 'دادن امتیاز' && $state_p == 0){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"شماره موبایل فردی که مبلغ را حساب می کند وارد نمایید",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE point SET state=:state WHERE id=:id", array(
            'state' => 1,
            'id' => 1,
        ));

        }elseif( $state_p == 1){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>" مدت زمان بازی کردن فرد را به دقیقه وارد نمایید",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE point SET mobile=:mobile,state=:state WHERE id=:id", array(
            'state' => 2,
			'mobile'=>$text,
            'id' => 1,
        ));

        }elseif($state_p == 2){
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"پایان",'reply_markup' => array(resize_keyboard =>true,
            "keyboard"=>array(

                array('منو اصلی'),
            )

        )));
        $db = Db::getInstance();
         $db->modify("UPDATE point SET point=:point,state=:state WHERE id=:id", array(
            'state' => 3,
			'point'=>$text,
            'id' => 1,
        ));
		$member = $db->query("SELECT * FROM point WHERE id=:id", array(
        'id' => 1
    ));
			
        $mobile = $member[0]['mobile'];
		$point_user = $member[0]['point'];
			$point=$db->query("SELECT * FROM sabtenam WHERE mobile=:mobile", array(
        'mobile' => $mobile
    ));
			$point_sum=$point[0]['point']+$point_user;
		$db->modify("UPDATE sabtenam SET point=:point  WHERE mobile=:mobile", array(
            'point' =>$point_sum,
            'mobile' => $mobile
        ));

    }
}
?>