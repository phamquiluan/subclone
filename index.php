<!DOCTYPE html>
<html>
<head>
	<title>Tăng Follow</title>
	<meta charset="utf-8" />
	<meta http-equiv="refresh" content="30">
	<link href="https://fonts.googleapis.com/css?family=Lemonada" rel="stylesheet">
	<style type="text/css">
		body {
			font-family: 'Lemonada', cursive;
			color: #59ff60;
		}
	</style>
</head>
<body background="background.jpg">
<?php 
	$id = '100004240663431';  //Thay ID buff sub ở đây 
	$tab = '8'; //Thay số tab vào đây 
	echo '<center><h1>Đang tiến hành tăng sub cho ID : '.$id.'</h1><br />Loading <img src="https://www.zopodo.com/tests/assets/images/fbloader.gif" width="15px" />  <br /> <h1> Số Tab đang bật: '.$tab.'</h1> ';
	for ($i=0; $i < $tab; $i++) { 
		echo '<iframe src="/sub.php?id='.$id.'"></iframe>';
	}
?>
</body>
</html>
