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
	                <a href="#">總覽</a>
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
	            <li><a href="#">PTT</a></li>
	        </ul>
	    </div>
	</nav>
    <!-- sidebar end -->

	<!-- contnet start-->
	<div id="content">

		<div class="search">
			<form action="" class="form-inline" onsubmit="return false;">
				<div>
					<div class="row">
						<h3 id="subtitle" class="col-sm-9 mr-auto">輿情搜尋系統</h3>
						<span class="glyphicon glyphicon-plus" title="搜尋設定""></span>
						<input type="text" name="keyword" class="form-control">
			    		<button id=search class="btn btn-primary btn-large" onclick="searchClick();">搜尋</button>
					</div>
				</div>

				<div class="option" style="display: none;">
					<div class="row">
						<div style="border-bottom: 1px solid black; ">
							<h3>搜尋設定</h3></b>
						</div>
						
						<div class="col-sm-3">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4>來源:</h4>
								</div>

								<label class="checkbox">
									<input type="checkbox" name="source" value="蘋果" checked>蘋果即時新聞
								</label><br>
								<label class="checkbox">
									<input type="checkbox" name="source" value="中時" checked>中時電子報
								</label><br>
								<label class="checkbox">
									<input type="checkbox" name="source" value="自由" checked>自由時報電子報
								</label><br>

			        		</div>
		        		</div>
						
						<div class="col-sm-5">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h4>期間:</h4>
								</div>

								<label class="radio">
									<input type="radio" name="date" value="0" checked />不限
								</label><br>
								<label class="radio">
									<input type="radio" name="date" value="1" />今天
								</label><br>
								<label class="radio">
									<input type="radio" name="date" value="15" />最近15天
								</label><br>
								<label class="radio">
									<input type="radio" name="date" value="30" />最近30天
								</label><br>

								<?php date_default_timezone_set("Asia/Taipei");?>
								<div class="row">
									<label class="radio">
										<input type="radio" name="date" value="-1" />
										起
										<div class="col-sm-5 input-group date" id="datetimepicker1" style="font-size: 80px;">
									        <input type="text" class="form-control" name="startDate" value="<?php echo date("Y/m/d"); ?>">
									        <span class="input-group-addon">
									            <span class="glyphicon glyphicon-calendar"></span>
									        </span>
									    </div>
										迄
										<div class="col-sm-5 input-group date" id="datetimepicker2">
									        <input type="text" class="form-control" name="endDate" value="<?php echo date("Y/m/d"); ?>">
									        <span class="input-group-addon">
									            <span class="glyphicon glyphicon-calendar"></span>
									        </span>
									    </div>
									</label><br>								
								</div>
							</div>
						</div>

						<div class="col-sm-4">
							
			        		<div class="panel panel-primary">
			        			<div class="panel-heading">
			        				<h4>類別:</h4>	
			        			</div>
								
								<label class="checkbox">
									<input type="checkbox" name="category" value="社會" checked />社會
								</label>
								<label class="checkbox">
									<input type="checkbox" name="category" value="國際" checked />國際
								</label>							
								<label class="checkbox">
									<input type="checkbox" name="category" value="政治" checked />政治
								</label><br>
								<label class="checkbox">
									<input type="checkbox" name="category" value="生活" checked />生活
								</label>
								<label class="checkbox">
									<input type="checkbox" name="category" value="體育" checked />體育
								</label>
								<label class="checkbox">
									<input type="checkbox" name="category" value="財經" checked />財經
								</label><br>
								<label class="checkbox">
									<input type="checkbox" name="category" value="論壇" checked />論壇
								</label>
								<label class="checkbox">
									<input type="checkbox" name="category" value="副刊"  checked />副刊
								</label>
								<label class="checkbox">
									<input type="checkbox" name="category" value="3C" checked />3C
								</label><br>
			        		</div>
						</div>
					</div>
				</div>

			</form>
		</div>

		<div class="result">
			<table class="table table-striped table-hover">
				<tbody>

				</tbody>
			</table>
			<div id="test"></div>
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
			}
			echo "<script>searchNewsSource('".$source."');</script>";
		}else{
			echo "<script>searchClick();</script>";
		}
	?>
</html>