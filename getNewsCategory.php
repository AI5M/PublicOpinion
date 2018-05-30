<?php 
	require('connDB.inc.php');
	$sql = "SELECT category_name AS c FROM article_category";
	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	$counter = 1;
	while($row = mysqli_fetch_assoc($result)){
		echo "<label class='checkbox' style='padding:3px;'>";
		echo "<input type='checkbox' name='category' value='".$row['c']."' checked />".$row['c'];
		echo "</label>";
		if($counter % 5 == 0) echo "<br>";
		$counter+=1;
	}
?>