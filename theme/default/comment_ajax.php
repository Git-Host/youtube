<?php
header('Content-Type: text/plain');
if (isset($error)) die('ERROR! <a href="javascript:jumpcommentpage('.$page.');">Retry?</a>');
$out = '<ul id="comments">';
$i = 0;
foreach ($comments as $entry) {
	$out.='<li><div><a href="person.php?id='.$entry['author'].'">'.$entry['author'].'</a>['.$entry['published'].']:<a href="javascript:translatecomment('.$i.');" title="Translate"><img align="right" src="'.THEME_PATH.'/images/translate.png" border="0"></a></div>';
	$out.='<blockquote id="comment_'.$i.'">'.$entry['content'].'</blockquote>';
	$out.='</li>';
	$i++;
}
$out.='</ul><table class="pageGuide"><tr><td class="left">';
if ($comments_has_prev) $out.='<a href="javascript:jumpcommentpage('.($page-1).');">'.PrevPage.'</a>';
$out.='</td><td class="center">'.str_replace("YYY",$comments_pages,str_replace("XXX",$page,ThisIsPageXXXOfYYY)).'</td><td class="right">';
if ($comments_has_next) $out.='<a href="javascript:jumpcommentpage('.($page+1).');">'.NextPage.'</a>';
$out.='</td></tr></table>';
die($out); // or ads will destory AJAX!
?>