<?php 
session_start();
if (file_exists("pswcon.php")) {
	include_once("pswcon.php");
} else {
	define("ADMIN_PASSWORD","123456");
}

$login=false;
if ($_SESSION["psw"]==ADMIN_PASSWORD) {
	$login=true;
} else {
	if ($_COOKIE["psw"]==ADMIN_PASSWORD) {
		$login=true;
	} else {
		if ($_POST["psw"]==ADMIN_PASSWORD) {
			$login=true;
		}
	}
}
if (!$login) {
	header("Location: index.html");
	print('<META HTTP-EQUIV="Refresh" CONTENT="10;URL=index.html">You did not <a href="index.html">login</a>.');
	exit();
}