<?php
	session_start();
	require_once('connDB.inc.php');
	$sql = "SELECT source ,category_name, title, create_time, site_url, category_color From news_info ";
	$condition = "";
	$hasCondition = false;
	if(isset($_POST['source'])){
		$source = join("','",$_POST['source']);
		$condition .= "WHERE(";
		$condition .= "source IN('".$source."'))";
		$hasCondition = true;
	}
	if(isset($_POST['category'])){
		$category = join("','",$_POST['category']);
		if($hasCondition) $condition .= "AND(" ;
		else $condition .= "WHERE(";
		$condition .= "category_name in ('".$category."'))";
	}

	if(isset($_POST['keyword']) && 	trim($_POST['keyword']) != ''){
		$keyword = explode(" ", $_POST['keyword']);
		if($hasCondition) $condition .= "AND(";
		else $condition .= "WHERE(";
		for ($i=0; $i<count($keyword); $i++) { 
			if($i>0) $condition .= "OR";
			$condition .= "(title LIKE '%".$keyword[$i]."%')";
		} 
		$condition .= ")";
	}
	
	if(isset($_POST['date']) && $_POST['date']!=0){
		$today = strtotime(date("Y/m/d"));
		$tomorrow = strtotime("+1 day", $today);

		$date = $_POST['date'];
		if($hasCondition) $condition .= "AND(";
		else $condition .= "WHERE(";
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
		$condition .= "create_time BETWEEN $startDate AND $endDate) ";
		// echo(date("Y/m/d",$startDate));
		// echo(date("Y/m/d",$endDate));
	}

	$sql .= $condition;
	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	$total = mysqli_num_rows($result);
	$pageSize = 50;
	$startPage = ($_POST['page'])*$pageSize;
	$totalPage = ceil($total/$pageSize); //总页数

	$arr['total'] = $total;
	$arr['pageSize'] = $pageSize;
	$arr['totalPage'] = $totalPage;

	$sql .="ORDER BY create_time DESC ";
	$_SESSION['source'] = "news_info";
	$_SESSION['condition'] = $condition;
	$sql .="LIMIT $startPage,$pageSize";
	// echo "$sql";
	$result = mysqli_query($link,$sql) or die("Error with SQL query 1");
	while($row = mysqli_fetch_assoc($result)){
		$rsource = $row['source'];
		$rcategory = $row['category_name'];
		$rtitle = $row['title'];
		$rcreate_time = date("Y/m/d",($row['create_time']-8*3600));
		$rsite_url = $row['site_url'];
		$rcolor = $row['category_color'];
		$arr['list'][] = array(
		 	'source' => $row['source'],
			'category_name' => $row['category_name'],
			'title' => $row['title'],
			'create_time' => date("Y/m/d",$row['create_time']-8*3600),
			'site_url' => $row['site_url'],
			'color' => $row['category_color'],
		 );

		// echo "<tr>";
		// echo "<td><h2>$rsource</h2></td>";
		// echo "<td><h3 style='background-color: $rcolor;'>$rcategory</h3></td>";
		// echo "<td><h1><a href='$rsite_url'>$rtitle</a></h1></td>";
		// echo "<td><h2>$rcreate_time</h2></td>";
		// echo "</tr>";
	}
	echo json_encode($arr);

	/*news_info	 =	CREATE VIEW news_info AS 
					SELECT '蘋果' as source, category_name, title, content, create_time, site_url, category_color
					From apple, article_category 
					WHERE (apple.category_id = article_category.category_id) 
					UNION ALL
					SELECT '中時' as source, category_name, title, content, create_time, site_url, category_color
					From chinatimes, article_category 
					WHERE (chinatimes.category_id = article_category.category_id) 
					UNION ALL
					SELECT '自由' as source, category_name, title, content, create_time, site_url, category_color
					From ltn_realtime, article_category 
					WHERE (ltn_realtime.category_id = article_category.category_id)*/	


?>

