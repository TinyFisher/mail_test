<!DOCTYPE html>
<html lang="en">
<head>
    <title>邮件测试系统</title>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <script src="./bootstrap/js/bootstrap.js"></script>
     <link href="./bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<script type="text/javascript">
function change()
{
	var warntime=document.getElementById("warn").value;
	var selectObj=document.getElementById("warn_time");
	for (i=0; i< selectObj.options.length; i++){
    var curOptObj=selectObj.options[i];
    var curText=curOptObj.value;
    if(warntime==curText){
        curOptObj.selected=true;
	}
	}
}
</script>

<body onload="change()">
<div class="well">
<div class="navbar">
 <div class="navbar-inner">
   <div class="container">
        <a class="brand" href="#"> 邮件测试系统v1.0 </a>
		<ul class="nav">
        <li >
        <a href="index.php">邮件配置</a>
        </li>
        <li><a href="show.php">收发件信息展示</a></li>
        <li class="active"><a href="warn.php">告警配置</a></li>
        </ul>
   </div>
  </div>
</div>
<div>
<form action="warn.php" type="get">
	<div>
	<h4>告警阀值</h4>
	<select name="warn_time" id="warn_time" >
		<option value="5">5min</option>
		<option value="10">10min</option>
		<option value="30">30min</option>
	</select>
	&nbsp <button type="submit" class="btn" id="start" >确定</button>
	</div>
</form>
</div>
<div>
<div>
<h4>告警邮件</h4>
</div>
	<table class="table table-bordered">
	<tr>
<!--	<th>序号</th>-->
	<th>邮件序列号</th>
	<th>发件人</th>
	<th>发件服务器地址</th>
	<th>收件人</th>
	<th>发件时间</th>
	<th>收件时间</th>
	<th>收发件时间间隔(单位：s)</th>
<!--	<th>是否已告警</th> -->
	</tr>
	<!--
	<tr>
	<td>1</td>
	<td>2345</td>
	<td>tinyfisher@foxmail.com</td>
	<td>10.0.0.1</td>
	<td>usertest@sina.com.cn</td>
	<td>2014-01-08 12:33:44</td>
	<td>2014-01-08 12:34:44</td>
	<td>1</td>
	<td></td>
	</tr>
	-->
	<?php
	
	$con = mysql_connect("localhost","root","19890804");
	if (!$con)
		  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db("mailtest", $con);
	$warn_time=$_GET['warn_time'];	
	$perNumber=10; //每页显示的记录数
	$page=$_GET['page']; //获得当前的页面值
	if ($warn_time==NULL)
		$warn_time=5;
	$warn_time=$warn_time*60;
	$count=mysql_query("select count(*) from mailtest where timespace > $warn_time"); //获得记录总数
	$rs=mysql_fetch_array($count); 
	$totalNumber=$rs[0];
	$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
	if (!isset($page)) {
	 $page=1;
	} //如果没有值,则赋值1
	$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
	$result=mysql_query("select * from mailtest where timespace>$warn_time limit  $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
	while ($row=mysql_fetch_array($result)) {
		  echo "<tr>";
		 // echo "<td>" . $row['id'] . "</td>";
		  echo "<td>" . $row['seq'] . "</td>";
		  echo "<td>" . $row['senduser'] . "</td>";
		  echo "<td>" . $row['sendserver'] . "</td>";
		  echo "<td>" . $row['recuser'] . "</td>";
		  echo "<td>" . $row['sendtime'] . "</td>";
		  echo "<td>" . $row['rectime'] . "</td>";
		  echo "<td>" . $row['timespace'] . "</td>";
		  //echo "<td>" . $row['warn'] . "</td>";
		  echo "</tr>";
	}
?>
	<input type="hidden"  id="warn" value="<?php echo $warn_time;?>">
</table>
	</div>
	<div class="pagination" align="center">
	<ul>
	<?php
	if ($page != 1) { //页数不等于1
	?>
		<li><a href="warn.php?page=<?php echo $page - 1;?>&warn_time=<?php  echo $warn_time; ?>">上一页</a></li> <!--显示上一页-->
	<?php
	}
	for ($i=1;$i<=$totalPage;$i++) {  //循环显示出页面
	?>
		<li id="<?php echo $i ?>" ><a href="warn.php?page=<?php echo $i;?>&warn_time=<?php  echo $warn_time; ?>"><?php echo $i ;?></a></li>
	<?php
	}
	if ($page<$totalPage) { //如果page小于总页数,显示下一页链接
	?>
		<li><a href="warn.php?page=<?php echo $page + 1;?>&warn_time=<?php  echo $warn_time; ?>">下一页</a></li>
	</ul>
	</div>
	<?php
	} 
	mysql_close($con);
	 
	?>


</div>
</div>
</body>


