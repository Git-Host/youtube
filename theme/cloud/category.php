<?php 
$pageTitle = $tit." - ".WEBSITE_TITLE;
$pageHideLeft = 0;
$pageHideRight = 0;
include(THEME_PATH."/header.php");
print("<h3>$tit</h3>");
if (isset($extramsgs)) foreach($extramsgs as $showtemp1) print($showtemp1);
print(ThisIsTheCategory);?>
<div><ul><?php 
foreach($Category as $id=>$name) { 
	if ((strpos(substr($id,strlen($parent)+2),'/')==false) & (substr($id,0,strlen($parent))==$parent)) {
	?><li class="category_list_item" style="float:left;clean:both;margin:10px;">
	<a href="?type=<?php echo $id; ?>" style="padding:5px;text-align:center;height:70px;width:250px;font-size:18px;">
	<img style="zoom:0.5;float:left;" src="http://commondatastorage.googleapis.com/ngsy/cimage/<?php echo $id; ?>.png"><br>
    <?php echo $name; ?>
	</a>
	</li><?php 
	}
} ?>
</ul></div>
<?php
include(THEME_PATH."/footer.php");
?>