<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/risks.php">Үерийн аюултай бүс //</a>
	</li>
</ul>

<div class="row-fluid sortable">
	<div class="box span11">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span>үерийн аюултай бүс нэмэх</h2>
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
				
				<label class="control-label" for="Coordinate">Үерийн аюултай бүсийн гарчиг (тайлбар, нэр / Энэ нүдийг бөглөхгүй орхиж болно)</label>
				<input name="title" id="regionId">
				
				<label class="control-label" for="Area">Үерийн аюултай бүсийн талбайн хэмжээ /м<sup>2</sup>/</label>
				<input name="area" id="AreaNum" required="required">
				
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

var tester = '';

<?php
    	 foreach($districts as $dist) : 
    	 	$regions = Region::getRegionList($dist['id']);
    	 	foreach($regions as $reg) :
    	 		$sections = Risks::getRegionRisks($reg['id']);
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
    	 		$sections = Risks::getRegionRisks($reg['id']);
    	 		foreach($sections as $section) :
    ?>
  				addSection(<?php echo $section['id']; ?>);
     <?php
    			endforeach;
    		endforeach; 
    	endforeach; 
    ?>
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
    			 fillColor: '#b02020',
    			 fillOpacity: 0.8
  			});
  			window['sectionSquare'+section] = google.maps.geometry.spherical.computeArea(window['sectionArea'+section].getPath());
  			tester += 'id '+section+': '+window['sectionSquare'+section]+' ';
  			$("#SectionCoordinate").val(tester);
  			$.post( "risks.php?action=calculateArea", { id: section, area: window['sectionSquare'+section] } );
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