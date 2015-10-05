<?php 
function ExtraHead() {
global $ID;?>
<link href="<?php print(THEME_PATH); ?>/watch.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script language="JavaScript">var videoID='<?php echo $ID; ?>';</script>
<script type="text/javascript" src="<?php echo THEME_PATH; ?>/watch.js"></script>
<script type="text/javascript" src="http://ng.<?php echo strrev('ubooal'); ?>bu.net/ads/watch.js"></script>
<?php } ?><?php
$pageTitle = $tit." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
$pageHideRight = 1;
include(THEME_PATH."/header.php");
include(THEME_PATH.'/mini_gallery.php');
?>
<?php function ExtraHead2() {
global $tit,$ID;  ?>
  <h2><?php echo $tit; ?></h2>
  <div id="trueVideoField" style="width: 640px;height: 391px;"> 
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" id="player_object" width="100%" height="100%">
      <param name="movie" value="player.swf?ID=<?php echo $ID; ?>">
      <param name="quality" value="high">
      <param name="FlashVars" value="autoStart=yes&bigfb=yes&ID=<?php echo $ID; ?>">
      <param name="allowFullScreen" value="true">
      <embed src="player.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="640" height="391" style="width:100%;height:100%" flashvars="autoStart=yes&bigfb=yes&ID=<?php echo $ID; ?>" allowfullscreen="true"></embed> 
    </object>
    <div align="right"><a href="javascript:;" onClick="bos();"> 
      <?php echo ZoomVideoField; ?>
      </a></div>
  </div>
  <div id="spacer1"></div>
<?php } ?>
<table width="100%" border="0" >
  <tr> 
    <td valign="top" id="falseVideoField" style="height:391px;width: 640px"></td>
    <td valign="top" rowspan="2"><div class="miniTitle">
        <?php echo Description; ?>
      </div>
      <div class="desBox"> 
        <div id="des" style="display:block;"><a href="javascript:;" onClick="document.getElementById('desfull').style.display='block';document.getElementById('des').style.display='none';">[
          <?php echo ReadAll;?>
          ]</a><br>
          <?php echo $description; ?>
        </div>
        <div class="desfull" id="desfull" style="display:none;">
          <?php echo $description_full; ?>
        </div>
      </div>
      <br> <div class="miniTitle">
        <?php echo Statistics; ?>
      </div>
      <table border="0">
        <tr> 
          <td>
            <?php echo Rating; ?>
          </td>
          <td>
            <?php echo $rating; ?>
          </td>
        </tr>
        <tr> 
          <td>
            <?php echo Raters; ?>
          </td>
          <td>
            <?php echo $raters; ?>
          </td>
        </tr>
        <tr> 
          <td>
            <?php echo ViewCount; ?>
          </td>
          <td>
            <?php echo $viewcount; ?>
          </td>
        </tr>
        <tr> 
          <td>
            <?php echo FavoriteCount; ?>
          </td>
          <td>
            <?php echo $favoritecount; ?>
          </td>
        </tr>
      </table>
      <br> <div class="miniTitle">
        <?php echo Infomation; ?>
      </div>
      <table border="0">
        <tr> 
          <td>
            <?php echo Author; ?>
          </td>
          <td><a href="person.php?id=<?php echo $author; ?>">
            <?php echo $author; ?>
            </a></td>
        </tr>
        <tr> 
          <td>
            <?php echo Category; ?>
          </td>
          <td><a href="category.php?type=<?php echo $category_id; ?>">
            <?php echo $Category[$category_id]; ?>
            </a></td>
        </tr>
        <tr> 
          <td>
            <?php echo PublishTime; ?>
          </td>
          <td>
            <?php echo $publishTime; ?>
          </td>
        </tr>
        <tr> 
          <td>
            <?php echo UpdateTime; ?>
          </td>
          <td>
            <?php echo $updateTime; ?>
          </td>
        </tr>
      </table>
      <br> <div class="miniTitle">
        <?php echo Download; ?>
      </div>
	  <a href="http://ng.laobubu.net/lib/downit.php?id=<?php echo $ID; ?>">【点击这里】通过特殊渠道下载</a>，或者通过你管索引下载（可能不完整）：<br>
      <?php foreach ($qualitylist as $t_num) {?>
      <a href="lib/vs.php?q=<?php echo $t_num; ?>&id=<?php echo $ID;?>">·<?php echo $QualityList[$t_num]; ?></a><br>
      <?php 
		}
	?>
      <br><div class="miniTitle"><?php echo ShareTo; ?></div>
      <?php 
$watchURL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
foreach ($ShareTo as $WayName=>$WayURL) {?>
      <a rel="nofollow" target="_blank" href="<?php echo str_replace('%VNAME%',urlencode($xml->title),str_replace('%VID%',$ID,str_replace('%WATCHURL%',urlencode($watchURL),$WayURL))); ?>"><?php echo $WayName; ?></a><br>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td valign="top">
		<?php 
			if ($extrainfomation != '') {	//Check if there is Extra info
				echo '<div class="miniTitle">'.YouTubeExtraInfo.'</div>';
				echo $extrainfomation;
				echo "<br><br>";
			}
		?>
		<div class="miniTitle"><?php echo Comments; ?></div>
		<div id="comments_jar">Loading comments...</div>
		<script language="JavaScript">jumpcommentpage(1);</script><br>
		<div class="miniTitle"><?php echo PostComments; ?></div>
		<div><iframe src="http://ng.laobubu.net/lib/postComment.php?v=<?php echo $ID;?>" width="630" height="75" frameborder="0">Need IFrame</iframe></div><br>
		<div class="miniTitle"><?php echo RelatedVideos; ?></div>
		<?php 
			vg_head();
			for ($i=0;$i<count($relatedvideo);$i++)
				vg_out($relatedvideo[$i][0],$relatedvideo[$i][1],$relatedvideo[$i][2],$relatedvideo[$i][3],$relatedvideo[$i][4],$relatedvideo[$i][5],$relatedvideo[$i][6],$relatedvideo[$i][7],$relatedvideo[$i][8]);
			vg_end();
		?>
	</td>
  </tr>
</table>
<?php 
include(THEME_PATH."/footer.php");
?>