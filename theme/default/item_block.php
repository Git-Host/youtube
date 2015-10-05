<?php 
function out($id,$title,$author,$descript,$length,$rate,$watchcount,$category_id,$img){
global $Category;?>
<table class="video_block">
  <tr> 
    <td rowspan="3" class="thumb"><?php if (CON_hide_img_thumb!="y") { ?><a href="watch.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"></a><?php } ?></td>
    <td class="title"><a href="watch.php?id=<?php echo $id; ?>"><?php echo $title; ?></a></td>
  </tr>
  <tr>
    <td class="des_mini">
	<?php 
	$o=_MSG1_;
	$o=str_replace('%a',$author,$o);
	$o=str_replace('%k',$Category[$category_id],$o);
	$o=str_replace('%1',$category_id,$o);
	$o=str_replace('%r',$rate,$o);
	$o=str_replace('%c',$watchcount,$o);
	$o=str_replace('%l',$length,$o);
	echo $o;
	?></td>
  </tr>
  <tr> 
    <td class="descript">
      <?php
	$des=$descript;
	if (strlen($des)>100) $des=substr($des,0,97)."...";
	echo $des;
?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="links"> <a href="watch.php?id=<?php echo $id; ?>"><?php echo WatchIt; ?></a> 
      | <a href="http://youtube.com/watch?v=<?php echo $id; ?>"><?php echo WatchOnYouTube; ?></a> 
      | <a href="person.php?id=<?php echo $author; ?>"><?php echo TheAuthor; ?></a> 
      | <a href="category.php?type=<?php echo $category_id; ?>"><?php echo str_replace("XXX",$Category[$category_id],TheCategoryXXX); ?></a> 
      | <a href="javascript:alert('<?php echo ThisFunctionIsUnavailableNow; ?>');"><?php echo ReportIt; ?></a> 
    </td>
  </tr>
</table>
<?php } 

function out_list($id,$title,$author,$descript,$watchcount,$img=''){
?>
<table class="video_block">
  <tr> 
    <td rowspan="3" class="thumb"><?php if (CON_hide_img_thumb!="y") { ?><a href="find.php?type=playlist&keyword=<?php echo $id; ?>"><img src="<?php if (strlen($img)>1) echo $img; else echo 'images/plist.png'; ?>"></a><?php } ?></td>
    <td class="title"><a href="find.php?type=playlist&keyword=<?php echo $id; ?>"><?php echo $title; ?></a></td>
  </tr>
  <tr>
    <td class="des_mini">
	<?php 
	$o=_MSG2_;
	$o=str_replace('%a',$author,$o);
	$o=str_replace('%c',$watchcount,$o);
	echo $o;
	?></td>
  </tr>
  <tr> 
    <td class="descript">
      <?php
	$des=$descript;
	if (strlen($des)>100) $des=substr($des,0,97)."...";
	echo $des;
?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="links">
		<a href="find.php?type=playlist&keyword=<?php echo $id; ?>"><?php echo ShowItems; ?></a> 
      | <a href="http://www.youtube.com/view_play_list?p=<?php echo $id; ?>"><?php echo WatchOnYouTube; ?></a> 
      | <a href="watch_list.php?id=<?php echo $id; ?>"><?php echo WatchPlaylist; ?></a> 
      | <a href="person.php?id=<?php echo $author; ?>"><?php echo TheAuthor; ?></a> 
      | <a href="javascript:alert('<?php echo ThisFunctionIsUnavailableNow; ?>');"><?php echo ReportIt; ?></a> 
    </td>
  </tr>
</table>
<?php } 

function out_author($title,$author,$descript,$updated='',$img=''){
?>
<table class="video_block">
  <tr> 
    <td rowspan="3" class="thumb"><?php if (CON_hide_img_thumb!="y") { ?><a href="find.php?type=playlist&keyword=<?php echo $id; ?>"><img src="<?php if (strlen($img)>1) echo $img; else echo 'images/plist.png'; ?>"></a><?php } ?></td>
    <td class="title"><a href="person.php?id=<?php echo $author; ?>"><?php echo (strlen($title)>1?$title:$author); ?></a></td>
  </tr>
  <tr>
    <td class="des_mini">
	<?php 
	$o=_MSG3_;
	$o=str_replace('%a',$author,$o);
	$o=str_replace('%d',$updated,$o);
	echo $o;
	?></td>
  </tr>
  <tr> 
    <td class="descript">
      <?php
	$des=$descript;
	if (strlen($des)>100) $des=substr($des,0,97)."...";
	echo $des;
?>
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="links">
		<a href="person.php?id=<?php echo $author; ?>"><?php echo TheAuthor; ?></a> 
      | <a href="javascript:alert('<?php echo ThisFunctionIsUnavailableNow; ?>');"><?php echo ReportIt; ?></a> 
    </td>
  </tr>
</table>
<?php } 

function out_bad() { ?>
<table class="video_block">
  <tr> 
    <td rowspan="3" class="thumb"><?php if (CON_hide_img_thumb!="y") { ?><img src="images/empty_thumb.png"><?php } ?></td>
    <td class="title">Blocked Item</td>
  </tr>
  <tr>
    <td class="des_mini">You Cannot See It.</td>
  </tr>
  <tr> 
    <td class="descript">
	This video is not allowed! It has been blocked according to the law.
    </td>
  </tr>
  <tr> 
    <td colspan="2" class="links">
		No More Infomation
    </td>
  </tr>
</table>
<?php
}
//out_bad();
//out("UjWfl7JT6-g","TEST123","laobubu","A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!A Video!",5,"5.444","99","Comedy","../images/getsource.png");
?>
