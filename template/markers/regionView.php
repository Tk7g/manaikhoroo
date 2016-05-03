<?php
//error_reporting(0);
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
			Дүүргийн хороод
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
			Харагдац
		</div>
		<div class="dsb-content">
			<div class="setOptions-row" id="roadMapSelect">
				Замын зураглал
			</div>
			<div class="setOptions-row" id="terrainSelect">
				Газар нутгийн нугачаа
			</div>
			<div class="setOptions-row" id="hybridSelect">
				Холимог
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
						Хүн амын нягтаршил
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
						Цэцэрлэгт хамрагддаггүй [%]
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
						Сургуульд хамрагддаггүй [%]
					</div>
				</div>
			</div>
			<div class="colorDataRow">
				<div id="popDensityColor">
					<div class="colorTitle">
						Тэмдэглэгээ
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
						Тэмдэглэгээ
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 10%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							11% - 20%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							21% - 30%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							> 30%
						</div>
					</div>
				</div>
				<div id="schoolDensityColor">
					<div class="colorTitle">
						Тэмдэглэгээ
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #ffdc9c;">
						</div>
						<div class="colorBoxNumber">
							0% - 10%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #e48801;">
						</div>
						<div class="colorBoxNumber">
							11% - 20%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #a84600;">
						</div>
						<div class="colorBoxNumber">
							21% - 30%
						</div>
					</div>
					<div class="colorBoxRow">
						<div class="colorBox" style="background: #730601;">
						</div>
						<div class="colorBoxNumber">
							> 30%
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/jsts.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_FOLDER; ?>/js/shared-map.js"></script>
<script type="text/javascript">
var inregions = [];
var regions = [];

var flids = [
<?php
	foreach($results['regions'] as $rg) :
		foreach($floods[$rg['id']] as $fld) {
?>
	<?php echo $fld['id']; ?>,
<?php
		}
	endforeach;
?>
-1];
flids.pop();

var pgids = [
<?php
	foreach($results['regions'] as $rg) :
		foreach($pls[$rg['id']] as $pl) {
?>
<?php echo $pl['id']; ?>,
<?php
		}
	endforeach;
?>
-1];
pgids.pop();

var rdids = [
<?php foreach($roads as $rd) :	?>
<?php echo $rd['id']; ?>,
<?php endforeach; ?>
-1];
rdids.pop();

function initialize() {
	var mapOptions = {
		zoom: <?php echo $results['district']['zoom']; ?>,
		center: new google.maps.LatLng(<?php echo $results['district']['position'] ?>),
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
	map.mapTypes.set("OSM", new google.maps.ImageMapType({
		getTileUrl: function(coord, zoom) {
			return "//tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
		},
		tileSize: new google.maps.Size(256, 256),
		name: "OpenStreetMap",
		maxZoom: 18
	}));
	infoWindow = new google.maps.InfoWindow({});

  <?php foreach($results['regions'] as $dist) : ?>
	  inregions.push(<?php echo json_encode($sections[$dist['id']] ); ?>);
	<?php endforeach; ?>

		<?php foreach($results['regions'] as $reg) : ?>
			addRegionTitle(<?php echo $reg['title']; ?>, <?php echo $reg['center'] ?>, <?php echo '"'.$reg['image'].'"'; ?>);
		<?php endforeach; ?>

  	$(".color-checker").click(function(){
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
				styleByRegion = {
				<?php foreach($results['regions'] as $dist) : ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
<?php if(isset($pop_district[$dist['id']][$sec['id']]) ) { ?>'<?php echo $sec['id']; ?>':'<?php echo $pop_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
			if($(this).find(".color-checkbox").attr("data") == "kin-density") {
				$("#kinDensityColor").show();
				styleByRegion = {
				<?php foreach($results['regions'] as $dist) : ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
<?php if(isset($kin_district[$dist['id']][$sec['id']])) { ?>'<?php echo $sec['id']; ?>':'<?php echo $kin_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
			if($(this).find(".color-checkbox").attr("data") == "school-density") {
				$("#schoolDensityColor").show();
				styleByRegion = {
				<?php foreach($results['regions'] as $dist) : ?>
					<?php foreach($sections[$dist['id']] as $sec) : ?>
<?php if(isset($school_district[$dist['id']][$sec['id']])) { ?>'<?php echo $sec['id']; ?>':'<?php echo $school_district[$dist['id']][$sec['id']]; ?>',<?php } ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
				'x': 0
			  };
				setRegionColor('x', 1);
			}
		}
	});

<?php function ider($o) { return $o['id']; } ?>
addRegions(<?php echo json_encode( array_map("ider", $results['regions'])  ) ?>);

<?php foreach($results['regions'] as $region) : ?>
	addRegionTitle(<?php echo $region['title']; ?>, <?php echo $region['center'] ?>, <?php echo '"'.$region['image'].'"'; ?>);
<?php endforeach; ?>

	$(".marker-row").click(function(e){
		var box = e.currentTarget;
		var markerType = $(box).find(".marker-checkbox").attr("data");
		if($(box).attr("data") == "checked") {
			$(box).find(".marker-checkbox").show();
			$(box).find(".marker-checked").hide();
			$(box).removeAttr("data");
			if(markerType == "sectionline") {
				removeSections();
			} else if(markerType == "flood-pol") {
				removeFloods();
			} else if(markerType == "pl-pol") {
				removePlaygrounds();
			} else if(markerType == "road-pol") {
				removeRoads();
				map.setOptions({styles: roadStylesRemove});
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
				$(".markerbox-type"+markerType).empty();
				removeMarker(markerType, <?php echo $results['district']['id']; ?>);
			}
		} else {
			$(box).find(".marker-checkbox").hide();
			$(box).find(".marker-checked").show();
			$(box).attr("data", "checked");
			if(markerType == "sectionline") {
				addSections();
			} else if(markerType == "flood-pol") {
				addFloods();
			} else if(markerType == "pl-pol") {
				addPlaygrounds();
			} else if(markerType == "road-pol") {
				addRoads();
				map.setOptions({styles: roadStyles});
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

function addMarker(typeid, district) {
	if (markers[typeid] && markers[typeid].length) {
		for (var m = 0; m < markers[typeid].length; m++) {
			markers[typeid][m].setMap(map);
		}
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getInfoMarkers&type='+typeid+'&district='+district+'', function(point){
		if(!point.coordinate || !point.coordinate.length) {
			return;
		}
		var zoomlevel = map.getZoom();
		var iconImg;

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
				var marker = new google.maps.Marker({
    			position: markerPt,
    			map: map,
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
			  markers[typeid].push(new google.maps.Marker({
    		  position: new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]),
    			map: map,
					icon: iconImg
  			}));
			}
		}
	});
}

function setRegionColor(section, color) {
	if (color) {
		strokeStyle.fillOpacity = 1;
	}
	if (!regions.length) {
		// convert to GeoJSON and add to Google Map if not done already
		for (var ir = 0; ir < inregions.length; ir++) {
			var rr = inregions[ir];
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

				regions.push({
					id: region.id,
					type: 'Feature',
					properties: {
						id: region.id,
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
			features: regions
		});
	}

	styleByRegion[section] = color;
	map.data.setStyle(function(feature) {
		return {
			strokeColor: strokeStyle.color,
			strokeOpacity: strokeStyle.opacity,
			strokeWeight: strokeStyle.weight,
			fillColor: styleByRegion[feature.getId()] || '#fff',
			// fill this region with the set color, unless no color exists or filling is off
			fillOpacity: ((strokeStyle.fillOpacity && styleByRegion[feature.getId()]) ? 0.6 : 0 )
		};
	});
}

function addWalk(type, district) {
	if(type == "walk-bus") {
		var walkid = 1;
	} else {
		var walkid = 2;
	}
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=getMarkers&type='+walkid+'&district='+district+'', function(point) {
		processWalkCircles(point, walkid);
	});
}

function fitBoundary(district, region) {
	$.getJSON('<?php echo SITE_URL; ?>indicator.php?action=regionBorder&region='+region, function(point){
		if(!point.coordinate || !point.coordinate.length) {
			return;
		} else {
			var khorooBounds = new google.maps.LatLngBounds();
			for(var k = 0; k < point.coordinate.length; k++) {
				khorooBounds.extend(new google.maps.LatLng(point.coordinate[k][0], point.coordinate[k][1]));
			}
			map.fitBounds(khorooBounds);
		}
	});
}

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
				new google.maps.Polygon({
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Хүн амын тоо
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Нийт өрхийн тоо
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Сургуульд хамрагддаггүй хүүхдийн тоо
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Газар нутгийн хэмжээ
						</div>
						<div class="detail-number">
							<?php echo number_format($districtArea['area_length']); ?> га
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Хүн амын нягтаршил
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
							<?php echo $results['district']['title'].' дүүргийн'; ?>
						</div>
						<div class="detail-description">
							Өрхийн болон бусад эмнэлгийн тоо
						</div>
						<div class="detail-number">
							<?php echo $districtMarkerCount['hospital']['COUNT(*)']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="infopage-title">
	<?php echo $results['district']['title'].' дүүргийн мэдээлэл'; ?>
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
		Хүн амын тоо
	</div>
	<div class="choice-btn" data="2">
		Нийт өрхийн тоо
	</div>
	<div class="choice-btn" data="3">
		Газар нутгийн хэмжээ
	</div>
	<div class="choice-btn" data="4">
		Хүн амын нягтаршил
	</div>
	<div class="choice-btn" data="5">
		Өрхийн болон бусад эмнэлгийн тоо
	</div>
	<div class="choice-btn" data="6">
		Усны худгийн тоо
	</div>
	<div class="choice-btn" data="7">
		Албан бус хогийн цэгийн тоо
	</div>
</div>
	</div>
	<div class="col-md-8">
		<div id="chart-component">
<h2 class="title">Хүн амын тоо</h2>
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

                	show_tooltip(item.pageX, item.pageY, "<div style='text-align: center;'>"+ x +"-р хороо<br/>Хүн амын тоо<br /><b><div style='font-size: 20px; color: #EEE;'>" + y + "</div></b></div>");
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
								<option value="">Сонгоно уу</option>
								<?php foreach($results['districts'] as $dist) : ?>
									<option value="d<?php echo $dist['id']; ?>"><?php echo $dist['title'].' дүүрэг'; ?></option>
									<?php foreach($results[$dist['id']] as $reg) : ?>
										<option value="<?php echo $reg['id']; ?>"><?php echo $dist['title'].' дүүргийн '.$reg['title']; ?></option>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							харьцуулах
						</div>
						<form action="indicator.php?action=select" id="SelectRegionForm1" method="post">
						<div class="rts-input">
							<select name="region_id" id="SelectRegion1" required="required">
								<option value="">Сонгоно уу</option>
								<?php foreach($results['regions'] as $rg) : ?>
								<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' дүүргийн '.$rg['title'].'-р хороо'; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						</form>
						<div class="rts-label">
							Хороодоос сонголт хийж мэдээлэл харна уу
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
		Хүн амын тоо
	</div>
	<div class="row-rgtable row-label">
		Нийт өрхийн тоо
	</div>
	<div class="row-rgtable row-label">
		Өрхийн дундаж хэмжээ
	</div>
	<div class="row-rgtable row-label">
		Газар нутгийн хэмжээ /га/
	</div>
	<div class="row-rgtable row-label">
		Хүн амын нягтаршил (хүн/га)
	</div>
	<div class="row-rgtable row-label">
		Автобусны буудлаас 5 минут алхах зайд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		Усны худгийн тоо
	</div>
	<div class="row-rgtable row-label">
		Усны худгаас 5 минут алхах зайд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		1000 хүнд ноогдох усны худгийн харьцаа
	</div>
	<div class="row-rgtable row-label">
		Албан бус хогийн цэгийн тоо
	</div>
	<div class="row-rgtable row-label">
		Аюултай бүсээс 100 м зайнд амьдардаг хүн амын %
	</div>
	<div class="row-rgtable row-label">
		Өрхийн болон бусад эмнэлэгийн тоо
	</div>
	<div class="row-rgtable row-label">
		1000 хүнд ноогдох өрхийн болон бусад эмнэлэгийн харьцаа
	</div>
	<div class="row-rgtable row-label">
		2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн тоо
	</div>
	<div class="row-rgtable row-label">
		2-5 насны цэцэрлэгт хамрагддаггүй хүүхдийн %
	</div>
	<div class="row-rgtable row-label">
		6-16 насны сургуульд хамрагддаггүй хүүхдийн тоо
	</div>
	<div class="row-rgtable row-label">
		6-16 насны сургуульд хамрагддаггүй хүүхдийн %
	</div>
</div>

<div class="col-city">
	<div class="row-header text-center">
		Нийслэл
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
	<?php echo $results['district']['title'].' дүүргийн '; ?> оны харьцуулалт
</div>
<div class="year-statistics">
	<div class="container">
		<div class="row">
			<div class="yearstat-selection">
				<form action="indicator.php?action=yearSelect" id="YearStatForm" method="post">
					<div class="yearstat-input">
						<label>Он</label>
						<select name="year1" id="YearInfo1" required="required">
							<option value>Он сонгоно уу</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Харьцуулах он</label>
						<select name="year2" id="YearInfo2" required="required">
							<option value>Он сонгоно уу</option>
							<?php foreach($years as $yr) : ?>
								<option value="<?php echo $yr['year']; ?>"><?php echo $yr['year']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<label>Үзүүлэлт</label>
						<select name="indicator_id" id="IndicatorInfo" required="required" style="width: 220px;">
							<option value>Сонгоно уу</option>
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
						<label>Хороо</label>
						<select name="region" id="RegionInfo" required="required" style="width: 220px;">
							<option value="">Сонгоно уу</option>
							<?php foreach($results['regions'] as $rg) : ?>
							<option value="<?php echo $rg['id']; ?>"><?php echo $results['district']['title'].' '.$rg['title'].'-р хороо'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="yearstat-input">
						<div id="yearstat-btn">Харьцуулах</div>
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
