<?php 
include('local/language.php'); 
if (isset($_GET['change'])){
	@session_start();
	$_SESSION["orderby"]=$_GET['change'];
	setcookie("orderby", $_GET['change'],time()+7*24*3600);
	if (isset($_GET['back'])) {
		header('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	$put_msg=1;
}

include(THEME_PATH."/orderby.php");
?>