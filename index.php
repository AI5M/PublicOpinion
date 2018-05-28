<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="no-cache" /> <!-- 不使用快取 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="bootstrap-3.3.7//css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/all.css">
    
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script src="bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-TW.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/all.js"></script>
    <title>輿情蒐集系統</title>
</head>

<body>

	<!-- sidebar start -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h2>輿情蒐集系統</h2>
        </div>

		<div class="sidebar-body">
	        <ul class="list-unstyled components">
	            <li class="active">
	                <a href="index.php">總覽</a>
	            </li>
	            <li>
	            	<a href="#newsMenu" data-toggle="collapse" aria-expanded="false">新聞網</a>
	                <ul class="list-unstyled collapse" id="newsMenu">
	                    <li><a href="?source=apple">蘋果即時新聞</a></li>
	                    <li><a href="?source=chinatimes">中時電子報</a></li>
	                    <li><a href="?source=ltn">自由時報電子報</a></li>
	                </ul>
	            </li>
	            <li>
	            	<a href="#forumMenu" data-toggle="collapse" aria-expanded="false">論壇</a>
					<ul class="list-unstyled collapse" id="forumMenu">
						<li><a href="#">論壇1</a></li>
						<li><a href="#">論壇2</a></li>
						<li><a href="#">論壇3</a></li>
						<li><a href="#">論壇3</a></li>
					</ul>
	            </li>
	            <li><a href="?source=ptt">PTT</a></li>
	        </ul>
	    </div>
	</nav>
    <!-- sidebar end -->

	<!-- contnet start-->
	<div id="content">

		<div class="search">
			<form action="" class="form-inline" onsubmit="return false;">
				<?php
					if(isset($_GET['source']) && $_GET['source'] == 'ptt')
						include_once('pttSearchCondition.php'); 		
					else
						include_once('newsSearchCondition.php');
				?>
			</form>
		</div>

		<div class="result">
			<div id="loading"></div>
			<table class="table table-striped table-hover">
				<tbody>

				</tbody>
			</table>
			<div id="pageCount"></div>
		</div>
    </div>
    <!-- content end -->
</body>
    <?php
		if(isset($_GET['source'])){ 
			switch($_GET['source']){
				case 'apple':
					$source = "蘋果";
					echo "<script>$('#subtitle').append('>蘋果即時新聞')</script>";
					break;
				case 'chinatimes':
					$source = "中時";
					echo "<script>$('#subtitle').append('>中時電子報')</script>";
					break;
				case 'ltn':
					$source = "自由";
					echo "<script>$('#subtitle').append('>自由時報電子報')</script>";
					break;
				case 'ptt':
					$source = "ptt";
					echo "<script>$('#subtitle').append('>PTT')</script>";
					break;	
			}
			if($source == "ptt")
				echo "<script>getPtt(1);</script>";
			else
				echo "<script>setSource('".$source."');</script>";
		}else{
			echo "<script>getData();</script>";
		}
	?>
</html>