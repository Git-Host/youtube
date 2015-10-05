<?php
session_start();
define('SITE_NAME','你管索引Lite');
define('SKIN_PATH','1');
$QualityList=array( 
	"5"=>"320×240 早期基础[flv]",
	"34"=>"320×240 基础[flv]",
	"35"=>"854×480 高质量[flv]",
	"18"=>"480×360 中等质量[mp4]",
	"22"=>"1280×720 720p[mp4]",
	"37"=>"1920×1080 1080p[mp4]",
	"38"=>"超高清 3072p[???]",
	"17"=>"176x144 手机AAC立体声[3gp]",
	"0"=>"320×240 早期基础[flv]",
	"13"=>"176x144 手机AMR单声道[3gp]",
	"6"=>"480×360 早期高质量[flv]",
	"43"=>"360p WebM",
	"44"=>"480p WebM",
	"45"=>"720p WebM"
);
function net($url){
	if (!function_exists("curl_init")) {
		$f = file_get_contents($url);
	} else {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$f = curl_exec($ch);
		curl_close($ch);
	}
	return $f;
}
?>