<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Хэсгийн хил</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>хэсгийн хилийн нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="section.php?action=draw&district=<?php echo $_GET['district']; ?>&region=<?php echo $_GET['region']; ?>" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_GET['district']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_GET['region']; ?>" id="regionId">
				<?php if($_SESSION['login']['group_id'] == 3) { ?>
				<input type="hidden" name="published" value="0" id="regionId">
				<?php } ?>
				<label class="control-label" for="Coordinate">Хэсгийн дугаар</label>
				<input name="title" id="sectionId" required="required">
				
				<label class="control-label" for="Area">Хэсгийн талбайн хэмжээ /м<sup>2</sup>/</label>
				<input name="area" id="AreaNum" required="required" style="margin-bottom: 20px;">
				
				<input type="hidden" name="coordinate" id="SectionCoordinate" />
				<!--<label class="control-label" for="Coordinate">Хэсгийн хилийн координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="SectionCoordinate" required="required"></textarea>-->
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
			<div id="btn-panel">
				<input id="reset" value="Ногоон байгууламжийн зураглал устгах" type="button" class="navi" />
			</div>
			<div class="form-actions">
				<button type="submit" name="saveSection" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>

<script>

var map;

var contentString = '';
var polygonSection = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];
var drawingManager;
var infoWindow;

<?php foreach($sections as $section) : ?>
	var sectionCoord<?php echo $section['id']; ?> = [];
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
	<?php foreach($sections as $section) : ?>
		addSection(<?php echo $section['id']; ?>, '<?php echo MAIN_FOLDER.'/img/section/'.$section['title'].'.png'; ?>');
	<?php endforeach; ?>
	
	drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
		drawingControl: false,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: [
				google.maps.drawing.OverlayType.POLYGON,
			]
		},
		polygonOptions: {
			fillColor: '#444',
			fillOpacity: 0.5,
			strokeWeight: 3,
			clickable: false,
			editable: true,
			zIndex: 1
		}
	});
	
	$('#reset').click(function(){ 
		polygonSection.setMap(null);
		contentString = '';
		drawingManager.setOptions({
			drawingControl: true,
			drawingMode: google.maps.drawing.OverlayType.POLYGON,
		});
		infoWindow.open(null);
	});
	
	textString = '<div id="drawInfoWindow" style="height: 50px; width: 260px;"><div class="buttonDrawPolygon"><button type="submit" name="saveSection" class="saveDrawPolygonBtn">Хадгалах</button></div><div class="buttonDrawPolygon"><a class="deleteDrawPolygonBtn" onclick="deletePolygonDraw();">Устгах</a></div><div class="buttonDrawPolygon"><a class="editDrawPolygonBtn" onclick="deleteInfoWindow();">Засварлах</a></div></div>';
	
	infoWindow = new google.maps.InfoWindow({
      	content: textString
  	});
	
	drawingManager.setMap(map);
	
	google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polg) {
		polygonSection = polg;
		var drawnPolygon = polg.getPath();
		latlngbounds = new google.maps.LatLngBounds();
		for(var i=0; i < drawnPolygon.getLength(); i++) {
			contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
			latlngbounds.extend(drawnPolygon.getAt(i));
		}
		$("#SectionCoordinate").val(contentString);
		$("#AreaNum").val(google.maps.geometry.spherical.computeArea(polg.getPath()));
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
			$("#SectionCoordinate").val(contentString);
			$("#AreaNum").val(google.maps.geometry.spherical.computeArea(drawnPolygon));
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
			$("#SectionCoordinate").val(contentString);
			$("#AreaNum").val(google.maps.geometry.spherical.computeArea(drawnPolygon));
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
			$("#SectionCoordinate").val(contentString);
			$("#AreaNum").val(google.maps.geometry.spherical.computeArea(drawnPolygon));
			infoWindow.setPosition(latlngbounds.getCenter());
			infoWindow.open(map);
		});
	});
}

function deleteInfoWindow() {
	infoWindow.close();
}

function deletePolygonDraw() {
	polygonSection.setMap(null);
	polygonSection = '';
	contentString = '';
	drawingManager.setOptions({
		drawingControl: true,
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
	});
	infoWindow.close();
}

function addSection(section, image) {
	$.getJSON('<?php echo MAIN_URL; ?>section.php?action=sectionBorder&section='+section, function(point){
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
    			 strokeWeight: 1.5,
    			 fillColor: '#FFF',
    			 fillOpacity: 0
  			});
			var regionImage = {url: image};
			var regionImagePosition = getCenterOfPolygon(window['sectionArea'+section]);
			var regionName = new google.maps.Marker({
      			position: regionImagePosition,
      			map: map,
      			icon: regionImage
  			});
			window['sectionArea'+section].setMap(map);
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