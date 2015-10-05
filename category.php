<?php 
include('local/language.php'); 
include('lib/apirequest.php'); 
include('lib/gfw.php'); 
initGFW('lib/mglib.txt');
$type="";
$parent="";
if (isset($_GET['type'])) {
	$type=$_GET['type'];
}
if (isset($_GET['parent'])) {
	$parent=$_GET['parent'];
}
$tit = (($type!="")?($Category[$type]." - "):"").(($parent!="")?str_replace('XXX',$Category[$parent],ChildCategoryOfXXX):Category);
if ($type=="") {
	$categories4show = array();
	foreach($Category as $id=>$name) { 
		if (substr($id,0,strlen($type)+1)==($type.'/')) { //((strpos(substr($id,strlen($parent)),'/')!=false) & (substr($id,0,strlen($parent))==$parent)) {
			$categories4show[$id] = $name;
		}
	}
	include(THEME_PATH.'/category.php'); 
} else {
	$outputitem=array();
	$feedURL = ytapi.'videos/-/'.$type.'/?orderby='.Orderby;
	if (strlen(Local)>1) $feedURL=$feedURL.'&restriction='.Local;
	if (isset($_GET['page']))
		$feedURL=$feedURL.'&start-index='.(($_GET['page']-1)*10+1);
	$feedURL=$feedURL.'&max-results=10';
	$feedURL=$feedURL.ytlang;
    $sxml = xml_load2($feedURL);
    $counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
    $total = $counts->totalResults;
    $indexfrom = $counts->startIndex;
    $indexto = $indexfrom + $counts->itemsPerPage;
    $pagenow = floor($indexfrom / ($counts->itemsPerPage))+1;
    $pagetotal = ceil($total / ($counts->itemsPerPage));
	$extraguide=array();
	foreach($Category as $id=>$name) { 
		if (substr($id,0,strlen($type)+1)==($type.'/')) {
			array_push($extraguide,array(MoreChildCategorys ,'category.php?parent='.$type));
			break;
		}
	}
	foreach ($sxml->entry as $entry) {
		$media = $entry->children('http://search.yahoo.com/mrss/');
		ob_start();
			print_r($media);
			$checking = ob_get_contents();
		ob_end_clean();
		if (!hasBadKey($checking)) {
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
			$attrs = $media->group->thumbnail[0]->attributes(); $thumbnail = $attrs['url']; 	$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($thumbnail).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
			$attrs = $yt->duration->attributes();				$length = $attrs['seconds']; 
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
$url_base = '?';
foreach($_GET as $a=>$b) if (strtolower(substr($a,0,4))!='page') $url_base=$url_base.$a.'='.urlencode($b).'&';
	include(THEME_PATH.'/result.php');
}
?>