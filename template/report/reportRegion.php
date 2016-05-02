<?php
include(SITE_TEMPLATE. "report/header.php");
?>
<div class="report-page">
	<div class="report-title">
		<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хороо'; ?>
	</div>
	<div class="report-type">
		<?php echo $type['title']; ?>
	</div>
	<div id="map-region" style="height: 800px;">
	</div>
	<div class="report-bottom">
		<div class="row">
			<div class="col-md-4">
				<div class="image-info">
					<img src="<?php echo $type['image']; ?>" />
				</div>
			</div>
			<div class="col-md-8">
				<div class="bottom-title">
					Тэмдэглэгээ
				</div>
				<div class="bottom-icon">
					<img src="<?php echo $type['image']; ?>" /> <?php echo $type['title']; ?>
				</div>
				<div class="bottom-info">
					<div class="info-title">
						Хүн амын нягтаршил/нэг га-д ноогдох хүний тоо
					</div>
					<div class="info-col">
						<div class="info-row">
							<div class="box-density" style="background: <?php echo $colors[3]; ?>; height: 30px; width: 50px;">
							</div>
							<div class="info-density">
								1-48
							</div>
						</div>
						<div class="info-row">
							<div class="box-density" style="background: <?php echo $colors[2]; ?>; display: block; height: 30px; width: 50px;">
							</div>
							<div class="info-density">
								49-77
							</div>
						</div>
						<div class="info-row">
							<div class="box-density" style="background: <?php echo $colors[1]; ?>; height: 30px; width: 50px;">
							</div>
							<div class="info-density">
								78-101
							</div>
						</div>
						<div class="info-row">
							<div class="box-density" style="background: <?php echo $colors[0]; ?>; height: 30px; width: 50px;">
							</div>
							<div class="info-density">
								102 >
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include(SITE_TEMPLATE. "report/footer.php");
?>

<script>
	var map;
	var points;
	var regionArea;

function initialize() {
	var mapOptions = {
		zoom: 4,
		center: new google.maps.LatLng(47.918506, 106.917750),
		panControl: false
	};
	map = new google.maps.Map(document.getElementById('map-region'),
      mapOptions);
	
	addRegion(<?php echo $district['id'] ?>, <?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	addMarker(<?php echo $type['id']; ?>, <?php echo $region['id']; ?>);
	fitBoundary(<?php echo $region['id'] ?>);
}

function addMarker(typeid, district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getRegionMarkers&type='+typeid+'&region='+district+'', function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				points = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $type['image']; ?>'
  				});
				points.setMap(map);
			}
		}
	});
}

function fitBoundary(region) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var khorooBounds = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			regionArea = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#28324e',
				strokeOpacity: 0,
				strokeWeight: 2,
				fillColor: '#FFF',
				fillOpacity: 0
			});
			map.fitBounds(khorooBounds);
			regionArea.setMap(map);
		}
	});
}

function addRegion(district, region, image) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			regionArea = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#28324e',
				strokeOpacity: 0.6,
				strokeWeight: 2,
				fillColor: '<?php echo $pop_color; ?>',
				fillOpacity: 0.8
			});
			regionArea.setMap(map);
		}
	});
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>