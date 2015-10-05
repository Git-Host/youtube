<?php 
include('local/language.php'); 
include('lib/apirequest.php'); 
include('lib/gfw.php'); 
initGFW('lib/mglib.txt');
/*
find.php?keyword=XXX&type=YYY
*/
if (!isset($_GET['type'])) {
	header("Location: baderr.html");
	exit();
}
$type=$_GET['type'];
if (($type=="search" | $type=="searchlist" | $type=="searchkey" | $type=="personal" | $type=="playlist" | $type=="searchchannel") & !isset($_GET['keyword'])){
	header("Location: baderr.html");
	exit();
}
$key=$_GET['keyword'];
if (isset($_GET['ss'])) $key=urldecode(strrev($_GET['keyword']));
if (hasBadKey($key)) {
	header('location: http://www.people.com.cn');
	exit();
}

$url_base='?';
foreach($_GET as $a=>$b) if (strtolower(substr($a,0,4))!='page') $url_base=$url_base.$a.'='.urlencode($b).'&';


if ($type=="search") {
	$tit = Search.'/'.$key;
	$feedURL = ytapi.'videos/?v=2&q='.urlencode(strtolower($key)).'&orderby='.Orderby;
	if (strlen(Local)>1) 		$feedURL.='&restriction='.Local;
	if (strlen($_GET["cat"])>1)	$feedURL.='&category='.$_GET["cat"];
	if ($_GET["caption"]=="yes")$feedURL.='&caption';
	//via http://code.google.com/intl/zh-CN/apis/youtube/reference.html#Searching_for_videos
} elseif ($type=="searchlist") {
	$tit = SearchPlaylist.'/'.$key;
	$feedURL = ytapi.'playlists/snippets?v=2&q='.urlencode(strtolower($key)).'&orderby='.Orderby;
	if (strlen(Local)>1) $feedURL=$feedURL.'&restriction='.Local;
	//via http://code.google.com/intl/eN/apis/youtube/2.0/developers_guide_protocol.html#Searching_for_Playlists
} elseif ($type=="searchkey") {
	$tit = SearchKeyMode.'/'.$key;
	$feedURL = ytapi.'videos/-/'.str_replace(' ','/',$key).'/?orderby='.Orderby;
	if (strlen(Local)>1) $feedURL=$feedURL.'&restriction='.Local;
} elseif ($type=="personal") {
	$p_type = "uploads";
	if (isset($_GET['p_type'])) $p_type = $_GET['p_type'];
	$tit = $PersonResult[$p_type].'/'.$key;
	$feedURL = ytapi.'users/'.urlencode(strtolower($key)).'/'.$p_type.'?&orderby='.Orderby;
	//喜爱的列蟿via http://code.google.com/intl/zh-CN/apis/youtube/developers_guide_php.html#PlaylistInfo
	//上传的视頿via http://code.google.com/intl/zh-CN/apis/youtube/developers_guide_php.html#RetrievingVideos
} elseif ($type=="playlist") {
	$tit = ItemsOfThePlaylist.'/';
	$feedURL = ytapi.'playlists/'.urlencode(strtolower($key)).'?';
} elseif ($type=="searchchannel") {
	$tit = $Search_Mode["searchchannel"].'/'.$key;
	$feedURL = ytapi.'channels?v=2&q='.urlencode(strtolower($key)).'&orderby='.Orderby;
} else {
	$tit = Result.'/'.$Special_Titles[$type];
	$feedURL = ytapi.'standardfeeds/'.ytpos.$type.'?';
}
if (isset($_GET['page'])) $feedURL=$feedURL.'&start-index='.(($_GET['page']-1)*10+1);
$feedURL=$feedURL.'&max-results=10';
if ($type!="personal") $feedURL=$feedURL.ytlang;
$sxml = xml_load2($feedURL);
if ($type=="searchlist" | $type=="searchchannel" | $type=="search")
	$counts = $sxml->children('http://a9.com/-/spec/opensearch/1.1/');
else
	$counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
$total = $counts->totalResults;
$indexfrom = $counts->startIndex;
$indexto = $indexfrom + $counts->itemsPerPage;
$pagenow = floor($indexfrom / ($counts->itemsPerPage))+1;
$pagetotal = ceil($total / ($counts->itemsPerPage));

$extraguide=array();
if ($type=="searchlist") 	$outputtype = "list";
if ($type=="searchchannel") $outputtype = "channel";
if ($type=="playlist") $tit .= $sxml->title;
if ($type=="personal") array_push($extraguide,array(TheAuthor.' - '.$key,'person.php?id='.$key));
if ($type=="playlist") array_push($extraguide,array(WatchPlaylist		,'watch_list.php?id='.$key));

$outputitem=array();
foreach ($sxml->entry as $entry) {
	$media = $entry->children('http://search.yahoo.com/mrss/');
	ob_start();
		print_r($entry);
		$checking = ob_get_contents();
	ob_end_clean();
	if (!hasBadKey($checking)) {
		if ($type=="searchlist") {
			//搜索的是播放列表
			$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
			$author = $entry->author->name;
			$title = $entry->title;
			$description = $entry->summary;
			$viewCount = $yt->countHint;
			$id = $yt->playlistId;
			array_push($outputitem,array($id,$title,$author,$description,$viewCount));
		} elseif ($type=="searchchannel") {	//搜索频道
			$author = $entry->author->name;
			$title = $entry->title;
			$description = $entry->summary;
			$xml_people = xml_load2(ytapi.'users/'.$author);
			$yt_media_people = $xml_people->children("http://search.yahoo.com/mrss/")->thumbnail->attributes();
			//$thumbnail = 'lib/ytp.php?'.(str_replace("ytimg","yx_x",str_replace("/","|",$yt_media_people['url'])));
			$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($yt_media_people['url']).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
			array_push($outputitem,array($title,$author,$description,'',$thumbnail));
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
			
			$attrs = $entry->link->attributes();
			$id = substr(stristr($attrs["href"],"v="),2,11);
			//$thumbnail = 'lib/ytp.php?http:||i.yx_x.com|vi|'.$id.'|2.jpg';
			$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url=http:%2F%2Fi.ytimg.com%2Fvi%2F'.$id.'%2F2.jpg&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
			
			@$attrs = $yt->duration->attributes();				@$length = $attrs['seconds']; 
			$attrs = $yt->statistics->attributes();				$viewCount = "0";				@$viewCount = $attrs['viewCount']; 
			if ($gd->rating) {
				$attrs = $gd->rating->attributes();
				$rating = $attrs['average']; 
				$rating = substr($rating,0,3);
			} else {
				$rating = 0; 
			}
			array_push($outputitem,array($id,$title,$author,$description,($length/60),$rating,$viewCount,$category,$thumbnail));
		}
	}
}
include(THEME_PATH.'/result.php'); 
?>