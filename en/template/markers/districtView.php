<?php
include(SITE_TEMPLATE. "header.php");
?>

<div id="map-header-district">
	<div id="map-district" style="height: 700px;">
	</div>
	<div id="map-marker-box">
		<?php include(SITE_TEMPLATE.'markers/map-marker.php'); ?>
	</div>
	<div id="district-select-box">
		<div class="dsb-title">
			Districts
		</div>
		<div class="dsb-content">
		<?php foreach($results['districts'] as $district) : ?>
			<div class="rs-row">
				<div class="ds-link">
				<a href="indicator.php?action=regionView&district=<?php echo $district['id']; ?>"><?php echo $district['title']; ?></a>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		
		<div class="dsb-title2">
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
						Population density
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
						Absent from kindergarten [%]
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
						Absent from school [%]
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
							0 - <?php echo number_format($max_indicator[0]['density'],2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[0]['density'],2)+0.01; ?> - <?php echo number_format($max_indicator[1]['density'],2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[1]['density'],2)+0.01; ?> - <?php echo number_format($max_indicator[2]['density'],2); ?>
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							<?php echo number_format($max_indicator[2]['density'],2)+0.01; ?> >
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
<?php foreach($results['types'] as $mk_type) : ?>
	var points<?php echo $mk_type['id']; ?> = [];
<?php endforeach; ?>
var circles1 = [];
var circles11 = [];
var circles21 = [];
var circles31 = [];
var circles2 = [];
var circles12 = [];
var circles22 = [];
var circles32 = [];

<?php 
foreach($results['districts'] as $dist) :
?>
<?php 
	foreach($regions[$dist['id']] as $rg) {
?>
	var distArea<?php echo $rg['id'] ?> = '';
	var regionColorArea<?php echo $rg['id']; ?>;
<?php
		foreach($sections[$rg['id']] as $sec) {
?>
	var popArea<?php echo $sec['id'];  ?> = '';
	var sectionArea<?php echo $sec['id']; ?>;
<?php
		}	
	}
?>
	var districtTitle<?php echo $dist['id']; ?>;
<?php foreach($floods[$dist['id']] as $fld) { ?>
	var floodCoord<?php echo $fld['id']; ?> = [];
	var floodArea<?php echo $fld['id']; ?> = [];
<?php
	} foreach($pls[$dist['id']] as $pl) { ?>
	var plCoord<?php echo $pl['id']; ?> = [];
	var plArea<?php echo $pl['id']; ?> = [];
<?php
	} 
	endforeach; 
?>

function initialize() {
	var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(47.918467, 106.919475),
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

<?php
	foreach($results['districts'] as $district) {
	 echo 'addDistrict('.$district['id'].'); ';	
?>
	addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
<?php
	}
?>
	
	google.maps.event.addListener(map, 'zoom_changed', function() {
    	<?php foreach($results['types'] as $mk_type) : ?>
			if(points<?php echo $mk_type['id']; ?> !== 'undefined' && points<?php echo $mk_type['id']; ?>.length > 0) {
				removeMarker(<?php echo $mk_type['id']; ?>);
				addMarker(<?php echo $mk_type['id']; ?>);	
			}
		<?php endforeach; ?>
		<?php foreach($results['districts'] as $district) : ?>
    		removeDistrictTitle(<?php echo $district['id']; ?>);
			addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
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
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							removeDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') { 
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").hide();
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							removeDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') { 
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			} 
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").hide();
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							removeDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') { 
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
						<?php endforeach; ?>
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
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							if(distArea<?php echo $reg['id']; ?> != '') {
								removeDistrictBackground(<?php echo $reg['id']; ?>);
							}
							addDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($pop_district[$reg['id']][$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $pop_district[$reg['id']][$sec['id']]; ?>');
							<?php } ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							if(distArea<?php echo $reg['id']; ?> != '') {
								removeDistrictBackground(<?php echo $reg['id']; ?>);
							}
							addDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($kin_district[$reg['id']][$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $kin_district[$reg['id']][$sec['id']]; ?>');
							<?php } ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			} 
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				<?php foreach($results['districts'] as $dist) : ?>
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php if($sections[$reg['id']] == NULL) { ?>
							if(distArea<?php echo $reg['id']; ?> != '') {
								removeDistrictBackground(<?php echo $reg['id']; ?>);
							}
							addDistrictBackground(<?php echo $reg['id']; ?>);
						<?php } ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($school_district[$reg['id']][$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $school_district[$reg['id']][$sec['id']]; ?>');
							<?php } ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}	
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

	$(".marker-checker").click(function(){
		var markerType = $(this).find(".marker-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".marker-checkbox").show();
			$(this).find(".marker-checked").hide();
			$(this).removeAttr("data");
			if(markerType == "flood-pol") {
				<?php 
					foreach($results['districts'] as $dist) : 
						foreach($floods[$dist['id']] as $fld) {
				?>
					removeFlood(<?php echo $fld['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "pl-pol") {
				<?php 
					foreach($results['districts'] as $dist) : 
						foreach($pls[$dist['id']] as $pl) {
				?>
					removePlayground(<?php echo $pl['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "road-pol") { 
				map.setOptions({styles: roadStylesRemove});
			} else if(markerType == "sectionline") {
				<?php 
				foreach($results['districts'] as $dist) : 
					foreach($regions[$dist['id']] as $rg) : 
						foreach($sections[$rg['id']] as $sec) {
				?>
					removeSection(<?php echo $sec['id']; ?>);
				<?php
						} 
					endforeach; 
				endforeach;
				?>
			} else {
				$(".infobox-type"+markerType).empty();
				removeMarker(markerType);
			}
		} else {
			$(this).find(".marker-checkbox").hide();
			$(this).find(".marker-checked").show();
			$(this).attr("data", "checked");
			if(markerType == "flood-pol") {
				<?php 
					foreach($results['districts'] as $dist) : 
						foreach($floods[$dist['id']] as $fld) {
				?>
					addFlood(<?php echo $fld['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "pl-pol") {
				<?php 
					foreach($results['districts'] as $dist) : 
						foreach($pls[$dist['id']] as $pl) {
				?>
					addPlayground(<?php echo $pl['id']; ?>);
				<?php
						} 
					endforeach; 
				?>
			} else if(markerType == "road-pol") { 
				map.setOptions({styles: roadStyles});
			} else if(markerType == "sectionline") {
				<?php 
				foreach($results['districts'] as $dist) : 
					foreach($regions[$dist['id']] as $rg) : 
						foreach($sections[$rg['id']] as $sec) {
				?>
					addSection(<?php echo $sec['id']; ?>);
				<?php
						} 
					endforeach; 
				endforeach;
				?>
			} else {
				$.ajax({ 
					type: "post",
					data: { type: markerType },
					url:"infobox.php",
					success:function (result) {
						$(".infobox-type"+markerType).html(result);
					}
				});
				addMarker(markerType);
			}	
		}
	});
	
	$(".marker-checker-walk").click(function(){
		var circleType = $(this).find(".marker-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".marker-checkbox").show();
			$(this).find(".marker-checked").hide();
			$(this).removeAttr("data");
			removeWalk(circleType);
		} else {
			$(this).find(".marker-checkbox").hide();
			$(this).find(".marker-checked").show();
			$(this).attr("data", "checked");
			addWalk(circleType);	
		}
	});
}

function removeDistrictTitle(districtid) {
	window['districtTitle'+districtid].setMap(null);
	window['districtTitle'+districtid] = [];
}

function addDistrictTitle(districtid, distlat, distlng, image) {
	zoomlevel = map.getZoom();
	var levelmultiplier = zoomlevel;
	var iconImg = {
		url: '<?php echo MAIN_FOLDER; ?>'+image,
   		size: new google.maps.Size(levelmultiplier*10, levelmultiplier*2),
    	origin: new google.maps.Point(0,0),
    	anchor: new google.maps.Point(levelmultiplier*5,levelmultiplier),
		scaledSize: new google.maps.Size(levelmultiplier*10, levelmultiplier*2)
	}
	window['districtTitle'+districtid] = new google.maps.Marker({
    	position: new google.maps.LatLng(distlat, distlng),
    	map: map,
		icon: iconImg
  	});
	window['districtTitle'+districtid].setMap(map);
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

function addSection(section) {
	$.getJSON('<?php echo SITE_URL; ?>marker.php?page=sectionBorder&section='+section, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			sectionCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				sectionCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['sectionArea'+section] = new google.maps.Polygon({
    			path: sectionCoord,
    			 strokeColor: '#fffffe',
    			 strokeOpacity: 1,
    			 strokeWeight: 1.5,
    			 fillColor: "#7dd303",
    			 fillOpacity: 0
  			});
			window['sectionArea'+section].setMap(map);
		}
	});
}

function removeSection(section) {
	window['sectionArea'+section].setMap(null);
	window['sectionArea'+section] = '';
}

function removePlayground(plId) {
	window['plArea'+plId].setMap(null);
	window['plCoord'+plId] = [];
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

function removeFlood(flood) {
	window['floodArea'+flood].setMap(null);
	window['floodCoord'+flood] = [];
}

function removeMarker(typeid) {
	for(var k = 0; k < window['points'+typeid].length; k++) {
		window['points'+typeid][k].setMap(null);
	}
	window['points'+typeid] = [];
}

function addMarker(typeid) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+typeid, function(point){
		if(point.marker.length == 0) {
			return;
		} else {
			if(typeid != 7) {
			zoomlevel = map.getZoom();
			var levelmultiplier = zoomlevel-9;
			var iconImg = {
				url: point.image.image,
   				size: new google.maps.Size(levelmultiplier*4, levelmultiplier*4),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier*4/2,levelmultiplier*4),
				scaledSize: new google.maps.Size(levelmultiplier*4, levelmultiplier*4)
			}
			for(var k = 0; k < point.marker.length; k++) {
				window['points'+typeid][k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
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
				url: point.image.image,
   				size: new google.maps.Size(levelmultiplier, levelmultiplier),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier,levelmultiplier),
				scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
			}
			for(var k = 0; k < point.marker.length; k++) {
				window['points'+typeid][k] = new google.maps.Marker({
    				position: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    				map: map,
					icon: iconImg
  				});
				window['points'+typeid][k].setMap(map);
			}
			}
		}
	});
}

function removeWalk(type) {
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
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+walkid, function(point){
		if(point.marker.length == 0) {
			return;
		} else {
			for(var k = 0; k < point.marker.length; k++) {
				if(walkid == 1) {
					window['circles'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#00371d",
						radius: 100,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles1'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#33bb7a",
						radius: 200,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles2'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#76f3b7",
						radius: 300,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
					window['circles3'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#d7ffec",
						radius: 400,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});	
				} else {
					window['circles'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#013167",
						radius: 100,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles1'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#3c82d1",
						radius: 200,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles2'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
    					map: map,
						fillColor: "#7fbbff",
						radius: 300,
						strokeWeight: 0,
						fillOpacity: 0.1
  					});
					window['circles3'+walkid][k] = new google.maps.Circle({
    					center: new google.maps.LatLng(point.marker[k][0], point.marker[k][1]),
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

function removeDistrictColor(section) {
	window['popArea'+section].setMap(null);
	window['popArea'+section] = '';
}

function addDistrictColor(section, color) {
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

function addDistrict(district) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				districtCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			var districtArea = new google.maps.Polygon({
				paths: districtCoord,
				strokeColor: '#f38924',
				strokeOpacity: 1,
				strokeWeight: 4,
				fillColor: '#FFFFFF',
				fillOpacity: 0
			});
			districtArea.setMap(map);
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
<div class="infopage-title">
	<?php echo 'Information of Ulaanbaatar'; ?>
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
		Total Population
	</div>
	<div class="choice-btn" data="2">
		Total Household
	</div>
	<div class="choice-btn" data="3">
		Total Area
	</div>
	<div class="choice-btn" data="4">
		Population Density
	</div>
	<div class="choice-btn" data="5">
		Number of Health Clinics
	</div>
	<div class="choice-btn" data="6">
		Number of Water kiosk
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
		<?php foreach($results['districts'] as $district) : ?>
			"<?php echo 'district'.$district['id']; ?>": {
				label: "<?php echo $district['title']; ?>",
				data: [["<?php echo $district['title']; ?>", <?php if($results[$district['id']]['info'] != NULL) { echo $results[$district['id']]['info']['population']; } else { echo 0; } ?>]]	
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
			choiceContainer.append("<br/><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label>");
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
        		},
				colors: [
					<?php foreach($results['districts'] as $district) : ?>
						"<?php echo $district['color']; ?>",
					<?php endforeach; ?>
				]
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
 
                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +" дүүрэг<br/>Хүн амын тоо<br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
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
			url:"get_chart.php?type=" + type,
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
<div class="stat-table-title">
		Data
</div>
<div id="statistic-table">
	<div class="container">
<table class="table table-striped">
	<thead>
		<tr>
			<th width="20%"></th>
			<th class="text-center">Ulaanbaatar city</th>
			<?php foreach($results['districts'] as $district) : ?>
				<th class="text-center"><?php echo $district['title']; ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Total Population</td>
			<td class="text-center"><?php echo $results['city']['population']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['population'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>otal Number Households</td>
			<td class="text-center"><?php echo $results['city']['household']; ?></td>
				<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['household'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Average Household Size</td>
			<td class="text-center"><?php echo round($results['city']['household_average'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['household_average'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Khoroo Area [Ha]</td>
			<td class="text-center"><?php echo round($results['city']['area_length']); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['area_length']);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Population Density [p/Ha]</td>
			<td class="text-center"><?php echo round($results['city']['population_density'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['population_density'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Percent of people living 5 min walk from bus stop</td>
			<td class="text-center"><?php echo round($results['city']['bus_density'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['bus_density'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Number of Water Kiosks</td>
			<td class="text-center"><?php echo $results['city']['bus_density']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['well_num'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Percent of people living 5 min walk from bus stop</td>
			<td class="text-center"><?php echo round($results['city']['well_density'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['well_density'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Ratio Water kiosks : 1,000 people</td>
			<td class="text-center"><?php echo round($results['city']['well_ratio'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['well_ratio'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Number of Illegal Dump Sites</td>
			<td class="text-center"><?php echo $results['city']['trash_num']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['trash_num'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Percent of people 100 m near area of risk</td>
			<td class="text-center"><?php echo round($results['city']['risk_ratio'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['risk_ratio'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Number of Health Centers</td>
			<td class="text-center"><?php echo $results['city']['hospital_num']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['hospital_num'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Ratio Health Centers : 1,000 people</td>
			<td class="text-center"><?php echo round($results['city']['hospital_ratio'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['hospital_ratio'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Number of Children 2-5 not in Kindergarten</td>
			<td class="text-center"><?php echo $results['city']['kin_num']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['kin_num'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Percent of Children 2-5 not in Kindergarten</td>
			<td class="text-center"><?php echo round($results['city']['kin_ratio'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['kin_ratio'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Number of Children 6-16 not in School</td>
			<td class="text-center"><?php echo $results['city']['school_num']; ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo $results[$district['id']]['info']['school_num'];	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
		<tr>
			<td>Percent of Children 6-16 not in School</td>
			<td class="text-center"><?php echo round($results['city']['school_ratio'], 2); ?></td>
			<?php foreach($results['districts'] as $district) : ?>
				<td class="text-center">
				<?php
					if($results[$district['id']]['info'] != NULL) {
						echo round($results[$district['id']]['info']['school_ratio'], 2);	
					} 
				?>
				</td>
			<?php endforeach; ?>
		</tr>
	</tbody>
</table>
	</div>
</div>

<?php
include(SITE_TEMPLATE. "footer.php");
?>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.categories.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.valuelabels.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/chart/jquery.flot.growraf.js"></script>