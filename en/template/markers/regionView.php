<?php
error_reporting(0);
include(SITE_TEMPLATE. "header.php");
?>

<div id="map-header-region">
	<div id="map-district" style="height: 700px;">
	</div>
	<div id="map-marker-box">
		<?php include(SITE_TEMPLATE.'markers/map-marker.php'); ?>
	</div>
	<div id="district-select-box">
		<div class="dsb-title">
			District khoroos
		</div>
		<div class="dsb-content" style="overflow: hidden;">
		<?php foreach($results['regions'] as $region) : ?>
			<div class="ds-row">
				<div class="rs-link" data="<?php echo $region['id']; ?>">
				<?php echo $region['title']; ?>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<div class="dsb-title2" style="display: block; overflow: hidden;">
			Map Type
		</div>
		<div class="dsb-content">
			<div class="setOptions-row" id="roadMapSelect">
				Roadmap
			</div>
			<div class="setOptions-row" id="terrainSelect">
				Terrain
			</div>
			<div class="setOptions-row" id="hybridSelect">
				Hybrid
			</div>
		</div>
		<div class="dsb-content">
			<div class="colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="pop-density">
					</div>
					<div class="color-checked" data="pop-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Population Density
					</div>
				</div>
			</div>
			<div class="colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="kin-density">
					</div>
					<div class="color-checked" data="kin-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Absent from Kindergarten [%]
					</div>
				</div>
			</div>
			<div class="colorRow">
				<div class="color-checker">
					<div class="color-checkbox" data="school-density">
					</div>
					<div class="color-checked" data="school-density">
					</div>
				</div>
				<div class="color-description">
					<div class="color-title">
						Absent from School [%]
					</div>
				</div>
			</div>
			<div class="colorDataRow">
				<div id="popDensityColor">
					<div class="colorTitle">
						Key
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0 - <?php echo number_format($max_indicator[0]['density'], 2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[0]['density'], 2)+0.01; ?> - <?php echo number_format($max_indicator[1]['density'], 2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[1]['density'], 2)+0.01; ?> - <?php echo number_format($max_indicator[3]['density'], 2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[3]['density'], 2)+0.01; ?>+
						</div>
					</div>
				</div>
				<div id="kinDensityColor">
					<div class="colorTitle">
						Key
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 25%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							26% - 50%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							51% - 75%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							76% - 100%
						</div>
					</div>
				</div>
				<div id="schoolDensityColor">
					<div class="colorTitle">
						Key
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 25%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							26% - 50%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							51% - 75%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							76% - 100%
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
var map;
var zoomlevel;
var circles1 = [];
var circles11 = [];
var circles21 = [];
var circles31 = [];
var circles2 = [];
var circles12 = [];
var circles22 = [];
var circles32 = [];


<?php foreach($results['types'] as $mk_type) : ?>
	var points<?php echo $mk_type['id']; ?> = [];
<?php endforeach; ?>
<?php foreach($results['regions'] as $rg) : ?>
	var distArea<?php echo $rg['id']; ?> = '';
	var regionArea<?php echo $rg['id']; ?>;
	var regionTitle<?php echo $rg['id']; ?>;
<?php
	foreach($sections[$rg['id']] as $sec) {
?>
	var sectionArea<?php echo $sec['id']; ?>;
	var popArea<?php echo $sec['id'];  ?> = '';
	var sectionCoord<?php echo $sec['id']; ?> = [];
<?php
	}
	foreach($floods[$rg['id']] as $fld) {
?>
	var floodCoord<?php echo $fld['id']; ?> = [];
	var floodArea<?php echo $fld['id']; ?> = [];
<?php
	} 
	foreach($pls[$rg['id']] as $pl) {
?>
	var plCoord<?php echo $pl['id']; ?> = [];
	var plArea<?php echo $pl['id']; ?> = [];
<?php
	}
	endforeach; 
?>

function initialize() {
	var mapOptions = {
		zoom: <?php echo $results['district']['zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $results['district']['position'] ?>),
		panControl: false,
		maxZoom: 19,
		minZoom: 9,
		mapTypeId: google.maps.MapTypeId.HYBRID,
styles: [
  {
    featureType: 'administrative.locality',
    elementType: 'labels',
    stylers: [
      { color: '#1d2b01' },
      { visibility: "off" }
    ]
  },{
  	featureType: 'administrative.neighborhood',
  	elementType: 'labels',
  	stylers: [
  		{ visibility: 'off' }
  	]
  }
]
	};
	map = new google.maps.Map(document.getElementById('map-district'),
      mapOptions);
	  
	google.maps.event.addListener(map, 'zoom_changed', function() {
		
    	<?php foreach($results['types'] as $mk_type) : ?>
			if(points<?php echo $mk_type['id']; ?> !== 'undefined' && points<?php echo $mk_type['id']; ?>.length > 0) {
				removeMarker(<?php echo $mk_type['id']; ?>, <?php echo $results['district']['id']; ?>);
				addMarker(<?php echo $mk_type['id']; ?>, <?php echo $results['district']['id']; ?>);	
			}
		<?php endforeach; ?>
		
		<?php foreach($results['regions'] as $reg) : ?>
    		removeRegionTitle(<?php echo $reg['id']; ?>);
			addRegionTitle(<?php echo $reg['id']; ?>, <?php echo $reg['center'] ?>, <?php echo '"'.$reg['image'].'"'; ?>);
		<?php endforeach; ?>
		
  	});
  	
  	$(".color-checker").click(function(){
		var colorType = $(this).find(".color-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".color-checkbox").show();
			$(this).find(".color-checked").hide();
			$(this).removeAttr("data");
			if($(this).find(".color-checkbox").attr("data") == "pop-density") {
				$("#popDensityColor").hide();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						removeDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						removeRegionColor(<?php echo $sec['id']; ?>);
					<?php endforeach; ?>
				<?php endforeach; ?>
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").hide();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						removeDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						removeRegionColor(<?php echo $sec['id']; ?>);
					<?php endforeach; ?>
				<?php endforeach; ?>
			} 
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").hide();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						removeDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						removeRegionColor(<?php echo $sec['id']; ?>);
					<?php endforeach; ?>
				<?php endforeach; ?>
			}	
		} else {
			$(".color-checker").each(function() {
				$(this).removeAttr("data");
				$(this).find(".color-checked").hide();
				$(this).find(".color-checkbox").show();
				$("#popDensityColor").hide();
				$("#kinDensityColor").hide();
				$("#schoolDensityColor").hide();
			});
			$(this).find(".color-checkbox").hide();
			$(this).find(".color-checked").show();
			$(this).attr("data", "checked");
			if($(this).find(".color-checkbox").attr("data") == "pop-density") {
				$("#popDensityColor").show();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						if(distArea<?php echo $dist['id']; ?> != '') {
							removeDistrictBackground(<?php echo $dist['id']; ?>);
						}
						addDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						if(<?php echo 'popArea'.$sec['id']; ?> != '') {
							removeRegionColor(<?php echo $sec['id']; ?>);
						}
						<?php if($pop_district[$dist['id']][$sec['id']] != NULL) { ?>
						addRegionColor(<?php echo $sec['id']; ?>, '<?php echo $pop_district[$dist['id']][$sec['id']]; ?>');
						<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						if(distArea<?php echo $dist['id']; ?> != '') {
							removeDistrictBackground(<?php echo $dist['id']; ?>);
						}
						addDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						if(<?php echo 'popArea'.$sec['id']; ?> != '') {
							removeRegionColor(<?php echo $sec['id']; ?>);
						}
						<?php if($pop_district[$dist['id']][$sec['id']] != NULL) { ?>
						addRegionColor(<?php echo $sec['id']; ?>, '<?php echo $kin_district[$dist['id']][$sec['id']]; ?>');
						<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			} 
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				<?php foreach($results['regions'] as $dist) : ?>
					<?php if($sections[$dist['id']] == NULL) { ?>
						if(distArea<?php echo $dist['id']; ?> != '') {
							removeDistrictBackground(<?php echo $dist['id']; ?>);
						}
						addDistrictBackground(<?php echo $dist['id']; ?>);
					<?php } ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
						if(<?php echo 'popArea'.$sec['id']; ?> != '') {
							removeRegionColor(<?php echo $sec['id']; ?>);
						}
						<?php if($pop_district[$dist['id']][$sec['id']] != NULL) { ?>
							addRegionColor(<?php echo $sec['id']; ?>, '<?php echo $school_district[$dist['id']][$sec['id']]; ?>');
						<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}	
		}
	});

<?php foreach($results['regions'] as $region) : ?>
	addRegion(<?php echo $results['district']['id'] ?>, <?php echo $region['id']; ?>, '<?php echo MAIN_FOLDER.''.$region['image']; ?>');
	addRegionTitle(<?php echo $region['id']; ?>, <?php echo $region['center'] ?>, <?php echo '"'.$region['image'].'"'; ?>);
<?php endforeach; ?>

	$(".marker-checker").click(function(){
		var markerType = $(this).find(".marker-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".marker-checkbox").show();
			$(this).find(".marker-checked").hide();
			$(this).removeAttr("data");
			if(markerType == "sectionline") {
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($sections[$rg['id']] as $sec) {
				?>
					removeSection(<?php echo $sec['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "flood-pol") {
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($floods[$rg['id']] as $fld) {
				?>
					removeFlood(<?php echo $fld['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "pl-pol") {
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($pls[$rg['id']] as $pl) {
				?>
					removePlayground(<?php echo $pl['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "road-pol") { 
				map.setOptions({styles: roadStylesRemove});
			} else {
				$(".infobox-type"+markerType).empty();
				$(".markerbox-type"+markerType).empty();
				removeMarker(markerType, <?php echo $results['district']['id']; ?>);	
			}
		} else {
			$(this).find(".marker-checkbox").hide();
			$(this).find(".marker-checked").show();
			$(this).attr("data", "checked");
			if(markerType == "sectionline") {
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($sections[$rg['id']] as $sec) {
				?>
					addSection(<?php echo $sec['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "flood-pol") {
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($floods[$rg['id']] as $fld) {
				?>
					addFlood(<?php echo $fld['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "pl-pol") { 
				<?php 
					foreach($results['regions'] as $rg) : 
						foreach($pls[$rg['id']] as $pl) {
				?>
					addPlayground(<?php echo $pl['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "road-pol") { 
				map.setOptions({styles: roadStyles});
			} else {
				$.ajax({ 
					type: "post",
					data: { type: markerType, district: <?php echo $results['district']['id']; ?> },
					url:"infoBoxRegion.php",
					success:function (result) {
						$(".infobox-type"+markerType).html(result);
					}
				});
				$.ajax({ 
					type: "post",
					data: { type: markerType, district: <?php echo $results['district']['id']; ?> },
					url:"getDistrictMarkerInfo.php",
					success:function (result) {
						$(".markerbox-type"+markerType).html(result);
					}
				});
				$(".mainfobox-title").show();
				addMarker(markerType, <?php echo $results['district']['id']; ?>);
			}		
		}
	});
	
	$(".marker-checker-walk").click(function(){
		var circleType = $(this).find(".marker-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".marker-checkbox").show();
			$(this).find(".marker-checked").hide();
			$(this).removeAttr("data");
			removeWalk(circleType, <?php echo $results['district']['id']; ?>);
		} else {
			$(this).find(".marker-checkbox").hide();
			$(this).find(".marker-checked").show();
			$(this).attr("data", "checked");
			addWalk(circleType, <?php echo $results['district']['id']; ?>);	
		}
	});

var roadStylesRemove = [
  {
    featureType: 'road.arterial',
    elementType: 'geometry.fill'
  },{
    featureType: 'road.highway',
    elementType: 'geometry.fill'
  }
];

var roadStyles = [
  {
    featureType: 'road.arterial',
    elementType: 'geometry.fill',
    stylers: [
      { color: '#ffde00' }
    ]
  },{
    featureType: 'road.highway',
    elementType: 'geometry.fill',
    stylers: [
      { color: '#ffde00' }
    ]
  }
];



var styles1 = [
  {
    featureType: 'landscape',
    elementType: 'geometry.fill',
  },{
    featureType: 'poi',
    elementType: 'geometry.fill',
  }
];
	
	$("#terrainSelect").click(function(){
		map.setOptions({mapTypeId: google.maps.MapTypeId.TERRAIN});
	});
	$("#roadMapSelect").click(function(){
		map.setOptions({mapTypeId: google.maps.MapTypeId.ROADMAP, styles: styles1});
	});
	$("#hybridSelect").click(function(){
		map.setOptions({mapTypeId: google.maps.MapTypeId.HYBRID});
	});
	
	$(".rs-link").click(function(){
		fitBoundary(<?php echo $results['district']['id'] ?>, $(this).attr("data"));
		$.ajax({ 
			type: "post",
			data: { region_id: $(this).attr("data") },
			url:"regionInfo.php",
			success:function (result) {
				$(".info-detailed").html(result);
			}
		});
	});
}

function addMarker(typeid, district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+typeid+'&district='+district+'', function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			if(typeid != 7) {
			zoomlevel = map.getZoom();
			var levelmultiplier = zoomlevel-9;
			var iconImg = {
				url: point.image,
   				size: new google.maps.Size(levelmultiplier*4, levelmultiplier*4),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier*4/2,levelmultiplier*4),
				scaledSize: new google.maps.Size(levelmultiplier*4, levelmultiplier*4)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				window['points'+typeid][k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: iconImg
  				});
				window['points'+typeid][k].setMap(map);
			}
			} else {
			zoomlevel = map.getZoom();
			if(zoomlevel < 14) {
				var subtract = zoomlevel - 1;
			} else {
				var subtract = 11;
			}
			var levelmultiplier = zoomlevel - subtract;
			var iconImg = {
				url: point.image,
   				size: new google.maps.Size(levelmultiplier, levelmultiplier),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier,levelmultiplier),
				scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				window['points'+typeid][k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    				map: map,
					icon: iconImg
  				});
				window['points'+typeid][k].setMap(map);
			}
			}
		}
	});
}

function addFlood(floodId) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=risksBorder&id='+floodId, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['floodCoord'+floodId] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['floodCoord'+floodId][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['floodArea'+floodId] = new google.maps.Polygon({
    			path: window['floodCoord'+floodId],
    			 strokeColor: '#900202',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#d40202',
    			 fillOpacity: 0.6
  			});
			window['floodArea'+floodId].setMap(map);
		}
	});
}

function addPlayground(plId) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=playgroundBorder&id='+plId, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['plCoord'+plId] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['plCoord'+plId][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['plArea'+plId] = new google.maps.Polygon({
    			path: window['plCoord'+plId],
    			 strokeColor: '#4a9e32',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: '#a7d392',
    			 fillOpacity: 0.6
  			});
			window['plArea'+plId].setMap(map);
		}
	});
}

function removeFlood(flood) {
	window['floodArea'+flood].setMap(null);
	window['floodCoord'+flood] = [];
}

function removePlayground(plId) {
	window['plArea'+plId].setMap(null);
	window['plCoord'+plId] = [];
}

function addSection(section) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			window['sectionCoord'+section] = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				window['sectionCoord'+section][k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['sectionArea'+section] = new google.maps.Polygon({
    			path: window['sectionCoord'+section],
    			 strokeColor: '#7dd303',
    			 strokeOpacity: 1,
    			 strokeWeight: 2,
    			 fillColor: "#7dd303",
    			 fillOpacity: 0
  			});
			window['sectionArea'+section].setMap(map);
		}
	});
}

function removeRegionColor(section) {
	if(window['popArea'+section] != '') {
		window['popArea'+section].setMap(null);	
	}
	window['popArea'+section] = '';
}

function addRegionColor(section, color) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var popCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				popCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['popArea'+section] = new google.maps.Polygon({
				paths: popCoord,
				strokeColor: '#FFFFFF',
				strokeOpacity: 0,
				strokeWeight: 0,
				fillColor: color,
				fillOpacity: 0.6
			});
			window['popArea'+section].setMap(map);
		}
	});
}

function removeSection(section) {
	window['sectionArea'+section].setMap(null);
	window['sectionCoord'+section] = [];
}

function removeMarker(typeid, district) {
	for(var k = 0; k < window['points'+typeid].length; k++) {
		window['points'+typeid][k].setMap(null);
	}
	window['points'+typeid] = [];
}

function removeWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1; 
	} else {
		var walkid = 2;
	}
	for(var k = 0; k < window['circles'+walkid].length; k++) {
		window['circles'+walkid][k].setMap(null);
	}
	for(var k = 0; k < window['circles1'+walkid].length; k++) {
		window['circles1'+walkid][k].setMap(null);
	}
	for(var k = 0; k < window['circles2'+walkid].length; k++) {
		window['circles2'+walkid][k].setMap(null);
	}
	for(var k = 0; k < window['circles3'+walkid].length; k++) {
		window['circles3'+walkid][k].setMap(null);
	}
	window['circles'+walkid] = [];
	window['circles1'+walkid] = [];
	window['circles2'+walkid] = [];
	window['circles3'+walkid] = [];
}

function addWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1; 
	} else {
		var walkid = 2;
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+walkid+'&district='+district+'', function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.coordinate.length; k++) {
				if(walkid == 1) {
					window['circles'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#00371d",
						radius: 100,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles1'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#33bb7a",
						radius: 200,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles2'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#76f3b7",
						radius: 300,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles3'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#d7ffec",
						radius: 400,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
				} else {
					window['circles'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#013167",
						radius: 100,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles1'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#3c82d1",
						radius: 200,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles2'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#7fbbff",
						radius: 300,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles3'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    					map: map,
						fillColor: "#d2e7ff",
						radius: 400,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
				}
				window['circles'+walkid][k].setMap(map);
			}
		}
	});
}

function fitBoundary(district, region) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var khorooBounds = [];
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			window['regionArea'+region] = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#000000',
				strokeOpacity: 0,
				strokeWeight: 2,
				fillColor: '#FFFFFF',
				fillOpacity: 0
			});
			map.fitBounds(khorooBounds);
			window['regionArea'+region].setMap(map);
		}
	});
}

function removeRegionTitle(regionid) {
	window['regionTitle'+regionid].setMap(null);
	window['regionTitle'+regionid] = [];
}

function addRegionTitle(regionid, distlat, distlng, image) {
	zoomlevel = map.getZoom();
	if(zoomlevel < 14) {
		var levelmultiplier = 6;
	} else {
		var levelmultiplier = zoomlevel-2;
	}
	var iconImg = {
		url: '<?php echo MAIN_FOLDER; ?>'+image,
   		size: new google.maps.Size(levelmultiplier*6, levelmultiplier*2),
    	origin: new google.maps.Point(0,0),
    	anchor: new google.maps.Point(levelmultiplier*3,levelmultiplier),
		scaledSize: new google.maps.Size(levelmultiplier*6, levelmultiplier*2)
	}
	window['regionTitle'+regionid] = new google.maps.Marker({
    	position: new google.maps.LatLng(distlat, distlng),
    	map: map,
		icon: iconImg
  	});
	window['regionTitle'+regionid].setMap(map);
}

function addRegion(district, region, image) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var polBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				polBounds.extend(regionCoord[k]);
			}
			window['regionArea'+region] = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#f38924',
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: '#FFFFFF',
				fillOpacity: 0
			});
			window['regionArea'+region].setMap(map);
		}
	});
}

function removeDistrictBackground(regId) {
	window['distArea'+regId].setMap(null);
	window['distArea'+regId] = '';
}

function addDistrictBackground(regId) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+regId, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var regionCoord = [];
			var polBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				polBounds.extend(regionCoord[k]);
			}
			window['distArea'+regId] = new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#f38924',
				strokeOpacity: 0,
				strokeWeight: 0,
				fillColor: '#ffdc9c',
				fillOpacity: 0.6
			});
			window['distArea'+regId].setMap(map);
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
</div>
<div class="info-detailed">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-blue">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/population.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Total population
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['population']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-darkgreen">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/household.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Total household
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['household']); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-green">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/school.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Absent from school
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['school_num']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="detail-infobox detail-yellow">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/area.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Total area
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['area_length']); ?> га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-orange">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/pop-density.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Population density
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['population_density'], 2); ?> хүн/га
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="detail-infobox detail-red">
					<div class="detail-icon">
						<img src="<?php echo MAIN_FOLDER.'/icons/info/hospital.png'; ?>" class="img-responsive"/>
					</div>
					<div class="detail-info">
						<div class="detail-title">
							<?php echo $results['district']['title'].' district'; ?>
						</div>
						<div class="detail-description">
							Number of health clinics
						</div>
						<div class="detail-number">
							<?php echo number_format($results['district_info']['hospital_num']); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="infopage-title">
	Data of <?php echo $results['district']['title'].' district'; ?>
</div>
<div id="mapbox-info">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="mapbox-content">
				<?php foreach($results['types'] as $marker_type) : ?>
					<div class="infobox-type<?php echo $marker_type['id']; ?>">
					</div>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="statistic-chart">
	<div class="container">
<div class="row">
	<div class="col-md-2">
<div class="chart-choice-box">
	<div class="choice-btn" data="1">
		Total population
	</div>
	<div class="choice-btn" data="2">
		Total household
	</div>
	<div class="choice-btn" data="3">
		Total area
	</div>
	<div class="choice-btn" data="4">
		Population density
	</div>
	<div class="choice-btn" data="5">
		Number of health clinics
	</div>
	<div class="choice-btn" data="6">
		Number of water kiosks
	</div>
	<div class="choice-btn" data="7">
		Illegal trash dump sites
	</div>
</div>
	</div>
	<div class="col-md-8">
		<div id="chart-component">
<h2 class="title">Total population</h2>
<div id="population-chart" style="width: 100%; height: 300px;">
</div>

<script>
$(document).ready(function() {
	var datasets = {
		<?php foreach($results['regions'] as $region) : ?>
			"<?php echo 'region'.$region['id']; ?>": {
				label: "<?php echo $region['title']; ?>",
				data: [["<?php echo $region['title']; ?>", <?php if($results['region_infos'][$region['id']]['population'] != NULL) { echo $results['region_infos'][$region['id']]['population']; } else { echo 0; } ?>]]	
			},
		<?php endforeach; ?>
	};
	
	var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
	});
	
	var choiceContainer = $("#district-choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<div class='region-choice-row'><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label></div>");
	});
	
	choiceContainer.find("input").click(plotAccordingToChoices);
	
	function plotAccordingToChoices() {
		var data = [];
		choiceContainer.find("input:checked").each(function () {
			var key = $(this).attr("name");
			if (key && datasets[key]) {
				data.push(datasets[key]);
			}
		});
		if (data.length > 0) {
			$.plot("#population-chart", data , {
				series: {
					bars: {
						show: true,
						barWidth: 0.6,
						align: "center",
						fillColor: {
							colors: [
								{opacity: 1},
								{opacity: 1}
							]
						}
					},
					valueLabels: {
						show: true,
						align: 'center',
						font: "9pt 'Arial'"
					},
					grow: { 
						active: true,
						duration: 150
					}
				},
				xaxis: {
					mode: "categories",
					tickLength: 0,
					reserveSpace: true
				},
				legend: {
					show: false
				},
				grid: {
            		hoverable: true,
            		borderWidth: 0
        		}
			});
		}
	}
	
	plotAccordingToChoices();
	
	function show_tooltip(x, y, contents) {
       		$('<div id="population_tooltip">' + contents + '</div>').css({
				'font-size': '13px',
				'display': 'none',
				'top': y - 100,
				'left': x - 70,
				'position': 'absolute',
				'background': '#475577',
				'border': '2px solid #28324e',
				'color': '#FFF',
				'padding': '5px 10px',
				'z-index': '100000'
        	}).appendTo("body").fadeIn();
    	}

		var previous_point = null;
    	var previous_label = null;
 		
    	$("#population-chart").on("plothover", function (event, pos, item) {
        	if (item) {
            	if ((previous_point != item.dataIndex) || (previous_label != item.series.label)) {
                	previous_point = item.dataIndex;
                	previous_label = item.series.label;
 					$("#population_tooltip").remove();
                	var y = item.datapoint[1];
                	var x = item.series.label;
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>Khoroo "+ x +"<br/>Total population<br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
            	}
        	} else {
				$("#population_tooltip").remove();
            	previous_point = null;
            	previous_label = null;
        	}
    	});
	});
</script>
		</div>
	</div>
	<div class="col-md-2">
		<div id="district-choices"></div>
	</div>
</div>

<script>

$(document).ready(function () {
	$(".choice-btn").click(function() {
		var type = $(this).attr("data");
		$("#district-choices").empty();
		$.ajax({ 
			type: "post",
			url:"get_regionChart.php?type=" + type +'&district='+<?php echo $_GET['district']; ?>,
			success:function (result) {
				$("#chart-component").html(result);
			}
		});
		return false;
	});
});

</script>
	</div>
</div>
	<div class="rts-box">
			<div class="container">
					<div class="rts-selectbox">
						<form action="indicator.php?action=select" id="SelectRegionForm2" method="post">
						<div class="rts-input">
							<select name="region_id2" id="SelectRegion2" required="required">
								<option value="">Select</option>
								<?php foreach($results['districts'] as $dist) : ?>
									<option value="d<?php echo $dist['id']; ?>"><?php echo $dist['title'].' district'; ?></option>
									<?php foreach($results[$dist['id']] as $reg) : ?>
										<option value="<?php echo $reg['id']; ?>"><?php echo $dist['title'].' district Khoroo'.$reg['title']; ?></option>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							compare
						</div>
						<form action="indicator.php?action=select" id="SelectRegionForm1" method="post">
						<div class="rts-input">
							<select name="region_id" id="SelectRegion1" required="required">
								<option value="">Select</option>
								<?php foreach($results['regions'] as $rg) : ?>
								<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' district Khoroo'.$rg['title']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							Select khoroos to see data
						</div>
					</div>
			</div>
	</div>

<div id="statistic-table">
	<div class="container" id="statTableBlock">
<div class="col-label">
	<div class="row-header">
	</div>
	<div class="row-rgtable row-label">
		Total Population
	</div>
	<div class="row-rgtable row-label">
		Total Number Households
	</div>
	<div class="row-rgtable row-label">
		Average Household Size
	</div>
	<div class="row-rgtable row-label">
		Khoroo Area [Ha]
	</div>
	<div class="row-rgtable row-label">
		Population Density [p/Ha]
	</div>
	<div class="row-rgtable row-label">
		Percent of people living 5 min walk from bus stop
	</div>
	<div class="row-rgtable row-label">
		Number of Water Kiosks
	</div>
	<div class="row-rgtable row-label">
		Percent of people 5 min walk from kiosk
	</div>
	<div class="row-rgtable row-label">
		Ratio Water kiosks : 1,000 people
	</div>
	<div class="row-rgtable row-label">
		Number of Illegal Dump Sites
	</div>
	<div class="row-rgtable row-label">
		Percent of people 100 m near area of risk
	</div>
	<div class="row-rgtable row-label">
		Number of Health Centers
	</div>
	<div class="row-rgtable row-label">
		Ratio Health Centers : 1,000 people
	</div>
	<div class="row-rgtable row-label">
		Number of Children 2-5 not in Kindergarten
	</div>
	<div class="row-rgtable row-label">
		Percent of Children 2-5 not in Kindergarten
	</div>
	<div class="row-rgtable row-label">
		Number of Children 6-16 not in School
	</div>
	<div class="row-rgtable row-label">
		Percent of Children 6-16 not in School
	</div>
</div>

<div class="col-city">
	<div class="row-header text-center">
		Ulaanbaatar
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['population']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['household']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['household_average'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['area_length']); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['population_density'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['bus_density'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['well']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['well_density'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['well_ratio'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['trash']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['risk_ratio'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $cityMarkerCount['hospital']['COUNT(*)']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['hospital_ratio'], 2); ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['kin_num']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['kin_ratio'], 2).'%'; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo $results['city']['school_num']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php echo round($results['city']['school_ratio'], 2).'%'; ?>
	</div>
</div>

<div class="col-district">
	<div class="row-header text-center">
		<?php echo $results['district']['title']; ?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) {
				echo $results['district_info']['population'];	
			}  
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) { 
				echo $results['district_info']['household']; 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php
			if($results['district_info'] != NULL) { 
				echo round($results['district_info']['household_average'], 2); 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['area_length']); 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['population_density'], 2); 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['bus_density'], 2).'%'; 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo $districtMarkerCount['well']['COUNT(*)']; 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['well_density'], 2).'%'; 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['well_ratio'], 2); 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo $districtMarkerCount['trash']['COUNT(*)']; 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
			if($results['district_info'] != NULL) {
				echo round($results['district_info']['risk_ratio'], 2).'%'; 
			}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo $districtMarkerCount['hospital']['COUNT(*)']; 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['hospital_ratio'], 2); 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo $results['district_info']['kin_num']; 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['kin_ratio'], 2).'%'; 
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo $results['district_info']['school_num'];
		}
		?>
	</div>
	<div class="row-rgtable row-value">
		<?php 
		if($results['district_info'] != NULL) {
			echo round($results['district_info']['school_ratio'], 2).'%'; 
		}
		?>
	</div>
</div>
<div class="col-region" id="colRegion1">
</div>
<div class="col-region" id="colRegion2">
</div>
	</div>
</div>
<div class="yearStatTitle">
	Comparison by year (<?php echo $results['district']['title'].' district '; ?>)
</div>
<div class="year-statistics">
	<div class="container">
		<div class="row">
			<div class="yearstat-selection">
				<form action="indicator.php?action=yearSelect" id="YearStatForm" method="post">
					<div class="yearstat-input">
						<label>Year</label>
						<select name="year1" id="YearInfo1" required="required">
							<option value>Select year</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Year to compare</label>
						<select name="year2" id="YearInfo2" required="required">
							<option value>Select year</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Data</label>
						<select name="indicator_id" id="IndicatorInfo" required="required" style="width: 220px;">
							<option value>Select</option>
							<?php
								$n = 0;
								foreach($indicators as $k=>$v) : 
								$n = $n + 1;
							?>
								<option value="<?php echo $k; ?>"><?php echo $n.'. '.$v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Khoroo</label>
						<select name="region" id="RegionInfo" required="required" style="width: 220px;">
							<option value="">Select</option>
							<?php foreach($results['regions'] as $rg) : ?>
							<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' khoroo '.$rg['title']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<div id="yearstat-btn">Compare</div>
					</div>
				</form>
			</div>
			<div id="YearStatInfoBox">
				
			</div>
		</div>
	</div>
</div>
<?php
include(SITE_TEMPLATE. "footer.php");
?>
<script>
$(document).ready(function () {
	$("#SelectRegion1").bind("change", function (event) {$.ajax({async:true, data:$("#SelectRegionForm1").serialize(), dataType:"html", success:function (data, textStatus) {$("#colRegion1").html(data);}, type:"post", url:"getRegion1.php"});
	return false;});
	$("#SelectRegion2").bind("change", function (event) {$.ajax({async:true, data:$("#SelectRegionForm2").serialize(), dataType:"html", success:function (data, textStatus) {$("#colRegion2").html(data);}, type:"post", url:"getRegion2.php"});
	return false;});
	$("#yearstat-btn").bind("click", function (event) {$.ajax({async:true, data:$("#YearStatForm").serialize(), dataType:"html", success:function (data, textStatus) {$("#YearStatInfoBox").html(data);}, type:"post", url:"getYearStat.php"});
	return false;});
});
</script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.valuelabels.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.growraf.js"></script>