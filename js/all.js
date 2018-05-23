$(document).ready(function () {
	$("#sidebar").mCustomScrollbar({
		theme: "minimal"
	});

    $('#datetimepicker1').datepicker({
           format:"yyyy/mm/dd",
           todayHighlight: true,
           initialDate:new Date(),
           orientation:"bottom",
           language: 'zh-TW',
           // startDate: "today", //
           // autoclose: true, //選擇完日期自動關閉
           // calendarWeeks: true, //顯示
    });

    $('#datetimepicker2').datepicker({
           format:"yyyy/mm/dd",
           todayHighlight: true,
           initialDate:new Date(),
           orientation:"bottom",
           language: 'zh-TW',
    });

    $('.glyphicon-plus').click(function(){
  		$('.option').toggle();
  		$('.glyphicon-plus').toggleClass("glyphicon-minus");
	});
});

function searchClick(){
	var sourceGroup = new Array();
	$("input[name=source]:checked").each(function() {
       sourceGroup.push($(this).val());
    });

    var categoryGroup = new Array();
	$("input[name=category]:checked").each(function() {
       categoryGroup.push($(this).val());
    });
    
	$.ajax({
		method: "POST",
		url: "getNews.php",
		async: false, //同步化
		data: {
			source: sourceGroup,
			category: categoryGroup,
  			date: $('input[name=date]:checked').val(),
  			startDate: $("input[name=startDate]").val(),
  			endDate: $("input[name=endDate]").val(),
  			keyword: $("input[name=keyword]").val()
		},
		success: function(text) {
			console.log(text)
			$("tbody").html(text);
		}
	});
	$('.option').hide();
	$('.glyphicon-plus').removeClass("glyphicon-minus");
}

function searchNewsSource(source){
	var sourceGroup = new Array();
	sourceGroup.push(source);
	$.ajax({
		method: "POST",
		url: "getNews.php",
		async: false, //同步化
		data: {
			source: sourceGroup,
		},
		success: function(text) {
			console.log(text)
			$("tbody").html(text);
		}
	});
	$('.option').hide();
	$('.glyphicon-plus').removeClass("glyphicon-minus");
}
