<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="page-report">
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportListBack&district='.$district['id'].'&region='.$region['id'].'&year='.$_GET['year']; ?>">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<div>Буцах</div>
				</a>
				<a class="reportPrintBtn" href="javascript:window.print()">
					<i class="glyphicon glyphicon-print"></i>
					<div>Хэвлэх</div>
				</a>
				</div>
				<div class="profileHeader">
					<div class="profileCol1">
						<div class="profileHeaderSub">
							Хороо
						</div>
						<div class="profileHeaderTitle">
							<?php echo $district['title'].' '.$region['title']; ?>
						</div>
					</div>
					<div class="profileCol2">
						<div class="profileHeaderSub">
							Нийт иргэдийн тоо
						</div>
						<div class="profileHeaderInfo">
							<?php echo number_format($info['population']); ?>
						</div>
					</div>
				</div>
				<div class="profileTop">
					<div class="profileCol1">
						<div class="profileTopMap">
							<div id="profileMainMap" style="height: 170px;">
							</div>
						</div>
					</div>
					<div class="profileCol2">
						<div class="profileTopInfo">
							<div class="profileTopCol">
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['household']); ?>
									</div>
									<div class="profileTopSub">
										Нийт өрхийн тоо
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['household_average'], 2); ?>
									</div>
									<div class="profileTopSub">
										Нэг өрхийн гишүүдийн дундаж тоо
									</div>
								</div>
							</div>
							<div class="profileTopCol">
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['area_length']); ?>
									</div>
									<div class="profileTopSub">
										Газар нутгийн хэмжээ /га/
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['population_density'], 2); ?>
									</div>
									<div class="profileTopSub">
										Хүн амын нягтаршил /1 га/
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="reportMapLarge">
					<div id="reportMapBox" style="height: 630px; width: 22cm;">
					</div>
					<div class="reportMapTitle">
						<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/maptitlebg.png'; ?>" class="mapTitleBg"/>
						<div class="mapTitleText">
						<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны аюултай бүс'; ?>
						</div>
					</div>
					<div class="reportDetailBox">
						<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/mapdetailbg.jpg'; ?>" class="mapDetailBg"/>
						<div class="reportDetailInfo">
							<div class="reportDetailTitle">
								Таних тэмдэг
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/flood.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Үерийн аюултай бүс
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/road.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Засмал/Төв зам
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/police.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Цагдаагийн хэсэг
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/crime.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Гэмт хэрэг гарч болзошгүй хэсэг
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/fuel.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Шатахуун түгээх станц
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/regionBorder.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Хорооны хил
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/sectionBorder.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Хэсгийн хил
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailSub">
									Хүн амын нягтаршил
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php
										echo number_format($breaks[1], 2).' - '.number_format($breaks[2],2);
									?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($breaks[2]+0.01,2).' - '.number_format($breaks[3],2); ?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($breaks[3]+0.01,2).' - '.number_format($from,2); ?>
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									<?php echo number_format($from+0.01,2).' - '.number_format($breaks[4],2); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="reportBottom">
					<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/risk-bottom.jpg'; ?>" class="reportBottomImg" />
					<div class="reportGraph">
						<div class="reportGraphTitle"><?php echo $district['title'].' дүүргийн хороодуудын '.$_GET['year'].' оны гэмт хэрэг гарч болзошгүй хэсгийн харьцуулалт'; ?></div>
						<div>
							<canvas id="canvas" height="150"></canvas>
						</div>
					</div>
					<div class="reportBottomInfo">
						<div class="reportBottomTitle">
							<?php echo $_GET['year'].' оны гэмт хэрэг гарч болзошгүй хэсгийн тоо';  ?>
						</div>
						<div class="reportBottomCount">
							<?php echo $crime_count['COUNT(*)']; ?>
						</div>
						<div class="reportBottomTitle">
							<?php echo $_GET['year'].' оны цагдаагийн хэсгийн тоо';  ?>
						</div>
						<div class="reportBottomCount">
							<?php echo $police_count['COUNT(*)']; ?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script src="/webroot/js/shared-report.js"></script>
<script>
	var map;
	var mapLarge;
	var regionBus;
	var regionBorder;
	var iconBus = [];
	var iconFuel = [];
	var iconLight = [];
	var busCircle = [];

function initialize() {
	var mapOptions = {
		zoom: 8,
		center: new google.maps.LatLng(47.918506, 106.917750),
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		draggable: false,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP

	};
	var mapOptions1 = {
<?php
	if(in_array($_GET['district'], array(1, 2))) {
?>
		zoom: <?php echo $region['zoom']+1; ?>,
		center: new google.maps.LatLng(<?php echo $region['center']; ?>),
<?php } elseif(in_array($_GET['region'], array(9, 10, 13, 15, 16, 18, 20, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 34, 36, 37, 38, 39, 41, 42, 43, 44, 46, 47, 48, 49, 50, 51, 52, 54, 56, 58, 59, 60, 62, 64, 65, 67, 71, 72, 73, 74, 75, 77, 78, 79, 80, 81, 82, 83, 85, 86, 87, 88, 89, 90, 92, 96, 98, 99, 100, 101, 102, 103, 105, 106, 107, 108, 109, 111, 112, 113, 114, 115, 116, 119, 120, 121, 122, 123, 124, 125, 126, 127, 129, 131, 132, 134, 135, 136, 137, 138, 139, 142, 143, 146, 148, 150, 151, 152))) { ?>
		zoom: <?php echo $region['zoom']+1; ?>,
		center: new google.maps.LatLng(<?php echo $region['center']; ?>),
<?php } else { ?>
		zoom: 8,
		center: new google.maps.LatLng(47.918506, 106.917750),
<?php } ?>
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP

	};
	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);
	mapLarge = new google.maps.Map(document.getElementById('reportMapBox'),
      mapOptions1);

	<?php foreach($regions as $reg) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $reg['id']; ?>, function(bounds) {
		mapLarge.fitBounds(bounds);
	});
	<?php endforeach; ?>
	<?php foreach($sections as $sec) : ?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $population_density[$sec['title']]; ?>', mapLarge, 0.5);
	<?php endforeach; ?>

	<?php foreach($risks as $gd) : ?>
		addRisks(<?php echo $gd['id']; ?>, mapLarge);
	<?php endforeach; ?>
	addMarker(<?php echo $region['id']; ?>, 6, '<?php echo MAIN_FOLDER."/images/reportProfile/crime.png"; ?>', mapLarge, iconBus);
	addMarker(<?php echo $region['id']; ?>, 15, '<?php echo MAIN_FOLDER."/images/reportProfile/fuel.png"; ?>', mapLarge, iconFuel);
	addMarker(<?php echo $region['id']; ?>, 5, '<?php echo MAIN_FOLDER."/images/reportProfile/police.png"; ?>', mapLarge, iconLight);

	<?php
		foreach($roads as $rd) :
			if($rd['width'] == 6) {
				$road = 3;
			} else {
				$road = 2;
			}
	?>
		addRoad(<?php echo $rd['id']; ?>, <?php echo $rd['width']; ?>, mapLarge);
	<?php endforeach; ?>
}

var barChartData = {
	labels : [<?php foreach($regions as $reg) { echo '"'.$reg['title'].'-р хороо",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(0,165,211,1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($regions as $reg) { echo $region_marker[$reg['id']]['COUNT(*)'].','; } ?>]
		},
	]
}

window.onload = function(){
	var ctx = document.getElementById("canvas").getContext("2d");
	window.myBar = new Chart(ctx).Bar(barChartData, {
		responsive : true
	});
}

</script>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize"></script>

<?php
include(SITE_TEMPLATE. "footer.php");
?>
