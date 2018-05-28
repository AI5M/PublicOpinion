<?php 
	require('connDB.inc.php');
	$sql = "SELECT board_name FROM ptt_board";
	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	while($row = mysqli_fetch_assoc($result)){
		echo "<option>".$row['board_name']."</option>";
	}
?>