<?php 
require('tokenmen.php'); 
include_once("../local/env_var.php");
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理中心</title>
<link href="s1.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#c {
	font-size: 14px;
	color: #000000;
	font-family: "Courier New", "Courier", "mono";
	height: 20em;
	width: 40em;
	border-top-width: 10px;
	border-right-width: 10px;
	border-bottom-width: 10px;
	border-left-width: 10px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #999999;
	border-right-color: #999999;
	border-bottom-color: #999999;
	border-left-color: #999999;
	padding: 5px;
	margin: 5px;
	background-color: #E7F1E7;
}
-->
</style>
<style type="text/css">
<!--
.c_box {
	background-color: #CCCCCC;
	padding: 10px;
	border: 1px solid #666666;
	text-align: center;
}
-->
</style>
</head>

<body>
<h2>你管索引后台</h2>
<h3>HTML嵌入代码修改</h3>
<h5>当前你管索引版本: <?php echo CURRENT_VERSION ?></h5>
<?php //if (function_exists("iconv")) { ?>
<p>HTML嵌入代码工作原理是<b>在&lt;/head&gt;前面加入代码</b>。以下为注意事项：</p>
<ul>
  <li>必须包含&lt;script&gt;和&lt;/script&gt;</li>
  <li>可以写SEO，例如【&lt;meta name=&quot;Description&quot; contect=&quot;这是一个视频网站&quot;&gt;&lt;/meta&gt;】</li>
  <li>可以写php代码，例如【&lt;?php echo(&quot;你的IP是&quot;.$_SERVER[&quot;REMOTE_ADDR&quot;]); 
    ?&gt;】</li>
</ul>
<?php 
	if (isset($_POST["c"])) {
		if (strlen($_POST["c"])>0) {
			if (get_magic_quotes_gpc()==1)
				$temp = stripcslashes($_POST["c"]);
			else
				$temp = $_POST["c"];
				
			if (file_put_contents("../local/codedef/before_head.php","UTF-8",$temp)!=false) {
				$m="更新完毕。";
			} else {
				$m="写入失败。请删除local\codedef文件夹里面的before_head.php。如果还是失败，请尝试修改local\codedef权限为最高权限";
			}
		} else {
			$m="是不是忘记写内容了？";
		}
		echo '<div style="color:#f00;font-size:18px;padding:5px;background:#fff" align="center">'.$m.'</div>';
	}
?>
<form method="post" action="">
    <label>在这里输入代码<br>
	<div class="c_box"><textarea name="c" id="c"><?php 
	@print(file_get_contents("../local/codedef/before_head.php"));
	?></textarea></div>
    </label>
  <p>
    <input type="submit" value="更新">
  </p>
  </form>
<?php /*}else{ ?>
<p><font color="#990000"><br>
  </font></p>
<hr>
<hr>
<hr>
<font color="#990000"><br>
很抱歉，该服务器上没有安装iconv组件。不过没关系，代码文件放在local\codedef\before_head.php里面。</font>
<p><font size="4"><b>解决方法</b></font></p>
<p>如果你可以安装，请安装之。如果不可以安装iconv，</p>
<p>你可以使用非微软的文档编辑器（如Notepad++）编辑它。</p>
<p><b>编码格式</b>：不带BOM的UTF-8</p>
<hr>
<hr>
<hr>
<p> 
  <?php } */?>
</p>
<hr>
<p style="font-size:12px;"> <a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a> 
</p>
</body>
</html>
