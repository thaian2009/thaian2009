<?php header("Access-Control-Allow-Origin: *"); ?>
<?
ini_set('max_execution_time', 0);
ini_set('user_agent','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');

$url= $_GET["url"];
$ses=$_GET["ses"];
$lenh=$_GET["lenh"];
$uid=$_GET["uid"];
$reason=$_GET["reason"];
$bantime=$_GET["bantime"];
$lvl=$_GET["lvl"];
$plus=$_GET["plus"];
$act=$_GET["act"];

if(strlen($ses) >= 1)
{
$kurl = 'http://'.$url.'/main.php?ses='.$ses.'&id=ch_topic_h&uid=195192&uuid='.$uid.'&style=Main';
$url = 'http://'.$url.'/admin.php?id='.$lenh.'&ses='.$ses.'&uid='.$uid;
if($lenh == 'ch_lvl'){
$fields = array(
'reason' => urlencode($reason),
'lvl' => urlencode($lvl),
'id' => urlencode($lenh)
);
$kact="đổi level thành " . $lvl;
}

if($lenh =='ch_plus'){
$fields = array(
'plus' => urlencode($plus),
'act' => urlencode($act),
'reason' => urlencode($reason),
'id' => urlencode($lenh)
);
if ($act == '-')
{
$kact="trừ " . $plus . " điểm thưởng";
}
else
{
$kact="cộng " . $plus . " điểm thưởng";
}
}

if($lenh == 'ban'){
$fields = array(
'reason' => urlencode($reason),
'bantime' => urlencode($bantime),
'id' => urlencode($lenh)
);
$kact="nhốt " . $bantime . " phút";
}

if($lenh == 'unreg'){
$fields = array(
'reason' => urlencode($reason),
'content' => urlencode("1"),
'id' => urlencode($lenh)
);
$kact="xóa nick";
}

$kfields = array(
'text' => urlencode($kact) . urlencode(" với lý do ") . urlencode($reason)
);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
foreach($kfields as $key=>$value) { $kfields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');
rtrim($kfields_string, '&');


$kch = curl_init();
curl_setopt($kch, CURLOPT_COOKIE, '__qca=P0-339331677-1435325942989; Menu=on; v=3; ses='.$ses.'; Style=Main; _gat=1; _ga=GA1.2.829838804.1435661085; __utmmobile=0x0f151e222f6d6f81');
curl_setopt($kch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
curl_setopt($kch, CURLOPT_FAILONERROR, 0);
curl_setopt($kch,CURLOPT_URL, $kurl);
curl_setopt($kch,CURLOPT_POST, count($kfields));
curl_setopt($kch,CURLOPT_POSTFIELDS, $kfields_string);
$kresult = curl_exec($kch);
curl_close($kch);


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
