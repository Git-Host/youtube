<?php 
include('local/language.php'); 
if (isset($_GET['change'])){
	@session_start();
	$_SESSION["local"]=$_GET['change'];
	setcookie("local", $_GET['change'],time()+7*24*3600);
	$put_msg=1;
}

include(THEME_PATH."/local.php");
?>