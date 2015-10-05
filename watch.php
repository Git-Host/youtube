<?php 
include('local/language.php');
if (isset($_GET["id"]))
	$ID=$_GET["id"];
elseif (isset($_GET["v"]))
	$ID=$_GET["v"];
else 
	die(file_get_contents('baderr.html'));


include_once('lib/mq.php');
include_once('lib/nglib.php');
include_once("lib/apirequest.php");
initGFW('lib/mglib.txt');
$rating = "-";
$raters = "-";
$viewcount = "-";
$favoritecount = "-";

$xml = xml_load2(ytapi.'videos/'.$ID);
$xml_related = xml_load2(ytapi.'videos/'.$ID.'/related');

if (hasBadKey(var_export($xml,true))) {
	header("Location: http://www.people.com.cn/");
	exit();
} 

$relatedvideo = array();
if ($xml_related != NULL)
	foreach ($xml_related->entry as $entry) {
		$media = $entry->children('http://search.yahoo.com/mrss/');
		ob_start();
			print_r($media);
			$checking = ob_get_contents();
		ob_end_clean();
		if (hasBadKey($checking)) {
			//out_bad();
		} else {
			$yt = $media->children('http://gdata.youtube.com/schemas/2007');
			$gd = $entry->children('http://schemas.google.com/g/2005'); 
			$title = $media->group->title;
			$author = $entry->author->name;
			$description = $media->group->description;
			ob_start();
				echo $media->group->category;
				$category = ob_get_contents();
			ob_end_clean();
			$attrs = $media->group->player->attributes(); 		$id = $attrs['url'];			$id = substr(stristr($id,"v="),2,11);
			$attrs = $media->group->thumbnail[0]->attributes(); $thumbnail = $attrs['url'];
			$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($yt_media_people['url']).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
			//$thumbnail = 'lib/ytp.php?'.(str_replace("ytimg","yx_x",str_replace("/","|",$thumbnail)));
			$attrs = $yt->duration->attributes();				$length = $attrs['seconds']; 
			$attrs = $yt->statistics->attributes();				$viewCount = "0";				@$viewCount = $attrs['viewCount']; 
			if ($gd->rating) {
				$attrs = $gd->rating->attributes();
				$rating = $attrs['average']; 
				$rating = substr($rating,0,3);
			} else {
				$rating = 0; 
			}
			array_push($relatedvideo,array($id,$title,$author,$description,($length/60),$rating,$viewCount,$category,$thumbnail));
		}
	}

$tit = $xml->title;
$description_full = str_replace("\n","<br>",$xml->content);
$description = substr($description_full,0,140);
@$media = $xml->children('http://search.yahoo.com/mrss/');
ob_start();
	echo $media->group->category;
	$category_id = ob_get_contents();
ob_end_clean();
$author = $xml->author->uri;
$author = substr(strstr($author,'users/'),6);

$publishTime = date("Y-m-d H:i:s",strtotime($xml->published));
$updateTime  = date("Y-m-d H:i:s",strtotime($xml->updated));

@$r1 = $xml->children('http://schemas.google.com/g/2005')->rating->attributes();
@$rating = $r1['average'];
@$raters = $r1['numRaters'];

@$s1 = $xml->children('http://gdata.youtube.com/schemas/2007')->statistics->attributes();
@$viewcount = $s1['viewCount'];
@$favoritecount = $s1['favoriteCount'];

$qualitylist = array();
foreach (getVList($ID,array()) as $x=>$y){
	$qualitylist[]=substr($x,1);
}
if (count($qualitylist)<2) {
	header('location: fixer.php');
	die('<a href="fixer.php">FIX ERROR</a>');
}
$str_page = get_net_data("http://www.youtube.com/watch?v=".$ID);
if (strpos($str_page,'watch-extra-info-left')!=false) {	//Check if there is Extra info
	$extrainfomation = strstr($str_page,"watch-extra-info-left");
	$extrainfomation = strstr($extrainfomation,">");
	$extrainfomation = substr($extrainfomation,0,strpos($extrainfomation,'</span'));
	$extrainfomation = strip_tags($extrainfomation);
}

include(THEME_PATH."/watch.php");
?>