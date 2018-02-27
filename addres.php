<?php
function addres($text,$chat_id)
{
	if($text=='📡آدرس  ما'){
		  MessageRequestJson("sendphoto", array('chat_id' => $chat_id, 'photo' => "https://mehrdadseyfi.ir/punisherbot/addres.jpg",'caption'=>"#آدرس
شهر زیبا _ بلوار تعاون _ آلاله شرقی _ انتهای عدالت _ هفتم غربی", 'reply_markup' => array(resize_keyboard => true,


            "keyboard" => array(

                array('ثبت نام در مسابقات 🏆', 'کد معرف من'),
                array('امتیازات شما', 'رزرو میز'),
                array('ساعت کاری امروز ما'),
                array('📡آدرس  ما')

            )

        )));
		
	}
}

?>