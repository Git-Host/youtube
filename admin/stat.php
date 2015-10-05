<?php 
require('tokenmen.php'); 
include_once("../local/env_var.php");
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理中心</title>
<link href="s1.css" rel="stylesheet" type="text/css">
</head>

<body>
<h2>你管索引后台</h2>
<h3>统计数据</h3>
<h5>当前你管索引版本: <?php echo CURRENT_VERSION ?></h5>
<hr>
<h4>视频代理流量</h4>
<p>仅统计视频带来的流量</p>
<?php if (isset($_GET['date'])) {echo "<pre>".file_get_contents('../stat/'.$_GET['date'].'.txt')."</pre>"; 
}?>
<form>
<select name="date"><?php foreach (glob("../stat/*.txt") as $filename) {?>
  <option><?php echo basename($filename,".txt"); ?></option>
<?php } ?></select><input value="查看" type="submit">
</form>
<hr>
<h4>来访者、来路、区域分布等</h4>
<p>很遗憾，当前你管索引还没有统计功能。你可以尝试一下这两个免费统计服务，把他们的统计代码使用“<a href="code.php">HTML嵌入代码修改</a>”工具插入你的网站。</p>
<p>我推荐的</p>
<ul>
  <li><font size="4"><a href="http://www.google.com/analytics/">Google Analytics</a></font><br>
    - 中文界面，而且很好用，可以准确显示全球访客来源，以及许多有趣功能。但是要求电脑性能够好，否则后台页面很卡。
</li>
  <li><a href="http://www.cnzz.com/"><font size="4">cnzz</font></a><br>
  - 中国站长几乎都知道的，不少个人网站都有
</li>
</ul>
<hr>
<p style="font-size:12px;"> <a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a> 
</p>
</body>
</html>