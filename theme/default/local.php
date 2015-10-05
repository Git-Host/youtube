<?php 
$pageTitle = LocalChooser." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
function ExtraHead() { ?>
<style type="text/css">
<!--
#countries a,li {
	margin: 10px;
	padding: 5px;
	width: 120px;
	float: left;
	border: none;
	height: 40px;
	text-decoration: none;
	font-size: 18px;
}
#countries a:hover {
	background-color:#E7D2C5;
	font-weight: bold;
}
-->
</style><?php }
include(THEME_PATH."/header.php"); ?>
<?php
if ($put_msg==1){
	put_alert(YourChangeHasBeenApplied);
}
?>
<h3><?php echo LocalChooser; ?></h3>
<p><?php echo PleaseChooseLocal; ?></p>
<p><?php echo ThisIsThePlaceList; ?></p>
<ul id="countries"> 
<?php foreach($CountryCode as $id=>$name) {?>
<li>
<a href="?change=<?php echo $id; ?>"><img class="localimg" src="images/cc/<?php echo $id; ?>.png"> 
<?php echo $name; ?>
</a> 
</li>
<?php } ?>
</ul>
<?php include(THEME_PATH."/footer.php"); ?>