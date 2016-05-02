<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php">Зурган тэмдэглэгээ</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=delselect">Тэмдэглэгээ устгах</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $results['district']['title'].' дүүргийн зурган тэмдэглэгээ устгах'; ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="markers.php?action=deleteMarker&type=<?php echo $results['type']['id']; ?>" id="delDistrictMarker" method="post">
			<fieldset>
				<div class="inputRow">
					<div class="inputBlock">
						<label>Байршлын өргөрөг</label>
						<input type="text" name="latitude" id="MarkerLatitude" required="required" class="input-xlarge"/>
					</div>
					<div class="inputBlock">
						<label class="control-label" for="MarkerLongitude">Байршлын уртраг</label>
						<input type="text" name="longitude" id="MarkerLongitude" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div id="msg-block">
				</div>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div class="form-actions">
			</div>
			</form>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>

<script>

var map;
var infoWindow;
var iconmarker;
var contentString;
var points = [];

var khorooCoord<?php echo $results['region']['id']; ?> = [];
var khorooArea<?php echo $results['region']['id']; ?> = [];

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	
	map = new google.maps.Map(document.getElementById('marker-map'),
		mapOptions);
		addRegion(<?php echo $results['region']['id']; ?>, '<?php echo MAIN_FOLDER.''.$results['region']['image']; ?>');
		districtMarkers(<?php echo $results['type']['id']; ?>);
}

function districtMarkers(typeid) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=getRegionMarkers&type='+typeid, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				points[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $results['type']['image']; ?>'
  				});
				points[k].setMap(map);
				google.maps.event.addListener(points[k], 'click', function(event){
					if(infoWindow != null) {
						infoWindow.close(map);
					}
					$("#MarkerLatitude").val(event.latLng.lat());
					$("#MarkerLongitude").val(event.latLng.lng());
	
					contentString = '<div id="saveWindow" style="height: 100px;"><div class="saveDesc">Энэхүү тэмдэглэгээг устгах уу?</div><div class="choiceWindow"><a class="saveChoice DelChoice" onclick="delLocation();">Тийм</a><a class="saveChoice" onclick="deleteWindow();">Үгүй</a></div></div>';
	
					infoWindow = new google.maps.InfoWindow({
      					content: contentString,
						position: new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())
  					});
					infoWindow.open(map, points[k]);
				});
			}
		}
	});
}

function deleteWindow() {
	infoWindow.close(map);
}

function delLocation() {
	$.ajax({
		async:true, 
		data:$("#delDistrictMarker").serialize(), 
		dataType:"html", 
		success:function (data, textStatus) {$("#msg-block").html(data);},
		type:"post", 
		url:"<?php echo MAIN_URL; ?>markers.php?action=delMarker&type="+<?php echo $results['type']['id']; ?>
	});
	infoWindow.close(map);
	for(var k = 0; k < points.length; k++) {
		points[k].setMap(null);
		points[k] = null;
	}
	points = [];
	setTimeout(districtMarkers(<?php echo $results['type']['id']; ?>), 4000);
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
			window['khorooArea'+region] = new google.maps.Polygon({
				paths: window['khorooCoord'+region],
				strokeColor: '#28324e',
				strokeOpacity: 0.6,
				strokeWeight: 2,
				fillColor: '#54acd2',
				fillOpacity: 0.15
			});
			map.fitBounds(khorooBounds);
			var regionImage = {url: image};
			var regionImagePosition = getCenterOfPolygon(window['khorooArea'+region]);
			var regionName = new google.maps.Marker({
      			position: regionImagePosition,
      			map: map,
      			icon: regionImage
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>