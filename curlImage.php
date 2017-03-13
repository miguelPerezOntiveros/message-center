<?php 
$ch = curl_init();


header("Content-Type: image/jpeg");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');


$url = 'http://10.13.9.199:9090/ws/rest/messages-center/thread/1487646019590/message/1489169993138/attachment/diagram.png';
curl_setopt($ch, CURLOPT_URL, $url);


$res = curl_exec($ch);
curl_close($ch) ;
echo $res;




 ?>