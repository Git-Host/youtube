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
#m {
	border: 1px solid #598297;
	background-color: #94BACB;
	padding: 5px;
	margin: 5px;
}
#m td {
	width:160px;
	height:160px;
	text-align: center;
}
#m a img {
	border: none;
}
#m a {
	font-size: 18px;
	color: #003366;
	text-decoration: none;
	line-height: 40px;
}
-->
</style>
</head>

<body>
<h2>你管索引后台</h2>
<h3>主页</h3>
<h5>当前你管索引版本: <?php echo CURRENT_VERSION ?></h5>
<div align="center">
  <table cellpadding="0" id="m">
    <tr> 
      <td bgcolor="#C1E3BF"><a href="stat.php"><img src="images/stat.png"><br>
        统计数据</a></td>
      <td bgcolor="#C1C0E2"><a href="code.php"><img src="images/code.png"><br>
        HTML嵌入代码</a></td>
      <td><a href="config.php"><img src="images/config.png"><br>
        我的选项</a></td>
    </tr>
    <tr> 
      <td><a href="#"><img src="images/earth.png"><br>
        (保留)</a></td>
      <td bgcolor="#CBE0E9"><a href="http://code.google.com/p/youtubeindex/issues/entry"><img src="images/ask.png"><br>
        信息反馈</a></td>
      <td bgcolor="#E1C1C4"><a href="http://code.google.com/p/youtubeindex/"><img src="images/update.png"><br>
        检查更新</a></td>
    </tr>
    <tr> 
      <td bgcolor="#D6EAC1"><a href="testenv.php"><img src="images/server.png"><br>
        环境测试</a></td>
      <td><a href="skin.php"><img src="images/skin.png"><br>
        皮肤更换</a></td>
      <td bgcolor="#CBD8CC"><a href="logout.php"><img src="images/exit.png"><br>
        安全退出</a></td>
    </tr>
  </table>
</div>
<hr>
<p style="font-size:12px;"> <a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a> 
</p>
</body>
</html>
