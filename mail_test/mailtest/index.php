<!DOCTYPE html>
<html lang="en">
<head>
    <title>邮件测试系统</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <script src="./bootstrap/js/bootstrap.js"></script>
     <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<script type="text/javascript">
function check()
{
	var send_username=document.getElementById("send_username").value;
	var send_passwd=document.getElementById("send_passwd").value;
	var rec_username=document.getElementById("rec_username").value;
	var rec_passwd=document.getElementById("rec_passwd").value;
	if(send_username=='')
	{
		alert ("发件人不能为空！");
		return false;
	}
	else if(rec_username=='')
	{
		alert ("收件人不能为空！");
		return false;
	}
}

function checkon()
{
	var result=check();
	if (result!=false)
	{
		alert("开始测试！");
		document.getElementById("start").disabled=true;
		document.getElementById("stop").disabled=false;
		document.getElementById("start").value="stop";
		document.getElementById("stop").value="start";
		document.getElementById("command").value="start";
		add_((document.getElementById("send_username")));
		add_((document.getElementById("send_passwd")));
		add_((document.getElementById("rec_username")));
		add_((document.getElementById("rec_passwd")));
		add_((document.getElementById("send_server")));
		add_((document.getElementById("time_space")));
		add_((document.getElementById("start")));
		add_((document.getElementById("stop")));
		document.getElementById('myform').submit();
		return true;
	}
	else
	{
		return false;
	}
}

function stop_send()
{
	alert("停止测试！");
	document.getElementById("start").disabled=false;
	document.getElementById("stop").disabled=true;
	document.getElementById("start").value="start";
	document.getElementById("stop").value="stop";
	document.getElementById("command").value="stop";
	add_((document.getElementById("start")));
	add_((document.getElementById("stop")));
	document.getElementById('myform').submit();
	return true;
}

function addCookie(objName,objValue,objHours){//添加cookie
	var str = objName + "=" + escape(objValue);
	if(objHours > 0){//为0时不设定过期时间，浏览器关闭时cookie自动消失
		var date = new Date();
	var ms = objHours*3600*1000;
date.setTime(date.getTime() + ms);
str += "; expires=" + date.toGMTString();
}
document.cookie = str;
}


function getCookie(objName){//获取指定名称的cookie的值
var arrStr = document.cookie.split("; ");
for(var i = 0;i < arrStr.length;i ++){
var temp = arrStr[i].split("=");
if(temp[0] == objName) return unescape(temp[1]);
}
}

function add_(obj){
	addCookie(obj.name,obj.value,10000);
}

function get_(_form){
	for(i=0;i < document.forms[_form].length;i++){
         element = document.forms[_form][i];
		 cookieV = getCookie(element.name)
		 if(element.name=="start")
		 {
			 if(cookieV =="stop")
				 element.disabled=true;
			 else
				 element.disabled=false;
		 }
		 else if(element.name=="stop")
		 {
			 if(cookieV =="start")
				 element.disabled=false;
			 else
				 element.disabled=true;
		 }
		 else if (typeof(cookieV) != 'undefined')
		 {
			element.value = cookieV;
		 }
    }
}
</script>

<body onload="get_('myform')">
<div class="well" >
<div class="navbar">
 <div class="navbar-inner">
   <div class="container">
        <a class="brand" href="#"> 邮件测试系统v1.0 </a>
		<ul class="nav">
        <li class="active">
        <a href="index.php">邮件配置</a>
        </li>
        <li><a href="show.php">收发件信息展示</a></li>
        <li><a href="warn.php">告警配置</a></li>
        </ul>
   </div>
  </div>
</div>
<div align="center">
<form action="contrl.php" method="post" name="myform" id="myform">
	<div>
		<label>发件人地址</label>
		<input type="text" class="span3" placeholder="Email" name="send_username" id="send_username">
	</div>
	<div>
		<label>发件人密码</label>
		<input type="text" class="span3" placeholder="Password" name="send_passwd" id="send_passwd" >
	</div>
	<div>
		<label>发件服务器地址</label>
		<select name="send_server" id="send_server">
			<option value="10.29.11.208">10.29.11.208</option>
			<option value="10.71.8.152">10.71.8.152</option>
			<option value="10.69.2.31">10.69.2.31</option>
		</select>
	</div>
	<div>
		<label>发件时间间隔</label>
		<select name="time_space" id="time_space">
			<option value="3">3s</option>
			<option value="5">5s</option>
			<option value="10">10s</option>
		</select>
	</div>
	<div>
		<label>收件人地址</label>
		<input type="text" class="span3" placeholder="Email" name="rec_username" id="rec_username">
	</div>
	<div>
		<label>收件人密码</label>
		<input type="text" class="span3" placeholder="Password" name="rec_passwd" id="rec_passwd">
	</div>
	<input   name="command" id="command" type="hidden" value="command" >
    <button type="button" class="btn" name="start" id="start" value="start" onclick="checkon()" >开始</button>
    <button type="button" class="btn" name="stop" id="stop" value="stop" onclick="stop_send()" disabled>停止</button>
</form>
</div>
<?php
/*
$con = mysql_connect("localhost","root");
if (!$con)
	  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("mailtest", $con);

$result = mysql_query("SELECT * FROM mailtest");

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['seq'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
 */
?>
</div>
</body>


