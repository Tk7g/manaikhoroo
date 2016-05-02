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

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>замын зураглал нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="road.php?action=draw" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_SESSION['login']['district_id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_SESSION['login']['region_id']; ?>" id="regionId">
				
				<label class="control-label" for="Coordinate">Зам, гудамжны нэр</label>
				<input name="title" id="RoadTitle" required="required">
				<label class="control-label" for="Coordinate">Байршил</label>
				<input name="location" id="Location" required="required">
				<label class="control-label" for="Width">Замын хучилтын төрөл (кодыг бичих)</label>
				<select name="info1" id="Info1">
					<option value="1">1 - (Цемент бетон болон асфальт бетон өнгөт хучилттай)</option>
					<option value="2">2 - (Дайрган буюу хайрган хучилттай авто зам)</option>
					<option value="3">3 - (Буталсан чулуугаар тэгшилж, сайжруулсан хөрсөн зам)</option>
					<option value="4">4 - (Хучилт хийгдээгүй энгийн шороон хөрсөн зам)</option>
				</select>
				<label class="control-label" for="Width">Замын урт /км/</label>
				<input name="info2" id="Info2" required="required">
				<label class="control-label" for="Width">Замын өргөн /метр/</label>
				<select name="info3" id="Info3" required="required">
					<option value="">Сонгоно уу</option>
					<?php for($i=1; $i<=20; $i=$i+0.1) { ?>
					<option value="<?php echo $i; ?>"><?php echo $i.' метр'; ?></option>
					<?php } ?>
				</select>
				<label class="control-label" for="Year">Он</label>
				<select name="year" id="Year">
					<option value="">Сонгоно уу</option>
					<?php foreach($years as $yr) : ?>
					<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
					<?php endforeach; ?>
				</select>
				<input type="hidden" name="coordinate" id="RoadCoordinate" value="" />
				<!--<label class="control-label" for="Coordinate">Замын зураглалын координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="RoadCoordinate" required="required"></textarea>-->
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
			<div id="btn-panel">
				<input id="reset" value="Замын зураглал устгах" type="button" class="navi" />
				<input id="showData" value="Замын зураглалын координатууд гаргах" type="button" class="navi"/>
			</div>
			<div class="form-actions">
				<button type="submit" name="saveRoad" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div id="test">
	
</div>

<script>

var map;

var contentString = '';
var polygonSection = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

<?php foreach($sections as $section) : ?>
	var roadCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
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
		addRoad(<?php echo $road['id']; ?>, <?php echo $road['info3']; ?>);
	<?php
			}
		endforeach; 
	?>
	
	var drawingManager = new google.maps.drawing.DrawingManager({
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
	});
	
	drawingManager.setMap(map);
	google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polg) {
		drawingManager.setOptions({
			drawingControl: false,
		});
		polygonSection = polg;
		var drawnPolygon = polg.getPath();
		for(var i=0; i < drawnPolygon.getLength(); i++) {
			contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
		}
		$("#RoadCoordinate").val(contentString);
		$("#Info2").val(google.maps.geometry.spherical.computeLength(polg.getPath())*0.001);
		drawingManager.setDrawingMode(null);
		google.maps.event.addListener(drawnPolygon, 'set_at', function() {
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
  		});

		google.maps.event.addListener(drawnPolygon, 'insert_at', function() {
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
		});
		
		google.maps.event.addListener(drawnPolygon, 'remove_at', function() {
			contentString = '';
			for(var i=0; i < drawnPolygon.getLength(); i++) {
				contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
			}
			$("#RoadCoordinate").val(contentString);
			$("#Info2").val(google.maps.geometry.spherical.computeLength(drawnPolygon)*0.001);
		});
	});

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