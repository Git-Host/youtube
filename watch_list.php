<?php 
include('local/language.php');
if (!isset($_GET['id'])) die("<b>NO ARGUMENT</b>: id<br><a href='index.php'>Please go back</a>");

$ID=$_GET['id'];
include('lib/mq.php');
include_once("lib/apirequest.php");
initGFW('lib/mglib.txt');

$xml = xml_load2(ytapi.'playlists/'.$ID.'?start-index=1&max-results=50');
$tit = $xml->title;
$media = $xml->children('http://search.yahoo.com/mrss/');
$description_full = str_replace("\n","<br>",$media->group->description);
$description = substr($description_full,0,140);
$author = $xml->author->uri;		$author = substr(strstr($author,'users/'),6);

@date_default_timezone_set(PRC);
$updateTime  = date("Y-m-d H:i:s",strtotime($xml->updated));

$entry = $xml->entry;
$attrs = $entry[0]->link->attributes();
$vid = substr(stristr($attrs["href"],"v="),2,11);


$i=0;
$videos=array();
foreach ($xml->entry as $entry) {
	$media = $entry->children('http://search.yahoo.com/mrss/');
	$attrs = $entry->link->attributes();
	$vid = substr(stristr($attrs["href"],"v="),2,11);
	array_push($videos,array(
		'id'=>$vid,
		'title'=>($media->group->title),
		'author'=>($entry->author->name)));
	$i++;
}
include(THEME_PATH."/watch_list.php");
?>