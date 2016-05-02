<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bg-light-green.jpg'; ?>" class="bg-page-image"/>
			<div class="page-report">
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportDistrictListBack&district='.$district['id'].'&year='.$_GET['year']; ?>">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<div>Back</div>
				</a>
				<a class="reportBtn" href="//pdfcrowd.com/url_to_pdf/?width=210mm&height=297mm&use_print_media=1">
					<i class="glyphicon glyphicon-print"></i>
					<div>PDF</div>
				</a>
				<a class="reportPrintBtn" href="javascript:window.print()">
					<i class="glyphicon glyphicon-print"></i>
					<div>Print</div>
				</a>
				</div>
				<div class="profileHeader">
					<div class="profileCol1">
						<div class="profileHeaderSub">
							District
						</div>
						<div class="profileHeaderTitle">
							<?php echo $district['title'].' '.$region['title']; ?>
						</div>
					</div>
					<div class="profileCol2">
						<div class="profileHeaderSub">
							Total population
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
										Total household
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['household_average'], 2); ?>
									</div>
									<div class="profileTopSub">
										Average household size
									</div>
								</div>
							</div>
							<div class="profileTopCol">
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['area_length']); ?>
									</div>
									<div class="profileTopSub">
										Total area /Ha/
									</div>
								</div>
								<div class="profileTopDetail">
									<div class="profileTopNumber">
										<?php echo number_format($info['population_density'], 2); ?>
									</div>
									<div class="profileTopSub">
										Population density (p/Ha)
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
						<?php echo 'School of '.$district['title'].' district'; ?>
						</div>
					</div>
					<div class="reportDetailBox">
						<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/mapdetailbg.jpg'; ?>" class="mapDetailBg"/>
						<div class="reportDetailInfo">
							<div class="reportDetailTitle">
								Key
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/school.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									School
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/sectionBorder.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Khoroo border
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage1">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/5min.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									<5 min walk
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailSub">
									Children absent from school
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color1.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									1 - 21
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color2.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									22 - 44
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color3.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									45 - 64
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/pop-color4.jpg'; ?>" />
								</div>
								<div class="reportDetailDesc">
									65 >
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="reportBottom">
					<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/school-bottom.jpg'; ?>" class="reportBottomImg" />
					<div class="reportGraph">
						<div class="reportGraphTitle"><?php echo 'School comparison of capital city of '.$_GET['year']; ?></div>
						<div>
							<canvas id="canvas" height="150"></canvas>
						</div>
					</div>
					<div class="reportBottomInfo">
						<div class="reportBottomTitle">
							<?php echo 'Total school of '.$_GET['year'];  ?>
						</div>
						<div class="reportBottomCount">
							<?php echo $count_marker['COUNT(*)']; ?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script>
	var map;
	var mapLarge;
	var regionBus;
	var regionBorder;
	var iconBus = [];
	var busCircle = [];
	
	<?php foreach($districts as $dist) : ?>
		var districtArea<?php echo $dist['id']; ?>;
	<?php endforeach; ?>
	
	<?php foreach($regions as $reg) : ?>
		var regionCoord<?php echo $sec['id']; ?> = [];
		var regionArea<?php echo $sec['id']; ?> = [];
	<?php endforeach; ?>
	
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
		zoom: <?php echo $district['zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $district['position'] ?>),
		panControl: false,
		mapTypeControl: false,
		zoomControl: false,
		scaleControl: false,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.HYBRID
		
	};
	
	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);
	mapLarge = new google.maps.Map(document.getElementById('reportMapBox'),
      mapOptions1);
	
	<?php foreach($districts as $dist) : ?>
		 addDistrict(<?php echo $dist['id']; ?>);
	<?php endforeach; ?>
	<?php foreach($regions as $sec) : ?>
		addRegion(<?php echo $sec['id']; ?>, '<?php echo $school_color[$sec['id']]; ?>', mapLarge);
	<?php endforeach; ?>
	
	addRegionDistrict(<?php echo $district['id']; ?>, mapLarge);
	//districtBorder(<?php echo $_GET['district']; ?>, mapLarge);
	
	addWalk(<?php echo $district['id']; ?>, "#195734", 100, 0.5, 4, mapLarge);
	addWalk(<?php echo $district['id']; ?>, "#8ba686", 200, 0.4, 4, mapLarge);
	addWalk(<?php echo $district['id']; ?>, "#cfd4c1", 300, 0.3, 4, mapLarge);
	addWalk(<?php echo $district['id']; ?>, "#f0e5d8", 400, 0.2, 4, mapLarge);
	addMarker(<?php echo $district['id']; ?>, 4, '<?php echo MAIN_FOLDER."/images/reportProfile/school.jpg"; ?>', mapLarge, iconBus);
	
	fitBoundary(<?php echo $district['id']; ?>, map);
}

function addWalk(region, color, radius, opacity, type, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+type+'&district='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				busCircle[k] = new google.maps.Circle({
    				center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					fillColor: color,
					radius: radius,
					strokeWeight: 0,
					fillOpacity: opacity
  				});
				busCircle[k].setMap(mapVar);
			}
		}
	});
}

function addRegionDistrict(district, where) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtRegionCoord = [];
			var districtRegionBounds = [];
			var districtRegionBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				districtRegionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				districtRegionBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			var districtRegionArea = new google.maps.Polygon({
				paths: districtRegionCoord,
				strokeColor: '#f38924',
				strokeOpacity: 0,
				strokeWeight: 4,
				fillColor: '#FFFFFF',
				fillOpacity: 0
			});
			districtRegionArea.setMap(mapLarge);
			myFitBounds(where, districtRegionBounds);
		}
	});
}

function addMarker(region, type, image, mapVar, iconVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+type+'&district='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var iconImg = {
				url: image,
   				size: new google.maps.Size(26, 26),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(8, 9)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				iconVar[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					icon: iconImg,
  				});
				iconVar[k].setMap(mapVar);
			}
		}
	});
}

function addRegion(section, color, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['regionCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['regionCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['regionArea'+section] = new google.maps.Polygon({
    			path: window['regionCoord'+section],
    			 strokeColor: '#000000',
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: color,
    			 fillOpacity: 0.5
  			});
			window['regionArea'+section].setMap(mapVar);
		}
	});
}

function fitBoundary(region, where) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+region, function(point){
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
			boundArea = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#28324e',
				strokeOpacity: 0,
				strokeWeight: 2,
				fillColor: '#FFF',
				fillOpacity: 0
			});
			boundArea.setMap(where);
			myFitBounds(where, khorooBounds);
		}
	});
}

function districtBorder(district, where) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionBorderCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				regionBorderCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
				regionBorder = new google.maps.Polygon({
					paths: regionBorderCoord,
					strokeColor: '#f3330d',
					strokeOpacity: 0.6,
					strokeWeight: 4,
					fillColor: '#f7c567',
					fillOpacity: 0
				});
			regionBorder.setMap(where);
		}
	});
}

function myFitBounds(myMap, bounds) {
    myMap.fitBounds(bounds);

    var overlayHelper = new google.maps.OverlayView();
    overlayHelper.draw = function () {
        if (!this.ready) {
            var projection = this.getProjection(),
                zoom = getExtraZoom(projection, bounds, myMap.getBounds());
            if (zoom > 0) {
                myMap.setZoom(myMap.getZoom() + zoom);
            }
            this.ready = true;
            google.maps.event.trigger(this, 'ready');
        }
    };
    overlayHelper.setMap(myMap);
}

// LatLngBounds b1, b2 -> zoom increment
function getExtraZoom(projection, expectedBounds, actualBounds) {
    var expectedSize = getSizeInPixels(projection, expectedBounds),
        actualSize = getSizeInPixels(projection, actualBounds);

    if (Math.floor(expectedSize.x) == 0 || Math.floor(expectedSize.y) == 0) {
        return 0;
    }

    var qx = actualSize.x / expectedSize.x;
    var qy = actualSize.y / expectedSize.y;
    var min = Math.min(qx, qy);

    if (min < 1) {
        return 0;
    }

    return Math.floor(Math.log(min) / Math.log(2) /* = log2(min) */);
}

// LatLngBounds bnds -> height and width as a Point
function getSizeInPixels(projection, bounds) {
    var sw = projection.fromLatLngToContainerPixel(bounds.getSouthWest());
    var ne = projection.fromLatLngToContainerPixel(bounds.getNorthEast());
    return new google.maps.Point(Math.abs(sw.y - ne.y), Math.abs(sw.x - ne.x));
}

function addDistrict(district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				districtCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			if(district == <?php echo $district['id']; ?>) {
				window['districtArea'+district] = new google.maps.Polygon({
					paths: districtCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#f7c567',
					fillOpacity: 1
				});
			} else {
				window['districtArea'+district] = new google.maps.Polygon({
					paths: districtCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#FFF',
					fillOpacity: 1
				});
			}
			window['districtArea'+district].setMap(map);
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