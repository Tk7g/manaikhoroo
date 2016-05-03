<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/shared-map.js"></script>
<script>
var map;

var districts=<?php echo json_encode($results['districts']);?>;
var sections=<?php echo json_encode($sections);?>;

var sectionids = [];
var markers = {};
var styleByRegion = {};

var currentColors = null;
var colorsets = {
	population_density: [
		{
  		max: 35.54,
			color: '#ffdc9c'
		},{
  		max: 38.51,
			color: '#e48801'
		},{
  		max: 116.13,
			color: '#a84600'
		},{
			color: '#730601'
		}
	],
	education: [
		{
			max: 10,
			color: '#ffdc9c'
		},{
			max: 20,
			color: '#e48801'
		},{
			max: 30,
			color: '#a84600'
		},{
			color: '#730601'
		}
	]
};

function initialize() {
	initToggleMenu();
	<?php if(isset($regions)):?>
		var regions=<?php echo json_encode($regions);?>;
		var mapOptions = {
		zoom: 15,
		center: new google.maps.LatLng(47.918467, 106.919475),
		panControl: false,
		maxZoom: 19,
		minZoom: 9,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		streetViewControl: false,
		mapTypeControl:false,
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
		  },{
		    featureType: 'road',
		    elementType: 'geometry.stroke',
		    stylers: [
		      { color: '#dbd9c9' },
		      { "visibility": "simplified" }
		    ]
		  }
		]
			};
			map = new google.maps.Map(document.getElementById('map-district'),
		      mapOptions);
			map.mapTypes.set("OSM", new google.maps.ImageMapType({
				getTileUrl: function(coord, zoom) {
					return "//tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
				},
				tileSize: new google.maps.Size(256, 256),
				name: "OpenStreetMap",
				maxZoom: 18
			}));

		<?php
			foreach($results['districts'] as $district) {
			 echo 'addDistrict('.$district['id'].'); ';
		?>


			addDistrictTitle(<?php echo $district['id']; ?>, <?php echo $district['titlePosition'] ?>, <?php echo '"'.$district['image'].'"'; ?>);
		<?php
			}
		?>

			//generate sectionids
			for (var i = districts.length - 1; i >= 0; i--) {
				for (var j = regions[districts[i].id].length - 1; j >= 0; j--) {
					var region=regions[districts[i].id][j];
					for (var k = sections[region.id].length - 1; k >= 0; k--) {
						sectionids.push(sections[region.id][k].id);
					}
				}
			}
	<?php else:?>
		var regions=<?php echo json_encode($results['regions']);?>;
		
		var mapOptions = {
			<?php if(isset($_GET['region'])):?>
			zoom: <?php echo $current_region['zoom']; ?>,
			center: new google.maps.LatLng(<?php echo $current_region['center'] ?>),
			<?php else:?>
			zoom: <?php echo $results['district']['zoom']; ?>,
			center: new google.maps.LatLng(<?php echo $results['district']['position'] ?>),
			<?php endif;?>
			panControl: false,
			streetViewControl: false,
			maxZoom: 19,
			minZoom: 9,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
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
		infoWindow = new google.maps.InfoWindow({});

		var regionids=[];
		for (var i = regions.length - 1; i >= 0; i--) {
			regionids.push(regions[i].id);
		}
		addRegions(regionids);

		<?php foreach($results['regions'] as $reg) : ?>
			addRegionTitle(<?php echo $reg['title']; ?>, <?php echo $reg['center'] ?>, <?php echo '"'.$reg['image'].'"'; ?>);
		<?php endforeach; ?>
	<?php endif;?>


	$(".colorRow").click(function(){
		var colorType = $(this).find(".color-checkbox").attr("data");
		if($(this).attr("data") == "checked") {
			$(this).find(".color-checkbox").show();
			$(this).find(".color-checked").hide();
			$(this).removeAttr("data");

			if($(this).find(".color-checkbox").attr("data") == "pop-density") {
				$("#popDensityColor").hide();
				removeRegionColor();
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").hide();
				removeRegionColor();
			}
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").hide();
				removeRegionColor();
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
				currentColors = colorsets['population_density'];
				styleByRegion = {
					<?php if(isset($regions)):?>
						<?php foreach($results['districts'] as $dist) : ?>
							<?php foreach($regions[$dist['id']] as $reg) : ?>
								<?php foreach($sections[$reg['id']] as $sec) : ?>
									<?php if(isset($pop_district[$reg['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $pop_district[$reg['id']][$sec['id']]; ?>',<?php } ?>
						  		<?php endforeach; ?>
					  		<?php endforeach; ?>
						<?php endforeach; ?>
					<?php else:?>
						<?php foreach($results['regions'] as $dist) : ?>
							<?php foreach($sections[$dist['id']] as $sec) : ?>
								<?php if(isset($pop_district[$dist['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $pop_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endif;?>

				'x': 0
			  };
				setRegionColor('x', 1);
			}

			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				currentColors = colorsets['education'];
				styleByRegion = {
					<?php if(isset($regions)):?>
						<?php foreach($results['districts'] as $dist) : ?>
							<?php foreach($regions[$dist['id']] as $reg) : ?>
								<?php foreach($sections[$reg['id']] as $sec) : ?>
									<?php if(isset($kin_district[$reg['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $kin_district[$reg['id']][$sec['id']]; ?>',<?php } ?>
						  		<?php endforeach; ?>
					  		<?php endforeach; ?>
						<?php endforeach; ?>
					<?php else:?>
						<?php foreach($results['regions'] as $dist) : ?>
							<?php foreach($sections[$dist['id']] as $sec) : ?>
								<?php if(isset($kin_district[$dist['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $kin_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endif;?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}

			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				currentColors = colorsets['education'];
				styleByRegion = {
				<?php if(isset($regions)):?>
						<?php foreach($results['districts'] as $dist) : ?>
							<?php foreach($regions[$dist['id']] as $reg) : ?>
								<?php foreach($sections[$reg['id']] as $sec) : ?>
									<?php if(isset($school_district[$reg['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $school_district[$reg['id']][$sec['id']]; ?>',<?php } ?>
						  		<?php endforeach; ?>
					  		<?php endforeach; ?>
						<?php endforeach; ?>
					<?php else:?>
						<?php foreach($results['regions'] as $dist) : ?>
							<?php foreach($sections[$dist['id']] as $sec) : ?>
								<?php if(isset($school_district[$dist['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $school_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
							<?php endforeach; ?>
						<?php endforeach; ?>
					<?php endif;?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
		}

		if($('.color-checker .color-checked:hidden').length===3){
			$('#color-data-row').hide();
		}
		else{
			$('#color-data-row').show();
		}
	});

	$(".marker-row").click(function(e){
		var box = e.currentTarget;
		var markerType = $(box).find(".marker-checkbox").attr("data");
		if($(box).attr("data") == "checked") {
			$(box).find(".marker-checkbox").show();
			$(box).find(".marker-checked").hide();
			$(box).removeAttr("data");
			if(markerType == "flood-pol") {
				removeFloods();
			} else if(markerType == "pl-pol") {
				removePlaygrounds();
			} else if(markerType == "road-pol") {
				removeRoads();
				map.setOptions({styles: roadStylesRemove});
			} else if(markerType == "sectionline") {
				removeSections();
			} else if(markerType == "cableline") {
					removeMobinet();
			} else if(markerType == "gmobileline") {
					removeGmobile();
			} else if(markerType == "tnline") {
					removeTopnet();
			} else if(markerType == "sansarline") {
					removeSansar();
			} else if(markerType == "uniline") {
					removeUnivision();
			} else if(markerType == "magicline") {
					removeMagicnet();
			} else if(markerType == "niislelline") {
					removeNiislel();
			} else if(markerType == "zhutline") {
					removeZhut();
			} else {
				$(".infobox-type"+markerType).empty();
				removeMarker(markerType);
			}
		} else {
			$(box).find(".marker-checkbox").hide();
			$(box).find(".marker-checked").show();
			$(box).attr("data", "checked");
			if(markerType == "flood-pol") {
				addFloods();
			} else if(markerType == "pl-pol") {
				addPlaygrounds();
			} else if(markerType == "road-pol") {
				addRoads();
				map.setOptions({styles: roadStyles});
			} else if(markerType == "sectionline") {
			  addSections(sectionids);
			} else if(markerType == "cableline") {
					addMobinet();
			} else if(markerType == "gmobileline") {
					addGmobile();
			} else if(markerType == "tnline") {
					addTopnet();
			} else if(markerType == "sansarline") {
					addSansar();
			} else if(markerType == "uniline") {
					addUnivision();
			} else if(markerType == "magicline") {
					addMagicnet();
			} else if(markerType == "niislelline") {
					addNiislel();
			} else if(markerType == "zhutline") {
					addZhut();
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
	<?php if(!isset($regions)):?>
	$(".rs-link").click(function(e){
		$(".rs-link").removeClass("selected");
		$(e.currentTarget).addClass("selected");
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
	<?php endif;?>
}

function addDistrictTitle(districtid, distlat, distlng, image) {
  var zoomlevel = map.getZoom();
	var levelmultiplier = zoomlevel;
	var iconImg = {
		url: '<?php echo MAIN_FOLDER; ?>'+image,
   	size: new google.maps.Size(levelmultiplier*10, levelmultiplier*2),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(levelmultiplier*5,levelmultiplier),
		scaledSize: new google.maps.Size(levelmultiplier*10, levelmultiplier*2)
	};
	new google.maps.Marker({
    position: new google.maps.LatLng(distlat, distlng),
    map: map,
	  icon: iconImg
  });
}

function unfilterKhoroo() {
	var markerTypes = Object.keys(markers);
	for (var t = 0; t < markerTypes.length; t++) {
		if ($(".marker-checked[data=" + markerTypes[t] + "]").css('display') === "block") {
		  for (var m = 0; m < markers[markerTypes[t]].length; m++) {
				markers[markerTypes[t]][m].setMap(map);
			}
		}
	}
}

function filterKhoroo(khorooID) {
	if (currentKhoroo) {
		unfilterKhoroo();
		if (currentKhoroo == khorooID) {
			$(".rs-link").removeClass("selected");
			currentKhoroo = null;
			return;
		}
	}
	currentKhoroo = khorooID;

	map.fitBounds(knownBounds[khorooID]);
	var markerTypes = Object.keys(markers);
	for (var t = 0; t < markerTypes.length; t++) {
		for (var m = 0; m < markers[markerTypes[t]].length; m++) {
			var marker = markers[markerTypes[t]][m];
    	if (!google.maps.geometry.poly.containsLocation(marker.getPosition(), khoroos[khorooID])) {
			  marker.setMap(null);
			}
		}
	}
}

function fitBoundary(district, region) {
	if (!knownBounds[region]) {
  	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		  if(!point.coordinate || !point.coordinate.length) {
			  return;
		  } else {
				var khorooBounds = new google.maps.LatLngBounds();
				for(var k = 0; k < point.coordinate.length; k++) {
					khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
				}
				knownBounds[region] = khorooBounds;
				filterKhoroo(region);
			}
		});
	} else {
		filterKhoroo(region);
	}
}

var dataregions = [];

function addRegionTitle(regionid, distlat, distlng, image) {
	var zoomlevel = map.getZoom();
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
	};
	var title = new google.maps.Marker({
    position: new google.maps.LatLng(distlat, distlng),
    map: map,
		icon: iconImg
  });
	google.maps.event.addListener(title, 'click', function(event){
		if (!isNaN(1 * regionid)) {
  		$($(".dsb-content .rs-link")[1 * regionid - 1]).trigger('click');
		}
	});
}

function chooseColor(value) {
	value *= 1;
	if (!value) {
		return '#fff';
	}
	var estimateColor = currentColors[currentColors.length-1].color;
	for (var c = currentColors.length - 2; c >= 0; c--) {
		if (value > currentColors[c].max) {
			break;
		}
		estimateColor = currentColors[c].color;
	}
	return estimateColor;
}

function setRegionColor(section, color) {
	if (color) {
		strokeStyle.fillOpacity = 1;
	}
	if (!dataregions.length) {
		// convert to GeoJSON and add to Google Map if not done already
		var dists = Object.keys(sections);
		for (var ir = 0; ir < dists.length; ir++) {
			var rr = sections[dists[ir]];
			for (var r = 0; r < rr.length; r++) {
				var region = rr[r];
				var incoord = region.coordinate.split(')(');
				var coordinates = [];
				for (var c = 0; c < incoord.length; c++) {
					incoord[c] = incoord[c].replace('(','').replace(')','').split(', ');
					incoord[c][0] *= 1;
					incoord[c][1] *= 1;
					if (isNaN(incoord[c][0]) || isNaN(incoord[c][1])) {
						continue;
					}
					coordinates.push([incoord[c][1], incoord[c][0]]);
				}
				if (!coordinates.length) {
					continue;
				}
				coordinates.push(coordinates[0]);

				dataregions.push({
					id: region.id * 1,
					type: 'Feature',
					properties: {
						id: region.id * 1,
		  			title: region.title,
			  		district_id: region.district_id,
					  region_id: region.region_id,
					  area: region.area
					},
					geometry: {
						type: 'Polygon',
					  coordinates: [coordinates]
					}
				});
			}
		}

		map.data.setStyle({
			fillOpacity: strokeStyle.fillOpacity,
			strokeColor: strokeStyle.color,
			strokeOpacity: strokeStyle.opacity,
			strokeWeight: strokeStyle.weight
		});
		map.data.addGeoJson({
			type: 'FeatureCollection',
			features: dataregions
		});
	}

	styleByRegion[section] = color;
	map.data.setStyle(function(feature) {
		return {
			strokeColor: strokeStyle.color,
			strokeOpacity: strokeStyle.opacity,
			strokeWeight: strokeStyle.weight,
			fillColor: chooseColor(styleByRegion[feature.getId()]),
			// fill this region with the set color, unless no color exists or filling is off
			fillOpacity: ((strokeStyle.fillOpacity && styleByRegion[feature.getId()]) ? 0.6 : 0 )
		};
	});
}

function renderDistrictMarker(typeid, district) {
	if (markers[typeid] && markers[typeid].length) {
		for (var m = 0; m < markers[typeid].length; m++) {
			if (!currentKhoroo || google.maps.geometry.poly.containsLocation(markers[typeid][m].getPosition(), khoroos[currentKhoroo])) {
				markers[typeid][m].setMap(map);
			}
		}
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getInfoMarkers&type='+typeid+'&district='+district+'', function(point){
		if(!point.coordinate || !point.coordinate.length) {
			return;
		}
		var zoomlevel = map.getZoom();
		var iconImg;

		var setmap = map;

		if(typeid != 7) {
			var levelmultiplier = zoomlevel-9;
			iconImg = {
				url: point.image,
   			size: new google.maps.Size(levelmultiplier*4, levelmultiplier*4),
    		origin: new google.maps.Point(0,0),
    		anchor: new google.maps.Point(levelmultiplier*4/2,levelmultiplier*4),
				scaledSize: new google.maps.Size(levelmultiplier*4, levelmultiplier*4)
			};
			for(var k = 0; k < point.coordinate.length; k++) {
				var markerPt = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				if (currentKhoroo && !google.maps.geometry.poly.containsLocation(markerPt, khoroos[currentKhoroo])) {
					setmap = null;
				} else {
					setmap = map;
				}
				var marker = new google.maps.Marker({
    			position: markerPt,
    			map: setmap,
					icon: iconImg
  			});
				if (!markers[typeid]) {
					markers[typeid] = [];
				}
				markers[typeid].push(marker);
				clickMarker(marker, point.info[k]);
			}
		} else {
			if(zoomlevel < 14) {
				var subtract = zoomlevel - 1;
			} else {
				var subtract = 11;
			}
			var levelmultiplier = zoomlevel - subtract;
			iconImg = {
				url: point.image,
   			size: new google.maps.Size(levelmultiplier, levelmultiplier),
    		origin: new google.maps.Point(0,0),
    		anchor: new google.maps.Point(levelmultiplier,levelmultiplier),
				scaledSize: new google.maps.Size(levelmultiplier, levelmultiplier)
			};
			if (!markers[typeid]) {
				markers[typeid] = [];
			}
			for(var k = 0; k < point.coordinate.length; k++) {
				var markerPt = new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]);
				if (currentKhoroo && !google.maps.geometry.poly.containsLocation(markerPt, khoroos[currentKhoroo])) {
					setmap = null;
				} else {
					setmap = map;
				}
			  markers[typeid].push(new google.maps.Marker({
    		  position: markerPt,
    			map: setmap,
					icon: iconImg
  			}));
			}
		}
	});
}

function addMarker(typeid){
	<?php if(isset($activeDistrict)):?>
	var district=<?php echo $activeDistrict;?>;
	renderDistrictMarker(typeid,district);
	<?php else:?>
	renderMarker(typeid);
	<?php endif;?>
}

function clickMarker(marker, markerdata) {
	var markerInfoTitle = markerdata[0];
	var markerInfoPhone = markerdata[1];
	var markerInfoEmail = markerdata[2];
	var markerInfoDesc = markerdata[3];
	google.maps.event.addListener(marker, 'click', function(event){
		infoWindow.close();
		var contentString = '<div id="infoWindow" style="height: 120px; width: 210px;">';
		if(markerInfoTitle) {
			contentString += '<div class="markerInfoTitle">'+markerInfoTitle+'</div>';
		}
		if(markerInfoPhone) {
			contentString += '<div class="contactInfoTitle"><span>Утас: </span>'+markerInfoPhone+'</div>';
		}
		if(markerInfoEmail) {
			contentString += '<div class="contactInfoTitle"><span>И-мэйл: </span>'+markerInfoEmail+'</div>'
		}
		if(markerInfoDesc) {
			contentString += '<div class="additionalInfoTitle"><h6>Нэмэлт тайлбар</h6><p>'+markerInfoDesc+'</p></div>'
		}
		if(!markerInfoTitle && !markerInfoPhone && !markerInfoEmail && !markerInfoDesc) {
			contentString += '<div class="noInfoTitle">Мэдээлэл алга байна.</div>';
		}
		contentString += '</div>';

		infoWindow.setContent(contentString);
		infoWindow.open(map, marker);
	});
}

function renderMarker(typeid) {
	if (markers[typeid] && markers[typeid].length) {
		for (var m = 0; m < markers[typeid].length; m++) {
			if (!currentKhoroo || google.maps.geometry.poly.containsLocation(markers[typeid][m].getPosition(), khoroos[currentKhoroo])) {
  			markers[typeid][m].setMap(map);
			}
		}
		return;
	}
	markers[typeid] = [];

	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+typeid, function(point){
		if(point.marker.length == 0) {
			return;
		} else {
			var setmap;
			if(typeid != 7) {
			  var zoomlevel = map.getZoom();
			  var levelmultiplier = zoomlevel-9;
			  var iconImg = {
				  url: point.image.image,
   				size: new google.maps.Size(levelmultiplier*4, levelmultiplier*4),
    			origin: new google.maps.Point(0,0),
    			anchor: new google.maps.Point(levelmultiplier*4/2,levelmultiplier*4),
				  scaledSize: new google.maps.Size(levelmultiplier*4, levelmultiplier*4)
			  };
	  		for(var k = 0; k < point.marker.length; k++) {
					var markerPt = new google.maps.LatLng(point.marker[k][0], point.marker[k][1]);
					if (currentKhoroo && !google.maps.geometry.poly.containsLocation(markerPt, khoroos[currentKhoroo])) {
						setmap = null;
					} else {
						setmap = map;
					}
				  markers[typeid].push(new google.maps.Marker({
    				position: markerPt,
    				map: setmap,
					  icon: iconImg
  				}));
			  }
			} else {
			  var zoomlevel = map.getZoom();
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
			  };
  			for(var k = 0; k < point.marker.length; k++) {
					var markerPt = new google.maps.LatLng(point.marker[k][0], point.marker[k][1]);
					if (currentKhoroo && !google.maps.geometry.poly.containsLocation(markerPt, khoroos[currentKhoroo])) {
						setmap = null;
					} else {
						setmap = map;
					}
	  			markers[typeid].push(new google.maps.Marker({
    				position: markerPt,
    				map: setmap,
					  icon: iconImg
  				}));
	  		}
			}
		}
	});
}

function addWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1;
	} else {
		var walkid = 2;
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=addMarkerDistrict&type='+walkid, function(point){
		processWalkCircles(point, walkid);
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
				fillOpacity: 0,
				clickable: false,
				map: map
			});
		}
	});
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
			new google.maps.Polygon({
				paths: regionCoord,
				strokeColor: '#f38924',
				strokeOpacity: 0,
				strokeWeight: 0,
				fillColor: '#ffdc9c',
				fillOpacity: 0.6,
				map: map,
				clickable: false
			});
		}
	});
}

function addRegions(regionids) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&regions='+regionids.join(','), function(regions){
		for (var r = 0; r < regions.length; r++) {
			var point = regions[r];
			if(!point.coordinate || !point.coordinate.length) {
				continue;
			} else {
				var regionCoord = [];
				var polBounds = new google.maps.LatLngBounds();
				for(var k = 0; k < point.coordinate.length; k++) {
					regionCoord[k] = new google.maps.LatLng(point.coordinate[k][0] * 1, point.coordinate[k][1] * 1);
					polBounds.extend(regionCoord[k]);
				}
				khoroos[point.id] = new google.maps.Polygon({
					paths: regionCoord,
					strokeColor: '#f38924',
					strokeOpacity: 1,
					strokeWeight: 3,
					fillColor: '#FFFFFF',
					fillOpacity: 0,
					map: map,
					clickable: false
				});
			}
		}
	});
}

function initToggleMenu(){
	$('.toggle-menu-filter').click(function(){
		var panel=$('#filter-panel');
		if(panel.hasClass('active')){
			panel.removeClass('active');
		}
		else{
			panel.addClass('active');
		}
	});
}

function switchToMap(){
	$('.map-control').show();
	$('#filter-panel').addClass('active');
	$('#map-statistic').hide();
}

function switchToStat(){
	$('.map-control').hide();
	$('#filter-panel').removeClass('active');
	$('#map-statistic').show();
}
</script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDK9WxrpaRxS1yhssT0ylOjzF6EFRGxZYI&callback=initialize&libraries=geometry"></script>
