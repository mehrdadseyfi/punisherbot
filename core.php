<?php
define('BOT_TOKEN','498215540:AAH3EAPYGL1d1o1kmkJsOc7Zok99ZGMi3-w');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('ADMIN_ID', '445580996');


function MessageRequestJson($method, $parameters) {

    if (!$parameters) {
        $parameters = array();
    }

    $parameters["method"] = $method;

    $handle = curl_init(API_URL);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    $result = curl_exec($handle);
    return $result;
}


function baseUrl(){
    return 'https://moein-khosravi.ir/';
}


function randomImage(){
    $images = glob("images/*.{jpg,png}",GLOB_BRACE);
    $randomImage = $images[array_rand($images)];
    return baseUrl()."faranesh/f/".$randomImage;
}


?>