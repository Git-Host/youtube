<?php
$pageTitle = $tit." - ".WEBSITE_TITLE;
$pageHideLeft = 0;
$pageHideRight = 0;
include(THEME_PATH."/header.php");
include(THEME_PATH.'/item_block.php');
print("<h3>$tit</h3>");
if (isset($extramsgs)) foreach($extramsgs as $showtemp1) print($showtemp1);
print('<div class="subTitle">'.str_replace("XXX",$total,TheNumberOfResultsIsXXX).'</div>');
if (is_array($extraguide)) 
	for ($i=0;$i<count($extraguide);$i++) {
		print('<div class="pageGuide" align="center"><a href="'.$extraguide[$i][1].'">&raquo;'.$extraguide[$i][0].'</a></div>');
}
?>
<table class="pageGuide">
  <tr>
    <td class="left"><?php if ($pagenow>1) { ?><a href="<?php echo $url_base.'page='; echo($pagenow-1); ?>"><?php echo PrevPage; ?></a><?php } ?></td>
    <td class="center"><?php echo str_replace("YYY",$pagetotal,str_replace("XXX",$pagenow,ThisIsPageXXXOfYYY)); ?></td>
    <td class="right"><?php if ($pagenow<$pagetotal) { ?><a href="<?php echo $url_base.'page='; echo($pagenow+1); ?>"><?php echo NextPage; ?></a><?php } ?></td>
  </tr>
</table>
<hr class="nextToResults">
<?php
for ($i=0;$i<count($outputitem);$i++) {
	if ($outputtype == "channel") 	out_author($outputitem[$i][0],$outputitem[$i][1],$outputitem[$i][2],$outputitem[$i][3],$outputitem[$i][4]);
	elseif ($outputtype == "list") 	out_list($outputitem[$i][0],$outputitem[$i][1],$outputitem[$i][2],$outputitem[$i][3],$outputitem[$i][4]);
	else 							out($outputitem[$i][0],$outputitem[$i][1],$outputitem[$i][2],$outputitem[$i][3],$outputitem[$i][4],$outputitem[$i][5],$outputitem[$i][6],$outputitem[$i][7],$outputitem[$i][8]);
}?>
<hr class="nextToResults">
<table class="pageGuide">
  <tr>
    <td class="left"><?php if ($pagenow>1) { ?><a href="<?php echo $url_base.'page='; echo($pagenow-1); ?>"><?php echo PrevPage; ?></a><?php } ?></td>
    <td class="center"><?php echo str_replace("YYY",$pagetotal,str_replace("XXX",$pagenow,ThisIsPageXXXOfYYY)); ?></td>
    <td class="right"><?php if ($pagenow<$pagetotal) { ?><a href="<?php echo $url_base.'page='; echo($pagenow+1); ?>"><?php echo NextPage; ?></a><?php } ?></td>
  </tr>
</table>
<?php
include(THEME_PATH."/footer.php");
?>