<?php
$_gfw_keys=null;
$_gfw_key_count=null;

function initGFW($keyfilename){
	if(!file_exists($keyfilename)) return false;
	global $_gfw_keys;
	global $_gfw_key_count;
	$_gfw_keys = file($keyfilename.(($_SERVER["HTTPS"]=="on")?'.small':''));
	$_gfw_key_count = count($_gfw_keys)-1;
	return true;
}
function hasBadKey($str1){
	global $_gfw_keys;
	global $_gfw_key_count;
	if ($_gfw_keys==null) return false;
	if ($_gfw_key_count==null) return false;
	$str="_".trim($str1)."_";
	for ($i=1; $i<$_gfw_key_count; $i++){
		$temp1 = trim($_gfw_keys[$i]);
		if (stripos($str,$temp1)!=false) return true;
	}
	return false;
}
// hasBadKey(string) truefalseʾǷд
?>