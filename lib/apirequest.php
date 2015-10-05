<?php
@session_start();
if (!isset($_SESSION["local"])) $_SESSION["local"]="";
if (!isset($_SESSION["lang"])) $_SESSION["lang"]="";

define('ytapi','http://gdata.youtube.com/feeds/api/');
define('Local',$_SESSION["local"]);
define('Lang',$_SESSION["lang"]);
define('Orderby',$_SESSION["orderby"]);

if (strlen(Local)>0) {
	define('ytpos',Local.'/');
} else {
	define('ytpos','');
}
if (strlen(Lang)>0) {
	define('ytlang','&lr='.Lang);
} else {
	define('ytlang','');
}

function xml_load2($url) {
	if (!function_exists("curl_init")) {
		$file_contents = file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 20;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	//if (stripos($file_contents,'<')==false) return NULL;
	ob_start();
		$rtn = simplexml_load_string($file_contents);
		$checking = ob_get_contents();
	ob_end_clean();
	if (strlen($checking)>5) return NULL; else return $rtn;
}

/*
	这个是API请求。格式为
	
	require("lib/apirequest.php");
	
	然后你就拥有了一个常量ytapi，且已经为地区格式化
*/
?>