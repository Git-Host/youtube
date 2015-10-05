<?php 
$pageTitle = $tit." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
$pageHideRight = 1;
include(THEME_PATH."/header.php");
print("<h3>$tit</h3>");
?>
<table width="100%" id="person_zone">
<tr>
<td width="60%" valign="top" class="personData"> 
<img class="user_thumb" src="<?php echo 'https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?url='.urlencode($yt_media['url']).'&container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*';
//'lib/ytp.php?'.(str_replace("ytimg","yx_x",str_replace("/","|",$yt_media['url']))); ?>">
<table class="card">
<tr><td class="left"><?php echo UserName; //用户县?></td><td class="right"><?php echo $yt->username; ?></td></tr>
<tr><td class="left"><?php echo Age; //年龄 ?></td><td class="right"><?php echo $yt->age; ?></td></tr>
<tr><td class="left"><?php echo Gender; //性别 ?></td><td class="right"><?php echo $GenderData[$gender]; ?></td></tr>
<tr><td class="left"><?php echo Hometown; //家乡 ?></td><td class="right"><?php echo $yt->hometown; ?></td></tr>
<tr><td class="left"><?php echo Location; //所在地势?></td><td class="right"><?php echo $yt->location; ?></td></tr>
<tr><td class="left"><?php echo Occupation; //职业 ?></td><td class="right"><?php echo $yt->occupation; ?></td></tr>
<tr><td class="left"><?php echo Company; //公司 ?></td><td class="right"><?php echo $yt->company; ?></td></tr>
<tr><td class="left"><?php echo School; //学校 ?></td><td class="right"><?php echo $yt->school; ?></td></tr>
<tr><td class="left"><?php echo Hobbies; //兴趣爱好 ?></td><td class="right"><?php echo $yt->hobbies; ?></td></tr>
<tr><td class="left"><?php echo FavoriteBook; //喜欢的书篿?></td><td class="right"><?php echo $yt->books; ?></td></tr>
<tr><td class="left"><?php echo FavoriteMovies; //喜欢的电廿?></td><td class="right"><?php echo $yt->movies; ?></td></tr>
<tr><td class="left"><?php echo FavoriteMusic; //喜欢的音䷿?></td><td class="right"><?php echo $yt->music; ?></td></tr>
</table>
	</td>
    <td valign="top" class="personLink">
	<blockquote class="descript_self"><?php echo $yt->description; ?></blockquote>
	<h3><?php echo KnowMoreAboutHim; ?></h3>
	<ul><?php foreach($PersonResult as $id__=>$name__) {?>
		<li><a href="find.php?type=personal&keyword=<?php echo $id; ?>&p_type=<?php echo $id__; ?>"><?php echo $name__; ?></a></li>
	<?php } ?></ul>
	</td></tr>
</table>
<?php 
include(THEME_PATH."/footer.php");
?>