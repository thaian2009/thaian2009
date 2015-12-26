<?php header("Access-Control-Allow-Origin: *"); ?>
<?
ini_set('max_execution_time', 0);
ini_set('user_agent','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');

$url= $_GET["url"];
$ses=$_GET["ses"];
$ngay=$_GET["ngay"];
if(strlen($ses) >= 1)
{
$url = 'http://'.$url.'/main.php?ses='.$ses.'&id=ch_topic_h&uid=199085';
$fields = array(
'text' => urlencode($ngay)
);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIE, '__qca=P0-339331677-1435325942989; Menu=on; v=3; ses='.$ses.'; Style=Main; _gat=1; _ga=GA1.2.829838804.1435661085; __utmmobile=0x0f151e222f6d6f81');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
curl_setopt($ch, CURLOPT_FAILONERROR, 0);
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
$result = curl_exec($ch);
curl_close($ch);

}

?>
