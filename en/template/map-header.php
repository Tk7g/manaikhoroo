<?php
	$res = Marker::homeView();
	$districts = District::getDistrictList();
	$results = Marker::districtView();
	$pop_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$kin_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	$school_color = array("#ffdc9c", "#e48801", "#a84600", "#730601");
	
	$current_year = Year::getDefaultYear();
	
	foreach($results['districts'] as $district) {
		$regions[$district['id']] = Region::getRegionList($district['id']);
		$floods[$district['id']] = Risks::getDistrictRisks($district['id']);
		$pls[$district['id']] = Playground::getDistrictPlaygrounds($district['id']);
		foreach($regions[$district['id']] as $reg) {
			$sections[$reg['id']] = Section::getRegionSections($reg['id']);
			foreach($sections[$reg['id']] as $sec) {
				$sec_info[$sec['id']] = Info::SectionInfo($reg['id'], $district['id'], $sec['title'], $current_year['year']);
				if($sec_info[$sec['id']] != NULL) {
				
				if($sec_info[$sec['id']]['population_density'] <= 15) {
					$pop_district[$sec['id']] = $pop_color[0];
				} elseif($sec_info[$sec['id']]['population_density'] > 15 && $sec_info[$sec['id']]['population_density'] <= 30) {
					$pop_district[$sec['id']] = $pop_color[1];
				} elseif($sec_info[$sec['id']]['population_density'] > 30 && $sec_info[$sec['id']]['population_density'] <= 35) {
					$pop_district[$sec['id']] = $pop_color[2];
				} else {
					$pop_district[$sec['id']] = $pop_color[3];
				}
				
				if($sec_info[$sec['id']]['kin_ratio'] <= 25 ) {
					$kin_district[$sec['id']] = $kin_color[0];
				} elseif($sec_info[$sec['id']]['kin_ratio'] > 25 && $sec_info[$sec['id']]['kin_ratio'] <= 50) {
					$kin_district[$sec['id']] = $kin_color[1];
				} elseif($sec_info[$sec['id']]['kin_ratio'] > 50 && $sec_info[$sec['id']]['kin_ratio'] <= 75) {
					$kin_district[$sec['id']] = $kin_color[2];
				} else {
					$kin_district[$sec['id']] = $kin_color[3];
				}
				
				if($sec_info[$sec['id']]['school_ratio'] <= 25 ) {
					$school_district[$sec['id']] = $school_color[0];
				} elseif($sec_info[$sec['id']]['school_ratio'] > 25 && $sec_info[$sec['id']]['school_ratio'] <= 50) {
					$school_district[$sec['id']] = $school_color[1];
				} elseif($sec_info[$sec['id']]['school_ratio'] > 50 && $sec_info[$sec['id']]['school_ratio'] <= 75) {
					$school_district[$sec['id']] = $school_color[2];
				} else {
					$school_district[$sec['id']] = $school_color[3];
				}
				
				}
			}
		}
	}
?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="homemap-box">
				<div class="homemap-title">
					Ulaanbaatar Community Maps
				</div>
				<div class="homemap-desc">
					A comprehensive neighborhood view of the communities of Ulaanbaatar. Select a khoroo to view the khoroo maps.
				</div>
				<!--<div class="homemap-swticher">
					<div class="switch-button switch-checked">
						Дүүрэг
					</div>
					<div class="switch-button">
						Хороо
					</div>
				</div>-->
				<div class="homemap-select">
					<select data-placeholder="Click to Browse" class="chosen-select" style="width:270px;" tabindex="2">
						<option value=""></option>
						<?php foreach($districts as $dist) : ?>
						<option class="district-option" value="http://manaikhoroo.ub.gov.mn/en/indicator.php?action=regionView&district=<?php echo $dist['id']; ?>"><?php echo $dist['title'].' district'; ?></option>
						<?php
							foreach($regions[$dist['id']] as $reg) :
						?>
							<option class="region-option" value="http://manaikhoroo.ub.gov.mn/en/indicator.php?action=regionSingle&district=<?php echo $dist['id']; ?>&region=<?php echo $reg['id']; ?>"><?php echo $dist['title'].' Khoroo '.$reg['title']; ?></option>
						<?php
							endforeach;
						endforeach; 
						?>
					</select>
				</div>
	<div id="home-mapbox">
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
						Absent from Kindergarden [%]
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
							0 - 15
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							16 - 30
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							31 - 35
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							36 +
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
			</div>
		</div>
		<div class="col-md-7">
			<div id="home-map">
			</div>
		</div>
		<div class="col-md-2">
			<div id="marker-tags">
				<?php include(SITE_TEMPLATE.'markers/home-marker.php'); ?>
			</div>
		</div>
	</div>
</div>

<script>
var map;
var infoWindow = '';
<?php foreach($districts as $dist) : ?>
	var districtArea<?php echo $dist['id']; ?>;
	var districtTitle<?php echo $dist['id']; ?>;
<?php endforeach; ?>

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
	foreach($regions[$dist['id']] as $rg) {
		if($sections[$rg['id']] != NULL) {
			foreach($sections[$rg['id']] as $sec) {
?>
	var popArea<?php echo $sec['id'];  ?> = '';
	var sectionArea<?php echo $sec['id']; ?>;
<?php
			}
		}	
	}
	foreach($floods[$dist['id']] as $fld) { 
?>
	var floodCoord<?php echo $fld['id']; ?> = [];
	var floodArea<?php echo $fld['id']; ?> = [];
<?php
	} 
	foreach($pls[$dist['id']] as $pl) { 
?>
	var plCoord<?php echo $pl['id']; ?> = [];
	var plArea<?php echo $pl['id']; ?> = [];
<?php
	} 
	endforeach; 
?>

function initialize() {
	var mapOptions = {
		zoom: 10,
		center: new google.maps.LatLng(47.918506, 106.917750),
		panControl: false,
		maxZoom: 16,
		minZoom: 8,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('home-map'),
      mapOptions);
      
    google.maps.event.addListener(map, 'zoom_changed', function() {
    	<?php foreach($res['districts'] as $district) : ?>
    		removeDistrictTitle(<?php echo $district['id']; ?>);
			addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
		<?php endforeach; ?>
		
		<?php foreach($results['types'] as $mk_type) : ?>
			if(points<?php echo $mk_type['id']; ?> !== 'undefined' && points<?php echo $mk_type['id']; ?>.length > 0) {
				removeMarker(<?php echo $mk_type['id']; ?>);
				addMarker(<?php echo $mk_type['id']; ?>);	
			}
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
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#00a5d3", fillOpacity: 0.1});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
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
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#00a5d3", fillOpacity: 0.1});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
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
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#00a5d3", fillOpacity: 0.1});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
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
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#ffdc9c", fillOpacity: 0.5});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
					<?php if($sections[$reg['id']] != NULL) { ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($pop_district[$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $pop_district[$sec['id']]; ?>');
							<?php } ?>
						<?php endforeach; ?>
					<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				<?php foreach($results['districts'] as $dist) : ?>
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#ffdc9c", fillOpacity: 0.5});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($kin_district[$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $kin_district[$sec['id']]; ?>');
							<?php } ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			} 
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				<?php foreach($results['districts'] as $dist) : ?>
				districtArea<?php echo $dist['id']; ?>.setOptions({fillColor: "#ffdc9c", fillOpacity: 0.5});
					<?php foreach($regions[$dist['id']] as $reg) : ?>
						<?php foreach($sections[$reg['id']] as $sec) : ?>
							if(<?php echo 'popArea'.$sec['id']; ?> != '') {
								removeDistrictColor(<?php echo $sec['id']; ?>);
							}
							<?php if($school_district[$sec['id']] != NULL) { ?>
								addDistrictColor(<?php echo $sec['id']; ?>, '<?php echo $school_district[$sec['id']]; ?>');
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
    
<?php
	foreach($res['districts'] as $district) {
		echo 'addDistrict('.$district['id'].', "'.$district['title'].'"); ';
?>
	addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
<?php
	} 
?>

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
						if($sections[$rg['id']] != NULL) {
							foreach($sections[$rg['id']] as $sec) {
				?>
					removeSection(<?php echo $sec['id']; ?>);
				<?php
							}
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
						if($sections[$rg['id']] != NULL) {
							foreach($sections[$rg['id']] as $sec) {
				?>
					addSection(<?php echo $sec['id']; ?>);
				<?php
							}
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

function addDistrict(district, district_title) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addBorderDistrict&district='+district, function(point){
		if(point.coordinate.length == 0) {
			return;
		} else {
			var districtCoord = [];
			for(var k = 0; k < point.coordinate.length; k++) {
				districtCoord[k] = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
			}
			window['districtArea'+district] = new google.maps.Polygon({
				paths: districtCoord,
				strokeColor: '#FFFFFF',
				strokeOpacity: 1,
				strokeWeight: 2,
				fillColor: '#00a5d3',
				fillOpacity: 0.1
			});
			window['districtArea'+district].setMap(map);
			google.maps.event.addListener(window['districtArea'+district], 'click', function(event){
				if(infoWindow != '') {
					infoWindow.close();
					infoWindow = '';
				}
				infoWindow = new google.maps.InfoWindow();
				var contentString = '<div class="mapLinkBox"><a href="<?php echo SITE_URL; ?>indicator.php?action=regionView&district='+district+'"><strong>'+district_title+'</strong> дүүргийн газрын зураглалын сан руу шилжих</a></div>';
				infoWindow.setContent(contentString);
				infoWindow.setPosition(event.latLng);
				infoWindow.open(map);
			});
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
    			 strokeColor: '#223500',
    			 strokeOpacity: 1,
    			 strokeWeight: 1,
    			 fillColor: '#1f6400',
    			 fillOpacity: 0.6
  			});
			window['plArea'+plId].setMap(map);
		}
	});
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

$(".chosen-select").chosen({no_results_text: "Хайлт олдсонгүй."}); 

$(".chosen-select").change(function(){ if ($(this).val()!='') { window.location.href=$(this).val(); } });

</script>