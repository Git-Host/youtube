<?php 
include('local/language.php');
$page = 1;
if (isset($_GET['id']))
	$ID=$_GET['id'];
if (isset($_GET['page']))
	$page=strval($_GET['page']);

include('lib/mq.php');
include_once("lib/apirequest.php");
initGFW('lib/mglib.txt');

$xml = xml_load2(ytapi.'playlists/'.$ID.'?max-results=50&start-index='.(($page-1)*15+1).'&rand='.rand(0,1995));
/*$tit = $xml->title;
$media = $xml->children('http://search.yahoo.com/mrss/');
$description_full = str_replace("\n","<br>",$media->group->description);
$description = substr($description_full,0,140);
$author = $xml->author->uri;		$author = substr(strstr($author,'users/'),6);

@date_default_timezone_set(PRC);
$updateTime  = date("Y-m-d H:i:s",strtotime($xml->updated));
*/

$videos=array();
foreach ($xml->entry as $entry) {
	ob_start();
		print_r($entry);
		$checking = ob_get_contents();
	ob_end_clean();
	if (!hasBadKey($checking)) {
		$media = $entry->children('http://search.yahoo.com/mrss/');
		$attrs = $entry->link->attributes();
		$vid = substr(stristr($attrs["href"],"v="),2,11);
		array_push($videos,array(
			'id'=>$vid,
			'title'=>($media->group->title),
			'author'=>($entry->author->name)));
	}
}
include(THEME_PATH."/list_ajax.php");
?>