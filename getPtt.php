<?php
	require('connDB.inc.php');

	$sql = "SELECT board_name,board_class,title,push,shush,create_time,url FROM ptt ";
	$hasCondition = false;
	if(isset($_POST['board'])){
		$board = $_POST['board'];
		if($board != '不限'){
			$sql .= "WHERE (board_name='".$board."')";
			$hasCondition = true;
		}
	}

	if(isset($_POST['keyword']) && 	trim($_POST['keyword']) != ''){
		$keyword = explode(" ", $_POST['keyword']);
		if($hasCondition) $sql .= "AND(";
		else $sql .= "WHERE(";
		for ($i=0; $i<count($keyword); $i++) { 
			if($i>0) $sql .= "OR";
			$sql .= "(title LIKE '%".$keyword[$i]."%')";
		} 
		$sql .= ")";
	}

	if(isset($_POST['date']) && $_POST['date']!=0){
		$today = strtotime(date("Y/m/d"));
		$tomorrow = strtotime("+1 day", $today);

		$date = $_POST['date'];
		if($hasCondition) $sql .= "AND(";
		else $sql .= "WHERE(";
		switch ($date) {
			case '1':
				$startDate = $today;
				$endDate = $tomorrow;
				break;
			case '15':
				$startDate = strtotime("-15 day", $tomorrow);
				$endDate = $tomorrow;
				break;
			case '30':
				$startDate = strtotime("-30 day", $tomorrow);
				$endDate = $tomorrow;
				break;
			case '-1':
				$startDate = strtotime($_POST['startDate']);
				$endDate = strtotime($_POST['endDate']);
				$endDate = strtotime("+1 day", $endDate);
				break;
		}
		$sql .= "create_time BETWEEN $startDate AND $endDate) ";
	}

	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	$total = mysqli_num_rows($result);
	$pageSize = 50;
	$startPage = ($_POST['page'])*$pageSize;
	$totalPage = ceil($total/$pageSize); //总页数

	$arr['total'] = $total;
	$arr['pageSize'] = $pageSize;
	$arr['totalPage'] = $totalPage;

	$sql .="ORDER BY create_time DESC ";
	$sql .="LIMIT $startPage,$pageSize";

	// echo "$sql";

	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	while($row = mysqli_fetch_assoc($result)){
		$arr['list'][] = array(
		 	'board' => $row['board_name'],
			'board_class' => $row['board_class'],
			'title' => $row['title'],
			'push' => $row['push'],
			'shush' => $row['shush'],
			'create_time' => date("Y/m/d",$row['create_time']),
			'url' => $row['url'],
		 );

		// echo "<tr>";
		// echo "<td><h2>$rsource</h2></td>";
		// echo "<td><h3 style='background-color: $rcolor;'>$rcategory</h3></td>";
		// echo "<td><h1><a href='$rsite_url'>$rtitle</a></h1></td>";
		// echo "<td><h2>$rcreate_time</h2></td>";
		// echo "</tr>";
	}
	echo json_encode($arr);
?>