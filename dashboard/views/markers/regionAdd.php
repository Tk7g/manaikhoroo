<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>

<div class="row-fluid">
	<div class="box2">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon edit"></i><span class="break"></span><?php echo $results['district']['title'].' дүүргийн '.$results['region']['title'].'-р хорооны зурган тэмдэглэгээ нэмэх'; ?>
			<span style="margin-left: 40px;">Байршлын уртраг</span>
			<span id="MarkerLat"></span>
			<span style="margin-left: 15px;">Байршлын өргөрөг</span>
			<span id="MarkerLon"></span></h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content2">
			<form action="markers.php?action=saveDesc&type=<?php echo $results['type']['id']; ?>" id="saveDistrictMarker" method="post" enctype="multipart/form-data">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $results['district']['id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="" id="regionId">
				<input type="hidden" name="published" value="1" id="Published">
				<input type="hidden" value="<?php echo date('Y'); ?>" name="year" id="Year" />
				<input type="hidden" value="" name="markertitle" id="markerTitle"/>
				<input type="hidden" value="" name="markerphone" id="markerPhone"/>
				<input type="hidden" value="" name="markeremail" id="markerEmail"/>
				<input type="hidden" value="" name="markertext" id="markerText"/>
				<input type="hidden" name="latitude" id="MarkerLatitude" required="required" class="input-xlarge"/>
				<input type="hidden" name="longitude" id="MarkerLongitude" required="required" class="input-xlarge"/>
				<!--<div class="control-group">
					<label class="control-label" for="Image">Тайлбарын зураг</label>
					<div class="controls">
						<input type="file" name="image" id="Image">
					</div>
				</div>-->
				<div id="msg-block">
				</div>
				<div id="map-box">
					<div id="marker-map"></div>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>
<script>
	var windowHeight  = $(window).height(); 
	$("#marker-map").css( "height", 0.89*windowHeight );
</script>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script>

var map;
var marker;
var infoWindow;
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
	$("#MarkerLat").text(location.lat());
	$("#MarkerLon").text(location.lng());
	$("#regionId").val(region);
	
	contentString = '<div id="saveWindow" style="height: 100px;"><div class="saveDesc">Энэхүү тэмдэглэгээг хадгалах уу?</div><div class="choiceWindow"><a class="saveChoice" onclick="saveLocation();">Тийм</a><a class="saveChoice" onclick="deleteMarker();">Үгүй</a></div></div>';
	
	infoWindow = new google.maps.InfoWindow({
      	content: contentString
  	});
	
	infoWindow.open(map, marker);
	
	google.maps.event.addListener(infoWindow, 'closeclick', function(){
		deleteMarker();
	});
}

function districtMarkers(typeid) {
	$.getJSON('<?php echo MAIN_URL; ?>markers.php?action=getRegionPanelMarkers&type='+typeid, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				if(point.info[k][0] != null) {
					var markerInfoTitle = point.info[k][0];
				} else {
					var markerInfoTitle = '';
				}
				if(point.info[k][1] != null) {
					var markerInfoPhone = point.info[k][1];
				} else {
					var markerInfoPhone = '';
				}
				if(point.info[k][2] != null) {
					var markerInfoEmail = point.info[k][2];
				} else {
					var markerInfoEmail = '';
				}
				if(point.info[k][3] != null) {
					var markerInfoDesc = point.info[k][3];
				} else {
					var markerInfoDesc = '';
				}
				if(point.info[k][4] != null) {
					var markerInfoImage = point.info[k][4];
				} else {
					var markerInfoImage = '';
				}
				if(point.id[k][0] != null) {
					var markerId = point.id[k][0];
				} else {
					var markerId = '';
				}
				if(point.id[k][0] != null) {
					var markerId = point.id[k][0];
				} else {
					var markerId = '';
				}
				if(point.coordinate[k][0] != null) {
					var markerLatitude = point.coordinate[k][0];
				} else {
					var markerLatitude = '';
				}
				if(point.coordinate[k][1] != null) {
					var markerLongitude = point.coordinate[k][1];
				} else {
					var markerLongitude = '';
				}
				points[k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: '<?php echo $results['type']['image']; ?>',
					title: markerInfoTitle
  				});
				points[k].setMap(map);
				points[k].set('markerlatitude', markerLatitude);
				points[k].set('markerlongitude', markerLongitude);
				points[k].set('markertitle', markerInfoTitle);
				points[k].set('markerphone', markerInfoPhone);
				points[k].set('markeremail', markerInfoEmail);
				points[k].set('markerdesc', markerInfoDesc);
				points[k].set('markerimage', markerInfoImage);
				points[k].set('markerid', markerId);
				google.maps.event.addListener(points[k], 'click', function(event){
					var markerlatitude = this.get('markerlatitude');
					var markerlongitude = this.get('markerlongitude');
					var markertitle = this.get('markertitle');
					var markerphone = this.get('markerphone');
					var markeremail = this.get('markeremail');
					var markerdesc = this.get('markerdesc');
					var markerimage = this.get('markerimage');
					var markerid = this.get('markerid');
					if(markertitle == '') {
						$("#markerTitle").val('nothing');
					} else {
						$("#markerTitle").val(markertitle);
					}
					if(markerphone == '') {
						$("#markerPhone").val('nothing');
					} else {
						$("#markerPhone").val(markerphone);
					}
					if(markeremail == '') {
						$("#markerEmail").val('nothing');
					} else {
						$("#markerEmail").val(markeremail);
					}
					if(markerdesc == '') {
						$("#markerText").val('nothing');
					} else {
						$("#markerText").val(markerdesc);
					}
					if(infoWindow != null) {
						infoWindow.close(map);
					}
					$("#MarkerLatitude").val(event.latLng.lat());
					$("#MarkerLongitude").val(event.latLng.lng());
					if(markerimage != '') {
						contentString = '<div id="saveWindow" style="height: 350px; width: 310px;"><form action="markers.php?action=saveDescription&type=<?php echo $_GET['type']; ?>" id="markerForm'+markerid+'" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="'+markerid+'" /><input type="hidden" name="latitude" value="'+markerlatitude+'" /><input type="hidden" name="longitude" value="'+markerlongitude+'" /><div class="descInput"><label>Байршлын гарчиг</label><input type="text" name="title" id="Title'+k+'" value="'+markertitle+'" /></div><div class="descInput"><label>Утас</label><input type="text" value="'+markerphone+'" name="phone" id="Phone'+k+'" /></div><div class="descInput"><label>И-мэйл</label><input type="text" value="'+markeremail+'" name="email" id="Email'+k+'" /></div><div class="descInput"><label>Тайлбар</label><textarea name="description" id="Description'+k+'" >'+markerdesc+'</textarea></div><div class="descInput"><img src="http://manaikhoroo.ub.gov.mn/webroot/marker_img/'+markerimage+'" /></div><div class="descInput"><input type="file" name="image" id="Image"></div><div class="descInput"><input type="submit" name="saveMarkerDesc" value="Хадгалах" /></div></form></div>';
					} else {
						contentString = '<div id="saveWindow" style="height: 350px; width: 310px;"><form action="markers.php?action=saveDescription&type=<?php echo $_GET['type']; ?>" id="markerForm'+markerid+'" method="post" enctype="multipart/form-data"><input type="hidden" name="id" value="'+markerid+'" /><input type="hidden" name="latitude" value="'+markerlatitude+'" /><input type="hidden" name="longitude" value="'+markerlongitude+'" /><div class="descInput"><label>Байршлын гарчиг</label><input type="text" name="title" id="Title'+k+'" value="'+markertitle+'" /></div><div class="descInput"><label>Утас</label><input type="text" value="'+markerphone+'" name="phone" id="Phone'+k+'" /></div><div class="descInput"><label>И-мэйл</label><input type="text" value="'+markeremail+'" name="email" id="Email'+k+'" /></div><div class="descInput"><label>Тайлбар</label><textarea name="description" id="Description'+k+'" >'+markerdesc+'</textarea></div><div class="descInput"><input type="file" name="image" id="Image"></div><div class="descInput"><input type="submit" name="saveMarkerDesc" value="Хадгалах" /></div></form></div>';
					}
					
	
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

function getChangedText(field) {
	var markerInputText = field.value;
	$("#markerText").val(markerInputText);
}

function getChangedPhone(field) {
	var markerInputPhone = field.value;
	$("#markerPhone").val(markerInputPhone);
}

function getChangedEmail(field) {
	var markerInputPhone = field.value;
	$("#markerEmail").val(markerInputPhone);
}

function getChangedTitle(field) {
	var markerInputTitle = field.value;
	$("#markerTitle").val(markerInputTitle);
}

function deleteMarker() {
	marker.setMap(null);
	infoWindow.close(map);
}

function saveDesc() {
	$.ajax({
		async:true, 
		data:$("#saveDistrictMarker").serialize(), 
		dataType:"html", 
		success:function (data, textStatus) {$("#msg-block").html(data);},
		type:"post", 
		url:"<?php echo MAIN_URL; ?>markers.php?action=saveDesc&type="+<?php echo $results['type']['id']; ?>
	});
	infoWindow.close(map);
	for(var k = 0; k < points.length; k++) {
		points[k].setMap(null);
		points[k] = null;
	}
	points = [];
	setTimeout(districtMarkers(<?php echo $results['type']['id']; ?>), 2000);
	location.reload();
} 

function saveLocation() {
	$.ajax({
		async:true, 
		data:$("#saveDistrictMarker").serialize(), 
		dataType:"html", 
		success:function (data, textStatus) {
			location.href = 'http://manaikhoroo.ub.gov.mn/dashboard/markers.php?action=regionAdd3&type=<?php echo $results['type']['id']; ?>&id='+data;
		},
		type:"post", 
		url:"<?php echo MAIN_URL; ?>markers.php?action=saveDistrict&type="+<?php echo $results['type']['id']; ?>
	});
	marker = null;
	infoWindow.close(map);
	districtMarkers(<?php echo $results['type']['id']; ?>);
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

$(document).ready(function() { 
<?php foreach($markers as $mkr) : ?>
	$("#markerForm<?php echo $mkr['id']; ?>").ajaxForm({ 
        target: '#markerTest<?php echo $mkr['id']; ?>', 
    });
<?php endforeach; ?>
});
</script>