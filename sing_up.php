<?php
function sign_up($text,$chat_id,$username)
{
    $user_id=$chat_id;
    $db = Db::getInstance();
    $member = $db->query("SELECT * FROM sabtenam WHERE user_id=:user_id", array(
        'user_id' => $user_id,
    ));
			
    if(count($member)== 1){
        $state = $member[0][state];
    }
    else{
        $db = Db::getInstance();
        $db->query("INSERT INTO sabtenam (user_id,username) VALUES ('".$user_id."','".$username."')"); 
        $state = 0;
    }


    if($text == 'ثبت نام'){

        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"خوش آمدید 😇
برای ثبت نام بر روی دکمه ثبت نام در Punisher club کلیک نمایید👇🏻👇🏻👇🏻", 'reply_markup' => array(resize_keyboard =>true,
            "keyboard"=>array(
                array('ثبت نام در Punisher club','منو اصلی')
            )
        )));
    }
    else if($text == 'ثبت نام در Punisher club' && $state == 0){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"نام و نام خانوادگی خود را وارد کنید و ارسال نمایید",'reply_markup' => array("remove_keyboard"=>true)));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET state=:state WHERE user_id=:user_id", array(
            'state' => 1,
            'user_id' => $user_id,
        ));
    }
    else if($state == 1){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"نام مستعار مد نظر خود در Punisher club  را وارد کنید و ارسال نمایید"));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET first_name=:first_name,state=:state WHERE user_id=:user_id", array(
            'first_name' => $text,
            'state' => 2,
            'user_id' => $user_id,
        ));

    }
    else if($state == 2){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"سن خود را وارد کنید و ارسال نمایید"));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET user_club=:user_club,state=:state WHERE user_id=:user_id", array(
            'user_club' => $text,
            'state' => 3,
            'user_id' => $user_id,
        ));

    }
    else if($state == 3){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"شماره تماس خود را وارد کنید و ارسال نمایید"."\n"."شماره خود را به صورت 09121234567 وارد کنید"));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET sen=:sen,state=:state WHERE user_id=:user_id", array(
            'sen' => $text,
            'state' => 4,
            'user_id' => $user_id,
        ));

    }   else if($state == 4){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>"کد معرف خود را وارد نمایید:
		تاهم شما و هم معرف شما از تخفیفات ما برخوردار شوند"
));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET mobile=:mobile,state=:state WHERE user_id=:user_id", array(
            'mobile' => $text,
            'state' => 5,
            'user_id' => $user_id,
        ));

    }
    else if($state == 5){
        MessageRequestJson("sendMessage", array('chat_id' =>$user_id,'text'=>" بازی مورد علاقه خود بین PES  و یا FIFA   را وارد کنید.(این اطلاعات برای این است که در صورت برگزاری مسابقات هر کدامیک به شما اطلاع بدهیم.در صورت علاقه به هر دو نام هر دو را بنویسید)"));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET m_id=:m_id,state=:state WHERE user_id=:user_id", array(
            'm_id' => $text,
            'state' => 6,
            'user_id' => $user_id,
        )); 
		
		$point=$db->query("SELECT * FROM sabtenam WHERE user_id=:user_id", array(
        'user_id' => $text
    ));
			$point_sum=$point[0]['point']+60;
		$db->modify("UPDATE sabtenam SET point=:point  WHERE user_id=:user_id", array(
            'point' =>$point_sum,
            'user_id' => $text
        ));
		

    }
    else if($state == 6){
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"کد معرف شما .این کد را به دوستان خود بدهید تا با ثبت نام انها شما از تخفیفات ما برخوردار شوید"."\n"."$user_id"."\n"."پایان",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('منو اصلی')

            )

        )));
        $db = Db::getInstance();
        $db->modify("UPDATE sabtenam SET lovegame=:lovegame,state=:state,point=:point,comp=:comp WHERE user_id=:user_id", array(
            'lovegame' => $text,
            'state' => 0,
            'comp'=>1,
            'user_id' => $user_id,
			'point'=>0
        ));  
   
		

    }else if($text == 'کد معرف من' ){
        MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"$user_id",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('منو اصلی')

            )

        )));
       

    }else if($text == 'امتیازات شما' ){
		$point=$db->query("SELECT * FROM sabtenam WHERE user_id=:user_id", array(
        'user_id' => $user_id
    )); 
			$point_su=$point[0]['point'];
	
	   MessageRequestJson("sendMessage", array('chat_id' =>$chat_id,'text'=>"$point_su",'reply_markup' => array(resize_keyboard =>true,

            "keyboard"=>array(

                array('منو اصلی')

            )

        )));
       

    }

}
?>