<?php
/************************************
 * 你管索引lib v2
  @updated 2012年12月9日1:44:22
  @author laobubu
  @description 获取youtube视频下载地址
************************************/

//获取原始数据
function getVInfo($id){
	$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,"; 
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5"; 
	$header[] = "Cache-Control: max-age=0"; 
	$header[] = "Connection: keep-alive"; 
	$header[] = "Keep-Alive: 300"; 
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; 
	$header[] = "Accept-Language: zh-cn,en;q=0.5"; 
	$header[] = "Pragma: "; 
	$url = 'http://www.youtube.com/get_video_info?video_id='.$id.'&eurl=http://ng.laobubu.com/';
	if (!function_exists("curl_init")) {
		$f = file_get_contents($url);
	} else {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.youtube.com/watch?v='.$id);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.91 Safari/534.30");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$f = curl_exec($ch);
		curl_close($ch);
	}
	if (strpos($f,'url_encoded_fmt_stream_map')===FALSE) { //error happened
		$url = 'http://www.youtube.com/watch?v='.$id;
		if (!function_exists("curl_init")) {
			$f = file_get_contents($url);
		} else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
			curl_setopt($ch, CURLOPT_REFERER, 'http://www.youtube.com/watch?v='.$id);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.91 Safari/534.30");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$f = curl_exec($ch);
			curl_close($ch);
		}
		$f = substr($f,strpos($f,'flashvars'));
		$f = substr($f,strpos($f,'"')+1);
		$f = substr($f,0,strpos($f,'"'));
		$f = str_replace('\u0026','&',$f);
		$f = str_replace('&amp;','&',$f);
	}
	return $f;
}

function deleteFromArray(&$array, $deleteIt, $useOldKeys = FALSE){
    $key = array_search($deleteIt,$array,TRUE);
    if($key === FALSE)
        return FALSE;
    unset($array[$key]);
    if(!$useOldKeys)
        $array = array_values($array);
    return TRUE;
}

/****************************
按照typelist要求的将指定格式视频列到前面
 @author laobubu
 @example typelist = "webm,mp4"
 ****************************/
function formatVListByType($vlist,$typelist,$typename="type",$removeOtherType=false){
	$rtn = array();
	$f = explode(',',$typelist);
	foreach ($f as $t) {
		foreach ($vlist as $i) {
		 $temp= stripos($i[$typename],$t);
			if (($temp===0)|($temp>3)) {
				$rtn[] = $i;
				deleteFromArray($vlist,$i);
			}
		}
	}
	if (!$removeOtherType) $rtn=array_merge($rtn,$vlist);
	
	$rtn2 = array();
	$f = array("medium","large","hd720","hd1080");
	foreach ($f as $t) {
		foreach ($rtn as $i) {
			if (strpos($i['quality'],$t)!==FALSE) {
				$rtn2[] = $i;
				deleteFromArray($rtn,$i);
			}
		}
	}
	$rtn2=array_merge($rtn2,$rtn);
	
	return $rtn2;
}


/****************************
从原始数据里提取视频地址列表
 @author laobubu
 @example 
 array(16) {
  [0]=>
  array(5) {
    ["itag"]=>  string(2) "46"
    ["url"]=>string(562) "视频地址"
	["type"]=>  string(34) "video/webm; codecs="vp8.0, vorbis""
    ["fallback_host"]=>  string(27) "tc.v14.cache5.c.youtube.com"
    ["quality"]=>  string(6) "hd1080"
  }
  [1]=>
  array(5) {
    ["itag"]=>  string(2) "37"
    ["url"]=> string(562) "视频地址"
    ["type"]=>  string(42) "video/mp4; codecs="avc1.64001F, mp4a.40.2""
    ["fallback_host"]=>  string(27) "tc.v15.cache4.c.youtube.com"
    ["quality"]=>  string(6) "hd1080"
  }
  [2]=>
  array(5) {
    ["itag"]=>  string(2) "45"
    ["url"]=>  string(561) "视频地址"
    ["type"]=>  string(34) "video/webm; codecs="vp8.0, vorbis""
    ["fallback_host"]=>  string(27) "tc.v22.cache2.c.youtube.com"
    ["quality"]=>  string(5) "hd720"
  }
  ...
**************************/
function url_encoded_fmt_stream_map($raw, $remove3D=true, $removeSmall=true) {
	parse_str($raw,$a);
	$str = explode(',',$a["url_encoded_fmt_stream_map"]);
	$rtn = array();
	foreach($str as $item) {
		parse_str($item,$add);
		$q = urldecode($a["quality"]);
		$add["url"] = (urldecode($add["url"])."&signature=".$add["sig"]);
		$add["type"]= stripslashes( $add["type"]);
		unset($add["sig"]);
		if (isset($add["stereo3d"]) && $remove3D) continue;
		if (($add["quality"] == "small") && $removeSmall) continue;
		$rtn[] = $add;
	}
	$rtn = array_reverse($rtn);
	return $rtn;
}


$defaultStreams = array(
"5"=>array("width" =>"320","height" =>"240","container" =>"FLV,acodec:MP3,vcodec:H.263"),
"17"=>array("width" =>"176","height" =>"144","container" =>"3GPP,acodec:AAC,vcodec:MPEG-4"),
"18"=>array("width" =>"640","height" =>"360","container" =>"MP4,acodec:AAC,vcodec:H.264","vprofile" =>"Baseline"),
"22"=>array("width" =>"1280","height" =>"720","container" =>"MP4,acodec:AAC,vcodec:H.264","vprofile" =>"High"),
"34"=>array("width" =>"640","height" =>"360","container" =>"FLV,acodec:AAC,vcodec:H.264","vprofile" =>"Main"),
"35"=>array("width" =>"854","height" =>"480","container" =>"FLV,acodec:AAC,vcodec:H.264","vprofile" =>"Main"),
"36"=>array("width" =>"320","height" =>"240","container" =>"3GPP,acodec:AAC,vcodec:MPEG-4","vprofile" =>"Simple"),
"37"=>array("width" =>"1920","height" =>"1080","container" =>"MP4,acodec:AAC,vcodec:H.264"),
"38"=>array("width" =>"2048","height" =>"1536","container" =>"MP4,acodec:AAC,vcodec:H.264"),
"43"=>array("width" =>"640","height" =>"360","container" =>"WebM,acodec:Vorbis,vcodec:VP8"),
"44"=>array("width" =>"854","height" =>"480","container" =>"WebM,acodec:Vorbis,vcodec:VP8"),
"45"=>array("width" =>"1280","height" =>"720","container" =>"WebM,acodec:Vorbis,vcodec:VP8"),
"46"=>array("width" =>"1920","height" =>"1080","container" =>"WebM,acodec:Vorbis,vcodec:VP8"),
"82"=>array("width" =>"640","height" =>"360","container" =>"MP4,acodec:AAC,vcodec:H.264","stereo3d" =>true),
"83"=>array("width" =>"854","height" =>"480","container" =>"MP4,acodec:AAC,vcodec:H.264","stereo3d" =>true),
"84"=>array("width" =>"1280","height" =>"720","container" =>"MP4,acodec:AAC,vcodec:H.264","stereo3d" =>true),
"85"=>array("width" =>"1920","height" =>"1080","container" =>"MP4,acodec:AAC,vcodec:H.264","stereo3d" =>true),
"100"=>array("width" =>"640","height" =>"360","container" =>"WebM,acodec:Vorbis,vcodec:VP8","stereo3d" =>true),
"101"=>array("width" =>"854","height" =>"480","container" =>"WebM,acodec:Vorbis,vcodec:VP8","stereo3d" =>true),
"102"=>array("width" =>"1280","height" =>"720","container" =>"WebM,acodec:Vorbis,vcodec:VP8","stereo3d" =>true),
);


//VAR AP
if (strpos($_SERVER['SCRIPT_NAME'],'nglib.php')!==FALSE){
	$_tempvid='uelHwf8o7_U';
	if (isset($_GET['v'])) $_tempvid = $_GET['v'];
	$a = getVInfo($_tempvid);
	parse_str($a,$b);
	unset($b['url_encoded_fmt_stream_map']);
	$b['yti_vlist']=url_encoded_fmt_stream_map($a,!isset($_GET['keep3d']),!isset($_GET['keepsmall']));
	if (isset($_GET['fvlist'])) $b['yti_vlist'] = formatVListByType($b['yti_vlist'],$_GET['fvlist']);
	ob_end_clean();
	$rtn = json_encode($b);
	if (isset($_GET['encode_magickey'])) {
		$a = intval($_GET['encode_magickey']);
		function encode_char(&$ch){
			global $a;
			return chr(ord($ch)+$a);
		}
			//$rtn = iconv('UTF-8','UTF-16',$rtn);
		preg_match_all('/([\d\D])/s',$rtn,$bytes);
		$bytes=array_map('encode_char',$bytes[1]) ;
		$rtn=implode('',$bytes);
		//$str = iconv('UTF-16',$charset,$str);
	}
	die($rtn);
}


/*********
loadvideo 处理视频地址解析并放入session
*************/
function loadvideo($vid,$type=""){
	if (isset($_SESSION['vurl_expire_'.$vid]))
		if (time()>$_SESSION['vurl_expire_'.$vid]) {
			unset($_SESSION['vurl_'.$vid]);
		}
	if (!isset($_SESSION['vurl_'.$vid])) {	
		$vlist = url_encoded_fmt_stream_map(getVInfo($vid));
		$_SESSION['vurl_'.$vid] = $vlist;
		$_SESSION['vurl_expire_'.$vid] = time()+60*35;
	}
}

function getitembytype($vid,$type){
loadvideo($vid);
$vlist = formatVListByType( $_SESSION['vurl_'.$vid] ,$type);
return $vlist[0];
}

function getitembyitag($vid,$itag){
loadvideo($vid);
$vlist = formatVListByType( $_SESSION['vurl_'.$vid] ,$itag,"itag");
return $vlist[0];
}
?>