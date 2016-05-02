<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/news.php">Иргэдээс ирүүлсэн санал хүсэлтүүдийн статистик</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>Иргэдээс ирүүлсэн санал хүсэлтүүдийн статистик</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
		
			<div id="statGraph" style="height: 300px;"></div>
			<div class="statCounterBlock" style="margin-top: 15px;">
			<?php foreach($types as $type) : ?>
				<div class="statCounterCount"><?php echo '<b>'.$type['title'].'</b>: '.$sanalTypeCount[$type['id']]['COUNT(*)']; ?></div>
			<?php endforeach; ?>
				<div class="statCounterCount"><?php echo '<b>Нийт</b>: '.$total_count['COUNT(*)']; ?></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart', 'bar']});
google.setOnLoadCallback(drawButeetsChart);
function drawButeetsChart() {
	var data = new google.visualization.arrayToDataTable([
		['Ангилал', <?php foreach($types as $type) { echo "'".$type['title']."', "; } ?>],
		["Санал хүсэлтийн тоо", <?php foreach($types as $type) { echo $sanalTypeCount[$type['id']]['COUNT(*)'].", "; } ?>],
	]);

        var options = {
			chartArea:{
				top: 20,
				left: 30,
    			width: '70%',
    			height: '85%'
			},
			bar: { groupWidth: "100%" },
			hAxis: {textStyle: {color: '#333', fontSize: 12}, textPosition: 'out'},
			vAxis: {textStyle: {color: '#333', fontSize: 12}},
			annotations: {textStyle: {fontSize: 11}},
        };
        
        var chart = new google.visualization.ColumnChart(document.getElementById('statGraph'));

		chart.draw(data, options);
}
</script>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>