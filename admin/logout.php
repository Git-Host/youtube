<?php 
@session_start();
$_SESSION["psw"]="";
@setcookie("psw", "", time()-1);
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>退出</title>
<style type="text/css">
<!--
.b1 {
	margin: 10px;
	padding: 10px;
	width: 80%;
	border: 1px dotted #006699;
	background-color: #A8D1E6;
	font-size: 14px;
}
body {
	background-color: #ACC8D7;
	text-align: center;
}
body,a {
	color: #15394A;
	text-decoration: none;
}
-->
</style>
</head>

<body>
<div class="b1"> 
  <p><b><font color="#000000" size="4">:: 退出 ::</font></b></p>
  <p>你已经退出，<a href="index.html">点击<b>这里</b>回到主页</a></p>
</div>
</body>
</html>
