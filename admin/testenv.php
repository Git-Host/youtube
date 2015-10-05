<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>你管索引环境测试</title>
<link href="s1.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.testcurl {
	overflow: scroll;
	height: 400px;
	width: 550px;
}
-->
</style>
<style type="text/css">
<!--
-->
</style>
</head>

<body>
<p>这是什么？</p>
<p>你管索引环境测试用于测试当前服务器是否可以安你管索引。</p>

<table width="100%" border="0">
  <tr> 
    <td>
	<h2>cURL测试</h2><?php
$iscurl=function_exists("curl_init");	
?><blockquote>
        <p>cURL对于你管索引基础功能而言是可有可无的东西，不过最好还是有它。以下为cURL测试情况。</p><hr>
<?php if (!$iscurl) {?>
		<p>很遗憾，这个服务器没有安装cURL。可能导致的结果如下：</p>
		<ul>
          <li>无法获取视频长度</li>
          <li>缓存现象</li>
        </ul>
        <p>你可以尝试联系管理员并要求其安装cURL。</p>
<?php } else {?>
		<p>祝贺！本服务器上有cURL。</p>
<?php } ?>
    </blockquote></td>
  </tr>
  <tr>
    <td><h2>file_get_contents和allow_url_fopen测试</h2><?php
$iscurl=function_exists("file_get_contents");
$iscurl=$iscurl & ("1"==ini_get("allow_url_fopen"));	
?><blockquote>
        <p>file_get_contents是cURL的替代物，但是这个东西问题多……</p>
        <hr>
<?php if (!$iscurl) {?>
		<p>很遗憾，这个服务器没有开通file_get_contents，或者allow_url_fopen被关闭。</p>
		<p><b>如果你的服务器支持cURL，那么还可以使用。</b></p>
        <p>你可以尝试联系管理员并要求其开通file_get_contents并打开allow_url_fopen。</p>
        <?php } else {?>
        <p>祝贺！本服务器上有file_get_contents，并且allow_url_fopen被开启。</p>
<?php } ?>
    </blockquote></td>
  </tr>
  <tr>
    <td><h2>访问YouTube测试</h2><?php
	if (!function_exists("curl_init")) {
		$file_contents = file_get_contents("http://www.youtube.com");
	} else {
		$ch = curl_init();
		$timeout = 10;
		curl_setopt($ch, CURLOPT_URL, "http://www.youtube.com");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		$file_contents = curl_exec($ch);
		curl_close($ch);
	}
?><blockquote>
        <p>你管索引必须能够连接到YouTube，否则无法使用！！！</p>
        <hr>
<?php if (strlen($file_contents)<400) {?>
		<p>很遗憾，连接YouTube失败。</p>
        <p>你可以尝试联系管理员并要求其取消此限制。如果你认为这个结果不正确，请刷新页面以再次测试（可能是服务器网络质量差导致的）</p>
        <?php } else {?>
        <p>祝贺！连接YouTube成功。</p>
<?php } ?>
    </blockquote></td>
  </tr>
</table>
<hr>
<p style="font-size:12px;">
<a href="http://code.google.com/p/youtubeindex/">该站点基于《你管索引》，详情点击这里</a>
</p>
</body>
</html>