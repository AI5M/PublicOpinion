<?php 
	$username = 'ken-alex';
  	$password = '0000';
	$host = '127.0.0.1';
  	$database = 'public_opinion';
	$link = mysqli_connect($host,$username,$password,$database)
						or die('Error with MySQL connection');//連接伺服器
						# where'news_info.source'='蘋果'
	mysqli_set_charset($link, "UTF8");
?>
