<?php header('Content-type: text/html; charset=utf-8'); ?>
<?php header("Access-Control-Allow-Origin: *"); ?>
<?php
echo '<html><head><style media="all" type="text/css">body{margin: 0px;}</style></head></html>';
ini_set('max_execution_time', 0);
ini_set('user_agent','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');

$diachi=htmlentities($_GET["url"]); //tenwap
$sor=htmlentities($_GET["sor"]);
if($sor==''){$sor='new';}
$type=htmlentities($_GET["type"]);
if($type==''){$type='iframe';}
$style=htmlentities($_GET["style"],ENT_QUOTES, "utf-8");
if($style==''){$style='<div style="background-color:#efefef">Tên: [-ten-] ->> <a href="[-url-]">[-name-]</a> ([-so-])</div>';}
$nick=htmlentities($_GET["nick"]); //taikhoan
$password=base64_encode(htmlentities($_GET["pass"]));
$pass=base64_decode($password); 
$url='http://xxx.'.$diachi.'/main.php?id=log&nick='.$nick.'&pass='.$pass.'&rem=1';

$cookie=('v=3; __qca=P0-1585199047-1438802163714; _gat=1; _ga=GA1.2.829838804.1435661085; __utmmobile=0xd26871e48aba491d');
$user=('Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
function http_login_client($url, $params = "", $cookies_send = "" ){
    $cookies = array();
    $headers = getallheaders();
    $ch = curl_init($url);
    $options = array(CURLOPT_POST => 1,
                        CURLINFO_HEADER_OUT => true,
                        CURLOPT_POSTFIELDS => $params,
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_HEADER => 1,
                        CURLOPT_COOKIE => $cookies_send,
                        CURLOPT_USERAGENT => $headers['User-Agent']
);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
   preg_match_all('/^Set-Cookie: (.*?)=(.*?);/m', $response, $matches);
    foreach( $matches[1] as $index => $cookie )
        $cookies[$cookie] = $matches[2][$index];
    return $cookies;
}
$cookies= http_login_client($url,$cookie,$user);



function url_get_contents($url) {
$data=NULL;
$data=file_get_contents($url);
if($data)
{
preg_match("/<body(.*?)>(.+?)<\/body>/s", $data, $matches);
$data=$matches[2];
}
return $data;
}


$links='http://xxx.'.$diachi.'/forums.php?id=menu&sor='.$sor.'&ses='.$cookies["ses"];
$nguon= url_get_contents($links);
$html = split('<div class="left">',$nguon);
$html=split('<div class="center">',$html[1]);
$html=$html[0];
$inx=0;
$tten=array();$turl=array();$tname=array();$tso=array();
preg_match_all("/<b>(.+?)<\/b>(.+?)<a href=\"(.+?)\">(.+?)\(([0-9]|[0-9][0-9]|[0-9][0-9][0-9])\)<\/a>/", $html, $matches, PREG_SET_ORDER);

foreach ($matches as $val) {
    $tten[$inx]= $val[1];
	$turl[$inx]= 'http://'.$diachi.$val[3];
	$tname[$inx]= $val[4];
	$tso[$inx]= $val[5];
	$inx=$inx+1;
}
$snoidung=$style;$giatri='';
$scount=1;
for($y=0;$y<count($tten);$y++)
{
	$snoidung1=str_replace('[-ten-]',$tten[$y],$snoidung);
	$snoidung2=str_replace('[-url-]',$turl[$y],$snoidung1);
	$snoidung3=str_replace('[-name-]',$tname[$y],$snoidung2);
	$snoidung4=str_replace('[-so-]',$tso[$y],$snoidung3);
	$snoidung5=str_replace('[-count-]',$scount,$snoidung4);
	$giatri .=$snoidung5;
	$scount=$scount+1;
}
if($type=='iframe')
{
echo '<span id="mssforum">'.html_entity_decode($giatri,ENT_QUOTES, "utf-8").'</span>';
}
if($type=='js')
{
	echo 'document.write(\''.$giatri.'\');';
}
?>
