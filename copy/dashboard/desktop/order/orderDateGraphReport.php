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
				<form action="order.php?action=selectDateGraphReport" method="post">
					<div class="floatRow">
						<label>Эхлэх огноо</label>
						<input name="order_date1" type="text" id="OrderDate1" required="required" value="<?php if(isset($_GET['date1'])) { echo $_GET['date1']; } ?>" />
					</div>
					<div class="floatRow">
						<label>Төгсөх огноо</label>
						<input name="order_date2" type="text" id="OrderDate2" required="required" value="<?php if(isset($_GET['date2'])) { echo $_GET['date2']; } ?>" />
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
					Орлогын график /₮/
				</div>
				<div class="orderReportGraph">
					<canvas id="yearRevenue" style="height: 400px;"></canvas>
				</div>
				<div class="orderReportGraphTitle">
					Захиалгын хэмжээ /м<sup>3</sup>/
				</div>
				<div class="orderReportGraph">
					<canvas id="yearSize" style="height: 400px;"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	
$(function() {
    $( "#OrderDate1" ).datepicker({
    	dateFormat: "yy-mm-dd"
    });
    $( "#OrderDate2" ).datepicker({
    	dateFormat: "yy-mm-dd"
    });
});

	var lineChartData = {
		labels : [<?php for($k=0; $k<=$current_days; $k++){ echo '"'.date('m/d', strtotime($current_date1. " + $k days")).'",'; } ?>],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php for($k=0; $k<=$current_days; $k++){ echo "'".$totalDateRevenue[$k]."',"; } ?>]
			}
		]
	}
	
	var lineChartData2 = {
		labels : [<?php for($k=0; $k<=$current_days; $k++){ echo '"'.date('m/d', strtotime($current_date1. " + $k days")).'",'; } ?>],
		datasets : [
			{
				label: "My First dataset",
				fillColor : "#FEDE00",
				strokeColor : "#EEEEEE",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "#fff",
				pointHighlightStroke : "#1e681d",
				data : [<?php for($k=0; $k<=$current_days; $k++){ echo "'".$totalDateSize[$k]."',"; } ?>]
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