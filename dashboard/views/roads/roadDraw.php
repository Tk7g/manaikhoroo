<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Замын зураглал /<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid">
	<div class="box2 span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>замын зураглал нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content2">
			<form action="road.php?action=draw" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_SESSION['login']['district_id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_SESSION['login']['region_id']; ?>" id="regionId">
				<input type="hidden" name="coordinate" id="RoadCoordinate" value="" />
				
				<div class="inputRow2">
					<div class="inputBlock">
						<label>Зам, гудамжны нэр</label>
						<input style="width: 100px;" name="title" id="RoadTitle" required="required">
					</div>
					<div class="inputBlock">
						<label>Байршил</label>
						<input style="width: 100px;" name="location" id="Location" required="required">
					</div>
					<div class="inputBlock">
						<label>Замын хучилтын төрөл</label>
						<select name="info1" id="Info1" style="width: 140px; font-size: 12px; line-height:12px; height: 26px; padding: 2px 5px; border: 1px solid #999 !important;" required="required">
							<option value="1">1 - (Цемент бетон болон асфальт бетон өнгөт хучилттай)</option>
							<option value="2">2 - (Дайрган буюу хайрган хучилттай авто зам)</option>
							<option value="3">3 - (Буталсан чулуугаар тэгшилж, сайжруулсан хөрсөн зам)</option>
							<option value="4">4 - (Хучилт хийгдээгүй энгийн шороон хөрсөн зам)</option>
						</select>
					</div>
					<div class="inputBlock">
						<label>Замын урт /км/</label>
						<input style="width: 90px;" name="info2" id="Info2" required="required">
					</div>
					<div class="inputBlock">
						<label>Замын өргөн /метр/</label>
						<select style="width: 120px;" name="info3" id="Info3" required="required" style="width: 140px; font-size: 12px; line-height:12px; height: 26px; padding: 2px 5px; border: 1px solid #999 !important;">
							<?php for($i=1; $i<=20; $i=$i+0.1) { ?>
							<option value="<?php echo $i; ?>"><?php echo $i.' метр'; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="inputBlock">
						<label>Он</label>
						<select name="year" id="Year" required="required" style="width: 60px; font-size: 12px; line-height:12px; height: 26px; padding: 2px 5px; border: 1px solid #999 !important;">
							<?php foreach($years as $yr) : ?>
							<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="inputRow3">
					<div class="inputBlock3">
						<input id="reset" value="Замын зураглал устгах" type="button" class="navi" />
					</div>
					<div class="inputBlock3">
						<button type="submit" name="saveRoad" class="btn btn-primary">Хадгалах</button>
					</div>
				</div>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>
<div id="test">
	
</div>

<script>
	var windowHeight  = $(window).height(); 
	$("#marker-map").css( "height", 0.89*windowHeight );
</script>

<script>

var map;

var contentString = '';
var polygonSection = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];
var drawingManager;
var infoWindow;

<?php foreach($sections as $section) : ?>
	var roadCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var latlngbounds = new google.maps.LatLngBounds();
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	  addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	<?php 
		foreach($roads as $road) : 
			if($road['info3'] == NULL) {
	?>
		addRoad(<?php echo $road['id']; ?>, 3);
	<?php
			} else {
	?>
		addRoad(<?php echo $road['id']; ?>, <?php echo $road['info3']/3; ?>);
	<?php
			}
		endforeach; 
	?>
	
	drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYLINE,
		drawingControl: true,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: [
				google.maps.drawing.OverlayType.POLYLINE,
			]
		},
		polylineOptions: {
			strokeColor: "#d70202",
			strokeWeight: 3,
			clickable: true,
			editable: true,
			zIndex: 1
		}
	});
	
	$('#reset').click(function(){ 
		polygonSection.setMap(null);
		contentString = '';
		drawingManager.setOptions({
			drawingControl: true,
			drawingMode: google.maps.drawing.OverlayType.POLYLINE,
		});
		infoWindow.open(null);
	});
	
	textString = '<div id="drawInfoWindow" style="height: 50px; width: 260px;"><div class="buttonDrawPolygon"><button type="submit" name="saveRoad" class="saveDrawPolygonBtn">Хадгалах</button></div><div class="buttonDrawPolygon"><a class="deleteDrawPolygonBtn" onclick="deletePolygonDraw();">Устгах</a></div><div class="buttonDrawPolygon"><a class="editDrawPolygonBtn" onclick="deleteInfoWindow();">Засварлах</a></div></div>';
	
	infoWindow = new google.maps.InfoWindow({
      	content: textString
  	});
	
	drawingManager.setMap(map);
	
	google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polg) {
		polygonSection = polg;
		var drawnPolygon = polg.getPath();
		latlngbounds = new google.maps.LatLngBounds();
		for(var i=0; i < drawnPolygon.getLength(); i++) {
			contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
			latlngbounds.extend(drawnPolygon.getAt(i));
		}
		$("#RoadCoordinate").val(contentString);
		$("#Info2").val(google.maps.geometry.spherical.computeLength(polg.getPath())*0.001);
		infoWindow.setPosition(latlngbounds.getCenter());
		infoWindow.open(map);
		drawingManager.setDrawingMode(null);
		google.maps.event.addListener(drawnPolygon, 'set_at', function() {
			latlngbounds = new google.maps.LatLngBounds();
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
				latlngbounds.extend(drawnPolygon.getAt(i));
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
			infoWindow.setPosition(latlngbounds.getCenter());
			infoWindow.open(map);
  		});

		google.maps.event.addListener(drawnPolygon, 'insert_at', function() {
			latlngbounds = new google.maps.LatLngBounds();
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
				latlngbounds.extend(drawnPolygon.getAt(i));
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
			infoWindow.setPosition(latlngbounds.getCenter());
			infoWindow.open(map);
		});
		
		google.maps.event.addListener(drawnPolygon, 'remove_at', function() {
			latlngbounds = new google.maps.LatLngBounds();
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
				latlngbounds.extend(drawnPolygon.getAt(i));
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
			infoWindow.setPosition(latlngbounds.getCenter());
			infoWindow.open(map);
		});
	});

}

function deleteInfoWindow() {
	infoWindow.close();
	drawingManager.setOptions({
		drawingControl: false,
	});
}

function deletePolygonDraw() {
	polygonSection.setMap(null);
	polygonSection = '';
	contentString = '';
	drawingManager.setOptions({
		drawingControl: true,
		drawingMode: google.maps.drawing.OverlayType.POLYLINE,
	});
	infoWindow.close();
}

function addRoad(road, widthRoad) {
	$.getJSON('<?php echo MAIN_URL; ?>road.php?action=roadBorder&road='+road, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['roadCoord'+road] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['roadCoord'+road][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['roadArea'+road] = new google.maps.Polyline({
    			 path: window['roadCoord'+road],
    			 geodesic: true,
    			 strokeColor: '#fbdc00',
    			 strokeOpacity: 1.0,
    			 strokeWeight: widthRoad
  			});
			window['roadArea'+road].setMap(map);
		}
	});
}

function addRegion(region, image) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['khorooCoord'+region] = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				window['khorooCoord'+region][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			window['khorooArea'+region] = new google.maps.Polyline({
    			path: window['khorooCoord'+region],
    			geodesic: true,
    			strokeColor: '#000000',
    			strokeOpacity: 1.0,
    			strokeWeight: 3
  			});
			window['khorooArea'+region].setMap(map);
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&libraries=drawing&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>

<?php include(MAIN_TEMPLATE. "footer.php"); ?>