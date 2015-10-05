<?php 
/*
	This is Image Proxy【图片代理】
	ytp.php?URL
	URL里面的yx_x会修改为ytimg
	 　　　　|会修改为/
*/

$file_path = $_SERVER['QUERY_STRING']; 
$file_path = str_replace("|","/",$file_path);
$file_path = str_replace("yx_x","ytimg",$file_path);
header('location: https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.$file_path.'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*');
exit();

function get_net_data($url){
	if (!function_exists("curl_init")) {
		$file_contents = file_get_contents($url);
	} else {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
	return $file_contents; 
}

$file_path = $_SERVER['QUERY_STRING']; 
if (strlen($file_path)>5) {
	$file_path = str_replace("|","/",$file_path);
	$file_path = str_replace("yx_x","ytimg",$file_path);
	$file_name = basename($file_path);
	header('Content-Type: image/jpeg'); 
	header("Content-Disposition:filename=$file_name"); 
	echo get_net_data($file_path);
	exit();
} else {
	echo "ErrLen!";
}
?>