<?php 
header('Content-Type: text/plain');
	/*
		使用xml格式获取视频信息
		错误情况
			lost_arg		参数id缺失
			api_load_error	API载入视频信息失败
			did_not_get_qs	获取视频质量表失败
	*/
	if (!isset($_GET["id"])) {
		die('<ngsyvideo><msg>lost_arg</msg></ngsyvideo>');
	} else {
		$id = $_GET["id"];
	}
	
	
	echo('<!-- NO AD PLEASE');
	@ob_flush();
	@flush();
	
	include_once("mq.php");
	include_once("../local/language.php");
	include_once("apirequest.php");
	initGFW('mglib.txt');
	
	ob_start();
	$xml = xml_load2(ytapi.'videos/'.$id);
	$media = $xml->children('http://search.yahoo.com/mrss/');
	$checking = ob_get_contents();
	ob_end_clean();
	if (strlen($checking)>10) die('<ngsyvideo><msg>api_load_error</msg></ngsyvideo>');
	/*
	$str = getArgData("http://www.youtube.com/watch?v=".$id);
	//if (strlen($str)<10) die('<ngsyvideo><msg>did_not_get_qs</msg></ngsyvideo>');
	@$url_map_array = fmt_url_map($str);
	*/
	
	$author = $xml->author->uri;
	$author = substr(strstr($author,'users/'),6);
	
	$baseurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$baseurl = substr($baseurl,0,strrpos($baseurl,"/"));
	$attrs = $media->group->thumbnail[0]->attributes();
	$thumbnail = $attrs['url'];
	//$thumbnail = $baseurl.'/ytp.php?'.(str_replace("ytimg","yx_x",str_replace("/","|",$thumbnail)));
	$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($thumbnail).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
	
	$attrs = $media->group->content[0]->attributes();
	$length = $attrs['duration'];
	
	$rating = "0";
	@$r1 = $xml->children('http://schemas.google.com/g/2005')->rating->attributes();
	@$rating = $r1['average'];
	
	
	
$a = ' -->
<?xml version="1.0" encoding="utf-8"?>';
$a .='<ngsyvideo>
<id>'.$id.'</id>
<title>'.$xml->title.'</title>
<author>'.$author.'</author>
<image>'.$thumbnail.'</image>
<rating>'.$rating.'</rating>
<length>'.$length.'</length><!-- 单位为秒(s) -->
<quality>';
include('nglib.php');
foreach (getVList($id) as $t_num1=>$t_url) {
	$t_num=substr($t_num1,1);
	$a.='<qitem id="'.$t_num.'" description="'.$QualityList[$t_num].'">'.$t_url.'</qitem>';
}

$a.='</quality>';
$ccurl = get_one_arg_data($str,'ttsurl');
$cc = get_net_data($ccurl.'&type=list&tlangs=1&asrs=1&hl=zh&v='.$id);
if (strlen($cc)>2) {
	$a.=$cc;
	print($cc);
}else {
	$a.='<transcript_list/>';
	print('<transcript_list/>');
}

print('<laobubu>');

$a.='<ccurl>'.strstr($ccurl,"timedtext?").'</ccurl>
</ngsyvideo>';

die($a);
flush();
?>