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

	$("#pageCount span a").click(function(){
		var rel = $(this).attr("rel");
		if(rel){
			searchClick(rel);
		}
	});

	$(".page-link").click(function(){
		alert("2131231");
	});
});


$(".page-link").on('click',function(){
	var rel = $(this).attr("rel");
	if(rel){
		getData(rel);
	}
});

function getPageBar(source='news'){
	var pageBar='<ul class="pagination">';
	if(curPage < 1) curPage=1;
	if(curPage > totalPage) curPage=totalPage;

	if(curPage == 1){
		pageBar+='<li class="page-item">';
		pageBar+='<span aria-hidden="true">&laquo;</span></a></li>';
	}else{
		pageBar+='<li class="page-item">';
		if(source == 'ptt')
			pageBar+='<a class="page-link" aria-label="Previous" onclick="getPtt('+(curPage-1)+');">';
		else
			pageBar+='<a class="page-link" aria-label="Previous" onclick="getData('+(curPage-1)+');">';
		pageBar+='<span aria-hidden="true">&laquo;</span></a></li>';
	}

	pagecount=0;
	for(var i=curPage-5 ; i<totalPage+1 & pagecount<10;i++){
		if(i>0 && i<totalPage+1){
			if(i == curPage){
				pageBar+='<li class="page-item active">';
				pageBar+='<a class="page-link">'+i+'</a></li>';
			}
			else{
				pageBar+='<li class="page-item">';
				if(source == 'ptt')
					pageBar+='<a class="page-link" onclick="getPtt('+i+');">'+i+'</a></li>';
				else
					pageBar+='<a class="page-link" onclick="getData('+i+');">'+i+'</a></li>';
			}
			pagecount++;
		}
	}

	if(curPage == totalPage){
		pageBar+='<li class="page-item">';
		pageBar+='<span aria-hidden="true">&raquo;</span></a></li>';
	}else{
		pageBar+='<li class="page-item">';
		if(source == 'ptt')
			pageBar+='<a class="page-link" aria-label="Previous" onclick="getPtt('+(curPage+1)+');">';
		else
			pageBar+='<a class="page-link" aria-label="Previous" onclick="getData('+(curPage+1)+');">';
		pageBar+='<span aria-hidden="true">&raquo;</span></a></li>';
	}
	pageBar+='</ul>';
	pageBar+="<li>共 "+total+" 筆</li>";
	$("#pageCount").html(pageBar);
}

var curPage = 1;
var total,pageSize,totalPage;
function getData(page=1){
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
		// async: false, //同步化
		dataType:"json",
		data: {
			source: sourceGroup,
			category: categoryGroup,
  			date: $('input[name=date]:checked').val(),
  			startDate: $("input[name=startDate]").val(),
  			endDate: $("input[name=endDate]").val(),
  			keyword: $("input[name=keyword]").val(),
  			page: page-1
		},
		beforeSend:function(){
			$('.option').hide();
			$('.glyphicon-plus').removeClass("glyphicon-minus");
			$("#loading").append("<p id='loading'>loading...</li>");
			$("#pageCount").empty();
			$("tbody").empty();//清空
			$("#search").attr('disabled',true);
			setTimeout("$('#search').attr('disabled',false)",400);
		},
		success: function(text) {
			// console.log(text);
			total = text.total; //總數
			pageSize = text.pageSize; //每頁顯示數量
			curPage = page; //當前頁
			totalPage = text.totalPage; //總頁數
			var row="";
			var list = text.list;
			$.each(list,function(index,array){ //遍历json数据列
				row += "<tr>";
				row += "<td><h2>"+array['source']+"</h2></td>";
				row += "<td><h3 style='background-color: "+array['color']+";'>"+array['category_name']+"</h3></td>";
				row += "<td><h1><a href='"+array['site_url']+"'>"+array['title']+"</a></h1></td>";
				row += "<td><h2>"+array['create_time']+"</h2></td>";
				row += "</tr>";
			});
			$("tbody").append(row);
		},
		complete:function(){ //生成分页条
			$("#loading").empty("<p id='loading'>loading...</li>");//显示加载动画
			getPageBar('news');
		}
	});
}

function setSource(source){
	$("input[name=source]:checked").each(function() {
		if($(this).val() != source){
			$(this).attr('checked', false);
			$(this).attr('disabled', true);
		}
	});
	getData();
}

function getPtt(page=1){	    
	$.ajax({
		method: "POST",
		url: "getPtt.php",
		// async: false, //同步化
		dataType:"json",
		data: {
			board : $('.board option:selected').text(),
  			date: $('.date option:selected').val(),
  			startDate: $("input[name=startDate]").val(),
  			endDate: $("input[name=endDate]").val(),
  			keyword: $("input[name=keyword]").val(),
  			page: page-1
		},
		beforeSend:function(){
			$('.option').hide();
			$('.glyphicon-plus').removeClass("glyphicon-minus");
			$("#loading").append("<p id='loading'>loading...</li>");
			$("#pageCount").empty();
			$("tbody").empty();//清空
			$("#search").attr('disabled',true);
			setTimeout("$('#search').attr('disabled',false)",400);
		},
		success: function(text) {
			// $('tbody').html(text);
			// console.log(text);
			total = text.total; //總數
			pageSize = text.pageSize; //每頁顯示數量
			curPage = page; //當前頁
			totalPage = text.totalPage; //總頁數
			var row="";
			var list = text.list;
			row += "<tr>";
			row += "<td><h2>看板</h2></td>";
			row += "<td><h2>類別</h2></td>";
			row += "<td><h2>標題</h2></td>";
			row += "<td><h2>推</h2></td>";
			row += "<td><h2>噓</h2></td>";
			row += "<td><h2>日期</h2></td>";
			$.each(list,function(index,array){ //遍历json数据列
				row += "<tr>";
				row += "<td><h2>"+array['board']+"</h2></td>";
				row += "<td><h2>"+array['board_class']+"</h3></td>";
				row += "<td><h1><a href='"+array['url']+"'>"+array['title']+"</a></h1></td>";
				row += "<td><h2>"+array['push']+"</h2></td>";
				row += "<td><h2>"+array['shush']+"</h2></td>";
				row += "<td><h2>"+array['create_time']+"</h2></td>";
				row += "</tr>";
			});
			$("tbody").append(row);
		},
		complete:function(){ //生成分页条
			$("#loading").empty("<p id='loading'>loading...</li>");//显示加载动画
			getPageBar('ptt');
		}
	});
}

function download_csv(){
	window.open('download.php', 'download');
}

// function searchNewsSource(source,page=1){
// 	var sourceGroup = new Array();
// 	sourceGroup.push(source);
// 	$.ajax({
// 		method: "POST",
// 		url: "getNews.php",
// 		async: false, //同步化
// 		data: {
// 			source: sourceGroup,
// 		},
// 		success: function(text) {
// 			console.log(text)
// 			$("tbody").html(text);
// 		}
// 	});
// 	$('.option').hide();
// 	$('.glyphicon-plus').removeClass("glyphicon-minus");
// }
