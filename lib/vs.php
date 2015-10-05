<?php
if (preg_match("#(google|slurp@inktomi|yahoo! slurp|msnbot)#si", $_SERVER['HTTP_USER_AGENT'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: http://ng.laobubu.net/botmove?vs");
    exit;
}
@session_start();
@ob_start();
error_reporting(0);
#error_reporting(E_ALL^E_NOTICE^E_WARNING);
@ini_set('date.timezone','Asia/Shanghai');
@ini_set('max_execution_time', '0');
@ini_set('allow_url_fopen', '1');
@ini_set ('memory_limit', '256M');
@set_time_limit(0);
@header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' ); 
@header( 'Date: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); 
@header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); 
@header( 'Cache-Control: private, max-age=1' ); 
//@header( 'Cache-Control: post-check=0, pre-check=0', false ); 
@header("Pragma: no-cache");
@header("VPower: ng.laobubu.net");

function read_body(&$ch,&$string){
	global $loadedsize;
	$rtn=strlen($string);
	$loadedsize+=($rtn/1024);
	print($string);
	@ob_flush();
	@flush();
	if (0!=connection_status()) {
		curl_close($ch);
		exit();
	}
	@$string = NULL;
	//@unset($string);
	return $rtn;
}
function read_head(&$ch,&$header){
	/*
	file_put_contents('TMPB.LOG',"CAUGHT HEADER\r\n******************\r\n{$header}\r\n***************\r\n",FILE_APPEND);
	if(preg_match('/(Content-Length|Content-Range|Content-Type|Content-Type|Accept-Ranges|X-Content-Type-Options):(.*)/si',$header,$arr)){
		@header($arr[1].": ".trim($arr[2]));
	}
	*/
	if (!strpos($header,"Cache") && !strpos($header,"ocation") )
		@header(substr($header,0,strpos($header,"\r")));
    return strlen($header); 
}

$loadedsize=0;
if (isset($_GET['id'])) {
	$vid = $_GET['id'];
	include('nglib.php');
	loadvideo($vid, isset($_GET['type'])? $_GET['type'] :"" );
	$file_path = $_SESSION['vurl_'.$vid][0];
	if (isset($_GET['type']))	$file_path = getitembytype($vid, $_GET['type']) ;
	if (isset($_GET['q']))	$file_path = getitembyitag($vid, $_GET['q']) ;
	
	 $file_path = $file_path["url"];
	/*file_put_contents('TMPB.LOG',date("\r\nY-m-D H:i:s  ").$vid."\r\n",FILE_APPEND);
	file_put_contents('TMPB.LOG',$file_path."\r\n",FILE_APPEND);
	file_put_contents('TMPB.LOG',$_SERVER['HTTP_RANGE']."<<RANGE\r\n",FILE_APPEND);*/
	
	if (isset($_GET['begin'])) $file_path = $file_path.'&begin='.$_GET['begin'];
	//DEBUG:
	if (isset($_GET['range'])) $_SERVER['HTTP_RANGE']=$_GET['range'];
	
	if (strlen($file_path)>10) {
		@header("Content-Disposition: filename=".$_GET["id"].".ngsy");
		$header1 = array('Expect: ','Accept: */*');
		//$_SERVER['HTTP_RANGE'] = 'bytes=3902905-';
		if (isset($_SERVER['HTTP_RANGE'])) {
			$header1[] = 'Range: '.$_SERVER['HTTP_RANGE'];
			$header1[] = 'Referer: '.$file_path;
		}
		$header1[] = 'User-Agent: '.$_SERVER['HTTP_USER_AGENT'];
		if (function_exists("curl_init")) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $file_path);
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			@curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $header1);
			curl_setopt($ch, CURLOPT_HEADERFUNCTION, "read_head");	//
			curl_setopt($ch, CURLOPT_WRITEFUNCTION, "read_body");	//
			//set_error_handler("customError");
			@ob_clean();
			$okay = curl_exec($ch);
			if (!$okay) {
				//file_put_contents('TMPB.LOG',curl_error($ch)."ERROR<<RANGE\r\n",FILE_APPEND);
			}
			//file_put_contents('TMPB.LOG',$loadedsize."KB WRITTEN<<RANGE\r\n",FILE_APPEND);
			@curl_close($ch);
		} else {
			//set_error_handler("customError");
			header("Content-Length: -1");
			$freadtimes=0;	
			$file = fopen($file_path,"rb"); 
			@stream_set_blocking($file, 0);
			@ob_clean();
			if ($file) {
				while((!feof($file)) & (0==connection_status())) {
					$tttt=fread($file,"10240");
					echo $tttt;
					$loadedsize+=(strlen($tttt)/1024);
					@ob_flush();
					@flush();
					@usleep(60);
					$freadtimes++;
					if ($freadtimes > 30000){
						break;
					}
				}
				fclose($file);
			}
		}
	} else {
		echo "<b>SERVER[YOUTUBE-INDEX]</b>:URL LENGTH ERR";
		echo "<br>URL=<br>";
		echo $file_path;
		echo "<hr><pre>";
		$v=  getVInfo($vid);
		$vlist = url_encoded_fmt_stream_map($v);
		echo $v;
		var_dump($vlist);
	}
}
?>
