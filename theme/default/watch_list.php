<?php 
function ExtraHead() {
global $videos,$ID;?>
<link href="<?php print(THEME_PATH); ?>/watch.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var isBig = 0;
var xmlTopNotice = null;
var prevItemId = '<?php echo $videos[0]['id']; ?>';
var listID = '<?php echo $ID; ?>';
var cur_index = 0;
var page = 1;
</script>
<script type="text/javascript" src="<?php echo THEME_PATH; ?>/watch_list.js"></script>
<SCRIPT LANGUAGE="VBScript"> 
Sub player_object_FSCommand(ByVal command, ByVal args) 
	call player_object_DoFSCommand(command, args) 
End Sub 
</SCRIPT> 
<style type="text/css">
#falseVideoField, .tvf_intd {
	width: 600px;
}
.tvf_intd {
	height: 440px;
}
</style>
<?php } 
function ExtraHead2() { global $videos;  ?>
<h2><?php echo $tit; ?></h2>
<div id="trueVideoField" style="height:440px;width:600px;"> 
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" id="player_object">
    <param name="movie" value="player.swf?ID=<?php echo $videos[0]['id']; ?>">
    <param name="quality" value="high">
    <param name="FlashVars" value="bigfb=yes&ID=<?php echo $videos[0]['id']; ?>">
    <param name="allowFullScreen" value="true">
    <param name="swLiveConnect" value="true">
	<param name="allowScriptAccess" value="always">
    <embed src="player.swf" allowScriptAccess="always" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="100%" flashvars="bigfb=yes&ID=<?php echo $videos[0]['id']; ?>" allowfullscreen="true" name="player_object" swLiveConnect="true"></embed> 
  </object>
  <div align="right"><a href="javascript:;" onClick="bos();"><?php echo ZoomVideoField; ?></a></div>
</div>
<div id="spacer1"></div>
<?php }
$pageTitle = $tit." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
$pageHideRight = 1;
include(THEME_PATH."/header.php");
?>
<table width="100%" border="0">
  <tr> 
    <td id="falseVideoField" style="height:440px;width:600px;"></td>
    <td rowspan="2" valign="top"><div id="video_playlist_jar">
<ul id="video_playlist_items">
	<?php 	$i=0;	foreach ($videos as $entry) {	?>
	<li class="vitem<?php if ($i==0) echo "_current"; ?>" id="<?php echo $entry['id']; ?>"><a href="javascript:;" onClick="playItem('<?php echo $entry['id']; ?>',<?php echo $i; ?>);" id="<?php echo $entry['id']; ?>_a"><?php echo $entry['title']; ?></a></li>
	<?php $i++; }?>
</ul>
</div>
<a href="javascript:loadmore();" id="loadmore"><?php echo LoadMore; ?></a>
</td>
  </tr>
  <tr>
    <td valign="top"><div class="miniTitle">
        <?php echo Description; ?>
      </div>
      <div class="desBox"> 
        <div id="des" style="display:block;"><a href="javascript:;" onClick="document.getElementById('desfull').style.display='block';document.getElementById('des').style.display='none';">[<?php echo ReadAll;?>]</a><br>
          <?php echo $description; ?>
        </div>
        <div class="desfull" id="desfull" style="display:none;">
          <?php echo $description_full; ?>
        </div>
      </div>
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
            <?php echo UpdateTime; ?>
          </td>
          <td>
            <?php echo $updateTime; ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php 
include(THEME_PATH."/footer.php");
?>