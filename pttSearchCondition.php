<div>
	<div class="row text-right">
		<h3 id="subtitle" class="col-sm-5 text-left">輿情搜尋系統</h3>
		<span class="glyphicon glyphicon-plus" title="搜尋設定""></span>
		<input type="text" name="keyword" class="form-control">
		<button id=search class="btn btn-primary" onclick="getPtt();">搜尋</button>

		<div class="row">
			<button id=download class="btn btn-defualt" onclick="download_csv();">下載查詢結果</button>
		</div>
	</div>
</div>

<div class="option" style="display: none;">
	<div class="row">
		<div style="border-bottom: 1px solid black; ">
			<h3>搜尋設定</h3></b>
		</div>
		
		<div class="row">
			<div class="panel panel-primary">
    			<label for="sel1">看板:</label>
				<select class="form-control board" style="font-size: 12px;">
					<option>不限</option>
					<?php include_once('getPttBoard.php') ?>
				</select>
    		</div>
		</div>

		<div class="row">
    		<div class="panel panel-primary">
				<label for="sel1">期間:</label>
				<select class="form-control date" style="font-size: 12px;">
					<option value='0'>不限</option>
					<option value='1'>今天</option>
					<option value='15'>最近15天</option>
					<option value='30'>最近30天</option>
					<option value='-1'>選擇日期	</option>
				</select>
				<div class="row" id='time' hidden>
					起
					<div class="col-sm-2 input-group date" id="datetimepicker1" style="font-size: 80px;">
				        <input type="text" class="form-control" name="startDate" value="<?php echo date("Y/m/d"); ?>">
				        <span class="input-group-addon">
				            <span class="glyphicon glyphicon-calendar"></span>
				        </span>
				    </div>
					迄
					<div class="col-sm-2 input-group date" id="datetimepicker2">
				        <input type="text" class="form-control" name="endDate" value="<?php echo date("Y/m/d"); ?>">
				        <span class="input-group-addon">
				            <span class="glyphicon glyphicon-calendar"></span>
				        </span>
				    </div>							
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('.date').on('change', function () {
		var date = $('.date option:selected').val();
		if(date == '-1'){
			$('#time').show();
		}else{
			$('#time').hide();
		}
	});
</script>