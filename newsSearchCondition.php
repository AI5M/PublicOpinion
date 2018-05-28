<div>
	<div class="row">
		<h3 id="subtitle" class="col-sm-9 mr-auto">輿情搜尋系統</h3>
		<span class="glyphicon glyphicon-plus" title="搜尋設定""></span>
		<input type="text" name="keyword" class="form-control">
		<button id=search class="btn btn-primary btn-large" onclick="getData();">搜尋</button>
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