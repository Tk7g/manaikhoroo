<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/header.php");
	include(ADMIN_TEMPLATE. "session_check.php");
?>

<div id="mainComponent">
	<div class="mainTitle">
		<?php echo $page_title; ?>
	</div>
	<div class="mainWrapper">
		<div class="orderInfoWrapper">
			<div class="yearSelectBox">
				<form action="order.php?action=selectYearGraphReport" method="post">
					<div class="floatRow">
						<label>Он</label>
						<select name="year" id="Year" required="required">
							<?php for($k=2014; $k<=date('Y'); $k++) { ?>
							<option value="<?php echo $k; ?>" <?php if($current_year == $k){ echo 'selected'; } ?>><?php echo $k; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="floatRow">
						<label>Төрөл</label>
						<select name="type" id="Type" required="required">
							<option value="0" <?php if($type == 0){ echo 'selected'; } ?>>Бүгд</option>
							<option value="1" <?php if($type == 1){ echo 'selected'; } ?>>Гэрээт захиалга</option>
							<option value="2" <?php if($type == 2){ echo 'selected'; } ?>>Гэрээт бус захиалга</option>
						</select>
					</div>
					<div class="floatRow">
						<button type="submit" name="selectYear" class="yearSelectBtn">Тайлан гаргах</button>
					</div>
				</form>
			</div>
			<div id="reportGraphBlock">
				<div class="orderReportGraphTitle">
					<?php echo $current_year; ?> оны орлогын график
				</div>
				<div class="orderReportGraph">
					<canvas id="yearRevenue" style="height: 400px;"></canvas>
				</div>
				<div class="orderReportGraphTitle">
					<?php echo $current_year; ?> оны захиалгын хэмжээ
				</div>
				<div class="orderReportGraph">
					<canvas id="yearSize" style="height: 400px;"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	
	var lineChartData = {
		labels : ["1 сар","2 сар","3 сар","4 сар","5 сар","6 сар","7 сар","8 сар", "9 сар","10 сар","11 сар","12 сар"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php echo $monthOrderRevenue[1]; ?>, <?php echo $monthOrderRevenue[2]; ?>, <?php echo $monthOrderRevenue[3]; ?>, <?php echo $monthOrderRevenue[4]; ?>, <?php echo $monthOrderRevenue[5]; ?>, <?php echo $monthOrderRevenue[6]; ?>, <?php echo $monthOrderRevenue[7]; ?>, <?php echo $monthOrderRevenue[8]; ?>, <?php echo $monthOrderRevenue[9]; ?>, <?php echo $monthOrderRevenue[10]; ?>, <?php echo $monthOrderRevenue[11]; ?>, <?php echo $monthOrderRevenue[12]; ?>]
			}
		]
	}
	
	var lineChartData2 = {
		labels : ["1 сар","2 сар","3 сар","4 сар","5 сар","6 сар","7 сар","8 сар", "9 сар","10 сар","11 сар","12 сар"],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php echo $monthOrderSize[1]; ?>, <?php echo $monthOrderSize[2]; ?>, <?php echo $monthOrderSize[3]; ?>, <?php echo $monthOrderSize[4]; ?>, <?php echo $monthOrderSize[5]; ?>, <?php echo $monthOrderSize[6]; ?>, <?php echo $monthOrderSize[7]; ?>, <?php echo $monthOrderSize[8]; ?>, <?php echo $monthOrderSize[9]; ?>, <?php echo $monthOrderSize[10]; ?>, <?php echo $monthOrderSize[11]; ?>, <?php echo $monthOrderSize[12]; ?>]
			}
		]
	}

	window.onload = function(){
		var ctx = document.getElementById("yearRevenue").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "#EEEEEE",
			scaleFontColor: "e9e9e9"
		});
		var ctx2 = document.getElementById("yearSize").getContext("2d");
		window.myLine = new Chart(ctx2).Line(lineChartData2, {
			responsive: true,
			scaleLineColor: "#EEEEEE",
			scaleFontColor: "e9e9e9"
		});
	}

</script>

<?php 
	include(ADMIN_WEB_TEMPLATE. "layout/footer.php");
?>