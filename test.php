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
	<div>
		<button><a href="http://www.google.com">Google</a></button>
	</div>
</body>
<script>
	$(document).ready(function () {
		// var googleLink = $("<a>").attr({
		// 'href': 'http://www.google.com'
		// }).text("Google");
		// $("body").append(googleLink);
		$('a').click(function(event) {
			var googleLink = $("<a>").attr({
			'href': 'http://www.google.com'
			}).text("Google");
			$("body").append(googleLink);
		});

	});
	$('button').click();
</script>
</html>


<!-- <?php 
  //echo date("Y/m/d",1527625440);
 ?> -->