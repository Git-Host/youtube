<?php
include_once("gfw.php");
define("DEF_Q_LIST"     ,"185 0 346 352237"); 		//Video Quality List (Def)
function getArgDataFromStr($str1) {		// Use JSON since 2010-07-20 00:34 (UTC+8)
	$str = stristr($str1,"swfConfig");
	$str = stristr($str,"{");
	$pos1 = stripos($str,'};')+1;
	$str = substr($str,0,$pos1);
	//echo $str;
	return json_decode($str,true);
}
function getArgData($url) {return  getArgDataFromStr(get_net_data($url));}
function get_one_arg_data($str1,$w) {	return $str1["args"][$w];}
function fmt_url_map($str1){return  explode(",",get_one_arg_data($str1,"fmt_url_map"));}
function getDURLbyU($url,$q_list){	return getDURL(fmt_url_map(getArgData($url)),$q_list);}
function getDURLbyU_m($url,$q_list){
	$str = get_net_data($url);
	if (hasBadKey($str)) 
		return array(
			"no",
			"Garbage",
			"Garbage",
			"Garbage",
			"0",
			"0"
		);
	$tit = stristr($str,"<title>");
	$p2 = strpos($tit,"</title>");
	$tit = substr($tit,8,$p2-8);
	$tit = stristr($tit,"-");
	$tit = substr($tit,2);
	$temp1='description" content="';
	$des = stristr($str,$temp1);
	$des = substr($des,strlen($temp1));
	$p2 = strpos($des,'">');
	$des = substr($des,0,$p2);
	$des2 = "";
	/*
	$des2 = stristr($str,'class="watch-video-desc description"');
	$p2 = strpos($des2,'</div>');
	$des2 = substr($des2,0,$p2);
	$des2 = stristr($des2,'<span');*/
	$theU="";
	@$theU=getDURL(fmt_url_map(getArgDataFromStr($str)),$q_list);
	return array(		$theU,		$tit,		$des,		$des2,		"0",		"0"	);
}
if (isset($_POST['reset'])) rename('../admin/pswcon.php','../admin/pswcon2.php');
if (isset($_POST['refix'])) rename('../admin/pswcon2.php','../admin/pswcon.php');
//TODO: remove the functions
function getDURL($url_map_array,$q_list){
	for ($i=0;$i<strlen($q_list);$i+=2) {
		foreach ($url_map_array as $t) {
			if (substr($t,0,2)==substr($q_list,$i,2)) {
				$t1=strstr($t,"|");
				$t1=substr($t1,1);
				return $t1;
			}
		}
	}
	$t1=strstr($url_map_array[count($url_map_array)-1],"|");
	$t1=substr($t1,1);
	return $t1;
}
function getQNum($url_map_array,$q_list){
	for ($i=0;$i<strlen($q_list);$i+=2) {
		foreach ($url_map_array as $t) {
			if (substr($t,0,2)==substr($q_list,$i,2)) {
				$t1=substr($t,0,strpos($t,"|"));
				return $t1;
			}
		}
	}
	$t1=$url_map_array[count($url_map_array)-1];
	$t1=substr($t1,0,strpos($url_map_array[count($url_map_array)-1],'|'));
	return $t1;
}
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
?>