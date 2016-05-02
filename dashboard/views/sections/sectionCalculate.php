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
				<input name="area" id="AreaNum" required="required">
				
				<label class="control-label" for="Coordinate">Хэсгийн хилийн координатууд</label>
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

var contentString = '';
var polygonSection = '';
var tester = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

	<?php
    	 foreach($districts as $dist) : 
    	 	$regions = Region::getRegionList($dist['id']);
    	 	foreach($regions as $reg) :
    	 		$sections = Section::getRegionSections($reg['id']);
    	 		foreach($sections as $section) :
    ?>
var sectionSquare<?php echo $section['id']; ?> = '';
var sectionArea<?php echo $section['id']; ?> = '';
var sectionCoord<?php echo $section['id']; ?> = [];
     <?php
    			endforeach;
    		endforeach; 
    	endforeach; 
    ?>

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng(47.918506, 106.917750)
	};
	map = new google.maps.Map(document.getElementById('marker-map'),
      mapOptions);
    <?php
    	 foreach($districts as $dist) : 
    	 	$regions = Region::getRegionList($dist['id']);
    	 	foreach($regions as $reg) :
    	 		$sections = Section::getRegionSections($reg['id']);
    	 		foreach($sections as $section) :
    ?>
  				addSection(<?php echo $section['id']; ?>);
     <?php
    			endforeach;
    		endforeach; 
    	endforeach; 
    ?>
	<?php foreach($sections as $section) : ?>
		addSection(<?php echo $section['id']; ?>, '<?php echo MAIN_FOLDER.'/img/section/'.$section['title'].'.png'; ?>');
	<?php endforeach; ?>
}

function addSection(section) {
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
  			window['sectionSquare'+section] = google.maps.geometry.spherical.computeArea(window['sectionArea'+section].getPath());
  			tester += 'id '+section+': '+window['sectionSquare'+section]+' ';
  			$("#SectionCoordinate").val(tester);
  			$.post( "section.php?action=calculateArea", { id: section, area: window['sectionSquare'+section] } );
			window['sectionArea'+section].setMap(map);
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
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&libraries=geometry&callback=initialize";
  document.body.appendChild(script);
}

window.onload = loadScript();

</script>