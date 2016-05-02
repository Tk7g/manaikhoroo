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
		<a href="/dashboard/markers.php?action=select">Тэмдэглэгээ нэмэх</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $results['district']['title'].' дүүргийн зурган тэмдэглэгээ нэмэх'; ?></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form action="markers.php?action=saveDistrict&type=<?php echo $results['type']['id']; ?>" id="saveDistrictMarker" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $results['district']['id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="" id="regionId">
				<input type="hidden" name="published" value="1" id="Published">
				<div class="control-group">
					<label class="control-label" for="MarkerLatitude">Байршлын өргөрөг</label>
					<div class="controls">
						<input type="text" name="latitude" id="MarkerLatitude" required="required" class="input-xlarge"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="MarkerLongitude">Байршлын уртраг</label>
					<div class="controls">
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
var marker;
var infoWindow;
var contentString;

<?php foreach($results['regions'] as $region) : ?>
	var khorooCoord<?php echo $region['id']; ?> = [];
	var khorooArea<?php echo $region['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
<?php foreach($results['regions'] as $region) : ?>
	addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
<?php endforeach; ?>
	 districtMarkers(<?php echo $results['type']['id']; ?>)
}

function addMarker(location, region) {
	if(marker != null) {
		marker.setMap(null);
	}
	marker = new google.maps.Marker({
    	position: location,
    	map: map,
		icon: '<?php echo $results['type']['image']; ?>'
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

function districtMarkers(typeid) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=getMarkers&type='+typeid, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var points = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				points[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $results['type']['image']; ?>'
  				});
				points[k].setMap(map);
			}
		}
	});
}

function deleteMarker() {
	marker.setMap(null);
	infoWindow.close(map);
}

function saveLocation() {
	$.ajax({
		async:true, 
		data:$("#saveDistrictMarker").serialize(), 
		dataType:"html", 
		success:function (data, textStatus) {$("#msg-block").html(data);},
		type:"post", 
		url:"<?php echo MAIN_URL; ?>markers.php?action=saveDistrict&type="+<?php echo $results['type']['id']; ?>
	});
	marker = null;
	infoWindow.close(map);
} 

function addRegion(region, image) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['khorooCoord'+region] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['khorooCoord'+region][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['khorooArea'+region] = new google.maps.Polygon({
				paths: window['khorooCoord'+region],
				strokeColor: '#080808',
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: '#2d89ef',
				fillOpacity: 0.1
			});
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