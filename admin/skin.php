<?php 
require('tokenmen.php'); 
include_once("../local/env_var.php");
$cur = "default"; //当前皮肤
if (file_exists("../local/codedef/theme.php")) {
	$cur = strstr(file_get_contents("../local/codedef/theme.php"),',"');
	$cur = substr($cur,2,strpos($cur,'"',3)-2);
}
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>皮肤更换</title>
<link href="s1.css" rel="stylesheet" type="text/css">
</head>

<body>
<h2>你管索引后台</h2>
<h3>皮肤更换</h3>
<h5>当前你管索引版本: <?php echo CURRENT_VERSION ?></h5>
<p>皮肤放置于<b>theme</b>文件夹内。你可以访问<a href="http://ng.laobubu.net/support/skin" target="_blank">http://ng.laobubu.net/support/skin</a>下载皮肤包并解压缩到那里</p>
<form method="post" action=""><font style="background-color:#ffffff" size="4" color="red"><?php if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (file_put_contents("../local/codedef/theme.php",'<?php define("THEME_PATH","theme/'.$_POST['skin'].'");'))  {
		echo "保存设置成功";
	}else{
		echo '更新失败，请修改/local/codedef的权限为7xx（例如757）';
	}
	$cur = $_POST['skin'];
} ?></font>
<table width="100%" border="0">
  <tr><?php 
$i = 0;
$p='[Name=(.*)\nVer=(.*)\nAuthor=(.*)\nContact=(.*)\n]';
foreach (glob("../theme/*",GLOB_ONLYDIR) as $filename) {
$t = file_get_contents($filename.'/function.php');
if (!preg_match($p,$t,$b)) {
$b=array("",basename($filename)."(无法解析名字)","","","");
}
?>
<td width="33%"><label><input type="radio" name="skin" value="<?php echo basename($filename); ?>"<?php if (basename($filename)==$cur) print(' checked'); ?>><?php echo $b[1];?><br>
<img src="../theme/<?php echo basename($filename); ?>/thumb.jpg" border="0"><br>
版本：<?php echo $b[2];?><br>
作者：<a href="<?php echo $b[4];?>" target="_blank"><?php echo $b[3];?></a><br>
</label></td>
<?php 
$i++;
if ($i==3){
	print("</tr><tr>");
	$i=0;
}
} ?>
  </tr>
</table><br><br><br>
<input type="submit" value="更换">
</form>
</p>
<hr>
<p style="font-size:12px;"> <a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a> 
</p>
</body>
</html>
