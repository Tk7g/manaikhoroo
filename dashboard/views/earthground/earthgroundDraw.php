<?php include(MAIN_TEMPLATE. "header.php"); ?>
<?php include(ADMIN_TEMPLATE."session_check.php"); ?>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
			<a href="/dashboard/">Эхлэл</a> 
		<i class="icon-angle-right"></i>
	</li>
	<li>
		<a href="/dashboard/earthground.php">Сул шороон хөрстэй талбай /<?php echo $district['title'].' дүүргийн '.$region['title'].'-р хороо'; ?>/</a>
	</li>
</ul>

<div class="row-fluid">
	<div class="box2 span12">
		<div class="box-header" data-original-title>
			<h2><i class="halflings-icon pencil"></i><span class="break"></span><?php echo $district['title'].' дүүргийн '.$region['title'].'-р хорооны '; ?>сул шороон хөрстэй талбай нэмэх</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content2">
			<form action="earthground.php?action=draw" id="" method="post">
			<fieldset>
				<input type="hidden" name="district_id" value="<?php echo $_SESSION['login']['district_id']; ?>" id="districtId">
				<input type="hidden" name="region_id" value="<?php echo $_SESSION['login']['region_id']; ?>" id="regionId">
				<input type="hidden" value="<?php echo date('Y'); ?>" name="year" id="Year" />
				<input type="hidden" name="coordinate" id="SectionCoordinate" />
				
				<div class="inputRow2">
					<div class="inputBlock">
						<label>Нэр, байршил</label>
						<input style="width: 230px;" name="title" id="Title" required="required" placeholder="Тайлбар (заавал бөглөнө)">
					</div>
					<div class="inputBlock">
						<label>Талбайн хэмжээ /м2/</label>
						<input name="area" id="AreaNum" required="required" style="width: 180px; margin-bottom: 20px;" placeholder="Талбайн хэмжээ /м2/">
					</div>
					<div class="inputBlock">
						<label>Талбайн урт /м/</label>
						<input name="areaLength" id="AreaLength" required="required" style="width: 180px; margin-bottom: 20px;" placeholder="Урт /м/">
					</div>
				</div>
				<div class="inputRow3">
					<div class="inputBlock3">
						<input id="reset" value="Сул шороон хөрстэй талбайн зураглал устгах" type="button" class="navi" />
					</div>
					<div class="inputBlock3">
						<button type="submit" name="saveSection" class="btn btn-primary">Хадгалах</button>
					</div>
				</div>
				<div id="map-box">
					<div id="marker-map" style="height: 500px;"></div>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
</div>

<script>

var windowHeight  = $(window).height(); 
$("#marker-map").css( "height", 0.89*windowHeight );

var map;

var measure;
var dotCount;

var contentString = '';
var khorooCoord<?php echo $region['id']; ?> = [];
var khorooArea<?php echo $region['id']; ?> = [];

<?php foreach($sections as $section) : ?>
	var sectionCoord<?php echo $section['id']; ?> = [];
<?php endforeach; ?>

function initialize() {
	var latlngbounds = new google.maps.LatLngBounds();
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
	
	measure = {
		mvcLine: new google.maps.MVCArray(),
		mvcPolygon: new google.maps.MVCArray(),
		mvcMarkers: new google.maps.MVCArray(),
		line: null,
		polygon: null
	};
	
	$('#reset').click(function(){
		location.reload();
	});
	
	google.maps.event.addListener(map, "click", function(evt) {
    	// When the map is clicked, pass the LatLng obect to the measureAdd function
    	measureAdd(evt.latLng);
	});

}


function measureAdd(latLng) {
	var marker = new google.maps.Marker({
      map: map,
      position: latLng,
      draggable: true,
      raiseOnDrag: false,
      title: "Drag me to change shape",
	});
  
	// Add this LatLng to our line and polygon MVCArrays
	// Objects added to these MVCArrays automatically update the line and polygon shapes on the map
	measure.mvcLine.push(latLng);
	measure.mvcPolygon.push(latLng);

	// Push this marker to an MVCArray
	// This way later we can loop through the array and remove them when measuring is done
	measure.mvcMarkers.push(marker);
	
	// Get the index position of the LatLng we just pushed into the MVCArray
	// We'll need this later to update the MVCArray if the user moves the measure vertexes
	var latLngIndex = measure.mvcLine.getLength() - 1;
	
	// When the measure vertex markers are dragged, update the geometry of the line and polygon by resetting the
	//     LatLng at this position
	google.maps.event.addListener(marker, "drag", function(evt) {
		measure.mvcLine.setAt(latLngIndex, evt.latLng);
		measure.mvcPolygon.setAt(latLngIndex, evt.latLng);
	});
	
	// When dragging has ended and there is more than one vertex, measure length, area.
	google.maps.event.addListener(marker, "dragend", function() {
		if (measure.mvcLine.getLength() > 1) {
			measureCalc();
		}
	});
	
	// If there is more than one vertex on the line
	if (measure.mvcLine.getLength() > 1) {

    // If the line hasn't been created yet
    if (!measure.line) {

      // Create the line (google.maps.Polyline)
      measure.line = new google.maps.Polyline({
        map: map,
        clickable: false,
        strokeColor: "#FF0000",
        strokeOpacity: 1,
        strokeWeight: 3,
        path:measure. mvcLine
      });

    }
    
    // If there is more than two vertexes for a polygon
    if (measure.mvcPolygon.getLength() > 2) {

      // If the polygon hasn't been created yet
      if (!measure.polygon) {

        // Create the polygon (google.maps.Polygon)
        measure.polygon = new google.maps.Polygon({
          clickable: false,
          map: map,
          fillOpacity: 0.25,
          strokeColor: "#FF0000",
          strokeOpacity: 1,
          paths: measure.mvcPolygon
        });

      }

    }
    }
    
      // If there's more than one vertex, measure length, area.
	if (measure.mvcLine.getLength() > 1) {
		measureCalc();
	}
    
}

function measureCalc() {
	dotCount = measure.mvcPolygon.getLength();
	var drawnLine = measure.line.getPath();
	var length = google.maps.geometry.spherical.computeLength(drawnLine);
	$("#AreaLength").val(length);
	
	var drawnPolygon = measure.polygon.getPath();
	var area = google.maps.geometry.spherical.computeArea(drawnPolygon);
	
	latlngbounds = new google.maps.LatLngBounds();
	for(var i=0; i < drawnPolygon.getLength(); i++) {
		contentString += '('+drawnPolygon.getAt(i).lat()+','+drawnPolygon.getAt(i).lng()+')';
		latlngbounds.extend(drawnPolygon.getAt(i));
	}
	
	$("#AreaNum").val(area);
	$("#SectionCoordinate").val(contentString);
}


function addSection(section) {
	$.getJSON('<?php echo MAIN_URL; ?>earthground.php?action=earthgroundBorder&section='+section, function(point){
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

<?php include(MAIN_TEMPLATE. "footer.php"); ?>