<?php 
include('local/language.php');
include_once('lib/mq.php');
include_once("lib/apirequest.php");
initGFW('lib/mglib.txt');

$pageTitle = WEBSITE_TITLE;
$pageHideLeft = 0;
$pageHideRight = 0;
include(THEME_PATH."/header.php");
include(THEME_PATH.'/mini_gallery.php');

function ShowVideoGallery($dataid,$time="",$local="-") {
	$url = ytapi.'standardfeeds/';
	if ($local=="-") {
		$url.=ytpos;
	}else{
		if (strlen($local)>0) $url.=$local.'/';
	}
	$url.=$dataid;
	if (strlen($time)>0) $url.="?time=".$time;
	$xml = xml_load2($url);
	if ($xml != NULL) {
		vg_head();
		foreach ($xml->entry as $entry) {
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
				$thumbnail = 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($thumbnail).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
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
				vg_out($id,$title,$author,$description,($length/60),$rating,$viewCount,$category,$thumbnail);
			}
		}
		vg_end();
	} else {
		echo '<b><a href="http://code.google.com/p/youtubeindex/">NGSY</a>_FAILED:LOAD_VIDEO_LIST</b><br>Please contact laobubu@gmail.com';
	}
}
?>
<h3><?php echo WELCOME_YOU; ?></h3>
<?php require('local/welcome.php'); ?>
<?php include(THEME_PATH."/footer.php"); ?>