<?php 
if (!isset($_GET['id'])){
	header("Location: baderr.html");
	exit();
} 
include('local/language.php'); 
include('lib/apirequest.php'); 
include('lib/gfw.php'); 
initGFW('lib/mglib.txt');

$id=$_GET['id'];
$sxml = xml_load2(ytapi.'users/'.$id);
$entry = $sxml;//->entry;

ob_start();
	print_r($entry);
	$checking = ob_get_contents();
ob_end_clean();
if (hasBadKey($checking)) {
	header("Location: http://www.people.com.cn/");
	exit();
} 

$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
$yt_media = $entry->children("http://search.yahoo.com/mrss/")->thumbnail->attributes();
ob_start();
	echo($yt->gender);
	$gender = ob_get_contents();
ob_end_clean();

$tit = str_replace('XXX',$yt->username,ChannelOfXXX);
include(THEME_PATH."/person.php");
?>