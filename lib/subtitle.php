<?php 
header('Content-Type: text/plain');
ob_start();
/*
	这个是字幕获取程序 
	
	via http://userscripts.org/topics/25132
*/

function get_net_data($url){
	if (!function_exists("curl_init")) {
		$file_contents = file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	return $file_contents; 
}

$empty='<transcript></transcript>';
if (!isset($_GET['id'])) die($empty);
if (!isset($_GET['lang'])) die($empty);
include_once("gfw.php");
initGFW('mglib.txt');
$url = 'http://video.google.com/timedtext?hl=zh&type=track&lang='.$_GET['lang'].'&name='.urlencode($_GET['name']).'&v='.$_GET['id'];
if (isset($_GET["tlang"])) $url.="&tlang=".$_GET["tlang"];
echo '<!-- '.$url.' -->';
$out = get_net_data($url);
if (strlen($out)<10) die($empty);
if (strpos($out,'<title>404 Not Found</title>')>5) die($empty);
if (hasBadKey($out)) die($empty);
$out = str_replace("&amp;","&",$out);
print($out);
die(ob_get_contents());  
?>