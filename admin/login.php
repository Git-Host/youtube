<?php
require('tokenmen.php');
$_SESSION["psw"]=$_POST["psw"]; 
if ($_POST["remember"]=='y') setcookie("psw", $_POST["psw"], time()+3600*24*7);
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登陆</title>
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
  <p><b><font color="#000000" size="4">:: 登陆成功 ::</font></b></p>
  <p>你已经登陆，<a href="panel.php">点击<b>这里</b>进入控制板</a></p><?php if ($_POST['remember']=='y') { ?>
  <p>“记住登陆”已经启用，有效期7天</p>
<?php } ?>
</div>
</body>
</html>
