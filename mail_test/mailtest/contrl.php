<!DOCTYPE html>
<!--<html lang="en">
<head>
    <title>邮件测试系统</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <script src="./bootstrap/js/bootstrap.js"></script>
     <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
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
-->
<?php
$send_username=$_POST['send_username'];
$send_passwd=$_POST['send_passwd'];
$send_server=$_POST['send_server'];
$time_space=$_POST['time_space'];
$rec_username=$_POST['rec_username'];
$rec_passwd=$_POST['rec_passwd'];
$act_start=$_POST['start'];
$act_stop=$_POST['stop'];
$command=$_POST['command'];
//echo "act is ". $command . "\n";
if ($act_start==NULL)
	$act_start="null";
if ($act_stop==NULL)
	$act_stop="null";
$msg_arr=array('send_username'=>$send_username, 'send_passwd'=>$send_passwd,'send_server'=>$send_server,'time_space'=>$time_space,'rec_username'=>$rec_username,'rec_passwd'=>$rec_passwd,'act_start'=>$act_start,'act_stop'=>$act_stop,'command'=>$command);
$jsoncode=json_encode($msg_arr); //json格式的发送消息
//echo $jsoncode;
error_reporting(E_ALL);  
set_time_limit(0);  
$address="localhost";
$service_port=8001;
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);  
if ($socket < 0)  
{  
	echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";  
}  
else  
{  
	echo "create socket success.\n";  
}  
  
//echo "试图连接 '$address' 端口 '$service_port'...<br>";  
$result = socket_connect($socket, $address, $service_port);  
if ($result < 0)  
{  
	echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";  
}  
else  
{  
	echo "connect server success!<br>";  
}  
  
//$in = "1\r\n";  
  
  
if(!socket_write($socket, $jsoncode, strlen($jsoncode)))  
{  
	echo "socket_write() failed: reason: " . socket_strerror($socket) . "\n";  
}  
else  
{  
	echo "send msg success!<br>";  
//	echo "发送的内容为:<font color='red'>$jsoncode</font> <br&gt;";  
}  
  
socket_close($socket);  
echo "<script language=javascript>history.go(-1)</script>";
?>
<!--
<br>
<br>
<br>
<button type="button" class="btn" onclick ="location.href='index.php'" >返回</button>
</div>
</body>
-->
