<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-report">
					<div class="reportBtnRow">
						<a class="reportBtn" href="//pdfcrowd.com/url_to_pdf/?width=210mm&height=297mm&use_print_media=1">
							<i class="glyphicon glyphicon-print"></i>
							<div>PDF хувилбар</div>
						</a>
					</div>
					<div class="reportPageTitle">
					<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны тайлан'; ?>
					</div>
					<div class="reportPage">
						<div class="reportInfoBox">
							<table width="100%">
								<tr>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">Хүн амын тоо</div>
											<div style="width: 7cm;">
												<canvas id="population-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">Өрхийн тоо</div>
											<div style="width: 7cm;">
												<canvas id="household-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">Газар нутгийн хэмжээ /га/</div>
											<div style="width: 7cm;">
												<canvas id="area-chart" height="200"></canvas>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">Хүн амын нягтаршил (хүн/га)</div>
											<div style="width: 7cm;">
												<canvas id="popDensity-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">Өрхийн дундаж хэмжээ</div>
											<div style="width: 7cm;">
												<canvas id="hhAve-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн %</div>
											<div style="width: 7cm;">
												<canvas id="kinRatio-chart" height="200"></canvas>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">1000 хүнд ноогдох усны худгийн харьцаа</div>
											<div style="width: 7cm;">
												<canvas id="wellDen-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа</div>
											<div style="width: 7cm;">
												<canvas id="hosRatio-chart" height="200"></canvas>
											</div>
										</div>
									</td>
									<td width="33%">
										<div class="reportInfoCol">
											<div class="yearReportColTitle">1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа</div>
											<div style="width: 7cm;">
												<canvas id="schoolRatio-chart" height="200"></canvas>
											</div>
										</div>
									</td>
								</tr>
								<?php
									$k = 0; 
									foreach($types as $tp) : 
									$k = $k + 1;
									if($k == 1) {
										echo '<tr>';
									}
								?>
								<td>
									<div class="reportInfoCol">
										<div class="yearReportColTitle"><?php echo $tp['title']; ?></div>
										<div style="width: 7cm;">
											<canvas id="chart<?php echo $tp['id']; ?>" height="200"></canvas>
										</div>
									</div>
								</td>
								<?php
									if($k == 3) {
										echo '</tr>';
										$k = 0;
									} 
									endforeach; 
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

var populationChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(0,165,211,1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo $info[$yr['year']]['population'].','; } else { echo '0,'; }} ?>]
		},
	]
}

var householdChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(15,138,134, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo $info[$yr['year']]['household'].','; } else { echo '0,'; }} ?>]
		},
	]
}

var areaChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(223,112,39, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo $info[$yr['year']]['area_length'].','; } else { echo '0,'; }} ?>]
		},
	]
}

var popDensityChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(242,195,18, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['population_density'], 1).','; } else { echo '0,'; }} ?>]
		},
	]
}

var hhAveChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(147,101,184, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['household_average']).','; } else { echo '0,'; }} ?>]
		},
	]
}

var kinRatioChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(0,168,133, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['kin_ratio']).','; } else { echo '0,'; }} ?>]
		},
	]
}

var wellDenChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(44,130,201, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['well_ratio'], 1).','; } else { echo '0,'; }} ?>]
		},
	]
}

var hosRatioChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(241,89,64, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['hospital_ratio'], 1).','; } else { echo '0,'; }} ?>]
		},
	]
}

var schoolRatioChartData = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(84,172,210, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($info[$yr['year']] != NULL) { echo number_format($info[$yr['year']]['school_ratio'], 1).','; } else { echo '0,'; }} ?>]
		},
	]
}

<?php foreach($types as $tp) : ?>
var ChartData<?php echo $tp['id']; ?> = {
	labels : [<?php foreach($years as $yr) { echo '"'.$yr['year'].' он",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(<?php echo rand(25,200); ?>,<?php echo rand(50,220); ?>,<?php echo rand(80,150); ?>, 1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($years as $yr) { if($count_marker[$tp['id']][$yr['year']] != NULL) { echo number_format($count_marker[$tp['id']][$yr['year']]['COUNT(*)']).','; } else { echo '0,'; }} ?>]
		},
	]
}
<?php endforeach; ?>

window.onload = function(){
	var ctx = document.getElementById("population-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(populationChartData, {
		responsive : true
	});
	var ctx = document.getElementById("household-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(householdChartData, {
		responsive : true
	});
	var ctx = document.getElementById("area-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(areaChartData, {
		responsive : true
	});
	var ctx = document.getElementById("popDensity-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(popDensityChartData, {
		responsive : true
	});
	var ctx = document.getElementById("hhAve-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(hhAveChartData, {
		responsive : true
	});
	var ctx = document.getElementById("kinRatio-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(kinRatioChartData, {
		responsive : true
	});
	var ctx = document.getElementById("wellDen-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(wellDenChartData, {
		responsive : true
	});
	var ctx = document.getElementById("hosRatio-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(hosRatioChartData, {
		responsive : true
	});
	var ctx = document.getElementById("schoolRatio-chart").getContext("2d");
	window.myBar = new Chart(ctx).Bar(schoolRatioChartData, {
		responsive : true
	});
	<?php foreach($types as $tp) : ?>
	var ctx = document.getElementById("chart<?php echo $tp['id']; ?>").getContext("2d");
	window.myBar = new Chart(ctx).Bar(ChartData<?php echo $tp['id']; ?>, {
		responsive : true
	});
	<?php endforeach; ?>
}

</script>
<?php
include(SITE_TEMPLATE. "footer.php");
?>