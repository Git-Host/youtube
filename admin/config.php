<?php 
require('tokenmen.php'); 
include_once("../local/env_var.php");
$msg = '';
if ($_SERVER['REQUEST_METHOD']=='POST') {
	@chmod("../admin",0757);
	if (isset($_POST["domode"])) {	//修改密码
		@chmod("pswcon.php",0757);
		$out = '<?php define("ADMIN_PASSWORD","'.$_POST["cp"].'");';
		if (file_put_contents("pswcon.php",$out)!=false)
			$msg = '密码已经修改！请牢记你的密码';
		else
			$msg = '密码更新失败，请修改/admin的权限为7xx（例如757）';
	} else {
		@chmod("../local/codedef",0757);
		@chmod("../local/codedef/cons.php",0757);
		$out = file_get_contents("condemo.php");
		foreach ($_POST as $aaaa=>$bbbb)
			$out = str_replace('>'.$aaaa,$bbbb,$out);
		if (file_put_contents("../local/codedef/cons.php",$out)!=false)
			$msg = '设置已更新';
		else
			$msg = '更新失败，请修改/local/codedef的权限为7xx（例如757）';
	}
}
@include_once("../local/codedef/cons.php");
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理中心</title>
<link href="s1.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.em1 {
	font-style: italic;
	color: #666666;
	border-top-width: 5px;
	border-right-width: 5px;
	border-bottom-width: 5px;
	border-left-width: 5px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
	padding: 5px;
	margin: 10px;
}
-->
</style>
</head>

<body>
<h2>你管索引后台</h2>
<h3>我的选项 </h3>
<h5>当前你管索引版本: <?php echo CURRENT_VERSION ?></h5>
<p>在“我的选项”里面，你可以自定义一些你管索引的特性：</p>
<?php 
	if (strlen($msg)>0) {
		echo '<div style="color:#f00;font-size:18px;padding:5px;background:#fff" align="center">'.$msg.'</div>';
	}
?>
<form method="post" action="">
  <p><label>功夫网过滤范围
    <select name="flitercon" id="flitercon"> <!--
      <option value="no">无</option>
      <option value="result">索引结果</option> -->
      <option value="all" selected>索引结果和视频转播</option>
    </select></label>
  <div class="em1">你管索引自带过滤程序以防止网站被和谐，分三种等级：<br>
    一是完全自由，<br>
    二是过滤结果（默认，但是不法分子会通过特殊方法下载视频），<br>
    三就是完全过滤（特殊情况下使用，某些服务器会不正常）</div>
  </p>
  <p>
    <label><input name="hide_img_left" type="checkbox" id="hide_img_left" value="y"<?php if (CON_hide_img_left=="y") echo " checked";?>>隐藏左侧分类图像</label><br>
    <label><input name="hide_img_thumb" type="checkbox" id="hide_img_thumb" value="y"<?php if (CON_hide_img_thumb=="y") echo " checked";?>>隐藏视频缩略图</label>
  <div class="em1">为了防止网页载入因为图像而过卡，可以使用以上两个选项</div>
  </p>
  <p>
    <label>网站名称
    <input name="site_title" type="text" value="<?php print((defined("CON_site_title") & CON_site_title!==">site_title")?CON_site_title:"你管索引"); ?>" size="20" maxlength="20">
    </label>
  <div class="em1">从2.1.1版本开始，可以通过这里定义网站名了</div>
  </p>
  <p> 
    <label>
    <input name="protect_disable" type="checkbox" id="protect_disable" value="yes"<?php if (CON_protect_disable=="yes") echo " checked";?>>启用内存保护程序</label>
    <br>
    <label>当内存使用量达到<select name="protect_bfb" id="protect_bfb">
      <option<?php if(CON_protect_bfb=="99") echo " selected"; ?> value="99">99（默认值）</option>
      <option<?php if(CON_protect_bfb=="99.5") echo " selected"; ?>>99.5</option>
      <option<?php if(CON_protect_bfb=="98") echo " selected"; ?>>98</option>
      <option<?php if(CON_protect_bfb=="97") echo " selected"; ?>>97</option>
      <option<?php if(CON_protect_bfb=="96") echo " selected"; ?>>96</option>
      <option<?php if(CON_protect_bfb=="95") echo " selected"; ?>>95</option>
      <option<?php if(CON_protect_bfb=="94") echo " selected"; ?>>94</option>
      <option<?php if(CON_protect_bfb=="90") echo " selected"; ?>>90</option>
      <option<?php if(CON_protect_bfb=="86") echo " selected"; ?>>86</option>
      <option<?php if(CON_protect_bfb=="85") echo " selected"; ?>>85</option>
      <option<?php if(CON_protect_bfb=="82") echo " selected"; ?>>82</option>
      <option<?php if(CON_protect_bfb=="80") echo " selected"; ?>>80</option>
      <option<?php if(CON_protect_bfb=="75") echo " selected"; ?>>75</option>
      <option<?php if(CON_protect_bfb=="70") echo " selected"; ?>>70</option>
    </select>％时禁止创建视频流</label>
  <div class="em1">
  建议打开该保护程序。小心被服务器管理员suspend你的账户。<br><?php
  	$str = false;
	if (function_exists("shell_exec")) $str = @shell_exec('more /proc/meminfo');
  	if (false === $str) {
		print("……囧，你<b>还是屏蔽这个保护程序吧</b>。你管索引无法获悉内存使用率，免得系统又要进行多余的工作。<br>（顺便问一句，你是不是在使用非Linux的主机啊，或者管理员屏蔽了shell_exec）");
	} else {
		$pattern = "/(.+):\s*([0-9]+)/"; 
		preg_match_all($pattern, $str, $out);
		print("当前使用率为".(100*($out[2][0]-$out[2][1])/$out[2][0])."％");
	}
?></div>
  </p>
  
  <p>
    <input type="submit" value="更新">
  </p>
</form>
<hr>
<form method="post" action="">
  <p>
    <label>新密码
    <input name="cp" type="password" id="cp" maxlength="20">
    </label>
	<input name="domode" type="hidden" value="cp">
  <div class="em1">
    <p>默认密码是123456。如果修改不成功，可以使用以下任一方法：</p>
    <p><b>方法一</b>：修改tokenmen.php源代码中的123456为你的密码</p>
    <p><b><font color="#990000">密码切忌包含引号！</font></b></p>
  </div>
  <p>
    <input type="submit" value="更新">
  </p>
</form>
<hr>
<p style="font-size:12px;"> <a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a> </p>
</body>
</html>
