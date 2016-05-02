<?php
include(SITE_TEMPLATE. "header.php");
?>
<div id="reportPage">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bg-green.jpg'; ?>" class="bg-page-image"/>
			<div class="page-report">
				<div class="reportBtnRow">
				<a class="reportBackBtn" href="<?php echo SITE_URL.'report.php?action=reportListBack&district='.$district['id'].'&region='.$region['id'].'&year='.$_GET['year']; ?>">
					<i class="glyphicon glyphicon-arrow-left"></i>
					<div>Буцах</div>
				</a>
				<a class="reportBtn" href="//pdfcrowd.com/url_to_pdf/?use_print_media=1">
					<i class="glyphicon glyphicon-print"></i>
					<div>PDF хувилбар</div>
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
						<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны нийтийн тээвэр'; ?>
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
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/bus.jpg"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Автобусны буудал
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/light.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Гудамжны гэрэлтүүлэг
								</div>
							</div>
							<div class="reportDetailRow">
								<div class="reportDetailImage">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/torongarts.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									Торон гарц гаргах боломжит газар
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
								<div class="reportDetailImage1">
									<img src="<?php echo MAIN_FOLDER."/images/reportProfile/5min.png"; ?>" />
								</div>
								<div class="reportDetailDesc">
									5 минутанд алхах зай
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
					<img src="<?php echo MAIN_FOLDER.'/images/reportProfile/bus-bottom.jpg'; ?>" class="reportBottomImg" />
					<div class="reportGraph">
						<div class="reportGraphTitle"><?php echo $district['title'].' дүүргийн хороодуудын '.$_GET['year'].' оны автобусны буудлын харьцуулалт'; ?></div>
						<div>
							<canvas id="canvas" height="150"></canvas>
						</div>
					</div>
					<div class="reportBottomInfo">
						<div class="reportBottomTitle">
							<?php echo $_GET['year'].' оны автобусны буудлын тоо';  ?>
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
	var iconLight = [];
	var busCircle = [];
	
	<?php foreach($regions as $reg) : ?>
	var regionArea<?php echo $reg['id']; ?>;
	<?php endforeach; ?>
	
	<?php foreach($sections as $sec) : ?>
		var sectionCoord<?php echo $sec['id']; ?> = [];
	<?php endforeach; ?>
	
	<?php foreach($torongarts as $tr) : ?>
		var torongartsCoord<?php echo $tr['id']; ?> = [];
	<?php endforeach; ?>
	
	<?php foreach($roads as $rd) : ?>
		var rdCoord<?php echo $rd['id']; ?> = [];
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
		mapTypeId: google.maps.MapTypeId.HYBRID
		
	};
	map = new google.maps.Map(document.getElementById('profileMainMap'),
      mapOptions);
	mapLarge = new google.maps.Map(document.getElementById('reportMapBox'),
      mapOptions1);
    
    fitBoundary(<?php echo $region['id']; ?>, map);
<?php
	if(!in_array($_GET['district'], array(1, 2))) {
		if(!in_array($_GET['region'], array(9, 10, 13, 15, 16, 18, 20, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 34, 36, 37, 38, 39, 41, 42, 43, 44, 46, 47, 48, 49, 50, 51, 52, 54, 56, 58, 59, 60, 62, 64, 65, 67, 71, 72, 73, 74, 75, 77, 78, 79, 80, 81, 82, 83, 85, 86, 87, 88, 89, 90, 92, 96, 98, 99, 100, 101, 102, 103, 105, 106, 107, 108, 109, 111, 112, 113, 114, 115, 116, 119, 120, 121, 122, 123, 124, 125, 126, 127, 129, 131, 132, 134, 135, 136, 137, 138, 139, 142, 143, 146, 148, 150, 151, 152))) {
?>
	fitBoundary(<?php echo $region['id']; ?>, mapLarge);
<?php }} ?>
	
	
	addMarker(<?php echo $region['id']; ?>, 1, '<?php echo MAIN_FOLDER."/images/reportProfile/bus.jpg"; ?>', mapLarge, iconBus, <?php echo $_GET['year'] ?>);
	addMarker(<?php echo $region['id']; ?>, 7, '<?php echo MAIN_FOLDER."/images/reportProfile/light.png"; ?>', mapLarge, iconLight, <?php echo $_GET['year'] ?>);
	<?php foreach($regions as $reg) : ?>
	addRegion(<?php echo $district['id'] ?>, <?php echo $reg['id']; ?>);
	<?php endforeach; ?>
	<?php foreach($sections as $sec) : ?>
		<?php
			if($pop_color[$sec['title']] == "#FFFFFF") {
		?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', mapLarge, 0);
		<?php
			} else {
		?>
		addSection(<?php echo $sec['id']; ?>, '<?php echo $pop_color[$sec['title']]; ?>', mapLarge, 0.5);
		<?php
			}
		?>
	<?php endforeach; ?>
	<?php foreach($torongarts as $tr) : ?>
		addTorongarts(<?php echo $tr['id']; ?>, mapLarge);
	<?php endforeach; ?>
	regionBorder(<?php echo $_GET['district']; ?>, <?php echo $_GET['region']; ?>, mapLarge);
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
	
	setTimeout(function () {
    	addWalk(<?php echo $region['id']; ?>, "#f0e5d8", 400, 0.25, 1, mapLarge);   
    }, 1000);
	setTimeout(function () {
    	addWalk(<?php echo $region['id']; ?>, "#cdd3c0", 300, 0.4, 1, mapLarge);    
    }, 1500);
	setTimeout(function () {
    	addWalk(<?php echo $region['id']; ?>, "#8ba686", 200, 0.5, 1, mapLarge);    
    }, 2000);
    setTimeout(function () {
    	addWalk(<?php echo $region['id']; ?>, "#195734", 100, 0.6, 1, mapLarge);    
    }, 3000);
    
    google.maps.event.addListener(mapLarge, 'zoom_changed', function() {
		
    	removeMarker(<?php echo $region['id']; ?>, 7, iconLight);
    	removeMarker(<?php echo $region['id']; ?>, 1, iconBus);
    	addMarker(<?php echo $region['id']; ?>, 1, '<?php echo MAIN_FOLDER."/images/reportProfile/bus.jpg"; ?>', mapLarge, iconBus, <?php echo $_GET['year'] ?>);
    	addMarker(<?php echo $region['id']; ?>, 7, '<?php echo MAIN_FOLDER."/images/reportProfile/light.png"; ?>', mapLarge, iconLight, <?php echo $_GET['year'] ?>);
		
  	});
}

function removeMarker(region, type, iconVar) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				iconVar[k].setMap(null);
			}
		}
	});
}

function addRoad(plId, roadWidth, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=roadBorder&id='+plId, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['rdCoord'+plId] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['rdCoord'+plId][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['rdArea'+plId] = new google.maps.Polyline({
    			 path: window['rdCoord'+plId],
    			 geodesic: true,
    			 strokeColor: '#fbdc00',
    			 strokeOpacity: 1.0,
    			 strokeWeight: roadWidth
  			});
			window['rdArea'+plId].setMap(mapVar);
		}
	});
}

function addMarker(region, type, image, mapVar, iconVar, year) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarks&type='+type+'&region='+region+'&year='+year, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			if(type != 7) {
			var zoomlevel = mapLarge.getZoom();
			if(zoomlevel < 13) {
				var subtract = 1;
			} else {
				var subtract = zoomlevel - 1;
			}
			var levelmultiplier = subtract;
			var iconImg = {
				url: image,
   				size: new google.maps.Size(levelmultiplier, levelmultiplier),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier/2,levelmultiplier),
				scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
			}
			} else {
			
			var zoomlevel = mapLarge.getZoom();
			if(zoomlevel < 13) {
				var subtract = 1;
			} else {
				var subtract = zoomlevel - 1;
			}
			var levelmultiplier = subtract;
			var iconImg = {
				url: image,
   				size: new google.maps.Size(levelmultiplier, levelmultiplier),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier,levelmultiplier),
				scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
			}
			
			}
			/*var iconImg = {
				url: image,
   				size: new google.maps.Size(26, 26),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(4,4),
				scaledSize: new google.maps.Size(8, 9)
			}*/
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

function addWalk(region, color, radius, opacity, type, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>report.php?action=getRegionMarkers&type='+type+'&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				busCircle[k] = new google.maps.Circle({
    				center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: mapVar,
					fillColor: color,
					radius: radius,
					strokeWeight: 1,
					strokeColor: '#fef5eb',
					fillOpacity: opacity,
					strokeOpacity: 0.2
  				});
				busCircle[k].setMap(mapVar);
			}
		}
	});
}

function addTorongarts(section, mapVar) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=torongartsBorder&torongarts='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['torongartsCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['torongartsCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['torongartsArea'+section] = new google.maps.Polygon({
    			path: window['torongartsCoord'+section],
    			 strokeColor: '#440101',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#ac0707',
    			 fillOpacity: 0.7
  			});
			window['torongartsArea'+section].setMap(mapVar);
		}
	});
}

function addSection(section, color, mapVar, opac) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['sectionCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['sectionCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['sectionArea'+section] = new google.maps.Polygon({
    			path: window['sectionCoord'+section],
    			 strokeColor: '#000000',
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: color,
    			 fillOpacity: opac
  			});
			window['sectionArea'+section].setMap(mapVar);
		}
	});
}

function fitBoundary(region, where) {
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
			myFitBounds(where, khorooBounds);
			regionArea.setMap(where);
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

function regionBorder(district, region, where) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
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

function addRegion(district, region) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			if(region == <?php echo $region['id']; ?>) {
				window['regionArea'+region] = new google.maps.Polygon({
					paths: regionCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#f7c567',
					fillOpacity: 1
				});
			} else {
				window['regionArea'+region] = new google.maps.Polygon({
					paths: regionCoord,
					strokeColor: '#000',
					strokeOpacity: 1,
					strokeWeight: 2,
					fillColor: '#FFF',
					fillOpacity: 1
				});
			}
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
	loadScript();
	var ctx = document.getElementById("canvas").getContext("2d");
	window.myBar = new Chart(ctx).Bar(barChartData, {
		responsive : true
	});
}

</script>

<?php
include(SITE_TEMPLATE. "footer.php");
?>