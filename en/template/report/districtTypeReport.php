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
						<?php echo $district['title'].' дүүргийн '.$_GET['year'].' оны '.$type['title']; ?>
					</div>
					<div class="reportPage">
						<div id="reportMap" style="height: 16cm; width: 21cm; margin: 0 auto;">
						</div>
						<div class="reportInfoBox">
							<table width="100%">
								<tr>
									<td width="30%">
										<div class="reportInfoCol">
											<div class="reportInfoRow mainInfo">
												<span><?php echo $type['title']; ?>: <?php echo $count_marker['COUNT(*)']; ?></span>
											</div>
											<div class="reportInfoRow">
												<span>Хүн амын тоо: </span><?php echo $info['population']; ?>
											</div>
											<div class="reportInfoRow">
												<span>Нийт өрхийн тоо: </span><?php echo $info['household']; ?>
											</div>
											<div class="reportInfoRow">
												<span>Өрхийн дундаж хэмжээ: </span><?php echo $info['household_average']; ?>
											</div>
											<div class="reportInfoRow">
												<span>Газар нутгийн хэмжээ: </span><?php echo $info['area_length'].' га'; ?>
											</div>
										</div>
									</td>
									<td width="30%">
										<div class="reportInfoCol">
											<div class="reportInfoColTitle">Тэмдэглэгээ</div>
											<div class="reportMarker">
												<img src="<?php echo $type['image']; ?>" /> <?php echo $type['title']; ?>
											</div>
											<div class="reportPopulation">
												<div class="titlePopulation">
													Хүн амын нягтаршил (хүн/га)
												</div>
												<div class="populationRow">
													<div class="boxDensity">
														<img src="<?php echo MAIN_FOLDER.'/img/report/bg1.jpg'; ?>" />
													</div>
													<div class="popDensity">
														1-48
													</div>
												</div>
												<div class="populationRow">
													<div class="boxDensity">
														<img src="<?php echo MAIN_FOLDER.'/img/report/bg2.jpg'; ?>" />
													</div>
													<div class="popDensity">
														49-77
													</div>
												</div>
												<div class="populationRow">
													<div class="boxDensity">
														<img src="<?php echo MAIN_FOLDER.'/img/report/bg3.jpg'; ?>" />
													</div>
													<div class="popDensity">
														78-101
													</div>
												</div>
												<div class="populationRow">
													<div class="boxDensity">
														<img src="<?php echo MAIN_FOLDER.'/img/report/bg4.jpg'; ?>" />
													</div>
													<div class="popDensity">
														102-с дээш
													</div>
												</div>
											</div>
										</div>
									</td>
									<td width="40%">
										<div class="reportInfoCol">
											<div class="reportInfoColTitle"><?php echo 'Дүүргүүдийн харьцуулалт'; ?></div>
											<div style="width: 10cm;">
												<canvas id="canvas" height="200"></canvas>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var map;
	var points;
<?php foreach($regions as $rg) : ?>
	var regionArea<?php echo $rg['id']; ?>;
<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: <?php echo $district['zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $district['position'] ?>),
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		draggable: false,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('reportMap'),
      mapOptions);
	
<?php foreach($regions as $region) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>', '<?php echo $pop_color[$region['id']]; ?>');
<?php endforeach; ?>
addMarker(<?php echo $_GET['type']; ?>, <?php echo $district['id']; ?>);
}

function addMarker(typeid, district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+typeid+'&district='+district+'', function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var img = {
				url: point.image,
   				size: new google.maps.Size(26, 32),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(0, 32),
				scaledSize: new google.maps.Size(6, 7)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				points = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: img
  				});
				points.setMap(map);
			}
		}
	});
}

function addRegion(district, region, image, bgcolor) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['regionArea'+region] = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#000000',
				strokeOpacity: 0.6,
				strokeWeight: 2,
				fillColor: bgcolor,
				fillOpacity: 0.8
			});
			var regionImage = {url: image};
			var regionImagePosition = getCenterOfPolygon(window['regionArea'+region]);
			var regionName = new google.maps.Marker({
      			position: regionImagePosition,
      			map: map,
      			icon: regionImage
  			});
			window['regionArea'+region].setMap(map);
		}
	});
}

function getCenterOfPolygon(polygon){
	var PI=22/7
	var X=0;
	var Y=0;
	var Z=0;
	polygon.getPath().forEach(function (vertex, inex) {
		lat1=vertex.lat();
		lon1=vertex.lng();
		lat1 = lat1 * PI/180
		lon1 = lon1 * PI/180
		X += Math.cos(lat1) * Math.cos(lon1)
		Y += Math.cos(lat1) * Math.sin(lon1)
		Z += Math.sin(lat1)
	})
	Lon = Math.atan2(Y, X)
	Hyp = Math.sqrt(X * X + Y * Y)
	Lat = Math.atan2(Z, Hyp)
	Lat = Lat * 180/PI
	Lon = Lon * 180/PI 
	return new google.maps.LatLng(Lat,Lon);
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

var barChartData = {
	labels : [<?php foreach($districts as $dist) { echo '"'.$dist['title'].'",'; } ?>],
	datasets : [
		{
			fillColor : "rgba(0,165,211,1)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php foreach($districts as $dist) { echo $district_marker[$dist['id']]['COUNT(*)'].','; } ?>]
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
<?php
include(SITE_TEMPLATE. "footer.php");
?>