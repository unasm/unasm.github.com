<?php
/**
*    @name:       ./curl.php
*    @author:     unasm<1264310280@qq.com>
*    @since :     2014-07-20 14:36:06
*/
function curl2($url , $post){
    $curl = curl_init();
    curl_setopt($curl , CURLOPT_URL, $url);
    //curl_setopt($curl , CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($curl , CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl , CURLOPT_CUSTOMREQUEST,'POST');

    $userAgent ='Mozilla/5.0 (X11; Linux x86_64) AppleWebit/537.36 ()HTML, like Gecko) Ubuntu Chromium/34.0.1847.116 Chrome/34.0.1847.116 Safari/537.36';
    curl_setopt($curl , CURLOPT_USERAGENT , $userAgent);
    curl_setopt($curl , CURLOPT_RETURNTRANSFER , 1);
    curl_setopt($curl , CURLOPT_POST, 1);
    //curl_setopt($curl , CURLOPT_HTTPHEADER , $header);
    curl_setopt($curl , CURLOPT_POSTFIELDS , $post);
    $data = curl_exec($curl);
    curl_close($curl);
    echo $data;
}

$post = array(
    'client_id' => "410943492",
    'client_secret' => "5fa05954154245442574a0a0eb38b217",
    'grant_type' => "authorization_code" ,
    'redirect_uri' => "http://127.0.0.4:8080" ,
    'code' => "8f7a8d324c18f4c15e2aa560df2587b6"
);
/*
$post['client_id'] = "410943492";
$post['client_secret'] = "5fa05954154245442574a0a0eb38b217";
$post['grant_type'] = "authorization_code";
//$post['redirect_uri'] = "http://apps.weibo.com/doujiamin";
$post['redirect_uri'] = "http://127.0.0.4:8080/";
//$post['code'] = "339049f58be134a0eb647fe9556008d3";
$post['code'] = "8f7a8d324c18f4c15e2aa560df2587b6";
 */
curl2("https://api.weibo.com/oauth2/access_token" , $post);
//curl2("http://127.0.0.3:8080/utils/get.php" , $post);
?>
