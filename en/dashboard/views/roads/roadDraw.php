<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php">Замын зураглал</a>
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
				
				<label class="control-label" for="Coordinate">Замын нэр (тайлбар)</label>
				<input name="title" id="RoadTitle">
				
				<label class="control-label" for="Coordinate">Замын зураглалын координатууд</label>
				<textarea style="width: 90%;" rows="10" name="coordinate" id="RoadCoordinate">
				</textarea>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			<div id="dataPanel"></div>
			<div id="btn-panel">
				<input id="reset" value="Замын зураглал устгах" type="button" class="navi"/>
				<input id="showData" value="Замын зураглалын координатууд гаргах" type="button" class="navi"/>
			</div>
			<div class="form-actions">
				<button type="submit" name="saveRoad" class="btn btn-primary">Хадгалах</button>
			</div>
			</form>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script type="text/javascript" src="<?php echo MAIN_FOLDER.'/js/polygon.js'; ?>"></script>
<script>

var map;

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
	  addRegion(<?php echo $region['id']; ?>);
	<?php foreach($roads as $road) : ?>
		addRoad(<?php echo $road['id']; ?>);
	<?php endforeach; ?>
	
	var creator = new PolygonCreator(map);
	
	$('#reset').click(function(){ 
		creator.destroy();
		creator=null;
		creator=new PolygonCreator(map);
	});
	
	$('#showData').click(function(){
		$('#RoadCoordinate').empty();
		if(null==creator.showData()){
			$('#RoadCoordinate').append('Хэсгийн хил үүсгэнэ үү');
		}else{
			$('#RoadCoordinate').val(creator.showData());
		}
	});
}

function addRoad(road) {
	$.getJSON('<?php echo MAIN_URL; ?>road.php?action=roadBorder&road='+road, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['roadCoord'+road] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['roadCoord'+road][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['roadArea'+road] = new google.maps.Polygon({
    			path: window['roadCoord'+road],
    			 strokeColor: '#000000',
    			 strokeOpacity: 0,
    			 strokeWeight: 0,
    			 fillColor: '#fca91c',
    			 fillOpacity: 0.8
  			});
			window['roadArea'+road].setMap(map);
		}
	});
}

function addRegion(region) {
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>