<?php 
	header('Content-Description: File Transfer');
	header("Content-type: text/csv; charset=utf-8");  
	header("Content-disposition: attachment; filename=result.csv");
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');

	session_start();
	require_once('connDB.inc.php');
	if(isset($_SESSION['sql'])){
		$sql = "SELECT * FROM ".$_SESSION['source']." ";
		$sql .= $_SESSION['condition'];
	}
	echo chr(0xEF).chr(0xBB).chr(0xBF);
	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	$total_fields = mysqli_num_fields($result);
	while($row = mysqli_fetch_row($result)){
		for($i=0; $i<$total_fields; $i++){
			echo $row[$i].",";
		}
		echo "\n";
	}
 ?>