<?php 
include(ADMIN_TEMPLATE."session_check.php"); 
include(SITE_TEMPLATE. "header.php");
?>
<div id="userPage">
	<div class="container">
		<div class="col-md-2">
		<?php require(SITE_TEMPLATE . "users/menu-left.php"); ?>
		</div>
		<div class="col-md-10">
			<div class="addMarkerComponent">
				<form action="user.php?action=addMarker&type=<?php echo $_GET['type'].'&d='.$_GET['d'].'&r='.$_GET['r']; ?>" id="addMarker" method="post">
					<fieldset>
						<div class="form-group">
							<label for="MarkerLatitude">Байршлын өргөрөг</label>
							<input type="text" name="latitude" id="MarkerLatitude" required="required" class="form-control"/>
						</div>
						<div class="form-group">
							<label for="MarkerLongitude">Байршлын уртраг</label>
							<input type="text" name="longitude" id="MarkerLongitude" required="required" class="form-control"/>
						</div>
						<div class="delMyMarker">
							<a href="?page=delMyMarker&id=<?php echo $_GET['id']; ?>" class='btn btn-danger' onclick="return confirm('Энэ тэмдэглэгээг устгах уу?');"><i class="halflings-icon white trash"></i> Устгах</a>
						</div>
						<div id="msg-block">
							<?php echo $msg; ?>
						</div>
						<div id="map-box">
							<div id="marker-map" style="height: 500px;"></div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<script>

var map;
var marker;
var infoWindow;
var contentString;

var khorooCoord<?php echo $region['id'] ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];


function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	regionMarkers(<?php echo $type['id']; ?>, <?php echo $region['id']; ?>, <?php echo $user['id']; ?>)
}

function addMarker(location, region) {
	if(marker != null) {
		marker.setMap(null);
	}
	marker = new google.maps.Marker({
    	position: location,
    	map: map,
		icon: '<?php echo $type['image']; ?>'
  	});
	marker.setMap(map);
	$("#MarkerLatitude").val(location.lat());
	$("#MarkerLongitude").val(location.lng());
	$("#regionId").val(region);
	
	contentString = '<div id="saveWindow" style="height: 100px;"><div class="saveDesc">Энэхүү тэмдэглэгээг хадгалах уу?</div><div class="choiceWindow"><a class="saveChoice" onclick="saveLocation();">Тийм</a><a class="saveChoice" onclick="deleteMarker();">Үгүй</a></div></div>';
	
	infoWindow = new google.maps.InfoWindow({
      	content: contentString
  	});
	
	infoWindow.open(map, marker);
}

function regionMarkers(typeid, region, id) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=getNonPublishedRegionMarkers&type='+typeid+'&r='+region+'&id='+id, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var points = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				points[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $type['image']; ?>'
  				});
				points[k].setMap(map);
			}
		}
	});
}

function addRegion(region, image) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=regionBorder&region='+region, function(point){
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
				strokeColor: '#080808',
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: '#2d89ef',
				fillOpacity: 0.1
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
<?php
include(SITE_TEMPLATE. "footer.php");
?>