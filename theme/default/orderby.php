<?php 
$pageTitle = OrderbyChooser." - ".WEBSITE_TITLE;
$pageHideLeft = 1;
function ExtraHead() { ?>
<style type="text/css">
<!--
#countries a,li {
	margin: 10px;
	padding: 5px;
	width: 180px;
	float: left;
	border: none;
	height: 60px;
	text-decoration: none;
	font-size: 14px;
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
<h3><?php echo OrderbyChooser; ?></h3>
<p><?php echo PleaseChooseOrderby; ?></p>
<p><?php echo ThisIsTheOrderbyList; ?></p>
<ul id="countries"> 
<?php foreach($OrderbyCode as $id=>$name) {?>
<li>
<a href="?change=<?php echo $id; ?>">
<?php echo $name; ?>
</a> 
</li>
<?php } ?>
</ul>
<?php include(THEME_PATH."/footer.php"); ?>