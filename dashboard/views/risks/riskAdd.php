<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/risks.php">Үерийн аюултай бүс /<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>үерийн аюултай бүс нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="risks.php?action=draw" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_SESSION['login']['district_id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_SESSION['login']['region_id']; ?>" id="regionId">
				<input type="hidden" value="<?php echo date('Y'); ?>" name="year" id="Year" />
				
				<label class="control-label" for="Coordinate">Үерийн аюултай бүсийн гарчиг (тайлбар, нэр)</label>
				<input name="title" id="regionId" required="required">
				<label class="control-label" for="Coordinate">Үерийн аюултай бүсийн координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="SectionCoordinate" required="required"></textarea>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
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
var drawingManager;
var polygonCoord = '';
var newPolygon;
var drawingManager;

var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

<?php foreach($sections as $section) : ?>
	var sectionCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	  addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	<?php foreach($sections as $section) : ?>
		addSection(<?php echo $section['id']; ?>);
	<?php endforeach; ?>

	drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
		drawingControl: true,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: [
				google.maps.drawing.OverlayType.POLYGON
			]
		},
		polygonOptions: {
			fillColor: '#7cc242',
			fillOpacity: 1,
			strokeWeight: 3,
			strokeColor: '#000000',
			clickable: false,
			zIndex: 1
		}
	});
	setDrawer(map);
	
	google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
  		if (event.type == google.maps.drawing.OverlayType.POLYGON) {
    		var polygonCoordArray = event.overlay.getPath();
			for(var i=0; i<polygonCoordArray.getLength();i++) {
				var xy = polygonCoordArray.getAt(i);
				polygonCoord += '(' + xy.lat() + ', ' + xy.lng() + ')';
			}
			$('#SectionCoordinate').val(polygonCoord);
			setDrawer(null);
			event.overlay.setMap(null);
			newPolygon = new google.maps.Polygon({
    			 path: polygonCoordArray,
    			 strokeColor: '#000000',
    			 strokeOpacity: 0,
    			 strokeWeight: 0,
    			 fillColor: '#7cc242',
    			 fillOpacity: 0.8
  			});
			newPolygon.setMap(map);
  		}
	});
}

function setDrawer(setting) {
	drawingManager.setMap(setting);
}

function addSection(section) {
	$.getJSON('<?php echo MAIN_URL; ?>risks.php?action=risksBorder&section='+section, function(point){
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
    			 strokeOpacity: 0,
    			 strokeWeight: 0,
    			 fillColor: '#7cc242',
    			 fillOpacity: 0.8
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