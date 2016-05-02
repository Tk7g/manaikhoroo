<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/section.php?action=regionSelect">Хэсгийн хил</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>хэсгийн хил баталгаажуулах</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<div id="sectionLists">
				<table width="100%">
					<tr>
						<th width="10%">№</th>
						<th width="35%">Хороо</th>
						<th width="30%">Хэсгийн дугаар</th>
						<th width="15%"></th>
						<th width="10%"></th>
					</tr>
					<?php
						$i = 0; 
						foreach($sections as $sec) : 
						$i = $i + 1;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $region['title']; ?>-р хороо</td>
						<td><?php echo $sec['title']; ?>-р хэсэг</td>
						<td><a href="section.php?action=sectionConfirm&region=<?php echo $_GET['region']; ?>&district=<?php echo $_GET['district']; ?>&section=<?php echo $sec['id']; ?>" class="btn btn-success">Баталгаажуулах</a></td>
						<td><a href="section.php?action=sectionCancel&region=<?php echo $_GET['region']; ?>&district=<?php echo $_GET['district']; ?>&section=<?php echo $sec['id']; ?>" class="btn btn-danger">Цуцлах</a></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div id="sectionDesc">
				<div class="sectionDesc">
					<div class="secConfirm">
					</div>
					<div class="secDesc">
						- Баталгаажсан
					</div>
				</div>
				<div class="sectionDesc">
					<div class="secNotConfirm">
					</div>
					<div class="secDesc">
						- Баталгаажуулаагүй
					</div>
				</div>
			</div>
			<div id="map-box">
				<div id="marker-map" style="height: 500px;"></div>
			</div>
		</div>
	</div>
</div>
<?php include(MAIN_TEMPLATE. "footer.php"); ?>
<script>

var map;

var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

<?php foreach($sections as $section) : ?>
	var sectionCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(<?php echo $region['center']; ?>)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
	  addRegion(<?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	<?php foreach($sections as $section) : ?>
		addSection(<?php echo $section['id']; ?>, '<?php echo MAIN_FOLDER.'/img/section/'.$section['title'].'.png'; ?>', '<?php if($section['published'] == 1){ echo "#00a300"; } else { echo "#eb3c00"; } ?>');
	<?php endforeach; ?>
	
	var creator = new PolygonCreator(map);
	
	$('#reset').click(function(){ 
		creator.destroy();
		creator=null;
		creator=new PolygonCreator(map);
	});
	
	$('#showData').click(function(){
		$('#SectionCoordinate').empty();
		if(null==creator.showData()){
			$('#SectionCoordinate').append('Хэсгийн хил үүсгэнэ үү');
		}else{
			$('#SectionCoordinate').val(creator.showData());
		}
	});
}

function addSection(section, image, color) {
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
    			 fillColor: color,
    			 fillOpacity: 0.4
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>