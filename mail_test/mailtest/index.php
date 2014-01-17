<!DOCTYPE html>
<html lang="en">
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
<div align="center">
<form action="contrl.php" method="post">
	<div>
		<label>发件人地址</label>
		<input type="text" class="span3" placeholder="Email" name="send_username">
	</div>
	<div>
		<label>发件人密码</label>
		<input type="text" class="span3" placeholder="Password" name="send_passwd">
	</div>
	<div>
		<label>发件服务器地址</label>
		<select name="send_server" >
			<option value="10.29.11.208">10.29.11.208</option>
			<option value="10.71.8.152">10.71.8.152</option>
			<option value="10.69.2.31">10.69.2.31</option>
		</select>
	</div>
	<div>
		<label>发件时间间隔</label>
		<select name="time_space" >
			<option value="3">3s</option>
			<option value="5">5s</option>
			<option value="10">10s</option>
		</select>
	</div>
	<div>
		<label>收件人地址</label>
		<input type="text" class="span3" placeholder="Email" name="rec_username">
	</div>
	<div>
		<label>收件人密码</label>
		<input type="text" class="span3" placeholder="Password" name="rec_passwd">
	</div>
    <button type="submit" class="btn" id="start" >开始</button>
    <button type="button" class="btn" id="stop">停止</button>
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


