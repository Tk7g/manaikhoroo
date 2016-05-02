<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=markerRegion">Зурган тэмдэглэгээ</a>
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/markers.php?action=civRegionMarker">Иргэдээс ирүүлсэн зурган тэмдэглэгээ</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $marker['districtTitle'].' дүүргийн '.$marker['regionTitle'].'-р хороонд ирүүлсэн зурган тэмдэглэгээ'; ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="markers.php?action=civRegionMarkerDecline&marker=<?php echo $marker['id']; ?>" id="declineDistrictMarker" method="post">
			<fieldset>
				<input type="hidden" name="id" value="<?php echo $marker['id']; ?>" id="markerId">
				<div class="control-group">
					<span>Байршлын өргөрөг: </span><?php echo $marker['latitude']; ?>
				</div>
				<div class="control-group">
					<span>Байршлын уртраг: </span><?php echo $marker['longitude']; ?>
				</div>
				<div class="control-group">
					<span>Овог нэр: </span><?php echo substr($marker['lastname'],0,2).'.'.$marker['firstname']; ?>
				</div>
				<div class="control-group">
					<span>Регистр №: </span><?php echo $marker['identity']; ?>
				</div>
				<div class="control-group">
					<span>И-мэйл: </span><?php echo $marker['email']; ?>
				</div>
				<div class="control-group">
					<span>Утас: </span><?php echo $marker['phone']; ?>
				</div>
				<?php if($marker['district_accept'] == 0) { ?>
				<button style="margin-bottom: 10px;" type="submit" name="declineMarker" class="btn btn-primary">Зөвшөөрлийг цуцлах</button>
				<?php } elseif($marker['district_accept'] == 1) { ?>
				<div>
					Зурган тэмдэглэгээг дүүрэг зөвшөөрсөн байгаа тул дүүргийн ажилтандаа хандана уу
				</div>
				<?php } ?>
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
var marker;
var infoWindow;
var contentString;

var khorooCoord<?php echo $marker['region_id']; ?> = [];
var khorooArea<?php echo $marker['region_id']; ?> = [];


function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	addRegion(<?php echo $marker['region_id']; ?>, '<?php echo MAIN_FOLDER.''.$marker['regionImage']; ?>');
	districtMarkers(<?php echo $marker['type_id']; ?>)
}

function districtMarkers(typeid) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=civRegionMarkers&type='+typeid+'&region_accept=1', function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var points = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				points[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $marker['typeImage']; ?>'
  				});
				points[k].setMap(map);
			}
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
			google.maps.event.addListener(window['khorooArea'+region], 'click', function(event){
				addMarker(event.latLng, region);
			});
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